<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function index()
    {
        $this->load->view('login');
    }

    public function validation_login()
    {
        cek_ajax();
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_username' => form_error('username'),
                'err_password' => form_error('password')
            ];
            echo json_encode($params);
            die;
        } else {
            $this->to_login();
        }
    }

    private function to_login()
    {
        $username = htmlspecialchars($this->input->post('username'));
        $password = md5(sha1($this->input->post('password')));
        $user = $this->db->get_where('user', ['username' => $username])->row();

        if ($user) {
            if ($user->password == $password) {
                if ($user->is_active == 1) {
                    $data = [
                        'username' => $user->username,
                        'status' => $user->is_active,
                    ];
                    $this->session->set_userdata($data);
                    $params = [
                        'type' => 'result',
                        'status' => true,
                        'msg' => 'Login Success',
                        'redirect' => base_url('dashboard')
                    ];
                } else {
                    $params = [
                        'type' => 'result',
                        'status' => false,
                        'msg' => 'Account is not active'
                    ];
                }
            } else {
                $params = [
                    'type' => 'result',
                    'status' => false,
                    'msg' => 'Invalid Password'
                ];
            }
        } else {
            $params = [
                'type' => 'result',
                'status' => false,
                'msg' => 'Invalid Username'
            ];
        }

        echo json_encode($params);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
}
