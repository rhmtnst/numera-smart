<?php

namespace Database\Seeders;

use App\Models\LearningMaterial;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\RemedialExercise;
use App\Models\RemedialMaterial;
use App\Models\RemedialMaterialNewmanStage;
use App\Models\Topic;
use App\Models\VerificationQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Paket konten asesmen, Newman, dan remediasi untuk kelas V dan VI.
 * Materi utama 36 topik sudah disediakan LearningMaterialSeeder.
 * Semua soal asesmen dan materi remediasi dibuat sebagai draft untuk review guru.
 */
class GradeFiveSixContentSeeder extends Seeder
{
    private const STAGES = [
        'reading', 'comprehension', 'transformation', 'process_skills', 'encoding',
    ];

    public function run(): void
    {
        DB::transaction(function () {
            Topic::query()
                ->whereIn('grade_level', [5, 6])
                ->where('is_active', true)
                ->with('learningMaterial')
                ->orderBy('grade_level')
                ->orderBy('sort_order')
                ->get()
                ->each(function (Topic $topic) {
                    $items = $this->questionsFor($topic);
                    if (count($items) !== 10) {
                        throw new \RuntimeException('Paket soal harus berisi 10 soal: '.$topic->title);
                    }

                    // Jangan menimpa materi utama yang telah diedit atau ditinjau guru.
                    if (!$topic->learningMaterial) {
                        LearningMaterial::create([
                            'topic_id' => $topic->id,
                            'title' => $topic->title,
                            'competency' => 'Siswa mampu memahami konsep '.$topic->title.' dan menerapkannya pada masalah kontekstual.',
                            'objectives' => [
                                'Menjelaskan konsep utama '.$topic->title.'.',
                                'Memilih strategi yang sesuai untuk menyelesaikan masalah.',
                                'Menuliskan langkah dan kesimpulan secara runtut.',
                            ],
                            'content' => 'Pelajari konsep '.$topic->title.'. Perhatikan informasi pada soal, tentukan apa yang diketahui dan ditanyakan, pilih strategi yang sesuai, lalu periksa kembali hasilnya.',
                            'example_content' => 'Baca contoh pada soal, tuliskan informasi penting, kerjakan langkah demi langkah, dan jelaskan alasan pemilihan strategi.',
                            'practice_prompt' => 'Buat satu contoh masalah sehari-hari yang berkaitan dengan '.$topic->title.' dan jelaskan cara menyelesaikannya.',
                            'estimated_minutes' => 25,
                            'status' => 'published',
                            'published_at' => now(),
                        ]);
                    }

                    foreach ($items as $index => $item) {
                        $question = Question::firstOrNew([
                            'topic_id' => $topic->id,
                            'stimulus' => $item['stimulus'],
                            'question_text' => $item['question'],
                        ]);
                        $isNew = !$question->exists;
                        $question->fill([
                            'question_type' => 'multiple_choice',
                            'correct_answer' => 'A',
                            'explanation' => $item['explanation'],
                            'difficulty' => $index < 3 ? 'easy' : ($index < 7 ? 'medium' : 'hard'),
                            'points' => 10,
                            'sort_order' => $index + 1,
                            'is_active' => true,
                            'source' => 'ai_assisted_draft',
                            'analysis_config' => $item['analysis_config'],
                        ]);
                        if ($isNew) {
                            $question->review_status = 'draft';
                        }
                        $question->save();

                        foreach (['A', 'B', 'C', 'D'] as $optionIndex => $label) {
                            QuestionOption::updateOrCreate(
                                ['question_id' => $question->id, 'option_label' => $label],
                                [
                                    'option_text' => (string) $item['options'][$optionIndex],
                                    'is_correct' => $label === 'A',
                                    'sort_order' => $optionIndex + 1,
                                ]
                            );
                        }
                    }

                    $this->seedRemedial($topic, $items);
                    $this->seedVerification($topic);
                });
        });
    }

