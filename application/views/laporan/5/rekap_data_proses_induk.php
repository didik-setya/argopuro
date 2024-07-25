<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Rekap Proses Induk</h3>

                <div class="card">
                    <div class="card-body table-responsive">

                        <form action="<?php echo site_url('export/rekap_data_proses_induk/') ?>" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select data-plugin-selectTwo class="form-control" id="proyek_id" name="proyek_id">
                                            <option value="">Semua Lokasi</option>
                                            <?php foreach ($tanah_proyek as $tp) : ?>
                                                <option value="<?php echo $tp->id; ?>"><?php echo $tp->nama_proyek; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select data-plugin-selectTwo class="form-control" id="status_proyek" name="status_proyek">
                                            <option value="">Status Proyek</option>
                                            <option value="1">Luar Ijin</option>
                                            <option value="2">Dalam Ijin</option>
                                            <option value="3">Lokasi</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 text-right ">
                                    <a class="btn btn-success btn-sm" onclick="reload_filter()"><i class="fas fa-filter"></i> Filter Data</a>
                                    <button class="btn btn-info btn-sm" type="submit"><i class="fa fa-print"></i> Cetak</button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered table-sm mt-2" id="table-rekap-induk">
                            <thead>
                                <tr class="bg-dark text-light text-center">
                                    <th rowspan="3" style="text-align: center;vertical-align: middle;">NO</th>
                                    <th rowspan="3" style="text-align: center;vertical-align: middle;">LOKASI</th>
                                    <th colspan="6" style="text-align: center;vertical-align: middle;">PROSES INDUK</th>
                                    <th colspan="2" rowspan="2" style="text-align: center;vertical-align: middle;">TERBIT TAHUN <?= date('Y') ?></th>
                                    <th colspan="2" rowspan="2" style="text-align: center;vertical-align: middle;">SISA SEBELUM TERBIT s/d <?= date('Y') ?></th>
                                </tr>
                                <tr style="background-color:#9234eb ;" class="text-white text-center">
                                    <th colspan="2" style="text-align: center;vertical-align: middle;">SISA S/D <?= date('Y') - 1 ?></th>
                                    <th colspan="2" style="text-align: center;vertical-align: middle;">TAHUN <?= date('Y') ?></th>
                                    <th colspan="2" style="text-align: center;vertical-align: middle;">TOTAL</th>
                                </tr>
                                <tr style="background-color: #d1d1d1;" class="text-center">
                                    <th style="text-align: center;vertical-align: middle;">INDUK</th>
                                    <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                    <th style="text-align: center;vertical-align: middle;">INDUK</th>
                                    <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                    <th style="text-align: center;vertical-align: middle;">INDUK</th>
                                    <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                    <th style="text-align: center;vertical-align: middle;">INDUK</th>
                                    <th style="text-align: center;vertical-align: middle;">LUAS TERBIT</th>
                                    <th style="text-align: center;vertical-align: middle;">INDUK</th>
                                    <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                </tr>

                            </thead>

                            <tbody>
                                <?php $i = 1;
                                foreach ($rekap_induk as $r) {
                                    $this_year = date('Y');
                                    $last_year = date('Y') - 1;

                                    $pro_old_bid = $this->laporan->count_induk_rekap($r->proyek_id, 'dil', 'belum', null, $last_year)->num_rows();
                                    $get_pro_old_luas = $this->laporan->count_induk_rekap($r->proyek_id, 'luas', 'belum', null, $last_year)->row()->luas_terbit;
                                    if ($get_pro_old_luas) {
                                        $s_old_luas = $get_pro_old_luas;
                                    } else {
                                        $s_old_luas = 0;
                                    }


                                    $pro_new_bid = $this->laporan->count_induk_rekap($r->proyek_id, 'dil', 'belum', $this_year)->num_rows();
                                    $get_pro_new_luas = $this->laporan->count_induk_rekap($r->proyek_id, 'luas', 'belum', $this_year)->row()->luas_terbit;
                                    if ($get_pro_new_luas) {
                                        $s_new_luas = $get_pro_new_luas;
                                    } else {
                                        $s_new_luas = 0;
                                    }


                                    $tot_pro_bid = $pro_old_bid + $pro_new_bid;
                                    $tot_pro_luas = $s_old_luas + $s_new_luas;


                                    $terb_bid = $this->laporan->count_induk_rekap($r->proyek_id, 'dil', 'terbit', $this_year)->num_rows();
                                    $get_terb_luas = $this->laporan->count_induk_rekap($r->proyek_id, 'luas', 'terbit', $this_year)->row()->luas_terbit;
                                    if ($get_terb_luas) {
                                        $terb_luas = $get_terb_luas;
                                    } else {
                                        $terb_luas = 0;
                                    }


                                    $sis_bid = $tot_pro_bid - $terb_bid;
                                    $sis_luas = $tot_pro_luas - $terb_luas;
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $r->nama_proyek ?> (<?= $r->nama_status ?>)</td>

                                        <td><?= $pro_old_bid ?></td>
                                        <td><?= $s_old_luas ?></td>

                                        <td><?= $pro_new_bid ?></td>
                                        <td><?= $s_new_luas ?></td>

                                        <td><?= $tot_pro_bid ?></td>
                                        <td><?= $tot_pro_luas ?></td>

                                        <td><?= $terb_bid ?></td>
                                        <td><?= $terb_luas ?></td>

                                        <td><?= $sis_bid ?></td>
                                        <td><?= $sis_luas ?></td>

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
    const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    $(document).ready(function() {
        $('#table-rekap-induk').dataTable({
            "scrollX": true,
            "searching": true,
            "ordering": false,
            "autoWidth": false,
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
        })
    })

    function reload_filter() {
        let proyek = $('#proyek_id').val()
        let status = $('#status_proyek').val()
        let url = '<?= base_url('dashboard/rekap_data_proses_induk') ?>?proyek=' + proyek + '&status=' + status;
        window.location.href = url;
    }
</script>