# Walkthrough: Upgrade SI TERNAK ke CodeIgniter 4.4.8

upgrade aplikasi **SI TERNAK** dari CodeIgniter 3 (CI3) ke CodeIgniter 4.4.8 telah selesai dilaksanakan sepenuhnya dengan sukses. Seluruh modul utama telah dimigrasikan, diuji sintaksnya (*linting*), dan diverifikasi konfigurasinya.

---

## 🛠️ Perubahan yang Dilakukan

### 1. Inisialisasi & Konfigurasi Dasar
* **Instalasi Framework:** Menginstal CodeIgniter 4.4.8 (versi tertinggi yang kompatibel dengan PHP 8.0.30 di server) menggunakan `composer.phar` lokal.
* **Environment (`.env`):** Menyiapkan berkas `.env` yang mengonfigurasi basis URL ke `http://localhost/si_ternak/public/`, mengaktifkan mode `development`, dan menghubungkan database `siternak_db` (user: `root`, pass: `sembarangji`).
* **Autentikasi (Filter):** Memigrasikan pengecekan login di CI3 (`MY_Controller.php`) menjadi Controller Filter modern di CI4 (`app/Filters/AuthFilter.php`). Filter ini otomatis menyaring akses ke seluruh halaman admin/dashboard kecuali `/auth/*`.
* **Keamanan:** Mengaktifkan proteksi **CSRF** dan **XSS** (`invalidchars`) secara global di `app/Config/Filters.php`.
* **Routing:** Mengaktifkan **Auto Routing** (`$autoRoute = true`) di `app/Config/Routing.php` untuk meniru perilaku routing otomatis CI3, serta memetakan beberapa rute kustom di `app/Config/Routes.php`.

### 2. Migrasi Model (CI3 ➡️ CI4)
Seluruh model dimigrasikan ke `app/Models/` dengan namespaces PHP dan mewarisi `CodeIgniter\Model`. Struktur database asli dipertahankan tanpa perubahan:
* `UserModel` (`app/Models/UserModel.php`): Penanganan akun pengguna dan logging aktivitas masuk.
* `HewanModel` (`app/Models/HewanModel.php`): CRUD ternak sapi bali, limosin, dll.
* `PeternakModel` (`app/Models/PeternakModel.php`): CRUD pemilik ternak.
* `PetugasModel` (`app/Models/PetugasModel.php`): CRUD inseminator dan petugas medis.
* `JenisPakanModel` (`app/Models/JenisPakanModel.php`): CRUD jenis pakan silase/konsentrat.
* `KelompokProduksiPakanModel` (`app/Models/KelompokProduksiPakanModel.php`): Kelompok pengolah pakan.
* `LaporanProduksiPakanModel` (`app/Models/LaporanProduksiPakanModel.php`): Header laporan pakan bulanan.
* `DetailProduksiPakanModel` (`app/Models/DetailProduksiPakanModel.php`): Rincian produksi pakan.
* `InseminasiModel` (`app/Models/InseminasiModel.php`): Penanganan Inseminasi Buatan (IB), kebuntingan (PKB), dan kelahiran.
* `VaksinasiModel` (`app/Models/VaksinasiModel.php`): Batch upload csv vaksinasi massal.
* `LaporanBulananModel` (`app/Models/LaporanBulananModel.php`): Mutasi populasi ternak bulanan.
* `WilayahModel` (`app/Models/WilayahModel.php`): Master wilayah kecamatan/desa di Kab. Sinjai.
* `DashboardModel` (`app/Models/DashboardModel.php`): Query agregasi data dashboard utama.

### 3. Migrasi Controller (CI3 ➡️ CI4)
Seluruh pengontrol dimigrasikan ke `app/Controllers/` dengan penyesuaian pengambilan parameter input (`$this->request->getPost()`), manipulasi sesi (`session()`), penanganan unggahan berkas (`getFile()`), dan pengembalian respons view:
* `Auth.php`, `Admin.php`, `Dashboard.php`, `User.php`, `Master.php`, `Pakan.php`, `Inseminasi.php`, `Perkembangan.php`, `Vaksinasi.php`.

