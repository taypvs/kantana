<?php
class Mdepartment extends CI_Model{
    protected $_table = 'department_master';
    public function __construct(){
        parent::__construct();
    }

    public function getDepartment ($id){
      $this->db->where('id',$id);
      $this->db->select('name, id, register_id');
      return $this->db->get($this->_table)->result_array();
    }

    public function insertDepartment ($data_insert){
      $this->db->insert($this->_table,$data_insert);
    }

    public function getListDepartmentFromCompany($company_master_id){
      $this->db->where('company_master_id',$company_master_id);
      $this->db->where('available',1);
      $this->db->select("*");
      return $this->db->get($this->_table)->result_array();
    }

    public function getListDepartmentFromCompanyMaster(){
      $this->db->where('invisible',1);
      $this->db->where('available',1);
      $this->db->select("*");
      return $this->db->get($this->_table)->result_array();
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

    public function ajax_update_department_master_model($id,$data_update){
      $this->db->where('id',$id);
      $this->db->update($this->_table,$data_update);
    }
    public function ajax_update_department_company_model($id,$data_update){
      $this->db->where('id',$id);
      $this->db->update($this->_table,$data_update);
    }
}
?>
