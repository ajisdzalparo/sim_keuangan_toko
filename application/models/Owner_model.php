<?php

class Owner_model extends CI_Model
{

 public function constract()
 {
  $this->load->database();
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

 public function get_inventory($limit = 10, $start = 0)
 {
  $this->db->select('*');
  $this->db->from('inventory');
  $this->db->limit($limit, $start);
  $query = $this->db->get();
  return $query->result();
 }

 public function count_inventory()
 {
  return $this->db->count_all('inventory');
 }

 public function get_revenue($limit = 20, $start = 0)
 {
  $this->db->select('*');
  $this->db->from('revenue');
  $this->db->limit($limit, $start);
  $query = $this->db->get();
  return $query->result();
 }

 public function count_revenue()
 {
  return $this->db->count_all_results('revenue');
 }

 public function getTotalRevenueToday()
 {
  $this->db->select_sum('total_price');
  $this->db->where('date', date('Y-m-d'));
  $query = $this->db->get('revenue');
  $result = $query->row();
  return $result ? $result->total_price : 0;
 }

 public function getTotalValueToday()
 {
  $this->db->select_sum('value');
  $this->db->where('date', date('Y-m-d'));
  $query = $this->db->get('revenue');
  $result = $query->row();
  return $result ? $result->value : 0;
 }

 public function get_daily_data()
 {
  $today = date('Y-m-d');
  $this->db->where('DATE(date)', $today);
  $query = $this->db->get('revenue');
  return $query->result();
 }

 public function count_daily_data()
 {
  $today = date('Y-m-d');
  $this->db->where('DATE(date)', $today);
  $this->db->from('revenue');
  return $this->db->count_all_results();
 }

 public function get_monthly_data($limit, $offset)
 {
  $this->db->select('*');
  $this->db->from('revenue');
  $this->db->where('MONTH(date)', date('m'));
  $this->db->limit($limit, $offset);
  $query = $this->db->get();
  return $query->result();
 }

 public function count_monthly_data()
 {
  $this->db->where('MONTH(date)', date('m'));
  $this->db->from('revenue');
  return $this->db->count_all_results();
 }

 public function get_yearly_data($limit, $offset)
 {
  $this->db->select('*');
  $this->db->from('revenue');
  $this->db->where('YEAR(date)', date('Y'));
  $this->db->limit($limit, $offset);
  $query = $this->db->get();
  return $query->result();
 }

 public function count_yearly_data()
 {
  $this->db->where('YEAR(date)', date('Y'));
  $this->db->from('revenue');
  return $this->db->count_all_results();
 }

 public function get_sales_data_weekly()
 {
  $salesData = [];
  for ($i = 0; $i < 7; $i++) {
   $date = date('Y-m-d', strtotime("-$i days"));
   $this->db->select_sum('total_price', 'total_price');
   $this->db->where('DATE(date)', $date);
   $this->db->from('revenue');
   $query = $this->db->get();
   $result = $query->row();
   $salesData[date('l', strtotime($date))] = $result ? $result->total_price : 0;
  }
  return array_reverse($salesData, true);
 }

 public function get_total_monthly_sales()
 {
  $currentYear = date('Y');
  $this->db->select('MONTH(date) as month, SUM(total_price) as total_price');
  $this->db->where('YEAR(date)', $currentYear);
  $this->db->group_by('MONTH(date)');
  $this->db->from('revenue');
  $query = $this->db->get();
  $result = $query->result();

  $monthlySales = array_fill(1, 12, 0); // Fill all months with 0
  foreach ($result as $row) {
   $monthlySales[intval($row->month)] = floatval($row->total_price);
  }
  return $monthlySales;
 }

 public function get_sales_data_yearly()
 {
  $currentYear = date('Y');
  $this->db->select('SUM(total_price) as total_price');
  $this->db->where('YEAR(date)', $currentYear);
  $this->db->from('revenue');
  $query = $this->db->get();

  // Handle jika tidak ada data yang ditemukan
  if ($query->num_rows() > 0 && $query->row()->total_price !== null) {
   return $query->row()->total_price;
  } else {
   return 0; // Mengembalikan 0 jika tidak ada penjualan
  }
 }

 public function get_all_revenue($limit = 10, $start = 0)
 {
  $this->db->select('*');
  $this->db->from('revenue');
  $this->db->limit($limit, $start);
  $query = $this->db->get();
  return $query->result();
 }

 public function count_all_revenue()
 {
  $this->db->from('revenue');
  return $this->db->count_all_results();
 }

 public function getAccountOwner()
 {
  $this->db->select('*');
  $this->db->from('users');
  $this->db->where('role', 'owner');
  $query = $this->db->get();
  return $query->result();
 }

 public function updateAccountOwner($id, $email, $password)
 {
  $data = array(
   'id' => $id,
   'email' => $email,
   'password' => $password,
   'role' => 'owner'
  );

  $this->db->where('id', $id);
  $this->db->update('users', $data);
 }

 public function getAccountAdmin()
 {
  $this->db->select('*');
  $this->db->from('users');
  $this->db->where('role', 'admin');
  $query = $this->db->get();
  return $query->result();
 }

 public function insertAccountAdmin($email, $password)
 {
  $data = array(
   'email' => $email,
   'password' => $password,
   'role' => 'admin'
  );

  $this->db->insert('users', $data);
 }

 public function editAccountAdmin($where, $table)
 {
  return $this->db->get_where($table, $where);
 }

 public function updateAccountAdmin($id, $email, $password)
 {
  $data = array(
   'id' => $id,
   'email' => $email,
   'password' => $password,
   'role' => 'admin'
  );

  $this->db->where('id', $id);
  $this->db->update('users', $data);
 }

 public function deleteAccountAdmin($id)
 {
  $this->db->where('id', $id);
  $this->db->delete('users');
 }
}
