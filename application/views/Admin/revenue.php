<?php if ($this->session->flashdata('message_name')) : ?>
 <div class="alert alert-success">
  <?= $this->session->flashdata('message_name'); ?>
 </div>
<?php endif; ?>

<section class="container-fluid mt-4 p-4">

 <h4 class="mb-4"><b>Add</b> Daily Revenue</h4>
 <table class="table">
  <thead class="bg-primary text-white fw-bold rounded-top">
   <tr>
    <th scope="col">#</th>
    <th scope="col">Client</th>
    <th scope="col">Product</th>
    <th scope="col">Price</th>
    <th scope="col">Value</th>
    <th scope="col">Total</th>
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
    <?php $no = 1 + ($this->uri->segment(3) ? $this->uri->segment(3) : 0); ?>
    <?php foreach ($revenue_data as $row) : ?>
     <tr>
      <th scope="row"><?= $no++ ?></th>
      <td><?= $row->client ?></td>
      <td><?= $row->product_name ?></td>
      <td>Rp <?= $row->price ?></td>
      <td>x<?= $row->value ?></td>
      <td>RP <?= $row->price * $row->value ?></td>
      <td><?= date('d-m-Y', strtotime($row->date)) ?></td>
      <td>
       <?php echo anchor('admin/editDataRevenue/' . $row->id, '<button type="button" class="btn btn-sm btn-warning">Edit</button>') ?>
       <?php echo anchor('admin/deleteDataRevenue/' . $row->id, '<button type="button" class="btn btn-sm btn-danger text-dark text-white">Delete</button>') ?>
      </td>
     </tr>
    <?php endforeach ?>
   <?php endif ?>
  </tbody>
 </table>
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
</section>
</section>