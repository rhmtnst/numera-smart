# NUMERA SMART — Paket Pengembangan Terintegrasi

## Cakupan paket
- Fondasi administrator: sekolah, akun guru, penugasan guru per sekolah/kelas IV–VI, pengelolaan siswa, kode pendaftaran sekolah.
- Pendaftaran mandiri dibatasi untuk siswa dan wajib memakai kode sekolah aktif; role selalu ditetapkan server sebagai `student`.
- Fondasi pembelajaran siswa tetap menggunakan domain/topik dan asesmen yang telah ada pada proyek.
- Fitur guru yang sudah ada (hasil asesmen, analisis Newman, verifikasi, rekomendasi dan remediasi) dipertahankan.
- Materi/topik kelas IV, V, VI tersedia melalui `LearningDomainSeeder`; konten soal yang belum tersedia harus ditambahkan/ditinjau guru sebelum dipublikasikan.

## Instalasi aman
1. Backup folder proyek dan database SQLite lama.
2. Ekstrak paket ke folder baru.
3. Salin `.env` milik proyek lokal yang aktif ke root proyek baru. Jangan membagikan `.env`.
4. Salin database SQLite yang sudah dipakai ke `database/database.sqlite` jika ingin mempertahankan akun/data.
5. Jalankan `composer install` bila folder `vendor` tidak disertakan.
6. Jalankan `npm install` lalu `npm run build`.
7. Jalankan `php artisan optimize:clear`.
8. Jalankan `php artisan migrate --pretend`, tinjau SQL, backup database, lalu `php artisan migrate`.
9. Jalankan `php artisan route:list --path=admin -v`.
10. Jalankan `php artisan serve` atau gunakan virtual host Laragon.

## Penggunaan admin
Login dengan akun role `admin`. Dashboard menyediakan tautan Data Sekolah, Data Guru, Penugasan Guru, Kode Sekolah, dan Data Siswa. Buat sekolah aktif terlebih dahulu, buat akun guru, tetapkan penugasan kelas, lalu buat kode pendaftaran.

## Alur siswa
Siswa mendaftar dengan nama, email, kelas IV/V/VI, password, dan kode sekolah aktif. Kode dapat dibatasi jumlah penggunaan dan tanggal kedaluwarsanya. Role siswa dan sekolah ditentukan server dari kode, bukan dari input role pengguna.

## Catatan validasi
- Jalankan pengujian fungsional di Laragon dengan salinan database terlebih dahulu.
- Analisis Newman adalah interpretasi berbasis respons/aturan yang sudah ada; guru tetap melakukan verifikasi sebelum rekomendasi remediasi dipublikasikan.
- Paket tidak mengaktifkan API berbayar. Fitur teknologi pendukung eksternal harus tetap opsional.
- Materi topik sudah tersedia dalam seeder; cakupan soal per topik dan kualitas pedagogis tetap harus ditinjau/dilengkapi sebelum penerapan ke sekolah.
