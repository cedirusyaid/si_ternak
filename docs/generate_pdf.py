import sys
from fpdf import FPDF
from fpdf.enums import XPos, YPos

class PDFReport(FPDF):
    def header(self):
        # Header banner
        self.set_fill_color(24, 76, 120) # Deep Navy
        self.rect(0, 0, 210, 16, 'F')
        
        self.set_font('Helvetica', 'B', 8)
        self.set_text_color(255, 255, 255)
        self.set_xy(10, 4)
        self.cell(100, 8, 'DINAS PETERNAKAN DAN KESEHATAN HEWAN KABUPATEN SINJAI', 0, 0, 'L')
        self.cell(90, 8, 'SI TERNAK - SURVEILANS SPASIO-TEMPORAL', 0, 1, 'R')
        self.ln(10)

    def footer(self):
        self.set_y(-14)
        self.set_font('Helvetica', 'I', 8)
        self.set_text_color(130, 130, 130)
        self.cell(100, 8, f'Halaman {self.page_no()}/{{nb}} - Blueprint Sistem & UI/UX', 0, 0, 'L')
        self.cell(90, 8, 'Disnakkeswan Kab. Sinjai', 0, 0, 'R')

def build_pdf(output_path):
    pdf = PDFReport('P', 'mm', 'A4')
    pdf.alias_nb_pages()
    pdf.set_auto_page_break(auto=True, margin=16)
    pdf.add_page()
    
    # Title Section
    pdf.set_text_color(24, 76, 120)
    pdf.set_font('Helvetica', 'B', 14)
    pdf.cell(0, 7, 'BLUEPRINT RANCANGAN SISTEM & DESAIN UI/UX', new_x=XPos.LMARGIN, new_y=YPos.NEXT, align='C')
    pdf.cell(0, 6, 'SURVEILANS SPASIO-TEMPORAL PENYAKIT TERNAK & UNGGAS', new_x=XPos.LMARGIN, new_y=YPos.NEXT, align='C')
    
    pdf.set_font('Helvetica', 'I', 8.5)
    pdf.set_text_color(100, 100, 100)
    pdf.cell(0, 5, 'Pemetaan Penyakit Berbasis Desa/Kelurahan dengan Analisis Timeline Interaktif (Kabupaten Sinjai)', new_x=XPos.LMARGIN, new_y=YPos.NEXT, align='C')
    
    pdf.set_draw_color(24, 76, 120)
    pdf.set_line_width(0.4)
    pdf.line(15, 38, 195, 38)
    pdf.ln(4)

    def section(title):
        pdf.ln(2)
        pdf.set_fill_color(235, 243, 250)
        pdf.set_text_color(24, 76, 120)
        pdf.set_font('Helvetica', 'B', 10)
        pdf.cell(0, 6, f"  {title}", fill=True, new_x=XPos.LMARGIN, new_y=YPos.NEXT)
        pdf.ln(1.5)

    # 1. LATAR BELAKANG
    section("1. Latar Belakang & Istilah Teknis Veteriner")
    pdf.set_font('Helvetica', '', 8.5)
    pdf.set_text_color(40, 40, 40)
    pdf.multi_cell(0, 4.2, 
        "Sistem Surveilans Spasio-Temporal dirancang untuk memantau kejadian Penyakit Hewan Menular Strategis (PHMS) "
        "secara terpadu pada ternak ruminansia (sapi, kerbau, kambing) dan komoditas unggas (ayam, bebek). "
        "Sistem ini menggabungkan dimensi ruang (wilayah desa/kelurahan di Sinjai) dan dimensi waktu (timeline perkembangan kasus) "
        "menggunakan teknologi GIS interaktif berbasis Web (Leaflet.js + WKT Poligon)."
    )
    
    # 2. KATALOG PENYAKIT
    section("2. Klasifikasi Penyakit Prioritas (Ternak & Unggas)")
    pdf.set_fill_color(24, 76, 120)
    pdf.set_text_color(255, 255, 255)
    pdf.set_font('Helvetica', 'B', 7.5)
    pdf.cell(14, 5, 'Kode', 1, 0, 'C', True)
    pdf.cell(38, 5, 'Nama Penyakit', 1, 0, 'L', True)
    pdf.cell(30, 5, 'Komoditas', 1, 0, 'L', True)
    pdf.cell(18, 5, 'Sifat', 1, 0, 'C', True)
    pdf.cell(80, 5, 'Gejala Klinis & Dampak Utama', 1, 1, 'L', True)
    
    diseases = [
        ("PMK", "Mulut & Kuku (FMD)", "Sapi, Kerbau, Kambing", "Virus", "Lepuh lidah/kuku, pincang, air liur berbusa, menular cepat."),
        ("ANT", "Anthrax (Radang Limpa)", "Ruminansia, Manusia", "Zoonosis", "Kematian mendadak, darah keluar dari lubang alami tanpa beku."),
        ("LSD", "Lumpy Skin Disease", "Sapi, Kerbau", "Virus", "Benjolan nodul keras di kulit tubuh, demam tinggi, kurus."),
        ("JEM", "Penyakit Jembrana", "Khusus Sapi Bali", "Virus", "Keringat darah (blood sweating), demam akut, bengkak limfa."),
        ("SE", "Ngorok (Septicaemia)", "Sapi, Kerbau", "Bakteri", "Busung leher/dada, sesak napas akut, suara mendengkur keras."),
        ("BRU", "Brucellosis (Keluron)", "Sapi, Kambing, Manusia", "Zoonosis", "Keguguran semester akhir kehamilan, retensi plasenta, mandul."),
        ("AI", "Flu Burung (Avian Infl.)", "Ayam, Bebek, Unggas", "Zoonosis", "Kematian massal sangat cepat, jengger biru, kaki berbintik merah."),
        ("ND", "Tetelo (Newcastle Dis.)", "Semua Jenis Unggas", "Virus", "Leher berputar (tortikolis), gangguan saraf, mortalitas 100%."),
        ("GUM", "Gumboro (IBD)", "Anak Ayam (DOC)", "Virus", "Kerusakan bursa Fabricius, diare putih berlendir, lesu."),
        ("SNOT", "Coryza / Snot", "Ayam Layer & Broiler", "Bakteri", "Muka & hidung bengkak berlendir bau, produksi telur anjlok.")
    ]
    pdf.set_font('Helvetica', '', 7)
    fill = False
    for code, name, target, sifat, desc in diseases:
        pdf.set_fill_color(248, 250, 252) if fill else pdf.set_fill_color(255, 255, 255)
        pdf.set_text_color(180, 20, 20) if sifat == "Zoonosis" else pdf.set_text_color(30, 30, 30)
        pdf.cell(14, 4.5, code, 1, 0, 'C', fill)
        pdf.set_text_color(30, 30, 30)
        pdf.cell(38, 4.5, name, 1, 0, 'L', fill)
        pdf.cell(30, 4.5, target, 1, 0, 'L', fill)
        if sifat == "Zoonosis":
            pdf.set_text_color(180, 20, 20)
            pdf.set_font('Helvetica', 'B', 7)
        pdf.cell(18, 4.5, sifat, 1, 0, 'C', fill)
        pdf.set_font('Helvetica', '', 7)
        pdf.set_text_color(40, 40, 40)
        pdf.cell(80, 4.5, desc, 1, 1, 'L', fill)
        fill = not fill

    # 3. RANCANGAN UI/UX
    section("3. Rancangan Komprehensif Antarmuka (UI/UX Design)")
    pdf.set_font('Helvetica', '', 8.5)
    pdf.set_text_color(40, 40, 40)
    pdf.multi_cell(0, 4.2, 
        "Desain antarmuka mematuhi standar AdminLTE 3 dan IDDS (INA Digital) dengan struktur tata letak intuitif "
        "yang dioptimalkan untuk dua kelompok pengguna: Petugas Medis Lapangan (Mobile View) dan Pimpinan Dinas (Desktop View)."
    )
    pdf.ln(1)
    
    # UI Elements Table
    pdf.set_fill_color(230, 235, 240)
    pdf.set_font('Helvetica', 'B', 7.5)
    pdf.cell(42, 5, 'Komponen Layar', 1, 0, 'L', True)
    pdf.cell(50, 5, 'Elemen Interaksi UI', 1, 0, 'L', True)
    pdf.cell(88, 5, 'Fungsi & Pengalaman Pengguna (UX)', 1, 1, 'L', True)
    
    ui_specs = [
        ("Layar 1: Peta Spasial & Timeline Playback", "Leaflet Map + Floating Timeline Controller + Filter Toolbar", "Menampilkan peta poligon 80 desa Sinjai dengan slider bulan dan tombol Play/Pause animasi pergerakan wabah."),
        ("Pewarnaan Zonasi (Choropleth Auto)", "Warna Poligon: Merah (>=5 kasus), Kuning (1-4 kasus), Hijau (Bebas)", "Memungkinkan identifikasi instan wilayah genting (Hotspot) dan status kesembuhan ternak."),
        ("Layar 2: Form Input Kasus Lapangan", "Wizard Form 3-Step + Auto Detect GPS Kandang + Upload Foto", "Dioptimalkan untuk HP petugas di lapangan agar input pelaporan cepat dan akurat di lokasi peternak."),
        ("Layar 3: Monitoring & Quick Update", "DataTable + Icon-Only Action Buttons + Tooltip Hover", "Pencatatan kasus dengan tombol aksi standar (fa-circle-info, fa-pen, fa-trash) dan update status kesembuhan."),
        ("Widget KPI Statistik Bulanan", "5 Kartu Metrik: Kasus Aktif, Sembuh, Mati, Potong Darurat, Vaksinasi", "Ringkasan data real-time untuk pengambilan keputusan pimpinan secara cepat.")
    ]
    pdf.set_font('Helvetica', '', 7)
    for c_name, c_elem, c_ux in ui_specs:
        pdf.cell(42, 5, c_name, 1, 0, 'L')
        pdf.cell(50, 5, c_elem, 1, 0, 'L')
        pdf.cell(88, 5, c_ux, 1, 1, 'L')

    # 4. SKEMA DATABASE
    section("4. Skema Database & Relasi Spasio-Temporal")
    pdf.set_font('Helvetica', '', 8)
    pdf.set_text_color(40, 40, 40)
    pdf.multi_cell(0, 4.2, 
        "Tabel utama transaksi 'trn_kasus_penyakit' menampung data riwayat kasus, jumlah morbiditas/mortalitas, "
        "dan berelasi langsung dengan tabel poligon 'kode_desa' serta master penyakit 'mst_penyakit'."
    )
    pdf.ln(1)
    
    pdf.set_fill_color(240, 243, 246)
    pdf.set_font('Helvetica', 'B', 7)
    pdf.cell(45, 4.5, 'Kolom Data', 1, 0, 'L', True)
    pdf.cell(32, 4.5, 'Tipe Data', 1, 0, 'L', True)
    pdf.cell(103, 4.5, 'Kegunaan & Integrasi Spasial', 1, 1, 'L', True)
    
    db_rows = [
        ("id_kasus / no_laporan", "INT / VARCHAR(50)", "Primary Key dan nomor unik pelaporan kasus keswan"),
        ("id_penyakit & komoditas", "INT / ENUM", "Relasi ke master penyakit dan kelompok ternak/unggas"),
        ("desa_id & kecamatan_id", "BIGINT / INT", "Foreign Key yang menghubungkan kasus ke poligon peta kode_desa"),
        ("tanggal_kejadian & selesai", "DATE / DATE", "Penanda rentang waktu (timeline) kasus aktif hingga selesai"),
        ("jumlah_sakit / sembuh / mati", "INT (Angka)", "Dasar penghitungan rumus Zonasi Merah-Kuning-Hijau"),
        ("status_kasus", "ENUM", "Status validasi: Suspek -> Terkonfirmasi -> Terkendali -> Selesai"),
        ("koordinat_gps & foto_gejala", "VARCHAR / VARCHAR", "Titik GPS kandang dan dokumentasi bukti klinis")
    ]
    pdf.set_font('Helvetica', '', 7)
    for col, dt, util in db_rows:
        pdf.cell(45, 4.2, col, 1, 0, 'L')
        pdf.cell(32, 4.2, dt, 1, 0, 'L')
        pdf.cell(103, 4.2, util, 1, 1, 'L')

    # 5. ROADMAP
    section("5. Rencana Tahapan Eksekusi (Roadmap)")
    roadmap = [
        ("Fase 1: Database & Seeder", "Penyusunan tabel trn_kasus_penyakit dan seeder master penyakit ternak + unggas."),
        ("Fase 2: Form Input Lapangan", "Pembangunan form input kasus mobile-friendly dan tracking status kesembuhan."),
        ("Fase 3: Service API GeoJSON", "Pengembangan REST API Spasio-Temporal yang memproses WKT poligon 80 desa."),
        ("Fase 4: Antarmuka Peta Leaflet", "Integrasi peta interaktif dengan timeline slider dan animasi playback otomatis."),
        ("Fase 5: Laporan Eksekutif", "Fitur rekapitulasi & ekspor laporan surveilans bulanan (PDF/Excel) untuk pimpinan.")
    ]
    for r_title, r_desc in roadmap:
        pdf.set_font('Helvetica', 'B', 7.5)
        pdf.set_text_color(24, 76, 120)
        pdf.cell(42, 4.2, f"- {r_title}:", 0, 0)
        pdf.set_font('Helvetica', '', 7.5)
        pdf.set_text_color(50, 50, 50)
        pdf.cell(0, 4.2, r_desc, 0, 1)

    pdf.output(output_path)
    print(f"PDF Berhasil dibuat di: {output_path}")

if __name__ == '__main__':
    target = sys.argv[1] if len(sys.argv) > 1 else 'docs/RANCANGAN_PETA_PENYAKIT_TIMELINE.pdf'
    build_pdf(target)
