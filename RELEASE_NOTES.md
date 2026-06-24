# RELEASE NOTES - SI TERNAK

## [v1.0.2] - 2026-06-24
### 🐛 Fixed
- Memperbaiki kendala error "No direct script access allowed" dengan mengembalikan berkas error views bawaan CodeIgniter 4 yang sebelumnya tercampur dengan berkas lama CodeIgniter 3.
- Mengganti penggunaan variabel legacy `$this->uri->segment()` pada menu navigasi `app/Views/template/header.php` menggunakan helper baru `uri_segment()` yang didefinisikan secara global pada `app/Common.php`.
- Mengembalikan berkas `app/Views/welcome_message.php` standar CodeIgniter 4 agar terbebas dari pengecekan `BASEPATH` lama.

## [v1.0.1] - 2026-06-24
### 🔄 Changed
- Menyempurnakan berkas `README.md` dengan penjelasan deskripsi sistem terintegrasi, detail *tech stack*, petunjuk instalasi dan konfigurasi (`database.php` & `config.php`), serta bagan *roadmap* pengembangan fase 1-4.
- Inisialisasi berkas `RELEASE_NOTES.md` untuk mencatat riwayat perubahan aplikasi secara terstruktur.

---
