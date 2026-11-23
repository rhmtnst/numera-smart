# NUMERA SMART — Mulai dari sini

Ini adalah salinan proyek dengan perbaikan alur verifikasi Newman, proses analisis, dan rekomendasi remediasi.

## Pemasangan aman di Laragon

1. Jangan hapus atau timpa folder proyek lama.
2. Ekstrak paket ini ke folder baru, misalnya `C:\laragon\www\numera-smart-revisi`.
3. Dari folder proyek lama, salin file `.env` ke folder baru. Jangan membagikan file tersebut karena berisi konfigurasi rahasia.
4. Hentikan server lama terlebih dahulu. Salin `database\database.sqlite` terbaru dari proyek lama ke folder baru agar akun, asesmen, jawaban, dan materi terakhir tetap terbawa.
5. Buka terminal pada folder baru dan jalankan:

```bash
php artisan optimize:clear
php artisan db:seed --class=NewmanVerificationSeeder
php artisan route:list
```

6. Jalankan aplikasi dari folder baru dengan perintah Laragon/terminal yang biasa digunakan.

**Jangan jalankan `php artisan migrate:fresh`, `php artisan db:wipe`, atau menghapus file SQLite.**

## Apa yang sudah dirapikan?

- Verifikasi dapat mencakup seluruh lima tahap Newman, tetapi hanya meminta jawaban tambahan jika bukti tahap belum cukup.
- Bank pertanyaan disiapkan per topik untuk lima tahap Newman.
- Analisis Gemini dijalankan setelah transaksi penyelesaian asesmen, bukan di dalam transaksi.
- Rekomendasi hanya dapat diberikan setelah analisis keseluruhan dan temuan tahap dikonfirmasi guru.
- Materi remediasi yang telah dibuat tetap dipakai dan dapat digunakan ulang untuk temuan yang cocok.
- Akses siswa ke materi rekomendasi memeriksa konfirmasi guru per tahap.

Baca `PANDUAN_ALUR_SISTEM_NUMERA_SMART.md` untuk alur lengkap dan `CATATAN_PERBAIKAN_DAN_HASIL_AUDIT.md` untuk daftar perubahan serta batasan pengujian.
