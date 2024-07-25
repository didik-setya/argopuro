 <section class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-12">
                 <h3>Master Menu</h3>

                 <div class="card">
                     <div class="card-body">


                         <table class="table table-bordered table-sm" id="table_menu">
                             <thead>
                                 <tr class="bg-secondary">
                                     <th colspan="2">Menu</th>
                                     <th>URL</th>
                                     <th><i class="fa fa-cogs"></i></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php foreach ($data as $d) { ?>
                                     <tr>
                                         <td colspan="2"><?= $d->icon . ' ' . $d->label  ?></td>
                                         <td><?= $d->url ?></td>
                                         <td>
                                             <button class="btn btn-sm btn-primary" onclick="edit_menu('<?= $d->id ?>')"><i class="fas fa-edit"></i></button>
                                             <button class="btn btn-sm btn-danger" onclick="delete_menu('<?= $d->id ?>')"><i class="fas fa-trash"></i></button>
                                         </td>
                                     </tr>
                                     <?php
                                        if ($d->type == 2) {
                                            $sub_menu = $this->db->get_where('menu', ['type' => 3, 'status' => 1, 'parent' => $d->id])->result();
                                            foreach ($sub_menu as $sm) {
                                        ?>

                                             <tr>
                                                 <td></td>
                                                 <td><?= $sm->icon . ' ' . $sm->label ?></td>
                                                 <td><?= $sm->url ?></td>
                                                 <td>
                                                     <button class="btn btn-sm btn-primary" onclick="edit_menu('<?= $sm->id ?>')"><i class="fas fa-edit"></i></button>
                                                     <button class="btn btn-sm btn-danger" onclick="delete_menu('<?= $sm->id ?>')"><i class="fas fa-trash"></i></button>
                                                 </td>
                                             </tr>

                                     <?php }
                                        } ?>
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
             <form action="<?= base_url('ajax/validation_menu') ?>" id="form_menu" method="post">
                 <input type="hidden" name="id" id="id">
                 <input type="hidden" name="act" id="act">
                 <div class="modal-body">
                     <div class="form-group mb-3">
                         <label>Type</label>
                         <select name="type" id="type" required class="form-control">
                             <option value="">--pilih--</option>
                             <option value="1">Menu Regular</option>
                             <option value="2">Menu Dropdown</option>
                             <option value="3">Submenu in dropdown</option>
                         </select>
                     </div>

                     <div id="show_parent"></div>

                     <div class="form-group mb-3">
                         <label>Label</label>
                         <input type="text" name="label" id="label" class="form-control" required>
                         <small class="text-danger" id="err_label"></small>
                     </div>

                     <div class="form-group mb-3">
                         <label>URL</label>
                         <div class="input-group">
                             <div class="input-group-prepend">
                                 <span class="input-group-text" id="basic-addon1"><?= base_url() ?></span>
                             </div>
                             <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="url" id="url">
                         </div>
                         <small class="text-danger" id="err_url"></small>
                     </div>

                     <div class="form-group mb-3">
                         <label>Icon</label>
                         <input type="text" name="icon" id="icon" class="form-control" required>
                         <small class="text-danger" id="err_icon"></small>
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

 <div id="hidden_parent" class="d-none">
     <div class="form-group mb-3">
         <label>Parent</label>
         <select name="parent" id="parent" class="form-control" required>
             <option value="">--pilih--</option>
             <?php foreach ($menu_dropdown as $dd) { ?>
                 <option value="<?= $dd->id ?>"><?= $dd->label ?></option>
             <?php } ?>
         </select>
     </div>
 </div>


 <script>
     const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

     function add_menu() {
         $('#staticBackdrop').modal('show')
         $('.modal-title').html('Tambah Menu Baru')

         $('#err_label').html('')
         $('#err_url').html('')
         $('#err_icon').html('')

         $('#act').val('add');
         $('#id').val('');
         $('#type').val('')
         $('#show_parent').html('')
         $('#label').val('')
         $('#url').val('')
         $('#icon').val('')
     }

     function edit_menu(id) {
         $('#staticBackdrop').modal('show')
         $('.modal-title').html('Edit Menu')

         $('#err_label').html('')
         $('#err_url').html('')
         $('#err_icon').html('')

         $('#act').val('edit');
         $('#id').val(id);
         $('#type').val('')
         $('#show_parent').html('')
         $('#label').val('')
         $('#url').val('')
         $('#icon').val('')
         get_detail_menu(id)
     }

     function get_detail_menu(id) {
         $.ajax({
             url: '<?= base_url('ajax/detail_menu') ?>',
             data: {
                 id: id
             },
             type: 'POST',
             dataType: 'JSON',
             success: function(d) {
                 $('#type').val(d.type)
                 $('#label').val(d.label)
                 $('#icon').val(d.icon)
                 $('#url').val(d.url)

                 if (d.type == 3) {
                     let html = $('#hidden_parent').html()
                     $('#show_parent').html(html)
                     $('#staticBackdrop').find('#parent').val(d.parent)
                 }
             },
             error: function(xhr, status, error) {
                 error_alert(error)
             }
         })
     }

     $('#type').change(function() {
         let v = $(this).val()
         if (v == 3) {
             let html = $('#hidden_parent').html()
             $('#show_parent').html(html)
         } else {
             $('#show_parent').html('')
         }
     })

     $('#form_menu').submit(function(e) {
         e.preventDefault()
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
                     if (d.err_label == '') {
                         $('#err_label').html('')
                     } else {
                         $('#err_label').html(d.err_label)
                     }

                     if (d.err_url == '') {
                         $('#err_url').html('')
                     } else {
                         $('#err_url').html(d.err_url)
                     }

                     if (d.err_icon == '') {
                         $('#err_icon').html('')
                     } else {
                         $('#err_icon').html(d.err_icon)
                     }
                 } else if (d.type == 'result') {
                     $('#err_label').html('')
                     $('#err_url').html('')
                     $('#err_icon').html('')

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

     function delete_menu(id) {
         Swal.fire({
             title: "Apakah anda yakin?",
             text: "Untuk menghapus menu ini?",
             showCancelButton: true,
             confirmButtonText: "Yes",
         }).then((result) => {
             /* Read more about isConfirmed, isDenied below */
             if (result.isConfirmed) {
                 to_delete_menu(id)
             }
         });
     }

     function to_delete_menu(id) {
         $.ajax({
             url: '<?= base_url('ajax/delete_menu') ?>',
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