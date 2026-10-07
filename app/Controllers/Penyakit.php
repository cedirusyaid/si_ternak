<?php

namespace App\Controllers;

use App\Models\PenyakitModel;
use App\Models\KasusPenyakitModel;
use App\Models\WilayahModel;
use App\Models\PetugasModel;
use App\Models\PeternakModel;

class Penyakit extends BaseController
{
    protected $penyakitModel;
    protected $kasusModel;
    protected $wilayahModel;

    public function __construct()
    {
        $this->penyakitModel = new PenyakitModel();
        $this->kasusModel    = new KasusPenyakitModel();
        $this->wilayahModel  = new WilayahModel();
    }

    // =========================================================================
    // 1. PETA GIS TIMELINE & DASHBOARD SPASIO-TEMPORAL
    // =========================================================================
    public function index()
    {
        $data['title']         = "Peta Surveilans Spasio-Temporal Penyakit";
        $data['penyakit_list'] = $this->penyakitModel->get_all();
        $data['kecamatan_list']= $this->wilayahModel->get_all_kecamatan();
        $data['komoditas_list']= ['Sapi Potong', 'Sapi Perah', 'Kerbau', 'Kambing', 'Domba', 'Ayam Broiler', 'Ayam Layer', 'Ayam Kampung', 'Itik/Bebek'];
        $data['current_year']  = date('Y');
        $data['current_month'] = date('n');

        return view('template/header', $data)
             . view('penyakit/v_peta_timeline', $data)
             . view('template/footer');
    }

    // Helper parser WKT ke Geometry GeoJSON
    private function wktToGeoJsonGeometry($wkt)
    {
        $wkt = trim($wkt);
        if (preg_match('/^POLYGON\s*\(\((.*?)\)\)$/si', $wkt, $m)) {
            $rings = explode(',', trim($m[1]));
            $coords = [];
            foreach ($rings as $ring) {
                $parts = preg_split('/\s+/', trim($ring));
                if (count($parts) >= 2) {
                    $coords[] = [(float) $parts[0], (float) $parts[1]]; // [lng, lat]
                }
            }
            return [
                'type'        => 'Polygon',
                'coordinates' => [$coords]
            ];
        } elseif (preg_match('/^MULTIPOLYGON\s*\((.*?)\)$/si', $wkt, $m)) {
            preg_match_all('/\(\((.*?)\)\)/s', $m[1], $polyMatches);
            $multiCoords = [];
            foreach ($polyMatches[1] as $polyStr) {
                $rings = explode(',', trim($polyStr));
                $coords = [];
                foreach ($rings as $ring) {
                    $parts = preg_split('/\s+/', trim($ring));
                    if (count($parts) >= 2) {
                        $coords[] = [(float) $parts[0], (float) $parts[1]];
                    }
                }
                if (!empty($coords)) {
                    $multiCoords[] = [$coords];
                }
            }
            return [
                'type'        => 'MultiPolygon',
                'coordinates' => $multiCoords
            ];
        }
        return null;
    }

