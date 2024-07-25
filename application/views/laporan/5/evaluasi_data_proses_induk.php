<?php
$list_proyek = $this->db->get('master_proyek')->result();
$f_proyek = $this->input->get('proyek');
$f_status = $this->input->get('status');

$status_induk = ['belum', 'terbit'];

$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
$list_year = [$last_year, $this_year];
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Evaluasi Proyek Proses Induk</h3>

                <div class="card">
                    <div class="card-body table-responsive">

                        <form action="<?= base_url('export/evaluasi_data_proses_induk/') ?>" method="get">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select name="proyek" id="f_proyek" class="form-control">
                                        <option value="">--pilih proyek--</option>
                                        <?php foreach ($list_proyek as $lp) {
                                            if ($lp->id == $f_proyek) {
                                                echo '<option selected value="' . $lp->id . '">' . $lp->nama_proyek . '</option>';
                                            } else {
                                                echo '<option value="' . $lp->id . '">' . $lp->nama_proyek . '</option>';
                                            }
                                        } ?>
                                    </select>

                                </div>
                                <div class="col-md-3">
                                    <select name="status" id="f_status" class="form-control">
                                        <option value="">--pilih status--</option>
                                        <?php foreach ($status_induk as $si) {
                                            if ($si == $f_status) {
                                                echo '<option selected value="' . $si . '">' . $si . '</option>';
                                            } else {
                                                echo '<option value="' . $si . '">' . $si . '</option>';
                                            }
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-right">
                                        <a class="btn btn-sm btn-primary" onclick="filter_data()"><i class="fas fa-filter"></i> Filter</a>
                                        <a class="btn btn-sm btn-success" onclick="add_proses_induk()"><i class="fa fa-plus"></i> Tambah Data</a>
                                        <button class="btn btn-info btn-sm" type="submit"><i class="fa fa-print"></i> Cetak</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
                                <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Induk Terbit</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active table-responsive" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <br>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th rowspan="2"><i class="fa fa-cogs"></i></th>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">No. Gambar</th>
                                            <th rowspan="2">Blok</th>

                                            <th colspan="3">Luas M<SUP>2</SUP></th>
                                            <th colspan="2">Daftar SK Hak</th>
                                            <th colspan="2">Terbit SK Hak</th>
                                            <th colspan="2">Daftar SHGB</th>
                                            <th colspan="3">Terbit SHGB</th>
                                            <th rowspan="2">Target Penyelesaian</th>
                                            <th rowspan="2">Keterangan</th>
                                        </tr>
                                        <tr style="background: #dbdbdb;">
                                            <th>Daftar</th>
                                            <th>Terbit</th>
                                            <th>Selisih</th>
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
                                        <?php foreach ($list_year as $ly) {
                                            $data = $this->laporan->get_data_proses_induk($ly, $f_proyek, 'belum', '', $f_status)->result();
                                        ?>
                                            <tr style="background: #dedda0;">
                                                <td><strong>Tahun <?= $ly ?></strong></td>
                                                <?php for ($a = 1; $a < 18; $a++) { ?>
                                                    <td></td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                            $i = 1;
                                            $luas_terbit = 0;
                                            foreach ($data as $d) {

                                                $id_proses_induk = $d->id_proses_induk;

                                                $total_luas_daftar = $this->db->select('sum(luas_surat) as luas')
                                                    ->from('master_tanah')
                                                    ->join('sub_proses_induk', 'master_tanah.id = sub_proses_induk.tanah_id', 'left')
                                                    ->where('sub_proses_induk.induk_id', $id_proses_induk)
                                                    ->get()->row()->luas;

                                                $luas_terbit = $d->luas_terbit;

                                                $selisih = $total_luas_daftar - $luas_terbit;

                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#" onclick="detail_data('<?= $d->id_proses_induk ?>')">Detail</a>
                                                                <a class="dropdown-item" href="#" onclick="edit_data('<?= $d->id_proses_induk ?>')">Edit Status</a>
                                                                <a class="dropdown-item" href="#" onclick="delete_data('<?= $d->id_proses_induk ?>')">Hapus</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $d->no_gambar ?></td>
                                                    <td><?= $d->nama_proyek . ' (' . $d->nama_status . ')'; ?></td>
                                                    <td><?= $total_luas_daftar ?></td>
                                                    <td><?= $luas_terbit ?></td>
                                                    <td><?= $selisih ?></td>
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
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade table-responsive" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <br>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr style="background-color: #821122" class="text-white">
                                            <th rowspan="2"><i class="fa fa-cogs"></i></th>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">No. Gambar</th>
                                            <th rowspan="2">Blok</th>
                                            <th colspan="3">Luas M<SUP>2</SUP></th>
                                            <th colspan="2">Daftar SK Hak</th>
                                            <th colspan="2">Terbit SK Hak</th>
                                            <th colspan="2">Daftar SHGB</th>
                                            <th colspan="3">Terbit SHGB</th>
                                            <th rowspan="2">Target Penyelesaian</th>
                                            <th rowspan="2">Keterangan</th>
                                        </tr>
                                        <tr style="background: #dbdbdb;">
                                            <th>Daftar</th>
                                            <th>Terbit</th>
                                            <th>Selisih</th>
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
                                        <?php foreach ($list_year as $ly) {
                                            $data = $this->laporan->get_data_proses_induk($ly, $f_proyek, 'terbit', '', $f_status)->result();
                                        ?>
                                            <tr style="background: #dedda0;">
                                                <td><strong>Tahun <?= $ly ?></strong></td>
                                                <?php for ($a = 1; $a < 18; $a++) { ?>
                                                    <td></td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                            $i = 1;
                                            $luas_terbit = 0;
                                            foreach ($data as $d) {

                                                $id_proses_induk = $d->id_proses_induk;

                                                $total_luas_daftar = $this->db->select('sum(luas_surat) as luas')
                                                    ->from('master_tanah')
                                                    ->join('sub_proses_induk', 'master_tanah.id = sub_proses_induk.tanah_id', 'left')
                                                    ->where('sub_proses_induk.induk_id', $id_proses_induk)
                                                    ->get()->row()->luas;

                                                $luas_terbit = $d->luas_terbit;

                                                $selisih = $total_luas_daftar - $luas_terbit;

                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#" onclick="detail_data('<?= $d->id_proses_induk ?>')">Detail</a>
                                                                <a class="dropdown-item" href="#" onclick="edit_data('<?= $d->id_proses_induk ?>')">Edit Status</a>
                                                                <a class="dropdown-item" href="#" onclick="delete_data('<?= $d->id_proses_induk ?>')">Hapus</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $d->no_gambar ?></td>
                                                    <td><?= $d->nama_proyek . ' (' . $d->nama_status . ')'; ?></td>
                                                    <td><?= $total_luas_daftar ?></td>
                                                    <td><?= $luas_terbit ?></td>
                                                    <td><?= $selisih ?></td>
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
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Modal Tambah Start -->
<div class="modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
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
                        <label>Daftar SK Hak</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="date" placeholder="Luas Surat" name="tgl_daftar_sk_hak" id="tgl_daftar_sk_hak" class="form-control" required>
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
<div class="modal fade bd-example-modal-lg" id="modal-listitems" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-dark">
                <h5 id="staticBackdropLabel">Tambah Tanah</h5>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-hover" id="itemsdata">
                    <thead>
                        <tr class="bg-dark text-light">
                            <th>No</th>
                            <th>Nama Proyek</th>
                            <th>Nama Penjual</th>
                            <th>Luas Surat</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($data_list as $dl) { ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $dl->nama_proyek ?>(<?= $dl->nama_status ?>)</td>
                                <td><?= $dl->nama_penjual ?></td>
                                <td><?= $dl->luas_surat ?></td>
                                <td><button class="btn btn-sm btn-success" onclick="to_add_list_data_tanah('<?= $dl->id_tanah ?>', '<?= $dl->nama_proyek ?> (<?= $dl->nama_status ?>)', '<?= $dl->nama_penjual ?>', '<?= $dl->luas_surat ?>')"><i class="fas fa-check-circle"></i></button></td>
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

<script>
    const spinner_btn = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    const spinner = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';

    $(document).ready(function() {
        $('thead').find('th').addClass('text-nowrap text-center')
        $('tbody').find('td').addClass('text-nowrap text-center')

        $('#itemsdata').dataTable({
            "scrollX": false,
            "searching": true,
            "ordering": true,
            "autoWidth": false,
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
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
        $('#modal-listitems').modal('show')
    })
    $(document).on('click', '.delete-form', function() {
        $(this).parent('td').parent('tr').remove();
    })

    $('#form_induk').submit(function(e) {
        e.preventDefault()

        let tgl_daftar_sk_hak = $('#tgl_daftar_sk_hak').val();
        let list_data_tanah = $('#table_tanah_induk').find('tbody').html();

        if (tgl_daftar_sk_hak != '' && list_data_tanah != '') {
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
    }

    function edit_data(id) {
        $('.modal-title').html('Edit Penggabungan')

        $('#err_no_gambar').html('')
        $('#err_tgl_daftar_sk').html('')
        $('#err_status_induk').html('')

        $('#act').val('edit');
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

        $('#table_tanah_induk').find('tbody').html('')

        Swal.fire({
            title: "Loading",
            html: "Please wait...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });


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
                // $('#tanah_id').val(data.tanah_id)
                // $('#ket_sub').val(data.ket_sub)


                let i;
                let no = 1;
                let val = '';
                for (i = 0; i < list.length; i++) {
                    val += '<tr><td class="no_list">' + no++ + '</td><td>' + list[i].nama_proyek + ' (' + list[i].nama_status + ')' + '</td><td>' + list[i].nama_penjual + '</td><td>' + list[i].luas_surat + '</td><td><input class="form-control" name="ket_sub[]" value="' + list[i].ket_sub + '"></td><td><button type="button" class="btn btn-sm btn-danger delete-form"><i class="fa fa-trash"></i></button><input type="hidden" name="tanah_id[]" value="' + list[i].tanah_id + '"></td></tr>';
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
        let f_proyek = $('#f_proyek').val()
        let f_status = $('#f_status').val()

        window.location.href = '<?= base_url('dashboard/evaluasi_data_proses_induk?proyek=') ?>' + f_proyek + '&status=' + f_status;
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
</script>