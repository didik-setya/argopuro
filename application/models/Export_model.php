<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Export_model extends CI_Model
{
    //EXPORT EXCEL MASTER TANAH START
    public function export_master_tanah($perumahan = null, $status_perumahan = null, $tgl_awal = null, $tgl_akhir = null)
    {
        $this->db->select('
        a.*,
        b.*,
        c.kode as kode_sertifikat1,
        d.kode as kode_sertifikat2,
        c.nama_sertif as nama_surat_tanah1,
        d.nama_sertif as nama_surat_tanah2,
        ')
            ->from('master_tanah a')
            ->join('master_proyek b', 'a.proyek_id = b.id', 'left')
            ->join('master_sertifikat_tanah c', 'c.id = a.status_surat_tanah1', 'left')
            ->join('master_sertifikat_tanah d', 'd.id = a.status_surat_tanah2', 'left');

        if ($perumahan != null) {
            $this->db->where('a.proyek_id', $perumahan);
        }

        if ($status_perumahan != null) {
            $this->db->where('a.status_proyek', $status_perumahan);
        }

        if (!empty($tgl_awal) && !empty($tgl_akhir)) {
            $this->db->where('a.tgl_pembelian BETWEEN "' . $tgl_awal . '" and "' . $tgl_akhir . '"');
        }

        $query = $this->db->get();
        return $query->result();
    }
    public function export_tanah($id_tanah)
    {
        $this->db->select('
        master_tanah.*,
        master_proyek.nama_proyek, 
        master_status_proyek.nama_status, 
        master_sertifikat_tanah.kode, 
        ')
            ->from('master_tanah')
            ->join('master_proyek', 'master_proyek.id = master_tanah.proyek_id', 'left')
            ->join('master_status_proyek', 'master_status_proyek.id = master_tanah.status_proyek', 'left')
            ->join('master_sertifikat_tanah', 'master_sertifikat_tanah.id = master_tanah.status_surat_tanah1', 'left')
            ->where('master_tanah.id', $id_tanah);
        return $this->db->get()->result();
    }
    public function export_pembayaran($id_tanah, $tgl_awal = '', $tgl_akhir = '')
    {
        $this->db->select('
        tbl_pembayaran_tanah.tgl_pembayaran, 
        tbl_pembayaran_tanah.status_bayar, 
        tbl_pembayaran_tanah.total_bayar, 
        tbl_pembayaran_tanah.ket as keterangan
        ')
            ->from('tbl_pembayaran_tanah')
            ->where('tbl_pembayaran_tanah.tanah_id', $id_tanah);

        if (!empty($tgl_awal) && !empty($tgl_akhir)) {
            $this->db->where('tbl_pembayaran_tanah.tgl_pembayaran BETWEEN "' . $tgl_awal . '" and "' . $tgl_akhir . '"');
        }
        return $this->db->get()->result();
    }
    //EXPORT EXCEL MASTER TANAH END

    //EXPORT MENU NO.1 START
    public function export_proses_ijin_lokasi($proyek_id = '', $firstdate = '', $lastdate = '', $status_proyek = '', $status_ijin = '')
    {
        $this->db->select('
            master_tanah.status_teknik,
            master_tanah.luas_surat,
            master_proyek.nama_proyek,
            tbl_ijin_lokasi.*,
            tbl_ijin_lokasi.status as status_ijin,
            master_status_proyek.nama_status
            ')
            ->from('tbl_ijin_lokasi')
            ->join('master_tanah', 'tbl_ijin_lokasi.tanah_id = master_tanah.id')
            ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id')
            ->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id');
        if (!empty($firstdate) and !empty($lastdate)) {
            $this->db->where('tbl_ijin_lokasi.daftar_online_oss BETWEEN "' . $firstdate . '" and "' . $lastdate . '"');
        }
        if (!empty($proyek_id)) {
            $this->db->where('master_proyek.id', $proyek_id);
        }
        if (!empty($status)) {
            $this->db->where('master_tanah.status_proyek', $status_proyek);
        }
        if (!empty($status)) {
            $this->db->where('master_tanah.status_proyek', $status_proyek);
        }
        if (!empty($status_ijin)) {
            $this->db->where('tbl_ijin_lokasi.status', $status_ijin);
        }
        return $this->db->get()->result();
    }
    public function export_terbit_ijin_lokasi($proyek_id = '', $status = '')
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
        if ($proyek_id) {
            $this->db->where('master_tanah.proyek_id', $proyek_id);
        }

        if ($status) {
            $this->db->where('master_tanah.status_proyek', $status);
        }
        return $this->db->get()->result();
    }
    //EXPORT MENU NO.1 END

    //EXPORT MENU NO.2 START
    public function export_evaluasi_pembelian_Tanah($proyek_id = '', $status = '', $tahun = '', $firstdate = '', $lastdate = '')
    {
        $this->db->select('
        a.*,
        b.*,
        c.kode as kode_sertifikat1,
        d.kode as kode_sertifikat2,
        c.nama_sertif as nama_sertif1,
        d.nama_sertif as nama_sertif2,
        ')
            ->from('master_tanah a')
            ->join('master_proyek b', 'a.proyek_id = b.id', 'left')
            ->join('master_sertifikat_tanah c', 'c.id = a.status_surat_tanah1', 'left')
            ->join('master_sertifikat_tanah d', 'd.id = a.status_surat_tanah2', 'left');

        if ($proyek_id != null) {
            $this->db->where('a.proyek_id', $proyek_id);
        }
        if ($status != null) {
            $this->db->where('a.status_proyek', $status);
        }
        if ($tahun != null) {
            $this->db->where('YEAR(a.created_at)', $tahun);
        }
        if ($firstdate && $lastdate) {
            $this->db->where('a.created_at BETWEEN "' . $firstdate . '" and "' . $lastdate . '"');
        }

        return $this->db->get()->result();
    }
    public function export_rekap_tanah($proyek_id = '', $status = '')
    {
        $this->db->select('master_tanah.*,master_tanah.id as id_tanah,master_proyek.*,master_status_proyek.*');
        $this->db->from('master_tanah');
        $this->db->join('master_proyek', 'master_proyek.id = master_tanah.proyek_id', 'left');
        $this->db->join('master_status_proyek', 'master_status_proyek.id = master_tanah.status_proyek', 'left');
        $this->db->group_by('master_tanah.proyek_id');
        $this->db->group_by('master_tanah.status_proyek');

        if (!empty($status)) {
            $this->db->where('master_tanah.status_proyek', $status);
        }
        if (!empty($proyek_id)) {
            $this->db->where('master_tanah.proyek_id', $proyek_id);
        }

        return $this->db->get()->result();
    }
    public function export_target_menu($id = null, $tahun = null, $status_proyek = null)
    {
        $this->db->select('target_bidang, target_luas');
        $this->db->from('master_proyek_target');
        $this->db->join('master_proyek', 'master_proyek_target.proyek_id = master_proyek.id', 'left');
        $this->db->where('year(tahun)', $tahun);
        $this->db->where('proyek_id', $id);

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
    public function get_realisasi_menu($id, $sebelum, $sesudah, $status_proyek)
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
    //EXPORT MENU NO.2 END

    //EXPORT MENU NO.5 START
    public function export_evaluasi_induk($proyek_id = null, $tahun = null, $status = null)
    {
        $this->db->select('
        tbl_proses_induk.*,
        tbl_proses_induk.id as id_proses_induk,
        tbl_proses_induk.no_gambar as no_gambar_induk,
        tbl_proses_induk.ket as ket_induk,
        sub_proses_induk.*,
        master_tanah.*,
        master_tanah.id as id_tanah,
        a.kode as kode_sertifikat1,
        b.kode as kode_sertifikat2,
        master_proyek.*,
        master_proyek.nama_proyek,
        master_status_proyek.nama_status,
        ')
            ->from('tbl_proses_induk')
            ->join('sub_proses_induk', 'tbl_proses_induk.id = sub_proses_induk.induk_id', 'left')
            ->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id', 'left')
            ->join('master_sertifikat_tanah a', 'master_tanah.status_surat_tanah1 = a.id', 'left')
            ->join('master_sertifikat_tanah b', 'master_tanah.status_surat_tanah2 = b.id', 'left')
            ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id', 'left')
            ->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id', 'left')
            ->group_by('sub_proses_induk.induk_id');
        // $this->db->order_by('b.id_master_item')

        if ($proyek_id) {
            $this->db->where('master_tanah.proyek_id', $proyek_id);
        }

        if ($tahun) {
            $this->db->where('year(tbl_proses_induk.created_at)', $tahun);
        }

        if ($status) {
            $this->db->where('tbl_proses_induk.status_induk', $status);
        }


        return $this->db->get()->result();
    }
    public function export_sub_induk($id_induk)
    {
        $this->db->select('*');
        $this->db->from('sub_proses_induk');
        $this->db->join('master_tanah', 'sub_proses_induk.tanah_id = master_tanah.id');
        $this->db->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id');
        $this->db->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id');
        $this->db->where('sub_proses_induk.induk_id', $id_induk);

        return $this->db->get()->result();
    }

    public function export_rekap_proses_induk($proyek = null, $status = null)
    {
        $this->db->select('
                    tbl_proses_induk.*,
                    tbl_proses_induk.id as id_proses_induk,
                    tbl_proses_induk.ket as ket_proses,
                    master_tanah.*,
                    master_status_proyek.nama_status,
                    master_proyek.nama_proyek,
                    tbl_proses_induk.luas_terbit as luas_daftar
            ');



        $this->db->from('tbl_proses_induk');
        $this->db->join(
            'sub_proses_induk',
            'sub_proses_induk.induk_id = tbl_proses_induk.id',
            'left'
        );
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
            $this->db->where(
                'master_tanah.status_proyek',
                $status
            );
        }

        if (!$status) {
            $this->db->group_by('master_proyek.id');
        }


        return $this->db->get();
    }

    public function export_count_induk(
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

    //EXPORT MENU NO.5 END

    //EXPORT MENU NO.6 START
    public function export_evaluasi_revisi_split($proyek_id = '', $new_year = '', $old_year = '', $status = null)
    {

        $this->db->select('
            tbl_penggabungan_induk.*,
            tbl_penggabungan_induk.id as id_penggabungan,
            tbl_penggabungan_induk.ket as ket_penggabungan,
            tbl_proses_induk.no_gambar,
            sub_penggabungan_induk.*,
            sub_penggabungan_induk.induk_id as sub_penggabungan_id,
            master_tanah.*,
            master_status_proyek.nama_status,
            master_proyek.nama_proyek,
            
        ')
            ->from('tbl_penggabungan_induk')
            ->join('sub_penggabungan_induk', 'sub_penggabungan_induk.penggabungan_id = tbl_penggabungan_induk.id', 'left')
            ->join('tbl_proses_induk', 'tbl_proses_induk.id = sub_penggabungan_induk.induk_id', 'left')
            ->join('sub_proses_induk', 'sub_proses_induk.induk_id = tbl_proses_induk.id', 'left')
            ->join('master_tanah', 'master_tanah.id = sub_proses_induk.tanah_id', 'left')
            ->join('master_proyek', 'master_proyek.id = master_tanah.proyek_id', 'left')
            ->join('master_status_proyek', 'master_status_proyek.id = master_tanah.status_proyek', 'left')
            ->group_by('sub_penggabungan_induk.penggabungan_id');

        if (!empty($new_year) and !empty($old_year)) {
            $this->db->where('tbl_penggabungan_induk.created_at BETWEEN "' . $new_year . '" and "' . $old_year . '"');
        }
        if (!empty($proyek_id)) {
            $this->db->where('master_tanah.proyek_id', $proyek_id);
        }

        if ($status) {
            $this->db->where('master_tanah.status_proyek', $status);
        }

        return $this->db->get()->result();
    }

    public function list_penggabungan_induk($id)
    {
        $this->db->select('
        sub_penggabungan_induk.*,
        tbl_proses_induk.*
        ')
            ->from('sub_penggabungan_induk')
            ->join('tbl_proses_induk', 'sub_penggabungan_induk.induk_id = tbl_proses_induk.id')
            ->where('sub_penggabungan_induk.penggabungan_id', $id);

        return $this->db->get()->result();
    }

    public function export_rekap_penggabungan_split($new_year = null, $old_year = null, $proyek = null, $status = null, $type = null, $st_proyek = null)
    {


        if ($status && $type) {
            if ($type == 'luas') {
                if ($status == 'proses') {
                    $this->db->select('SUM(master_tanah.luas_surat) AS luas_terbit');
                } else if ($status == 'terbit') {
                    $this->db->select('SUM(tbl_penggabungan_induk.luas_terbit) AS luas_terbit');
                }
            } else if ($type == 'bid') {
                $this->db->select('tbl_penggabungan_induk.*');
            }
        } else {
            $this->db->select('
                    tbl_penggabungan_induk.*,
                    tbl_penggabungan_induk.id as id_penggabungan_induk,
                    tbl_penggabungan_induk.ket as ket_penggabungan,
                    master_tanah.*,
                    master_proyek.nama_proyek,
                    tbl_proses_induk.luas_terbit as luas_daftar
            ');
        }


        $this->db->from('tbl_penggabungan_induk');
        $this->db->join('sub_penggabungan_induk', 'sub_penggabungan_induk.penggabungan_id = tbl_penggabungan_induk.id', 'left');
        $this->db->join('tbl_proses_induk', 'tbl_proses_induk.id = sub_penggabungan_induk.induk_id', 'left');
        $this->db->join('sub_proses_induk', 'sub_proses_induk.induk_id = tbl_proses_induk.id', 'left');
        $this->db->join('master_tanah', 'master_tanah.id = sub_proses_induk.tanah_id', 'left');
        $this->db->join('master_proyek', 'master_proyek.id = master_tanah.proyek_id', 'left');

        if ($proyek) {
            $this->db->where(
                'master_proyek.id',
                $proyek
            );
        }

        if ($status) {
            $this->db->where('tbl_penggabungan_induk.status_penggabungan', $status);
        }

        if ($old_year) {
            $this->db->where('year(tbl_penggabungan_induk.created_at) <=', $old_year);
        }

        if ($new_year) {
            $this->db->where(
                'year(tbl_penggabungan_induk.created_at)',
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

    public function export_count_bidluas(
        $proyek = null,
        $type = null,
        $status = null,
        $new_year = null,
        $old_year = null
    ) {

        if ($type && $type == 'luas') {
            if ($status == 'proses') {
                $this->db->select('SUM(master_tanah.luas_surat) as luas_terbit');
            } else if ($status == 'terbit') {
                $this->db->select('SUM(tbl_penggabungan_induk.luas_terbit) as luas_terbit');
            }
        } else {
            $this->db->select('tbl_penggabungan_induk.ket as ket_real');
        }

        $this->db->from('tbl_penggabungan_induk');
        $this->db->join('sub_penggabungan_induk', 'sub_penggabungan_induk.penggabungan_id = tbl_penggabungan_induk.id');
        $this->db->join('tbl_proses_induk', 'tbl_proses_induk.id = sub_penggabungan_induk.induk_id');
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
            $this->db->where('tbl_penggabungan_induk.status_penggabungan', $status);
        }

        if ($old_year) {
            $this->db->where('year(tbl_penggabungan_induk.created_at) <=', $old_year);
        }

        if ($new_year) {
            $this->db->where(
                'year(tbl_penggabungan_induk.created_at)',
                $new_year
            );
        }

        return $this->db->get();
    }
    //EXPORT MENU NO.6 END
}
