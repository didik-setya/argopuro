<?php
$month = $this->model->get_month_data();
$last_year = date('Y', strtotime('-1 year'));
$scd_last_year = date('Y', strtotime('-2 year'));
$this_year = date('Y');
?>
<style>
    #table thead tr:nth-child(2) {
        background-color: #decc64;
    }

    #table thead tr:nth-child(1) {
        background-color: #ba236a;
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
                                    <th rowspan="2">Proyek</th>

                                    <th colspan="2">Jumlah</th>
                                    <th colspan="2">Luas</th>
                                    <th colspan="3">Pembayaran Tahun <?= $last_year ?></th>
                                    <th colspan="3">Tagihan Tahun <?= $this_year ?></th>
                                    <th colspan="2">Pembayaran Tahun <?= $this_year ?></th>

                                    <th rowspan="2">Ket</th>
                                </tr>
                                <tr>
                                    <th>Bid/Kav</th>
                                    <th>PBB</th>

                                    <th>Bid/Kav</th>
                                    <th>PBB</th>

                                    <th>s/d Tahun <?= $scd_last_year ?></th>
                                    <th>Tahun <?= $last_year ?></th>
                                    <th>total</th>

                                    <th>s/d Tahun <?= $last_year ?></th>
                                    <th>Tahun <?= $this_year ?></th>
                                    <th>Total</th>

                                    <th>Sudah</th>
                                    <th>Belum</th>
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