    private function seedRemedial(Topic $topic, array $items): void
    {
        $material = RemedialMaterial::firstOrNew([
            'topic_id' => $topic->id,
            'title' => 'Belajar Kembali: '.$topic->title,
        ]);
        $isNew = !$material->exists;
        $material->fill([
            'description' => 'Penguatan konsep '.$topic->title.' melalui penjelasan ulang, contoh terbimbing, dan latihan bertahap.',
            'content' => "Mari belajar kembali secara bertahap.\n\n1. Baca soal sampai selesai.\n2. Tandai informasi penting.\n3. Jelaskan apa yang diketahui dan ditanyakan.\n4. Pilih operasi, gambar, tabel, atau strategi yang sesuai.\n5. Kerjakan langkah demi langkah.\n6. Periksa kembali jawaban dan tuliskan kesimpulan.",
            'example_content' => $items[0]['stimulus'].' '.$items[0]['question'].' '.$items[0]['explanation'],
        ]);
        if ($isNew) {
            $material->created_by = null;
            $material->status = 'draft';
        }
        $material->save();

        foreach (self::STAGES as $stage) {
            RemedialMaterialNewmanStage::updateOrCreate(
                ['remedial_material_id' => $material->id, 'stage' => $stage],
                []
            );
        }

        foreach (array_slice($items, 0, 5) as $index => $item) {
            $exercise = RemedialExercise::firstOrNew([
                'remedial_material_id' => $material->id,
                'sort_order' => $index + 1,
            ]);
            $exercise->fill([
                'question_type' => 'multiple_choice',
                'question_text' => $item['stimulus'].' '.$item['question'],
                'options' => [
                    'A' => (string) $item['options'][0],
                    'B' => (string) $item['options'][1],
                    'C' => (string) $item['options'][2],
                    'D' => (string) $item['options'][3],
                ],
                'correct_answer' => 'A',
                'explanation' => $item['explanation'],
                'points' => 2,
                'is_active' => true,
            ]);
            $exercise->save();
        }
    }

