<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    private $width_captcha = 200;
    private $height_captcha = 50;
    // private $permitted_chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    private $permitted_chars = '23456789abcdefghijkmnpqrstuvwxyz';
    private $setting;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("LoginModel");
    }

    public function index()
    {
        if ($this->LoginModel->logged_id()) {
            redirect(base_url('dashboard'));
        }

        $this->load->view('users/login');
    }

    public function login()
    {
        $username = $this->input->post('username', TRUE);
        // $name = $this->input->post('name', TRUE);
        $userpass = MD5($this->input->post('userpass', TRUE));
        $captcha = $this->input->post('captcha', TRUE);

        $cek = $this->LoginModel->cek_login('user_account', array('username' => $username), array('userpass' => $userpass));

        // var_dump($cek, $userpass, $this->input->post('userpass', TRUE));

        if (!$cek == FALSE) {
            if ($captcha == $this->session->userdata('captcha')) {
                foreach ($cek as $auth) {
                    $session_data = array(
                        'user_id' => $auth->user_id,
                        'username' => $auth->username,
                        // 'name' => $name,
                        'userpass' => $auth->userpass,
                        'role' => $auth->role,
                        'status' => 'login'
                    );

                    // $activity_data = array(
                    //     'user_id' => $auth->user_id,
                    //     'activity' => 'Login Berhasil',
                    //     'times' => date('Y-m-d H:i:s')
                    // );

                    // $this->LoginModel->tambah('activity_log', $activity_data);

                    $this->session->set_userdata($session_data);

                    $result["error"] = "";
                    $result["success"] = base_url("dashboard");
                    echo json_encode($result);
                }
            } else {
                $result["error"] = "captcha";
                $result["success"] = base_url("auth");
                echo json_encode($result);
            }
        } else {
            $result["error"] = "pass";
            $result["success"] = base_url("auth");
            echo json_encode($result);
        }
    }

    public function ubah_password()
    {
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth'));
        } else {
            $this->load->view('users/ubah_pass');
        }
    }

    public function update_password()
    {
        $this->db->trans_begin();
        try {
            $session_id = $this->session->userdata('user_id');
            $session_pass = $this->session->userdata('userpass');

            $this->form_validation->set_rules('o_userpass', 'Password Lama', 'required|trim');
            $this->form_validation->set_rules('n_userpass', 'Pasrword Baru', 'required|trim|matches[c_userpass]');
            $this->form_validation->set_rules('c_userpass', 'Konfirmasi Password Baru', 'required|trim|matches[n_userpass]');

            $o_userpass = md5($this->input->post('o_userpass'));
            $n_userpass = $this->input->post('n_userpass');

            if ($this->form_validation->run() == true) {
                if ($o_userpass == $session_pass) {
                    $userpass = array('userpass' => md5($n_userpass));
                    $where = array('user_id' => $session_id);
                    $this->LoginModel->ubah_password($where, $userpass);

                    // $activity_data = array(
                    //     'user_id' => $this->session->userdata('user_id'),
                    //     'activity' => 'Ubah Password Berhasil',
                    //     'times' => date('Y-m-d H:i:s')
                    // );

                    // $this->LoginModel->tambah('activity_log', $activity_data);
                    $this->db->trans_commit();
                    redirect(base_url('auth/logout'));
                } else {
                    $this->session->set_flashdata('error1', 'Password lama salah!');
                    $this->load->view('users/ubah_pass');
                }
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan! Pastikan input anda benar!');
                $this->load->view('users/ubah_pass');
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            redirect(base_url('dashboard'));
        }
    }

    public function logout()
    {
        // $activity_data = array(
        //     'user_id' => $this->session->userdata('user_id'),
        //     'activity' => 'Logout',
        //     'times' => date('Y-m-d H:i:s')
        // );

        // $this->LoginModel->tambah('activity_log', $activity_data);

        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }
    
    public function captcha()
    {
        $image = $this->generate_image_background();
        $this->generate_noise($image);
        $captchaString = $this->generate_string();
        $this->session->set_userdata("captcha", $captchaString);
        $this->generate_text_image($image, $captchaString);
        header("Content-type: image/png");
        return imagepng($image);
    }

    private function generate_string($strength = 6)
    {

        $input_length = strlen($this->permitted_chars);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $this->permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

    private function generate_image_background()
    {
        $image = imagecreate($this->width_captcha, $this->height_captcha);
        imagecolorallocate($image, 255, 255, 255);
        return $image;
    }

    private function generate_noise($image)
    {
        $noise_color = imagecolorallocate($image, 89, 101, 240);
        $this->generate_ellipse($image, $noise_color);
        $this->generate_line($image, $noise_color);
    }

    private function generate_ellipse($image, $color)
    {
        for ($i = 0; $i < 25; $i++) {
            imagefilledellipse(
                $image,
                mt_rand(0, $this->width_captcha),
                mt_rand(0, $this->height_captcha),
                5,
                5,
                $color
            );
        }
    }

    private function generate_line($image, $color)
    {
        for ($i = 0; $i < mt_rand(1, 3); $i++) {
            imageline(
                $image,
                mt_rand(0, $this->width_captcha),
                mt_rand(0, $this->height_captcha),
                mt_rand(0, $this->width_captcha),
                mt_rand(0, $this->height_captcha),
                $color
            );
        }
    }

    private function generate_text_image($image, $captcha_string)
    {
        $text_color = imagecolorallocate($image, 89, 101, 240);
        $fonts = [
            dirname(__FILE__) . "/../../assets/fonts/Ubuntu.ttf",
            dirname(__FILE__) . "/../../assets/fonts/Merriweather.ttf",
            dirname(__FILE__) . "/../../assets/fonts/PlayfairDisplay.ttf",
        ];

        for ($i = 0; $i < strlen($captcha_string); $i++) {
            $charPos = (int)(175 / strlen($captcha_string)) * $i + 15;
            imagettftext($image, 20, 0, $charPos, mt_rand(30, 40), $text_color, $fonts[mt_rand(0, 2)], $captcha_string[$i]);
        }
    }
}
