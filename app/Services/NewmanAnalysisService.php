<?php

namespace App\Services;

use App\Models\StudentAnswer;
use App\Models\AnswerAnalysis;
use Illuminate\Support\Facades\DB;

class NewmanAnalysisService
{
    private array $stages = [
        'reading',
        'comprehension',
        'transformation',
        'process_skills',
        'encoding',
    ];

    
public function analyze(StudentAnswer $studentAnswer): AnswerAnalysis
{
    // 1. Ambil data jawaban dan relasi yang diperlukan.
    $studentAnswer->load([
        'question.options',
        'assessmentAttempt.topic',
    ]);

    $question = $studentAnswer->question;
    $config = $question->analysis_config ?? [];

    if (is_string($config)) {
        $config = json_decode($config, true) ?? [];
    }

    // 2. Buat atau ambil analisis dalam transaksi singkat.
    $analysis = DB::transaction(function () use ($studentAnswer) {
        $analysis = AnswerAnalysis::where(
            'student_answer_id',
            $studentAnswer->id
        )->lockForUpdate()->first();

        if (!$analysis) {
            $analysis = AnswerAnalysis::create([
                'student_answer_id' => $studentAnswer->id,
                'analysis_status' => 'pending',
                'analysis_method' => 'rule_based',
            ]);
        }

        return $analysis;
    });

    // Jangan menimpa hasil yang sudah diperiksa guru.
    if ($analysis->reviewed_at !== null) {
        return $analysis->load('newmanFindings');
    }

    // 3. Ambil jawaban verifikasi siswa.
    $analysis->load('verificationResponses.verificationQuestion');

    // 4. Jalankan analisis berbasis aturan.
    $findings = [
        'reading' => $this->analyzeReading($analysis),

        'comprehension' => $this->analyzeComprehension($analysis),

        'transformation' => $this->analyzeTransformation(
            $studentAnswer,
            $config
        ),

        'process_skills' => $this->analyzeProcessSkills(
            $studentAnswer,
            $config
        ),

        'encoding' => $this->analyzeEncoding(
            $studentAnswer,
            $config
        ),
    ];

    // 5. Panggil Gemini DI LUAR transaksi database.
    $analysisMethod = 'rule_based';

    try {
        $aiFindings = $this->analyzeWithGemini(
            $studentAnswer,
            $analysis,
            $config
        );

        if ($aiFindings !== null) {
            $usedAiSupplement = false;

            // Hasil berbasis aturan yang sudah memiliki bukti eksplisit tidak
            // ditimpa oleh kesimpulan AI yang mungkin berbeda. Gemini melengkapi
            // tahap yang belum cukup bukti, terutama Reading/Comprehension.
            foreach ($this->stages as $stage) {
                if (($findings[$stage]['status'] ?? 'insufficient_evidence') === 'insufficient_evidence') {
                    $findings[$stage] = $aiFindings[$stage];
                    $usedAiSupplement = true;
                }
            }

            $analysisMethod = $usedAiSupplement ? 'hybrid' : 'rule_based';
        }
    } catch (\Throwable $exception) {
        report($exception);
    }

    // 6. Simpan hasil analisis dalam transaksi singkat.
    DB::transaction(function () use (
        $studentAnswer,
        $findings,
        $analysisMethod
    ) {
        $analysis = AnswerAnalysis::where(
            'student_answer_id',
            $studentAnswer->id
        )->lockForUpdate()->firstOrFail();

        // Jika guru sudah memeriksa selama AI bekerja,
        // jangan timpa hasil pemeriksaan tersebut.
        if ($analysis->reviewed_at !== null) {
            return;
        }

        foreach ($findings as $stage => $finding) {
            $existingFinding = $analysis->newmanFindings()
                ->where('stage', $stage)
                ->lockForUpdate()
                ->first();

            // Keputusan dan bukti yang sudah diperiksa guru pada tahap ini
            // tidak boleh berubah hanya karena siswa mengirim verifikasi ulang.
            if ($existingFinding?->reviewed_at !== null) {
                continue;
            }

            $analysis->newmanFindings()->updateOrCreate(
                ['stage' => $stage],
                [
                    'finding_status' => $finding['status'],
                    'evidence' => $finding['evidence'],
                    'reason' => $finding['reason'],
                ]
            );
        }

        $persistedFindings = $analysis->newmanFindings()->get();
        $errorStages = $persistedFindings
            ->where('finding_status', 'error_indicated')
            ->pluck('stage')
            ->all();

        $summary = match ($analysisMethod) {
            'hybrid' => 'Analisis menggunakan aturan sistem dan bantuan Gemini AI. ',
            'gemini_ai' => 'Analisis berbantuan Gemini AI. ',
            default => 'Analisis berbasis aturan. ',
        };

        $summary .= empty($errorStages)
            ? 'Belum ditemukan indikasi kesalahan yang cukup kuat. Hasil tetap perlu ditinjau guru.'
            : 'Terdapat indikasi kesalahan pada tahap: '
                . implode(', ', $errorStages)
                . '. Hasil tetap perlu ditinjau guru.';

        $analysis->update([
            'analysis_status' => 'completed',
            'analysis_method' => $analysisMethod,
            'analysis_summary' => $summary,
        ]);
    });

    return AnswerAnalysis::where(
        'student_answer_id',
        $studentAnswer->id
    )->firstOrFail()->load('newmanFindings');
}



