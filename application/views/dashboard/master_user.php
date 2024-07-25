<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Master User</h3>

                <div class="card">
                    <div class="card-body">

                        <button class="btn btn-sm btn-success mb-3" onclick="add_user()"><i class="fa fa-plus"></i> Tambah</button>

                        <table class="table table-bordered table-sm w-100" id="table">
                            <thead>
                                <tr class="bg-secondary">
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Role</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($data as $d) { ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d->nama_user ?></td>
                                        <td><?= $d->username ?></td>
                                        <td>
                                            <?php if ($d->is_active == 1) {
                                                echo '<span class="badge badge-success">Aktif</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">Nonaktif</span>';
                                            } ?>
                                        </td>
                                        <td><?= $d->nama_role ?></td>
                                        <td>
                                            <div class="dropdown dropleft">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                </button>
                                                <div class="dropdown-menu">
                                                    <?php if ($d->is_active == 1) { ?>
                                                        <a class="dropdown-item" href="#" onclick="action_status('0', '<?= $d->id ?>', 'status')">Nonaktifkan</a>
                                                    <?php } else { ?>
                                                        <a class="dropdown-item" href="#" onclick="action_status('1', '<?= $d->id ?>', 'status')">Aktifkan</a>
                                                    <?php } ?>
                                                    <a class="dropdown-item" href="#" onclick="delete_user('<?= $d->id ?>', '<?= $d->username ?>', '<?= $d->nama ?>', '<?= $d->id_role ?>')">Edit</a>
                                                    <a class="dropdown-item" href="#" onclick="action_status('0', '<?= $d->id ?>', 'delete')">Hapus</a>
                                                </div>
                                            </div>
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
<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ajax/validation_user') ?>" id="form_user" method="post">
                <input type="hidden" name="act" id="act">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Role User</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">--pilih--</option>
                            <?php foreach ($role as $r) { ?>
                                <option value="<?= $r->id ?>"><?= $r->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" id="nama" required class="form-control">
                        <small class="text-danger" id="err_nama"></small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Username</label>
                        <input type="text" name="username" id="username" required class="form-control">
                        <small class="text-danger" id="err_username"></small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Password Baru</label>
                        <input type="password" name="new_pass" id="new_pass" required class="form-control">
                        <small class="text-danger" id="err_new_pass"></small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Ulangi Password Baru</label>
                        <input type="password" name="repeat_pass" id="repeat_pass" required class="form-control">
                        <small class="text-danger" id="err_repeat_pass"></small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="to_submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    $(document).ready(function() {
        new DataTable('#table');
    })


    function add_user() {
        $('#exampleModal').modal('show')
        $('#exampleModal').find('.modal-title').html('Tambah User Baru');

        $('#err_nama').html('')
        $('#err_username').html('')
        $('#err_new_pass').html('')
        $('#err_repeat_pass').html('')

        $('#act').val('add');
        $('#id').val('');
        $('#role').val('');
        $('#nama').val('');
        $('#username').val('');
        $('#new_pass').val('');
        $('#repeat_pass').val('');

    }

    function delete_user(id, username, nama, role) {
        $('#exampleModal').modal('show')
        $('#exampleModal').find('.modal-title').html('Edit User');

        $('#err_nama').html('')
        $('#err_username').html('')
        $('#err_new_pass').html('')
        $('#err_repeat_pass').html('')

        $('#act').val('edit');
        $('#id').val(id);
        $('#role').val(role);
        $('#nama').val(nama);
        $('#username').val(username);
        $('#new_pass').val('');
        $('#repeat_pass').val('');
    }

    function action_status(status, id, act) {
        $.ajax({
            url: '<?= base_url('ajax/action_user') ?>',
            data: {
                id: id,
                status: status,
                act: act
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
            error: function(xhr, status, error) {
                error_alert(error)
            }
        })
    }

    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }

    $('#form_user').submit(function(e) {
        e.preventDefault();
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
                    if (d.err_nama == '') {
                        $('#err_nama').html('')
                    } else {
                        $('#err_nama').html(d.err_nama)
                    }

                    if (d.err_username == '') {
                        $('#err_username').html('')
                    } else {
                        $('#err_username').html(d.err_username)
                    }

                    if (d.err_new_pass == '') {
                        $('#err_new_pass').html('')
                    } else {
                        $('#err_new_pass').html(d.err_new_pass)
                    }

                    if (d.err_repeat_pass == '') {
                        $('#err_repeat_pass').html('')
                    } else {
                        $('#err_repeat_pass').html(d.err_repeat_pass)
                    }

                } else if (d.type == 'result') {
                    $('#err_nama').html('')
                    $('#err_username').html('')
                    $('#err_new_pass').html('')
                    $('#err_repeat_pass').html('')

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
</script>