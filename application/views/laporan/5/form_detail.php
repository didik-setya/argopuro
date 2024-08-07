<?php
$luas_terbit = 0;
$luas_surat = $data->luas_surat;
$luas_terbit = $data->luas_terbit;

$luas_selisih = $luas_terbit - $luas_surat;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <table class="table table-bordered table-sm table-striped">
                <div class="row">
                    <tr>
                        <th>Nomor Gambar</th>
                        <td><?= $data->no_gambar ?></td>
                    </tr>

                    <tr>
                        <th>Luas Daftar</th>
                        <td><?= $data->luas_surat ?></td>
                    </tr>
                    <tr>
                        <th>Luas Terbit</th>
                        <td><?= $luas_terbit ?></td>
                    </tr>
                    <tr>
                        <th>Luas Selisih</th>
                        <td><?= $luas_selisih ?></td>
                    </tr>

                    <tr>
                        <th>Daftar Ukur</th>
                        <td><?= tgl_indo($data->tgl_ukur) ?></td>
                    </tr>

                    <tr>
                        <th>No. Ukur</th>
                        <td><?= $data->no_ukur ?></td>
                    </tr>

                    <tr>
                        <th>Tanggal Daftar SK Hak</th>
                        <td><?= tgl_indo($data->tgl_daftar_sk_hak) ?></td>
                    </tr>
                    <tr>
                        <th>Nomor Berkas SK Hak</th>
                        <td><?= $data->no_daftar_sk_hak ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Terbit SK Hak</th>
                        <td><?= tgl_indo($data->tgl_terbit_sk_hak) ?></td>
                    </tr>
                    <tr>
                        <th>Nomor Terbit SK Hak</th>
                        <td><?= $data->no_terbit_sk_hak ?></td>
                    </tr>
                </div>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-bordered table-sm table-striped">
                <div class="row">
                    <tr>
                        <th>Tanggal Daftar SHGB</th>
                        <td><?= $data->tgl_daftar_shgb ?></td>
                    </tr>
                    <tr>
                        <th>Nomor Berkas Daftar SHGB</th>
                        <td><?= $data->no_daftar_shgb ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Terbit SHGB</th>
                        <td><?= tgl_indo($data->tgl_terbit_shgb) ?></td>
                    </tr>
                    <tr>
                        <th>Nomor Terbit SHGB</th>
                        <td><?= $data->no_terbit_shgb ?></td>
                    </tr>
                    <tr>
                        <th>Masa Berlaku SHGB</th>
                        <td><?= tgl_indo($data->masa_berlaku_shgb) ?></td>
                    </tr>
                    <tr>
                        <th>Target Penyelesaian</th>
                        <td><?= tgl_indo($data->target_penyelesaian) ?></td>
                    </tr>
                    <tr>
                        <th>Status Proses Induk</th>
                        <td><?= $data->status_induk ?></td>
                    </tr>
                    <tr>
                        <th>Status Tanah</th>
                        <td><?php
                            if ($data->status_tanah == 'ip_proyek') {
                                echo 'IP Proyek';
                            } else if ($data->status_tanah == 'tanah_proyek') {
                                echo 'Tanah Proyek';
                            } else {
                                echo '-';
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td><?= $data->ket_induk ?></td>
                    </tr>
                </div>
            </table>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <h6 class="card-title">Rincian</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped">
                    <thead>
                        <tr class="bg-dark text-light">
                            <th>Lokasi</th>
                            <th>Nama Penjual</th>
                            <th>Luas Surat</th>
                            <th>Keterangan Sub</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sub as $s) { ?>
                            <tr>
                                <td><?= $s->nama_proyek . '(' . $s->nama_status . ')' ?></td>
                                <td><?= $s->nama_penjual ?></td>
                                <td><?= $s->luas_surat ?></td>
                                <td><?= $s->ket_sub ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>