### 4. Migrasi View & Aset Statis
* **Aset Statis:** Memindahkan seluruh pustaka Bootstrap, AdminLTE, FontAwesome, dan aset gambar ke direktori publik baru di `public/assets/`.
* **Penyempurnaan View:**
  * Memindahkan berkas view ke `app/Views/`.
  * Memperbarui pemanggilan flashdata sesi dari `$this->session->flashdata('key')` menjadi `session()->getFlashdata('key')` agar tidak memicu error di CI4.
  * Menambahkan `<?= csrf_field() ?>` pada form-form yang menggunakan metode POST secara manual untuk mematuhi aturan CSRF global.
  * Membuat fungsi penanganan galat validasi global `validation_errors()` di `app/Common.php` sebagai pengganti library form validation CI3 sehingga kode view form tidak perlu diubah.

### 5. Cadangan & Rollout
* Seluruh berkas lama CodeIgniter 3 (`application/`, `system/`, `assets/`, `index.php`, `composer.json`, `.gitignore`) telah dipindahkan dengan aman ke dalam folder backup khusus: `backup_ci3/`.
* Berkas-berkas CodeIgniter 4 baru telah diluncurkan langsung di root workspace `/html/si_ternak/`.

---

## 🧪 Validasi dan Pengujian

1. **Uji Sintaks PHP (PHP Linting):**
   Telah dijalankan pemeriksaan sintaks pada seluruh file PHP baru di dalam folder `app/`:
   ```bash
   find app/ -name "*.php" -exec php -l {} \;
   ```
   **Hasil:** `No syntax errors detected` di seluruh file (100% Valid).

2. **Uji Bootstrap Command-Line (CLI Spark):**
   Menjalankan perintah `php spark` untuk memastikan framework CodeIgniter 4 berhasil dimuat:
   ```bash
   php spark
   ```
   **Hasil:** CLI Spark termuat dengan sempurna, menampilkan seluruh perintah generator dan utilitas database.

3. **Uji Pemetaan Rute (Routing Test):**
   Memeriksa hasil routing akhir aplikasi:
   ```bash
   php spark routes
   ```
   **Hasil:** Seluruh modul rute terdaftar dengan benar dengan penapisan filter global `csrf`, `invalidchars`, dan `auth` (autentikasi filter) aktif sebelum dieksekusi.

### 6. Perbaikan Galat Migrasi Tambahan (Hotfix v1.0.2)
* **Masalah "No direct script access allowed":** Terjadi akibat sisa berkas views galat/error bawaan CI3 di dalam `app/Views/errors/html/` and `app/Views/errors/cli/`. Kode pengetesan `defined('BASEPATH')` mematikan alur eksekusi saat terjadi galat internal karena CI4 tidak mendefinisikan `BASEPATH`.
  * **Solusi:** Merestorasi seluruh berkas views error bawaan CI4 yang bersih dari `vendor/codeigniter4/framework/app/Views/errors/` ke `app/Views/errors/`.
* **Masalah Undefined Property `$uri` di View Layout:** Berkas view `app/Views/template/header.php` memicu error fatal karena mencoba mengakses `$this->uri->segment()` untuk menandai tautan aktif di menu navigasi, sedangkan kelas View CI4 tidak memilikinya.
  * **Solusi:** 
    1. Membuat fungsi pembantu `uri_segment(int $index)` di `app/Common.php` untuk mengambil segmen URI secara dinamis melalui service URI bawaan CI4 (`service('request')->getUri()->getSegments()`).
    2. Memigrasikan seluruh pemanggilan `$this->uri->segment(n)` pada `app/Views/template/header.php` ke `uri_segment(n)`.
    3. Merestorasi berkas `app/Views/welcome_message.php` ke versi standar CI4 yang bersih tanpa cek `BASEPATH`.

---

## 🧪 Validasi Akhir
* **Akses Dashboard:** Uji coba menggunakan `curl` mengonfirmasi bahwa halaman `http://localhost/si_ternak/public/dashboard` memuat HTML Dashboard SI TERNAK dengan sukses (HTTP status 200/Redirect ke login sesuai kondisi sesi autentikasi).
* **Linting Akhir:** Seluruh berkas yang diubah telah divalidasi dengan `php -l` dan bebas dari galat sintaksis.

