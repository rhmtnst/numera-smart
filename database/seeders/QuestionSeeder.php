<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $topic = Topic::where('grade_level', 4)
            ->where('title', 'Penjumlahan dan Pengurangan')
            ->firstOrFail();

        $questions = [
            [
                'question_text' => 'Berapakah jumlah buku yang masih tersedia di perpustakaan?',
                'stimulus' => 'Sebuah perpustakaan sekolah memiliki 125 buku cerita. Kemudian, perpustakaan menerima sumbangan sebanyak 87 buku baru. Setelah itu, sebanyak 46 buku dipinjam oleh siswa.',
                'correct_answer' => 'B',
                'explanation' => 'Jumlah buku setelah menerima sumbangan adalah 125 + 87 = 212 buku. Setelah 46 buku dipinjam, jumlah yang tersisa adalah 212 - 46 = 166 buku.',
                'difficulty' => 'easy',
                'sort_order' => 1,
                'options' => [
                    'A' => '156 buku',
                    'B' => '166 buku',
                    'C' => '176 buku',
                    'D' => '212 buku',
                ],
            ],
            [
                'question_text' => 'Berapa jumlah seluruh peserta kegiatan tersebut?',
                'stimulus' => 'Pada kegiatan olahraga sekolah, terdapat 138 siswa kelas IV dan 56 siswa kelas V yang ikut berpartisipasi.',
                'correct_answer' => 'C',
                'explanation' => 'Untuk mengetahui jumlah seluruh peserta, kedua kelompok dijumlahkan: 138 + 56 = 194 siswa.',
                'difficulty' => 'easy',
                'sort_order' => 2,
                'options' => [
                    'A' => '184 siswa',
                    'B' => '192 siswa',
                    'C' => '194 siswa',
                    'D' => '204 siswa',
                ],
            ],
            [
                'question_text' => 'Berapa jumlah beras yang tersisa di gudang?',
                'stimulus' => 'Sebuah gudang menyimpan 250 kilogram beras. Sebanyak 87 kilogram beras dikirim ke beberapa toko.',
                'correct_answer' => 'A',
                'explanation' => 'Jumlah beras yang tersisa diperoleh dengan mengurangkan jumlah beras yang dikirim dari persediaan awal: 250 - 87 = 163 kilogram.',
                'difficulty' => 'easy',
                'sort_order' => 3,
                'options' => [
                    'A' => '163 kilogram',
                    'B' => '173 kilogram',
                    'C' => '183 kilogram',
                    'D' => '337 kilogram',
                ],
            ],
            [
                'question_text' => 'Berapa jumlah buku yang ada di perpustakaan sekarang?',
                'stimulus' => 'Perpustakaan memiliki 320 buku. Sebanyak 78 buku dipinjam oleh siswa. Pada hari berikutnya, 45 buku yang sebelumnya dipinjam dikembalikan.',
                'correct_answer' => 'D',
                'explanation' => 'Pertama, kurangi buku yang dipinjam: 320 - 78 = 242 buku. Kemudian tambahkan buku yang dikembalikan: 242 + 45 = 287 buku.',
                'difficulty' => 'medium',
                'sort_order' => 4,
                'options' => [
                    'A' => '197 buku',
                    'B' => '275 buku',
                    'C' => '353 buku',
                    'D' => '287 buku',
                ],
            ],
            [
                'question_text' => 'Berapa uang yang dimiliki panitia setelah seluruh kegiatan tersebut?',
                'stimulus' => 'Panitia kelas mengumpulkan uang sebesar Rp475.000. Uang sebesar Rp186.000 digunakan untuk membeli perlengkapan kegiatan. Kemudian, panitia menerima tambahan sumbangan sebesar Rp95.000.',
                'correct_answer' => 'B',
                'explanation' => 'Uang setelah membeli perlengkapan adalah Rp475.000 - Rp186.000 = Rp289.000. Setelah menerima sumbangan, jumlahnya menjadi Rp289.000 + Rp95.000 = Rp384.000.',
                'difficulty' => 'medium',
                'sort_order' => 5,
                'options' => [
                    'A' => 'Rp374.000',
                    'B' => 'Rp384.000',
                    'C' => 'Rp394.000',
                    'D' => 'Rp570.000',
                ],
            ],
        ];

        foreach ($questions as $item) {
            $question = Question::updateOrCreate(
                [
                    'topic_id' => $topic->id,
                    'question_text' => $item['question_text'],
                ],
                [
                    'stimulus' => $item['stimulus'],
                    'question_type' => 'multiple_choice',
                    'correct_answer' => $item['correct_answer'],
                    'explanation' => $item['explanation'],
                    'difficulty' => $item['difficulty'],
                    'points' => 10,
                    'sort_order' => $item['sort_order'],
                    'is_active' => true,
                    'review_status' => 'draft',
                    'source' => 'manual',
                    'analysis_config' => match ($item['sort_order']) {
                        1 => ['expected_steps' => [['operation' => 'addition', 'values' => [125, 87], 'result' => 212], ['operation' => 'subtraction', 'values' => [212, 46], 'result' => 166]], 'expected_answer' => 166, 'expected_unit' => 'buku'],
                        2 => ['expected_steps' => [['operation' => 'addition', 'values' => [138, 56], 'result' => 194]], 'expected_answer' => 194, 'expected_unit' => 'siswa'],
                        3 => ['expected_steps' => [['operation' => 'subtraction', 'values' => [250, 87], 'result' => 163]], 'expected_answer' => 163, 'expected_unit' => 'kilogram'],
                        4 => ['expected_steps' => [['operation' => 'subtraction', 'values' => [320, 78], 'result' => 242], ['operation' => 'addition', 'values' => [242, 45], 'result' => 287]], 'expected_answer' => 287, 'expected_unit' => 'buku'],
                        5 => ['expected_steps' => [['operation' => 'subtraction', 'values' => [475000, 186000], 'result' => 289000], ['operation' => 'addition', 'values' => [289000, 95000], 'result' => 384000]], 'expected_answer' => 384000],
                        default => [],
                    },
                ]
            );

            foreach ($item['options'] as $label => $optionText) {
                QuestionOption::updateOrCreate(
                    [
                        'question_id' => $question->id,
                        'option_label' => $label,
                    ],
                    [
                        'option_text' => $optionText,
                        'is_correct' => $label === $item['correct_answer'],
                        'sort_order' => ord($label) - ord('A') + 1,
                    ]
                );
            }
        }
    }
}