<?php
$tanah_proyek = $this->db->get('master_proyek')->result();
$f_proyek = $this->input->get('proyek');
$f_status = $this->input->get('status');

$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');

$data = $this->laporan->get_data_shgb()->result();
$data2 = $this->laporan->get_data_shgb_penggabungan()->result();

// $last_data = $this->laporan->get_data_shgb($f_proyek, $f_status, $last_year)->result();
// $this_data = $this->laporan->get_data_shgb($f_proyek, $f_status, null, $this_year)->result();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Evaluasi Proyek Sudah SHGB</h3>

                <div class="card">
                    <div class="card-body table-responsive">


                        <table class="table table-bordered table-sm" id="table-shgb">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th rowspan="3" style="text-align: center;vertical-align: middle;">NO</th>
                                    <th rowspan="3" style="text-align: center;vertical-align: middle;">SHGB</th>
                                    <th rowspan="2" colspan="2" style="text-align: center;vertical-align: middle;">DATA TANAH</th>
                                    <th rowspan="3" style="text-align: center;vertical-align: middle;">BATAS WAKTU SHGB</th>
                                    <th rowspan="3" style="text-align: center;vertical-align: middle;">POSISI SURAT</th>
                                    <th rowspan="3" style="text-align: center;vertical-align: middle;">JML SHGB</th>
                                    <th colspan="4" style="text-align: center;vertical-align: middle;">PROSES SPLIT</th>
                                    <th colspan="2" style="text-align: center;vertical-align: middle;">PROSES GABUNG</th>
                                    <th rowspan="3" style="text-align: center;vertical-align: middle;">TERBIT PROSES</th>
                                    <th colspan="2" rowspan="2" style="text-align: center;vertical-align: middle;">SISA SETELAH TERBIT</th>
                                    <th rowspan="3" style="text-align: center;vertical-align: middle;">KETERANGAN</th>
                                </tr>
                                <tr class="bg-primary text-light">
                                    <th rowspan="2" style="text-align: center;vertical-align: middle;">JML SHGB</th>
                                    <th colspan="3" style="text-align: center;vertical-align: middle;">LUAS</th>
                                    <th rowspan="2" style="text-align: center;vertical-align: middle;">JML SHGB</th>
                                    <th rowspan="2" style="text-align: center;vertical-align: middle;">LUAS</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;vertical-align: middle;">ATAS NAMA</th>
                                    <th style="text-align: center;vertical-align: middle;"> LUAS</th>
                                    <th style="text-align: center;vertical-align: middle;">SHGB</th>
                                    <th style="text-align: center;vertical-align: middle;"> PROSES </th>
                                    <th style="text-align: center;vertical-align: middle;">TERBIT</th>
                                    <th style="text-align: center;vertical-align: middle;">JML</th>
                                    <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                </tr>
                            </thead>


                            <tbody>
                                <?php $i = 1;
                                foreach ($data as $d) { ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d->no_terbit_shgb ?></td>
                                        <td>PT. GBU</td>
                                        <td><?= $d->luas_terbit ?></td>
                                        <td><?= tgl_indo($d->tgl_terbit_shgb) ?></td>
                                        <td></td>
                                        <td>1</td>

                                        <?php
                                        $data_splitsing = $this->laporan->get_data_split_7($d->id, null, 'induk');
                                        $split_terbit = 0;
                                        if ($data_splitsing->num_rows() <= 0) {
                                        ?>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        <?php } else {
                                            $data_spl = $data_splitsing->row();
                                            $split_proses = $this->laporan->count_splitsing_7($d->id, 'proses', 'induk')->row()->luas_splitsing;
                                            $split_terbit = $this->laporan->count_splitsing_7($d->id, 'terbit', 'induk')->row()->luas_splitsing;
                                        ?>
                                            <td><?= $data_splitsing->num_rows() ?></td>
                                            <td><?= $d->luas_terbit ?></td>
                                            <td><?= $split_proses ?></td>
                                            <td><?= $split_terbit ?></td>
                                        <?php } ?>


                                        <?php
                                        $jml_penggabungan = $this->laporan->get_jml_penggabungan($d->id, null, 'induk')->num_rows();
                                        $l_penggabungan = $this->laporan->get_jml_penggabungan($d->id, null, 'induk')->row()->jml;
                                        if ($l_penggabungan || $l_penggabungan > 0) {
                                            echo '
                                                <td>' . $jml_penggabungan . '</td>
                                                <td>' . $l_penggabungan . '</td>
                                            ';
                                        } else {
                                            echo '
                                                <td></td>
                                                <td></td>
                                            ';
                                        }
                                        ?>

                                        <td>-</td>
                                        <td>1</td>

                                        <?php
                                        $get_penggabungan_terbit = $this->laporan->get_jml_penggabungan($d->id, 'terbit', 'induk')->row()->jml;
                                        $l_penggabungan_terbit = 0;
                                        if ($get_penggabungan_terbit != '' || $get_penggabungan_terbit != null) {
                                            $l_penggabungan_terbit = $get_penggabungan_terbit;
                                        }

                                        $sisa_terbit = $d->luas_terbit - ($split_terbit + $l_penggabungan_terbit);

                                        echo '<td>' . $sisa_terbit . '</td>';
                                        ?>
                                        <td>-</td>



                                    </tr>
                                <?php } ?>
                                <?php foreach ($data2 as $d2) { ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d2->no_shgb ?></td>
                                        <td>PT. GBU</td>
                                        <td><?= $d2->luas_terbit ?></td>
                                        <td>
                                            <!-- batas shgb kosong (tidak ada) -->
                                        </td>

                                        <td><?= $d2->posisi ?></td>
                                        <td>1</td>


                                        <?php
                                        $data_splitsing = $this->laporan->get_data_split_7($d2->id, null, 'penggabungan');
                                        $split_terbit = 0;
                                        if ($data_splitsing->num_rows() <= 0) {
                                        ?>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        <?php } else {
                                            $data_spl = $data_splitsing->row();
                                            $split_proses = $this->laporan->count_splitsing_7($d2->id, 'proses', 'penggabungan')->row()->luas_splitsing;
                                            $split_terbit = $this->laporan->count_splitsing_7($d2->id, 'terbit', 'penggabungan')->row()->luas_splitsing;
                                        ?>
                                            <td><?= $data_splitsing->num_rows() ?></td>
                                            <td><?= $d2->luas_terbit ?></td>
                                            <td><?= $split_proses ?></td>
                                            <td><?= $split_terbit ?></td>
                                        <?php } ?>


                                        <?php
                                        $jml_penggabungan = $this->laporan->get_jml_penggabungan($d2->id, null, 'penggabungan')->num_rows();
                                        $l_penggabungan = $this->laporan->get_jml_penggabungan($d2->id, null, 'penggabungan')->row()->jml;
                                        if ($l_penggabungan || $l_penggabungan > 0) {
                                            echo '
                                                <td>' . $jml_penggabungan . '</td>
                                                <td>' . $l_penggabungan . '</td>
                                            ';
                                        } else {
                                            echo '
                                                <td></td>
                                                <td></td>
                                            ';
                                        }
                                        ?>

                                        <td>-</td>
                                        <td>1</td>

                                        <?php
                                        $get_penggabungan_terbit = $this->laporan->get_jml_penggabungan($d2->id, 'terbit', 'penggabungan')->row()->jml;
                                        $l_penggabungan_terbit = 0;
                                        if ($get_penggabungan_terbit != '' || $get_penggabungan_terbit != null) {
                                            $l_penggabungan_terbit = $get_penggabungan_terbit;
                                        }

                                        $sisa_terbit = $d2->luas_terbit - ($split_terbit + $l_penggabungan_terbit);

                                        echo '<td>' . $sisa_terbit . '</td>';
                                        ?>
                                        <td>-</td>



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
        $('#table-shgb').find('thead tr th').addClass('text-nowrap');
        $('#table-shgb').dataTable({
            "scrollX": false,
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
        let proyek = $('#proyek_id').val()
        let status = $('#status_proyek').val()
        let url = '<?= base_url('dashboard/evaluasi_sudah_shgb/') ?>?proyek=' + proyek + '&status=' + status;
        window.location.href = url;
    }
</script>