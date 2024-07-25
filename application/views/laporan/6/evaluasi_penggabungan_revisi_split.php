<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Evaluasi Data Penggabungan Induk</h3>

                <div class="card">
                    <div class="card-body table-responsive">
                        <form action="<?php echo site_url('export/evaluasi_revisi_split/') ?>" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select data-plugin-selectTwo class="form-control" id="proyek_id" name="proyek_id">
                                            <option value="">Semua Lokasi</option>
                                            <?php foreach ($tanah_proyek as $tp) : ?>
                                                <option value="<?php echo $tp->id; ?>"><?php echo $tp->nama_proyek; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select data-plugin-selectTwo class="form-control" id="status_proyek" name="status_proyek">
                                            <option value="">Status Proyek</option>
                                            <option value="1">Luar Ijin</option>
                                            <option value="2">Dalam Ijin</option>
                                            <option value="3">Lokasi</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 text-right ">
                                    <a class="btn btn-primary btn-sm" onclick="filter_data()"><i class="fas fa-filter"></i> Filter Data</a>
                                    <a class="btn btn-sm btn-success" onclick="add_penggabungan()"><i class="fa fa-plus"></i> Tambah</a>
                                    <button class="btn btn-info btn-sm" type="submit"><i class="fa fa-print"></i> Cetak</button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered table-sm" id="table-penggabungan">
                            <thead>
                                <tr class="bg-dark text-light text-center">
                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">NO</th>
                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">AKSI</th>
                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">BLOK</th>
                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">PERUMAHAN</th>
                                    <th style="text-align: center;vertical-align: middle;" colspan="4">LUAS M<SUP>2</SUP></th>
                                    <th style="text-align: center;vertical-align: middle;" colspan="2">TANGGAL</th>
                                    <th style="text-align: center;vertical-align: middle;" colspan="2">NOMOR</th>
                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">POSISI</th>
                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">KET</th>

                                </tr>
                                <tr style="background-color:#9234eb ;">
                                    <th class="text-white text-center">SURAT</th>
                                    <th class="text-white text-center">DAFTAR</th>
                                    <th class="text-white text-center">TERBIT</th>
                                    <th class="text-white text-center">SELISIH</th>
                                    <th class="text-white text-center">DAFTAR</th>
                                    <th class="text-white text-center">TERBIT</th>
                                    <th class="text-white text-center">BERKAS</th>
                                    <th class="text-white text-center">SHGB</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>Tahun <?php echo date('Y') - 1 ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php $no = 1;
                                $l_surat_a = 0;
                                $l_daftar_a = 0;
                                $l_terbit_a = 0;
                                $l_selisih_a = 0;

                                foreach ($data_old as $do) {
                                    $l_surat_a += $do->luas_surat;
                                    $l_daftar_a += $do->luas_daftar;
                                    $l_terbit_a += $do->luas_terbit;
                                    $l_selisih_a += $do->luas_daftar - $do->luas_terbit;
                                ?>
                                    <tr>
                                        <td style="vertical-align: middle;"><?= $no++; ?></td>
                                        <td style="vertical-align: middle;">
                                            <div class="dropdown dropright">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                    Action</button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" onclick="detail_penggabungan('<?= $do->id_penggabungan_induk ?>')">Detail</a>
                                                    <a class="dropdown-item" href="#" onclick="edit_penggabungan('<?= $do->id_penggabungan_induk ?>')">Edit</a>
                                                    <a class="dropdown-item" href="#" onclick="delete_penggabungan('<?= $do->id_penggabungan_induk ?>')">Hapus</a>
                                                </div>
                                            </div>
                                        </td>

                                        <td style="vertical-align: middle;"><?php echo $do->nomor_gambar ?></td>
                                        <td style="vertical-align: middle;"><?php echo $do->nama_proyek ?></td>
                                        <td style="vertical-align: middle;"><?php echo $do->luas_surat ?></td>
                                        <td style="vertical-align: middle;"><?php echo $do->luas_daftar ?></td>
                                        <td style="vertical-align: middle;"><?php echo $do->luas_terbit ?></td>
                                        <td style="vertical-align: middle;"><?php echo $do->luas_daftar - $do->luas_terbit ?></td>
                                        <td style="vertical-align: middle;"><?php echo tgl_indo($do->tgl_daftar) ?></td>
                                        <td style="vertical-align: middle;"><?php echo tgl_indo($do->tgl_terbit) ?></td>
                                        <td style="vertical-align: middle;"><?php echo $do->no_berkas ?></td>
                                        <td style="vertical-align: middle;"><?php echo $do->no_shgb ?></td>
                                        <td style="vertical-align: middle;"><?php echo $do->posisi ?></td>
                                        <td style="vertical-align: middle;"><?php echo $do->ket_penggabungan ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>-</td>
                                    <td>Jumlah A : </td>
                                    <td></td>
                                    <td></td>
                                    <td><?= $l_surat_a ?></td>
                                    <td><?= $l_daftar_a ?></td>
                                    <td><?= $l_terbit_a ?></td>
                                    <td><?= $l_selisih_a ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Proses Tahun <?php echo date('Y') ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                                $l_surat_b = 0;
                                $l_daftar_b = 0;
                                $l_terbit_b = 0;
                                $l_selisih_b = 0;
                                $no = 1;
                                foreach ($data_new as $dn) {
                                    $l_surat_b += $dn->luas_surat;
                                    $l_daftar_b += $dn->luas_daftar;
                                    $l_terbit_b += $dn->luas_terbit;
                                    $l_selisih_b += $dn->luas_daftar - $dn->luas_terbit;
                                ?>
                                    <tr>
                                        <td style="vertical-align: middle;"><?php echo $no++; ?></td>
                                        <td style="vertical-align: middle;">
                                            <div class="dropdown dropright">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                    Action</button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" onclick="detail_penggabungan('<?= $dn->id_penggabungan_induk ?>')">Detail</a>
                                                    <a class="dropdown-item" href="#" onclick="edit_penggabungan('<?= $dn->id_penggabungan_induk ?>')">Edit</a>
                                                    <a class="dropdown-item" href="#" onclick="delete_penggabungan('<?= $dn->id_penggabungan_induk ?>')">Hapus</a>
                                                </div>
                                            </div>
                                        </td>

                                        <td style="vertical-align: middle;"><?php echo $dn->nomor_gambar ?></td>
                                        <td style="vertical-align: middle;"><?php echo $dn->nama_proyek ?></td>
                                        <td style="vertical-align: middle;"><?php echo $dn->luas_surat ?></td>
                                        <td style="vertical-align: middle;"><?php echo $dn->luas_daftar ?></td>
                                        <td style="vertical-align: middle;"><?php echo $dn->luas_terbit ?></td>
                                        <td style="vertical-align: middle;"><?php echo $dn->luas_daftar - $dn->luas_terbit ?></td>
                                        <td style="vertical-align: middle;"><?php echo tgl_indo($dn->tgl_daftar) ?></td>
                                        <td style="vertical-align: middle;"><?php echo tgl_indo($dn->tgl_terbit) ?></td>
                                        <td style="vertical-align: middle;"><?php echo $dn->no_berkas ?></td>
                                        <td style="vertical-align: middle;"><?php echo $dn->no_shgb ?></td>
                                        <td style="vertical-align: middle;"><?php echo $dn->posisi ?></td>
                                        <td style="vertical-align: middle;"><?php echo $dn->ket_penggabungan ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>-</td>
                                    <td>Jumlah B : </td>
                                    <td></td>
                                    <td></td>
                                    <td><?= $l_surat_b ?></td>
                                    <td><?= $l_daftar_b ?></td>
                                    <td><?= $l_terbit_b ?></td>
                                    <td><?= $l_selisih_b ?></td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-light" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ajax_tanah/validation_penggabungan') ?>" id="form_penggabungan" method="post">
                <input type="hidden" name="id" id="id_penggabungan">
                <input type="hidden" name="act" id="act">

                <div class="modal-body">

                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label>Luas Terbit</label>
                                <input type="text" name="luas_terbit" id="luas_terbit" class="form-control">

                            </div>
                            <div class="col-6">
                                <label>Status Penggabungan</label>
                                <select name="stat_peng" id="stat_peng" class="form-control">
                                    <option value="">--pilih--</option>
                                    <option value="proses">Proses</option>
                                    <option value="terbit">Terbit</option>
                                </select>
                                <small class="text-danger" id="err_stat_peng"></small>
                            </div>
                        </div>

                    </div>

                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label>Tanggal Daftar</label>
                                <input type="date" name="tgl_daftar" id="tgl_daftar" class="form-control" required>
                                <small class="text-danger" id="err_tgl_daftar"></small>
                            </div>
                            <div class="col-6">
                                <label>Tanggal Terbit</label>
                                <input type="date" name="tgl_terbit" id="tgl_terbit" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label>Nomor Berkas</label>
                                <input type="text" name="no_berkas" id="no_berkas" class="form-control">
                            </div>
                            <div class="col-6">
                                <label>Nomor SHGB</label>
                                <input type="text" name="no_shgb" id="no_shgb" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Posisi</label>
                        <input type="text" name="posisi" id="posisi" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="ket" id="ket" rows="3" placeholder="Keterangan Tanah"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>Data Tanah Induk</h5>
                            <a type="button" class="mb-3 mt-xs mr-xs btn btn-primary" id="tambahItem"><i class="fa fa-plus"></i> Tambah Item</a>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="table_modal_penggabungan">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>No</th>
                                            <th>No. SHGB</th>
                                            <th>Luas Terbit Induk</th>
                                            <th>Blok</th>
                                            <th><i class="fa fa-cogs"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
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

<!-- Modal untuk memilih tanah induk -->
<div class="modal fade bd-example-modal-lg" id="modal-listitems" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-dark">
                <h5 id="staticBackdropLabel">Tambah Tanah Induk</h5>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-hover" id="itemsdata">
                    <thead>
                        <tr class="bg-dark text-light">
                            <th>No</th>
                            <th>Nama Proyek</th>
                            <th>Nomor Terbit SHGB</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($data_list as $dl) { ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $dl->nama_proyek ?></td>
                                <td><?= $dl->no_terbit_shgb ?></td>
                                <td><button class="btn btn-sm btn-success" onclick="to_add_list_data_induk('<?= $dl->id ?>', '<?= $dl->no_terbit_shgb ?>', '<?= $dl->luas_terbit ?>')"><i class="fas fa-check-circle"></i></button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- modal detail -->
<div class="modal" id="modalDetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-light" id="staticBackdropLabel">Detail Penggabungan</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
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
    const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    $(document).ready(function() {
        $('#table-penggabungan').dataTable({
            "scrollX": true,
            "searching": true,
            "ordering": false,
            "autoWidth": false,
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
        })
    })

    function to_add_list_data_induk(id, shgb, luas) {
        let no;

        let all_list = $('#table_modal_penggabungan').find('tbody').html();
        if (all_list) {
            let last_row = $('#table_modal_penggabungan').find('tbody').find('tr').last().find('td').first().html()
            let num = parseInt(last_row);
            no = num + 1;
        } else {
            no = 1;
        }

        let val = '<tr><td class="no_list">' + no + '</td><td>' + shgb + '</td><td>' + luas + '</td><td><input class="form-control" name="blok[]" required></td><td><button type="button" class="btn btn-sm btn-danger delete-form"><i class="fa fa-trash"></i></button><input type="hidden" name="id_induk[]" value="' + id + '"></td></tr>';
        $('#table_modal_penggabungan').find('tbody').append(val)
        $('#modal-listitems').modal('hide')
    }


    $('#form_penggabungan').submit(function(e) {
        e.preventDefault()

        let tgl_daftar = $('#tgl_daftar').val();
        let list_data_induk = $('#table_modal_penggabungan').find('tbody').html();

        if (tgl_daftar != '' && list_data_induk != '') {
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
                        Swal.fire({
                            title: "Error",
                            text: d.msg,
                            icon: "error"
                        }).then((res) => {
                            $('#staticBackdrop').modal('hide')
                            window.location.reload()
                        });

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
        } else {
            error_alert('Harap isi semua inputan');
        }



    })

    $('#tambahItem').click(function() {
        $('#modal-listitems').modal('show')
    })

    $(document).on('click', '.delete-form', function() {
        $(this).parent('td').parent('tr').remove();
    })

    function add_penggabungan() {
        $('#staticBackdrop').modal('show')
        $('.modal-title').html('Tambah Penggabungan')

        $('#err_stat_peng').html('')
        $('#err_tgl_daftar').html('')

        $('#act').val('add');
        $('#luas_terbit').val('');
        $('#tgl_daftar').val('')
        $('#tgl_terbit').val('')
        $('#no_berkas').val('')
        $('#no_shgb').val('')
        $('#posisi').val('')
        $('#penggabungan_id').val('')
        $('#induk_id').val('')
        $('#blok').val('')
        $('#table_modal_penggabungan').find('tbody').html('')
        $('#stat_peng').val('')

    }

    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }

    function detail_penggabungan(id) {
        $('#modalDetail').modal('show')
        $('#modalDetail').find('.modal-body').html('')

        $.ajax({
            url: '<?= base_url('ajax_tanah/ajax_detail_penggabungan_perum') ?>',
            data: {
                id: id
            },
            type: 'POST',
            success: function(d) {
                $('#modalDetail').find('.modal-body').html(d)
            },
            error: function(xhr, status, error) {
                error_alert(error)
            }
        })
    }

    function filter_data() {
        let proyek = $('#proyek_id').val()
        let status = $('#status_proyek').val()

        window.location.href = '<?= base_url('dashboard/evaluasi_revisi_split?') ?>proyek=' + proyek + '&status=' + status;
    }

    function edit_penggabungan(id) {
        $('.modal-title').html('Edit Penggabungan')

        $('#err_stat_peng').html('')
        $('#err_tgl_daftar').html('')

        $('#act').val('edit');
        $('#luas_terbit').val('');
        $('#tgl_daftar').val('')
        $('#tgl_terbit').val('')
        $('#no_berkas').val('')
        $('#no_shgb').val('')
        $('#posisi').val('')
        $('#penggabungan_id').val('')
        $('#induk_id').val('')
        $('#blok').val('')
        $('#table_modal_penggabungan').find('tbody').html('')
        $('#stat_peng').val('')

        Swal.fire({
            title: "Loading",
            html: "Please wait...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });


        $.ajax({
            url: '<?= base_url('ajax_tanah/get_penggabungan_tanah') ?>',
            data: {
                id: id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                Swal.close()
                $('#staticBackdrop').modal('show')
                let data = d.data;
                let list = d.list;
                $('#id_penggabungan').val(data.id_penggabungan_induk)
                $('#luas_terbit').val(data.luas_terbit);
                $('#tgl_daftar').val(data.tgl_daftar)
                $('#tgl_terbit').val(data.tgl_terbit)
                $('#no_berkas').val(data.no_berkas)
                $('#no_shgb').val(data.no_shgb)
                $('#posisi').val(data.posisi)
                $('#ket').val(data.ket_penggabungan)
                $('#stat_peng').val(data.status_penggabungan)


                let i;
                let no = 1;
                let val = '';
                for (i = 0; i < list.length; i++) {
                    val += '<tr><td class="no_list">' + no++ + '</td><td>' + list[i].no_terbit_shgb + '</td><td>' + list[i].luas_terbit + '</td><td><input class="form-control" name="blok[]" required value="' + list[i].blok + '"></td><td><button type="button" class="btn btn-sm btn-danger delete-form"><i class="fa fa-trash"></i></button><input type="hidden" name="id_induk[]" value="' + list[i].induk_id + '"></td></tr>';
                }
                $('#table_modal_penggabungan').find('tbody').html(val)


            },
            error: function(xhr, status, error) {
                Swal.close()
                error_alert(error)
            }
        })

    }

    function delete_penggabungan(id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('ajax_tanah/delete_penggabungan') ?>',
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
                    error: function(xhr, status, error) {
                        error_alert(error)
                    }
                })
            }
        });
    }



    $(document).on('hidden.bs.modal', '.modal', function() {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    });
</script>