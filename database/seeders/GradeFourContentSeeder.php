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
 * Paket konten lengkap awal Kelas IV.
 *
 * Konten dibuat sebagai draft yang dapat ditinjau guru. Materi utama
 * dipublikasikan untuk mempertahankan alur belajar yang sudah diuji.
 * Seeder idempotent: tidak menggandakan topik, materi, soal, atau latihan.
 */
class GradeFourContentSeeder extends Seeder
{
    private const STAGES = [
        'reading' => 'Membaca informasi penting pada soal',
        'comprehension' => 'Menjelaskan informasi diketahui dan ditanyakan',
        'transformation' => 'Memilih operasi atau model matematika',
        'process_skills' => 'Menunjukkan langkah dan ketepatan perhitungan',
        'encoding' => 'Menuliskan jawaban akhir beserta satuan/kesimpulan',
    ];

    public function run(): void
    {
        $lessons = $this->lessons();

        DB::transaction(function () use ($lessons) {
            foreach ($lessons as $title => $lesson) {
                $topic = Topic::query()
                    ->where('grade_level', 4)
                    ->where('title', $title)
                    ->first();

                if (!$topic) {
                    continue;
                }

                $material = LearningMaterial::firstOrNew(['topic_id' => $topic->id]);
                $isNew = !$material->exists;

                $material->fill([
                    'title' => $title,
                    'competency' => $lesson['competency'],
                    'objectives' => $lesson['objectives'],
                    'content' => $lesson['content'],
                    'example_content' => $lesson['example'],
                    'practice_prompt' => $lesson['reflection'],
                    'estimated_minutes' => 25,
                ]);

                if ($isNew) {
                    $material->status = 'published';
                    $material->published_at = now();
                }
                $material->save();

                $questions = $this->questionsFor($title);

                // Hapus hanya lima soal prototipe lama yang dibuat seeder awal,
                // agar topik pertama tepat berisi 10 soal rancangan Kelas IV.
                if ($title === 'Penjumlahan dan Pengurangan') {
                    $legacyPrompts = [
                        'Berapakah jumlah buku yang masih tersedia di perpustakaan?',
                        'Berapa jumlah seluruh peserta kegiatan tersebut?',
                        'Berapa jumlah beras yang tersisa di gudang?',
                        'Berapa jumlah buku yang ada di perpustakaan sekarang?',
                        'Berapa uang yang dimiliki panitia setelah seluruh kegiatan tersebut?',
                    ];
                    Question::query()
                        ->where('topic_id', $topic->id)
                        ->whereIn('question_text', $legacyPrompts)
                        ->where('review_status', 'draft')
                        ->whereNull('created_by')
                        ->delete();
                }

               
foreach ($questions as $index => $item) {
    $question = Question::firstOrNew([
        'topic_id' => $topic->id,
        'stimulus' => $item['stimulus'],
        'question_text' => $item['question'],
    ]);

    $isNewQuestion = !$question->exists;


                    $question->fill([
                        'stimulus' => $item['stimulus'],
                        'question_type' => 'multiple_choice',
                        'correct_answer' => 'A',
                        'explanation' => $item['explanation'],
                        'difficulty' => $item['difficulty'] ?? ($index < 3 ? 'easy' : ($index < 7 ? 'medium' : 'hard')),
                        'points' => 10,
                        'sort_order' => $index + 1,
                        'is_active' => true,
                        'source' => 'ai_assisted_draft',
                        'analysis_config' => $item['analysis_config'] ?? [],
                    ]);

                    if ($isNewQuestion) {
                        $question->review_status = 'draft';
                    }
                    $question->save();

                    $options = [
                        'A' => (string) $item['answer'],
                        'B' => (string) $item['wrong'][0],
                        'C' => (string) $item['wrong'][1],
                        'D' => (string) $item['wrong'][2],
                    ];

                    foreach ($options as $label => $text) {
                        QuestionOption::updateOrCreate(
                            ['question_id' => $question->id, 'option_label' => $label],
                            [
                                'option_text' => $text,
                                'is_correct' => $label === 'A',
                                'sort_order' => ord($label) - 64,
                            ]
                        );
                    }
                }

                $this->seedRemedial($topic, $lesson, $questions);
                $this->seedVerificationQuestions($topic);
            }
        });
    }

