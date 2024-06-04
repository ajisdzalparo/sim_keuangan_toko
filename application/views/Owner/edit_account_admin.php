<section class="container-fluid mt-4">
 <div class="card">
  <div class="p-3">
   <h1>Edit Account Admin</h1>
  </div>
  <div class="card-body">
   <?php foreach ($user as $data) : ?>
    <form action="<?= base_url('owner/updateAccountAdmin') ?>" method="post">
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