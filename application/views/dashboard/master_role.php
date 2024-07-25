 <section class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-12">
                 <h3>Master Role User</h3>

                 <div class="card">
                     <div class="card-body">
                         <button class="btn btn-sm btn-success mb-3" onclick="add_role()"><i class="fa fa-plus"></i> Tambah</button>

                         <table class="table table-bordered table-sm w-100" id="table_role">
                             <thead>
                                 <tr class="bg-secondary">
                                     <th width="5%">#</th>
                                     <th>Nama Role</th>
                                     <th width="20%"><i class="fa fa-cogs"></i></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php $i = 1;
                                    foreach ($data as $d) { ?>
                                     <tr>
                                         <td><?= $i++ ?></td>
                                         <td><?= $d->nama ?></td>
                                         <td>
                                             <button class="btn btn-sm btn-danger" onclick="delete_role('<?= $d->id ?>')"><i class="fa fa-trash"></i></button>
                                             <button class="btn btn-sm btn-primary" onclick="edit_role('<?= $d->id ?>', '<?= $d->nama ?>')"><i class="fa fa-edit"></i></button>
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
 <div class="modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="<?= base_url('ajax/validation_role') ?>" id="form" method="post">
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Nama Role</label>
                         <input type="text" name="role" id="role" class="form-control" required>
                         <input type="hidden" name="id" id="id">
                         <input type="hidden" name="act" id="act">
                     </div>
                     <small class="text-danger" id="err_role"></small>
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
     const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

     $(document).ready(function() {
         new DataTable('#table_role');
     })

     $('#form').submit(function(e) {
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

                 if (d.type == 'validation') {
                     if (d.err_role == '') {
                         $('#err_role').html('')
                     } else {
                         $('#err_role').html(d.err_role)

                     }
                 } else if (d.type == 'result') {
                     $('#err_role').html('')
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
                 }

             },
             error: function(xhr, status, error) {
                 $('#to_submit').removeAttr('disabled')
                 $('#to_submit').html('Save')
                 error_alert(error)
             }
         })
     })

     function add_role() {
         $('#staticBackdrop').modal('show');
         $('#staticBackdropLabel').html('Tambah Role Baru')
         $('#role').val('')
         $('#id').val('')
         $('#act').val('add')
         $('#err_role').html('')
     }

     function edit_role(id, name) {
         $('#staticBackdrop').modal('show');
         $('#staticBackdropLabel').html('Edit Role')
         $('#role').val(name)
         $('#id').val(id)
         $('#act').val('edit')
         $('#err_role').html('')
     }

     function delete_role(id) {
         Swal.fire({
             title: "Apakah anda yakin?",
             text: 'Untuk menghapus role ini?',
             showCancelButton: true,
             confirmButtonText: "Yes",
         }).then((result) => {
             /* Read more about isConfirmed, isDenied below */
             if (result.isConfirmed) {
                 to_delete_role(id)
             }
         });
     }

     function to_delete_role(id) {
         $.ajax({
             url: '<?= base_url('ajax/delete_role') ?>',
             data: {
                 id: id
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

     function error_alert(msg) {
         Swal.fire({
             title: "Error",
             text: msg,
             icon: "error"
         });
     }
 </script>