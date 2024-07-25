<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">

                <div class="form-group mt-lg">
                </div>
                <h3>Data Pembayaran Tanah</h3>
                <div class="card">
                    <div class="card-body table-responsive">
                        <form action="<?php echo site_url('export/pembayaran_master_tanah/' . $id_tanah->id) ?>" method="get">
                            <div class="row">

                                <div class="col-3">
                                    <div class="form-group">
                                        <input type="date" name="firstdate" id="firstdate" class="form-control" onchange="refresh()" />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <input type="date" name="lastdate" id="lastdate" class="form-control" onchange="refresh()" />
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-sm" type="submit">
                                            <i class="fa fa-print"></i> Cetak
                                        </button>
                                        <a class="btn btn-sm btn-success " onclick="add_pembayaran()"><i class="fa fa-plus"></i> Tambah Pembayaran</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-4">
                                <div class="card card-outline card-warning" style="max-width: 18rem;">

                                    <div class="card-body">
                                        <p class="font-weight-normal">Total Belum Dibayar</p>
                                        <h5 class="card-text font-weight-bold"><?= $total_belum_dibayar ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card card-outline card-success" style="max-width: 18rem;">
                                    <div class="card-body">
                                        <p class="font-weight-normal">Total Terbayar</p>
                                        <h5 class="card-text font-weight-bold"><?= $pembayaran_terakhir ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card card-outline card-info" style="max-width: 18rem;">
                                    <div class="card-body">
                                        <p class="font-weight-normal">Harga Beli</p>
                                        <h5 class="card-text font-weight-bold"><?= $harga_beli ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table class="table table-bordered" id="table_pembayaran">
                            <thead>
                                <tr class="text-center">
                                    <th style="vertical-align: middle;"><i class="fa fa-cogs"></i></th>
                                    <th style="vertical-align: middle;">No. Pembayaran</th>
                                    <th style="vertical-align: middle;">Tanggal Pembayaran</th>
                                    <th style="vertical-align: middle;">Tanggal Realisasi</th>
                                    <th style="vertical-align: middle;">Nominal</th>
                                    <th style="vertical-align: middle;">Status Pembayaran</th>
                                    <th style="vertical-align: middle;">Keterangan</th>
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

