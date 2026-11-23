# NUMERA SMART — Paket Konten Kelas IV

## Tujuan paket

Paket ini menyiapkan satu siklus konten Kelas IV untuk 12 topik yang sudah ada di NUMERA SMART:
- 12 materi utama yang dipublikasikan agar siswa dapat belajar.
- 120 soal asesmen (10 per topik), berstatus `draft` agar ditinjau guru.
- 12 paket materi remediasi, masing-masing dengan 5 latihan pilihan ganda.
- 5 pertanyaan verifikasi Newman per topik (60 pertanyaan).
- Pemetaan materi remediasi ke lima tahap Newman.
- Pengujian kelengkapan konten Kelas IV.

Konten adalah draf pengembangan berbantuan AI/templat yang tetap wajib divalidasi guru terhadap CP/ATP sekolah. Jangan menganggap semua materi otomatis tervalidasi hanya karena sudah masuk database.

## Cara memasang pada proyek yang sudah berjalan

1. Buat salinan cadangan proyek dan database SQLite yang sekarang dipakai.
2. Ekstrak ZIP paket ini.
3. Salin file `.env` dari proyek lama ke proyek hasil ekstrak.
4. Salin `database/database.sqlite` dari proyek lama ke proyek hasil ekstrak.
5. Buka folder proyek hasil ekstrak di terminal.
6. Jalankan:

```bash
php artisan optimize:clear
php artisan db:seed
```

Tidak ada migration baru pada paket konten ini. Jangan menjalankan `migrate:fresh` karena akan menghapus data akun, sekolah, guru, siswa, dan riwayat yang ada.

Jika dependensi frontend belum terpasang:

```bash
npm install
npm run build
```

Kemudian jalankan aplikasi:

```bash
php artisan serve
```

## Hasil data yang diharapkan setelah seeding

| Item Kelas IV | Target |
|---|---:|
| Topik | 12 |
| Materi utama | 12 |
| Soal asesmen | 120 |
| Soal per topik | 10 |
| Materi remediasi | 12 |
| Latihan remediasi | 60 |
| Pertanyaan verifikasi Newman | 60 |
| Tahap Newman per paket remediasi | 5 |

Seeder bersifat idempotent untuk data yang dikelolanya. Menjalankan `db:seed` kembali tidak dimaksudkan untuk membuat duplikat.

## Alur review guru

1. Guru masuk dengan akun yang ditugaskan ke Kelas IV.
2. Buka menu Review Soal.
3. Periksa soal, stimulus, pilihan jawaban, kunci, dan pembahasan.
4. Setujui soal yang benar; soal yang disetujui akan tersedia untuk asesmen siswa.
5. Buka menu Materi Remediasi.
6. Periksa materi dan lima latihan pada setiap topik.
7. Publikasikan materi remediasi setelah validasi.

Materi utama Kelas IV disediakan dalam status published agar halaman belajar siswa terisi. Guru tetap harus meninjau isi dan dapat mengedit materi melalui menu Bank Materi/Materi Pembelajaran sebelum penggunaan resmi.

## Cakupan analisis Newman

Konfigurasi soal numerik menyimpan jawaban yang diharapkan dan langkah operasi untuk membantu pemeriksaan transformasi, proses hitung, dan jawaban akhir. Reading dan comprehension tetap memerlukan bukti dari respons siswa terhadap pertanyaan verifikasi. Status analisis `insufficient_evidence` bukan diagnosis kesalahan; guru harus memeriksa bukti sebelum mengonfirmasi temuan atau membuat rekomendasi remediasi.

## Pemeriksaan

Jalankan:

```bash
php artisan test --filter=GradeFourContentCompletenessTest
```

Lalu:

```bash
php artisan test
```

Pengujian harus dijalankan di lingkungan lokal yang memiliki ekstensi PHP yang dibutuhkan PHPUnit serta PDO SQLite. Paket ini telah diperiksa sintaks PHP dan daftar route di lingkungan pembuat, tetapi test database penuh perlu dijalankan di Laragon.
