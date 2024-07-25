<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Master Sertifikat Tanah</h3>

                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-sm btn-success mb-3" onclick="add_sertifikat()"><i class="fa fa-plus"></i> Tambah</button>

                        <table class="table table-bordered table-sm" id="table_menu">
                            <thead>
                                <tr class="bg-secondary">
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Sertifikat</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($data as $d) { ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d->kode ?></td>
                                        <td><?= $d->nama_sertif ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="edit_sertifikat('<?= $d->id ?>')"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger" onclick="delete_sertifikat('<?= $d->id ?>')"><i class="fas fa-trash"></i></button>
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
            <form action="<?= base_url('ajax/validation_sertifikat') ?>" id="form_sertifikat" method="post">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="act" id="act">
                <div class="modal-body">

                    <div class="form-group mb-3">
                        <label>Kode Sertifikat</label>
                        <input type="text" name="kode" id="kode" class="form-control" required>
                        <small class="text-danger" id="err_kode"></small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Nama Sertifikat</label>
                        <input type="text" name="nama_sertif" id="nama_sertif" class="form-control" required>
                        <small class="text-danger" id="err_nama_sertif"></small>
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

    function add_sertifikat() {
        $('#staticBackdrop').modal('show')
        $('.modal-title').html('Tambah Sertifikat Baru')

        $('#err_kode').html('')
        $('#err_kode_sertif').html('')

        $('#act').val('add');
        $('#id').val('');
        $('#kode').val('')
        $('#nama_sertif').val('')
    }

    function edit_sertifikat(id) {
        $('#staticBackdrop').modal('show')
        $('.modal-title').html('Edit Master Sertifikat Tanah')

        $('#err_kode').html('')
        $('#err_kode_sertif').html('')

        $('#act').val('edit');
        $('#id').val(id);
        $('#kode').val('')
        $('#nama_sertif').val('')
        get_detail_sertifikat(id)
    }

    function get_detail_sertifikat(id) {
        $.ajax({
            url: '<?= base_url('ajax/detail_sertifikat') ?>',
            data: {
                id: id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#kode').val(d.kode)
                $('#nama_sertif').val(d.nama_sertif)

            },
            error: function(xhr, status, error) {
                error_alert(error)
            }
        })
    }

    $('#form_sertifikat').submit(function(e) {
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
                    if (d.err_kode == '') {
                        $('#err_kode').html('')
                    } else {
                        $('#err_kode').html(d.err_kode)
                    }

                    if (d.err_nama_sertif == '') {
                        $('#err_nama_sertif').html('')
                    } else {
                        $('#err_nama_sertif').html(d.err_nama_sertif)
                    }

                } else if (d.type == 'result') {
                    $('#err_kode').html('')
                    $('#err_nama_sertif').html('')

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

    function delete_sertifikat(id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus Master Sertifikat Tanah ini?",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                to_delete_sertifikat(id)
            }
        });
    }

    function to_delete_sertifikat(id) {
        $.ajax({
            url: '<?= base_url('ajax/delete_sertifikat') ?>',
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