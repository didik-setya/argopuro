<?php
$tanah_proyek = $this->db->get('master_proyek')->result();

$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
?>
<section class="content-header">
    <div class="container-fluid">
        <h3>Rekap Tanah SHGB</h3>

        <div class="row my-3">
            <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                <select name="filter" id="filter" class="form-control">
                    <option value="">--semua lokasi--</option>
                    <?php foreach ($tanah_proyek as $tp) : ?>
                        <option value="<?php echo $tp->id; ?>"><?php echo $tp->nama_proyek; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-7 col-lg-7"></div>
            <div class="col-12 col-sm-12 col-md-2 col-lg-2 text-center">
                <button class="btn btn-sm btn-primary" onclick="filter_data()">Filter</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <?php var_dump($data) ?> -->
                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th rowspan="3" class="bg-dark text-light">No</th>
                                    <th rowspan="3" class="bg-dark text-light">Lokasi</th>

                                    <th colspan="6" class="bg-primary text-light">Tanah Proyek Sudah SHGB</th>
                                    <th colspan="4" class="bg-primary text-light">Proses Sampai 2024</th>

                                    <th colspan="2" rowspan="2" class="bg-success text-light">Sisa Tanah Proyek Sudah SHGB Belum Proses</th>
                                    <th colspan="2" rowspan="2" class="bg-dark text-light">Jalan Pasos</th>
                                </tr>

                                <tr class="bg-secondary">
                                    <th colspan="2">Sisa s/d Tahun <?= $last_year ?></th>
                                    <th colspan="2">Tahun <?= $this_year ?></th>
                                    <th colspan="2">Total</th>

                                    <th colspan="2">Splitsing</th>
                                    <th colspan="2">Penggabungan</th>
                                </tr>

                                <tr>
                                    <th>SHGB</th>
                                    <th>Luas</th>

                                    <th>SHGB</th>
                                    <th>Luas</th>

                                    <th>SHGB</th>
                                    <th>Luas</th>

                                    <th>SHGB</th>
                                    <th>Luas</th>

                                    <th>SHGB</th>
                                    <th>Luas</th>

                                    <th>SHGB</th>
                                    <th>Luas</th>

                                    <th>SHGB</th>
                                    <th>Luas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $tot_shgb = 0;
                                $tot_luas = 0;
                                foreach ($data as $d) {
                                    $shgb_last = $this->laporan->get_data_rekap_shgb($d->proyek_id, $last_year, null, 'shgb')->num_rows();
                                    $get_luas_last = $this->laporan->get_data_rekap_shgb($d->proyek_id, $last_year, null, 'luas')->row()->luwas;
                                    if ($get_luas_last) {
                                        $luas_last = $get_luas_last;
                                    } else {
                                        $luas_last = 0;
                                    }

                                    $shgb_this = $this->laporan->get_data_rekap_shgb($d->proyek_id, $this_year, null, 'shgb')->num_rows();
                                    $get_luas_this = $this->laporan->get_data_rekap_shgb($d->proyek_id, null, $this_year, 'luas')->row()->luwas;


                                    if ($get_luas_this) {
                                        $luas_this = $get_luas_this;
                                    } else {
                                        $luas_this = 0;
                                    }

                                    $tot_luas = $luas_last + $luas_this;
                                    $tot_shgb = $shgb_last + $shgb_this;
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d->nama_proyek ?></td>
                                        <td><?= $shgb_last ?></td>
                                        <td><?= $luas_last ?></td>
                                        <td><?= $shgb_this ?></td>
                                        <td><?= $luas_this ?></td>
                                        <td><?= $tot_shgb ?></td>
                                        <td><?= $tot_luas ?></td>
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
    </div>
</section>

<script>
    $(document).ready(function() {
        $('#table').find('thead tr th').addClass('text-nowrap text-center');
        $('#table').dataTable({
            "scrollX": true,
            "searching": true,
            "ordering": false,
            "autoWidth": true,
            columnDefs: [{
                "defaultContent": " ",
                "targets": "_all"
            }],
        })
    })

    function filter_data() {
        let f = $('#filter').val();
        let url = '<?= base_url('dashboard/rekap_sudah_shgb?proyek=') ?>' + f;
        window.location.href = url;
    }
</script>