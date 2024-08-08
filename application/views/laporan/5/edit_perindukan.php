<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3>Edit Proses Induk</h3>
            </div>



            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('ajax_laporan/validation_proses_induk') ?>" id="form_induk" method="post">
                            <input type="hidden" name="id" id="id" value="<?= $id ?>">
                            <input type="hidden" name="act" id="act" value="edit">

                            <div class="row">
                                <div class="col-lg-5">

                                    <div class="form-group mb-3">
                                        <label>Nomor Gambar</label>
                                        <input type="text" name="no_gambar" id="no_gambar" value="<?= $induk->no_gambar ?>" class="form-control" required>
                                        <small class="text-danger" id="err_no_gambar"></small>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Luas Terbit</label>
                                        <input type="text" name="luas_terbit" id="luas_terbit" class="form-control" value="<?= $induk->luas_terbit ?>">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Daftar Ukur</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="date" name="tgl_ukur" id="tgl_ukur" class="form-control" required value="<?= $induk->tgl_ukur ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="No. Daftar Ukur" name="no_ukur" id="no_ukur" class="form-control" value="<?= $induk->no_ukur ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Terbit Ukur</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="date" name="tbt_ukur" id="tbt_ukur" class="form-control" value="<?= $induk->tgl_terbit_ukur ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" name="tgl_tbt_ukur" id="tgl_tbt_ukur" class="form-control" placeholder="No. Terbit Ukur" value="<?= $induk->no_terbit_ukur ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Daftar SK Hak</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="date" placeholder="Luas Surat" name="tgl_daftar_sk_hak" id="tgl_daftar_sk_hak" class="form-control" value="<?= $induk->tgl_daftar_sk_hak ?>">
                                            </div>
                                            <small class="text-danger" id="err_tgl_daftar_sk"></small>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nomor Daftar SK Hak" name="no_daftar_sk_hak" id="no_daftar_sk_hak" class="form-control" value="<?= $induk->no_daftar_sk_hak ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Terbit SK Hak</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="date" placeholder="Luas Surat" name="tgl_terbit_sk_hak" id="tgl_terbit_sk_hak" class="form-control" value="<?= $induk->tgl_terbit_sk_hak ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nomor Terbit SK Hak" name="no_terbit_sk_hak" id="no_terbit_sk_hak" class="form-control" value="<?= $induk->no_terbit_sk_hak ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Daftar SHGB</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="date" placeholder="Luas Surat" name="tgl_daftar_shgb" id="tgl_daftar_shgb" class="form-control" value="<?= $induk->tgl_daftar_shgb ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nomor Daftar SHGB" name="no_daftar_shgb" id="no_daftar_shgb" class="form-control" value="<?= $induk->no_daftar_shgb ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Terbit SHGB</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="date" placeholder="Luas Surat" name="tgl_terbit_shgb" id="tgl_terbit_shgb" class="form-control" value="<?= $induk->tgl_terbit_shgb ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Nomor Terbit SHGB" name="no_terbit_shgb" id="no_terbit_shgb" class="form-control" value="<?= $induk->no_terbit_shgb ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Masa Berlaku SHGB</label>
                                        <input type="date" name="masa_berlaku_shgb" id="masa_berlaku_shgb" class="form-control" value="<?= $induk->masa_berlaku_shgb ?>">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Target Penyelesaian</label>
                                        <input type="date" name="target_penyelesaian" id="target_penyelesaian" class="form-control" value="<?= $induk->target_penyelesaian ?>">
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
                                        <textarea class="form-control" name="ket" id="ket" rows="3" placeholder="Keterangan Induk"><?= $induk->ket_induk ?></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-7">
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
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>