# NUMERA SMART — Paket Pengembangan Terintegrasi

Paket ini berisi pembaruan untuk tujuh prioritas pengembangan NUMERA SMART. Gunakan database proyek terakhir yang sudah berisi akun administrator, sekolah, guru, siswa, penugasan, dan 36 topik.

## Isi pembaruan

1. **Fondasi dan akses**: middleware peran admin/guru/siswa; daftar siswa guru dibatasi berdasarkan kombinasi sekolah dan kelas yang ditugaskan; hasil asesmen, analisis, review soal, dan remediasi diberi pembatasan kelas/siswa.
2. **Kartu topik**: topik aktif ditampilkan untuk kelas siswa walaupun belum memiliki soal asesmen yang disetujui. Siswa melihat empat domain dan topik sesuai kelas IV/V/VI.
3. **Materi utama**: tabel `learning_materials`, pengelolaan materi guru, dan seeder materi awal untuk 36 topik. Materi berisi kompetensi, tujuan, penjelasan, contoh, dan latihan reflektif.
4. **Bank soal/asesmen**: alur bank soal dan review tetap dipakai; penyelesaian asesmen sekarang menghitung skor berbobot dan menyimpan benar/salah setiap jawaban.
5. **Newman**: alur analisis rule-based dipertahankan; pertanyaan verifikasi Reading dan Comprehension disediakan untuk tiap topik. Hasil otomatis tetap harus ditinjau guru.
6. **Remediasi**: pembatasan materi/hasil remediasi mengikuti penugasan guru dan siswa yang menjadi tanggung jawabnya.
7. **Pengujian**: ditambahkan feature tests untuk akses topik siswa dan pembatasan daftar siswa guru.

## Instalasi pada Laragon (database lama dipertahankan)

1. Hentikan `php artisan serve` dengan `Ctrl + C`.
2. Ekstrak ZIP ke folder baru, misalnya `C:\laragon\www\numera-smart-final`.
3. Salin file `.env` dari proyek NUMERA SMART terakhir ke folder baru.
4. Salin `database\database.sqlite` dari proyek NUMERA SMART terakhir ke folder baru.
5. Buka folder baru di VS Code.
6. Jalankan:

```bash
composer install
npm install
npm run build
php artisan optimize:clear
php artisan migrate
php artisan db:seed
```

7. Jalankan aplikasi:

```bash
php artisan serve
```

8. Buka `http://127.0.0.1:8000`.

**Jangan jalankan `php artisan migrate:fresh`.** Perintah `db:seed` pada paket ini memanggil `LearningDomainSeeder`, `LearningMaterialSeeder`, `QuestionSeeder`, dan `NewmanVerificationSeeder`. Seeder memakai `updateOrCreate`, tidak membuat/menghapus akun pengguna. Lima contoh soal untuk topik Penjumlahan dan Pengurangan kelas IV dibuat sebagai draft agar guru dapat meninjau sebelum dipakai siswa.

## Catatan kurikulum dan validasi

- Seeder materi menyediakan satu materi awal untuk setiap 36 topik. Materi tersebut merupakan draf konten pembelajaran awal untuk diuji dan **wajib ditinjau guru** agar sesuai dengan kurikulum, buku ajar, konteks lokal, dan kebijakan sekolah sebelum penerapan nyata.
- Soal contoh disimpan sebagai draft dan belum otomatis tersedia untuk asesmen. Guru perlu memeriksa lalu menyetujui soal melalui menu Review Soal.
- Reading dan Comprehension pada analisis Newman tidak disimpulkan otomatis hanya dari jawaban pilihan ganda. Sistem meminta respons verifikasi dan guru harus menilai bukti tersebut. Ini disengaja agar aplikasi tidak membuat diagnosis yang tidak didukung bukti.
- Analisis Newman rule-based adalah alat bantu penapisan, bukan pengganti penilaian profesional guru.

## Pemeriksaan teknis yang dilakukan pada paket

- Sintaks PHP pada folder aplikasi, route, migration, seeder, dan test diperiksa dengan `php -l`.
- 50 template Blade berhasil dikompilasi melalui Blade compiler.
- Route terdaftar dan middleware `auth` + `role:student/teacher/admin` terlihat pada route list.
- SQL struktur tabel materi diuji secara terpisah menggunakan SQLite Python.
- Pengujian Laravel end-to-end belum dapat dijalankan di lingkungan pembuatan paket karena PHP CLI di lingkungan ini tidak memiliki ekstensi PDO SQLite. Jalankan test pada Laragon setelah `composer install` dan migrasi.
