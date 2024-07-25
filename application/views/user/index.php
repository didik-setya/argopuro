<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Settings</h3>

                <div class="card">
                    <div class="card-body">

                        <form action="<?= base_url('user/first_validation') ?>" id="first_form" method="post">
                            <div class="form-group row my-3">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" name="username" class="form-control" id="username" required value="<?= $user->username ?>">
                                    <small class="text-danger" id="err_username"></small>
                                </div>
                            </div>

                            <div class="form-group row my-3">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" id="name" required value="<?= $user->nama ?>">
                                    <small class="text-danger" id="err_name"></small>
                                </div>
                            </div>

                            <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-save"></i> Save</button>
                            <button class="btn btn-sm btn-primary" type="button" id="change_pass_btn"><i class="fa fa-key"></i> Change Password</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Modal -->
<div class="modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-light" id="staticBackdropLabel">Change Password</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/validation_pass') ?>" id="form_pass" method="post">
                <div class="modal-body">
                    <div class="form-group row my-2">
                        <label for="old_pass" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="old_pass" class="form-control" id="old_pass" required>
                            <small class="text-danger" id="err_old_pass"></small>
                        </div>
                    </div>

                    <div class="form-group row my-2">
                        <label for="new_pass" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="new_pass" class="form-control" id="new_pass" required>
                            <small class="text-danger" id="err_new_pass"></small>
                        </div>
                    </div>

                    <div class="form-group row my-2">
                        <label for="repeat_new_pass" class="col-sm-2 col-form-label">Repeat New Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="repeat_new_pass" class="form-control" id="repeat_new_pass" required>
                            <small class="text-danger" id="err_repeat_new_pass"></small>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $('#first_form').submit(function(e) {
        e.preventDefault();
        loading()

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                setTimeout(() => {
                    Swal.close()
                    if (d.type == 'validation') {
                        if (d.err_name == '') {
                            $('#err_name').html('')
                        } else {
                            $('#err_name').html(d.err_name)
                        }

                        if (d.err_username == '') {
                            $('#err_username').html('')
                        } else {
                            $('#err_username').html(d.err_username)
                        }
                    } else if (d.type == 'result') {
                        $('#err_name').html('')
                        $('#err_username').html('')

                        if (d.status == false) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: d.msg
                            }).then((res) => {
                                window.location.reload()
                            });
                        } else {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: d.msg
                            }).then((res) => {
                                window.location.reload()
                            });
                        }
                    }
                }, 1200);
            },
            error: function(xhr, status, error) {
                setTimeout(() => {
                    Swal.close()
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: error
                    });
                }, 1200);

            }
        })

    })

    $('#change_pass_btn').click(function() {
        $('#staticBackdrop').modal('show')

        $('#old_pass').val('');
        $('#new_pass').val('');
        $('#repeat_new_pass').val('');

        $('#err_old_pass').html('');
        $('#err_new_pass').html('');
        $('#err_repeat_new_pass').html('');
    })

    $('#form_pass').submit(function(e) {
        e.preventDefault();
        loading();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'json',
            success: function(d) {
                setTimeout(() => {
                    Swal.close()
                    if (d.type == 'validation') {
                        if (d.err_old_pass == '') {
                            $('#err_old_pass').html('')
                        } else {
                            $('#err_old_pass').html(d.err_old_pass)
                        }

                        if (d.err_new_pass == '') {
                            $('#err_new_pass').html('')
                        } else {
                            $('#err_new_pass').html(d.err_new_pass)
                        }

                        if (d.err_repeat_new_pass == '') {
                            $('#err_repeat_new_pass').html('')
                        } else {
                            $('#err_repeat_new_pass').html(d.err_repeat_new_pass)
                        }
                    } else if (d.type == 'result') {
                        $('#staticBackdrop').modal('hide')
                        if (d.status == false) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: d.msg
                            }).then((res) => {
                                window.location.reload()
                            });
                        } else {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: d.msg
                            }).then((res) => {
                                window.location.reload()
                            });
                        }
                    }
                }, 1200);
            },
            error: function(xhr, status, error) {
                setTimeout(() => {
                    Swal.close()
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: error
                    });
                }, 1200);
            }
        })
    })

    function loading() {
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