<?php
$proyek =  $this->model->get_lokasi_proses_ijin('ok')->result();

?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Evaluasi Terbit Ijin</h3>

                <div class="card">
                    <div class="card-body table-responsive">

                        <form action="<?= site_url('export/terbit_ijin_lokasi/') ?>" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="proyek_f" id="proyek_f" class="form-control">
                                            <option value="">--semua proyek--</option>
                                            <?php foreach ($tanah_proyek as $l) { ?>
                                                <option value="<?= $l->id ?>"><?= $l->nama_proyek ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="status_f" id="status_f" class="form-control">
                                            <option value="">--semua status</option>
                                            <?php foreach ($status as $st) { ?>
                                                <option value="<?= $st->id ?>"><?= $st->nama_status ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 text-right ">
                                    <a class="btn btn-sm btn-primary" onclick="filter_data()"><i class="fas fa-filter"></i> Filter Data</a>
                                    <button class="btn btn-sm btn-info" type="submit">
                                        <i class="fa fa-print"></i> Cetak
                                    </button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-sm table-bordered w-100" id="table">
                            <thead>
                                <tr style="background-color: #51008f;" class="text-white">
                                    <th rowspan="3" class="text-center text-nowrap"><i class="fa fa-cogs"></i></th>
                                    <th rowspan="3" class="text-center">#</th>
                                    <th rowspan="3" class="text-center text-nowrap">Proyek</th>

                                    <th colspan="4" class="text-center">Data Ijin Lokasi</th>
                                    <th rowspan="2" colspan="2" class="text-center">Tanah Yang Dimiliki</th>
                                    <th rowspan="3" class="text-center">Ket</th>
                                </tr>

                                <tr style="background-color: #d1d1d1;">
                                    <th rowspan="2" class="text-center">Luas</th>
                                    <th rowspan="2" class="text-center">No. Ijin</th>
                                    <th colspan="2" class="text-center">Tanggal</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Terbit</th>
                                    <th class="text-center">Masa Berlaku</th>
                                    <th class="text-center">Luas</th>
                                    <th class="text-center">%</th>
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


<!-- Modal -->
<div class="modal" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h5 class="modal-title text-light" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ajax_laporan/act_proses_ijin_lokasi') ?>" method="post" id="form_laporan">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="act" id="act">
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="to_submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="modalDetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-light bg-primary">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    const spinner_btn = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    const spinner = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';

    $(document).ready(function() {
        load_data()
    })

    function filter_data() {
        let proyek = $('#proyek_f').val()
        let status = $('#status_f').val()

        load_data(proyek, status)
    }

    function load_data(proyek = null, status = null) {
        $('#table').DataTable().destroy();

        let table = $('#table').dataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('ajax_laporan/load_evaluasi_terbit_ijin') ?>",
                "type": "POST",
                "data": {
                    "proyek": proyek,
                    "status": status
                }
            },
            "columnDefs": [],
            "ordering": false,
            "iDisplayLength": 10,
            // "scrollX": true,
            // "autoWidth": false
        });
    }

    function detail(id) {
        let modal = $('#modalDetail')
        modal.find('.modal-body').html(spinner)
        modal.modal('show');
        modal.find('.modal-title').html('Detail Data')

        $.ajax({
            url: '<?= base_url('ajax_laporan/detail_terbit_ijin') ?>',
            data: {
                id: id
            },
            type: 'POST',
            success: function(d) {
                modal.find('.modal-body').html(d)
            },
            error: function(xhr, status, error) {
                error_alert(error);
            }
        })
    }

    function edit(id) {
        let modal = $('#modalEdit')
        modal.find('.modal-body').html(spinner)
        modal.modal('show');
        modal.find('.modal-title').html('Edit Data')
        modal.find('#id').val(id)
        modal.find('#act').val('edit')

        $.ajax({
            url: '<?= base_url('ajax_laporan/form_edit_ijin_lokasi') ?>',
            data: {
                id: id
            },
            type: 'POST',
            success: function(d) {
                modal.find('.modal-body').html(d)
            },
            error: function(xhr, status, error) {
                error_alert(error);
            }
        })
    }

    function delete_data(id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: 'untuk menghapus data ini?',
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('ajax_laporan/delete_ijin_lokasi') ?>',
                    data: {
                        id: id
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d) {
                        if (d.status == false) {
                            error_alert(d.msg);
                            setTimeout(() => {
                                load_data();
                            }, 1500);
                        } else {
                            Swal.fire({
                                title: "Success",
                                text: d.msg,
                                icon: "success"
                            }).then((res) => {
                                load_data()
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        error_alert(error)
                    }
                })
            }
        });
    }

    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }

    $('#form_laporan').submit(function(e) {
        e.preventDefault();
        let modal = $('#modalEdit')
        modal.find('#to_submit').html(spinner_btn)
        modal.find('#to_submit').attr('disabled', true)

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                modal.find('#to_submit').html('Save')
                modal.find('#to_submit').removeAttr('disabled')
                modal.modal('hide')
                if (d.status == false) {
                    error_alert(d.msg);
                } else {
                    Swal.fire({
                        title: "Success",
                        text: d.msg,
                        icon: "success"
                    }).then((res) => {
                        load_data()
                    });
                }
            },
            error: function(xhr, status, error) {
                error_alert(error)
                modal.find('#to_submit').html('Save')
                modal.find('#to_submit').removeAttr('disabled')
            }
        })

    })
</script>