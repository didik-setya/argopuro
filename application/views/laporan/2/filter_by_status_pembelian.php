<!-- ISI DATA START -->
<div class="card">
    <div class="card-body">

        <table class="table table-responsive table-bordered text-nowrap" id="table-evaluasi">
            <thead>
                <tr style="background-color: #51008f;" class="text-white text-center">
                    <th rowspan="2" style="vertical-align: middle;">#</th>
                    <th rowspan="2" style="vertical-align: middle;">Lokasi</th>
                    <th rowspan="2" style="vertical-align: middle;">Tanggal Pembelian</th>
                    <th rowspan="2" style="vertical-align: middle;">Nama Penjual</th>
                    <th colspan="3" style="vertical-align: middle;">Data Surat Tanah 1</th>
                    <th colspan="3" style="vertical-align: middle;">Data Surat Tanah 2</th>
                    <th rowspan="2" style="vertical-align: middle;">No Gambar</th>
                    <th colspan="2" style="vertical-align: middle;">Luas (m2)</th>
                    <th colspan="3" style="vertical-align: middle;">PBB</th>
                    <th colspan="2" style="vertical-align: middle;">Harga Pengalihan Hak</th>
                    <th colspan="2" style="vertical-align: middle;">Makelar</th>
                    <th colspan="3" style="vertical-align: middle;">Pengalihan Hak</th>
                    <th colspan="5" style="vertical-align: middle;">Biaya Lain-lain</th>
                    <th rowspan="2" style="vertical-align: middle;">Total Harga</th>
                    <th rowspan="2" style="vertical-align: middle;">Harga / M^2</th>
                    <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
                </tr>
                <tr style="background-color: #d1d1d1;" class="text-center">
                    <!-- DATA SURAT TANAH 1 -->
                    <th style="vertical-align: middle;">Nama</th>
                    <th style="vertical-align: middle;">Surat</th>
                    <th style="vertical-align: middle;">Nomor Surat</th>
                    <!-- END DATA SURAT TANAH 1 -->

                    <!-- DATA SURAT TANAH 2 -->
                    <th style="vertical-align: middle;">Nama</th>
                    <th style="vertical-align: middle;">Surat</th>
                    <th style="vertical-align: middle;">Nomor Surat</th>
                    <!-- END DATA SURAT TANAH 2 -->

                    <th style="vertical-align: middle;">Surat</th>
                    <th style="vertical-align: middle;">Ukur</th>
                    <th style="vertical-align: middle;">Nomor</th>
                    <th style="vertical-align: middle;">Luas</th>
                    <th style="vertical-align: middle;">NJOP Bangunan</th>
                    <th style="vertical-align: middle;">Satuan</th>
                    <th style="vertical-align: middle;">Total</th>
                    <th style="vertical-align: middle;">Nama</th>
                    <th style="vertical-align: middle;">Nilai</th>
                    <th style="vertical-align: middle;">Tanggal</th>
                    <th style="vertical-align: middle;">Akta</th>
                    <th style="vertical-align: middle;">Nama</th>


                    <th style="vertical-align: middle;">Pematangan</th>
                    <th style="vertical-align: middle;">Ganti Rugi</th>
                    <th style="vertical-align: middle;">PBB</th>
                    <th style="vertical-align: middle;">Lain-lain</th>
                    <th style="vertical-align: middle;">Total</th>
                </tr>


            </thead>
            <tbody id="content">

                <?php
                if ($status_proyek == 1) {
                    $status = 'Luar Ijin';
                } else if ($status_proyek == 2) {
                    $status = 'Dalam Ijin';
                } else if ($status_proyek == 3) {
                    $status = 'Lokasi';
                } else {
                    $status = '';
                }
                ?>
                <tr class="table-warning">
                    <td class="text-bold text-nowrap">
                        IP Proyek - <?= $status ?>
                    </td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php foreach ($perumahan as $key) :
                    $dataperumahan = $this->laporan->get_tanah_menu2($key->proyek_id, '', '', $status_proyek);
                ?>
                    <tr class="table-secondary">
                        <td class="text-bold">Proyek - <?= $key->nama_proyek ?></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php
                    $i = 1;
                    foreach ($dataperumahan as $value => $data) : ?>
                        <?php
                        if ($data->tgl_akta_pengalihan != null) {
                            $tgl_akta_pengalihan = tgl_indo($data->tgl_akta_pengalihan);
                        } else {
                            $tgl_akta_pengalihan = '-';
                        }
                        if ($data->proyek_id == '0') {
                            $perumahan = 'Tidak ada';
                        } else {
                            $perumahan = $data->nama_proyek . " / " . "$data->nama_surat_tanah1";
                        }
                        if ($data->total_harga_pengalihan == 0) {
                            $harga_satuan = 0;
                            $total_harga_pengalihan = 0;
                        } else {
                            $total_harga_pengalihan = $data->total_harga_pengalihan;
                            $harga_satuan = $data->total_harga_pengalihan / $data->luas_surat;
                        }
                        if ($data->harga_jual_makelar == 0 || $data->harga_jual_makelar == '') {
                            $harga_jual_makelar = 0;
                        } else {
                            $harga_jual_makelar = $data->harga_jual_makelar;
                        }
                        if ($data->biaya_lain == 0 || $data->biaya_lain == '') {
                            $biaya_lain = 0;
                        } else {
                            $biaya_lain = $data->biaya_lain;
                        }

                        if ($data->biaya_lain_pematangan == '') {
                            $pematangan = 0;
                        } else {
                            $pematangan = $data->biaya_lain_pematangan;
                        }

                        if ($data->biaya_lain_pbb == '') {
                            $biaya_lain_pbb = 0;
                        } else {
                            $biaya_lain_pbb = $data->biaya_lain_pbb;
                        }

                        if ($data->biaya_lain_rugi == '') {
                            $ganti_rugi = 0;
                        } else {
                            $ganti_rugi = $data->biaya_lain_rugi;
                        }

                        $totalbiayalain = $biaya_lain + $pematangan + $biaya_lain_pbb + $ganti_rugi;
                        $totalharga_biaya = $total_harga_pengalihan + $harga_jual_makelar + $totalbiayalain;
                        if ($totalharga_biaya == 0) {
                            $harga_perm = 0;
                        } else {
                            $harga_perm = $totalharga_biaya / $data->luas_ukur;
                        }
                        ?>
                        <tr>
                            <td class="text-center"><?= $i++ ?></td>
                            <td class="text-nowrap"><?= $perumahan ?></td>
                            <td><?= tgl_indo($data->tgl_pembelian) ?></td>
                            <td><?= $data->nama_penjual ?></td>
                            <td><?= $data->nama_surat_tanah1 ?></td>
                            <td><?= $data->kode_sertifikat1 ?></td>
                            <td><?= $data->keterangan1 ?></td>
                            <td><?= $data->nama_surat_tanah2 ?></td>
                            <td><?= $data->kode_sertifikat2 ?></td>
                            <td><?= $data->keterangan2 ?></td>
                            <td><?= $data->nomor_gambar ?></td>
                            <td><?= $data->luas_surat ?> Meter</td>
                            <td><?= $data->luas_ukur ?> Meter</td>
                            <td><?= $data->nomor_pbb ?></td>
                            <td><?= $data->luas_bangunan_pbb ?> Meter</td>
                            <td><?= rupiah($data->njop_bangunan) ?></td>
                            <td><?= $data->luas_bumi_pbb ?> Meter</td>
                            <td><?= rupiah($data->njop_bumi_pbb) ?></td>
                            <td><?= $data->nama_makelar ?></td>
                            <td><?= rupiah($data->harga_jual_makelar) ?></td>
                            <td><?= $tgl_akta_pengalihan ?></td>
                            <td><?= $data->no_akta_pengalihan ?></td>
                            <td><?= $data->atas_nama_pengalihan ?></td>
                            <td><?= rupiah($data->biaya_lain_pematangan) ?></td>
                            <td><?= rupiah($data->biaya_lain_rugi) ?></td>
                            <td><?= rupiah($data->biaya_lain_pbb) ?></td>
                            <td><?= rupiah($data->biaya_lain) ?></td>
                            <td><?= rupiah($totalbiayalain) ?></td>
                            <td><?= rupiah($totalharga_biaya) ?></td>
                            <td><?= rupiah($harga_perm) ?></td>
                            <td><?= $data->ket ?></td>

                        </tr>
                    <?php endforeach ?>
                <?php endforeach ?>

            </tbody>
        </table>
    </div>
</div>