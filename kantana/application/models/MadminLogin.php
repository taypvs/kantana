<?php
class MadminLogin extends CI_Model{
    protected $_table = 'admin';
    public function __construct(){
        parent::__construct();
    }

    public function getInfoAdmin($id){
      $this->db->where('username',$id);
      return $this->db->get($this->_table)->result_array();
    }


}
?>
