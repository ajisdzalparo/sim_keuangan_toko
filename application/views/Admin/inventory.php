<style>
  .pagination-container nav,
  .pagination-container ul,
  .pagination-container li {
    border: none !important;
    /* Menghilangkan border */
    text-decoration: none !important;
    /* Menghilangkan underline */
  }
</style>

<div class="container-fluid p-5">
  <div class="row">
    <div class="col-md-6">
      <div class="card p-4">
        <h1>IN-BOUND</h1>
        <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
        <?= form_open('admin/addInboundData', 'method="post"') ?>
        <div class="form-group mb-2">
          <label for="product_name">Product</label>
          <input type="text" name="product_name" id="product_name" class="form-control">
        </div>
        <div class="form-group mb-2">
          <label for="color">Color</label>
          <select name="color" id="color" class="form-control">
            <option value="">-- Pilih Warna --</option>
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
          <input type="number" name="price" id="price" class="form-control">
        </div>
        <div class="form-group mb-2">
          <label for="stock">Stok</label>
          <input type="number" name="stock" id="stock" class="form-control">
        </div>
        <button type="submit" class="btn btn-success mt-5 px-5">Submit</button>
        </form>
        <?php if ($this->session->flashdata('inbound_message')) : ?>
          <div class="alert alert-info"><?= $this->session->flashdata('inbound_message'); ?></div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-4">
        <h1>OUT-BOUND</h1>
        <?= form_open('admin/Outbound', 'method="post"') ?>
        <div class="form-group mb-2">
          <label for="product_name">Product</label>
          <select name="product_name_out" id="product_name_out" class="form-control">
            <option value="">-- Select Product --</option>
            <?php foreach ($all_products as $product) : ?>
              <option value="<?= $product->product_name ?>">
                <?= $product->product_name ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group mb-2">
          <label for="color">Color</label>
          <select name="color_out" id="color_out" class="form-control" onchange="fetchDataOutbound()">
            <option value="">-- Pilih Warna --</option>
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
          <label for="price_out">Price</label>
          <input type="number" name="price_out" id="price_out" class="form-control" readonly>
        </div>
        <div class="form-group mb-2">
          <label for="stock_out">Value</label>
          <input type="number" name="stock_out" id="stock_out" class="form-control">
        </div>
        <button type="submit" class="btn btn-success mt-5 px-5">Submit</button>
        </form>
        <?php if ($this->session->flashdata('outbound_message')) : ?>
          <div class="alert alert-info"><?= $this->session->flashdata('outbound_message'); ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="container mt-5">
    <!-- Filter Form -->
    <div class="mb-3">
      <form action="" method="get">
        <div class="form-group">
          <label for="filter_product_name">Filter by Product:</label>
          <select name="filter_product_name" id="filter_product_name" class="form-control" onchange="this.form.submit()">
            <option value="">All Products</option>
            <?php foreach ($all_products as $product) : ?>
              <option value="<?= $product->product_name ?>" <?= isset($_GET['filter_product_name']) && $_GET['filter_product_name'] == $product->product_name ? 'selected' : '' ?>>
                <?= $product->product_name ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </form>
    </div>

    <!-- Table Product -->
    <div class="table-responsive">
      <table class="table">
        <thead class="bg-primary text-white fw-bold rounded-top">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Product</th>
            <th scope="col">Color</th>
            <th scope="col">Price</th>
            <th scope="col">Stok</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody class="bg-white">
          <?php if ($inventory_data == null) : ?>
            <tr>
              <td colspan="12" class="text-center h4 text-secondary">No Data</td>
            </tr>
          <?php else : ?>
            <?php $no = 1; ?>
            <?php foreach ($inventory_data as $row) : ?>
              <tr>
                <th scope="row"><?= $no; ?></th>
                <td><?= $row->product_name; ?></td>
                <td><?= $row->color ?></td>
                <td><?= $row->price ?></td>
                <td><?= $row->stock ?></td>
                <td>
                  <?php echo anchor('admin/editDataInventory/' . $row->id, '<button type="button" class="btn btn-sm btn-warning">Edit</button>') ?>
                  <?php echo anchor('admin/deleteDataInventory/' . $row->id, '<button type="button" class="btn btn-sm btn-danger text-dark text-white">Delete</button>') ?>
                </td>
              </tr>
              <?php $no++; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
      <div class="text-center pagination-container">
        <?php
        // style untuk pagination
        $this->pagination->initialize(array(
          'full_tag_open' => '<nav><ul class="pagination justify-content-center">',
          'full_tag_close' => '</ul></nav>',
          'num_tag_open' => '<li class="page-item">',
          'num_tag_close' => '</li>',
          'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
          'cur_tag_close' => '</a></li>',
          'next_tag_open' => '<li class="page-item">',
          'next_tag_close' => '</li>',
          'prev_tag_open' => '<li class="page-item">',
          'prev_tag_close' => '</li>',
          'first_tag_open' => '<li class="page-item">',
          'first_tag_close' => '</li>',
          'last_tag_open' => '<li class="page-item">',
          'last_tag_close' => '</li>',
          'attributes' => array('class' => 'page-link')
        ));
        echo $this->pagination->create_links();
        ?>
      </div>
    </div>
  </div>
</div>
<script>
  function fetchDataOutbound() {
    var productName = document.getElementById('product_name_out').value;
    var color = document.getElementById('color_out').value;

    fetch(`<?= base_url('admin/fetchDataOutbound') ?>/${productName}/${color}`)
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        var priceInput = document.getElementById('price_out');
        var stockInput = document.getElementById('stock_out');

        if (data && data.price && data.stock) {
          priceInput.value = data.price;
          stockInput.value = data.stock;
        } else {
          priceInput.value = '';
          stockInput.value = '';
        }
      })
      .catch(error => {
        console.error('Error fetching data:', error);
        var priceInput = document.getElementById('price_out');
        var stockInput = document.getElementById('stock_out');
        priceInput.value = '';
        stockInput.value = '';
      });
  }
</script>