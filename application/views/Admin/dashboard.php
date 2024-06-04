<div class="container-fluid mt-4 p-4">
  <section>
    <h4><b>Add</b> Daily Revenue</h4>
    <div class="row">
      <div class="col-sm-8">
        <div class="card p-3">
          <?= form_open('admin/insertRevenue', 'method="post"') ?>

          <!-- Tempat untuk menampilkan flashdata -->
          <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-<?= $this->session->flashdata('message_type'); ?> alert-dismissible fade show" role="alert">
              <?= $this->session->flashdata('message'); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <div class="mb-3">
            <label for="Client" class="form-label">Client</label>
            <input type="text" class="form-control" name="client">
          </div>

          <div class="mb-3">
            <label for="Product" class="form-label">Product</label>
            <input type="text" class="form-control" name="product_name">
          </div>

          <div class="mb-3">
            <label for="Price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price">
          </div>

          <div class="mb-3">
            <label for="Value" class="form-label">Value</label>
            <input type="number" class="form-control" name="value">
          </div>

          <div class="mb-3">
            <label for="Date" class="form-label">Date</label>
            <input type="date" class="form-control" name="date">
          </div>

          <div class="d-flex justify-content-center">
            <button class="btn btn-success text-uppercase px-5 mt-4">Submit</button>
          </div>

          <?= form_close() ?>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="row mb-4">
          <div class="col-12 col-lg-6">
            <div class="card side-card bg-primary p-2">
              <div class="d-flex flex-column justify-content-center">
                <h3 class="text-white fw-bold" style="font-size: 16px;">Sales</h3>
                <span style="font-size: 12px;">Daily</span>
                <p class="text-white fw-bold mt-2" style="font-size: 14px;"><?= $total_value_today ?> pcs</p>
              </div>
              <img class="position-absolute top-0 end-0 z-0 img-fluid" src="<?= base_url("assets/images/illustration/trade1.png") ?>">
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <div class="card side-card bg-success p-2">
              <div class="d-flex flex-column justify-content-center">
                <h3 class="text-white fw-bold" style="font-size: 16px;">Revenue</h3>
                <span style="font-size: 12px;">Daily</span>
                <p class="text-white fw-bold mt-2" style="font-size: 14px;">Rp. <?= number_format($total_revenue_today ?? 0, 0, ',', '.') ?></p>
              </div>
              <img class="position-absolute top-0 end-0 img-fluid me-2 mt-1" src="<?= base_url("assets/images/illustration/money-bag.png") ?>" max-width="90px">
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12 col-lg-6">
            <?= anchor('admin/inventory', '<div class="card side-card bg-warning p-2 inventory-card" style="text-decoration: none;">
              <div class="d-flex flex-column justify-content-center">
                <p class="text-white fw-bold mt-4 text-wrap" style="font-size: 15px; text-decoration: none;">VIEW <br> INVENTORY</p>
              </div>
              <img class="position-absolute top-0 end-0 img-fluid me-1 mt-1" src="' . base_url("assets/images/illustration/inventory.png") . '" style="max-width:90px;">
            </div>', ['style' => 'text-decoration: none;']) ?>
          </div>

          <div class="col-12 col-lg-6">
            <?php
            echo anchor('admin/daily', '<div class="card side-card bg-info p-2">
              <div class="d-flex flex-column justify-content-center">
                <p class="text-white fw-bold mt-4" style="font-size: 15px;">VIEW <br> DAILY REVENUE</p>
              </div>
              <img class="position-absolute top-0 end-0 img-fluid me-1 mt-1" src="' . base_url("assets/images/illustration/income-chart.png") . '" max-width="90px">
            </div>', ['style' => 'text-decoration: none;']);
            ?>
          </div>
        </div>
        <div class="row">
          <img src="<?= base_url("assets/images/illustration/Group13.png") ?>">
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="table-responsive">
        <table class="table">
          <thead class="bg-primary text-white fw-bold rounded-top">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Client</th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Value</th>
              <th scope="col">Total Price</th>
              <th scope="col">Date</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <?php if ($revenue_data == null) : ?>
              <tr>
                <td colspan="12" class="text-center h4 text-secondary">No Data</td>
              </tr>
            <?php else : ?>
              <?php $no = 1; ?>
              <?php foreach ($revenue_data as $row) : ?>
                <tr>
                  <th scope="row"><?= $no ?></th>
                  <td><?= $row->client ?></td>
                  <td><?= $row->product_name ?></td>
                  <td>Rp <?= number_format($row->price, 0, ',', '.') ?></td>
                  <td><?= $row->value ?></td>
                  <td>Rp <?= number_format($row->total_price, 0, ',', '.') ?></td>
                  <td><?= date('d-m-Y', strtotime($row->date)) ?></td>
                  <td>
                    <?= anchor('admin/editDataRevenueInDashboard/' . $row->id, '<button type="button" class="btn btn-warning">Edit</button>') ?>
                    <?php echo anchor('admin/deleteDataRevenueInDashboard/' . $row->id, '<button type="button" class="btn btn-sm btn-danger text-dark text-white">Delete</button>') ?>
                  </td>
                </tr>
                <?php $no++; ?>
              <?php endforeach ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<style>
  .inventory-card:hover {
    transform: scale(1.05);
    /* Membuat elemen bergerak naik 5% ketika dihover */
  }

  .side-card:hover {
    transform: scale(1.05);
    /* Membesar 5% ketika di-hover */
    transition: transform 0.3s ease-in-out;
    /* Animasi berlangsung selama 0.3 detik */
  }
</style>