    private function lessons(): array
    {
        return [
            'Penjumlahan dan Pengurangan' => [
                'competency' => 'Siswa memahami makna penjumlahan dan pengurangan bilangan cacah serta menggunakannya untuk menyelesaikan masalah sehari-hari.',
                'objectives' => ['Menjelaskan penjumlahan sebagai penggabungan atau penambahan.', 'Menjelaskan pengurangan sebagai pengambilan atau pencarian selisih.', 'Menghitung bilangan sampai 10.000 dengan memperhatikan nilai tempat.', 'Memeriksa kewajaran hasil perhitungan.'],
                'content' => "1. Penjumlahan\nPenjumlahan menggabungkan dua kelompok atau lebih. Tanda yang digunakan adalah +. Nilai tempat satuan, puluhan, ratusan, dan ribuan perlu disusun sejajar.\n\n2. Pengurangan\nPengurangan digunakan untuk mencari sisa, selisih, atau banyak benda yang belum diketahui. Tanda yang digunakan adalah −. Jika angka pada suatu nilai tempat tidak cukup, kita dapat melakukan pengelompokan ulang (meminjam dari nilai tempat di sebelah kiri).\n\n3. Memeriksa jawaban\nPeriksa hasil dengan operasi kebalikan. Jika 325 + 148 = 473, maka 473 − 148 harus kembali menjadi 325. Perhatikan juga satuan dan apakah hasil masuk akal.",
                'example' => "Perpustakaan memiliki 1.245 buku. Sekolah menerima 375 buku baru, lalu 128 buku dipinjam.\nJumlah setelah menerima buku: 1.245 + 375 = 1.620 buku.\nSisa setelah dipinjam: 1.620 − 128 = 1.492 buku.",
                'reflection' => 'Di kebun sekolah ada 1.250 bibit. Sebanyak 375 bibit ditanam. Berapa bibit yang belum ditanam? Tuliskan operasi dan cara memeriksa jawabanmu.',
            ],
            'Perkalian dan Pembagian' => [
                'competency' => 'Siswa menggunakan perkalian dan pembagian bilangan cacah untuk menyelesaikan masalah kelompok sama banyak dan pembagian adil.',
                'objectives' => ['Memaknai perkalian sebagai kelompok sama banyak.', 'Menggunakan fakta perkalian dasar.', 'Memaknai pembagian sebagai pengelompokan atau pembagian sama rata.', 'Memeriksa hubungan perkalian dan pembagian.'],
                'content' => "1. Perkalian\nPerkalian dapat dipahami sebagai penjumlahan berulang. Contoh 4 × 6 berarti empat kelompok yang masing-masing berisi enam benda: 6 + 6 + 6 + 6 = 24.\n\n2. Pembagian\nPembagian membagi jumlah menjadi kelompok sama banyak atau menentukan banyak kelompok. Contoh 24 ÷ 4 = 6 berarti 24 benda dibagi menjadi 4 kelompok, setiap kelompok berisi 6 benda.\n\n3. Hubungan operasi\nPerkalian dan pembagian merupakan operasi kebalikan. Jika 7 × 8 = 56, maka 56 ÷ 7 = 8 dan 56 ÷ 8 = 7.",
                'example' => "Ada 8 rak. Setiap rak berisi 12 buku. Jumlah buku adalah 8 × 12 = 96 buku. Jika 96 buku dibagikan sama rata ke 8 kelas, setiap kelas menerima 96 ÷ 8 = 12 buku.",
                'reflection' => 'Ada 9 kantong dengan 8 jeruk pada setiap kantong. Jeruk dibagikan sama rata kepada 6 kelompok. Berapa jeruk yang diterima setiap kelompok?',
            ],
            'Operasi Hitung Campuran' => [
                'competency' => 'Siswa menyelesaikan operasi hitung campuran bilangan cacah dengan urutan operasi yang tepat.',
                'objectives' => ['Mengenali operasi yang terdapat dalam kalimat matematika.', 'Menerapkan urutan operasi.', 'Menggunakan tanda kurung untuk menunjukkan bagian yang dikerjakan lebih dahulu.', 'Menjelaskan langkah penyelesaian.'],
                'content' => "Operasi hitung campuran memuat lebih dari satu operasi, misalnya penjumlahan dan perkalian.\n\nUrutan pengerjaan:\n1. Kerjakan operasi di dalam tanda kurung terlebih dahulu.\n2. Kerjakan perkalian atau pembagian sebelum penjumlahan atau pengurangan.\n3. Jika operasi setingkat, kerjakan dari kiri ke kanan.\n\nJangan selalu menghitung dari kiri ke kanan tanpa memperhatikan aturan tersebut. Tulis setiap langkah agar mudah diperiksa.",
                'example' => "Hitung 24 + 6 × 5.\nLangkah 1: 6 × 5 = 30.\nLangkah 2: 24 + 30 = 54.\nJadi hasilnya 54, bukan 150.",
                'reflection' => 'Hitung 48 − 6 × 5. Jelaskan mengapa perkalian dikerjakan lebih dahulu.',
            ],
            'Pengukuran Panjang dan Berat' => [
                'competency' => 'Siswa memilih alat dan satuan baku yang sesuai untuk mengukur panjang dan massa benda di lingkungan sekitar.',
                'objectives' => ['Mengenali satuan mm, cm, m, km, g, dan kg.', 'Memilih alat ukur yang sesuai.', 'Mengubah satuan panjang dan massa sederhana.', 'Membandingkan hasil pengukuran.'],
                'content' => "Panjang menyatakan jarak dari satu titik ke titik lain. Alat ukur panjang antara lain penggaris dan meteran. Satuan yang sering digunakan adalah milimeter (mm), sentimeter (cm), meter (m), dan kilometer (km).\n\nMassa benda dalam kehidupan sehari-hari sering disebut berat. Alat ukurnya adalah timbangan. Satuan yang sering digunakan adalah gram (g) dan kilogram (kg).\n\nHubungan satuan penting: 1 m = 100 cm; 1 cm = 10 mm; 1 km = 1.000 m; 1 kg = 1.000 g. Pilih satuan yang sesuai dengan ukuran benda.",
                'example' => "Panjang meja 1 m 25 cm. Karena 1 m = 100 cm, panjang meja = 100 cm + 25 cm = 125 cm. Massa beras 2 kg sama dengan 2.000 g.",
                'reflection' => 'Pita sepanjang 3 m dipotong 75 cm. Berapa sentimeter pita yang tersisa?',
            ],
            'Pengukuran Waktu' => [
                'competency' => 'Siswa membaca waktu, menentukan lama kegiatan, dan menggunakan hubungan satuan waktu dalam konteks sehari-hari.',
                'objectives' => ['Membaca jam analog dan digital.', 'Menggunakan hubungan jam, menit, dan detik.', 'Menentukan durasi kegiatan.', 'Menyelesaikan masalah jadwal sederhana.'],
                'content' => "Waktu digunakan untuk menyatakan kapan suatu kegiatan berlangsung dan berapa lama kegiatan dilakukan.\n\nHubungan satuan: 1 menit = 60 detik; 1 jam = 60 menit; 1 hari = 24 jam; 1 minggu = 7 hari.\n\nUntuk mencari lama kegiatan, hitung selisih waktu selesai dan waktu mulai. Jika melewati pergantian jam, hitung bagian waktu secara bertahap agar tidak keliru.",
                'example' => "Kegiatan membaca dimulai pukul 07.25 dan selesai pukul 08.10. Dari 07.25 ke 08.00 adalah 35 menit, lalu ke 08.10 adalah 10 menit. Lama kegiatan 45 menit.",
                'reflection' => 'Latihan dimulai pukul 15.35 dan berlangsung 50 menit. Pukul berapa latihan selesai?',
            ],
            'Hubungan Antar Satuan' => [
                'competency' => 'Siswa menggunakan hubungan antarsatuan baku dalam pengukuran panjang, massa, dan kapasitas sederhana.',
                'objectives' => ['Mengenali hubungan satuan metrik.', 'Mengubah satuan ke bentuk yang lebih kecil atau lebih besar.', 'Memilih satuan yang tepat dalam masalah kontekstual.', 'Menjelaskan langkah konversi.'],
                'content' => "Satuan metrik memiliki hubungan kelipatan sepuluh atau seribu. Mengubah satuan tidak mengubah ukuran sebenarnya, hanya mengubah cara menuliskannya.\n\nContoh hubungan: 1 km = 1.000 m; 1 m = 100 cm; 1 kg = 1.000 g; 1 liter = 1.000 mililiter (mL).\n\nJika mengubah ke satuan yang lebih kecil, jumlah satuannya menjadi lebih banyak. Jika mengubah ke satuan yang lebih besar, jumlah satuannya menjadi lebih sedikit. Perhatikan satuan awal dan satuan tujuan.",
                'example' => "2 kg = 2 × 1.000 g = 2.000 g. Sebaliknya, 3.500 g = 3.500 ÷ 1.000 kg = 3,5 kg.",
                'reflection' => 'Sebuah botol berisi 1,5 liter air. Berapa mililiter air di dalam botol tersebut?',
            ],
            'Mengenal Bangun Datar' => [
                'competency' => 'Siswa mengenali dan mengelompokkan bangun datar berdasarkan bentuk, sisi, dan sudutnya.',
                'objectives' => ['Mengenali persegi, persegi panjang, segitiga, dan lingkaran.', 'Menyebutkan ciri sederhana setiap bangun.', 'Menemukan contoh bangun datar di lingkungan.', 'Mengelompokkan bangun berdasarkan cirinya.'],
                'content' => "Bangun datar adalah bentuk dua dimensi yang memiliki panjang dan lebar. Bangun datar tidak memiliki isi atau volume.\n\nPersegi memiliki empat sisi sama panjang dan empat sudut siku-siku. Persegi panjang memiliki dua pasang sisi berhadapan sama panjang dan empat sudut siku-siku. Segitiga memiliki tiga sisi dan tiga sudut. Lingkaran memiliki satu garis lengkung tertutup dan tidak memiliki titik sudut.\n\nAmati benda di sekitar untuk menemukan bentuk bangun datar, misalnya ubin, buku, rambu, dan jam dinding.",
                'example' => "Permukaan buku berbentuk persegi panjang. Ubin tertentu berbentuk persegi. Rambu peringatan dapat berbentuk segitiga.",
                'reflection' => 'Temukan tiga benda di rumah atau sekolah. Sebutkan bentuk bangun datarnya dan alasanmu.',
            ],
            'Sifat-Sifat Bangun Datar' => [
                'competency' => 'Siswa membandingkan sifat bangun datar berdasarkan jumlah sisi, panjang sisi, dan sudut.',
                'objectives' => ['Menghitung sisi dan sudut bangun datar.', 'Membedakan persegi dan persegi panjang.', 'Mengenali segi banyak sederhana.', 'Mengelompokkan bangun berdasarkan sifat.'],
                'content' => "Sifat bangun datar dapat dilihat dari jumlah sisi, jumlah titik sudut, panjang sisi, dan jenis sudut.\n\nSegitiga memiliki 3 sisi dan 3 titik sudut. Segi empat memiliki 4 sisi dan 4 titik sudut. Segi lima memiliki 5 sisi dan 5 titik sudut. Segi enam memiliki 6 sisi dan 6 titik sudut.\n\nPersegi adalah segi empat dengan semua sisi sama panjang dan semua sudut siku-siku. Persegi panjang memiliki sisi berhadapan sama panjang dan semua sudut siku-siku. Tidak semua segi empat adalah persegi.",
                'example' => "Bangun dengan empat sisi sama panjang dan empat sudut siku-siku adalah persegi. Bangun dengan dua pasang sisi berhadapan sama panjang dan empat sudut siku-siku adalah persegi panjang.",
                'reflection' => 'Apa persamaan dan perbedaan persegi dengan persegi panjang?',
            ],
            'Keliling Bangun Datar' => [
                'competency' => 'Siswa menentukan keliling bangun datar sederhana dengan menjumlahkan panjang seluruh sisinya.',
                'objectives' => ['Menjelaskan keliling sebagai panjang garis batas.', 'Menghitung keliling persegi.', 'Menghitung keliling persegi panjang.', 'Menyelesaikan masalah keliling dalam konteks nyata.'],
                'content' => "Keliling adalah panjang seluruh garis yang membatasi bangun datar. Untuk mencari keliling, jumlahkan panjang semua sisi.\n\nPersegi: K = 4 × sisi.\nPersegi panjang: K = 2 × (panjang + lebar).\nSegitiga: K = sisi 1 + sisi 2 + sisi 3.\n\nPastikan semua ukuran menggunakan satuan yang sama sebelum dijumlahkan. Keliling menggunakan satuan panjang, misalnya cm atau m, bukan cm².",
                'example' => "Taman berbentuk persegi panjang memiliki panjang 12 m dan lebar 7 m. Keliling = 2 × (12 + 7) = 38 m.",
                'reflection' => 'Sebuah bingkai berbentuk persegi memiliki sisi 9 cm. Berapa panjang pita yang diperlukan untuk mengelilingi bingkai?',
            ],
            'Membaca dan Mengumpulkan Data' => [
                'competency' => 'Siswa mengumpulkan, mengelompokkan, membaca, dan membandingkan data sederhana dari lingkungan.',
                'objectives' => ['Mengajukan pertanyaan untuk mengumpulkan data.', 'Mencatat hasil pengamatan atau survei.', 'Mengelompokkan data berdasarkan kategori.', 'Menentukan jumlah dan perbedaan data.'],
                'content' => "Data adalah kumpulan informasi tentang suatu hal. Data dapat diperoleh melalui pengamatan, pencatatan, atau bertanya kepada orang lain (survei).\n\nAgar data mudah dibaca, kelompokkan informasi berdasarkan kategori. Hitung banyak data pada setiap kategori. Periksa kembali agar tidak ada data yang terlewat atau dihitung dua kali.\n\nKita dapat membandingkan kategori yang jumlahnya paling banyak, paling sedikit, atau memiliki selisih tertentu.",
                'example' => "Dari 20 siswa, 8 memilih sepak bola, 7 memilih bulu tangkis, dan 5 memilih berenang. Jumlah seluruh siswa = 8 + 7 + 5 = 20. Pilihan terbanyak adalah sepak bola.",
                'reflection' => 'Tanyakan kepada lima teman tentang buah kesukaan mereka. Catat hasilnya dan tentukan buah yang paling banyak dipilih.',
            ],
            'Tabel dan Piktogram' => [
                'competency' => 'Siswa menyajikan dan membaca data sederhana dalam tabel dan piktogram dengan keterangan yang jelas.',
                'objectives' => ['Membaca judul dan kategori pada tabel.', 'Menafsirkan banyak data pada tabel.', 'Membaca piktogram berdasarkan keterangan simbol.', 'Membandingkan jumlah antar kategori.'],
                'content' => "Tabel menyusun data dalam baris dan kolom. Judul tabel menjelaskan isi data, sedangkan nama kategori menunjukkan kelompok yang dibandingkan.\n\nPiktogram menyajikan data menggunakan gambar atau simbol. Piktogram harus memiliki keterangan nilai setiap simbol. Satu gambar dapat mewakili satu benda atau beberapa benda.\n\nSaat membaca piktogram, kalikan jumlah simbol dengan nilai setiap simbol. Jika ada setengah simbol, perhatikan apakah keterangan memperbolehkan setengah nilai.",
                'example' => "Pada piktogram, satu gambar buku mewakili 2 buku. Jika kategori A memiliki 4 gambar, jumlah buku kategori A adalah 4 × 2 = 8 buku.",
                'reflection' => 'Jika satu gambar mewakili 3 siswa, berapa siswa yang diwakili oleh 5 gambar?',
            ],
            'Diagram Batang' => [
                'competency' => 'Siswa membaca dan menafsirkan diagram batang sederhana untuk membandingkan data.',
                'objectives' => ['Mengenali judul, kategori, dan skala diagram batang.', 'Membaca nilai setiap batang.', 'Menentukan data terbanyak dan tersedikit.', 'Menghitung jumlah dan selisih berdasarkan diagram.'],
                'content' => "Diagram batang menggunakan batang untuk menunjukkan banyak data pada setiap kategori. Batang yang lebih tinggi menunjukkan jumlah yang lebih besar.\n\nPerhatikan judul diagram, nama kategori pada sumbu mendatar, dan skala angka pada sumbu tegak. Baca tinggi batang sesuai skala, bukan hanya memperkirakan dari gambar.\n\nDiagram batang membantu membandingkan kategori, menentukan nilai tertinggi dan terendah, serta menghitung jumlah atau selisih.",
                'example' => "Data buku yang dibaca: Senin 4 buku, Selasa 6 buku, Rabu 3 buku. Jumlah buku = 4 + 6 + 3 = 13. Hari dengan jumlah terbanyak adalah Selasa.",
                'reflection' => 'Data pengunjung perpustakaan: Senin 12, Selasa 15, Rabu 9. Hari apa yang paling ramai dan berapa selisih pengunjung Selasa dengan Rabu?',
            ],
        ];
    }

