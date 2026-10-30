<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuratSaham extends CI_Model
{
    public function getData($where)
    {
        return $this->db->get_where('v_transaksi', $where);
    }
}
