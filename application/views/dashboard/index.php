 <section class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-12">
                 <h3>Dashboard</h3>
             </div>

             <div class="col-sm-12 col-lg-7">
                 <div class="card">
                     <div class="card-header bg-danger text-light">
                         <strong>Pembayaran Akan Datang</strong>
                     </div>
                     <div class="p-1">
                         <table class="table table-sm table-bordered" id="table-pembayaran">
                             <thead>
                                 <tr class="bg-dark text-light text-center">
                                     <th>Nama Proyek</th>
                                     <th>Nama Penjual</th>
                                     <th>Total Bayar</th>
                                     <th>Tgl Pembayaran</th>
                                     <th>Status Proyek</th>
                                 </tr>
                             </thead>
                             <tbody></tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div><!-- /.container-fluid -->
 </section>

 <script>
     const spinner = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>'

     $(document).ready(function() {
         load_pembayaran()
     })

     function load_pembayaran() {
         $('#table-pembayaran').find('tbody').html('<tr><td colspan="5">' + spinner + '</td></tr>');
         $.ajax({
             url: '<?= base_url('ajax/notif_pembayaran') ?>',
             type: 'POST',
             success: function(d) {
                 $('#table-pembayaran').find('tbody').html(d);
             },
             error: function(xhr, status, error) {
                 alert(error);
             }
         })
     }
 </script>