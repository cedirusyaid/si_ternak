# 📘 SI TERNAK (Sistem Informasi Peternakan)
**Dinas Peternakan dan Kesehatan Hewan Kabupaten Sinjai**

SI TERNAK adalah aplikasi berbasis web yang dirancang untuk digitalisasi recording dan pelaporan data peternakan di Kabupaten Sinjai secara terintegrasi.

---

## 🚀 Fitur Utama

1.  **Monitoring Produksi Pakan**: Pencatatan produksi bulanan (Silase & Konsentrat) dari Unit Pengolahan Pakan (UPP) di berbagai kecamatan.
2.  **Sistem Reproduksi**: Manajemen data Inseminasi Buatan (IB), Pemeriksaan Kebuntingan (PKB), dan kelahiran ternak.
3.  **Recording Populasi**: Pemantauan mutasi populasi ternak (lahir, mati, jual, potong, hilang) secara real-time.
4.  **Vaksinasi & Kesehatan**: Pencatatan kegiatan vaksinasi massal (PMK, Anthrax, dll) dan tracking riwayat kesehatan hewan.

---

## 🛠️ Teknologi

- **Backend**: PHP (CodeIgniter 3 Framework)
- **Database**: MySQL / MariaDB
- **Frontend**: Bootstrap + AdminLTE Template
- **Server**: Apache / Nginx

---

## 📂 Struktur Direktori Utama

- `application/controllers/`: Logika bisnis aplikasi.
- `application/models/`: Interaksi data dan database.
- `application/views/`: Antarmuka pengguna (UI).
- `assets/`: File statis seperti CSS, JS, dan gambar.
- `uploads/`: Lokasi penyimpanan file ungguhan (csv, dokumen, dll).

---

## ⚙️ Instalasi

1. Clone repositori ini:
   ```bash
   git clone git@github.com:cedirusyaid/si_ternak.git
   ```
2. Konfigurasi database pada file `application/config/database.php`.
3. Sesuaikan `base_url` pada file `application/config/config.php`.
4. Import file database (jika tersedia) ke MySQL/MariaDB.
5. Jalankan melalui server lokal (XAMPP/Laragon/Nginx).

---

## 📝 Standar Commit

Gunakan format berikut untuk pesan commit:
`YYMMDD - [Tipe]: Deskripsi`
Contoh: `260420 - [feat]: Menambahkan modul laporan pakan`

---
*© 2026 Dinas Peternakan dan Kesehatan Hewan Kabupaten Sinjai.*
