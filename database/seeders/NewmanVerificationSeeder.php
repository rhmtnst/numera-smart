<?php

namespace Database\Seeders;

use App\Models\Topic;
use App\Models\VerificationQuestion;
use Illuminate\Database\Seeder;

class NewmanVerificationSeeder extends Seeder
{
    /**
     * Satu pertanyaan aktif per topik untuk setiap tahap Newman.
     * Aman dijalankan ulang dan menonaktifkan pertanyaan lama yang duplikat.
     */
    public function run(): void
    {
        $templates = [
            'reading' => [
                'question' => 'Bacalah kembali soal tentang :topic. Tuliskan kata, angka, dan informasi penting yang kamu temukan.',
                'guide' => 'Periksa apakah siswa dapat mengenali informasi, angka, satuan, dan kata kunci yang relevan dari stimulus soal.',
            ],
            'comprehension' => [
                'question' => 'Dengan bahasamu sendiri, jelaskan apa yang diketahui dan apa yang diminta dalam soal tentang :topic.',
                'guide' => 'Periksa apakah siswa dapat menjelaskan informasi yang diketahui dan tujuan pertanyaan secara tepat.',
            ],
            'transformation' => [
                'question' => 'Menurutmu, operasi hitung, gambar, tabel, atau cara apa yang tepat untuk menyelesaikan soal tentang :topic? Jelaskan alasanmu.',
                'guide' => 'Periksa apakah siswa memilih model matematika atau strategi yang sesuai dengan hubungan informasi dalam soal, serta alasan pemilihannya.',
            ],
            'process_skills' => [
                'question' => 'Ceritakan langkah demi langkah bagaimana kamu menghitung atau menggunakan cara yang kamu pilih untuk soal tentang :topic.',
                'guide' => 'Periksa urutan langkah, ketepatan operasi, prosedur, dan perhitungan. Bedakan kesalahan memilih model dengan kesalahan melakukan perhitungan.',
            ],
            'encoding' => [
                'question' => 'Tuliskan jawaban akhir soal tentang :topic dengan kalimat lengkap. Sertakan angka dan satuan jika diperlukan.',
                'guide' => 'Periksa apakah siswa menuliskan hasil akhir secara jelas, menggunakan satuan yang sesuai, dan menghubungkan jawaban dengan pertanyaan.',
            ],
        ];

        foreach (Topic::where('is_active', true)->get() as $topic) {
            foreach ($templates as $stage => $template) {
                $questionText = str_replace(':topic', $topic->title, $template['question']);

                $question = VerificationQuestion::query()
                    ->where('topic_id', $topic->id)
                    ->where('target_stage', $stage)
                    ->orderBy('id')
                    ->first();

                if (!$question) {
                    $question = new VerificationQuestion();
                    $question->topic_id = $topic->id;
                    $question->target_stage = $stage;
                }

                $question->question_text = $questionText;
                $question->response_type = 'text';
                $question->options = null;
                $question->interpretation_guide = $template['guide'];
                $question->sort_order = array_search($stage, array_keys($templates), true) + 1;
                $question->is_active = true;
                $question->save();

                VerificationQuestion::query()
                    ->where('topic_id', $topic->id)
                    ->where('target_stage', $stage)
                    ->where('id', '!=', $question->id)
                    ->update(['is_active' => false]);
            }
        }
    }
}
