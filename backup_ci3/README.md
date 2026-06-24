# 🐄 SI TERNAK (Sistem Informasi Peternakan)

**Sistem Digitalisasi Recording dan Pelaporan Peternakan Terintegrasi**  
*Dinas Peternakan dan Kesehatan Hewan Kabupaten Sinjai*

---

## 🚀 Gambaran Umum

**SI TERNAK** adalah aplikasi berbasis web yang dirancang untuk mentransformasi proses pencatatan (recording) dan pelaporan data peternakan di Kabupaten Sinjai dari manual ke digital. Aplikasi ini mengintegrasikan berbagai aspek peternakan, mulai dari produksi pakan, siklus reproduksi hewan, hingga monitoring populasi secara real-time.

## ✨ Fitur Utama

- **📦 Monitoring Produksi Pakan:** Pencatatan produksi bulanan Silase dan Konsentrat dari berbagai Unit Pengolahan Pakan (UPP) di tingkat kecamatan.
- **🧬 Sistem Reproduksi Digital:** Tracking Inseminasi Buatan (IB), Pemeriksaan Kebuntingan (PKB), hingga kelahiran ternak secara mendetail.
- **📊 Recording Populasi:** Monitoring mutasi ternak (lahir, mati, jual, potong, hilang) untuk rekapitulasi populasi bulanan yang akurat.
- **💉 Vaksinasi & Kesehatan:** Pencatatan program vaksinasi massal (PMK, Anthrax, dll) dan riwayat kesehatan ternak berdasarkan eartag.
- **🗺️ Geospasial Wilayah:** Integrasi data wilayah kecamatan dan desa di Kabupaten Sinjai.

## 🛠️ Tech Stack

- **Backend:** PHP 7.4+ dengan Framework **CodeIgniter 3**
- **Frontend:** Bootstrap 4 & **AdminLTE 3** Template
- **Database:** MySQL / MariaDB
- **Tools:** DataTables Server-Side, Summernote Editor

## ⚙️ Instalasi & Konfigurasi

1.  **Clone Repository:**
    ```bash
    git clone https://github.com/username/si_ternak.git
    ```
2.  **Database:**
    - Buat database baru bernama `siternak_db`.
    - Import file `siternak_db.sql` (atau `ternak_db.sql`) ke database tersebut.
3.  **Konfigurasi Koneksi:**
    Edit file `application/config/database.php`:
    ```php
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '', // Isi dengan password database Anda
    'database' => 'siternak_db',
    ```
4.  **Konfigurasi Base URL:**
    Edit file `application/config/config.php`:
    ```php
    $config['base_url'] = 'http://localhost/si_ternak/';
    ```

## 📂 Struktur Folder Utama

- `application/controllers/`: Logika alur aplikasi (Pakan, Inseminasi, Vaksinasi, dll).
- `application/models/`: Interaksi data dengan database (M_hewan, M_pakan, dll).
- `application/views/`: Antarmuka pengguna (UI) per modul.
- `assets/`: File statis (CSS, JS, Images, AdminLTE).

## 🗺️ Roadmap Pengembangan

- [x] **Fase 1:** Konsolidasi database & master data wilayah.
- [ ] **Fase 2:** Fitur cetak laporan otomatis format PDF (Laporan Produksi Pakan).
- [ ] **Fase 3:** Dashboard grafik tren produksi dan peta sebaran penyakit.
- [ ] **Fase 4:** Export Excel/PDF untuk semua modul & Mobile Friendly View.

---
*Dibuat dengan ❤️ oleh Aruna (Assistant) untuk Dinas Peternakan dan Kesehatan Hewan Kabupaten Sinjai.*
