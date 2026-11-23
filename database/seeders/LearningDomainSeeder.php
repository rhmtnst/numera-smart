<?php

namespace Database\Seeders;

use App\Models\LearningDomain;
use Illuminate\Database\Seeder;

class LearningDomainSeeder extends Seeder
{
    public function run(): void
    {
        $domains = [
            [
                'name' => 'Operasi Hitung',
                'slug' => 'operasi-hitung',
                'description' => 'Belajar memahami dan menggunakan operasi hitung dalam kehidupan sehari-hari.',
                'sort_order' => 1,
                'topics' => [
                    4 => ['Penjumlahan dan Pengurangan', 'Perkalian dan Pembagian', 'Operasi Hitung Campuran'],
                    5 => ['Operasi Hitung Bilangan Cacah', 'Operasi Hitung Pecahan', 'Kelipatan dan Faktor Bilangan'],
                    6 => ['Operasi Hitung Pecahan dan Desimal', 'Perbandingan dan Rasio', 'Persentase dalam Kehidupan Sehari-hari'],
                ],
            ],
            [
                'name' => 'Pengukuran',
                'slug' => 'pengukuran',
                'description' => 'Belajar mengenal satuan dan menggunakan pengukuran dalam situasi nyata.',
                'sort_order' => 2,
                'topics' => [
                    4 => ['Pengukuran Panjang dan Berat', 'Pengukuran Waktu', 'Hubungan Antar Satuan'],
                    5 => ['Satuan Luas dan Volume', 'Pengukuran Waktu dan Kecepatan', 'Konversi Satuan Pengukuran'],
                    6 => ['Pengukuran Luas dan Volume', 'Satuan dan Skala', 'Penerapan Pengukuran dalam Kehidupan'],
                ],
            ],
            [
                'name' => 'Geometri',
                'slug' => 'geometri',
                'description' => 'Belajar mengenali bentuk, sifat, hubungan, dan ukuran bangun geometri.',
                'sort_order' => 3,
                'topics' => [
                    4 => ['Mengenal Bangun Datar', 'Sifat-Sifat Bangun Datar', 'Keliling Bangun Datar'],
                    5 => ['Luas Bangun Datar', 'Bangun Ruang dan Sifatnya', 'Jaring-Jaring Bangun Ruang'],
                    6 => ['Gabungan Bangun Datar', 'Luas Permukaan dan Volume', 'Hubungan Antarbangun Geometri'],
                ],
            ],
            [
                'name' => 'Data dan Penyajian',
                'slug' => 'data-dan-penyajian',
                'description' => 'Belajar membaca, mengolah, membandingkan, dan menyajikan data.',
                'sort_order' => 4,
                'topics' => [
                    4 => ['Membaca dan Mengumpulkan Data', 'Tabel dan Piktogram', 'Diagram Batang'],
                    5 => ['Mengolah Data dalam Tabel', 'Diagram Garis dan Batang', 'Membandingkan Data'],
                    6 => ['Menganalisis Data', 'Diagram dan Penyajian Data', 'Menarik Kesimpulan dari Data'],
                ],
            ],
        ];

        foreach ($domains as $domainData) {
            $topics = $domainData['topics'];

            $domain = LearningDomain::updateOrCreate(
                ['slug' => $domainData['slug']],
                [
                    'name' => $domainData['name'],
                    'description' => $domainData['description'],
                    'sort_order' => $domainData['sort_order'],
                    'is_active' => true,
                ]
            );

            foreach ($topics as $grade => $topicTitles) {
                foreach ($topicTitles as $index => $title) {
                    $domain->topics()->updateOrCreate(
                        [
                            'grade_level' => $grade,
                            'title' => $title,
                        ],
                        [
                            'description' => "Materi {$title} untuk siswa kelas {$grade}.",
                            'sort_order' => $index + 1,
                            'is_active' => true,
                        ]
                    );
                }
            }
        }
    }
}
