<?php
class Madmincareerdescription extends CI_Model{
    protected $_table = 'CareerDescriptionItem';
    public function __construct(){
        parent::__construct();
    }

    public function getlistCareer(){
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getCareerDescriptionAtCareerId($id){
      $this->db->where('career_id',$id);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function insertListCareerDescription ($data_insert){
      $this->db->insert_batch($this->_table,$data_insert);
    }

    function removeDescriptionDataAtCareerId($id)
    {
       $this->db->where('career_id', $id);
       $this->db->delete($this->_table);
    }
}
?>
