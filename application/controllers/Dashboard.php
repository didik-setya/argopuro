<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'user' => get_user(),
            'view' => 'dashboard/index'
        ];
        $this->load->view('dashboard', $data);
    }

    public function master_role()
    {
        $data = [
            'title' => 'Master Role User',
            'user' => get_user(),
            'view' => 'dashboard/master_role',
            'data' => $this->db->get('user_role')->result()
        ];
        $this->load->view('dashboard', $data);
    }

    public function master_user()
    {
        $data = [
            'title' => 'Master User',
            'user' => get_user(),
            'view' => 'dashboard/master_user',
            'role' => $this->db->get('user_role')->result(),
            'data' => $this->model->get_data_user()->result()
        ];
        $this->load->view('dashboard', $data);
    }

    public function master_menu()
    {
        $data = [
            'title' => 'Master Menu',
            'user' => get_user(),
            'view' => 'dashboard/master_menu',
            'menu_dropdown' => $this->db->get_where('menu', ['type' => 2, 'status' => 1])->result(),
            'data' => $this->db->where(['type !=' => 3, 'status' => 1])->get('menu')->result()
        ];
        $this->load->view('dashboard', $data);
    }

    public function access_menu()
    {
        $data = [
            'title' => 'Master Access Menu',
            'user' => get_user(),
            'view' => 'dashboard/access_menu',
            'role' => $this->db->get('user_role')->result(),
            'menu' => $this->db->where(['type !=' => 3, 'status' => 1])->get('menu')->result()
        ];
        $this->load->view('dashboard', $data);
    }

    public function master_proyek()
    {
        $data = [
            'title' => 'Master Proyek',
            'user' => get_user(),
            'view' => 'dashboard/master_proyek',
            'kab' => $this->db->get('kabupaten')->result(),
            'data' => $this->model->get_master_proyek()->result()
        ];
        $this->load->view('dashboard', $data);
    }

    public function master_tanah()
    {
        $data = [
            'title' => 'Master Tanah',
            'user' => get_user(),
            'view' => 'dashboard/master_tanah',
            'data' => $this->master->get_data_tanah()->result(),
            'proyek' => $this->db->get('master_proyek')->result(),
            'status_proyek' => $this->db->get('master_status_proyek')->result(),
            'sertifikat_tanah' => $this->db->get('master_sertifikat_tanah')->result(),
            'jenis_pengalihan' => $this->db->get('master_jenis_pengalihan')->result(),
            'menu' => $this->db->where(['type !=' => 3, 'status' => 1])->get('menu')->result()
        ];
        $this->load->view('dashboard', $data);
    }
    public function pembayaran_tanah($tanah_id)
    {
        $total_pembayaran = 0;

        $query = $this->db->query("select * from master_tanah where id='" . $tanah_id . "'");
        foreach ($query->result() as $data_tanah) {
            $data['tanah_milik'] = $data_tanah->nama_penjual;
            $data['tgl_pembelian'] = $data_tanah->tgl_pembelian;
            $data['luas_surat'] = $data_tanah->luas_surat;
            $harga_jual_makelar = 0;
            $biaya_lain = 0;
            if ($data_tanah->harga_jual_makelar == 0 || $data_tanah->harga_jual_makelar == '') {
                $harga_jual_makelar = 0;
            } else {
                $harga_jual_makelar = $data_tanah->harga_jual_makelar;
            }

            if ($data_tanah->biaya_lain == 0 || $data_tanah->biaya_lain == '') {
                $biaya_lain = 0;
            } else {
                $biaya_lain = $data_tanah->biaya_lain;
            }
            $total_pembayaran = $data_tanah->total_harga_pengalihan + $biaya_lain + $harga_jual_makelar;
            $data['total_harga_pengalihan'] = rupiah($total_pembayaran);
        }

        // $query = $this->db->query("select status_bayar, tanah_id, tgl_, total_bayar, keterangan from tabel_pembayaran where kode_item='" . $kode_item . "' and status_bayar=1 ");
        $data_pembayaran = $this->db->get_where('tbl_pembayaran_tanah', ['tanah_id' => $tanah_id, 'status_bayar' => 2])->result();

        $total_sudah_dibayar = 0;
        $pembayaran_terakhir = 0;
        foreach ($data_pembayaran as $dp) {
            $total_sudah_dibayar += $dp->total_bayar;
            $pembayaran_terakhir = $dp->total_bayar;
        }

        $data = [
            'title' => 'Data Pembayaran Tanah',
            'user' => get_user(),
            'view' => 'dashboard/pembayaran_tanah',
            'id_tanah' => $this->db->get_where('master_tanah', ['id' => $tanah_id])->row(),
            'harga_beli' => rupiah($total_pembayaran),
            'pembayaran_terakhir' => rupiah($total_sudah_dibayar),
            'total_belum_dibayar' => rupiah($total_pembayaran - $total_sudah_dibayar),
            'limit' => rupiah($total_pembayaran - $total_sudah_dibayar),
            'tanah_id' => $tanah_id
        ];

        $this->load->view('dashboard', $data);
    }
    public function master_operasional()
    {
        $data = [
            'title' => 'Master Tanah',
            'user' => get_user(),
            'view' => 'dashboard/master_operasional',
            'data' => $this->db->get('master_operasional')->result(),
        ];
        $this->load->view('dashboard', $data);
    }
    public function master_sertifikat_tanah()
    {
        $data = [
            'title' => 'Master Sertifikat Tanah',
            'user' => get_user(),
            'view' => 'dashboard/master_sertifikat',
            'data' => $this->db->get('master_sertifikat_tanah')->result(),
        ];
        $this->load->view('dashboard', $data);
    }
    public function master_jenis_pengalihan()
    {
        $data = [
            'title' => 'Master Sertifikat Tanah',
            'user' => get_user(),
            'view' => 'dashboard/master_jenis_pengalihan',
            'data' => $this->db->get('master_jenis_pengalihan')->result(),
        ];
        $this->load->view('dashboard', $data);
    }


    public function target_proyek($id = null)
    {
        $proyek = $this->db->where('id', $id)->get('master_proyek')->row();

        if ($proyek) {
            $data = [
                'title' => 'Target Proyek',
                'user' => get_user(),
                'view' => 'dashboard/target_proyek',
                'proyek' => $proyek,
                'bulan' => $this->model->get_month_data(),
                'data' => $this->model->get_target_proyek($id)->result()
            ];
            $this->load->view('dashboard', $data);
        } else {
            redirect(base_url('dashboard/master_proyek'));
        }
    }


    public function laporan()
    {
        $data = [
            'title' => 'Data Laporan',
            'user' => get_user(),
            'view' => 'dashboard/laporan',
            'data' => $this->model->all_menu_in_laporan()
        ];
        $this->load->view('dashboard', $data);
    }

    //LAPORAN NO.1 START
    public function proses_ijin_lokasi()
    {
        $data = [
            'title' => 'Data Proses Ijin Lokasi',
            'tanah_proyek' => $this->db->get('master_proyek')->result(),
            'user' => get_user(),
            'view' => 'laporan/1/proses_ijin_lokasi',
            'lokasi' => $this->model->get_lokasi_proses_ijin()->result(),
            'status' => $this->db->get('master_status_proyek')->result()
        ];
        $this->load->view('dashboard', $data);
    }

    public function ijin_lokasi()
    {
        $data = [
            'title' => 'Evaluasi Terbit Ijin',
            'tanah_proyek' => $this->db->get('master_proyek')->result(),
            'user' => get_user(),
            'view' => 'laporan/1/rinci_ijin_lokasi',
            'status' => $this->db->get('master_status_proyek')->result()
        ];
        $this->load->view('dashboard', $data);
    }
    //LAPORAN NO.1 END

    //LAPORAN NO.2 START
    public function evaluasi_pembelian_tanah()
    {
        $data = [
            'title' => 'Data Evaluasi Pembelian Tanah',
            'user' => get_user(),
            'view' => 'laporan/2/evaluasi_pembelian_tanah',
            'tanah_proyek' => $this->db->get('master_proyek')->result(),
            'status_proyek' => $this->db->get('master_status_proyek')->result(),
        ];
        $this->load->view('dashboard', $data);
    }
    public function rekap_pembelian_tanah()
    {
        $proyek = $this->input->get('proyek');
        $status = $this->input->get('status');
        $date_a = $this->input->get('date_a');
        $date_b = $this->input->get('date_b');

        $data = [
            'ip_luar_ijin' => $this->get_rekap_pembelian('1', $proyek, $status, $date_a, $date_b),
            'ip_dalam_ijin' => $this->get_rekap_pembelian('2', $proyek, $status, $date_a, $date_b),
            'ip_lokasi' => $this->get_rekap_pembelian('3', $proyek, $status, $date_a, $date_b),
            'title' => 'Data Evaluasi Pembelian Tanah',
            'user' => get_user(),
            'view' => 'laporan/2/rekap_pembelian_tanah',
            'pro' => $this->laporan->get_proyek_by_tanah()->result(),
            'proyek' => $this->db->get('master_proyek')->result(),
        ];


        $this->load->view('dashboard', $data);
    }
    private function get_rekap_pembelian($jenis = null, $proyek = null, $status = null, $date_a = null, $date_b = null)
    {
        $data_rekap = $this->laporan->get_rekap_tanah_menu2($jenis, $proyek, $status, $date_a, $date_b);
        $data = array();
        foreach ($data_rekap as $r) {

            $datatarget = $this->laporan->get_target_menu2($r->proyek_id, date('Y'), $jenis);
            $target_luas = 0;
            $target_bidang = 0;

            $awalbulan = date('Y-01-01');
            $tengahbulan = date('Y-06-30');
            $akhirbulan = date('Y-12-31');


            $datarealisasisebelum = $this->laporan->get_realisasi_menu2($r->proyek_id, $awalbulan, $tengahbulan, $jenis);
            $datarealisasisesudah = $this->laporan->get_realisasi_menu2($r->proyek_id, $tengahbulan, $akhirbulan, $jenis);

            if (empty($datatarget)) {
            } else {
                $proyek = $r->proyek_id;
                $status_proyek = $r->status_proyek;
                $target_luas = $this->db->select('SUM(target_luas) as luas')
                    ->from('master_proyek_target')
                    ->where('master_proyek_target.proyek_id', $proyek)
                    ->get()->row()->luas;
                $target_bidang = $this->db->select('SUM(target_bidang) as bidang')
                    ->from('master_proyek_target')
                    ->where('master_proyek_target.proyek_id', $proyek)
                    ->get()->row()->bidang;
            }
            $row = array();

            $row[] = $this->security->xss_clean($r->id_tanah);
            $row['nama_proyek'] = $this->security->xss_clean($r->nama_proyek);
            // $row[] = $this->security->xss_clean($r->lokasi);
            $row['bidtarget'] = $this->security->xss_clean($target_bidang);
            $row['luastarget'] = $this->security->xss_clean($target_luas);
            $row['bidrealsebelum'] = $this->security->xss_clean($datarealisasisebelum['bid']);
            if ($datarealisasisebelum['luas'] == '') {
                $row['luasrealsebelum'] = $this->security->xss_clean(0);
            } else {
                $row['luasrealsebelum'] = $this->security->xss_clean($datarealisasisebelum['luas']);
            }
            $row['bidrealsesudah'] = $this->security->xss_clean($datarealisasisesudah['bid']);
            if ($datarealisasisesudah['luas'] == '') {
                $row['luasrealsesudah'] = $this->security->xss_clean(0);
            } else {
                $row['luasrealsesudah'] = $this->security->xss_clean($datarealisasisesudah['luas']);
            }
            $row['datatarget'] = $this->security->xss_clean($datatarget);
            $row['status'] = $this->security->xss_clean($r->nama_status);
            $luastarget = 0;
            $bidtarget = 0;
            $data[] = $row;
        }
        return $data;
    }
    //LAPORAN NO.2 END

    //LAPORAN NO.3 START
    public function evaluasi_landbank()
    {
        $data = [
            'title' => 'Evaluasi Rekap Land Bank',
            'user' => get_user(),
            'view' => 'laporan/3/rekap_landbank',
            'status_proyek' => $this->db->get('master_status_proyek')->result(),
            'proyek' => $this->db->get('master_proyek')->result()
        ];
        $this->load->view('dashboard', $data);
    }

    public function landbank_perum()
    {
        $data = [
            'title' => 'Evaluasi Land Bank Perumahan',
            'user' => get_user(),
            'view' => 'laporan/3/landbank_perum'
        ];
        $this->load->view('dashboard', $data);
    }
    //LAPORAN NO.3 END

    //LAPORAN NO.4 START

    public function evaluasi_belum_shgb()
    {
        $data = [
            'title' => 'Rekap Evaluasi Tanah Belum SHGB',
            'user' => get_user(),
            'view' => 'laporan/4/evaluasi_belum_shgb'
        ];
        $this->load->view('dashboard', $data);
    }

    public function belum_shgb_perum()
    {
        $data = [
            'title' => 'Evaluasi Tanah Belum SHGB',
            'user' => get_user(),
            'view' => 'laporan/4/belum_shgb_perum'
        ];
        $this->load->view('dashboard', $data);
    }

    //LAPORAN NO.4 END

    //LAPORAN NO.5 START
    public function evaluasi_data_proses_induk()
    {
        $data = [
            'title' => 'Evaluasi Proses Induk',
            'user' => get_user(),
            'view' => 'laporan/5/new_evaluasi_data'
        ];
        $this->load->view('dashboard', $data);
    }
    public function rekap_data_proses_induk()
    {
        $proyek_id = $this->input->get('proyek');
        $status = $this->input->get('status');

        $data = [
            'title' => 'Rekap Data Proses Induk',
            'user' => get_user(),
            'tanah_proyek' => $this->db->get('master_proyek')->result(),
            'rekap_induk' => $this->laporan->get_rekap_proses_induk(null, null, $proyek_id, null, null, $status)->result(),
            'view' => 'laporan/5/rekap_data_proses_induk'
        ];
        $this->load->view('dashboard', $data);
    }

    public function edit_perindukan()
    {
        $id = $this->input->get('induk');
        if (!$id) {
            redirect(base_url('dashboard/evaluasi_data_proses_induk'));
        } else {
            $data_induk = $this->laporan->get_data_proses_induk(null, null, null, $id)->row();
            $data_tanah = $this->laporan->get_data_subproses_induk($id)->result();

            if ($data_induk) {
                $data = [
                    'title' => 'Rekap Data Proses Induk',
                    'user' => get_user(),
                    'view' => 'laporan/5/edit_perindukan',
                    'induk' => $data_induk,
                    'tanah' => $data_tanah,
                    'id' => $id
                ];
                $this->load->view('dashboard', $data);
            } else {
                redirect(base_url('dashboard/evaluasi_data_proses_induk'));
            }
        }
    }
    //LAPORAN NO.5 END

    //LAPORAN NO.6 START
    public function rekap_revisi_split()
    {
        $proyek_id = $this->input->get('proyek');
        $status = $this->input->get('status');

        $data = [
            'title' => 'Evaluasi Data Penggabungan Induk',
            'tanah_proyek' => $this->db->get('master_proyek')->result(),
            'user' => get_user(),
            'rekap_penggabungan' => $this->laporan->get_rekap_penggabungan_split(null, null, $proyek_id, null, null, $status)->result(),
            'view' => 'laporan/6/rekap_penggabungan_revisi_split'
        ];
        $this->load->view('dashboard', $data);
    }
    public function evaluasi_revisi_split()
    {
        $proyek_id = $this->input->get('proyek');
        $status = $this->input->get('status');
        // $proyek_id = $get['proyek_id'];

        $data = [
            'title' => 'Evaluasi Rekap Penggabungan Induk',
            // 'tanah_proyek' => $this->db->get('master_proyek')->result(),
            // 'data_old' => $this->laporan->get_evaluasi_revisi_split($proyek_id, '1970-01-01', (date('Y') - 1) . '-12-31', null, $status)->result(),
            // 'data_new' => $this->laporan->get_evaluasi_revisi_split($proyek_id, date('Y' . '-01-01'), date('Y') . '-12-31', null, $status)->result(),
            // 'data_list' => $this->laporan->get_list_tambah_tanah_induk()->result(),
            'user' => get_user(),
            'view' => 'laporan/6/new_evaluasi'
        ];
        $this->load->view('dashboard', $data);
    }

    //LAPORAN NO.6 END

    //LAPORAN NO.7 START
    public function rekap_sudah_shgb()
    {
        $proyek = $this->input->get('proyek');
        $data = [
            'title' => 'Evaluasi Data Proses Induk',
            'user' => get_user(),
            'view' => 'laporan/7/rekap_tanah_sudah_shgb',
            'data' => $this->laporan->get_data_rekap_shgb($proyek)->result()
        ];
        $this->load->view('dashboard', $data);
    }

    public function evaluasi_sudah_shgb()
    {
        $proyek_id = $this->input->get('proyek_id');
        $data = [
            'title' => 'Evaluasi Data Proses Induk',
            'user' => get_user(),
            'view' => 'laporan/7/evaluasi_tanah_sudah_shgb'
        ];
        $this->load->view('dashboard', $data);
    }
    //LAPORAN NO.7 END

    //LAPORAN NO.8 START
    public function rekap_proses_splitsing()
    {
        $proyek_id = $this->input->get('proyek_id');
        $data = [
            'title' => 'Evaluasi Data Proses Induk',
            'user' => get_user(),
            'view' => 'laporan/8/rekap_proses_splitsing'
        ];
        $this->load->view('dashboard', $data);
    }
    public function evaluasi_proses_splitsing()
    {
        $proyek_id = $this->input->get('proyek_id');
        $data = [
            'title' => 'Evaluasi Data Proses Induk',
            'user' => get_user(),
            'induk' => $this->laporan->get_data_blm_splitsing()->result(),
            'view' => 'laporan/8/new_proses_splitsing'
        ];
        $this->load->view('dashboard', $data);
    }
    //LAPORAN NO.8 END

    //laporan no 9
    public function data_sert_perum()
    {
        $data = [
            'title' => 'Laporan Hutang Sertifikat Belum Split',
            'user' => get_user(),
            'view' => 'laporan/9/data_sert_perum'
        ];
        $this->load->view('dashboard', $data);
    }


    public function rekap_sert_perum()
    {
        $data = [
            'title' => 'Rekap Hutang Sertifikat Belum Split',
            'user' => get_user(),
            'view' => 'laporan/9/rekap_sert_perum'
        ];
        $this->load->view('dashboard', $data);
    }

    //end no 9


    //laporan no 10
    public function data_splitsing()
    {
        $data = [
            'title' => 'Evaluasi Stok Kavling Splitsing',
            'user' => get_user(),
            'view' => 'laporan/10/data_splitsing'
        ];
        $this->load->view('dashboard', $data);
    }


    public function rekap_splitsing()
    {
        $data = [
            'title' => 'Rekap Stok Kavling Splitsing',
            'user' => get_user(),
            'view' => 'laporan/10/rekap_splitsing'
        ];
        $this->load->view('dashboard', $data);
    }
    //end no 10



    //laporan no 11
    public function data_baliknama()
    {
        $data = [
            'title' => 'Evaluasi AJB dan Balik Nama',
            'user' => get_user(),
            'view' => 'laporan/11/data_baliknama'
        ];
        $this->load->view('dashboard', $data);
    }
    public function rekap_baliknama()
    {
        $data = [
            'title' => 'Rekap Sertifikat Baliknama',
            'user' => get_user(),
            'view' => 'laporan/11/rekap_baliknama'
        ];
        $this->load->view('dashboard', $data);
    }
    //end no 11


    //laporan no 12
    public function data_pbb()
    {
        $data = [
            'title' => 'Data SPPT PBB',
            'user' => get_user(),
            'view' => 'laporan/12/data_pbb'
        ];
        $this->load->view('dashboard', $data);
    }
    public function rekap_pbb()
    {
        $data = [
            'title' => 'Rekaptulasi PBB',
            'user' => get_user(),
            'view' => 'laporan/12/rekap_pbb'
        ];
        $this->load->view('dashboard', $data);
    }
    //end no 12

}
