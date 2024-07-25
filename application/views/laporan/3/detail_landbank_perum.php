<?php
$satuan_pengalihan_hak = $data->total_harga_pengalihan /  $data->luas_surat;

$total_lain = $data->biaya_lain_pematangan + $data->biaya_lain_rugi + $data->biaya_lain_pbb + $data->biaya_lain;

$total_all = $total_lain + $data->total_harga_pengalihan + $data->harga_jual_makelar;

$harga_per_meter = $total_all / $data->luas_ukur;
?>
<table class="table table-bordered table-sm table-striped">
    <tr>
        <th>Lokasi</th>
        <td><?= $data->nama_proyek ?></td>
    </tr>
    <tr>
        <th>Tanggal Pembelian</th>
        <td><?php cek_tgl($data->tgl_pembelian) ?></td>
    </tr>
    <tr>
        <th>Nama Penjual</th>
        <td><?= $data->nama_penjual ?></td>
    </tr>
    <tr>
        <th>No. Gambar</th>
        <td><?= $data->nomor_gambar ?></td>
    </tr>

    <tr>
        <th>Luas Surat</th>
        <td><?= $data->luas_surat ?></td>
    </tr>
    <tr>
        <th>Luas Ukur</th>
        <td><?= $data->luas_ukur ?></td>
    </tr>

    <tr>
        <th>No. PBB</th>
        <td><?= $data->nomor_pbb ?></td>
    </tr>
    <tr>
        <th>Atas Nama PBB</th>
        <td><?= $data->atas_nama_pbb ?></td>
    </tr>
    <tr>
        <th>Luas Bangunan PBB</th>
        <td><?= $data->luas_bangunan_pbb ?></td>
    </tr>
    <tr>
        <th>NJOP Bangunan</th>
        <td><?= $data->njop_bangunan ?></td>
    </tr>
    <tr>
        <th>Luas Bumi</th>
        <td><?= $data->luas_bumi_pbb ?></td>
    </tr>
    <tr>
        <th>NJOP Bumi</th>
        <td><?= $data->njop_bumi_pbb ?></td>
    </tr>


    <tr>
        <th>Total Harga Pengalihan</th>
        <td>Rp. <?= number_format($data->total_harga_pengalihan) ?></td>
    </tr>
    <tr>
        <th>Satuan Harga Pengalihan</th>
        <td>Rp. <?= number_format($satuan_pengalihan_hak) ?></td>
    </tr>


    <tr>
        <th>Nama Makelar</th>
        <td><?= $data->nama_makelar ?></td>
    </tr>
    <tr>
        <th>Nilai</th>
        <td>Rp. <?= number_format($data->harga_jual_makelar) ?></td>
    </tr>

    <tr>
        <th>Status Pengalihan</th>
        <td><?= $data->status_pengalihan ?></td>
    </tr>
    <tr>
        <th>Jenis Pengalihan</th>
        <td><?= $data->nama_pengalihan ?></td>
    </tr>
    <tr>
        <th>Tanggal Akte Pengalihan</th>
        <td><?php cek_tgl($data->tgl_akta_pengalihan) ?></td>
    </tr>
    <tr>
        <th>Akte Pengalihan </th>
        <td><?= $data->no_akta_pengalihan ?></td>
    </tr>
    <tr>
        <th>Atas Nama Pengalihan</th>
        <td><?= $data->atas_nama_pengalihan ?></td>
    </tr>

    <tr>
        <th>Biaya Pematangan</th>
        <td>Rp. <?= number_format($data->biaya_lain_pematangan) ?></td>
    </tr>
    <tr>
        <th>Biaya Ganti Rugi</th>
        <td>Rp. <?= number_format($data->biaya_lain_rugi) ?></td>
    </tr>
    <tr>
        <th>Biaya PBB</th>
        <td>Rp. <?= number_format($data->biaya_lain_pbb) ?></td>
    </tr>
    <tr>
        <th>Lain-lain</th>
        <td>Rp. <?= number_format($data->biaya_lain) ?></td>
    </tr>
    <tr>
        <th>Total Biaya Lain-lain</th>
        <td>Rp. <?= number_format($total_lain) ?></td>
    </tr>
    <tr>
        <th>Ket Lain-lain</th>
        <td><?= $data->ket_lain ?></td>
    </tr>

    <tr>
        <th>Total Harga</th>
        <td>Rp. <?= number_format($total_all) ?></td>
    </tr>
    <tr>
        <th>Harga / m<sup>2</sup></th>
        <td>Rp. <?= number_format($harga_per_meter) ?></td>
    </tr>
    <tr>
        <th>Status Teknik</th>
        <td><?= $data->status_teknik ?></td>
    </tr>
    <tr>
        <th>Ket</th>
        <td><?= $data->ket ?></td>
    </tr>


</table>