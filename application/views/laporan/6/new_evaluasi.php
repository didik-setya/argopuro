<style>
    .btn-action::after {
        display: none;
    }
</style>
<section class="content-header">
    <div class="container-fluid">
        <h3>Evaluasi Data Penggabungan Induk</h3>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-lg-3">

                            </div>
                            <div class="col-lg-3">

                            </div>
                            <div class="col-lg-3">

                            </div>
                            <div class="col-lg-3 text-center">
                                <button class="btn btn-sm btn-primary" onclick="add_data()"><i class="fa fa-plus"></i> Tambah</button>
                            </div>
                            <div class="col-12 my-3">
                                <table class="table table-bordered table-sm" id="main_table">
                                    <thead>
                                        <tr class="bg-dark text-light text-center">
                                            <th rowspan="2"><i class="fa fa-cogs"></i></th>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Luas Terbit</th>

                                            <th colspan="2">Nomor</th>
                                            <th colspan="2">Tanggal</th>

                                            <th rowspan="2">Posisi</th>
                                            <th rowspan="2">Status</th>
                                            <th rowspan="2">Ket</th>
                                        </tr>

                                        <tr class="text-center text-light bg-danger">
                                            <th>Berkas</th>
                                            <th>SHGB</th>
                                            <th>Daftar</th>
                                            <th>Terbit</th>
                                        </tr>

                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Modal -->
<div class="modal" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Penggabungan</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('ajax_laporan/action_laporan_6', 'id="form_laporan"') ?>
            <input type="hidden" name="action" id="action">
            <input type="hidden" name="id" id="id_action">
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-lg-4 col-md-6 my-2">
                        <label><b>Luas Terbit</b></label>
                        <input type="text" name="luas_terbit" id="luas_terbit" class="form-control" required>
                    </div>

                    <div class="form-group col-lg-4 col-md-6 my-2">
                        <label><b>Status Penggabungan</b></label>
                        <select name="status_penggabungan" id="status_penggabungan" required class="form-control">
                            <option value="">--pilih--</option>
                            <option value="proses">Proses</option>
                            <option value="terbit">Terbit</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-4 col-md-6 my-2">
                        <label><b>Tgl. Daftar</b></label>
                        <input type="date" name="tgl_daftar" id="tgl_daftar" class="form-control" required>
                    </div>

                    <div class="form-group col-lg-4 col-md-6 my-2">
                        <label><b>Tgl. Terbit</b></label>
                        <input type="date" name="tgl_terbit" id="tgl_terbit" class="form-control">
                    </div>

                    <div class="form-group col-lg-4 col-md-6 my-2">
                        <label><b>No. Berkas</b></label>
                        <input type="text" name="berkas" id="berkas" class="form-control">
                    </div>

                    <div class="form-group col-lg-4 col-md-6 my-2">
                        <label><b>No. SHGB</b></label>
                        <input type="text" name="shgb" id="shgb" class="form-control">
                    </div>

                    <div class="form-group col-lg-4 col-md-6 my-2">
                        <label><b>Posisi</b></label>
                        <input type="text" name="posisi" id="posisi" class="form-control">
                    </div>

                    <div class="form-group col-lg-8 col-md-6 my-2">
                        <label><b>Keterangan</b></label>
                        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-sm" id="tbl_list_penggabungan">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th><i class="fa fa-cogs"></i></th>
                                    <th>Nama Proyek</th>
                                    <th>No. SHGB</th>
                                    <th>Blok</th>
                                    <th>Luas Surat</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_add_form" onclick="add_list_penggabungan()"><i class="fa fa-plus"></i> Tambah Form</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal add list-->
<div class="modal" id="modalList" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header bg-danger text-light">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Tanah</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <small><b>Pilih Kategori</b></small>
                        <select name="select_category" id="select_category" class="form-control mb-3">
                            <option value="">--pilih--</option>
                            <option value="induk" selected>Tanah Induk</option>
                            <option value="sisa_induk">Sisa Induk</option>
                            <option value="splitsing">Sudah Splitsing</option>
                        </select>
                    </div>

                    <div class="col-lg-12 table-responsive">
                        <table class="table table-bordered table-sm mb-3" id="dtbl_select_tanah">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>Nama Proyek</th>
                                    <th>No. SHGB</th>
                                    <th>Blok</th>
                                    <th>Luas Surat</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Ok</button>
            </div>
        </div>
    </div>
</div>


