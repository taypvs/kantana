<?php
class Mcustomer extends CI_Model{
    protected $_table = 'customer';
    protected $_contract_table = 'customer_contract';
    public function __construct(){
        parent::__construct();
    }

    public function getCustomer ($id){
      $this->db->where('id',$id);
      $this->db->select('id, name, agency, register_id');
      return $this->db->get($this->_table)->result_array();
    }

    public function getListCustomerFromCompany ($company_id) {
      $this->db->where('company_id',$company_id);
      $this->db->where('available',1);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getListCustomerFromCompanyEmployee ($employee_id) {
      $this->db->where('employee_id',$employee_id);
      $this->db->where('available',1);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getListCustomerFromCompanyMaster () {
      $this->db->where('available',1);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getListAgencyFromCompany ($company_id) {
      $this->db->where('company_id',$company_id);

      $this->db->where('available',1);
      $this->db->where('agency !=','none');
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getListNotAgencyFromCompany ($company_id) {
      $this->db->where('company_id',$company_id);
      $this->db->where('available',1);
      $this->db->where('agency','none');
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getListAgencyFromCompanyMaster () {
      $this->db->where('available',1);
      $this->db->where('agency !=','none');
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getListNotAgencyFromCompanyMaster () {
      $this->db->where('available',1);
      $this->db->where('agency','none');
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getListCustomerFromContract ($employeemaster_id) {
      $this->db->select('*');
      $this->db->from ($_table);
      $this->db->join($_contract_table, 'customer_contact.customer_id = customer.id');
      $this->db->where('customer_contact.employee_id',$employeemaster_id);
      $this->db->where('customer.available',1);
      $query = $this->db->get();
      return $query->result_array();
    }

    public function insertCustomer ($data_insert){
      $this->db->insert($this->_table,$data_insert);
    }

    public function ajax_update_customer_master_model($id,$data_update){
      $this->db->where('id',$id);
      $this->db->update($this->_table,$data_update);
    }
    public function ajax_update_customer_employee_model($id,$data_update){
      $this->db->where('id',$id);
      $this->db->update($this->_table,$data_update);
    }
    public function ajax_update_customer_company_model($id,$data_update){
      $this->db->where('id',$id);
      $this->db->update($this->_table,$data_update);
    }

    public function turnRemove ($id) {
      $data=array(
        "available" => 0
      );
      $this->db->where("id", $id);
        if($this->db->update($this->_table, $data)){
            return true;
        }else{
            return false;
        }
    }
}
?>