    private function questionsFor(string $topic): array
    {
        $sets = $this->questionSets();
        return $sets[$topic] ?? [];
    }

    /**
     * Sepuluh soal pilihan ganda per topik. Format baris:
     * stimulus, pertanyaan, jawaban, tiga pengecoh, pembahasan, konfigurasi langkah.
     */
    private function questionSets(): array
    {
        return [
            'Penjumlahan dan Pengurangan' => $this->numericSet([
                ['Perpustakaan memiliki 1.245 buku dan menerima 375 buku baru.', 'Berapa jumlah buku setelah menerima sumbangan?', 1620, [1520, 1610, 1720], '1.245 + 375 = 1.620 buku.', [['operation'=>'addition','values'=>[1245,375],'result'=>1620]]],
                ['Di gudang ada 2.350 kg beras. Sebanyak 875 kg dikirim.', 'Berapa kilogram beras yang tersisa?', 1475, [1375, 1525, 3225], '2.350 − 875 = 1.475 kg.', [['operation'=>'subtraction','values'=>[2350,875],'result'=>1475]]],
                ['Sekolah mengumpulkan 1.875 botol pada minggu pertama dan 2.125 botol pada minggu kedua.', 'Berapa botol yang terkumpul seluruhnya?', 4000, [3900, 4100, 4250], '1.875 + 2.125 = 4.000 botol.', [['operation'=>'addition','values'=>[1875,2125],'result'=>4000]]],
                ['Toko memiliki 3.000 pensil. Sebanyak 1.275 pensil terjual.', 'Berapa pensil yang belum terjual?', 1725, [1625, 1825, 4275], '3.000 − 1.275 = 1.725 pensil.', [['operation'=>'subtraction','values'=>[3000,1275],'result'=>1725]]],
                ['Jumlah peserta lomba kelas IV 1.248 siswa dan kelas V 1.136 siswa.', 'Berapa jumlah peserta kedua kelas?', 2384, [2284, 2394, 2484], '1.248 + 1.136 = 2.384 siswa.', [['operation'=>'addition','values'=>[1248,1136],'result'=>2384]]],
                ['Petani memanen 2.450 buah jeruk. Sebanyak 1.685 buah dikirim ke pasar.', 'Berapa buah jeruk yang tersisa?', 765, [755, 775, 865], '2.450 − 1.685 = 765 buah.', [['operation'=>'subtraction','values'=>[2450,1685],'result'=>765]]],
                ['Perpustakaan memiliki 2.375 buku cerita dan 1.825 buku pengetahuan.', 'Berapa jumlah seluruh buku?', 4200, [4100, 4300, 4000], '2.375 + 1.825 = 4.200 buku.', [['operation'=>'addition','values'=>[2375,1825],'result'=>4200]]],
                ['Sebuah stadion menampung 5.000 orang. Saat ini ada 3.675 penonton.', 'Berapa tempat duduk yang masih kosong?', 1325, [1225, 1425, 1675], '5.000 − 3.675 = 1.325 tempat duduk.', [['operation'=>'subtraction','values'=>[5000,3675],'result'=>1325]]],
                ['Koperasi menerima 1.465 buku tulis pada pagi hari dan 1.275 pada siang hari.', 'Berapa buku tulis yang diterima?', 2740, [2640, 2750, 2840], '1.465 + 1.275 = 2.740 buku.', [['operation'=>'addition','values'=>[1465,1275],'result'=>2740]]],
                ['Ada 4.250 bibit tanaman. Sebanyak 1.875 bibit sudah ditanam.', 'Berapa bibit yang belum ditanam?', 2375, [2275, 2475, 2625], '4.250 − 1.875 = 2.375 bibit.', [['operation'=>'subtraction','values'=>[4250,1875],'result'=>2375]]],
            ]),
            'Perkalian dan Pembagian' => $this->numericSet([
                ['Ada 8 kotak pensil. Setiap kotak berisi 12 pensil.', 'Berapa jumlah seluruh pensil?', 96, [86, 92, 108], '8 × 12 = 96 pensil.', [['operation'=>'multiplication','values'=>[8,12],'result'=>96]]],
                ['Sebanyak 144 kue dibagikan sama rata kepada 12 kelompok.', 'Berapa kue yang diterima setiap kelompok?', 12, [10,11,14], '144 ÷ 12 = 12 kue.', [['operation'=>'division','values'=>[144,12],'result'=>12]]],
                ['Ada 7 baris kursi. Setiap baris berisi 15 kursi.', 'Berapa jumlah kursi seluruhnya?', 105, [95,100,115], '7 × 15 = 105 kursi.', [['operation'=>'multiplication','values'=>[7,15],'result'=>105]]],
                ['Sebanyak 168 buku disusun sama banyak pada 14 rak.', 'Berapa buku pada setiap rak?', 12, [11,13,14], '168 ÷ 14 = 12 buku.', [['operation'=>'division','values'=>[168,14],'result'=>12]]],
                ['Seorang petani menanam 9 baris. Setiap baris berisi 18 bibit.', 'Berapa bibit yang ditanam?', 162, [152,160,172], '9 × 18 = 162 bibit.', [['operation'=>'multiplication','values'=>[9,18],'result'=>162]]],
                ['Ada 225 jeruk yang dimasukkan ke 15 keranjang sama banyak.', 'Berapa jeruk pada setiap keranjang?', 15, [12,14,16], '225 ÷ 15 = 15 jeruk.', [['operation'=>'division','values'=>[225,15],'result'=>15]]],
                ['Setiap siswa mendapat 6 lembar kertas. Ada 24 siswa.', 'Berapa lembar kertas yang diperlukan?', 144, [134,140,154], '24 × 6 = 144 lembar.', [['operation'=>'multiplication','values'=>[24,6],'result'=>144]]],
                ['Sebanyak 196 kelereng dibagi ke 7 anak sama banyak.', 'Berapa kelereng yang diterima setiap anak?', 28, [26,27,29], '196 ÷ 7 = 28 kelereng.', [['operation'=>'division','values'=>[196,7],'result'=>28]]],
                ['Ada 13 kantong. Setiap kantong berisi 11 permen.', 'Berapa jumlah permen?', 143, [133,141,153], '13 × 11 = 143 permen.', [['operation'=>'multiplication','values'=>[13,11],'result'=>143]]],
                ['Sebanyak 240 bibit dibagi rata ke 16 petak.', 'Berapa bibit pada setiap petak?', 15, [14,16,18], '240 ÷ 16 = 15 bibit.', [['operation'=>'division','values'=>[240,16],'result'=>15]]],
            ]),
            'Operasi Hitung Campuran' => $this->numericSet([
                ['Perhatikan 25 + 5 × 4.', 'Berapakah hasil operasi tersebut?', 45, [120,100,50], 'Kerjakan perkalian dahulu: 5 × 4 = 20; 25 + 20 = 45.', [['operation'=>'multiplication','values'=>[5,4],'result'=>20],['operation'=>'addition','values'=>[25,20],'result'=>45]]],
                ['Perhatikan (36 − 12) ÷ 4.', 'Berapakah hasilnya?', 6, [3,9,12], 'Kerjakan kurung: 36 − 12 = 24; 24 ÷ 4 = 6.', [['operation'=>'subtraction','values'=>[36,12],'result'=>24],['operation'=>'division','values'=>[24,4],'result'=>6]]],
                ['Perhatikan 18 + 24 ÷ 6.', 'Berapakah hasilnya?', 22, [7,21,42], '24 ÷ 6 = 4; 18 + 4 = 22.', [['operation'=>'division','values'=>[24,6],'result'=>4],['operation'=>'addition','values'=>[18,4],'result'=>22]]],
                ['Perhatikan 50 − 6 × 7.', 'Berapakah hasilnya?', 8, [308,44,14], '6 × 7 = 42; 50 − 42 = 8.', [['operation'=>'multiplication','values'=>[6,7],'result'=>42],['operation'=>'subtraction','values'=>[50,42],'result'=>8]]],
                ['Perhatikan (15 + 9) × 2.', 'Berapakah hasilnya?', 48, [33,39,30], '15 + 9 = 24; 24 × 2 = 48.', [['operation'=>'addition','values'=>[15,9],'result'=>24],['operation'=>'multiplication','values'=>[24,2],'result'=>48]]],
                ['Perhatikan 72 ÷ 8 + 13.', 'Berapakah hasilnya?', 22, [10,17,31], '72 ÷ 8 = 9; 9 + 13 = 22.', [['operation'=>'division','values'=>[72,8],'result'=>9],['operation'=>'addition','values'=>[9,13],'result'=>22]]],
                ['Perhatikan 9 × 6 − 17.', 'Berapakah hasilnya?', 37, [27,43,71], '9 × 6 = 54; 54 − 17 = 37.', [['operation'=>'multiplication','values'=>[9,6],'result'=>54],['operation'=>'subtraction','values'=>[54,17],'result'=>37]]],
                ['Perhatikan 100 − (8 × 9).', 'Berapakah hasilnya?', 28, [18,36,92], '8 × 9 = 72; 100 − 72 = 28.', [['operation'=>'multiplication','values'=>[8,9],'result'=>72],['operation'=>'subtraction','values'=>[100,72],'result'=>28]]],
                ['Perhatikan (48 ÷ 6) × 5.', 'Berapakah hasilnya?', 40, [13,35,45], '48 ÷ 6 = 8; 8 × 5 = 40.', [['operation'=>'division','values'=>[48,6],'result'=>8],['operation'=>'multiplication','values'=>[8,5],'result'=>40]]],
                ['Perhatikan 35 + 45 ÷ 5.', 'Berapakah hasilnya?', 44, [16,40,80], '45 ÷ 5 = 9; 35 + 9 = 44.', [['operation'=>'division','values'=>[45,5],'result'=>9],['operation'=>'addition','values'=>[35,9],'result'=>44]]],
            ]),
            'Pengukuran Panjang dan Berat' => $this->numericSet([
                ['Panjang pita adalah 3 m.', 'Berapa sentimeter panjang pita?', 300, [30,3000,130], '3 × 100 = 300 cm.', [['operation'=>'multiplication','values'=>[3,100],'result'=>300]]],
                ['Massa beras adalah 2 kg.', 'Berapa gram massa beras?', 2000, [200,20000,1200], '2 × 1.000 = 2.000 g.', [['operation'=>'multiplication','values'=>[2,1000],'result'=>2000]]],
                ['Panjang tali 450 cm.', 'Berapa meter dan sentimeter panjang tali?', '4 m 50 cm', ['45 m','4 m 5 cm','450 m'], '450 cm = 400 cm + 50 cm = 4 m 50 cm.', []],
                ['Jarak rumah ke sekolah 2 km.', 'Berapa meter jarak tersebut?', 2000, [200,20000,1200], '2 × 1.000 = 2.000 m.', [['operation'=>'multiplication','values'=>[2,1000],'result'=>2000]]],
                ['Massa gula 3.500 g.', 'Berapa kilogram dan gram massa gula?', '3 kg 500 g', ['35 kg','3 kg 50 g','350 kg'], '3.500 g = 3.000 g + 500 g = 3 kg 500 g.', []],
                ['Panjang pensil 15 cm.', 'Berapa milimeter panjang pensil?', 150, [15,1500,105], '15 × 10 = 150 mm.', [['operation'=>'multiplication','values'=>[15,10],'result'=>150]]],
                ['Massa satu karung 5 kg dan karung lain 2 kg.', 'Berapa gram massa kedua karung seluruhnya?', 7000, [700,5000,12000], '(5 + 2) × 1.000 = 7.000 g.', [['operation'=>'addition','values'=>[5,2],'result'=>7],['operation'=>'multiplication','values'=>[7,1000],'result'=>7000]]],
                ['Panjang kain 5 m dipotong 125 cm.', 'Berapa sentimeter kain yang tersisa?', 375, [325,425,475], '5 m = 500 cm; 500 − 125 = 375 cm.', [['operation'=>'multiplication','values'=>[5,100],'result'=>500],['operation'=>'subtraction','values'=>[500,125],'result'=>375]]],
                ['Tinggi pohon 4 m 25 cm.', 'Berapa sentimeter tinggi pohon?', 425, [4025,45,250], '4 × 100 + 25 = 425 cm.', [['operation'=>'multiplication','values'=>[4,100],'result'=>400],['operation'=>'addition','values'=>[400,25],'result'=>425]]],
                ['Massa buah 1 kg 250 g.', 'Berapa gram massa buah?', 1250, [1025,2500,1500], '1.000 + 250 = 1.250 g.', [['operation'=>'addition','values'=>[1000,250],'result'=>1250]]],
            ]),
            'Pengukuran Waktu' => $this->numericSet([
                ['Kegiatan dimulai pukul 07.15 dan selesai pukul 08.00.', 'Berapa lama kegiatan berlangsung dalam menit?', 45, [35,50,55], '07.15 ke 08.00 = 45 menit.', []],
                ['Film berlangsung selama 2 jam.', 'Berapa menit lama film?', 120, [100, 140, 200], '2 × 60 = 120 menit.', [['operation'=>'multiplication','values'=>[2,60],'result'=>120]]],
                ['Siswa belajar selama 90 menit.', 'Berapa jam dan menit lama belajar?', '1 jam 30 menit', ['1 jam 15 menit','90 jam','2 jam 30 menit'], '90 menit = 60 menit + 30 menit = 1 jam 30 menit.', []],
                ['Sebuah kegiatan dimulai pukul 09.20 dan berakhir pukul 10.05.', 'Berapa menit durasi kegiatan?', 45, [35,55,65], '09.20 ke 10.00 = 40 menit, ditambah 5 menit = 45 menit.', []],
                ['Ada 3 jam waktu latihan.', 'Berapa menit waktu latihan?', 180, [150,160,210], '3 × 60 = 180 menit.', [['operation'=>'multiplication','values'=>[3,60],'result'=>180]]],
                ['Waktu istirahat berlangsung 15 menit sebanyak 2 kali.', 'Berapa menit jumlah waktu istirahat?', 30, [25,35,45], '15 × 2 = 30 menit.', [['operation'=>'multiplication','values'=>[15,2],'result'=>30]]],
                ['Bus berangkat pukul 13.10 dan tiba pukul 14.00.', 'Berapa lama perjalanan?', 50, [40,60,70], '13.10 ke 14.00 = 50 menit.', []],
                ['Satu hari memiliki 24 jam.', 'Berapa jam dalam 3 hari?', 72, [48,60,96], '3 × 24 = 72 jam.', [['operation'=>'multiplication','values'=>[3,24],'result'=>72]]],
                ['Siswa membaca 25 menit pada pagi hari dan 35 menit sore hari.', 'Berapa total waktu membaca?', 60, [50,55,65], '25 + 35 = 60 menit.', [['operation'=>'addition','values'=>[25,35],'result'=>60]]],
                ['Sebuah acara berlangsung 2 jam 15 menit.', 'Berapa menit seluruh durasinya?', 135, [125,145,215], '2 × 60 + 15 = 135 menit.', [['operation'=>'multiplication','values'=>[2,60],'result'=>120],['operation'=>'addition','values'=>[120,15],'result'=>135]]],
            ]),
            'Hubungan Antar Satuan' => $this->numericSet([
                ['Sebuah botol berisi 2 liter air.', 'Berapa mililiter air tersebut?', 2000, [200,20000,1200], '2 × 1.000 = 2.000 mL.', [['operation'=>'multiplication','values'=>[2,1000],'result'=>2000]]],
                ['Panjang jalan 3 km.', 'Berapa meter panjang jalan?', 3000, [300,30000,1300], '3 × 1.000 = 3.000 m.', [['operation'=>'multiplication','values'=>[3,1000],'result'=>3000]]],
                ['Massa tepung 4.500 gram.', 'Berapa kilogram dan gram massa tepung?', '4 kg 500 g', ['45 kg','4 kg 50 g','450 kg'], '4.500 g = 4.000 g + 500 g.', []],
                ['Ada 750 mL jus.', 'Berapa liter dan mililiter jumlah jus?', '0,75 liter', ['7,5 liter','0,075 liter','75 liter'], '750 mL = 750/1.000 liter = 0,75 liter.', []],
                ['Panjang tali 250 cm.', 'Berapa meter dan sentimeter panjang tali?', '2 m 50 cm', ['25 m','2 m 5 cm','250 m'], '250 cm = 200 cm + 50 cm.', []],
                ['Massa beras 6 kg.', 'Berapa gram massa beras?', 6000, [600,60000,1600], '6 × 1.000 = 6.000 g.', [['operation'=>'multiplication','values'=>[6,1000],'result'=>6000]]],
                ['Isi wadah 1.500 mL.', 'Berapa liter dan mililiter isi wadah?', '1 liter 500 mL', ['15 liter','1 liter 50 mL','150 liter'], '1.500 mL = 1.000 mL + 500 mL.', []],
                ['Panjang kain 7 m.', 'Berapa sentimeter panjang kain?', 700, [70,7000,170], '7 × 100 = 700 cm.', [['operation'=>'multiplication','values'=>[7,100],'result'=>700]]],
                ['Massa apel 2 kg 250 g.', 'Berapa gram massa apel?', 2250, [2025,2500,225], '2.000 + 250 = 2.250 g.', [['operation'=>'addition','values'=>[2000,250],'result'=>2250]]],
                ['Jarak lari 5.000 m.', 'Berapa kilometer jarak lari?', 5, [50,0.5,500], '5.000 ÷ 1.000 = 5 km.', [['operation'=>'division','values'=>[5000,1000],'result'=>5]]],
            ]),
            'Mengenal Bangun Datar' => $this->textSet([
                ['Permukaan ubin memiliki empat sisi sama panjang dan empat sudut siku-siku.', 'Bangun datar apakah yang sesuai?', 'Persegi', ['Persegi panjang','Segitiga','Lingkaran'], 'Persegi memiliki empat sisi sama panjang dan empat sudut siku-siku.'],
                ['Sebuah bentuk memiliki tiga sisi dan tiga titik sudut.', 'Apa nama bangun datar tersebut?', 'Segitiga', ['Persegi','Lingkaran','Segi lima'], 'Bangun dengan tiga sisi disebut segitiga.'],
                ['Sampul buku memiliki dua pasang sisi berhadapan sama panjang dan empat sudut siku-siku.', 'Bangun apakah bentuk sampul buku?', 'Persegi panjang', ['Persegi','Segitiga','Lingkaran'], 'Persegi panjang memiliki dua pasang sisi berhadapan sama panjang.'],
                ['Jam dinding berbentuk bulat tanpa titik sudut.', 'Bangun datar apakah yang menyerupainya?', 'Lingkaran', ['Persegi','Segitiga','Trapesium'], 'Lingkaran memiliki garis lengkung tertutup dan tidak memiliki titik sudut.'],
                ['Bangun datar memiliki empat sisi.', 'Termasuk kelompok bangun apakah bentuk tersebut?', 'Segi empat', ['Segitiga','Segi lima','Lingkaran'], 'Bangun dengan empat sisi disebut segi empat.'],
                ['Rambu berbentuk tiga sisi.', 'Berapa jumlah titik sudutnya?', '3', ['2','4','5'], 'Segitiga mempunyai tiga titik sudut.'],
                ['Sebuah bangun memiliki satu garis lengkung tertutup.', 'Berapa titik sudut lingkaran?', '0', ['1','2','4'], 'Lingkaran tidak memiliki titik sudut.'],
                ['Ubin berbentuk persegi memiliki sisi 6 cm.', 'Berapa jumlah sisi ubin tersebut?', '4', ['3','5','6'], 'Persegi merupakan segi empat, sehingga memiliki empat sisi.'],
                ['Bentuk atap rumah tampak seperti bangun dengan tiga sisi.', 'Apa nama bangun tersebut?', 'Segitiga', ['Persegi','Lingkaran','Persegi panjang'], 'Bentuk dengan tiga sisi adalah segitiga.'],
                ['Bentuk buku tulis tampak memiliki empat sudut siku-siku.', 'Bangun yang paling sesuai adalah?', 'Persegi panjang', ['Lingkaran','Segitiga','Setengah lingkaran'], 'Buku tulis umumnya berbentuk persegi panjang.'],
            ]),
            'Sifat-Sifat Bangun Datar' => $this->textSet([
                ['Persegi memiliki empat sisi sama panjang.', 'Berapa jumlah sudut persegi?', '4', ['3','5','6'], 'Persegi memiliki empat sudut.'],
                ['Segi lima merupakan bangun datar.', 'Berapa jumlah sisinya?', '5', ['4','6','8'], 'Awalan penta berarti lima; segi lima mempunyai lima sisi.'],
                ['Segi enam mempunyai berapa titik sudut?', 'Pilih jumlah titik sudut yang benar.', '6', ['5','7','8'], 'Segi enam memiliki enam sisi dan enam titik sudut.'],
                ['Persegi panjang memiliki sisi berhadapan sama panjang.', 'Berapa pasang sisi berhadapan?', '2 pasang', ['1 pasang','3 pasang','4 pasang'], 'Persegi panjang mempunyai dua pasang sisi berhadapan.'],
                ['Segitiga memiliki tiga sisi.', 'Berapa jumlah titik sudutnya?', '3', ['2','4','5'], 'Setiap segitiga mempunyai tiga titik sudut.'],
                ['Bangun memiliki empat sisi sama panjang dan empat sudut siku-siku.', 'Bangun apakah itu?', 'Persegi', ['Persegi panjang','Segitiga','Lingkaran'], 'Ciri tersebut merupakan sifat persegi.'],
                ['Bangun memiliki enam sisi.', 'Nama bangun berdasarkan jumlah sisi adalah?', 'Segi enam', ['Segi lima','Segi empat','Segi tujuh'], 'Bangun bersisi enam disebut segi enam.'],
                ['Persegi dan persegi panjang sama-sama memiliki empat sudut siku-siku.', 'Pernyataan ini menunjukkan apa?', 'Persamaan sifat', ['Perbedaan jumlah sisi','Tidak ada persamaan','Keduanya lingkaran'], 'Keduanya memiliki empat sudut siku-siku.'],
                ['Sebuah segi empat memiliki dua pasang sisi sejajar.', 'Berapa jumlah sisinya?', '4', ['3','5','6'], 'Segi empat memiliki empat sisi.'],
                ['Bangun datar dengan lima sisi disebut apa?', 'Pilih nama yang tepat.', 'Segi lima', ['Segi empat','Segi enam','Segitiga'], 'Bangun dengan lima sisi disebut segi lima.'],
            ]),
            'Keliling Bangun Datar' => $this->numericSet([
                ['Persegi memiliki sisi 8 cm.', 'Berapakah keliling persegi?', 32, [24,16,64], 'K = 4 × 8 = 32 cm.', [['operation'=>'multiplication','values'=>[4,8],'result'=>32]]],
                ['Persegi panjang panjangnya 10 cm dan lebarnya 4 cm.', 'Berapakah kelilingnya?', 28, [14,40,24], 'K = 2 × (10 + 4) = 28 cm.', [['operation'=>'addition','values'=>[10,4],'result'=>14],['operation'=>'multiplication','values'=>[14,2],'result'=>28]]],
                ['Segitiga memiliki sisi 5 cm, 6 cm, dan 7 cm.', 'Berapakah kelilingnya?', 18, [17,19,20], '5 + 6 + 7 = 18 cm.', [['operation'=>'addition','values'=>[5,6],'result'=>11],['operation'=>'addition','values'=>[11,7],'result'=>18]]],
                ['Persegi memiliki sisi 12 m.', 'Berapakah kelilingnya?', 48, [24,36,144], '4 × 12 = 48 m.', [['operation'=>'multiplication','values'=>[4,12],'result'=>48]]],
                ['Persegi panjang berukuran 15 m × 5 m.', 'Berapakah kelilingnya?', 40, [20,75,30], '2 × (15 + 5) = 40 m.', [['operation'=>'addition','values'=>[15,5],'result'=>20],['operation'=>'multiplication','values'=>[20,2],'result'=>40]]],
                ['Segitiga sama sisi memiliki panjang sisi 9 cm.', 'Berapakah kelilingnya?', 27, [18,36,81], '3 × 9 = 27 cm.', [['operation'=>'multiplication','values'=>[3,9],'result'=>27]]],
                ['Taman berbentuk persegi dengan sisi 14 m.', 'Berapa meter pagar untuk mengelilinginya?', 56, [28,42,196], '4 × 14 = 56 m.', [['operation'=>'multiplication','values'=>[4,14],'result'=>56]]],
                ['Persegi panjang memiliki panjang 18 cm dan lebar 7 cm.', 'Berapakah kelilingnya?', 50, [25,126,43], '2 × (18 + 7) = 50 cm.', [['operation'=>'addition','values'=>[18,7],'result'=>25],['operation'=>'multiplication','values'=>[25,2],'result'=>50]]],
                ['Bangun segitiga memiliki sisi 8 cm, 8 cm, dan 10 cm.', 'Berapakah kelilingnya?', 26, [18,24,28], '8 + 8 + 10 = 26 cm.', [['operation'=>'addition','values'=>[8,8],'result'=>16],['operation'=>'addition','values'=>[16,10],'result'=>26]]],
                ['Lapangan persegi panjang berukuran 25 m × 15 m.', 'Berapakah keliling lapangan?', 80, [40,375,70], '2 × (25 + 15) = 80 m.', [['operation'=>'addition','values'=>[25,15],'result'=>40],['operation'=>'multiplication','values'=>[40,2],'result'=>80]]],
            ]),
            'Membaca dan Mengumpulkan Data' => $this->numericSet([
                ['Hasil survei buah: apel 8 siswa, jeruk 6 siswa, pisang 5 siswa.', 'Berapa siswa yang mengikuti survei?', 19, [18,20,21], '8 + 6 + 5 = 19 siswa.', [['operation'=>'addition','values'=>[8,6],'result'=>14],['operation'=>'addition','values'=>[14,5],'result'=>19]]],
                ['Data buku dibaca: Senin 4, Selasa 7, Rabu 5.', 'Hari apa jumlah buku terbanyak dibaca?', 'Selasa', ['Senin','Rabu','Sama banyak'], 'Nilai terbesar adalah 7 pada hari Selasa.'],
                ['Data tanaman: mawar 12, melati 9, anggrek 7.', 'Berapa selisih mawar dan anggrek?', 5, [3,4,6], '12 − 7 = 5 tanaman.', [['operation'=>'subtraction','values'=>[12,7],'result'=>5]]],
                ['Survei olahraga: sepak bola 10, bulu tangkis 8, renang 6.', 'Berapa siswa memilih bulu tangkis atau renang?', 14, [12,16,18], '8 + 6 = 14 siswa.', [['operation'=>'addition','values'=>[8,6],'result'=>14]]],
                ['Data kendaraan: sepeda 9, motor 13, mobil 4.', 'Kategori mana yang paling sedikit?', 'Mobil', ['Sepeda','Motor','Sama banyak'], 'Jumlah paling sedikit adalah 4 pada kategori mobil.'],
                ['Data kehadiran: Senin 28, Selasa 30, Rabu 29.', 'Berapa jumlah hadir selama tiga hari?', 87, [86,88,89], '28 + 30 + 29 = 87 siswa-hari.', [['operation'=>'addition','values'=>[28,30],'result'=>58],['operation'=>'addition','values'=>[58,29],'result'=>87]]],
                ['Data warna kesukaan: merah 7, biru 11, hijau 8.', 'Berapa selisih pilihan biru dan merah?', 4, [3,5,6], '11 − 7 = 4 siswa.', [['operation'=>'subtraction','values'=>[11,7],'result'=>4]]],
                ['Data buku: cerita 15, pengetahuan 12, komik 9.', 'Berapa jumlah buku cerita dan komik?', 24, [21,26,36], '15 + 9 = 24 buku.', [['operation'=>'addition','values'=>[15,9],'result'=>24]]],
                ['Data hasil panen: Senin 20 kg, Selasa 25 kg, Rabu 15 kg.', 'Berapa total hasil panen?', 60, [50,55,65], '20 + 25 + 15 = 60 kg.', [['operation'=>'addition','values'=>[20,25],'result'=>45],['operation'=>'addition','values'=>[45,15],'result'=>60]]],
                ['Data pengunjung: pagi 18, siang 25, sore 17.', 'Waktu mana yang memiliki pengunjung terbanyak?', 'Siang', ['Pagi','Sore','Sama banyak'], 'Jumlah terbesar adalah 25 pada waktu siang.'],
            ]),
            'Tabel dan Piktogram' => $this->numericSet([
                ['Dalam tabel, kelas IV A mengumpulkan 12 kg kertas dan IV B 15 kg.', 'Berapa kilogram kertas yang terkumpul?', 27, [25,26,28], '12 + 15 = 27 kg.', [['operation'=>'addition','values'=>[12,15],'result'=>27]]],
                ['Satu gambar pada piktogram mewakili 2 buku. Ada 6 gambar.', 'Berapa buku yang diwakili?', 12, [8,10,14], '6 × 2 = 12 buku.', [['operation'=>'multiplication','values'=>[6,2],'result'=>12]]],
                ['Satu simbol mewakili 5 siswa. Kategori A memiliki 4 simbol.', 'Berapa siswa pada kategori A?', 20, [15,25,30], '4 × 5 = 20 siswa.', [['operation'=>'multiplication','values'=>[4,5],'result'=>20]]],
                ['Tabel menunjukkan apel 14, jeruk 11, dan mangga 9.', 'Berapa jumlah seluruh buah?', 34, [32,33,35], '14 + 11 + 9 = 34 buah.', [['operation'=>'addition','values'=>[14,11],'result'=>25],['operation'=>'addition','values'=>[25,9],'result'=>34]]],
                ['Satu gambar mewakili 3 kendaraan. Piktogram menunjukkan 7 gambar.', 'Berapa kendaraan seluruhnya?', 21, [18,24,27], '7 × 3 = 21 kendaraan.', [['operation'=>'multiplication','values'=>[7,3],'result'=>21]]],
                ['Tabel buku: cerita 18, sains 12, sejarah 10.', 'Berapa selisih buku cerita dan sejarah?', 8, [6,7,9], '18 − 10 = 8 buku.', [['operation'=>'subtraction','values'=>[18,10],'result'=>8]]],
                ['Satu simbol mewakili 4 siswa. Ada 5 simbol dan setengah simbol.', 'Berapa siswa yang diwakili?', 22, [20,24,26], '5 × 4 + 2 = 22 siswa.', [['operation'=>'multiplication','values'=>[5,4],'result'=>20],['operation'=>'addition','values'=>[20,2],'result'=>22]]],
                ['Tabel hasil kebun: cabai 16 kg, tomat 13 kg.', 'Berapa total hasil kebun?', 29, [27,28,30], '16 + 13 = 29 kg.', [['operation'=>'addition','values'=>[16,13],'result'=>29]]],
                ['Piktogram menunjukkan 8 simbol. Setiap simbol mewakili 5 paket.', 'Berapa paket seluruhnya?', 40, [35,45,50], '8 × 5 = 40 paket.', [['operation'=>'multiplication','values'=>[8,5],'result'=>40]]],
                ['Tabel pengunjung: Senin 24, Selasa 31, Rabu 27.', 'Berapa selisih pengunjung terbanyak dan tersedikit?', 7, [5,6,8], '31 − 24 = 7 pengunjung.', [['operation'=>'subtraction','values'=>[31,24],'result'=>7]]],
            ]),
            'Diagram Batang' => $this->numericSet([
                ['Diagram batang menunjukkan buku dibaca: Senin 5, Selasa 8, Rabu 6.', 'Berapa jumlah buku yang dibaca?', 19, [18,20,21], '5 + 8 + 6 = 19 buku.', [['operation'=>'addition','values'=>[5,8],'result'=>13],['operation'=>'addition','values'=>[13,6],'result'=>19]]],
                ['Diagram menunjukkan pengunjung: Senin 12, Selasa 17, Rabu 9.', 'Hari apa pengunjung terbanyak?', 'Selasa', ['Senin','Rabu','Sama banyak'], 'Batang tertinggi bernilai 17 pada Selasa.'],
                ['Diagram menunjukkan hasil panen 25 kg dan 18 kg pada dua hari.', 'Berapa selisih hasil panen?', 7, [6,8,9], '25 − 18 = 7 kg.', [['operation'=>'subtraction','values'=>[25,18],'result'=>7]]],
                ['Diagram batang: merah 14, biru 20, hijau 16.', 'Berapa jumlah data biru dan hijau?', 36, [34,35,37], '20 + 16 = 36.', [['operation'=>'addition','values'=>[20,16],'result'=>36]]],
                ['Diagram menunjukkan peserta: kelas A 24, kelas B 28, kelas C 22.', 'Berapa jumlah seluruh peserta?', 74, [72,73,75], '24 + 28 + 22 = 74 peserta.', [['operation'=>'addition','values'=>[24,28],'result'=>52],['operation'=>'addition','values'=>[52,22],'result'=>74]]],
                ['Batang tertinggi bernilai 35 dan terendah 18.', 'Berapa selisih kedua nilai?', 17, [15,16,18], '35 − 18 = 17.', [['operation'=>'subtraction','values'=>[35,18],'result'=>17]]],
                ['Diagram menunjukkan buah terjual: apel 30, jeruk 25, pisang 20.', 'Berapa jumlah buah terjual?', 75, [70,80,85], '30 + 25 + 20 = 75 buah.', [['operation'=>'addition','values'=>[30,25],'result'=>55],['operation'=>'addition','values'=>[55,20],'result'=>75]]],
                ['Diagram menunjukkan kehadiran 18, 20, 19, dan 23 siswa.', 'Berapa nilai tertinggi?', 23, [18,20,19], 'Nilai tertinggi dari data adalah 23 siswa.'],
                ['Data diagram: Senin 16, Selasa 21, Rabu 18.', 'Berapa selisih Selasa dan Senin?', 5, [4,6,7], '21 − 16 = 5.', [['operation'=>'subtraction','values'=>[21,16],'result'=>5]]],
                ['Diagram batang menunjukkan 4 kategori: 10, 15, 12, dan 13.', 'Berapa jumlah seluruh data?', 50, [48,49,51], '10 + 15 + 12 + 13 = 50.', [['operation'=>'addition','values'=>[10,15],'result'=>25],['operation'=>'addition','values'=>[12,13],'result'=>25],['operation'=>'addition','values'=>[25,25],'result'=>50]]],
            ]),
        ];
    }

