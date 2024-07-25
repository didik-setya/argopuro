<?php
$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
$list_year = [$last_year, $this_year];

$f_proyek = $this->input->get('proyek');
$f_status = $this->input->get('status');
$proyek =  $this->model->get_lokasi_proses_ijin('ok')->result();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Data Perijinan Lokasi Proses</h3>

                <div class="card">
                    <div class="card-body table-responsive">

                        <form action="<?= site_url('export/proses_ijin_lokasi/') ?>" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="proyek_f" id="proyek_f" class="form-control">
                                            <option value="">--semua proyek--</option>
                                            <?php foreach ($tanah_proyek as $l) { ?>

                                                <?php if ($l->id == $f_proyek) { ?>
                                                    <option selected value="<?= $l->id ?>"><?= $l->nama_proyek ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $l->id ?>"><?= $l->nama_proyek ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="status_f" id="status_f" class="form-control">
                                            <option value="">--semua status</option>
                                            <?php foreach ($status as $st) { ?>
                                                <?php if ($st->id == $f_status) { ?>
                                                    <option selected value="<?= $st->id ?>"><?= $st->nama_status ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $st->id ?>"><?= $st->nama_status ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 text-right ">
                                    <a class="btn btn-sm btn-primary" onclick="filter_data()"><i class="fas fa-filter"></i> Filter Data</a>
                                    <a class="btn btn-sm btn-success" onclick="to_add()"><i class="fa fa-plus"></i> Tambah</a>
                                    <button class="btn btn-sm btn-info" type="submit">
                                        <i class="fa fa-print"></i> Cetak
                                    </button>

                                </div>
                            </div>

                        </form>

                        <table class="table table-sm table-bordered" id="table">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th rowspan="3"><i class="fa fa-cogs"></i></th>
                                    <th rowspan="3">#</th>
                                    <th rowspan="3">Perumahan</th>

                                    <th colspan="4">Data Ijin Lokasi</th>

                                    <th rowspan="3">Daftar Online OSS</th>
                                    <th rowspan="3">No Terbit OSS</th>

                                    <th colspan="4">Daftar Pertimbangan Teknis</th>
                                    <th colspan="3">Daftar Ijin Lokasi</th>

                                    <th rowspan="3">Masa Berlaku</th>
                                    <th rowspan="3">Status</th>
                                    <th rowspan="3">Status Tanah</th>
                                    <th rowspan="3">Ket</th>
                                </tr>

                                <tr class="bg-primary text-light">
                                    <th rowspan="2">Letak Titik Koordinat</th>
                                    <th colspan="3">Luas (m2)</th>

                                    <th rowspan="2">Tanggal Daftar</th>
                                    <th rowspan="2">No Berkas</th>
                                    <th rowspan="2">Tanggal Terbit</th>
                                    <th rowspan="2">No. SK</th>
                                    <th rowspan="2">Tanggal Daftar</th>
                                    <th rowspan="2">Tanggal Terbit</th>
                                    <th rowspan="2">No Surat</th>
                                </tr>

                                <tr>
                                    <th>Daftar</th>
                                    <th>Terbit</th>
                                    <th>Selisih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($list_year as $ly) {
                                    $data = $this->laporan->query_proses_ijin_lokasi($ly, 'proses', null, $f_proyek, $f_status)->result();
                                ?>
                                    <tr style="background-color: #ded883;">
                                        <th>Proses Tahun <?= $ly ?></th>
                                        <?php for ($i = 0; $i < 19; $i++) { ?>
                                            <td></td>
                                        <?php } ?>
                                    </tr>

                                    <?php $i = 1;
                                    $l_daftar = 0;
                                    $l_terbit = 0;
                                    $l_selisih = 0;
                                    foreach ($data as $d) {
                                        $l_daftar += $d->luas_surat;
                                        $l_terbit += $d->luas_terbit;
                                        $l_selisih += $d->luas_surat - $d->luas_terbit;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#" onclick="edit_ijin('<?= $d->id ?>')">Edit</a>
                                                        <a class="dropdown-item" href="#" onclick="delete_ijin('<?= $d->id ?>')">Hapus</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $i++ ?></td>
                                            <td><?= $d->nama_proyek ?> (<?= $d->nama_status ?>)</td>
                                            <td><?= $d->koordinat ?></td>
                                            <td><?= $d->luas_surat ?></td>

                                            <td><?= $d->luas_terbit ?></td>
                                            <td><?php
                                                $selisih = $d->luas_surat - $d->luas_terbit;
                                                echo number_format($selisih);
                                                ?></td>
                                            <td><?php $d1 = date_create($d->daftar_online_oss);
                                                echo date_format($d1, 'd F Y'); ?></td>
                                            <td>
                                                <?= $d->no_terbit_oss ?>
                                            </td>
                                            <td>
                                                <?php if ($d->tgl_daftar_pertimbangan == '0000-00-00') {
                                                    echo '-';
                                                } else {
                                                    $d2 = date_create($d->tgl_daftar_pertimbangan);
                                                    echo date_format($d2, 'd F Y');
                                                } ?>
                                            </td>

                                            <td><?= $d->no_berkas_pertimbangan ?></td>
                                            <td>
                                                <?php if ($d->tgl_terbit_pertimbangan == '0000-00-00') {
                                                    echo '-';
                                                } else {
                                                    $d3 = date_create($d->tgl_terbit_pertimbangan);
                                                    echo date_format($d3, 'd F Y');
                                                } ?>
                                            </td>
                                            <td><?= $d->no_sk_pertimbangan ?></td>
                                            <td>
                                                <?php if ($d->tgl_daftar_lokasi == '0000-00-00') {
                                                    echo '-';
                                                } else {
                                                    $d4 = date_create($d->tgl_daftar_lokasi);
                                                    echo date_format($d4, 'd F Y');
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if ($d->tgl_terbit_lokasi == '0000-00-00') {
                                                    echo '-';
                                                } else {
                                                    $d5 = date_create($d->tgl_terbit_lokasi);
                                                    echo date_format($d5, 'd F Y');
                                                } ?>
                                            </td>

                                            <td><?= $d->nomor_ijin_lokasi ?></td>
                                            <td>
                                                <?php if ($d->masa_berlaku == '0000-00-00') {
                                                    echo '-';
                                                } else {
                                                    $d6 = date_create($d->masa_berlaku);
                                                    echo date_format($d6, 'd F Y');
                                                } ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary"><?= $d->status ?></span>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"><?= $d->status_tanah ?></span>
                                            </td>
                                            <td><?= $d->ket ?></td>
                                        </tr>
                                    <?php } ?>

                                    <tr style="background-color: #cfcfcf;">
                                        <th>Jumlah Luas Proses <?= $ly ?></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?= $l_daftar ?></td>
                                        <td><?= $l_terbit ?></td>
                                        <td><?= $l_selisih ?></td>
                                        <?php for ($i = 0; $i < 13; $i++) { ?>
                                            <td></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<div id="form_perijinan" class="d-none">
    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>Tanah</strong></label>
        </div>
        <div class="col-md-9">
            <select name="lokasi" id="lokasi" class="w-100 form-control lokasi" required>
                <option value="">--pilih--</option>
                <?php foreach ($lokasi as $l) { ?>
                    <option value="<?= $l->id_tanah ?>"><?= $l->nama_proyek ?> (<?= $l->nama_status ?>) (<?= $l->nama_surat_tanah1 ?> / <?= $l->keterangan1 ?>)</option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>Koordinat</strong></label>
        </div>
        <div class="col-md-9">
            <input type="text" name="koordinat" id="koordinat" class="form-control">
        </div>
    </div>

    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>Luas Terbit</strong></label>
        </div>

        <div class="col-md-9">
            <input type="number" name="luas_terbit" id="luas_terbit" class="form-control" required>
        </div>
    </div>

    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>Tanggal Daftar OSS</strong></label>
        </div>
        <div class="col-md-4">
            <input type="date" name="tgl_oss" id="tgl_oss" class="form-control" required>
        </div>
        <div class="col-md-5">
            <input type="text" name="no_oss" id="no_oss" class="form-control" placeholder="No Terbit OSS">
        </div>
    </div>

    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>Tanggal Daftar Pertimbangan</strong></label>
        </div>
        <div class="col-md-4">
            <input type="date" name="tgl_dft_pertimbangan" id="tgl_dft_pertimbangan" class="form-control">
        </div>
        <div class="col-md-5">
            <input type="text" name="no_dft_pertimbangan" id="no_dft_pertimbangan" class="form-control" placeholder="No Daftar Pertimbangan">
        </div>
    </div>

    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>Tanggal Terbit Pertimbangan</strong></label>
        </div>
        <div class="col-md-4">
            <input type="date" name="tgl_tbt_pertimbangan" id="tgl_tbt_pertimbangan" class="form-control">
        </div>
        <div class="col-md-5">
            <input type="text" name="no_tbt_pertimbangan" id="no_tbt_pertimbangan" class="form-control" placeholder="No SK Pertimbangan">
        </div>
    </div>

    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>Tanggal Daftar Lokasi</strong></label>
        </div>
        <div class="col-md-9">
            <input type="date" name="tgl_dft_lokasi" id="tgl_dft_lokasi" class="form-control">
        </div>
    </div>

    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>Tanggal Terbit Lokasi</strong></label>
        </div>
        <div class="col-md-9">
            <input type="date" name="tgl_tbt_lokasi" id="tgl_tbt_lokasi" class="form-control">
        </div>
    </div>

    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>No. Ijin Lokasi</strong></label>
        </div>
        <div class="col-md-9">
            <input type="text" name="no_lokasi" id="no_lokasi" class="form-control">
        </div>
    </div>

    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>Masa Berlaku</strong></label>
        </div>
        <div class="col-md-9">
            <input type="date" name="masa_berlaku" id="masa_berlaku" class="form-control">
        </div>
    </div>

    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>Status Tanah</strong></label>
        </div>
        <div class="col-md-9">
            <select name="status_tanah" id="status_tanah" class="form-control" required>
                <option value="">--pilih--</option>
                <option value="belum bebas">Belum Bebas</option>
                <option value="bebas">Sudah Bebas</option>
            </select>
        </div>
    </div>

    <div class="form-group row my-1">
        <div class="col-md-3">
            <label><strong>Keterangan</strong></label>
        </div>
        <div class="col-md-9">
            <textarea name="ket" id="ket" cols="30" rows="5" class="form-control"></textarea>
        </div>
    </div>



</div>

<!-- Modal -->
<div class="modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ajax_laporan/act_proses_ijin_lokasi') ?>" method="post" id="form_laporan">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="act" id="act">
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="to_submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const spinner_btn = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    const spinner = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';

    $(document).ready(function() {

        // load_data()
        $('#table').dataTable({
            "scrollX": true,
            "ordering": false,
            "columnDefs": [{
                "targets": [0], //first column / numbering column
                "className": "text-nowrap"
            }, ],
        })
    })

    function edit_ijin(id) {
        let modal = $('#staticBackdrop')
        modal.find('.modal-body').html(spinner)
        modal.modal('show');
        modal.find('.modal-title').html('Edit Data')
        modal.find('#id').val(id)
        modal.find('#act').val('edit')


        $.ajax({
            url: '<?= base_url('ajax_laporan/form_edit_ijin_lokasi') ?>',
            data: {
                id: id
            },
            type: 'POST',
            success: function(d) {
                modal.find('.modal-body').html(d)
            },
            error: function(xhr, status, error) {
                error_alert(error);
            }
        })
    }

    function to_add() {
        let form = $('#form_perijinan').html()
        let modal = $('#staticBackdrop')
        modal.modal('show');
        modal.find('.modal-title').html('Tambah Data')
        modal.find('.modal-body').html(form)
        modal.find('#id').val('')
        modal.find('#act').val('add')
    }

    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }

    function delete_ijin(id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: 'untuk menghapus data ini?',
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('ajax_laporan/delete_ijin_lokasi') ?>',
                    data: {
                        id: id
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d) {
                        if (d.status == false) {
                            error_alert(d.msg);
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
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

    function filter_data() {
        let proyek = $('#proyek_f').val();
        let status = $('#status_f').val();
        let new_uri = '<?= base_url('dashboard/proses_ijin_lokasi?proyek=') ?>' + proyek + '&status=' + status;
        window.location.href = new_uri;
    }

    $('#form_laporan').submit(function(e) {
        e.preventDefault();
        let modal = $('#staticBackdrop')
        modal.find('#to_submit').html(spinner_btn)
        modal.find('#to_submit').attr('disabled', true)

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                modal.find('#to_submit').html('Save')
                modal.find('#to_submit').removeAttr('disabled')
                modal.modal('hide')
                if (d.status == false) {
                    error_alert(d.msg);
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
                modal.find('#to_submit').html('Save')
                modal.find('#to_submit').removeAttr('disabled')
            }
        })

    })
</script>