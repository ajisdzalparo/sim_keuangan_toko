<section class="container-fluid mt-4">
 <div class="card">
  <div class="p-3">
   <h1>Edit Product</h1>
  </div>
  <div class="card-body">
   <!-- Tempat untuk menampilkan flashdata error -->
   <?php if ($this->session->flashdata('error_message')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
     <?= $this->session->flashdata('error_message'); ?>
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
   <?php endif; ?>

   <?php foreach ($revenue_data as $data) : ?>
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= form_open('admin/updateRevenueInDashboard', 'method="post"') ?>

    <!-- Tempat untuk menampilkan flashdata -->
    <?php if ($this->session->flashdata('message')) : ?>
     <div class="alert alert-<?= $this->session->flashdata('message_type'); ?> alert-dismissible fade show" role="alert">
      <?= $this->session->flashdata('message'); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
    <?php endif; ?>

    <div class="mb-3">
     <input type="hidden" name="id" value="<?= $data->id; ?>" hidden>
    </div>

    <div class="mb-3">
     <label for="Client" class="form-label">Client</label>
     <input type="text" class="form-control" name="client" value="<?= $data->client; ?>">
    </div>

    <div class="mb-3">
     <label for="Product" class="form-label">Product</label>
     <input type="text" class="form-control" name="product_name" value="<?= $data->product_name; ?>">
    </div>

    <div class="mb-3">
     <label for="Price" class="form-label">Price</label>
     <input type="number" class="form-control" name="price" value="<?= $data->price; ?>">
    </div>

    <div class="mb-3">
     <label for="Value" class="form-label">Value</label>
     <input type="number" class="form-control" name="value" value="<?= $data->value; ?>">
    </div>

    <div class="mb-3">
     <label for="Date" class="form-label">Date</label>
     <input type="date" class="form-control" name="date" value="<?= $data->date; ?>">
    </div>

    <div class="d-flex justify-content-center">
     <button class="btn btn-success text-uppercase px-5 mt-4">Submit</button>
    </div>

    <?= form_close() ?>
   <?php endforeach ?>
  </div>
 </div>
</section>
</section>