### 7. Penyesuaian Form Inseminasi & Sistem Bantuan (Hotfix v1.0.3)
* **Status Awal:** Dropdown "Status Awal" dihilangkan dari form Tambah Inseminasi Buatan agar bernilai default "menunggu".
* **Pencarian Autocomplete:** Form `tambah_ib` & `edit_ib` sekarang menggunakan input teks dengan pencarian otomatis (autocomplete) berbasis AJAX untuk Peternak dan Hewan Betina (menghemat memori dan mempercepat muatan).
* **Alamat Otomatis:** Saat memilih peternak atau hewan betina, alamat lengkap, desa, dan kecamatan pemilik hewan terisi secara otomatis di form dan disimpan langsung ke database inseminasi.
* **Bantuan Per Orang:** Bidang bantuan (`sumber_dana`, `ras_ternak`, `tahun_anggaran`) dan penugasan Kelompok Ternak dipindahkan dari entitas kelompok ke individu `peternak`. Form kelompok dibersihkan dari bidang bantuan, dan Daftar Kelompok Ternak kini menampilkan rekapitulasi bantuan anggota kelompok secara dinamis.
* **Kolom Kumulatif:** Menambahkan kolom input serta kolom tabel "Kumulatif" (Jantan & Betina) pada Laporan Bulanan Perkembangan.

### 8. Halaman Detail Inseminasi & Penyederhanaan Laporan Pakan (Hotfix/Feature v1.0.4)
* **Detail Inseminasi:** Menambahkan halaman detail yang memuat informasi lengkap tentang rekaman Inseminasi Buatan (IB) termasuk data status (dengan badge berwarna), hewan, pemilik (alamat lengkap), petugas, serta metadata pencatatan (dibuat oleh, tanggal input). Menghubungkan tombol "Detail" di halaman index inseminasi ke halaman baru ini.
* **Penyederhanaan Form Laporan Produksi Pakan:** Mengubah alur penginputan detail pakan yang sebelumnya menggunakan tombol dinamis dan dropdown berulang menjadi form grid (tabel) statis yang memuat seluruh jenis pakan aktif. Pengguna tinggal menginput jumlah angka produksi di setiap baris jenis pakan, memangkas proses penginputan data secara signifikan.
* **Melengkapi Alur CRUD Laporan Pakan:** Menambahkan method `laporan_produksi_update()` dan `laporan_produksi_delete()` pada Controller Pakan untuk menyempurnakan fitur Edit dan Hapus laporan yang sebelumnya terputus/404. View edit juga disatukan ke view form utama (`v_laporan_produksi_form.php`) agar lebih efisien.
* **Filter Bulanan Otomatis (Onchange):** Menambahkan filter Bulan dan Tahun pada halaman index laporan produksi pakan dengan nilai default mengarah ke **bulan lalu** (bulan berjalan - 1). Dropdown filter menggunakan event `onchange` JavaScript sehingga halaman ter-reload otomatis memfilter data tanpa memerlukan tombol submit filter.

### 9. Menampilkan Semua Kelompok & Status Belum Input (Hotfix/Feature v1.0.5)
* **Tampilan Seluruh Kelompok:** Memodifikasi `get_all()` di `LaporanProduksiPakanModel.php` agar mengambil data kelompok dari tabel `kelompok_produksi_pakan` dan melakukan `LEFT JOIN` ke data laporan pada bulan/tahun terpilih. Hal ini memastikan seluruh kelompok terdaftar di halaman laporan produksi meskipun belum menginput data.
* **Status Belum Input:** Jika suatu kelompok belum menginput laporan untuk periode yang disaring, baris kelompok tersebut ditandai dengan status **"Belum Input"** (label merah) dan total produksinya diset `0`.
* **Pengisian Cepat (Pre-fill Form):** Menyediakan tombol **"Input Laporan"** pada baris kelompok yang belum mengisi. Tombol ini mengarahkan ke form tambah laporan dengan otomatis menyertakan ID Kelompok, Bulan, dan Tahun terpilih melalui parameter GET, sehingga pengguna tidak perlu memilih ulang data tersebut pada form baru.
