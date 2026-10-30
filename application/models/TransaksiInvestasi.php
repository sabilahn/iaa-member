<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransaksiInvestasi extends CI_Model
{
    public function transaksi_list($tahun)
    {
        return $this->db->query("SELECT * FROM transaksi_investasi where year(tgl_transaksi) = '" . $tahun . "' and is_deleted = 0 order by created_at DESC");
    }
    public function jml_transaksi($no_rekening, $tahun)
    {
        return $this->db->query("SELECT jml_transaksi FROM v_transaksi_thn where no_rekening = '" . $no_rekening . "' and tahun = '" . $tahun . "'");
    }
    public function cekTransaksi($no_rekening, $tgl_transaksi)
    {
        return $this->db->query("SELECT * FROM transaksi_investasi WHERE no_rekening = '" . $no_rekening . "' AND tgl_transaksi = '" . $tgl_transaksi . "' AND is_deleted = 0");
    }
    public function countTransaksi($no_rekening, $tgl_transaksi)
    {
        return $this->db->query("SELECT COUNT(id_transaksi) AS banyak_transaksi FROM transaksi_investasi WHERE no_rekening = '" . $no_rekening . "' AND year(tgl_transaksi) = year('" . $tgl_transaksi . "')")->row();
    }
    public function cekSaldo($no_rekening, $tgl_transaksi)
    {
        return $this->db->query("SELECT * FROM saldo_harian WHERE no_rekening = '" . $no_rekening . "' AND tahun = year('" . $tgl_transaksi . "')");
    }
    function rekening_list()
    {
        return $this->db->query("SELECT no_rekening FROM client_account");
    }
    public function tambah($table, $data)
    {
        if ($this->db->insert($table, $data)) {
            return true;
        }
        return false;
    }
    public function edit($table, $data, $where)
    {
        if ($this->db->update($table, $data, $where)) {
            return true;
        }
        return false;
    }
    public function hapus($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function hapus_saldo($no_rekening, $tgl_transaksi)
    {
        return $this->db->query("DELETE FROM saldo_harian WHERE no_rekening = '" . $no_rekening . "' AND tahun = year('" . $tgl_transaksi . "')");
    }

    public function penarikan_list()
    {
        return $this->db->query("SELECT * FROM penarikan_investasi order by created_at DESC");
    }
    public function cekTransaksi2($no_rekening, $tahun)
    {
        return $this->db->query("SELECT * FROM transaksi_investasi WHERE no_rekening = '" . $no_rekening . "' AND year(tgl_transaksi) = '" . $tahun . "' AND is_deleted = 0");
    }
    public function getTransaksi($tahun)
    {
        return $this->db->query("SELECT * FROM v_transaksi_thn where jml_transaksi != '' and tahun = '" . $tahun . "'");
    }
    public function getWhere($table, $where)
    {
        return $this->db->get_where($table, $where);
    }
    public function getSertifikat($id_transaksi)
    {
        return $this->db->query("SELECT no_sertfikat FROM transaksi_investasi where id_transaksi = '" . $id_transaksi . "'");
    }
}
