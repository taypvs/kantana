<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfilter extends CI_Model{
  public function __construct()
  {
    parent::__construct();
  }

  public function getInfoByDate($fromdate, $todate){
    $this->db->where('created_date >=',$fromdate);
    $this->db->where('created_date <=',$todate);
    $this->db->select('*');
    $this->db->select_max('total_selling_price','max_selling_cost');
    $this->db->select_min('total_selling_price','min_selling_cost');
    $this->db->distinct();
    $this->db->select_sum('sale_est_diff');
    $this->db->select_sum('total_selling_price');
    $this->db->select_avg('gross_profit');
    $this->db->group_by('created_date');
    $this->db->order_by('created_date','asc');
    $query = $this->db->get('sale_data');
    if($query->num_rows() > 0){
      return $query->result_array();
    }
  }

  public function getInfoByName($fromdate, $todate){
    $this->db->where('sale_data.created_date >=',$fromdate);
    $this->db->where('sale_data.created_date <=',$todate);
    $this->db->select('sale_data.employee_id,sale_data.sale_est_diff,sale_data.total_selling_price,sale_data.created_date,employee.id,employee.name')
    ->from('sale_data')
    ->join('employee','sale_data.employee_id = employee.id');
    $this->db->select_max('total_selling_price','max_selling_cost');
    $this->db->select_min('total_selling_price','min_selling_cost');
    $this->db->distinct();
    $this->db->select_sum('sale_est_diff');
    $this->db->select_sum('total_selling_price');
    $this->db->select_avg('gross_profit');
    $this->db->group_by('employee_id');
    $this->db->order_by('employee_id','asc');
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result_array();
    }
  }

  public function getInfoByProject($fromdate, $todate){
    $this->db->where('created_date >=',$fromdate);
    $this->db->where('created_date <=',$todate);
    $this->db->select('*');
    $this->db->select_max('total_selling_price','max_selling_cost');
    $this->db->select_min('total_selling_price','min_selling_cost');
    $this->db->distinct();
    $this->db->select_sum('sale_est_diff');
    $this->db->select_sum('total_selling_price');
    $this->db->select_avg('gross_profit');
    $this->db->group_by('project_title');
    $this->db->order_by('project_title','asc');
    $query = $this->db->get('sale_data');
    if($query->num_rows() > 0){
      return $query->result_array();
    }
  }

  public function getInfoByDepartment($fromdate, $todate){
    $this->db->where('sale_data.created_date >=',$fromdate);
    $this->db->where('sale_data.created_date <=',$todate);
    $this->db->select('sale_data.department_id,sale_data.sale_est_diff,sale_data.total_selling_price,sale_data.created_date,department_master.id,department_master.name')
    ->from('sale_data')
    ->join('department_master','sale_data.department_id = department_master.id');
    $this->db->select_max('total_selling_price','max_selling_cost');
    $this->db->select_min('total_selling_price','min_selling_cost');
    $this->db->distinct();
    $this->db->select_sum('sale_est_diff');
    $this->db->select_sum('total_selling_price');
    $this->db->select_avg('gross_profit');
    $this->db->group_by('department_id');
    $this->db->order_by('department_id','asc');
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result_array();
    }
  }

  public function getInfoByCustomer($fromdate, $todate, $agency){
    $this->db->where('sale_data.created_date >=',$fromdate);
    $this->db->where('sale_data.created_date <=',$todate);
    $this->db->select('sale_data.customer_id,sale_data.sale_est_diff,sale_data.total_selling_price,sale_data.created_date,customer.id,customer.name,customer.agency')
    ->from('sale_data')
    ->join('customer','sale_data.customer_id = customer.id');
    if($agency == 'agency'){
      $this->db->where('customer.agency !=','none');
    } else {
      $this->db->where('customer.agency =','none');
    }
    $this->db->select_max('total_selling_price','max_selling_cost');
    $this->db->select_min('total_selling_price','min_selling_cost');
    $this->db->distinct();
    $this->db->select_sum('sale_est_diff');
    $this->db->select_sum('total_selling_price');
    $this->db->select_avg('gross_profit');
    $this->db->group_by('department_id');
    $this->db->order_by('department_id','asc');
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result_array();
    }
  }

}
?>
