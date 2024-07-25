<?php
$list_proyek = $this->db->get('master_proyek')->result();

$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
$list_year = [$last_year, $this_year];

$f_proyek = $this->input->get('proyek');

$list_month = $this->model->get_month_data();

?>

<style>
    #tr_blue {
        background-color: #3d5ad1;
        color: white;
    }
</style>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Evaluasi Rekap Land Bank</h3>
                <div class="card">
                    <div class="card-body table-responsive">


                        <div class="row mb-3">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-3"></div>

                            <div class="col-md-6 text-right ">
                                <a class="btn btn-sm btn-info" href="<?= base_url('export/export_rekap_8') ?>" id="to_print" target="_blank">
                                    <i class="fa fa-print"></i> Cetak
                                </a>
                            </div>
                        </div>

                        <table class="table table-bordered table-sm mt-3 w-100" id="table">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="bg-dark text-light text-center">#</th>
                                    <th rowspan="2" class="bg-dark text-light text-center">Lokasi</th>
                                    <th colspan="3" class="bg-dark text-light text-center">Proses Splitsing</th>
                                    <th colspan="13" class="bg-dark text-light text-center">Terbit Tahun <?= $this_year ?></th>
                                    <th rowspan="2" class="bg-dark text-light text-center">Sisa Belum Terbit</th>
                                    <th rowspan="2" class="bg-dark text-light text-center">Keterangan</th>
                                </tr>

                                <tr id="tr_blue">
                                    <th>sd. <?= $last_year ?></th>
                                    <th>Thn. <?= $this_year ?></th>
                                    <th>Jumlah</th>
                                    <?php foreach ($list_month as $lm) { ?>
                                        <th><?= $lm['short'] ?></th>
                                    <?php } ?>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($list_proyek as $lp) {
                                    $list_terbit_month = '';
                                    $total_terbit_month = 0;

                                    $p_last_year = $this->laporan->data_rekap_splitsing($lp->id, 'proses', null, null, $last_year)->num_rows();
                                    $p_this_year = $this->laporan->data_rekap_splitsing($lp->id, 'proses', null, null, $this_year)->num_rows();
                                    $total_proses = $p_last_year + $p_this_year;


                                    foreach ($list_month as $lm) {
                                        $jml_data = $this->laporan->data_rekap_splitsing($lp->id, 'terbit', $lm['val'], $this_year)->num_rows();
                                        $total_terbit_month += $jml_data;

                                        if ($jml_data > 0) {
                                            $data = $jml_data;
                                        } else {
                                            $data = '-';
                                        }

                                        $list_terbit_month .= '
                                            <td>' . $data . '</td>
                                        ';
                                    }

                                    $sisa = $total_proses - $total_terbit_month;

                                    echo '<tr>
                                            <td>' . $i++ . '</td>
                                            <td>' . $lp->nama_proyek . '</td>
                                            <td>' . $p_last_year . '</td>
                                            <td>' . $p_this_year . '</td>
                                            <td>' . $total_proses . '</td>
                                            ' . $list_terbit_month . '
                                            <td>' . $total_terbit_month . '</td>
                                            <td>' . $sisa . '</td>
                                            <td></td>
                                        </tr>';
                                } ?>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<script>
    $('#proyek_f').change(function() {
        let v = $(this).val();
        $('#to_filter').attr('href', '<?= base_url('dashboard/rekap_proses_splitsing?proyek=') ?>' + v)
        $('#to_print').attr('href', '<?= base_url('export/export_rekap_8?proyek=') ?>' + v)
    })

    $('#table').dataTable({
        scrollX: true,
        ordering: false
    })
</script>