    private function numericSet(array $rows): array
    {
        return array_map(fn ($r) => [
            'stimulus' => $r[0],
            'question' => $r[1],
            'answer' => $r[2],
            'wrong' => $r[3],
            'explanation' => $r[4],
            'analysis_config' => [
                'expected_answer' => $r[2],
                'expected_steps' => $r[5] ?? [],
            ],
        ], $rows);
    }

    private function textSet(array $rows): array
    {
        return array_map(fn ($r) => [
            'stimulus' => $r[0],
            'question' => $r[1],
            'answer' => $r[2],
            'wrong' => $r[3],
            'explanation' => $r[4],
            'analysis_config' => ['expected_answer' => $r[2], 'expected_steps' => []],
        ], $rows);
    }

    private function seedRemedial(Topic $topic, array $lesson, array $questions): void
    {
        $material = RemedialMaterial::firstOrNew([
            'topic_id' => $topic->id,
            'title' => 'Belajar Kembali: ' . $topic->title,
        ]);
        $isNew = !$material->exists;

        $material->fill([
            'description' => 'Penguatan konsep ' . $topic->title . ' melalui langkah sederhana, contoh terbimbing, dan latihan bertahap.',
            'content' => "Mari belajar kembali secara perlahan.\n\n" . $lesson['content'] . "\n\nStrategi belajar:\n1. Baca soal sampai selesai.\n2. Tandai informasi penting.\n3. Jelaskan apa yang diketahui dan ditanyakan.\n4. Pilih operasi atau gambar yang sesuai.\n5. Hitung langkah demi langkah.\n6. Periksa kembali jawaban dan satuannya.",
            'example_content' => $lesson['example'],
        ]);
        if ($isNew) {
            $material->created_by = null;
            $material->status = 'draft';
        }
        $material->save();

        foreach (array_keys(self::STAGES) as $stage) {
            RemedialMaterialNewmanStage::updateOrCreate(
                ['remedial_material_id' => $material->id, 'stage' => $stage],
                []
            );
        }

        foreach (array_slice($questions, 0, 5) as $i => $questionData) {
            $exercise = RemedialExercise::firstOrNew([
                'remedial_material_id' => $material->id,
                'sort_order' => $i + 1,
            ]);
            $exercise->fill([
                'question_type' => 'multiple_choice',
                'question_text' => $questionData['stimulus'] . ' ' . $questionData['question'],
                'options' => [
                    'A' => (string) $questionData['answer'],
                    'B' => (string) $questionData['wrong'][0],
                    'C' => (string) $questionData['wrong'][1],
                    'D' => (string) $questionData['wrong'][2],
                ],
                'correct_answer' => 'A',
                'explanation' => $questionData['explanation'] .
                    ' Gunakan langkah membaca, memahami, memilih strategi, menghitung, dan menuliskan kesimpulan.',
                'points' => 2,
                'is_active' => true,
            ]);
            $exercise->save();
        }
    }

