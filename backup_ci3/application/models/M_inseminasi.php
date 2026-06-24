<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_inseminasi extends CI_Model {

    //============================================
    // INSEMINASI
    //============================================

    public function get_inseminasi($id = null)
    {
        $this->db->select('inseminasi.*, hewan.nama_hewan, peternak.nama_peternak, petugas_lapangan.nama_petugas');
        $this->db->from('inseminasi');
        $this->db->join('hewan', 'hewan.id_hewan = inseminasi.id_hewan', 'left');
        $this->db->join('peternak', 'peternak.id_peternak = hewan.id_peternak', 'left');
        $this->db->join('petugas_lapangan', 'petugas_lapangan.id_petugas = inseminasi.id_petugas', 'left');
        if ($id) {
            $this->db->where('inseminasi.id_ib', $id);
            return $this->db->get()->row();
        }
        $this->db->order_by('inseminasi.tanggal_ib', 'DESC');
        return $this->db->get()->result();
    }

    public function insert_inseminasi($data)
    {
        return $this->db->insert('inseminasi', $data);
    }

    public function update_inseminasi($id, $data)
    {
        $this->db->where('id_ib', $id);
        return $this->db->update('inseminasi', $data);
    }

    public function delete_inseminasi($id)
    {
        $this->db->where('id_ib', $id);
        return $this->db->delete('inseminasi');
    }

    //============================================
    // KELAHIRAN
    //============================================

    public function get_kelahiran($id = null)
    {
        $this->db->select('kelahiran.*, hewan.nama_hewan, peternak.nama_peternak, petugas_lapangan.nama_petugas');
        $this->db->from('kelahiran');
        $this->db->join('hewan', 'hewan.id_hewan = kelahiran.id_hewan', 'left');
        $this->db->join('peternak', 'peternak.id_peternak = hewan.id_peternak', 'left');
        $this->db->join('petugas_lapangan', 'petugas_lapangan.id_petugas = kelahiran.id_petugas', 'left');
        if ($id) {
            $this->db->where('kelahiran.id_laporan', $id);
            return $this->db->get()->row();
        }
        $this->db->order_by('kelahiran.tgl_laporan', 'DESC');
        return $this->db->get()->result();
    }

    public function insert_kelahiran($data)
    {
        return $this->db->insert('kelahiran', $data);
    }

    public function update_kelahiran($id, $data)
    {
        $this->db->where('id_laporan', $id);
        return $this->db->update('kelahiran', $data);
    }

    public function delete_kelahiran($id)
    {
        $this->db->where('id_laporan', $id);
        return $this->db->delete('kelahiran');
    }

    //============================================
    // PEMERIKSAAN KEBUNTINGAN (PKB)
    //============================================

    public function get_pkb($id = null)
    {
        $this->db->select('pemeriksaan_kebuntingan.*, hewan.nama_hewan, peternak.nama_peternak, petugas_lapangan.nama_petugas');
        $this->db->from('pemeriksaan_kebuntingan');
        $this->db->join('hewan', 'hewan.id_hewan = pemeriksaan_kebuntingan.id_hewan', 'left');
        $this->db->join('peternak', 'peternak.id_peternak = hewan.id_peternak', 'left');
        $this->db->join('petugas_lapangan', 'petugas_lapangan.id_petugas = pemeriksaan_kebuntingan.id_petugas', 'left');
        if ($id) {
            $this->db->where('pemeriksaan_kebuntingan.id_pkb', $id);
            return $this->db->get()->row();
        }
        $this->db->order_by('pemeriksaan_kebuntingan.tanggal_pkb', 'DESC');
        return $this->db->get()->result();
    }

    public function insert_pkb($data)
    {
        return $this->db->insert('pemeriksaan_kebuntingan', $data);
    }

    public function update_pkb($id, $data)
    {
        $this->db->where('id_pkb', $id);
        return $this->db->update('pemeriksaan_kebuntingan', $data);
    }

    public function delete_pkb($id)
    {
        $this->db->where('id_pkb', $id);
        return $this->db->delete('pemeriksaan_kebuntingan');
    }

    //============================================
    // HELPERS (untuk dropdown form)
    //============================================

    public function get_list_hewan()
    {
        $this->db->select('id_hewan, nama_hewan');
        $this->db->where('jenis_kelamin', 'betina');
        $this->db->where('status', 'aktif');
        return $this->db->get('hewan')->result();
    }

    public function get_list_petugas()
    {
        $this->db->select('id_petugas, nama_petugas');
        $this->db->where('is_active', 1);
        return $this->db->get('petugas_lapangan')->result();
    }
}
