 <div class="table-responsive">
     <table class="table table-bordered" id="getProducts" width="100%" cellspacing="0">
         <thead>
             <tr>
                 <th>No</th>
                 <th>Name</th>
                 <th>Description</th>
                 <th>Price</th>
                 <th>Date</th>
                 <th>Option</th>
             </tr>
         </thead>
         <tbody>
             <?php $no = 1;
                foreach ($data_products as $datas) : ?>
                 <tr>
                     <td width="1%"><?= $no++; ?></td>
                     <td><?= esc($datas['name']); ?></td>
                     <td><?= esc($datas['description']); ?></td>
                     <td><?= esc($datas['price']); ?></td>
                     <td><?= esc($datas['date']); ?></td>
                     <td class="text-center" width="20%">
                         <button class="btn btn-success btn-sm mb-1" onclick="edit('<?= $datas['id']; ?>')">
                             Update
                         </button>

                         <button class="btn btn-danger btn-sm mb-1" onclick="deletes('<?= $datas['id']; ?>')">
                             Delete
                         </button>
                     </td>
                 </tr>
             <?php endforeach; ?>
         </tbody>
     </table>
 </div>

 <script>
     $(document).ready(function() {
         $('#getProducts').DataTable();
     });

     function edit(id) {
         $.ajax({
             type: "post",
             url: "<?= base_url('/ajax-jquery/get_modal_edit'); ?>",
             data: {
                 id: id
             },
             dataType: "json",
             success: function(response) {
                 if (response.output) {
                     $('.view-modal').html(response.output).show();
                     $('#editModal').modal('show');
                 }
             },
             error: function(xhr, ajaxOptions, thrownError) {
                 alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
             }
         });
     }

     function deletes(id) {
         Swal.fire({
             title: 'Are you sure?',
             text: `You won't be able to revert this!`,
             icon: 'question',
             showCancelButton: true,
             confirmButtonColor: '#d33',
             cancelButtonColor: '#3085d6',
             confirmButtonText: 'Yes, delete it!',
             cancelButtonText: 'Cancel'
         }).then((result) => {
             if (result.value) {
                 $.ajax({
                     type: "post",
                     url: "<?= base_url('ajax-jquery/delete_data'); ?>",
                     data: {
                         id: id
                     },
                     dataType: "json",
                     success: function(response) {
                         if (response.output) {
                             Swal.fire({
                                 icon: 'success',
                                 title: 'Deleted',
                                 text: response.output,
                             });
                             getProducts();
                         }
                     },
                     error: function(xhr, ajaxOptions, thrownError) {
                         alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                     }
                 });
             }
         });
     }
 </script>