 <section class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-12">
                 <h3>Rekap Data Evaluasi Pembelian Tanah</h3>
             </div>

             <div class="col-12">
                 <form action="<?php echo site_url('export/rekap_pembelian_tanah/') ?>" method="get">
                     <div class="row">
                         <div class="col-md-3">
                             <div class="form-group">
                                 <select data-plugin-selectTwo class="form-control" id="proyek_id" name="proyek_id">
                                     <option value="">Semua Lokasi</option>
                                     <?php foreach ($proyek as $py) : ?>
                                         <option value="<?php echo $py->id; ?>"><?php echo $py->nama_proyek; ?></option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-2">
                             <div class="form-group">
                                 <select data-plugin-selectTwo class="form-control" id="status_proyek" name="status_proyek">
                                     <option value="">Status Proyek</option>
                                     <option value="1">Luar Ijin</option>
                                     <option value="2">Dalam Ijin</option>
                                     <option value="3">Lokasi</option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-2">
                             <input type="date" name="date1" id="f_date1" class="form-control">
                         </div>
                         <div class="col-md-2">
                             <input type="date" name="date2" id="f_date2" class="form-control">
                         </div>

                         <div class="col-md-3 text-right ">
                             <a class="btn btn-success btn-sm" onclick="load_data()"><i class="fas fa-filter"></i> Filter Data</a>
                             <button class="btn btn-info btn-sm" type="submit"><i class="fa fa-print"></i> Cetak</button>
                         </div>
                     </div>
                 </form>
             </div>

             <div class="col-12">
                 <div class="card">
                     <div class="card-body">

                         <nav>
                             <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                 <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
                                 <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Target</button>
                             </div>
                         </nav>
                         <div class="tab-content" id="nav-tabContent">
                             <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                 <br>
                                 <table class="table table-responsive-sm table-bordered text-nowrap" id="table_rekap_pembelian" style="width: 100%;">
                                     <thead>
                                         <tr class="bg-dark text-light">
                                             <th rowspan="3" style="text-align: center;vertical-align: middle;">#</th>
                                             <th rowspan="3" style="text-align: center;vertical-align: middle; ">Proyek</th>
                                             <th rowspan="2" colspan="2" style="text-align: center;vertical-align: middle; ">Target s/d <?= date('Y') ?></th>
                                             <th colspan="6" style="text-align: center;vertical-align: middle; ">Realisasi <?= date('Y') ?></th>
                                             <th rowspan="2" colspan="3" style="text-align: center;vertical-align: middle;">Evaluasi</th>
                                         </tr>
                                         <?php
                                            $now = date('M');
                                            $past = "Aug";

                                            $bulan_ini = date('M');
                                            $bulan_lalu = date('M', strtotime("-1 month", strtotime($bulan_ini)));

                                            ?>
                                         <tr class="bg-primary text-light">
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">Jan - Juni</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">Juli - Desember</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">TOTAL</th>
                                         </tr>
                                         <tr>
                                             <th style="text-align: center;vertical-align: middle;">Bidang</th>
                                             <th style="text-align: center;vertical-align: middle;">Luas</th>
                                             <th style="text-align: center;vertical-align: middle;">Bidang</th>
                                             <th style="text-align: center;vertical-align: middle;">Luas</th>
                                             <th style="text-align: center;vertical-align: middle;">Bidang</th>
                                             <th style="text-align: center;vertical-align: middle;">Luas</th>
                                             <th style="text-align: center;vertical-align: middle;">Bidang</th>
                                             <th style="text-align: center;vertical-align: middle;">Luas</th>
                                             <th style="text-align: center;vertical-align: middle;">Bidang</th>
                                             <th style="text-align: center;vertical-align: middle;">Luas</th>
                                             <th style="text-align: center;vertical-align: middle;">%</th>
                                         </tr>
                                     </thead>
                                     <tbody>

                                         <!-- IP LUAR IJIN START -->
                                         <?php if (isset($ip_luar_ijin)) { ?>
                                             <tr class="table-secondary">
                                                 <td class="text-bold">IP Proyek - Luar Ijin</td>
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
                                             <?php $no = 1;
                                                foreach ($ip_luar_ijin as $data1) : ?>
                                                 <tr class="text-center">
                                                     <td><?= $no++; ?></td>
                                                     <td><?= $data1['nama_proyek']; ?></td>
                                                     <?php if ($data1['bidtarget']) { ?>
                                                         <td><?= $data1['bidtarget']; ?></td>
                                                     <?php } else { ?>
                                                         <td>Tidak Terdapat Target</td>
                                                     <?php } ?>
                                                     <?php if ($data1['luastarget']) { ?>
                                                         <td><?= $data1['luastarget']; ?></td>
                                                     <?php } else { ?>
                                                         <td>Tidak Terdapat Target</td>
                                                     <?php } ?>

                                                     <td><?= $data1['bidrealsebelum']; ?></td>
                                                     <td><?= $data1['luasrealsebelum']; ?></td>
                                                     <td><?= $data1['bidrealsesudah']; ?></td>
                                                     <td><?= $data1['luasrealsesudah']; ?></td>
                                                     <td><?= $data1['bidrealsebelum'] + $data1['bidrealsesudah']; ?></td>
                                                     <td><?= $data1['luasrealsesudah'] + $data1['luasrealsebelum']; ?></td>

                                                     <?php if ($data1['bidtarget'] == 0) { ?>
                                                         <td><?= ($data1['bidrealsesudah'] + $data1['bidrealsebelum']) - 0 ?></td>
                                                     <?php } else { ?>
                                                         <td><?= ($data1['bidrealsesudah'] + $data1['bidrealsebelum']) - $data1['bidtarget'] ?></td>
                                                     <?php } ?>

                                                     <?php if ($data1['luastarget'] == 0) { ?>
                                                         <td><?= ($data1['luasrealsesudah'] + $data1['luasrealsebelum']) - 0 ?></td>
                                                     <?php } else { ?>
                                                         <td><?= ($data1['luasrealsesudah'] + $data1['luasrealsebelum']) - $data1['luastarget'] ?></td>
                                                     <?php } ?>

                                                     <?php if ($data1['bidtarget'] == 0) { ?>
                                                         <td><?php
                                                                $hasil = ((($data1['bidrealsebelum'] + $data1['bidrealsesudah']) - 0) / 1) * 100;
                                                                echo number_format((float)$hasil, 2, '.', '');
                                                                ?>%</td>
                                                     <?php } else if ($data1['bidrealsebelum'] != 0 || $data1['bidrealsesudah'] != 0 || $data1['bidtarget'] != 0 || $data1['luastarget'] != 0) { ?>
                                                         <td>
                                                             <?php $hasil = ((($data1['bidrealsebelum'] + $data1['bidrealsesudah']) - $data1['bidtarget']) / 1) * 100;
                                                                echo number_format((float)$hasil, 2, '.', ''); ?>%
                                                         </td>
                                                     <?php } else { ?>
                                                         <td>0</td>
                                                     <?php } ?>
                                                 </tr>
                                             <?php endforeach ?>
                                         <?php } ?>
                                         <!-- IP LUAR IJIN END -->

                                         <!-- IP DALAM IJIN START -->
                                         <?php if (isset($ip_dalam_ijin)) { ?>
                                             <tr class="table-secondary">
                                                 <td class="text-bold">IP Proyek - Dalam Ijin</td>
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
                                             <?php $no = 1;
                                                foreach ($ip_dalam_ijin as $data2) : ?>
                                                 <tr class="text-center">
                                                     <td><?= $no++; ?></td>
                                                     <td><?= $data2['nama_proyek']; ?></td>
                                                     <?php if ($data2['bidtarget']) { ?>
                                                         <td><?= $data2['bidtarget']; ?></td>
                                                     <?php } else { ?>
                                                         <td>Tidak Terdapat Target</td>
                                                     <?php } ?>
                                                     <?php if ($data2['luastarget']) { ?>
                                                         <td><?= $data2['luastarget']; ?></td>
                                                     <?php } else { ?>
                                                         <td>Tidak Terdapat Target</td>
                                                     <?php } ?>

                                                     <td><?= $data2['bidrealsebelum']; ?></td>
                                                     <td><?= $data2['luasrealsebelum']; ?></td>
                                                     <td><?= $data2['bidrealsesudah']; ?></td>
                                                     <td><?= $data2['luasrealsesudah']; ?></td>
                                                     <td><?= $data2['bidrealsebelum'] + $data2['bidrealsesudah']; ?></td>
                                                     <td><?= $data2['luasrealsesudah'] + $data2['luasrealsebelum']; ?></td>

                                                     <?php if ($data2['bidtarget'] == 0) { ?>
                                                         <td><?= ($data2['bidrealsesudah'] + $data2['bidrealsebelum']) - 0 ?></td>
                                                     <?php } else { ?>
                                                         <td><?= ($data2['bidrealsesudah'] + $data2['bidrealsebelum']) - $data2['bidtarget'] ?></td>
                                                     <?php } ?>

                                                     <?php if ($data2['luastarget'] == 0) { ?>
                                                         <td><?= ($data2['luasrealsesudah'] + $data2['luasrealsebelum']) - 0 ?></td>
                                                     <?php } else { ?>
                                                         <td><?= ($data2['luasrealsesudah'] + $data2['luasrealsebelum']) - $data2['luastarget'] ?></td>
                                                     <?php } ?>

                                                     <?php if ($data2['bidtarget'] == 0) { ?>
                                                         <td><?php
                                                                $hasil = ((($data2['bidrealsebelum'] + $data2['bidrealsesudah']) - 0) / 1) * 100;
                                                                echo number_format((float)$hasil, 2, '.', '');
                                                                ?>%</td>
                                                     <?php } else if ($data2['bidrealsebelum'] != 0 || $data2['bidrealsesudah'] != 0 || $data2['bidtarget'] != 0 || $data2['luastarget'] != 0) { ?>
                                                         <td>
                                                             <?php $hasil = ((($data2['bidrealsebelum'] + $data2['bidrealsesudah']) - $data2['bidtarget']) / 1) * 100;
                                                                echo number_format((float)$hasil, 2, '.', ''); ?>%
                                                         </td>
                                                     <?php } else { ?>
                                                         <td>0</td>
                                                     <?php } ?>
                                                 </tr>
                                             <?php endforeach ?>
                                         <?php } ?>
                                         <!-- IP DALAM IJIN END -->

                                         <!-- IP LOKASI START -->
                                         <?php if (isset($ip_lokasi)) { ?>
                                             <tr class="table-secondary">
                                                 <td class="text-bold">IP Proyek - Lokasi</td>
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
                                             <?php $no = 1;
                                                foreach ($ip_lokasi as $data3) : ?>
                                                 <tr class="text-center">
                                                     <td><?= $no++; ?></td>
                                                     <td><?= $data3['nama_proyek']; ?></td>
                                                     <?php if ($data3['bidtarget']) { ?>
                                                         <td><?= $data3['bidtarget']; ?></td>
                                                     <?php } else { ?>
                                                         <td>Tidak Terdapat Target</td>
                                                     <?php } ?>
                                                     <?php if ($data3['luastarget']) { ?>
                                                         <td><?= $data3['luastarget']; ?></td>
                                                     <?php } else { ?>
                                                         <td>Tidak Terdapat Target</td>
                                                     <?php } ?>

                                                     <td><?= $data3['bidrealsebelum']; ?></td>
                                                     <td><?= $data3['luasrealsebelum']; ?></td>
                                                     <td><?= $data3['bidrealsesudah']; ?></td>
                                                     <td><?= $data3['luasrealsesudah']; ?></td>
                                                     <td><?= $data3['bidrealsebelum'] + $data3['bidrealsesudah']; ?></td>
                                                     <td><?= $data3['luasrealsesudah'] + $data3['luasrealsebelum']; ?></td>

                                                     <?php if ($data3['bidtarget'] == 0) { ?>
                                                         <td><?= ($data3['bidrealsesudah'] + $data3['bidrealsebelum']) - 0 ?></td>
                                                     <?php } else { ?>
                                                         <td><?= ($data3['bidrealsesudah'] + $data3['bidrealsebelum']) - $data3['bidtarget'] ?></td>
                                                     <?php } ?>

                                                     <?php if ($data3['luastarget'] == 0) { ?>
                                                         <td><?= ($data3['luasrealsesudah'] + $data3['luasrealsebelum']) - 0 ?></td>
                                                     <?php } else { ?>
                                                         <td><?= ($data3['luasrealsesudah'] + $data3['luasrealsebelum']) - $data3['luastarget'] ?></td>
                                                     <?php } ?>

                                                     <?php if ($data3['bidtarget'] == 0) { ?>
                                                         <td><?php
                                                                $hasil = ((($data3['bidrealsebelum'] + $data3['bidrealsesudah']) - 0) / 1) * 100;
                                                                echo number_format((float)$hasil, 2, '.', '');
                                                                ?>%</td>
                                                     <?php } else if ($data3['bidrealsebelum'] != 0 || $data3['bidrealsesudah'] != 0 || $data3['bidtarget'] != 0 || $data3['luastarget'] != 0) { ?>
                                                         <td>
                                                             <?php $hasil = ((($data3['bidrealsebelum'] + $data3['bidrealsesudah']) - $data3['bidtarget']) / 1) * 100;
                                                                echo number_format((float)$hasil, 2, '.', ''); ?>%
                                                         </td>
                                                     <?php } else { ?>
                                                         <td>0</td>
                                                     <?php } ?>
                                                 </tr>
                                             <?php endforeach ?>
                                         <?php } ?>
                                         <!-- IP LOKASI END -->

                                     </tbody>
                                     <tfoot>
                                     </tfoot>
                                 </table>
                             </div>
                             <div class="tab-pane fade table-responsive" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                 <br>
                                 <table class="table table-bordered text-nowrap" id="table_target_pembelian" style="width:100%">
                                     <thead>
                                         <tr class=" bg-dark text-light">
                                             <th rowspan="3" style="text-align: center;vertical-align: middle; ">#</th>
                                             <th rowspan="3" style="text-align: center;vertical-align: middle; ">Proyek</th>
                                             <th class="bg-primary text-white" colspan="24" style="text-align: center;vertical-align: middle;">TARGET <?= date("Y") ?></th>
                                         </tr>
                                         <tr>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">JAN</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">FEB</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">MAR</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">APR</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">MEI</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">JUN</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">JUL</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">AGU</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">SEP</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">OKT</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">NOV</th>
                                             <th colspan="2" style="text-align: center;vertical-align: middle;">DES</th>
                                         </tr>
                                         <tr>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                             <th style="text-align: center;vertical-align: middle;">BID </th>
                                             <th style="text-align: center;vertical-align: middle;">LUAS</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php $i = 1;
                                            foreach ($pro as $p) { ?>
                                             <tr>
                                                 <td><?= $i++; ?></td>
                                                 <td><?= $p->nama_proyek ?></td>
                                                 <?php
                                                    $year = date('Y');
                                                    $target = $this->db->where(['proyek_id' => $p->id, 'year(tahun)' => $year])->get('master_proyek_target')->result();
                                                    ?>
                                                 <?php if (!empty($target)) { ?>
                                                     <?php foreach ($target as $tr) { ?>
                                                         <td><?= $tr->target_bidang ?></td>
                                                         <td><?= $tr->target_luas ?></td>
                                                     <?php } ?>
                                                 <?php } else { ?>
                                                     <td>Tidak ada target</td>
                                                     <td>0</td>
                                                     <?php for ($i = 0; $i < 11; $i++) { ?>
                                                         <td>0</td>
                                                         <td>0</td>
                                                     <?php } ?>
                                                 <?php } ?>
                                             </tr>
                                         <?php } ?>
                                     </tbody>
                                     <tfoot>
                                     </tfoot>
                                 </table>
                             </div>
                         </div>



                     </div>
                 </div>
             </div>
         </div>
     </div><!-- /.container-fluid -->
 </section>


 <script>
     const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

     $(document).ready(function() {

         $('#table_target_pembelian').dataTable({
             "searching": false,
             "ordering": false,
         });

         $('#table_rekap_pembelian').dataTable({
             "scrollX": true,
             "searching": false,
             "ordering": false,
             "autoWidth": false,
             columnDefs: [{
                 "defaultContent": "-",
                 "targets": "_all"
             }],
         })
     })

     function load_data() {

         var cek = '<?= site_url('dashboard/rekap_pembelian_tanah') ?>';
         let proyek = $('#proyek_id').val();
         let status = $('#status_proyek').val();
         let date_a = $('#f_date1').val()
         let date_b = $('#f_date2').val()

         window.location.href = cek + '?proyek=' + proyek + '&status=' + status + '&date_a=' + date_a + '&date_b=' + date_b;

     }
 </script>