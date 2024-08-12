<?php
$data = $this->laporan->get_data_has_splitsing()->result();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3>Evaluasi Proses Splitsing</h3>

                <button class="btn btn-sm btn-success" onclick="add_data()"><i class="fa fa-plus"></i> Tambah Splitsing</button>

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
                                            <div class="btn-group dropleft">
                                                <button type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-cogs"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Dropdown menu links -->
                                                    <a class="dropdown-item" href="#" onclick="detail_splitsing('<?= $d->id ?>')">Detail</a>
                                                    <a class="dropdown-item" href="#" onclick="edit_splitsing('<?= $d->id ?>')">Edit</a>
                                                    <a class="dropdown-item" href="#" onclick="delete_data('<?= $d->id ?>')">Hapus</a>

                                                    <?php if ($d->sisa_from_induk > 0) { ?>
                                                        <a class="dropdown-item" href="#" onclick="add_split('<?= $d->induk_id ?>', '<?= $d->no_terbit_shgb ?>', '<?= $d->sisa_induk ?>')">Tambah Splitsing</a>
                                                    <?php } ?>
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
    </div>
</section>


<!-- Modal -->
<div class="modal" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-danger text-light">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Splitsing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-light" aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('ajax_laporan/act_evaluasi_splitsing', 'class="form_add_splitsing"') ?>
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="act" id="action">
            <div class="modal-body row">
                <div class="form-group col-md-4">
                    <label><b>Induk</b></label>
                    <select name="induk" id="induk" class="form-control" required>
                        <option value="">--pilih--</option>
                        <?php foreach ($induk as $i) { ?>
                            <option value="<?= $i->id ?>" data-terbit="<?= $i->luas_terbit ?>"><?= $i->no_terbit_shgb ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label><b>Luas</b></label>
                    <input type="text" name="lterbit" readonly id="Lterbit" class="form-control">
                </div>

                <div class="form-group col-md-4">
                    <label><b>Status</b></label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">--pilih--</option>
                        <option value="proses">Proses</option>
                        <option value="terbit">Terbit</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label><b>No. Daftar</b></label>
                    <input type="text" name="no_daftar" id="no_daftar" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label><b>Tgl. Daftar</b></label>
                    <input type="date" name="tgl_daftar" id="tgl_daftar" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label><b>Masa Berlaku</b></label>
                    <input type="date" name="masa_berlaku" id="masa_berlaku" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label><b>Tgl. Terbit</b></label>
                    <input type="date" name="tgl_terbit" id="tgl_terbit" class="form-control">
                </div>


                <div class="col-12 mt-3">
                    <table class="table table-sm table-bordered" id="table_splitsing">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>Blok</th>
                                <th>Luas Daftar</th>
                                <th>Luas Terbit</th>
                                <th>No. SHGB</th>
                                <th>Ket</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="add_list_splitsing('1')"><i class="fa fa-plus"></i> Form Splitsing</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>


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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-danger text-light">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-light" aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('ajax_laporan/act_evaluasi_splitsing', 'class="form_add_splitsing"') ?>
            <input type="hidden" name="id" id="id_edit">
            <input type="hidden" name="act" id="action" value="edit">
            <div class="modal-body row">
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
                                <th>Luas Daftar</th>
                                <th>Luas Terbit</th>
                                <th>No. SHGB</th>
                                <th>Ket</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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


<!-- Modal tambah split dari sisa-->
<div class="modal" id="modalFromSplit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Splitsing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-light" aria-hidden="true">&times;</span>
                </button>
            </div>


            <?= form_open('ajax_laporan/act_evaluasi_splitsing', 'class="form_add_splitsing"') ?>
            <input type="hidden" name="act" value="add_from_split">
            <div class="modal-body table-responsive ">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><b>Induk</b></label>
                        <input type="text" name="induk_show" id="induk_split" class="form-control" readonly>
                        <input type="hidden" name="induk" id="induk_split_hidden">
                    </div>

                    <div class="form-group col-md-4">
                        <label><b>Luas</b></label>
                        <input type="text" name="luas" id="luas_split" class="form-control" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label><b>Status</b></label>
                        <select name="status" id="status_split" class="form-control" required>
                            <option value="">--pilih--</option>
                            <option value="proses">Proses</option>
                            <option value="terbit">Terbit</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label><b>No. Daftar</b></label>
                        <input type="text" name="no_daftar" id="no_daftar_split" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label><b>Tgl. Daftar</b></label>
                        <input type="date" name="tgl_daftar" id="tgl_daftar_split" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label><b>Masa Berlaku</b></label>
                        <input type="date" name="masa_berlaku" id="masa_berlaku_split" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label><b>Tgl. Terbit</b></label>
                        <input type="date" name="tgl_terbit" id="tgl_terbit_split" class="form-control">
                    </div>


                    <div class="col-12">
                        <table class="table table-bordered table-sm" id="table_splitsing_new">
                            <thead>
                                <tr class="bg-primary text-light">
                                    <th>#</th>
                                    <th>Blok</th>
                                    <th>Luas Daftar</th>
                                    <th>Luas Terbit</th>
                                    <th>No. SHGB</th>
                                    <th>Ket</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="add_list_splitsing('2')"><i class="fa fa-plus"></i> Form Splitsing</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>

        </div>
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

    function add_data() {
        $('#modalAdd').modal('show')
        $('#modalAdd .modal-title').html('Tambah Data Splitsing')


        $('#id').val('');
        $('#action').val('add');
        $('#induk').val('');
        $('#Lterbit').val('');
        $('#status').val('');
        $('#no_daftar').val('');
        $('#tgl_daftar').val('');

        $('#table_splitsing tbody').html('')
    }

    let select = document.getElementById('induk');
    select.addEventListener('change', function() {
        let selectedOpt = select.options[select.selectedIndex]
        let luas = selectedOpt.getAttribute('data-terbit');
        $('#Lterbit').val(luas);
        $('#table_splitsing tbody').html('')
    })

    function add_list_splitsing(id) {
        let induk = $('#induk').val();
        let html = '<tr> <td><button class="btn btn-xs btn-danger delete_form_split" type="button"><i class="fa fa-trash"></i></button></td><td><input type="text" class="form-control" name="blok[]" required></td> <td><input type="number" class="form-control" name="l_dft[]" required></td> <td><input type="number" class="form-control" name="l_tbt[]"></td> <td><input type="text" class="form-control" name="shgb[]"></td> <td><textarea class="form-control" name="ket[]"></textarea></td></tr>';

        if (id == 1) {
            if (induk) {
                $('#table_splitsing').find('tbody').append(html)
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Harap pilih induk'
                })
            }
        } else if (id == 2) {
            $('#table_splitsing_new').find('tbody').append(html)
        }


    }

    $(document).on('click', '.delete_form_split', function() {
        $(this).parent('td').parent('tr').remove();
    })

    $('.form_add_splitsing').submit(function(e) {
        e.preventDefault();
        loading_animation();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
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
                            $('#modalAdd').modal('hide')
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


    function detail_splitsing(id) {
        loading_animation();
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_evaluasi_splitsing') ?>',
            type: 'POST',
            data: {
                act: 'detail',
                id: id
            },
            success: function(d) {
                setTimeout(() => {
                    Swal.close()
                    $('#modalDetail').modal('show')
                    $('#modalDetail').find('.modal-body').html(d)
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

    function edit_splitsing(id, type = null) {
        $('#modalEdit').modal('show')
        $('#modalEdit .modal-title').html('Edit Data Splitsing')

        $('#id_edit').val(id);
        $('#induk_edit').val('');
        $('#Lterbit_edit').val('');
        $('#status_edit').val('');
        $('#no_daftar_edit').val('');
        $('#tgl_daftar_edit').val('');

        $('#table_splitsing_edit tbody').html('')
        getting_data_for_edit(id, type)
    }

    function getting_data_for_edit(id, type = null) {
        loading_animation();
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_evaluasi_splitsing') ?>',
            data: {
                act: 'data_edit',
                id: id,
                type: type
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                setTimeout(() => {
                    Swal.close();
                    let data = d.data;
                    let split = d.splitsing;
                    let i;
                    let html_table = '';
                    let fst_splitsing = split[0];


                    $('#induk_edit').val(data.no_terbit_shgb);
                    $('#Lterbit_edit').val(data.sisa_from_induk)
                    $('#status_edit').val(data.status)
                    $('#no_daftar_edit').val(data.no_daftar)
                    $('#tgl_daftar_edit').val(data.tgl_daftar)

                    $('#masa_berlaku_edit').val(fst_splitsing.masa_berlaku)
                    $('#tgl_terbit_edit').val(fst_splitsing.tgl_terbit)

                    for (i = 0; i < split.length; i++) {
                        html_table += '<tr> <td><button class="btn btn-xs btn-danger" type="button" onclick="delete_split(' + split[i].id + ')"><i class="fa fa-trash"></i></button> <input type="hidden" name="id_split[]" value="' + split[i].id + '"> </td><td><input value="' + split[i].blok + '" type="text" class="form-control" name="blok[]" required></td> <td><input value="' + split[i].luas_daftar + '" type="number" class="form-control" name="l_dft[]" required></td> <td><input value="' + split[i].luas_terbit + '" type="number" class="form-control" name="l_tbt[]"></td> <td><input value="' + split[i].no_shgb + '" type="text" class="form-control" name="shgb[]"></td> <td><textarea class="form-control" name="ket[]">' + split[i].keterangan + '</textarea></td></tr>';
                    }
                    $('#table_splitsing_edit tbody').html(html_table)
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

    function delete_split(id) {
        Swal.fire({
            icon: "warning",
            title: "Apakah anda yakin?",
            text: "Data akan di hapus permanen",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                proccess_delete_split(id)
            }
        });
    }

    function proccess_delete_split(id) {
        loading_animation()
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_evaluasi_splitsing') ?>',
            data: {
                id: id,
                act: 'delete_split'
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                setTimeout(() => {
                    Swal.close()
                    if (d.status == false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: d.msg
                        }).then((res) => {
                            getting_data_for_edit(d.id)
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg
                        }).then((res) => {
                            getting_data_for_edit(d.id)
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
    }

    function delete_data(id) {
        Swal.fire({
            icon: "warning",
            title: "Apakah anda yakin?",
            text: "Data akan di hapus permanen",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                to_delete_data(id)
            }
        });
    }

    function to_delete_data(id) {
        loading_animation()
        $.ajax({
            url: '<?= base_url('ajax_laporan/act_evaluasi_splitsing') ?>',
            data: {
                id: id,
                act: 'delete_data'
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                setTimeout(() => {
                    Swal.close();
                    if (d.status == false) {
                        error_alert(d.msg)
                    } else {
                        Swal.fire({
                            icon: "success",
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
    }


    function add_split(id, induk_name, sisa_luas) {
        $('#modalFromSplit').modal('show')
        $('#induk_split').val(induk_name)
        $('#induk_split_hidden').val(id)
        $('#luas_split').val(sisa_luas)

        $('#status_split').val('')
        $('#no_daftar_split').val('')
        $('#tgl_daftar_split').val('')
        $('#masa_berlaku_split').val('')
        $('#tgl_terbit_split').val('')

        $('#table_splitsing_new tbody').html('')
    }



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