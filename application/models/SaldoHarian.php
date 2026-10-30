<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SaldoHarian extends CI_Model
{
    public function saldo_harian_list($tahun)
    {
        return $this->db->query("SELECT * FROM v_saldo_harian WHERE tahun = '" . $tahun . "'");
    }
}
