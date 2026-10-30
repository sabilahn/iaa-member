<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class ProfilPemegangSaham extends CI_Model
{
    public function profiles()
    {
        return $this->db->query("SELECT * FROM client_account");
    }

    public function cek($table, $no_rekening)
    {
        return $this->db->get_where($table, ['no_rekening' => $no_rekening])->row_array();
    }
    public function tambah($table, $data)
    {
        if ($this->db->insert($table, $data)) {
            return true;
        }
        return false;
    }
    public function edit_data($no_rekening)
    {
        return $this->db->get_where('client_account', ['no_rekening' => $no_rekening])->row_array();
    }
    public function ubah_anggota($where, $data)
    {
        if ($this->db->update('client_account', $data, $where)) {
            return true;
        }
        return false;
    }
    public function hapus_anggota($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}
