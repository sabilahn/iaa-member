<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Curl extends CI_Controller {
    public function __construct() {
       parent::__construct();
       $this->config->load('api', FALSE, TRUE);
    }
   
    public function getRequest()
    {
        $path = $_POST['path'];
        // $path = 'saldoInvestasi/1887-0001';

        // echo($path);

        $baseUrl = getenv('IAA_API_URL') ?: ($this->config->item('iaa_api_url') ?: 'https://api.dharma-iaa.com/ws/admin/');
        $secretKey = getenv('IAA_SECRET_KEY') ?: ($this->config->item('iaa_secret_key') ?: '');

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

        $data = json_decode($result, true);

        echo json_encode($data);
    }

}
