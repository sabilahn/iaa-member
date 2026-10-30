<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saldo_client extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth'));
        }
    }

    public function investasi()
    {
        $data['title'] = 'IAA Investment | Saldo Investasi';

        $this->load->view('header', $data);
        $this->load->view('client/menu');
        $this->load->view('client/saldo_investasi');
        $this->load->view('footer');
    }

    public function rata_harian()
    {
        $no_rekening = $this->session->userdata('username');

        $data['title'] = 'IAA Investment | Saldo Rata-rata Harian';

        $this->load->view('header', $data);
        $this->load->view('client/menu');
        $this->load->view('client/saldo_rata_harian');
        $this->load->view('footer');
    }
}
