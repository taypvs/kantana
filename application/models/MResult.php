<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MResult extends CI_Model{
  public function __construct()
  {
    parent::__construct();
  }

  public function getFullInfo($fromdate, $todate, $project_title, $employee_id, $customer_id, $department_id, $agency_id){
    if($project_title !== ''){
      $this->db->where('cost_data_estimate.project_title=',$project_title);
    }
    if($employee_id !== 'none'){
      $this->db->where('cost_data_estimate.employee_id=',$employee_id);
    }
    if($customer_id !== 'none'){
      $this->db->where('cost_data_estimate.customer_id=',$customer_id);
    }
    if($department_id !== 'none'){
      $this->db->where('cost_data_estimate.department_id=',$department_id);
    }
    if($agency_id !== 'none'){
      $this->db->where('cost_data_estimate.agency_id=',$agency_id);
    }

    $this->db->select('
      cost_data_estimate.id as cus_cost_id,
      cost_data_estimate.project_title,
      cost_data_estimate.customer_id,
      cost_data_estimate.employee_id,
      cost_data_estimate.department_id,
      cost_data_estimate.est_total_cost,
      cost_data_estimate.est_total_selling_price,
      cost_data_estimate.created_date,
      employee.id,
      employee.name as emp_name,
      customer.id,
      customer.name as cus_name,
      agency.id as agency_id,
      agency.name as agency_name,
      department_master.id,
      department_master.name as dep_name,
    ')
    ->from('cost_data_estimate')
    ->join('employee','cost_data_estimate.employee_id = employee.id')
    ->join('customer','cost_data_estimate.customer_id = customer.id')
    ->join('customer as agency','cost_data_estimate.agency_id = agency.id')
    ->join('department_master','cost_data_estimate.department_id = department_master.id');
    // $this->db->select_max('est_total_selling_price','max_selling_cost');
    // $this->db->select_min('est_total_selling_price','min_selling_cost');
    $this->db->distinct();
    // $this->db->select_sum('est_total_cost');
    // $this->db->select_sum('est_total_selling_price');
    // $this->db->group_by('cost_data_estimate.created_date');
    $this->db->having('cost_data_estimate.created_date >=',$fromdate);
    $this->db->having('cost_data_estimate.created_date <=',$todate);
    $this->db->order_by('cus_cost_id','asc');
    $query = $this->db->get();

    // echo $this->db->last_query();
    if($query->num_rows() > 0){

      return $query->result_array();
    }
  }

}
?>
