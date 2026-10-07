# 🗺️ RANCANGAN SISTEM SURVEILANS & PEMETAAN SPASIO-TEMPORAL PENYAKIT TERNAK
**Dinas Peternakan dan Kesehatan Hewan Kabupaten Sinjai**
*Dokumen Spesifikasi Teknis & Desain Arsitektur Sistem Informasi Kesehatan Hewan (GIS Timeline)*

---

## 📑 DAFTAR ISI
1. [Latar Belakang & Istilah Teknis Veteriner](#1-latar-belakang--istilah-teknis-veteriner)
2. [Klasifikasi Penyakit Hewan Menular Strategis (PHMS)](#2-klasifikasi-penyakit-hewan-menular-strategis-phms)
3. [Rancangan Skema Database (MySQL/MariaDB)](#3-rancangan-skema-database-mysqlmariadb)
4. [Arsitektur Backend & API GeoJSON (CodeIgniter 4)](#4-arsitektur-backend--api-geojson-codeigniter-4)
5. [Desain Frontend & Visualisasi Peta Timeline (Leaflet.js)](#5-desain-frontend--visualisasi-peta-timeline-leafletjs)
6. [Indikator Epidemiologi & Formula Zonasi](#6-indikator-epidemiologi--formula-zonasi)
7. [Tahapan & Rencana Implementasi](#7-tahapan--rencana-implementasi)

---

## 1. LATAR BELAKANG & ISTILAH TEKNIS VETERINER

Dalam bidang **Kesehatan Hewan (Keswan)** dan **Epidemiologi Veteriner** (mengacu pada standar Direktorat Jenderal Peternakan dan Kesehatan Hewan Kementan RI & sistem **iSIKHNAS**), pemetaan penyakit berbasis waktu dan wilayah dikenal sebagai **Surveilans Spasio-Temporal**.

### Glosarium Istilah Penting:
- **Spasio-Temporal**: Analisis data yang menggabungkan dua dimensi sekaligus, yaitu ruang/lokasi spasial (desa/kelurahan) dan dimensi temporal (riwayat rentang waktu kejadian).
- **PHMS (Penyakit Hewan Menular Strategis)**: Penyakit hewan yang dapat menimbulkan angka kematian tinggi, kerugian ekonomi signifikan, atau bersifat zoonosis.
- **Zoonosis**: Penyakit hewan yang dapat menular ke manusia (contoh: Anthrax, Rabies, Brucellosis).
- **Morbiditas (Attack Rate)**: Persentase hewan yang sakit dari total populasi rentan di suatu wilayah.
- **Mortalitas (Case Fatality Rate / CFR)**: Persentase hewan yang mati akibat penyakit dari jumlah total hewan yang terinfeksi.
- **Zonasi Kasus (Epidemiological Zonation)**: Klasifikasi tingkat kerawanan wilayah (Zona Merah/Wabah, Zona Kuning/Terancam, Zona Hijau/Bebas).
- **WKT (Well-Known Text)**: Format representasi teks standar untuk menyimpan geometri koordinat poligon batas wilayah administratif pada sistem GIS.

---

## 2. KLASIFIKASI PENYAKIT HEWAN MENULAR STRATEGIS (PHMS)

| No | Kode | Nama Penyakit | Agen Penyebab | Spesies Sasaran | Karakteristik Klinis & Dampak |
|---|---|---|---|---|---|
| 1 | **PMK** | Penyakit Mulut dan Kuku (*FMD*) | Virus (*Aphthovirus*) | Sapi, Kerbau, Kambing, Babi | Penularan aerosol sangat cepat, lepuh pada lidah, moncong kuku terlepas, hipersalivasi. |
| 2 | **ANT** | Anthrax (Radang Limpa) | Bakteri (*Bacillus anthracis*) | Ruminansia (*Zoonosis*) | Kematian mendadak, darah keluar dari lubang kumlah tanpa membeku. Sangat berbahaya bagi manusia. |
| 3 | **LSD** | *Lumpy Skin Disease* | Virus (*Capripoxvirus*) | Sapi, Kerbau | Benjolan nodul pada seluruh kulit, edema kaki, penurunan drastis produksi susu & berat badan. |
| 4 | **JEM** | Penyakit Jembrana | Virus (*Retroviridae*) | Khusus Sapi Bali | Demam akut, pembengkakan kelenjar limfa prefemoralis, keringat darah (*blood sweating*). |
| 5 | **SE** | *Septicaemia Epizootica* (Ngorok) | Bakteri (*Pasteurella multocida*) | Sapi, Kerbau | Busung submandibular (leher bengkak), sesak napas, suara mendengkur keras, demam tinggi. |
| 6 | **BRU** | Brucellosis (Keluron Menular) | Bakteri (*Brucella abortus*) | Sapi, Kambing (*Zoonosis*) | Keguguran pada kebuntingan semester akhir (bulan ke-6 s.d. 9), retensi plasenta, mandul. |
| 7 | **RAB** | Rabies (Anjing Gila) | Virus (*Lyssavirus*) | HPR, Hewan Ternak (*Zoonosis*) | Gangguan sistem saraf pusat, paralisis, hidrofobia, agresi tinggi. |
| 8 | **SUR** | Surra (*Trypanosomiasis*) | Protozoa (*Trypanosoma evansi*) | Kuda, Kerbau, Sapi | Ditularkan lalat *Tabanus*, demam intermiten, anemia progresif, edema pada bagian bawah perut. |

---

## 3. RANCANGAN SKEMA DATABASE (MYSQL/MARIADB)

Tabel berikut dirancang terintegrasi dengan tabel master spasial yang sudah ada di database (`kode_desa` dan `kode_kecamatan`).

```sql
-- --------------------------------------------------------
-- 1. Pembaruan Master Data Penyakit
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `mst_penyakit` (
  `id_penyakit` int(11) NOT NULL AUTO_INCREMENT,
  `kode_penyakit` varchar(20) NOT NULL UNIQUE,
  `nama_penyakit` varchar(150) NOT NULL,
  `nama_ilmiah` varchar(150) DEFAULT NULL,
  `kategori` enum('Virus', 'Bakteri', 'Parasit', 'Jamur', 'Lainnya') NOT NULL,
  `sifat_zoonosis` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1: Menular ke Manusia, 0: Tidak',
  `spesies_rentan` varchar(255) DEFAULT 'Sapi, Kerbau, Kambing',
  `masa_inkubasi_hari` int(11) DEFAULT 14,
  `warna_marker` varchar(10) DEFAULT '#FF0000',
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_penyakit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- 2. Transaksi Kasus Penyakit (Time-Series & Geo-Tagged)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `trn_kasus_penyakit` (
  `id_kasus` int(11) NOT NULL AUTO_INCREMENT,
  `no_laporan` varchar(50) NOT NULL UNIQUE,
  `id_penyakit` int(11) NOT NULL,
  `desa_id` bigint(20) NOT NULL,
  `kecamatan_id` int(11) NOT NULL,
  `id_peternak` varchar(50) DEFAULT NULL,
  `id_hewan` varchar(50) DEFAULT NULL,
  `id_petugas` varchar(50) DEFAULT NULL,
  
  -- Periode Waktu Kasus (Timeline Anchor)
  `tanggal_lapor` date NOT NULL,
  `tanggal_kejadian` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  
  -- Indikator Kuantitatif Kasus
  `populasi_rentan` int(11) NOT NULL DEFAULT 0 COMMENT 'Estimasi populasi ternak rentan di wilayah kandang',
  `jumlah_sakit` int(11) NOT NULL DEFAULT 1 COMMENT 'Jumlah ternak bergejala / positif',
  `jumlah_sembuh` int(11) NOT NULL DEFAULT 0,
  `jumlah_mati` int(11) NOT NULL DEFAULT 0,
  `jumlah_potong_bersyarat` int(11) NOT NULL DEFAULT 0,
  
  -- Status Penanganan Kasus
  `status_kasus` enum('Suspek', 'Terkonfirmasi', 'Terkendali', 'Selesai') NOT NULL DEFAULT 'Suspek',
  `tindakan_penanganan` text DEFAULT NULL COMMENT 'Contoh: Vaksinasi Darurat, Karantina, Pengobatan',
  `koordinat_gps` varchar(100) DEFAULT NULL COMMENT 'Format: latitude,longitude titik kandang',
  `keterangan` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id_kasus`),
  KEY `idx_tanggal` (`tanggal_kejadian`),
  KEY `idx_desa` (`desa_id`),
  KEY `idx_penyakit` (`id_penyakit`),
  CONSTRAINT `fk_kasus_penyakit` FOREIGN KEY (`id_penyakit`) REFERENCES `mst_penyakit` (`id_penyakit`) ON UPDATE CASCADE,
  CONSTRAINT `fk_kasus_desa` FOREIGN KEY (`desa_id`) REFERENCES `kode_desa` (`desa_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

---

## 4. ARSITEKTUR BACKEND & API GEOJSON (CODEIGNITER 4)

### Endpoint REST API untuk Peta Timeline
1. **`GET /penyakit/api/timeline-geojson`**
   - **Parameter Query**: `tahun`, `bulan`, `id_penyakit`, `status`
   - **Output**: Fitur `GeoJSON FeatureCollection` dari tabel `kode_desa` dengan *properties* kalkulasi kasus bulanan.

```json
{
  "type": "FeatureCollection",
  "metadata": {
    "periode": "2026-10",
    "total_kasus_aktif": 14,
    "total_sembuh": 30,
    "total_mati": 2
  },
  "features": [
    {
      "type": "Feature",
      "properties": {
        "desa_id": 7307010001,
        "desa_nama": "Tassililu",
        "kecamatan_id": 730701,
        "kasus_aktif": 5,
        "kasus_sembuh": 12,
        "kasus_mati": 1,
        "status_zonasi": "Merah",
        "warna_zona": "#dc3545",
        "rincian_penyakit": [
          {"nama": "PMK", "jumlah": 4},
          {"nama": "SE", "jumlah": 1}
        ]
      },
      "geometry": {
        "type": "Polygon",
        "coordinates": [[[120.123, -5.123], [120.134, -5.130], "..."]]
      }
    }
  ]
}
```

---

## 5. DESAIN FRONTEND & VISUALISASI PETA TIMELINE (LEAFLET.JS)

### Mockup Tata Letak Antarmuka (UI Layout)
```
+-----------------------------------------------------------------------------------------------+
| SI TERNAK - PETA EPIDEMIOLOGI & SURVEILANS KESEHATAN HEWAN                                   |
+-----------------------------------------------------------------------------------------------+
| [ Filter Penyakit: Semua PHMS ▼ ]  [ Filter Tahun: 2026 ▼ ]     [ ▶ Play Timeline ] [ ⏸ Pause ]|
+-----------------------------------------------------------------------------------------------+
|                                                                                               |
|   📍 PETA INTERAKTIF KABUPATEN SINJAI (Leaflet Map + WKT Desa)                                |
|                                                                                               |
|          [ Sinjai Barat ] 🔴 (Kasus Aktif: 8)                                                 |
|          [ Sinjai Timur ] 🟡 (Kasus Aktif: 2)        [ LEGENDA ZONASI ]                       |
|          [ Sinjai Selatan ] 🟢 (0 Kasus)             🔴 Zona Merah  : Kasus Aktif ≥ 5        |
|          [ Tellu Limpoe ] 🟢 (Bebas)                 🟡 Zona Kuning : Kasus Aktif 1 - 4      |
|                                                      🟢 Zona Hijau  : 0 Kasus (Aman)          |
|                                                                                               |
|   * Klik Poligon Desa: Muncul Pop-Up info riwayat kasus, nama peternak, & nomor telepon       |
|                                                                                               |
+-----------------------------------------------------------------------------------------------+
| TIMELINE SLIDER:                                                                              |
| [◄ Prev]  |---|---|---|---|---|---|---|---|---|---|---|---| [Next ►] (Kecepatan: 1x / 2x / 5x) |
|          Jan Feb Mar Apr Mei Jun Jul Agu Sep [ Okt 2026 ● ] Nov Des                           |
+-----------------------------------------------------------------------------------------------+
| 📊 KARTU STATISTIK BULAN INI:                                                                 |
| [ 🔴 Kasus Aktif: 14 ]   [ 🟢 Sembuh: 38 ]   [ ⚫ Mati: 3 ]   [ 💉 Tervaksinasi: 1.250 Dosis ] |
+-----------------------------------------------------------------------------------------------+
```

### Komponen JavaScript:
1. **Leaflet.js + WKT Parser (`wicket.js` / `wellknown.js`)**: Mengubah data string koordinat `wkt` dari `kode_desa` menjadi layer GeoJSON poligon peta interaktif.
2. **Timeline Control Engine**: Komponen pengontrol urutan frame waktu (bulanan/mingguan) dengan fitur *Auto-Play*, *Pause*, dan *Scrubbing*.
3. **Choropleth Dynamic Styler**: Fungsi pewarnaan poligon wilayah secara reaktif saat slider waktu bergeser.

---

## 6. INDIKATOR EPIDEMIOLOGI & FORMULA ZONASI

### 1. Perhitungan Kasus Aktif per Wilayah:
$$\text{Kasus Aktif} = \sum \text{Jumlah Sakit} - (\sum \text{Jumlah Sembuh} + \sum \text{Jumlah Mati} + \sum \text{Potong Bersyarat})$$

### 2. Standar Klasifikasi Zonasi Wilayah (Kementan):
- 🔴 **Zona Merah (Tertular / Wabah)**:
  - Terdapat $\ge 5$ ekor kasus aktif atau terjadi penyebaran $\ge 2$ dusun dalam satu desa pada periode berjalan.
- 🟡 **Zona Kuning (Terancam / Waspada)**:
  - Terdapat $1 - 4$ ekor kasus aktif, ATAU wilayah desa bertetangga langsung (*buffer zone*) dengan desa Zona Merah.
- 🟢 **Zona Hijau (Bebas Kasus)**:
  - $0$ kasus aktif selama minimal $2 \times$ masa inkubasi terpanjang (28 hari berturut-turut).

---

## 7. TAHAPAN & RENCANA IMPLEMENTASI

| Fase | Kegiatan Utama | Output & Deliverable |
|---|---|---|
| **Fase 1** | Eksekusi DDL Database & Seeder Master Penyakit | Tabel `mst_penyakit` dan `trn_kasus_penyakit` aktif di MariaDB. |
| **Fase 2** | Pembuatan Model & CRUD Form Input Kasus Penyakit | Form pelaporan kasus baru, edit status kesembuhan ternak oleh petugas medis. |
| **Fase 3** | Pembangunan Service GeoJSON & Parser WKT | Endpoint API spasial yang menghasilkan GeoJSON reaktif per timeline bulan. |
| **Fase 4** | Integrasi Tampilan Peta Leaflet & Timeline Slider | Tampilan dashboard visual peta interaktif dengan animasi playback. |
| **Fase 5** | Modul Rekapitulasi Laporan Epidemiologi (PDF/Excel) | Laporan bulanan kejadian penyakit ternak siap cetak untuk pimpinan dinas. |

---
*Dokumen ini disusun sebagai blueprint resmi arsitektur sistem informasi kesehatan hewan SI TERNAK Sinjai.*