<!-- modal detail -->
<div class="modal" id="modalDetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="staticBackdropLabel">Detail Data</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
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
<script>
    $(document).ready(function() {
        load_main_data()
    })

    function load_main_data() {
        $('#main_table').DataTable().destroy()
        $('#main_table').dataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('ajax_laporan/dtbl_main_no_6') ?>",
                "type": "POST"
            },
            "columnDefs": [{}],
            "ordering": false,
            "iDisplayLength": 10,
            "autoWidth": false
        });
    }

    function add_data() {
        $('#modalAdd').modal('show')
        $('#modalAdd h5').html('Tambah Penggabungan')
        $('#btn_add_form').removeClass('d-none');
        $('#tbl_list_penggabungan tbody').html('');

        $('#id_action').val('')
        $('#action').val('add')
        $('#luas_terbit').val('')
        $('#status_penggabungan').val('')
        $('#tgl_terbit').val('')
        $('#berkas').val('')
        $('#shgb').val('')
        $('#posisi').val('')
        $('#keterangan').val('')
        $('#tgl_daftar').val('')
    }

    $('#modalList').on('hide.bs.modal', function() {
        $('#modalAdd').modal('show')
    })

    function add_list_penggabungan() {
        $('#modalList').modal('show')
        $('#modalAdd').modal('hide')
        let all_form = $('#form_laporan').serializeArray();
        let kategori = $('#select_category').val();
        let has_selected = [];
        for (let i = 0; i < all_form.length; i++) {
            if (all_form[i].name == kategori + '[]') {
                has_selected.push(all_form[i].value)
            }
        }
        load_list_tanah(has_selected)
    }

    $('#select_category').change(function() {
        let all_form = $('#form_laporan').serializeArray();
        let kategori = $(this).val();
        let has_selected = [];
        for (let i = 0; i < all_form.length; i++) {
            if (all_form[i].name == kategori + '[]') {
                has_selected.push(all_form[i].value)
            }
        }
        load_list_tanah(has_selected);
    })

    function load_list_tanah(selected = null) {
        let category = $('#select_category').val()
        $('#dtbl_select_tanah').DataTable().destroy()
        $('#dtbl_select_tanah').dataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('ajax_laporan/datatable_list_tanah_6') ?>",
                "type": "POST",
                "data": {
                    "kategori": category,
                    "selected": selected
                }
            },
            "columnDefs": [{
                    "targets": [0, 1, 2, 3, 4], //first column / numbering column
                    "className": "text-nowrap"
                },

            ],
            "ordering": false,
            "iDisplayLength": 10,
            // "scrollX": true,
            "searching": false,
            "autoWidth": false
        });
    }

    function add_items(type = '', id = '', proyek = '', shgb = '', luas = '', blok = '') {
        let html = '<tr><td><button class="btn btn-sm btn-danger delete_items"><i class="fa fa-times"></i></button>  <input type="hidden" name="id_item[]" value="' + id + '"> <input type="hidden" name="type[]" value="' + type + '"> <input type="hidden" name="' + type + '[]" value="' + id + '"> </td> <td>' + proyek + '</td> <td>' + shgb + '</td> <td>' + blok + '</td> <td>' + luas + '</td><tr>';
        $('#tbl_list_penggabungan tbody').append(html)
        $('#modalList').modal('hide')
    }

    $(document).on('click', '.delete_items', function() {
        $(this).parent('td').parent('tr').remove()
    })





    $('#form_laporan').submit(function(e) {
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

    function edit_data(id) {
        loading();
        $.ajax({
            url: '<?= base_url('ajax_laporan/action_laporan_6') ?>',
            data: {
                id: id,
                action: 'get_edit'
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                setTimeout(() => {

                    let main = d.main;
                    let sub = d.sub;

                    $('#modalAdd').modal('show')
                    $('#modalAdd h5').html('Edit Penggabungan')
                    $('#btn_add_form').removeClass('d-none');
                    $('#tbl_list_penggabungan tbody').html('');

                    $('#id_action').val(id)
                    $('#action').val('edit')
                    $('#luas_terbit').val(main.luas_terbit)

                    $('#status_penggabungan').val(main.status_penggabungan)
                    $('#tgl_daftar').val(main.tgl_daftar)
                    $('#tgl_terbit').val(main.tgl_terbit)
                    $('#berkas').val(main.no_berkas)
                    $('#shgb').val(main.no_shgb)
                    $('#posisi').val(main.posisi)
                    $('#keterangan').val(main.ket)

                    let tbody = '';
                    for (let i = 0; i < sub.length; i++) {
                        tbody += '<tr><td><button class="btn btn-sm btn-outline-danger delete_items"><i class="fa fa-trash"></i></button>  <input type="hidden" name="id_item[]" value="' + sub[i].induk_id + '"> <input type="hidden" name="type[]" value="' + sub[i].type + '"> <input type="hidden" name="' + sub[i].type + '[]" value="' + sub[i].induk_id + '"> </td> <td>' + sub[i].proyek + '</td> <td>' + sub[i].shgb + '</td> <td>' + sub[i].blok + '</td> <td>' + sub[i].luas + '</td><tr>';
                    }
                    $('#tbl_list_penggabungan tbody').html(tbody)
                    Swal.close()
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
        loading();
        load_data_detail(id)
    }

    function load_data_detail(id) {
        $.ajax({
            url: '<?= base_url('ajax_laporan/action_laporan_6') ?>',
            data: {
                id: id,
                action: 'detail'
            },
            type: 'POST',
            success: function(d) {
                setTimeout(() => {
                    Swal.close()
                    $('#modalDetail').modal('show')
                    $('#modalDetail .modal-body').html(d)
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
        loading();
        $.ajax({
            url: '<?= base_url('ajax_laporan/action_laporan_6') ?>',
            data: {
                id: id,
                action: 'delete'
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
                        })
                        load_main_data()
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




    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }

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