<?php
$status_teknik = ['belum', 'selesai'];
$status_pengalihan = ['belum order', 'order', 'terbit'];

$total_lain = $data->biaya_lain_pematangan + $data->biaya_lain_rugi + $data->biaya_lain_pbb + $data->biaya_lain;
$total_all = $total_lain + $data->total_harga_pengalihan + $data->harga_jual_makelar;
$harga_per_meter = $total_all / $data->luas_ukur;
?>
<input type="hidden" name="id" id="id_edit" value="<?= $data->id ?>">

<div class="row my-2">
    <div class="col-md-3">
        <strong>Nama Penjual</strong>
    </div>
    <div class="col-md-9">
        <input type="text" name="penjual" id="penjual" disabled class="form-control" value="<?= $data->nama_penjual ?>">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Tanggal Pembelian</strong>
    </div>
    <div class="col-md-9">
        <input type="date" name="tglbeli" id="tglbeli" disabled class="form-control" value="<?= $data->tgl_pembelian ?>">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Data Surat Tanah 1</strong>
    </div>
    <div class="col-md-4">
        <input type="text" name="namasrt1" id="namasrt1" value="<?= $data->nama_surat_tanah1 ?>" class="form-control" disabled>
    </div>
    <div class="col-md-5">
        <input type="text" name="ketsrt1" id="ketsrt1" value="<?= $data->keterangan1 ?>" class="form-control" disabled>
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Data Surat Tanah 2</strong>
    </div>
    <div class="col-md-4">
        <input type="text" name="namasrt2" id="namasrt2" value="<?= $data->nama_surat_tanah2 ?>" class="form-control" disabled>
    </div>
    <div class="col-md-5">
        <input type="text" name="ketsrt2" id="ketsrt2" value="<?= $data->keterangan2 ?>" class="form-control" disabled>
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Total Harga Pengalihan</strong>
    </div>
    <div class="col-md-9">
        <input type="text" name="total_pengalihan" id="total_pengalihan" disabled class="form-control mask" value="<?= $data->total_harga_pengalihan ?>">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Makelar</strong>
    </div>
    <div class="col-md-9">
        <input type="text" name="makelar" id="makelar" disabled class="form-control" value="<?= $data->nama_makelar ?>">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Nilai Makelar</strong>
    </div>
    <div class="col-md-9">
        <input type="text" name="nmakelar" id="nmakelar" disabled class="form-control mask" value="<?= $data->harga_jual_makelar ?>">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Harga Jual</strong>
    </div>
    <div class="col-md-9">
        <input type="text" name="harga_jual" id="harga_jual" disabled class="form-control mask" value="<?= $data->total_harga_pengalihan ?>">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Status Akta</strong>
    </div>
    <div class="col-md-9">
        <select name="status_pengalihan_akta" id="status_pengalihan_akta" class="form-control">
            <option value="">--pilih--</option>
            <?php foreach ($status_pengalihan as $sp) {
                if ($sp == $data->status_pengalihan) {
                    echo '<option value="' . $sp . '" selected>' . $sp . '</option>';
                } else {
                    echo '<option value="' . $sp . '">' . $sp . '</option>';
                }
            } ?>
        </select>
    </div>
</div>
<div class="row my-2">
    <div class="col-md-3">
        <strong>Tanggal Pengalihan Status</strong>
    </div>
    <div class="col-md-9">
        <input type="date" name="tgl_pengalihan_status" id="tgl_pengalihan_status" class="form-control" value="<?= $data->tgl_status_pengalihan ?>">
    </div>
</div>
<div class="row my-2">
    <div class="col-md-3">
        <strong>Tanggal Pengalihan Akta</strong>
    </div>
    <div class="col-md-9">
        <input type="date" name="tgl_pengalihan_akta" id="tgl_pengalihan_akta" class="form-control" value="<?= $data->tgl_akta_pengalihan ?>">
    </div>
</div>
<div class="row my-2">
    <div class="col-md-3">
        <strong>No. Akta Pengalihan</strong>
    </div>
    <div class="col-md-9">
        <input type="text" name="no_pengalihan_akta" id="no_pengalihan_akta" class="form-control" value="<?= $data->no_akta_pengalihan ?>">
    </div>
</div>
<div class="row my-2">
    <div class="col-md-3">
        <strong>Nama Pengalihan</strong>
    </div>
    <div class="col-md-9">
        <input type="text" name="nama_pengalihan" id="nama_pengalihan" class="form-control" value="<?= $data->atas_nama_pengalihan ?>">
    </div>
</div>
<div class="row my-2">
    <div class="col-md-3">
        <strong>Harga / m<sup>2</sup></strong>
    </div>
    <div class="col-md-9">
        <input type="text" name="hrg_m2" id="hrg_m2" disabled class="form-control" value="<?= number_format($harga_per_meter) ?>">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Serah Terima Finance</strong>
    </div>
    <div class="col-md-9">
        <input type="date" name="finance" id="finance" value="<?= $data->serah_terima_finance ?>" class="form-control">
    </div>
</div>

<div class="row my-2">
    <div class="col-md-3">
        <strong>Serah Terima Teknik</strong>
    </div>
    <div class="col-md-9">
        <select name="ke_teknik" id="ke_teknik" class="form-control">
            <option value="">--pilih--</option>
            <?php foreach ($status_teknik as $st) {
                if ($st == $data->status_teknik) {
                    echo '<option value="' . $st . '" selected>' . $st . '</option>';
                } else {
                    echo '<option value="' . $st . '">' . $st . '</option>';
                }
            } ?>
        </select>
    </div>
</div>
<div class="row my-2">
    <div class="col-md-3">
        <strong>Ket</strong>
    </div>
    <div class="col-md-9">
        <textarea name="ket" id="ket" cols="30" rows="5" class="form-control"><?= $data->ket ?></textarea>
    </div>
</div>



<script>
    $('.mask').mask('#.##0', {
        reverse: true
    });
</script>