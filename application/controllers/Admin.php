<?php

class Admin extends CI_Controller
{

 public function __construct()
 {
  parent::__construct();
  $this->load->database();
  $this->load->library('session');
  $this->load->model("Admin_model");
  $this->load->helper('url');
  date_default_timezone_set('Asia/Jakarta');

  // Cek session login, kecuali untuk fungsi 'login'
  if (!$this->session->userdata('logged_in') && $this->router->fetch_method() != 'login') {
   redirect('admin/login');
  }
 }

 public function login()
 {
  // Cek apakah pengguna sudah login, jika ya, redirect ke dashboard
  if ($this->session->userdata('logged_in')) {
   redirect('admin/dashboard');
  }

  // Load library dan helper yang dibutuhkan
  $this->load->library('form_validation');
  $this->load->helper('url');

  // Atur aturan validasi untuk form login
  $this->form_validation->set_rules('email', 'Email', 'required');
  $this->form_validation->set_rules('password', 'Password', 'required');

  if ($this->form_validation->run() == FALSE) {
   // Tampilkan halaman login jika validasi gagal
   $this->load->view('admin/login');
  } else {
   // Input dari form
   $email = $this->input->post('email');
   $password = $this->input->post('password');

   // Verifikasi pengguna melalui model
   $user = $this->Admin_model->validate_user($email, $password);
   if ($user) {
    // Cek role pengguna
    if ($user->role == 'admin') {
     // Set session data
     $this->session->set_userdata('logged_in', TRUE);
     $this->session->set_userdata('role', 'admin');
     redirect('admin/dashboard');
    } else {
     // Set flash data untuk error dan redirect ke login
     $this->session->set_flashdata('error', 'Akses Ditolak. Hanya Admin yang Dibolehkan.');
     redirect('admin/login');
    }
   } else {
    // Set flash data untuk error dan redirect ke login
    $this->session->set_flashdata('error', 'Email atau Password Salah');
    redirect('admin/login');
   }
  }
 }

 public function logout()
 {
  // Hapus data session
  $this->session->unset_userdata('logged_in');
  $this->session->unset_userdata('role');

  // Set flash data untuk notifikasi logout berhasil
  $this->session->set_flashdata('message', 'Anda telah berhasil logout.');
  $this->session->set_flashdata('message_type', 'success');

  // Redirect ke halaman login
  redirect('admin/login');
 }

 public function Dashboard()
 {
  $data['revenue_data'] = $this->Admin_model->getDataRevenueToday();
  $data['total_revenue_today'] = $this->Admin_model->getTotalRevenueToday();
  $data['total_value_today'] = $this->Admin_model->getTotalValueToday();

  $this->load->view("template/admin/sidebar");
  $this->load->view("template/admin/navbar");
  $this->load->view("admin/dashboard", $data);
  $this->load->view("template/admin/footer");
 }

 public function Inventory()
 {
  $this->load->library('pagination');

  // Mengambil filter dari query string
  $filter_product_name = $this->input->get('filter_product_name');

  // Hitung jumlah total baris dengan filter
  $total_rows = $this->Admin_model->countInventoryData($filter_product_name);

  // Konfigurasi pagination
  $page_number = $this->uri->segment(3) ? $this->uri->segment(3) : 1;
  $config = [
   'base_url' => base_url('admin/inventory'),
   'total_rows' => $total_rows,
   'per_page' => 5,
   'uri_segment' => 3,
   'use_page_numbers' => TRUE,
   'full_tag_open' => '<nav><ul class="pagination justify-content-center">',
   'full_tag_close' => '</ul></nav>',
   'num_tag_open' => '<li class="page-item">',
   'num_tag_close' => '</li>',
   'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
   'cur_tag_close' => '</a></li>',
   'next_tag_open' => '<li class="page-item">',
   'next_tag_close' => '</li>',
   'prev_tag_open' => $page_number == 1 ? '<li class="page-item disabled">' : '<li class="page-item">',
   'prev_tag_close' => '</li>',
   'first_tag_open' => '<li class="page-item">',
   'first_tag_close' => '</li>',
   'last_tag_open' => '<li class="page-item">',
   'last_tag_close' => '</li>',
   'attributes' => ['class' => 'page-link']
  ];

  $this->pagination->initialize($config);

  $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
  $offset = ($page == 0) ? 0 : ($page - 1) * $config['per_page'];

  $data['inventory_data'] = $this->Admin_model->getDataInventory($filter_product_name, $config['per_page'], $offset);
  $data['all_products'] = $this->Admin_model->getAllProductNames();

  $this->load->view("template/admin/sidebar");
  $this->load->view("template/admin/navbar");
  $this->load->view("admin/inventory", $data);
  $this->load->view("template/admin/footer");
 }


