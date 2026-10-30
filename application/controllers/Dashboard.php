<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth'));
        }
    }
    public function index()
    {
        $no_rekening = $this->session->userdata('username');

        $data['title'] = 'IAA Investment | Dashboard';

        $this->load->view('header', $data);

        if ($this->session->userdata('role') != 'user') {
            $this->load->view('menu');
            $this->load->view('dashboard');
        } else {
            $this->load->view('client/menu');
            $this->load->view('client/dashboard', $data);
        }
        $this->load->view('footer');
    }
}
