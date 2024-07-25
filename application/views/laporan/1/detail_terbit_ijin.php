<table class="table table-sm table-bordered table-striped">
    <tr>
        <th>Lokasi</th>
        <td><?= $laporan->nama_proyek . ' (' . $laporan->nama_status . ')'; ?></td>
    </tr>

    <tr>
        <th>Titik Koordinat</th>
        <td><?= $laporan->koordinat ?></td>
    </tr>

    <tr>
        <th>Luas Surat</th>
        <td><?= $laporan->luas_surat ?></td>
    </tr>

    <tr>
        <th>Luas Terbit</th>
        <td><?= $laporan->luas_terbit ?></td>
    </tr>

    <tr>
        <th>Nomor Terbit</th>
        <td><?= $laporan->no_terbit_oss ?></td>
    </tr>

    <tr>
        <th>Daftar OSS</th>
        <td>
            <?php
            if ($laporan->daftar_online_oss == '0000-00-00') {
                echo '-';
            } else {
                $d1 = date_create($laporan->daftar_online_oss);
                echo date_format($d1, 'd F Y');
            }
            ?>
        </td>
    </tr>

    <tr>
        <th>Tanggal Daftar Pertimbangan</th>
        <td>
            <?php
            if ($laporan->tgl_daftar_pertimbangan == '0000-00-00') {
                echo '-';
            } else {
                $d2 = date_create($laporan->tgl_daftar_pertimbangan);
                echo date_format($d2, 'd F Y');
            }
            ?>
        </td>
    </tr>

    <tr>
        <th>Nomor Berkas Pertimbangan</th>
        <td><?= $laporan->no_berkas_pertimbangan ?></td>
    </tr>

    <tr>
        <th>Tanggal Terbit Pertimbangan</th>
        <td>
            <?php
            if ($laporan->tgl_terbit_pertimbangan == '0000-00-00') {
                echo '-';
            } else {
                $d3 = date_create($laporan->tgl_terbit_pertimbangan);
                echo date_format($d3, 'd F Y');
            }
            ?>
        </td>
    </tr>

    <tr>
        <th>Nomor SK Pertimbangan</th>
        <td><?= $laporan->no_sk_pertimbangan ?></td>
    </tr>

    <tr>
        <th>Tanggal Daftar Izin</th>
        <td>
            <?php
            if ($laporan->tgl_daftar_lokasi == '0000-00-00') {
                echo '-';
            } else {
                $d4 = date_create($laporan->tgl_daftar_lokasi);
                echo date_format($d4, 'd F Y');
            }
            ?>
        </td>
    </tr>

    <tr>
        <th>Tanggal Terbit Izin</th>
        <td>
            <?php
            if ($laporan->tgl_terbit_lokasi == '0000-00-00') {
                echo '-';
            } else {
                $d5 = date_create($laporan->tgl_terbit_lokasi);
                echo date_format($d5, 'd F Y');
            }
            ?>
        </td>
    </tr>

    <tr>
        <th>Nomor Izin</th>
        <td><?= $laporan->nomor_ijin_lokasi ?></td>
    </tr>

    <tr>
        <th>Masa Berlaku Izin</th>
        <td>
            <?php
            if ($laporan->masa_berlaku == '0000-00-00') {
                echo '-';
            } else {
                $d6 = date_create($laporan->masa_berlaku);
                echo date_format($d6, 'd F Y');
            }
            ?>
        </td>
    </tr>

    <tr>
        <th>Keterangan Izin</th>
        <td>
            <?= $laporan->ket ?>
        </td>
    </tr>

    <tr>
        <th>Status</th>
        <td><?= $laporan->status ?></td>
    </tr>
</table>