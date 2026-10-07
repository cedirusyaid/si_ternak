<?php

namespace App\Models;

use CodeIgniter\Model;

class KasusPenyakitModel extends Model
{
    protected $table            = 'trn_kasus_penyakit';
    protected $primaryKey       = 'id_kasus';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'no_laporan',
        'id_penyakit',
        'komoditas',
        'desa_id',
        'kecamatan_id',
        'dusun',
        'id_peternak',
        'nama_peternak_manual',
        'id_petugas',
        'tanggal_lapor',
        'tanggal_kejadian',
        'tanggal_selesai',
        'populasi_rentan',
        'jumlah_sakit',
        'jumlah_sembuh',
        'jumlah_mati',
        'jumlah_potong_bersyarat',
        'status_kasus',
        'tindakan_penanganan',
        'koordinat_gps',
        'foto_gejala',
        'keterangan',
        'created_by'
    ];

    // Mengambil daftar kasus dengan join lengkap
    public function get_all($filters = [])
    {
        $builder = $this->builder();
        $builder->select('trn_kasus_penyakit.*, mst_penyakit.nama_penyakit, mst_penyakit.kode_penyakit, mst_penyakit.sifat_zoonosis, mst_penyakit.warna_marker, kode_desa.desa_nama, kode_kecamatan.kecamatan_nama, petugas_lapangan.nama_petugas');
        $builder->join('mst_penyakit', 'mst_penyakit.id_penyakit = trn_kasus_penyakit.id_penyakit', 'left');
        $builder->join('kode_desa', 'kode_desa.desa_id = trn_kasus_penyakit.desa_id', 'left');
        $builder->join('kode_kecamatan', 'kode_kecamatan.kecamatan_id = trn_kasus_penyakit.kecamatan_id', 'left');
        $builder->join('petugas_lapangan', 'petugas_lapangan.id_petugas = trn_kasus_penyakit.id_petugas', 'left');

        if (!empty($filters['tahun'])) {
            $builder->where('YEAR(trn_kasus_penyakit.tanggal_kejadian)', $filters['tahun']);
        }
        if (!empty($filters['bulan'])) {
            $builder->where('MONTH(trn_kasus_penyakit.tanggal_kejadian)', $filters['bulan']);
        }
        if (!empty($filters['id_penyakit']) && $filters['id_penyakit'] !== 'all') {
            $builder->where('trn_kasus_penyakit.id_penyakit', $filters['id_penyakit']);
        }
        if (!empty($filters['komoditas']) && $filters['komoditas'] !== 'all') {
            $builder->where('trn_kasus_penyakit.komoditas', $filters['komoditas']);
        }
        if (!empty($filters['kecamatan_id']) && $filters['kecamatan_id'] !== 'all') {
            $builder->where('trn_kasus_penyakit.kecamatan_id', $filters['kecamatan_id']);
        }

        $builder->orderBy('trn_kasus_penyakit.tanggal_kejadian', 'DESC');
        return $builder->get()->getResult();
    }

    public function get_by_id($id)
    {
        $builder = $this->builder();
        $builder->select('trn_kasus_penyakit.*, mst_penyakit.nama_penyakit, mst_penyakit.kode_penyakit, mst_penyakit.nama_ilmiah, mst_penyakit.sifat_zoonosis, mst_penyakit.prosedur_darurat, kode_desa.desa_nama, kode_kecamatan.kecamatan_nama, petugas_lapangan.nama_petugas, peternak.nama_peternak as nama_peternak_db');
        $builder->join('mst_penyakit', 'mst_penyakit.id_penyakit = trn_kasus_penyakit.id_penyakit', 'left');
        $builder->join('kode_desa', 'kode_desa.desa_id = trn_kasus_penyakit.desa_id', 'left');
        $builder->join('kode_kecamatan', 'kode_kecamatan.kecamatan_id = trn_kasus_penyakit.kecamatan_id', 'left');
        $builder->join('petugas_lapangan', 'petugas_lapangan.id_petugas = trn_kasus_penyakit.id_petugas', 'left');
        $builder->join('peternak', 'peternak.id_peternak = trn_kasus_penyakit.id_peternak', 'left');
        $builder->where('trn_kasus_penyakit.id_kasus', $id);
        return $builder->get()->getRow();
    }

    // Mengambil agregat per desa untuk GeoJSON Spasio-Temporal
    public function get_desa_timeline_aggregates($tahun, $bulan, $id_penyakit = 'all', $komoditas = 'all')
    {
        $db = \Config\Database::connect();
        
        // Ambil semua desa dan poligon WKT
        $desaBuilder = $db->table('kode_desa');
        $desaBuilder->select('kode_desa.desa_id, kode_desa.desa_nama, kode_desa.kecamatan_id, kode_desa.wkt, kode_kecamatan.kecamatan_nama');
        $desaBuilder->join('kode_kecamatan', 'kode_kecamatan.kecamatan_id = kode_desa.kecamatan_id', 'left');
        $desaList = $desaBuilder->get()->getResult();

        // Ambil data kasus pada periode tahun & bulan tersebut
        $kasusBuilder = $db->table('trn_kasus_penyakit');
        $kasusBuilder->select('trn_kasus_penyakit.*, mst_penyakit.nama_penyakit, mst_penyakit.kode_penyakit');
        $kasusBuilder->join('mst_penyakit', 'mst_penyakit.id_penyakit = trn_kasus_penyakit.id_penyakit', 'left');
        
        // Filter timeline: kasus aktif di bulan terpilih (tanggal kejadian <= akhir bulan && (tanggal_selesai is null atau >= awal bulan))
        $startDate = sprintf('%04d-%02d-01', $tahun, $bulan);
        $endDate   = date('Y-m-t', strtotime($startDate));

        $kasusBuilder->where('trn_kasus_penyakit.tanggal_kejadian <=', $endDate);
        $kasusBuilder->groupStart()
            ->where('trn_kasus_penyakit.tanggal_selesai IS NULL', null, false)
            ->orWhere('trn_kasus_penyakit.tanggal_selesai >=', $startDate)
        ->groupEnd();

        if (!empty($id_penyakit) && $id_penyakit !== 'all') {
            $kasusBuilder->where('trn_kasus_penyakit.id_penyakit', $id_penyakit);
        }
        if (!empty($komoditas) && $komoditas !== 'all') {
            $kasusBuilder->where('trn_kasus_penyakit.komoditas', $komoditas);
        }

        $kasusList = $kasusBuilder->get()->getResult();

        // Kelompokkan kasus berdasarkan desa_id
        $kasusByDesa = [];
        foreach ($kasusList as $k) {
            $dId = $k->desa_id;
            if (!isset($kasusByDesa[$dId])) {
                $kasusByDesa[$dId] = [
                    'total_sakit'   => 0,
                    'total_sembuh'  => 0,
                    'total_mati'    => 0,
                    'total_potong'  => 0,
                    'kasus_aktif'   => 0,
                    'daftar_kasus'  => []
                ];
            }
            $kasusByDesa[$dId]['total_sakit']  += $k->jumlah_sakit;
            $kasusByDesa[$dId]['total_sembuh'] += $k->jumlah_sembuh;
            $kasusByDesa[$dId]['total_mati']   += $k->jumlah_mati;
            $kasusByDesa[$dId]['total_potong'] += $k->jumlah_potong_bersyarat;
            
            $aktif = max(0, $k->jumlah_sakit - ($k->jumlah_sembuh + $k->jumlah_mati + $k->jumlah_potong_bersyarat));
            $kasusByDesa[$dId]['kasus_aktif']  += $aktif;
            
            $kasusByDesa[$dId]['daftar_kasus'][] = [
                'penyakit'     => $k->nama_penyakit,
                'komoditas'    => $k->komoditas,
                'sakit'        => $k->jumlah_sakit,
                'aktif'        => $aktif,
                'status'       => $k->status_kasus,
                'tgl_kejadian' => $k->tanggal_kejadian
            ];
        }

        return [
            'desa_list'     => $desaList,
            'kasus_by_desa' => $kasusByDesa
        ];
    }
}