    // Endpoint API REST GeoJSON untuk Timeline Playback
    public function api_timeline_geojson()
    {
        $tahun       = $this->request->getGet('tahun') ?? date('Y');
        $bulan       = $this->request->getGet('bulan') ?? date('n');
        $id_penyakit = $this->request->getGet('id_penyakit') ?? 'all';
        $komoditas   = $this->request->getGet('komoditas') ?? 'all';

        $raw = $this->kasusModel->get_desa_timeline_aggregates($tahun, $bulan, $id_penyakit, $komoditas);

        $features = [];
        $totalAktif = 0;
        $totalSembuh = 0;
        $totalMati = 0;

        foreach ($raw['desa_list'] as $desa) {
            $desaId = $desa->desa_id;
            $hasKasus = isset($raw['kasus_by_desa'][$desaId]);
            $kasusData = $hasKasus ? $raw['kasus_by_desa'][$desaId] : [
                'total_sakit'  => 0,
                'total_sembuh' => 0,
                'total_mati'   => 0,
                'total_potong' => 0,
                'kasus_aktif'  => 0,
                'daftar_kasus' => []
            ];

            $aktif = $kasusData['kasus_aktif'];
            $totalAktif += $aktif;
            $totalSembuh += $kasusData['total_sembuh'];
            $totalMati += $kasusData['total_mati'];

            // Tentukan status zonasi dan warna
            if ($aktif >= 5) {
                $zonasi = 'Merah';
                $color  = '#dc3545'; // Bahaya / Wabah Aktif
                $fillOpacity = 0.65;
            } elseif ($aktif >= 1) {
                $zonasi = 'Kuning';
                $color  = '#ffc107'; // Waspada / Terancam
                $fillOpacity = 0.55;
            } else {
                $zonasi = 'Hijau';
                $color  = '#28a745'; // Bebas / Aman
                $fillOpacity = 0.35;
            }

            $geometry = $this->wktToGeoJsonGeometry($desa->wkt);

            $features[] = [
                'type' => 'Feature',
                'geometry' => $geometry,
                'properties' => [
                    'desa_id'         => (int) $desa->desa_id,
                    'desa_nama'       => $desa->desa_nama,
                    'kecamatan_id'    => (int) $desa->kecamatan_id,
                    'kecamatan_nama'  => $desa->kecamatan_nama,
                    'kasus_aktif'     => $aktif,
                    'total_sakit'     => $kasusData['total_sakit'],
                    'total_sembuh'    => $kasusData['total_sembuh'],
                    'total_mati'      => $kasusData['total_mati'],
                    'total_potong'    => $kasusData['total_potong'],
                    'zonasi'          => $zonasi,
                    'color'           => $color,
                    'fillOpacity'     => $fillOpacity,
                    'daftar_kasus'    => $kasusData['daftar_kasus']
                ]
            ];
        }

        $response = [
            'type' => 'FeatureCollection',
            'metadata' => [
                'tahun'             => (int) $tahun,
                'bulan'             => (int) $bulan,
                'total_kasus_aktif' => $totalAktif,
                'total_sembuh'      => $totalSembuh,
                'total_mati'        => $totalMati,
                'total_desa'        => count($features)
            ],
            'features' => $features
        ];

        return $this->response->setJSON($response);
    }

    // =========================================================================
    // 2. MANAJEMEN & DAFTAR LAPORAN KASUS
    // =========================================================================
    public function kasus()
    {
        $filters = [
            'tahun'        => $this->request->getGet('tahun'),
            'bulan'        => $this->request->getGet('bulan'),
            'id_penyakit'  => $this->request->getGet('id_penyakit'),
            'komoditas'    => $this->request->getGet('komoditas'),
            'kecamatan_id' => $this->request->getGet('kecamatan_id')
        ];

        $data['title']          = "Monitoring Kasus Penyakit Ternak & Unggas";
        $data['kasus_list']     = $this->kasusModel->get_all($filters);
        $data['penyakit_list']  = $this->penyakitModel->get_all();
        $data['kecamatan_list'] = $this->wilayahModel->get_all_kecamatan();
        $data['komoditas_list'] = ['Sapi Potong', 'Sapi Perah', 'Kerbau', 'Kambing', 'Domba', 'Ayam Broiler', 'Ayam Layer', 'Ayam Kampung', 'Itik/Bebek'];
        $data['filters']        = $filters;

        return view('template/header', $data)
             . view('penyakit/v_kasus_index', $data)
             . view('template/footer');
    }

