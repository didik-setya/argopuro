<?php
$tipe_splitsing = $this->config->item('type_splitsing');
$data_stok = $this->laporan->get_data_stok()->result();
$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');


$data_splitsing = $this->laporan->get_detail_data_splitsing('sp')->result();
$data_jalan_fasos = $this->laporan->get_detail_data_splitsing('jf')->result();
$data_sisa_induk = $this->laporan->get_detail_data_splitsing('si')->result();
?>
<style>
    #main_table thead tr:nth-child(1) {
        background: #073887;
        color: white;
    }

    #table_detail thead tr:nth-child(1) {
        background-color: #0d1273;
        color: white;
    }

    .bg-kuning {
        background-color: #fcec97;
    }
</style>


<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3>Evaluasi Stok Kavling Splitsing</h3>
                <button class="btn btn-sm btn-success mb-3" onclick="add_data()"><i class="fa fa-plus"></i> Tambah Splitsing</button>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Splitsing</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Jalan & Fasos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="abs" data-toggle="tab" data-target="#abs-c" type="button" role="tab" aria-controls="abs-c" aria-selected="false">Sisa Splitsing</button>
                    </li>

                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-responsive main-table1" id="table_detail">
                                    <thead>
                                        <tr>
                                            <th rowspan="4"><i class="fa fa-cogs"></i></th>
                                            <th rowspan="4">#</th>
                                            <th rowspan="4">Perumahan</th>
                                            <th rowspan="4">Blok</th>
                                            <th rowspan="4">Jml Kvl</th>

                                            <th colspan="3">L. Tanah</th>

                                            <th rowspan="4">No. Induk</th>
                                            <th rowspan="4">No. Sert</th>
                                            <th rowspan="4">Tgl. Daftar</th>
                                            <th rowspan="4">Tgl. Terbit</th>
                                            <th rowspan="4">Batas Waktu HGB</th>

                                            <th colspan="6">Belum Terbit Split</th>
                                            <th colspan="6">Terbit Stok</th>

                                            <th colspan="12">Penjualan <?= $this_year ?></th>
                                            <th rowspan="4">Ket</th>
                                        </tr>

                                        <tr>
                                            <th rowspan="3" class="bg-secondary">Technic</th>
                                            <th rowspan="3" class="bg-secondary">Sert</th>
                                            <th rowspan="3" class="bg-secondary">Selisih</th>

                                            <th colspan="2" class="bg-kuning">Belum Proses</th>
                                            <th colspan="2" class="bg-kuning">Proses</th>
                                            <th colspan="2" class="bg-kuning">Total</th>

                                            <th colspan="2" class="bg-kuning">s/d Tahun <?= $last_year ?></th>
                                            <th colspan="2" class="bg-kuning">Tahun <?= $this_year ?></th>
                                            <th colspan="2" class="bg-kuning">Total</th>

                                            <th colspan="6" class="bg-info">Stock</th>
                                            <th colspan="6" class="bg-info">Belum Terbit Split</th>
                                        </tr>

                                        <tr>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>

                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>

                                            <th colspan="2" class="bg-kuning">s/d Tahun <?= $last_year ?></th>
                                            <th colspan="2" class="bg-kuning">Tahun <?= $this_year ?></th>
                                            <th colspan="2" class="bg-kuning">Total</th>

                                            <th colspan="2" class="bg-kuning">Belum Proses</th>
                                            <th colspan="2" class="bg-kuning">Proses</th>
                                            <th colspan="2" class="bg-kuning">Total</th>
                                        </tr>

                                        <tr>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>

                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
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

                                                if ($tgl_terbit_split >= $this_year) {
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
                                        ?>
                                            <tr>
                                                <!-- 37 column -->
                                                <td>
                                                    <?php if ($ds->data_locked == 0) { ?>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-outline-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-cogs"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" onclick="key_data('<?= $ds->id_splitsing ?>',1)" href="#"><i class="fas fa-lock"></i> Lock Data</a>
                                                                <a class="dropdown-item" onclick="delete_split('<?= $ds->id_sub_splitsing ?>')" href="#"><i class="far fa-trash-alt"></i> Hapus Data</a>
                                                            </div>
                                                        </div>
                                                    <?php } else if ($ds->data_locked == 1) { ?>
                                                        <button class="btn btn-sm btn-secondary" onclick="key_data('<?= $ds->id_splitsing ?>', 2)" data-toggle="tooltip" data-placement="top" data-original-title="Unlock Data" title><i class="fas fa-lock-open"></i></button>
                                                    <?php } ?>
                                                </td>

                                                <td><?= $no++ ?></td>
                                                <td><?= $ds->nama_proyek ?></td>
                                                <td><?= $ds->blok ?></td>
                                                <td>1</td>
                                                <td><?= $l_teknik ?></td>
                                                <td><?= $l_terbit ?></td>
                                                <td><?= $l_selisih ?></td>
                                                <td><?= $ds->no_induk ?></td>
                                                <td><?= $ds->no_shgb ?></td>
                                                <td><?= $tgl_daftar ?></td>
                                                <td><?= $tgl_terbit ?></td>
                                                <td><?= $batas_hgb ?></td>
                                                <?= $belum_terbit_split . $terbit_stok  ?>
                                                <?php for ($i = 0; $i < 12; $i++) {
                                                    echo '<td></td>';
                                                } ?>
                                                <td><?= $ds->keterangan ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                        <div class="card">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-responsive main-table2" id="table_detail">
                                    <thead>
                                        <tr>
                                            <th rowspan="4"><i class="fa fa-cogs"></i></th>
                                            <th rowspan="4">#</th>
                                            <th rowspan="4">Perumahan</th>
                                            <th rowspan="4">Blok</th>
                                            <th rowspan="4">Jml Kvl</th>

                                            <th colspan="3">L. Tanah</th>

                                            <th rowspan="4">No. Induk</th>
                                            <th rowspan="4">No. Sert</th>
                                            <th rowspan="4">Tgl. Daftar</th>
                                            <th rowspan="4">Tgl. Terbit</th>
                                            <th rowspan="4">Batas Waktu HGB</th>

                                            <th colspan="6">Belum Terbit Split</th>
                                            <th colspan="6">Terbit Stok</th>

                                            <th colspan="12">Penjualan <?= $this_year ?></th>
                                            <th rowspan="4">Ket</th>
                                        </tr>

                                        <tr>
                                            <th rowspan="3" class="bg-secondary">Technic</th>
                                            <th rowspan="3" class="bg-secondary">Sert</th>
                                            <th rowspan="3" class="bg-secondary">Selisih</th>

                                            <th colspan="2" class="bg-kuning">Belum Proses</th>
                                            <th colspan="2" class="bg-kuning">Proses</th>
                                            <th colspan="2" class="bg-kuning">Total</th>

                                            <th colspan="2" class="bg-kuning">s/d Tahun <?= $last_year ?></th>
                                            <th colspan="2" class="bg-kuning">Tahun <?= $this_year ?></th>
                                            <th colspan="2" class="bg-kuning">Total</th>

                                            <th colspan="6" class="bg-info">Stock</th>
                                            <th colspan="6" class="bg-info">Belum Terbit Split</th>
                                        </tr>

                                        <tr>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>

                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>

                                            <th colspan="2" class="bg-kuning">s/d Tahun <?= $last_year ?></th>
                                            <th colspan="2" class="bg-kuning">Tahun <?= $this_year ?></th>
                                            <th colspan="2" class="bg-kuning">Total</th>

                                            <th colspan="2" class="bg-kuning">Belum Proses</th>
                                            <th colspan="2" class="bg-kuning">Proses</th>
                                            <th colspan="2" class="bg-kuning">Total</th>
                                        </tr>

                                        <tr>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>

                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($data_jalan_fasos as $ds) {
                                            $l_teknik = $ds->luas_daftar;
                                            $l_terbit = $ds->luas_terbit;
                                            $l_selisih = $l_teknik - $l_terbit;
                                            $tgl_daftar = tgl_indo($ds->tgl_daftar);
                                            $tgl_terbit = tgl_indo($ds->tgl_terbit);
                                            $batas_hgb = tgl_indo($ds->masa_berlaku);

                                            if ($ds->status == 'terbit') {
                                                $get_tgl_terbit_split = date_create($ds->tgl_terbit);
                                                $tgl_terbit_split = date_format($get_tgl_terbit_split, 'Y');

                                                if ($tgl_terbit_split >= $this_year) {
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
                                        ?>
                                            <tr>
                                                <!-- 37 column -->
                                                <td>
                                                    <?php if ($ds->data_locked == 0) { ?>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-outline-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-cogs"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" onclick="key_data('<?= $ds->id_splitsing ?>',1)" href="#"><i class="fas fa-lock"></i> Lock Data</a>
                                                                <a class="dropdown-item" onclick="delete_split('<?= $ds->id_sub_splitsing ?>')" href="#"><i class="far fa-trash-alt"></i> Hapus Data</a>
                                                            </div>
                                                        </div>
                                                    <?php } else if ($ds->data_locked == 1) { ?>
                                                        <button class="btn btn-sm btn-secondary" onclick="key_data('<?= $ds->id_splitsing ?>', 2)" data-toggle="tooltip" data-placement="top" data-original-title="Unlock Data" title><i class="fas fa-lock-open"></i></button>
                                                    <?php } ?>
                                                </td>

                                                <td><?= $no++ ?></td>
                                                <td><?= $ds->nama_proyek ?></td>
                                                <td><?= $ds->blok ?></td>
                                                <td>1</td>
                                                <td><?= $l_teknik ?></td>
                                                <td><?= $l_terbit ?></td>
                                                <td><?= $l_selisih ?></td>
                                                <td><?= $ds->no_induk ?></td>
                                                <td><?= $ds->no_shgb ?></td>
                                                <td><?= $tgl_daftar ?></td>
                                                <td><?= $tgl_terbit ?></td>
                                                <td><?= $batas_hgb ?></td>
                                                <?= $belum_terbit_split . $terbit_stok  ?>
                                                <?php for ($i = 0; $i < 12; $i++) {
                                                    echo '<td></td>';
                                                } ?>
                                                <td><?= $ds->keterangan ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="abs-c" role="tabpanel" aria-labelledby="abs">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-responsive main-table3" id="table_detail">
                                    <thead>
                                        <tr>
                                            <th rowspan="4"><i class="fa fa-cogs"></i></th>
                                            <th rowspan="4">#</th>
                                            <th rowspan="4">Perumahan</th>
                                            <th rowspan="4">Blok</th>
                                            <th rowspan="4">Jml Kvl</th>

                                            <th colspan="3">L. Tanah</th>

                                            <th rowspan="4">No. Induk</th>
                                            <th rowspan="4">No. Sert</th>
                                            <th rowspan="4">Tgl. Daftar</th>
                                            <th rowspan="4">Tgl. Terbit</th>
                                            <th rowspan="4">Batas Waktu HGB</th>

                                            <th colspan="6">Belum Terbit Split</th>
                                            <th colspan="6">Terbit Stok</th>

                                            <th colspan="12">Penjualan <?= $this_year ?></th>
                                            <th rowspan="4">Ket</th>
                                        </tr>

                                        <tr>
                                            <th rowspan="3" class="bg-secondary">Technic</th>
                                            <th rowspan="3" class="bg-secondary">Sert</th>
                                            <th rowspan="3" class="bg-secondary">Selisih</th>

                                            <th colspan="2" class="bg-kuning">Belum Proses</th>
                                            <th colspan="2" class="bg-kuning">Proses</th>
                                            <th colspan="2" class="bg-kuning">Total</th>

                                            <th colspan="2" class="bg-kuning">s/d Tahun <?= $last_year ?></th>
                                            <th colspan="2" class="bg-kuning">Tahun <?= $this_year ?></th>
                                            <th colspan="2" class="bg-kuning">Total</th>

                                            <th colspan="6" class="bg-info">Stock</th>
                                            <th colspan="6" class="bg-info">Belum Terbit Split</th>
                                        </tr>

                                        <tr>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>

                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>
                                            <th rowspan="2" class="bg-secondary">Kav</th>
                                            <th rowspan="2" class="bg-secondary">Sert</th>

                                            <th colspan="2" class="bg-kuning">s/d Tahun <?= $last_year ?></th>
                                            <th colspan="2" class="bg-kuning">Tahun <?= $this_year ?></th>
                                            <th colspan="2" class="bg-kuning">Total</th>

                                            <th colspan="2" class="bg-kuning">Belum Proses</th>
                                            <th colspan="2" class="bg-kuning">Proses</th>
                                            <th colspan="2" class="bg-kuning">Total</th>
                                        </tr>

                                        <tr>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>

                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>
                                            <th class="bg-secondary">Kav</th>
                                            <th class="bg-secondary">Sert</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($data_jalan_fasos as $ds) {
                                            $l_teknik = $ds->luas_daftar;
                                            $l_terbit = $ds->luas_terbit;
                                            $l_selisih = $l_teknik - $l_terbit;
                                            $tgl_daftar = tgl_indo($ds->tgl_daftar);
                                            $tgl_terbit = tgl_indo($ds->tgl_terbit);
                                            $batas_hgb = tgl_indo($ds->masa_berlaku);

                                            if ($ds->status == 'terbit') {
                                                $get_tgl_terbit_split = date_create($ds->tgl_terbit);
                                                $tgl_terbit_split = date_format($get_tgl_terbit_split, 'Y');

                                                if ($tgl_terbit_split >= $this_year) {
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
                                        ?>
                                            <tr>
                                                <!-- 37 column -->
                                                <td>
                                                    <?php if ($ds->data_locked == 0) { ?>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-outline-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-cogs"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" onclick="key_data('<?= $ds->id_splitsing ?>',1)" href="#"><i class="fas fa-lock"></i> Lock Data</a>
                                                                <a class="dropdown-item" onclick="delete_split('<?= $ds->id_sub_splitsing ?>')" href="#"><i class="far fa-trash-alt"></i> Hapus Data</a>
                                                            </div>
                                                        </div>
                                                    <?php } else if ($ds->data_locked == 1) { ?>
                                                        <button class="btn btn-sm btn-secondary" onclick="key_data('<?= $ds->id_splitsing ?>', 2)" data-toggle="tooltip" data-placement="top" data-original-title="Unlock Data" title><i class="fas fa-lock-open"></i></button>
                                                    <?php } ?>
                                                </td>

                                                <td><?= $no++ ?></td>
                                                <td><?= $ds->nama_proyek ?></td>
                                                <td><?= $ds->blok ?></td>
                                                <td>1</td>
                                                <td><?= $l_teknik ?></td>
                                                <td><?= $l_terbit ?></td>
                                                <td><?= $l_selisih ?></td>
                                                <td><?= $ds->no_induk ?></td>
                                                <td><?= $ds->no_shgb ?></td>
                                                <td><?= $tgl_daftar ?></td>
                                                <td><?= $tgl_terbit ?></td>
                                                <td><?= $batas_hgb ?></td>
                                                <?= $belum_terbit_split . $terbit_stok  ?>
                                                <?php for ($i = 0; $i < 12; $i++) {
                                                    echo '<td></td>';
                                                } ?>
                                                <td><?= $ds->keterangan ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>


<!-- Modal -->
<div class="modal" id="modalMain" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <form action="<?= base_url('ajax_laporan/act_splitsing_10') ?>" class="form_act" method="post" data-act="add">
            <input type="hidden" name="act" class="act" value="add">
            <div class="modal-content modal-fullscreen">
                <div class="modal-header bg-dark text-light">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label><b>Proyek</b></label>
                                <select name="induk" id="select_induk" required class="form-control">
                                    <option value="">--pilih proyek--</option>
                                    <?php foreach ($induk as $i) { ?>
                                        <option value="<?= $i->id ?>"><?= $i->nama_proyek ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 ">

                            <table class="table table-sm table-bordered by-2 w-100" id="table_form">
                                <thead>
                                    <tr class="bg-primary text-light">
                                        <th style="width: 5%;">#</th>
                                        <th>Blok</th>
                                        <th>Luas</th>
                                        <th>Tipe</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="add_new_form_split('add')"><i class="fa fa-plus"></i> Form Splitsing</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <form action="<?= base_url('ajax_laporan/act_splitsing_10') ?>" class="form_act" method="post" data-act="edit">
            <input type="hidden" name="act" class="act" value="edit">
            <input type="hidden" name="id" id="id_act">

            <div class="modal-content modal-fullscreen">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-light" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label><b>Induk</b></label>
                                <input type="text" name="induk" id="induk_edit" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label><b>Luas</b></label>
                                <input type="text" name="luas" id="luas_induk_edit" readonly class="form-control">
                            </div>
                        </div>

                        <div class="col-12">
                            <table class="table table-sm table-bordered by-2 w-100" id="table_form_edit">
                                <thead>
                                    <tr class="bg-primary text-light">
                                        <th style="width: 5%;">#</th>
                                        <th>Blok</th>
                                        <th>Luas</th>
                                        <th>Tipe</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="add_new_form_split('edit')"><i class="fa fa-plus"></i> Form Splitsing</button>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
    let form_splitsing = '<tr><td class="text-center"><button data-toggle="tooltip" data-placement="top" title="Hapus Data" class="btn btn-sm btn-danger delete_form"><i class="fas fa-times-circle"></i></button></td><td><input type="text" name="blok[]" id="blok" required class="form-control" placeholder="Nama blok..."></td><td><input type="number" class="form-control" name="luas_blok[]" id="luas_blok"></td><td><input type="hidden" name="type[]" value="sp"> Splitsing </td></tr>'




    $(document).ready(function() {
        let select = document.getElementById('select_induk');
        select.addEventListener('change', function() {
            let selectedOpt = select.options[select.selectedIndex]
            let luas = selectedOpt.getAttribute('data-terbit');
            $('#luas_induk').val(luas);
            $('#table_splitsing tbody').html('')
        })

        $('#main_table thead tr th').addClass('text-center text-nowrap')
        $('#table_detail thead tr th').addClass('text-center text-nowrap')
        $('#main_table').dataTable({
            ordering: false,
        })


    })

    $(document).on('click', '.delete_form', function() {
        $(this).parent('td').parent('tr').remove();
    })

    function add_data() {
        $('#modalMain').modal('show')
        $('#modalMain .modal-title').html('Tambah Data')

        $('#select_induk').val('')
        $('#luas_induk').val('')
        $('#table_form tbody').html('')
    }

    function edit_data(id) {
        loading_animation()
        $('#modalEdit .modal-title').html('Edit Data')

        $('#id_act').val(id)
        $('#induk_edit').val('')
        $('#luas_induk_edit').val('')
        $('#table_form_edit tbody').html('')
        get_data_for_edit(id)
    }

    function add_new_form_split(from_table) {
        let induk = $('#select_induk').val()
        let induk_edit = $('#induk_edit').val();

        if (from_table == 'add') {
            if (induk) {
                $('#table_form tbody').append(form_splitsing)
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Pilih proyek terlebih dahulu',
                })
            }
        } else if (from_table == 'edit') {
            if (induk_edit) {
                $('#table_form_edit tbody').append(form_splitsing)
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Pilih proyek terlebih dahulu',
                })
            }
        }
    }

    function add_new_form_jf(from_table) {
        let induk = $('#select_induk').val()
        let induk_edit = $('#induk_edit').val();

        if (from_table == 'add') {
            if (induk) {
                $('#table_form tbody').append(form_jf)
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Pilih proyek terlebih dahulu',
                })
            }
        } else if (from_table == 'edit') {
            if (induk_edit) {
                $('#table_form_edit tbody').append(form_jf)
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Pilih proyek terlebih dahulu',
                })
            }
        }
    }

    function add_new_form_si(from_table) {
        let induk = $('#select_induk').val()
        let induk_edit = $('#induk_edit').val();

        if (from_table == 'add') {
            if (induk) {
                $('#table_form tbody').append(form_si)
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Pilih proyek terlebih dahulu',
                })
            }
        } else if (from_table == 'edit') {
            if (induk_edit) {
                $('#table_form_edit tbody').append(form_si)
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Pilih proyek terlebih dahulu',
                })
            }
        }
    }

    function get_data_for_edit(id) {
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_splitsing_10') ?>',
            data: {
                id: id,
                act: 'get_data_edit'
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                setTimeout(() => {
                    Swal.close();
                    $('#modalEdit').modal('show')
                    $('#induk_edit').val(d.data.no_terbit_shgb)
                    $('#luas_induk_edit').val(d.data.luas_induk)

                    let data_split = d.splitsing
                    let show_split = ''
                    let i
                    for (i = 0; i < data_split.length; i++) {
                        let tipe = data_split[i].tipe;
                        let show_tipe = ''

                        if (tipe == 'jf') {
                            show_tipe = 'Jalan & Fasos'
                        } else if (tipe == 'sp') {
                            show_tipe = 'Splitsing'
                        } else {
                            show_tipe = 'Unknow'
                        }

                        show_split += '<tr><td class="text-center"><button data-toggle="tooltip" data-placement="top" title="Hapus Data" class="btn btn-sm btn-warning delete_split" type="button" data-id="' + data_split[i].id + '"><i class="fas fa-trash-alt"></i></button> <input type="hidden" name="id_splitsing[]" value="' + data_split[i].id + '"> </td><td><input type="text" name="blok_edit[]" id="blok" required class="form-control" placeholder="Nama blok..." value="' + data_split[i].blok + '"></td><td><input type="number" class="form-control" name="luas_blok_edit[]" id="luas_blok" value="' + data_split[i].luas_daftar + '"></td><td><input type="hidden" name="type_blok_edit[]" value="' + tipe + '"> ' + show_tipe + '</td></tr>';
                        // type_blok_edit
                    }
                    $('#table_form_edit tbody').html(show_split)



                }, 200);
            },
            error: function(xhr, status, error) {
                setTimeout(() => {
                    Swal.close()
                    error_alert(error)
                }, 200);
            }
        })
    }


    $(document).on('click', '.delete_split', function() {
        let id = $(this).data('id')
        Swal.fire({
            icon: 'warning',
            title: "Apakah anda yakin?",
            text: "Data akan di hapus secara permanen",
            showCancelButton: true,
            confirmButtonText: "Yes",
            allowOutsideClick: false,

        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                delete_split(id)
            }
        });
    })

    function delete_split(id) {

        Swal.fire({
            icon: 'warning',
            title: "Apakah anda yakin?",
            text: "Data akan di hapus secara permanen",
            showCancelButton: true,
            confirmButtonText: "Yes",
            allowOutsideClick: false,
        }).then((res) => {
            loading_animation()
            $.ajax({
                url: '<?= base_url('ajax_laporan/act_splitsing_10') ?>',
                data: {
                    id: id,
                    act: 'delete_split'
                },
                type: 'POST',
                dataType: 'JSON',
                success: function(d) {
                    setTimeout(() => {
                        Swal.close()
                        if (d.status == false) {
                            error_alert(d.msg)
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: d.msg
                            }).then((res) => {
                                window.location.reload()
                            })
                        }
                    }, 200);
                },
                error: function(xhr, status, error) {
                    setTimeout(() => {
                        Swal.close()
                        error_alert(error)
                    }, 200);
                }
            })
        })


    }

    function detail_data(id) {
        $('#table_detail tbody').html('')
        $('#modalDetail').modal('show')
        loading_animation();
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_splitsing_10') ?>',
            data: {
                id: id,
                act: 'get_data_detail'
            },
            type: 'POST',
            dataType: 'text',
            success: function(d) {
                setTimeout(() => {
                    Swal.close()
                    $('#table_detail tbody').html(d)
                }, 200);
            },
            error: function(xhr, status, error) {
                setTimeout(() => {
                    Swal.close()
                    error_alert(error)
                }, 200);
            }
        })
    }

    function key_data(id, type) {
        loading_animation()
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_splitsing_10') ?>',
            data: {
                id: id,
                type: type,
                act: 'key_data'
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                setTimeout(() => {
                    Swal.close()
                    if (d.status == false) {
                        error_alert(d.msg)
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg
                        }).then((res) => {
                            window.location.reload()
                        })
                    }
                }, 200);
            },
            error: function(xhr, status, error) {
                setTimeout(() => {
                    Swal.close()
                    error_alert(error)
                }, 200);
            }
        })
    }

    function delete_data(id) {
        Swal.fire({
            icon: 'warning',
            title: "Apakah anda yakin?",
            text: "Data akan di hapus secara permanen",
            showCancelButton: true,
            confirmButtonText: "Yes",
            allowOutsideClick: false,

        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                loading_animation()
                $.ajax({
                    url: '<?= base_url('ajax_laporan/act_splitsing_10') ?>',
                    data: {
                        id: id,
                        act: 'delete_data'
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d) {
                        setTimeout(() => {
                            Swal.close()
                            if (d.status == false) {
                                error_alert(d.msg)
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: d.msg
                                }).then((res) => {
                                    window.location.reload()
                                })
                            }
                        }, 200);
                    },
                    error: function(xhr, status, error) {
                        setTimeout(() => {
                            Swal.close()
                            error_alert(error)
                        }, 200);
                    }
                })
            }
        });
    }



    $('.form_act').submit(function(e) {
        e.preventDefault()
        let act = $(this).data('act')

        let form_blok = $('#table_form tbody').html()
        let form_blok_edit = $('#table_form_edit tbody').html()

        if (act == 'add' && form_blok == '' || act == 'edit' && form_blok_edit == '') {
            error_alert('Harap isi splitsing')
        } else {
            loading_animation()

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function(d) {
                    setTimeout(() => {
                        Swal.close();
                        if (d.status == false) {
                            error_alert(d.msg)
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: d.msg
                            }).then((res) => {
                                window.location.reload()
                            })
                        }
                    }, 200);
                },
                error: function(xhr, status, error) {
                    setTimeout(() => {
                        Swal.close()
                        error_alert(error)
                    }, 200);
                }
            })
        }

    })



    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }

    function loading_animation() {
        Swal.fire({
            title: "Loading",
            html: "Please wait...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    }
</script>