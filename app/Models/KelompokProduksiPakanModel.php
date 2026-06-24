<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokProduksiPakanModel extends Model
{
    protected $table      = 'kelompok_produksi_pakan';
    protected $primaryKey = 'id_kelompok';

    protected $returnType     = 'object';
    protected $allowedFields = ['id_kelompok', 'nama_kelompok', 'kecamatan', 'desa', 'alamat_lengkap', 'created_by', 'created_at'];

    public function get_all()
    {
        return $this->findAll();
    }
}
