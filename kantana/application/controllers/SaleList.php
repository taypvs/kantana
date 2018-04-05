<?php
class SaleList extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->model("Msalecostdetail");
    $this->load->model("Mproduct");
    $this->load->model("Mcustomer");
    $this->load->model("Memployee");
    $this->load->model("Mdepartment");
    $this->load->model("Mestcost");

    $data_post = $this->input->post();
    if($data_post!=null) {
      $this->session->set_flashdata($this->_flash_post, $data_post);
      $this->checkValidationForm(); // Check Validation
      if ($this->form_validation->run() == TRUE) {
         redirect('salelist/add');
      }
    }


    // Flash Message
    $this->_data['mess'] = $this->session->flashdata($this->_flash_mess);
    $data = $this->session->all_userdata();

    // Get Item from database
    // $list_cost_item = $this->Mestcostdetail->getListCostItemFromCompany($data['company_id']);
    $list_product = $this->Mproduct->getListProductFromCompany($data['company_id']);
    $list_employee = $this->Memployee->getListEmployeeFromCompany($data['company_id']);
    $list_customer_ag = $this->Mcustomer->getListAgencyFromCompany($data['company_id']);
    $list_customer_na = $this->Mcustomer->getListNotAgencyFromCompany($data['company_id']);
    $list_department = $this->Mdepartment->getListDepartmentFromCompany($data['company_id']);
    $est_cost_item = $this->Mestcost->getEstCostItem($data['company_id']);

    // Set Data to View
    $this->_data['name'] = $data['name'];
    // $this->_data['list_cost_item'] = $list_cost_item;
    $this->_data['list_product'] = $list_product;
    $this->_data['list_employee'] = $list_employee;
    $this->_data['list_customer'] = $list_customer_ag;
    $this->_data['list_customer_na'] = $list_customer_na;
    $this->_data['list_department'] = $list_department;
    $this->_data['est_cost_item'] = $est_cost_item;
    $this->load->view('/price/sale_list.php', $this->_data);
  }

  public function getPrice(){
    $this->load->model(array('Mproduct'));
    $product_id = $_REQUEST['id'];
    $this->Mproduct->getPriceProduct($product_id);
  }

  public function getListItem(){
    $this->load->model('Mestcostdetail');
    $product_id = $_REQUEST['id'];

    $query = $this->Mestcostdetail->getCostItemFromTotalCostId($product_id);
    if($query->num_rows() > 0){
      $post_data = $query->result_array();
      $data['status'] = 'ok';
      $data['result'] = $post_data;
    } else {
      $data['status'] = 'error';
      $data['result'] = 'No result';
    }
    echo json_encode($data);
  }

  public function add () {
    $this->load->model("Msale");
    $this->load->model("Msalecostdetail");

    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();

    // print("Data Item Send : <pre>".print_r($data,true)."</pre>");

    // $data_post = $this->input->post();



    $title = $data['sale_case_name'];
    $customer = $data['sale_customer'];
    $agency = $data['sale_agency'];
    $employee = $data['sale_employee'];
    $department = $data['sale_department'];
    $formatDate = $data['sale_created_date'];
    $initTotal = remove_format($data['sale_init_total']);
    $saleTotal = remove_format($data['sale_sale_total']);
    $profit = remove_format($data['sale_profit']);
    $maxItemId = $this->getMaxItemId () == '' ? 1 : $this->getMaxItemId ();
    $maxItemId++;

    $data_insert = array(
      "project_title" => $title,
      "customer_id" => $customer,
      "agency_id" => $agency,
      "employee_id" => $employee,
      "department_id" => $department,
      "item_id" => $maxItemId,
      "total_selling_price" => $initTotal,
      "sale_est_diff" => $saleTotal,
      "gross_profit" => $profit,
      "created_date" => $formatDate,
      "updated_date" => $formatDate
    );
    // print("<pre>".print_r($data_insert,true)."</pre>");
    $result = $this->Msale->insertSaleCostItem($data_insert);

      $this->getMultiDataCostItem ($data, $dataUser['company_id'], $maxItemId);
      $this->session->set_flashdata($this->_flash_mess, "案件を登録しました!");
      redirect('salelist','location');


    // redirect('companymaster');
  }

  private function getMaxItemId () {
    $maxID = $this->Msale->getMaxItemId ();
    return $maxID[0]['id'];
  }

  private function getMultiDataCostItem ($data, $company_id, $item_id) {

    $numLine = $data['sale_row_num'];
    // print("Data Item Send : <pre>".print_r($data,true)."</pre>");

    $data_insert = array ();
    for ($i = 0; $i <=$numLine; $i++){
      //echo "print num line : " . $numLine;
      // $linePrefix = $i == 0 ? '' : '_' . $i;
      $linePrefix = '_' . $i;
      $lineNum = 'line_num-'.$i;
      $sale_product_id = 'sale_product_id'.$linePrefix;
      $sale_note = 'sale_note'.$linePrefix;
      $sale_cost_per_item = 'sale_cost_per_item'.$linePrefix; // Giá từng sp
      $quantity = 'sale-quantity'.$linePrefix; // SỐ lượng
      $unit = 'unit'.$linePrefix;
      $sale_total = 'sale_total'.$linePrefix; // Giá tổng
      $quantity2 = 'sale_quality2'.$linePrefix;
      $sale_price = 'sale_price'; //Giá ước tính
      $sale_total_price = 'sale_total_price'.$linePrefix; // Tổng giá ước tính
      $sale_diff = 'sale_diff'.$linePrefix;

      if (isset($data[$sale_product_id])){
        $data_line = array(
          "sale_data_id" => $item_id,
          "line_number" => $data[$lineNum],
          "note" => $data[$sale_note],
          "sale_cost_per_item" => remove_format($data[$sale_cost_per_item]),
          "quantity" => $data[$quantity],
          "quantity2" => $data[$quantity2],
          "unit" => $data[$unit],
          "sale_total" => remove_format($data[$sale_total]),
          "sale_cost" => remove_format($data[$sale_total_price]),
          "sale_est_cost" => remove_format($data[$sale_price]),
          "sale_diff" => remove_format($data[$sale_diff]),
          "customer_id" => $data['sale_customer'],
          "product_id" => $data[$sale_product_id],
          "company_id" => $company_id
        );
        array_push ($data_insert, $data_line);
      }

    }

    // print("Data Item Insert : <pre>".print_r($data_insert,true)."</pre>");
    $this->Msalecostdetail->inserMultiItem($data_insert);
  }

  private function checkValidationForm() {

    $data_post = $this->input->post();

    $this->form_validation->set_rules("sale_case_name", "案件", "required|xss_clean|trim",
                                      array('required' => '「案件」に入力してください。'));
    // $this->form_validation->set_message("est_case_name", "案件に入力してください。");

    $this->form_validation->set_rules("sale_customer", "得意先", "callback_select_none",
                                      array('select_none' => '「得意先」を選択してください。'));

    $this->form_validation->set_rules("sale_agency", "代理店", "callback_select_none",
                                      array('select_none' => '「代理店」を選択してください。'));

    $this->form_validation->set_rules("sale_employee", "当社担当者", "callback_select_none",
                                      array('select_none' => '「当社担当者」を選択してください。'));

    $this->form_validation->set_rules("sale_department", "当社担当部署", "callback_select_none",
                                      array('select_none' => '「当社担当部署」を選択してください。'));

    $this->form_validation->set_rules("sale_created_date", "作成日", "required|trim|xss_clean",
                                      array('required' => '「作成日」を選択してください。'));

    $numLine = $data_post['sale_row_num'];

    for ($i = 0; $i <=$numLine; $i++){
      //echo "print num line : " . $numLine;
      $linePrefix = '_' . $i;
      // $lineNum = 'line_num-'.$i;
      $product_id = 'sale_product_id'.$linePrefix;
      $quantity = 'sale_quantity'.$linePrefix;
      $sale_total = 'sale_total'.$linePrefix;

      $this->form_validation->set_rules($product_id, "項目", "required|xss_clean|trim",
                                        array('required' =>  ($i+1).'目の「項目」を選択してください。'));
      $this->form_validation->set_rules($quantity, "数量", "required|xss_clean|trim",
                                        array('required' =>  ($i+1).'目の「数量」に入力してください。'));
    }

  }

  function select_none($str)
  {
     $field_value = $str; //this is redundant, but it's to show you how
     //the content of the fields gets automatically passed to the method

     if($field_value != "none")
     {
       return TRUE;
     }
     else
     {
       return FALSE;
     }
  }

}
 ?>
