<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanModel extends CI_Model
{

    public function getUsers()
    {
        return $this->db->query("SELECT * FROM client_account");
    }
    public function getKec()
    {
        return $this->db->query("SELECT kec FROM v_bagi_hasil group by kec order by kec ASC");
    }
    public function getData($table, $tahun)
    {
        return $this->db->get_where($table, $tahun);
    }
    public function getDataTransaksiBln($bulan, $tahun)
    {
        return $this->db->query("SELECT * FROM v_transaksi
        WHERE month(tgl_transaksi) = '" . $bulan . "' AND year(tgl_transaksi) = '" . $tahun . "' AND is_deleted = 0");
    }
    public function getDataTransaksiTerknini($tgl_awal, $tgl_akhir)
    {
        return $this->db->query("SELECT * FROM v_transaksi
        WHERE tgl_transaksi BETWEEN '" . $tgl_awal . "' and '" . $tgl_akhir . "' AND is_deleted = 0");
    }
    public function tambah($table, $data)
    {
        if ($this->db->insert($table, $data)) {
            return true;
        }
        return false;
    }
}
