<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SisaHasilUsaha extends CI_Model
{
    public function shu_list()
    {
        return $this->db->query("SELECT * FROM sisa_hasil_usaha");
    }
    public function cek($tahun)
    {
        return $this->db->query("SELECT * FROM sisa_hasil_usaha WHERE tahun = '" . $tahun . "'");
    }
    public function cek1($tahun)
    {
        return $this->db->query("SELECT * FROM saldo_harian WHERE year(created_at) = '" . $tahun . "'");
    }
    public function tambah($data, $table)
    {
        if ($this->db->insert($table, $data)) {
            return true;
        }
        return false;
    }
    public function getUser()
    {
        return $this->db->query("SELECT no_rekening, nama FROM client_account")->result_array();
    }
    public function getTotalSaldoHarian($tahun)
    {
        return $this->db->query("SELECT sum(rata_rata_harian) as total_rata_rata_harian FROM saldo_harian WHERE year(created_at) = '" . $tahun . "'")->row();
    }
    public function getSaldoHarian($no_rekening, $tahun)
    {
        return $this->db->query("SELECT rata_rata_harian FROM saldo_harian WHERE no_rekening = '" . $no_rekening . "' AND year(created_at) = '" . $tahun . "'")->row();
    }
    // public function getTransaksi($no_rekening, $tahun)
    // {
    //     return $this->db->query("SELECT sum(jml_transaksi) as jml_transaksi FROM transaksi_investasi WHERE no_rekening = '" . $no_rekening . "'AND year(tgl_transaksi) = '" . $tahun . "'")->row();
    // }
    public function edit($table, $data, $where)
    {
        if ($this->db->update($table, $data, $where)) {
            return true;
        }
        return false;
    }
    public function hapus($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}
