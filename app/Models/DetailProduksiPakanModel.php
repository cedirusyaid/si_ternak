<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailProduksiPakanModel extends Model
{
    protected $table      = 'detail_produksi_pakan';
    protected $primaryKey = 'id_detail'; // wait, it might not have an auto inc primary key, but let's check its schema.

    protected $returnType     = 'object';
    protected $allowedFields = ['id_laporan', 'id_jenis_pakan', 'jumlah_produksi'];

    public function get_by_laporan($id_laporan)
    {
        $builder = $this->builder();
        $builder->select('detail_produksi_pakan.*, jenis_pakan.nama_jenis');
        $builder->join('jenis_pakan', 'detail_produksi_pakan.id_jenis_pakan = jenis_pakan.id_jenis_pakan');
        $builder->where('id_laporan', $id_laporan);
        return $builder->get()->getResult();
    }

    public function delete_by_laporan($id_laporan)
    {
        return $this->where('id_laporan', $id_laporan)->delete();
    }
}