    /**
     * Meminta Gemini menganalisis lima tahap Newman berdasarkan bukti
     * yang benar-benar tersimpan. Mengembalikan null jika API gagal agar
     * analisis berbasis aturan tetap menjadi fallback.
     */
    private function analyzeWithGemini(
        StudentAnswer $answer,
        AnswerAnalysis $analysis,
        array $config
    ): ?array {
        try {
            $answer->loadMissing(['question.options', 'assessmentAttempt.topic']);
            $analysis->loadMissing('verificationResponses.verificationQuestion');

            $question = $answer->question;
            if (!$question) {
                return null;
            }

            $options = $question->options->map(function ($option) {
                return [
                    'label' => $option->option_label,
                    'text' => $option->option_text,
                    'is_correct' => (bool) $option->is_correct,
                ];
            })->values()->all();

            $verification = $analysis->verificationResponses->map(function ($response) {
                $verificationQuestion = $response->verificationQuestion;
                return [
                    'target_stage' => $verificationQuestion?->target_stage,
                    'question' => $verificationQuestion?->question_text,
                    'interpretation_guide' => $verificationQuestion?->interpretation_guide,
                    'student_response' => $response->response_text,
                ];
            })->values()->all();

            $payload = [
                'topic' => $answer->assessmentAttempt?->topic?->name,
                'question' => [
                    'stimulus' => $question->stimulus ?? null,
                    'question_text' => $question->question_text ?? $question->question ?? null,
                    'options' => $options,
                    'correct_answer' => $question->correct_answer,
                    'analysis_config' => $config,
                ],
                'student_response' => [
                    'selected_option' => $answer->answer_text,
                    'is_correct_by_system' => $answer->is_correct,
                    'working_steps' => $answer->working_steps,
                    'student_explanation' => $answer->student_explanation,
                ],
                'verification_responses' => $verification,
            ];

            $prompt = <<<'PROMPT'
Anda adalah asisten analisis pendidikan yang membantu guru menganalisis kesulitan numerasi siswa SD menggunakan tahapan Newman.
Analisis hanya berdasarkan data yang diberikan. Jangan mengarang bukti. Jangan menyimpulkan siswa salah hanya karena metode berbeda dari kunci. Jika bukti tahap tertentu tidak cukup, gunakan insufficient_evidence. Jawaban verifikasi harus dinilai terhadap pertanyaan dan interpretation_guide jika tersedia.

Definisi status:
- error_indicated = ada bukti eksplisit kesalahan.
- no_error_indicated = bukti yang tersedia menunjukkan tahap dilakukan dengan benar.
- insufficient_evidence = data tidak cukup untuk menyimpulkan.

Keluarkan HANYA JSON valid dengan lima properti: reading, comprehension, transformation, process_skills, encoding. Setiap properti harus berisi status, evidence, reason. Status hanya boleh error_indicated, no_error_indicated, atau insufficient_evidence. Evidence dan reason harus berbahasa Indonesia, ringkas, dan menyebut bukti spesifik. Jangan menilai tahap Reading/Comprehension dari benar-salah pilihan akhir saja.

Contoh bentuk keluaran:
{"reading":{"status":"insufficient_evidence","evidence":"...","reason":"..."},"comprehension":{"status":"insufficient_evidence","evidence":"...","reason":"..."},"transformation":{"status":"insufficient_evidence","evidence":"...","reason":"..."},"process_skills":{"status":"insufficient_evidence","evidence":"...","reason":"..."},"encoding":{"status":"insufficient_evidence","evidence":"...","reason":"..."}}

DATA SISWA (tanpa identitas pribadi):
PROMPT
                . json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);



            $result = app(GeminiService::class)->generateJson($prompt);
            $stages = ['reading', 'comprehension', 'transformation', 'process_skills', 'encoding'];
            $normalized = [];

            foreach ($stages as $stage) {
                $item = $result[$stage] ?? null;
                if (!is_array($item)) {
                    return null;
                }

                $status = $item['status'] ?? 'insufficient_evidence';
                if (!in_array($status, ['error_indicated', 'no_error_indicated', 'insufficient_evidence'], true)) {
                    $status = 'insufficient_evidence';
                }

                $normalized[$stage] = [
                    'status' => $status,
                    'evidence' => isset($item['evidence']) ? mb_substr((string) $item['evidence'], 0, 5000) : null,
                    'reason' => isset($item['reason']) ? mb_substr((string) $item['reason'], 0, 5000) : 'Belum ada alasan analisis dari AI.',
                ];
            }

            return $normalized;
        } catch (\Throwable $exception) {
            report($exception);
            return null;
        }
    }

    /**
     * Analisis tahap Reading.
     * Jawaban verifikasi dicatat sebagai bukti, tetapi belum
     * dinilai otomatis karena belum ada rubrik terstruktur.
     */
    private function analyzeReading(AnswerAnalysis $analysis): array
    {
        $evidence = $this->getVerificationEvidence(
            $analysis,
            'reading'
        );

        return [
            'status' => 'insufficient_evidence',
            'evidence' => $evidence,
            'reason' => $evidence !== null
                ? 'Jawaban verifikasi Reading sudah diterima dan dicatat. Kebenaran jawaban masih memerlukan pemeriksaan guru karena belum tersedia rubrik penilaian terstruktur.'
                : 'Belum tersedia bukti langsung mengenai kemampuan siswa membaca informasi dalam soal. Diperlukan jawaban verifikasi atau pemeriksaan guru.',
        ];
    }

    /**
     * Analisis tahap Comprehension.
     * Jawaban verifikasi dicatat sebagai bukti, bukan langsung
     * dianggap sebagai bukti pemahaman yang benar.
     */
    private function analyzeComprehension(AnswerAnalysis $analysis): array
    {
        $evidence = $this->getVerificationEvidence(
            $analysis,
            'comprehension'
        );

        return [
            'status' => 'insufficient_evidence',
            'evidence' => $evidence,
            'reason' => $evidence !== null
                ? 'Jawaban verifikasi Comprehension sudah diterima dan dicatat. Pemahaman siswa masih memerlukan pemeriksaan guru karena belum tersedia rubrik penilaian terstruktur.'
                : 'Belum tersedia bukti yang cukup untuk memastikan pemahaman siswa terhadap informasi dan maksud soal.',
        ];
    }

    /**
     * Mengambil bukti jawaban verifikasi berdasarkan tahap Newman.
     */
    private function getVerificationEvidence(
        AnswerAnalysis $analysis,
        string $stage
    ): ?string {
        $responses = $analysis->verificationResponses
            ->filter(function ($response) use ($stage) {
                return $response->verificationQuestion !== null
                    && $response->verificationQuestion->target_stage === $stage
                    && trim((string) $response->response_text) !== '';
            });

        if ($responses->isEmpty()) {
            return null;
        }

        return $responses->map(function ($response) {
            return 'Pertanyaan: '
                . $response->verificationQuestion->question_text
                . "\nJawaban siswa: "
                . trim($response->response_text);
        })->implode("\n\n");
    }

    /**
     * Memeriksa kesesuaian transformasi soal ke operasi matematika.
     * Perbedaan metode tidak otomatis dianggap sebagai kesalahan.
     */
    private function analyzeTransformation(
        StudentAnswer $answer,
        array $config
    ): array {
        $expectedSteps = $config['expected_steps'] ?? [];

        if (empty($expectedSteps) || empty($answer->working_steps)) {
            return $this->insufficient(
                'Belum tersedia konfigurasi atau langkah pengerjaan yang cukup untuk memeriksa transformasi.'
            );
        }

        $equations = $this->extractEquations($answer->working_steps);

        if (empty($equations)) {
            return $this->insufficient(
                'Tidak ditemukan persamaan matematika yang dapat diperiksa.'
            );
        }

        $evidence = [];
        $matchedCount = 0;
        $usedEquationIndexes = [];

        foreach ($expectedSteps as $index => $expected) {
            $expectedOperation = $expected['operation'] ?? null;
            $expectedValues = $expected['values'] ?? [];

            if (
                $expectedOperation === null ||
                count($expectedValues) < 2
            ) {
                return $this->insufficient(
                    'Konfigurasi transformasi langkah ke-'
                    . ($index + 1)
                    . ' belum lengkap.'
                );
            }

            $matchedEquation = null;

            foreach ($equations as $equationIndex => $equation) {
                if (isset($usedEquationIndexes[$equationIndex])) {
                    continue;
                }

                $operationMatch =
                    $equation['operation'] === $expectedOperation;

                $operandsMatch =
                    $this->sameNumber(
                        $equation['left'],
                        $expectedValues[0]
                    ) &&
                    $this->sameNumber(
                        $equation['right'],
                        $expectedValues[1]
                    );

                if ($operationMatch && $operandsMatch) {
                    $matchedEquation = $equation;
                    $usedEquationIndexes[$equationIndex] = true;
                    break;
                }
            }

            if ($matchedEquation === null) {
                $evidence[] = 'Langkah referensi ke-'
                    . ($index + 1)
                    . ' belum dapat dicocokkan dengan pengerjaan siswa.';

                continue;
            }

            $matchedCount++;

            $evidence[] = 'Langkah '
                . ($index + 1)
                . ': '
                . $matchedEquation['text']
                . '; operasi dan angka sesuai dengan referensi.';
        }

        if ($matchedCount === count($expectedSteps)) {
            return [
                'status' => 'no_error_indicated',
                'evidence' => implode("\n", $evidence),
                'reason' => 'Seluruh operasi dan informasi angka pada langkah referensi dapat ditemukan dalam pengerjaan siswa. Perbedaan format penulisan tidak dianggap sebagai kesalahan.',
            ];
        }

        return [
            'status' => 'insufficient_evidence',
            'evidence' => implode("\n", $evidence),
            'reason' => 'Sebagian langkah referensi belum dapat dicocokkan. Siswa mungkin menggunakan metode alternatif atau belum menuliskan seluruh langkah. Diperlukan pemeriksaan guru.',
        ];
    }

    /**
     * Memeriksa ketepatan proses perhitungan siswa.
     * Persamaan dicocokkan berdasarkan operasi dan operand,
     * bukan hanya berdasarkan posisi persamaan.
     */
    private function analyzeProcessSkills(
        StudentAnswer $answer,
        array $config
    ): array {
        $expectedSteps = $config['expected_steps'] ?? [];

        if (empty($expectedSteps) || empty($answer->working_steps)) {
            return $this->insufficient(
                'Belum tersedia langkah perhitungan atau konfigurasi soal yang cukup.'
            );
        }

        $equations = $this->extractEquations($answer->working_steps);

        if (empty($equations)) {
            return $this->insufficient(
                'Tidak ditemukan persamaan yang dapat diperiksa ketepatan perhitungannya.'
            );
        }

        $evidence = [];
        $calculationErrors = [];
        $unmatchedSteps = [];
        $usedEquationIndexes = [];

        foreach ($expectedSteps as $index => $expected) {
            $expectedOperation = $expected['operation'] ?? null;
            $expectedValues = $expected['values'] ?? [];

            if (
                $expectedOperation === null ||
                count($expectedValues) < 2 ||
                !isset($expected['result'])
            ) {
                return $this->insufficient(
                    'Konfigurasi langkah perhitungan ke-'
                    . ($index + 1)
                    . ' belum lengkap.'
                );
            }

            $matchedEquation = null;

            foreach ($equations as $equationIndex => $equation) {
                if (isset($usedEquationIndexes[$equationIndex])) {
                    continue;
                }

                $sameOperation =
                    $equation['operation'] === $expectedOperation;

                $sameOperands =
                    $this->sameNumber(
                        $equation['left'],
                        $expectedValues[0]
                    ) &&
                    $this->sameNumber(
                        $equation['right'],
                        $expectedValues[1]
                    );

                if ($sameOperation && $sameOperands) {
                    $matchedEquation = $equation;
                    $usedEquationIndexes[$equationIndex] = true;
                    break;
                }
            }

            if ($matchedEquation === null) {
                $unmatchedSteps[] =
                    'Langkah referensi ke-'
                    . ($index + 1)
                    . ' belum dapat dicocokkan dengan pengerjaan siswa.';

                continue;
            }

            $evidence[] = $matchedEquation['text'];

            $calculationCorrect = $this->sameNumber(
                $matchedEquation['result'],
                $expected['result']
            );

            if (!$calculationCorrect) {
                $calculationErrors[] = $matchedEquation['text'];
            }
        }

        if (!empty($calculationErrors)) {
            return [
                'status' => 'error_indicated',
                'evidence' => implode("\n", $calculationErrors),
                'reason' => 'Terdapat hasil perhitungan yang tidak sesuai dengan hasil referensi pada langkah yang dapat dicocokkan. Langkah lainnya tetap memerlukan pemeriksaan guru.',
            ];
        }

        if (!empty($unmatchedSteps)) {
            return [
                'status' => 'insufficient_evidence',
                'evidence' => implode(
                    "\n",
                    array_merge($evidence, $unmatchedSteps)
                ),
                'reason' => 'Sebagian langkah referensi belum dapat dicocokkan. Hal ini belum cukup untuk menyimpulkan siswa melakukan kesalahan perhitungan.',
            ];
        }

        return [
            'status' => 'no_error_indicated',
            'evidence' => implode("\n", $evidence),
            'reason' => 'Seluruh langkah perhitungan yang dapat diperiksa sesuai dengan hasil yang diharapkan.',
        ];
    }

    /**
     * Memeriksa jawaban akhir dan satuan yang dituliskan siswa.
     */
    private function analyzeEncoding(
        StudentAnswer $answer,
        array $config
    ): array {
        $expectedAnswer = $config['expected_answer'] ?? null;
        $expectedUnit = $config['expected_unit'] ?? null;

        if ($expectedAnswer === null) {
            return $this->insufficient(
                'Konfigurasi jawaban yang diharapkan belum tersedia.'
            );
        }

        $texts = [
            $answer->student_explanation ?? '',
            $answer->working_steps ?? '',
        ];

        $finalStatement = null;

        foreach ($texts as $text) {
            if (trim($text) === '') {
                continue;
            }

            $parts = preg_split(
                '/\b(?:jadi|maka|kesimpulan)\b\s*[:,]?\s*/iu',
                $text,
                -1,
                PREG_SPLIT_NO_EMPTY
            );

            if (count($parts) < 2) {
                continue;
            }

            $candidate = trim(end($parts));

            $candidate = trim(
                $candidate,
                " \t\n\r\0\x0B,.;:"
            );

            if (preg_match('/-?\d+(?:[.,]\d+)?/u', $candidate)) {
                $finalStatement = $candidate;
                break;
            }
        }

        if ($finalStatement === null) {
            return $this->insufficient(
                'Belum ditemukan pernyataan akhir yang secara jelas menunjukkan jawaban siswa. Persamaan perhitungan saja belum cukup untuk memastikan kemampuan menuliskan kesimpulan.'
            );
        }

        preg_match_all(
            '/-?\d+(?:[.,]\d+)?/u',
            $finalStatement,
            $matches
        );

        $finalNumber = end($matches[0]);

        $numberCorrect = $this->sameNumber(
            $finalNumber,
            $expectedAnswer
        );

        $unitCorrect = $expectedUnit !== null
            ? mb_stripos($finalStatement, $expectedUnit) !== false
            : true;

        $evidence = 'Pernyataan akhir siswa: ' . $finalStatement;

        if (!$numberCorrect) {
            return [
                'status' => 'insufficient_evidence',
                'evidence' => $evidence,
                'reason' => 'Nilai akhir berbeda dari jawaban referensi. Perbedaan dapat berasal dari kesalahan tahap sebelumnya sehingga perlu pemeriksaan lebih lanjut.',
            ];
        }

        if (!$unitCorrect) {
            return [
                'status' => 'error_indicated',
                'evidence' => $evidence,
                'reason' => 'Nilai numerik sudah sesuai, tetapi satuan yang dituliskan tidak sesuai atau tidak dicantumkan.',
            ];
        }

        return [
            'status' => 'no_error_indicated',
            'evidence' => $evidence,
            'reason' => 'Nilai akhir dan satuan yang dituliskan sesuai dengan jawaban yang diharapkan.',
        ];
    }

    /**
     * Mengambil persamaan aritmetika dari langkah pengerjaan.
     * Mendukung +, -, *, ×, x, /, ÷, dan :
     */
    private function extractEquations(string $text): array
    {
        preg_match_all(
            '/(-?\d+(?:[.,]\d+)?)\s*([+\-*×xX−\/÷:])\s*(-?\d+(?:[.,]\d+)?)\s*=\s*(-?\d+(?:[.,]\d+)?)/u',
            $text,
            $matches,
            PREG_SET_ORDER
        );

        $equations = [];

        foreach ($matches as $match) {
            $symbol = $match[2];

            $operation = match ($symbol) {
                '+' => 'addition',
                '-', '−' => 'subtraction',
                '*', '×', 'x', 'X' => 'multiplication',
                '/', '÷', ':' => 'division',
                default => null,
            };

            if ($operation === null) {
                continue;
            }

            $equations[] = [
                'left' => $match[1],
                'right' => $match[3],
                'result' => $match[4],
                'operation' => $operation,
                'text' => $match[0],
            ];
        }

        return $equations;
    }

    /**
     * Membandingkan dua nilai numerik.
     */
    private function sameNumber($first, $second): bool
    {
        if ($first === null || $second === null) {
            return false;
        }

        $first = str_replace(',', '.', (string) $first);
        $second = str_replace(',', '.', (string) $second);

        return is_numeric($first)
            && is_numeric($second)
            && abs((float) $first - (float) $second) < 0.000001;
    }

    private function insufficient(string $reason): array
    {
        return [
            'status' => 'insufficient_evidence',
            'evidence' => null,
            'reason' => $reason,
        ];
    }
}