<!-- Modal Tambah -->
<div class="modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ajax_tanah/to_action_pembayaran') ?>" id="form_pembayaran" method="post">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="act" id="act">
                <input type="hidden" id="total_belum_bayar" value="<?= $limit ?>" name="limit" />
                <input type="hidden" value="<?= $tanah_id ?>" name="tanah_id">

                <div class="modal-body" id="form_inputan">

                    <div class="row mb-3">
                        <div class="col-3">
                            <input type="date" id="tgl_pembayaran" autocomplete="off" name="tgl_pembayaran[]" class="form-control " placeholder="Tanggal Pembayaran" required />
                        </div>
                        <div class="col-3">
                            <input type="text" id="total_bayar" autocomplete="off" name="total_bayar[]" class="form-control mask-money" placeholder="Nominal" required />
                        </div>
                        <div class="col-3">
                            <select name="status_bayar[]" id="status_bayar" class="form-control" required>
                                <option value="">--pilih--</option>
                                <option value="1">Belum Terbayar</option>
                                <option value="2">Sudah Terbayar</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <input type="text" id="ket" name="ket[]" class="form-control tanggalformat" placeholder="Keterangan" />
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-success mr-auto" id="tambah_form" type="button"><i class="fa fa-plus"></i> Tambah Form Pembayaran</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="to_submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ajax_tanah/to_action_pembayaran') ?>" id="form_pembayaran_edit" method="post">
                <input type="hidden" name="id" id="id_edit">
                <input type="hidden" name="act" id="act" value="edit">
                <input type="hidden" id="total_belum_bayar" value="<?= $limit ?>" name="limit" />
                <input type="hidden" value="<?= $tanah_id ?>" name="tanah_id">

                <div class="modal-body" id="form_inputan">

                    <div class="form-group mb-3">
                        <label>Tanggal Pembayaran</label>
                        <input type="date" id="tgl_pembayaran_edit" autocomplete="off" name="tgl_pembayaran" class="form-control " />
                    </div>
                    <div class="form-group mb-3">
                        <label>Tanggal Realisasi</label>
                        <input type="date" id="tgl_realisasi_edit" autocomplete="off" name="tgl_realisasi" class="form-control " />
                    </div>
                    <div class="form-group mb-3">
                        <label>Nominal Pembayaran</label>
                        <input type="text" id="total_bayar_edit" autocomplete="off" name="total_bayar" class="form-control mask-money" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Status Pembayaran</label>
                        <select name="status_bayar" id="status_bayar_edit" class="form-control">
                            <option value="">--pilih--</option>
                            <option value="1">Belum Terbayar</option>
                            <option value="2">Sudah Terbayar</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Keterangan Pembayaran</label>
                        <textarea class="form-control" name="ket" id="ket_edit" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="to_submit_edit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    $('.mask-money').mask("#.##0", {
        reverse: true
    });

    var tablehutang = $('#table_pembayaran').DataTable({
        "serverSide": true,
        "ordering": false,
        "searching": false,
        "order": [],
        "ajax": {
            url: "<?= base_url() ?>ajax_tanah/get_data_pembayaran/" + <?= $tanah_id; ?>,
            type: 'GET'
        },
        "columnDefs": [{
            "targets": [0],
            "orderable": false,
        }, ],
    });

    function add_pembayaran() {
        $('#staticBackdrop').modal('show')
        $('.modal-title').html('Tambah Pembayaran Baru')

        $('#act').val('add');
        $('#tgl_pembayaran').val('');
        $('#total_bayar').val('');
        $('#status_bayar').val('');
        $('#ket').val('');
    }

    function edit_pembayaran(id) {
        $('#modalEdit').modal('show')
        $('.modal-title').html('Edit Pembayaran')

        $('#id_edit').val(id)
        $('#tgl_pembayaran_edit').val('')
        $('#tgl_realisasi_edit').val('')
        $('#total_bayar_edit').val('')
        $('#status_bayar_edit').val('')
        $('#ket_edit').val('')
        get_detail_pembayaran(id)
    }

    function get_detail_pembayaran(id) {
        $.ajax({
            url: '<?= base_url('ajax_tanah/detail_pembayaran') ?>',
            data: {
                id: id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {

                $('#tgl_pembayaran_edit').val(d.tgl_pembayaran)
                $('#tgl_realisasi_edit').val(d.tgl_realisasi)
                $('#total_bayar_edit').val(d.total_bayar)
                $('#status_bayar_edit').val(d.status_bayar)
                $('#ket_edit').val(d.ket)

            },
            error: function(xhr, status, error) {
                error_alert(error)
            }
        })
    }

    function delete_pembayaran(id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus Pembayaran Tanah ini?",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                to_delete_pembayaran(id)
            }
        });
    }

    function to_delete_pembayaran(id) {
        $.ajax({
            url: '<?= base_url('ajax_tanah/delete_pembayaran') ?>',
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

    $('#form_pembayaran').submit(function(e) {
        e.preventDefault();
        $('.mask-money').unmask();
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

                if (d.status == false) {
                    error_alert(d.msg)
                    $('#staticBackdrop').modal('hide')
                } else {
                    Swal.fire({
                        title: "Success",
                        text: d.msg,
                        icon: "success"
                    }).then((res) => {
                        $('#staticBackdrop').modal('hide')
                        window.location.reload()
                    });
                }
            },
            error: function(xhr, status, error) {
                $('#to_submit').removeAttr('disabled')
                $('#to_submit').html('Save')
                error_alert(error)
            }
        })
    })

    $('#form_pembayaran_edit').submit(function(e) {
        e.preventDefault();
        $('.mask-money').unmask();
        $('#to_submit_edit').attr('disabled', true)
        $('#to_submit_edit').html(spinner)

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#to_submit_edit').removeAttr('disabled')
                $('#to_submit_edit').html('Save')

                if (d.status == false) {
                    error_alert(d.msg)
                    $('#modalEdit').modal('hide')
                } else {
                    Swal.fire({
                        title: "Success",
                        text: d.msg,
                        icon: "success"
                    }).then((res) => {
                        $('#modalEdit').modal('hide')
                        window.location.reload()
                    });
                }
            },
            error: function(xhr, status, error) {
                $('#to_submit_edit').removeAttr('disabled')
                $('#to_submit_edit').html('Save')
                error_alert(error)
            }
        })
    })

    $(document).ready(function() {
        var max_fields = 10; //maximum input boxes allowed
        var wrapper = $("#form_inputan"); //Fields wrapper
        var add_button = $("#tambah_form"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('' +
                    ' <div class="row"> <div class="form-group col-sm-12 col-md-2 mt-3"> <label><strong>Tanggal</strong></label> <input required type="date" id="tgl_pembayaran" name="tgl_pembayaran[]" class="form-control tanggalformat" placeholder="Tanggal Pembayaran" /> </div> <div class="form-group col-sm-12 col-md-3 mt-3"><label><strong>Nominal</strong></label> <input class="form-control mask-money" type="text" name="total_bayar[]" id="total_bayar" placeholder="Nominal" required> </div> <div class="form-group col-sm-12 col-md-3 mt-3"><label><strong>Status</strong></label> <select class="form-control" name="status_bayar[]" id="status_bayar" class="select2" style="width: 100%" required> <option value="">--pilih--</option><option value="1">Belum Terbayar</option><option value="2">Sudah Terbayar</option> </select> </div> <div class="form-group col-sm-12 col-md-2 mt-3"><label><strong>Keterangan</strong></label> <input type="text" name="ket[]" id="ket" class="form-control" placeholder="Keterangan"> </div> <div class="form-group col-sm-12 col-md-2 mt-3 d-flex justify-content-center align-items-end"><button class="btn btn-danger delete_form mt-3">Hapus</button></div>  </div>'
                ); //add input box
            }

            $('.mask-money').mask("#.##0", {
                reverse: true
            });

        });
        $(document).on('click', '.delete_form', function() {
            $(this).parent('div').parent('div').remove();
        })
    });

    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }
</script>