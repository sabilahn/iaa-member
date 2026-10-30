<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Copy_of_surat_saham extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->config->load('api', FALSE, TRUE);
    }

    public function index()
    {
        $data['title'] = 'IAA Investment | Surat Saham';

        $this->load->view('header', $data);
        $this->load->view('client/menu');
        $this->load->view('client/surat_saham');
        $this->load->view('footer');
    }

    public function surat_saham()
    {
        $data['title'] = 'IAA Investment | Cetak Surat Saham';

        $baseUrl = getenv('IAA_API_URL') ?: ($this->config->item('iaa_api_url') ?: 'https://api.dharma-iaa.com/ws/admin/');
        $secretKey = getenv('IAA_SECRET_KEY') ?: ($this->config->item('iaa_secret_key') ?: '');

        $path = 'transaksiSaham/'. $_GET['no_sertifikat'];

        /* Endpoint */
        $url = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
   
        /* eCurl */
        $curl = curl_init($url);
            
        /* Define content type */
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'x-secret-key:' . $secretKey));
            
        /* Return json */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
        /* make request */
        $result = curl_exec($curl);
        
        /* close curl */
        curl_close($curl);

        $res = json_decode($result, true);

        // var_dump($data['no_rekening']);

        $data['data_transaksi'] = [
            'no_rekening' => $res[0]['no_rekening'],
            'nama' => $res[0]['nama'],
            'nik' => $res[0]['nik'],
            'tgl_lahir' => $res[0]['tgl_lahir'],
            'tgl_transaksi' => $res[0]['tgl_transaksi'],
            'jml_transaksi' => $res[0]['jml_transaksi'],
            'no_sertifikat' => $res[0]['no_sertifikat']
        ];

        // var_dump($data['no_rekening']);
        $this->load->library('cetak_pdf');

        $customPaper = array(0, 0, 771, 395);
        $this->cetak_pdf->set_paper($customPaper);
        $this->cetak_pdf->filename = "surat-saham-[" . $res[0]['no_rekening'] . "].pdf";
        $this->cetak_pdf->load_view('client/cetak_surat_saham', $data);
        // $this->load->view('client/cetak_surat_saham', $data);
    }
}
