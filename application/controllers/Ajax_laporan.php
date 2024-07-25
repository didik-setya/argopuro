<?php
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
        $this->form_validation->set_rules('tgl_daftar_sk_hak', 'Tanggal Daftar SK Hak', 'required');
        $this->form_validation->set_rules('status_induk', 'Status Induk', 'required');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_no_gambar' => form_error('no_gambar'),
                'err_tgl_daftar_sk' => form_error('tgl_daftar_sk_hak'),
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
                    'status_tanah' => $this->input->post('status_tanah', true)
                ];
                $this->db->insert('tbl_proses_induk', $data);

                $id_proses_induk =  $this->db->insert_id();
                $id_tanah = $this->input->post('tanah_id');
                $ket_sub = $this->input->post('ket_sub');

                $count_tanah = count((array)$id_tanah);
                $data_sub = array();
                for ($i = 0; $i < $count_tanah; $i++) {
                    $data_sub[] = [
                        'induk_id' => $id_proses_induk,
                        'tanah_id' => $id_tanah[$i],
                        'ket_sub' => $ket_sub[$i],
                    ];
                }
                $this->db->insert_batch('sub_proses_induk', $data_sub);

                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Proses Induk berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Proses Induk gagal di tambahkan'
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
                    'status_tanah' => $this->input->post('status_tanah', true)
                ];
                $this->db->where('id', $id)->update('tbl_proses_induk', $data);
                $this->db->where('induk_id', $id)->delete('sub_proses_induk');

                $sub_id = $this->input->post('sub_id');
                $id_tanah = $this->input->post('tanah_id');

                $ket_sub = $this->input->post('ket_sub');

                $count_tanah = count((array)$id_tanah);
                $data_sub = array();
                for ($i = 0; $i < $count_tanah; $i++) {
                    $data_sub[] = [
                        'induk_id' => $id,
                        'tanah_id' => $id_tanah[$i],
                        'ket_sub' => $ket_sub[$i],
                    ];
                }
                $this->db->insert_batch('sub_proses_induk', $data_sub);

                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Proses Induk berhasil di edit'
                    ];
                } else {
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
        $get_data = $this->laporan->get_list_data_tanah($status);
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
            "recordsTotal" => $this->laporan->count_all_list_tanah($status),
            "recordsFiltered" => $this->laporan->get_filtered_list_tanah($status),
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
            case 'add':
                $new_splitsing_id = time();

                $splitsing = [];
                $blok = $this->input->post('blok');
                $jml_blok = count($blok);

                $limit_luas = $this->input->post('lterbit');
                $form_luas_dft = $this->input->post('l_dft');
                $jml_luas = 0;

                for ($i = 0; $i < $jml_blok; $i++) {

                    $jml_luas += $form_luas_dft[$i];

                    $row = [
                        'splitsing_id' => $new_splitsing_id,
                        'blok' => $blok[$i],
                        'luas_daftar' => $this->input->post('l_dft', true)[$i],
                        'luas_terbit' => $this->input->post('l_tbt', true)[$i],
                        'no_shgb' => $this->input->post('shgb', true)[$i],
                        'masa_berlaku' => $this->input->post('exp', true)[$i],
                        'tgl_terbit' => $this->input->post('tgl', true)[$i],
                        'keterangan' => $this->input->post('ket')[$i]
                    ];
                    $splitsing[] = $row;
                }
                $sisa_induk = $limit_luas - $jml_luas;
                $data_splitsing = [
                    'id' => $new_splitsing_id,
                    'induk_id' => $this->input->post('induk', true),
                    'no_daftar' => $this->input->post('no_daftar', true),
                    'tgl_daftar' => $this->input->post('tgl_daftar', true),
                    'status' => $this->input->post('status', true),
                    'total_luas_splitsing' => $jml_luas,
                    'sisa_induk' => $sisa_induk,
                    'create_at' => date('Y-m-d')
                ];


                if ($jml_luas > $limit_luas) {
                    $params = [
                        'status' => false,
                        'msg' => 'Total luas daftar melebihi limit luas induk',
                        'tot' => $jml_luas,
                        'limit' => $limit_luas
                    ];
                } else {

                    $this->db->trans_begin();

                    $this->db->insert('tbl_splitsing', $data_splitsing);
                    $this->db->insert_batch('sub_splitsing', $splitsing);

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $params = [
                            'status' => false,
                            'msg' => 'Gagal menambahkan data'
                        ];
                    } else {
                        $this->db->trans_commit();
                        $params = [
                            'status' => true,
                            'msg' => 'Data berhasil di tambahkan'
                        ];
                    }
                }
                echo json_encode($params);
                die;
                break;
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
                $data_splitsing = $this->laporan->get_data_has_splitsing($id)->row();
                $splitsing = $this->db->get_where('sub_splitsing', ['splitsing_id' => $id])->result();

                $output = [
                    'data' => $data_splitsing,
                    'splitsing' => $splitsing
                ];
                echo json_encode($output);
                break;
            case 'edit':

                $blok = $this->input->post('blok');
                $jml_blok = count($blok);

                $limit_luas = $this->input->post('lterbit');
                $form_luas_dft = $this->input->post('l_dft');

                $jml_luas = 0;
                for ($i = 0; $i < $jml_blok; $i++) {
                    $jml_luas += $form_luas_dft[$i];
                }
                $sisa_induk = $limit_luas - $jml_luas;
                if ($sisa_induk < 0) {
                    $params = [
                        'status' => false,
                        'msg' => 'Total luas daftar melebihi limit luas induk',
                        'tot' => $jml_luas,
                        'limit' => $limit_luas
                    ];
                } else {

                    $this->db->trans_begin();

                    for ($i = 0; $i < $jml_blok; $i++) {
                        $row = [
                            'blok' => $blok[$i],
                            'luas_daftar' => $this->input->post('l_dft', true)[$i],
                            'luas_terbit' => $this->input->post('l_tbt', true)[$i],
                            'no_shgb' => $this->input->post('shgb', true)[$i],
                            'masa_berlaku' => $this->input->post('exp', true)[$i],
                            'tgl_terbit' => $this->input->post('tgl', true)[$i],
                            'keterangan' => $this->input->post('ket')[$i]
                        ];
                        $id_split = $this->input->post('id_split', true)[$i];
                        $this->db->where('id', $id_split)->update('sub_splitsing', $row);
                    }

                    $data_splitsing = [
                        'no_daftar' => $this->input->post('no_daftar', true),
                        'tgl_daftar' => $this->input->post('tgl_daftar', true),
                        'status' => $this->input->post('status', true),
                        'total_luas_splitsing' => $jml_luas,
                        'sisa_induk' => $sisa_induk,
                        'create_at' => date('Y-m-d')
                    ];
                    $this->db->where('id', $id)->update('tbl_splitsing', $data_splitsing);
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $params = [
                            'status' => false,
                            'msg' => 'Data gagal di edit'
                        ];
                    } else {
                        $this->db->trans_commit();
                        $params = [
                            'status' => true,
                            'msg' => 'Data berhasil di edit'
                        ];
                    }
                }

                echo json_encode($params);
                die;
                break;
            case 'delete_split':
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
            case 'delete_data':

                $this->db->trans_begin();

                $this->db->delete('tbl_splitsing', ['id' => $id]);
                $this->db->delete('sub_splitsing', ['splitsing_id' => $id]);

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
}
