<?php
$month = $this->model->get_month_data();
$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
$proyek = $this->db->get('master_proyek')->result();
?>
<style>
    #table thead tr:nth-child(1) {
        background-color: #941230;
        color: white;
    }
</style>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Rekap Hutang Sertifikat Belum Split</h3>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">

                        <a href="<?= base_url('export/export_rekap_9') ?>" class="btn btn-sm btn-success my-1" target="_blank"><i class="far fa-file-excel"></i> Export Data</a>

                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Proyek</th>
                                    <th colspan="3">Hutang Penjualan Belum Terbit Split</th>
                                    <th colspan="13">Terbit Split Tahun <?= $this_year ?></th>
                                    <th rowspan="2">Sisa Hutang</th>
                                    <th colspan="2">Evaluasi</th>
                                </tr>
                                <tr>
                                    <th>s/d <?= $last_year ?></th>
                                    <th>Tahun <?= $this_year ?></th>
                                    <th>Jumlah</th>

                                    <?php foreach ($month as $mth) { ?>
                                        <th><?= $mth['short'] ?></th>
                                    <?php } ?>
                                    <th>Total</th>

                                    <th>Proses</th>
                                    <th>Belum</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<script>
    $('#table thead tr th').addClass('text-center text-nowrap')
</script>