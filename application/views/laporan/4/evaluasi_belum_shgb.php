<?php
$status_pengalihan = ['belum order', 'order', 'terbit'];
$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');

$proyek = $this->db->get('master_proyek')->result();
// $data = $this->laporan->get_rekap_belum_shgb()->result();
?>
<section class="content-header">
    <div class="container-fluid">
        <h3>Rekap Evaluasi Tanah Belum SHGB</h3>
        <div class="row mb-2">
            <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                <select name="proyek" id="proyek" class="form-control">
                    <option value="">--pilih--</option>
                    <?php foreach ($proyek as $pr) { ?>
                        <option value="<?= $pr->id ?>"><?= $pr->nama_proyek ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6"></div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 text-right">
                <button class="btn btn-sm btn-success" onclick="filter_data()"><i class="fas fa-filter"></i> Filter</button>
                <a href="<?= base_url('export/evaluasi_belum_shgb?proyek=') ?>" id="to_export" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-file-excel"></i> Cetak</a>

            </div>

            <div class="col-12">

                <div class="card mt-3">
                    <div class="card-body">

                        <table class="table table-bordered table-sm" id="_table">
                            <thead>
                                <tr class="text-light">
                                    <th class="bg-dark" rowspan="2">#</th>
                                    <th class="bg-dark" rowspan="2">Lokasi</th>

                                    <th class="bg-primary" colspan="3">Tanah Belum SHGB s/d Tahun <?= $last_year ?></th>
                                    <th class="bg-primary" colspan="3">Tanah Belum SHGB s/d Tahun <?= $this_year ?></th>
                                    <th class="bg-primary" colspan="3">Total Tanah Proyek Sebelum SHGB </th>
                                    <th class="bg-primary" colspan="3">Proses SHGB Tahun <?= $this_year ?></th>
                                    <th class="bg-primary" colspan="3">Sisa Tanah Proyek Belum SHGB s/d Tahun <?= $this_year ?></th>

                                    <th class="bg-success" colspan="4">Proses Peralihan Bank</th>
                                    <th class="bg-success" colspan="2">S Terima Finance</th>
                                </tr>

                                <tr>
                                    <th class="bg-secondary">BID</th>
                                    <th class="bg-secondary">L. surat</th>
                                    <th class="bg-secondary">L. Ukur</th>

                                    <th class="bg-secondary">BID</th>
                                    <th class="bg-secondary">L. surat</th>
                                    <th class="bg-secondary">L. Ukur</th>

                                    <th class="bg-secondary">BID</th>
                                    <th class="bg-secondary">L. surat</th>
                                    <th class="bg-secondary">L. Ukur</th>

                                    <th class="bg-secondary">BID</th>
                                    <th class="bg-secondary">L. surat</th>
                                    <th class="bg-secondary">L. Ukur</th>

                                    <th class="bg-secondary">BID</th>
                                    <th class="bg-secondary">L. surat</th>
                                    <th class="bg-secondary">L. Ukur</th>

                                    <?php foreach ($status_pengalihan as $sph) { ?>
                                        <th class="bg-secondary"><?= ucwords($sph) ?></th>
                                    <?php } ?>
                                    <th class="bg-secondary">Total</th>

                                    <th class="bg-secondary">Belum</th>
                                    <th class="bg-secondary">Selesai</th>


                                </tr>
                            </thead>

                            <tbody></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<script>
    $(document).ready(function() {

        load_data()
        $('thead').find('th').addClass('text-nowrap text-center')
        $('tbody').find('td').addClass('text-nowrap text-center')
    })


    function load_data(proyek = null) {
        $('#_table').DataTable().destroy();

        let table = $('#_table').dataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('ajax_laporan/load_rekap_belum_shgb') ?>",
                "type": "POST",
                "data": {
                    "proyek": proyek,
                }
            },
            "columnDefs": [],
            "ordering": false,
            "iDisplayLength": 10,
            "scrollX": true,
            "searching": false
            // "autoWidth": false
        });
    }

    function filter_data() {
        let proyek = $('#proyek').val();
        load_data(proyek);
    }

    $('#proyek').change(function() {
        let v = $(this).val()
        $('#to_export').attr('href', '<?= base_url('export/evaluasi_belum_shgb?proyek=') ?>' + v)
    })
</script>