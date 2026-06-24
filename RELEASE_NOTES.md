# RELEASE NOTES - SI TERNAK

## [v1.0.3] - 2026-06-24
### ✨ Added
- Menambahkan kolom `id_kelompok`, `tahun_anggaran`, `sumber_dana`, dan `ras_ternak` pada tabel `peternak` untuk mendukung alokasi bantuan per individu (bantuan per orang).
- Menambahkan input bantuan (Kelompok, Tahun, Sumber Dana, Ras Ternak) pada form Tambah/Edit Peternak.
- Menambahkan rekapitulasi breed bantuan anggota kelompok secara dinamis pada daftar Kelompok Ternak.
- Menambahkan input dan kolom "Kumulatif" (Jantan/Betina) pada Laporan Bulanan Perkembangan.
- Membuat endpoint AJAX `ajax_search_peternak` dan `ajax_search_hewan` pada controller `Inseminasi` untuk mendukung pencarian otomatis.

### 🔄 Changed
- Mengubah form Inseminasi Buatan (`tambah_ib` & `edit_ib`) untuk menggunakan input teks autocomplete untuk pencarian Peternak & ID Hewan secara interaktif.
- Mengotomatiskan pengisian alamat (alamat lengkap, desa, kecamatan) di form Inseminasi Buatan berdasarkan Peternak yang dipilih, serta menyimpannya ke database.
- Menghilangkan dropdown `Status Awal` pada form Tambah Inseminasi Buatan (default "menunggu" saat penambahan).
- Menyembunyikan form input bantuan statis di Tambah/Edit Kelompok karena data bantuan telah dipindahkan ke tingkat individu.

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
