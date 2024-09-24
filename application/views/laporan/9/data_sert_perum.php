<?php
$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
$status = [
    ['title' => 'Belum Proses', 'value' => 'belum proses'],
    ['title' => 'Proses', 'value' => 'proses'],
    ['title' => 'Terbit', 'value' => 'terbit'],
];
?>


<style>
    #thead1 th {
        background-color: #40168a;
        color: white;
    }
</style>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Laporan Hutang Sertifikat Belum Split</h3>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <a id="export_data" href="<?= base_url('export/export_evaluasi_9') ?>" class="btn btn-sm btn-success my-1" target="_blank"><i class="far fa-file-excel"></i> Export Data</a>
                        <table class="table table-bordered" id="table">
                            <thead>
                                <tr id="thead1">
                                    <th rowspan="2">#</th>
                                    <th rowspan="2"><i class="fa fa-cogs"></i></th>
                                    <th rowspan="2">Tgl Jual</th>
                                    <th rowspan="2">Nama</th>
                                    <th rowspan="2">Type</th>
                                    <th rowspan="2">Blok</th>
                                    <th rowspan="2">Jml Kavling</th>
                                    <th colspan="3">Luas</th>
                                    <th rowspan="2">Tgl Proses</th>
                                    <th rowspan="2">Tgl Terbit</th>
                                    <th rowspan="2">No. Sert</th>
                                    <th rowspan="2">Masa SHGB</th>
                                    <th rowspan="2">Ket</th>
                                </tr>
                                <tr>
                                    <th>Daftar</th>
                                    <th>Sert</th>
                                    <th>Selisih</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


<div class="modal" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-light">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">&times;</span>
                </button>
            </div>
            <?= form_open('ajax_laporan/act_sertifikat_belum_split', 'id="form_edit"') ?>
            <input type="hidden" name="id" id="id_edit">
            <input type="hidden" name="act" id="act_edit" value="edit">
            <div class="modal-body">
                <div class="form-group my-1">
                    <label><b>Nama Pembeli</b></label>
                    <input type="text" name="pembeli" id="pembeli" class="form-control">
                </div>

                <div class="form-group my-1">
                    <label><b>Tgl. Jual</b></label>
                    <input type="date" name="tgl_jual" id="tgl_jual" class="form-control">
                </div>

                <div class="form-group my-1">
                    <label><b>Type</b></label>
                    <input type="text" name="type" id="type" class="form-control">
                </div>

                <div class="form-group my-1">
                    <label><b>No. SHGB</b></label>
                    <input type="text" name="shgb" id="shgb" class="form-control">
                </div>

                <div class="form-group my-1">
                    <label><b>Masa Berlaku</b></label>
                    <input type="text" name="masa_berlaku" id="masa_berlaku" class="form-control">
                </div>

                <div class="form-group my-1">
                    <label><b>Status Penjualan</b></label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">--pilih--</option>
                        <?php foreach ($status as $st) { ?>
                            <option value="<?= $st['value'] ?>"><?= $st['title'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group my-1">
                    <label><b>Ket</b></label>
                    <textarea name="ket" id="ket" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#table thead tr th').addClass('text-center text-nowrap')

    $('#form_edit').submit(function(e) {
        e.preventDefault();
        loading_animate();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                setTimeout(() => {
                    Swal.close();
                    if (d.status == false) {
                        error_alert(d.msg)
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg
                        }).then((res) => {
                            $('#modalEdit').modal('hide')
                            window.location.reload()
                        })
                    }
                }, 200);
            },
            error: function(xhr, status, error) {
                setTimeout(() => {
                    Swal.close();
                    error_alert(error)
                }, 200);
            }
        })
    })

    function edit_data(id) {
        loading_animate();
        $('#id_edit').val(id)
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_sertifikat_belum_split') ?>',
            data: {
                id: id,
                act: 'get_row'
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                setTimeout(() => {
                    Swal.close();
                    if (d.status == false) {
                        error_alert(d.msg);
                    } else {
                        let data = d.data;
                        insert_value(data)
                        $('#modalEdit').modal('show')
                    }
                }, 200);
            },
            error: function(xhr, status, error) {
                setTimeout(() => {
                    Swal.close();
                    error_alert(error);
                }, 200);
            }
        })
    }

    function insert_value(data) {
        $('#pembeli').val(data.pembeli);
        $('#tgl_jual').val(data.tgl_jual);
        $('#type').val(data.type);
        $('#shgb').val(data.shgb);
        $('#masa_berlaku').val(data.expired);
        $('#status').val(data.status);
        $('#ket').val(data.ket);
    }

    function delete_data(id) {
        Swal.fire({
            icon: 'warning',
            title: "Apakah anda yakin?",
            text: 'untuk menghapus data ini?',
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                loading_animate()
                $.ajax({
                    url: '<?= base_url('ajax_laporan/act_sertifikat_belum_split') ?>',
                    data: {
                        id: id,
                        act: 'delete'
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d) {
                        setTimeout(() => {
                            Swal.close()
                            if (d.status == false) {
                                error_alert(d.msg)
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: d.msg
                                }).then((res) => {
                                    window.location.reload();
                                });
                            }
                        }, 200);
                    },
                    error: function(xhr, status, error) {
                        setTimeout(() => {
                            Swal.close()
                            error_alert(error)
                        }, 200);
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

    function loading_animate() {
        Swal.fire({
            title: "Loading",
            html: "Please wait...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

    }
</script>