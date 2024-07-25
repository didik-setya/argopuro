<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <div class="form-group mt-lg">

                </div>
                <h3>Data Evaluasi Pembelian Tanah</h3>

                <form action="<?= site_url('export/evaluasi_pembayaran_tanah/') ?>" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="proyek_id" id="proyek_id" class="form-control">
                                    <option value="">--pilih proyek--</option>
                                    <?php foreach ($tanah_proyek as $p) { ?>
                                        <option value="<?= $p->id ?>"><?= $p->nama_proyek ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="status_proyek" id="status_proyek" class="form-control">
                                    <option value="">--status proyek--</option>
                                    <?php foreach ($status_proyek as $sp) { ?>
                                        <option value="<?= $sp->id ?>"><?= $sp->nama_status ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="year" id="year_f" class="form-control">
                                    <option value="">--pilih--</option>
                                    <?php
                                    $this_year = date('Y') + 1;
                                    $last_year = $this_year - 20;
                                    for ($y = $last_year; $y < $this_year; $y++) {
                                    ?>
                                        <option value="<?= $y ?>"><?= $y ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 text-right ">
                            <a class="btn btn-success btn-sm" onclick="load_data()"><i class="fas fa-filter"></i> Filter Data</a>
                            <button class="btn btn-info btn-sm" type="submit"><i class="fa fa-print"></i> Cetak</button>
                        </div>
                    </div>
                </form>

                <!-- ISI DATA START -->
                <div id="content-data"></div>

                <!-- ISI DATA END -->


            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<script>

</script>
<script>
    const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    $(document).ready(function() {
        load_data()
        $('#table_evaluasi').dataTable({
            "scrollX": true,
            "ordering": false,
            "columnDefs": [{
                "targets": [0], //first column / numbering column
                "className": "text-nowrap"
            }, ],
        })
    })

    function load_data() {
        var proyek = $('#proyek_id').val();
        var status = $('#status_proyek').val();
        let year = $('#year_f').val()
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>ajax_laporan/load_evaluasi_pembelian',
            data: {
                proyek: proyek,
                status: status,
                year: year
            },
            success: function(html) {
                $('#content-data').html(html);
            }
        });
    }
</script>