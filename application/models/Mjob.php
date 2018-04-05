<?php
class Mjob extends CI_Model{
    protected $_table = 'job';
    public function __construct(){
        parent::__construct();
    }

    public function getJobList ($id){
      $this->db->where('company_id',$id);
      $this->db->select('id, name, company_id');
      return $this->db->get($this->_table)->result_array();
    }

    public function getJobListMaster (){
      $this->db->select('id, name, company_id');
      return $this->db->get($this->_table)->result_array();
    }

}
?>
