<?php
class Musercareerapplication extends CI_Model{
    protected $_table = 'CareerApplication';
    public function __construct(){
        parent::__construct();
    }

    public function insertNewApplication($data_insert){
      $this->db->insert($this->_table,$data_insert);
    }


}
?>
