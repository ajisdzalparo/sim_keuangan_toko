<section class="container-fluid mt-4">
 <div class="card">
  <div class="p-3">
   <h1>Profile</h1>
  </div>
  <div class="card-body">
   <?php foreach ($user as $data) : ?>
    <form action="<?= base_url('owner/updateAccount') ?>" method="post">
     <input type="id" class="form-control" id="id" name="id" value="<?= $data->id; ?>" hidden>
     <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="email" name="email" value="<?= $data->email; ?>">
     </div>
     <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="text" class="form-control" id="password" name="password" value="<?= $data->password; ?>">
     </div>
     <button type="submit" class="btn btn-primary">Update Account</button>
    </form>
   <?php endforeach ?>
  </div>
</section>

<!-- Include SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php if ($this->session->flashdata('success')) : ?>
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