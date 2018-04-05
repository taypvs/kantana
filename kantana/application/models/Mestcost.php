<?php
class Mestcost extends CI_Model{
    protected $_table = 'cost_data_estimate';
    public function __construct(){
        parent::__construct();
    }

    public function getCostItemRelative ($id) {
      $this->db->where('item_id',$id);
      $this->db->select('id, proposal_code, project_title, customer_id, employee_id, department_id, item_id, est_total_cost, est_total_selling_price, gross_profit, created_date, updated_date');
      return $this->db->get($this->_table)->result_array();
    }

    // Get sum of estimate total cost in current month
    public function getSumEstTotalCostCurrentMonth ($year, $month) {
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
      $this->db->select_sum('est_total_cost');
      return $this->db->get($this->_table)->row();
    }

    // Get sum of estimate total cost in last month
    public function getSumEstTotalCostLastMonth ($year, $month) {
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
      $this->db->select_sum('est_total_cost');
      return $this->db->get($this->_table)->row();
    }

    // Get max cost on current month
    public function getMaxCostCurrentMonth ($year, $month) {
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
      $this->db->select_max('est_total_cost');
      return $this->db->get($this->_table)->row();
    }

    // Get min cost on current month
    public function getMinCostCurrentMonth ($year, $month) {
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
      $this->db->select_min('est_total_cost');
      return $this->db->get($this->_table)->row();
    }

    // Count item
    public function countItem ($year, $month) {
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

    public function inserCostItem ($data_insert){
      return $this->db->insert($this->_table,$data_insert);
    }

    public function getMaxItemId () {
      $this->db->select_max('id');
      return $this->db->get($this->_table)->result_array();
    }

    public function getEstCostItem($company_id){
      $this->db->where('cost_data_estimate.company_id', $company_id);
      $this->db->select('
        cost_data_estimate.id,
        cost_data_estimate.project_title,
        cost_data_estimate.customer_id,
        cost_data_estimate.employee_id,
        cost_data_estimate.department_id,
        cost_data_estimate.agency_id,
        cost_data_estimate.created_date,
        cost_data_estimate.company_id,
        cost_data_estimate.item_id,
        cost_data_estimate.est_total_cost,
        cost_data_estimate.est_total_selling_price,
        cost_data_item_estimate.cost_data_id,
        cost_data_item_estimate.line_number,
        cost_data_item_estimate.note,
        cost_data_item_estimate.product_id,
        cost_data_item_estimate.price_total,
        
        ')
      ->from('cost_data_estimate')
      ->join('cost_data_item_estimate','cost_data_item_estimate.cost_data_id = cost_data_estimate.item_id');
      // $this->db->group_by('cost_data_estimate.item_id');
      return $this->db->get()->result_array();
    }


}
?>
