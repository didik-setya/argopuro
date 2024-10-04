<?php
$data = $this->laporan->get_data_has_splitsing()->result();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3>Evaluasi Proses Splitsing</h3>

                <div class="card mt-3">
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-bordered w-100" id="main_table">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>#</th>
                                    <th>Induk</th>
                                    <th>Luas Induk</th>
                                    <th>Total Luas Splitsing</th>
                                    <th>Sisa Induk</th>
                                    <th>No. Daftar</th>
                                    <th>Tgl. Daftar</th>
                                    <th>Status</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($data as $d) {
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d->no_terbit_shgb ?></td>
                                        <td><?= $d->luas_induk ?></td>
                                        <td><?= $d->total_luas_splitsing ?></td>
                                        <td><?= $d->sisa_from_induk ?></td>
                                        <td><?= $d->no_daftar ?></td>
                                        <td><?= tgl_indo($d->tgl_daftar) ?></td>
                                        <td><?= $d->status ?></td>
                                        <td>
                                            <?php if ($d->data_locked == 1) { ?>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-cogs"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="edit_data('<?= $d->id ?>')" href="#"><i class="fa fa-edit"></i> Edit</a>
                                                        <a class="dropdown-item" onclick="detail_data('<?= $d->id ?>')" href="#"><i class="fas fa-search"></i> Detail</a>
                                                    </div>
                                                </div>
                                            <?php } else if ($d->data_locked == 0) { ?>
                                                <button disabled class="btn btn-sm btn-secondary"><i class="fa fa-cogs"></i></button>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal" id="modalDetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title" id="staticBackdropLabel">Detail Splitsing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-scrollable modal-fullscreen">
        <?= form_open('ajax_laporan/act_evaluasi_splitsing', 'class="form_add_splitsing"') ?>

        <div class="modal-content">
            <div class="modal-header  bg-danger text-light">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-light" aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" name="id" id="id_edit">
            <input type="hidden" name="act" id="action" value="edit">
            <div class="modal-body row px-4">
                <div class="form-group col-md-4">
                    <label><b>Induk</b></label>
                    <input type="text" name="induk" id="induk_edit" readonly class="form-control">
                </div>

                <div class="form-group col-md-4">
                    <label><b>Luas</b></label>
                    <input type="text" name="lterbit" readonly id="Lterbit_edit" class="form-control">
                </div>

                <div class="form-group col-md-4">
                    <label><b>Status</b></label>
                    <select name="status" id="status_edit" class="form-control" required>
                        <option value="">--pilih--</option>
                        <option value="proses">Proses</option>
                        <option value="terbit">Terbit</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label><b>No. Daftar</b></label>
                    <input type="text" name="no_daftar" id="no_daftar_edit" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label><b>Tgl. Daftar</b></label>
                    <input type="date" name="tgl_daftar" id="tgl_daftar_edit" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label><b>Masa Berlaku</b></label>
                    <input type="date" name="masa_berlaku" id="masa_berlaku_edit" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label><b>Tgl. Terbit</b></label>
                    <input type="date" name="tgl_terbit" id="tgl_terbit_edit" class="form-control">
                </div>


                <div class="col-12 mt-3">
                    <table class="table table-sm table-bordered" id="table_splitsing_edit">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>Blok</th>
                                <th>Tipe</th>
                                <th>Luas Daftar</th>
                                <th>Luas Terbit</th>
                                <th>No. SHGB</th>
                                <th>Ket</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>




<script>
    $(document).ready(function() {
        $('#main_table thead tr th').addClass('text-left')
        $('#main_table').dataTable({
            ordering: false,
            // scrollX: true,
            autowidth: false
        })
    })

    function edit_data(id) {
        $('#id_edit').val(id)
        $('#induk_edit').val('')
        $('#Lterbit_edit').val('')
        $('#status_edit').val('')
        $('#no_daftar_edit').val('')
        $('#tgl_daftar_edit').val('')
        $('#masa_berlaku_edit').val('')
        $('#tgl_terbit_edit').val('')
        $('#table_splitsing_edit tbody').html('')


        get_data_for_edit(id)
    }

    function get_data_for_edit(id) {
        loading_animation()
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_evaluasi_splitsing') ?>',
            data: {
                id: id,
                act: 'data_edit'
            },
            type: 'POST',
            dataType: 'json',
            success: function(d) {
                setTimeout(() => {
                    Swal.close()
                    $('#modalEdit').modal('show')
                    let data = d.data
                    let split = d.splitsing

                    $('#induk_edit').val(data.no_terbit_shgb)
                    $('#Lterbit_edit').val(data.luas_induk)
                    $('#status_edit').val(data.status)
                    $('#no_daftar_edit').val(data.no_daftar)
                    $('#tgl_daftar_edit').val(data.tgl_daftar)
                    $('#masa_berlaku_edit').val(split[0].masa_berlaku)
                    $('#tgl_terbit_edit').val(split[0].tgl_terbit)


                    let i
                    let html = '';
                    let no = 1;
                    for (i = 0; i < split.length; i++) {
                        let show_blok = split[i].blok + ' (' + data.nama_proyek + ')';
                        let tipe = ''
                        let luas_terbit = ''
                        let no_shgb = ''
                        if (split[i].tipe == 'sp') {
                            tipe = 'Splitsing'
                        } else if (split[i].tipe == 'fs') {
                            tipe = 'Jalan & Fasos'
                        } else {
                            tipe = 'Unknow'
                        }

                        if (split[i].luas_terbit == null) {
                            luas_terbit = '';
                        } else {
                            luas_terbit = split[i].luas_terbit
                        }

                        if (split[i].no_shgb == null) {
                            no_shgb = ''
                        } else {
                            no_shgb = split[i].no_shgb
                        }




                        html += '<tr><td>' + no++ + '<input type="hidden" name="id_split[]" id="id_split" value="' + split[i].id + '"></td><td>' + show_blok + '</td><td>' + tipe + '</td><td>' + split[i].luas_daftar + '</td><td><input required type="text" name="luas_terbit[]" id="luas_terbit" class="form-control" value="' + luas_terbit + '"></td><td><input required type="text" name="shgb_split[]" id="shgb" class="form-control" value="' + no_shgb + '"></td><td><textarea name="ket[]" id="ket" class="form-control" >' + split[i].keterangan + '</textarea></td></tr>'
                    }
                    $('#table_splitsing_edit tbody').html(html)


                    console.log(d);
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

    function detail_data(id) {
        loading_animation()
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_evaluasi_splitsing') ?>',
            data: {
                id: id,
                act: 'detail'
            },
            type: 'POST',
            success: function(d) {
                setTimeout(() => {
                    Swal.close()
                    $('#modalDetail .modal-body').html(d)
                    $('#modalDetail').modal('show')
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





    $('.form_add_splitsing').submit(function(e) {
        e.preventDefault()
        loading_animation()
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'json',
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
                            window.location.reload()
                        })
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
    })


    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }

    function loading_animation() {
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