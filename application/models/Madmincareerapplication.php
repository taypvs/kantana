<?php
class Madmincareerapplication extends CI_Model{
    protected $_table = 'CareerApplication';
    public function __construct(){
        parent::__construct();
    }

    public function getlistApplication(){
      $this->db->select('Career.*, CareerApplication.*');
      $this->db->join('Career', 'Career.id = CareerApplication.career_id');
      return $this->db->get($this->_table)->result_array();
    }

    public function insertNewApplication($data_insert){
      $this->db->insert($this->_table,$data_insert);
    }

    public function getApplicationAtId($id){
      $this->db->where('CareerApplication.id',$id);
      $this->db->select('*');
      $this->db->join('Career', 'Career.id = CareerApplication.career_id');
      return $this->db->get($this->_table)->result_array();
    }


}
?>
