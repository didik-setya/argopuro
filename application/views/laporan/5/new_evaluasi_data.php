<?php
$status_induk = ['belum', 'terbit'];
// $status_tanah = ['ip_proyek', 'tanah_proyek'];

$status_tanah = [
    [
        'name' => 'IP Proyek',
        'val' => 'ip_proyek'
    ],
    [
        'name' => 'Tanah Proyek',
        'val' => 'tanah_proyek'
    ]
];
$list_proyek = $this->db->get('master_proyek')->result();

$ftahun = $this->input->get('ftahun');
$fproyek = $this->input->get('fproyek');
$fstatus = $this->input->get('fstatus');
$ftanah = $this->input->get('ftanah');
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3>Evaluasi Proyek Proses Induk</h3>
            </div>

            <div class="col-12 my-2">
                <a class="btn btn-sm btn-primary" onclick="add_proses_induk()"><i class="fa fa-plus"></i> Tambah Data</a>
                <button class="btn btn-sm btn-dark" onclick="filter_data()"><i class="fas fa-filter"></i> Filter Data</button>
                <a href="<?= base_url('export/evaluasi_data_proses_induk?ftahun=' . $ftahun . '&fproyek=' . $fproyek . '&fstatus=' . $fstatus) ?>" class="btn btn-sm btn-success" target="_blank"><i class="far fa-file-excel"></i> Export Data</a>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-bordered w-100" id="main_table">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th rowspan="2"><i class="fa fa-cogs"></i></th>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">No. Gambar</th>
                                    <th rowspan="2">Blok</th>

                                    <th colspan="3">Luas M<SUP>2</SUP></th>
                                    <th colspan="2">Daftar Ukur</th>
                                    <th colspan="2">Terbit Ukur</th>

                                    <th colspan="2">Daftar SK Hak</th>
                                    <th colspan="2">Terbit SK Hak</th>
                                    <th colspan="2">Daftar SHGB</th>
                                    <th colspan="3">Terbit SHGB</th>
                                    <th rowspan="2">Target Penyelesaian</th>
                                    <th rowspan="2">Keterangan</th>
                                    <th rowspan="2">Status Induk</th>
                                    <th rowspan="2">Status Tanah</th>
                                </tr>
                                <tr style="background: #dbdbdb;">
                                    <th>Daftar</th>
                                    <th>Terbit</th>
                                    <th>Selisih</th>
                                    <th>Tanggal</th>
                                    <th>No. Berkas</th>
                                    <th>Tanggal</th>
                                    <th>No. Berkas</th>
                                    <th>Tanggal</th>
                                    <th>No. Berkas</th>
                                    <th>Tanggal</th>
                                    <th>No. SK</th>
                                    <th>Tanggal</th>
                                    <th>No. Berkas</th>
                                    <th>Tanggal</th>
                                    <th>No. SHGB</th>
                                    <th>Masa Berlaku</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $data = $this->laporan->get_data_proses_induk($ftahun, $fproyek, $fstatus, null, $ftanah)->result();
                                $i = 1;
                                foreach ($data as $d) {
                                    $id_proses_induk = $d->id_proses_induk;

                                    $total_luas_daftar = $this->db->select('sum(luas_surat) as luas')
                                        ->from('master_tanah')
                                        ->join('sub_proses_induk', 'master_tanah.id = sub_proses_induk.tanah_id', 'left')
                                        ->where('sub_proses_induk.induk_id', $id_proses_induk)
                                        ->get()->row()->luas;

                                    $luas_terbit = $d->luas_terbit;

                                    $selisih = $total_luas_daftar - $luas_terbit;
                                    $hash_id = md5(sha1($d->id_proses_induk));
                                ?>
                                    <tr>
                                        <td>

                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-cogs"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" onclick="detail_data('<?= $d->id_proses_induk ?>')">Detail</a>
                                                    <a class="dropdown-item" href="#" onclick="edit_data('<?= $d->id_proses_induk ?>')">Edit Status</a>
                                                    <!-- <a class="dropdown-item" href="<?= base_url('dashboard/edit_perindukan?induk=' . $d->id_proses_induk) ?>">Edit</a> -->

                                                    <a class="dropdown-item" href="#" onclick="delete_data('<?= $d->id_proses_induk ?>')">Hapus</a>
                                                </div>
                                            </div>

                                        </td>
                                        <td><?= $i++ ?></td>
                                        <td><?= $d->no_gambar ?></td>
                                        <td><?= $d->nama_proyek . ' (' . $d->nama_status . ')'; ?></td>
                                        <td><?= $total_luas_daftar ?></td>
                                        <td><?= $luas_terbit ?></td>
                                        <td><?= $selisih ?></td>
                                        <td><?= $d->tgl_ukur ?></td>
                                        <td><?= $d->no_ukur ?></td>
                                        <td><?= $d->tgl_terbit_ukur ?></td>
                                        <td><?= $d->no_terbit_ukur ?></td>
                                        <td><?= $d->tgl_daftar_sk_hak ?></td>
                                        <td><?= $d->no_daftar_sk_hak ?></td>
                                        <td><?= $d->tgl_terbit_sk_hak ?></td>
                                        <td><?= $d->no_terbit_sk_hak ?></td>
                                        <td><?= $d->tgl_daftar_shgb ?></td>
                                        <td><?= $d->no_daftar_shgb ?></td>
                                        <td><?= $d->tgl_terbit_shgb ?></td>
                                        <td><?= $d->no_terbit_shgb ?></td>
                                        <td><?= $d->masa_berlaku_shgb ?></td>
                                        <td><?= $d->target_penyelesaian ?></td>
                                        <td><?= $d->ket_induk ?></td>
                                        <td><?= $d->status_induk ?></td>
                                        <td>
                                            <?php
                                            if ($d->status_tanah == 'ip_proyek') {
                                                echo 'IP Proyek';
                                            } else if ($d->status_tanah == 'tanah_proyek') {
                                                echo 'Tanah Proyek';
                                            } else {
                                                echo '-';
                                            }
                                            ?>
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

<!-- Modal Tambah Start -->
<div class="modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-light" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ajax_laporan/validation_proses_induk') ?>" id="form_induk" method="post">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="act" id="act">

                <div class="modal-body">

                    <div class="form-group mb-3">
                        <label>Nomor Gambar</label>
                        <input type="text" name="no_gambar" id="no_gambar" class="form-control" required>
                        <small class="text-danger" id="err_no_gambar"></small>
                    </div>

                    <div class="form-group mb-3">
                        <label>Luas Terbit</label>
                        <input type="text" name="luas_terbit" id="luas_terbit" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Daftar Ukur</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="date" name="tgl_ukur" id="tgl_ukur" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" placeholder="No. Daftar Ukur" name="no_ukur" id="no_ukur" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Terbit Ukur</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="date" name="tbt_ukur" id="tbt_ukur" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="tgl_tbt_ukur" id="tgl_tbt_ukur" class="form-control" placeholder="No. Terbit Ukur">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Daftar SK Hak</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="date" placeholder="Luas Surat" name="tgl_daftar_sk_hak" id="tgl_daftar_sk_hak" class="form-control">
                            </div>
                            <small class="text-danger" id="err_tgl_daftar_sk"></small>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Nomor Daftar SK Hak" name="no_daftar_sk_hak" id="no_daftar_sk_hak" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Terbit SK Hak</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="date" placeholder="Luas Surat" name="tgl_terbit_sk_hak" id="tgl_terbit_sk_hak" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Nomor Terbit SK Hak" name="no_terbit_sk_hak" id="no_terbit_sk_hak" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Daftar SHGB</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="date" placeholder="Luas Surat" name="tgl_daftar_shgb" id="tgl_daftar_shgb" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Nomor Daftar SHGB" name="no_daftar_shgb" id="no_daftar_shgb" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Terbit SHGB</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="date" placeholder="Luas Surat" name="tgl_terbit_shgb" id="tgl_terbit_shgb" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Nomor Terbit SHGB" name="no_terbit_shgb" id="no_terbit_shgb" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Masa Berlaku SHGB</label>
                        <input type="date" name="masa_berlaku_shgb" id="masa_berlaku_shgb" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Target Penyelesaian</label>
                        <input type="date" name="target_penyelesaian" id="target_penyelesaian" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Status Induk</label>
                        <select name="status_induk" id="status_induk" required class="form-control">
                            <option value="">--pilih--</option>
                            <option value="belum">Belum Terbit</option>
                            <option value="terbit">Sudah Terbit</option>
                        </select>
                    </div><small class="text-danger" id="err_status_induk"></small>

                    <div class="form-group mb-3">
                        <label>Status Tanah</label>
                        <select name="status_tanah" id="status_tanah" required class="form-control">
                            <option value="">--pilih--</option>
                            <option value="ip_proyek">IP Proyek</option>
                            <option value="tanah_proyek">Tanah Proyek</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="ket" id="ket" rows="3" placeholder="Keterangan Induk"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>Data Tanah untuk di indukkan</h5>
                            <a type="button" class="mb-3 mt-xs mr-xs btn btn-primary" id="tambahItem"><i class="fa fa-plus"></i> Tambah Item</a>
                            <div class="table">
                                <table class="table table-bordered table-hover table-striped no-footer" id="table_tanah_induk">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>No</th>
                                            <th>Proyek</th>
                                            <th>Nama Penjual</th>
                                            <th>Luas Surat</th>
                                            <th>Keterangan Sub Tanah</th>
                                            <th><i class="fa fa-cogs"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="to_submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Tambah End -->

<!-- Modal List Item -->
<div class="modal bd-example-modal-lg" id="modal-listitems" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-dark">
                <h5 id="staticBackdropLabel">Tambah Tanah</h5>
            </div>

            <div class="modal-body table-responsive">
                <table class="table table-bordered table-hover" id="itemsdata">
                    <thead>
                        <tr class="bg-dark text-light">
                            <th>No</th>
                            <th>Nama Proyek</th>
                            <th>Nama Penjual</th>
                            <th>Luas Surat</th>
                            <th>Status Teknik</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>

                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<!-- Modal List Item End-->

<!-- Modal Detail Start -->
<div class="modal" id="modalDetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title text-light" id="staticBackdropLabel">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
<!-- Modal Detail End -->


<!-- modal filter -->
<div class="modal" id="modalFilter" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="staticBackdropLabel">Filter Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-light" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form_filter" method="get">
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Tahun</b></label>
                        <select name="ftahun" id="ftahun" class="form-control">
                            <option value="">--pilih--</option>
                            <?php
                            $now_year = date('Y');
                            for ($y = 1990; $y <= $now_year; $y++) { ?>
                                <?php if ($ftahun == $y) { ?>
                                    <option selected value="<?= $y ?>"><?= $y ?></option>
                                <?php } else { ?>
                                    <option value="<?= $y ?>"><?= $y ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><b>Proyek</b></label>
                        <select name="fproyek" id="fproyek" class="form-control">
                            <option value="">--pilih--</option>
                            <?php foreach ($list_proyek as $lp) { ?>
                                <?php if ($fproyek == $lp->id) { ?>
                                    <option selected value="<?= $lp->id ?>"><?= $lp->nama_proyek ?></option>
                                <?php } else { ?>
                                    <option value="<?= $lp->id ?>"><?= $lp->nama_proyek ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><b>Status Proses Induk</b></label>
                        <select name="fstatus" id="fstatus" class="form-control">
                            <option value="">--pilih--</option>
                            <?php foreach ($status_induk as $st) { ?>
                                <?php if ($fstatus == $st) { ?>
                                    <option selected value="<?= $st ?>"><?= $st ?></option>
                                <?php } else { ?>
                                    <option value="<?= $st ?>"><?= $st ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><b>Status Tanah</b></label>
                        <select name="ftanah" id="ftanah" class="form-control">
                            <option value="">--pilih--</option>
                            <?php foreach ($status_tanah as $st) {
                                if ($ftanah == $st['val']) {
                                    echo '<option value="' . $st['val'] . '" selected>' . $st['name'] . '</option>';
                                } else {
                                    echo '<option value="' . $st['val'] . '">' . $st['name'] . '</option>';
                                }
                            } ?>
                        </select>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Run</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal filter -->
<script>
    const spinner_btn = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    const spinner = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';

    $(document).ready(function() {
        $('thead').find('th').addClass('text-nowrap text-center')
        $('tbody').find('td').addClass('text-nowrap text-center')

        $('#main_table').dataTable({
            "scrollX": false,
            "searching": true,
            "ordering": false,
            "autoWidth": false,
        })


    })



    function to_add_list_data_tanah(id_tanah, proyek, penjual, luas) {
        let no;

        let all_list = $('#table_tanah_induk').find('tbody').html();
        if (all_list) {
            let last_row = $('#table_tanah_induk').find('tbody').find('tr').last().find('td').first().html()
            let num = parseInt(last_row);
            no = num + 1;
        } else {
            no = 1;
        }

        let val = '<tr><td class="no_list">' + no + '</td><td>' + proyek + '</td><td>' + penjual + '</td><td>' + luas + '</td><td><input class="form-control" name="ket_sub[]" ></td><td><button type="button" class="btn btn-sm btn-danger delete-form"><i class="fa fa-trash"></i></button><input type="hidden" name="tanah_id[]" value="' + id_tanah + '"></td></tr>';
        $('#table_tanah_induk').find('tbody').append(val)
        $('#modal-listitems').modal('hide')
    }

    $('#tambahItem').click(function() {
        let stat_tanah = $('#status_tanah').val()
        if (stat_tanah == '' || stat_tanah == null || stat_tanah == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap pilih status tanah'
            })
        } else {
            $('#modal-listitems').modal('show')
            var formData = $('#form_induk').serializeArray();
            let tanah = [];
            for (let i = 0; i < formData.length; i++) {
                if (formData[i].name == 'tanah_id[]') {
                    tanah.push(formData[i].value)
                }
            }
            load_list_data_tanah(stat_tanah, tanah);
        }


    })

    function load_list_data_tanah(status, tanah_id = null) {
        $('#itemsdata').DataTable().destroy();
        $('#itemsdata').dataTable({
            "processing": true,
            "serverSide": true,
            "order": [],

            "ajax": {
                "url": "<?= base_url('ajax_laporan/load_list_tanah_5') ?>",
                "type": "POST",
                "data": {
                    "status": status,
                    "tanah_id": tanah_id
                }
            },

            "scrollX": false,
            "searching": true,
            "ordering": true,
            "autoWidth": false,
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
        })
    }




    $('#status_tanah').change(function() {
        let action = $('#act').val();
        console.log(action);
        if (action == 'add') {
            $('#table_tanah_induk').find('tbody').html('')
        }
    })

    $(document).on('click', '.delete-form', function() {
        $(this).parent('td').parent('tr').remove();
    })

    $('#form_induk').submit(function(e) {
        e.preventDefault()

        let list_data_tanah = $('#table_tanah_induk').find('tbody').html();

        if (list_data_tanah != '') {
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


    function add_proses_induk() {
        $('#staticBackdrop').modal('show')
        $('.modal-title').html('Tambah Data Baru')

        $('#err_no_gambar').html('')
        $('#err_tgl_daftar_sk').html('')
        $('#err_status_induk').html('')

        $('#act').val('add');
        $('#no_gambar').val('');
        $('#luas_terbit').val('');
        $('#tgl_daftar_sk_hak').val('');
        $('#no_daftar_sk_hak').val('');
        $('#tgl_terbit_sk_hak').val('');
        $('#no_terbit_sk_hak').val('');
        $('#tgl_daftar_shgb').val('');
        $('#no_daftar_shgb').val('');
        $('#tgl_terbit_shgb').val('');
        $('#no_terbit_shgb').val('');
        $('#masa_berlaku_shgb').val('');
        $('#target_penyelesaian').val('');
        $('#status_induk').val('');
        $('#ket').val('');

        $('#tanah_id').val('');
        $('#ket_sub').val('');

        $('#tbt_ukur').val('')
        $('#tgl_tbt_ukur').val('')

    }

    function edit_data(id) {
        $('.modal-title').html('Edit Penggabungan')

        $('#err_no_gambar').html('')
        $('#err_tgl_daftar_sk').html('')
        $('#err_status_induk').html('')

        $('#act').val('edit');
        $('#no_gambar').val('');
        $('#luas_terbit').val('');
        $('#tgl_ukur').val('');
        $('#no_ukur').val('');
        $('#tgl_daftar_sk_hak').val('');
        $('#no_daftar_sk_hak').val('');
        $('#tgl_terbit_sk_hak').val('');
        $('#no_terbit_sk_hak').val('');
        $('#tgl_daftar_shgb').val('');
        $('#no_daftar_shgb').val('');
        $('#tgl_terbit_shgb').val('');
        $('#no_terbit_shgb').val('');
        $('#masa_berlaku_shgb').val('');
        $('#target_penyelesaian').val('');
        $('#status_induk').val('');
        $('#ket').val('');
        $('#tanah_id').val('');
        $('#ket_sub').val('');

        $('#table_tanah_induk').find('tbody').html('')

        Swal.fire({
            title: "Loading",
            html: "Please wait...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        get_data_for_edit(id)
    }


    function get_data_for_edit(id) {
        $.ajax({
            url: '<?= base_url('ajax_laporan/get_induk_tanah') ?>',
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
                $('#id').val(data.id_proses_induk)
                $('#no_gambar').val(data.no_gambar);
                $('#luas_terbit').val(data.luas_terbit)
                $('#tgl_daftar_sk_hak').val(data.tgl_daftar_sk_hak)
                $('#no_daftar_sk_hak').val(data.no_daftar_sk_hak)
                $('#tgl_terbit_sk_hak').val(data.tgl_terbit_sk_hak)
                $('#no_terbit_sk_hak').val(data.no_terbit_sk_hak)
                $('#tgl_daftar_shgb').val(data.tgl_daftar_shgb)
                $('#no_daftar_shgb').val(data.no_daftar_shgb)
                $('#tgl_terbit_shgb').val(data.tgl_terbit_shgb)
                $('#no_terbit_shgb').val(data.no_terbit_shgb)
                $('#masa_berlaku_shgb').val(data.masa_berlaku_shgb)
                $('#target_penyelesaian').val(data.target_penyelesaian)
                $('#status_induk').val(data.status_induk)
                $('#ket').val(data.ket_induk)
                $('#tgl_ukur').val(data.tgl_ukur);
                $('#no_ukur').val(data.no_ukur);
                $('#status_tanah').val(data.status_tanah);

                $('#tbt_ukur').val(data.tgl_terbit_ukur)
                $('#tgl_tbt_ukur').val(data.no_terbit_ukur)
                // $('#tanah_id').val(data.tanah_id)
                // $('#ket_sub').val(data.ket_sub)


                let i;
                let no = 1;
                let val = '';
                for (i = 0; i < list.length; i++) {
                    val += '<tr><td class="no_list">' + no++ + '</td><td>' + list[i].nama_proyek + ' (' + list[i].nama_status + ')' + '</td><td>' + list[i].nama_penjual + '</td><td>' + list[i].luas_surat + '</td><td><input class="form-control" name="ket_sub[]" value="' + list[i].ket_sub + '"></td><td><button type="button" class="btn btn-sm btn-warning delete_tanah" data-id="' + list[i].id_sub_induk + '" data-induk="' + list[i].induk_id + '" data-tanah="' + list[i].tanah_id + '"><i class="fa fa-trash"></i></button><input type="hidden" name="tanah_id[]" value="' + list[i].tanah_id + '"></td></tr>';
                }
                $('#table_tanah_induk').find('tbody').html(val)


            },
            error: function(xhr, status, error) {
                Swal.close()
                error_alert(error)
            }
        })
    }

    function filter_data() {
        $('#modalFilter').modal('show')
    }

    function detail_data(id) {
        let modal = $('#modalDetail');
        modal.modal('show');
        modal.find('.modal-body').html(spinner);

        $.ajax({
            url: '<?= base_url('ajax_laporan/detail_proses_induk') ?>',
            data: {
                id: id
            },
            type: 'POST',
            success: function(d) {
                modal.find('.modal-body').html(d);
            },
            error: function(xhr, status, error) {
                error_alert(error);
            }
        })
    }

    function delete_data(id) {
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
                    url: '<?= base_url('ajax_laporan/delete_proses_induk') ?>',
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

    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }

    $(document).on('hidden.bs.modal', '.modal', function() {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    });

    $(document).on('click', '.delete_tanah', function() {
        let id = $(this).data('id');
        let induk = $(this).data('induk');
        let tanah = $(this).data('tanah');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((res) => {
            if (res.isConfirmed) {
                delete_tanah(id, induk, tanah)
            }
        })
    })

    function delete_tanah(id, induk_id, tanah_id) {
        loading()
        $.ajax({
            url: '<?= base_url('ajax_laporan/delete_sub_induk') ?>',
            data: {
                id: id,
                tanah: tanah_id
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
                        }).then((res) => {
                            get_data_for_edit(induk_id)
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