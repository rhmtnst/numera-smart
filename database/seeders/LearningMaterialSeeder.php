<?php

namespace Database\Seeders;

use App\Models\LearningMaterial;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class LearningMaterialSeeder extends Seeder
{
    /**
     * Materi inti ringkas untuk prototipe pembelajaran 36 topik.
     * Konten awal dipublikasikan agar alur siswa dapat diuji; guru tetap
     * perlu meninjau kesesuaian kurikulum dan konteks sekolah sebelum penerapan.
     */
    public function run(): void
    {
        $lessons = [
            'Penjumlahan dan Pengurangan' => ['Gabungkan atau kurangi jumlah benda. Penjumlahan digunakan saat jumlah bertambah atau beberapa kelompok digabung. Pengurangan digunakan untuk mencari sisa atau selisih. Susun bilangan menurut nilai tempat (satuan, puluhan, ratusan), lalu hitung dari kanan ke kiri.', 'Perpustakaan memiliki 125 buku dan menerima 87 buku. Jumlahnya 125 + 87 = 212 buku. Jika 46 buku dipinjam, sisanya 212 − 46 = 166 buku.', 'Di kebun ada 148 tanaman. Sebanyak 39 tanaman dipindahkan. Berapa tanaman yang tersisa?', '109 tanaman'],
            'Perkalian dan Pembagian' => ['Perkalian adalah penjumlahan berulang dengan kelompok yang sama. Pembagian membagi jumlah menjadi kelompok sama banyak. Hubungan keduanya dapat diperiksa dengan operasi kebalikan.', 'Ada 6 kotak. Setiap kotak berisi 8 pensil. Jumlah pensil 6 × 8 = 48. Jika 48 pensil dibagi rata ke 6 kotak, tiap kotak berisi 48 ÷ 6 = 8 pensil.', 'Terdapat 7 kantong dengan 9 kelereng setiap kantong. Berapa jumlah seluruh kelereng?', '63 kelereng'],
            'Operasi Hitung Campuran' => ['Operasi campuran memuat lebih dari satu operasi. Kerjakan perkalian atau pembagian lebih dahulu daripada penjumlahan atau pengurangan. Jika ada tanda kurung, kerjakan bagian di dalam kurung terlebih dahulu.', 'Untuk 20 + 4 × 3, hitung 4 × 3 = 12, kemudian 20 + 12 = 32. Jangan menghitung dari kiri ke kanan tanpa memperhatikan aturan operasi.', 'Hitung 36 − 5 × 4.', '16'],
            'Operasi Hitung Bilangan Cacah' => ['Bilangan cacah dimulai dari 0 dan berlanjut 1, 2, 3, dan seterusnya. Gunakan nilai tempat untuk membaca, membandingkan, mengurutkan, serta melakukan operasi hitung bilangan cacah.', 'Pada bilangan 4.582, angka 4 bernilai 4.000, angka 5 bernilai 500, angka 8 bernilai 80, dan angka 2 bernilai 2.', 'Tuliskan bentuk panjang dari 3.746.', '3.000 + 700 + 40 + 6'],
            'Operasi Hitung Pecahan' => ['Pecahan menyatakan bagian dari satu keseluruhan yang dibagi sama besar. Pembilang menunjukkan banyak bagian yang diambil, sedangkan penyebut menunjukkan jumlah seluruh bagian. Untuk menjumlahkan atau mengurangkan pecahan, samakan penyebut terlebih dahulu.', '1/4 + 2/4 = 3/4 karena penyebutnya sama. Untuk 1/2 + 1/4, ubah 1/2 menjadi 2/4 sehingga hasilnya 3/4.', 'Hitung 2/5 + 1/5.', '3/5'],
            'Kelipatan dan Faktor Bilangan' => ['Kelipatan diperoleh dengan mengalikan suatu bilangan dengan 1, 2, 3, dan seterusnya. Faktor adalah bilangan yang membagi habis suatu bilangan. Kelipatan persekutuan dan faktor persekutuan membantu menyelesaikan masalah berulang dan pembagian kelompok.', 'Kelipatan 4 adalah 4, 8, 12, 16, 20, ... Faktor 12 adalah 1, 2, 3, 4, 6, dan 12.', 'Sebutkan tiga kelipatan positif pertama dari 6.', '6, 12, 18'],
            'Operasi Hitung Pecahan dan Desimal' => ['Pecahan dan desimal dapat menyatakan nilai yang sama. Untuk mengubah pecahan berpenyebut 10 atau 100 menjadi desimal, tuliskan angka sesuai nilai tempat. Saat menghitung, samakan bentuk bilangan bila diperlukan.', '1/2 = 0,5 dan 1/4 = 0,25. Maka 0,5 + 0,25 = 0,75.', 'Ubah 3/4 menjadi bentuk desimal.', '0,75'],
            'Perbandingan dan Rasio' => ['Rasio membandingkan dua besaran. Urutan besaran harus diperhatikan. Rasio 2 : 3 berarti setiap 2 bagian besaran pertama berpasangan dengan 3 bagian besaran kedua. Rasio senilai diperoleh dengan mengalikan atau membagi kedua suku dengan bilangan yang sama.', 'Perbandingan 4 pensil merah dan 6 pensil biru adalah 4 : 6. Sederhanakan dengan membagi keduanya dengan 2 menjadi 2 : 3.', 'Sederhanakan rasio 8 : 12.', '2 : 3'],
            'Persentase dalam Kehidupan Sehari-hari' => ['Persentase berarti bagian per seratus. Tanda % dapat diubah menjadi pecahan berpenyebut 100 atau desimal. Untuk mencari persentase dari suatu jumlah, ubah persentase menjadi pecahan atau desimal lalu kalikan dengan jumlah tersebut.', '25% dari 80 adalah 25/100 × 80 = 20.', 'Berapa 10% dari 150?', '15'],
            'Pengukuran Panjang dan Berat' => ['Panjang mengukur jarak, sedangkan berat dalam konteks sehari-hari mengukur berat benda. Kenali satuan mm, cm, m, km serta g dan kg. Saat mengubah satuan, gunakan hubungan 1 m = 100 cm dan 1 kg = 1.000 g.', 'Panjang pita 2 m sama dengan 200 cm. Berat beras 3 kg sama dengan 3.000 g.', 'Ubah 4 m menjadi sentimeter.', '400 cm'],
            'Pengukuran Waktu' => ['Waktu dapat dinyatakan dalam detik, menit, jam, hari, dan seterusnya. Hubungan penting: 1 menit = 60 detik dan 1 jam = 60 menit. Untuk menghitung lama kegiatan, tentukan selisih waktu mulai dan selesai.', 'Kegiatan dimulai pukul 08.15 dan selesai pukul 09.00. Lama kegiatan adalah 45 menit.', 'Berapa menit dalam 2 jam?', '120 menit'],
            'Hubungan Antar Satuan' => ['Satuan panjang, massa, dan kapasitas memiliki hubungan kelipatan sepuluh pada sistem metrik. Pilih satuan yang sesuai, lalu ubah dengan mengalikan atau membagi berdasarkan hubungan antarsatuan.', '1 kilometer = 1.000 meter. Jadi 2,5 km = 2.500 m.', 'Ubah 3.500 gram menjadi kilogram.', '3,5 kg'],
            'Satuan Luas dan Volume' => ['Luas mengukur besar permukaan dan ditulis dalam satuan persegi seperti cm² atau m². Volume mengukur ruang yang ditempati benda dan dapat dinyatakan dalam satuan kubik atau liter. Bedakan satuan panjang, luas, dan volume.', 'Luas persegi panjang dengan panjang 8 cm dan lebar 5 cm adalah 8 × 5 = 40 cm².', 'Hitung luas persegi panjang berukuran 9 cm × 4 cm.', '36 cm²'],
            'Pengukuran Waktu dan Kecepatan' => ['Kecepatan menyatakan jarak yang ditempuh tiap satuan waktu. Jika jarak dan waktu diketahui, kecepatan rata-rata = jarak ÷ waktu. Pastikan satuan jarak dan waktu sesuai.', 'Sepeda menempuh 12 km dalam 2 jam. Kecepatan rata-ratanya 12 ÷ 2 = 6 km/jam.', 'Seseorang berjalan 15 km selama 3 jam. Berapa kecepatan rata-ratanya?', '5 km/jam'],
            'Konversi Satuan Pengukuran' => ['Konversi satuan mengubah ukuran ke satuan lain tanpa mengubah nilainya. Pada satuan metrik, perpindahan ke satuan lebih kecil biasanya mengalikan dan ke satuan lebih besar membagi sesuai faktor konversi.', '2,4 liter = 2.400 mililiter karena 1 liter = 1.000 mililiter.', 'Ubah 750 cm menjadi meter.', '7,5 m'],
            'Pengukuran Luas dan Volume' => ['Luas bangun datar dihitung dari ukuran sisi atau dimensinya. Volume balok diperoleh dari panjang × lebar × tinggi. Tuliskan satuan persegi untuk luas dan satuan kubik untuk volume.', 'Balok berukuran 4 cm × 3 cm × 5 cm memiliki volume 4 × 3 × 5 = 60 cm³.', 'Hitung volume balok dengan ukuran 6 cm × 2 cm × 3 cm.', '36 cm³'],
            'Satuan dan Skala' => ['Skala membandingkan jarak pada gambar atau peta dengan jarak sebenarnya menggunakan satuan yang sama. Skala 1 : 100.000 berarti 1 cm pada peta mewakili 100.000 cm atau 1 km sebenarnya.', 'Jarak pada peta 3 cm dengan skala 1 : 50.000 mewakili 150.000 cm = 1,5 km.', 'Pada skala 1 : 200.000, jarak 4 cm pada peta mewakili berapa kilometer?', '8 km'],
            'Penerapan Pengukuran dalam Kehidupan' => ['Pengukuran membantu memperkirakan dan menentukan panjang, luas, massa, volume, waktu, serta suhu dalam kegiatan sehari-hari. Pilih alat dan satuan berdasarkan benda atau kejadian yang diukur.', 'Untuk mengukur panjang meja gunakan meteran dan satuan cm atau m. Untuk massa buah gunakan timbangan dan satuan gram atau kilogram.', 'Alat apa yang tepat untuk mengukur massa 2 kg beras?', 'Timbangan'],
            'Mengenal Bangun Datar' => ['Bangun datar adalah bentuk dua dimensi yang memiliki panjang dan lebar. Kenali persegi, persegi panjang, segitiga, lingkaran, dan bangun lain dari sisi, sudut, serta bentuknya.', 'Persegi memiliki empat sisi sama panjang dan empat sudut siku-siku. Persegi panjang memiliki sisi berhadapan sama panjang.', 'Bangun datar apa yang memiliki tiga sisi?', 'Segitiga'],
            'Sifat-Sifat Bangun Datar' => ['Setiap bangun datar memiliki sifat yang dapat dibandingkan, seperti jumlah sisi, panjang sisi, besar sudut, dan simetri. Gunakan sifat tersebut untuk mengelompokkan bangun.', 'Persegi memiliki empat sisi sama panjang. Persegi panjang memiliki dua pasang sisi berhadapan yang sama panjang.', 'Berapa jumlah sisi dan sudut pada segi lima?', '5 sisi dan 5 sudut'],
            'Keliling Bangun Datar' => ['Keliling adalah jumlah panjang seluruh sisi pada bangun datar. Untuk persegi, keliling = 4 × sisi. Untuk persegi panjang, keliling = 2 × (panjang + lebar).', 'Persegi dengan sisi 6 cm memiliki keliling 4 × 6 = 24 cm.', 'Hitung keliling persegi panjang dengan panjang 8 cm dan lebar 3 cm.', '22 cm'],
            'Luas Bangun Datar' => ['Luas adalah ukuran daerah yang ditutupi bangun datar. Luas persegi = sisi × sisi; luas persegi panjang = panjang × lebar. Luas segitiga = 1/2 × alas × tinggi.', 'Segitiga dengan alas 10 cm dan tinggi 6 cm memiliki luas 1/2 × 10 × 6 = 30 cm².', 'Hitung luas persegi dengan sisi 7 cm.', '49 cm²'],
            'Bangun Ruang dan Sifatnya' => ['Bangun ruang memiliki panjang, lebar, dan tinggi serta menempati ruang. Kenali kubus, balok, prisma, limas, tabung, kerucut, dan bola melalui sisi, rusuk, titik sudut, atau permukaan lengkungnya.', 'Kubus memiliki 6 sisi berbentuk persegi, 12 rusuk sama panjang, dan 8 titik sudut.', 'Berapa sisi datar pada balok?', '6 sisi'],
            'Jaring-Jaring Bangun Ruang' => ['Jaring-jaring adalah susunan bangun datar yang dapat dilipat menjadi bangun ruang. Periksa apakah setiap sisi bertemu pada rusuk yang tepat dan tidak saling menumpuk.', 'Jaring-jaring kubus terdiri dari enam persegi sama besar yang tersusun sehingga dapat dilipat menjadi kubus.', 'Bangun datar apa saja yang menyusun jaring-jaring balok?', 'Enam persegi panjang (pasangan ukuran dapat sama)'],
            'Gabungan Bangun Datar' => ['Bangun gabungan terbentuk dari dua atau lebih bangun datar sederhana. Pecah bentuk menjadi bagian yang dikenal, hitung ukuran tiap bagian, lalu jumlahkan atau kurangi sesuai yang ditanyakan.', 'Bentuk L dapat dibagi menjadi dua persegi panjang. Luas total adalah jumlah luas kedua bagian tanpa menghitung daerah tumpang tindih dua kali.', 'Sebutkan satu cara membagi bentuk gabungan berbentuk huruf L.', 'Menjadi dua persegi panjang'],
            'Luas Permukaan dan Volume' => ['Luas permukaan adalah jumlah luas seluruh sisi luar bangun ruang. Volume adalah isi ruang di dalamnya. Untuk kubus, volume = s³ dan luas permukaan = 6s². Untuk balok, volume = p × l × t.', 'Kubus dengan rusuk 4 cm memiliki volume 4 × 4 × 4 = 64 cm³ dan luas permukaan 6 × 16 = 96 cm².', 'Hitung volume kubus dengan rusuk 5 cm.', '125 cm³'],
            'Hubungan Antarbangun Geometri' => ['Bangun geometri dapat memiliki hubungan berdasarkan sisi, sudut, simetri, atau bentuk penyusunnya. Satu bangun dapat menjadi bagian dari bangun lain atau tersusun dari beberapa bangun sederhana.', 'Persegi merupakan persegi panjang khusus karena memiliki empat sudut siku-siku dan sisi berhadapan sejajar, dengan tambahan semua sisi sama panjang.', 'Apa persamaan utama persegi dan persegi panjang?', 'Keduanya memiliki empat sudut siku-siku dan sisi berhadapan sejajar'],
            'Membaca dan Mengumpulkan Data' => ['Data adalah kumpulan informasi hasil pengamatan, pencatatan, atau pengukuran. Data yang baik dicatat secara teratur dan sesuai pertanyaan yang ingin dijawab.', 'Catat warna kesukaan 20 siswa dengan memberi satu tanda pada kategori warna yang dipilih setiap siswa, lalu hitung frekuensinya.', 'Jika ingin mengetahui buah favorit teman sekelas, informasi apa yang perlu dikumpulkan?', 'Pilihan buah dari setiap siswa'],
            'Tabel dan Piktogram' => ['Tabel menyusun data dalam baris dan kolom. Piktogram menyajikan data menggunakan gambar atau simbol. Perhatikan keterangan nilai setiap simbol sebelum menghitung jumlah.', 'Jika satu gambar apel mewakili 2 siswa dan terlihat 5 gambar, berarti ada 10 siswa.', 'Satu simbol mewakili 3 buku. Jika ada 4 simbol, berapa buku yang diwakili?', '12 buku'],
            'Diagram Batang' => ['Diagram batang membandingkan jumlah pada beberapa kategori menggunakan batang. Tinggi batang menunjukkan nilai. Baca judul, label kategori, dan skala sebelum membandingkan data.', 'Pada diagram penjualan, batang Senin menunjukkan 8 dan Selasa 12. Penjualan Selasa lebih banyak 12 − 8 = 4 barang.', 'Kategori A memiliki 7 suara dan B memiliki 11 suara. Berapa selisihnya?', '4 suara'],
            'Mengolah Data dalam Tabel' => ['Data dalam tabel dapat dihitung jumlahnya, dibandingkan, dan dikelompokkan. Periksa satuan serta judul kolom agar tidak salah membaca informasi.', 'Tabel jumlah buku: kelas IV 24, kelas V 28, kelas VI 20. Total buku = 24 + 28 + 20 = 72.', 'Dari data 15, 18, dan 12, berapa jumlah seluruhnya?', '45'],
            'Diagram Garis dan Batang' => ['Diagram garis memperlihatkan perubahan data berurutan, misalnya dari hari ke hari. Diagram batang membandingkan kategori. Pilih diagram yang sesuai dengan tujuan penyajian.', 'Suhu selama tiga hari 28°C, 30°C, dan 29°C dapat disajikan dengan diagram garis untuk melihat perubahan.', 'Diagram apa yang cocok untuk menunjukkan perubahan jumlah pengunjung dari Senin sampai Jumat?', 'Diagram garis'],
            'Membandingkan Data' => ['Membandingkan data dilakukan dengan melihat nilai terbesar, terkecil, selisih, atau pola. Pastikan data berasal dari satuan dan kategori yang sebanding.', 'Jumlah buku kelas A 32 dan kelas B 27. Kelas A memiliki 5 buku lebih banyak.', 'Nilai kelompok pertama 76 dan kelompok kedua 84. Berapa selisihnya?', '8'],
            'Menganalisis Data' => ['Analisis data berarti membaca informasi, menemukan pola, membandingkan nilai, dan menjawab pertanyaan berdasarkan bukti. Kesimpulan harus sesuai dengan data, bukan dugaan.', 'Jika jumlah pengunjung meningkat dari 10, 14, menjadi 18, data menunjukkan kenaikan 4 pengunjung pada setiap pengamatan.', 'Data penjualan 5, 9, 7, 12. Nilai tertinggi terjadi pada pengamatan ke berapa?', 'Pengamatan keempat'],
            'Diagram dan Penyajian Data' => ['Penyajian data dapat menggunakan tabel, diagram batang, diagram garis, atau diagram lingkaran. Pilih bentuk yang membuat informasi mudah dibaca dan tidak menyesatkan.', 'Data pilihan olahraga siswa dapat ditampilkan dalam diagram batang untuk membandingkan banyak pemilih setiap olahraga.', 'Untuk menunjukkan bagian dari keseluruhan dalam persentase, diagram apa yang dapat digunakan?', 'Diagram lingkaran'],
            'Menarik Kesimpulan dari Data' => ['Kesimpulan adalah pernyataan yang didukung oleh hasil pengamatan atau data. Sebutkan pola utama dan hindari menyimpulkan hal yang tidak tercatat.', 'Jika 18 dari 30 siswa memilih bersepeda, dapat disimpulkan bersepeda merupakan pilihan mayoritas pada kelompok yang disurvei.', 'Dalam survei 20 siswa, 12 memilih membaca dan 8 memilih menggambar. Aktivitas mana yang lebih banyak dipilih?', 'Membaca'],
        ];

        foreach (Topic::with('learningDomain')->where('is_active', true)->get() as $topic) {
            $lesson = $lessons[$topic->title] ?? null;
            if (!$lesson) {
                continue;
            }

            [$content, $example, $practice, $answer] = $lesson;
            LearningMaterial::updateOrCreate(
                ['topic_id' => $topic->id],
                [
                    'title' => $topic->title,
                    'competency' => 'Siswa mampu menjelaskan konsep ' . strtolower($topic->title) . ' dan menerapkannya untuk menyelesaikan masalah kontekstual sederhana.',
                    'objectives' => [
                        'Menjelaskan konsep dasar ' . strtolower($topic->title) . '.',
                        'Menggunakan konsep untuk menyelesaikan masalah sederhana.',
                        'Menuliskan langkah dan satuan jawaban secara tepat.',
                    ],
                    'content' => $content,
                    'example_content' => $example,
                    'practice_prompt' => $practice,
                    'estimated_minutes' => 15,
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );
        }
    }
}
