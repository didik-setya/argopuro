<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Laporan_model extends CI_Model
{

    // LAPORAN NO 1 EVALUASI PROSES DAN IJIN LOKASI TANAH START
    public function query_proses_ijin_lokasi($tahun = null, $status = null, $id = null, $proyek = null, $status_proyek = null)
    {
        $this->db->select('
            master_tanah.status_teknik,
            master_tanah.luas_surat,
            master_proyek.nama_proyek,
            tbl_ijin_lokasi.*,
            master_status_proyek.nama_status
            ')
            ->from('tbl_ijin_lokasi')
            ->join('master_tanah', 'tbl_ijin_lokasi.tanah_id = master_tanah.id')
            ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id')
            ->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id');

        if ($tahun) {
            $this->db->where('year(tbl_ijin_lokasi.daftar_online_oss)', $tahun);
        }

        if ($status) {
            $this->db->where('tbl_ijin_lokasi.status', $status);
        }

        if ($id) {
            $this->db->where('tbl_ijin_lokasi.id', $id);
        }

        if ($proyek) {
            $this->db->where('master_tanah.proyek_id', $proyek);
        }

        if ($status_proyek) {
            $this->db->where('master_tanah.status_proyek', $status_proyek);
        }
        return $this->db->get();
    }

    private function query_terbit_ijin($proyek = null, $status = null)
    {
        $this->db->select('
            master_tanah.status_teknik,
            master_tanah.luas_surat,
            master_proyek.nama_proyek,
            tbl_ijin_lokasi.*,
            master_status_proyek.nama_status
            ')
            ->from('tbl_ijin_lokasi')
            ->join('master_tanah', 'tbl_ijin_lokasi.tanah_id = master_tanah.id')
            ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id')
            ->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id')
            ->where('tbl_ijin_lokasi.status', 'terbit');
        if ($proyek) {
            $this->db->where('master_tanah.proyek_id', $proyek);
        }

        if ($status) {
            $this->db->where('master_tanah.status_proyek', $status);
        }
    }

    private function filter_terbit_ijin($proyek = null, $status = null)
    {
        $this->query_terbit_ijin($proyek, $status);
        $search = ['koordinat', 'nama_proyek'];
        $i = 0;
        foreach ($search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
    }

    public function get_terbit_ijin($proyek = null, $status = null)
    {
        $this->filter_terbit_ijin($proyek, $status);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_terbit_ijin($proyek = null, $status = null)
    {
        $this->filter_terbit_ijin($proyek, $status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_terbit_ijin($proyek = null, $status = null)
    {
        $this->query_terbit_ijin($proyek, $status);
        return $this->db->count_all_results();
    }

    // LAPORAN NO 1 EVALUASI PROSES DAN IJIN LOKASI TANAH END

    // LAPORAN NO 2 EVALUASI PEMBELIAN TANAH START

    public function get_tanah_menu2($proyek = null, $firstdate = null, $lastdate = null, $status_perumahan = null, $year = null)
    {
        $this->db->select('a.*,b.nama_proyek,c.kode as kode_sertifikat1,d.kode as kode_sertifikat2');
        $this->db->from('master_tanah a');
        $this->db->join('master_proyek b', 'b.id = a.proyek_id', 'left');
        $this->db->join('master_sertifikat_tanah c', 'c.id = a.status_surat_tanah1', 'left');
        $this->db->join('master_sertifikat_tanah d', 'd.id = a.status_surat_tanah2', 'left');


        if ($firstdate && $lastdate) {
            $this->db->where('a.created_at BETWEEN "' . $firstdate . '" and "' . $lastdate . '"');
        }

        if ($proyek) {
            $this->db->where('a.proyek_id', $proyek);
        }

        if ($status_perumahan) {
            $this->db->where('a.status_proyek', $status_perumahan);
        }

        if ($year) {
            $this->db->where('YEAR(a.created_at)', $year);
        }

        return $this->db->get()->result();
    }

    public function get_data_tanah_menu2($id_proyek = '', $status_proyek = '', $firstdate = null, $lastdate = null)
    {
        $this->db->select('*');
        $this->db->from('master_tanah');
        $this->db->join('master_proyek', 'master_proyek.id = master_tanah.proyek_id', 'left');
        $this->db->join('master_status_proyek', 'master_status_proyek.id = master_tanah.status_proyek', 'left');
        if ($id_proyek) {
            $this->db->where('master_tanah.proyek_id', $id_proyek);
        }
        if ($status_proyek) {
            $this->db->where('master_tanah.status_proyek', $status_proyek);
        }
        if ($firstdate && $lastdate) {
            $this->db->where('master_tanah.created_at BETWEEN "' . $firstdate . '" and "' . $lastdate . '"');
        }
        $hasil = $this->db->get();
        return $hasil->result_array()[0];
    }

    public function get_filter_status_menu2($proyek = null, $firstdate = null, $lastdate = null, $status_perumahan = null, $year = null)
    {
        $this->db->select('a.*,b.nama_proyek,c.kode as kode_sertifikat1,d.kode as kode_sertifikat2');
        $this->db->from('master_tanah a');
        $this->db->join('master_proyek b', 'b.id = a.proyek_id', 'left');
        $this->db->join('master_sertifikat_tanah c', 'c.id = a.status_surat_tanah1', 'left');
        $this->db->join('master_sertifikat_tanah d', 'd.id = a.status_surat_tanah2', 'left');
        $this->db->group_by('b.id');


        if ($firstdate && $lastdate) {
            $this->db->where('a.created_at BETWEEN "' . $firstdate . '" and "' . $lastdate . '"');
        }

        if ($proyek) {
            $this->db->where('a.proyek_id', $proyek);
        }

        if ($status_perumahan) {
            $this->db->where('a.status_proyek', $status_perumahan);
        }

        if ($year) {
            $this->db->where('YEAR(a.created_at)', $year);
        }

        return $this->db->get()->result();
    }

    public function get_rekap_tanah_menu2($jenis = '', $proyek = null, $status = null, $date_a = null, $date_b = null)
    {
        $this->db->select('master_tanah.*,master_tanah.id as id_tanah,master_proyek.*,master_status_proyek.*');
        $this->db->from('master_tanah');
        $this->db->join('master_proyek', 'master_proyek.id = master_tanah.proyek_id', 'left');
        $this->db->join('master_status_proyek', 'master_status_proyek.id = master_tanah.status_proyek', 'left');
        $this->db->group_by('master_tanah.proyek_id');
        $this->db->group_by('master_tanah.status_proyek');

        // if (!empty($status)) {
        //     $this->db->where('master_tanah.status_proyek', $jenis);
        // }

        if ($proyek && $status) {
            $this->db->where('master_tanah.proyek_id', $proyek)->where('master_tanah.status_proyek', $status);
        } else {
            $this->db->where('master_tanah.status_proyek', $jenis);
        }

        if ($date_a && $date_b) {
            $this->db->where('master_tanah.created_at BETWEEN "' . $date_a . '" AND "' . $date_b . '"');
        }

        return $this->db->get()->result();
    }
    public function get_target_menu2($id = null, $tahun = null, $status_proyek = null)
    {
        $this->db->select('target_bidang, target_luas');
        $this->db->from('master_proyek_target');
        $this->db->join('master_proyek', 'master_proyek_target.proyek_id = master_proyek.id', 'left');
        $this->db->where('proyek_id', $id);
        $this->db->where('year(tahun)', $tahun);
        $this->db->where('status_proyek', $status_proyek);

        $get = $this->db->get();
        if ($get->num_rows() > 0) {

            $hasil = $get->result_array();

            $data = array();
            foreach ($hasil as $hs) {
                $row = [];
                $row['bid'] = $hs['target_bidang'];
                $row['luas'] =  $hs['target_luas'];
                $data[] = $row;
            }
            return $data;
        } else {
            $row = [];
            $row['bid'] = 'Tidak Ada Data Target!, Harap Mengisi Master Target';
            $row['luas'] = 0;
            $data[] = $row;;
            return $data;
        }
    }
    public function get_realisasi_menu2($id, $sebelum, $sesudah, $status_proyek)
    {
        $this->db->select("count(proyek_id) as bid,sum(luas_surat) as luas");
        $this->db->from('master_tanah');
        $this->db->where('proyek_id', $id);
        $this->db->where('tgl_pembelian BETWEEN "' . $sebelum . '" and "' . $sesudah . '"');
        $this->db->where('status_proyek', $status_proyek);
        $hasil = $this->db->get();
        if ($hasil->num_rows() > 0) {
            return $hasil->result_array()[0];
        } else {
            return array('luas' => 0, 'bid' => 0);
        }
    }
    // LAPORAN NO 2 EVALUASI PEMBELIAN TANAH END

    //LAPORAN NO 3 LAND BANK START
    public function get_data_landbank_perum($tahun = null, $lokasi = null, $s_peralihan = null, $s_teknik = null, $id = null)
    {
        $this->db->select('
            master_tanah.*,
            master_proyek.nama_proyek,
            master_status_proyek.nama_status,
            master_jenis_pengalihan.nama_pengalihan
        ')
            ->from('master_tanah')
            ->join(
                'master_proyek',
                'master_tanah.proyek_id = master_proyek.id'
            )
            ->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id')
            ->join('master_jenis_pengalihan', 'master_tanah.jenis_pengalihan = master_jenis_pengalihan.id')
            ->where('master_tanah.status_perindukan', 'belum');

        if ($tahun) {
            $this->db->where('year(master_tanah.created_at)', $tahun);
        }

        if ($lokasi) {
            $this->db->where('master_tanah.proyek_id', $lokasi);
        }

        if ($s_peralihan) {
            $this->db->where('master_tanah.status_pengalihan', $s_peralihan);
        }

        if ($s_teknik) {
            $this->db->where('master_tanah.status_teknik', $s_teknik);
        }

        if ($id) {
            $this->db->where('master_tanah.id', $id);
        }

        $data = $this->db->get();
        return $data;
    }

    public function get_rekap_landbank($status_proyek = null, $group = null, $id_proyek = null)
    {
        $this->db->select('
            master_tanah.*,
            master_proyek.nama_proyek,
        ')
            ->from('master_tanah')
            ->join(
                'master_proyek',
                'master_tanah.proyek_id = master_proyek.id'
            );
        if ($status_proyek) {
            $this->db->where('master_tanah.status_proyek', $status_proyek);
        }

        if ($group) {
            $this->db->group_by('master_tanah.proyek_id');
            $this->db->group_by('master_tanah.status_proyek');
        }

        if ($id_proyek) {
            $this->db->where('master_tanah.proyek_id', $id_proyek);
        }

        $data = $this->db->get();
        return $data;
    }

    public function get_detail_rekap_landbank($proyek_id = null, $status_proyek = null, $tahun = null, $teknik = null)
    {
        $this->db->select('
            SUM(master_tanah.luas_surat) AS jml_luas_surat,
            SUM(master_tanah.luas_ukur) AS jml_luas_ukur
        ')
            ->from('master_tanah')
            ->join(
                'master_proyek',
                'master_tanah.proyek_id = master_proyek.id'
            );

        if ($proyek_id) {
            $this->db->where('master_tanah.proyek_id', $proyek_id);
        }
        if ($status_proyek) {
            $this->db->where('master_tanah.status_proyek', $status_proyek);
        }
        if ($tahun) {
            $this->db->where('year(master_tanah.created_at)', $tahun);
        }
        if ($teknik) {
            $this->db->where('master_tanah.status_teknik', $teknik);
        }

        $data = $this->db->get()->row();

        if ($data->jml_luas_surat == null) {
            $ls = 0;
        } else {
            $ls = $data->jml_luas_surat;
        }

        if ($data->jml_luas_ukur == null) {
            $lu = 0;
        } else {
            $lu = $data->jml_luas_ukur;
        }

        $out = [
            'luas_surat' => $ls,
            'luas_ukur' => $lu
        ];

        return $out;
    }

    public function jml_bid_rekap_landbank($proyek_id = null, $status_proyek = null, $tahun = null, $teknik = null, $pengalihan = null, $tgl_finance = null)
    {
        $this->db->select('master_tanah.*')
            ->from('master_tanah')
            ->join(
                'master_proyek',
                'master_tanah.proyek_id = master_proyek.id'
            );

        if ($proyek_id) {
            $this->db->where('master_tanah.proyek_id', $proyek_id);
        }
        if ($status_proyek) {
            $this->db->where('master_tanah.status_proyek', $status_proyek);
        }
        if ($tahun) {
            $this->db->where('year(master_tanah.created_at)', $tahun);
        }
        if ($teknik) {
            $this->db->where('master_tanah.status_teknik', $teknik);
        }

        if ($pengalihan) {
            $this->db->where('master_tanah.status_pengalihan', $pengalihan);
        }

        if ($tgl_finance == 'yes') {
            $this->db->where('master_tanah.serah_terima_finance !=', null);
        } else if ($tgl_finance == 'no') {
            $this->db->where('master_tanah.serah_terima_finance', null);
        }


        $data = $this->db->get();
        return $data;
    }
    //LAPORAN NO 3 LAND BANK END

    //LAPORAN NO 4 START
    public function get_tanah_belum_shgb($tahun = null, $lokasi = null, $s_peralihan = null, $s_shgb = null, $id = null)
    {
        $this->db->select('
            master_tanah.*,
            master_proyek.nama_proyek,
            master_status_proyek.nama_status,
            master_jenis_pengalihan.nama_pengalihan
        ')
            ->from('master_tanah')
            ->join(
                'master_proyek',
                'master_tanah.proyek_id = master_proyek.id'
            )
            ->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id')
            ->join('master_jenis_pengalihan', 'master_tanah.jenis_pengalihan = master_jenis_pengalihan.id');

        if ($tahun) {
            $this->db->where('year(master_tanah.created_at)', $tahun);
        }

        if ($lokasi) {
            $this->db->where('master_tanah.proyek_id', $lokasi);
        }

        if ($s_peralihan) {
            $this->db->where('master_tanah.status_pengalihan', $s_peralihan);
        }

        if ($id) {
            $this->db->where('master_tanah.id', $id);
        }

        if ($s_shgb) {
            $this->db->where('master_tanah.status_proses_shgb', $s_shgb);
        }

        $data = $this->db->get();
        return $data;
    }

    public function get_jml_belum_shgb($tahun = null, $shgb = null, $id_proyek = null)
    {
        $this->db->select('
        SUM(master_tanah.luas_surat) AS jml_luas_surat,
        SUM(master_tanah.luas_ukur) AS jml_luas_ukur
        ')
            ->from('master_tanah')
            ->join(
                'master_proyek',
                'master_tanah.proyek_id = master_proyek.id'
            );

        if ($tahun) {
            $this->db->where('year(master_tanah.created_at)', $tahun);
        }

        if ($shgb) {
            $this->db->where('master_tanah.status_proses_shgb', $shgb);
        }

        if ($id_proyek) {
            $this->db->where('master_tanah.proyek_id', $id_proyek);
        }
        $data = $this->db->get()->row();


        if ($data->jml_luas_surat == null) {
            $ls = 0;
        } else {
            $ls = $data->jml_luas_surat;
        }

        if ($data->jml_luas_ukur == null) {
            $lu = 0;
        } else {
            $lu = $data->jml_luas_ukur;
        }
        $bid = $this->get_jml_bid_belum_shgb($tahun, $shgb, $id_proyek);

        $out = [
            'luas_surat' => $ls,
            'luas_ukur' => $lu,
            'bid' => $bid
        ];
        return $out;
    }

    public function get_jml_bid_belum_shgb(
        $tahun = null,
        $shgb = null,
        $id_proyek = null,
        $peralihan_bank = null,
        $finance = null
    ) {
        $this->db->select('master_tanah.*')
            ->from('master_tanah')
            ->join(
                'master_proyek',
                'master_tanah.proyek_id = master_proyek.id'
            );
        if ($tahun) {
            $this->db->where('year(master_tanah.created_at)', $tahun);
        }

        if ($shgb) {
            $this->db->where('master_tanah.status_proses_shgb', $shgb);
        }

        if ($id_proyek) {
            $this->db->where('master_tanah.proyek_id', $id_proyek);
        }

        if ($peralihan_bank) {
            $this->db->where('master_tanah.status_pengalihan', $peralihan_bank);
        }

        if ($finance) {
            if ($finance == 'yes') {
                $this->db->where(
                    'master_tanah.serah_terima_finance !=',
                    null
                )->where('master_tanah.serah_terima_finance !=', '0000-00-00');
            } else if ($finance == 'no') {
                $this->db->where('master_tanah.serah_terima_finance', null)->where('master_tanah.serah_terima_finance', '0000-00-00');
            }
        }
        $data = $this->db->get()->num_rows();
        return $data;
    }

    private function q_rekap_belum_shgb($proyek = null)
    {
        $this->db->select('
            master_proyek.id as id_proyek,
            master_proyek.nama_proyek,
            master_tanah.id as id_tanah
        ')
            ->from('master_proyek')
            ->join(
                'master_tanah',
                'master_proyek.id = master_tanah.proyek_id'
            )
            ->group_by('master_proyek.id');

        if ($proyek) {
            $this->db->where(
                'master_proyek.id',
                $proyek
            );
        }
    }

    public function get_rekap_belum_shgb($proyek = null)
    {
        $this->q_rekap_belum_shgb($proyek);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_all_rekap_belum_shgb($proyek = null)
    {
        $this->q_rekap_belum_shgb($proyek);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_filter_rekap_belum_shgb($proyek = null)
    {
        $this->q_rekap_belum_shgb($proyek);
        return $this->db->count_all_results();
    }
    //LAPORAN NO 4 END

    //LAPORAN NO 5 START
    private function q_list_tambah_tanah($status_teknik = null, $tanah = null)
    {
        $this->db->select('master_tanah.*,
        master_tanah.id as id_tanah,
        master_proyek.nama_proyek,
        master_status_proyek.nama_status');
        $this->db->from('master_tanah');
        $this->db->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id', 'left');
        $this->db->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id', 'left');
        $this->db->where('master_tanah.status_perindukan', 'belum');
        $this->db->order_by('master_tanah.id', 'ASC');

        if ($status_teknik) {
            if ($status_teknik == 'tanah_proyek') {
                $this->db->where('master_tanah.status_teknik', 'selesai');
            } else if ($status_teknik == 'ip_proyek') {
                $this->db->where('master_tanah.status_teknik', 'belum');
            }
        }

        if ($tanah) {
            $this->db->where_not_in('master_tanah.id', $tanah);
        }
    }

    private function filter_list_tanah($status_teknik = null, $tanah = null)
    {
        $this->q_list_tambah_tanah($status_teknik, $tanah);
        $search = ['nama_regu', 'nama_user'];
        $i = 0;
        foreach ($search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
    }

    public function get_list_data_tanah($status_teknik = null, $tanah = null)
    {
        $this->filter_list_tanah($status_teknik, $tanah);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_list_tanah($status_teknik = null, $tanah = null)
    {
        $this->filter_list_tanah($status_teknik, $tanah);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_list_tanah($status_teknik = null, $tanah = null)
    {
        $this->q_list_tambah_tanah($status_teknik, $tanah);
        return $this->db->count_all_results();
    }






    public function get_data_proses_induk($tahun = null, $lokasi = '', $s_induk = null, $id = null, $status_tanah = null)
    {
        $this->db->select('
            tbl_proses_induk.id as id_proses_induk,
            tbl_proses_induk.no_gambar,
            tbl_proses_induk.ket as ket_induk,
            tbl_proses_induk.*,
            sub_proses_induk.*,
            sub_proses_induk.id as sub_id,
            master_tanah.*,
            master_proyek.nama_proyek,
            master_status_proyek.nama_status,
            master_jenis_pengalihan.nama_pengalihan
        ')
            ->from('tbl_proses_induk')
            ->join(
                'sub_proses_induk',
                'tbl_proses_induk.id = sub_proses_induk.induk_id'
            )
            ->join(
                'master_tanah',
                'sub_proses_induk.tanah_id = master_tanah.id'
            )
            ->join(
                'master_proyek',
                'master_tanah.proyek_id = master_proyek.id'
            )
            ->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id')
            ->join('master_jenis_pengalihan', 'master_tanah.jenis_pengalihan = master_jenis_pengalihan.id')
            ->group_by('sub_proses_induk.induk_id');

        if ($tahun) {
            $this->db->where('year(tbl_proses_induk.created_at)', $tahun);
        }

        if ($s_induk) {
            $this->db->where('tbl_proses_induk.status_induk', $s_induk);
        }

        if ($lokasi) {
            $this->db->where('master_tanah.proyek_id', $lokasi);
        }

        if ($id) {
            $this->db->where('tbl_proses_induk.id', $id);
        }

        if ($status_tanah) {
            $this->db->where('tbl_proses_induk.status_tanah', $status_tanah);
        }

        $data = $this->db->get();
        return $data;
    }
    public function get_data_subproses_induk($id = null)
    {
        $this->db->select('sub_proses_induk.id AS id_sub_induk, sub_proses_induk.*, master_tanah.*, master_proyek.*, master_status_proyek.*');
        $this->db->from('sub_proses_induk');
        $this->db->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id');
        $this->db->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id');
        $this->db->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id');
        $this->db->where('sub_proses_induk.induk_id', $id);

        $query = $this->db->get();
        return $query;
    }

    public function get_rekap_proses_induk($new_year = null, $old_year = null, $proyek = null, $status = null, $type = null, $st_proyek = null)
    {


        if ($status && $type) {
            if ($type == 'luas') {
                if ($status == 'belum') {
                    $this->db->select('SUM(master_tanah.luas_surat) AS luas_terbit');
                } else if ($status == 'terbit') {
                    $this->db->select('SUM(tbl_proses_induk.luas_terbit) AS luas_terbit');
                }
            } else if ($type == 'bid') {
                $this->db->select('tbl_proses_induk.*');
            }
        } else {
            $this->db->select('
                    tbl_proses_induk.*,
                    tbl_proses_induk.id as id_proses_induk,
                    tbl_proses_induk.ket as ket_proses,
                    master_tanah.*,
                    master_status_proyek.nama_status,
                    master_proyek.nama_proyek,
                    tbl_proses_induk.luas_terbit as luas_daftar
            ');
        }


        $this->db->from('tbl_proses_induk');
        $this->db->join('sub_proses_induk', 'sub_proses_induk.induk_id = tbl_proses_induk.id', 'left');
        $this->db->join('master_tanah', 'master_tanah.id = sub_proses_induk.tanah_id', 'left');
        $this->db->join('master_status_proyek', 'master_status_proyek.id = master_tanah.status_proyek', 'left');
        $this->db->join('master_proyek', 'master_proyek.id = master_tanah.proyek_id', 'left');

        if ($proyek) {
            $this->db->where(
                'master_proyek.id',
                $proyek
            );
        }

        if ($status) {
            $this->db->where('tbl_proses_induk.status_induk', $status);
        }

        if ($old_year) {
            $this->db->where('year(tbl_proses_induk.created_at) <=', $old_year);
        }

        if ($new_year) {
            $this->db->where(
                'year(tbl_proses_induk.created_at)',
                $new_year
            );
        }

        if ($st_proyek) {
            $this->db->where('master_tanah.status_proyek', $st_proyek);
        }

        if (!$status) {
            $this->db->group_by('master_proyek.id');
        }



        return $this->db->get();
    }

    public function count_induk_rekap(
        $proyek = null,
        $type = null,
        $status = null,
        $new_year = null,
        $old_year = null
    ) {

        if ($type && $type == 'luas') {
            if ($status == 'belum') {
                $this->db->select('SUM(master_tanah.luas_surat) as luas_terbit');
            } else if ($status == 'terbit') {
                $this->db->select('SUM(tbl_proses_induk.luas_terbit) as luas_terbit');
            }
        } else {
            $this->db->select('tbl_proses_induk.ket as ket_real');
        }

        $this->db->from('tbl_proses_induk');
        $this->db->join('sub_proses_induk', 'sub_proses_induk.induk_id = tbl_proses_induk.id');
        $this->db->join('master_tanah', 'master_tanah.id = sub_proses_induk.tanah_id');
        $this->db->join('master_proyek', 'master_proyek.id = master_tanah.proyek_id');


        if ($proyek) {
            $this->db->where(
                'master_proyek.id',
                $proyek
            );
        }

        if ($status) {
            $this->db->where('tbl_proses_induk.status_induk', $status);
        }

        if ($old_year) {
            $this->db->where('year(tbl_proses_induk.created_at) <=', $old_year);
        }

        if ($new_year) {
            $this->db->where(
                'year(tbl_proses_induk.created_at)',
                $new_year
            );
        }

        return $this->db->get();
    }


    //LAPORAN NO 5 END

    //LAPORAN NO 6 START baru
    private function get_data_has_added_6($kategori = null)
    {
        $this->db->select('
        sub_penggabungan_induk.*
        ')
            ->from('sub_penggabungan_induk')
            ->join('tbl_penggabungan_induk', 'sub_penggabungan_induk.penggabungan_id = tbl_penggabungan_induk.id');
        if ($kategori) {
            $this->db->where('sub_penggabungan_induk.type', $kategori);
        }

        $get_data = $this->db->get()->result();

        if (!empty($get_data)) {
            $output = [];
            foreach ($get_data as $gd) {
                $output[] =  $gd->induk_id;
            }
        } else {
            $output = null;
        }
        return $output;
    }

    public function query_list_tanah_6($kategori = null, $selected = null, $id = null)
    {
        $has_added = $this->get_data_has_added_6($kategori);

        if ($kategori == 'induk') {

            $data_sudah = $this->db->select('induk_id')->group_by('induk_id')->get('tbl_splitsing')->result();
            $dt = [];
            foreach ($data_sudah as $ds) {
                $dt[] = $ds->induk_id;
            }

            $this->db->select('
                tbl_proses_induk.id,
                tbl_proses_induk.no_terbit_shgb,
                tbl_proses_induk.luas_terbit,
                master_proyek.nama_proyek
            ')
                ->from('tbl_proses_induk')
                ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id')
                ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id')
                ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id')
                ->group_by('tbl_proses_induk.id')
                ->where('tbl_proses_induk.status_induk', 'terbit')
                ->where('tbl_proses_induk.status_tanah', 'tanah_proyek');
            if ($data_sudah) {
                $this->db->where_not_in('tbl_proses_induk.id', $dt);
            }

            if ($selected) {
                $this->db->where_not_in('tbl_proses_induk.id', $selected);
            }

            if ($has_added) {
                $this->db->where_not_in('tbl_proses_induk.id', $has_added);
            }

            if ($id) {
                $this->db->where('tbl_proses_induk.id', $id);
                return $this->db->get();
            }
        } else if ($kategori == 'sisa_induk') {
            $this->db->select('
                tbl_proses_induk.id,
                tbl_proses_induk.no_terbit_shgb,
                tbl_proses_induk.sisa_induk,
                master_proyek.nama_proyek
            ')
                ->from('tbl_proses_induk')
                ->join('tbl_splitsing', 'tbl_proses_induk.id = tbl_splitsing.induk_id')
                ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id')
                ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id')
                ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id')
                ->group_by('tbl_proses_induk.id')
                ->where('tbl_proses_induk.status_induk', 'terbit')
                ->where('tbl_proses_induk.status_tanah', 'tanah_proyek')
                ->where('tbl_proses_induk.sisa_induk >', 0);
            if ($selected) {
                $this->db->where_not_in('tbl_proses_induk.id', $selected);
            }


            if ($has_added) {
                $this->db->where_not_in('tbl_proses_induk.id', $has_added);
            }

            if ($id) {
                $this->db->where('tbl_proses_induk.id', $id);
                return $this->db->get();
            }
        } else if ($kategori == 'splitsing') {
            $this->db->select('
                sub_splitsing.id,
                sub_splitsing.blok,
                sub_splitsing.luas_terbit,
                sub_splitsing.no_shgb,
                master_proyek.nama_proyek
            ')
                ->from('sub_splitsing')
                ->join('tbl_splitsing', 'sub_splitsing.splitsing_id = tbl_splitsing.id')
                ->join('tbl_proses_induk', 'tbl_splitsing.induk_id = tbl_proses_induk.id')
                ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id')
                ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id')
                ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id')
                ->where('tbl_splitsing.status', 'terbit')
                ->group_by('sub_splitsing.id');
            if ($selected) {
                $this->db->where_not_in('sub_splitsing.id', $selected);
            }

            if ($has_added) {
                $this->db->where_not_in('sub_splitsing.id', $has_added);
            }

            if ($id) {
                $this->db->where('sub_splitsing.id', $id);
                return $this->db->get();
            }
        }
    }

    public function get_list_tanah_6($kategori = null, $selected = null)
    {
        $this->query_list_tanah_6($kategori, $selected);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_count_list_tanah_6($kategori = null, $selected = null)
    {
        $this->query_list_tanah_6($kategori, $selected);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_detail_6($kategori = null, $id = null)
    {
        if ($kategori == 'induk') {
            $this->db->select('
                tbl_proses_induk.id,
                tbl_proses_induk.no_terbit_shgb,
                tbl_proses_induk.luas_terbit,
                master_proyek.nama_proyek
            ')
                ->from('tbl_proses_induk')
                ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id')
                ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id')
                ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id')
                ->group_by('tbl_proses_induk.id');
            if ($id) {
                $this->db->where('tbl_proses_induk.id', $id);
            }
        } else if ($kategori == 'sisa_induk') {
            $this->db->select('
                tbl_proses_induk.id,
                tbl_proses_induk.no_terbit_shgb,
                tbl_proses_induk.sisa_induk,
                master_proyek.nama_proyek
            ')
                ->from('tbl_proses_induk')
                ->join('tbl_splitsing', 'tbl_proses_induk.id = tbl_splitsing.induk_id')
                ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id')
                ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id')
                ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id')
                ->group_by('tbl_proses_induk.id');

            if ($id) {
                $this->db->where('tbl_proses_induk.id', $id);
            }
        } else if ($kategori == 'splitsing') {
            $this->db->select('
                sub_splitsing.id,
                sub_splitsing.blok,
                sub_splitsing.luas_terbit,
                sub_splitsing.no_shgb,
                master_proyek.nama_proyek
            ')
                ->from('sub_splitsing')
                ->join('tbl_splitsing', 'sub_splitsing.splitsing_id = tbl_splitsing.id')
                ->join('tbl_proses_induk', 'tbl_splitsing.induk_id = tbl_proses_induk.id')
                ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id')
                ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id')
                ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id')
                ->group_by('sub_splitsing.id');

            if ($id) {
                $this->db->where('sub_splitsing.id', $id);
            }
        }

        return $this->db->get();
    }






    private function query_dtbl_no_6()
    {
        $this->db->select('tbl_penggabungan_induk.*')
            ->from('tbl_penggabungan_induk')
            ->join('sub_penggabungan_induk', 'tbl_penggabungan_induk.id = sub_penggabungan_induk.penggabungan_id')
            ->group_by('tbl_penggabungan_induk.id');
    }

    private function filter_query_no_6()
    {
        $this->query_dtbl_no_6();
        $search = ['no_berkas', 'no_shgb', 'posisi', 'ket'];
        $i = 0;
        foreach ($search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
    }

    public function get_dtbl_no_6()
    {
        $this->filter_query_no_6();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function filtered_dtbl_6()
    {
        $this->filter_query_no_6();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_dtbl_6()
    {
        $this->query_dtbl_no_6();
        return $this->db->count_all_results();
    }


    //LAPORAN NO 6 END


    //LAPORAN NO 7 START
    public function get_data_shgb($proyek_id = null, $year = null)
    {
        $this->db->select('
            tbl_proses_induk.*,
            sub_proses_induk.ket_sub,
            master_tanah.atas_nama_pengalihan
        ');
        $this->db->from('tbl_proses_induk');
        $this->db->join('sub_proses_induk', 'sub_proses_induk.induk_id = tbl_proses_induk.id', 'left');
        $this->db->join('master_tanah', 'master_tanah.id = sub_proses_induk.tanah_id', 'left');
        // $this->db->order_by('b.id_master_item');

        if ($proyek_id) {
            $this->db->where('master_tanah.proyek_id', $proyek_id);
        }

        if ($year) {
            $this->db->where('year(tbl_proses_induk.created_at)', $year);
        }
        $this->db->group_by('tbl_proses_induk.id');


        return $this->db->get();
    }

    public function get_data_split_7($induk = null, $status = null)
    {
        $this->db->select('
            tbl_splitsing.*,
            sub_splitsing.*,
        ')
            ->from('tbl_splitsing')
            ->join('sub_splitsing', 'tbl_splitsing.id = sub_splitsing.splitsing_id');

        if ($induk) {
            $this->db->where('tbl_splitsing.induk_id', $induk);
        }

        if ($status) {
            $this->db->where('tbl_splitsing.status', $status);
        }

        $data = $this->db->get();
        return $data;
    }

    public function count_splitsing_7($induk = null, $status = null)
    {
        $this->db->select('SUM(total_luas_splitsing) AS luas_splitsing')
            ->from('tbl_splitsing');

        if ($induk) {
            $this->db->where('tbl_splitsing.induk_id', $induk);
        }

        if ($status) {
            $this->db->where('tbl_splitsing.status', $status);
        }

        $data = $this->db->get();
        return $data;
    }

    public function get_jalan_fasos($proyek_id = NULL, $firstdate = '', $lastdate = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_jalan_fasos a');
        $this->db->join('tbl_proses_induk b', 'b.id = a.induk_id', 'left');
        $this->db->join('sub_proses_induk c', 'c.induk_id = b.id', 'left');
        $this->db->join('master_tanah d', 'd.id = c.tanah_id', 'left');

        if (!empty($firstdate) and !empty($lastdate)) {
            $this->db->where('b.masa_berlaku_shgb BETWEEN "' . $firstdate . '" and "' . $lastdate . '"');
        }
        if (!empty($proyek_id)) {
            $this->db->where('d.proyek_id', $proyek_id);
        }

        return $this->db->get();
    }
    //LAPORAN NO 7 END




    //baru nutuk export rekap no 4
    public function data_export_rekap_belum_shgb($proyek = null)
    {
        $this->db->select('
        master_proyek.id as id_proyek,
        master_proyek.nama_proyek,
        master_tanah.id as id_tanah
        ')
            ->from('master_proyek')
            ->join(
                'master_tanah',
                'master_proyek.id = master_tanah.proyek_id'
            )
            ->group_by('master_proyek.id');

        if ($proyek) {
            $this->db->where(
                'master_proyek.id',
                $proyek
            );
        }
        return $this->db->get()->result();
    }


    //baru untuk rekap no 2
    public function get_proyek_by_tanah()
    {
        $this->db->select('
            master_proyek.id,
            master_proyek.nama_proyek
        ')
            ->from('master_proyek')
            ->join(
                'master_tanah',
                'master_proyek.id = master_tanah.proyek_id'
            )
            ->group_by('master_proyek.id');
        $data = $this->db->get();
        return $data;
    }



    public function get_data_rekap_shgb(
        $proyek_id = null,
        $last_year = null,
        $this_year = null,
        $type = null
    ) {
        if ($type == 'luas') {
            $this->db->select('SUM(tbl_proses_induk.luas_terbit) as luwas');
        } else {
            $this->db->select('
            tbl_proses_induk.*,
            sub_proses_induk.ket_sub,
            master_tanah.atas_nama_pengalihan,
            master_proyek.*,
            master_proyek.id as proyek_id
            ');
        }


        $this->db->from('tbl_proses_induk');
        $this->db->join('sub_proses_induk', 'sub_proses_induk.induk_id = tbl_proses_induk.id', 'left');
        $this->db->join('master_tanah', 'master_tanah.id = sub_proses_induk.tanah_id', 'left')
            ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id', 'left')
            ->where('tbl_proses_induk.status_induk', 'terbit');

        if ($proyek_id) {
            $this->db->where('master_tanah.proyek_id', $proyek_id);
        }

        if ($last_year) {
            $this->db->where('year(tbl_proses_induk.created_at) <=', $last_year);
        }
        if ($this_year) {
            $this->db->where('year(tbl_proses_induk.created_at)', $this_year);
        }

        if (!$type) {
            $this->db->group_by('master_proyek.id');
        }
        return $this->db->get();
    }




    //laporan no 8
    public function get_data_blm_splitsing()
    {
        $data_sudah = $this->db->select('induk_id')->group_by('induk_id')->get('tbl_splitsing')->result();
        $dt = [];
        foreach ($data_sudah as $ds) {
            $dt[] = $ds->induk_id;
        }

        if ($data_sudah) {
            $data = $this->db->select('id, no_terbit_shgb, luas_terbit')->where_not_in('id', $dt)->where('status_induk', 'terbit')->where('status_tanah', 'tanah_proyek')->get('tbl_proses_induk');
        } else {
            $data = $this->db->select('id, no_terbit_shgb, luas_terbit')->where('status_induk', 'terbit')->where('status_tanah', 'tanah_proyek')->get('tbl_proses_induk');
        }

        return $data;
    }


    public function get_data_has_splitsing($id = null)
    {
        $this->db->select('
            tbl_splitsing.*,
            tbl_proses_induk.luas_terbit AS luas_induk,
            tbl_proses_induk.no_terbit_shgb,
            tbl_proses_induk.sisa_induk AS sisa_from_induk
        ')
            ->from('tbl_splitsing')
            ->join('tbl_proses_induk', 'tbl_splitsing.induk_id = tbl_proses_induk.id');

        if ($id) {
            $this->db->where('tbl_splitsing.id', $id);
        }

        $data = $this->db->get();
        return $data;
    }


    public function data_rekap_splitsing($proyek_id = null, $status = null, $month = null, $year = null, $last_year = null)
    {
        $this->db->select('sub_splitsing.tgl_terbit')
            ->from('sub_splitsing')
            ->join('tbl_splitsing', 'sub_splitsing.splitsing_id = tbl_splitsing.id')
            ->join('tbl_proses_induk', 'tbl_splitsing.induk_id = tbl_proses_induk.id')
            ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id')
            ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id');
        $this->db->group_by('sub_splitsing.id');

        if ($proyek_id) {
            $this->db->where('master_tanah.proyek_id', $proyek_id);
        }

        if ($status == 'proses') {
            $this->db->where('year(tbl_splitsing.tgl_daftar) <=', $last_year)->where('tbl_splitsing.status', $status);
        } else if ($status == 'terbit') {
            $this->db->where('month(sub_splitsing.tgl_terbit)', $month)->where('year(sub_splitsing.tgl_terbit)', $year)->where('tbl_splitsing.status', $status);
        }

        $data = $this->db->get();
        return $data;
    }

    // end no 8





    //laporan no 9

    public function data_laporan_9($this_year = null, $last_year = null, $status = null, $id_splitsing = null)
    {
        $this->db->select('
            tbl_splitsing.*,
            tbl_splitsing.id AS id_splitsing,
            tbl_penggabungan_induk.no_shgb AS shgb_induk,
            sub_penggabungan_induk.blok,
            sub_penggabungan_induk.penggabungan_id,
            master_tanah.luas_surat,
            sub_proses_induk.id as id_sub_proses
        ')
            ->from('tbl_splitsing')
            ->join('tbl_penggabungan_induk', 'tbl_splitsing.penggabungan_id = tbl_penggabungan_induk.id')
            ->join('sub_penggabungan_induk', 'tbl_penggabungan_induk.id = sub_penggabungan_induk.penggabungan_id')
            ->join('tbl_proses_induk', 'sub_penggabungan_induk.induk_id = tbl_proses_induk.id')
            ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id AND (tbl_splitsing.sub_proses_id = sub_proses_induk.id)')
            ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id')
            ->where('tbl_splitsing.status', 'terbit');
        if ($this_year) {
            $this->db->where('year(tbl_splitsing.create_at)', $this_year);
        }
        if ($last_year) {
            $this->db->where('year(tbl_splitsing.create_at) <=', $last_year);
        }
        if ($status) {
            $this->db->where('tbl_splitsing.status_penjualan', $status);
        }
        if ($id_splitsing) {
            $this->db->where('tbl_splitsing.id', $id_splitsing);
        }
        return $this->db->get();
    }

    public function data_rekap_9($this_year = null, $last_year = null, $status = null, $month_tbt = null, $year_tbt = null, $proyek = null)
    {
        $this->db->select('
            tbl_splitsing.*,
            tbl_splitsing.id AS id_splitsing,
            tbl_penggabungan_induk.no_shgb AS shgb_induk,
            sub_penggabungan_induk.blok,
            sub_penggabungan_induk.penggabungan_id,
            master_tanah.luas_surat,
            sub_proses_induk.id as id_sub_proses
        ')
            ->from('tbl_splitsing')
            ->join('tbl_penggabungan_induk', 'tbl_splitsing.penggabungan_id = tbl_penggabungan_induk.id')
            ->join('sub_penggabungan_induk', 'tbl_penggabungan_induk.id = sub_penggabungan_induk.penggabungan_id')
            ->join('tbl_proses_induk', 'sub_penggabungan_induk.induk_id = tbl_proses_induk.id')
            ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id AND (tbl_splitsing.sub_proses_id = sub_proses_induk.id)')
            ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id')
            ->where('tbl_splitsing.status', 'terbit');

        if ($proyek) {
            $this->db->where('master_tanah.proyek_id', $proyek);
        }

        if ($this_year) {
            $this->db->where('year(tbl_splitsing.create_at)', $this_year);
        }
        if ($last_year) {
            $this->db->where('year(tbl_splitsing.create_at) <=', $last_year);
        }
        if ($status) {
            $this->db->where('tbl_splitsing.status_penjualan', $status);
        }

        if ($month_tbt && $year_tbt) {
            $this->db->where('month(tbl_splitsing.tgl_terbit)', $month_tbt);
            $this->db->where('year(tbl_splitsing.tgl_terbit)', $year_tbt);
        }

        return $this->db->get();
    }

    //end no 9




    //no 10

    public function get_data_10($year = null, $perum = null)
    {
        $this->db->select('
            sub_splitsing.*,
            tbl_splitsing.*,
            sub_splitsing.no_shgb AS shgb_blok,
            master_proyek.nama_proyek,
            master_proyek.id AS id_proyek,
            master_status_proyek.nama_status,
            tbl_proses_induk.no_terbit_shgb AS shgb_induk
        ')
            ->from('sub_splitsing')
            ->join('tbl_splitsing', 'sub_splitsing.splitsing_id = tbl_splitsing.id')
            ->join('tbl_proses_induk', 'tbl_splitsing.induk_id = tbl_proses_induk.id')
            ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id')
            ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id')
            ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id')
            ->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id');
        $this->db->group_by('sub_splitsing.id');
        if ($year) {
            $this->db->where('year(tbl_splitsing.create_at)', $year);
        }

        if ($perum) {
            $this->db->where('master_proyek.id', $perum);
        }
        $data = $this->db->get();
        return $data;
    }

    //end no 10
}
