<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DistribusiDanPorsi extends CI_Model
{
    public function show($table, $tahun)
    {
        return $this->db->get_where($table, array('tahun' => $tahun));
    }
}
