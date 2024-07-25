<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Ajax extends CI_Controller
{
    public function validation_role()
    {
        cek_ajax();
        $act = $this->input->post('act');
        if ($act == 'add') {
            $this->form_validation->set_rules('role', 'Nama Role', 'required|trim|is_unique[user_role.nama]');
            if ($this->form_validation->run() == false) {
                $params = [
                    'type' => 'validation',
                    'err_role' => form_error('role')
                ];
                echo json_encode($params);
                die;
            } else {
                $this->to_action_role();
            }
        } else if ($act == 'edit') {
            $role = htmlspecialchars($this->input->post('role'));
            $id = $this->input->post('id');
            $get_role = $this->db->get_where('user_role', ['nama' => $role, 'id !=' => $id])->num_rows();
            if ($get_role > 0) {
                $params = [
                    'type' => 'validation',
                    'err_role' => 'Nama Role is already available'
                ];
                echo json_encode($params);
                die;
            } else {
                $this->to_action_role();
            }
        } else {
            $params = [
                'type' => 'result',
                'status' => false,
                'msg' => 'Error to action data'
            ];
            echo json_encode($params);
        }
    }

    private function to_action_role()
    {
        $act = htmlspecialchars($this->input->post('act'));
        $role = htmlspecialchars($this->input->post('role'));
        switch ($act) {
            case 'add':
                $data = ['nama' => $role];
                $this->db->insert('user_role', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'type' => 'result',
                        'status' => true,
                        'msg' => 'Role baru berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'type' => 'result',
                        'status' => false,
                        'msg' => 'Role baru gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $id = htmlspecialchars($this->input->post('id'));
                $this->db->set('nama', $role)->where('id', $id)->update('user_role');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'type' => 'result',
                        'status' => true,
                        'msg' => 'Role berhasil di edit'
                    ];
                } else {
                    $params = [
                        'type' => 'result',
                        'status' => false,
                        'msg' => 'Role gagal di edit'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function delete_role()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('user_role');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Role berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Role gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function validation_user()
    {
        cek_ajax();
        $user = get_user();
        $act = $this->input->post('act');
        if ($act == 'add') {
            $this->form_validation->set_rules('nama', 'Nama', 'required|trim|min_length[5]');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[5]|is_unique[user.username]|alpha_dash');
            $this->form_validation->set_rules('new_pass', 'Password Baru', 'required|trim|min_length[5]|matches[repeat_pass]');
            $this->form_validation->set_rules('repeat_pass', 'Ulangi Password Baru', 'required|trim|matches[new_pass]');

            if ($this->form_validation->run() == false) {
                $params = [
                    'type' => 'validation',
                    'err_nama' => form_error('nama'),
                    'err_username' => form_error('username'),
                    'err_new_pass' => form_error('new_pass'),
                    'err_repeat_pass' => form_error('repeat_pass')
                ];
                echo json_encode($params);
            } else {
                $this->to_action_user($user, $act);
            }
        } else if ($act == 'edit') {
            $this->form_validation->set_rules('nama', 'Nama', 'required|trim|min_length[5]');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[5]|alpha_dash');
            $this->form_validation->set_rules('new_pass', 'Password Baru', 'required|trim|min_length[5]|matches[repeat_pass]');
            $this->form_validation->set_rules('repeat_pass', 'Ulangi Password Baru', 'required|trim|matches[new_pass]');
            if ($this->form_validation->run() == false) {
                $params = [
                    'type' => 'validation',
                    'err_nama' => form_error('nama'),
                    'err_username' => form_error('username'),
                    'err_new_pass' => form_error('new_pass'),
                    'err_repeat_pass' => form_error('repeat_pass')
                ];
                echo json_encode($params);
            } else {
                $username = htmlspecialchars($this->input->post('username'));
                $id = $this->input->post('id');
                $get_user = $this->db->get_where('user', ['username' => $username, 'id !=' => $id])->num_rows();
                if ($get_user > 0) {
                    $params = [
                        'type' => 'validation',
                        'err_username' => 'Username is already available'
                    ];
                } else {
                    $this->to_action_user($user, $act);
                }
            }
        } else {
            $params = [
                'status' => false,
                'type' => 'result',
                'msg' => 'Invalid action'
            ];
            echo json_encode($params);
            die;
        }
    }

    private function to_action_user($user, $act)
    {
        switch ($act) {
            case 'add':
                $data = [
                    'nama' => htmlspecialchars($this->input->post('nama')),
                    'username' => htmlspecialchars($this->input->post('username')),
                    'password' => md5(sha1($this->input->post('new_pass'))),
                    'is_active' => 1,
                    'id_role' => htmlspecialchars($this->input->post('role'))
                ];
                $this->db->insert('user', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'User baru berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'User baru gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $id = $this->input->post('id');
                $data = [
                    'nama' => htmlspecialchars($this->input->post('nama')),
                    'username' => htmlspecialchars($this->input->post('username')),
                    'password' => md5(sha1($this->input->post('new_pass'))),
                    'id_role' => htmlspecialchars($this->input->post('role'))
                ];
                $this->db->where('id', $id)->update('user', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'User berhasil di edit'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'User gagal di edit'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function action_user()
    {
        cek_ajax();
        $user = get_user();
        $act = $this->input->post('act');
        switch ($act) {
            case 'status':
                $id = $this->input->post('id');
                $data = [
                    'is_active' => htmlspecialchars($this->input->post('status'))
                ];
                $this->db->where('id', $id)->update('user', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Status user berhasil di ubah'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Status user gagal di ubah'
                    ];
                }
                echo json_encode($params);
                break;
            case 'delete':
                $id = $this->input->post('id');
                $this->db->where('id', $id)->delete('user');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Data user berhasil di hapus'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Data user gagal di hapus'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function validation_menu()
    {
        cek_ajax();
        get_user();
        $this->form_validation->set_rules('label', 'Label', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('url', 'URL', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_label' => form_error('label'),
                'err_url' => form_error('url'),
                'err_icon' => form_error('icon')
            ];
            echo json_encode($params);
            die;
        } else {
            $this->to_action_menu();
        }
    }

    private function to_action_menu()
    {
        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $data = [
                    'label' => htmlspecialchars($this->input->post('label')),
                    'url' => htmlspecialchars($this->input->post('url')),
                    'icon' => $this->input->post('icon'),
                    'type' => $this->input->post('type'),
                    'parent' => $this->input->post('parent'),
                    'status' => 1
                ];
                $this->db->insert('menu', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Menu baru berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Menu baru gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $id = $this->input->post('id');

                $data = [
                    'label' => htmlspecialchars($this->input->post('label')),
                    'url' => htmlspecialchars($this->input->post('url')),
                    'icon' => $this->input->post('icon'),
                    'type' => $this->input->post('type'),
                    'parent' => $this->input->post('parent'),
                ];
                $this->db->where('id', $id)->update('menu', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Menu berhasil di edit'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Menu gagal di edit'
                    ];
                }


                echo json_encode($params);
                break;
        }
    }

    public function detail_menu()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $get_user = $this->db->get_where('menu', ['id' => $id])->row();
        echo json_encode($get_user);
        die;
    }

    public function delete_menu()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('menu');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Menu berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Menu gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function get_form_menu()
    {
        cek_ajax();
        get_user();
        $data['role'] = $this->input->post('role');
        $data['menu'] = $this->db->where(['type !=' => 3, 'status' => 1])->get('menu')->result();
        $this->load->view('ajax/show_form_access_menu', $data);
    }

    public function update_access_menu()
    {
        cek_ajax();
        get_user();
        $id_role = $this->input->post('role');
        $menu = $this->input->post('check');
        if (!$menu) {
            $params = [
                'status' => false,
                'msg' => 'Harap pilih menu'
            ];
        } else {
            $jml_menu = count($menu);
            $insert_data = [];
            for ($i = 0; $i < $jml_menu; $i++) {
                array_push($insert_data, array(
                    'id_role' => $id_role,
                    'id_menu' => $menu[$i]
                ));
            }


            $this->db->trans_begin();
            $this->db->where('id_role', $id_role)->delete('menu_access');
            $this->db->insert_batch('menu_access', $insert_data);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $params = [
                    'status' => false,
                    'msg' => 'Akses menu gagal di perbarui'
                ];
            } else {
                $this->db->trans_commit();
                $params = [
                    'status' => true,
                    'msg' => 'Akses menu berhasil di perbarui'
                ];
            }
        }
        echo json_encode($params);
    }

    // TAMBAHAN MENU AGNA START //
    public function validation_operasional()
    {
        cek_ajax();
        get_user();
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('posisi', 'Posisi', 'required');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_nama' => form_error('nama'),
                'err_posisi' => form_error('posisi'),
            ];
            echo json_encode($params);
            die;
        } else {
            $this->to_action_operasional();
        }
    }
    private function to_action_operasional()
    {
        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $data = [
                    'nama' => htmlspecialchars($this->input->post('nama')),
                    'posisi' => $this->input->post('posisi'),
                ];
                $this->db->insert('master_operasional', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Manajemen Operasional berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Manajemen Operasional gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $id = $this->input->post('id');

                $data = [
                    'nama' => $this->input->post('nama'),
                    'posisi' => $this->input->post('posisi'),
                ];
                $this->db->where('id', $id)->update('master_operasional', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Manajemen Operasional berhasil di edit'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Manajemen Operasional gagal di edit'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function detail_operasional()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $get_operasional = $this->db->get_where('master_operasional', ['id' => $id])->row();
        echo json_encode($get_operasional);
        die;
    }

    public function delete_operasional()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('master_operasional');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Manajemen Operasional berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Manajemen Operasional gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function validation_sertifikat()
    {
        cek_ajax();
        get_user();
        $this->form_validation->set_rules('kode', 'Kode', 'required');
        $this->form_validation->set_rules('nama_sertif', 'Nama Sertifikat', 'required');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_kode' => form_error('kode'),
                'err_nama_sertif' => form_error('nama_sertif'),
            ];
            echo json_encode($params);
            die;
        } else {
            $this->to_action_sertifikat();
        }
    }
    private function to_action_sertifikat()
    {
        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $data = [
                    'kode' => htmlspecialchars($this->input->post('kode')),
                    'nama_sertif' => $this->input->post('nama_sertif'),
                ];
                $this->db->insert('master_sertifikat_tanah', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Sertifikat Tanah berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Sertifikat Tanah gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $id = $this->input->post('id');

                $data = [
                    'kode' => $this->input->post('kode'),
                    'nama_sertif' => $this->input->post('nama_sertif'),
                ];
                $this->db->where('id', $id)->update('master_sertifikat_tanah', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Sertifikat Tanah berhasil di edit'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Sertifikat Tanah gagal di edit'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function detail_sertifikat()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $get_sertifikat = $this->db->get_where('master_sertifikat_tanah', ['id' => $id])->row();
        echo json_encode($get_sertifikat);
        die;
    }

    public function delete_sertifikat()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('master_sertifikat_tanah');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Sertifikat Tanah berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Sertifikat Tanah gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function validation_pengalihan()
    {
        cek_ajax();
        get_user();
        $this->form_validation->set_rules('kode_pengalihan', 'Kode Pengalihan', 'required');
        $this->form_validation->set_rules('nama_pengalihan', 'Nama Pengalihan', 'required');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_kode_pengalihan' => form_error('kode_pengalihan'),
                'err_nama_pengalihan' => form_error('nama_pengalihan'),
            ];
            echo json_encode($params);
            die;
        } else {
            $this->to_action_pengalihan();
        }
    }
    private function to_action_pengalihan()
    {
        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $data = [
                    'kode_pengalihan' => htmlspecialchars($this->input->post('kode_pengalihan')),
                    'nama_pengalihan' => $this->input->post('nama_pengalihan'),
                ];
                $this->db->insert('master_jenis_pengalihan', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Jenis Pengalihan berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Jenis Pengalihan gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $id = $this->input->post('id');

                $data = [
                    'kode_pengalihan' => $this->input->post('kode_pengalihan'),
                    'nama_pengalihan' => $this->input->post('nama_pengalihan'),
                ];
                $this->db->where('id', $id)->update('master_jenis_pengalihan', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Jenis Pengalihan berhasil di edit'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Jenis Pengalihan gagal di edit'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function detail_pengalihan()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $get_pengalihan = $this->db->get_where('master_jenis_pengalihan', ['id' => $id])->row();
        echo json_encode($get_pengalihan);
        die;
    }

    public function delete_pengalihan()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('master_jenis_pengalihan');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Jenis Pengalihan berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Jenis Pengalihan gagal di hapus'
            ];
        }
        echo json_encode($params);
    }
    //TAMBAHAN AGNA 26 Maret 2024 END//






    //sistem pengingat 
    public function notif_pembayaran()
    {
        $this_date = date('Y-m-d');
        $arr_date = [];
        for ($i = 1; $i < 8; $i++) {
            $get_date = strtotime('+' . $i . ' day', strtotime($this_date));
            $date = date('Y-m-d', $get_date);
            $arr_date[] = $date;
        }
        array_push($arr_date, $this_date);
        $data = $this->model->get_pembayaran_belum($arr_date)->result();

        var_dump($data);

        $html = '';
        if (empty($data)) {
            $html = '<tr><td class="text-center" colspan="5">No data result</td></tr>';
        } else {
            foreach ($data as $d) {
                $tgl = date_create($d->tgl_pembayaran);
                $html .= '
                    <tr>
                        <td>' . $d->nama_proyek . '</td>
                        <td>' . $d->nama_penjual . '</td>
                        <td>Rp. ' . number_format($d->total_bayar) . '</td>
                        <td>' . date_format($tgl, 'd/m/Y') . '</td>
                        <td>' . $d->nama_status . '</td>
                    </tr>
                ';
            }
        }
        echo $html;
    }
}
