<?php
$month = $this->model->get_month_data();
$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');

$last_year2 = date('Y', strtotime('-2 year'));
$last_year3 = date('Y', strtotime('-3 year'));
$last_year4 = date('Y', strtotime('-4 year'));
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

                        <table id="table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Surat Tanah/Blok</th>
                                    <th rowspan="2">No. Gbr</th>

                                    <th colspan="2">Luas (m<sup>2</sup>)</th>
                                    <th colspan="4">SPPT PBB</th>
                                    <th colspan="2">NJOP /m<sup>2</sup> </th>
                                    <th colspan="3">Tagihan Tahun <?= $this_year ?></th>
                                    <th colspan="2">Keputusan</th>
                                    <th colspan="2">Pembayaran Tahun <?= $this_year ?></th>
                                    <th colspan="4">Pembayaran Tahun Sebelumnya</th>

                                    <th rowspan="2">Ket</th>
                                </tr>
                                <tr>
                                    <th>Surat</th>
                                    <th>Ukur</th>

                                    <th>Nomor</th>
                                    <th>Nama</th>
                                    <th>Luas BGN</th>
                                    <th>Luas TNH</th>

                                    <th>Thn <?= $last_year ?></th>
                                    <th>Thn <?= $this_year ?></th>

                                    <th>s/d <?= $last_year ?></th>
                                    <th>Thn <?= $this_year ?></th>
                                    <th>Total</th>

                                    <th>PT</th>
                                    <th>PHK Lain</th>

                                    <th>Sudah</th>
                                    <th>Belum</th>

                                    <th><?= $last_year4 ?></th>
                                    <th><?= $last_year3 ?></th>
                                    <th><?= $last_year2 ?></th>
                                    <th><?= $last_year ?></th>
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