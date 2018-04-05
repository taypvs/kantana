<?php
class Memployee extends CI_Model{
    protected $_table = 'employee';
    public function __construct(){
        parent::__construct();
    }

    public function checkUser($id, $pass){
      $this->db->where('login_id',$id);
      $this->db->where('password',$pass);
      $query=$this->db->get($this->_table);
      if($query->num_rows() > 0){
        return TRUE;
      }else{
        return FALSE;
      }
    }

    public function getEmployee ($id){
      $this->db->where('login_id',$id);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getEmployeeWithPermission ($permission) {
      // 4a : 掛け率
      // 4b : 担当者
      // 4c  : 従業員マスタ
      // 4d : 部署マスタ
      // 5 : normal
      $this->db->like('permission',$permission);
      $this->db->where('invisible',1);
      $this->db->where('available',1);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getListEmployeeFromCompany ($company_id) {
      $this->db->where('company_id',$company_id);
      $this->db->where('available',1);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getListEmployeeFromCompanyMaster () {
      $this->db->where('available',1);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function insertEmployee ($data_insert){
      $this->db->insert($this->_table,$data_insert);
    }

    public function ajax_update_employee_master_model($id,$data_update){
      $this->db->where('id',$id);
      $this->db->update($this->_table,$data_update);
    }
    public function ajax_update_employee_company_model($id,$data_update){
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