 public function addInboundData()
 {
  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');

  // Set validation rules for inbound data
  $this->form_validation->set_rules('product_name', 'product_name', 'required');
  $this->form_validation->set_rules('color', 'color', 'required');
  $this->form_validation->set_rules('price', 'price', 'required|numeric');
  $this->form_validation->set_rules('stock', 'stock', 'required|numeric');

  if ($this->form_validation->run() == FALSE) {
   $this->session->set_flashdata('error', validation_errors());
   redirect('admin/addInbound');
  } else {
   $product_name = $this->input->post('product_name');
   $color = $this->input->post('color');
   $price = $this->input->post('price');
   $stock = $this->input->post('stock');

   // Cek apakah kombinasi product_name dan color sudah ada di database
   $existing_product = $this->Admin_model->getProductByProductNameAndColor($product_name, $color);

   if ($existing_product) {
    // Jika produk sudah ada, tambahkan saja stoknya
    $new_stock = $existing_product->stock + $stock;
    $this->Admin_model->updateStock($product_name, $color, $price, $new_stock);
   } else {
    // Jika produk belum ada, masukkan semua data baru
    $this->Admin_model->insertDataInventory($product_name, $color, $price, $stock);
   }
   redirect('admin/inventory');
  }
 }

 public function Outbound()
 {
  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');

  // Set validation rules for outbound data
  $this->form_validation->set_rules('product_name_out', 'product_name_out', 'required');
  $this->form_validation->set_rules('color_out', 'color_out', 'required');
  $this->form_validation->set_rules('price_out', 'price_out', 'required|numeric');
  $this->form_validation->set_rules('stock_out', 'stock_out', 'required|numeric');

  if ($this->form_validation->run() == FALSE) {
   $this->session->set_flashdata('error', validation_errors());
   redirect('admin/inventory');
  } else {
   $product_name = $this->input->post('product_name_out');
   $color = $this->input->post('color_out');
   $price = $this->input->post('price_out');
   $stock = $this->input->post('stock_out');

   // Cek stok di database
   $current_stock = $this->Admin_model->checkStock($product_name, $color, $price);

   if ($current_stock) {
    if ($current_stock == 1 || $current_stock - $stock <= 0) {
     // Hapus data jika stok setelah dikurangi menjadi 0 atau kurang
     $this->Admin_model->deleteDataInventory($product_name, $color, $price, $current_stock);
    } else {
     // Kurangi stok jika lebih dari 1 dan hasilnya tidak nol
     $new_stock = $current_stock - $stock;
     $this->Admin_model->updateStock($product_name, $color, $price, $new_stock);
    }
   }

   redirect('admin/inventory');
  }
 }

 public function editDataInventory($id)
 {
  $where = array('id' => $id);
  $data['inventory_data'] = $this->Admin_model->editDataInventory($where, 'inventory')->result();

  $this->load->view("template/admin/sidebar");
  $this->load->view("template/admin/navbar");
  $this->load->view("admin/edit_inventory", $data);
  $this->load->view("template/admin/footer");
 }

 public function updateDataInventory()
 {
  $this->load->library('form_validation');
  $this->form_validation->set_rules('product_name', 'Product Name', 'required');
  $this->form_validation->set_rules('color', 'Color', 'required');
  $this->form_validation->set_rules('price', 'Price', 'required|numeric');
  $this->form_validation->set_rules('stock', 'Stock', 'required|numeric');

  $id = $this->input->post('id');
  if ($this->form_validation->run() == FALSE) {
   $this->session->set_flashdata('error', validation_errors());
   redirect('admin/editData/' . $id);
  }
  $product_name = $this->input->post('product_name');
  $color = $this->input->post('color');
  $price = $this->input->post('price');
  $stock = $this->input->post('stock');

  $this->Admin_model->updateDataInventory($id, $product_name, $color, $price, $stock);
  redirect('admin/inventory');
 }

 public function deleteDataInventory($id)
 {
  $this->Admin_model->deleteInventory($id);
  redirect('admin/inventory');
 }

 public function insertRevenue()
 {
  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');

  $this->form_validation->set_rules('client', 'Client', 'required');
  $this->form_validation->set_rules('product_name', 'Product Name', 'required');
  $this->form_validation->set_rules('price', 'Price', 'required|numeric');
  $this->form_validation->set_rules('value', 'Value', 'required|numeric');
  $this->form_validation->set_rules('date', 'Date', 'required');

  if ($this->form_validation->run() == FALSE) {
   $this->session->set_flashdata('error', validation_errors());
   redirect('admin/dashboard');
  } else {
   $client = $this->input->post('client');
   $product_name = $this->input->post('product_name');
   $price = $this->input->post('price');
   $value = $this->input->post('value');
   $date = $this->input->post('date');

   if ($this->Admin_model->insertRevenue($client, $product_name, $price, $value, $date)) {
    $this->session->set_flashdata('message', 'Data successfully saved.');
    $this->session->set_flashdata('message_type', 'success');
   } else {
    $this->session->set_flashdata('message', 'Failed to save data.');
    $this->session->set_flashdata('message_type', 'danger');
   }

   redirect('admin/dashboard');
  }
 }

