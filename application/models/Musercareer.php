<?php
class Musercareer extends CI_Model{
    protected $_table = 'career';
    public function __construct(){
        parent::__construct();
    }

    public function getlistCareer(){
      $this->db->select('*');
      $this->db->where('active', 1);
      return $this->db->get($this->_table)->result_array();
    }

    public function getCareerAtId($id){
      $this->db->where('id',$id);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }


}
?>
