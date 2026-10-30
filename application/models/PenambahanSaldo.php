<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenambahanSaldo extends CI_Model
{
    public function getUser()
    {
        return $this->db->query("SELECT no_rekening FROM client_account")->result_array();
    }
    public function getTransaksi($no_rekening, $tahun)
    {
        return $this->db->query("SELECT sum(jml_transaksi) as jml_transaksi FROM transaksi_investasi WHERE no_rekening = '" . $no_rekening . "' AND year(tgl_transaksi) = '" . $tahun . "'")->row();
    }
    public function getSaldo($no_rekening, $tahun)
    {
        return $this->db->query("SELECT rata_rata_harian FROM saldo_harian WHERE no_rekening = '" . $no_rekening . "' AND year(tgl_transaksi) = '" . $tahun . "'")->row();
    }
    public function updateRataHarian($data, $no_rekening, $tahun)
    {
        return $this->db->query("UPDATE saldo_harian SET rata_rata_harian = $data WHERE no_rekening = '" . $no_rekening . "' AND year(tgl_transaksi) = '" . $tahun . "'");
    }
    public function updateRataTahun($data, $no_rekening, $tahun)
    {
        return $this->db->query("UPDATE saldo_harian SET rata_rata_tahun = $data WHERE no_rekening = '" . $no_rekening . "' AND year(tgl_transaksi) = '" . $tahun . "'");
    }
}
