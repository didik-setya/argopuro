<?php
$list_proyek = $this->db->get('master_proyek')->result();

$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
$list_year = [$last_year, $this_year];

$f_proyek = $this->input->get('proyek');
$data_splitsing_ty = $this->laporan->get_data_evaluasi_splitsing($this_year, null, $f_proyek, 'group')->result();
$data_splitsing_ly = $this->laporan->get_data_evaluasi_splitsing(null, $last_year, $f_proyek, 'group')->result();
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Evaluasi Proses Splitsing</h3>

                <div class="card">
                    <div class="card-body table-responsive">

                        <form action="<?= site_url('export/proses_ijin_lokasi/') ?>" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="proyek_f" id="proyek_f" class="form-control">
                                            <option value="">--semua proyek--</option>
                                            <?php foreach ($list_proyek as $l) { ?>

                                                <?php if ($l->id == $f_proyek) { ?>
                                                    <option selected value="<?= $l->id ?>"><?= $l->nama_proyek ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $l->id ?>"><?= $l->nama_proyek ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>

                                <div class="col-md-6 text-right ">
                                    <a class="btn btn-sm btn-primary" href="<?= base_url('dashboard/evaluasi_proses_splitsing?proyek=' . $f_proyek) ?>" id="on_filter"><i class="fas fa-filter"></i> Filter Data</a>

                                    <a class="btn btn-sm btn-success" onclick="to_add()"><i class="fa fa-plus"></i> Tambah</a>
                                    <a class="btn btn-sm btn-info" id="to_print" href="<?= base_url('export/export_evaluasi_8?proyek=' . $f_proyek) ?>" target="_blank">
                                        <i class="fa fa-print"></i> Cetak
                                    </a>

                                </div>
                            </div>

                        </form>

                        <table class="table table-sm table-bordered" id="table">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th style='text-align: center;vertical-align: middle;'><i class="fa fa-cogs"></i></th>
                                    <th style='text-align: center;vertical-align: middle;'>#</th>
                                    <th style='text-align: center;vertical-align: middle;'>Induk</th>
                                    <th style='text-align: center;vertical-align: middle;'>Unit</th>
                                    <th style='text-align: center;vertical-align: middle;'>Blok</th>
                                    <th style='text-align: center;vertical-align: middle;'>Ukuran Kavling</th>
                                    <th style='text-align: center;vertical-align: middle;'>Luas Terbit</th>
                                    <th style='text-align: center;vertical-align: middle;'>Selisih</th>
                                    <th style='text-align: center;vertical-align: middle;'>No. SHGB</th>
                                    <th style='text-align: center;vertical-align: middle;'>Masa Berlaku</th>
                                    <th style='text-align: center;vertical-align: middle;'>No. Daftar</th>
                                    <th style='text-align: center;vertical-align: middle;'>Tgl. Daftar</th>
                                    <th style='text-align: center;vertical-align: middle;'>Tgl. Terbit</th>
                                    <th style='text-align: center;vertical-align: middle;'>Keterangan</th>
                                    <th style='text-align: center;vertical-align: middle;'>Status</th>
                                </tr>
                            </thead>


                            <tbody>
                                <tr>
                                    <td class="bg-info" colspan="15"><b>A. Proses s/d <?= $last_year ?></b></td>
                                </tr>
                                <?php $no = 1;
                                $t_unit_a = 0;
                                $t_ukav_a = 0;
                                $t_ltbt_a = 0;
                                $t_selisih_a = 0;
                                foreach ($data_splitsing_ly as $dta) {
                                    $data_unit = $this->laporan->get_data_evaluasi_splitsing(null, $last_year, $f_proyek, null, $dta->group_id)->result();
                                    $jml_unit = count($data_unit);
                                    $u_kav = 0;
                                    $l_terb = 0;
                                    $jml_selisih = 0;


                                    $t_unit_a += $jml_unit;

                                ?>
                                    <tr class="text-danger">
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-cogs"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" onclick="edit_data('<?= $dta->group_id ?>')">Edit</a>
                                                    <a class="dropdown-item" href="#" onclick="delete_data('<?= $dta->group_id ?>')">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $no++ ?></td>
                                        <td><?= $dta->shgb_induk ?></td>
                                        <td><?= $jml_unit ?></td>
                                        <td colspan="10"></td>
                                        <td><?= $dta->status ?></td>
                                    </tr>

                                    <?php foreach ($data_unit as $dtu) {
                                        $selisih = $dtu->luas_kavling - $dtu->luas_terbit;
                                        $u_kav += $dtu->luas_kavling;
                                        $l_terb += $dtu->luas_terbit;
                                        $jml_selisih += $selisih;
                                    ?>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><?= $dtu->blok ?></td>
                                            <td><?= $dtu->luas_kavling ?></td>
                                            <td><?= $dtu->luas_terbit ?></td>
                                            <td><?= $selisih ?></td>
                                            <td><?= $dtu->no_shgb ?></td>
                                            <td><?= tgl_indo($dtu->masa_berlaku) ?></td>
                                            <td><?= $dtu->no_daftar ?></td>
                                            <td><?= tgl_indo($dtu->tgl_daftar) ?></td>
                                            <td><?= tgl_indo($dtu->tgl_terbit) ?></td>
                                            <td><?= $dtu->keterangan ?></td>
                                            <td></td>
                                        </tr>
                                    <?php }

                                    $t_ukav_a += $u_kav;
                                    $t_ltbt_a += $l_terb;
                                    $t_selisih_a += $jml_selisih;

                                    ?>
                                    <tr class="bg-warning">
                                        <td></td>
                                        <td colspan="2">Jumlah</td>
                                        <td><?= $jml_unit ?></td>
                                        <td></td>
                                        <td><?= $u_kav ?></td>
                                        <td><?= $l_terb ?></td>
                                        <td><?= $jml_selisih ?></td>
                                        <td colspan="7"></td>
                                    </tr>

                                <?php } ?>
                                <tr class="bg-info">
                                    <td></td>
                                    <td colspan="2">Total - A</td>
                                    <td><?= $t_unit_a ?></td>
                                    <td></td>
                                    <td><?= $t_ukav_a ?></td>
                                    <td><?= $t_ltbt_a ?></td>
                                    <td><?= $t_selisih_a ?></td>
                                    <td colspan="7"></td>
                                </tr>



                                <tr>
                                    <td colspan="15"></td>
                                </tr>



                                <tr>
                                    <td class="bg-info" colspan="15"><b>B. Tahun <?= $this_year ?></b></td>
                                </tr>
                                <?php $no = 1;
                                $t_unit_b = 0;
                                $t_ukav_b = 0;
                                $t_ltbt_b = 0;
                                $t_selisih_b = 0;
                                foreach ($data_splitsing_ty as $dta) {
                                    $data_unit = $this->laporan->get_data_evaluasi_splitsing($this_year, null, $f_proyek, null, $dta->group_id)->result();
                                    $jml_unit = count($data_unit);
                                    $u_kav = 0;
                                    $l_terb = 0;
                                    $jml_selisih = 0;


                                    $t_unit_b += $jml_unit;

                                ?>
                                    <tr class="text-danger">
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-cogs"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" onclick="edit_data('<?= $dta->group_id ?>')">Edit</a>
                                                    <a class="dropdown-item" href="#" onclick="delete_data('<?= $dta->group_id ?>')">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $no++ ?></td>
                                        <td><?= $dta->shgb_induk ?></td>
                                        <td><?= $jml_unit ?></td>
                                        <td colspan="10"></td>
                                        <td><?= $dta->status ?></td>
                                    </tr>

                                    <?php foreach ($data_unit as $dtu) {
                                        $selisih = $dtu->luas_kavling - $dtu->luas_terbit;
                                        $u_kav += $dtu->luas_kavling;
                                        $l_terb += $dtu->luas_terbit;
                                        $jml_selisih += $selisih;
                                    ?>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><?= $dtu->blok ?></td>
                                            <td><?= $dtu->luas_kavling ?></td>
                                            <td><?= $dtu->luas_terbit ?></td>
                                            <td><?= $selisih ?></td>
                                            <td><?= $dtu->no_shgb ?></td>
                                            <td><?= tgl_indo($dtu->masa_berlaku) ?></td>
                                            <td><?= $dtu->no_daftar ?></td>
                                            <td><?= tgl_indo($dtu->tgl_daftar) ?></td>
                                            <td><?= tgl_indo($dtu->tgl_terbit) ?></td>
                                            <td><?= $dtu->keterangan ?></td>
                                            <td></td>
                                        </tr>
                                    <?php }

                                    $t_ukav_b += $u_kav;
                                    $t_ltbt_b += $l_terb;
                                    $t_selisih_b += $jml_selisih;

                                    ?>
                                    <tr class="bg-warning">
                                        <td></td>
                                        <td colspan="2">Jumlah</td>
                                        <td><?= $jml_unit ?></td>
                                        <td></td>
                                        <td><?= $u_kav ?></td>
                                        <td><?= $l_terb ?></td>
                                        <td><?= $jml_selisih ?></td>
                                        <td colspan="7"></td>
                                    </tr>

                                <?php } ?>
                                <tr class="bg-info">
                                    <td></td>
                                    <td colspan="2">Total - B</td>
                                    <td><?= $t_unit_b ?></td>
                                    <td></td>
                                    <td><?= $t_ukav_b ?></td>
                                    <td><?= $t_ltbt_b ?></td>
                                    <td><?= $t_selisih_b ?></td>
                                    <td colspan="7"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-dark">
                                    <th></th>
                                    <th colspan="2">Total</th>
                                    <th><?= $t_unit_a + $t_unit_b ?></th>
                                    <th></th>
                                    <th><?= $t_ukav_a + $t_ukav_b ?></th>
                                    <th><?= $t_ltbt_a + $t_ltbt_b ?></th>
                                    <th><?= $t_selisih_a + $t_selisih_b ?></th>
                                    <th colspan="7"></th>
                                </tr>
                            </tfoot>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


<!-- Modal -->
<div class="modal" id="modalAction" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-light" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ajax_laporan/act_evaluasi_splitsing') ?>" method="post" id="form_modal">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="act" id="action">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group my-1" id="to_select_induk">
                                <label>Induk</label>
                                <select name="induk" id="select_induk" class="form-control" required>
                                    <option value="">--pilih--</option>
                                    <?php foreach ($data_penggabungan as $dp) { ?>
                                        <option value="<?= $dp->id ?>"><?= $dp->no_daftar_shgb ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group my-1">
                                <label>Status</label>
                                <select name="status" id="select_status" class="form-control" required>
                                    <option value="">--pilih--</option>
                                    <option value="proses">Proses</option>
                                    <option value="terbit">Terbit</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mt-2 table-responsive">
                            <table class="table table-sm table-bordered" id="table_list_blok">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th>#</th>
                                        <th>Blok</th>
                                        <th>Ukuran Kavling</th>
                                        <th>Luas Terbit</th>
                                        <th>No. SHGB</th>
                                        <th>Masa Berlaku</th>
                                        <th>No Daftar</th>
                                        <th>Tgl. Daftar</th>
                                        <th>Tgl. Terbit</th>
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
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#table thead tr th').addClass('text-nowrap')

    function to_add() {
        $('#modalAction').modal('show');
        $('#modalAction .modal-title').html('Tambah Proses Splitsing')
        $('#action').val('add')
        $('#id').val('');
        clear_form()
        $('#to_select_induk').removeClass('d-none')
        $('#select_induk').attr('required', true)
    }

    function clear_form() {
        $('#select_induk').val('')
        $('#l_terbit').val('')
        $('#shgb').val('')
        $('#exp').val('')
        $('#no_daftar').val('')
        $('#tgl_dft').val('')
        $('#tgl_tbt').val('')
        $('#ket').val('')
        $('#table_list_blok tbody').html('')
        $('#select_status').val('')
    }

    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }

    function loading_animate() {
        Swal.fire({
            title: "Loading",
            html: "Please wait...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

    }

    function edit_data(id) {
        $('#modalAction .modal-title').html('Edit Proses Splitsing')
        $('#action').val('edit')
        $('#id').val(id);
        $('#to_select_induk').addClass('d-none')
        $('#select_induk').removeAttr('required')
        clear_form()
        loading_animate()

        $.ajax({
            url: '<?= base_url('ajax_laporan/get_data_evaluasi8') ?>',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'JSON',
            success: function(d) {
                setTimeout(() => {
                    Swal.close();
                    const data = d.data;
                    const dta = d.data[0];
                    $('#select_status').val(dta.status)
                    $('#modalAction').modal('show');

                    let i;
                    let no = 1;
                    let datalist = '';
                    for (i = 0; i < data.length; i++) {
                        datalist += '<tr><td>' + no++ + '<input type="hidden" name="id_splitsing[]" value="' + data[i].id_splitsing + '"> <input type="hidden" name="id_sub_proses[]" value="' + data[i].id_sub_proses + '"></td><td>' + data[i].blok + '</td><td><input type="text" name="luas_kavling[]" class="form-control" required value="' + data[i].luas_surat + '"></td><td><input type="text" name="l_terbit[]" placeholder="Luas Terbit" class="form-control" value="' + data[i].luas_terbit + '"></td><td><input type="text" name="shgb[]" placeholder="No. SHGB" class="form-control" value="' + data[i].no_shgb + '"></td><td><input type="date" name="exp[]" class="form-control" value="' + data[i].masa_berlaku + '"></td><td><input type="text" name="no_dft[]" placeholder="No. Daftar" class="form-control" value="' + data[i].no_daftar + '"></td><td><input type="date" name="tgl_dft[]" class="form-control" value="' + data[i].tgl_daftar + '"></td><td><input type="date" name="tgl_tbt[]" class="form-control" value="' + data[i].tgl_terbit + '"></td><td><textarea class="form-control" name="ket[]">' + data[i].keterangan + '</textarea></td></tr>';
                    }
                    $('#table_list_blok tbody').html(datalist)

                }, 1000);
            },
            error: function(xhr, status, error) {
                setTimeout(() => {
                    Swal.close()
                    error_alert(error)
                }, 500);
            }
        })
    }

    function delete_data(id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: 'Untuk menghapus data ini?',
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                loading_animate()
                $.ajax({
                    url: '<?= base_url('ajax_laporan/act_evaluasi_splitsing'); ?>',
                    data: {
                        act: 'delete',
                        id: id
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d) {
                        setTimeout(() => {
                            Swal.close()
                            if (d.status == false) {
                                error_alert(d.msg);
                            } else {
                                Swal.fire({
                                    title: "Success",
                                    text: d.msg,
                                    icon: "success"
                                }).then((rs) => {
                                    window.location.reload()
                                });
                            }
                        }, 500);
                    },
                    error: function(xhr, status, error) {
                        setTimeout(() => {
                            Swal.close()
                            error_alert(error)
                        }, 500);
                    }
                })
            }
        });
    }

    $('#proyek_f').click(function() {
        let v = $(this).val()
        $('#on_filter').attr('href', '<?= base_url('dashboard/evaluasi_proses_splitsing?proyek=') ?>' + v);
        $('#to_print').attr('href', '<?= base_url('export/export_evaluasi_8?proyek=') ?>' + v);
    })

    $('#select_induk').change(function() {
        let v = $(this).val()
        loading_animate()
        $.ajax({
            url: '<?= base_url('ajax_laporan/get_sub_kavling') ?>',
            data: {
                id: v
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                setTimeout(() => {
                    Swal.close();
                    console.log(d);

                    let i;
                    let no = 1;
                    let datalist = '';
                    for (i = 0; i < d.length; i++) {
                        datalist += '<tr><td>' + no++ + '<input type="hidden" name="id_splitsing[]" value=""> <input type="hidden" name="id_sub_proses[]" value="' + d[i].id_sub_proses + '"></td><td>' + d[i].blok + '</td><td><input type="text" name="luas_kavling[]" class="form-control" required value="' + d[i].luas_surat + '"></td><td><input type="text" name="l_terbit[]" placeholder="Luas Terbit" class="form-control"></td><td><input type="text" name="shgb[]" placeholder="No. SHGB" class="form-control"></td><td><input type="date" name="exp[]" class="form-control"></td><td><input type="text" name="no_dft[]" placeholder="No. Daftar" class="form-control"></td><td><input type="date" name="tgl_dft[]" class="form-control"></td><td><input type="date" name="tgl_tbt[]" class="form-control"></td><td><textarea class="form-control" name="ket[]"></textarea></td></tr>';
                    }
                    $('#table_list_blok tbody').html(datalist)
                }, 500);
            },
            error: function(xhr, status, error) {
                setTimeout(() => {
                    Swal.close()
                    error_alert(error)
                }, 1000);
            }
        })
    })

    $('#form_modal').submit(function(e) {
        e.preventDefault();
        loading_animate();
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
                            title: "Success",
                            text: d.msg,
                            icon: "success"
                        }).then((rs) => {
                            $('#modalAction').modal('hide');
                            window.location.reload()
                        });
                    }
                }, 500);
            },
            error: function(xhr, status, error) {
                setTimeout(() => {
                    Swal.close()
                    error_alert(error)
                }, 500);
            }
        })
    })
</script>