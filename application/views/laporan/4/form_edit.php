<?php
$s_pengalihan = ['belum', 'proses'];
$j_pengalihan = $this->db->get('master_jenis_pengalihan')->result();

?>
<input type="hidden" name="id" id="id" value="<?= $data->id ?>">

<div class="row my-2">
    <div class="col-md-3">
        <strong>Status SHGB</strong>
    </div>
    <div class="col-md-9">
        <select name="s_shgb" id="s_shgb" class="form-control" required>
            <option value="">--pilih--</option>
            <?php foreach ($s_pengalihan as $sp) { ?>
                <?php if ($sp == $data->status_proses_shgb) { ?>
                    <option value="<?= $sp ?>" selected><?= $sp ?></option>
                <?php } else { ?>
                    <option value="<?= $sp ?>"><?= $sp ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Tanggal Proses</strong>
    </div>
    <div class="col-md-9">
        <input type="date" name="tgl_proses" id="tgl_proses" class="form-control" value="<?= $data->tgl_status_pengalihan ?>">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Jenis</strong>
    </div>
    <div class="col-md-9">
        <select name="j_pengalihan" id="j_pengalihan" class="form-control">
            <option value="">--pilih--</option>
            <?php foreach ($j_pengalihan as $jp) {
                if ($jp->id == $data->jenis_pengalihan) {
                    echo '<option value="' . $jp->id . '" selected>' . $jp->nama_pengalihan . '</option>';
                } else {
                    echo '<option value="' . $jp->id . '">' . $jp->nama_pengalihan . '</option>';
                }
            } ?>
        </select>
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>No. Akta</strong>
    </div>
    <div class="col-md-9">
        <input type="text" name="no_akta" id="no_akta" class="form-control" value="<?= $data->no_akta_pengalihan ?>">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Tanggal Akta</strong>
    </div>
    <div class="col-md-9">
        <input type="date" name="tgl_akta" id="tgl_akta" class="form-control" value="<?= $data->tgl_akta_pengalihan ?>">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Atas Nama</strong>
    </div>
    <div class="col-md-9">
        <input type="text" name="atas_nama" id="atas_nama" class="form-control" value="<?= $data->atas_nama_pengalihan ?>">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Terima Finance</strong>
    </div>
    <div class="col-md-9">
        <input type="date" name="st_finance" id="st_finance" class="form-control" value="<?= $data->serah_terima_finance ?>">
    </div>
</div>