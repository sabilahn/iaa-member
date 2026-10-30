<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bagi_hasil extends CI_Controller
{
    var $no_rekening;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('BagiHasil');
        $this->load->model('TransaksiInvestasi');
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth'));
        }

        $this->no_rekening = $this->session->userdata('username');
    }

    public function dividen()
    {
        $data['title'] = 'IAA Investment | Dividen Persero';

        $this->load->view('header', $data);
        $this->load->view('client/menu');
        $this->load->view('client/dividen_persero');
        $this->load->view('footer');
    }
}
