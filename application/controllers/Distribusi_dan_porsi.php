<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Distribusi_dan_porsi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth'));
        }
    }
    public function index()
    {
        $data['title'] = 'IAA Investment | Distribusi dan Porsi';

        $this->load->view('header', $data);
        $this->load->view('client/menu');
        $this->load->view('client/distribusi_porsi', $data);
        $this->load->view('footer');
    }
}
