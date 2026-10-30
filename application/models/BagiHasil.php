<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BagiHasil extends CI_Model
{
    public function data($tahun)
    {
        return $this->db->get_where('v_bagi_hasil', array('tahun' => $tahun));
    }
}
