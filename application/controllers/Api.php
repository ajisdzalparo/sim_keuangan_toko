<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Owner_model');
    header('Access-Control-Allow-Origin: *'); // Allow all domains
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Adjust methods as necessary
    header('Access-Control-Allow-Headers: Content-Type'); // Ensure this matches headers you are sending
  }

  public function revenue()
  {
    $timeFrame = $this->input->get('timeFrame');
    $response = [];
    switch ($timeFrame) {
      case 'daily':
        $salesData = $this->Owner_model->get_sales_data_weekly();
        $response = ['sales_per_day' => $salesData, 'label' => "Weekly Sales"];
        break;
      case 'monthly':
        $monthlySales = $this->Owner_model->get_total_monthly_sales();
        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $data = array_combine($labels, $monthlySales);
        $response = ['sales_per_month' => $data, 'label' => date('Y')];
        break;
      case 'yearly':
        $totalSales = $this->Owner_model->get_sales_data_yearly();
        $currentYear = date('Y');
        $labels = range($currentYear, $currentYear + 9);
        $data = array_fill_keys($labels, 0);
        $data[$currentYear] = $totalSales; // Menetapkan total penjualan tahun ini ke label tahun yang sesuai
        $response = ['sales_per_year' => $data, 'label' => date('Y')];
        break;
      default:
        $response = ['error' => 'Timeframe tidak valid'];
        break;
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }
}