    public function kasus_add()
    {
        $petugasModel = new PetugasModel();
        $peternakModel= new PeternakModel();

        $data['title']          = "Tambah Laporan Kasus Penyakit";
        $data['penyakit_list']  = $this->penyakitModel->get_all();
        $data['kecamatan_list'] = $this->wilayahModel->get_all_kecamatan();
        $data['petugas_list']   = $petugasModel->get_all();
        $data['peternak_list']  = $peternakModel->get_all();
        $data['komoditas_list'] = ['Sapi Potong', 'Sapi Perah', 'Kerbau', 'Kambing', 'Domba', 'Ayam Broiler', 'Ayam Layer', 'Ayam Kampung', 'Itik/Bebek'];
        $data['auto_no_laporan']= 'KS-' . date('ym') . '-' . sprintf('%03d', rand(10, 999));

        return view('template/header', $data)
             . view('penyakit/v_kasus_form', $data)
             . view('template/footer');
    }

    public function kasus_store()
    {
        $rules = [
            'no_laporan'       => 'required|is_unique[trn_kasus_penyakit.no_laporan]',
            'id_penyakit'      => 'required|numeric',
            'komoditas'        => 'required',
            'kecamatan_id'     => 'required|numeric',
            'desa_id'          => 'required|numeric',
            'tanggal_kejadian' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Mohon lengkapi seluruh field wajib dengan benar.');
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();

        // Upload Foto jika ada
        $fotoName = null;
        $foto = $this->request->getFile('foto_gejala');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads/penyakit', $fotoName);
        }

        $data = [
            'no_laporan'             => $post['no_laporan'],
            'id_penyakit'            => $post['id_penyakit'],
            'komoditas'              => $post['komoditas'],
            'kecamatan_id'           => $post['kecamatan_id'],
            'desa_id'                => $post['desa_id'],
            'dusun'                  => $post['dusun'] ?? null,
            'id_peternak'            => !empty($post['id_peternak']) ? $post['id_peternak'] : null,
            'nama_peternak_manual'   => $post['nama_peternak_manual'] ?? null,
            'id_petugas'             => !empty($post['id_petugas']) ? $post['id_petugas'] : null,
            'tanggal_lapor'          => date('Y-m-d'),
            'tanggal_kejadian'       => $post['tanggal_kejadian'],
            'tanggal_selesai'        => !empty($post['tanggal_selesai']) ? $post['tanggal_selesai'] : null,
            'populasi_rentan'        => (int) ($post['populasi_rentan'] ?? 0),
            'jumlah_sakit'           => (int) ($post['jumlah_sakit'] ?? 1),
            'jumlah_sembuh'          => (int) ($post['jumlah_sembuh'] ?? 0),
            'jumlah_mati'            => (int) ($post['jumlah_mati'] ?? 0),
            'jumlah_potong_bersyarat'=> (int) ($post['jumlah_potong_bersyarat'] ?? 0),
            'status_kasus'           => $post['status_kasus'] ?? 'Suspek',
            'tindakan_penanganan'    => $post['tindakan_penanganan'] ?? null,
            'koordinat_gps'          => $post['koordinat_gps'] ?? null,
            'foto_gejala'            => $fotoName,
            'keterangan'             => $post['keterangan'] ?? null,
            'created_by'             => session()->get('user_id')
        ];

        $this->kasusModel->insert($data);
        session()->setFlashdata('success', 'Laporan kasus berhasil disimpan.');
        return redirect()->to(base_url('penyakit/kasus'));
    }

    public function kasus_edit($id)
    {
        $kasus = $this->kasusModel->get_by_id($id);
        if (!$kasus) {
            session()->setFlashdata('error', 'Data kasus tidak ditemukan.');
            return redirect()->to(base_url('penyakit/kasus'));
        }

        $petugasModel = new PetugasModel();
        $peternakModel= new PeternakModel();

        $data['title']          = "Edit Laporan Kasus: " . $kasus->no_laporan;
        $data['kasus']          = $kasus;
        $data['penyakit_list']  = $this->penyakitModel->get_all();
        $data['kecamatan_list'] = $this->wilayahModel->get_all_kecamatan();
        $data['desa_list']      = $this->wilayahModel->get_desa_by_kecamatan($kasus->kecamatan_id);
        $data['petugas_list']   = $petugasModel->get_all();
        $data['peternak_list']  = $peternakModel->get_all();
        $data['komoditas_list'] = ['Sapi Potong', 'Sapi Perah', 'Kerbau', 'Kambing', 'Domba', 'Ayam Broiler', 'Ayam Layer', 'Ayam Kampung', 'Itik/Bebek'];

        return view('template/header', $data)
             . view('penyakit/v_kasus_form', $data)
             . view('template/footer');
    }

