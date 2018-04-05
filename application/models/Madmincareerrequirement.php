<?php
class Madmincareerrequirement extends CI_Model{
    protected $_table = 'CareerRequirementItem';
    public function __construct(){
        parent::__construct();
    }

    public function getlistCareer(){
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getCareerRequirementAtCareerId($id){
      $this->db->where('career_id',$id);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function insertListCareerRequirement ($data_insert){
      $this->db->insert_batch($this->_table,$data_insert);
    }

    function removeRequirementDataAtCareerId($id)
    {
       $this->db->where('career_id', $id);
       $this->db->delete($this->_table);
    }
}
?>
