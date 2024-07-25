<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Master Jenis Pengalihan</h3>

                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-sm btn-success mb-3" onclick="add_pengalihan()"><i class="fa fa-plus"></i> Tambah</button>

                        <table class="table table-bordered table-sm" id="table_menu">
                            <thead>
                                <tr class="bg-secondary">
                                    <th>No</th>
                                    <th>Kode Pengalihan</th>
                                    <th>Nama Pengalihan</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $d) { ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d->kode_pengalihan ?></td>
                                        <td><?= $d->nama_pengalihan ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="edit_pengalihan('<?= $d->id ?>')"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger" onclick="delete_pengalihan('<?= $d->id ?>')"><i class="fas fa-trash"></i></button>
                                        </td>
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

<!-- Modal -->
<div class="modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ajax/validation_pengalihan') ?>" id="form_pengalihan" method="post">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="act" id="act">
                <div class="modal-body">

                    <div class="form-group mb-3">
                        <label>Kode Pengalihan</label>
                        <input type="text" name="kode_pengalihan" id="kode_pengalihan" class="form-control" required>
                        <small class="text-danger" id="err_kode_pengalihan"></small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Nama Pengalihan</label>
                        <input type="text" name="nama_pengalihan" id="nama_pengalihan" class="form-control" required>
                        <small class="text-danger" id="err_nama_pengalihan"></small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="to_submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    function add_pengalihan() {
        $('#staticBackdrop').modal('show')
        $('.modal-title').html('Tambah Jenis Pengalihan Baru')

        $('#err_kode_pengalihan').html('')
        $('#err_nama_pengalihan').html('')

        $('#act').val('add');
        $('#id').val('');
        $('#kode_pengalihan').val('')
        $('#nama_pengalihan').val('')
    }

    function edit_pengalihan(id) {
        $('#staticBackdrop').modal('show')
        $('.modal-title').html('Edit Jenis Pengalihan Tanah')

        $('#err_kode_pengalihan').html('')
        $('#err_nama_pengalihan').html('')

        $('#act').val('edit');
        $('#id').val(id);
        $('#kode_pengalihan').val('')
        $('#nama_pengalihan').val('')
        get_detail_pengalihan(id)
    }

    function get_detail_pengalihan(id) {
        $.ajax({
            url: '<?= base_url('ajax/detail_pengalihan') ?>',
            data: {
                id: id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#kode_pengalihan').val(d.kode_pengalihan)
                $('#nama_pengalihan').val(d.nama_pengalihan)

            },
            error: function(xhr, status, error) {
                error_alert(error)
            }
        })
    }

    $('#form_pengalihan').submit(function(e) {
        e.preventDefault()
        $('#to_submit').attr('disabled', true)
        $('#to_submit').html(spinner)

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#to_submit').removeAttr('disabled')
                $('#to_submit').html('Save')

                if (d.type == 'validation') {
                    if (d.err_kode_pengalihan == '') {
                        $('#err_kode_pengalihan').html('')
                    } else {
                        $('#err_kode_pengalihan').html(d.err_kode_pengalihan)
                    }

                    if (d.err_nama_pengalihan == '') {
                        $('#err_nama_pengalihan').html('')
                    } else {
                        $('#err_nama_pengalihan').html(d.err_nama_pengalihan)
                    }

                } else if (d.type == 'result') {
                    $('#err_kode_pengalihan').html('')
                    $('#err_nama_pengalihan').html('')

                    if (d.status == false) {
                        Swal.fire({
                            title: "Error",
                            text: d.msg,
                            icon: "error"
                        }).then((res) => {
                            window.location.reload()
                        });
                    } else {
                        Swal.fire({
                            title: "Success",
                            text: d.msg,
                            icon: "success"
                        }).then((res) => {
                            window.location.reload()
                        });
                    }
                }
            },
            error: function(xhr, status, error) {
                $('#to_submit').removeAttr('disabled')
                $('#to_submit').html('Save')
                error_alert(error)
            }
        })
    })

    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }

    function delete_pengalihan(id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus Jenis Pengalihan Tanah ini?",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                to_delete_pengalihan(id)
            }
        });
    }

    function to_delete_pengalihan(id) {
        $.ajax({
            url: '<?= base_url('ajax/delete_pengalihan') ?>',
            data: {
                id: id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                if (d.status == false) {
                    Swal.fire({
                        title: "Error",
                        text: d.msg,
                        icon: "error"
                    }).then((res) => {
                        window.location.reload()
                    });
                } else {
                    Swal.fire({
                        title: "Success",
                        text: d.msg,
                        icon: "success"
                    }).then((res) => {
                        window.location.reload()
                    });
                }
            },
            error: function(xrh, status, error) {
                error_alert(error)
            }
        })
    }
</script>