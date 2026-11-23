# NUMERA SMART — Panduan Alur Sistem (Versi Perapian)

Dokumen ini menjelaskan alur operasional yang harus diikuti. Sistem tetap memakai materi utama, soal, dan materi remediasi yang sudah ada; tidak perlu membuat ulang konten.

## A. Peran pengguna

1. **Admin** mengelola sekolah, akun guru/siswa, kode registrasi, dan penugasan guru ke kelas.
2. **Guru** meninjau materi/soal, memantau asesmen, memeriksa analisis Newman, mengonfirmasi temuan, dan memilih materi remediasi.
3. **Siswa** mempelajari materi utama, mengerjakan asesmen, menjawab pertanyaan verifikasi jika bukti belum cukup, lalu mengerjakan remediasi yang direkomendasikan.

## B. Alur inti dari awal sampai akhir

### 1. Persiapan guru
- Pastikan topik aktif dan sesuai kelas siswa.
- Materi utama berstatus `published` agar dapat dibaca siswa.
- Soal asesmen harus berstatus `approved` dan aktif.
- Satu topik yang dipakai untuk uji coba memiliki 10 soal.
- Materi remediasi harus memiliki status `published`, minimal satu latihan aktif, dan pemetaan satu atau lebih tahap Newman.
- Materi remediasi yang sudah ada dipertahankan. Satu materi dapat digunakan ulang untuk beberapa nomor/temuan selama topik dan tahapnya cocok.

### 2. Asesmen siswa
- Siswa membuka topik sesuai kelasnya, mempelajari materi, lalu memulai asesmen.
- Siswa mengisi pilihan jawaban, langkah pengerjaan, dan penjelasan.
- Sistem memeriksa jawaban dan menghitung nilai awal.
- Asesmen disimpan sebagai `completed` terlebih dahulu dalam transaksi database singkat.
- Analisis AI dijalankan setelah transaksi selesai. Panggilan Gemini tidak boleh menahan transaksi SQLite.

### 3. Analisis Newman per nomor soal
Setiap jawaban siswa memiliki satu `AnswerAnalysis` dan lima `NewmanFinding`:
1. `reading` — Membaca
2. `comprehension` — Memahami
3. `transformation` — Transformasi
4. `process_skills` — Keterampilan proses
5. `encoding` — Menuliskan jawaban

Status temuan:
- `error_indicated`: ada bukti kesalahan yang spesifik.
- `no_error_indicated`: bukti menunjukkan tahap dilakukan dengan benar.
- `insufficient_evidence`: bukti belum cukup untuk menyimpulkan.

Jawaban akhir salah tidak otomatis berarti kelima tahap salah. Contoh: siswa dapat memahami cerita dan menghitung dengan benar, tetapi memilih operasi yang keliru. Dalam kasus itu, dugaan utama berada pada Transformation.

### 4. Pertanyaan verifikasi siswa
- Pertanyaan verifikasi bukan asesmen kedua dan tidak selalu harus muncul untuk semua tahap.
- Sistem hanya meminta bukti tambahan untuk tahap yang berstatus `insufficient_evidence`.
- Bank pertanyaan sekarang disiapkan untuk seluruh lima tahap Newman, per topik.
- Jika tahap sudah memiliki bukti yang cukup (`error_indicated` atau `no_error_indicated`), pertanyaan tambahan untuk tahap itu tidak perlu ditampilkan.
- Jika tidak ada pertanyaan, halaman menjelaskan bahwa tidak ada bukti tambahan yang perlu diisi; bukan menampilkan pesan seolah-olah halaman rusak.
- Setelah siswa mengirim respons, sistem menjalankan analisis ulang. Jika AI tidak tersedia, status yang belum dapat dipastikan tetap perlu ditinjau guru; sistem tidak boleh mengarang kepastian.

### 5. Pemeriksaan guru
Ada dua lapis pemeriksaan:
- **Keputusan analisis keseluruhan** pada `AnswerAnalysis`.
- **Keputusan tiap tahap** pada `NewmanFinding`.

