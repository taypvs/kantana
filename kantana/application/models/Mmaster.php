<?php
class Mmaster extends CI_Model{
    protected $_table = 'master';
    public function __construct(){
        parent::__construct();
    }

    public function checkMaster($id, $pass){
      $this->db->where('login_id',$id);
      $this->db->where('password',$pass);
      $query=$this->db->get($this->_table);
      if($query->num_rows() > 0){
        return TRUE;
      }else{
        return FALSE;
      }
    }

    public function getMaster ($id){
      $this->db->where('login_id',$id);
      $this->db->select('login_id, name, id, role');
      return $this->db->get($this->_table)->result_array();
    }


}
?>
