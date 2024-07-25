<?php
$month = $this->model->get_month_data();
$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
?>
<style>
    .table thead tr:nth-child(2) {
        background-color: #decc64;
    }

    .table-1 thead tr:nth-child(1) {
        background-color: #6b1173;
        color: white;
    }

    .table-2 thead tr:nth-child(1) {
        background-color: #821419;
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


                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
                                <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Belum Order</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                                <br>
                                <table class="table table-bordered w-100 table-1">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Tgl. Order</th>
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">Blok</th>
                                            <th rowspan="2">Jml. Kav</th>

                                            <th colspan="3">L. Tanah</th>

                                            <th rowspan="2">No. Sert</th>
                                            <th rowspan="2">Masa Berlaku</th>
                                            <th rowspan="2">Sistem Bayar</th>
                                            <th rowspan="2">Notaris</th>
                                            <th rowspan="2">Harga AJB</th>

                                            <th colspan="2">Pajak-pajak</th>
                                            <th colspan="4">AJB</th>
                                            <th colspan="2">Balik Nama</th>
                                            <th colspan="12">Rincian Terbit BN per Bulan</th>

                                            <th rowspan="2">Ket</th>
                                        </tr>
                                        <tr>
                                            <th>Jual</th>
                                            <th>Sert</th>
                                            <th>Selisih</th>

                                            <th>SPP</th>
                                            <th>BPHTB</th>

                                            <th>Belum</th>
                                            <th>Proses</th>
                                            <th>Terbit</th>
                                            <th>No. AJB</th>

                                            <th>Proses</th>
                                            <th>Terbit</th>

                                            <?php foreach ($month as $mth) { ?>
                                                <th><?= $mth['short'] ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                </table>

                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">


                                <br>
                                <table class="table table-bordered w-100 table-2">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Tgl. Order</th>
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">Blok</th>
                                            <th rowspan="2">Jml. Kav</th>

                                            <th colspan="3">L. Tanah</th>

                                            <th rowspan="2">No. Sert</th>
                                            <th rowspan="2">Masa Berlaku</th>
                                            <th rowspan="2">Sistem Bayar</th>
                                            <th rowspan="2">Notaris</th>
                                            <th rowspan="2">Harga AJB</th>

                                            <th colspan="2">Pajak-pajak</th>
                                            <th colspan="4">AJB</th>
                                            <th colspan="2">Balik Nama</th>
                                            <th colspan="12">Rincian Terbit BN per Bulan</th>

                                            <th rowspan="2">Ket</th>
                                        </tr>
                                        <tr>
                                            <th>Jual</th>
                                            <th>Sert</th>
                                            <th>Selisih</th>

                                            <th>SPP</th>
                                            <th>BPHTB</th>

                                            <th>Belum</th>
                                            <th>Proses</th>
                                            <th>Terbit</th>
                                            <th>No. AJB</th>

                                            <th>Proses</th>
                                            <th>Terbit</th>

                                            <?php foreach ($month as $mth) { ?>
                                                <th><?= $mth['short'] ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<script>
    $('.table thead tr th').addClass('text-center text-nowrap')
</script>