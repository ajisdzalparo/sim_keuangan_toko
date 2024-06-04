<section class="container-fluid mt-4">
 <div class="card">
  <div class="p-3">
   <h1>Admin Account</h1>
  </div>
  <div class="card-body" style="height: auto; min-height: 700px;">
   <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalInsertAccount">+ Add Account</button>
   <div class="table-responsive-sm">
    <table class="table" id="revenueTable">
     <thead class="bg-primary text-white fw-bold rounded-top">
      <tr style="font-size: 20px;" class="text-md">
       <th scope="col">#</th>
       <th scope="col">Email</th>
       <th scope="col">Password</th>
       <th scope="col">Action</th>
      </tr>
     </thead>
     <tbody class="bg-white">
      <?php if ($user == null) : ?>
       <tr>
        <td colspan="12" class="text-center h4 text-secondary">No Data Admin</td>
       </tr>
      <?php else : ?>
       <?php $no = 1 ?>
       <?php foreach ($user as $data) : ?>
        <tr style="font-size: 16px;">
         <th scope="row"><?= $no++; ?></th>
         <td><?= $data->email; ?></td>
         <td><?= $data->password; ?></td>
         <td>
          <?php echo anchor('owner/editAccountAdmin/' . $data->id, '<button type="button" class="btn btn-sm btn-warning">Edit</button>') ?>
          <?php echo anchor('owner/deleteAccountAdmin/' . $data->id, '<button type="button" class="btn btn-sm btn-danger text-dark text-white">Delete</button>') ?>
         </td>
        </tr>
       <?php endforeach; ?>
      <?php endif; ?>
     </tbody>
    </table>
   </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalInsertAccount" tabindex="-1" aria-labelledby="modalAdmin" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h1 class="modal-title fs-5" id="modalAdmin">Insert Admin Account</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>
   <div class="modal-body">
    <form action="<?= base_url('owner/insertAdminAccount') ?>" method="post">
     <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Insert email address...">
     </div>
     <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Insert email address...">
     </div>
     <button type="submit" class="btn btn-primary">Submit</button>
    </form>
   </div>
  </div>
 </div>
</div>

<!-- Include SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php if ($this->session->flashdata('update success')) : ?>
 <script>
  Swal.fire({
   title: 'Account Updated!',
   text: "Akun telah berhasil diupdate.",
   icon: 'success',
   confirmButtonColor: '#3085d6',
   confirmButtonText: 'OK'
  });
 </script>
<?php endif; ?>
<?php if ($this->session->flashdata('delete success')) : ?>
 <script>
  Swal.fire({
   title: 'Account Deleted!',
   text: "Akun telah berhasil dihapus.",
   icon: 'success',
   confirmButtonColor: '#3085d6',
   confirmButtonText: 'OK'
  });
 </script>
<?php endif; ?>
<?php if ($this->session->flashdata('insert success')) : ?>
 <script>
  Swal.fire({
   title: 'Account Inserted!',
   text: "Akun telah berhasil disimpan.",
   icon: 'success',
   confirmButtonColor: '#3085d6',
   confirmButtonText: 'OK'
  });
 </script>
<?php endif; ?>