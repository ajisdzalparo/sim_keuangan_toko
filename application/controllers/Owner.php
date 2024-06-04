<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Owner extends CI_Controller
{

 public function __construct()
 {
  parent::__construct();
  $this->load->database();
  $this->load->model('Owner_model');
  $this->load->library('session');
  $this->load->helper('url');
  date_default_timezone_set('Asia/Jakarta');
 }

 public function login()
 {
  // Cek apakah pengguna sudah login, jika ya, redirect ke dashboard
  if ($this->session->userdata('logged_in')) {
   redirect('owner/dashboard');
  }

  // Load library dan helper yang dibutuhkan
  $this->load->library('form_validation');
  $this->load->helper('url');

  // Atur aturan validasi untuk form login
  $this->form_validation->set_rules('email', 'Email', 'required');
  $this->form_validation->set_rules('password', 'Password', 'required');

  if ($this->form_validation->run() == FALSE) {
   // Tampilkan halaman login jika validasi gagal
   $this->load->view('owner/login');
  } else {
   // Input dari form
   $email = $this->input->post('email');
   $password = $this->input->post('password');

   // Verifikasi pengguna melalui model
   $user = $this->Owner_model->validate_user($email, $password);
   if ($user) {
    // Cek role pengguna
    if ($user->role == 'owner') {
     // Set session data
     $this->session->set_userdata('logged_in', TRUE);
     $this->session->set_userdata('role', 'owner');
     redirect('owner/dashboard');
    } else {
     // Set flash data untuk error dan redirect ke login
     $this->session->set_flashdata('error', 'Akses Ditolak. Hanya Owner yang Dibolehkan.');
     redirect('owner/login');
    }
   } else {
    // Set flash data untuk error dan redirect ke login
    $this->session->set_flashdata('error', 'Email atau Password Salah');
    redirect('owner/login');
   }
  }
 }

 public function dashboard($page = 0)
 {
  // Ambil data per halaman tanpa pagination
  $data['daily_data'] = $this->Owner_model->get_daily_data();
  $data['total_revenue_today'] = $this->Owner_model->getTotalRevenueToday();
  $data['total_value_today'] = $this->Owner_model->getTotalValueToday();

  $this->load->view("template/owner/sidebar");
  $this->load->view("template/owner/navbar");
  $this->load->view("owner/dashboard", $data);
  $this->load->view("template/owner/footer");
 }

 public function inventory($page = 0)
 {
  $this->load->library('pagination');

  $config['base_url'] = site_url('owner/inventory');
  $config['total_rows'] = $this->Owner_model->count_inventory();
  $config['per_page'] = 15;
  $config['uri_segment'] = 3;
  $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
  $config['full_tag_close'] = '</ul>';
  $config['attributes'] = ['class' => 'page-link'];
  $config['first_link'] = 'First';
  $config['last_link'] = 'Last';
  $config['first_tag_open'] = '<li class="page-item">';
  $config['first_tag_close'] = '</li>';
  $config['prev_link'] = '&laquo';
  $config['prev_tag_open'] = '<li class="page-item">';
  $config['prev_tag_close'] = '</li>';
  $config['next_link'] = '&raquo';
  $config['next_tag_open'] = '<li class="page-item">';
  $config['next_tag_close'] = '</li>';
  $config['last_tag_open'] = '<li class="page-item">';
  $config['last_tag_close'] = '</li>';
  $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
  $config['cur_tag_close'] = '</a></li>';
  $config['num_tag_open'] = '<li class="page-item">';
  $config['num_tag_close'] = '</li>';

  $this->pagination->initialize($config);

  $data['inventory'] = $this->Owner_model->get_inventory($config['per_page'], $page);
  $data['links'] = $this->pagination->create_links();

  $this->load->view("template/owner/sidebar");
  $this->load->view("template/owner/navbar");
  $this->load->view("owner/inventory", $data);
  $this->load->view("template/owner/footer");
 }

 public function all_revenue($page = 0)
 {
  $this->load->library('pagination');

  $config['base_url'] = site_url('owner/all_revenue');
  $config['total_rows'] = $this->Owner_model->count_all_revenue(); // Ensure this line exists
  $config['per_page'] = 15;
  $config['uri_segment'] = 3;
  $this->apply_pagination_config($config);

  $this->pagination->initialize($config);

  $data['all_revenue'] = $this->Owner_model->get_all_revenue($config['per_page'], $page);
  $data['links'] = $this->pagination->create_links();
  $data['start'] = $page;

  $this->load->view("template/owner/sidebar");
  $this->load->view("template/owner/navbar");
  $this->load->view("owner/all_revenue", $data);
  $this->load->view("template/owner/footer");
 }

 public function daily($page = 0)
 {
  $this->load->library('pagination');

  $config['base_url'] = site_url('owner/daily');
  $config['total_rows'] = $this->Owner_model->count_daily_data();
  $config['per_page'] = 15;
  $config['uri_segment'] = 3;
  $this->apply_pagination_config($config);

  $this->pagination->initialize($config);

  $data['daily_data'] = $this->Owner_model->get_daily_data($config['per_page'], $page);
  $data['links'] = $this->pagination->create_links();

  // Cek jika tidak ada data dan set flash data
  if (empty($data['daily_data'])) {
   $this->session->set_flashdata('no_data', 'Tidak ada data penjualan untuk hari ini.');
  }

  $this->load->view("template/owner/sidebar");
  $this->load->view("template/owner/navbar");
  $this->load->view("owner/daily", $data);
  $this->load->view("template/owner/footer");
 }

 private function apply_pagination_config(&$config)
 {
  $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
  $config['full_tag_close'] = '</ul>';
  $config['attributes'] = ['class' => 'page-link'];
  $config['first_link'] = 'First';
  $config['last_link'] = 'Last';
  $config['first_tag_open'] = '<li class="page-item">';
  $config['first_tag_close'] = '</li>';
  $config['prev_link'] = '&laquo';
  $config['prev_tag_open'] = '<li class="page-item">';
  $config['prev_tag_close'] = '</li>';
  $config['next_link'] = '&raquo';
  $config['next_tag_open'] = '<li class="page-item">';
  $config['next_tag_close'] = '</li>';
  $config['last_tag_open'] = '<li class="page-item">';
  $config['last_tag_close'] = '</li>';
  $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
  $config['cur_tag_close'] = '</a></li>';
  $config['num_tag_open'] = '<li class="page-item">';
  $config['num_tag_close'] = '</li>';
 }

 public function monthly($page = 0)
 {
  $this->load->library('pagination');

  $config['base_url'] = site_url('owner/monthly');
  $config['total_rows'] = $this->Owner_model->count_monthly_data();
  $config['per_page'] = 15; // Sesuaikan dengan kebutuhan
  $config['uri_segment'] = 3;
  $this->apply_pagination_config($config);

  $this->pagination->initialize($config);

  $page = ($this->uri->segment(3)) ? (int)$this->uri->segment(3) : 0;
  $start = $page * $config['per_page'];

  $data['monthly_data'] = $this->Owner_model->get_monthly_data($config['per_page'], $page);
  $data['links'] = $this->pagination->create_links();

  // Cek jika tidak ada data dan set flash data
  if (empty($data['monthly_data'])) {
   $this->session->set_flashdata('no_data', 'Tidak ada data penjualan untuk bulan ini.');
  }

  $this->load->view("template/owner/sidebar");
  $this->load->view("template/owner/navbar");
  $this->load->view("owner/monthly", $data);
  $this->load->view("template/owner/footer");
 }

 public function yearly($page = 0)
 {
  $this->load->library('pagination');

  $config['base_url'] = site_url('owner/yearly');
  $config['total_rows'] = $this->Owner_model->count_yearly_data();
  $config['per_page'] = 15;
  $config['uri_segment'] = 3;
  $this->apply_pagination_config($config);

  $this->pagination->initialize($config);

  $page = ($this->uri->segment(3)) ? (int)$this->uri->segment(3) : 0;
  $start = $page * $config['per_page'];

  $data['yearly_data'] = $this->Owner_model->get_yearly_data($config['per_page'], $page);
  $data['links'] = $this->pagination->create_links();

  // Cek jika tidak ada data dan set flash data
  if (empty($data['yearly_data'])) {
   $this->session->set_flashdata('no_data', 'Tidak ada data penjualan untuk tahun ini.');
  }

  $this->load->view("template/owner/sidebar");
  $this->load->view("template/owner/navbar");
  $this->load->view("owner/yearly", $data);
  $this->load->view("template/owner/footer");
 }

 public function logout()
 {
  // Hapus data sesi
  $this->session->unset_userdata('logged_in');
  $this->session->unset_userdata('role');

  // Set flash data untuk notifikasi logout berhasil
  $this->session->set_flashdata('success', 'Anda berhasil logout.');

  // Redirect ke halaman login
  redirect('owner/login');
 }

 public function profile()
 {
  $data['user'] = $this->Owner_model->getAccountOwner();

  $this->load->view("template/owner/sidebar");
  $this->load->view("template/owner/navbar");
  $this->load->view("owner/profile", $data);
  $this->load->view("template/owner/footer");
 }

 public function updateAccount()
 {
  $id = $this->input->post('id');
  $email = $this->input->post('email');
  $password = $this->input->post('password');
  $this->Owner_model->updateAccountOwner($id, $email, $password);

  $this->session->set_flashdata('success', 'Account berhasil diupdate.');

  redirect('owner/profile');
 }

 public function accountAdmin()
 {
  $data['user'] = $this->Owner_model->getAccountAdmin();

  $this->load->view("template/owner/sidebar");
  $this->load->view("template/owner/navbar");
  $this->load->view("owner/account_admin", $data);
  $this->load->view("template/owner/footer");
 }

 public function insertAdminAccount()
 {
  $email = $this->input->post('email');
  $password = $this->input->post('password');

  $this->Owner_model->insertAccountAdmin($email, $password);
  $this->session->set_flashdata('insert success', 'Account berhasil ditambahkan.');
  redirect('owner/accountAdmin');
 }

 public function editAccountAdmin($id)
 {
  $where = array('id' => $id);
  $data['user'] = $this->Owner_model->editAccountAdmin($where, 'users')->result();

  $this->load->view("template/owner/sidebar");
  $this->load->view("template/owner/navbar");
  $this->load->view("owner/edit_account_admin", $data);
  $this->load->view("template/owner/footer");
 }

 public function updateAccountAdmin()
 {
  $id = $this->input->post('id');
  $email = $this->input->post('email');
  $password = $this->input->post('password');
  $this->Owner_model->updateAccountAdmin($id, $email, $password);

  $this->session->set_flashdata('update success', 'Account berhasil diupdate.');

  redirect('owner/accountAdmin');
 }

 public function deleteAccountAdmin($id)
 {
  $this->Owner_model->deleteAccountAdmin($id);
  $this->session->set_flashdata('delete success', 'Account berhasil dihapus.');
  redirect('owner/accountAdmin');
 }
}
