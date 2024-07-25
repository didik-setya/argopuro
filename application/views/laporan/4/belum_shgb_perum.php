<?php
$list_proyek = $this->db->get('master_proyek')->result();
$status_induk = ['belum', 'terbit'];
$f_proyek = $this->input->get('proyek');
$f_status = $this->input->get('status');

$last_year = date('Y', strtotime('-1 year'));
$this_year = date('Y');
$list_year = [$last_year, $this_year];
$status_pengalihan = ['belum order', 'order', 'terbit'];
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Evaluasi Tanah Belum SHGB</h3>
                <div class="card">
                    <div class="card-body">
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
                                    <option value="">--pilih status peralihan--</option>
                                    <?php foreach ($status_pengalihan as $sp) {
                                        if ($sp == $f_status) {
                                            echo '<option selected value="' . $sp . '">' . $sp . '</option>';
                                        } else {
                                            echo '<option value="' . $sp . '">' . $sp . '</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div class="text-right">
                                    <button class="btn btn-sm btn-primary" onclick="filter_data()"><i class="fas fa-filter"></i> Filter</button>
                                    <a href="<?= base_url('export/belum_shgb_perum?proyek=' . $f_proyek . '&status=' . $f_status) ?>" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Cetak</a>

                                </div>
                            </div>
                        </div>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
                                <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Proses SHGB</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active table-responsive" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <br>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr style="background-color: #1c9e86" class="text-white">
                                            <th rowspan="2"><i class="fa fa-cogs"></i></th>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Nama Penjual</th>
                                            <th rowspan="2">Lokasi</th>
                                            <th rowspan="2">Tanggal Pembelian</th>
                                            <th rowspan="2">No. Gambar</th>

                                            <th colspan="3">Data Surat Tanah 1</th>
                                            <th colspan="3">Data Surat Tanah 2</th>
                                            <th colspan="2">Luas (m<sup>2</sup>)</th>
                                            <th colspan="6">PBB</th>
                                            <th colspan="2">Harga Pengalihan Hak</th>
                                            <th colspan="2">Makelar</th>
                                            <th colspan="7">Pengalihan Hak</th>
                                            <th colspan="5">Biaya Lain-lain</th>

                                            <th rowspan="2">Total Harga</th>
                                            <th rowspan="2">Harga / m<sup>2</sup></th>
                                            <th rowspan="2">S Terima Finance</th>
                                            <th rowspan="2">Ket</th>
                                        </tr>
                                        <tr style="background: #dbdbdb;">
                                            <th>Nama</th>
                                            <th>Surat</th>
                                            <th>No. Surat</th>

                                            <th>Nama</th>
                                            <th>Surat</th>
                                            <th>No. Surat</th>

                                            <th>Surat</th>
                                            <th>Ukur</th>

                                            <th>Nomor</th>
                                            <th>Atas Nama</th>
                                            <th>Luas Bangunan</th>
                                            <th>NJOP Bangunan</th>
                                            <th>Luas Bumi</th>
                                            <th>NJOP Bumi</th>

                                            <th>Satuan</th>
                                            <th>Total</th>

                                            <th>Nama</th>
                                            <th>Nilai</th>

                                            <th>Belum Order</th>
                                            <th>Order</th>
                                            <th>Terbit</th>
                                            <th>Jenis</th>
                                            <th>Tanggal</th>
                                            <th>Akte</th>
                                            <th>Nama</th>

                                            <th>Pematangan</th>
                                            <th>Ganti Rugi</th>
                                            <th>PBB</th>
                                            <th>Lain-lain</th>
                                            <th>Total</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list_year as $ly) {
                                            $data = $this->laporan->get_tanah_belum_shgb($ly, $f_proyek, $f_status, 'belum')->result();
                                        ?>
                                            <tr style="background: #dedda0;">
                                                <td><strong>Tahun <?= $ly ?></strong></td>
                                                <?php for ($a = 1; $a < 41; $a++) { ?>
                                                    <td></td>
                                                <?php } ?>
                                            </tr>
                                            <?php $i = 1;
                                            foreach ($data as $d) {
                                                $getsertif1 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah1])->row();
                                                $getsertif2 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah2])->row();

                                                if ($getsertif1) {
                                                    $sertif1 = $getsertif1->nama_sertif;
                                                } else {
                                                    $sertif1 = '-';
                                                }

                                                if ($getsertif2) {
                                                    $sertif2 = $getsertif2->nama_sertif;
                                                } else {
                                                    $sertif2 = '-';
                                                }

                                                $satuan_pengalihan_hak = $d->total_harga_pengalihan /  $d->luas_surat;

                                                $total_lain = $d->biaya_lain_pematangan + $d->biaya_lain_rugi + $d->biaya_lain_pbb + $d->biaya_lain;

                                                $total_all = $total_lain + $d->total_harga_pengalihan + $d->harga_jual_makelar;

                                                $harga_per_meter = $total_all / $d->luas_ukur;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#" onclick="detail_data('<?= $d->id ?>')">Detail</a>
                                                                <a class="dropdown-item" href="#" onclick="edit_data('<?= $d->id ?>')">Edit Status</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $d->nama_penjual ?></td>
                                                    <td><?= $d->nama_proyek . ' (' . $d->nama_status . ')'; ?></td>
                                                    <td><?php cek_tgl($d->tgl_pembelian) ?></td>
                                                    <td><?= $d->nomor_gambar ?></td>

                                                    <td><?= $d->nama_surat_tanah1 ?></td>
                                                    <td><?= $sertif1 ?></td>
                                                    <td><?= $d->keterangan1 ?></td>

                                                    <td><?= $d->nama_surat_tanah2 ?></td>
                                                    <td><?= $sertif2 ?></td>
                                                    <td><?= $d->keterangan2 ?></td>

                                                    <td><?= $d->luas_surat ?></td>
                                                    <td><?= $d->luas_ukur ?></td>

                                                    <td><?= $d->nomor_pbb ?></td>
                                                    <td><?= $d->atas_nama_pbb ?></td>
                                                    <td><?= $d->luas_bangunan_pbb ?></td>
                                                    <td>Rp. <?= number_format($d->njop_bangunan) ?></td>
                                                    <td><?= $d->luas_bumi_pbb ?></td>
                                                    <td>Rp. <?= number_format($d->njop_bumi_pbb) ?></td>

                                                    <td>Rp. <?= number_format($satuan_pengalihan_hak) ?></td>
                                                    <td>Rp. <?= number_format($d->total_harga_pengalihan) ?></td>

                                                    <td><?= $d->nama_makelar ?></td>
                                                    <td>Rp. <?= number_format($d->harga_jual_makelar) ?></td>

                                                    <td><?php if ($d->status_pengalihan == 'belum order') {
                                                            cek_tgl($d->created_at);
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($d->status_pengalihan == 'order') {
                                                            cek_tgl($d->tgl_status_pengalihan);
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($d->status_pengalihan == 'terbit') {
                                                            cek_tgl($d->tgl_status_pengalihan);
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?= $d->nama_pengalihan ?>
                                                    </td>
                                                    <td><?php cek_tgl($d->tgl_akta_pengalihan) ?></td>
                                                    <td><?= $d->no_akta_pengalihan ?></td>
                                                    <td><?= $d->atas_nama_pengalihan ?></td>

                                                    <td>Rp. <?= number_format($d->biaya_lain_pematangan) ?></td>
                                                    <td>Rp. <?= number_format($d->biaya_lain_rugi) ?></td>
                                                    <td>Rp. <?= number_format($d->biaya_lain_pbb) ?></td>
                                                    <td>Rp. <?= number_format($d->biaya_lain) ?></td>
                                                    <td>Rp. <?= number_format($total_lain) ?></td>

                                                    <td>Rp. <?= number_format($total_all) ?></td>
                                                    <td>Rp. <?= number_format($harga_per_meter) ?></td>
                                                    <td><?php cek_tgl($d->serah_terima_finance) ?></td>
                                                    <td><?= $d->ket ?></td>
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
                                            <th rowspan="2">Nama Penjual</th>
                                            <th rowspan="2">Lokasi</th>
                                            <th rowspan="2">Tanggal Pembelian</th>
                                            <th rowspan="2">No. Gambar</th>

                                            <th colspan="3">Data Surat Tanah 1</th>
                                            <th colspan="3">Data Surat Tanah 2</th>
                                            <th colspan="2">Luas (m<sup>2</sup>)</th>
                                            <th colspan="6">PBB</th>
                                            <th colspan="2">Harga Pengalihan Hak</th>
                                            <th colspan="2">Makelar</th>
                                            <th colspan="7">Pengalihan Hak</th>
                                            <th colspan="5">Biaya Lain-lain</th>

                                            <th rowspan="2">Total Harga</th>
                                            <th rowspan="2">Harga / m<sup>2</sup></th>
                                            <th rowspan="2">S Terima Finance</th>
                                            <th rowspan="2">Ket</th>
                                        </tr>
                                        <tr style="background: #dbdbdb;">
                                            <th>Nama</th>
                                            <th>Surat</th>
                                            <th>No. Surat</th>

                                            <th>Nama</th>
                                            <th>Surat</th>
                                            <th>No. Surat</th>

                                            <th>Surat</th>
                                            <th>Ukur</th>

                                            <th>Nomor</th>
                                            <th>Atas Nama</th>
                                            <th>Luas Bangunan</th>
                                            <th>NJOP Bangunan</th>
                                            <th>Luas Bumi</th>
                                            <th>NJOP Bumi</th>

                                            <th>Satuan</th>
                                            <th>Total</th>

                                            <th>Nama</th>
                                            <th>Nilai</th>

                                            <th>Belum Order</th>
                                            <th>Order</th>
                                            <th>Terbit</th>
                                            <th>Jenis</th>
                                            <th>Tanggal</th>
                                            <th>Akte</th>
                                            <th>Nama</th>

                                            <th>Pematangan</th>
                                            <th>Ganti Rugi</th>
                                            <th>PBB</th>
                                            <th>Lain-lain</th>
                                            <th>Total</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list_year as $ly) {
                                            $data = $this->laporan->get_tanah_belum_shgb($ly, $f_proyek, $f_status, 'proses')->result();
                                        ?>
                                            <tr style="background: #dedda0;">
                                                <td><strong>Tahun <?= $ly ?></strong></td>
                                                <?php for ($a = 1; $a < 41; $a++) { ?>
                                                    <td></td>
                                                <?php } ?>
                                            </tr>
                                            <?php $i = 1;
                                            foreach ($data as $d) {
                                                $getsertif1 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah1])->row();
                                                $getsertif2 = $this->db->get_where('master_sertifikat_tanah', ['id' => $d->status_surat_tanah2])->row();

                                                if ($getsertif1) {
                                                    $sertif1 = $getsertif1->nama_sertif;
                                                } else {
                                                    $sertif1 = '-';
                                                }

                                                if ($getsertif2) {
                                                    $sertif2 = $getsertif2->nama_sertif;
                                                } else {
                                                    $sertif2 = '-';
                                                }

                                                $satuan_pengalihan_hak = $d->total_harga_pengalihan /  $d->luas_surat;

                                                $total_lain = $d->biaya_lain_pematangan + $d->biaya_lain_rugi + $d->biaya_lain_pbb + $d->biaya_lain;

                                                $total_all = $total_lain + $d->total_harga_pengalihan + $d->harga_jual_makelar;

                                                $harga_per_meter = $total_all / $d->luas_ukur;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#" onclick="detail_data('<?= $d->id ?>')">Detail</a>
                                                                <a class="dropdown-item" href="#" onclick="edit_data('<?= $d->id ?>')">Edit Status</a>
                                                                <a class="dropdown-item" href="#" onclick="delete_data('<?= $d->id ?>')">Hapus Data</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $d->nama_penjual ?></td>
                                                    <td><?= $d->nama_proyek . ' (' . $d->nama_status . ')'; ?></td>
                                                    <td><?php cek_tgl($d->tgl_pembelian) ?></td>
                                                    <td><?= $d->nomor_gambar ?></td>

                                                    <td><?= $d->nama_surat_tanah1 ?></td>
                                                    <td><?= $sertif1 ?></td>
                                                    <td><?= $d->keterangan1 ?></td>

                                                    <td><?= $d->nama_surat_tanah2 ?></td>
                                                    <td><?= $sertif2 ?></td>
                                                    <td><?= $d->keterangan2 ?></td>

                                                    <td><?= $d->luas_surat ?></td>
                                                    <td><?= $d->luas_ukur ?></td>

                                                    <td><?= $d->nomor_pbb ?></td>
                                                    <td><?= $d->atas_nama_pbb ?></td>
                                                    <td><?= $d->luas_bangunan_pbb ?></td>
                                                    <td>Rp. <?= number_format($d->njop_bangunan) ?></td>
                                                    <td><?= $d->luas_bumi_pbb ?></td>
                                                    <td>Rp. <?= number_format($d->njop_bumi_pbb) ?></td>

                                                    <td>Rp. <?= number_format($satuan_pengalihan_hak) ?></td>
                                                    <td>Rp. <?= number_format($d->total_harga_pengalihan) ?></td>

                                                    <td><?= $d->nama_makelar ?></td>
                                                    <td>Rp. <?= number_format($d->harga_jual_makelar) ?></td>

                                                    <td><?php if ($d->status_pengalihan == 'belum order') {
                                                            cek_tgl($d->created_at);
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($d->status_pengalihan == 'order') {
                                                            cek_tgl($d->tgl_status_pengalihan);
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($d->status_pengalihan == 'terbit') {
                                                            cek_tgl($d->tgl_status_pengalihan);
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?= $d->nama_pengalihan ?>
                                                    </td>
                                                    <td><?php cek_tgl($d->tgl_akta_pengalihan) ?></td>
                                                    <td><?= $d->no_akta_pengalihan ?></td>
                                                    <td><?= $d->atas_nama_pengalihan ?></td>

                                                    <td>Rp. <?= number_format($d->biaya_lain_pematangan) ?></td>
                                                    <td>Rp. <?= number_format($d->biaya_lain_rugi) ?></td>
                                                    <td>Rp. <?= number_format($d->biaya_lain_pbb) ?></td>
                                                    <td>Rp. <?= number_format($d->biaya_lain) ?></td>
                                                    <td>Rp. <?= number_format($total_lain) ?></td>

                                                    <td>Rp. <?= number_format($total_all) ?></td>
                                                    <td>Rp. <?= number_format($harga_per_meter) ?></td>
                                                    <td><?php cek_tgl($d->serah_terima_finance) ?></td>
                                                    <td><?= $d->ket ?></td>
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

<!-- Modal -->
<div class="modal" id="modalDetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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

<!-- Modal -->
<div class="modal" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h5 class="modal-title " id="staticBackdropLabel">Edit Data</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ajax_laporan/edit_belum_shgb') ?>" id="form_edit" method="post">
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const spinner_btn = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    const spinner = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';


    $(document).ready(function() {
        $('thead').find('th').addClass('text-nowrap text-center')
        $('tbody').find('td').addClass('text-nowrap text-center')
    })

    function edit_data(id) {
        let modal = $('#modalEdit');
        modal.modal('show');
        modal.find('.modal-body').html(spinner);

        $.ajax({
            url: '<?= base_url('ajax_laporan/form_edit_shgb') ?>',
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

    function detail_data(id) {
        let modal = $('#modalDetail');
        modal.modal('show');
        modal.find('.modal-body').html(spinner);

        $.ajax({
            url: '<?= base_url('ajax_laporan/detail_landbank_perum') ?>',
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

    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }

    function delete_data(id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: 'untuk menghapus data ini?',
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('ajax_laporan/delete_belum_shgb') ?>',
                    data: {
                        id: id
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d) {
                        if (d.status == false) {
                            error_alert(d.msg)
                        } else {
                            Swal.fire({
                                title: "Success",
                                text: d.msg,
                                icon: "success"
                            });
                            setTimeout(() => {
                                window.location.reload()
                            }, 1500);
                        }
                    },
                    error: function(xhr, status, error) {
                        error_alert(error);
                    }
                })
            }
        });
    }

    function filter_data() {
        let proyek = $('#f_proyek').val();
        let status = $('#f_status').val();

        window.location.href = '<?= base_url('dashboard/belum_shgb_perum?proyek=') ?>' + proyek + '&status=' + status;
    }

    $('#form_edit').submit(function(e) {
        e.preventDefault();
        $('#submit').attr('disabled', true);
        $('#submit').html(spinner_btn);

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#modalEdit').modal('hide')
                if (d.status == false) {
                    error_alert(d.msg);
                } else {
                    Swal.fire({
                        title: "Success",
                        text: d.msg,
                        icon: "success"
                    });
                    setTimeout(() => {
                        window.location.reload()
                    }, 1500);
                }
            },
            error: function(xhr, status, error) {
                error_alert(error)
            }
        })
    })
</script>