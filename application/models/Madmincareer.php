<?php
class Madmincareer extends CI_Model{
    protected $_table = 'career';
    public function __construct(){
        parent::__construct();
    }

    public function getlistCareer(){
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getCareerAtId($id){
      $this->db->where('id',$id);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function insertNewCareer($data_insert){
      $this->db->insert($this->_table,$data_insert);
    }

    public function selectMaxIdCareer(){
      $this->db->select_max('id');
      return $this->db->get($this->_table)->result_array();
    }

    public function updateCareerInfo($id,$data_update){
      $this->db->where('id',$id);
      $this->db->update($this->_table,$data_update);
    }

    public function removeCareerAtId($id){
      $this->db->where('id',$id);
      $this->db->delete($this->_table);
    }

}
?>