 public function Daily()
 {
  $this->load->library('pagination');
  $config['base_url'] = base_url('admin/daily');
  $config['total_rows'] = $this->Admin_model->countRevenueData();
  $config['per_page'] = 10; // Sesuaikan dengan kebutuhan

  $this->pagination->initialize($config);

  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
  $data['revenue_data'] = $this->Admin_model->getDataRevenueTodayPagination($config['per_page'], $page);

  $this->load->view("template/admin/sidebar");
  $this->load->view("template/admin/navbar");
  $this->load->view("admin/revenue", $data);
  $this->load->view("template/admin/footer");
 }

 public function deleteDataRevenueInDashboard($id)
 {
  $this->Admin_model->deleteRevenue($id);
  redirect('admin/dashboard');
 }
 public function deleteDataRevenue($id)
 {
  $this->Admin_model->deleteRevenue($id);
  redirect('admin/revenue');
 }

 public function editDataRevenueInDashboard($id)
 {
  $where = array('id' => $id);
  $data['revenue_data'] = $this->Admin_model->editDataRevenue($where, 'revenue')->result();

  $this->load->view("template/admin/sidebar");
  $this->load->view("template/admin/navbar");
  $this->load->view("admin/edit_revenue_dashboard", $data);
  $this->load->view("template/admin/footer");
 }

 public function editDataRevenue($id)
 {
  $where = array('id' => $id);
  $data['revenue_data'] = $this->Admin_model->editDataRevenue($where, 'revenue')->result();

  $this->load->view("template/admin/sidebar");
  $this->load->view("template/admin/navbar");
  $this->load->view("admin/edit_revenue", $data);
  $this->load->view("template/admin/footer");
 }

 public function updateRevenueInDashboard()
 {
  $this->load->library('form_validation');
  $this->form_validation->set_rules('client', 'Client', 'required');
  $this->form_validation->set_rules('product_name', 'Product Name', 'required');
  $this->form_validation->set_rules('price', 'Price', 'required|numeric');
  $this->form_validation->set_rules('value', 'Value', 'required|numeric');
  $this->form_validation->set_rules('date', 'Date', 'required');

  $id = $this->input->post('id');
  if ($this->form_validation->run() == FALSE) {
   $this->session->set_flashdata('error', validation_errors());
   redirect('admin/editRevenueInDashboard/' . $id);
  }
  $client = $this->input->post('client');
  $product_name = $this->input->post('product_name');
  $price = $this->input->post('price');
  $value = $this->input->post('value');
  $total_price = $price * $value;
  $date = $this->input->post('date');
  $insert_date = date('Y-m-d');

  $this->Admin_model->updateDataRevenue($id, $client, $product_name, $price, $value, $total_price, $date, $insert_date);
  redirect('admin/dashboard');
 }

 public function updateDataRevenue()
 {
  $this->load->library('form_validation');
  $this->form_validation->set_rules('client', 'Client', 'required');
  $this->form_validation->set_rules('product_name', 'Product Name', 'required');
  $this->form_validation->set_rules('price', 'Price', 'required|numeric');
  $this->form_validation->set_rules('value', 'Value', 'required|numeric');
  $this->form_validation->set_rules('date', 'Date', 'required');

  $id = $this->input->post('id');
  if ($this->form_validation->run() == FALSE) {
   $this->session->set_flashdata('error', validation_errors());
   redirect('admin/editRevenue/' . $id);
  }
  $client = $this->input->post('client');
  $product_name = $this->input->post('product_name');
  $price = $this->input->post('price');
  $value = $this->input->post('value');
  $total_price = $price * $value;
  $date = $this->input->post('date');
  $insert_date = date('Y-m-d');

  $this->Admin_model->updateDataRevenue($id, $client, $product_name, $price, $value, $total_price, $date, $insert_date);
  redirect('admin/daily');
 }

 public function revenue()
 {
  $filter_client = $this->input->get('filter_client');
  $data['revenue_data'] = $this->Admin_model->getRevenueDataByClient($filter_client);
  $data['all_clients'] = $this->Admin_model->getAllClients();

  $this->load->view("template/admin/sidebar");
  $this->load->view("template/admin/navbar");
  $this->load->view("admin/revenue", $data);
  $this->load->view("template/admin/footer");
 }

 public function fetchDataOutbound($productName, $color)
 {
  $product = $this->Admin_model->getProductByProductNameAndColor($productName, $color);

  if ($product) {
   $data = [
    'price' => $product->price,
    'stock' => $product->stock
   ];
   header('Content-Type: application/json');
   echo json_encode($data);
  } else {
   $data = [
    'price' => null,
    'stock' => null
   ];
   header('Content-Type: application/json');
   echo json_encode($data);
  }
 }
}
