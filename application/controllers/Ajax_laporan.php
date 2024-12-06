<?php

use PhpOffice\PhpSpreadsheet\Worksheet\Row;

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Ajax_laporan extends CI_Controller
{

    //LAPORAN NO 1
    public function form_edit_ijin_lokasi()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');

        $data['data'] = $this->db->get_where('tbl_ijin_lokasi', ['id' => $id])->row();
        $data['lokasi'] = $this->model->get_lokasi_proses_ijin()->result();
        $this->load->view('laporan/1/form_ijin_lokasi', $data);
    }

    public function act_proses_ijin_lokasi()
    {
        cek_ajax();
        get_user();
        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $data = [
                    'tanah_id' => htmlspecialchars($this->input->post('lokasi')),
                    'koordinat' => htmlspecialchars($this->input->post('koordinat')),
                    'luas_terbit' => htmlspecialchars($this->input->post('luas_terbit')),
                    'daftar_online_oss' => htmlspecialchars($this->input->post('tgl_oss')),
                    'no_terbit_oss' => htmlspecialchars($this->input->post('no_oss')),
                    'tgl_daftar_pertimbangan' => htmlspecialchars($this->input->post('tgl_dft_pertimbangan')),
                    'no_berkas_pertimbangan' => htmlspecialchars($this->input->post('no_dft_pertimbangan')),
                    'tgl_terbit_pertimbangan' => htmlspecialchars($this->input->post('tgl_tbt_pertimbangan')),
                    'no_sk_pertimbangan' => htmlspecialchars($this->input->post('no_tbt_pertimbangan')),
                    'tgl_daftar_lokasi' => htmlspecialchars($this->input->post('tgl_dft_lokasi')),
                    'tgl_terbit_lokasi' => htmlspecialchars($this->input->post('tgl_tbt_lokasi')),
                    'nomor_ijin_lokasi' => htmlspecialchars($this->input->post('no_lokasi')),
                    'masa_berlaku' => htmlspecialchars($this->input->post('masa_berlaku')),
                    'ket' => htmlspecialchars($this->input->post('ket')),
                    'status' => 'proses',
                    'status_tanah' => htmlspecialchars($this->input->post('status_tanah'))
                ];

                $this->db->insert('tbl_ijin_lokasi', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Data baru berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Data baru gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $update_data = [
                    'tanah_id' => htmlspecialchars($this->input->post('lokasi')),
                    'koordinat' => htmlspecialchars($this->input->post('koordinat')),
                    'luas_terbit' => htmlspecialchars($this->input->post('luas_terbit')),
                    'daftar_online_oss' => htmlspecialchars($this->input->post('tgl_oss')),
                    'no_terbit_oss' => htmlspecialchars($this->input->post('no_oss')),
                    'tgl_daftar_pertimbangan' => htmlspecialchars($this->input->post('tgl_dft_pertimbangan')),
                    'no_berkas_pertimbangan' => htmlspecialchars($this->input->post('no_dft_pertimbangan')),
                    'tgl_terbit_pertimbangan' => htmlspecialchars($this->input->post('tgl_tbt_pertimbangan')),
                    'no_sk_pertimbangan' => htmlspecialchars($this->input->post('no_tbt_pertimbangan')),
                    'tgl_daftar_lokasi' => htmlspecialchars($this->input->post('tgl_dft_lokasi')),
                    'tgl_terbit_lokasi' => htmlspecialchars($this->input->post('tgl_tbt_lokasi')),
                    'nomor_ijin_lokasi' => htmlspecialchars($this->input->post('no_lokasi')),
                    'masa_berlaku' => htmlspecialchars($this->input->post('masa_berlaku')),
                    'ket' => htmlspecialchars($this->input->post('ket')),
                    'status' => htmlspecialchars($this->input->post('status_ijin')),
                    'status_tanah' => htmlspecialchars($this->input->post('status_tanah'))
                ];
                $id = $this->input->post('id');
                $this->db->where('id', $id)->update('tbl_ijin_lokasi', $update_data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Data berhasil di update'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Data gagal di update'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function delete_ijin_lokasi()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('tbl_ijin_lokasi');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Data berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => true,
                'msg' => 'Data berhasil di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function load_evaluasi_terbit_ijin()
    {
        cek_ajax();
        get_user();
        $f_proyek = $this->input->post('proyek');
        $f_status = $this->input->post('status');

        $result = $this->laporan->get_terbit_ijin($f_proyek, $f_status);
        $data = [];
        $i = 1;
        foreach ($result as $r) {
            $d_terbit = date_create($r->tgl_terbit_lokasi);
            $d_exp = date_create($r->masa_berlaku);
            $persentase = $r->luas_surat / $r->luas_terbit * 100;
            $row = [];
            $row[] = '
            <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    Action
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" onclick="detail(\'' . $r->id . '\')">Detail</a>
                    <a class="dropdown-item" href="#" onclick="edit(\'' . $r->id . '\')">Edit</a>
                    <a class="dropdown-item" href="#" onclick="delete_data(\'' . $r->id . '\')">Hapus</a>
                </div>
            </div>
            ';
            $row[] = $i++;
            $row[] = $r->nama_proyek . '(' . $r->nama_status . ') / ' . $r->no_terbit_oss;
            $row[] = $r->luas_terbit;
            $row[]  = $r->no_terbit_oss;
            $row[] = date_format($d_terbit, 'd F Y');
            $row[] = date_format($d_exp, 'd F Y');
            $row[] = $r->luas_surat;
            $row[] = round($persentase, 2);
            $row[] = $r->ket;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->laporan->count_all_terbit_ijin(),
            "recordsFiltered" => $this->laporan->count_filtered_terbit_ijin(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function detail_terbit_ijin()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $data['laporan'] = $this->laporan->query_proses_ijin_lokasi(null, null, $id)->row();
        $this->load->view('laporan/1/detail_terbit_ijin', $data);
    }
    //LAPORAN NO 1 END

    //LAPORAN NO 2 START
    public function load_evaluasi_pembelian()
    {
        $data = [
            'proyek_id' => $this->input->post('proyek'),
            'status_proyek' => $this->input->post('status'),
            'tahun' => $this->input->post('year')
        ];
        if ($data['status_proyek']) {
            $data = [
                'perumahan' => $this->laporan->get_filter_status_menu2($data['proyek_id'], date('Y' . '-01-01'), date('Y') . '-12-31', $data['status_proyek'], $data['tahun']),
                'status_proyek' => $data['status_proyek'],
            ];
            $this->load->view('laporan/2/filter_by_status_pembelian', $data);
        } else if ($data['tahun']) {
            $data = [
                'tahun' => $this->input->post('year'),
                'ip_luar_ijin' => $this->laporan->get_filter_status_menu2('', '', '', 1, $data['tahun']),
                'ip_dalam_ijin' => $this->laporan->get_filter_status_menu2('', '', '', 2, $data['tahun']),
                'ip_lokasi' => $this->laporan->get_filter_status_menu2('', '', '', 3, $data['tahun']),
            ];
            $this->load->view('laporan/2/filter_by_tahun_pembelian', $data);
        } else {
            $data = [
                'title' => 'Data Evaluasi Pembelian Tanah',
                'user' => get_user(),
                'tanah_proyek' => $this->db->get('master_proyek')->result(),

                'ip_luar_ijin' => $this->laporan->get_filter_status_menu2($data['proyek_id'], date('Y' . '-01-01'), date('Y') . '-12-31', 1, $data['tahun']),
                'ip_dalam_ijin' => $this->laporan->get_filter_status_menu2($data['proyek_id'], date('Y' . '-01-01'), date('Y') . '-12-31', 2, $data['tahun']),
                'ip_lokasi' => $this->laporan->get_filter_status_menu2($data['proyek_id'], date('Y' . '-01-01'), date('Y') . '-12-31', 3, $data['tahun']),

            ];
            $this->load->view('laporan/2/all_data_evaluasi_pembelian', $data);
        }
    }

    //LAPORAN NO 2 END

    //LAPORAN NO 3 START
    public function detail_landbank_perum()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $data['data'] = $this->laporan->get_data_landbank_perum(null, null, null, null, $id)->row();
        $this->load->view('laporan/3/detail_landbank_perum', $data);
    }

    public function form_edit_landbank()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $data['data'] = $this->laporan->get_data_landbank_perum(null, null, null, null, $id)->row();
        $this->load->view('laporan/3/form_edit_landbank', $data);
    }

    public function update_data_landbank()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');

        $data_update = [
            'serah_terima_finance' => htmlspecialchars($this->input->post('finance')),
            'status_pengalihan' => htmlspecialchars($this->input->post('status_pengalihan_akta')),
            'tgl_status_pengalihan' => htmlspecialchars($this->input->post('tgl_pengalihan_status')),
            'tgl_akta_pengalihan' => htmlspecialchars($this->input->post('tgl_pengalihan_akta')),
            'no_akta_pengalihan' => htmlspecialchars($this->input->post('no_pengalihan_akta')),
            'atas_nama_pengalihan' => htmlspecialchars($this->input->post('nama_pengalihan')),
            'status_teknik' => htmlspecialchars($this->input->post('ke_teknik')),
            'ket' => htmlspecialchars($this->input->post('ket'))
        ];
        $this->db->where('id', $id)->update('master_tanah', $data_update);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Data berhasil di update'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Data gagal di update'
            ];
        }
        echo json_encode($params);
    }

    public function to_delete_landbank()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->delete('master_tanah', ['id' => $id]);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Data berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Data gagal di hapus'
            ];
        }
        echo json_encode($params);
    }
    //LAPORAN NO 3 END

    //LAPORAN NO 4 START
    public function form_edit_shgb()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $data['data'] = $this->laporan->get_tanah_belum_shgb(null, null, null, null, $id)->row();
        $this->load->view('laporan/4/form_edit', $data);
    }

    public function edit_belum_shgb()
    {
        cek_ajax();
        get_user();

        $id = $this->input->post('id');
        $data = [
            'status_proses_shgb' => htmlspecialchars($this->input->post('s_shgb')),
            'tgl_status_pengalihan' => htmlspecialchars($this->input->post('tgl_proses')),
            'jenis_pengalihan' => htmlspecialchars($this->input->post('j_pengalihan')),
            'no_akta_pengalihan' => htmlspecialchars($this->input->post('no_akta')),
            'tgl_akta_pengalihan' => htmlspecialchars($this->input->post('tgl_akta')),
            'atas_nama_pengalihan' => htmlspecialchars($this->input->post('atas_nama')),
            'serah_terima_finance' => htmlspecialchars($this->input->post('st_finance')),
        ];
        $this->db->where('id', $id)->update('master_tanah', $data);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Data berhasil di update'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Data gagal di update'
            ];
        }
        echo json_encode($params);
    }

    public function delete_belum_shgb()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->delete('master_tanah', ['id' => $id]);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Data berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Data gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function load_rekap_belum_shgb()
    {
        cek_ajax();
        get_user();
        $f_proyek = $this->input->post('proyek');
        $result = $this->laporan->get_rekap_belum_shgb($f_proyek);
        $status_pengalihan = ['belum order', 'order', 'terbit'];
        $last_year = date('Y', strtotime('-1 year'));
        $this_year = date('Y');

        $data = [];
        $i = 1;

        foreach ($result as $d) {
            $shgb_last = $this->laporan->get_jml_belum_shgb($last_year, 'belum', $d->id_proyek);
            $shgb_now = $this->laporan->get_jml_belum_shgb($this_year, 'belum', $d->id_proyek);
            $total_blm_shgb = $this->laporan->get_jml_belum_shgb(null, 'belum', $d->id_proyek);
            $proses_this_year = $this->laporan->get_jml_belum_shgb($this_year, 'proses', $d->id_proyek);


            $sisa_bid = $shgb_now['bid'] - $proses_this_year['bid'];
            $sisa_surat = $shgb_now['luas_surat'] - $proses_this_year['luas_ukur'];
            $sisa_ukur = $shgb_now['luas_surat'] - $proses_this_year['luas_ukur'];
            $total_bid_spb = 0;

            $finance_blm = $this->laporan->get_jml_bid_belum_shgb(null, null, $d->id_proyek, null, 'no');
            $finance_sdh = $this->laporan->get_jml_bid_belum_shgb(null, null, $d->id_proyek, null, 'yes');


            $row = [];

            $row[] = $i++;
            $row[] = $d->nama_proyek;

            $row[] = $shgb_last['bid'];
            $row[] = $shgb_last['luas_surat'];
            $row[] = $shgb_last['luas_ukur'];

            $row[] = $shgb_now['bid'];
            $row[] = $shgb_now['luas_surat'];
            $row[] = $shgb_now['luas_ukur'];

            $row[] = $total_blm_shgb['bid'];
            $row[] = $total_blm_shgb['luas_surat'];
            $row[] = $total_blm_shgb['luas_ukur'];

            $row[] = $proses_this_year['bid'];
            $row[] = $proses_this_year['luas_surat'];
            $row[] = $proses_this_year['luas_ukur'];

            $row[] = $sisa_bid;
            $row[] = $sisa_surat;
            $row[] = $sisa_ukur;

            foreach ($status_pengalihan as $sp) {
                $bid_spb = $this->laporan->get_jml_bid_belum_shgb(null, null, $d->id_proyek, $sp);
                $total_bid_spb += $bid_spb;
                $row[] = $bid_spb;
            }
            $row[] = $total_bid_spb;
            $row[] = $finance_blm;
            $row[] = $finance_sdh;

            $data[] = $row;
        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->laporan->count_all_rekap_belum_shgb($f_proyek),
            "recordsFiltered" => $this->laporan->count_filter_rekap_belum_shgb($f_proyek),
            "data" => $data,
        );
        echo json_encode($output);
    }
    //LAPORAN NO 4 END

    //LAPORAN NO 5 START

    public function validation_proses_induk()
    {
        cek_ajax();
        get_user();
        $this->form_validation->set_rules('no_gambar', 'Nomor Gambar', 'required');
        $this->form_validation->set_rules('status_induk', 'Status Induk', 'required');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_no_gambar' => form_error('no_gambar'),
                'err_status_induk' => form_error('status_induk'),
            ];
            echo json_encode($params);
            die;
        } else {
            $this->to_action_prosesInduk();
        }
    }

    private function to_action_prosesInduk()
    {
        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $data = [
                    'no_gambar' => $this->input->post('no_gambar'),
                    'luas_terbit' => $this->input->post('luas_terbit'),
                    'tgl_daftar_sk_hak' => $this->input->post('tgl_daftar_sk_hak'),
                    'no_daftar_sk_hak' => $this->input->post('no_daftar_sk_hak'),
                    'tgl_terbit_sk_hak' => $this->input->post('tgl_terbit_sk_hak'),
                    'no_terbit_sk_hak' => $this->input->post('no_terbit_sk_hak'),
                    'tgl_daftar_shgb' => $this->input->post('tgl_daftar_shgb'),
                    'no_daftar_shgb' => $this->input->post('no_daftar_shgb'),
                    'tgl_terbit_shgb' => $this->input->post('tgl_terbit_shgb'),
                    'no_terbit_shgb' => $this->input->post('no_terbit_shgb'),
                    'masa_berlaku_shgb' => $this->input->post('masa_berlaku_shgb'),
                    'target_penyelesaian' => $this->input->post('target_penyelesaian'),
                    'status_induk' => $this->input->post('status_induk'),
                    'ket' => $this->input->post('ket'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'tgl_ukur' => $this->input->post('tgl_ukur', true),
                    'no_ukur' => $this->input->post('no_ukur', true),
                    'status_tanah' => $this->input->post('status_tanah', true),
                    'tgl_terbit_ukur' => $this->input->post('tbt_ukur'),
                    'no_terbit_ukur' => $this->input->post('tgl_tbt_ukur'),
                    'sisa_induk' => $this->input->post('luas_terbit'),
                ];
                $this->db->insert('tbl_proses_induk', $data);

                $id_proses_induk =  $this->db->insert_id();
                $id_tanah = $this->input->post('tanah_id');
                $ket_sub = $this->input->post('ket_sub');

                $count_tanah = count((array)$id_tanah);
                $data_sub = array();
                $data_idtanah = [];
                for ($i = 0; $i < $count_tanah; $i++) {
                    $data_sub[] = [
                        'induk_id' => $id_proses_induk,
                        'tanah_id' => $id_tanah[$i],
                        'ket_sub' => $ket_sub[$i],
                    ];
                    $row = $id_tanah[$i];
                    $data_idtanah[] = $row;
                }


                $this->db->trans_begin();
                $this->db->set('status_perindukan', 'sudah')->where_in('id', $data_idtanah)->update('master_tanah');
                $this->db->insert_batch('sub_proses_induk', $data_sub);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Proses Induk gagal di tambahkan'
                    ];
                } else {
                    $this->db->trans_commit();
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Proses Induk berhasil di tambahkan'
                    ];
                }

                echo json_encode($params);
                break;
            case 'edit':
                $id = $this->input->post('id');

                $data = [
                    'no_gambar' => $this->input->post('no_gambar'),
                    'luas_terbit' => $this->input->post('luas_terbit'),
                    'tgl_daftar_sk_hak' => $this->input->post('tgl_daftar_sk_hak'),
                    'no_daftar_sk_hak' => $this->input->post('no_daftar_sk_hak'),
                    'tgl_terbit_sk_hak' => $this->input->post('tgl_terbit_sk_hak'),
                    'no_terbit_sk_hak' => $this->input->post('no_terbit_sk_hak'),
                    'tgl_daftar_shgb' => $this->input->post('tgl_daftar_shgb'),
                    'no_daftar_shgb' => $this->input->post('no_daftar_shgb'),
                    'tgl_terbit_shgb' => $this->input->post('tgl_terbit_shgb'),
                    'no_terbit_shgb' => $this->input->post('no_terbit_shgb'),
                    'masa_berlaku_shgb' => $this->input->post('masa_berlaku_shgb'),
                    'target_penyelesaian' => $this->input->post('target_penyelesaian'),
                    'status_induk' => $this->input->post('status_induk'),
                    'ket' => $this->input->post('ket'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'tgl_ukur' => $this->input->post('tgl_ukur', true),
                    'no_ukur' => $this->input->post('no_ukur', true),
                    'status_tanah' => $this->input->post('status_tanah', true),
                    'tgl_terbit_ukur' => $this->input->post('tbt_ukur'),
                    'no_terbit_ukur' => $this->input->post('tgl_tbt_ukur')
                ];

                $sub_id = $this->input->post('sub_id');
                $id_tanah = $this->input->post('tanah_id');

                $ket_sub = $this->input->post('ket_sub');

                $count_tanah = count((array)$id_tanah);
                $data_sub = array();
                $list_id_tanah = [];
                for ($i = 0; $i < $count_tanah; $i++) {
                    $data_sub[] = [
                        'induk_id' => $id,
                        'tanah_id' => $id_tanah[$i],
                        'ket_sub' => $ket_sub[$i],
                    ];
                    $row = $id_tanah[$i];
                    $list_id_tanah[] = $row;
                }


                $this->db->trans_begin();

                $this->db->where('id', $id)->update('tbl_proses_induk', $data);
                $this->db->where('induk_id', $id)->delete('sub_proses_induk');
                $this->db->set('status_perindukan', 'sudah')->where_in('id', $list_id_tanah)->update('master_tanah');
                $this->db->insert_batch('sub_proses_induk', $data_sub);
                $status_tanah = $this->input->post('status_tanah');

                if ($status_tanah == 'tanah_proyek') {
                    $this->db->set('status_teknik', 'selesai')->where_in('id', $list_id_tanah)->update('master_tanah');
                }

                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Proses Induk berhasil di edit'
                    ];
                } else {
                    $this->db->trans_rollback();
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Proses Induk gagal di edit'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function delete_sub_induk()
    {
        cek_ajax();
        $id = $this->input->post('id');
        $id_tanah = $this->input->post('tanah');
        $this->db->trans_begin();

        $this->db->set('status_perindukan', 'belum')->where('id', $id_tanah)->update('master_tanah');
        $this->db->where('id', $id)->delete('sub_proses_induk');
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $params = [
                'status' => true,
                'msg' => 'Data tanah berhasil di hapus'
            ];
        } else {
            $this->db->trans_rollback();
            $params = [
                'status' => false,
                'msg' => 'Data tanah gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function get_induk_tanah()
    {
        cek_ajax();
        get_user();
        $id_induk = $this->input->post('id');

        $data = [
            'data' => $this->laporan->get_data_proses_induk(null, null, null, $id_induk)->row(),
            'list' => $this->laporan->get_data_subproses_induk($id_induk)->result()
        ];

        echo json_encode($data);
    }


    public function detail_proses_induk()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $data = [
            'data' =>  $this->laporan->get_data_proses_induk(null, null, null, $id)->row(),
            'sub' => $this->laporan->get_data_subproses_induk($id)->result(),
        ];
        $this->load->view('laporan/5/form_detail', $data);
    }
    public function form_edit_proses_induk()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $data = [
            'data' =>  $this->laporan->get_data_proses_induk(null, null, null, $id)->row(),
            'sub' => $this->laporan->get_data_subproses_induk($id)->result(),
        ];
        $this->load->view('laporan/5/form_edit', $data);
    }

    public function delete_proses_induk()
    {
        cek_ajax();
        get_user();

        $id = $this->input->post('id');
        $this->db->trans_begin();

        $this->db->delete('tbl_proses_induk', ['id' => $id]);
        $this->db->delete('sub_proses_induk', ['induk_id' => $id]);

        if ($this->db->trans_status() === FALSE) {


            $this->db->trans_rollback();
            $params = [
                'status' => false,
                'msg' => 'Proses Induk gagal di hapus'
            ];
        } else {
            $this->db->trans_commit();
            $params = [
                'status' => true,
                'msg' => 'Proses Induk berhasil di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function load_list_tanah_5()
    {
        cek_ajax();

        $data = [];
        $status = $this->input->post('status');
        $tanah = $this->input->post('tanah_id');
        $get_data = $this->laporan->get_list_data_tanah($status, $tanah);
        $i = 1;
        foreach ($get_data as $d) {
            $row = [];
            $row[] = $i++;
            $row[] = $d->nama_proyek . ' (' . $d->nama_status . ')';
            $row[] = $d->nama_penjual;
            $row[] = $d->luas_surat;
            $row[] = $d->status_teknik;
            $row[] = '
                <button class="btn btn-sm btn-success" onclick="to_add_list_data_tanah(\'' . $d->id_tanah . '\', \'' . $d->nama_proyek . ' (' . $d->nama_status . ')' . '\' , \'' . $d->nama_penjual . '\', \'' . $d->luas_surat . '\')"><i class="fas fa-check-circle"></i></button>
            ';
            $data[] = $row;
        }



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->laporan->count_all_list_tanah($status, $tanah),
            "recordsFiltered" => $this->laporan->get_filtered_list_tanah($status, $tanah),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //LAPORAN NO 5 END









    ///laporan no 8
    public function get_sub_kavling()
    {
        cek_ajax();
        $id = $this->input->post('id');
        $data = $this->laporan->query_get_kavling_penggabungan($id)->result();
        echo json_encode($data);
    }

    public function get_data_evaluasi8()
    {
        cek_ajax();
        $id = $this->input->post('id');
        $data = $this->laporan->get_data_evaluasi_splitsing(null, null, null, null, $id)->result();
        $out = [
            'data' => $data
        ];
        echo json_encode($out);
    }

    public function act_evaluasi_splitsing()
    {
        cek_ajax();
        $id = $this->input->post('id');
        $act = $this->input->post('act');

        switch ($act) {
            case 'detail':
                $get_data = $this->db->get_where('sub_splitsing', ['splitsing_id' => $id])->result();
                $html = '';
                if ($get_data) {
                    $i = 1;
                    foreach ($get_data as $d) {
                        $selisih = $d->luas_daftar - $d->luas_terbit;
                        $exp = tgl_indo($d->masa_berlaku);
                        $tgl_tbt = tgl_indo($d->tgl_terbit);


                        $html .= '
                            <tr>
                                <td>' . $i++ . '</td>
                                <td>' . $d->blok . '</td>
                                <td>' . $d->luas_daftar . '</td>
                                <td>' . $d->luas_terbit . '</td>
                                <td>' . $selisih . '</td>
                                <td>' . $d->no_shgb . '</td>
                                <td>' . $exp . '</td>
                                <td>' . $tgl_tbt . '</td>
                                <td>' . $d->keterangan . '</td>
                            </tr>
                        ';
                    }
                } else {
                    $html = '<tr><td colspan="10" class="text-danger text-center">No data result</td></tr>';
                }

                $output = '
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>Blok</th>
                                <th>Luas Daftar</th>
                                <th>Luas Terbit</th>
                                <th>Selisih</th>
                                <th>No. SHGB</th>
                                <th>Masa Berlaku</th>
                                <th>Tgl. Terbit</th>
                                <th>Ket</th>
                            </tr>
                        </thead>
                        <tbody>' . $html . '</tbody>
                    </table>
                ';

                echo $output;
                break;

            case 'data_edit':
                $type = $this->input->post('type');
                $source = $this->input->post('source');
                if ($type) {
                    $sub_splitsing = $this->db->get_where('sub_splitsing', ['splitsing_id' => $id])->result();
                    $splitsing = $this->db->get_where('tbl_splitsing', ['id' => $id])->row();
                    $induk_splitsing = $this->laporan->get_data_has_splitsing($type, 1)->row();

                    $data = [
                        'create_at' => $splitsing->create_at,
                        'id' => $splitsing->id,
                        'induk_id' => $splitsing->induk_id,
                        'luas_induk' => $induk_splitsing->luas_induk,
                        'no_daftar' => $splitsing->no_daftar,
                        'no_terbit_shgb' => $induk_splitsing->no_terbit_shgb,
                        'sisa_induk' => $induk_splitsing->sisa_induk,
                        'status' => $splitsing->status,
                        'status_penjualan' => $splitsing->status_penjualan,
                        'tgl_daftar' => $splitsing->tgl_daftar,
                        'total_luas_splitsing' => $splitsing->total_luas_splitsing,
                        'type' => $splitsing->type
                    ];

                    $output = [
                        'data' => $data,
                        'splitsing' => $sub_splitsing
                    ];
                } else {
                    if ($source == 'induk') {
                        $data_splitsing = $this->laporan->get_data_has_splitsing($id, 'induk')->row();
                    } else if ($source == 'penggabungan') {
                        $data_splitsing = $this->laporan->get_data_has_splitsing($id, 'penggabungan')->row();
                    } else {
                        $data_splitsing = $this->laporan->get_data_has_splitsing($id)->row();
                    }
                    $splitsing = $this->db->get_where('sub_splitsing', ['splitsing_id' => $id])->result();


                    $output = [
                        'data' => $data_splitsing,
                        'splitsing' => $splitsing
                    ];
                }


                echo json_encode($output);
                break;
            case 'edit':
                $id = $this->input->post('id');
                $id_split = $this->input->post('id_split');
                $luas_terbit = $this->input->post('luas_terbit');
                $new_luas_terbit = $this->input->post('new_luas_terbit');

                $no_shgb = $this->input->post('shgb_split');
                $new_no_shgb = $this->input->post('new_shgb_split');

                $ket = $this->input->post('ket');
                $new_ket = $this->input->post('new_ket');

                $new_blok = $this->input->post('new_blok');
                $luas_daftar = $this->input->post('luas_blok');
                $tipe_split = $this->input->post('type');

                $tgl_terbit = $this->input->post('tgl_terbit');
                $masa_berlaku = $this->input->post('masa_berlaku');
                $induk = $this->input->post('induk');
                $source = $this->input->post('source');


                $update_main_split = [
                    'status' => $this->input->post('status'),
                    'no_daftar' => $this->input->post('no_daftar'),
                    'tgl_daftar' => $this->input->post('tgl_daftar'),
                    'induk_id' => $induk,
                    'sumber_induk' => $this->input->post('source')
                ];

                if ($source == 'induk') {
                    $get_luas_induk = $this->db->select('luas_terbit')->from('tbl_proses_induk')->where('id', $induk)->get()->row()->luas_terbit;
                } else if ($source == 'penggabungan') {
                    $get_luas_induk = $this->db->select('luas_terbit')->from('tbl_penggabungan_induk')->where('id', $induk)->get()->row()->luas_terbit;
                }
                $get_luas_splitsing = $this->db->select('SUM(luas_daftar) AS luas')->from('sub_splitsing')->where('splitsing_id', $id)->get()->row()->luas;

                $luas_new_blok = 0;
                if ($new_blok) {
                    $jml_new_blok = count($new_blok);
                    $data_new_blok = [];
                    for ($a = 0; $a < $jml_new_blok; $a++) {
                        $row = [
                            'splitsing_id' => $id,
                            'blok' => $new_blok[$a],
                            'luas_daftar' => $luas_daftar[$a],
                            'luas_terbit' => $new_luas_terbit[$a],
                            'no_shgb' => $new_no_shgb[$a],
                            'masa_berlaku' => $masa_berlaku,
                            'tgl_terbit' => $tgl_terbit,
                            'keterangan' => $new_ket[$a],
                            'created_at' => date('Y-m-d H:i:s'),
                            'tipe' => $tipe_split[$a]
                        ];
                        $data_new_blok[] = $row;
                        $luas_new_blok += $luas_daftar[$a];
                    }
                }

                $luas_induk = 0;
                $luas_splitsing = 0;
                if ($get_luas_induk) {
                    $luas_induk = $get_luas_induk;
                }

                if ($get_luas_splitsing) {
                    $luas_splitsing = $get_luas_splitsing;
                }

                $total_luas_blok = $luas_splitsing + $luas_new_blok;
                if ($total_luas_blok > $luas_induk) {
                    $params = [
                        'status' => false,
                        'msg' => 'Total luas daftar melebihi luas induk (Total Luas: ' . $total_luas_blok . ' | Luas Induk: ' . $luas_induk . ')'
                    ];
                    echo json_encode($params);
                    die;
                }
                $sisa_split = $luas_induk - $total_luas_blok;








                $this->db->trans_begin();

                $jml_split = count($id_split);
                for ($i = 0; $i < $jml_split; $i++) {
                    $update_split = [
                        'luas_terbit' => $luas_terbit[$i],
                        'no_shgb' => $no_shgb[$i],
                        'keterangan' => $ket[$i],
                        'tgl_terbit' => $tgl_terbit,
                        'masa_berlaku' => $masa_berlaku
                    ];
                    $id_update = $id_split[$i];
                    $this->db->where('id', $id_update)->update('sub_splitsing', $update_split);
                }
                $this->db->where('id', $id)->update('tbl_splitsing', $update_main_split);
                if ($source == 'shgb') {
                    $this->db->set('sisa_induk', $sisa_split)->where('id', $induk)->update('tbl_proses_induk');
                }
                if ($new_blok) {
                    $this->db->insert_batch('sub_splitsing', $data_new_blok);
                }

                // if ($new_blok) {
                //     $jml_new_blok = count($new_blok);
                //     $data_new_blok = [];
                //     for ($a = 0; $a < $jml_new_blok; $a++) {
                //         $row = [
                //             'splitsing_id' => $id,
                //             'blok' => $new_blok[$a],
                //             'luas_daftar' => $luas_daftar[$a],
                //             'luas_terbit' => $new_luas_terbit[$a],
                //             'no_shgb' => $new_no_shgb[$a],
                //             'masa_berlaku' => $masa_berlaku,
                //             'tgl_terbit' => $tgl_terbit,
                //             'keterangan' => $new_ket[$a],
                //             'created_at' => date('Y-m-d H:i:s'),
                //             'tipe' => $tipe_split[$a]
                //         ];
                //         $data_new_blok[] = $row;
                //     }
                //     $this->db->insert_batch('sub_splitsing', $data_new_blok);
                // }


                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $params = [
                        'status' => false,
                        'msg' => 'Data gagal di ubah'
                    ];
                } else {
                    $this->db->trans_commit();
                    $params = [
                        'status' => true,
                        'msg' => 'Data berhasil di ubah'
                    ];
                }




                echo json_encode($params);
                die;
                break;
            case 'get_data_induk':

                $get_induk_has_selected = $this->db->where('sumber_induk', 'induk')->group_by('induk_id')->get('tbl_splitsing')->result();
                $induk_selected = [];
                foreach ($get_induk_has_selected as $gi) {
                    $induk_selected[] = $gi->induk_id;
                }

                $this->db->select('
                tbl_proses_induk.no_terbit_shgb,
                tbl_proses_induk.id,
                tbl_proses_induk.luas_terbit,
                tbl_proses_induk.status_induk,
                "induk" AS type_source 
                ')
                    ->from('tbl_proses_induk')
                    ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id')
                    ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id')
                    ->where('tbl_proses_induk.status_tanah', 'tanah_proyek')
                    ->where('tbl_proses_induk.status_induk', 'terbit')
                    ->where('master_tanah.proyek_id', $id);
                if ($induk_selected) {
                    $this->db->where_not_in('tbl_proses_induk.id', $induk_selected);
                }
                $this->db->group_by('tbl_proses_induk.id');
                $data1 = $this->db->get()->result();




                //data induk dari penggabungan
                $get_penggabungan_has_selected = $this->db->where('sumber_induk', 'penggabungan')->group_by('induk_id')->get('tbl_splitsing')->result();
                $penggabungan_selected = [];
                foreach ($get_penggabungan_has_selected as $gi) {
                    $penggabungan_selected[] = $gi->induk_id;
                }

                $this->db->select('
                    tbl_penggabungan_induk.id,
                    tbl_penggabungan_induk.no_shgb AS no_terbit_shgb,
                    tbl_penggabungan_induk.luas_terbit AS luas_terbit,
                    tbl_penggabungan_induk.opsi_data,
                    "penggabungan" AS type_source 
                ')
                    ->from('tbl_penggabungan_induk')
                    ->join('sub_penggabungan_induk', 'sub_penggabungan_induk.penggabungan_id = tbl_penggabungan_induk.id')
                    ->join('sub_splitsing', 'sub_splitsing.id = sub_penggabungan_induk.induk_id')
                    ->join('tbl_splitsing', 'tbl_splitsing.id = sub_splitsing.splitsing_id')
                    ->where('tbl_penggabungan_induk.status_penggabungan', 'terbit')
                    ->where('tbl_penggabungan_induk.opsi_data', 'shgb')
                    ->where('tbl_splitsing.proyek_id', $id);
                if ($penggabungan_selected) {
                    $this->db->where_not_in('tbl_penggabungan_induk.id', $penggabungan_selected);
                }
                $this->db->group_by('tbl_penggabungan_induk.id');
                $data2 = $this->db->get()->result();
                $data = array_merge($data1, $data2);


                $output = [
                    'status' => true,
                    'data' => $data,
                ];
                echo json_encode($output);
                break;
        }
    }

    //no 8 end



    //no 9 start
    public function act_sertifikat_belum_split()
    {
        cek_ajax();
        $id = $this->input->post('id');
        $act = $this->input->post('act');
        switch ($act) {
            case 'delete':
                $this->db->delete('tbl_splitsing', ['id' => $id]);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Data berhasil di hapus'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Data gagal di hapus'
                    ];
                }
                echo json_encode($params);
                die;
                break;
            case 'get_row':
                $getdata = $this->laporan->data_laporan_9(null, null, null, $id)->row();
                if (!empty($getdata)) {
                    $data = [
                        'pembeli' => $getdata->pembeli,
                        'type' => $getdata->type,
                        'tgl_jual' => $getdata->tgl_penjualan,
                        'shgb' => $getdata->no_shgb,
                        'expired' => $getdata->masa_berlaku,
                        'status' => $getdata->status_penjualan,
                        'ket' => $getdata->keterangan
                    ];
                    $params = ['status' => true, 'data' => $data];
                } else {
                    $params = ['status' => false, 'msg' => 'Data not found'];
                }
                echo json_encode($params);
                die;
                break;
            case 'edit':
                $status = $this->input->post('status');
                $data = [
                    'pembeli' => htmlspecialchars($this->input->post('pembeli')),
                    'tgl_penjualan' => htmlspecialchars($this->input->post('tgl_jual')),
                    'type' => htmlspecialchars($this->input->post('type')),
                    'no_shgb' => htmlspecialchars($this->input->post('shgb')),
                    'masa_berlaku' => htmlspecialchars($this->input->post('masa_berlaku')),
                    'status_penjualan' => htmlspecialchars($this->input->post('status')),
                    'keterangan' => htmlspecialchars($this->input->post('ket')),
                ];

                $this->db->trans_begin();
                $this->db->where('id', $id)->update('tbl_splitsing', $data);

                if ($status == 'proses') {
                    $this->db->set('tgl_proses', date('Y-m-d'))->where('id', $id)->update('tbl_splitsing');
                } else if ($status == 'terbit') {
                    $this->db->set('tgl_terbit', date('Y-m-d'))->where('id', $id)->update('tbl_splitsing');
                }


                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $params = ['status' => false, 'msg' => 'Data gagal di edit'];
                } else {
                    $this->db->trans_commit();
                    $params = ['status' => true, 'msg' => 'Data berhasil di edit'];
                }

                echo json_encode($params);
                break;
        }
    }

    //no 9 end





    //no 6 start
    public function datatable_list_tanah_6()
    {
        cek_ajax();
        $kategori = $this->input->post('kategori');
        $selected = $this->input->post('selected');
        switch ($kategori) {
            case 'induk':

                $data = $this->laporan->get_list_tanah_6($kategori, $selected);
                $list = [];
                foreach ($data as $d) {
                    $row = [];
                    $row[] = $d->nama_proyek;
                    $row[] = $d->no_terbit_shgb;
                    $row[] = '';
                    $row[] = $d->luas_terbit;
                    $row[] = '<button onclick="add_items(\'' . $kategori . '\', \'' . $d->id . '\', \'' . $d->nama_proyek . '\', \'' . $d->no_terbit_shgb . '\', \'' . $d->luas_terbit . '\')" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button';
                    $list[] = $row;
                }
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->laporan->get_count_list_tanah_6($kategori, $selected),
                    "recordsFiltered" => $this->laporan->get_count_list_tanah_6($kategori, $selected),
                    "data" => $list,
                );
                echo json_encode($output);
                die;
                break;
            case 'sisa_induk':
                $data = $this->laporan->get_list_tanah_6($kategori, $selected);
                $list = [];
                foreach ($data as $d) {
                    $row = [];
                    $row[] = $d->nama_proyek;
                    $row[] = $d->no_shgb;
                    $row[] = $d->blok;
                    $row[] = $d->luas_terbit;
                    $row[] = '<button onclick="add_items(\'' . $kategori . '\', \'' . $d->id_splitsing . '\', \'' . $d->nama_proyek . '\', \'' . $d->no_shgb . '\', \'' . $d->luas_terbit . '\', \'' . $d->blok . '\')" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button';
                    $list[] = $row;
                }
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->laporan->get_count_list_tanah_6($kategori, $selected),
                    "recordsFiltered" => $this->laporan->get_count_list_tanah_6($kategori, $selected),
                    "data" => $list,
                );
                echo json_encode($output);
                die;
                break;
            case 'splitsing':
                $data = $this->laporan->get_list_tanah_6($kategori, $selected);
                $list = [];
                foreach ($data as $d) {
                    $row = [];
                    $row[] = $d->nama_proyek;
                    $row[] = $d->no_shgb;
                    $row[] = $d->blok;
                    $row[] = $d->luas_terbit;
                    $row[] = '<button onclick="add_items(\'' . $kategori . '\', \'' . $d->id . '\', \'' . $d->nama_proyek . '\', \'' . $d->no_shgb . '\', \'' . $d->luas_terbit . '\', \'' . $d->blok . '\')" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button';
                    $list[] = $row;
                }
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->laporan->get_count_list_tanah_6($kategori, $selected),
                    "recordsFiltered" => $this->laporan->get_count_list_tanah_6($kategori, $selected),
                    "data" => $list,
                );
                echo json_encode($output);
                die;
                break;
        }
    }

    public function dtbl_main_no_6()
    {
        cek_ajax();
        $data = $this->laporan->get_dtbl_no_6();
        $output = [];
        $no = 1;
        foreach ($data as $d) {
            $row = [];

            if ($d->status_penggabungan == 'terbit') {
                $opsi_data = '<a href="#" class="dropdown-item" onclick="opsi_data(\'' . $d->id . '\', \'' . $d->opsi_data . '\', \'' . $d->no_shgb . '\')">Opsi Data</a>';
            } else {
                $opsi_data = '';
            }

            $row[] = '
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle btn-action" type="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-cogs"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="detail_data(\'' . $d->id . '\')" >Detail</a>
                        <a class="dropdown-item" href="#" onclick="edit_data(\'' . $d->id . '\')">Edit</a>
                        <a class="dropdown-item" href="#" onclick="delete_data(\'' . $d->id . '\')">Hapus</a>
                        ' . $opsi_data . '
                    </div>
                </div>
            ';
            $row[] = $no++;
            $row[] = $d->luas_terbit;
            $row[] = $d->no_berkas;
            $row[] = $d->no_shgb;
            $row[] = tgl_indo($d->tgl_daftar);
            $row[] = tgl_indo($d->tgl_terbit);
            $row[] = $d->posisi;
            $row[] = $d->status_penggabungan;
            $row[] = $d->opsi_data;
            $row[] = $d->ket;
            $output[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->laporan->count_all_dtbl_6(),
            "recordsFiltered" => $this->laporan->filtered_dtbl_6(),
            "data" => $output,
        );
        echo json_encode($output);
    }

    public function action_laporan_6()
    {
        cek_ajax();
        $post = $this->input->post(null, true);
        $act = $post['action'];
        switch ($act) {
            case 'add':
                $new_id = time();
                $list_tanah = [];
                $data_type = $this->input->post('type');
                $c_tanah = count($data_type);

                if ($c_tanah <= 0) {
                    $params = [
                        'status' => false,
                        'msg' => 'Harap pilih data tanah'
                    ];
                    echo json_encode($params);
                    die;
                }

                for ($i = 0; $i < $c_tanah; $i++) {
                    $row = [
                        'penggabungan_id' => $new_id,
                        'induk_id' => $post['id_item'][$i],
                        'type' => $post['type'][$i]
                    ];
                    $list_tanah[] = $row;
                }

                $data_penggabungan = [
                    'id' => $new_id,
                    'luas_terbit' => $post['luas_terbit'],
                    'tgl_daftar' => $post['tgl_daftar'],
                    'tgl_terbit' => $post['tgl_terbit'],
                    'no_berkas' => $post['berkas'],
                    'no_shgb' => $post['shgb'],
                    'posisi' => $post['posisi'],
                    'status_penggabungan' => $post['status_penggabungan'],
                    'ket' => $post['keterangan']
                ];

                $this->db->trans_begin();

                $this->db->insert('tbl_penggabungan_induk', $data_penggabungan);
                $this->db->insert_batch('sub_penggabungan_induk', $list_tanah);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $params = [
                        'status' => false,
                        'msg' => 'Penggabungan gagal di tambahkan'
                    ];
                } else {
                    $this->db->trans_commit();
                    $params = [
                        'status' => true,
                        'msg' => 'Penggabungan berhasil di tambahkan'
                    ];
                }
                echo json_encode($params);
                die;
                break;
            case 'detail':
                $id = $post['id'];
                $get_data = $this->db->get_where('sub_penggabungan_induk', ['penggabungan_id' => $id])->result();
                $table_content = '';
                if (!empty($get_data)) {
                    $no = 1;
                    foreach ($get_data as $d) {
                        $qdata = $this->laporan->get_detail_6($d->type, $d->induk_id)->row();

                        if ($d->type == 'splitsing') {
                            $proyek = $qdata->nama_proyek;
                            $shgb = $qdata->no_shgb;
                            $blok = $qdata->blok;
                            $ltbt = $qdata->luas_terbit;
                            $tipe = 'Tanah Splitsing';
                        } else if ($d->type == 'sisa_induk') {
                            $proyek = $qdata->nama_proyek;
                            $shgb = $qdata->no_shgb;
                            $blok = $qdata->blok;
                            $ltbt = $qdata->luas_terbit;
                            $tipe = 'Tanah Sisa Induk';
                        } else if ($d->type == 'induk') {
                            $proyek = $qdata->nama_proyek;
                            $shgb = $qdata->no_terbit_shgb;
                            $blok = '';
                            $ltbt = $qdata->luas_terbit;
                            $tipe = 'Tanah Induk';
                        }


                        $table_content .= '
                                <tr>
                                    <td>' . $no++ . '</td>
                                    <td>' . $proyek . '</td>
                                    <td>' . $shgb . '</td>
                                    <td>' . $blok . '</td>
                                    <td>' . $ltbt . '</td>
                                    <td>' . $tipe . '</td>
                                </tr>
                                ';
                    }
                } else {
                    $table_content = '<tr><td colspan="6">No data result</td></tr>';
                }

                $table = '
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>No</th>
                                <th>Nama Proyek</th>
                                <th>No. SHGB</th>
                                <th>Blok</th>
                                <th>Luas Surat</th>
                                <th>Tipe Tanah</th>
                            </tr>
                        </thead>
                        <tbody>' . $table_content . '</tbody>
                    </table>
                ';
                echo $table;
                break;
            case 'get_edit':
                $id = $this->input->post('id');
                $data_penggabungan = $this->db->get_where('tbl_penggabungan_induk', ['id' => $id])->row();
                $data_sub = $this->db->get_where('sub_penggabungan_induk', ['penggabungan_id' => $id])->result();

                if (!empty($data_sub)) {
                    $sub = [];
                    foreach ($data_sub as $ds) {
                        $qdata = $this->laporan->get_detail_6($ds->type, $ds->induk_id)->row();

                        if ($ds->type == 'induk') {
                            $blok = '';
                            $shgb = $qdata->no_terbit_shgb;
                            $lsurat = $qdata->luas_terbit;
                        } else if ($ds->type == 'sisa_induk') {
                            $blok = $qdata->blok;
                            $shgb = $qdata->no_shgb;
                            $lsurat = $qdata->luas_terbit;
                        } else if ($ds->type == 'splitsing') {
                            $blok = $qdata->blok;
                            $shgb = $qdata->no_shgb;
                            $lsurat = $qdata->luas_terbit;
                        }

                        $row = [
                            'induk_id' => $ds->induk_id,
                            'type' => $ds->type,
                            'proyek' => $qdata->nama_proyek,
                            'blok' => $blok,
                            'shgb' => $shgb,
                            'luas' => $lsurat
                        ];
                        $sub[] = $row;
                    }
                } else {
                    $sub = [];
                }

                $output = [
                    'main' => $data_penggabungan,
                    'sub' => $sub
                ];
                echo json_encode($output);
                die;

                break;
            case 'edit':
                $id = $post['id'];
                $list_tanah = [];
                $data_type = $this->input->post('type');
                $c_tanah = count($data_type);

                if ($c_tanah <= 0) {
                    $params = [
                        'status' => false,
                        'msg' => 'Harap pilih data tanah'
                    ];
                    echo json_encode($params);
                    die;
                }

                for ($i = 0; $i < $c_tanah; $i++) {
                    $row = [
                        'penggabungan_id' => $id,
                        'induk_id' => $post['id_item'][$i],
                        'type' => $post['type'][$i]
                    ];
                    $list_tanah[] = $row;
                }

                $data_penggabungan = [
                    'luas_terbit' => $post['luas_terbit'],
                    'tgl_daftar' => $post['tgl_daftar'],
                    'tgl_terbit' => $post['tgl_terbit'],
                    'no_berkas' => $post['berkas'],
                    'no_shgb' => $post['shgb'],
                    'posisi' => $post['posisi'],
                    'status_penggabungan' => $post['status_penggabungan'],
                    'ket' => $post['keterangan']
                ];

                $this->db->trans_begin();
                $this->db->where('penggabungan_id', $id)->delete('sub_penggabungan_induk');
                $this->db->where('id', $id)->update('tbl_penggabungan_induk', $data_penggabungan);
                $this->db->insert_batch('sub_penggabungan_induk', $list_tanah);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $params = [
                        'status' => false,
                        'msg' => 'Penggabungan gagal di edit'
                    ];
                } else {
                    $this->db->trans_commit();
                    $params = [
                        'status' => true,
                        'msg' => 'Penggabungan berhasil di edit'
                    ];
                }
                echo json_encode($params);
                die;
                break;
            case 'delete':
                $id = $this->input->post('id');
                $this->db->trans_begin();

                $this->db->where('penggabungan_id', $id)->delete('sub_penggabungan_induk');
                $this->db->where('id', $id)->delete('tbl_penggabungan_induk');

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $params = [
                        'status' => false,
                        'msg' => 'Penggabungan gagal di hapus'
                    ];
                } else {
                    $this->db->trans_commit();
                    $params = [
                        'status' => true,
                        'msg' => 'Penggabungan berhasil di hapus'
                    ];
                }
                echo json_encode($params);
                break;
            case 'opsi_data':
                $id = $this->input->post('id');
                $opsi = $this->input->post('opsi');

                $this->db->set('opsi_data', $opsi)->where('id', $id)->update('tbl_penggabungan_induk');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Opsi data berhasil di ubah'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Opsi data gagal di ubah'
                    ];
                }

                echo json_encode($params);
                die;

                break;
        }
    }
    //no 6 end






    //no 10
    public function act_splitsing_10()
    {
        cek_ajax();
        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $new_id = time();
                $induk_id = $this->input->post('induk');
                $blok = $this->input->post('blok');
                $type = $this->input->post('type');
                $luas_blok = $this->input->post('luas_blok');

                $count_blok = count($blok);
                $total_luas_blok = 0;
                $data_sub_splitsing = [];
                for ($i = 0; $i < $count_blok; $i++) {
                    $total_luas_blok += $luas_blok[$i];
                    $row = [
                        'splitsing_id' => $new_id,
                        'blok' => $blok[$i],
                        'luas_daftar' => $luas_blok[$i],
                        'tipe' => $type[$i]
                    ];
                    $data_sub_splitsing[] = $row;
                }


                $data_splitsing = [
                    'id' => $new_id,
                    'proyek_id' => $induk_id,
                    'total_luas_splitsing' => $total_luas_blok,
                    'sisa_induk' => 0,
                    'data_locked' => 0,
                    'create_at' => date('Y-m-d')
                ];



                $this->db->trans_begin();

                $this->db->insert('tbl_splitsing', $data_splitsing);
                $this->db->insert_batch('sub_splitsing', $data_sub_splitsing);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $params = [
                        'status' => false,
                        'msg' => 'Data gagal di tambahkan'
                    ];
                } else {
                    $this->db->trans_commit();
                    $params = [
                        'status' => true,
                        'msg' => 'Data berhasil di tambahkan'
                    ];
                }

                echo json_encode($params);
                die;
                break;
            case 'edit':
                $id = $this->input->post('id');
                $luas_induk = $this->input->post('luas');

                $new_blok = $this->input->post('blok');
                $new_type = $this->input->post('type');
                $b_split_new = $this->input->post('luas_blok');

                $now_blok = $this->input->post('blok_edit');
                $now_type = $this->input->post('type_blok_edit');
                $b_split_now = $this->input->post('luas_blok_edit');
                $id_splitsing = $this->input->post('id_splitsing');


                $c_split_now = count($b_split_now);

                if ($b_split_new) {
                    $c_split_new = count($b_split_new);
                }


                $l_split_now = 0;
                $l_split_new = 0;
                $data_new_split = [];
                for ($a = 0; $a < $c_split_now; $a++) {
                    $l_split_now += $b_split_now[$a];
                }
                if ($b_split_new) {
                    for ($b = 0; $b < $c_split_new; $b++) {
                        $l_split_new += $b_split_new[$b];

                        $row = [
                            'splitsing_id' => $id,
                            'blok' => $new_blok[$b],
                            'luas_daftar' => $b_split_new[$b],
                            'tipe' => $new_type[$b]
                        ];
                        $data_new_split[] = $row;
                    }
                }

                $total_luas_split = $l_split_now + $l_split_new;
                $sisa_induk = $luas_induk - $total_luas_split;


                if ($sisa_induk < 0) {
                    $params = [
                        'status' => false,
                        'msg' => 'Total luas melebihi luas induk'
                    ];
                } else {
                    $this->db->trans_begin();
                    $get_data_splitsing = $this->db->get_where('tbl_splitsing', ['id' => $id])->row();
                    $id_induk = $get_data_splitsing->induk_id;


                    $this->db->set('sisa_induk', $sisa_induk)->where('id', $id_induk)->update('tbl_proses_induk');
                    $this->db->set('sisa_induk', $sisa_induk)->set('total_luas_splitsing', $total_luas_split)->where('id', $id)->update('tbl_splitsing');
                    if ($b_split_new) {
                        $this->db->insert_batch('sub_splitsing', $data_new_split);
                    }
                    for ($i = 0; $i < $c_split_now; $i++) {
                        $update_split = [
                            'blok' => $now_blok[$i],
                            'luas_daftar' => $b_split_now[$i],
                            'tipe' => $now_type[$i]
                        ];
                        $id_has_split = $id_splitsing[$i];
                        $this->db->where('id', $id_has_split)->update('sub_splitsing', $update_split);
                    }


                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $params = [
                            'status' => false,
                            'msg' => 'Data gagal di ubah'
                        ];
                    } else {
                        $this->db->trans_commit();
                        $params = [
                            'status' => true,
                            'msg' => 'Data berhasil di ubah'
                        ];
                    }
                }



                echo json_encode($params);
                die;
                break;
            case 'get_data_edit':
                $id = $this->input->post('id');
                $data_splitsing = $this->laporan->get_data_has_splitsing($id)->row();
                $splitsing = $this->db->get_where('sub_splitsing', ['splitsing_id' => $id])->result();

                $output = [
                    'data' => $data_splitsing,
                    'splitsing' => $splitsing
                ];

                echo json_encode($output);
                die;
                break;
            case 'delete_split':
                $id = $this->input->post('id');
                $subsplit = $this->db->where('id', $id)->get('sub_splitsing')->row();
                $data = $this->db->where('id', $subsplit->splitsing_id)->get('tbl_splitsing')->row();

                $new_sisa = $data->sisa_induk + $subsplit->luas_daftar;
                $new_total = $data->total_luas_splitsing - $subsplit->luas_daftar;

                $update_splitsing = [
                    'total_luas_splitsing' => $new_total,
                    'sisa_induk' => $new_sisa
                ];

                $this->db->trans_begin();

                $this->db->where('id', $data->id)->update('tbl_splitsing', $update_splitsing);
                $this->db->where('id', $id)->delete('sub_splitsing');
                $this->db->set('sisa_induk', $new_sisa)->where('id', $data->induk_id)->update('tbl_proses_induk');

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $params = [
                        'status' => false,
                        'msg' => 'Data gagal di hapus',
                        'id' => $data->id
                    ];
                } else {
                    $this->db->trans_commit();
                    $params = [
                        'status' => true,
                        'msg' => 'Data berhasil di hapus',
                        'id' => $data->id
                    ];
                }
                echo json_encode($params);
                die;
                break;
            case 'get_data_detail':
                $id = $this->input->post('id');
                $data_splitsing = $this->laporan->get_detail_data_splitsing($id)->result();
                $html_output = '';
                $no = 1;
                foreach ($data_splitsing as $ds) {
                    $l_teknik = $ds->luas_daftar;
                    $l_terbit = $ds->luas_terbit;
                    $l_selisih = $l_teknik - $l_terbit;
                    $tgl_daftar = tgl_indo($ds->tgl_daftar);
                    $tgl_terbit = tgl_indo($ds->tgl_terbit);
                    $batas_hgb = tgl_indo($ds->masa_berlaku);

                    if ($ds->status == 'terbit') {
                        $get_tgl_terbit_split = date_create($ds->tgl_terbit);
                        $tgl_terbit_split = date_format($get_tgl_terbit_split, 'Y');
                        $now_year = date('Y');


                        if ($tgl_terbit_split >= $now_year) {
                            $show_lastyear = '<td></td><td></td>';
                            $show_thisyear = '<td>1</td><td>1</td>';
                            $total_terbit = '<td>1</td><td>1</td>';


                            $belum_terbit_split = '<td></td><td></td> <td></td><td></td> <td></td><td></td>';
                            $terbit_stok = $show_lastyear . $show_thisyear . $total_terbit;
                        } else {
                            $show_lastyear = '<td>1</td><td>1</td>';
                            $show_thisyear = '<td></td><td></td>';
                            $total_terbit = '<td>1</td><td>1</td>';


                            $belum_terbit_split = '<td></td><td></td> <td></td><td></td> <td></td><td></td>';
                            $terbit_stok = $show_lastyear . $show_thisyear . $total_terbit;
                        }
                    } else if ($ds->status == 'belum proses') {
                        $belum_proses = '<td>1</td><td>1</td>';
                        $proses = '<td></td><td></td>';
                        $total_belum_terbit = '<td>1</td><td>1</td>';

                        $belum_terbit_split = $belum_proses . $proses . $total_belum_terbit;
                        $terbit_stok = '<td></td><td></td> <td></td><td></td> <td></td><td></td>';
                    } else if ($ds->status == 'proses') {
                        $belum_proses = '<td></td><td></td>';
                        $proses = '<td>1</td><td>1</td>';
                        $total_belum_terbit = '<td>1</td><td>1</td>';

                        $belum_terbit_split = $belum_proses . $proses . $total_belum_terbit;
                        $terbit_stok = '<td></td><td></td> <td></td><td></td> <td></td><td></td>';
                    }




                    $html_output .= '
                        <tr>
                            <td>' . $no . '</td>
                            <td>' . $ds->nama_proyek . '</td>
                            <td>' . $ds->blok . '</td>
                            <td>1</td>
                            <td>' . $l_teknik . '</td>
                            <td>' . $l_terbit . '</td>
                            <td>' . $l_selisih . '</td>
                            <td>' . $ds->no_induk . '</td>
                            <td>' . $ds->no_shgb . '</td>
                            <td>' . $tgl_daftar . '</td>
                            <td>' . $tgl_terbit . '</td>
                            <td>' . $batas_hgb . '</td>
                            ' . $belum_terbit_split . $terbit_stok . '
                        </tr>
                    ';
                    $no++;
                }
                echo $html_output;
                die;
                break;
            case 'key_data':
                $id = $this->input->post('id');
                $type = $this->input->post('type');

                if ($type == 1) {
                    //lock
                    $this->db->set('data_locked', 1);
                } else {
                    //unlock
                    $this->db->set('data_locked', 0);
                }
                $this->db->where('id', $id)->update('tbl_splitsing');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Data berhasil di ubah'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Data gagal di ubah'
                    ];
                }
                echo json_encode($params);
                die;
                break;
            case 'delete_data':
                $id = $this->input->post('id');
                $get_splitsing = $this->db->get_where('tbl_splitsing', ['id' => $id])->row();
                $luas_split = $get_splitsing->total_luas_splitsing;
                $sisa_split = $get_splitsing->sisa_induk;
                $id_induk = $get_splitsing->induk_id;

                $recovery_sisa = $luas_split + $sisa_split;


                $this->db->trans_begin();

                $this->db->set('sisa_induk', $recovery_sisa)->where('id', $id_induk)->update('tbl_proses_induk');
                $this->db->where('id', $id)->delete('tbl_splitsing');
                $this->db->where('splitsing_id', $id)->delete('sub_splitsing');

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $params = [
                        'status' => false,
                        'msg' => 'Data gagal di hapus'
                    ];
                } else {
                    $this->db->trans_commit();
                    $params = [
                        'status' => true,
                        'msg' => 'Data berhasil di hapus'
                    ];
                }
                echo json_encode($params);
                die;
                break;
            case 'opsi_data':
                $id = $this->input->post('id');
                $opsi = $this->input->post('opsi_data');
                $this->db->set('opsi_data', $opsi)->where('id', $id)->update('tbl_proses_induk');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Opsi sisa data berhasil di ubah'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Opsi sisa data gagal di ubah'
                    ];
                }
                echo json_encode($params);
                die;
                break;
            case 'add_split':
                $id_split = $this->input->post('id_split');
                $blok = $this->input->post('blok');
                $type = $this->input->post('type');
                $luas_blok = $this->input->post('luas_blok');

                $count_blok = count($blok);
                $data_sub_splitsing = [];
                for ($i = 0; $i < $count_blok; $i++) {
                    $row = [
                        'splitsing_id' => $id_split,
                        'blok' => $blok[$i],
                        'luas_daftar' => $luas_blok[$i],
                        'tipe' => $type[$i]
                    ];
                    $data_sub_splitsing[] = $row;
                }


                $this->db->trans_begin();

                $this->db->insert_batch('sub_splitsing', $data_sub_splitsing);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $params = [
                        'status' => false,
                        'msg' => 'Splitsing gagal di tambahkan'
                    ];
                } else {
                    $this->db->trans_commit();
                    $params = [
                        'status' => true,
                        'msg' => 'Splitsing berhasil di tambahkan'
                    ];
                }
                echo json_encode($params);

                break;
        }
    }


    //end no 10
}
