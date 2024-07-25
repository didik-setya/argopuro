<?php
$f_year = $this->input->get('year');
$f_perum = $this->input->get('perum');
$month = $this->model->get_month_data();
$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
$data = $this->laporan->get_data_10($f_year, $f_perum)->result();
$data_proyek = $this->db->get('master_proyek')->result();


?>

<style>
    #main_table thead tr:nth-child(1) {
        background-color: #0d1273;
        color: white;
    }

    .bg-kuning {
        background-color: #ebe286;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Evaluasi Stok Kavling Splitsing</h3>
            </div>

            <div class="col-12">

                <button class="btn btn-sm btn-dark" onclick="filter_data()"><i class="fa fa-filter"></i> Filter</button>


                <div class="card mt-3">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered" id="main_table">
                            <thead>
                                <tr>
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
                                <?php $i = 1;
                                foreach ($data as $d) { ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d->nama_proyek ?></td>
                                        <td><?= $d->blok ?></td>
                                        <td>1</td>

                                        <td></td>
                                        <td></td>
                                        <td></td>

                                        <td><?= $d->shgb_induk ?></td>
                                        <td><?= $d->shgb_blok ?></td>
                                        <td><?= tgl_indo($d->tgl_daftar) ?></td>
                                        <td><?= tgl_indo($d->tgl_terbit) ?></td>
                                        <td><?= tgl_indo($d->masa_berlaku) ?></td>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Modal -->
<div class="modal" id="modalFilter" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-light">
                <h5 class="modal-title" id="exampleModalLabel">Filter Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-light" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="get" id="form_filter">
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Tahun</b></label>
                        <select name="year" id="year" class="form-control">
                            <option value="">--pilih--</option>
                            <?php $now_year = date('Y');
                            for ($a = 1990; $a <= $now_year; $a++) {
                            ?>
                                <?php if ($f_year == $a) { ?>
                                    <option selected value="<?= $a ?>"><?= $a ?></option>
                                <?php } else { ?>
                                    <option value="<?= $a ?>"><?= $a ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Proyek</label>
                        <select name="perum" id="perum" class="form-control">
                            <option value="">--pilih--</option>
                            <?php foreach ($data_proyek as $d) { ?>
                                <?php if ($f_perum == $d->id) { ?>
                                    <option selected value="<?= $d->id ?>"><?= $d->nama_proyek ?></option>
                                <?php } else { ?>
                                    <option value="<?= $d->id ?>"><?= $d->nama_proyek ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Go</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#main_table thead tr th').addClass('text-center text-nowrap')
    $('#main_table').dataTable({
        ordering: false,
        // scrollX: true
    })

    $('#form_filter').submit(function(e) {
        // e.preventDefault()
        loading_animation()
    })

    function filter_data() {
        $('#modalFilter').modal('show')
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