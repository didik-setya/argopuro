<?php
$data = $this->laporan->get_data_has_splitsing(null, 'induk')->result();
$data2 = $this->laporan->get_data_has_splitsing(null, 'penggabungan')->result();
$data0 = $this->laporan->get_data_has_splitsing()->result();

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
                                    <th>Proyek</th>
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
                                        <td><?= $d->nama_proyek ?></td>
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
                                                        <a class="dropdown-item" onclick="edit_data('<?= $d->id_splitsing ?>',  '<?= $d->sumber_induk ?>')" href="#"><i class="fa fa-edit"></i> Edit</a>
                                                        <a class="dropdown-item" onclick="detail_data('<?= $d->id_splitsing ?>')" href="#"><i class="fas fa-search"></i> Detail</a>
                                                    </div>
                                                </div>
                                            <?php } else if ($d->data_locked == 0) { ?>
                                                <button disabled class="btn btn-sm btn-secondary"><i class="fa fa-cogs"></i></button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>


                                <?php
                                foreach ($data2 as $d) {
                                    $sisa_induk = $d->luas_induk - $d->total_luas_splitsing;
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d->nama_proyek ?></td>
                                        <td><?= $d->no_terbit_shgb ?></td>
                                        <td><?= $d->luas_induk ?></td>
                                        <td><?= $d->total_luas_splitsing ?></td>
                                        <td><?= $sisa_induk ?></td>
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
                                                        <a class="dropdown-item" onclick="edit_data('<?= $d->id_splitsing ?>', '<?= $d->sumber_induk ?>')" href="#"><i class="fa fa-edit"></i> Edit</a>
                                                        <a class="dropdown-item" onclick="detail_data('<?= $d->id_splitsing ?>')" href="#"><i class="fas fa-search"></i> Detail</a>
                                                    </div>
                                                </div>
                                            <?php } else if ($d->data_locked == 0) { ?>
                                                <button disabled class="btn btn-sm btn-secondary"><i class="fa fa-cogs"></i></button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>


                                <?php
                                foreach ($data0 as $d) {
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d->nama_proyek ?></td>
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
                                                        <a class="dropdown-item" onclick="edit_data('<?= $d->id_splitsing ?>',  '<?= $d->sumber_induk ?>')" href="#"><i class="fa fa-edit"></i> Edit</a>
                                                        <a class="dropdown-item" onclick="detail_data('<?= $d->id_splitsing ?>')" href="#"><i class="fas fa-search"></i> Detail</a>
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

                <div class="form-group col-md-3">
                    <label><b>Proyek</b></label>
                    <input type="text" name="proyek" id="proyek_edit" readonly class="form-control">
                </div>

                <div class="form-group col-md-3">
                    <label><b>Induk</b></label>
                    <select name="induk" id="induk_edit" class="form-control" required>
                        <option value="">--pilih--</option>
                    </select>
                    <input type="hidden" name="source" id="source_induk" value="">
                </div>

                <div class="form-group col-md-3">
                    <label><b>Luas</b></label>
                    <input type="text" name="lterbit" readonly id="Lterbit_edit" class="form-control">
                </div>

                <div class="form-group col-md-3">
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
                <button type="button" class="btn btn-outline-info" onclick="add_form_si()" id="add_si"><i class="fa fa-plus"></i> Form Sisa Induk</button>
                <button type="button" class="btn btn-outline-success" onclick="add_form_jf()" id="add_jf"><i class="fa fa-plus"></i> Form Jalan Fasos</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>




<script>
    let form_jf = '<tr><td class="text-center"><button data-toggle="tooltip" data-placement="top" title="Hapus Data" class="btn btn-sm btn-danger delete_form" type="button"><i class="fas fa-times-circle"></i></button></td><td><input type="text" name="new_blok[]" id="blok" required class="form-control" placeholder="Nama blok..."></td><td><input type="hidden" name="type[]" value="jf"> Jalan & Fasos </td><td><input type="number" class="form-control" name="luas_blok[]" id="luas_blok"></td><td><input required="" type="text" name="new_luas_terbit[]" id="luas_terbit" class="form-control" value=""></td><td><input required="" type="text" name="new_shgb_split[]" id="shgb" class="form-control" value=""></td><td><textarea name="new_ket[]" id="ket" class="form-control"></textarea></td></tr>'

    let form_si = '<tr><td class="text-center"><button data-toggle="tooltip" data-placement="top" title="Hapus Data" class="btn btn-sm btn-danger delete_form" type="button"><i class="fas fa-times-circle"></i></button></td><td><input type="text" name="new_blok[]" id="blok" required class="form-control" placeholder="Nama blok..."></td><td><input type="hidden" name="type[]" value="si"> Sisa Induk </td><td><input type="number" class="form-control" name="luas_blok[]" id="luas_blok"></td><td><input required="" type="text" name="new_luas_terbit[]" id="luas_terbit" class="form-control" value=""></td><td><input required="" type="text" name="new_shgb_split[]" id="shgb" class="form-control" value=""></td><td><textarea name="new_ket[]" id="ket" class="form-control"></textarea></td></tr>'

    $(document).ready(function() {
        $('#main_table thead tr th').addClass('text-left')
        $('#main_table').dataTable({
            ordering: false,
            // scrollX: true,
            autowidth: false
        })
    })

    function edit_data(id, source) {
        $('#id_edit').val(id)
        $('#induk_edit').val('')
        $('#Lterbit_edit').val('')
        $('#status_edit').val('')
        $('#no_daftar_edit').val('')
        $('#tgl_daftar_edit').val('')
        $('#masa_berlaku_edit').val('')
        $('#tgl_terbit_edit').val('')
        $('#table_splitsing_edit tbody').html('')


        get_data_for_edit(id, source)
    }

    function get_data_for_edit(id, source) {
        loading_animation()
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_evaluasi_splitsing') ?>',
            data: {
                id: id,
                act: 'data_edit',
                source: source
            },
            type: 'POST',
            dataType: 'json',
            success: function(d) {
                setTimeout(() => {
                    Swal.close()
                    let data = d.data
                    let split = d.splitsing
                    $('#induk_edit').removeAttr('readonly')
                    $('#proyek_edit').val(data.nama_proyek)
                    $('#Lterbit_edit').val(data.luas_induk)
                    $('#status_edit').val(data.status)
                    $('#no_daftar_edit').val(data.no_daftar)
                    $('#tgl_daftar_edit').val(data.tgl_daftar)
                    $('#source_induk').val(data.sumber_induk)
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
                        } else if (split[i].tipe == 'jf') {
                            tipe = 'Jalan & Fasos'
                        } else if (split[i].tipe == 'si') {
                            tipe = 'Sisa Induk'
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




                        html += '<tr><td>' + no++ + '<input type="hidden" name="id_split[]" id="id_split" value="' + split[i].id + '"></td><td>' + show_blok + '</td><td>' + tipe + '</td><td>' + split[i].luas_daftar + '</td><td><input required type="text" name="luas_terbit[]" id="luas_terbit" class="form-control" value="' + luas_terbit + '" required></td><td><input required type="text" name="shgb_split[]" id="shgb" class="form-control" value="' + no_shgb + '" required></td><td><textarea name="ket[]" id="ket" class="form-control" >' + split[i].keterangan + '</textarea></td></tr>'
                    }
                    $('#table_splitsing_edit tbody').html(html)

                    if (data.induk_id == '' || data.induk_id == 0) {
                        get_data_induk(data.proyek_id, 'ok gas', data.induk_id);
                    } else {
                        let select = '<option value="' + data.induk_id + '">' + data.no_terbit_shgb + '</option>';
                        $('#induk_edit').html(select)
                        $('#induk_edit').attr('readonly', true)
                        $('#modalEdit').modal('show')
                    }

                    if (data.status == 'terbit') {
                        $('#add_si').removeClass('d-none');
                        $('#add_jf').removeClass('d-none');
                    } else {
                        $('#add_si').addClass('d-none');
                        $('#add_jf').addClass('d-none');
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

    function get_data_induk(id, modal = null, checked = null) {
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_evaluasi_splitsing') ?>',
            data: {
                id: id,
                act: 'get_data_induk'
            },
            type: 'POST',
            dataType: 'json',
            error: function(xhr, status, error) {
                setTimeout(() => {
                    Swal.close()
                    error_alert(error)
                }, 200);
            },
            success: function(d) {
                let data_induk = d.data;
                let html = '<option value="">--pilih--</option>';
                let i;
                for (i = 0; i < data_induk.length; i++) {
                    html += '<option data-source="' + data_induk[i].type_source + '" data-luas="' + data_induk[i].luas_terbit + '" value="' + data_induk[i].id + '">' + data_induk[i].no_terbit_shgb + '</option>';
                }


                $('#induk_edit').html(html)
                if (modal) {
                    setTimeout(() => {
                        $('#modalEdit').modal('show')
                    }, 50);
                }

                if (checked && checked > 0) {
                    setTimeout(() => {
                        $('#induk_edit').val(checked)
                    }, 100);
                }
            }
        })
    }

    $('#induk_edit').change(function() {
        let selectedOption = $(this).find('option:selected');
        var dataLuas = selectedOption.data('luas');
        let dataSource = selectedOption.data('source')
        if (dataLuas) {
            $('#Lterbit_edit').val(dataLuas)
        } else {
            $('#Lterbit_edit').val('')
        }

        if (dataSource) {
            $('#source_induk').val(dataSource)
        } else {
            $('#source_induk').val('')
        }
    })

    function add_form_si() {
        $('#table_splitsing_edit tbody').append(form_si);
    }

    function add_form_jf() {
        $('#table_splitsing_edit tbody').append(form_jf);
    }

    $(document).on('click', '.delete_form', function() {
        $(this).closest('tr').remove();
    })





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