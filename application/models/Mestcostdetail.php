<?php
class Mestcostdetail extends CI_Model{
    protected $_table = 'cost_data_item_estimate';
    public function __construct(){
        parent::__construct();
    }

    public function getListCostItemFromCompany ($company_id) {
      $this->db->where('company_id',$company_id);
      $this->db->select('id, line_number, note, cost_per_item, quantity, unit, cost_total, multiplication_factor, price_per_item, price_total, customer_id, company_id');
      return $this->db->get($this->_table)->result_array();
    }

    public function getCostItemFromId ($id) {
      $this->db->where('id',$id);
      $this->db->select('id, line_number, note, cost_per_item, quantity, unit, cost_total, multiplication_factor, price_per_item, price_total, customer_id, company_id');
      return $this->db->get($this->_table)->result_array();
    }

    public function getCostItemFromTotalCostId ($id) {
      $this->db->where('cost_data_id',$id);
      $this->db->select('id, line_number, product_id, note, cost_per_item, quantity, unit, cost_total, multiplication_factor, price_per_item, price_total, customer_id, company_id');
      $query = $this->db->get($this->_table);

      return $query;
    }

    public function inserCostItem ($data_insert){
      $this->db->insert($this->_table,$data_insert);
    }

    public function inserMultiItem ($data_insert){
      $this->db->insert_batch($this->_table,$data_insert);
    }

    public function hasDefaultItem ($company_id) {
      $this->db->where('company_id',$company_id);
      $this->db->select('id');
      $query = $this->db->get($this->_table);
      if($query->num_rows() > 0){
        return TRUE;
      }else{
        return FALSE;
      }
    }
}
?>
