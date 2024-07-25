<?php

function cek_ajax()
{
    $t = get_instance();
    if (!$t->input->is_ajax_request()) {
        exit('No direct script access allowed');
    }
}

function get_user()
{
    $t = get_instance();
    $username = $t->session->userdata('username');
    $user = $t->db->get_where('user', ['username' => $username])->row();
    if ($user) {
        return $user;
    } else {
        redirect('login');
    }
}

function tgl_indo($date)
{
    if ($date == '0000-00-00' || $date == null) {
        return '-';
    } else {
        $BulanIndo = array(
            "Januari", "Februari", "Maret",

            "April", "Mei", "Juni",

            "Juli", "Agustus", "September",

            "Oktober", "November", "Desember"
        );

        $tahun = substr($date, 0, 4);

        $bulan = substr($date, 5, 2);

        $tgl   = substr($date, 8, 2);

        $jam   = substr($date, 10);

        $result = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun . " " . $jam;

        return ($result);
    }
}

function rupiah($angka)
{

    if ($angka == '' || $angka == null) {

        $rupiah = 0;
    } else {

        $rupiah = number_format($angka, 0, ',', '.');
    }

    return "Rp " . $rupiah;
}

function bilanganbulat($teks)
{
    $teks = preg_replace("/[^0-9]/", "", $teks);
    return $teks;
}
function cek_tgl($elem)
{
    if ($elem == '0000-00-00' || $elem == '' || $elem == null) {
        echo '-';
    } else {
        $d = date_create($elem);
        echo date_format($d, 'd F Y');
    }
}
