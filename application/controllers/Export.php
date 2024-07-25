<?php
defined('BASEPATH') or exit('No direct script access allowed');
require './assets/phpspreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller
{
    //EXPORT EXCEL MASTER TANAH START
    public function master_tanah()
    {
        $perumahan = $this->input->get('perumahan');
        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $status_perumahan = $this->input->get('status_perumahan');

        if ($perumahan != '') {
            if ($status_perumahan == '') {
                $data = $this->export->export_master_tanah($perumahan, $tgl_awal, $tgl_akhir);
            } else {
                $data = $this->export->export_master_tanah($perumahan, $tgl_awal, $tgl_akhir, $status_perumahan);
            }
        } else {
            if ($status_perumahan != '') {
                $data = $this->export->export_master_tanah(null, $tgl_awal, $tgl_akhir, $status_perumahan);
            } else {
                $data = $this->export->export_master_tanah(null, $tgl_awal, $tgl_akhir);
            }
            if ($perumahan == NULL && $status_perumahan == NULL) {
                $data = $this->export->export_master_tanah();
            } else {
                $data = $this->export->export_master_tanah();
            }
        }

        $html_master_tanah = '';
        $no = 1;

        foreach ($data as $per) {
            if ($per->biaya_lain_pematangan == NULL) {
                $pematangan = 0;
            } else {
                $pematangan = $per->biaya_lain_pematangan;
            }

            if ($per->biaya_lain_pbb == NULL) {
                $lain_pbb = 0;
            } else {
                $lain_pbb = $per->biaya_lain_pbb;
            }

            if ($per->biaya_lain_rugi == NULL) {
                $ganti_rugi = 0;
            } else {
                $ganti_rugi = $per->biaya_lain_rugi;
            }

            if ($per->biaya_lain == NULL) {
                $biaya_lain = 0;
            } else {
                $biaya_lain = $per->biaya_lain;
            }

            if ($per->harga_jual_makelar == '') {
                $harga_jual_makelar = 0;
            } else {
                $harga_jual_makelar = $per->harga_jual_makelar;
            }

            if ($per->total_harga_pengalihan == 0) {
                $total_harga_pengalihan = 0;
            } else {
                $total_harga_pengalihan  = $per->total_harga_pengalihan;
            }

            if ($per->luas_surat == NULL) {
                $per_luas_surat = 0;
            } else {
                $per_luas_surat  = $per->luas_surat;
            }

            if ($per->total_harga_pengalihan == 0) {
                $harga_satuan = 0;
            } else {
                $harga_satuan = $harga_jual_makelar / $per_luas_surat;
            }

            $total_biaya_lain_lain = $pematangan + $lain_pbb + $ganti_rugi + $biaya_lain;
            $total = $per->harga_jual_makelar + $per->total_harga_pengalihan + $total_biaya_lain_lain;
            if ($data) {
                $row = "<td>" . $no++ . "</td>";
                $nama_proyek = "<td>$per->nama_proyek</td>";
                $tgl_pembelian = "<td>" . tgl_indo($per->tgl_pembelian) . "</td>";
                $nama_penjual = "<td>$per->nama_penjual</td>";
                $nama_surat_tanah1 = "<td>$per->nama_surat_tanah1</td>";
                $kode_sertifikat1 = "<td>$per->kode_sertifikat1</td>";
                $keterangan1 = "<td>$per->keterangan1</td>";
                $nama_surat_tanah2 = "<td>$per->nama_surat_tanah2</td>";
                $kode_sertifikat2 = "<td>$per->kode_sertifikat2</td>";
                $keterangan2 = "<td>$per->keterangan2</td>";
                $nomor_gambar = "<td>$per->nomor_gambar</td>";
                $jumlah_bidang = "<td>1</td>";
                $luas_surat = "<td>$per->luas_surat</td>";
                $luas_ukur = "<td>$per->luas_ukur</td>";

                $nomor_pbb = "<td>$per->nomor_pbb</td>";
                $luas_bangunan_pbb = "<td>$per->luas_bangunan_pbb</td>";
                $njop_bangunan = "<td>" . rupiah($per->njop_bangunan) . "</td>";
                $harga_satuan = "<td>" . rupiah($harga_satuan) . "</td>";
                $harga_jual_makelar = "<td>" . rupiah($harga_jual_makelar) . "</td>";
                $nama_makelar = "<td>$per->nama_makelar</td>";
                $total_harga_pengalihan = "<td>" . rupiah($total_harga_pengalihan) . "</td>";

                $tgl_status_pengalihan = "<td>" . tgl_indo($per->tgl_status_pengalihan) . "</td>";
                $no_akta_pengalihan = "<td>$per->no_akta_pengalihan</td>";
                $atas_nama_pengalihan = "<td>$per->atas_nama_pengalihan</td>";

                $biaya_pematangan = "<td>" . rupiah($pematangan) . "</td>";
                $biaya_ganti_rugi = "<td>" . rupiah($ganti_rugi) . "</td>";
                $biaya_lain_pbb = "<td>" . rupiah($lain_pbb) . "</td>";
                $biaya_lain_lain = "<td>" . rupiah($biaya_lain) . "</td>";
                $total_biaya_lain = "<td>" . rupiah($total_biaya_lain_lain) . "</td>";

                $total_biaya = "<td>" . rupiah($total) . "</td>";
                $total_harga = "<td>" . rupiah($total / $per->luas_ukur) . "</td>";

                $keterangan = "<td>$per->ket</td>";

                $html_master_tanah .= "<tr>" .
                    $row .
                    $nama_proyek .
                    $tgl_pembelian .
                    $nama_penjual .
                    $nama_surat_tanah1 .
                    $kode_sertifikat1 .
                    $keterangan1 .
                    $nama_surat_tanah2 .
                    $kode_sertifikat2 .
                    $keterangan2 .
                    $nomor_gambar .
                    $luas_surat .
                    $luas_ukur .
                    $nomor_pbb .
                    $luas_bangunan_pbb .
                    $njop_bangunan .
                    $harga_satuan .
                    $harga_jual_makelar .
                    $nama_makelar .
                    $total_harga_pengalihan .
                    $tgl_status_pengalihan .
                    $no_akta_pengalihan .
                    $atas_nama_pengalihan .
                    $biaya_pematangan .
                    $biaya_ganti_rugi .
                    $biaya_lain_pbb .
                    $biaya_lain_lain .
                    $total_biaya_lain .
                    $total_biaya .
                    $total_harga .
                    $keterangan .
                    "</tr>";
            } else {
                $html_master_tanah .= "<tr>
                    <td></td>
                </tr>";
            }
        }
        $test = '
                <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: verdana;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                </head>
                <body>
                <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                <br>
                <span style="font-size: 18px"><b>LAPORAN MASTER TANAH</b></span>
                <br>
                <span style="font-size: 18px"><b>TAHUN ' . date('Y') . '</b></span>
                <br>
                <table border="1">
                    <tr style="background-color: #343a40; color: white;">
                        <th rowspan="2" style="vertical-align: middle;">No</th>
                                     <th rowspan="2" style="vertical-align: middle;">Lokasi</th>
                                     <th rowspan="2" style="vertical-align: middle;">Tanggal Pembelian</th>
                                     <th rowspan="2" style="vertical-align: middle;">Nama Penjual</th>
                                     <th colspan="3" style="vertical-align: middle;">Data Surat Tanah 1</th>
                                     <th colspan="3" style="vertical-align: middle;">Data Surat Tanah 2</th>
                                     <th rowspan="2" style="vertical-align: middle;">No Gambar</th>
                                     <th colspan="2" style="vertical-align: middle;">Luas (m2)</th>
                                     <th colspan="3" style="vertical-align: middle;">PBB</th>
                                     <th colspan="2" style="vertical-align: middle;">Harga Pengalihan Hak</th>
                                     <th colspan="2" style="vertical-align: middle;">Makelar</th>
                                     <th colspan="3" style="vertical-align: middle;">Pengalihan Hak</th>
                                     <th colspan="5" style="vertical-align: middle;">Biaya Lain-lain</th>
                                     <th rowspan="2" style="vertical-align: middle;">Total Harga</th>
                                     <th rowspan="2" style="vertical-align: middle;">Harga / M^2</th>
                                     <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
                    </tr>
                    <tr style="background-color: #007bff; color: white;">
                       <th style="vertical-align: middle;">Nama</th>
                                     <th style="vertical-align: middle;">Surat</th>
                                     <th style="vertical-align: middle;">Nomor Surat</th>
                                     <th style="vertical-align: middle;">Nama</th>
                                     <th style="vertical-align: middle;">Surat</th>
                                     <th style="vertical-align: middle;">Nomor Surat</th>
                                     <th style="vertical-align: middle;">Surat</th>
                                     <th style="vertical-align: middle;">Ukur</th>
                                     <th style="vertical-align: middle;">Nomor</th>
                                     <th style="vertical-align: middle;">Luas</th>
                                     <th style="vertical-align: middle;">NJOP Bangunan</th>
                                     <th style="vertical-align: middle;">Satuan</th>
                                     <th style="vertical-align: middle;">Total</th>
                                     <th style="vertical-align: middle;">Nama</th>
                                     <th style="vertical-align: middle;">Nilai</th>
                                     <th style="vertical-align: middle;">Tanggal</th>
                                     <th style="vertical-align: middle;">Akta</th>
                                     <th style="vertical-align: middle;">Nama</th>
                                     <th style="vertical-align: middle;">Pematangan</th>
                                     <th style="vertical-align: middle;">Ganti Rugi</th>
                                     <th style="vertical-align: middle;">PBB</th>
                                     <th style="vertical-align: middle;">Lain-lain</th>
                                     <th style="vertical-align: middle;">Total</th>
                    </tr>
                    ' . $html_master_tanah . '
                </table>
                </body></html>
                ';


        $file = "Laporan Excel Master Tanah.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$file\"");
        echo $test;
        exit;
    }
    public function pembayaran_master_tanah($id_tanah)
    {
        $tgl_awal = $this->input->get('firstdate');
        $tgl_akhir = $this->input->get('lastdate');

        $query_tanah = $this->export->export_tanah($id_tanah);
        $query_pembayaran = $this->export->export_pembayaran($id_tanah, $tgl_awal, $tgl_akhir);

        $html_tanah = '';
        $html_pembayaran = '';
        $jml_total_pembayaran = '';

        $no = 1;

        foreach ($query_tanah as $r) {

            if ($query_tanah) {

                $nama_penjual = "<td style='text-align: center;vertical-align: middle;'>$r->nama_penjual</td>";
                $nama_proyek = "<td style='text-align: center;vertical-align: middle;'>$r->nama_proyek ($r->nama_status)</td>";
                $keterangan1 = "<td style='text-align: center;vertical-align: middle;'>$r->keterangan1</td>";
                $status_surat_tanah = "<td style='text-align: center;vertical-align: middle;'>$r->kode</td>";
                $luas_surat = "<td style='text-align: center;vertical-align: middle;'>$r->luas_surat</td>";
                $luas_ukur = "<td style='text-align: center;vertical-align: middle;'>$r->luas_ukur</td>";

                $html_tanah .= "<tr>
                        " .
                    $nama_penjual .
                    $nama_proyek .
                    $nama_proyek .
                    $keterangan1 .
                    $status_surat_tanah .
                    $luas_surat .
                    $luas_ukur
                    . "
        </tr>";
            } else {
                $html_tanah .= "<tr>
                    <td></td>
                </tr>";
            }
        }

        foreach ($query_pembayaran as $d) {

            if ($query_pembayaran) {

                $row = "<td style='text-align: center;vertical-align: middle;'>" . $no++ . "</td>";
                $tgl_pembayaran = "<td style='text-align: center;vertical-align: middle;'>" . tgl_indo($d->tgl_pembayaran) . "</td>";
                $total_bayar = "<td style='text-align: center;vertical-align: middle;'>" . rupiah($d->total_bayar) . "</td>";
                $status_bayar = "<td style='text-align: center;vertical-align: middle;'>$d->status_bayar</td>";
                $keterangan = "<td style='text-align: center;vertical-align: middle;'>$d->keterangan</td>";

                $sum_total_bayar = $this->db->select('SUM(total_bayar) as total')
                    ->from('tbl_pembayaran_tanah')
                    ->where('tbl_pembayaran_tanah.tanah_id', $id_tanah)
                    ->get()->row()->total;
                $jml_total_pembayaran .= "<td style='text-align: center;vertical-align: middle;'>" . rupiah($sum_total_bayar) . "</td>";

                $html_pembayaran .= "<tr>
                        " .
                    $row .
                    $tgl_pembayaran .
                    $total_bayar .
                    $status_bayar .
                    $keterangan
                    . "
        </tr>";
            } else {
                $html_pembayaran .= "<tr>
                    <td></td>
                </tr>";
            }
        }

        $test = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: verdana;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                    <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                    <br>
                    <span style="font-size: 18px"><b>DATA PEMBELIAN TANAH</b></span>
                    <br>
                    <span style="font-size: 18px"><b>TAHUN ' . date('Y') . '</b></span>
                    <br>
                    <table border="1">
                    <tr>
                        <th style="text-align: center;vertical-align: middle;">NAMA PENJUAL</th>
                        <th style="text-align: center;vertical-align: middle;">LOKASI</th>
                        <th style="text-align: center;vertical-align: middle;">TANGGAL PEMBELIAN</th>
                        <th style="text-align: center;vertical-align: middle;">NAMA SURAT TANAH</th>
                        <th style="text-align: center;vertical-align: middle;">SURAT TANAH</th>
                        <th style="text-align: center;vertical-align: middle;">LUAS SURAT</th>
                        <th style="text-align: center;vertical-align: middle;">LUAS UKUR</th>
                    </tr>               
                   ' . $html_tanah . '
                    </table>
                   <br>

                   <table border="1">
                    <tr>
                        <th style="text-align: center;vertical-align: middle;">NO</th>
                        <th style="text-align: center;vertical-align: middle;">TANGGAL PEMBAYARAN</th>
                        <th style="text-align: center;vertical-align: middle;">NOMINAL</th>
                        <th style="text-align: center;vertical-align: middle;">STATUS PEMBAYARAN</th>
                        <th style="text-align: center;vertical-align: middle;">KETERANGAN</th>
                    </tr>               
                   ' . $html_pembayaran . '
                   <tr>
                    <td style="text-align: center;vertical-align: middle;" colspan="2">Total Yang Telah Dibayar</td>
                    ' . $jml_total_pembayaran . '
                   </tr>
                </table>';
        $file = "Laporan Pembayaran Tanah.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }
    //EXPORT EXCEL MASTER TANAH END

    //EXPORT MENU NO.1 START
    public function proses_ijin_lokasi()
    {
        $proyek_id = $this->input->get('proyek_f');
        $status_id = $this->input->get('status_f');

        if ($proyek_id || $status_id) {
            $data_seb = $this->export->export_proses_ijin_lokasi($proyek_id, '1970-01-01', (date('Y') - 1) . '-12-31', $status_id, 'proses');
            $data_ses =  $this->export->export_proses_ijin_lokasi($proyek_id, date('Y' . '-01-01'), date('Y') . '-12-31', $status_id, 'proses');
        } else {
            $data_seb = $this->export->export_proses_ijin_lokasi('', '1970-01-01', (date('Y') - 1) . '-12-31', '', 'proses');
            $data_ses =  $this->export->export_proses_ijin_lokasi('', date('Y' . '-01-01'), date('Y') . '-12-31', '', 'proses');
        }
        $luas_terbit = 0;
        $html_seb = '';
        $html_ses = '';
        $no = 1;

        $today = date('Y-m-d');
        $leftYear = date('Y', strtotime('-1 year', strtotime($today)));

        $tahun_proses_sebelum = "<td colspan='20'>A. sd. Tahun " . $leftYear . "</td>";
        $tahun_proses_sesudah = "<td colspan='20'>B. Tahun " . date('Y') . "</td>";
        foreach ($data_seb as $seb) {
            $luas_terbit = $seb->luas_terbit;
            $luas_kurang = $seb->luas_surat -  $luas_terbit;

            if ($data_seb) {
                $row = "<td>" . $no++ . "</td>";
                $nama_proyek = "<td>$seb->nama_proyek ($seb->nama_status)</td>";
                $koordinat = "<td>$seb->koordinat</td>";
                $luas_surat = "<td>$seb->luas_surat</td>";
                $luas_terbit = "<td>$seb->luas_terbit</td>";
                $luas_selisih = "<td>$luas_kurang</td>";
                $daftar_online_oss = "<td>$seb->daftar_online_oss</td>";
                $no_terbit_oss = "<td>$seb->no_terbit_oss</td>";
                $tgl_daftar_pertimbangan = "<td>$seb->tgl_daftar_pertimbangan</td>";
                $no_berkas_pertimbangan = "<td>$seb->no_berkas_pertimbangan</td>";
                $tgl_terbit_pertimbangan = "<td>$seb->tgl_terbit_pertimbangan</td>";
                $no_sk_pertimbangan = "<td>$seb->no_sk_pertimbangan</td>";
                $tgl_daftar_lokasi = "<td>$seb->tgl_daftar_lokasi</td>";
                $tgl_terbit_lokasi = "<td>$seb->tgl_terbit_lokasi</td>";
                $nomor_ijin_lokasi = "<td>$seb->nomor_ijin_lokasi</td>";
                $masa_berlaku = "<td>$seb->masa_berlaku</td>";
                $status = "<td>$seb->status_ijin</td>";
                $status_tanah = "<td>$seb->status_tanah</td>";
                $ket = "<td>$seb->ket</td>";

                $html_seb .= "<tr>
                        " .
                    $row .
                    $nama_proyek .
                    $koordinat .
                    $luas_surat .
                    $luas_terbit .
                    $luas_selisih .
                    $daftar_online_oss .
                    $no_terbit_oss .
                    $tgl_daftar_pertimbangan .
                    $no_berkas_pertimbangan .
                    $tgl_terbit_pertimbangan .
                    $no_sk_pertimbangan .
                    $tgl_daftar_lokasi .
                    $tgl_terbit_lokasi .
                    $nomor_ijin_lokasi .
                    $masa_berlaku .
                    $status .
                    $status_tanah .
                    $ket
                    . "
        </tr>";
            } else {
                $html_seb .= "<tr>
                    <td></td>
                </tr>";
            }
        }

        foreach ($data_ses as $ses) {
            $luas_terbit = $ses->luas_terbit;
            $luas_kurang = $ses->luas_surat -  $luas_terbit;

            if ($data_ses) {

                $row = "<td>" . $no++ . "</td>";
                $nama_proyek = "<td>$ses->nama_proyek ($ses->nama_status)</td>";
                $koordinat = "<td>$ses->koordinat</td>";
                $luas_surat = "<td>$ses->luas_surat</td>";
                $luas_terbit = "<td>$ses->luas_terbit</td>";
                $luas_selisih = "<td>$luas_kurang</td>";
                $daftar_online_oss = "<td>$ses->daftar_online_oss</td>";
                $no_terbit_oss = "<td>$ses->no_terbit_oss</td>";
                $tgl_daftar_pertimbangan = "<td>$ses->tgl_daftar_pertimbangan</td>";
                $no_berkas_pertimbangan = "<td>$ses->no_berkas_pertimbangan</td>";
                $tgl_terbit_pertimbangan = "<td>$ses->tgl_terbit_pertimbangan</td>";
                $no_sk_pertimbangan = "<td>$ses->no_sk_pertimbangan</td>";
                $tgl_daftar_lokasi = "<td>$ses->tgl_daftar_lokasi</td>";
                $tgl_terbit_lokasi = "<td>$ses->tgl_terbit_lokasi</td>";
                $nomor_ijin_lokasi = "<td>$ses->nomor_ijin_lokasi</td>";
                $masa_berlaku = "<td>$ses->masa_berlaku</td>";
                $status = "<td>$ses->status_ijin</td>";
                $status_tanah = "<td>$ses->status_tanah</td>";
                $ket = "<td>$ses->ket</td>";

                $html_ses .= "<tr>
                        " .
                    $row .
                    $nama_proyek .
                    $koordinat .
                    $luas_surat .
                    $luas_terbit .
                    $luas_selisih .
                    $daftar_online_oss .
                    $no_terbit_oss .
                    $tgl_daftar_pertimbangan .
                    $no_berkas_pertimbangan .
                    $tgl_terbit_pertimbangan .
                    $no_sk_pertimbangan .
                    $tgl_daftar_lokasi .
                    $tgl_terbit_lokasi .
                    $nomor_ijin_lokasi .
                    $masa_berlaku .
                    $status .
                    $status_tanah .
                    $ket
                    . "
        </tr>";
            } else {
                $html_ses .= "<tr>
                <td></td>
            </tr>";
            }
        }


        $test = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: verdana;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                    <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                    <br>
                    <span style="font-size: 18px"><b>EVALUASI PROSES PENYELESAIAN IJIN LOKASI</b></span>
                    <br>
                    <span style="font-size: 18px"><b>TAHUN ' . date('Y') . '</b></span>
                    <br>
                    <table border="1">
                    <tr style="background-color: #343a40; color:white;">
                        <th rowspan="3">No</th>
                        <th rowspan="3">Proyek</th>
                        <th rowspan="1" colspan="4" style="text-align: center;vertical-align: middle;">Data Ijin Lokasi </th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Daftar Online OSS</th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Nomor Terbit OSS</th>
                        <th colspan="4" style="text-align: center;vertical-align: middle;">Daftar Pertimbangan Teknis</th>
                        <th colspan="3" style="text-align: center;vertical-align: middle;">Daftar Ijin Lokasi</th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Masa Berlaku</th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Status Izin</th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Status Tanah</th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Keterangan</th>
                    </tr>
                    <tr style="background-color: #007bff; color:white;">
                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Letak Titik Koordinat</th>
                        <th colspan="3" style="text-align: center;vertical-align: middle;">luas (m2)</th>
                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Tanggal Daftar</th>
                        <th rowspan="2" style="text-align: center;vertical-align: middle;">No Berkas</th>
                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Tanggal Terbit</th>
                        <th rowspan="2" style="text-align: center;vertical-align: middle;">No SK</th>
                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Tanggal Daftar</th>
                        <th rowspan="2" style="text-align: center;vertical-align: middle;">Tanggal Terbit</th>
                        <th rowspan="2" style="text-align: center;vertical-align: middle;">No Surat</th>
                    </tr>
                    <tr>
                        <th style="text-align: center;vertical-align: middle;">Daftar</th>
                        <th style="text-align: center;vertical-align: middle;">Terbit</th>
                        <th style="text-align: center;vertical-align: middle;">Selisih</th>
                    </tr>
                    <span style="font-size: 14px"><b> I. PROSES PENYELESAIAN IJIN LOKASI</b></span>
                    <tr>
                        ' . $tahun_proses_sebelum . '
                    </tr>
                    ' . $html_seb . '
                    <tr>
                        ' . $tahun_proses_sesudah . '
                    </tr>
                     ' . $html_ses . '
                </table>
               
                ';


        $file = "1. Laporan Proyek Proses Evaluasi Izin Lokasi.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }

    public function terbit_ijin_lokasi()
    {
        $proyek_id = $this->input->get('proyek_f');
        $status = $this->input->get('status_f');

        $data = $this->export->export_terbit_ijin_lokasi($proyek_id, $status);

        $luas_terbit = 0;
        $html_data = '';
        $no = 1;

        foreach ($data as $d) {
            $d_terbit = tgl_indo($d->tgl_terbit_lokasi);
            $d_exp = tgl_indo($d->masa_berlaku);
            $persentase = $d->luas_surat / $d->luas_terbit * 100;
            $get_persen_luas = round($persentase);

            if ($data) {
                $row = "<td>" . $no++ . "</td>";
                $nama_proyek = "<td>$d->nama_proyek ($d->nama_status) / $d->no_terbit_oss</td>";
                $luas_terbit = "<td>$d->luas_terbit</td>";
                $no_terbit_oss = "<td>$d->no_terbit_oss</td>";
                $tgl_terbit = "<td>$d_terbit</td>";
                $tgl_masa_berlaku = "<td>$d_exp</td>";

                $luas_surat = "<td>$d->luas_surat</td>";
                $persen_luas = "<td>$get_persen_luas</td>";
                $ket = "<td>$d->ket</td>";

                $html_data .= "<tr>
                        " .
                    $row .
                    $nama_proyek .
                    $luas_terbit .
                    $no_terbit_oss .
                    $tgl_terbit .
                    $tgl_masa_berlaku .
                    $luas_surat .
                    $persen_luas .
                    $ket
                    . "
        </tr>";
            } else {
                $html_data .= "<tr>
                    <td></td>
                </tr>";
            }
        }

        $test = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: verdana;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                    <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                    <br>
                    <span style="font-size: 18px"><b>EVALUASI TERBIT PENYELESAIAN IJIN LOKASI</b></span>
                    <br>
                    <span style="font-size: 18px"><b>TAHUN ' . date('Y') . '</b></span>
                    <br>
                    <table border="1">
                    <tr style="background-color: #51008f; color: white">
                        <th rowspan="3">No</th>
                        <th rowspan="3" class="text-center text-nowrap">Proyek</th>
                        <th colspan="4" class="text-center">Data Ijin Lokasi</th>
                        <th rowspan="2" colspan="2" class="text-center">Tanah Yang Dimiliki</th>
                        <th rowspan="3" class="text-center">Ket</th>
                    </tr>
                    <tr style="background-color: #d1d1d1;">
                        <th rowspan="2" class="text-center">Luas</th>
                        <th rowspan="2" class="text-center">No. Ijin</th>
                        <th colspan="2" class="text-center">Tanggal</th>
                    </tr>
                    <tr>
                        <th class="text-center">Terbit</th>
                        <th class="text-center">Masa Berlaku</th>
                        <th class="text-center">Luas</th>
                        <th class="text-center">%</th>
                    </tr>
                    
                    ' . $html_data . '
                    
                </table>
               
                ';


        $file = "1. Laporan Proyek Terbit Evaluasi Izin Lokasi.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }
    //EXPORT MENU NO.1 END

    //EXPORT MENU NO.2 START
    public function evaluasi_pembayaran_tanah()
    {
        $proyek_id = $this->input->get('proyek_id');
        $status = $this->input->get('status_proyek');
        $tahun = $this->input->get('year');

        if ($status) {
            $this->filter_evaluasi_pembayaran_tanah($proyek_id, $status, $tahun);
            die;
        } else if ($tahun) {
            $data_luar_ijin = $this->export->export_evaluasi_pembelian_Tanah($proyek_id, '1', $tahun);
            $data_dalam_ijin = $this->export->export_evaluasi_pembelian_Tanah($proyek_id, '2', $tahun);
            $data_lokasi = $this->export->export_evaluasi_pembelian_Tanah($proyek_id, '3', $tahun);
        } else {
            $data_luar_ijin = $this->export->export_evaluasi_pembelian_Tanah($proyek_id, '1', '', date('Y' . '-01-01'), date('Y') . '-12-31');
            $data_dalam_ijin = $this->export->export_evaluasi_pembelian_Tanah($proyek_id, '2', '', date('Y' . '-01-01'), date('Y') . '-12-31');
            $data_lokasi = $this->export->export_evaluasi_pembelian_Tanah($proyek_id, '3', '', date('Y' . '-01-01'), date('Y') . '-12-31');
        }

        $html_luar_ijin = '';
        $html_dalam_ijin = '';
        $html_lokasi = '';
        $no = 1;

        foreach ($data_luar_ijin as $dli) {
            if ($dli->luas_ukur) {
                $luas_ukur = $dli->luas_ukur;
            } else {
                $luas_ukur = 0;
            }
            if ($dli->tgl_akta_pengalihan != null) {
                $tgl_akta_pengalihan = tgl_indo($dli->tgl_akta_pengalihan);
            } else {
                $tgl_akta_pengalihan = '-';
            }

            if ($dli->total_harga_pengalihan == 0) {
                $harga_satuan = 0;
                $total_harga_pengalihan = 0;
            } else {
                $total_harga_pengalihan = $dli->total_harga_pengalihan;
                $harga_satuan = $dli->total_harga_pengalihan / $dli->luas_surat;
            }

            if ($dli->harga_jual_makelar == 0 || $dli->harga_jual_makelar == '') {
                $harga_jual_makelar = 0;
            } else {
                $harga_jual_makelar = $dli->harga_jual_makelar;
            }

            if ($dli->biaya_lain == 0 || $dli->biaya_lain == '') {
                $biaya_lain = 0;
            } else {
                $biaya_lain = $dli->biaya_lain;
            }

            if ($dli->biaya_lain_pematangan == '') {
                $pematangan = 0;
            } else {
                $pematangan = $dli->biaya_lain_pematangan;
            }

            if ($dli->biaya_lain_pbb == '') {
                $biaya_lain_pbb = 0;
            } else {
                $biaya_lain_pbb = $dli->biaya_lain_pbb;
            }

            if ($dli->biaya_lain_rugi == '') {
                $ganti_rugi = 0;
            } else {
                $ganti_rugi = $dli->biaya_lain_rugi;
            }

            $total_biaya_lain = $biaya_lain + $pematangan + $biaya_lain_pbb + $ganti_rugi;
            $total_harga_biaya = $total_harga_pengalihan + $harga_jual_makelar + $total_biaya_lain;

            if ($total_harga_biaya == 0) {
                $harga_perm = 0;
            } else {
                $harga_perm = $total_harga_biaya / $luas_ukur;
            }

            if ($data_luar_ijin) {
                $row = "<td style='text-align: center;vertical-align: middle;'>" . $no++ . "</td>";
                $tgl_pembelian = "<td>" . tgl_indo($dli->tgl_pembelian) . "</td>";
                $nama_penjual = "<td>" . $dli->nama_penjual . "</td>";
                $nama_proyek = "<td>$dli->nama_proyek ($dli->nama_surat_tanah1)</td>";
                $nama_surat_tanah1 = "<td>$dli->nama_surat_tanah1</td>";
                $status_surat_tanah1 = "<td>$dli->nama_sertif1</td>";
                $keterangan1 = "<td>$dli->keterangan1</td>";
                $nama_surat_tanah2 = "<td>$dli->nama_surat_tanah2</td>";
                $status_surat_tanah2 = "<td>$dli->nama_sertif2</td>";
                $keterangan2 = "<td>$dli->keterangan2</td>";
                $nomor_gambar = "<td>$dli->nomor_gambar</td>";
                $jumlah_bid = "<td>1</td>";
                $luas_surat = "<td>$dli->luas_surat</td>";
                $luas_ukur = "<td>$luas_ukur</td>";
                $nomor_pbb = "<td>$dli->nomor_pbb</td>";
                $atas_nama_pbb = "<td>$dli->atas_nama_pbb</td>";
                $luas_bangunan_pbb = "<td>$dli->luas_bangunan_pbb</td>";
                $njop_bangunan = "<td>" . rupiah($dli->njop_bangunan) . "</td>";
                $satuan_harga_pengalihan = "<td>" . rupiah($dli->total_harga_pengalihan / $dli->luas_surat) . "</td>";
                $total_harga_pengalihan = "<td>" . rupiah($dli->total_harga_pengalihan) . "</td>";
                $nama_makelar = "<td>$dli->nama_makelar</td>";
                $harga_jual_makelar = "<td>" . rupiah($dli->harga_jual_makelar) . "</td>";
                $tgl_akta_pengalihan = "<td>" . tgl_indo($dli->tgl_akta_pengalihan) . "</td>";
                $no_akta_pengalihan = "<td>$dli->no_akta_pengalihan</td>";
                $atas_nama_pengalihan = "<td>$dli->atas_nama_pengalihan</td>";

                $biaya_lain_pematangan = "<td>" . rupiah($dli->biaya_lain_pematangan) . "</td>";
                $biaya_lain_rugi = "<td>" . rupiah($dli->biaya_lain_rugi) . "</td>";
                $biaya_lain_pbb = "<td>" . rupiah($dli->biaya_lain_pbb) . "</td>";
                $biaya_lain = "<td>" . rupiah($dli->biaya_lain) . "</td>";
                $total_biaya_lain = "<td>" . rupiah($total_biaya_lain) . "</td>";
                $total_harga_biaya = "<td>" . rupiah($total_harga_biaya) . "</td>";
                $harga_perm = "<td>" . rupiah($harga_perm) . "</td>";
                $ket = "<td>$dli->ket</td>";

                $html_luar_ijin .= "<tr>
                        " .
                    $row .
                    $tgl_pembelian .
                    $nama_penjual .
                    $nama_proyek .
                    $nama_surat_tanah1 .
                    $status_surat_tanah1 .
                    $keterangan1 .
                    $nama_surat_tanah2 .
                    $status_surat_tanah2 .
                    $keterangan2 .
                    $nomor_gambar .
                    $jumlah_bid .
                    $luas_surat .
                    $luas_ukur .
                    $atas_nama_pbb .
                    $nomor_pbb .
                    $luas_bangunan_pbb .
                    $njop_bangunan .
                    $satuan_harga_pengalihan .
                    $total_harga_pengalihan .
                    $nama_makelar .
                    $harga_jual_makelar .
                    $tgl_akta_pengalihan .
                    $no_akta_pengalihan .
                    $atas_nama_pengalihan .
                    $biaya_lain_pematangan .
                    $biaya_lain_rugi .
                    $biaya_lain_pbb .
                    $biaya_lain .
                    $total_biaya_lain .
                    $total_harga_biaya .
                    $harga_perm .
                    $ket
                    . "
        </tr>";
            } else {
                $html_luar_ijin .= "<tr>
                    <td></td>
                </tr>";
            }
        }

        foreach ($data_dalam_ijin as $ddi) {
            if ($ddi->luas_ukur) {
                $luas_ukur = $ddi->luas_ukur;
            } else {
                $luas_ukur = 0;
            }
            if ($ddi->tgl_akta_pengalihan != null) {
                $tgl_akta_pengalihan = tgl_indo($ddi->tgl_akta_pengalihan);
            } else {
                $tgl_akta_pengalihan = '-';
            }

            if ($ddi->total_harga_pengalihan == 0) {
                $harga_satuan = 0;
                $total_harga_pengalihan = 0;
            } else {
                $total_harga_pengalihan = $ddi->total_harga_pengalihan;
                $harga_satuan = $ddi->total_harga_pengalihan / $ddi->luas_surat;
            }

            if ($ddi->harga_jual_makelar == 0 || $ddi->harga_jual_makelar == '') {
                $harga_jual_makelar = 0;
            } else {
                $harga_jual_makelar = $ddi->harga_jual_makelar;
            }

            if ($ddi->biaya_lain == 0 || $ddi->biaya_lain == '') {
                $biaya_lain = 0;
            } else {
                $biaya_lain = $ddi->biaya_lain;
            }

            if ($ddi->biaya_lain_pematangan == '') {
                $pematangan = 0;
            } else {
                $pematangan = $ddi->biaya_lain_pematangan;
            }

            if ($ddi->biaya_lain_pbb == '') {
                $biaya_lain_pbb = 0;
            } else {
                $biaya_lain_pbb = $ddi->biaya_lain_pbb;
            }

            if ($ddi->biaya_lain_rugi == '') {
                $ganti_rugi = 0;
            } else {
                $ganti_rugi = $ddi->biaya_lain_rugi;
            }

            $total_biaya_lain = $biaya_lain + $pematangan + $biaya_lain_pbb + $ganti_rugi;
            $total_harga_biaya = $total_harga_pengalihan + $harga_jual_makelar + $total_biaya_lain;

            if ($total_harga_biaya == 0) {
                $harga_perm = 0;
            } else {
                $harga_perm = $total_harga_biaya / $luas_ukur;
            }

            if ($data_dalam_ijin) {

                $row = "<td style='text-align: center;vertical-align: middle;'>" . $no++ . "</td>";
                $tgl_pembelian = "<td>" . tgl_indo($ddi->tgl_pembelian) . "</td>";
                $nama_penjual = "<td>" . $ddi->nama_penjual . "</td>";
                $nama_proyek = "<td>$ddi->nama_proyek ($ddi->nama_surat_tanah1)</td>";
                $nama_surat_tanah1 = "<td>$ddi->nama_surat_tanah1</td>";
                $status_surat_tanah1 = "<td>$ddi->nama_sertif1</td>";
                $keterangan1 = "<td>$ddi->keterangan1</td>";
                $nama_surat_tanah2 = "<td>$ddi->nama_surat_tanah2</td>";
                $status_surat_tanah2 = "<td>$ddi->nama_sertif2</td>";
                $keterangan2 = "<td>$ddi->keterangan2</td>";
                $nomor_gambar = "<td>$ddi->nomor_gambar</td>";
                $jumlah_bid = "<td>1</td>";
                $luas_surat = "<td>$ddi->luas_surat</td>";
                $luas_ukur = "<td>$luas_ukur</td>";
                $nomor_pbb = "<td>$ddi->nomor_pbb</td>";
                $atas_nama_pbb = "<td>$ddi->atas_nama_pbb</td>";
                $luas_bangunan_pbb = "<td>$ddi->luas_bangunan_pbb</td>";
                $njop_bangunan = "<td>" . rupiah($ddi->njop_bangunan) . "</td>";
                $satuan_harga_pengalihan = "<td>" . rupiah($ddi->total_harga_pengalihan / $ddi->luas_surat) . "</td>";
                $total_harga_pengalihan = "<td>" . rupiah($ddi->total_harga_pengalihan) . "</td>";
                $nama_makelar = "<td>$ddi->nama_makelar</td>";
                $harga_jual_makelar = "<td>" . rupiah($ddi->harga_jual_makelar) . "</td>";
                $tgl_akta_pengalihan = "<td>" . tgl_indo($ddi->tgl_akta_pengalihan) . "</td>";
                $no_akta_pengalihan = "<td>$ddi->no_akta_pengalihan</td>";
                $atas_nama_pengalihan = "<td>$ddi->atas_nama_pengalihan</td>";

                $biaya_lain_pematangan = "<td>" . rupiah($ddi->biaya_lain_pematangan) . "</td>";
                $biaya_lain_rugi = "<td>" . rupiah($ddi->biaya_lain_rugi) . "</td>";
                $biaya_lain_pbb = "<td>" . rupiah($ddi->biaya_lain_pbb) . "</td>";
                $biaya_lain = "<td>" . rupiah($ddi->biaya_lain) . "</td>";
                $total_biaya_lain = "<td>" . rupiah($total_biaya_lain) . "</td>";
                $total_harga_biaya = "<td>" . rupiah($total_harga_biaya) . "</td>";
                $harga_perm = "<td>" . rupiah($harga_perm) . "</td>";
                $ket = "<td>$ddi->ket</td>";

                $html_dalam_ijin .= "<tr>
                        " .
                    $row .
                    $tgl_pembelian .
                    $nama_penjual .
                    $nama_proyek .
                    $nama_surat_tanah1 .
                    $status_surat_tanah1 .
                    $keterangan1 .
                    $nama_surat_tanah2 .
                    $status_surat_tanah2 .
                    $keterangan2 .
                    $nomor_gambar .
                    $jumlah_bid .
                    $luas_surat .
                    $luas_ukur .
                    $nomor_pbb .
                    $atas_nama_pbb .
                    $luas_bangunan_pbb .
                    $njop_bangunan .
                    $satuan_harga_pengalihan .
                    $total_harga_pengalihan .
                    $nama_makelar .
                    $harga_jual_makelar .
                    $tgl_akta_pengalihan .
                    $no_akta_pengalihan .
                    $atas_nama_pengalihan .
                    $biaya_lain_pematangan .
                    $biaya_lain_rugi .
                    $biaya_lain_pbb .
                    $biaya_lain .
                    $total_biaya_lain .
                    $total_harga_biaya .
                    $harga_perm .
                    $ket
                    . "
        </tr>";
            } else {
                $html_dalam_ijin .= "<tr>
                <td></td>
            </tr>";
            }
        }

        foreach ($data_lokasi as $dl) {
            if ($dl->luas_ukur) {
                $luas_ukur = $dl->luas_ukur;
            } else {
                $luas_ukur = 0;
            }
            if ($dl->tgl_akta_pengalihan != null) {
                $tgl_akta_pengalihan = tgl_indo($dl->tgl_akta_pengalihan);
            } else {
                $tgl_akta_pengalihan = '-';
            }

            if ($dl->total_harga_pengalihan == 0) {
                $harga_satuan = 0;
                $total_harga_pengalihan = 0;
            } else {
                $total_harga_pengalihan = $dl->total_harga_pengalihan;
                $harga_satuan = $dl->total_harga_pengalihan / $dl->luas_surat;
            }

            if ($dl->harga_jual_makelar == 0 || $dl->harga_jual_makelar == '') {
                $harga_jual_makelar = 0;
            } else {
                $harga_jual_makelar = $dl->harga_jual_makelar;
            }

            if ($dl->biaya_lain == 0 || $dl->biaya_lain == '') {
                $biaya_lain = 0;
            } else {
                $biaya_lain = $dl->biaya_lain;
            }

            if ($dl->biaya_lain_pematangan == '') {
                $pematangan = 0;
            } else {
                $pematangan = $dl->biaya_lain_pematangan;
            }

            if ($dl->biaya_lain_pbb == '') {
                $biaya_lain_pbb = 0;
            } else {
                $biaya_lain_pbb = $dl->biaya_lain_pbb;
            }

            if ($dl->biaya_lain_rugi == '') {
                $ganti_rugi = 0;
            } else {
                $ganti_rugi = $dl->biaya_lain_rugi;
            }

            $total_biaya_lain = $biaya_lain + $pematangan + $biaya_lain_pbb + $ganti_rugi;
            $total_harga_biaya = $total_harga_pengalihan + $harga_jual_makelar + $total_biaya_lain;

            if ($total_harga_biaya == 0) {
                $harga_perm = 0;
            } else {
                $harga_perm = $total_harga_biaya / $luas_ukur;
            }

            if ($data_lokasi) {

                $row = "<td style='text-align: center;vertical-align: middle;'>" . $no++ . "</td>";
                $tgl_pembelian = "<td>" . tgl_indo($dl->tgl_pembelian) . "</td>";
                $nama_penjual = "<td>" . $dl->nama_penjual . "</td>";
                $nama_proyek = "<td>$dl->nama_proyek ($dl->nama_surat_tanah1)</td>";
                $nama_surat_tanah1 = "<td>$dl->nama_surat_tanah1</td>";
                $status_surat_tanah1 = "<td>$dl->nama_sertif1</td>";
                $keterangan1 = "<td>$dl->keterangan1</td>";
                $nama_surat_tanah2 = "<td>$dl->nama_surat_tanah2</td>";
                $status_surat_tanah2 = "<td>$dl->nama_sertif2</td>";
                $keterangan2 = "<td>$dl->keterangan2</td>";
                $nomor_gambar = "<td>$dl->nomor_gambar</td>";
                $jumlah_bid = "<td>1</td>";
                $luas_surat = "<td>$dl->luas_surat</td>";
                $luas_ukur = "<td>$luas_ukur</td>";
                $nomor_pbb = "<td>$dl->nomor_pbb</td>";
                $atas_nama_pbb = "<td>$dl->atas_nama_pbb</td>";
                $luas_bangunan_pbb = "<td>$dl->luas_bangunan_pbb</td>";
                $njop_bangunan = "<td>" . rupiah($dl->njop_bangunan) . "</td>";
                $satuan_harga_pengalihan = "<td>" . rupiah($dl->total_harga_pengalihan / $dl->luas_surat) . "</td>";
                $total_harga_pengalihan = "<td>" . rupiah($dl->total_harga_pengalihan) . "</td>";
                $nama_makelar = "<td>$dl->nama_makelar</td>";
                $harga_jual_makelar = "<td>" . rupiah($dl->harga_jual_makelar) . "</td>";
                $tgl_akta_pengalihan = "<td>" . tgl_indo($dl->tgl_akta_pengalihan) . "</td>";
                $no_akta_pengalihan = "<td>$dl->no_akta_pengalihan</td>";
                $atas_nama_pengalihan = "<td>$dl->atas_nama_pengalihan</td>";

                $biaya_lain_pematangan = "<td>" . rupiah($dl->biaya_lain_pematangan) . "</td>";
                $biaya_lain_rugi = "<td>" . rupiah($dl->biaya_lain_rugi) . "</td>";
                $biaya_lain_pbb = "<td>" . rupiah($dl->biaya_lain_pbb) . "</td>";
                $biaya_lain = "<td>" . rupiah($dl->biaya_lain) . "</td>";
                $total_biaya_lain = "<td>" . rupiah($total_biaya_lain) . "</td>";
                $total_harga_biaya = "<td>" . rupiah($total_harga_biaya) . "</td>";
                $harga_perm = "<td>" . rupiah($harga_perm) . "</td>";
                $ket = "<td>$dl->ket</td>";

                $html_lokasi .= "<tr>
                        " .
                    $row .
                    $tgl_pembelian .
                    $nama_penjual .
                    $nama_proyek .
                    $nama_surat_tanah1 .
                    $status_surat_tanah1 .
                    $keterangan1 .
                    $nama_surat_tanah2 .
                    $status_surat_tanah2 .
                    $keterangan2 .
                    $nomor_gambar .
                    $jumlah_bid .
                    $luas_surat .
                    $luas_ukur .
                    $nomor_pbb .
                    $atas_nama_pbb .
                    $luas_bangunan_pbb .
                    $njop_bangunan .
                    $satuan_harga_pengalihan .
                    $total_harga_pengalihan .
                    $nama_makelar .
                    $harga_jual_makelar .
                    $tgl_akta_pengalihan .
                    $no_akta_pengalihan .
                    $atas_nama_pengalihan .
                    $biaya_lain_pematangan .
                    $biaya_lain_rugi .
                    $biaya_lain_pbb .
                    $biaya_lain .
                    $total_biaya_lain .
                    $total_harga_biaya .
                    $harga_perm .
                    $ket
                    . "
        </tr>";
            } else {
                $html_lokasi .= "<tr>
                <td></td>
            </tr>";
            }
        }


        $test = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: verdana;
                }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                    <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                    <br>
                    <span style="font-size: 18px"><b>EVALUASI PEMBELIAN TANAH</b></span>
                    <br>
                    <span style="font-size: 18px"><b>TAHUN ' . date('Y') . '</b></span>
                    <br>
                    <table border="1">
                    <tr style="background-color: #51008f; color:white;">
                        <th rowspan="2">No</th>
                        <th rowspan="2" style="vertical-align: middle;">Tanggal Pembelian</th>
                        <th rowspan="2" style="vertical-align: middle;">Nama Penjual</th>
                        <th rowspan="2" style="vertical-align: middle;">Lokasi</th>
                        <th colspan="3" style="vertical-align: middle;">Data Surat Tanah 1</th>
                        <th colspan="3" style="vertical-align: middle;">Data Surat Tanah 2</th>
                        <th rowspan="2" style="vertical-align: middle;">Nomor Gambar</th>
                        <th rowspan="2" style="vertical-align: middle;">Jumlah Bidang</th>
                        <th colspan="2" style="vertical-align: middle;">Luas (m2)</th>
                        <th colspan="4" style="vertical-align: middle;">PBB</th>
                        <th colspan="2" style="vertical-align: middle;">Harga Pengalihan Hak</th>
                        <th colspan="2" style="vertical-align: middle;">Makelar</th>
                        <th colspan="3" style="vertical-align: middle;">Pengalihan Hak</th>
                        <th colspan="5" style="vertical-align: middle;">Biaya Lain-lain</th>
                        <th rowspan="2" style="vertical-align: middle;">Total Harga</th>
                        <th rowspan="2" style="vertical-align: middle;">Harga / M^2</th>
                        <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
                    </tr>
                    <tr style="background-color: #d1d1d1;>
                        <th style="vertical-align: middle;">Nama</th>
                        <th style="vertical-align: middle;">Surat</th>
                        <th style="vertical-align: middle;">Nomor Surat</th>
                        <th style="vertical-align: middle;">Nama</th>
                        <th style="vertical-align: middle;">Surat</th>
                        <th style="vertical-align: middle;">Nomor Surat</th>
                        <th style="vertical-align: middle;">Surat</th>
                        <th style="vertical-align: middle;">Ukur</th>
                        <th style="vertical-align: middle;">Atas Nama</th>
                        <th style="vertical-align: middle;">Nomor</th>
                        <th style="vertical-align: middle;">Luas</th>
                        <th style="vertical-align: middle;">NJOP Bangunan</th>
                        <th style="vertical-align: middle;">Satuan</th>
                        <th style="vertical-align: middle;">Total</th>
                        <th style="vertical-align: middle;">Nama</th>
                        <th style="vertical-align: middle;">Nilai</th>
                        <th style="vertical-align: middle;">Tanggal</th>
                        <th style="vertical-align: middle;">Akta</th>
                        <th style="vertical-align: middle;">Nama</th>
                        <th style="vertical-align: middle;">Pematangan</th>
                        <th style="vertical-align: middle;">Ganti Rugi</th>
                        <th style="vertical-align: middle;">PBB</th>
                        <th style="vertical-align: middle;">Lain-lain</th>
                        <th style="vertical-align: middle;">Total</th>
                    </tr>
                    <tr>
                    <th colspan"24"><b>I. IP PROYEK - LUAR IJIN</b></th>
                    </tr>
                    ' . $html_luar_ijin . '
                    <tr>
                    <th colspan"24"><b>II. IP PROYEK - DALAM IJIN</b></th>
                    </tr>
                    ' . $html_dalam_ijin . '
                    <tr>
                    <th colspan"24"><b>III. IP PROYEK - LOKASI</b></th>
                    </tr>
                    ' . $html_lokasi . '
                </table>
               
                ';


        $file = "2. Laporan Proyek Evaluasi Pembelian Tanah.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }

    private function filter_evaluasi_pembayaran_tanah($proyek_id, $status)
    {
        $data = $this->export->export_evaluasi_pembelian_Tanah($proyek_id, $status);
        $status_proyek = $this->db->get_where('master_status_proyek', ['id' => $status])->row();

        $html_data = '';
        $no = 1;
        foreach ($data as $r) {
            if ($r->luas_ukur) {
                $luas_ukur = $r->luas_ukur;
            } else {
                $luas_ukur = 0;
            }
            if ($r->tgl_akta_pengalihan != null) {
                $tgl_akta_pengalihan = tgl_indo($r->tgl_akta_pengalihan);
            } else {
                $tgl_akta_pengalihan = '-';
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

            $total_biaya_lain = $biaya_lain + $pematangan + $biaya_lain_pbb + $ganti_rugi;
            $total_harga_biaya = $total_harga_pengalihan + $harga_jual_makelar + $total_biaya_lain;

            if ($total_harga_biaya == 0) {
                $harga_perm = 0;
            } else {
                $harga_perm = $total_harga_biaya / $luas_ukur;
            }

            if ($data) {
                $row = "<td style='text-align: center;vertical-align: middle;'>" . $no++ . "</td>";
                $tgl_pembelian = "<td>" . tgl_indo($r->tgl_pembelian) . "</td>";
                $nama_penjual = "<td>" . $r->nama_penjual . "</td>";
                $nama_proyek = "<td>$r->nama_proyek ($r->nama_surat_tanah1)</td>";
                $nama_surat_tanah1 = "<td>$r->nama_surat_tanah1</td>";
                $status_surat_tanah1 = "<td>$r->nama_sertif1</td>";
                $keterangan1 = "<td>$r->keterangan1</td>";
                $nama_surat_tanah2 = "<td>$r->nama_surat_tanah2</td>";
                $status_surat_tanah2 = "<td>$r->nama_sertif2</td>";
                $keterangan2 = "<td>$r->keterangan2</td>";
                $nomor_gambar = "<td>$r->nomor_gambar</td>";
                $jumlah_bid = "<td>1</td>";
                $luas_surat = "<td>$r->luas_surat</td>";
                $luas_ukur = "<td>$luas_ukur</td>";
                $nomor_pbb = "<td>$r->nomor_pbb</td>";
                $atas_nama_pbb = "<td>$r->atas_nama_pbb</td>";
                $luas_bangunan_pbb = "<td>$r->luas_bangunan_pbb</td>";
                $njop_bangunan = "<td>" . rupiah($r->njop_bangunan) . "</td>";
                $satuan_harga_pengalihan = "<td>" . rupiah($r->total_harga_pengalihan / $r->luas_surat) . "</td>";
                $total_harga_pengalihan = "<td>" . rupiah($r->total_harga_pengalihan) . "</td>";
                $nama_makelar = "<td>$r->nama_makelar</td>";
                $harga_jual_makelar = "<td>" . rupiah($r->harga_jual_makelar) . "</td>";
                $tgl_akta_pengalihan = "<td>" . tgl_indo($r->tgl_akta_pengalihan) . "</td>";
                $no_akta_pengalihan = "<td>$r->no_akta_pengalihan</td>";
                $atas_nama_pengalihan = "<td>$r->atas_nama_pengalihan</td>";

                $biaya_lain_pematangan = "<td>" . rupiah($r->biaya_lain_pematangan) . "</td>";
                $biaya_lain_rugi = "<td>" . rupiah($r->biaya_lain_rugi) . "</td>";
                $biaya_lain_pbb = "<td>" . rupiah($r->biaya_lain_pbb) . "</td>";
                $biaya_lain = "<td>" . rupiah($r->biaya_lain) . "</td>";
                $total_biaya_lain = "<td>" . rupiah($total_biaya_lain) . "</td>";
                $total_harga_biaya = "<td>" . rupiah($total_harga_biaya) . "</td>";
                $harga_perm = "<td>" . rupiah($harga_perm) . "</td>";
                $ket = "<td>$r->ket</td>";

                $html_data .= "<tr>
                " .
                    $row .
                    $tgl_pembelian .
                    $nama_penjual .
                    $nama_proyek .
                    $nama_surat_tanah1 .
                    $status_surat_tanah1 .
                    $keterangan1 .
                    $nama_surat_tanah2 .
                    $status_surat_tanah2 .
                    $keterangan2 .
                    $nomor_gambar .
                    $jumlah_bid .
                    $luas_surat .
                    $luas_ukur .
                    $atas_nama_pbb .
                    $nomor_pbb .
                    $luas_bangunan_pbb .
                    $njop_bangunan .
                    $satuan_harga_pengalihan .
                    $total_harga_pengalihan .
                    $nama_makelar .
                    $harga_jual_makelar .
                    $tgl_akta_pengalihan .
                    $no_akta_pengalihan .
                    $atas_nama_pengalihan .
                    $biaya_lain_pematangan .
                    $biaya_lain_rugi .
                    $biaya_lain_pbb .
                    $biaya_lain .
                    $total_biaya_lain .
                    $total_harga_biaya .
                    $harga_perm .
                    $ket
                    . "
        </tr>";
            } else {
                $html_data .= "<tr>
            <td></td>
        </tr>";
            }
        }
        $test = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: verdana;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                    <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                    <br>
                    <span style="font-size: 18px"><b>EVALUASI PEMBELIAN TANAH</b></span>
                    <br>
                    <span style="font-size: 18px"><b>TAHUN ' . date('Y') . '</b></span>
                    <br>
                    <table border="1">
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2" style="vertical-align: middle;">Tanggal Pembelian</th>
                         <th rowspan="2" style="vertical-align: middle;">Nama Penjual</th>
                        <th rowspan="2" style="vertical-align: middle;">Lokasi</th>
                        <th colspan="3" style="vertical-align: middle;">Data Surat Tanah 1</th>
                        <th colspan="3" style="vertical-align: middle;">Data Surat Tanah 2</th>
                        <th rowspan="2" style="vertical-align: middle;">Nomor Gambar</th>
                        <th rowspan="2" style="vertical-align: middle;">Jumlah Bidang</th>
                        <th colspan="2" style="vertical-align: middle;">Luas (m2)</th>
                        <th colspan="4" style="vertical-align: middle;">PBB</th>
                        <th colspan="2" style="vertical-align: middle;">Harga Pengalihan Hak</th>
                        <th colspan="2" style="vertical-align: middle;">Makelar</th>
                        <th colspan="3" style="vertical-align: middle;">Pengalihan Hak</th>
                        <th colspan="5" style="vertical-align: middle;">Biaya Lain-lain</th>
                        <th rowspan="2" style="vertical-align: middle;">Total Harga</th>
                        <th rowspan="2" style="vertical-align: middle;">Harga / M^2</th>
                        <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
                    </tr>
                    <tr>
                        <th style="vertical-align: middle;">Nama</th>
                        <th style="vertical-align: middle;">Surat</th>
                        <th style="vertical-align: middle;">Nomor Surat</th>
                        <th style="vertical-align: middle;">Nama</th>
                        <th style="vertical-align: middle;">Surat</th>
                        <th style="vertical-align: middle;">Nomor Surat</th>
                        <th style="vertical-align: middle;">Surat</th>
                        <th style="vertical-align: middle;">Ukur</th>
                        <th style="vertical-align: middle;">Atas Nama</th>
                        <th style="vertical-align: middle;">Nomor</th>
                        <th style="vertical-align: middle;">Luas</th>
                        <th style="vertical-align: middle;">NJOP Bangunan</th>
                        <th style="vertical-align: middle;">Satuan</th>
                        <th style="vertical-align: middle;">Total</th>
                        <th style="vertical-align: middle;">Nama</th>
                        <th style="vertical-align: middle;">Nilai</th>
                        <th style="vertical-align: middle;">Tanggal</th>
                        <th style="vertical-align: middle;">Akta</th>
                        <th style="vertical-align: middle;">Nama</th>
                        <th style="vertical-align: middle;">Pematangan</th>
                        <th style="vertical-align: middle;">Ganti Rugi</th>
                        <th style="vertical-align: middle;">PBB</th>
                        <th style="vertical-align: middle;">Lain-lain</th>
                        <th style="vertical-align: middle;">Total</th>
                    </tr>
                    <tr>
                    <th colspan"24"><b>IP PROYEK - ' . $status_proyek->nama_status . '</b></th>
                    </tr>
                    ' . $html_data . '
                    <tr>
                </table>
               
                ';


        $file = "2. Laporan Proyek Evaluasi Pembelian Tanah " . $status_proyek->nama_status . ".xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }

    public function rekap_pembelian_tanah()
    {
        $proyek_id = $this->input->get('proyek_id');
        $status = $this->input->get('status_proyek');
        if ($status) {
            $data = $this->get_rekap_pembelian($proyek_id, $status);
            die;
        } else {
            $data_luar_ijin = $this->get_rekap_pembelian($proyek_id, '1');
            $data_dalam_ijin = $this->get_rekap_pembelian($proyek_id, '2');
            $data_lokasi = $this->get_rekap_pembelian($proyek_id, '3');
        }

        $html_luar_ijin = '';
        $target_luar_ijin = '';

        $html_dalam_ijin = '';
        $target_dalam_ijin = '';

        $html_lokasi = '';
        $target_lokasi = '';
        $no = 1;

        foreach ($data_luar_ijin as $dli) {
            if ($data_luar_ijin) {
                $row = "<td style='text-align: center;vertical-align: middle;'>" . $no++ . "</td>";
                $nama_proyek = "<td>" . $dli['nama_proyek'] . "</td>";

                $tambahbid_luar = $dli['bidrealsebelum'] + $dli['bidrealsesudah'];
                $tambahluas_luar = $dli['luasrealsebelum'] + $dli['luasrealsesudah'];


                if ($dli['bidtarget']) {
                    $v_bidtarget = "<td>" . $dli['bidtarget'] . "</td>";
                } else {
                    $v_bidtarget = "<td>Tidak Terdapat Target</td>";
                }
                if ($dli['luastarget']) {
                    $v_luastarget = "<td>" . $dli['luastarget'] . "</td>";
                } else {
                    $v_luastarget = "<td>Tidak Terdapat Target</td>";
                }

                $v_bidrealsebelum = "<td>" . $dli['bidrealsebelum'] . "</td>";
                $v_luasrealsebelum = "<td>" . $dli['luasrealsebelum'] . "</td>";
                $v_bidrealsesudah = "<td>" . $dli['bidrealsesudah'] . "</td>";
                $v_luasrealsesudah = "<td>" . $dli['luasrealsesudah'] . "</td>";

                $v_tambahbid = "<td>" . $tambahbid_luar . "</td>";
                $v_tambahluas = "<td>" . $tambahluas_luar . "</td>";

                if ($dli['bidtarget'] == 0) {
                    $bid_evaluasi_luar = $dli['bidrealsesudah'] + $dli['bidrealsebelum'] - 0;
                    $v_bidevaluasi_luar = "<td>" . $bid_evaluasi_luar . "</td>";
                } else {
                    $bid_evaluasi_luar =   ($dli['bidrealsesudah'] + $dli['bidrealsebelum']) - $dli['bidtarget'];
                    if ($bid_evaluasi_luar <= -1) {
                        $kurung_bid_evaluasi_luar = '(' . ($dli['bidrealsesudah'] + $dli['bidrealsebelum'] - $dli['bidtarget']) * -1 . ')';
                    } else {
                        $kurung_bid_evaluasi_luar = $bid_evaluasi_luar;
                    }
                    $v_bidevaluasi_luar = "<td>" . $kurung_bid_evaluasi_luar . "</td>";
                }

                if ($dli['luastarget'] == 0 || $dli['luastarget'] == 0) {
                    $luas_evaluasi_luar = $dli['luasrealsebelum'] + $dli['luasrealsesudah'] - 0;
                    $v_luasevaluasi_luar = "<td>" . $luas_evaluasi_luar . "</td>";
                } else {
                    $luas_evaluasi_luar = ($dli['luasrealsesudah'] + $dli['luasrealsebelum']) - $dli['luastarget'];
                    if ($luas_evaluasi_luar <= -1) {
                        $kurung_luas_evaluasi_luar = '(' . ($dli['luasrealsesudah'] + $dli['luasrealsebelum'] - $dli['luastarget']) * -1 . ')';
                    } else {
                        $kurung_luas_evaluasi_luar = $luas_evaluasi_luar;
                    }
                    $v_luasevaluasi_luar = "<td>" . $kurung_luas_evaluasi_luar . "</td>";
                }

                if ($luas_evaluasi_luar == 0) {
                    $hasil_1 = 0 * 100;
                    $v_hasil = "<td>" . number_format((float)$hasil_1, 2, '.', '') . "%</td>";
                } else if ($luas_evaluasi_luar <= -1) {
                    $hasil_2 = ($luas_evaluasi_luar / $dli['luastarget']) * 100;
                    $v_hasil = "<td>" . number_format((float)$hasil_2, 2, '.', '') . "%</td>";
                } else if ($luas_evaluasi_luar > 1) {
                    $hasil_3 = ($luas_evaluasi_luar / $dli['luastarget']) * 100;
                    $v_hasil = "<td>" . number_format((float)$hasil_3, 2, '.', '') . "%</td>";
                } else {
                    $v_hasil = "<td>0</td>";
                }
                $show = '';


                $html_luar_ijin .= "<tr>
                        " .
                    $row .
                    $nama_proyek .
                    $v_bidtarget .
                    $v_luastarget .
                    $v_bidrealsebelum .
                    $v_luasrealsebelum .
                    $v_bidrealsesudah .
                    $v_luasrealsesudah .
                    $v_tambahbid .
                    $v_tambahluas .
                    $v_bidevaluasi_luar .
                    $v_luasevaluasi_luar .
                    $v_hasil
                    . "
                    
                    </tr>";


                if (isset($dli['datatarget'])) {
                    $d = $dli['datatarget'];
                    $l = count($d);
                    for ($i = 0; $i < $l; $i++) {
                        // $dt_bid = $d[$i]['bid'];
                        // $dt_luas = $d[$i]['luas'];

                        $show .= '
                            <td>' . $d[$i]['bid'] . '</td>
                            <td>' . $d[$i]['luas'] . '</td>
                        ';
                    }
                } else {
                    for ($i = 0; $i < 12; $i++) {
                        // $dt_bid = 0;
                        // $dt_luas = 0;
                        $show .= '
                        <td>0</td>
                        <td>0</td>';
                    }
                }

                $target_luar_ijin .= "<tr>
                        " .
                    $row .
                    $nama_proyek .
                    $show
                    . "
                    </tr>";
            } else {
                $html_luar_ijin .= "<tr>
                    <td></td>
                </tr>";
                $target_luar_ijin .= "<tr>
                    <td></td>
                </tr>";
            }
        }

        foreach ($data_dalam_ijin as $ddi) {
            if ($data_dalam_ijin) {

                $row = "<td style='text-align: center;vertical-align: middle;'>" . $no++ . "</td>";
                $nama_proyek_dalam = "<td>" . $ddi['nama_proyek'] . "</td>";

                $tambahbid_dalam = $ddi['bidrealsebelum'] + $ddi['bidrealsesudah'];
                $tambahluas_dalam = $ddi['luasrealsebelum'] + $ddi['luasrealsesudah'];

                if ($ddi['bidtarget']) {
                    $bid_target_dalam = $ddi['bidtarget'];
                } else {
                    $bid_target_dalam = 0;
                }
                $v_bidtarget_dalam = "<td>" . $bid_target_dalam . "</td>";

                if ($ddi['luastarget']) {
                    $luas_target_dalam = $ddi['luastarget'];
                } else {
                    $luas_target_dalam = 0;
                }
                $v_luastarget_dalam = "<td>" . $luas_target_dalam . "</td>";

                $v_bidrealsebelum_dalam = "<td>" . $ddi['bidrealsebelum'] . "</td>";
                $v_luasrealsebelum_dalam = "<td>" . $ddi['luasrealsebelum'] . "</td>";
                $v_bidrealsesudah_dalam = "<td>" . $ddi['bidrealsesudah'] . "</td>";
                $v_luasrealsesudah_dalam = "<td>" . $ddi['luasrealsesudah'] . "</td>";

                $v_tambahbid_dalam = "<td>" . $tambahbid_dalam . "</td>";
                $v_tambahluas_dalam = "<td>" . $tambahluas_dalam . "</td>";

                if ($bid_target_dalam == 0) {
                    $bid_evaluasi_dalam = $tambahbid_dalam - 0;
                    $v_bidevaluasi_dalam = "<td>" . $bid_evaluasi_dalam . "</td>";
                } else {
                    $bid_evaluasi_dalam =   $tambahbid_dalam - $bid_target_dalam;
                    if ($bid_evaluasi_dalam <= -1) {
                        $kurung_bid_evaluasi_dalam = '(' . ($tambahbid_dalam - $bid_target_dalam) * -1 . ')';
                    } else {
                        $kurung_bid_evaluasi_dalam = $bid_evaluasi_dalam;
                    }
                    $v_bidevaluasi_dalam = "<td>" . $kurung_bid_evaluasi_dalam . "</td>";
                }

                if ($luas_target_dalam == 0) {
                    $luas_evaluasi_dalam = $ddi['luasrealsebelum'] + $ddi['luasrealsesudah'] - 0;
                    $luas_totalevaluasi_dalam = $luas_evaluasi_dalam;
                    $v_luasevaluasi_dalam = "<td>(" . $luas_totalevaluasi_dalam . ")</td>";
                } else {
                    $luas_evaluasi_dalam = $tambahluas_dalam - $luas_target_dalam;
                    if ($luas_evaluasi_dalam <= -1) {
                        $luas_totalevaluasi_dalam = ($tambahluas_dalam - $luas_target_dalam) * -1;
                    } else {
                        $luas_totalevaluasi_dalam = $luas_evaluasi_dalam;
                    }
                    $v_luasevaluasi_dalam = "<td>(" . $luas_totalevaluasi_dalam . ")</td>";
                }

                if ($luas_evaluasi_dalam == 0 || $luas_target_dalam == 0) {
                    $hasil_1 = 0 * 100;
                    $v_hasil_dalam = "<td>" . number_format((float)$hasil_1, 2, '.', '') . "%</td>";
                } else if ($luas_evaluasi_dalam <= -1) {
                    $hasil_2 = ($luas_evaluasi_dalam / $luas_target_dalam * -1) * 100;
                    $v_hasil_dalam = "<td>(" . number_format((float)$hasil_2, 2, '.', '') . "%)</td>";
                } else if ($luas_evaluasi_dalam > 1) {
                    $hasil_3 = ($luas_evaluasi_dalam / $luas_target_dalam) * 100;
                    $v_hasil_dalam = "<td>" . number_format((float)$hasil_3, 2, '.', '') . "%</td>";
                } else {
                    $v_hasil_dalam = "<td>0</td>";
                }

                $show_dalam = '';

                $html_dalam_ijin .= "<tr>
                        " .
                    $row .
                    $nama_proyek_dalam .
                    $v_bidtarget_dalam .
                    $v_luastarget_dalam .
                    $v_bidrealsebelum_dalam .
                    $v_luasrealsebelum_dalam .
                    $v_bidrealsesudah_dalam .
                    $v_luasrealsesudah_dalam .
                    $v_tambahbid_dalam .
                    $v_tambahluas_dalam .
                    $v_bidevaluasi_dalam .
                    $v_luasevaluasi_dalam .
                    $v_hasil_dalam
                    . "
                </tr>";

                if (isset($ddi['datatarget'])) {
                    $d = $ddi['datatarget'];
                    $l = count($d);
                    for ($i = 0; $i < $l; $i++) {
                        // $dt_bid = $d[$i]['bid'];
                        // $dt_luas = $d[$i]['luas'];

                        $show_dalam .= '
                            <td>' . $d[$i]['bid'] . '</td>
                            <td>' . $d[$i]['luas'] . '</td>
                        ';
                    }
                } else {
                    for ($i = 0; $i < 12; $i++) {
                        // $dt_bid = 0;
                        // $dt_luas = 0;
                        $show_dalam .= '
                        <td>0</td>
                        <td>0</td>';
                    }
                }
                $target_dalam_ijin .= "<tr>
                        " .
                    $row .
                    $nama_proyek .
                    $show_dalam
                    . "
                    </tr>";
            } else {
                $html_dalam_ijin .= "<tr>
                <td></td>
            </tr>";
                $target_dalam_ijin .= "<tr>
                    <td></td>
                </tr>";
            }
        }

        foreach ($data_lokasi as $dl) {
            if ($data_lokasi) {
                $row = "<td style='text-align: center;vertical-align: middle;'>" . $no++ . "</td>";
                $nama_proyek_lokasi = "<td>" . $dl['nama_proyek'] . "</td>";

                $tambahbid_lokasi = $dl['bidrealsebelum'] + $dl['bidrealsesudah'];
                $tambahluas_lokasi = $dl['luasrealsebelum'] + $dl['luasrealsesudah'];

                if ($dl['bidtarget']) {
                    $bid_target_lokasi = $dl['bidtarget'];
                } else {
                    $bid_target_lokasi = 0;
                }
                $v_bidtarget_lokasi = "<td>" . $bid_target_lokasi . "</td>";

                if ($dl['luastarget']) {
                    $luas_target_lokasi = $dl['luastarget'];
                } else {
                    $luas_target_lokasi = 0;
                }
                $v_luastarget_lokasi = "<td>" . $luas_target_lokasi . "</td>";

                $v_bidrealsebelum_lokasi = "<td>" . $dl['bidrealsebelum'] . "</td>";
                $v_luasrealsebelum_lokasi = "<td>" . $dl['luasrealsebelum'] . "</td>";
                $v_bidrealsesudah_lokasi = "<td>" . $dl['bidrealsesudah'] . "</td>";
                $v_luasrealsesudah_lokasi = "<td>" . $dl['luasrealsesudah'] . "</td>";

                $v_tambahbid_lokasi = "<td>" . $tambahbid_lokasi . "</td>";
                $v_tambahluas_lokasi = "<td>" . $tambahluas_lokasi . "</td>";

                if ($bid_target_lokasi == 0) {
                    $bid_evaluasi_lokasi = $tambahbid_lokasi - 0;
                    $v_bidevaluasi_lokasi = "<td>" . $bid_evaluasi_lokasi . "</td>";
                } else {
                    $bid_evaluasi_lokasi = $tambahbid_lokasi - $bid_target_lokasi;
                    if ($bid_evaluasi_lokasi <= -1) {
                        $kurung_bid_evaluasi_lokasi = ($tambahbid_lokasi - $bid_target_lokasi) * -1;
                    } else {
                        $kurung_bid_evaluasi_lokasi = $bid_evaluasi_lokasi;
                    }
                    $v_bidevaluasi_lokasi = "<td>(" . $kurung_bid_evaluasi_lokasi . ")</td>";
                }

                if ($luas_target_lokasi == 0) {
                    $luas_evaluasi_lokasi = $dl['luasrealsebelum'] + $dl['luasrealsesudah'] - 0;
                    $v_luasevaluasi_lokasi = "<td>" . $luas_evaluasi_lokasi . "</td>";
                } else {
                    $luas_evaluasi_lokasi = $tambahluas_lokasi - $luas_target_lokasi;
                    if ($luas_evaluasi_lokasi <= -1) {
                        $kurung_luas_evaluasi_lokasi =  ($tambahluas_lokasi - $luas_target_lokasi) * -1;
                    } else {
                        $kurung_luas_evaluasi_lokasi = $luas_evaluasi_lokasi;
                    }
                    $v_luasevaluasi_lokasi = "<td>(" . $kurung_luas_evaluasi_lokasi . ")</td>";
                }

                if ($luas_evaluasi_lokasi == 0 || $luas_target_lokasi == 0) {
                    $hasil_1 = 0 * 100;
                    $v_hasil_lokasi = "<td>" . number_format((float)$hasil_1, 2, '.', '') . "%</td>";
                } else if ($luas_evaluasi_lokasi <= -1) {
                    $hasil_2 = ($luas_evaluasi_lokasi / $luas_target_lokasi * -1) * 100;
                    $v_hasil_lokasi = "<td>(" . number_format((float)$hasil_2, 2, '.', '') . "%)</td>";
                } else if ($luas_evaluasi_lokasi > 1) {
                    $hasil_3 = ($luas_evaluasi_lokasi / $luas_target_lokasi) * 100;
                    $v_hasil_lokasi = "<td>" . number_format((float)$hasil_3, 2, '.', '') . "%</td>";
                } else {
                    $v_hasil_lokasi = "<td>0</td>";
                }


                $show_lokasi = '';

                $html_lokasi .= "<tr>
                        " .
                    $row .
                    $nama_proyek_lokasi .
                    $v_bidtarget_lokasi .
                    $v_luastarget_lokasi .
                    $v_bidrealsebelum_lokasi .
                    $v_luasrealsebelum_lokasi .
                    $v_bidrealsesudah_lokasi .
                    $v_luasrealsesudah_lokasi .
                    $v_tambahbid_lokasi .
                    $v_tambahluas_lokasi .
                    $v_bidevaluasi_lokasi .
                    $v_luasevaluasi_lokasi .
                    $v_hasil_lokasi
                    . "
                </tr>";

                if (isset($dl['datatarget'])) {
                    $d = $dl['datatarget'];
                    $l = count($d);
                    for ($i = 0; $i < $l; $i++) {
                        // $dt_bid = $d[$i]['bid'];
                        // $dt_luas = $d[$i]['luas'];

                        $show_lokasi .= '
                            <td>' . $d[$i]['bid'] . '</td>
                            <td>' . $d[$i]['luas'] . '</td>
                        ';
                    }
                } else {
                    for ($i = 0; $i < 12; $i++) {
                        // $dt_bid = 0;
                        // $dt_luas = 0;
                        $show_lokasi .= '
                        <td>0</td>
                        <td>0</td>';
                    }
                }
                $target_lokasi .= "<tr>
                        " .
                    $row .
                    $nama_proyek .
                    $show_lokasi
                    . "
                    </tr>";
            } else {
                $html_lokasi .= "<tr>
                <td></td>
            </tr>";
                $target_lokasi .= "<tr>
                <td></td>
            </tr>";
            }
        }


        $test = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: verdana;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                    <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                    <br>
                    <span style="font-size: 18px"><b>EVALUASI REKAP PEMBELIAN TANAH</b></span>
                    <br>
                    <span style="font-size: 18px"><b>TAHUN ' . date('Y') . '</b></span>
                    <br>
                    <table border="1">
                    <tr style="background-color: #343a40; color:white">
                         <th rowspan="3" style="text-align: center;vertical-align: middle; ">No</th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle; ">Proyek</th>
                        <th rowspan="2" colspan="2">TARGET s/d ' . date('Y') . '</th>
                        <th colspan="6">REALISASI ' . date('Y') . '</th>
                        <th rowspan="2" colspan="3">EVALUASI</th>
                    </tr>
                    <tr style="background-color: #007bff; color:white">
                        <th colspan="2" style="text-align: center;vertical-align: middle;">Jan - Juni</th>
                        <th colspan="2" style="text-align: center;vertical-align: middle;">Juli - Desember</th>
                        <th colspan="2" style="text-align: center;vertical-align: middle;">TOTAL</th>
                    </tr>
                    <tr>
                       <th style="text-align: center;vertical-align: middle;">Bidang</th>
                                     <th style="text-align: center;vertical-align: middle;">Luas</th>
                                     <th style="text-align: center;vertical-align: middle;">Bidang</th>
                                     <th style="text-align: center;vertical-align: middle;">Luas</th>
                                     <th style="text-align: center;vertical-align: middle;">Bidang</th>
                                     <th style="text-align: center;vertical-align: middle;">Luas</th>
                                     <th style="text-align: center;vertical-align: middle;">Bidang</th>
                                     <th style="text-align: center;vertical-align: middle;">Luas</th>
                                     <th style="text-align: center;vertical-align: middle;">Bidang</th>
                                     <th style="text-align: center;vertical-align: middle;">Luas</th>
                                     <th style="text-align: center;vertical-align: middle;">%</th>
                    </tr>
                    <tr>
                    <th colspan"24"><b>I. IP PROYEK - LUAR IJIN</b></th>
                    </tr>
                    ' . $html_luar_ijin . '
                    <tr>
                    <th colspan"24"><b>II. IP PROYEK - DALAM IJIN</b></th>
                    </tr>
                    ' . $html_dalam_ijin . '
                    <tr>
                    <th colspan"24"><b>III. IP PROYEK - LOKASI</b></th>
                    </tr>
                    ' . $html_lokasi . '
                </table>
               <br>
                <table border="1">
                    <tr style="background-color: #343a40; color:white">
                        <th rowspan="3" style="text-align: center;vertical-align: middle; ">#</th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle; ">Proyek</th>
                        <th colspan="24" style="text-align: center;vertical-align: middle;">TARGET <?= date("Y") ?></th>
                    </tr>
                    <tr style="background-color: #007bff; color:white">
                       <th colspan="2" style="text-align: center;vertical-align: middle;">JAN</th>
                                     <th colspan="2" style="text-align: center;vertical-align: middle;">FEB</th>
                                     <th colspan="2" style="text-align: center;vertical-align: middle;">MAR</th>
                                     <th colspan="2" style="text-align: center;vertical-align: middle;">APR</th>
                                     <th colspan="2" style="text-align: center;vertical-align: middle;">MEI</th>
                                     <th colspan="2" style="text-align: center;vertical-align: middle;">JUN</th>
                                     <th colspan="2" style="text-align: center;vertical-align: middle;">JUL</th>
                                     <th colspan="2" style="text-align: center;vertical-align: middle;">AGU</th>
                                     <th colspan="2" style="text-align: center;vertical-align: middle;">SEP</th>
                                     <th colspan="2" style="text-align: center;vertical-align: middle;">OKT</th>
                                     <th colspan="2" style="text-align: center;vertical-align: middle;">NOV</th>
                                     <th colspan="2" style="text-align: center;vertical-align: middle;">DES</th>
                    </tr>
                    <tr>
                       <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                     <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                     <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                     <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                     <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                     <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                     <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                     <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                     <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                     <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                     <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                     <th style="text-align: center;vertical-align: middle;">BID </th>
                                     <th style="text-align: center;vertical-align: middle;">LUAS</th>
                    </tr>
                    <tr>
                    <th colspan"24"><b>I. IP PROYEK - LUAR IJIN</b></th>
                    </tr>
                    ' . $target_luar_ijin . '
                    <tr>
                    <th colspan"24"><b>II. IP PROYEK - DALAM IJIN</b></th>
                    </tr>
                     ' . $target_dalam_ijin . '
                    <tr>
                    <th colspan"24"><b>III. IP PROYEK - LOKASI</b></th>
                    </tr>
                     ' . $target_lokasi . '
                </table>
                ';


        $file = "2. Laporan Rekap Pembelian Tanah.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }

    private function get_rekap_pembelian($proyek_id, $status)
    {
        $data_rekap = $this->export->export_rekap_tanah($proyek_id, $status);
        $data = array();
        foreach ($data_rekap as $r) {

            $datatarget = $this->export->export_target_menu($r->proyek_id, date('Y'), $status);
            $target_luas = 0;
            $target_bidang = 0;

            $awalbulan = date('Y-01-01');
            $tengahbulan = date('Y-06-30');
            $akhirbulan = date('Y-12-31');


            $datarealisasisebelum = $this->export->get_realisasi_menu($r->proyek_id, $awalbulan, $tengahbulan, $status);
            $datarealisasisesudah = $this->export->get_realisasi_menu($r->proyek_id, $tengahbulan, $akhirbulan, $status);

            if (empty($datatarget)) {
            } else {
                $proyek = $r->proyek_id;
                $status_proyek = $r->status_proyek;
                $target_luas = $this->db->select('SUM(target_luas) as luas')
                    ->from('master_proyek_target')
                    ->where('master_proyek_target.proyek_id', $proyek)
                    ->where('master_proyek_target.status_proyek', $status_proyek)
                    ->get()->row()->luas;
                $target_bidang = $this->db->select('SUM(target_bidang) as bidang')
                    ->from('master_proyek_target')
                    ->where('master_proyek_target.proyek_id', $proyek)
                    ->where('master_proyek_target.status_proyek', $status_proyek)
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
    //EXPORT MENU NO.2 END

    //EXPORT MENU NO.3 START
    public function landbank_perum()
    {
        $proyek = $this->input->get('proyek');
        $status = $this->input->get('status');

        $last_year = date('Y', strtotime('-1 year'));
        $this_year = date('Y');

        $reader = IOFactory::createReader('Xlsx');
        $excel = $reader->load('./assets/excel/excel_landbank_perum.xlsx');

        $data_ly = $this->laporan->get_data_landbank_perum($last_year, $proyek, $status, 'belum')->result();
        $data_ty = $this->laporan->get_data_landbank_perum($this_year, $proyek, $status, 'belum')->result();
        $teknik_ly = $this->laporan->get_data_landbank_perum($last_year, $proyek, $status, 'selesai')->result();
        $teknik_ty = $this->laporan->get_data_landbank_perum($this_year, $proyek, $status, 'selesai')->result();

        $no = 1;

        $current = 8;
        $excel->getActiveSheet()->setCellValue('A7', 'Tahun ' . $last_year);
        $excel->getActiveSheet()->getStyle('A7:AN7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('b0ac2c');
        $excel->getActiveSheet()->getStyle('A7:AN7')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

        foreach ($data_ly as $ly) {
            $getsertif1 = $this->db->get_where('master_sertifikat_tanah', ['id' => $ly->status_surat_tanah1])->row();
            $getsertif2 = $this->db->get_where('master_sertifikat_tanah', ['id' => $ly->status_surat_tanah2])->row();

            if ($getsertif1) {
                $sertif1 = $getsertif1->nama_sertif;
            } else {
                $sertif1 = '-';
            }

            if ($getsertif2) {
                $sertif2 = $getsertif2->nama_sertif;
            } else {
                $sertif2 = '-';
            }

            $satuan_pengalihan_hak = $ly->total_harga_pengalihan /  $ly->luas_surat;

            $total_lain = $ly->biaya_lain_pematangan + $ly->biaya_lain_rugi + $ly->biaya_lain_pbb + $ly->biaya_lain;

            $total_all = $total_lain + $ly->total_harga_pengalihan + $ly->harga_jual_makelar;

            $harga_per_meter = $total_all / $ly->luas_ukur;

            if (
                $ly->status_pengalihan == 'belum order'
            ) {
                $bo = tgl_indo($ly->created_at);
                $o = '-';
                $ter = '-';
            } else if ($ly->status_pengalihan == 'order') {
                $bo = '-';
                $o = tgl_indo($ly->tgl_status_pengalihan);
                $ter = '-';
            } else if ($ly->status_pengalihan == 'terbit') {
                $bo = '-';
                $o = '-';
                $ter = tgl_indo($ly->tgl_status_pengalihan);
            }

            $excel->getActiveSheet()->insertNewRowBefore($current + 1, 1);
            $excel->getActiveSheet()
                ->setCellValue('A' . $current, "$no")
                ->setCellValue('B' . $current, "$ly->nama_penjual")
                ->setCellValue('C' . $current, "$ly->nama_proyek ($ly->nama_status)")
                ->setCellValue('D' . $current, tgl_indo($ly->tgl_pembelian))
                ->setCellValue('E' . $current, "$ly->nomor_gambar")

                ->setCellValue('F' . $current, "$ly->nama_surat_tanah1")
                ->setCellValue('G' . $current, "$sertif1")
                ->setCellValue('H' . $current, "$ly->keterangan1")

                ->setCellValue('I' . $current, "$ly->nama_surat_tanah2")
                ->setCellValue('J' . $current, "$sertif2")
                ->setCellValue('K' . $current, "$ly->keterangan2")

                ->setCellValue('L' . $current, "$ly->luas_surat")
                ->setCellValue('M' . $current, "$ly->luas_ukur")

                ->setCellValue('N' . $current, "$ly->nomor_pbb")
                ->setCellValue('O' . $current, "$ly->atas_nama_pbb")
                ->setCellValue('P' . $current, "$ly->luas_bangunan_pbb")
                ->setCellValue('Q' . $current, number_format($ly->njop_bangunan))
                ->setCellValue('R' . $current, "$ly->luas_bumi_pbb")
                ->setCellValue('S' . $current, number_format($ly->njop_bumi_pbb))

                ->setCellValue('T' . $current, number_format($satuan_pengalihan_hak))
                ->setCellValue('U' . $current, number_format($ly->total_harga_pengalihan))

                ->setCellValue('V' . $current, "$ly->nama_makelar")
                ->setCellValue('W' . $current, number_format($ly->harga_jual_makelar))

                ->setCellValue('X' . $current, "$bo")
                ->setCellValue('Y' . $current, "$o")
                ->setCellValue('Z' . $current, "$ter")
                ->setCellValue('AA' . $current, "$ly->nama_pengalihan")
                ->setCellValue('AB' . $current, tgl_indo($ly->tgl_akta_pengalihan))
                ->setCellValue('AC' . $current, "$ly->no_akta_pengalihan")
                ->setCellValue('AD' . $current, "$ly->atas_nama_pengalihan")

                ->setCellValue('AE' . $current, number_format($ly->biaya_lain_pematangan))
                ->setCellValue('AF' . $current, number_format($ly->biaya_lain_rugi))
                ->setCellValue('AG' . $current, number_format($ly->biaya_lain_pbb))
                ->setCellValue('AH' . $current, number_format($ly->biaya_lain))
                ->setCellValue('AI' . $current, number_format($total_lain))

                ->setCellValue('AJ' . $current, number_format($total_all))
                ->setCellValue('AK' . $current, number_format($harga_per_meter))
                ->setCellValue('AL' . $current, tgl_indo($ly->serah_terima_finance))
                ->setCellValue('AM' . $current, "$ly->status_teknik")
                ->setCellValue('AN' . $current, "$ly->ket");
            $current++;
            $no++;
            $excel->getActiveSheet()->getStyle('A' . $current . ':AN' . $current . '')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }

        $count_datalast = count($data_ly);
        if ($count_datalast > 1) {
            $current2 = $current + $count_datalast;
        } else {
            $current2 = $current;
        }
        $curr = $current2 + 1;
        $excel->getActiveSheet()->setCellValue('A' . $current2, 'Tahun ' . $this_year);
        $excel->getActiveSheet()->getStyle('A' . $current2 . ':AN' . $current2 . '')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('b0ac2c');
        $excel->getActiveSheet()->getStyle('A' . $current2 . ':AN' . $current2 . '')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $no2 = 1;
        foreach ($data_ty as $ly) {
            $getsertif1 = $this->db->get_where('master_sertifikat_tanah', ['id' => $ly->status_surat_tanah1])->row();
            $getsertif2 = $this->db->get_where('master_sertifikat_tanah', ['id' => $ly->status_surat_tanah2])->row();

            if ($getsertif1) {
                $sertif1 = $getsertif1->nama_sertif;
            } else {
                $sertif1 = '-';
            }

            if ($getsertif2) {
                $sertif2 = $getsertif2->nama_sertif;
            } else {
                $sertif2 = '-';
            }

            $satuan_pengalihan_hak = $ly->total_harga_pengalihan /  $ly->luas_surat;

            $total_lain = $ly->biaya_lain_pematangan + $ly->biaya_lain_rugi + $ly->biaya_lain_pbb + $ly->biaya_lain;

            $total_all = $total_lain + $ly->total_harga_pengalihan + $ly->harga_jual_makelar;

            $harga_per_meter = $total_all / $ly->luas_ukur;

            if (
                $ly->status_pengalihan == 'belum order'
            ) {
                $bo = tgl_indo($ly->created_at);
                $o = '-';
                $ter = '-';
            } else if ($ly->status_pengalihan == 'order') {
                $bo = '-';
                $o = tgl_indo($ly->tgl_status_pengalihan);
                $ter = '-';
            } else if ($ly->status_pengalihan == 'terbit') {
                $bo = '-';
                $o = '-';
                $ter = tgl_indo($ly->tgl_status_pengalihan);
            }

            $excel->getActiveSheet()->insertNewRowBefore($curr + 1, 1);
            $excel->getActiveSheet()
                ->setCellValue(
                    'A' . $curr,
                    "$no2"
                )
                ->setCellValue(
                    'B' . $curr,
                    "$ly->nama_penjual"
                )
                ->setCellValue(
                    'C' . $curr,
                    "$ly->nama_proyek ($ly->nama_status)"
                )
                ->setCellValue(
                    'D' . $curr,
                    tgl_indo($ly->tgl_pembelian)
                )
                ->setCellValue(
                    'E' . $curr,
                    "$ly->nomor_gambar"
                )

                ->setCellValue(
                    'F' . $curr,
                    "$ly->nama_surat_tanah1"
                )
                ->setCellValue(
                    'G' . $curr,
                    "$sertif1"
                )
                ->setCellValue(
                    'H' . $curr,
                    "$ly->keterangan1"
                )

                ->setCellValue(
                    'I' . $curr,
                    "$ly->nama_surat_tanah2"
                )
                ->setCellValue(
                    'J' . $curr,
                    "$sertif2"
                )
                ->setCellValue(
                    'K' . $curr,
                    "$ly->keterangan2"
                )

                ->setCellValue(
                    'L' . $curr,
                    "$ly->luas_surat"
                )
                ->setCellValue(
                    'M' . $curr,
                    "$ly->luas_ukur"
                )

                ->setCellValue(
                    'N' . $curr,
                    "$ly->nomor_pbb"
                )
                ->setCellValue(
                    'O' . $curr,
                    "$ly->atas_nama_pbb"
                )
                ->setCellValue(
                    'P' . $curr,
                    "$ly->luas_bangunan_pbb"
                )
                ->setCellValue(
                    'Q' . $curr,
                    number_format($ly->njop_bangunan)
                )
                ->setCellValue(
                    'R' . $curr,
                    "$ly->luas_bumi_pbb"
                )
                ->setCellValue(
                    'S' . $curr,
                    number_format($ly->njop_bumi_pbb)
                )

                ->setCellValue(
                    'T' . $curr,
                    number_format($satuan_pengalihan_hak)
                )
                ->setCellValue(
                    'U' . $curr,
                    number_format($ly->total_harga_pengalihan)
                )

                ->setCellValue(
                    'V' . $curr,
                    "$ly->nama_makelar"
                )
                ->setCellValue(
                    'W' . $curr,
                    number_format($ly->harga_jual_makelar)
                )

                ->setCellValue(
                    'X' . $curr,
                    "$bo"
                )
                ->setCellValue(
                    'Y' . $curr,
                    "$o"
                )
                ->setCellValue(
                    'Z' . $curr,
                    "$ter"
                )
                ->setCellValue(
                    'AA' . $curr,
                    "$ly->nama_pengalihan"
                )
                ->setCellValue(
                    'AB' . $curr,
                    tgl_indo($ly->tgl_akta_pengalihan)
                )
                ->setCellValue(
                    'AC' . $curr,
                    "$ly->no_akta_pengalihan"
                )
                ->setCellValue(
                    'AD' . $curr,
                    "$ly->atas_nama_pengalihan"
                )

                ->setCellValue(
                    'AE' . $curr,
                    number_format($ly->biaya_lain_pematangan)
                )
                ->setCellValue(
                    'AF' . $curr,
                    number_format($ly->biaya_lain_rugi)
                )
                ->setCellValue(
                    'AG' . $curr,
                    number_format($ly->biaya_lain_pbb)
                )
                ->setCellValue(
                    'AH' . $curr,
                    number_format($ly->biaya_lain)
                )
                ->setCellValue(
                    'AI' . $curr,
                    number_format($total_lain)
                )

                ->setCellValue(
                    'AJ' . $curr,
                    number_format($total_all)
                )
                ->setCellValue(
                    'AK' . $curr,
                    number_format($harga_per_meter)
                )
                ->setCellValue(
                    'AL' . $curr,
                    tgl_indo($ly->serah_terima_finance)
                )
                ->setCellValue(
                    'AM' . $curr,
                    "$ly->status_teknik"
                )
                ->setCellValue(
                    'AN' . $curr,
                    "$ly->ket"
                );
            $curr++;
            $no2++;
            $excel->getActiveSheet()->getStyle('A' . $curr . ':AN' . $curr . '')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }

        $count_datathis = count($data_ty);
        $curr_t1 = $current2 + $count_datathis + 6;
        $curr_in1 = $curr_t1 + 1;

        $excel->getActiveSheet()->setCellValue('A' . $curr_t1, 'Tahun ' . $last_year);
        $excel->getActiveSheet()->getStyle('A' . $curr_t1 . ':AN' . $curr_t1 . '')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('b0ac2c');
        $excel->getActiveSheet()->getStyle('A' . $curr_t1 . ':AN' . $curr_t1 . '')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $no3 = 1;
        foreach ($teknik_ly as $ly) {
            $getsertif1 = $this->db->get_where('master_sertifikat_tanah', ['id' => $ly->status_surat_tanah1])->row();
            $getsertif2 = $this->db->get_where('master_sertifikat_tanah', ['id' => $ly->status_surat_tanah2])->row();

            if ($getsertif1) {
                $sertif1 = $getsertif1->nama_sertif;
            } else {
                $sertif1 = '-';
            }

            if ($getsertif2) {
                $sertif2 = $getsertif2->nama_sertif;
            } else {
                $sertif2 = '-';
            }

            $satuan_pengalihan_hak = $ly->total_harga_pengalihan /  $ly->luas_surat;

            $total_lain = $ly->biaya_lain_pematangan + $ly->biaya_lain_rugi + $ly->biaya_lain_pbb + $ly->biaya_lain;

            $total_all = $total_lain + $ly->total_harga_pengalihan + $ly->harga_jual_makelar;

            $harga_per_meter = $total_all / $ly->luas_ukur;

            if (
                $ly->status_pengalihan == 'belum order'
            ) {
                $bo = tgl_indo($ly->created_at);
                $o = '-';
                $ter = '-';
            } else if ($ly->status_pengalihan == 'order') {
                $bo = '-';
                $o = tgl_indo($ly->tgl_status_pengalihan);
                $ter = '-';
            } else if ($ly->status_pengalihan == 'terbit') {
                $bo = '-';
                $o = '-';
                $ter = tgl_indo($ly->tgl_status_pengalihan);
            }

            $excel->getActiveSheet()->insertNewRowBefore($curr_in1 + 1, 1);
            $excel->getActiveSheet()
                ->setCellValue('A' . $curr_in1, "$no3")
                ->setCellValue('B' . $curr_in1, "$ly->nama_penjual")
                ->setCellValue('C' . $curr_in1, "$ly->nama_proyek ($ly->nama_status)")
                ->setCellValue('D' . $curr_in1, tgl_indo($ly->tgl_pembelian))
                ->setCellValue('E' . $curr_in1, "$ly->nomor_gambar")

                ->setCellValue('F' . $curr_in1, "$ly->nama_surat_tanah1")
                ->setCellValue('G' . $curr_in1, "$sertif1")
                ->setCellValue('H' . $curr_in1, "$ly->keterangan1")

                ->setCellValue('I' . $curr_in1, "$ly->nama_surat_tanah2")
                ->setCellValue('J' . $curr_in1, "$sertif2")
                ->setCellValue('K' . $curr_in1, "$ly->keterangan2")

                ->setCellValue('L' . $curr_in1, "$ly->luas_surat")
                ->setCellValue('M' . $curr_in1, "$ly->luas_ukur")

                ->setCellValue('N' . $curr_in1, "$ly->nomor_pbb")
                ->setCellValue('O' . $curr_in1, "$ly->atas_nama_pbb")
                ->setCellValue('P' . $curr_in1, "$ly->luas_bangunan_pbb")
                ->setCellValue('Q' . $curr_in1, number_format($ly->njop_bangunan))
                ->setCellValue('R' . $curr_in1, "$ly->luas_bumi_pbb")
                ->setCellValue('S' . $curr_in1, number_format($ly->njop_bumi_pbb))

                ->setCellValue('T' . $curr_in1, number_format($satuan_pengalihan_hak))
                ->setCellValue('U' . $curr_in1, number_format($ly->total_harga_pengalihan))

                ->setCellValue('V' . $curr_in1, "$ly->nama_makelar")
                ->setCellValue('W' . $curr_in1, number_format($ly->harga_jual_makelar))

                ->setCellValue('X' . $curr_in1, "$bo")
                ->setCellValue('Y' . $curr_in1, "$o")
                ->setCellValue('Z' . $curr_in1, "$ter")
                ->setCellValue('AA' . $curr_in1, "$ly->nama_pengalihan")
                ->setCellValue('AB' . $curr_in1, tgl_indo($ly->tgl_akta_pengalihan))
                ->setCellValue('AC' . $curr_in1, "$ly->no_akta_pengalihan")
                ->setCellValue('AD' . $curr_in1, "$ly->atas_nama_pengalihan")

                ->setCellValue('AE' . $curr_in1, number_format($ly->biaya_lain_pematangan))
                ->setCellValue('AF' . $curr_in1, number_format($ly->biaya_lain_rugi))
                ->setCellValue('AG' . $curr_in1, number_format($ly->biaya_lain_pbb))
                ->setCellValue('AH' . $curr_in1, number_format($ly->biaya_lain))
                ->setCellValue('AI' . $curr_in1, number_format($total_lain))

                ->setCellValue('AJ' . $curr_in1, number_format($total_all))
                ->setCellValue('AK' . $curr_in1, number_format($harga_per_meter))
                ->setCellValue('AL' . $curr_in1, tgl_indo($ly->serah_terima_finance))
                ->setCellValue('AM' . $curr_in1, "$ly->status_teknik")
                ->setCellValue('AN' . $curr_in1, "$ly->ket");
            $curr_in1++;
            $no3++;
            $excel->getActiveSheet()->getStyle('A' . $curr_in1 . ':AN' . $curr_in1 . '')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }



        $count_tekniklast = count($teknik_ly);
        if ($count_tekniklast > 1) {
            $curr_t2 = $curr_in1 + $count_tekniklast;
        } else {
            $curr_t2 = $curr_in1;
        }
        $curr_in2 = $curr_t2 + 1;
        $excel->getActiveSheet()->setCellValue('A' . $curr_t2, 'Tahun ' . $this_year);
        $excel->getActiveSheet()->getStyle('A' . $curr_t2 . ':AN' . $curr_t2 . '')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('b0ac2c');
        $excel->getActiveSheet()->getStyle('A' . $curr_t2 . ':AN' . $curr_t2 . '')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);


        $no4 = 1;
        foreach ($teknik_ty as $ly) {
            $getsertif1 = $this->db->get_where('master_sertifikat_tanah', ['id' => $ly->status_surat_tanah1])->row();
            $getsertif2 = $this->db->get_where('master_sertifikat_tanah', ['id' => $ly->status_surat_tanah2])->row();

            if ($getsertif1) {
                $sertif1 = $getsertif1->nama_sertif;
            } else {
                $sertif1 = '-';
            }

            if ($getsertif2) {
                $sertif2 = $getsertif2->nama_sertif;
            } else {
                $sertif2 = '-';
            }

            $satuan_pengalihan_hak = $ly->total_harga_pengalihan /  $ly->luas_surat;

            $total_lain = $ly->biaya_lain_pematangan + $ly->biaya_lain_rugi + $ly->biaya_lain_pbb + $ly->biaya_lain;

            $total_all = $total_lain + $ly->total_harga_pengalihan + $ly->harga_jual_makelar;

            $harga_per_meter = $total_all / $ly->luas_ukur;

            if (
                $ly->status_pengalihan == 'belum order'
            ) {
                $bo = tgl_indo($ly->created_at);
                $o = '-';
                $ter = '-';
            } else if ($ly->status_pengalihan == 'order') {
                $bo = '-';
                $o = tgl_indo($ly->tgl_status_pengalihan);
                $ter = '-';
            } else if ($ly->status_pengalihan == 'terbit') {
                $bo = '-';
                $o = '-';
                $ter = tgl_indo($ly->tgl_status_pengalihan);
            }

            $excel->getActiveSheet()->insertNewRowBefore($curr_in2 + 1, 1);
            $excel->getActiveSheet()
                ->setCellValue('A' . $curr_in2, "$no4")
                ->setCellValue('B' . $curr_in2, "$ly->nama_penjual")
                ->setCellValue('C' . $curr_in2, "$ly->nama_proyek ($ly->nama_status)")
                ->setCellValue('D' . $curr_in2, tgl_indo($ly->tgl_pembelian))
                ->setCellValue('E' . $curr_in2, "$ly->nomor_gambar")

                ->setCellValue('F' . $curr_in2, "$ly->nama_surat_tanah1")
                ->setCellValue('G' . $curr_in2, "$sertif1")
                ->setCellValue('H' . $curr_in2, "$ly->keterangan1")

                ->setCellValue('I' . $curr_in2, "$ly->nama_surat_tanah2")
                ->setCellValue('J' . $curr_in2, "$sertif2")
                ->setCellValue('K' . $curr_in2, "$ly->keterangan2")

                ->setCellValue('L' . $curr_in2, "$ly->luas_surat")
                ->setCellValue('M' . $curr_in2, "$ly->luas_ukur")

                ->setCellValue('N' . $curr_in2, "$ly->nomor_pbb")
                ->setCellValue('O' . $curr_in2, "$ly->atas_nama_pbb")
                ->setCellValue('P' . $curr_in2, "$ly->luas_bangunan_pbb")
                ->setCellValue('Q' . $curr_in2, number_format($ly->njop_bangunan))
                ->setCellValue('R' . $curr_in2, "$ly->luas_bumi_pbb")
                ->setCellValue('S' . $curr_in2, number_format($ly->njop_bumi_pbb))

                ->setCellValue('T' . $curr_in2, number_format($satuan_pengalihan_hak))
                ->setCellValue('U' . $curr_in2, number_format($ly->total_harga_pengalihan))

                ->setCellValue('V' . $curr_in2, "$ly->nama_makelar")
                ->setCellValue('W' . $curr_in2, number_format($ly->harga_jual_makelar))

                ->setCellValue('X' . $curr_in2, "$bo")
                ->setCellValue('Y' . $curr_in2, "$o")
                ->setCellValue('Z' . $curr_in2, "$ter")
                ->setCellValue('AA' . $curr_in2, "$ly->nama_pengalihan")
                ->setCellValue('AB' . $curr_in2, tgl_indo($ly->tgl_akta_pengalihan))
                ->setCellValue('AC' . $curr_in2, "$ly->no_akta_pengalihan")
                ->setCellValue('AD' . $curr_in2, "$ly->atas_nama_pengalihan")

                ->setCellValue('AE' . $curr_in2, number_format($ly->biaya_lain_pematangan))
                ->setCellValue('AF' . $curr_in2, number_format($ly->biaya_lain_rugi))
                ->setCellValue('AG' . $curr_in2, number_format($ly->biaya_lain_pbb))
                ->setCellValue('AH' . $curr_in2, number_format($ly->biaya_lain))
                ->setCellValue('AI' . $curr_in2, number_format($total_lain))

                ->setCellValue('AJ' . $curr_in2, number_format($total_all))
                ->setCellValue('AK' . $curr_in2, number_format($harga_per_meter))
                ->setCellValue('AL' . $curr_in2, tgl_indo($ly->serah_terima_finance))
                ->setCellValue('AM' . $curr_in2, "$ly->status_teknik")
                ->setCellValue('AN' . $curr_in2, "$ly->ket");
            $curr_in2++;
            $no4++;
            $excel->getActiveSheet()->getStyle('A' . $curr_in2 . ':AN' . $curr_in2 . '')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }

        $this->to_export($excel, 'Landbank_perum.xlsx');
    }

    public function evaluasi_landbank()
    {
        $proyek = $this->input->get('proyek');
        $last_year = date('Y', strtotime('-1 year'));
        $this_year = date('Y');
        $reader = IOFactory::createReader('Xlsx');
        $excel = $reader->load('./assets/excel/excel_rekap_landbank.xlsx');

        $status_proyek = $this->db->get('master_status_proyek')->result();
        $data_li = $this->laporan->get_rekap_landbank(1, 'group', $proyek)->result();
        $data_di = $this->laporan->get_rekap_landbank(2, 'group', $proyek)->result();
        $data_l = $this->laporan->get_rekap_landbank(3, 'group', $proyek)->result();

        $excel->getActiveSheet()->setCellValue('C3', 'Landbank s/d ' . $last_year)
            ->setCellValue('F3', 'Landbank s/d ' . $this_year);


        //data luar ijin
        $start_li = 7;
        $no_li = 1;
        $excel->getActiveSheet()->setCellValue('A6', 'IP Proyek Luar Ijin');
        $excel->getActiveSheet()->getStyle('A6:W6')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('b0ac2c');
        $excel->getActiveSheet()->getStyle('A6:W6')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        foreach ($data_li as $d) {

            $bid_last_year = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, $last_year, null)->num_rows();
            $ls_last_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 1, $last_year, null)['luas_surat'];
            $lu_last_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 1, $last_year, null)['luas_ukur'];

            $bid_this_year = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, $this_year, null)->num_rows();
            $ls_this_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 1, $this_year, null)['luas_surat'];
            $lu_this_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 1, $this_year, null)['luas_ukur'];

            $bid_total = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, null, null)->num_rows();
            $ls_total = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 1, null, null)['luas_surat'];
            $lu_total = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 1, null, null)['luas_ukur'];

            $bid_teknik = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, null, 'selesai')->num_rows();
            $ls_teknik = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 1, null, 'selesai')['luas_surat'];
            $lu_teknik = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 1, null, 'selesai')['luas_ukur'];

            $bid_sisa = $bid_total - $bid_teknik;
            $ls_sisa = $ls_total - $ls_teknik;
            $lu_sisa = $lu_total - $lu_teknik;


            $bo_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 1, null, null, 'belum order')->num_rows();
            $o_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 1, null, null, 'order')->num_rows();
            $tb_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 1, null, null, 'terbit')->num_rows();
            $total_peralihan = $bo_peralihan + $o_peralihan + $tb_peralihan;

            $s_finance = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 1, null, null, null, 'yes')->num_rows();
            $b_finance = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 1, null, null, null, 'no')->num_rows();


            $excel->getActiveSheet()->insertNewRowBefore($start_li + 1, 1);
            $excel->getActiveSheet()
                ->setCellValue('A' . $start_li, "$no_li")
                ->setCellValue('B' . $start_li, "$d->nama_proyek")

                ->setCellValue('C' . $start_li, "$bid_last_year")
                ->setCellValue('D' . $start_li, "$ls_last_year")
                ->setCellValue('E' . $start_li, "$lu_last_year")

                ->setCellValue('F' . $start_li, "$bid_this_year")
                ->setCellValue('G' . $start_li, "$ls_this_year")
                ->setCellValue('H' . $start_li, "$lu_this_year")

                ->setCellValue('I' . $start_li, "$bid_total")
                ->setCellValue('J' . $start_li, "$ls_total")
                ->setCellValue('K' . $start_li, "$lu_total")

                ->setCellValue('L' . $start_li, "$bid_teknik")
                ->setCellValue('M' . $start_li, "$ls_teknik")
                ->setCellValue('N' . $start_li, "$lu_teknik")

                ->setCellValue('O' . $start_li, "$bid_sisa")
                ->setCellValue('P' . $start_li, "$ls_sisa")
                ->setCellValue('Q' . $start_li, "$lu_sisa")

                ->setCellValue('R' . $start_li, "$bo_peralihan")
                ->setCellValue('S' . $start_li, "$o_peralihan")
                ->setCellValue('T' . $start_li, "$tb_peralihan")
                ->setCellValue('U' . $start_li, "$total_peralihan")

                ->setCellValue('V' . $start_li, "$s_finance")
                ->setCellValue('W' . $start_li, "$b_finance");
            $start_li++;
        }


        //data dalam ijin
        $count_li = count($data_li);
        $header_di = $start_li + $count_li;
        $start_di = $header_di + 1;
        $excel->getActiveSheet()->setCellValue('A' . $header_di, 'IP Proyek Dalam Ijin');
        $excel->getActiveSheet()->getStyle('A' . $header_di . ':W' . $header_di . '')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('b0ac2c');
        $excel->getActiveSheet()->getStyle('A' . $header_di . ':W' . $header_di . '')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        foreach ($data_di as $d) {

            $bid_last_year = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, $last_year, null)->num_rows();
            $ls_last_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 2, $last_year, null)['luas_surat'];
            $lu_last_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 2, $last_year, null)['luas_ukur'];

            $bid_this_year = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, $this_year, null)->num_rows();
            $ls_this_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 2, $this_year, null)['luas_surat'];
            $lu_this_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 2, $this_year, null)['luas_ukur'];

            $bid_total = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, null, null)->num_rows();
            $ls_total = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 2, null, null)['luas_surat'];
            $lu_total = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 2, null, null)['luas_ukur'];

            $bid_teknik = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, null, 'selesai')->num_rows();
            $ls_teknik = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 2, null, 'selesai')['luas_surat'];
            $lu_teknik = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 2, null, 'selesai')['luas_ukur'];

            $bid_sisa = $bid_total - $bid_teknik;
            $ls_sisa = $ls_total - $ls_teknik;
            $lu_sisa = $lu_total - $lu_teknik;


            $bo_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 2, null, null, 'belum order')->num_rows();
            $o_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 2, null, null, 'order')->num_rows();
            $tb_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 2, null, null, 'terbit')->num_rows();
            $total_peralihan = $bo_peralihan + $o_peralihan + $tb_peralihan;

            $s_finance = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 2, null, null, null, 'yes')->num_rows();
            $b_finance = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 2, null, null, null, 'no')->num_rows();


            $excel->getActiveSheet()->insertNewRowBefore($start_di + 1, 1);
            $excel->getActiveSheet()
                ->setCellValue('A' . $start_di, "$no_li")
                ->setCellValue('B' . $start_di, "$d->nama_proyek")

                ->setCellValue('C' . $start_di, "$bid_last_year")
                ->setCellValue('D' . $start_di, "$ls_last_year")
                ->setCellValue('E' . $start_di, "$lu_last_year")

                ->setCellValue('F' . $start_di, "$bid_this_year")
                ->setCellValue('G' . $start_di, "$ls_this_year")
                ->setCellValue('H' . $start_di, "$lu_this_year")

                ->setCellValue('I' . $start_di, "$bid_total")
                ->setCellValue('J' . $start_di, "$ls_total")
                ->setCellValue('K' . $start_di, "$lu_total")

                ->setCellValue('L' . $start_di, "$bid_teknik")
                ->setCellValue('M' . $start_di, "$ls_teknik")
                ->setCellValue('N' . $start_di, "$lu_teknik")

                ->setCellValue('O' . $start_di, "$bid_sisa")
                ->setCellValue('P' . $start_di, "$ls_sisa")
                ->setCellValue('Q' . $start_di, "$lu_sisa")

                ->setCellValue('R' . $start_di, "$bo_peralihan")
                ->setCellValue('S' . $start_di, "$o_peralihan")
                ->setCellValue('T' . $start_di, "$tb_peralihan")
                ->setCellValue('U' . $start_di, "$total_peralihan")

                ->setCellValue('V' . $start_di, "$s_finance")
                ->setCellValue('W' . $start_di, "$b_finance");
            $start_di++;
        }


        //data lokasi
        $count_di = count($data_di);
        $header_l = $start_di + $count_di;
        $start_l = $header_l + 1;
        $excel->getActiveSheet()->setCellValue('A' . $header_l, 'IP Proyek Lokasi');
        $excel->getActiveSheet()->getStyle('A' . $header_l . ':W' . $header_l . '')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('b0ac2c');
        $excel->getActiveSheet()->getStyle('A' . $header_l . ':W' . $header_l . '')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        foreach ($data_l as $d) {

            $bid_last_year = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, $last_year, null)->num_rows();
            $ls_last_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 3, $last_year, null)['luas_surat'];
            $lu_last_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 3, $last_year, null)['luas_ukur'];

            $bid_this_year = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, $this_year, null)->num_rows();
            $ls_this_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 3, $this_year, null)['luas_surat'];
            $lu_this_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 3, $this_year, null)['luas_ukur'];

            $bid_total = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, null, null)->num_rows();
            $ls_total = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 3, null, null)['luas_surat'];
            $lu_total = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 3, null, null)['luas_ukur'];

            $bid_teknik = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, null, 'selesai')->num_rows();
            $ls_teknik = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 3, null, 'selesai')['luas_surat'];
            $lu_teknik = $this->laporan->get_detail_rekap_landbank($d->proyek_id, 3, null, 'selesai')['luas_ukur'];

            $bid_sisa = $bid_total - $bid_teknik;
            $ls_sisa = $ls_total - $ls_teknik;
            $lu_sisa = $lu_total - $lu_teknik;


            $bo_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 3, null, null, 'belum order')->num_rows();
            $o_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 3, null, null, 'order')->num_rows();
            $tb_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 3, null, null, 'terbit')->num_rows();
            $total_peralihan = $bo_peralihan + $o_peralihan + $tb_peralihan;

            $s_finance = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 3, null, null, null, 'yes')->num_rows();
            $b_finance = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, 3, null, null, null, 'no')->num_rows();


            $excel->getActiveSheet()->insertNewRowBefore($start_l + 1, 1);
            $excel->getActiveSheet()
                ->setCellValue('A' . $start_l, "$no_li")
                ->setCellValue('B' . $start_l, "$d->nama_proyek")

                ->setCellValue('C' . $start_l, "$bid_last_year")
                ->setCellValue('D' . $start_l, "$ls_last_year")
                ->setCellValue('E' . $start_l, "$lu_last_year")

                ->setCellValue('F' . $start_l, "$bid_this_year")
                ->setCellValue('G' . $start_l, "$ls_this_year")
                ->setCellValue('H' . $start_l, "$lu_this_year")

                ->setCellValue('I' . $start_l, "$bid_total")
                ->setCellValue('J' . $start_l, "$ls_total")
                ->setCellValue('K' . $start_l, "$lu_total")

                ->setCellValue('L' . $start_l, "$bid_teknik")
                ->setCellValue('M' . $start_l, "$ls_teknik")
                ->setCellValue('N' . $start_l, "$lu_teknik")

                ->setCellValue('O' . $start_l, "$bid_sisa")
                ->setCellValue('P' . $start_l, "$ls_sisa")
                ->setCellValue('Q' . $start_l, "$lu_sisa")

                ->setCellValue('R' . $start_l, "$bo_peralihan")
                ->setCellValue('S' . $start_l, "$o_peralihan")
                ->setCellValue('T' . $start_l, "$tb_peralihan")
                ->setCellValue('U' . $start_l, "$total_peralihan")

                ->setCellValue('V' . $start_l, "$s_finance")
                ->setCellValue('W' . $start_l, "$b_finance");
            $start_l++;
        }


        //set all with border
        $count_l = count($data_l);
        $start_last = $start_l + $count_l;
        $excel->getActiveSheet()->getStyle('A6:W' . $start_last . '')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $this->to_export($excel, 'Evaluasi Rekap Landbank.xlsx');
    }

    //EXPORT MENU NO.3 END

    //EXPORT NO 4

    //EXPORT NO 4
    public function belum_shgb_perum()
    {
        $proyek = $this->input->get('proyek');
        $peralihan = $this->input->get('status');

        $last_year = date('Y', strtotime('-1 year'));
        $this_year = date('Y');

        $d_home_ly = $this->laporan->get_tanah_belum_shgb($last_year, $proyek, $peralihan, 'belum')->result();
        $d_home_ty = $this->laporan->get_tanah_belum_shgb($this_year, $proyek, $peralihan, 'belum')->result();
        $d_proses_ly = $this->laporan->get_tanah_belum_shgb($last_year, $proyek, $peralihan, 'proses')->result();
        $d_proses_ty = $this->laporan->get_tanah_belum_shgb($this_year, $proyek, $peralihan, 'proses')->result();

        $data_home_last_year = '';
        $data_home_this_year = '';
        $data_proses_last_year = '';
        $data_proses_this_year = '';
        $no = 1;

        foreach ($d_home_ly as $d) {
            $getsertif1 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah1])->row();
            $getsertif2 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah2])->row();

            if ($getsertif1) {
                $sertif1 = $getsertif1->nama_sertif;
            } else {
                $sertif1 = '-';
            }

            if ($getsertif2) {
                $sertif2 = $getsertif2->nama_sertif;
            } else {
                $sertif2 = '-';
            }

            $satuan_pengalihan_hak = $d->total_harga_pengalihan /  $d->luas_surat;
            $total_lain = $d->biaya_lain_pematangan + $d->biaya_lain_rugi + $d->biaya_lain_pbb + $d->biaya_lain;
            $total_all = $total_lain + $d->total_harga_pengalihan + $d->harga_jual_makelar;
            $harga_per_meter = $total_all / $d->luas_ukur;


            $c = date_create($d->created_at);
            $tgl_bo = '-';
            $tgl_ord = '-';
            $tgl_tbt = '-';
            if ($d->status_pengalihan == 'belum order') {
                $tgl_bo = date_format($c, 'd M Y');
            } else if ($d->status_pengalihan == 'order') {
                $tgl_ord = tgl_indo($d->tgl_status_pengalihan);
            } else if ($d->status_pengalihan == 'terbit') {
                $tgl_tbt = tgl_indo($d->tgl_status_pengalihan);
            }

            $data_home_last_year .= '
                <tr>
                    <td>' . $no++ . '</td>
                    <td>' . $d->nama_penjual . '</td>
                    <td>' . $d->nama_proyek . ' (' . $d->nama_status . ')' . '</td>
                    <td>' . tgl_indo($d->tgl_pembelian) . '</td>
                    <td>' . $d->nomor_gambar . '</td>

                    <td>' . $d->nama_surat_tanah1 . '</td>
                    <td>' . $sertif1 . '</td>
                    <td>' . $d->keterangan1 . '</td>

                    <td>' . $d->nama_surat_tanah2 . '</td>
                    <td>' . $sertif2 . '</td>
                    <td>' . $d->keterangan2 . '</td>

                    <td>' . $d->luas_surat . '</td>
                    <td>' . $d->luas_ukur . '</td>

                    <td>' . $d->nomor_pbb . '</td>
                    <td>' . $d->atas_nama_pbb . '</td>
                    <td>' . $d->luas_bangunan_pbb . '</td>
                    <td>Rp. ' . number_format($d->njop_bangunan) . '</td>
                    <td>' . $d->luas_bumi_pbb . '</td>
                    <td>Rp. ' . number_format($d->njop_bumi_pbb) . '</td>

                    <td>Rp. ' . number_format($satuan_pengalihan_hak) . '</td>
                    <td>Rp. ' . number_format($d->total_harga_pengalihan) . '</td>

                    <td>' . $d->nama_makelar . '</td>
                    <td>Rp. ' . number_format($d->harga_jual_makelar) . '</td>

                    <td>' . $tgl_bo . '</td>
                    <td>' . $tgl_ord . '</td>
                    <td>' . $tgl_tbt . '</td>
                    <td>' . $d->nama_pengalihan . '</td>
                    <td>' . tgl_indo($d->tgl_akta_pengalihan) . '</td>
                    <td>' . $d->no_akta_pengalihan . '</td>
                    <td>' . $d->atas_nama_pengalihan . '</td>
                    
                    <td>Rp. ' . number_format($d->biaya_lain_pematangan) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain_rugi) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain_pbb) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain) . '</td>
                    <td>Rp. ' . number_format($total_lain) . '</td>

                    <td>Rp. ' . number_format($total_all) . '</td>
                    <td>Rp. ' . number_format($harga_per_meter) . '</td>
                    <td>' . tgl_indo($d->serah_terima_finance) . '</td>
                    <td>' . $d->status_teknik . '</td>
                    <td>' . $d->ket . '</td>

                </tr>
            ';
        }


        foreach ($d_home_ty as $d) {
            $getsertif1 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah1])->row();
            $getsertif2 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah2])->row();

            if ($getsertif1) {
                $sertif1 = $getsertif1->nama_sertif;
            } else {
                $sertif1 = '-';
            }

            if ($getsertif2) {
                $sertif2 = $getsertif2->nama_sertif;
            } else {
                $sertif2 = '-';
            }

            $satuan_pengalihan_hak = $d->total_harga_pengalihan /  $d->luas_surat;
            $total_lain = $d->biaya_lain_pematangan + $d->biaya_lain_rugi + $d->biaya_lain_pbb + $d->biaya_lain;
            $total_all = $total_lain + $d->total_harga_pengalihan + $d->harga_jual_makelar;
            $harga_per_meter = $total_all / $d->luas_ukur;


            $c = date_create($d->created_at);
            $tgl_bo = '-';
            $tgl_ord = '-';
            $tgl_tbt = '-';
            if ($d->status_pengalihan == 'belum order') {
                $tgl_bo = date_format($c, 'd M Y');
            } else if ($d->status_pengalihan == 'order') {
                $tgl_ord = tgl_indo($d->tgl_status_pengalihan);
            } else if ($d->status_pengalihan == 'terbit') {
                $tgl_tbt = tgl_indo($d->tgl_status_pengalihan);
            }

            $data_home_this_year .= '
                <tr>
                    <td>' . $no++ . '</td>
                    <td>' . $d->nama_penjual . '</td>
                    <td>' . $d->nama_proyek . ' (' . $d->nama_status . ')' . '</td>
                    <td>' . tgl_indo($d->tgl_pembelian) . '</td>
                    <td>' . $d->nomor_gambar . '</td>

                    <td>' . $d->nama_surat_tanah1 . '</td>
                    <td>' . $sertif1 . '</td>
                    <td>' . $d->keterangan1 . '</td>

                    <td>' . $d->nama_surat_tanah2 . '</td>
                    <td>' . $sertif2 . '</td>
                    <td>' . $d->keterangan2 . '</td>

                    <td>' . $d->luas_surat . '</td>
                    <td>' . $d->luas_ukur . '</td>

                    <td>' . $d->nomor_pbb . '</td>
                    <td>' . $d->atas_nama_pbb . '</td>
                    <td>' . $d->luas_bangunan_pbb . '</td>
                    <td>Rp. ' . number_format($d->njop_bangunan) . '</td>
                    <td>' . $d->luas_bumi_pbb . '</td>
                    <td>Rp. ' . number_format($d->njop_bumi_pbb) . '</td>

                    <td>Rp. ' . number_format($satuan_pengalihan_hak) . '</td>
                    <td>Rp. ' . number_format($d->total_harga_pengalihan) . '</td>

                    <td>' . $d->nama_makelar . '</td>
                    <td>Rp. ' . number_format($d->harga_jual_makelar) . '</td>

                    <td>' . $tgl_bo . '</td>
                    <td>' . $tgl_ord . '</td>
                    <td>' . $tgl_tbt . '</td>
                    <td>' . $d->nama_pengalihan . '</td>
                    <td>' . tgl_indo($d->tgl_akta_pengalihan) . '</td>
                    <td>' . $d->no_akta_pengalihan . '</td>
                    <td>' . $d->atas_nama_pengalihan . '</td>
                    
                    <td>Rp. ' . number_format($d->biaya_lain_pematangan) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain_rugi) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain_pbb) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain) . '</td>
                    <td>Rp. ' . number_format($total_lain) . '</td>

                    <td>Rp. ' . number_format($total_all) . '</td>
                    <td>Rp. ' . number_format($harga_per_meter) . '</td>
                    <td>' . tgl_indo($d->serah_terima_finance) . '</td>
                    <td>' . $d->status_teknik . '</td>
                    <td>' . $d->ket . '</td>

                </tr>
            ';
        }

        foreach ($d_proses_ly as $d) {
            $getsertif1 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah1])->row();
            $getsertif2 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah2])->row();

            if ($getsertif1) {
                $sertif1 = $getsertif1->nama_sertif;
            } else {
                $sertif1 = '-';
            }

            if ($getsertif2) {
                $sertif2 = $getsertif2->nama_sertif;
            } else {
                $sertif2 = '-';
            }

            $satuan_pengalihan_hak = $d->total_harga_pengalihan /  $d->luas_surat;
            $total_lain = $d->biaya_lain_pematangan + $d->biaya_lain_rugi + $d->biaya_lain_pbb + $d->biaya_lain;
            $total_all = $total_lain + $d->total_harga_pengalihan + $d->harga_jual_makelar;
            $harga_per_meter = $total_all / $d->luas_ukur;


            $c = date_create($d->created_at);
            $tgl_bo = '-';
            $tgl_ord = '-';
            $tgl_tbt = '-';
            if ($d->status_pengalihan == 'belum order') {
                $tgl_bo = date_format($c, 'd M Y');
            } else if ($d->status_pengalihan == 'order') {
                $tgl_ord = tgl_indo($d->tgl_status_pengalihan);
            } else if ($d->status_pengalihan == 'terbit') {
                $tgl_tbt = tgl_indo($d->tgl_status_pengalihan);
            }

            $data_proses_last_year .= '
                <tr>
                    <td>' . $no++ . '</td>
                    <td>' . $d->nama_penjual . '</td>
                    <td>' . $d->nama_proyek . ' (' . $d->nama_status . ')' . '</td>
                    <td>' . tgl_indo($d->tgl_pembelian) . '</td>
                    <td>' . $d->nomor_gambar . '</td>

                    <td>' . $d->nama_surat_tanah1 . '</td>
                    <td>' . $sertif1 . '</td>
                    <td>' . $d->keterangan1 . '</td>

                    <td>' . $d->nama_surat_tanah2 . '</td>
                    <td>' . $sertif2 . '</td>
                    <td>' . $d->keterangan2 . '</td>

                    <td>' . $d->luas_surat . '</td>
                    <td>' . $d->luas_ukur . '</td>

                    <td>' . $d->nomor_pbb . '</td>
                    <td>' . $d->atas_nama_pbb . '</td>
                    <td>' . $d->luas_bangunan_pbb . '</td>
                    <td>Rp. ' . number_format($d->njop_bangunan) . '</td>
                    <td>' . $d->luas_bumi_pbb . '</td>
                    <td>Rp. ' . number_format($d->njop_bumi_pbb) . '</td>

                    <td>Rp. ' . number_format($satuan_pengalihan_hak) . '</td>
                    <td>Rp. ' . number_format($d->total_harga_pengalihan) . '</td>

                    <td>' . $d->nama_makelar . '</td>
                    <td>Rp. ' . number_format($d->harga_jual_makelar) . '</td>

                    <td>' . $tgl_bo . '</td>
                    <td>' . $tgl_ord . '</td>
                    <td>' . $tgl_tbt . '</td>
                    <td>' . $d->nama_pengalihan . '</td>
                    <td>' . tgl_indo($d->tgl_akta_pengalihan) . '</td>
                    <td>' . $d->no_akta_pengalihan . '</td>
                    <td>' . $d->atas_nama_pengalihan . '</td>
                    
                    <td>Rp. ' . number_format($d->biaya_lain_pematangan) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain_rugi) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain_pbb) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain) . '</td>
                    <td>Rp. ' . number_format($total_lain) . '</td>

                    <td>Rp. ' . number_format($total_all) . '</td>
                    <td>Rp. ' . number_format($harga_per_meter) . '</td>
                    <td>' . tgl_indo($d->serah_terima_finance) . '</td>
                    <td>' . $d->status_teknik . '</td>
                    <td>' . $d->ket . '</td>

                </tr>
            ';
        }

        foreach ($d_proses_ty as $d) {
            $getsertif1 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah1])->row();
            $getsertif2 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah2])->row();

            if ($getsertif1) {
                $sertif1 = $getsertif1->nama_sertif;
            } else {
                $sertif1 = '-';
            }

            if ($getsertif2) {
                $sertif2 = $getsertif2->nama_sertif;
            } else {
                $sertif2 = '-';
            }

            $satuan_pengalihan_hak = $d->total_harga_pengalihan /  $d->luas_surat;
            $total_lain = $d->biaya_lain_pematangan + $d->biaya_lain_rugi + $d->biaya_lain_pbb + $d->biaya_lain;
            $total_all = $total_lain + $d->total_harga_pengalihan + $d->harga_jual_makelar;
            $harga_per_meter = $total_all / $d->luas_ukur;


            $c = date_create($d->created_at);
            $tgl_bo = '-';
            $tgl_ord = '-';
            $tgl_tbt = '-';
            if ($d->status_pengalihan == 'belum order') {
                $tgl_bo = date_format($c, 'd M Y');
            } else if ($d->status_pengalihan == 'order') {
                $tgl_ord = tgl_indo($d->tgl_status_pengalihan);
            } else if ($d->status_pengalihan == 'terbit') {
                $tgl_tbt = tgl_indo($d->tgl_status_pengalihan);
            }

            $data_proses_this_year .= '
                <tr>
                    <td>' . $no++ . '</td>
                    <td>' . $d->nama_penjual . '</td>
                    <td>' . $d->nama_proyek . ' (' . $d->nama_status . ')' . '</td>
                    <td>' . tgl_indo($d->tgl_pembelian) . '</td>
                    <td>' . $d->nomor_gambar . '</td>

                    <td>' . $d->nama_surat_tanah1 . '</td>
                    <td>' . $sertif1 . '</td>
                    <td>' . $d->keterangan1 . '</td>

                    <td>' . $d->nama_surat_tanah2 . '</td>
                    <td>' . $sertif2 . '</td>
                    <td>' . $d->keterangan2 . '</td>

                    <td>' . $d->luas_surat . '</td>
                    <td>' . $d->luas_ukur . '</td>

                    <td>' . $d->nomor_pbb . '</td>
                    <td>' . $d->atas_nama_pbb . '</td>
                    <td>' . $d->luas_bangunan_pbb . '</td>
                    <td>Rp. ' . number_format($d->njop_bangunan) . '</td>
                    <td>' . $d->luas_bumi_pbb . '</td>
                    <td>Rp. ' . number_format($d->njop_bumi_pbb) . '</td>

                    <td>Rp. ' . number_format($satuan_pengalihan_hak) . '</td>
                    <td>Rp. ' . number_format($d->total_harga_pengalihan) . '</td>

                    <td>' . $d->nama_makelar . '</td>
                    <td>Rp. ' . number_format($d->harga_jual_makelar) . '</td>

                    <td>' . $tgl_bo . '</td>
                    <td>' . $tgl_ord . '</td>
                    <td>' . $tgl_tbt . '</td>
                    <td>' . $d->nama_pengalihan . '</td>
                    <td>' . tgl_indo($d->tgl_akta_pengalihan) . '</td>
                    <td>' . $d->no_akta_pengalihan . '</td>
                    <td>' . $d->atas_nama_pengalihan . '</td>
                    
                    <td>Rp. ' . number_format($d->biaya_lain_pematangan) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain_rugi) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain_pbb) . '</td>
                    <td>Rp. ' . number_format($d->biaya_lain) . '</td>
                    <td>Rp. ' . number_format($total_lain) . '</td>

                    <td>Rp. ' . number_format($total_all) . '</td>
                    <td>Rp. ' . number_format($harga_per_meter) . '</td>
                    <td>' . tgl_indo($d->serah_terima_finance) . '</td>
                    <td>' . $d->status_teknik . '</td>
                    <td>' . $d->ket . '</td>

                </tr>
            ';
        }


        $test = '
                <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: Calibri;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                </head>
                <body>
                <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                <br>
                <span style="font-size: 18px"><b>Evaluasi Tanah Belum SHGB</b></span>
                <br>
               
                <table border="1">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Nama Penjual</th>
                        <th rowspan="2">Lokasi</th>
                        <th rowspan="2">Tgl Pembelian</th>
                        <th rowspan="2">No. Gambar</th>

                        <th colspan="3">Data Surat Tanah 1</th>
                        <th colspan="3">Data Surat Tanah 2</th>
                        <th colspan="2">Luas (m<sup>2</sup>)</th>
                        <th colspan="6">PBB</th>
                        <th colspan="2">Harga Pengalihan Hak</th>
                        <th colspan="2">Makelar</th>
                        <th colspan="7">Pengalihan Hak</th>
                        <th colspan="5">Biaya Lain-lain</th>

                        <th rowspan="2">Total Harga</th>
                        <th rowspan="2">Harga /meter<sup>2</sup></th>
                        <th rowspan="2">Serah Terima Finance</th>
                        <th rowspan="2">Status Teknik</th>
                        <th rowspan="2">Ket</th>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>Surat</td>
                        <td>No. Surat</td>

                        <td>Nama</td>
                        <td>Surat</td>
                        <td>No. Surat</td>

                        <td>Surat</td>
                        <td>Ukur</td>

                        <td>Nomor</td>
                        <td>Atas Nama</td>
                        <td>Luas Bangunan</td>
                        <td>NJOP Bangunan</td>
                        <td>Luas Bumi</td>
                        <td>NJOP Bumi</td>

                        <td>Satuan</td>
                        <td>Total</td>

                        <td>Nama</td>
                        <td>Nilai</td>

                        <td>Belum Order</td>
                        <td>Order</td>
                        <td>Terbit</td>
                        <td>Jenis</td>
                        <td>Tanggal</td>
                        <td>Akte</td>
                        <td>Nama</td>

                        <td>Pematangan</td>
                        <td>Ganti Rugi</td>
                        <td>PBB</td>
                        <td>Lain-lain</td>
                        <td>Total</td>

                    </tr>

                    <tr>
                        <td colspan="40">s/d Tahun ' . $last_year . '</td>
                    </tr>
                    ' . $data_home_last_year . '


                    <tr>
                        <td colspan="40">Tahun ' . $this_year . '</td>
                    </tr>
                    ' . $data_home_this_year . '
                </table>


                <br>
                <span style="font-size: 18px"><b>Proses SHGB</b></span>
                <br>

                <table border="1">
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Nama Penjual</th>
                        <th rowspan="2">Lokasi</th>
                        <th rowspan="2">Tgl Pembelian</th>
                        <th rowspan="2">No. Gambar</th>

                        <th colspan="3">Data Surat Tanah 1</th>
                        <th colspan="3">Data Surat Tanah 2</th>
                        <th colspan="2">Luas (m<sup>2</sup>)</th>
                        <th colspan="6">PBB</th>
                        <th colspan="2">Harga Pengalihan Hak</th>
                        <th colspan="2">Makelar</th>
                        <th colspan="7">Pengalihan Hak</th>
                        <th colspan="5">Biaya Lain-lain</th>

                        <th rowspan="2">Total Harga</th>
                        <th rowspan="2">Harga /meter<sup>2</sup></th>
                        <th rowspan="2">Serah Terima Finance</th>
                        <th rowspan="2">Status Teknik</th>
                        <th rowspan="2">Ket</th>
                    </tr>
                     <tr>
                        <td>Nama</td>
                        <td>Surat</td>
                        <td>No. Surat</td>

                        <td>Nama</td>
                        <td>Surat</td>
                        <td>No. Surat</td>

                        <td>Surat</td>
                        <td>Ukur</td>

                        <td>Nomor</td>
                        <td>Atas Nama</td>
                        <td>Luas Bangunan</td>
                        <td>NJOP Bangunan</td>
                        <td>Luas Bumi</td>
                        <td>NJOP Bumi</td>

                        <td>Satuan</td>
                        <td>Total</td>

                        <td>Nama</td>
                        <td>Nilai</td>

                        <td>Belum Order</td>
                        <td>Order</td>
                        <td>Terbit</td>
                        <td>Jenis</td>
                        <td>Tanggal</td>
                        <td>Akte</td>
                        <td>Nama</td>

                        <td>Pematangan</td>
                        <td>Ganti Rugi</td>
                        <td>PBB</td>
                        <td>Lain-lain</td>
                        <td>Total</td>

                    </tr>

                     <tr>
                        <td colspan="40">s/d Tahun ' . $last_year . '</td>
                    </tr>
                    ' . $data_proses_last_year . '
                    <tr>
                        <td colspan="40">Tahun ' . $this_year . '</td>
                    </tr>
                    ' . $data_proses_this_year . '

                </table>

                </body></html>
                ';


        $file = "4. Evaluasi Tanah Belum SHGB.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$file\"");
        echo $test;
    }

    public function evaluasi_belum_shgb()
    {
        $proyek = $this->input->get('proyek');
        $status_pengalihan = ['belum order', 'order', 'terbit'];
        $last_year = date('Y', strtotime('-1 year'));
        $this_year = date('Y');
        $data = $this->laporan->data_export_rekap_belum_shgb($proyek);

        $reader = IOFactory::createReader('Xlsx');
        $excel = $reader->load('./assets/excel/excel_rakap_belum_shgb.xlsx');

        $start = 5;
        $no = 1;

        $excel->getActiveSheet()->setCellValue('C3', "Tanah Belum SHGB s/d $last_year");
        $excel->getActiveSheet()->setCellValue('F3', "Tanah Belum SHGB Tahun $this_year");
        $excel->getActiveSheet()->setCellValue('L3', "Proses SHGB s/d $last_year");
        $excel->getActiveSheet()->setCellValue('O3', "Proses SHGB Tahun $this_year");

        foreach ($data as $d) {
            $shgb_last = $this->laporan->get_jml_belum_shgb($last_year, 'belum', $d->id_proyek);
            $shgb_now = $this->laporan->get_jml_belum_shgb($this_year, 'belum', $d->id_proyek);
            $total_blm_shgb = $this->laporan->get_jml_belum_shgb(null, 'belum', $d->id_proyek);
            $proses_this_year = $this->laporan->get_jml_belum_shgb($this_year, 'proses', $d->id_proyek);


            $sisa_bid = $shgb_now['bid'] - $proses_this_year['bid'];
            $sisa_surat = $shgb_now['luas_surat'] - $proses_this_year['luas_ukur'];
            $sisa_ukur = $shgb_now['luas_surat'] - $proses_this_year['luas_ukur'];

            $finance_blm = $this->laporan->get_jml_bid_belum_shgb(null, null, $d->id_proyek, null, 'no');
            $finance_sdh = $this->laporan->get_jml_bid_belum_shgb(null, null, $d->id_proyek, null, 'yes');


            $ppb_bo = $this->laporan->get_jml_bid_belum_shgb(null, null, $d->id_proyek, 'belum order');
            $ppb_ord = $this->laporan->get_jml_bid_belum_shgb(null, null, $d->id_proyek, 'order');
            $ppb_trb = $this->laporan->get_jml_bid_belum_shgb(null, null, $d->id_proyek, 'terbit');
            $total_bid_spb = $ppb_bo + $ppb_ord + $ppb_trb;


            $sl_bid = $shgb_last['bid'];
            $sl_ls = $shgb_last['luas_surat'];
            $sl_lu = $shgb_last['luas_ukur'];

            $sw_bid = $shgb_now['bid'];
            $sw_ls = $shgb_now['luas_surat'];
            $sw_lu = $shgb_now['luas_ukur'];

            $tbs_bid = $total_blm_shgb['bid'];
            $tbs_ls = $total_blm_shgb['luas_surat'];
            $tbs_lu = $total_blm_shgb['luas_ukur'];

            $pst_bid = $proses_this_year['bid'];
            $pst_ls = $proses_this_year['luas_surat'];
            $pst_lu = $proses_this_year['luas_ukur'];

            $stbs_bid = $sisa_bid;
            $stbs_ls = $sisa_surat;
            $stbs_lu = $sisa_ukur;


            $excel->getActiveSheet()->setCellValue('A' . $start, "$no")
                ->setCellValue('B' . $start, "$d->nama_proyek")

                ->setCellValue('C' . $start, "$sl_bid")
                ->setCellValue('D' . $start, "$sl_ls")
                ->setCellValue('E' . $start, "$sl_lu")

                ->setCellValue('F' . $start, "$sw_bid")
                ->setCellValue('G' . $start, "$sw_ls")
                ->setCellValue('H' . $start, "$sw_lu")

                ->setCellValue('I' . $start, "$tbs_bid")
                ->setCellValue('J' . $start, "$tbs_ls")
                ->setCellValue('K' . $start, "$tbs_lu")

                ->setCellValue('L' . $start, "$pst_bid")
                ->setCellValue('M' . $start, "$pst_ls")
                ->setCellValue('N' . $start, "$pst_lu")

                ->setCellValue('O' . $start, "$stbs_bid")
                ->setCellValue('P' . $start, "$stbs_ls")
                ->setCellValue('Q' . $start, "$stbs_lu")

                ->setCellValue('R' . $start, "$ppb_bo")
                ->setCellValue('S' . $start, "$ppb_ord")
                ->setCellValue('T' . $start, "$ppb_trb")
                ->setCellValue('U' . $start, "$total_bid_spb")

                ->setCellValue('V' . $start, "$finance_blm")
                ->setCellValue('W' . $start, "$finance_sdh");
            $start++;
            $no++;
        }

        $this->to_export($excel, '4. Rekap tanah belum SHGB.xlsx');
    }
    //END EXPORT NO 4




    //EXPORT MENU NO.5 START
    public function evaluasi_data_proses_induk()
    {
        $tahun = $this->input->get('ftahun');
        $proyek = $this->input->get('fproyek');
        $status = $this->input->get('fstatus');

        $data = $this->export->export_evaluasi_induk($proyek, $tahun, $status);
        $html = '';
        $i = 1;

        foreach ($data as $d) {
            $id_proses_induk = $d->id_proses_induk;
            $html_sub1 = '';
            $html_sub2 = '';

            $data_sub = $this->export->export_sub_induk($id_proses_induk);
            $jml_sub = count($data_sub);
            $total_luas_daftar = $this->db->select('sum(luas_surat) as luas')
                ->from('master_tanah')
                ->join('sub_proses_induk', 'master_tanah.id = sub_proses_induk.tanah_id', 'left')
                ->where('sub_proses_induk.induk_id', $id_proses_induk)
                ->get()->row()->luas;

            $luas_terbit = $d->luas_terbit;

            $selisih = $total_luas_daftar - $luas_terbit;


            // var_dump($data_sub[0]);

            if ($jml_sub > 1) {
                $r = $jml_sub;
                $datasub1 = $data_sub[0];
                unset($data_sub[0]);

                $rowspan = 'rowspan="' . $r . '"';
                $html_sub1 = '
                    <td>' . $datasub1->keterangan1 . '</td>
                    <td>' . $datasub1->nama_surat_tanah1 . '</td>
                    <td>' . $datasub1->luas_surat . '</td>
                    
                     <td>' . $total_luas_daftar . '</td>
                            <td>' . $luas_terbit . '</td>
                            <td>' . $selisih . '</td>

                            <td>' . $d->tgl_ukur . '</td>
                            <td>' . $d->no_ukur . '</td>

                            <td>' . $d->tgl_daftar_sk_hak . '</td>
                            <td>' . $d->no_daftar_sk_hak . '</td>

                            <td>' . $d->tgl_terbit_sk_hak . '</td>
                            <td>' . $d->no_terbit_sk_hak . '</td>

                            <td>' . $d->tgl_daftar_shgb . '</td>
                            <td>' . $d->no_daftar_shgb . '</td>

                            <td>' . $d->tgl_terbit_shgb . '</td>
                            <td>' . $d->no_terbit_shgb . '</td>

                            <td>' . $d->masa_berlaku_shgb . '</td>
                            <td>' . $d->target_penyelesaian . '</td>
                            <td>' . $d->ket_induk . '</td>
                            <td>' . $d->status_induk . '</td>
                            <td>' . $d->status_tanah . '</td>

                ';

                foreach ($data_sub as $ds) {
                    $html_sub2 .= '
                        <tr>
                            <td>' . $ds->keterangan1 . '</td>
                            <td>' . $ds->nama_surat_tanah1 . '</td>
                            <td>' . $ds->luas_surat . '</td>

                            <td>' . $total_luas_daftar . '</td>
                            <td>' . $luas_terbit . '</td>
                            <td>' . $selisih . '</td>

                            <td>' . $d->tgl_ukur . '</td>
                            <td>' . $d->no_ukur . '</td>

                            <td>' . $d->tgl_daftar_sk_hak . '</td>
                            <td>' . $d->no_daftar_sk_hak . '</td>

                            <td>' . $d->tgl_terbit_sk_hak . '</td>
                            <td>' . $d->no_terbit_sk_hak . '</td>

                            <td>' . $d->tgl_daftar_shgb . '</td>
                            <td>' . $d->no_daftar_shgb . '</td>

                            <td>' . $d->tgl_terbit_shgb . '</td>
                            <td>' . $d->no_terbit_shgb . '</td>

                            <td>' . $d->masa_berlaku_shgb . '</td>
                            <td>' . $d->target_penyelesaian . '</td>
                            <td>' . $d->ket_induk . '</td>
                            <td>' . $d->status_induk . '</td>
                            <td>' . $d->status_tanah . '</td>
                        </tr>
                    ';
                }
            } else {
                $rowspan = '';
                $html_sub2 = '';
                foreach ($data_sub as $ds) {
                    $html_sub1 .= '
                        <tr>
                            <td>' . $ds->keterangan1 . '</td>
                            <td>' . $ds->nama_surat_tanah1 . '</td>
                            <td>' . $ds->luas_surat . '</td>

                             <td>' . $total_luas_daftar . '</td>
                            <td>' . $luas_terbit . '</td>
                            <td>' . $selisih . '</td>

                            <td>' . $d->tgl_ukur . '</td>
                            <td>' . $d->no_ukur . '</td>

                            <td>' . $d->tgl_daftar_sk_hak . '</td>
                            <td>' . $d->no_daftar_sk_hak . '</td>

                            <td>' . $d->tgl_terbit_sk_hak . '</td>
                            <td>' . $d->no_terbit_sk_hak . '</td>

                            <td>' . $d->tgl_daftar_shgb . '</td>
                            <td>' . $d->no_daftar_shgb . '</td>

                            <td>' . $d->tgl_terbit_shgb . '</td>
                            <td>' . $d->no_terbit_shgb . '</td>

                            <td>' . $d->masa_berlaku_shgb . '</td>
                            <td>' . $d->target_penyelesaian . '</td>
                            <td>' . $d->ket_induk . '</td>
                            <td>' . $d->status_induk . '</td>
                            <td>' . $d->status_tanah . '</td>
                        </tr>
                    ';
                }
            }


            $html .= '
                <tr>
                    <td ' . $rowspan . ' >' . $i++ . '</td>
                    <td ' . $rowspan . '>' . $d->no_gambar_induk . '</td>
                    <td ' . $rowspan . '>' . $d->nama_proyek . ' (' . $d->nama_status . ')</td>

                    ' . $html_sub1 . '
                </tr>
            ' . $html_sub2;
        }



        $test = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: verdana;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                    <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                    <br>
                    <span style="font-size: 18px"><b>EVALUASI PROSES PENYELESAIAN INDUK</b></span>
                    <br>


                <table border="1">
                    <thead>
                        <tr>
                                        <th rowspan="2">#</th>
                                        <th rowspan="2">No. Gambar</th>
                                        <th rowspan="2">Blok</th>
                                        <th colspan="3">Data Tanah</th>

                                        <th colspan="3">Luas M<SUP>2</SUP></th>
                                        <th colspan="2">Daftar Ukur</th>
                                        <th colspan="2">Daftar SK Hak</th>
                                        <th colspan="2">Terbit SK Hak</th>
                                        <th colspan="2">Daftar SHGB</th>
                                        <th colspan="3">Terbit SHGB</th>
                                        <th rowspan="2">Target Penyelesaian</th>
                                        <th rowspan="2">Keterangan</th>
                                        <th rowspan="2">Status Proses Induk</th>
                                        <th rowspan="2">Status Tanah</th>
                        </tr>
                        <tr>
                                        <th>Surat</th>
                                        <th>Atas Nama</th>
                                        <th>Luas</th>

                                        <th>Daftar</th>
                                        <th>Terbit</th>
                                        <th>Selisih</th>
                                        <th>Tanggal</th>
                                        <th>No. Berkas</th>
                                        <th>Tanggal</th>
                                        <th>No. Berkas</th>
                                        <th>Tanggal</th>
                                        <th>No. SK</th>
                                        <th>Tanggal</th>
                                        <th>No. Berkas</th>
                                        <th>Tanggal</th>
                                        <th>No. SHGB</th>
                                        <th>Masa Berlaku</th>
                        </tr>
                    </thead>
                    <tbody>
                    ' . $html . '
                    </tbody>
                </table>

                         
                ';


        $file = "5. Laporan Evaluasi Proses Induk.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }

    public function rekap_data_proses_induk()
    {
        $proyek_id = $this->input->get('proyek');
        $status = $this->input->get('status');

        $data_rekap = $this->export->export_rekap_proses_induk($proyek_id, $status)->result();
        $html_rekap = '';
        $this_year = date('Y');
        $last_year = date('Y') - 1;

        $no = 1;
        foreach ($data_rekap as $r) {

            if ($data_rekap) {

                $pro_old_bid = $this->export->export_count_induk($r->proyek_id, 'dil', 'belum', null, $last_year)->num_rows();
                $get_pro_old_luas = $this->export->export_count_induk($r->proyek_id, 'luas', 'belum', null, $last_year)->row()->luas_terbit;
                if ($get_pro_old_luas) {
                    $s_old_luas = $get_pro_old_luas;
                } else {
                    $s_old_luas = 0;
                }


                $pro_new_bid = $this->export->export_count_induk($r->proyek_id, 'dil', 'belum', $this_year)->num_rows();
                $get_pro_new_luas = $this->export->export_count_induk($r->proyek_id, 'luas', 'belum', $this_year)->row()->luas_terbit;
                if ($get_pro_new_luas) {
                    $s_new_luas = $get_pro_new_luas;
                } else {
                    $s_new_luas = 0;
                }


                $tot_pro_bid = $pro_old_bid + $pro_new_bid;
                $tot_pro_luas = $s_old_luas + $s_new_luas;


                $terb_bid = $this->export->export_count_induk($r->proyek_id, 'dil', 'terbit', $this_year)->num_rows();
                $get_terb_luas = $this->export->export_count_induk($r->proyek_id, 'luas', 'terbit', $this_year)->row()->luas_terbit;
                if ($get_terb_luas) {
                    $terb_luas = $get_terb_luas;
                } else {
                    $terb_luas = 0;
                }


                $sis_bid = $tot_pro_bid - $terb_bid;
                $sis_luas = $tot_pro_luas - $terb_luas;

                $row = "<td style='text-align: center;vertical-align: middle;'>" . $no++ . "</td>";
                $nama_proyek = "<td style='text-align: center;vertical-align: middle;'>$r->nama_proyek ($r->nama_status)</td>";
                $v_pro_old_bid = "<td style='text-align: center;vertical-align: middle;'>$pro_old_bid</td>";
                $v_s_old_luas = "<td style='text-align: center;vertical-align: middle;'>$s_old_luas</td>";
                $v_pro_new_bid = "<td style='text-align: center;vertical-align: middle;'>$pro_new_bid</td>";
                $v_s_new_luas = "<td style='text-align: center;vertical-align: middle;'>$s_new_luas</td>";

                $v_tot_pro_bid = "<td style='text-align: center;vertical-align: middle;'>$tot_pro_bid</td>";
                $v_tot_pro_luas = "<td style='text-align: center;vertical-align: middle;'>$tot_pro_luas</td>";
                $v_terb_bid = "<td style='text-align: center;vertical-align: middle;'>$terb_bid</td>";
                $v_terb_luas = "<td style='text-align: center;vertical-align: middle;'>$terb_luas</td>";
                $v_sis_bid = "<td style='text-align: center;vertical-align: middle;'>$sis_bid</td>";
                $v_sis_luas = "<td style='text-align: center;vertical-align: middle;'>$sis_luas</td>";


                $html_rekap .= "<tr>
                        " .
                    $row .
                    $nama_proyek .
                    $v_pro_old_bid .
                    $v_s_old_luas .
                    $v_pro_new_bid .
                    $v_s_new_luas .
                    $v_tot_pro_bid .
                    $v_tot_pro_luas .
                    $v_terb_bid .
                    $v_terb_luas .
                    $v_sis_bid .
                    $v_sis_luas
                    . "
        </tr>";
            } else {
                $html_rekap .= "<tr>
                    <td></td>
                </tr>";
            }
        }

        $test = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: verdana;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes es>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                    <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                    <br>
                    <span style="font-size: 18px"><b>DATA REKAP PROSES INDUK</b></span>
                    <br>
                    <span style="font-size: 18px"><b>TAHUN ' . date('Y') . '</b></span>
                    <br>
                    <table border="1">
                    <tr style="background-color: #343a40; color: white;">
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">NO</th>
                                    <th rowspan="3" style="text-align: center;vertical-align: middle;">LOKASI</th>
                                    <th colspan="6" style="text-align: center;vertical-align: middle;">PROSES INDUK</th>
                                    <th colspan="2" rowspan="2" style="text-align: center;vertical-align: middle;">TERBIT TAHUN ' . date('Y') . '</th>
                                    <th colspan="2" rowspan="2" style="text-align: center;vertical-align: middle;">SISA SEBELUM TERBIT s/d ' . date('Y') . '</th>
                                
                    </tr>
                    <tr style="background-color: #9234eb ; color: white;">
                                      <th colspan="2" style="text-align: center;vertical-align: middle;">SISA S/D  ' . $last_year . '</th>
                                    <th colspan="2" style="text-align: center;vertical-align: middle;">TAHUN ' . date('Y') . '</th>
                                    <th colspan="2" style="text-align: center;vertical-align: middle;">TOTAL</th>
                    </tr>
                    <tr style="background-color: #d1d1d1;">
                        <th style="text-align: center;vertical-align: middle;">INDUK</th>
                                    <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                    <th style="text-align: center;vertical-align: middle;">INDUK</th>
                                    <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                    <th style="text-align: center;vertical-align: middle;">INDUK</th>
                                    <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                    <th style="text-align: center;vertical-align: middle;">INDUK</th>
                                    <th style="text-align: center;vertical-align: middle;">LUAS TERBIT</th>
                                    <th style="text-align: center;vertical-align: middle;">INDUK</th>
                                    <th style="text-align: center;vertical-align: middle;">LUAS</th>
                    </tr>
                    <tr>
                        ' . $html_rekap . '
                    </tr>
                    
                </table>

                <br>
                ';


        $file = "5. Laporan Rekap Proses Induk.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }

    //EXPORT MENU NO.5 END

    //EXPORT MENU NO.6 START
    public function evaluasi_revisi_split()
    {
        $proyek_id = $this->input->get('proyek_id');
        $status_proyek = $this->input->get('status_proyek');

        $data_penyelesaian_past = $this->export->export_evaluasi_revisi_split($proyek_id, '1970-01-01', (date('Y') - 1) . '-12-31', $status_proyek);
        $data_penyelesaian_now = $this->export->export_evaluasi_revisi_split($proyek_id, date('Y' . '-01-01'), date('Y') . '-12-31', $status_proyek);

        $html_penyelesaian_past = '';
        $html_subpenyelesaian_past = '';

        $html_penyelesaian_now = '';
        $html_subpenyelesaian_now = '';

        $today = date('Y-m-d');
        $leftYear = date('Y', strtotime('-1 year', strtotime($today)));

        $tahun_proses_sebelum = "<td colspan='18'>A. Proses sd. Tahun " . $leftYear . "</td>";
        $tahun_proses_sesudah = "<td colspan='18'>B. Proses  Tahun " . date('Y') . "</td>";
        $no = 1;

        foreach ($data_penyelesaian_past as $seb) {

            if ($data_penyelesaian_past) {

                $id_penggabungan = $seb->id_penggabungan;
                $sub_penggabungan_id = $seb->sub_penggabungan_id;
                $sub_penyelesaian_past = $this->export->list_penggabungan_induk($id_penggabungan);

                $row = "<td style='text-align: center;vertical-align: middle;'>" . $no++ . "</td>";

                foreach ($sub_penyelesaian_past as $spp) {
                    $html_subpenyelesaian_past .= "<tr style=" . "color: white" . ">" .
                        "<td style='text-align: center;vertical-align: middle;'>$spp->no_terbit_shgb</td>" .
                        "<td style='text-align: center;vertical-align: middle;'>$spp->blok</td>" .
                        "<td style='text-align: center;vertical-align: middle;'>$spp->luas_terbit</td>"
                        . "</tr>";
                }

                $html_sub_past = "<td style='text-align: center;vertical-align: middle;'><table border = '1'>$html_subpenyelesaian_past</table></td>";

                $total_luas_daftar = $this->db->select('sum(luas_surat) as luas, sub_proses_induk.induk_id as induk_proses_id')
                    ->from('master_tanah')
                    ->join('sub_proses_induk', 'master_tanah.id = sub_proses_induk.tanah_id', 'left')
                    ->join('tbl_proses_induk', 'sub_proses_induk.induk_id = tbl_proses_induk.id', 'left')
                    ->join('sub_penggabungan_induk', 'tbl_proses_induk.id = sub_penggabungan_induk.induk_id', 'left')
                    ->where('sub_proses_induk.induk_id', $sub_penggabungan_id)
                    ->get()->row()->luas;

                $luas_terbit = $seb->luas_terbit;
                $luas_selisih = $luas_terbit - $total_luas_daftar;

                $luas_daftar = "<td style='text-align: center;vertical-align: middle;'>$total_luas_daftar</td>";
                $v_luas_terbit = "<td style='text-align: center;vertical-align: middle;'>$luas_terbit</td>";
                $v_luas_selisih = "<td style='text-align: center;vertical-align: middle;'>$luas_selisih</td>";

                $tgl_daftar = "<td style='text-align: center;vertical-align: middle;'>" . tgl_indo($seb->tgl_daftar) . "</td>";
                $tgl_terbit = "<td style='text-align: center;vertical-align: middle;'>" . tgl_indo($seb->tgl_terbit) . "</td>";
                $no_berkas = "<td style='text-align: center;vertical-align: middle;'>" . $seb->no_berkas . "</td>";
                $no_shgb = "<td style='text-align: center;vertical-align: middle;'>" . $seb->no_shgb . "</td>";
                $posisi = "<td style='text-align: center;vertical-align: middle;'>" . $seb->posisi . "</td>";
                $ket_penggabungan = "<td style='text-align: center;vertical-align: middle;'>" . $seb->ket_penggabungan . "</td>";

                $html_penyelesaian_past .= "<tr>
                        " .
                    $row .
                    $html_sub_past .
                    $luas_daftar .
                    $v_luas_terbit .
                    $v_luas_selisih .
                    $tgl_daftar .
                    $tgl_terbit .
                    $no_berkas .
                    $no_shgb .
                    $posisi .
                    $ket_penggabungan
                    . "
        </tr>";
            } else {
                $html_penyelesaian_past .= "<tr>
                    <td></td>
                </tr>";
            }
        }

        foreach ($data_penyelesaian_now as $ses) {

            if ($data_penyelesaian_now) {


                $id_penggabungan = $ses->id_penggabungan;
                $sub_penggabungan_id = $ses->sub_penggabungan_id;
                $sub_penyelesaian_now = $this->export->list_penggabungan_induk($id_penggabungan);

                $row = "<td style='text-align: center;vertical-align: middle;'>" . $no++ . "</td>";

                foreach ($sub_penyelesaian_now as $spn) {
                    $html_subpenyelesaian_now .= "<tr style=" . "color: white" . ">" .
                        "<td style='text-align: center;vertical-align: middle;'>$spn->no_terbit_shgb</td>" .
                        "<td style='text-align: center;vertical-align: middle;'>$spn->blok</td>" .
                        "<td style='text-align: center;vertical-align: middle;'>$spn->luas_terbit</td>"
                        . "</tr>";
                }

                $html_sub_now = "<td style='text-align: center;vertical-align: middle;'><table border = '1'>$html_subpenyelesaian_now</table></td>";

                $total_luas_daftar = $this->db->select('sum(luas_surat) as luas, sub_proses_induk.induk_id as induk_proses_id')
                    ->from('master_tanah')
                    ->join('sub_proses_induk', 'master_tanah.id = sub_proses_induk.tanah_id', 'left')
                    ->join('tbl_proses_induk', 'sub_proses_induk.induk_id = tbl_proses_induk.id', 'left')
                    ->join('sub_penggabungan_induk', 'tbl_proses_induk.id = sub_penggabungan_induk.induk_id', 'left')
                    ->where('sub_proses_induk.induk_id', $sub_penggabungan_id)
                    ->get()->row()->luas;

                $luas_terbit = $ses->luas_terbit;
                $luas_selisih = $luas_terbit - $total_luas_daftar;

                $luas_daftar = "<td style='text-align: center;vertical-align: middle;'>$total_luas_daftar</td>";
                $v_luas_terbit = "<td style='text-align: center;vertical-align: middle;'>$luas_terbit</td>";
                $v_luas_selisih = "<td style='text-align: center;vertical-align: middle;'>$luas_selisih</td>";

                $tgl_daftar = "<td style='text-align: center;vertical-align: middle;'>" . tgl_indo($ses->tgl_daftar) . "</td>";
                $tgl_terbit = "<td style='text-align: center;vertical-align: middle;'>" . tgl_indo($ses->tgl_terbit) . "</td>";
                $no_berkas = "<td style='text-align: center;vertical-align: middle;'>" . $ses->no_berkas . "</td>";
                $no_shgb = "<td style='text-align: center;vertical-align: middle;'>" . $ses->no_shgb . "</td>";
                $posisi = "<td style='text-align: center;vertical-align: middle;'>" . $ses->posisi . "</td>";
                $ket_penggabungan = "<td style='text-align: center;vertical-align: middle;'>" . $ses->ket_penggabungan . "</td>";

                $html_penyelesaian_now .= "<tr>
                        " .
                    $row .
                    $html_sub_now .
                    $luas_daftar .
                    $v_luas_terbit .
                    $v_luas_selisih .
                    $tgl_daftar .
                    $tgl_terbit .
                    $no_berkas .
                    $no_shgb .
                    $posisi .
                    $ket_penggabungan
                    . "
        </tr>";
            } else {
                $html_penyelesaian_now .= "<tr>
                    <td></td>
                </tr>";
            }
        }

        $test = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: verdana;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                    <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                    <br>
                    <span style="font-size: 18px"><b>EVALUASI PROSES PENGGABUNGAN INDUK</b></span>
                    <br>
                    <span style="font-size: 18px"><b>TAHUN ' . date('Y') . '</b></span>
                    <br>
                    <table border="1">
                    <tr style="background-color: #343a40; color: white;">
                        <th style="text-align: center;vertical-align: middle;" rowspan="2">NO</th>
                        <th colspan="1">DATA TANAH</th>
                                    <th style="text-align: center;vertical-align: middle;" colspan="3">LUAS M<SUP>2</SUP></th>
                                    <th style="text-align: center;vertical-align: middle;" colspan="2">TANGGAL</th>
                                    <th style="text-align: center;vertical-align: middle;" colspan="2">NOMOR</th>
                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">POSISI</th>
                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">KET</th>
                    </tr>
                    <tr style="background-color: #9234eb ; color: white;">
                    <th><table border="1"><tr><th>No.SHGB</th><th>Blok</th><th>Luas</th></tr></table></th>
                                    <th class="text-white text-center">DAFTAR</th>
                                    <th class="text-white text-center">TERBIT</th>
                                    <th class="text-white text-center">SELISIH</th>
                                    <th class="text-white text-center">DAFTAR</th>
                                    <th class="text-white text-center">TERBIT</th>
                                    <th class="text-white text-center">BERKAS</th>
                                    <th class="text-white text-center">SHGB</th>
                    </tr>
                 
                    <tr style="background-color: #ded883;">
                    ' . $tahun_proses_sebelum . '
                    </tr>
                    ' . $html_penyelesaian_past . '
                    <tr style="background-color: #ded883;">
                    ' . $tahun_proses_sesudah . '
                    </tr>
                    ' . $html_penyelesaian_now . '
                    
                </table>';
        $file = "6. Laporan Evaluasi Penggabungan Induk.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $test;
    }
    public function rekap_revisi_split()
    {
        $proyek_id = $this->input->get('proyek_id');
        $status_proyek = $this->input->get('status_proyek');

        $rekap_penggabungan = $this->export->export_rekap_penggabungan_split(null, null, $proyek_id, null, null, $status_proyek)->result();

        $html_rekap_penggabungan = '';
        $no = 1;

        $this_year = date('Y');
        $last_year = date('Y') - 1;
        foreach ($rekap_penggabungan as $r) {



            $pro_old_bid = $this->export->export_count_bidluas($r->proyek_id, 'dil', 'proses', null, $last_year)->num_rows();
            $get_pro_old_luas = $this->export->export_count_bidluas($r->proyek_id, 'luas', 'proses', null, $last_year)->row()->luas_terbit;
            if ($get_pro_old_luas) {
                $s_old_luas = $get_pro_old_luas;
            } else {
                $s_old_luas = 0;
            }


            $pro_new_bid = $this->export->export_count_bidluas($r->proyek_id, 'dil', 'proses', $this_year)->num_rows();
            $get_pro_new_luas = $this->export->export_count_bidluas($r->proyek_id, 'luas', 'proses', $this_year)->row()->luas_terbit;
            if ($get_pro_new_luas) {
                $s_new_luas = $get_pro_new_luas;
            } else {
                $s_new_luas = 0;
            }


            $tot_pro_bid = $pro_old_bid + $pro_new_bid;
            $tot_pro_luas = $s_old_luas + $s_new_luas;


            $terb_bid = $this->export->export_count_bidluas($r->proyek_id, 'dil', 'terbit', $this_year)->num_rows();
            $get_terb_luas = $this->export->export_count_bidluas($r->proyek_id, 'luas', 'terbit', $this_year)->row()->luas_terbit;
            if ($get_terb_luas) {
                $terb_luas = $get_terb_luas;
            } else {
                $terb_luas = 0;
            }


            $sis_bid = $tot_pro_bid - $terb_bid;
            $sis_luas = $tot_pro_luas - $terb_luas;

            if ($rekap_penggabungan) {
                $row = "<td>" . $no++ . "</td>";

                $nama_proyek = "<td>$r->nama_proyek</td>";
                $pro_old_bid = "<td>$pro_old_bid</td>";
                $s_old_luas = "<td>$s_old_luas</td>";
                $pro_new_bid = "<td>$pro_new_bid</td>";
                $s_new_luas = "<td>$s_new_luas</td>";
                $tot_pro_bid = "<td>$tot_pro_bid</td>";
                $tot_pro_luas = "<td>$tot_pro_luas</td>";
                $terb_bid = "<td>$terb_bid</td>";
                $terb_luas = "<td>$terb_luas</td>";
                $sis_bid = "<td>$sis_bid</td>";
                $sis_luas = "<td>$sis_luas</td>";

                $html_rekap_penggabungan .= "<tr>
                        " .
                    $row .
                    $nama_proyek .
                    $pro_old_bid .
                    $s_old_luas .
                    $pro_new_bid .
                    $s_new_luas .
                    $tot_pro_bid .
                    $tot_pro_luas .
                    $terb_bid .
                    $terb_luas .
                    $sis_bid .
                    $sis_luas
                    . "
        </tr>";
            } else {
                $html_rekap_penggabungan .= "<tr>
                    <td></td>
                </tr>";
            }
        }

        $test = '
                <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: verdana;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                </head>
                <body>
                <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                <br>
                <span style="font-size: 18px"><b>REKAP PROSES PENGGABUNGAN INDUK</b></span>
                <br>
                <span style="font-size: 18px"><b>TAHUN ' . date('Y') . '</b></span>
                <br>
                <table border="1">
                    <tr style="background-color: #212529; color: white">
                       <th rowspan="3" style="text-align: center;vertical-align: middle;">NO</th>
                       <th rowspan="3" style="text-align: center;vertical-align: middle;">LOKASI</th>
                        <th colspan="6" style="text-align: center;vertical-align: middle;">PROSES PENGGABUNGAN </th>
                        <th colspan="2" rowspan="2" style="text-align: center;vertical-align: middle;">TERBIT TAHUN ' . date('Y') . '</th>
                        <th colspan="2" rowspan="2" style="text-align: center;vertical-align: middle;">SISA SEBELUM TERBIT s/d ' . date('Y') . '</th>
                    </tr>
                    <tr style="background-color: #9234eb;">
                        <th colspan="2" style="text-align: center;vertical-align: middle;">SISA S/D ' . $last_year . '</th>
                        <th colspan="2" style="text-align: center;vertical-align: middle;">TAHUN ' . date('Y') . '</th>
                        <th colspan="2" style="text-align: center;vertical-align: middle;">TOTAL</th>
                    </tr>
                    <tr style="background-color: #d1d1d1;">
                       <th style="text-align: center;vertical-align: middle;">BID</th>
                        <th style="text-align: center;vertical-align: middle;">LUAS</th>
                        <th style="text-align: center;vertical-align: middle;">BID</th>
                        <th style="text-align: center;vertical-align: middle;">LUAS</th>
                        <th style="text-align: center;vertical-align: middle;">BID</th>
                        <th style="text-align: center;vertical-align: middle;">LUAS</th>
                        <th style="text-align: center;vertical-align: middle;">BID</th>
                        <th style="text-align: center;vertical-align: middle;">LUAS</th>
                        <th style="text-align: center;vertical-align: middle;">BID</th>
                        <th style="text-align: center;vertical-align: middle;">LUAS</th>
                    </tr>
                    ' . $html_rekap_penggabungan . '
                </table>
                </body></html>
                ';


        $file = "6. Laporan Rekap Evaluasi Penggabungan Induk.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$file\"");
        echo $test;
        exit;
    }
    //EXPORT MENU NO.6 END



    //export no 8
    public function export_evaluasi_8()
    {
        $proyek = $this->input->get('proyek');
        $tgl_export = 'Tanggal Export: ' . date('Y-m-d');
        if ($proyek != '') {
            $get_data_proyek = $this->db->get_where('master_proyek', ['id' => $proyek])->row();
            $nama_perum = 'Perumahan ' . $get_data_proyek->nama_proyek;
        } else {
            $nama_perum = 'Semua Data Perumahan';
        }
        $last_year = date('Y', strtotime('-1 year'));
        $this_year = date('Y');

        $data_lastyear = $this->laporan->get_data_evaluasi_splitsing(null, $last_year, $proyek, 'group')->result();
        $data_thisyear = $this->laporan->get_data_evaluasi_splitsing($this_year, null, $proyek, 'group')->result();
        $get_list_month = $this->model->get_month_data();
        $show_lastyear = '';
        $show_thisyear = '';


        //show list month
        $list_month = '';
        foreach ($get_list_month as $glm) {
            $list_month .= '
                    <th>' . $glm['short'] . '</th>
            ';
        }
        $month = '<tr>' . $list_month . '</tr>';



        //show data last year
        $no = 1;
        $t_unit_a = 0;
        $t_ukav_a = 0;
        $t_ltbt_a = 0;
        $t_selisih_a = 0;
        $a_year = '<tr style="background: #bdd9ff"><td colspan="28">A. Proses s/d ' . $last_year . '</td></tr>';

        if (!empty($data_lastyear)) {
            foreach ($data_lastyear as $dta) {
                $data_unit = $this->laporan->get_data_evaluasi_splitsing(null, $last_year, $proyek, null, $dta->group_id)->result();
                $jml_unit = count($data_unit);
                $u_kav = 0;
                $l_terb = 0;
                $jml_selisih = 0;
                $t_unit_a += $jml_unit;

                $a_induk = '<tr style="color: red">
                        <td>' . $no++ . '</td>
                        <td>' . $dta->shgb_induk . '</td>
                        <td>' . $jml_unit . '</td>
                        <td colspan="10"></td>
                        <td>' . $dta->status . '</td>
                        <td colspan="2"></td>
                        <td colspan="12"></td>
                    </tr>';
                $a_blok = '';
                foreach ($data_unit as $dtu) {
                    $selisih = $dtu->luas_kavling - $dtu->luas_terbit;
                    $u_kav += $dtu->luas_kavling;
                    $l_terb += $dtu->luas_terbit;
                    $jml_selisih += $selisih;

                    $list_terbit_month = '';
                    foreach ($get_list_month as $lm) {
                        if ($dtu->status == 'terbit' && $dtu->tgl_terbit != '0000-00-00') {
                            $length_month = ceil(log10($lm['val'] + 1));
                            if ($length_month == 1) {
                                $bln = 0 . $lm['val'];
                            } else if ($length_month == 2) {
                                $bln = $lm['val'];
                            }

                            $jml_terbit = $this->laporan->get_count_data_terbit8($dtu->group_id, $dtu->id, $bln, $last_year)->row()->jml_terbit;

                            if ($jml_terbit > 0) {
                                $list_terbit_month .= '<td>' . $jml_terbit . '</td>';
                            } else {
                                $list_terbit_month .= '<td></td>';
                            }
                        } else {
                            $list_terbit_month .= '<td></td>';
                        }
                    }

                    $a_blok .= '<tr>
                            <td colspan="3"></td>
                            
                            <td>' . $dtu->blok . '</td>    
                            <td>' . $dtu->luas_kavling . '</td>    
                            <td>' . $dtu->luas_terbit . '</td>    
                            <td>' . $selisih . '</td>    
                            <td>' . $dtu->no_shgb . '</td>    
                            <td>' . tgl_indo($dtu->masa_berlaku) . '</td>    
                            <td>' . $dtu->no_daftar . '</td>    
                            <td>' . tgl_indo($dtu->tgl_daftar) . '</td>    
                            <td>' . tgl_indo($dtu->tgl_terbit) . '</td>    
                            <td>' . $dtu->keterangan . '</td>  
                            <td></td>  
                            <td colspan="2"></td>
                            ' . $list_terbit_month . '
                        </tr>';
                }

                $list_terbit_by_induk = '';
                foreach ($get_list_month as $lm) {
                    if ($dta->status == 'terbit' && $dta->tgl_terbit != '0000-00-00') {
                        $length_month = ceil(log10($lm['val'] + 1));
                        if ($length_month == 1) {
                            $bln = 0 . $lm['val'];
                        } else if ($length_month == 2) {
                            $bln = $lm['val'];
                        }

                        $jml_terbit = $this->laporan->get_count_data_terbit8($dta->group_id, null, $bln, $last_year)->row()->jml_terbit;

                        if ($jml_terbit > 0) {
                            $list_terbit_by_induk .= '<td>' . $jml_terbit . '</td>';
                        } else {
                            $list_terbit_by_induk .= '<td></td>';
                        }
                    } else {
                        $list_terbit_by_induk .= '<td></td>';
                    }
                }

                $t_ukav_a += $u_kav;
                $t_ltbt_a += $l_terb;
                $t_selisih_a += $jml_selisih;
                $total_by_induk = '<tr style="background: #fff5ad">
                        <td colspan="2">Jumlah</td>
                        <td>' . $jml_unit . '</td>
                        <td></td>
                        <td>' . $u_kav . '</td>
                        <td>' . $l_terb . '</td>
                        <td>' . $jml_selisih . '</td>
                        <td colspan="7"></td>
                        <td colspan="2"></td>
                        ' . $list_terbit_by_induk . '
                    </tr>';
                $show_lastyear .= $a_induk . $a_blok . $total_by_induk;
            }

            $list_terbit_all_a = '';
            foreach ($get_list_month as $lm) {
                $length_month = ceil(log10($lm['val'] + 1));
                if ($length_month == 1) {
                    $bln = 0 . $lm['val'];
                } else if ($length_month == 2) {
                    $bln = $lm['val'];
                }

                $jml_terbit = $this->laporan->get_count_data_terbit8(null, null, $bln, $last_year)->row()->jml_terbit;

                if ($jml_terbit > 0) {
                    $list_terbit_all_a .= '<td>' . $jml_terbit . '</td>';
                } else {
                    $list_terbit_all_a .= '<td></td>';
                }
            }
        } else {
            $show_lastyear = '<tr><td colspan="28">No data result</td></tr>';
            $list_terbit_all_a = '<td colspan="12"></td>';
        }



        $total_all_a = '<tr style="background: #bdd9ff">
                <td colspan="2">Total - A</td>
                <td>' . $t_unit_a . '</td>
                <td></td>
                <td>' . $t_ukav_a . '</td>
                <td>' . $t_ltbt_a . '</td>
                <td>' . $t_selisih_a . '</td>
                <td colspan="7"></td>
                <td colspan="2"></td>
                ' . $list_terbit_all_a . '
        </tr>';
        $separator = '<tr><td colspan="28"></td></tr><tr><td colspan="28"></td></tr>';


        //show data this year
        $no = 1;
        $t_unit_b = 0;
        $t_ukav_b = 0;
        $t_ltbt_b = 0;
        $t_selisih_b = 0;
        $b_year = '<tr style="background: #bdd9ff"><td colspan="28">B. Proses ' . $this_year . '</td></tr>';

        if (!empty($data_thisyear)) {
            foreach ($data_thisyear as $dta) {
                $data_unit = $this->laporan->get_data_evaluasi_splitsing($this_year, null, $proyek, null, $dta->group_id)->result();
                $jml_unit = count($data_unit);
                $u_kav = 0;
                $l_terb = 0;
                $jml_selisih = 0;
                $t_unit_b += $jml_unit;

                $b_induk = '<tr style="color: red">
                        <td>' . $no++ . '</td>
                        <td>' . $dta->shgb_induk . '</td>
                        <td>' . $jml_unit . '</td>
                        <td colspan="10"></td>
                        <td>' . $dta->status . '</td>  
                        <td colspan="2"></td>
                        <td colspan="12"></td>
                    </tr>';
                $b_blok = '';
                foreach ($data_unit as $dtu) {
                    $selisih = $dtu->luas_kavling - $dtu->luas_terbit;
                    $u_kav += $dtu->luas_kavling;
                    $l_terb += $dtu->luas_terbit;
                    $jml_selisih += $selisih;

                    $list_terbit_month = '';
                    foreach ($get_list_month as $lm) {
                        if ($dtu->status == 'terbit' && $dtu->tgl_terbit != '0000-00-00') {
                            $length_month = ceil(log10($lm['val'] + 1));
                            if ($length_month == 1) {
                                $bln = 0 . $lm['val'];
                            } else if ($length_month == 2) {
                                $bln = $lm['val'];
                            }

                            $jml_terbit = $this->laporan->get_count_data_terbit8($dtu->group_id, $dtu->id, $bln, $this_year)->row()->jml_terbit;

                            if ($jml_terbit > 0) {
                                $list_terbit_month .= '<td>' . $jml_terbit . '</td>';
                            } else {
                                $list_terbit_month .= '<td></td>';
                            }
                        } else {
                            $list_terbit_month .= '<td></td>';
                        }
                    }

                    $b_blok .= '<tr>
                            <td colspan="3"></td>
                            
                            <td>' . $dtu->blok . '</td>    
                            <td>' . $dtu->luas_kavling . '</td>    
                            <td>' . $dtu->luas_terbit . '</td>    
                            <td>' . $selisih . '</td>    
                            <td>' . $dtu->no_shgb . '</td>    
                            <td>' . tgl_indo($dtu->masa_berlaku) . '</td>    
                            <td>' . $dtu->no_daftar . '</td>    
                            <td>' . tgl_indo($dtu->tgl_daftar) . '</td>    
                            <td>' . tgl_indo($dtu->tgl_terbit) . '</td>    
                            <td>' . $dtu->keterangan . '</td>  
                            <td></td>  
                            <td colspan="2"></td>
                            ' . $list_terbit_month . '
                        </tr>';
                }


                $list_terbit_by_induk = '';
                foreach ($get_list_month as $lm) {
                    if ($dta->status == 'terbit' && $dta->tgl_terbit != '0000-00-00') {
                        $length_month = ceil(log10($lm['val'] + 1));
                        if ($length_month == 1) {
                            $bln = 0 . $lm['val'];
                        } else if ($length_month == 2) {
                            $bln = $lm['val'];
                        }

                        $jml_terbit = $this->laporan->get_count_data_terbit8($dta->group_id, null, $bln, $this_year)->row()->jml_terbit;

                        if ($jml_terbit > 0) {
                            $list_terbit_by_induk .= '<td>' . $jml_terbit . '</td>';
                        } else {
                            $list_terbit_by_induk .= '<td></td>';
                        }
                    } else {
                        $list_terbit_by_induk .= '<td></td>';
                    }
                }


                $t_ukav_b += $u_kav;
                $t_ltbt_b += $l_terb;
                $t_selisih_b += $jml_selisih;
                $total_by_induk = '<tr style="background: #fff5ad">
                        <td colspan="2">Jumlah</td>
                        <td>' . $jml_unit . '</td>
                        <td></td>
                        <td>' . $u_kav . '</td>
                        <td>' . $l_terb . '</td>
                        <td>' . $jml_selisih . '</td>
                        <td colspan="7"></td>
                        <td colspan="2"></td>
                        ' . $list_terbit_by_induk . '
                    </tr>';


                $show_thisyear .= $b_induk . $b_blok . $total_by_induk;
            }

            $list_terbit_all_b = '';
            foreach ($get_list_month as $lm) {
                $length_month = ceil(log10($lm['val'] + 1));
                if ($length_month == 1) {
                    $bln = 0 . $lm['val'];
                } else if ($length_month == 2) {
                    $bln = $lm['val'];
                }

                $jml_terbit = $this->laporan->get_count_data_terbit8(null, null, $bln, $this_year)->row()->jml_terbit;

                if ($jml_terbit > 0) {
                    $list_terbit_all_b .= '<td>' . $jml_terbit . '</td>';
                } else {
                    $list_terbit_all_b .= '<td></td>';
                }
            }
        } else {
            $show_thisyear = '<tr><td colspan="28">No data result</td></tr>';
            $list_terbit_all_b = '<td colspan="12"></td>';
        }






        $total_all_b = '<tr style="background: #bdd9ff">
                <td colspan="2">Total - B</td>
                <td>' . $t_unit_b . '</td>
                <td></td>
                <td>' . $t_ukav_b . '</td>
                <td>' . $t_ltbt_b . '</td>
                <td>' . $t_selisih_b . '</td>
                <td colspan="7"></td>
                <td colspan="2"></td>
                ' . $list_terbit_all_b . '
        </tr>';


        $total_unit = $t_unit_a + $t_unit_b;
        $total_ukav = $t_ukav_a + $t_ukav_b;
        $total_ltbt = $t_ltbt_a + $t_ltbt_b;
        $total_selisih = $t_selisih_a + $t_selisih_b;
        //total all
        $total = '
            <tr style="background-color: #454545; color: white">
                <td colspan="2">Total</td>
                <td>' . $total_unit . '</td>
                <td></td>
                <td>' . $total_ukav . '</td>
                <td>' . $total_ltbt . '</td>
                <td>' . $total_selisih . '</td>
                <td colspan="7"></td>
                <td colspan="2"></td>
                <td colspan="12"></td>
            </tr>
        ';



        $test = '
                <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: Calibri;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                </head>
                <body>
                <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                <br>
                <span style="font-size: 18px"><b>PROSES SERTIFIKASI SPLITSING</b></span>
                <br>
                </br>
               
                <table border="1">
                    <tr style="background-color: #454545; color: white">
                        <th rowspan="2">No</th>
                        <th rowspan="2">Induk</th>
                        <th rowspan="2">Unit</th>
                        <th rowspan="2">Blok</th>
                        <th rowspan="2">Ukuran Kavling</th>
                        <th rowspan="2">Luas Terbit</th>
                        <th rowspan="2">Selisih</th>
                        <th rowspan="2">No. SHGB</th>
                        <th rowspan="2">Masa Berlaku</th>
                        <th rowspan="2">No. Daftar</th>
                        <th rowspan="2">Tgl. Daftar</th>
                        <th rowspan="2">Tgl. Terbit</th>
                        <th rowspan="2">Ket</th>
                        <th rowspan="2">Status</th>

                        <th colspan="2" rowspan="2">-</th>
                        <th colspan="12">Tahun ' . $last_year . '</th>
                    </tr>
                    ' . $month . $a_year . $show_lastyear . $total_all_a . $separator . '

                    <tr style="background-color: #454545; color: white">
                        <th rowspan="2">No</th>
                        <th rowspan="2">Induk</th>
                        <th rowspan="2">Unit</th>
                        <th rowspan="2">Blok</th>
                        <th rowspan="2">Ukuran Kavling</th>
                        <th rowspan="2">Luas Terbit</th>
                        <th rowspan="2">Selisih</th>
                        <th rowspan="2">No. SHGB</th>
                        <th rowspan="2">Masa Berlaku</th>
                        <th rowspan="2">No. Daftar</th>
                        <th rowspan="2">Tgl. Daftar</th>
                        <th rowspan="2">Tgl. Terbit</th>
                        <th rowspan="2">Ket</th>
                        <th rowspan="2">Status</th>

                        <th colspan="2" rowspan="2">-</th>
                        <th colspan="12">Tahun ' . $this_year . '</th>
                    </tr>

                    ' . $month . $b_year . $show_thisyear . $total_all_b . $total . '
                     
                </table>
                </body></html>
                ';


        $file = "8. Evaluasi Proses Splitsing.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$file\"");
        echo $test;
    }

    public function export_rekap_8()
    {
        $proyek = $this->input->get('proyek');
        $last_year = date('Y', strtotime('-1 year'));
        $this_year = date('Y');
        if ($proyek == '') {
            $data_proyek = $this->db->get('master_proyek')->result();
        } else {
            $data_proyek = $this->db->get_where('master_proyek', ['id' => $proyek])->result();
        }

        $data_list = '';
        $i = 1;
        $total_ps_lastyear = 0;
        $total_ps_thisyear = 0;
        $total_jml_ps = 0;
        $total_sisa_blmtbt = 0;
        $get_month = $this->model->get_month_data();

        $terbit_month_total = '';
        foreach ($get_month as $lm) {
            $data_terbit = $this->laporan->data_rekap_8(null, 'terbit', null, $lm['val'], null, $this_year)->row()->jumlah;
            if ($data_terbit > 0) {
                $terbit_month_total .= '<td>' . $data_terbit . '</td>';
            } else {
                $terbit_month_total .= '<td>-</td>';
            }
        }

        foreach ($data_proyek as $lp) {
            $ps_lastyear = $this->laporan->data_rekap_8($lp->id, 'proses', null, null, $last_year)->row()->jumlah;
            $ps_thisyear = $this->laporan->data_rekap_8($lp->id, 'proses', null, null, null, $this_year)->row()->jumlah;
            $jml_blmterbit = $this->laporan->data_rekap_8($lp->id, null, 'terbit')->row()->jumlah;
            $total_sisa_blmtbt += $jml_blmterbit;

            $list_data_by_month = '';
            foreach ($get_month as $gm) {
                $length_month = ceil(log10($gm['val'] + 1));
                if ($length_month == 1) {
                    $bln = 0 . $gm['val'];
                } else if ($length_month == 2) {
                    $bln = $gm['val'];
                }
                $data_terbit = $this->laporan->data_rekap_8($lp->id, 'terbit', null, $bln, null, $this_year)->row()->jumlah;

                if ($data_terbit > 0) {
                    $list_data_by_month .= '<td>' . $data_terbit . '</td>';
                } else {
                    $list_data_by_month .= '<td>-</td>';
                }
            }

            $jml_ps = $ps_lastyear + $ps_thisyear;

            $total_jml_ps += $jml_ps;
            $total_ps_lastyear += $ps_lastyear;
            $total_ps_thisyear += $ps_thisyear;


            $data_list .= '
                <tr>
                    <td>' . $i++ . '</td>
                    <td>' . $lp->nama_proyek . '</td>
                    <td>' . $ps_lastyear . '</td>
                    <td>' . $ps_thisyear . '</td>
                    <td>' . $jml_ps . '</td>
                ' . $list_data_by_month . '
                    <td>' . $jml_blmterbit . '</td>
                    <td></td>
                </tr>
            ';
        }



        $test = '
                <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: Calibri;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                </head>
                <body>
                <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                <br>
                <span style="font-size: 18px"><b>REKAP SPLITSING</b></span>
                <br>
                </br>
               
                <table border="1">
                                <tr style="background: #303030; color: white">
                                    <th rowspan="2" class="bg-dark text-light text-center">#</th>
                                    <th rowspan="2" class="bg-dark text-light text-center">Lokasi</th>
                                    <th colspan="3" class="bg-dark text-light text-center">Proses Splitsing</th>
                                    <th colspan="12" class="bg-dark text-light text-center">Terbit Tahun ' . $this_year . '</th>
                                    <th rowspan="2" class="bg-dark text-light text-center">Sisa Belum Terbit</th>
                                    <th rowspan="2" class="bg-dark text-light text-center">Keterangan</th>
                                </tr>
                                <tr style="color: white">
                                    <th class="text-white text-center" style="background-color:#3477eb ;">sd. ' . $last_year . '</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Thn. ' . $this_year . '</th>
                                    <th class="text-white text-center" style="background-color:#3477eb ;">Jumlah</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Jan</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Feb</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Mar</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Apr</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Mei</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Jun</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Jul</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Ags</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Sep</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Okt</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Nov</th>
                                    <th class="text-white text-center" style="background-color: #3477eb;">Des</th>
                                </tr>
                    

                    ' . $data_list . '

                    <tr style="background: #d9edff">
                        <td></td>
                        <td>Total</td>
                        <td>' . $total_ps_lastyear . '</td>
                        <td>' . $total_ps_thisyear . '</td>
                        <td>' . $total_jml_ps . '</td>
                        ' . $terbit_month_total . '
                        <td>' . $total_sisa_blmtbt . '</td>
                        <td></td>
                    </tr>

                </table>
                </body></html>
                ';


        $file = "8. Rekap Splitsing.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$file\"");
        echo $test;
    }
    //end export no 8

    //FUNGSI EXPORT 
    private function to_export($excel, $file_name)
    {
        //set the header first, so the result will be treated as an xlsx file.
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        //make it an attachment so we can define filename
        header('Content-Disposition: attachment;filename="' . $file_name . '"');

        //create IOFactory object
        $writer = IOFactory::createWriter($excel, 'Xlsx');
        //save into php output
        $writer->save('php://output');
    }



    //export no 9

    public function export_evaluasi_9()
    {
        $last_year = date('Y', strtotime('-1 year'));
        $this_year = date('Y');
        $status = [
            ['title' => 'Belum Proses', 'value' => 'belum proses'],
            ['title' => 'Proses', 'value' => 'proses'],
            ['title' => 'Terbit', 'value' => 'terbit'],
        ];
        $data = '';

        foreach ($status as $stat) {
            $data_lastyear = $this->laporan->data_laporan_9(null, $last_year, $stat['value'])->result();
            $data_thisyear = $this->laporan->data_laporan_9($this_year, null, $stat['value'])->result();


            //data lastyear
            $list_lastyear = '';
            $no = 1;

            if (!empty($data_lastyear)) {
                foreach ($data_lastyear as $dt) {
                    $luas_selisih =  $dt->luas_kavling - $dt->luas_terbit;


                    if ($dt->status_penjualan == 'belum proses') {
                        $tgl_proses = '-';
                    } else {
                        $tgl_proses = tgl_indo($dt->tgl_proses);
                    }

                    if ($dt->status_penjualan == 'terbit') {
                        $tgl_terbit = tgl_indo($dt->tgl_terbit);
                    } else {
                        $tgl_terbit = '-';
                    }

                    $list_lastyear .= '
                        <tr>
                            <td>' . $no++ . '</td>
                            <td>' . tgl_indo($dt->tgl_penjualan) . '</td>
                            <td>' . $dt->pembeli . '</td>
                            <td>' . $dt->type . '</td>
                            <td>' . $dt->blok . '</td>
                            <td>1</td>
                            <td>' . $dt->luas_kavling . '</td>
                            <td>' . $dt->luas_terbit . '</td>
                            <td>' . $luas_selisih . '</td>
                            <td>' . $tgl_proses . '</td>
                            <td>' . $tgl_terbit . '</td>
                            <td>' . $dt->no_shgb . '</td>
                            <td>' . tgl_indo($dt->masa_berlaku) . '</td>
                            <td>' . $dt->keterangan . '</td>
                        </tr>
                    ';
                }
            } else {
                $list_lastyear = '<tr><td colspan="14" style="text-align: center; color: #9c0808;">No data result</td></tr>';
            }

            $show_lastyear = '<tr style="background: #c7c7c7"><td colspan="14">s.d Tahun ' . $last_year . '</td></tr>' . $list_lastyear;
            //end data lastyear


            //data thisyear
            $list_thisyear = '';
            $no = 1;
            if (!empty($data_thisyear)) {
                foreach ($data_thisyear as $dt) {
                    $luas_selisih =  $dt->luas_kavling - $dt->luas_terbit;


                    if ($dt->status_penjualan == 'belum proses') {
                        $tgl_proses = '-';
                    } else {
                        $tgl_proses = tgl_indo($dt->tgl_proses);
                    }

                    if ($dt->status_penjualan == 'terbit') {
                        $tgl_terbit = tgl_indo($dt->tgl_terbit);
                    } else {
                        $tgl_terbit = '-';
                    }

                    $list_thisyear .= '
                        <tr>
                            <td>' . $no++ . '</td>
                            <td>' . tgl_indo($dt->tgl_penjualan) . '</td>
                            <td>' . $dt->pembeli . '</td>
                            <td>' . $dt->type . '</td>
                            <td>' . $dt->blok . '</td>
                            <td>1</td>
                            <td>' . $dt->luas_kavling . '</td>
                            <td>' . $dt->luas_terbit . '</td>
                            <td>' . $luas_selisih . '</td>
                            <td>' . $tgl_proses . '</td>
                            <td>' . $tgl_terbit . '</td>
                            <td>' . $dt->no_shgb . '</td>
                            <td>' . tgl_indo($dt->masa_berlaku) . '</td>
                            <td>' . $dt->keterangan . '</td>
                        </tr>
                    ';
                }
            } else {
                $list_thisyear = '<tr><td colspan="14" style="text-align: center; color: #9c0808;">No data result</td></tr>';
            }
            $show_thisyear = '<tr style="background: #c7c7c7"><td colspan="14">Tahun ' . $this_year . '</td></tr>' . $list_thisyear;
            //end data thisyear



            $show_status = '<tr style="background: #f1f59f;"><td colspan="14"><b>' . $stat['title'] . '</b></td><tr>' . $show_lastyear . $show_thisyear;
            $data .= $show_status;
        }

        $test = '
                <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: Calibri;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                </head>
                <body>
                <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                <br>
                <span style="font-size: 18px"><b>DATA PENJUALAN BELUM TERBIT SPLITSING</b></span>
                <br>
                </br>
               
                <table border="1">
                    <tr style="background: #3032b0; color: white">
                        <th rowspan="2">#</th>
                        <th rowspan="2">Tgl. Jual</th>
                        <th rowspan="2">Nama</th>
                        <th rowspan="2">Type</th>
                        <th rowspan="2">Blok</th>
                        <th rowspan="2">Jml. Kavling</th>
                        <th colspan="3">Luas</th>
                        <th rowspan="2">Tgl. Proses</th>
                        <th rowspan="2">Tgl. Terbit</th>
                        <th rowspan="2">No. Sert</th>
                        <th rowspan="2">Masa SHGB</th>
                        <th rowspan="2">Ket</th>
                    </tr>
                     <tr>
                        <th>Daftar</th>
                        <th>Sert</th>
                        <th>Selisih</th>
                    </tr>
                    ' . $data . '
                </table>
                </body></html>
                ';


        $file = "9. PENJUALAN BELUM TERBIT SPLITSING.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$file\"");
        echo $test;
    }

    public function export_rekap_9()
    {
        $month = $this->model->get_month_data();
        $last_year = date('Y', strtotime('-1 year'));
        $this_year = date('Y');
        $proyek = $this->db->get('master_proyek')->result();

        $loop_month = '';
        foreach ($month as $mth) {
            $loop_month .= '<th>' . $mth['short'] . '</th>';
        }

        $data = '';
        $i = 1;
        foreach ($proyek as $p) {
            $jml_lastyear = $this->laporan->data_rekap_9(null, $last_year, null, null, null, $p->id)->num_rows();
            $jml_thisyear = $this->laporan->data_rekap_9($this_year, null, null, null, null, $p->id)->num_rows();
            $jml_evaluasi_belum = $this->laporan->data_rekap_9(null, null, 'belum proses', null, null, $p->id)->num_rows();
            $jml_evaluasi_proses = $this->laporan->data_rekap_9(null, null, 'proses', null, null, $p->id)->num_rows();
            $jml_ = $jml_lastyear + $jml_thisyear;

            $total_tbt_split = 0;
            $show_tbt_splitsing = '';
            foreach ($month as $bln) {
                $terbit_split = $this->laporan->data_rekap_9(null, null, 'terbit', $bln['val'], $this_year, $p->id)->num_rows();
                $total_tbt_split += $terbit_split;

                $show_tbt_splitsing .= '<td>' . $terbit_split . '</td>';
            }
            $sisa_hutang = $jml_ - $total_tbt_split;



            $data .= '
                <tr>
                    <td>' . $i++ . '</td>
                    <td>' . $p->nama_proyek . '</td>
                    <td>' . $jml_lastyear . '</td>
                    <td>' . $jml_thisyear . '</td>
                    <td>' . $jml_ . '</td>
                    ' . $show_tbt_splitsing . '
                    <td>' . $total_tbt_split . '</td>
                    <td>' . $sisa_hutang . '</td>
                    <td>' . $jml_evaluasi_belum . '</td>
                    <td>' . $jml_evaluasi_proses . '</td>
                </tr>
            ';
        }



        $test = '
                <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                <meta http-equiv=Content-Type content="text/html;
                charset=windows-1252">
                <meta name=ProgId content=Excel.Sheet>
                <meta name=Generator content="Microsoft Excel 11">
                <style>
                <!--table
                @page{}
                -->
                body{
                        font-family: Calibri;
                    }
                </style>
                <!--[if gte mso 9]><xml>
                <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
                <x:Name>Sheet1</x:Name>
                <x:WorksheetOptions><x:Panes>
                </x:Panes></x:WorksheetOptions>
                </x:ExcelWorksheet></x:ExcelWorksheets></
                x:ExcelWorkbook>
                </xml>
                <![endif]-->
                </head>
                <body>
                <span style="font-size: 18px"><b>PT. GUNUNG BATU UTAMA</b></span>
                <br>
                <span style="font-size: 18px"><b>REKAPITULASI DATA HUTANG SERTIFIKAT BELUM TERBIT SPLITSING</b></span>
                <br>
                </br>
               
                <table border="1">
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Proyek</th>
                                    <th colspan="3">Hutang Penjualan Belum Terbit Split</th>
                                    <th colspan="13">Terbit Split Tahun ' . $this_year . '</th>
                                    <th rowspan="2">Sisa Hutang</th>
                                    <th colspan="2">Evaluasi</th>
                                </tr>
                                <tr>
                                    <th>s.d Tahun ' . $last_year . '</th>
                                    <th>Tahun ' . $this_year . '</th>
                                    <th>Jumlah</th>

                                    ' . $loop_month . '
                                    <th>Total</th>
                                    <th>Proses</th>
                                    <th>Belum</th>
                                </tr>
                    ' . $data . '
                </table>
                </body></html>
                ';


        $file = "9. REKAPITULASI DATA HUTANG SERTIFIKAT BELUM TERBIT SPLITSING.xls";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$file\"");
        echo $test;
    }

    //end export no 9
}
