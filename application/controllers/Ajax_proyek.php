<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Ajax_proyek extends CI_Controller
{
    public function get_desa()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $get_desa = $this->db->get_where('desa', ['id_kecamatan' => $id])->result();
        echo json_encode($get_desa);
    }

    public function get_proyek_row()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $data = $this->model->get_master_proyek($id)->row();
        echo json_encode($data);
    }

    public function action_proyek()
    {
        cek_ajax();
        get_user();
        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $data = [
                    'kelurahan_id' => htmlspecialchars($this->input->post('desa')),
                    'nama_proyek' => htmlspecialchars($this->input->post('proyek')),
                    'create_at' => date('Y-m-d H:i:s'),
                    'update_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('master_proyek', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Proyek berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Proyek gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $id = $this->input->post('id');
                $data = [
                    'kelurahan_id' => htmlspecialchars($this->input->post('desa')),
                    'nama_proyek' => htmlspecialchars($this->input->post('proyek')),
                    'update_at' => date('Y-m-d H:i:s')
                ];
                $this->db->where('id', $id)->update('master_proyek', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Proyek berhasil di edit'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Proyek gagal di edit'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function action_target_proyek()
    {
        cek_ajax();
        get_user();
        $bulan = $this->input->post('month');
        $tahun = $this->input->post('year');
        $proyek = $this->input->post('id_proyek');
        // $status_proyek = $this->input->post('status_proyek');
        $luas = $this->input->post('luas');
        $bid = $this->input->post('bid');
        $act = $this->input->post('act');

        $jml_data = count($bulan);

        switch ($act) {
            case 'add':
                $target_proyek = $this->db->get_where('master_proyek_target', ['proyek_id' => $proyek, 'year(tahun)' => $tahun])->num_rows();

                if ($target_proyek > 0) {
                    $params = [
                        'status' => false,
                        'msg' => 'Gagal Menambahkan, terdapat Tahun yang sama'
                    ];
                } else {
                    $update_target = [];

                    for ($i = 0; $i < $jml_data; $i++) {
                        $year = $tahun . '-' . $bulan[$i] . '-' . '01';
                        array_push($update_target, array(
                            'proyek_id' => $proyek,
                            'group_id' => time(),
                            'tahun' => $year,
                            'target_bidang' => $bid[$i],
                            'target_luas' => $luas[$i]
                        ));
                    }
                    $this->db->insert_batch('master_proyek_target', $update_target);
                    if ($this->db->affected_rows() > 0) {
                        $params = [
                            'status' => true,
                            'msg' => 'Target proyek baru berhasil di tambahkan'
                        ];
                    } else {
                        $params = [
                            'status' => false,
                            'msg' => 'Target proyek baru gagal di tambahkan'
                        ];
                    }
                }

                echo json_encode($params);
                die;

                break;
            case 'edit':
                $id_group = $this->input->post('group_id');
                $target_proyek = $this->db->get_where('master_proyek_target', ['proyek_id' => $proyek, 'year(tahun)' => $tahun, 'group_id !=' => $id_group])->num_rows();

                if ($target_proyek > 0) {
                    $params = [
                        'status' => false,
                        'msg' => 'Gagal, terdapat Tahun yang sama'
                    ];
                } else {
                    $id_update = $this->input->post('id_val');

                    $affected_rows = 0;
                    for ($i = 0; $i < $jml_data; $i++) {
                        $year = $tahun . '-' . $bulan[$i] . '-' . '01';

                        $data_update = [
                            'tahun' => $year,
                            'target_bidang' => $bid[$i],
                            'target_luas' => $luas[$i]
                        ];
                        $this->db->where('id', $id_update[$i])->update('master_proyek_target', $data_update);

                        $affected_rows += $this->db->affected_rows();
                    }

                    // var_dump($affected_rows);
                    // die;
                    if ($affected_rows > 0) {
                        $params = [
                            'status' => true,
                            'msg' => 'Target proyek berhasil di update'
                        ];
                    } else {
                        $params = [
                            'status' => false,
                            'msg' => 'Target proyek gagal di update'
                        ];
                    }
                }
                echo json_encode($params);
                die;

                break;
        }
    }

    public function get_form_edit_target()
    {
        cek_ajax();
        get_user();
        $group = $this->input->post('id');
        $form = '';

        $list_month = $this->model->get_month_data();

        foreach ($list_month as $lm) {
            $data_target = $this->db->where([
                'group_id' => $group,
                'month(tahun)' => $lm['val']
            ])->get('master_proyek_target')->row();
            $form .= '
            <tr>
                <td>
                    ' . $lm['bulan'] . '
                    <input type="hidden" name="id_val[]" value="' . $data_target->id . '">
                    <input type="hidden" name="month[]" value="' . $lm['val'] . '">
                </td>
                <td>
                    <input type="number" name="bid[]" class="form-control bid" value="' . $data_target->target_bidang . '">
                </td>
                <td>
                    <input type="number" name="luas[]" class="form-control luas"  value="' . $data_target->target_luas . '">
                </td>
            </tr>
            ';
        }
        $html = '
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>BID</th>
                        <th>Luas</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $form . '
                </tbody>
            </table>
        ';
        echo $html;
    }

    public function to_delete_target()
    {
        cek_ajax();
        get_user();
        $group = $this->input->post('group');
        $this->db->where('group_id', $group)->delete('master_proyek_target');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Target berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Target gagal di hapus'
            ];
        }
        echo json_encode($params);
    }
}
