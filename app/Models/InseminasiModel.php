<?php

namespace App\Models;

use CodeIgniter\Model;

class InseminasiModel extends Model
{
    protected $table      = 'inseminasi';
    protected $primaryKey = 'id_ib';
    protected $returnType = 'object';

    //============================================
    // INSEMINASI
    //============================================

    public function get_inseminasi($id = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('inseminasi');
        $builder->select('inseminasi.*, hewan.nama_hewan, peternak.id_peternak, peternak.nama_peternak, peternak.alamat, peternak.desa as peternak_desa, peternak.kecamatan as peternak_kecamatan, petugas_lapangan.nama_petugas, users.nama_lengkap as nama_pembuat');
        $builder->join('hewan', 'hewan.id_hewan = inseminasi.id_hewan', 'left');
        $builder->join('peternak', 'peternak.id_peternak = hewan.id_peternak', 'left');
        $builder->join('petugas_lapangan', 'petugas_lapangan.id_petugas = inseminasi.id_petugas', 'left');
        $builder->join('users', 'users.id = inseminasi.created_by', 'left');
        if ($id) {
            $builder->where('inseminasi.id_ib', $id);
            return $builder->get()->getRow();
        }
        $builder->orderBy('inseminasi.tanggal_ib', 'DESC');
        return $builder->get()->getResult();
    }

    public function insert_inseminasi($data)
    {
        $db = \Config\Database::connect();
        return $db->table('inseminasi')->insert($data);
    }

    public function update_inseminasi($id, $data)
    {
        $db = \Config\Database::connect();
        return $db->table('inseminasi')->where('id_ib', $id)->update($data);
    }

    public function delete_inseminasi($id)
    {
        $db = \Config\Database::connect();
        return $db->table('inseminasi')->where('id_ib', $id)->delete();
    }

    //============================================
    // KELAHIRAN
    //============================================

    public function get_kelahiran($id = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('kelahiran');
        $builder->select('kelahiran.*, hewan.nama_hewan, peternak.nama_peternak, petugas_lapangan.nama_petugas');
        $builder->join('hewan', 'hewan.id_hewan = kelahiran.id_hewan', 'left');
        $builder->join('peternak', 'peternak.id_peternak = hewan.id_peternak', 'left');
        $builder->join('petugas_lapangan', 'petugas_lapangan.id_petugas = kelahiran.id_petugas', 'left');
        if ($id) {
            $builder->where('kelahiran.id_laporan', $id);
            return $builder->get()->getRow();
        }
        $builder->orderBy('kelahiran.tgl_laporan', 'DESC');
        return $builder->get()->getResult();
    }

    public function insert_kelahiran($data)
    {
        $db = \Config\Database::connect();
        return $db->table('kelahiran')->insert($data);
    }

    public function update_kelahiran($id, $data)
    {
        $db = \Config\Database::connect();
        return $db->table('kelahiran')->where('id_laporan', $id)->update($data);
    }

    public function delete_kelahiran($id)
    {
        $db = \Config\Database::connect();
        return $db->table('kelahiran')->where('id_laporan', $id)->delete();
    }

    //============================================
    // PEMERIKSAAN KEBUNTINGAN (PKB)
    //============================================

    public function get_pkb($id = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pemeriksaan_kebuntingan');
        $builder->select('pemeriksaan_kebuntingan.*, hewan.nama_hewan, peternak.nama_peternak, petugas_lapangan.nama_petugas');
        $builder->join('hewan', 'hewan.id_hewan = pemeriksaan_kebuntingan.id_hewan', 'left');
        $builder->join('peternak', 'peternak.id_peternak = hewan.id_peternak', 'left');
        $builder->join('petugas_lapangan', 'petugas_lapangan.id_petugas = pemeriksaan_kebuntingan.id_petugas', 'left');
        if ($id) {
            $builder->where('pemeriksaan_kebuntingan.id_pkb', $id);
            return $builder->get()->getRow();
        }
        $builder->orderBy('pemeriksaan_kebuntingan.tanggal_pkb', 'DESC');
        return $builder->get()->getResult();
    }

    public function insert_pkb($data)
    {
        $db = \Config\Database::connect();
        return $db->table('pemeriksaan_kebuntingan')->insert($data);
    }

    public function update_pkb($id, $data)
    {
        $db = \Config\Database::connect();
        return $db->table('pemeriksaan_kebuntingan')->where('id_pkb', $id)->update($data);
    }

    public function delete_pkb($id)
    {
        $db = \Config\Database::connect();
        return $db->table('pemeriksaan_kebuntingan')->where('id_pkb', $id)->delete();
    }

    //============================================
    // HELPERS (untuk dropdown form)
    //============================================

    public function get_list_hewan()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('hewan');
        $builder->select('id_hewan, nama_hewan');
        $builder->where('jenis_kelamin', 'betina');
        $builder->where('status', 'aktif');
        return $builder->get()->getResult();
    }

    public function get_list_petugas()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('petugas_lapangan');
        $builder->select('id_petugas, nama_petugas');
        $builder->where('is_active', 1);
        return $builder->get()->getResult();
    }
}
