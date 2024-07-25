<?php
$status_ijin = ['proses', 'terbit'];
?>
<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Lokasi</strong></label>
    </div>
    <div class="col-md-9">
        <select name="lokasi" id="lokasi" class="form-control" required>
            <option value="">--pilih--</option>
            <?php foreach ($lokasi as $l) { ?>
                <?php if ($data->tanah_id == $l->id_tanah) { ?>
                    <option selected value="<?= $l->id_tanah ?>"><?= $l->nama_proyek ?> (<?= $l->nama_status ?>)</option>
                <?php } else { ?>
                    <option value="<?= $l->id ?>"><?= $l->nama_proyek ?> (<?= $l->nama_status ?>)</option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Status Ijin</strong></label>
    </div>
    <div class="col-md-9">
        <select name="status_ijin" id="status_ijin" class="form-control" required>
            <option value="">--pilih--</option>
            <?php foreach ($status_ijin as $sj) { ?>
                <?php if ($sj == $data->status) { ?>
                    <option value="<?= $sj ?>" selected><?= $sj ?></option>
                <?php } else { ?>
                    <option value="<?= $sj ?>"><?= $sj ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Koordinat</strong></label>
    </div>
    <div class="col-md-9">
        <input type="text" name="koordinat" id="koordinat" class="form-control" value="<?= $data->koordinat ?>">
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Luas Terbit</strong></label>
    </div>

    <div class="col-md-9">
        <input type="number" name="luas_terbit" id="luas_terbit" class="form-control" required value="<?= $data->luas_terbit ?>">
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Tanggal Daftar OSS</strong></label>
    </div>
    <div class="col-md-4">
        <input type="date" name="tgl_oss" id="tgl_oss" class="form-control" required value="<?= $data->daftar_online_oss ?>">
    </div>
    <div class="col-md-5">
        <input type="text" name="no_oss" id="no_oss" class="form-control" placeholder="No Terbit OSS" value="<?= $data->no_terbit_oss ?>">
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Tanggal Daftar Pertimbangan</strong></label>
    </div>
    <div class="col-md-4">
        <input type="date" name="tgl_dft_pertimbangan" id="tgl_dft_pertimbangan" class="form-control" value="<?= $data->tgl_daftar_pertimbangan ?>">
    </div>
    <div class="col-md-5">
        <input type="text" name="no_dft_pertimbangan" id="no_dft_pertimbangan" class="form-control" placeholder="No Daftar Pertimbangan" value="<?= $data->no_berkas_pertimbangan ?>">
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Tanggal Terbit Pertimbangan</strong></label>
    </div>
    <div class="col-md-4">
        <input type="date" name="tgl_tbt_pertimbangan" id="tgl_tbt_pertimbangan" class="form-control" value="<?= $data->tgl_terbit_pertimbangan ?>">
    </div>
    <div class="col-md-5">
        <input type="text" name="no_tbt_pertimbangan" id="no_tbt_pertimbangan" class="form-control" placeholder="No SK Pertimbangan" value="<?= $data->no_sk_pertimbangan ?>">
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Tanggal Daftar Lokasi</strong></label>
    </div>
    <div class="col-md-9">
        <input type="date" name="tgl_dft_lokasi" id="tgl_dft_lokasi" class="form-control" value="<?= $data->tgl_daftar_lokasi ?>">
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Tanggal Terbit Lokasi</strong></label>
    </div>
    <div class="col-md-9">
        <input type="date" name="tgl_tbt_lokasi" id="tgl_tbt_lokasi" class="form-control" value="<?= $data->tgl_terbit_lokasi ?>">
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>No. Ijin Lokasi</strong></label>
    </div>
    <div class="col-md-9">
        <input type="text" name="no_lokasi" id="no_lokasi" class="form-control" value="<?= $data->nomor_ijin_lokasi ?>">
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Masa Berlaku</strong></label>
    </div>
    <div class="col-md-9">
        <input type="date" name="masa_berlaku" id="masa_berlaku" class="form-control" value="<?= $data->masa_berlaku ?>">
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Status Tanah</strong></label>
    </div>
    <div class="col-md-9">
        <select name="status_tanah" id="status_tanah" class="form-control" required>
            <option value="">--pilih--</option>
            <?php $status_tanah = ['belum bebas', 'bebas']; ?>
            <?php foreach ($status_tanah as $st) { ?>
                <?php if ($data->status_tanah == $st) { ?>
                    <option value="<?= $st ?>" selected><?= $st ?></option>
                <?php } else { ?>
                    <option value="<?= $st ?>"><?= $st ?></option>
                <?php } ?>
            <?php } ?>

        </select>
    </div>
</div>

<div class="form-group row my-1">
    <div class="col-md-3">
        <label><strong>Keterangan</strong></label>
    </div>
    <div class="col-md-9">
        <textarea name="ket" id="ket" cols="30" rows="5" class="form-control"><?= $data->ket ?></textarea>
    </div>
</div>