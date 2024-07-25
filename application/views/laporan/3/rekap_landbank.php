<?php
$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');

$f_proyek = $this->input->get('proyek');
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Evaluasi Rekap Land Bank</h3>

                <div class="card">
                    <div class="card-body table-responsive">


                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select name="f_proyek" id="f_proyek" class="form-control">
                                    <option value="">--pilih proyek--</option>
                                    <?php foreach ($proyek as $p) {
                                        if ($p->id == $f_proyek) {
                                            echo '<option value="' . $p->id . '" selected>' . $p->nama_proyek . '</option>';
                                        } else {
                                            echo '<option value="' . $p->id . '">' . $p->nama_proyek . '</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div class="text-right">
                                    <button class="btn btn-sm btn-success" onclick="to_filter()"><i class="fas fa-filter"></i> Filter</button>
                                    <a target="_blank" href="<?= base_url('export/evaluasi_landbank?proyek=') . $f_proyek ?>" class="btn btn-sm btn-primary"><i class="fas fa-file-excel"></i> Cetak</a>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered table-sm" id="table">
                            <thead>
                                <tr>
                                    <th rowspan="3" class="bg-dark text-light text-center">#</th>
                                    <th rowspan="3" class="bg-dark text-light text-center">Lokasi</th>

                                    <th colspan="3" style="background-color: #c22b80;" class="text-light text-center text-nowrap">Land Bank s/d <?= $last_year ?></th>
                                    <th colspan="3" style="background-color: #c22b80;" class="text-light text-center text-nowrap">Land Bank s/d <?= $this_year ?></th>
                                    <th colspan="3" style="background-color: #c22b80;" class="text-light text-center">Total Land Bank</th>
                                    <th colspan="3" style="background-color: #c22b80;" class="text-light text-center text-nowrap">Serah Terima Teknik</th>
                                    <th colspan="3" style="background-color: #c22b80;" class="text-light text-center">Sisa Land Bank</th>

                                    <th colspan="4" class="bg-success text-center text-white">Proses Peralihan Bank</th>
                                    <th colspan="2" class="bg-success text-center text-white text-nowrap">S Terima Finance</th>
                                </tr>

                                <tr>
                                    <th rowspan="2" class="text-white text-center" style="background-color:#9234eb ;">BID</th>
                                    <th colspan="2" class="text-white text-center" style="background-color: #3477eb;">Luas m<sup>2</sup></th>

                                    <th rowspan="2" class="text-white text-center" style="background-color:#9234eb ;">BID</th>
                                    <th colspan="2" class="text-white text-center" style="background-color: #3477eb;">Luas m<sup>2</sup></th>

                                    <th rowspan="2" class="text-white text-center" style="background-color:#9234eb ;">BID</th>
                                    <th colspan="2" class="text-white text-center" style="background-color: #3477eb;">Luas m<sup>2</sup></th>

                                    <th rowspan="2" class="text-white text-center" style="background-color:#9234eb ;">BID</th>
                                    <th colspan="2" class="text-white text-center" style="background-color: #3477eb;">Luas m<sup>2</sup></th>

                                    <th rowspan="2" class="text-white text-center" style="background-color:#9234eb ;">BID</th>
                                    <th colspan="2" class="text-white text-center" style="background-color: #3477eb;">Luas m<sup>2</sup></th>



                                    <th rowspan="2" class="text-center text-nowrap" style="background-color: #e3e3e3;">Belum Order</th>
                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Order</th>
                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Terbit</th>
                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Total</th>

                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Sudah</th>
                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Belum</th>
                                </tr>

                                <tr>
                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Surat</th>
                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Ukur</th>

                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Surat</th>
                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Ukur</th>

                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Surat</th>
                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Ukur</th>

                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Surat</th>
                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Ukur</th>

                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Surat</th>
                                    <th rowspan="2" class="text-center" style="background-color: #e3e3e3;">Ukur</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($status_proyek as $sp) {
                                    $data = $this->laporan->get_rekap_landbank($sp->id, 'group', $f_proyek)->result();
                                ?>
                                    <tr style="background: #e8e69e;">
                                        <td><strong>IP Proyek <?= $sp->nama_status ?></strong></td>
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
                                    <!-- 26 -->

                                    <?php $i = 1;
                                    foreach ($data as $d) {

                                        $bid_last_year = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, $last_year, null)->num_rows();
                                        $data_last_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, $sp->id, $last_year, null);

                                        $bid_this_year = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, $this_year, null)->num_rows();
                                        $data_this_year = $this->laporan->get_detail_rekap_landbank($d->proyek_id, $sp->id, $this_year, null);

                                        $bid_total = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, null, null)->num_rows();
                                        $data_total = $this->laporan->get_detail_rekap_landbank($d->proyek_id, $sp->id, null, null);

                                        $bid_teknik = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $d->status_proyek, null, 'selesai')->num_rows();
                                        $data_teknik = $this->laporan->get_detail_rekap_landbank($d->proyek_id, $sp->id, null, 'selesai');

                                        $bid_sisa = $bid_total - $bid_teknik;
                                        $ls_sisa = $data_total['luas_surat'] - $data_teknik['luas_surat'];
                                        $lu_sisa = $data_total['luas_ukur'] - $data_teknik['luas_ukur'];


                                        $bo_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $sp->id, null, null, 'belum order')->num_rows();
                                        $o_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $sp->id, null, null, 'order')->num_rows();
                                        $tb_peralihan = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $sp->id, null, null, 'terbit')->num_rows();
                                        $total_peralihan = $bo_peralihan + $o_peralihan + $tb_peralihan;

                                        $s_finance = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $sp->id, null, null, null, 'yes')->num_rows();
                                        $b_finance = $this->laporan->jml_bid_rekap_landbank($d->proyek_id, $sp->id, null, null, null, 'no')->num_rows();


                                    ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $d->nama_proyek ?></td>

                                            <td><?= $bid_last_year ?></td>
                                            <td><?= $data_last_year['luas_surat'] ?></td>
                                            <td><?= $data_last_year['luas_ukur'] ?></td>

                                            <td><?= $bid_this_year ?></td>
                                            <td><?= $data_this_year['luas_surat'] ?></td>
                                            <td><?= $data_this_year['luas_ukur'] ?></td>

                                            <td><?= $bid_total ?></td>
                                            <td><?= $data_total['luas_surat'] ?></td>
                                            <td><?= $data_total['luas_ukur'] ?></td>

                                            <td><?= $bid_teknik ?></td>
                                            <td><?= $data_teknik['luas_surat'] ?></td>
                                            <td><?= $data_teknik['luas_ukur'] ?></td>

                                            <td><?= $bid_sisa ?></td>
                                            <td><?= $ls_sisa ?></td>
                                            <td><?= $lu_sisa ?></td>

                                            <td><?= $bo_peralihan ?></td>
                                            <td><?= $o_peralihan ?></td>
                                            <td><?= $tb_peralihan ?></td>
                                            <td><?= $total_peralihan ?></td>

                                            <td><?= $s_finance ?></td>
                                            <td><?= $b_finance ?></td>
                                        </tr>
                                    <?php } ?>

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
    $('tbody').find('td').addClass('text-nowrap');
    // $('#table').dataTable();

    function to_filter() {
        let val = $('#f_proyek').val();
        window.location.href = '<?= base_url('dashboard/evaluasi_landbank?proyek=') ?>' + val;
    }
</script>