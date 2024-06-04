<?php

class Admin_model extends CI_Model
{
 public function __construct()
 {
  parent::__construct();
  $this->load->database();
  date_default_timezone_set('Asia/Jakarta');
 }

 public function validate_user($email, $password)
 {
  $this->db->where('email', $email);
  $this->db->where('password', $password);
  $query = $this->db->get('users');

  if ($query->num_rows() == 1) {
   return $query->row();
  } else {
   return false;
  }
 }

 public function getDataInventory($filter_product_name = null, $limit = null, $start = 0)
 {
  $this->db->select("*");
  $this->db->from("inventory");
  if (!empty($filter_product_name)) {
   $this->db->like('product_name', $filter_product_name);
  }
  $this->db->limit($limit, $start);
  return $this->db->get()->result();
 }

 public function countInventoryData($filter_product_name = null)
 {
  $this->db->from('inventory');
  if (!empty($filter_product_name)) {
   $this->db->like('product_name', $filter_product_name);
  }
  return $this->db->count_all_results();
 }

 public function insertDataInventory($product_name, $color, $price, $stock)
 {
  $data = array(
   'product_name' => $product_name,
   'color' => $color,
   'price' => $price,
   'stock' => $stock
  );
  $this->db->insert('inventory', $data);
 }

 public function checkStock($product_name, $color, $price)
 {
  $this->db->select('stock');
  $this->db->from('inventory');
  $this->db->where('product_name', $product_name);
  $this->db->where('color', $color);
  $this->db->where('price', $price);
  $result = $this->db->get()->row();
  return $result->stock;
 }

 public function updateStock($product_name, $color, $price, $new_stock)
 {
  $data = array(
   'stock' => $new_stock,
   'price' => $price // Asumsi Anda ingin memperbarui harga juga
  );
  $this->db->where('product_name', $product_name);
  $this->db->where('color', $color);
  $this->db->update('inventory', $data);
 }

 public function deleteDataInventory($product_name, $color, $price, $stock)
 {
  $this->db->where('product_name', $product_name);
  $this->db->where('color', $color);
  $this->db->where('price', $price);
  $this->db->where('stock', $stock);
  $this->db->delete('inventory');
 }

 public function getDataInventoryById($id)
 {
  $this->db->where('id', $id);
  $query = $this->db->get('inventory');
  return $query->row_array();
 }

 public function editDataInventory($where, $table)
 {
  return $this->db->get_where($table, $where);
 }

 public function updateDataInventory($id, $product_name, $color, $price, $stock)
 {
  $data = array(
   'product_name' => $product_name,
   'color' => $color,
   'price' => $price,
   'stock' => $stock
  );
  $this->db->where('id', $id);
  $this->db->update('inventory', $data);
  redirect('admin/inventory');
 }

 public function deleteInventory($id)
 {
  $this->db->where('id', $id);
  $this->db->delete('inventory');
  redirect('admin/inventory');
 }

 public function getDataRevenueToday()
 {
  $today = date('Y-m-d'); // Mendapatkan tanggal hari ini
  $this->db->where('DATE(insert_date)', $today); // Filter data berdasarkan tanggal insert
  $this->db->limit(5); // Batasi hasil query menjadi 5
  $query = $this->db->get('revenue');
  return $query->result();
 }

 public function getDataRevenueTodayPagination($limit, $start)
 {
  $today = date('Y-m-d'); // Mendapatkan tanggal hari ini
  $this->db->where('DATE(date)', $today); // Filter data berdasarkan tanggal insert
  $this->db->limit($limit, $start); // Batasi hasil query menjadi 5
  $query = $this->db->get('revenue');
  return $query->result();
 }

 public function countRevenueData()
 {
  $today = date('Y-m-d');
  $this->db->where('DATE(date)', $today);
  $this->db->from('revenue');
  return $this->db->count_all_results();
 }

 public function insertRevenue($client, $product_name, $price, $value, $date)
 {
  $data = array(
   'client' => $client,
   'product_name' => $product_name,
   'price' => $price,
   'value' => $value,
   'total_price' => $price * $value,
   'date' => $date,
   'insert_date' => date('Y-m-d')
  );

  $insert = $this->db->insert('revenue', $data);
  if ($insert) {
   return true; // Data berhasil disimpan
  } else {
   $error = $this->db->error();
   log_message('error', 'Insert revenue failed: ' . $error['message']);
   return false; // Gagal menyimpan data
  }
 }

 public function getTotalRevenueToday()
 {
  $this->db->select_sum('total_price');
  $this->db->where('date', date('Y-m-d'));
  $query = $this->db->get('revenue');
  $result = $query->row();
  return $result ? $result->total_price : 0; // Return 0 if no data found
 }

 public function getTotalValueToday()
 {
  $this->db->select_sum('value');
  $this->db->where('date', date('Y-m-d'));
  $query = $this->db->get('revenue');
  $result = $query->row();
  return $result ? $result->value : 0; // Return 0 if no data found
 }

 public function deleteRevenue($id)
 {
  $this->db->where('id', $id);
  $this->db->delete('revenue');
 }

 public function editDataRevenue($where, $table)
 {
  return $this->db->get_where($table, $where);
 }

 public function updateDataRevenue($id, $client, $product_name, $price, $value, $total_price, $date, $insert_date)
 {
  $data = array(
   'client' => $client,
   'product_name' => $product_name,
   'price' => $price,
   'value' => $value,
   'total_price' => $total_price,
   'date' => $date,
   'insert_date' => $insert_date
  );
  $this->db->where('id', $id);
  $this->db->update('revenue', $data);
 }

 public function getProductByProductNameAndColor($product_name, $color)
 {
  $this->db->from('inventory');
  $this->db->where('product_name', $product_name);
  $this->db->where('color', $color);
  $query = $this->db->get();
  return $query->row();
 }

 public function getAllProductNames()
 {
  $this->db->distinct();
  $this->db->select('product_name');
  $this->db->from('inventory');
  $query = $this->db->get();
  return $query->result();
 }
}
