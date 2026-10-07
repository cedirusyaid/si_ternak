import os
import sys
from fpdf import FPDF

class PDFReport(FPDF):
    def header(self):
        # Header banner
        self.set_fill_color(24, 76, 120) # Deep Navy
        self.rect(0, 0, 210, 18, 'F')
        
        self.set_font('Helvetica', 'B', 8)
        self.set_text_color(255, 255, 255)
        self.set_xy(10, 5)
        self.cell(0, 8, 'DINAS PETERNAKAN DAN KESEHATAN HEWAN KABUPATEN SINJAI', 0, 0, 'L')
        self.cell(0, 8, 'SISTEM INFORMASI KESEHATAN HEWAN (SI TERNAK)', 0, 0, 'R')
        self.ln(16)

    def footer(self):
        self.set_y(-15)
        self.set_font('Helvetica', 'I', 8)
        self.set_text_color(130, 130, 130)
        self.cell(0, 10, f'Halaman {self.page_no()}/{{nb}} - Dokumen Teknis & Blueprint Sistem', 0, 0, 'L')
        self.cell(0, 10, 'Disiapkan oleh: Disnakkeswan Sinjai', 0, 0, 'R')

def create_pdf(output_path):
    pdf = PDFReport('P', 'mm', 'A4')
    pdf.alias_nb_pages()
    pdf.set_auto_page_break(auto=True, margin=18)
    pdf.add_page()
    
    # Title Section
    pdf.set_text_color(24, 76, 120)
    pdf.set_font('Helvetica', 'B', 15)
    pdf.cell(0, 8, 'RANCANGAN SISTEM SURVEILANS & PEMETAAN', ln=True, align='C')
    pdf.cell(0, 7, 'SPASIO-TEMPORAL PENYAKIT TERNAK & UNGGAS', ln=True, align='C')
    
    pdf.set_font('Helvetica', 'I', 9)
    pdf.set_text_color(100, 100, 100)
    pdf.cell(0, 6, 'Integrasi GIS Pemetaan Penyakit Berbasis Desa/Kelurahan dengan Analisis Timeline', ln=True, align='C')
    
    pdf.set_draw_color(24, 76, 120)
    pdf.set_line_width(0.5)
    pdf.line(15, 45, 195, 45)
    pdf.ln(5)

    # Helper for Section Heading
    def section_heading(title, icon=""):
        pdf.ln(3)
        pdf.set_fill_color(235, 243, 250)
        pdf.set_text_color(24, 76, 120)
        pdf.set_font('Helvetica', 'B', 11)
        pdf.cell(0, 7, f"  {title}", fill=True, ln=True)
        pdf.ln(2)

    # 1. LATAR BELAKANG
    section_heading("1. Latar Belakang & Konsep Surveilans Spasio-Temporal")
    pdf.set_font('Helvetica', '', 9.5)
    pdf.set_text_color(40, 40, 40)
    p1 = (
        "Dalam bidang Kesehatan Hewan (Keswan) dan Epidemiologi Veteriner nasional (mengacu standar Kementan "
        "dan sistem iSIKHNAS), pemantauan penyakit ternak harus mampu menjawab dua aspek krusial: DIMENSI RUANG "
        "(Spasial/Lokasi Desa) dan DIMENSI WAKTU (Temporal/Perjalanan Kasus). Sistem ini dirancang untuk memetakan "
        "sebaran penyakit menular pada ternak besar, ternak kecil, serta komoditas unggas secara real-time "
        "menggunakan teknologi GIS berbasis Web (Leaflet.js + WKT Poligon Desa)."
    )
    pdf.multi_cell(0, 5, p1)
    
    # Istilah Kunci
    pdf.ln(2)
    pdf.set_font('Helvetica', 'B', 9)
    pdf.cell(0, 5, 'Istilah Kunci:', ln=True)
    pdf.set_font('Helvetica', '', 9)
    terms = [
        ("PHMS", "Penyakit Hewan Menular Strategis yang berisiko wabah & kerugian ekonomi tinggi."),
        ("Zoonosis", "Penyakit hewan yang dapat menular secara fatal ke manusia (contoh: Anthrax, Rabies, Flu Burung)."),
        ("Morbiditas / Attack Rate", "Persentase jumlah hewan yang terinfeksi di suatu populasi wilayah."),
        ("Case Fatality Rate (CFR)", "Persentase tingkat kematian dari seluruh ternak/unggas yang sakit."),
        ("Zonasi Epidemiologi", "Klasifikasi status kewaspadaan wilayah (Zona Merah, Kuning, Hijau).")
    ]
    for k, v in terms:
        pdf.set_font('Helvetica', 'B', 8.5)
        pdf.set_text_color(24, 76, 120)
        pdf.cell(45, 5, f"- {k}:", 0, 0)
        pdf.set_font('Helvetica', '', 8.5)
        pdf.set_text_color(40, 40, 40)
        pdf.cell(0, 5, v, 0, 1)

    # 2. DAFTAR PENYAKIT PRIORITAS
    section_heading("2. Klasifikasi Penyakit Prioritas (Ternak & Unggas)")
    
    # Table Header
    pdf.set_fill_color(24, 76, 120)
    pdf.set_text_color(255, 255, 255)
    pdf.set_font('Helvetica', 'B', 8)
    pdf.cell(16, 6, 'Kode', 1, 0, 'C', True)
    pdf.cell(40, 6, 'Nama Penyakit', 1, 0, 'L', True)
    pdf.cell(32, 6, 'Komoditas', 1, 0, 'L', True)
    pdf.cell(18, 6, 'Sifat', 1, 0, 'C', True)
    pdf.cell(74, 6, 'Gejala & Dampak Utama', 1, 1, 'L', True)
    
    # Table Content
    diseases = [
        ("PMK", "Mulut & Kuku (FMD)", "Sapi, Kerbau, Kambing", "Virus", "Lepuh mulut/kuku, pincang, air liur berlebih."),
        ("ANT", "Anthrax (Radang Limpa)", "Ruminansia, Manusia", "Zoonosis", "Kematian mendadak, darah keluar dari lubang alami."),
        ("LSD", "Lumpy Skin Disease", "Sapi, Kerbau", "Virus", "Benjolan nodul keras di kulit, demam tinggi."),
        ("JEM", "Penyakit Jembrana", "Khusus Sapi Bali", "Virus", "Keringat darah, demam akut, bengkak kelenjar limfa."),
        ("SE", "Ngorok (Septicaemia)", "Sapi, Kerbau", "Bakteri", "Leher bengkak, sesak napas, mendengkur keras."),
        ("BRU", "Brucellosis (Keluron)", "Sapi, Kambing, Manusia", "Zoonosis", "Keguguran semester akhir kehamilan, retensi plasenta."),
        ("AI", "Flu Burung (Avian Infl.)", "Ayam, Bebek, Unggas", "Zoonosis", "Kematian massal cepat, jengger biru, kaki merah."),
        ("ND", "Tetelo (Newcastle Dis.)", "Semua Jenis Unggas", "Virus", "Leher berputar (tortikolis), kelumpuhan saraf, mortalitas 100%."),
        ("GUM", "Gumboro (IBD)", "Anak Ayam (DOC)", "Virus", "Rusak kekebalan bursa Fabricius, diare putih, lesu."),
        ("SNOT", "Coryza / Snot", "Ayam Layer & Broiler", "Bakteri", "Muka & hidung bengkak berlendir, produksi telur anjlok."),
        ("PUL", "Pullorum (Berak Kapur)", "DOC & Anak Unggas", "Bakteri", "Kotoran putih menempel di anus, sayap terkulai.")
    ]
    
    pdf.set_font('Helvetica', '', 7.5)
    fill = False
    for code, name, target, sifat, desc in diseases:
        pdf.set_fill_color(248, 250, 252) if fill else pdf.set_fill_color(255, 255, 255)
        pdf.set_text_color(30, 30, 30)
        if sifat == "Zoonosis":
            pdf.set_text_color(180, 20, 20)
        pdf.cell(16, 5, code, 1, 0, 'C', fill)
        pdf.set_text_color(30, 30, 30)
        pdf.cell(40, 5, name, 1, 0, 'L', fill)
        pdf.cell(32, 5, target, 1, 0, 'L', fill)
        if sifat == "Zoonosis":
            pdf.set_text_color(180, 20, 20)
            pdf.set_font('Helvetica', 'B', 7.5)
        pdf.cell(18, 5, sifat, 1, 0, 'C', fill)
        pdf.set_font('Helvetica', '', 7.5)
        pdf.set_text_color(40, 40, 40)
        pdf.cell(74, 5, desc, 1, 1, 'L', fill)
        fill = not fill

    # 3. FITUR UTAMA SISTEM & PETA TIMELINE
    section_heading("3. Fitur Utama Peta Spasio-Temporal (GIS Timeline)")
    
    features = [
        ("Time-Slider & Playback Interaktif", "Pengguna dapat menggeser slider bulan/minggu atau menekan tombol Play untuk memutar pergerakan wabah dan pemulihan kasus dari waktu ke waktu secara animasi dinamis."),
        ("Pewarnaan Otomatis (Choropleth Zonasi)", "Poligon desa otomatis berubah warna: MERAH (Wabah / Kasus Aktif >= 5), KUNING (Waspada / Kasus 1-4), dan HIJAU (Bebas / 0 Kasus)."),
        ("Filter Multi-Kategori Komoditas", "Pilihan filter spesifik: Semua Ternak, Ruminansia Besar (Sapi/Kerbau), Ruminansia Kecil (Kambing), dan Unggas (Ayam/Bebek)."),
        ("Integrasi Data Geospasial Sinjai", "Memanfaatkan langsung kolom batas poligon wilayah (WKT) 80 desa se-Kabupaten Sinjai dari tabel master 'kode_desa'."),
        ("Pelaporan & Notifikasi Respons Cepat", "Form input pelaporan cepat oleh Dokter Hewan/Inseminator di lapangan dengan pencatatan populasi rentan, sembuh, mati, dan tindakan darurat.")
    ]
    
    for title, desc in features:
        pdf.set_font('Helvetica', 'B', 8.5)
        pdf.set_text_color(24, 76, 120)
        pdf.cell(0, 4.5, f"[x] {title}", ln=True)
        pdf.set_font('Helvetica', '', 8)
        pdf.set_text_color(50, 50, 50)
        pdf.multi_cell(0, 4, f"    {desc}")
        pdf.ln(1)

    # 4. SKEMA DATA & ARSITEKTUR TEKNIS
    section_heading("4. Arsitektur Teknis & Skema Database")
    pdf.set_font('Helvetica', '', 8.5)
    pdf.set_text_color(40, 40, 40)
    pdf.multi_cell(0, 4.5, 
        "Sistem dibangun di atas platform CodeIgniter 4 dengan integrasi MariaDB dan pustaka GIS Leaflet.js. "
        "Data kasus dicatat dalam tabel 'trn_kasus_penyakit' yang berelasi dengan tabel master spasial 'kode_desa' "
        "dan 'mst_penyakit'."
    )
    pdf.ln(2)
    
    # Table of Schema Fields
    pdf.set_fill_color(230, 235, 240)
    pdf.set_font('Helvetica', 'B', 7.5)
    pdf.cell(40, 5, 'Field Database', 1, 0, 'L', True)
    pdf.cell(30, 5, 'Tipe Data', 1, 0, 'L', True)
    pdf.cell(110, 5, 'Fungsi & Peruntukan', 1, 1, 'L', True)
    
    fields = [
        ("id_kasus / no_laporan", "INT / VARCHAR(50)", "Identitas unik dokumen kejadian penyakit"),
        ("id_penyakit & kategori_ternak", "INT / ENUM", "Jenis penyakit dan komoditas (Sapi / Kambing / Unggas)"),
        ("desa_id & kecamatan_id", "BIGINT / INT", "Relasi poligon peta administratif Sinjai (tabel kode_desa)"),
        ("tanggal_kejadian & tgl_selesai", "DATE", "Dimensi waktu awal infeksi dan penutupan masa wabah"),
        ("jumlah_sakit / sembuh / mati", "INT (Angka Kasus)", "Kalkulasi morbiditas, mortalitas, dan status aktif zonasi"),
        ("status_kasus", "ENUM", "Tahapan: Suspek -> Terkonfirmasi -> Terkendali -> Selesai"),
        ("koordinat_gps & tindakan", "VARCHAR / TEXT", "Titik koordinat kandang GPS dan catatan terapi/vaksinasi")
    ]
    pdf.set_font('Helvetica', '', 7.5)
    for f_name, f_type, f_desc in fields:
        pdf.cell(40, 4.5, f_name, 1, 0, 'L')
        pdf.cell(30, 4.5, f_type, 1, 0, 'L')
        pdf.cell(110, 4.5, f_desc, 1, 1, 'L')

    # 5. REKOMENDASI TAHAPAN EKSEKUSI
    section_heading("5. Rencana Tahapan Eksekusi (Roadmap)")
    steps = [
        ("Fase 1: Database & Seeder", "Pembuatan tabel trn_kasus_penyakit dan seeder master penyakit ternak + unggas."),
        ("Fase 2: Modul Input Kasus", "Form pelaporan kejadian sakit, update ternak sembuh/mati oleh petugas keswan."),
        ("Fase 3: Endpoint GeoJSON", "Penyediaan REST API spasio-temporal yang mengembalikan WKT + data kasus per bulan."),
        ("Fase 4: Antarmuka Peta Timeline", "Pembangunan peta Leaflet interaktif dengan slider timeline dan tombol play/pause."),
        ("Fase 5: Laporan Eksekutif", "Ekspor rekapitulasi laporan epidemiologi bulanan untuk pimpinan dinas.")
    ]
    for s_title, s_desc in steps:
        pdf.set_font('Helvetica', 'B', 8)
        pdf.set_text_color(24, 76, 120)
        pdf.cell(45, 4.5, f"- {s_title}:", 0, 0)
        pdf.set_font('Helvetica', '', 8)
        pdf.set_text_color(50, 50, 50)
        pdf.cell(0, 4.5, s_desc, 0, 1)

    # Output file
    pdf.output(output_path)
    print(f"PDF berhasil dibuat di: {output_path}")

if __name__ == '__main__':
    target = sys.argv[1] if len(sys.argv) > 1 else 'RANCANGAN_PETA_PENYAKIT_TIMELINE.pdf'
    create_pdf(target)
