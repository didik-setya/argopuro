<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="shortcut icon" href="<?= base_url('assets/img/web/gb_icon.png') ?>" type="image/x-icon">

    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/fontawesome-free/css/all.min.css">

    <script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            background-image: url('<?= base_url() ?>/assets/img/web/bg.jpg');
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
        <div class="col-12 col-sm-12 col-md-8 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/web/logo_gb.png') ?>" alt="logo" width="55%">

                        <form action="<?= base_url('login/validation_login') ?>" method="post">
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="username" id="username">
                            </div>
                            <small class="text-danger" id="err_username"></small>


                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Password" aria-label="password" aria-describedby="basic-addon1" name="password" id="password">
                            </div>
                            <small class="text-danger" id="err_password"></small>


                            <button class="btn btn-success w-100 mt-3" id="to_login" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $('form').submit(function(e) {
        e.preventDefault()
        let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        $('#to_login').attr('disabled', true)
        $('#to_login').html(spinner)
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#to_login').removeAttr('disabled')
                $('#to_login').html('Login')

                if (d.type == 'validation') {
                    if (d.err_username == '') {
                        $('#err_username').html('')
                    } else {
                        $('#err_username').html(d.err_username)
                    }

                    if (d.err_password == '') {
                        $('#err_password').html('')
                    } else {
                        $('#err_password').html(d.err_password)
                    }
                } else if (d.type == 'result') {
                    $('#err_username').html('')
                    $('#err_password').html('')

                    if (d.status == false) {
                        error_alert(d.msg)
                    } else {
                        Swal.fire({
                            title: "Success",
                            text: d.msg,
                            icon: "success"
                        }).then((res) => {
                            window.location.href = d.redirect
                        });
                    }

                }
            },
            error: function(xhr, status, error) {
                $('#to_login').removeAttr('disabled')
                $('#to_login').html('Login')
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
</script>

</html>