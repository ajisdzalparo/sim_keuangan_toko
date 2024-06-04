<section>
  <div class="container-fluid mt-4">
    <div class="row">
      <div class=col-sm-6>
        <h4 style="font-size: 16px;" class="mb-3"><b>Overview</b> Revenue</h4>
      </div>
      <div class=col-2>
        <select class="form-select form-select-sm" id="timeFrameSelect">
          <option value="daily">Daily</option>
          <option value="monthly">Monthly</option>
          <option value="yearly">Yearly</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-8">
      <div class="card p-4">
        <canvas id="myChart" width="auto" height="auto"></canvas>
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
          <?= anchor('owner/inventory', '<div class="card side-card bg-warning p-2 inventory-card" style="text-decoration: none;">
              <div class="d-flex flex-column justify-content-center">
                <p class="text-white fw-bold mt-4 text-wrap" style="font-size: 16px; text-decoration: none;">VIEW <br> INVENTORY</p>
              </div>
              <img class="position-absolute top-0 end-0 img-fluid me-2 mt-1" src="' . base_url("assets/images/illustration/inventory.png") . '" style="max-width:90px;">
            </div>', ['style' => 'text-decoration: none;']) ?>
        </div>

        <div class="col-12 col-lg-6">
          <?php
          echo anchor('owner/daily', '<div class="card side-card bg-info p-2">
              <div class="d-flex flex-column justify-content-center">
                <p class="text-white fw-bold mt-4" style="font-size: 16px;">VIEW <br> DAILY REVENUE</p>
              </div>
              <img class="position-absolute top-0 end-0 img-fluid me-2 mt-1" src="' . base_url("assets/images/illustration/income-chart.png") . '" max-width="90px">
            </div>', ['style' => 'text-decoration: none;']);
          ?>
        </div>
      </div>
      <div class="row">
        <img src="<?= base_url("assets/images/illustration/Group13.png") ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col mt-5">
      <div class="table-responsive-sm">
        <table class="table">
          <thead class="bg-primary text-white fw-bold rounded-top">
            <tr style="font-size: 20px;" class="text-md">
              <th scope="col">#</th>
              <th scope="col">Client</th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Value</th>
              <th scope="col">Total</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <?php if (empty($daily_data)) : ?>
              <tr>
                <td colspan="7" class="text-center h4 text-secondary">No Data</td>
              </tr>
            <?php else : ?>
              <?php $no = 1 + $this->uri->segment(3); ?>
              <?php foreach ($daily_data as $row) : ?>
                <tr style="font-size: 16px;">
                  <th scope="row"><?= $no++; ?></th>
                  <td><?= $row->client; ?></td>
                  <td><?= $row->product_name; ?></td>
                  <td>Rp <?= $row->price; ?></td>
                  <td><?= $row->value; ?></td>
                  <td>RP <?= $row->total_price; ?></td>
                  <td><?= $row->date; ?></td>
                </tr>
              <?php endforeach ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
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