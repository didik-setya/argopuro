<?php
$month = $this->model->get_month_data();
$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
?>
<style>
    #table thead tr:nth-child(2) {
        background-color: #decc64;
    }

    #table thead tr:nth-child(1) {
        background-color: #6b1173;
        color: white;
    }
</style>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3><?= $title ?></h3>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Perumahan</th>
                                    <th colspan="3">Order Marketing</th>
                                    <th colspan="13">Terbit Balik Nama Th. <?= $this_year ?></th>
                                    <th rowspan="2">Belum Terbit BN</th>
                                    <th colspan="4">Evaluasi Belum Terbit BN</th>
                                </tr>

                                <tr>
                                    <th>Sisa s/d <?= $last_year ?></th>
                                    <th>Tahun <?= $this_year ?></th>
                                    <th>Total</th>
                                    <?php foreach ($month as $mth) { ?>
                                        <th><?= $mth['short'] ?></th>
                                    <?php } ?>
                                    <th>Total</th>

                                    <th>Belum Proses</th>
                                    <th>Proses AJB</th>
                                    <th>Terbit AJB</th>
                                    <th>Proses BN</th>
                                </tr>
                            </thead>
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