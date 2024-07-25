 <section class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-12">

                 <div class="form-group mt-lg">

                 </div>

                 <h3>Master Tanah</h3>
                 <div class="card">
                     <div class="card-body">

                         <button class="btn btn-sm btn-success mb-3" onclick="add_tanah()"><i class="fa fa-plus"></i> Tambah Tanah</button>

                         <form action="<?= site_url('export/master_tanah/') ?>" method="get">
                             <div class="row">
                                 <div class="col-sm-2">
                                     <div class="form-group">
                                         <select data-plugin-selectTwo class="form-control" onchange="refresh()" id="perumahan" name="perumahan">
                                             <option value="">Semua Lokasi</option>
                                             <?php foreach ($proyek as $py) : ?>
                                                 <option value="<?php echo $py->id; ?>"><?php echo $py->nama_proyek; ?></option>
                                             <?php endforeach; ?>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-sm-2">
                                     <div class="form-group">
                                         <select data-plugin-selectTwo class="form-control" onchange="refresh()" id="status_perumahan" name="status_perumahan">
                                             <option value="">Semua Status</option>
                                             <?php foreach ($status_proyek as $sp) : ?>
                                                 <option value="<?php echo $sp->id; ?>"><?php echo $sp->nama_status ?></option>
                                             <?php endforeach; ?>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-sm-2">
                                     <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" onchange="refresh()" autocomplete="off" />
                                 </div>
                                 <div class="col-sm-2">
                                     <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" onchange="refresh()" autocomplete="off" />
                                 </div>
                                 <div class="col-sm-2">
                                     <button class="btn btn-primary btn-hover pr-5" type="submit">
                                         <i class="fa fa-print"></i> cetak
                                     </button>
                                 </div>
                             </div>

                         </form>

                         <table class="table table-responsive table-bordered" id="table_tanah" style="width:100%">
                             <thead>
                                 <tr class="bg-dark text-light">
                                     <th rowspan="2" style="vertical-align: middle;"><i class="fa fa-cogs"></i></th>
                                     <th rowspan="2" style="vertical-align: middle;">No</th>
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
                                 <tr class="bg-primary text-light">
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
                                     <th style="vertical-align: middle;">NJOP</th>
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

                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div><!-- /.container-fluid -->
 </section>



 <!-- Modal -->
 <div class="modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="<?= base_url('ajax_tanah/validation_tanah') ?>" id="form_tanah" method="post">
                 <input type="hidden" name="id" id="id">
                 <input type="hidden" name="act" id="act">

                 <div class="modal-body">
                     <div class="form-group mb-3">
                         <label>Lokasi</label>
                         <select name="proyek_id" id="proyek_id" required class="form-control">
                             <option value="">--pilih--</option>
                             <?php foreach ($proyek as $py) : ?>
                                 <option value="<?php echo $py->id; ?>"><?php echo $py->nama_proyek; ?></option>
                             <?php endforeach; ?>
                         </select>
                         <small class="text-danger" id="err_proyek_id"></small>
                     </div>

                     <div class="form-group mb-3">
                         <label>Status Proyek</label>
                         <select name="status_proyek" id="status_proyek" required class="form-control">
                             <option value="">--pilih--</option>
                             <?php foreach ($status_proyek as $sp) : ?>
                                 <option value="<?php echo $sp->id; ?>"><?php echo $sp->nama_status; ?></option>
                             <?php endforeach; ?>
                         </select>
                         <small class="text-danger" id="err_status_proyek"></small>
                     </div>

                     <div class="form-group mb-3">
                         <label>Nama Penjual</label>
                         <input type="text" name="nama_penjual" id="nama_penjual" class="form-control" required>
                         <small class="text-danger" id="err_nama_penjual"></small>
                     </div>

                     <div class="form-group mb-3">
                         <label>Tanggal Pembelian</label>
                         <input type="date" name="tgl_pembelian" id="tgl_pembelian" class="form-control" required>
                         <small class="text-danger" id="err_tgl_pembelian"></small>
                     </div>
                     <div class="form-group mb-3">
                         <label>Data Surat Tanah 1</label>
                         <div class="row">
                             <div class="col-sm-4">
                                 <input type="text" placeholder="Atas Nama Surat 1" name="nama_surat_tanah1" id="nama_surat_tanah1" class="form-control">
                             </div>
                             <small class="text-danger" id="err_surat_tanah1"></small>
                             <div class="col-sm-4">
                                 <select name="status_surat_tanah1" id="status_surat_tanah1" required class="form-control">
                                     <option value="">--pilih--</option>
                                     <?php foreach ($sertifikat_tanah as $st) : ?>
                                         <option value="<?php echo $st->id; ?>"><?php echo $st->kode . ' / ' . $st->nama_sertif; ?></option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                             <small class="text-danger" id="err_status_surat1"></small>
                             <div class="col-sm-4">
                                 <input type="text" placeholder="Keterangan Surat 1" name="keterangan1" id="keterangan1" class="form-control">
                             </div>
                         </div>
                     </div>
                     <div class="form-group mb-3">
                         <label>Data Surat Tanah 2</label>
                         <div class="row">
                             <div class="col-sm-4">
                                 <input type="text" placeholder="Atas Nama Surat 2" name="nama_surat_tanah2" id="nama_surat_tanah2" class="form-control">
                             </div>
                             <div class="col-sm-4">
                                 <select name="status_surat_tanah2" id="status_surat_tanah2" class="form-control">
                                     <option value="">--pilih--</option>
                                     <?php foreach ($sertifikat_tanah as $st) : ?>
                                         <option value="<?php echo $st->id; ?>"><?php echo $st->kode . ' / ' . $st->nama_sertif; ?></option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                             <div class="col-sm-4">
                                 <input type="text" placeholder="Keterangan Surat 2" name="keterangan2" id="keterangan2" class="form-control">
                             </div>
                         </div>
                     </div>

                     <div class="form-group mb-3">
                         <label>No Gambar</label>
                         <input type="text" placeholder="Nomor Gambar" name="nomor_gambar" id="nomor_gambar" class="form-control" required>
                         <small class="text-danger" id="err_nomor_gambar"></small>
                     </div>

                     <div class="form-group mb-3">
                         <label>Luas Tanah</label>
                         <div class="row">
                             <div class="col-sm-6">
                                 <input type="text" placeholder="Luas Surat" name="luas_surat" id="luas_surat" class="form-control" required>
                             </div>
                             <small class="text-danger" id="err_luas_surat"></small>
                             <div class="col-sm-6">
                                 <input type="text" placeholder="Luas Ukur" name="luas_ukur" id="luas_ukur" class="form-control" required>
                             </div>
                             <small class="text-danger" id="err_luas_ukur"></small>
                         </div>
                     </div>

                     <div class="form-group mb-3">
                         <label>Data PBB</label>
                         <div class="row">
                             <div class="col-sm-4">
                                 <input type="text" placeholder="Nomor PBB" name="nomor_pbb" id="nomor_pbb" class="form-control">
                             </div>
                             <div class="col-sm-4">
                                 <input type="text" placeholder="Atas Nama PBB" name="atas_nama_pbb" id="atas_nama_pbb" class="form-control">
                             </div>
                             <div class="col-sm-4">
                                 <input type="text" placeholder="Luas Bangunan PBB" name="luas_bangunan_pbb" id="luas_bangunan_pbb" class="form-control">
                             </div>
                         </div>
                     </div>
                     <div class="form-group mb-3">
                         <div class="row">
                             <div class="col-sm-4">
                                 <input type="text" placeholder="NJOP Bangunan" name="njop_bangunan" id="njop_bangunan" class="form-control mask-money">
                             </div>
                             <div class="col-sm-4">
                                 <input type="text" placeholder="Luas Bumi PBB" name="luas_bumi_pbb" id="luas_bumi_pbb" class="form-control">
                             </div>
                             <div class="col-sm-4">
                                 <input type="text" placeholder="NJOP Bumi" name="njop_bumi_pbb" id="njop_bumi_pbb" class="form-control mask-money">
                             </div>
                         </div>
                     </div>

                     <div class="form-group mb-3">
                         <label>Harga Pengalihan Hak</label>
                         <input type="text" placeholder="Total Harga Pengalihan" name="total_harga_pengalihan" id="total_harga_pengalihan" class="form-control mask-money" required>
                         <small class="text-danger" id="err_harga_pengalihan"></small>
                     </div>

                     <div class="form-group mb-3">
                         <label>Nama Makelar</label>
                         <input type="text" placeholder="Atas Nama Makelar" name="nama_makelar" id="nama_makelar" class="form-control" required>
                         <small class="text-danger" id="err_nama_makelar"></small>
                     </div>

                     <div class="form-group mb-3">
                         <label>Harga Jual Makelar</label>
                         <input type="text" placeholder="Harga Jual Makelar" name="harga_jual_makelar" id="harga_jual_makelar" class="form-control mask-money" required>
                         <small class="text-danger" id="err_jual_makelar"></small>
                     </div>

                     <div class="form-group mb-3">
                         <label>Jenis Pengalihan</label>
                         <select name="jenis_pengalihan" id="jenis_pengalihan" required class="form-control">
                             <option value="">--pilih--</option>
                             <?php foreach ($jenis_pengalihan as $jp) : ?>
                                 <option value="<?php echo $jp->id; ?>"><?php echo $jp->nama_pengalihan; ?></option>
                             <?php endforeach; ?>
                         </select>
                     </div><small class="text-danger" id="jenis_pengalihan"></small>

                     <div class="form-group mb-3">
                         <label>Biaya Lain Lain</label>
                         <div class="row">
                             <div class="col-sm-6">
                                 <input type="text" placeholder="Pematangan" name="biaya_lain_pematangan" id="biaya_lain_pematangan" class="form-control mask-money">
                             </div>
                             <div class="col-sm-6">
                                 <input type="text" placeholder="Ganti Rugi" name="biaya_lain_rugi" id="biaya_lain_rugi" class="form-control mask-money">
                             </div>
                         </div>
                     </div>

                     <div class="form-group mb-3">
                         <div class="row">
                             <div class="col-sm-6">
                                 <input type="text" placeholder="PBB" name="biaya_lain_pbb" id="biaya_lain_pbb" class="form-control mask-money">
                             </div>
                             <div class="col-sm-6">
                                 <input type="text" placeholder="Lain-lain" name="biaya_lain" id="biaya_lain" class="form-control mask-money">
                             </div>
                         </div>
                     </div>

                     <div class="form-group mb-3">
                         <textarea class="form-control" name="ket_lain" id="ket_lain" rows="3" placeholder="Keterangan Biaya Lain"></textarea>
                     </div>

                     <div class="form-group mb-3">
                         <label>Keterangan</label>
                         <textarea class="form-control" name="ket" id="ket" rows="3" placeholder="Keterangan Tanah"></textarea>
                     </div>

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
     const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

     $('.mask-money').mask("#.##0", {
         reverse: true
     });


     function refresh() {
         // $('#itemsdata').data.reload();
         table = $('#table_tanah').DataTable();
         table.destroy();

         $table = $('#table_tanah').DataTable({
             "serverSide": true,
             "ordering": false,
             "order": [],
             "ajax": {
                 "url": "<?php echo base_url() ?>ajax_tanah/datatable_tanah",
                 "type": "GET",
                 "data": {
                     tgl_awal: function() {
                         return $('#tgl_awal').val()
                     },
                     tgl_akhir: function() {
                         return $('#tgl_akhir').val()
                     },
                     perumahan: function() {
                         return $('#perumahan').val()
                     },
                     status_perumahan: function() {
                         return $('#status_perumahan').val()
                     }
                 }
             },
             "columnDefs": [{
                 "targets": [0],
                 "orderable": false,
             }, ],
         });
     }
     var tableitems = $('#table_tanah').DataTable({
         "serverSide": true,
         "ordering": false,
         "order": [],
         "ajax": {
             "url": "<?php echo base_url() ?>ajax_tanah/datatable_tanah",
             "type": "GET",
             "data": {
                 tgl_awal: function() {
                     return $('#tgl_awal').val()
                 },
                 tgl_akhir: function() {
                     return $('#tgl_akhir').val()
                 },
                 perumahan: function() {
                     return $('#perumahan').val()
                 },
                 status_perumahan: function() {
                     return $('#status_perumahan').val()
                 }
             }
         },
         "columnDefs": [{
             "targets": [0],
             "orderable": false,
         }, ],
     });

     function add_tanah() {
         $('#staticBackdrop').modal('show')
         $('.modal-title').html('Tambah Tanah Baru')

         $('#err_nama_penjual').html('')
         $('#err_tgl_pembelian').html('')
         $('#err_surat_tanah1').html('')
         $('#err_keterangan1').html('')
         $('#err_surat_tanah2').html('')
         $('#err_keterangan2').html('')
         $('#err_nomor_gambar').html('')
         $('#err_luas_surat').html('')
         $('#err_luas_ukur').html('')
         $('#err_nomor_pbb').html('')
         $('#err_nama_pbb').html('')
         $('#err_bangunan_pbb').html('')
         $('#err_njop_bangunan').html('')
         $('#err_bumi_pbb').html('')
         $('#err_njop_bumi_pbb').html('')
         $('#err_harga_pengalihan').html('')
         $('#err_nama_makelar').html('')
         $('#err_jual_makelar').html('')
         $('#err_lain_pematangan').html('')
         $('#err_lain_rugi').html('')
         $('#err_lain_pbb').html('')
         $('#err_biaya_lain').html('')

         $('#act').val('add');
         $('#proyek_id').val('');
         $('#status_proyek').val('');
         $('#nama_penjual').val('');
         $('#tgl_pembelian').val('');
         $('#nama_surat_tanah1').val('');
         $('#status_surat_tanah1').val('');
         $('#keterangan1').val('');
         $('#nama_surat_tanah2').val('');
         $('#status_surat_tanah2').val('');
         $('#keterangan2').val('');
         $('#nomor_gambar').val('');
         $('#luas_surat').val('');
         $('#luas_ukur').val('');
         $('#nomor_pbb').val('');
         $('#atas_nama_pbb').val('');
         $('#luas_bangunan_pbb').val('');
         $('#njop_bangunan').val('');
         $('#luas_bumi_pbb').val('');
         $('#njop_bumi_pbb').val('');
         $('#total_harga_pengalihan').val('');
         $('#nama_makelar').val('');
         $('#harga_jual_makelar').val('');
         $('#jenis_pengalihan').val('');
         $('#biaya_lain_pematangan').val('');
         $('#biaya_lain_rugi').val('');
         $('#biaya_lain_pbb').val('');
         $('#biaya_lain').val('');
         $('#ket_lain').val('');
         $('#keterangan').val('');

     }

     function edit_tanah(id) {
         $('#staticBackdrop').modal('show')
         $('.modal-title').html('Edit Tanah')

         $('#err_nama_penjual').html('')
         $('#err_tgl_pembelian').html('')
         $('#err_surat_tanah1').html('')
         $('#err_keterangan1').html('')
         $('#err_surat_tanah2').html('')
         $('#err_keterangan2').html('')
         $('#err_nomor_gambar').html('')
         $('#err_luas_surat').html('')
         $('#err_luas_ukur').html('')
         $('#err_nomor_pbb').html('')
         $('#err_nama_pbb').html('')
         $('#err_bangunan_pbb').html('')
         $('#err_njop_bangunan').html('')
         $('#err_bumi_pbb').html('')
         $('#err_njop_bumi_pbb').html('')
         $('#err_harga_pengalihan').html('')
         $('#err_nama_makelar').html('')
         $('#err_jual_makelar').html('')
         $('#err_lain_pematangan').html('')
         $('#err_lain_rugi').html('')
         $('#err_lain_pbb').html('')
         $('#err_biaya_lain').html('')

         $('#act').val('edit')
         $('#id').val(id)
         $('#proyek_id').val('')
         $('#status_proyek').val('')
         $('#nama_penjual').val('')
         $('#tgl_pembelian').val('')
         $('#nama_surat_tanah1').val('')
         $('#status_surat_tanah1').val('')
         $('#keterangan1').val('')
         $('#nama_surat_tanah2').val('')
         $('#status_surat_tanah2').val('')
         $('#keterangan2').val('')
         $('#nomor_gambar').val('')
         $('#luas_surat').val('')
         $('#luas_ukur').val('')
         $('#nomor_pbb').val('')
         $('#atas_nama_pbb').val('')
         $('#luas_bangunan_pbb').val('')
         $('#njop_bangunan').val('')
         $('#luas_bumi_pbb').val('')
         $('#njop_bumi_pbb').val('')
         $('#total_harga_pengalihan').val('')
         $('#nama_makelar').val('')
         $('#harga_jual_makelar').val('')
         $('#jenis_pengalihan').val('')
         $('#biaya_lain_pematangan').val('')
         $('#biaya_lain_rugi').val('')
         $('#biaya_lain_pbb').val('')
         $('#biaya_lain').val('')
         $('#ket_lain').val('')
         $('#ket').val('')
         get_detail_tanah(id)
     }

     function get_detail_tanah(id) {
         $.ajax({
             url: '<?= base_url('ajax_tanah/detail_tanah') ?>',
             data: {
                 id: id
             },
             type: 'POST',
             dataType: 'JSON',
             success: function(d) {

                 $('#proyek_id').val(d.proyek_id)
                 $('#status_proyek').val(d.status_proyek)
                 $('#nama_penjual').val(d.nama_penjual)
                 $('#tgl_pembelian').val(d.tgl_pembelian)
                 $('#nama_surat_tanah1').val(d.nama_surat_tanah1)
                 $('#status_surat_tanah1').val(d.status_surat_tanah1)
                 $('#keterangan1').val(d.keterangan1)
                 $('#nama_surat_tanah2').val(d.nama_surat_tanah2)
                 $('#status_surat_tanah2').val(d.status_surat_tanah2)
                 $('#keterangan2').val(d.keterangan2)
                 $('#nomor_gambar').val(d.nomor_gambar)
                 $('#luas_surat').val(d.luas_surat)
                 $('#luas_ukur').val(d.luas_ukur)
                 $('#nomor_pbb').val(d.nomor_pbb)
                 $('#atas_nama_pbb').val(d.atas_nama_pbb)
                 $('#luas_bangunan_pbb').val(d.luas_bangunan_pbb)
                 $('#njop_bangunan').val(d.njop_bangunan)
                 $('#luas_bumi_pbb').val(d.luas_bumi_pbb)
                 $('#njop_bumi_pbb').val(d.njop_bumi_pbb)
                 $('#total_harga_pengalihan').val(d.total_harga_pengalihan)
                 $('#nama_makelar').val(d.nama_makelar)
                 $('#harga_jual_makelar').val(d.harga_jual_makelar)
                 $('#jenis_pengalihan').val(d.jenis_pengalihan)
                 $('#biaya_lain_pematangan').val(d.biaya_lain_pematangan)
                 $('#biaya_lain_rugi').val(d.biaya_lain_rugi)
                 $('#biaya_lain_pbb').val(d.biaya_lain_pbb)
                 $('#biaya_lain').val(d.biaya_lain)
                 $('#ket_lain').val(d.ket_lain)
                 $('#ket').val(d.ket)

             },
             error: function(xhr, status, error) {
                 error_alert(error)
             }
         })
     }

     $('#form_tanah').submit(function(e) {
         e.preventDefault()
         $('.mask-money').unmask();
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

                 if (d.type == 'validation') {
                     if (d.err_nama_penjual == '') {
                         $('#err_nama_penjual').html('')
                     } else {
                         $('#err_nama_penjual').html(d.err_nama_penjual)
                     }
                     if (d.err_tgl_pembelian == '') {
                         $('#err_tgl_pembelian').html('')
                     } else {
                         $('#err_tgl_pembelian').html(d.err_tgl_pembelian)
                     }
                     if (d.err_surat_tanah1 == '') {
                         $('#err_surat_tanah1').html('')
                     } else {
                         $('#err_surat_tanah1').html(d.err_surat_tanah1)
                     }
                     if (d.err_keterangan1 == '') {
                         $('#err_keterangan1').html('')
                     } else {
                         $('#err_keterangan1').html(d.err_keterangan1)
                     }
                     if (d.err_surat_tanah2 == '') {
                         $('#err_surat_tanah2').html('')
                     } else {
                         $('#err_surat_tanah2').html(d.err_surat_tanah2)
                     }
                     if (d.err_keterangan2 == '') {
                         $('#err_keterangan2').html('')
                     } else {
                         $('#err_keterangan2').html(d.err_keterangan2)
                     }
                     if (d.err_nomor_gambar == '') {
                         $('#err_nomor_gambar').html('')
                     } else {
                         $('#err_nomor_gambar').html(d.err_nomor_gambar)
                     }
                     if (d.err_luas_surat == '') {
                         $('#err_luas_surat').html('')
                     } else {
                         $('#err_luas_surat').html(d.err_luas_surat)
                     }
                     if (d.err_luas_ukur == '') {
                         $('#err_luas_ukur').html('')
                     } else {
                         $('#err_luas_ukur').html(d.err_luas_ukur)
                     }
                     if (d.err_nomor_pbb == '') {
                         $('#err_nomor_pbb').html('')
                     } else {
                         $('#err_nomor_pbb').html(d.err_nomor_pbb)
                     }
                     if (d.err_nama_pbb == '') {
                         $('#err_nama_pbb').html('')
                     } else {
                         $('#err_nama_pbb').html(d.err_nama_pbb)
                     }
                     if (d.err_bangunan_pbb == '') {
                         $('#err_bangunan_pbb').html('')
                     } else {
                         $('#err_bangunan_pbb').html(d.err_bangunan_pbb)
                     }
                     if (d.err_njop_bangunan == '') {
                         $('#err_njop_bangunan').html('')
                     } else {
                         $('#err_njop_bangunan').html(d.err_njop_bangunan)
                     }
                     if (d.err_bumi_pbb == '') {
                         $('#err_bumi_pbb').html('')
                     } else {
                         $('#err_bumi_pbb').html(d.err_bumi_pbb)
                     }
                     if (d.err_njop_bumi_pbb == '') {
                         $('#err_njop_bumi_pbb').html('')
                     } else {
                         $('#err_njop_bumi_pbb').html(d.err_njop_bumi_pbb)
                     }
                     if (d.err_harga_pengalihan == '') {
                         $('#err_harga_pengalihan').html('')
                     } else {
                         $('#err_harga_pengalihan').html(d.err_harga_pengalihan)
                     }
                     if (d.err_nama_makelar == '') {
                         $('#err_nama_makelar').html('')
                     } else {
                         $('#err_nama_makelar').html(d.err_nama_makelar)
                     }
                     if (d.err_jual_makelar == '') {
                         $('#err_jual_makelar').html('')
                     } else {
                         $('#err_jual_makelar').html(d.err_jual_makelar)
                     }
                     if (d.err_lain_pematangan == '') {
                         $('#err_lain_pematangan').html('')
                     } else {
                         $('#err_lain_pematangan').html(d.err_lain_pematangan)
                     }
                     if (d.err_lain_rugi == '') {
                         $('#err_lain_rugi').html('')
                     } else {
                         $('#err_lain_rugi').html(d.err_lain_rugi)
                     }
                     if (d.err_lain_pbb == '') {
                         $('#err_lain_pbb').html('')
                     } else {
                         $('#err_lain_pbb').html(d.err_lain_pbb)
                     }
                     if (d.err_biaya_lain == '') {
                         $('#err_biaya_lain').html('')
                     } else {
                         $('#err_biaya_lain').html(d.err_biaya_lain)
                     }

                 } else if (d.type == 'result') {
                     $('#err_nama_penjual').html('')
                     $('#err_tgl_pembelian').html('')
                     $('#err_surat_tanah1').html('')
                     $('#err_keterangan1').html('')
                     $('#err_surat_tanah2').html('')
                     $('#err_keterangan2').html('')
                     $('#err_nomor_gambar').html('')
                     $('#err_luas_surat').html('')
                     $('#err_luas_ukur').html('')
                     $('#err_nomor_pbb').html('')
                     $('#err_nama_pbb').html('')
                     $('#err_bangunan_pbb').html('')
                     $('#err_njop_bangunan').html('')
                     $('#err_bumi_pbb').html('')
                     $('#err_njop_bumi_pbb').html('')
                     $('#err_harga_pengalihan').html('')
                     $('#err_nama_makelar').html('')
                     $('#err_jual_makelar').html('')
                     $('#err_lain_pematangan').html('')
                     $('#err_lain_rugi').html('')
                     $('#err_lain_pbb').html('')
                     $('#err_biaya_lain').html('')

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
                 }
             },
             error: function(xhr, status, error) {
                 $('#to_submit').removeAttr('disabled')
                 $('#to_submit').html('Save')
                 error_alert(error)
             }
         })
     })

     function error_alert(msg) {
         Swal.fire({
             title: "Error",
             text: msg,
             icon: "error"
         });
     }

     function delete_tanah(id) {
         Swal.fire({
             title: "Apakah anda yakin?",
             text: "Untuk menghapus Tanah ini?",
             showCancelButton: true,
             confirmButtonText: "Yes",
         }).then((result) => {
             /* Read more about isConfirmed, isDenied below */
             if (result.isConfirmed) {
                 to_delete_tanah(id)
             }
         });
     }

     function to_delete_tanah(id) {
         $.ajax({
             url: '<?= base_url('ajax_tanah/delete_tanah') ?>',
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
             error: function(xrh, status, error) {
                 error_alert(error)
             }
         })
     }
 </script>