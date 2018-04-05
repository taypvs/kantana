<?php
class Msale extends CI_Model{
    protected $_table = 'sale_data';
    public function __construct(){
        parent::__construct();
    }

    public function getSaleItemRelative ($id) {
      $this->db->where('item_id',$id);
      $this->db->select('id, project_title, customer_id, employee_id, total_selling_price, sale_est_diff, gross_profit, created_date, updated_date, item_id');
      return $this->db->get($this->_table)->result_array();
    }

    // Get sum of sale cost in current month
    public function getSumSaleCostCurrentMonth ($year, $month) {
      if($month == '02'){
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-28');
      } elseif ($month == '04' || $month == '06' || $month == '09' || $month == '11') {
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-30');
      } else {
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-31');
      }

      $this->db->select_sum('total_selling_price');
      return $this->db->get($this->_table)->row();
    }

    // Get sum of sale cost in last month
    public function getSumSaleCostLastMonth ($year, $month) {
      if($month == '02'){
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-28');
      } elseif ($month == '04' || $month == '06' || $month == '09' || $month == '11') {
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-30');
      } else {
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-31');
      }
      $this->db->select_sum('total_selling_price');
      return $this->db->get($this->_table)->row();
    }

    // Get max cost on current month
    public function getMaxSaleCostCurrentMonth ($year, $month) {
      if($month == '02'){
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-28');
      } elseif ($month == '04' || $month == '06' || $month == '09' || $month == '11') {
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-30');
      } else {
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-31');
      }
      $this->db->select_max('total_selling_price');
      return $this->db->get($this->_table)->row();
    }

    // Get min cost on current month
    public function getMinSaleCostCurrentMonth ($year, $month) {
      if($month == '02'){
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-28');
      } elseif ($month == '04' || $month == '06' || $month == '09' || $month == '11') {
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-30');
      } else {
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-31');
      }
      $this->db->select_min('total_selling_price');
      return $this->db->get($this->_table)->row();
    }

    // Count item
    public function countSaleItem ($year, $month) {
      if($month == '02'){
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-28');
      } elseif ($month == '04' || $month == '06' || $month == '09' || $month == '11') {
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-30');
      } else {
        $this->db->where('created_date >= ',  $year . '-' . $month . '-01');
        $this->db->where('created_date <= ',  $year . '-' . $month . '-31');
      }
      return $this->db->count_all_results($this->_table);
    }

    public function insertSaleCostItem ($data_insert){
      $this->db->insert($this->_table,$data_insert);
    }

    public function getMaxItemId () {
      $this->db->select_max('id');
      return $this->db->get($this->_table)->result_array();
    }


}
?>
