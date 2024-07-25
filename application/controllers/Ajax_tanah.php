<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Ajax_tanah extends CI_Controller
{
    public function validation_tanah()
    {
        cek_ajax();
        get_user();
        $this->form_validation->set_rules('proyek_id', 'Proyek', 'required');
        $this->form_validation->set_rules('status_proyek', 'Status Proyek', 'required');
        $this->form_validation->set_rules('nama_penjual', 'Nama Penjual', 'required');
        $this->form_validation->set_rules('tgl_pembelian', 'Tanggal Pembelian', 'required');
        $this->form_validation->set_rules('nama_surat_tanah1', 'Nama Surat Tanah 1', 'required');
        $this->form_validation->set_rules('status_surat_tanah1', 'Status Surat Tanah 1', 'required');
        $this->form_validation->set_rules('nomor_gambar', 'Nomor Gambar', 'required');
        $this->form_validation->set_rules('luas_surat', 'Luas Surat', 'required');
        $this->form_validation->set_rules('luas_ukur', 'Luas Ukur', 'required');
        $this->form_validation->set_rules('total_harga_pengalihan', 'Total Harga Pengalihan', 'required');
        $this->form_validation->set_rules('nama_makelar', 'Nama Makelar', 'required');
        $this->form_validation->set_rules('harga_jual_makelar', 'Harga Jual Makelar', 'required');
        $this->form_validation->set_rules('jenis_pengalihan', 'Jenis Pengalihan', 'required');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_proyek_id' => form_error('proyek_id'),
                'err_status_proyek' => form_error('status_proyek'),
                'err_nama_penjual' => form_error('nama_penjual'),
                'err_tgl_pembelian' => form_error('tgl_pembelian'),
                'err_surat_tanah1' => form_error('nama_surat_tanah1'),
                'err_status_surat1' => form_error('status_surat_tanah1'),
                'err_nomor_gambar' => form_error('nomor_gambar'),
                'err_luas_surat' => form_error('luas_surat'),
                'err_luas_ukur' => form_error('luas_ukur'),
                'err_harga_pengalihan' => form_error('total_harga_pengalihan'),
                'err_nama_makelar' => form_error('nama_makelar'),
                'err_jual_makelar' => form_error('harga_jual_makelar'),
                'err_jenis_pengalihan' => form_error('jenis_pengalihan'),
            ];
            echo json_encode($params);
            die;
        } else {
            $this->to_action_tanah();
        }
    }

    private function to_action_tanah()
    {
        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $data = [
                    'proyek_id' => $this->input->post('proyek_id'),
                    'status_proyek' => $this->input->post('status_proyek'),
                    'nama_penjual' => $this->input->post('nama_penjual'),
                    'tgl_pembelian' => $this->input->post('tgl_pembelian'),
                    'nama_surat_tanah1' => $this->input->post('nama_surat_tanah1'),
                    'status_surat_tanah1' => $this->input->post('status_surat_tanah1'),
                    'keterangan1' => $this->input->post('keterangan1'),
                    'nama_surat_tanah2' => $this->input->post('nama_surat_tanah2'),
                    'status_surat_tanah2' => $this->input->post('status_surat_tanah2'),
                    'keterangan2' => $this->input->post('keterangan2'),
                    'nomor_gambar' => $this->input->post('nomor_gambar'),
                    'luas_surat' => $this->input->post('luas_surat'),
                    'luas_ukur' => $this->input->post('luas_ukur'),
                    'nomor_pbb' => $this->input->post('nomor_pbb'),
                    'atas_nama_pbb' => $this->input->post('atas_nama_pbb'),
                    'luas_bangunan_pbb' => $this->input->post('luas_bangunan_pbb'),
                    'njop_bangunan' => $this->input->post('njop_bangunan'),
                    'luas_bumi_pbb' => $this->input->post('luas_bumi_pbb'),
                    'njop_bumi_pbb' => $this->input->post('njop_bumi_pbb'),
                    'total_harga_pengalihan' => $this->input->post('total_harga_pengalihan'),
                    'nama_makelar' => $this->input->post('nama_makelar'),
                    'harga_jual_makelar' => $this->input->post('harga_jual_makelar'),
                    'jenis_pengalihan' => $this->input->post('jenis_pengalihan'),
                    'biaya_lain_pematangan' => $this->input->post('biaya_lain_pematangan'),
                    'biaya_lain_rugi' => $this->input->post('biaya_lain_rugi'),
                    'biaya_lain_pbb' => $this->input->post('biaya_lain_pbb'),
                    'biaya_lain' => $this->input->post('biaya_lain'),
                    'ket_lain' => $this->input->post('ket_lain'),
                    'ket' => $this->input->post('ket'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('master_tanah', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Tanah baru berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Tanah baru gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $id = $this->input->post('id');

                $data = [
                    'proyek_id' => $this->input->post('proyek_id'),
                    'status_proyek' => $this->input->post('status_proyek'),
                    'nama_penjual' => $this->input->post('nama_penjual'),
                    'tgl_pembelian' => $this->input->post('tgl_pembelian'),
                    'nama_surat_tanah1' => $this->input->post('nama_surat_tanah1'),
                    'status_surat_tanah1' => $this->input->post('status_surat_tanah1'),
                    'keterangan1' => $this->input->post('keterangan1'),
                    'nama_surat_tanah2' => $this->input->post('nama_surat_tanah2'),
                    'status_surat_tanah2' => $this->input->post('status_surat_tanah2'),
                    'keterangan2' => $this->input->post('keterangan2'),
                    'nomor_gambar' => $this->input->post('nomor_gambar'),
                    'luas_surat' => $this->input->post('luas_surat'),
                    'luas_ukur' => $this->input->post('luas_ukur'),
                    'nomor_pbb' => $this->input->post('nomor_pbb'),
                    'atas_nama_pbb' => $this->input->post('atas_nama_pbb'),
                    'luas_bangunan_pbb' => $this->input->post('luas_bangunan_pbb'),
                    'njop_bangunan' => $this->input->post('njop_bangunan'),
                    'luas_bumi_pbb' => $this->input->post('luas_bumi_pbb'),
                    'njop_bumi_pbb' => $this->input->post('njop_bumi_pbb'),
                    'total_harga_pengalihan' => $this->input->post('total_harga_pengalihan'),
                    'nama_makelar' => $this->input->post('nama_makelar'),
                    'harga_jual_makelar' => $this->input->post('harga_jual_makelar'),
                    'jenis_pengalihan' => $this->input->post('jenis_pengalihan'),
                    'biaya_lain_pematangan' => $this->input->post('biaya_lain_pematangan'),
                    'biaya_lain_rugi' => $this->input->post('biaya_lain_rugi'),
                    'biaya_lain_pbb' => $this->input->post('biaya_lain_pbb'),
                    'biaya_lain' => $this->input->post('biaya_lain'),
                    'ket_lain' => $this->input->post('ket_lain'),
                    'ket' => $this->input->post('ket'),
                    'updated_at' => date('Y-m-d H:i:s'),


                ];
                $this->db->where('id', $id)->update('master_tanah', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Tanah berhasil di edit'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Tanah gagal di edit'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function datatable_tanah()
    {
        cek_ajax();
        $get = $this->input->get();

        $list = $this->master->get_tanah_datatable();
        $data = array();
        $i = 1;
        foreach ($list as $r) {
            $row = array();

            if ($r->tgl_akta_pengalihan != null) {
                $tgl_akta_pengalihan = tgl_indo($r->tgl_akta_pengalihan);
            } else {
                $tgl_akta_pengalihan = '-';
            }
            if ($r->proyek_id == '0') {
                $perumahan = 'Tidak ada';
            } else {
                $perumahan = $r->nama_proyek . " " . "($r->nama_status)";
            }
            if ($r->total_harga_pengalihan == 0) {
                $harga_satuan = 0;
                $total_harga_pengalihan = 0;
            } else {
                $total_harga_pengalihan = $r->total_harga_pengalihan;
                $harga_satuan = $r->total_harga_pengalihan / $r->luas_surat;
            }
            if ($r->harga_jual_makelar == 0 || $r->harga_jual_makelar == '') {
                $harga_jual_makelar = 0;
            } else {
                $harga_jual_makelar = $r->harga_jual_makelar;
            }
            if ($r->biaya_lain == 0 || $r->biaya_lain == '') {
                $biaya_lain = 0;
            } else {
                $biaya_lain = $r->biaya_lain;
            }

            if ($r->biaya_lain_pematangan == '') {
                $pematangan = 0;
            } else {
                $pematangan = $r->biaya_lain_pematangan;
            }

            if ($r->biaya_lain_pbb == '') {
                $biaya_lain_pbb = 0;
            } else {
                $biaya_lain_pbb = $r->biaya_lain_pbb;
            }

            if ($r->biaya_lain_rugi == '') {
                $ganti_rugi = 0;
            } else {
                $ganti_rugi = $r->biaya_lain_rugi;
            }

            $totalbiayalain = $biaya_lain + $pematangan + $biaya_lain_pbb + $ganti_rugi;
            $totalharga_biaya = $total_harga_pengalihan + $harga_jual_makelar + $totalbiayalain;
            if ($totalharga_biaya == 0) {
                $harga_perm = 0;
            } else {
                $harga_perm = $totalharga_biaya / $r->luas_ukur;
            }
            $row[] = '
            <div class="dropdown dropright">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="edit_tanah(' . $r->tanah_id . ')">Edit</a>
                        <a class="dropdown-item" href="#" onclick="delete_tanah(' . $r->tanah_id . ')">Hapus</a>
                        <a class="dropdown-item" href="' . site_url('dashboard/pembayaran_tanah/' . $r->tanah_id) . '">Data Pembayaran</a>
                    </div>
                </div>
                ';
            $row[] = $this->security->xss_clean($i);
            $row[] = $this->security->xss_clean($perumahan);
            $row[] = $this->security->xss_clean(tgl_indo($r->tgl_pembelian));
            $row[] = $this->security->xss_clean($r->nama_penjual);
            $row[] = $this->security->xss_clean($r->nama_surat_tanah1);
            $row[] = $this->security->xss_clean($r->kode_sertifikat1);
            $row[] = $this->security->xss_clean($r->keterangan1);

            $row[] = $this->security->xss_clean($r->nama_surat_tanah2);
            $row[] = $this->security->xss_clean($r->kode_sertifikat2);
            $row[] = $this->security->xss_clean($r->keterangan2);

            $row[] = $this->security->xss_clean($r->nomor_gambar);
            $row[] = $this->security->xss_clean($r->luas_surat);
            $row[] = $this->security->xss_clean($r->luas_ukur);
            $row[] = $this->security->xss_clean($r->nomor_pbb);
            $row[] = $this->security->xss_clean($r->luas_bangunan_pbb);
            $row[] = $this->security->xss_clean(rupiah($r->njop_bumi_pbb));
            $row[] = $this->security->xss_clean(rupiah($harga_satuan));
            $row[] = $this->security->xss_clean(rupiah($r->total_harga_pengalihan));
            $row[] = $this->security->xss_clean($r->nama_makelar);
            $row[] = $this->security->xss_clean(rupiah($r->harga_jual_makelar));
            $row[] = $this->security->xss_clean($tgl_akta_pengalihan);
            $row[] = $this->security->xss_clean($r->no_akta_pengalihan);
            $row[] = $this->security->xss_clean($r->atas_nama_pengalihan);

            $row[] = $this->security->xss_clean(rupiah($r->biaya_lain_pematangan));
            $row[] = $this->security->xss_clean(rupiah($r->biaya_lain_rugi));
            $row[] = $this->security->xss_clean(rupiah($r->biaya_lain_pbb));
            $row[] = $this->security->xss_clean(rupiah($r->biaya_lain));
            $row[] = $this->security->xss_clean(rupiah($totalbiayalain));

            $row[] = $this->security->xss_clean(rupiah($totalharga_biaya));
            $row[] = $this->security->xss_clean(rupiah($harga_perm));
            $row[] = $this->security->xss_clean($r->ket);

            $data[] = $row;
            $i++;
        }
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master->count_all_datatable_tanah(),
            "recordsFiltered" => $this->master->count_filtered_datatable_tanah(),
            "data" => $data,
        );
        echo json_encode($result);
    }

    public function detail_tanah()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $get_tanah = $this->master->detail_tanah($id)->row();
        echo json_encode($get_tanah);
        die;
    }
    public function delete_tanah()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('master_tanah');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Master Tanah berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Master Tanah gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function to_action_pembayaran()
    {
        cek_ajax();
        get_user();

        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $total_bayar = $this->input->post('total_bayar');
                $limit = bilanganbulat($this->input->post('limit'));
                $jml = count($total_bayar);
                $jml_all = 0;
                for ($i = 0; $i < $jml; $i++) {
                    $jml_all += $total_bayar[$i];
                }

                if ($jml_all > $limit) {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Total pembayaran melebihi limit'
                    ];
                    echo json_encode($params);
                    die;
                }

                $affected_rows = 0;
                foreach ($this->input->post('tgl_pembayaran') as $key => $item) {
                    $total_bayar = bilanganbulat($this->input->post('total_bayar')[$key]);
                    $array = array(
                        'tanah_id' => $this->input->post('tanah_id'),
                        'tgl_pembayaran' => $item,
                        'status_bayar' => $this->input->post('status_bayar')[$key],
                        'total_bayar' => $total_bayar,
                        'ket' => $this->input->post('ket')[$key],
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' =>  date('Y-m-d H:i:s'),
                    );
                    if ($this->input->post('status_bayar')[$key] == 2) {
                        $array['tgl_realisasi'] = date('y-m-d');
                    }
                    $this->db->insert("tbl_pembayaran_tanah", $array);
                    $affected_rows += $this->db->affected_rows();
                }

                if ($affected_rows > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Pembayaran baru berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Pembayaran baru gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                die;
                break;
            case 'edit':
                $id = $this->input->post('id');

                $total_bayar = $this->input->post('total_bayar');
                $limit = bilanganbulat($this->input->post('limit'));


                if ($total_bayar > $limit) {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Total pembayaran melebihi limit'
                    ];
                    echo json_encode($params);
                    die;
                }

                $data = [
                    'tgl_pembayaran' => $this->input->post('tgl_pembayaran'),
                    'tgl_realisasi' => $this->input->post('tgl_realisasi'),
                    'status_bayar' => $this->input->post('status_bayar'),
                    'total_bayar' =>  $this->input->post('total_bayar'),
                    'ket' => $this->input->post('ket'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->where('id', $id)->update('tbl_pembayaran_tanah', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Pembayaran tanah berhasil di edit'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Pembayaran tanah gagal di edit'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }
    public function get_data_pembayaran($tanah_id)
    {
        cek_ajax();
        $draw = intval($this->input->get("draw"));
        $query = $this->db->select("a.id,a.status_bayar, a.tanah_id, a.tgl_pembayaran, a.total_bayar, a.tgl_realisasi, a.ket")
            ->from("tbl_pembayaran_tanah a")
            ->where('a.tanah_id', $tanah_id)
            ->get();
        $data = [];
        $no = 1;
        foreach ($query->result() as $r) {
            if ($r->status_bayar == '1') {
                $status = '<a class="btn btn-danger btn-sm">Belum Terbayar</a>';
                // $status ='lunas';
            } else {
                $status = '<a class="btn btn-success btn-sm">Sudah Terbayar</a>';
            }

            $data[] = array(
                '
                <div class="dropdown dropright">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                Action</button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="edit_pembayaran(' . $this->security->xss_clean($r->id) . ')">Bayar</a>
                        <a class="dropdown-item" href="#" onclick="delete_pembayaran(' . $this->security->xss_clean($r->id) . ')">Hapus</a>
                    </div>
                </div>
            ',
                $no++,
                $this->security->xss_clean(tgl_indo($r->tgl_pembayaran)),
                $this->security->xss_clean(tgl_indo($r->tgl_realisasi)),
                $this->security->xss_clean(rupiah($r->total_bayar)),
                $this->security->xss_clean($status),
                $this->security->xss_clean($r->ket),
            );
        }
        $result = array(
            "draw" => $draw,
            "recordsTotal" => $query->num_rows(),
            "recordsFiltered" => $query->num_rows(),
            "data" => $data,
        );
        echo json_encode($result);
    }
    public function detail_pembayaran()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $get_pembayaran = $this->db->get_where('tbl_pembayaran_tanah', ['id' => $id])->row();
        echo json_encode($get_pembayaran);
        die;
    }
    public function delete_pembayaran()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('tbl_pembayaran_tanah');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Pembayaran Tanah berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Pembayaran Tanah gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    // MENU NO. 6 START
    public function validation_penggabungan()
    {
        cek_ajax();
        get_user();
        $this->form_validation->set_rules('stat_peng', 'Status Penggabungan', 'required');
        $this->form_validation->set_rules('tgl_daftar', 'Tanggal Daftar', 'required');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_stat_peng' => form_error('stat_peng'),
                'err_tgl_daftar' => form_error('tgl_daftar'),
            ];
            echo json_encode($params);
            die;
        } else {
            $this->to_action_penggabungan();
        }
    }

    private function to_action_penggabungan()
    {
        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $data = [
                    'luas_terbit' => $this->input->post('luas_terbit'),
                    'status_penggabungan' => $this->input->post('stat_peng'),
                    'tgl_daftar' => $this->input->post('tgl_daftar'),
                    'tgl_terbit' => $this->input->post('tgl_terbit'),
                    'no_berkas' => $this->input->post('no_berkas'),
                    'no_shgb' => $this->input->post('no_shgb'),
                    'posisi' => $this->input->post('posisi'),
                    'ket' => $this->input->post('ket'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('tbl_penggabungan_induk', $data);

                $id_penggabungan_induk =  $this->db->insert_id();
                $id_induk = $this->input->post('id_induk');
                $blok = $this->input->post('blok');

                $count_induk = count((array)$id_induk);
                $data_sub = array();
                for ($i = 0; $i < $count_induk; $i++) {
                    $data_sub[] = [
                        'penggabungan_id' => $id_penggabungan_induk,
                        'induk_id' => $id_induk[$i],
                        'blok' => $blok[$i],
                    ];
                }
                $this->db->insert_batch('sub_penggabungan_induk', $data_sub);

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
                    'luas_terbit' => $this->input->post('luas_terbit'),
                    'status_penggabungan' => $this->input->post('stat_peng'),
                    'tgl_daftar' => $this->input->post('tgl_daftar'),
                    'tgl_terbit' => $this->input->post('tgl_terbit'),
                    'no_berkas' => $this->input->post('no_berkas'),
                    'no_shgb' => $this->input->post('no_shgb'),
                    'posisi' => $this->input->post('posisi'),
                    'ket' => $this->input->post('ket'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->where('id', $id)->update('tbl_penggabungan_induk', $data);
                $this->db->where('penggabungan_id', $id)->delete('sub_penggabungan_induk');

                $id_induk = $this->input->post('id_induk');
                $blok = $this->input->post('blok');

                $count_induk = count((array)$id_induk);
                $data_sub = array();
                for ($i = 0; $i < $count_induk; $i++) {
                    $data_sub[] = [
                        'penggabungan_id' => $id,
                        'induk_id' => $id_induk[$i],
                        'blok' => $blok[$i],
                    ];
                }
                $this->db->insert_batch('sub_penggabungan_induk', $data_sub);

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

    public function ajax_detail_penggabungan_perum()
    {
        cek_ajax();
        get_user();
        $id_penggabungan = $this->input->post('id');
        $data = $this->laporan->get_evaluasi_revisi_split(null, null, null, $id_penggabungan)->row();
        $list = $this->laporan->list_penggabungan_induk($id_penggabungan)->result();
        $list_perum = '';
        $no = 1;
        foreach ($list as $l) {
            $list_perum .= '<tr>
                                <td>' . $no++ . '</td>
                                <td>' . $l->nama_proyek . '</td>
                                <td>' . $l->no_terbit_shgb . '</td>
                                <td>' . $l->blok . '</td>
                            </tr>';
        }

        $luas_daftar = $data->luas_daftar;
        $luas_terbit = $data->luas_terbit;
        $luas_selisih = $luas_daftar - $luas_terbit;

        $html2 =    '<div class="row">
                        <div class="col-12">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th>No</th>
                                        <th>No. SHGB</th>
                                        <th>Luas Terbit Induk</th>
                                        <th>Blok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                ' . $list_perum . '
                                </tbody>
                            </table>
                        </div>
                    </div>';

        $html1 =    '<div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th>Perumahan</th>
                                    <td>' . $data->nama_proyek . '</td>
                                </tr>
                                <tr>
                                    <th>Blok</th>
                                    <td>' . $data->nomor_gambar . '</td>
                                </tr>

                                <tr>
                                    <th>Luas Daftar</th>
                                    <td>' . $data->luas_daftar . '</td>
                                </tr>

                                <tr>
                                    <th>Luas Terbit</th>
                                    <td>' . $data->luas_terbit . '</td>
                                </tr>

                                <tr>
                                    <th>Luas Selisih</th>
                                    <td>' . $luas_selisih . '</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th>Tanggal Daftar</th>
                                    <td>' . tgl_indo($data->tgl_daftar) . '</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Terbit</th>
                                    <td>' . tgl_indo($data->tgl_terbit) . '</td>
                                </tr>

                                <tr>
                                    <th>No. Berkas</th>
                                    <td>' . $data->no_berkas . '</td>
                                </tr>

                                <tr>
                                    <th>No. SHGB</th>
                                    <td>' . $data->no_shgb . '</td>
                                </tr>

                                <tr>
                                    <th>Posisi</th>
                                    <td>' . $data->posisi . '</td>
                                </tr>

                                <tr>
                                    <th>Ket</th>
                                    <td>' . $data->ket_penggabungan . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>';


        echo $html1 . $html2;
    }

    public function get_penggabungan_tanah()
    {
        cek_ajax();
        get_user();
        $id_penggabungan = $this->input->post('id');

        $data = [
            'data' => $this->laporan->get_evaluasi_revisi_split(null, null, null, $id_penggabungan)->row(),
            'list' => $this->laporan->list_penggabungan_induk($id_penggabungan)->result()
        ];

        echo json_encode($data);
    }

    public function delete_penggabungan()
    {
        cek_ajax();
        get_user();

        $id = $this->input->post('id');
        $this->db->trans_begin();

        $this->db->delete('tbl_penggabungan_induk', ['id' => $id]);
        $this->db->delete('sub_penggabungan_induk', ['penggabungan_id' => $id]);

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
    }
    // MENU NO. 6 END
}
