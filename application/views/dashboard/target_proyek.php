 <section class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-12">
                 <h3>Data Target Proyek</h3>
                 <div class="card ">
                     <div class="card-body">
                         <a href="<?= base_url('dashboard/master_proyek') ?>" class="btn btn-sm btn-danger mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>

                         <button class="btn btn-sm btn-success mb-3" onclick="add_target()"><i class="fas fa-plus"></i> Tambah</button>

                         <table class="table table-bordered table-sm w-100" id="table_target">
                             <thead>
                                 <tr class="bg-dark text-light">
                                     <th class="text-center" rowspan="2"><i class="fa fa-cogs"></i></th>
                                     <th class="text-center" rowspan="2">Proyek</th>
                                     <th class="text-center" rowspan="2">Tahun</th>
                                     <?php foreach ($bulan as $m) { ?>
                                         <th class="text-center" colspan="2"><?= $m['short'] ?></th>
                                     <?php } ?>
                                 </tr>

                                 <tr class="bg-dark text-light">
                                     <?php foreach ($bulan as $m) { ?>
                                         <th class="text-center">BID</th>
                                         <th class="text-center">LUAS</th>
                                     <?php } ?>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php foreach ($data as $d) {
                                        $data_target = $this->db->get_where('master_proyek_target', ['proyek_id' => $d->id, 'group_id' => $d->group_id])->result();
                                        $year = date_create($d->tahun);
                                    ?>
                                     <tr>
                                         <td>
                                             <div class="dropdown">
                                                 <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                 </button>
                                                 <div class="dropdown-menu">
                                                     <a class="dropdown-item" href="#" onclick="edit_target('<?= $d->group_id ?>', '<?= date_format($year, 'Y') ?>')">Edit</a>
                                                     <a class="dropdown-item" href="#" onclick="delete_target('<?= $d->group_id ?>')">Hapus</a>
                                                 </div>
                                             </div>
                                         </td>
                                         <td><?= $d->nama_proyek ?></td>
                                         <td><?= date_format($year, 'Y') ?></td>
                                         <?php foreach ($data_target as $tr) { ?>
                                             <td><?= $tr->target_bidang ?></td>
                                             <td><?= $tr->target_luas ?></td>
                                         <?php } ?>
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
 <div class="modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header bg-dark">
                 <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="<?= base_url('ajax_proyek/action_target_proyek') ?>" id="form_proyek" method="post">
                 <input type="hidden" name="act" id="act">
                 <input type="hidden" name="group_id" id="group_id">
                 <div class="modal-body">
                     <div class="form-group mb-3">
                         <label>Proyek</label>
                         <input type="hidden" name="id_proyek" id="id_proyek" value="<?= $proyek->id ?>">
                         <input type="text" name="proyek" id="proyek" disabled class="form-control" value="<?= $proyek->nama_proyek ?>">
                     </div>


                     <div class="form-group mb-3">
                         <label>Tahun</label>
                         <input autocomplete="off" type="text" required name="year" class="form-control yearpicker" id="year" value="">
                     </div>

                     <label>Data Target</label>
                     <div id="show_form_target"></div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary" id="to_submit">Save</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <div class="d-none" id="form_target_new">
     <table class="table table-sm">
         <thead>
             <tr>
                 <th>Bulan</th>
                 <th>BID</th>
                 <th>Luas</th>
             </tr>
         </thead>
         <tbody>
             <?php foreach ($bulan as $mt) { ?>
                 <tr>
                     <td>
                         <?= $mt['bulan'] ?>
                         <input type="hidden" name="month[]" value="<?= $mt['val'] ?>">
                     </td>
                     <td>
                         <input type="number" name="bid[]" class="form-control bid">
                     </td>
                     <td>
                         <input type="number" name="luas[]" class="form-control luas">
                     </td>
                 </tr>
             <?php } ?>
         </tbody>
     </table>
 </div>

 <script>
     const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

     $(document).ready(function() {
         $('.yearpicker').yearpicker();
         $('#table_target').dataTable({
             searching: false,
             ordering: false,
             scrollX: true
         })
     })

     function add_target() {
         let form = $('#form_target_new').html()
         $('#staticBackdrop').modal('show');
         $('#staticBackdropLabel').html('Tambah Target')
         $('#act').val('add');
         $('#group_id').val('')
         $('#status_proyek').val('')
         $('#year').val('')
         $('#staticBackdrop').find('#show_form_target').html(form)
     }

     function edit_target(group, year) {
         $('#staticBackdrop').modal('show');
         $('#staticBackdropLabel').html('Edit Target')
         $('#act').val('edit');
         $('#group_id').val(group)
         $('#year').val(year)
         $('#staticBackdrop').find('#show_form_target').html(spinner)

         $.ajax({
             url: '<?= base_url('ajax_proyek/get_form_edit_target') ?>',
             data: {
                 id: group
             },
             type: 'POST',
             success: function(d) {
                 $('#staticBackdrop').find('#show_form_target').html(d)
             },
             error: function(xhr, status, error) {
                 error_alert(error)
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

     function delete_target(target) {
         Swal.fire({
             title: "Apakah anda yakin?",
             text: 'Untuk menghapus data ini?',
             showCancelButton: true,
             confirmButtonText: "Yes",
         }).then((result) => {
             /* Read more about isConfirmed, isDenied below */
             if (result.isConfirmed) {
                 $.ajax({
                     url: '<?= base_url('ajax_proyek/to_delete_target') ?>',
                     data: {
                         group: target
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
                             }).then((res) => {
                                 window.location.reload()
                             });
                         }
                     },
                     error: function(xhr, status, error) {
                         error_alert(error)
                     }
                 })
             }
         });
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
                     error_alert(d.msg)
                     $('#staticBackdrop').modal('hide')
                 } else {
                     Swal.fire({
                         title: "Success",
                         text: d.msg,
                         icon: "success"
                     }).then((res) => {
                         $('#staticBackdrop').modal('hide')
                         window.location.reload()
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