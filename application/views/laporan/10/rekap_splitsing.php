<?php
$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
$data_proyek = $this->db->get('master_proyek')->result();
?>

<style>
    /* #table thead tr:nth-child(1) {
        background-color: #140b63;
        color: white;
    } */

    #table_biru {
        background-color: #140b63;
        color: white;
    }

    #table_end {
        background-color: #6e6e6e;
        color: white;
    }

    .bg-ungu {
        background-color: #a344cf;
        color: white;
    }

    .bg-kuning {
        background-color: #decc64;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Rekap Stok Kavling Splitsing</h3>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr id="table_biru">
                                    <th rowspan="4">#</th>
                                    <th rowspan="4">Perumahan</th>
                                    <th colspan="10">Stock Kavling Evektif</th>
                                    <th colspan="6">Terjual Tahun <?= $this_year ?></th>
                                    <th colspan="10">Sisa Stock Kavling Evektif</th>
                                </tr>

                                <tr>
                                    <th colspan="6" class="bg-ungu">Terbit Splitsing</th>
                                    <th colspan="2" rowspan="2" class="bg-ungu">Belum Terbit Split</th>
                                    <th colspan="2" rowspan="2" class="bg-ungu">Total</th>

                                    <th colspan="2" rowspan="2" class="bg-ungu">Stock Terbit Split</th>
                                    <th colspan="2" rowspan="2" class="bg-ungu">Stock Belum Terbit Split</th>
                                    <th colspan="2" rowspan="2" class="bg-ungu">Total</th>

                                    <th colspan="2" rowspan="2" class="bg-ungu">Terbit Splitsing</th>
                                    <th colspan="2" rowspan="2" class="bg-ungu">Belum Terbit Splitsing</th>
                                    <th colspan="4" class="bg-ungu">Evaluasi Belum Terbit Split</th>
                                    <th colspan="2" rowspan="2" class="bg-ungu">Total</th>
                                </tr>

                                <tr>
                                    <th colspan="2" class="bg-kuning">s/d Tahun <?= $last_year ?></th>
                                    <th colspan="2" class="bg-kuning">Tahun <?= $this_year ?></th>
                                    <th colspan="2" class="bg-kuning">Total</th>

                                    <th colspan="2" class="bg-kuning">Belum Proses</th>
                                    <th colspan="2" class="bg-kuning">Proses</th>
                                </tr>

                                <tr id="table_end">
                                    <th>Sert</th>
                                    <th>kav</th>
                                    <th>Sert</th>
                                    <th>kav</th>
                                    <th>Sert</th>
                                    <th>kav</th>
                                    <th>Sert</th>
                                    <th>kav</th>
                                    <th>Sert</th>
                                    <th>kav</th>

                                    <th>Sert</th>
                                    <th>kav</th>
                                    <th>Sert</th>
                                    <th>kav</th>
                                    <th>Sert</th>
                                    <th>kav</th>

                                    <th>Sert</th>
                                    <th>kav</th>
                                    <th>Sert</th>
                                    <th>kav</th>
                                    <th>Sert</th>
                                    <th>kav</th>
                                    <th>Sert</th>
                                    <th>kav</th>
                                    <th>Sert</th>
                                    <th>kav</th>
                                </tr>
                            </thead>


                            <tbody>
                                <?php $i = 1;
                                foreach ($data_proyek as $dp) { ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $dp->nama_proyek ?></td>

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

<script>
    $('#table thead tr th').addClass('text-center text-nowrap')
    $('#table').dataTable({
        scrollX: true,
        ordering: false
    })
</script>