Guru harus membaca bukti, respons verifikasi, dan alasan AI. `confirmed` berarti guru menerima temuan/status yang disajikan AI; bukan berarti guru menyatakan siswa salah pada semua tahap. Status temuan tetap harus dibaca:
- `error_indicated` + dikonfirmasi guru: dapat menjadi dasar remediasi.
- `no_error_indicated` + dikonfirmasi guru: tidak perlu remediasi untuk tahap itu.
- `insufficient_evidence`: perlu pemeriksaan/tindak lanjut; jangan langsung diberi label kesalahan.

### 6. Rekomendasi remediasi per nomor
Rekomendasi ditautkan ke `NewmanFinding`, sehingga setiap rekomendasi memiliki jejak ke nomor soal dan tahap Newman tertentu.
Syarat pemberian rekomendasi:
- asesmen selesai;
- analisis keseluruhan selesai dan dikonfirmasi guru;
- temuan berstatus `error_indicated`;
- tahap Newman tersebut ditinjau dan dikonfirmasi guru;
- materi remediasi dipublikasikan;
- topik materi sama dengan topik asesmen;
- materi dipetakan ke tahap Newman yang sesuai;
- tersedia latihan aktif.

Materi yang sama boleh dipilih pada temuan/nomor berbeda. Duplikasi hanya dicegah untuk kombinasi temuan yang sama dan materi yang sama. Ini menjaga riwayat per nomor tanpa menggandakan isi materi.

### 7. Pengerjaan dan hasil remediasi
- Siswa membuka rekomendasi yang diberikan guru.
- Siswa mempelajari materi dan mengerjakan latihan aktif.
- Status rekomendasi bergerak dari `pending` → `in_progress` → `completed`.
- Setiap percobaan remedial menyimpan jawaban, nilai, waktu mulai, dan waktu selesai.
- Guru melihat riwayat hasil remedial dari halaman analisis. Nilai remedial harus dibaca bersama nilai asesmen awal pada topik yang sama; satu nilai remedial saja tidak membuktikan peningkatan kemampuan.

## C. Status alur yang perlu dipahami

| Status | Makna | Tindakan |
|---|---|---|
| Analisis `pending` | Analisis belum selesai | Tunggu/proses ulang; guru jangan memberi rekomendasi |
| Analisis `completed` | Lima temuan tersedia | Guru meninjau |
| Temuan `error_indicated` | Ada bukti indikasi kesalahan | Guru konfirmasi; lalu pilih remediasi |
| Temuan `no_error_indicated` | Tidak ada indikasi kesalahan dari bukti tersedia | Tidak perlu remediasi |
| Temuan `insufficient_evidence` | Bukti belum cukup | Siswa menjawab verifikasi bila tersedia; guru meninjau |
| Rekomendasi `pending` | Materi sudah direkomendasikan | Siswa belum memulai |
| Rekomendasi `in_progress` | Siswa sedang mengerjakan | Siswa lanjutkan latihan |
| Rekomendasi `completed` | Latihan selesai | Guru meninjau hasil |

## D. Perintah aman setelah memasang versi perbaikan

Jalankan dari folder proyek baru:

```bash
php artisan optimize:clear
php artisan db:seed --class=NewmanVerificationSeeder
php artisan route:list
```

Perintah seeder di atas hanya menambah/memperbarui bank pertanyaan verifikasi. Perintah tersebut tidak menghapus akun, asesmen, jawaban, materi, atau hasil siswa.

**Jangan jalankan** `migrate:fresh`, `db:wipe`, atau menghapus `database/database.sqlite` pada database yang berisi data nyata.

## E. Batasan yang harus tetap disadari

- AI adalah alat bantu analisis, bukan penentu final. Guru tetap memvalidasi.
- Jawaban teks siswa tidak boleh dinilai benar/salah hanya dari satu kata kunci.
- Jika Gemini gagal, sistem harus menampilkan status yang belum pasti untuk ditinjau, bukan mengklaim analisis AI berhasil.
- Pengujian otomatis penuh belum dapat dijalankan di lingkungan pemeriksaan ini karena ekstensi PHP `dom`, `mbstring`, `xmlwriter`, dan driver SQLite tidak tersedia. Pemeriksaan sintaks PHP dan pemuatan daftar route dapat dijalankan; pengujian aplikasi harus dilanjutkan di Laragon pada komputer pengguna.
