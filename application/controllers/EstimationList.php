<?php
class EstimationList extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->model("Mestcostdetail");
    $this->load->model("Mproduct");
    $this->load->model("Mcustomer");
    $this->load->model("Memployee");
    $this->load->model("Mdepartment");

    $data_post = $this->input->post();
    if($data_post!=null) {
      $this->session->set_flashdata($this->_flash_post, $data_post);
      $this->checkValidationForm(); // Check Validation
      if ($this->form_validation->run() == TRUE) {
         redirect('estimationlist/add');
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

    // Set Data to View
    $this->_data['name'] = $data['name'];
    // $this->_data['list_cost_item'] = $list_cost_item;
    $this->_data['list_product'] = $list_product;
    $this->_data['list_employee'] = $list_employee;
    $this->_data['list_customer'] = $list_customer_ag;
    $this->_data['list_customer_na'] = $list_customer_na;
    $this->_data['list_department'] = $list_department;
    $this->load->view('/price/estimation_list.php', $this->_data);
  }

  public function add () {
    $this->load->model("Mestcost");
    $this->load->model("Mestcostdetail");

    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();


    $title = $data['est_case_name'];
    $customer = $data['est_customer'];
    $agency = explode('-', $data['est_agency'])[0];
    $employee = $data['est_employee'];
    $department = $data['est_department'];
    $originalDate = str_replace('/','-', $data['est_created_date']);
    $formatDate = date("Y-m-d", strtotime($originalDate));
    $initTotal = round($data['est_init_total']);
    $saleTotal = round($data['est_sale_total']);
    $profit = round($data['est_profit']);
    $maxItemId = $this->getMaxItemId () == '' ? 1 : $this->getMaxItemId ();
    $maxItemId++;

    $data_insert = array(
      "project_title" => $title,
      "customer_id" => $customer,
      "agency_id" => $agency,
      "company_id" => $dataUser['company_id'],
      "employee_id" => $employee,
      "department_id" => $department,
      "item_id" => $maxItemId,
      "est_total_cost" => $initTotal,
      "est_total_selling_price" => $saleTotal,
      "gross_profit" => $profit,
      "created_date" => $formatDate,
      "updated_date" => $formatDate
    );
    //print("<pre>".print_r($data_insert,true)."</pre>");
    $result = $this->Mestcost->inserCostItem($data_insert);

    if ($result !== null) {
      $this->getMultiDataCostItem ($data, $dataUser['company_id'], $maxItemId);
      $this->session->set_flashdata($this->_flash_mess, "案件を登録しました!");
      redirect('estimationlist');
    }


    // redirect('companymaster');
  }

  private function getMaxItemId () {
    $maxID = $this->Mestcost->getMaxItemId ();
    return $maxID[0]['id'];
  }

  private function getMultiDataCostItem ($data, $company_id, $item_id) {

    $numLine = $data['row_num'];
    //print("Data Item Send : <pre>".print_r($data,true)."</pre>");

    $data_insert = array ();
    for ($i = 0; $i <=$numLine; $i++){
      //echo "print num line : " . $numLine;
      $linePrefix = $i == 0 ? '' : '-' . $i;
      $lineNum = 'line_num-'.$i;
      $product_id = 'product_id'.$linePrefix;
      $note = 'note'.$linePrefix;
      $cost_per_item = 'cost_per_item'.$linePrefix;
      $quantity = 'quantity'.$linePrefix;
      $unit = 'unit'.$linePrefix;
      $total = 'total'.$linePrefix;
      $multi_factor = 'multi_factor'.$linePrefix;
      $sale_total = 'sale_total'.$linePrefix;
      $sale_per_item = 'sale_per_item'.$linePrefix;

      if (isset($data[$lineNum])){
        $data_line = array(
          "cost_data_id" => $item_id,
          "line_number" => $data[$lineNum],
          "note" => $data[$note],
          "cost_per_item" => $data[$cost_per_item],
          "quantity" => $data[$quantity],
          "unit" => $data[$unit],
          "cost_total" => $data[$total],
          "multiplication_factor" => $data[$multi_factor],
          "price_per_item" => $data[$sale_per_item],
          "price_total" => $data[$sale_total],
          "customer_id" => $data['est_customer'],
          "product_id" => explode('-', $data[$product_id])[0],
          "company_id" => $company_id
        );
        array_push ($data_insert, $data_line);
      }

    }

    // print("Data Item Insert : <pre>".print_r($data,true)."</pre>");
    $this->Mestcostdetail->inserMultiItem($data_insert);
  }


  private function checkValidationForm() {

    $data_post = $this->input->post();

    $this->form_validation->set_rules("est_case_name", "案件", "required|xss_clean|trim",
                                      array('required' => '「案件」に入力してください。'));
    // $this->form_validation->set_message("est_case_name", "案件に入力してください。");

    $this->form_validation->set_rules("est_customer", "得意先", "callback_select_none",
                                      array('select_none' => '「得意先」を選択してください。'));

    $this->form_validation->set_rules("est_agency", "代理店", "callback_select_none",
                                      array('select_none' => '「代理店」を選択してください。'));

    $this->form_validation->set_rules("est_employee", "当社担当者", "callback_select_none",
                                      array('select_none' => '「当社担当者」を選択してください。'));

    $this->form_validation->set_rules("est_department", "当社担当部署", "callback_select_none",
                                      array('select_none' => '「当社担当部署」を選択してください。'));

    $this->form_validation->set_rules("est_created_date", "作成日", "required|trim|xss_clean",
                                      array('required' => '「作成日」を選択してください。'));

    $numLine = $data_post['row_num'];

    for ($i = 0; $i <=$numLine; $i++){
      //echo "print num line : " . $numLine;
      $linePrefix = $i == 0 ? '' : '-' . $i;
      // $lineNum = 'line_num-'.$i;
      $product_id = 'product_id'.$linePrefix;
      $quantity = 'quantity'.$linePrefix;

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
