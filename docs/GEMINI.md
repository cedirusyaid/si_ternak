# 📘 **SI TERNAK (Sistem Informasi Peternakan)**
**Dinas Peternakan dan Kesehatan Hewan Kabupaten Sinjai**

Dokumen ini berisi dokumentasi teknis, arsitektur aplikasi, struktur database, dan rencana pengembangan untuk aplikasi SI TERNAK.

---

## 🏢 **1. GAMBARAN UMUM APLIKASI**

**SI TERNAK** adalah aplikasi berbasis web yang digunakan untuk digitalisasi recording dan pelaporan data peternakan di Kabupaten Sinjai. Aplikasi ini dirancang untuk memantau aktivitas peternakan secara terintegrasi, mulai dari produksi pakan, reproduksi (IB), hingga populasi ternak.

### **Fungsi Utama (Berdasarkan Data & Laporan)**
1.  **Monitoring Produksi Pakan (Silase & Konsentrat)**
    *   Berdasarkan *Laporan Produksi Pakan Thn 2025*, sistem ini mencatat produksi bulanan dari Unit Pengolahan Pakan (UPP) di berbagai kecamatan (Sinjai Utara, Bulupoddo, Sinjai Timur, dll).
    *   **Jenis Pakan yang dicatat:**
        *   **Silase:** Jerami, Rumput Gajah, Batang Jagung, Kulit Jagung, Limbah Batang Pisang.
        *   **Konsentrat.**
    *   Pelaporan dilakukan per **Kelompok Ternak** dengan akumulasi bulanan.

2.  **Sistem Reproduksi (Inseminasi Buatan & Kelahiran)**
    *   Mencatat aktivitas Inseminasi Buatan (IB) yang dilakukan oleh petugas lapangan.
    *   Monitoring status kebuntingan (PKB) dan kelahiran ternak.
    *   Data mencakup: Identitas Peternak, Data Hewan (Sapi Bali, Sapi Limosin, dll), dan Data Petugas.

3.  **Recording Populasi & Perkembangan Ternak**
    *   Mencatat mutasi ternak: Lahir, Mati (Dewasa/Anak), Jual, Potong, dan Hilang.
    *   Laporan bulanan populasi awal dan akhir bulan.

4.  **Vaksinasi & Kesehatan Hewan (Modul Baru)**
    *   Pencatatan kegiatan vaksinasi (misal: PMK, Anthrax).
    *   Tracking riwayat kesehatan ternak berdasarkan ID Hewan/Eartag.

---

## 🏗️ **2. ARSITEKTUR TEKNIS**

### **Teknologi**
*   **Framework Backend:** CodeIgniter 3 (PHP)
*   **Database:** MySQL / MariaDB
*   **Frontend:** Bootstrap + AdminLTE Template
*   **Server:** Apache/Nginx

### **Struktur Folder & Modul**
Berdasarkan struktur direktori saat ini:

```
application/
├── controllers/
│   ├── Dashboard.php    # Halaman Utama & Statistik
│   ├── Pakan.php        # Modul Produksi Pakan (Sesuai PDF Laporan)
│   ├── Inseminasi.php   # Modul IB, PKB, dan Kelahiran
│   ├── Perkembangan.php # Modul Populasi Ternak
│   ├── Vaksinasi.php    # Modul Vaksinasi (Baru)
│   ├── Master.php       # Manajemen Data Master (Petugas, Hewan, dll)
│   └── ...
├── models/
│   ├── M_laporan_produksi_pakan.php  # Logika Database Pakan
│   ├── M_inseminasi.php              # Logika Database IB
│   ├── M_hewan.php                   # Data Ternak
│   └── ...
└── views/
    ├── pakan/           # View Input & Laporan Pakan
    ├── inseminasi/      # View Kartu Ternak & IB
    └── ...
```

---

## 🗃️ **3. STRUKTUR DATABASE (Analisis `siternak_db.sql`)**

Database `siternak_db` terdiri dari beberapa klaster tabel utama yang saling berelasi:

