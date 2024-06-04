<section>
 <div class="container-fluid-sm p-3 mx-4">
  <div class="row-sm mt-4 mb-3">
   <h3 style="font-size: 20px;" class="col-sm ">Inventory</h3>
  </div>
  <div class="row mt-5">
   <div class="table-responsive-sm col-sm">
    <table class="table">
     <thead class="bg-primary text-white fw-bold rounded-top">
      <tr style="font-size: 20px;" class="text-md">
       <th scope="col">#</th>
       <th scope="col">Product</th>
       <th scope="col">Color</th>
       <th scope="col">Price</th>
       <th scope="col">Stock</th>
      </tr>
     </thead>
     <tbody class="bg-white">
      <?php $no = 1 + $this->uri->segment(3); ?>
      <?php foreach ($inventory as $item) : ?>
       <tr style="font-size: 16px;">
        <td><?= $no++; ?></td>
        <td><?= $item->product_name; ?></td>
        <td><?= $item->color; ?></td>
        <td>Rp <?= $item->price; ?></td>
        <td><?= $item->stock; ?></td>
       </tr>
      <?php endforeach; ?>
     </tbody>
    </table>
    <div class="d-flex justify-content-center">
     <?= $links ?>
    </div>
   </div>
  </div>
 </div>
</section>
</section>