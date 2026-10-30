<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginModel extends CI_Model
{
    public function logged_id()
    {
        return $this->session->userdata('user_id');
    }

    public function cek_login($table, $username, $userpass)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($username);
        $this->db->where($userpass);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    public function tambah($table, $data)
    {
        if ($this->db->insert($table, $data)) {
            return true;
        }
        return false;
    }

    public function ubah_password($where, $data)
    {
        if ($this->db->update('user_account', $data, $where)) {
            return true;
        }
        return false;
    }

    public function user_list()
    {
        return $this->db->query("SELECT * FROM user_account")->result_array();
    }

    public function activity_list()
    {
        return $this->db->query("SELECT * FROM v_activity")->result_array();
    }
}
