<?php
class Mproduct extends CI_Model{
    protected $_table = 'product';
    public function __construct(){
        parent::__construct();
    }

    public function getListProductFromCompany ($company_id){
      $this->db->where('company_id',$company_id);
      $this->db->where('available ',1);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getPriceProduct($product_id){
      $this->db->select('*');
      $this->db->where('id', $product_id);
      $query = $this->db->get($this->_table);
      if($query->num_rows() > 0){
        $post_data = $query->row();
        $data['status'] = 'ok';
        $data['result'] = $post_data;
      } else {
        $data['status'] = 'error';
        $data['result'] = 'No result';
      }
      echo json_encode($data);
    }

    public function getListProductFromCompanyEmployee ($employee_id){
      $this->db->where('employee_id',$employee_id);
      $this->db->where('available ',1);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function getListProductFromCompanyMaster (){
      $this->db->where('available ',1);
      $this->db->select('*');
      return $this->db->get($this->_table)->result_array();
    }

    public function insertProduct ($data_insert){
      $this->db->insert($this->_table,$data_insert);
    }

    public function ajax_update_product_master_model($id,$data_update){
      $this->db->where('id',$id);
      $this->db->update($this->_table,$data_update);
    }
    public function ajax_update_product_company_model($id,$data_update){
      $this->db->where('id',$id);
      $this->db->update($this->_table,$data_update);
    }
    public function ajax_update_product_employee_model($id,$data_update){
      $this->db->where('id',$id);
      $this->db->update($this->_table,$data_update);
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
}
?>
