<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
    public function index()
    {
        $data = [
            'title' => 'Settings',
            'user' => get_user(),
            'view' => 'user/index'
        ];
        $this->load->view('dashboard', $data);
    }

    public function first_validation()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[5]');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_name' => form_error('name'),
                'err_username' => form_error('username')
            ];
            echo json_encode($params);
            die;
        } else {
            $username = $this->input->post('username');
            $user = get_user();
            $username_already = $this->db->get_where('user', ['username' => $username, 'id !=' => $user->id])->num_rows();

            if ($username_already > 0) {
                $params = [
                    'type' => 'validation',
                    'err_username' => 'Username is already'
                ];
                echo json_encode($params);
                die;
            } else {
                $this->to_first_validation();
            }
        }
    }

    private function to_first_validation()
    {
        $user = get_user();
        $username = htmlspecialchars($this->input->post('username'));
        $name = htmlspecialchars($this->input->post('name'));

        $data = [
            'nama' => $name,
            'username' => $username
        ];
        $this->db->where('id', $user->id)->update('user', $data);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'type' => 'result',
                'status' => true,
                'msg' => 'Profil berhasil di perbarui'
            ];
        } else {
            $params = [
                'type' => 'result',
                'status' => false,
                'msg' => 'Profil gagal di perbarui'
            ];
        }
        echo json_encode($params);
    }

    public function validation_pass()
    {
        $this->form_validation->set_rules('old_pass', 'Old Password', 'required|trim');
        $this->form_validation->set_rules('new_pass', 'New Password', 'required|trim|min_length[5]|matches[repeat_new_pass]');
        $this->form_validation->set_rules('repeat_new_pass', 'Repeat New Password', 'required|trim|matches[new_pass]');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_old_pass' => form_error('old_pass'),
                'err_new_pass' => form_error('new_pass'),
                'err_repeat_new_pass' => form_error('repeat_new_pass')
            ];
            echo json_encode($params);
            die;
        } else {
            $user = get_user();
            $old_pass = md5(sha1($this->input->post('old_pass')));
            $new_pass = md5(sha1($this->input->post('new_pass')));


            if ($user->password == $old_pass) {
                if ($user->password != $new_pass) {
                    $this->to_change_password();
                } else {
                    $params = [
                        'type' => 'validation',
                        'err_new_pass' => 'The new password cannot be the same as the old password'
                    ];
                    echo json_encode($params);
                    die;
                }
            } else {
                $params = [
                    'type' => 'validation',
                    'err_old_pass' => 'Wrong Old Password'
                ];
                echo json_encode($params);
                die;
            }
        }
    }

    private function to_change_password()
    {
        $new_pass  = md5(sha1($this->input->post('new_pass')));
        $user = get_user();
        $this->db->set('password', $new_pass)->where('id', $user->id)->update('user');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'type' => 'result',
                'status' => true,
                'msg' => 'Password berhasil di perbarui'
            ];
        } else {
            $params = [
                'type' => 'result',
                'status' => false,
                'msg' => 'Password gagal di perbarui'
            ];
        }
        echo json_encode($params);
    }
}