### **A. Klaster Produksi Pakan (Sesuai Laporan PDF)**
Menyimpan data realisasi fisik produksi pakan dari kelompok tani.
*   `kelompok_produksi_pakan`: Data kelompok pengolah pakan (Nama, Alamat, Kecamatan).
*   `jenis_pakan`: Master data jenis pakan (Jerami, Rumput Gajah, Konsentrat, dll).
*   `laporan_produksi_pakan`: Header laporan per bulan/tahun per kelompok.
*   `detail_produksi_pakan`: Rincian jumlah produksi (kg) per jenis pakan untuk setiap laporan.
*   `rekap_total_produksi`: Tabel agregasi/cache untuk total produksi.

### **B. Klaster Reproduksi (IB & Breeding)**
Menangani siklus hidup reproduksi ternak.
*   `peternak`: Data pemilik ternak (NIK, Nama, Lokasi).
*   `hewan`: Data individu ternak (Kode Eartag, Bangsa, Jenis Kelamin).
*   `petugas_lapangan`: Data Inseminator dan petugas medis (NIP, Jabatan).
*   `inseminasi`: Transaksi IB (Tanggal, Kode Straw, ID Pejantan).
*   `pemeriksaan_kebuntingan`: Hasil PKB pasca IB.
*   `kelahiran`: Pencatatan kelahiran hasil IB atau kawin alam.

### **C. Klaster Populasi (Perkembangan)**
*   `kelompok_ternak`: Data kelompok penerima bantuan/binaan.
*   `laporan_bulanan`: Matriks mutasi ternak (Awal, Lahir, Mati, Jual, Akhir).

### **D. Klaster Vaksinasi (Kesehatan)**
*   `laporan_vaksinasi_ternak`: Transaksi vaksinasi detail (Program, Penyakit, Vaksinator).
*   `master_program_vaksinasi`: Program pemerintah (misal: Vaksinasi PMK 2025).
*   `master_penyakit`: Jenis penyakit (PMK, Anthrax, SE).

### **E. Sistem & Utilitas**
*   `users`: Manajemen pengguna (Admin, Operator, Kadis).
*   `app_settings`: Konfigurasi global aplikasi (Tahun Anggaran, Nama Instansi).
*   `kode_desa` & `kode_kecamatan`: Master wilayah administrasi (dengan data Geospasial/WKT).

---

## 🚀 **4. RENCANA PENGEMBANGAN (ROADMAP)**

Berdasarkan *Dokumen Rencana Pengembangan* sebelumnya, berikut status dan langkah selanjutnya:

### **Fase 1: Konsolidasi Data (Selesai/Ongoing)**
*   [x] Struktur database terintegrasi (Pakan, IB, Vaksinasi).
*   [x] Input data historis Produksi Pakan 2025 (Sesuai PDF).
*   [x] Master data wilayah (Kecamatan/Desa) lengkap.

### **Fase 2: Optimalisasi Modul Pakan (Prioritas)**
*   [ ] Fitur cetak laporan otomatis mirip format PDF "Laporan Produksi Pakan".
*   [ ] Dashboard grafik tren produksi pakan (Silase vs Konsentrat).
*   [ ] Validasi input agar tidak melebihi kapasitas atau anomali data.

### **Fase 3: Integrasi Vaksinasi & Kesehatan**
*   [ ] Form input vaksinasi massal (Bulk Insert).
*   [ ] Peta sebaran penyakit berdasarkan data `laporan_vaksinasi_ternak` dan `kode_desa`.
*   [ ] Notifikasi jadwal vaksinasi ulang (Booster).

### **Fase 4: Reporting & Eksekutif Dashboard**
*   [ ] Rekapitulasi populasi real-time ("Satu Data Ternak").
*   [ ] Export Excel/PDF untuk semua modul laporan dinas.
*   [ ] Mobile friendly view untuk petugas lapangan.

---

## 📝 **Catatan Teknis**
*   **Data PDF**: Data pada `LAPORAN PRODUKSI PAKAN THN 2025.pdf` telah terpetakan ke tabel `detail_produksi_pakan` dan `laporan_produksi_pakan`. Pastikan ID Kelompok pada aplikasi sesuai dengan nama kelompok di PDF.
*   **Koneksi Database**: Konfigurasi ada di `application/config/database.php`.
*   **Base URL**: Sesuaikan di `application/config/config.php` saat deployment.

---
*Dokumen ini diperbarui secara otomatis oleh Assistant Gemini berdasarkan analisis file proyek.*
