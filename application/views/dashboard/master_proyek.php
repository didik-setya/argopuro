 <section class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-12">
                 <h3>Master Proyek</h3>
                 <div class="card">
                     <div class="card-body">
                         <button class="btn btn-sm btn-success mb-3" onclick="add_proyek()"><i class="fa fa-plus"></i> Tambah</button>

                         <table class="table table-sm table-bordered" id="table_proyek">
                             <thead>
                                 <tr class="bg-secondary text-light">
                                     <th>#</th>
                                     <th>Lokasi</th>
                                     <th>Nama Proyek</th>
                                     <th><i class="fa fa-cogs"></i></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $i = 1;
                                    foreach ($data as $d) { ?>
                                     <tr>
                                         <td><?= $i++ ?></td>
                                         <td><?= $d->nama_kabupaten . ' / ' . $d->nama_kecamatan . ' / ' . $d->nama_desa ?></td>
                                         <td><?= $d->nama_proyek ?></td>
                                         <td>
                                             <div class="dropdown dropleft">
                                                 <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                 </button>
                                                 <div class="dropdown-menu">
                                                     <a class="dropdown-item" href="#" onclick="edit_proyek('<?= $d->id ?>')">Edit</a>
                                                     <a class="dropdown-item" href="<?= base_url('dashboard/target_proyek/' . $d->id) ?>">Target</a>
                                                 </div>
                                             </div>
                                         </td>
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

 <!-- Modal -->
 <div class="modal" id="modalProyek" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="<?= base_url('ajax_proyek/action_proyek') ?>" id="form_proyek" method="post">
                 <input type="hidden" name="act" id="act">
                 <input type="hidden" name="id" id="id_proyek">
                 <div class="modal-body">
                     <div class="form-group mb-3">
                         <label>Nama Proyek</label>
                         <input type="text" name="proyek" id="proyek" class="form-control" required>
                     </div>

                     <div class="form-group mb-3">
                         <label>Kecamatan</label>
                         <select name="kab" id="kab" class="form-control select2" style="width: 100%;" required>
                             <option value="">--pilih--</option>
                             <?php foreach ($kab as $k) {
                                    $kec = $this->db->where('id_kabupaten', $k->id_kabupaten)->get('kecamatan')->result();
                                ?>
                                 <optgroup label="<?= $k->nama_kabupaten ?>">
                                     <?php foreach ($kec as $kc) { ?>
                                         <option value="<?= $kc->id_kecamatan ?>"><?= $kc->nama_kecamatan ?></option>
                                     <?php } ?>
                                 </optgroup>
                             <?php } ?>
                         </select>
                     </div>

                     <div class="form-group mb-3">
                         <label>Desa</label>
                         <select name="desa" id="desa" required class="from-control select2" style="width: 100%;">
                             <option value="">--pilih--</option>
                         </select>
                     </div>


                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary" id="to_submit">Save</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <script>
     let modal = $('#modalProyek');
     const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';


     $(document).ready(function() {
         modal.find('.select2').select2({
             theme: 'bootstrap4',
             dropdownParent: modal
         })
         $('#table_proyek').dataTable()
     });

     $('#kab').change(function() {
         let v = $(this).val()
         get_desa(v)
     })

     function get_desa(v, match = null) {
         $.ajax({
             url: '<?= base_url('ajax_proyek/get_desa') ?>',
             data: {
                 id: v
             },
             type: 'POST',
             dataType: 'JSON',
             success: function(d) {
                 show_desa(d, match)
             },
             error: function(xhr, status, error) {
                 error_alert(error);
             }
         })
     }

     function show_desa(d, match = null) {
         let html = '<option value="">--pilih--</option>';
         if (match) {
             for (let i = 0; i < d.length; i++) {
                 if (d[i].id_desa == match) {
                     html += '<option selected value="' + d[i].id_desa + '">' + d[i].nama_desa + '</option>';
                 } else {
                     html += '<option value="' + d[i].id_desa + '">' + d[i].nama_desa + '</option>';
                 }
             }
         } else {
             for (let i = 0; i < d.length; i++) {
                 html += '<option value="' + d[i].id_desa + '">' + d[i].nama_desa + '</option>';
             }
         }
         $('#desa').html(html);
     }

     function add_proyek() {
         modal.modal('show')
         modal.find('.modal-title').html('Tambah Proyek')
         modal.find('#act').val('add');
         modal.find('#proyek').val('')
         modal.find('#kab').val('')
         modal.find('#desa').val('')
     }

     function error_alert(msg) {
         Swal.fire({
             title: "Error",
             text: msg,
             icon: "error"
         });
     }

     function edit_proyek(id) {
         modal.modal('show')
         modal.find('.modal-title').html('Edit Proyek')
         modal.find('#act').val('edit');
         modal.find('#proyek').val('')
         modal.find('#kab').val('')
         modal.find('#desa').val('')
         modal.find('#id_proyek').val(id)
         get_data_proyek(id)
     }

     function get_data_proyek(id) {
         $.ajax({
             url: '<?= base_url('ajax_proyek/get_proyek_row') ?>',
             data: {
                 id: id
             },
             type: 'POST',
             dataType: 'JSON',
             success: function(d) {
                 get_desa(d.id_kecamatan, d.kelurahan_id)
                 modal.find('#proyek').val(d.nama_proyek)
                 modal.find('#kab').val(d.id_kecamatan)
             },
             error: function(xhr, status, error) {
                 error_alert(error)
             }
         })
     }



     $('#form_proyek').submit(function(e) {
         e.preventDefault();
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
                 if (d.status == false) {
                     Swal.fire({
                         title: "Error",
                         text: d.msg,
                         icon: "error"
                     }).then((res) => {
                         window.location.reload();
                         modal.modal('hide')
                     });
                 } else {
                     Swal.fire({
                         title: "Success",
                         text: d.msg,
                         icon: "success"
                     }).then((res) => {
                         window.location.reload();
                         modal.modal('hide')
                     });
                 }
             },
             error: function(xhr, status, error) {
                 $('#to_submit').removeAttr('disabled')
                 $('#to_submit').html('Save')
                 error_alert(error)
             }
         })

     })
 </script>