    public function kasus_update($id)
    {
        $kasus = $this->kasusModel->find($id);
        if (!$kasus) {
            session()->setFlashdata('error', 'Data kasus tidak ditemukan.');
            return redirect()->to(base_url('penyakit/kasus'));
        }

        $post = $this->request->getPost();

        $data = [
            'id_penyakit'            => $post['id_penyakit'],
            'komoditas'              => $post['komoditas'],
            'kecamatan_id'           => $post['kecamatan_id'],
            'desa_id'                => $post['desa_id'],
            'dusun'                  => $post['dusun'] ?? null,
            'id_peternak'            => !empty($post['id_peternak']) ? $post['id_peternak'] : null,
            'nama_peternak_manual'   => $post['nama_peternak_manual'] ?? null,
            'id_petugas'             => !empty($post['id_petugas']) ? $post['id_petugas'] : null,
            'tanggal_kejadian'       => $post['tanggal_kejadian'],
            'tanggal_selesai'        => !empty($post['tanggal_selesai']) ? $post['tanggal_selesai'] : null,
            'populasi_rentan'        => (int) ($post['populasi_rentan'] ?? 0),
            'jumlah_sakit'           => (int) ($post['jumlah_sakit'] ?? 1),
            'jumlah_sembuh'          => (int) ($post['jumlah_sembuh'] ?? 0),
            'jumlah_mati'            => (int) ($post['jumlah_mati'] ?? 0),
            'jumlah_potong_bersyarat'=> (int) ($post['jumlah_potong_bersyarat'] ?? 0),
            'status_kasus'           => $post['status_kasus'] ?? 'Suspek',
            'tindakan_penanganan'    => $post['tindakan_penanganan'] ?? null,
            'koordinat_gps'          => $post['koordinat_gps'] ?? null,
            'keterangan'             => $post['keterangan'] ?? null
        ];

        // Upload Foto baru jika ada
        $foto = $this->request->getFile('foto_gejala');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads/penyakit', $fotoName);
            $data['foto_gejala'] = $fotoName;
        }

        $this->kasusModel->update($id, $data);
        session()->setFlashdata('success', 'Data kasus berhasil diperbarui.');
        return redirect()->to(base_url('penyakit/kasus'));
    }

    public function kasus_detail($id)
    {
        $kasus = $this->kasusModel->get_by_id($id);
        if (!$kasus) {
            session()->setFlashdata('error', 'Data kasus tidak ditemukan.');
            return redirect()->to(base_url('penyakit/kasus'));
        }

        $data['title'] = "Rincian Kasus: " . $kasus->no_laporan;
        $data['kasus'] = $kasus;

        return view('template/header', $data)
             . view('penyakit/v_kasus_detail', $data)
             . view('template/footer');
    }

    public function kasus_delete($id)
    {
        $this->kasusModel->delete($id);
        session()->setFlashdata('success', 'Data kasus berhasil dihapus.');
        return redirect()->to(base_url('penyakit/kasus'));
    }

    // =========================================================================
    // 3. MASTER PENYAKIT & HELPER AJAX
    // =========================================================================
    public function master()
    {
        $data['title']         = "Katalog Penyakit Hewan Menular Strategis (PHMS)";
        $data['penyakit_list'] = $this->penyakitModel->get_all();

        return view('template/header', $data)
             . view('penyakit/v_master_index', $data)
             . view('template/footer');
    }

    public function ajax_get_desa_by_kecamatan($kecamatan_id)
    {
        $desaList = $this->wilayahModel->get_desa_by_kecamatan($kecamatan_id);
        return $this->response->setJSON($desaList);
    }
}
