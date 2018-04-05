<?php
class Mcompany extends CI_Model{
    protected $_table = 'company_master';
    public function __construct(){
        parent::__construct();
    }

    public function checkCompany($id, $pass){
      $this->db->where('management_id',$id);
      $this->db->where('password',$pass);
      $query=$this->db->get($this->_table);
      if($query->num_rows() > 0){
        return TRUE;
      }else{
        return FALSE;
      }
    }

    public function getCompany ($id){
      $this->db->where('management_id',$id);
      $this->db->select('id, name, management_id,multiplication_factor_init,available, role, invisible');
      return $this->db->get($this->_table)->result_array();
    }

    public function insertCompany ($data_insert){
      $this->db->insert($this->_table,$data_insert);
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


    public function getListCompanyFromMaster($master_id){
      $this->db->where('master_id',$master_id);
      $this->db->where('invisible',1);
      $this->db->where('available',1);
      $this->db->select("*");
      return $this->db->get($this->_table)->result_array();
    }

    public function getListCompanyFromMaster2($master_id){
      $this->db->where('master_id',$master_id);
      $this->db->where('available',1);
      $this->db->select("*");
      return $this->db->get($this->_table)->result_array();
    }

    public function ajax_update_company_model($id,$data_update){
      $this->db->where('id',$id);
      $this->db->update($this->_table,$data_update);
    }

}
?>
