# NUMERA SMART — Revisi Diagnosis Newman per Topik

## Perubahan utama
- Analisis Newman tetap disimpan per jawaban/nomor soal.
- Halaman detail analisis guru menampilkan rekap lima tahap Newman untuk satu asesmen topik.
- Persentase dihitung dari temuan yang statusnya `error_indicated` atau `no_error_indicated`. Temuan `insufficient_evidence` ditampilkan terpisah dan tidak masuk penyebut persentase.
- Guru memberikan satu keputusan untuk keseluruhan diagnosis topik: `confirmed` atau `needs_revision`.
- Rekomendasi remedial dibuka setelah diagnosis topik dikonfirmasi. Materi tetap harus sesuai topik, tahap Newman, berstatus published, dan memiliki latihan aktif.
- Bukti per nomor dan respons verifikasi siswa tetap disimpan dan dapat ditinjau.

## Langkah setelah menyalin proyek
1. Cadangkan database terlebih dahulu.
2. Jalankan `php artisan optimize:clear`.
3. Jalankan `php artisan migrate` untuk membuat tabel `assessment_topic_reviews`.
4. Jalankan `php artisan route:list` untuk memeriksa route (pastikan ekstensi PHP yang dibutuhkan Laravel/Termwind tersedia).
5. Login sebagai guru dan buka detail asesmen topik. Periksa kartu Ringkasan Analisis Newman di bawah Informasi Asesmen.
6. Pastikan semua jawaban telah selesai dianalisis. Pilih `Konfirmasi diagnosis` atau `Perlu perbaikan`, isi catatan, lalu simpan.
7. Setelah dikonfirmasi, buka bagian Rekomendasi Remediasi pada temuan yang berstatus `error_indicated`.

## Catatan
Jangan menjalankan `migrate:fresh` atau menghapus database. Migrasi baru hanya menambahkan tabel review topik dan tidak menghapus tabel/data lama.