    private function seedVerificationQuestions(Topic $topic): void
    {
        $topic->verificationQuestions()
            ->whereIn('target_stage', ['reading', 'comprehension'])
            ->where(function ($query) {
                $query->where('question_text', 'like', 'Bacalah kembali soal tentang%')
                    ->orWhere('question_text', 'like', 'Dengan bahasamu sendiri%');
            })
            ->delete();

        $prompts = [
            'reading' => 'Bacalah kembali soal tentang ' . $topic->title . '. Kata, angka, dan satuan apa yang menurutmu penting?',
            'comprehension' => 'Dengan bahasamu sendiri, apa yang diketahui dan apa yang diminta dalam soal?',
            'transformation' => 'Operasi, gambar, tabel, atau cara apa yang kamu pilih? Mengapa cara itu sesuai?',
            'process_skills' => 'Tunjukkan langkah perhitunganmu satu per satu. Pada bagian mana kamu merasa ragu?',
            'encoding' => 'Tuliskan jawaban akhir dengan satuan dan jelaskan arti jawaban itu dalam cerita soal.',
        ];

        foreach ($prompts as $index => $prompt) {
            VerificationQuestion::updateOrCreate(
                [
                    'topic_id' => $topic->id,
                    'target_stage' => $index,
                    'question_text' => $prompt,
                ],
                [
                    'response_type' => 'text',
                    'interpretation_guide' => self::STAGES[$index] ?? 'Bukti respons perlu ditinjau guru.',
                    'sort_order' => array_search($index, array_keys(self::STAGES), true) + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