    private function seedVerification(Topic $topic): void
    {
        $topic->verificationQuestions()
            ->whereIn('target_stage', ['reading', 'comprehension'])
            ->where(function ($query) {
                $query->where('question_text', 'like', 'Bacalah kembali soal tentang%')
                    ->orWhere('question_text', 'like', 'Dengan bahasamu sendiri%');
            })
            ->delete();

        $prompts = [
            'reading' => 'Bacalah kembali soal tentang '.$topic->title.'. Kata, angka, atau informasi penting apa yang kamu temukan?',
            'comprehension' => 'Dengan bahasamu sendiri, jelaskan apa yang diketahui dan apa yang ditanyakan dalam soal.',
            'transformation' => 'Strategi, operasi, gambar, atau tabel apa yang kamu pilih? Mengapa strategi itu sesuai?',
            'process_skills' => 'Tuliskan langkah penyelesaianmu satu per satu. Bagian mana yang paling sulit?',
            'encoding' => 'Tuliskan jawaban akhir dan jelaskan arti jawaban tersebut sesuai konteks soal.',
        ];
        foreach ($prompts as $index => $prompt) {
            VerificationQuestion::updateOrCreate(
                ['topic_id' => $topic->id, 'target_stage' => $index, 'question_text' => $prompt],
                [
                    'response_type' => 'text',
                    'interpretation_guide' => 'Guru menilai respons berdasarkan bukti pemahaman siswa dan konteks soal; jawaban teks tidak dinilai otomatis tanpa rubrik.',
                    'sort_order' => array_search($index, self::STAGES, true) + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    private function questionsFor(Topic $topic): array
    {
        $title = strtolower($topic->title);
        $grade = (int) $topic->grade_level;
        $items = [];
        for ($i = 1; $i <= 10; $i++) {
            $items[] = $this->makeItem($title, $grade, $i);
        }
        return $items;
    }

    private function makeItem(string $title, int $grade, int $i): array
    {
        $n = $i + ($grade - 5) * 3;
        $kind = match (true) {
            str_contains($title, 'rasio') || str_contains($title, 'perbandingan') => 'ratio',
            str_contains($title, 'persentase') => 'percent',
            str_contains($title, 'pecahan dan desimal') => 'decimal',
            str_contains($title, 'pecahan') => 'fraction',
            str_contains($title, 'kelipatan') || str_contains($title, 'faktor') => 'multiple',
            str_contains($title, 'kecepatan') => 'speed',
            str_contains($title, 'skala') => 'scale',
            str_contains($title, 'konversi') || str_contains($title, 'satuan') => 'conversion',
            str_contains($title, 'luas permukaan') => 'surface_volume',
            str_contains($title, 'volume') => 'volume',
            str_contains($title, 'luas bangun') || str_contains($title, 'keliling') => 'area',
            str_contains($title, 'jaring-jaring') => 'nets',
            str_contains($title, 'sifatnya') => 'solid',
            str_contains($title, 'penerapan pengukuran') => 'conversion',
            str_contains($title, 'gabungan') => 'composite',
            str_contains($title, 'hubungan antarbangun geometri') => 'relation',
            str_contains($title, 'diagram garis') || str_contains($title, 'diagram batang') => 'chart',
            str_contains($title, 'tabel') => 'table',
            str_contains($title, 'menganalisis') => 'mean',
            str_contains($title, 'membandingkan') => 'range',
            str_contains($title, 'kesimpulan') => 'conclusion',
            str_contains($title, 'diagram dan penyajian') => 'chartkind',
            str_contains($title, 'data') => 'data',
            default => 'whole',
        };

        $stimulus = '';
        $question = '';
        $answer = null;
        $wrong = [];
        $explanation = '';
        $config = [];
        $unit = null;

        switch ($kind) {
            case 'ratio':
                $a = 2 * $n; $b = 3 * $n; $answer = '2 : 3';
                $stimulus = "Perbandingan jumlah benda merah dan biru adalah {$a} : {$b}.";
                $question = 'Bentuk paling sederhana dari perbandingan tersebut adalah ...';
                $wrong = ['3 : 2', '2 : 5', '1 : 3'];
                $explanation = "Kedua suku dibagi {$n}, sehingga {$a} : {$b} = 2 : 3.";
                break;
            case 'percent':
                $p = [10, 20, 25, 30, 40][($i - 1) % 5]; $base = 100 + 20 * $n; $answer = $p * $base / 100;
                $stimulus = "Sebuah toko memberikan potongan {$p}% dari harga Rp{$base}.";
                $question = 'Berapakah nilai potongannya?'; $unit = 'rupiah';
                $wrong = [$answer + 10, $answer - 10, $base - $answer];
                $explanation = "{$p}/100 × {$base} = {$answer}.";
                $config = ['expected_steps' => [['operation' => 'multiplication', 'values' => [$base, $p / 100], 'result' => $answer]], 'expected_answer' => $answer];
                break;
            case 'fraction':
                $den = 12 + $n; $a = 1 + ($n % 4); $b = 1 + (($n + 1) % 4); $sum = $a + $b; $answer = $sum.'/'.$den;
                $stimulus = "Sebuah pita dibagi menjadi {$den} bagian sama. Rani menggunakan {$a} bagian dan kemudian {$b} bagian lagi.";
                $question = 'Berapa bagian pita yang digunakan seluruhnya?';
                $wrong = [($sum + 1).'/'.$den, abs($a - $b).'/'.$den, $sum.'/'.($den + 1)];
                $explanation = "Penyebut sama, jadi {$a}/{$den} + {$b}/{$den} = {$sum}/{$den}.";
                break;
            case 'decimal':
                $a = number_format($n / 10, 1, '.', ''); $b = number_format(($n + 2) / 10, 1, '.', ''); $answer = number_format((float)$a + (float)$b, 1, '.', '');
                $stimulus = "Panjang pita pertama {$a} m dan pita kedua {$b} m.";
                $question = 'Berapa panjang kedua pita seluruhnya?'; $unit = 'm';
                $wrong = [number_format((float)$answer + 1, 1, '.', ''), number_format((float)$answer - 1, 1, '.', ''), number_format((float)$answer + 0.5, 1, '.', '')];
                $explanation = "{$a} + {$b} = {$answer} m.";
                $config = ['expected_steps' => [['operation' => 'addition', 'values' => [(float)$a, (float)$b], 'result' => (float)$answer]], 'expected_answer' => (float)$answer, 'expected_unit' => 'm'];
                break;
            case 'multiple':
                $base = 4 + $n; $answer = $base * 6;
                $stimulus = "Kelipatan suatu bilangan diperoleh dengan mengalikan bilangan tersebut dengan 1, 2, 3, dan seterusnya.";
                $question = "Berapakah kelipatan keenam dari {$base}?";
                $wrong = [$answer - 2 * $base, $answer + $base, $base * 5];
                $explanation = "Kelipatan keenam = {$base} × 6 = {$answer}.";
                $config = ['expected_steps' => [['operation' => 'multiplication', 'values' => [$base, 6], 'result' => $answer]], 'expected_answer' => $answer];
                break;
            case 'speed':
                $time = 2 + ($n % 5); $speed = 30 + 5 * $n; $distance = $time * $speed; $answer = $speed;
                $stimulus = "Sebuah kendaraan menempuh jarak {$distance} km selama {$time} jam dengan kecepatan tetap.";
                $question = 'Berapa kecepatan rata-ratanya?'; $unit = 'km/jam';
                $wrong = [$speed + 5, $speed - 5, $distance + $time];
                $explanation = "Kecepatan = jarak ÷ waktu = {$distance} ÷ {$time} = {$speed} km/jam.";
                $config = ['expected_steps' => [['operation' => 'division', 'values' => [$distance, $time], 'result' => $speed]], 'expected_answer' => $speed, 'expected_unit' => 'km/jam'];
                break;
            case 'scale':
                $cm = 2 + $n; $scale = 10000; $meters = $cm * $scale / 100;
                $answer = $meters;
                $stimulus = "Pada peta berskala 1 : 10.000, jarak dua tempat adalah {$cm} cm.";
                $question = 'Berapa jarak sebenarnya dalam meter?'; $unit = 'meter';
                $wrong = [$meters / 10, $meters * 10, $meters + 100];
                $explanation = "Jarak sebenarnya = {$cm} × 10.000 cm = {$meters} meter.";
                $config = ['expected_steps' => [['operation' => 'multiplication', 'values' => [$cm, 100], 'result' => $cm * 100]], 'expected_answer' => $meters, 'expected_unit' => 'meter'];
                break;
            case 'conversion':
                $value = 2 + $n; $answer = $value * 100;
                $stimulus = "Sebuah kain memiliki panjang {$value} meter.";
                $question = 'Berapa panjang kain tersebut dalam sentimeter?'; $unit = 'cm';
                $wrong = [$value * 10, $value * 1000, $answer + 10];
                $explanation = "1 meter = 100 sentimeter, jadi {$value} × 100 = {$answer} cm.";
                $config = ['expected_steps' => [['operation' => 'multiplication', 'values' => [$value, 100], 'result' => $answer]], 'expected_answer' => $answer, 'expected_unit' => 'cm'];
                break;
            case 'volume':
                $l = 2 + ($n % 4); $w = 3 + ($n % 3); $h = 2 + ($n % 5); $answer = $l * $w * $h;
                $stimulus = "Sebuah balok memiliki panjang {$l} cm, lebar {$w} cm, dan tinggi {$h} cm.";
                $question = 'Berapakah volume balok tersebut?'; $unit = 'cm3';
                $wrong = [$answer + $l, $l * $w + $h, $answer - $w];
                $explanation = "Volume = panjang × lebar × tinggi = {$l} × {$w} × {$h} = {$answer} cm3.";
                $config = ['expected_steps' => [['operation' => 'multiplication', 'values' => [$l, $w], 'result' => $l * $w], ['operation' => 'multiplication', 'values' => [$l * $w, $h], 'result' => $answer]], 'expected_answer' => $answer];
                break;
            case 'surface_volume':
                if ($i % 2 === 0) {
                    $side = 2 + ($n % 6); $answer = 6 * $side * $side;
                    $stimulus = "Latihan {$i}: sebuah kubus memiliki panjang rusuk {$side} cm.";
                    $question = 'Berapakah luas permukaan kubus tersebut?';
                    $wrong = [$side * $side, 2 * $side * $side, 4 * $side * $side];
                    $explanation = "Luas permukaan kubus = 6 × rusuk × rusuk = 6 × {$side} × {$side} = {$answer} cm2.";
                    $config = ['expected_answer' => $answer];
                } else {
                    $side = 2 + ($n % 6); $answer = $side * $side * $side;
                    $stimulus = "Latihan {$i}: sebuah kubus memiliki panjang rusuk {$side} cm.";
                    $question = 'Berapakah volume kubus tersebut?';
                    $wrong = [$answer + 1, $answer + 2, $answer + 3];
                    $explanation = "Volume kubus = rusuk × rusuk × rusuk = {$side} × {$side} × {$side} = {$answer} cm3.";
                    $config = ['expected_answer' => $answer];
                }
                break;
            case 'relation':
                $answer = 'Setiap persegi merupakan persegi panjang';
                $stimulus = 'Persegi memiliki empat sisi sama panjang dan empat sudut siku-siku. Persegi panjang memiliki dua pasang sisi berhadapan sama panjang dan empat sudut siku-siku.';
                $question = 'Pernyataan hubungan kedua bangun yang benar adalah ...';
                $wrong = ['Setiap persegi panjang merupakan persegi', 'Persegi tidak memiliki sudut siku-siku', 'Persegi dan persegi panjang tidak memiliki kesamaan'];
                $explanation = 'Persegi memenuhi sifat persegi panjang, tetapi persegi panjang belum tentu memiliki empat sisi sama panjang.';
                $stimulus .= ' Kasus pembanding '.$i.'.';
                break;
            case 'area':
                $l = 5 + $n; $w = 3 + ($n % 4); $answer = $l * $w;
                $stimulus = "Sebuah bidang berbentuk persegi panjang memiliki panjang {$l} cm dan lebar {$w} cm.";
                $question = 'Berapakah luas bidang tersebut?'; $unit = 'cm2';
                $wrong = [$l + $w, 2 * ($l + $w), $answer + $l];
                $explanation = "Luas = panjang × lebar = {$l} × {$w} = {$answer} cm2.";
                $config = ['expected_steps' => [['operation' => 'multiplication', 'values' => [$l, $w], 'result' => $answer]], 'expected_answer' => $answer];
                break;
            case 'solid':
                $solid = $i % 3;
                if ($solid === 1) {
                    $answer = 6; $stimulus = 'Bangun ruang yang diamati adalah kubus.';
                    $question = 'Berapa banyak sisi berbentuk persegi yang dimiliki kubus?';
                    $wrong = [8, 10, 12]; $explanation = 'Kubus memiliki 6 sisi berbentuk persegi.';
                } elseif ($solid === 2) {
                    $answer = 12; $stimulus = 'Bangun ruang yang diamati adalah balok.';
                    $question = 'Berapa banyak rusuk yang dimiliki balok?';
                    $wrong = [8, 10, 14]; $explanation = 'Balok memiliki 12 rusuk.';
                } else {
                    $answer = 8; $stimulus = 'Bangun ruang yang diamati adalah kubus.';
                    $question = 'Berapa banyak titik sudut yang dimiliki kubus?';
                    $wrong = [6, 10, 12]; $explanation = 'Kubus memiliki 8 titik sudut.';
                }
                $stimulus .= ' (Latihan '.$i.')';
                break;
            case 'nets':
                $answer = '6 persegi';
                $stimulus = 'Sebuah jaring-jaring kubus tersusun dari beberapa bangun datar yang sama.';
                $question = 'Berapa banyak persegi yang diperlukan untuk membentuk satu kubus?';
                $wrong = ['4 persegi', '5 persegi', '8 persegi'];
                $explanation = 'Kubus mempunyai enam sisi, sehingga jaring-jaringnya terdiri atas enam persegi.';
                $stimulus .= ' Contoh ke-'.$i.'.';
                break;
            case 'composite':
                $a = 4 + $n; $b = 3 + ($n % 4); $c = 2 + ($n % 3); $answer = $a * $b + $c * $b;
                $stimulus = "Bangun gabungan terdiri atas dua persegi panjang berdampingan. Ukuran bagian pertama {$a} cm × {$b} cm dan bagian kedua {$c} cm × {$b} cm.";
                $question = 'Berapakah luas seluruh bangun gabungan?'; $unit = 'cm2';
                $wrong = [$a * $b, ($a + $c) + $b, $answer + $b];
                $explanation = "Luas total = ({$a} × {$b}) + ({$c} × {$b}) = {$answer} cm2.";
                $config = ['expected_steps' => [['operation' => 'multiplication', 'values' => [$a, $b], 'result' => $a * $b], ['operation' => 'multiplication', 'values' => [$c, $b], 'result' => $c * $b]], 'expected_answer' => $answer];
                break;
            case 'chart':
            case 'table':
            case 'data':
                $a = 12 + $n; $b = 17 + 2 * $n; $c = 9 + $n; $answer = $b - $a;
                $stimulus = "Data jumlah buku yang dipinjam: Senin {$a}, Selasa {$b}, Rabu {$c}.";
                $question = 'Berapa selisih jumlah buku yang dipinjam pada Selasa dan Senin?'; $unit = 'buku';
                $wrong = [$a + $b, $b - $c, $answer + 2];
                $explanation = "Selisih = {$b} − {$a} = {$answer} buku.";
                $config = ['expected_steps' => [['operation' => 'subtraction', 'values' => [$b, $a], 'result' => $answer]], 'expected_answer' => $answer, 'expected_unit' => 'buku'];
                break;
            case 'mean':
                $a = 60 + $n; $b = 70 + $n; $c = 80 + $n; $answer = ($a + $b + $c) / 3;
                $stimulus = "Nilai tiga siswa adalah {$a}, {$b}, dan {$c}.";
                $question = 'Berapakah nilai rata-ratanya?';
                $wrong = [$a + $b + $c, $answer + 5, $answer - 5];
                $explanation = "Rata-rata = ({$a} + {$b} + {$c}) ÷ 3 = {$answer}.";
                $config = ['expected_steps' => [['operation' => 'addition', 'values' => [$a, $b], 'result' => $a + $b], ['operation' => 'addition', 'values' => [$a + $b, $c], 'result' => $a + $b + $c], ['operation' => 'division', 'values' => [$a + $b + $c, 3], 'result' => $answer]], 'expected_answer' => $answer];
                break;
            case 'range':
                $a = 45 + $n; $b = 70 + $n; $c = 55 + $n; $answer = $b - $a;
                $stimulus = "Data nilai adalah {$a}, {$b}, dan {$c}.";
                $question = 'Berapakah jangkauan data tersebut?';
                $wrong = [$b - $c, $c - $a, $a + $b + $c];
                $explanation = "Jangkauan = nilai terbesar − nilai terkecil = {$b} − {$a} = {$answer}.";
                $config = ['expected_steps' => [['operation' => 'subtraction', 'values' => [$b, $a], 'result' => $answer]], 'expected_answer' => $answer];
                break;
            case 'conclusion':
                $a = 12 + $n; $b = 7 + $n; $c = 4 + $n;
                $answer = 'Membaca';
                $stimulus = "Dalam survei, {$a} siswa memilih membaca, {$b} memilih menggambar, dan {$c} memilih olahraga.";
                $question = 'Kegiatan apa yang paling banyak dipilih?';
                $wrong = ['Menggambar', 'Olahraga', 'Semua kegiatan sama banyak'];
                $explanation = "Membaca dipilih {$a} siswa, jumlah terbesar pada data.";
                break;
            case 'chartkind':
                $answer = 'Diagram garis';
                $stimulus = 'Data jumlah pengunjung perpustakaan selama '.$n.' hari dicatat secara berurutan.';
                $question = 'Penyajian yang paling tepat untuk memperlihatkan perubahan jumlah pengunjung dari hari ke hari adalah ...';
                $wrong = ['Piktogram tanpa keterangan', 'Denah ruangan', 'Jaring-jaring bangun ruang'];
                $explanation = 'Diagram garis cocok untuk memperlihatkan perubahan data berurutan dari waktu ke waktu.';
                break;
            default:
                $a = 1250 + 100 * $n; $b = 350 + 25 * $n; $answer = $a + $b;
                $stimulus = "Perpustakaan memiliki {$a} buku dan menerima {$b} buku baru.";
                $question = 'Berapa jumlah buku setelah menerima buku baru?'; $unit = 'buku';
                $wrong = [$answer - 100, $answer + 100, $a - $b];
                $explanation = "Jumlah buku = {$a} + {$b} = {$answer} buku.";
                $config = ['expected_steps' => [['operation' => 'addition', 'values' => [$a, $b], 'result' => $answer]], 'expected_answer' => $answer, 'expected_unit' => 'buku'];
        }

        $format = fn ($value) => is_float($value) && floor($value) === $value ? (string)(int)$value : (string)$value;
        $answer = $format($answer);
        $wrong = array_map($format, $wrong);
        return [
            'stimulus' => $stimulus,
            'question' => $question,
            'answer' => $answer,
            'options' => array_merge([$answer], $wrong),
            'explanation' => $explanation,
            'analysis_config' => $config,
        ];
    }
}
