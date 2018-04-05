<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MSaleResult extends CI_Model{
  public function __construct()
  {
    parent::__construct();
  }

  public function getFullInfoSale($fromdate, $todate, $project_title, $employee_id, $customer_id, $department_id, $agency_id){
    if($project_title !== ''){
      $this->db->where('sale_data.project_title=',$project_title);
    }
    if($employee_id !== 'none'){
      $this->db->where('sale_data.employee_id=',$employee_id);
    }
    if($customer_id !== 'none'){
      $this->db->where('sale_data.customer_id=',$customer_id);
    }
    if($department_id !== 'none'){
      $this->db->where('sale_data.department_id=',$department_id);
    }
    if($agency_id !== 'none'){
      $this->db->where('sale_data.agency_id=',$agency_id);
    }

    $this->db->select('
      sale_data.id as sale_cus_cost_id,
      sale_data.project_title,
      sale_data.customer_id,
      sale_data.employee_id,
      sale_data.department_id,
      sale_data.sale_est_diff,
      sale_data.total_selling_price,
      sale_data.created_date,
      employee.id,
      employee.name as emp_name,
      customer.id,
      customer.name as cus_name,
      agency.id as agency_id,
      agency.name as agency_name,
      department_master.id,
      department_master.name as dep_name,
    ')
    ->from('sale_data')
    ->join('employee','sale_data.employee_id = employee.id')
    ->join('customer','sale_data.customer_id = customer.id')
    ->join('customer as agency','sale_data.agency_id = agency.id')
    ->join('department_master','sale_data.department_id = department_master.id');
    // $this->db->select_max('total_selling_price','max_selling_cost');
    // $this->db->select_min('total_selling_price','min_selling_cost');
    $this->db->distinct();
    // $this->db->select_sum('sale_est_diff');
    // $this->db->select_sum('total_selling_price');
    // $this->db->group_by('sale_data.created_date');
    $this->db->having('sale_data.created_date >=',$fromdate);
    $this->db->having('sale_data.created_date <=',$todate);
    $this->db->order_by('sale_cus_cost_id','asc');
    $query = $this->db->get();
    //echo $this->db->last_query();
    if($query->num_rows() > 0){

      return $query->result_array();
    }
  }

}
?>
