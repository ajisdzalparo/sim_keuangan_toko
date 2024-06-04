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

   <?php foreach ($inventory_data as $data) : ?>
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= form_open('admin/updateDataInventory', ['method' => 'post']) ?>
    <div class="form-group mb-2">
     <input type="hidden" name="id" id="id" class="form-control" value="<?= $data->id ?>">
    </div>
    <div class="form-group mb-2">
     <label for="product_name">Product</label>
     <input type="text" name="product_name" id="product_name" class="form-control" value="<?= $data->product_name ?>">
    </div>
    <div class="form-group mb-2">
     <label for="color">Color</label>
     <select name="color" id="color" class="form-control">
      <option value="<?= $data->color ?? '' ?>"><?= $data->color ?? 'Select Color' ?></option>
      <option value="Merah">Merah</option>
      <option value="Kuning">Kuning</option>
      <option value="Hijau">Hijau</option>
      <option value="Biru">Biru</option>
      <option value="Hitam">Hitam</option>
      <option value="Putih">Putih</option>
      <option value="Orange">Orange</option>
     </select>
    </div>
    <div class="form-group mb-2">
     <label for="price">Price</label>
     <input type="number" name="price" id="price" class="form-control" value="<?= $data->price ?>">
    </div>
    <div class="form-group mb-2">
     <label for="stock">Stock</label>
     <input type="number" name="stock" id="stock" class="form-control" value="<?= $data->stock ?>">
    </div>
    <button type="submit" class="btn btn-success mt-5 px-5">Submit</button>
    </form>
   <?php endforeach ?>
  </div>
 </div>
</section>
</section>