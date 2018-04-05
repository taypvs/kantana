<?php
class ProductMaster extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
    // /is_logged_in();
  }

  public function index(){
    $this->load->model("Mproduct");
    $this->load->model("Mcompany");
    $this->load->model("Memployee");
    $data_post = $this->input->post();
    $data = $this->session->all_userdata();
    if($data_post!=null) {
      $this->session->set_flashdata($this->_flash_post,$data_post);
      if (isset($data_post['add'])){
        $this->checkValidationForm(); // Check Validation
        if ($this->form_validation->run() == TRUE) {
          if($data['role'] == 1){
            redirect('productMaster/addMasterRole');
          } elseif($data['role'] == 2){
            redirect('productMaster/add');
          } else {
            redirect('productMaster/addEmployeeRole');
          }

        }
      }
      else if (isset($data_post['remove']))
        redirect('productMaster/remove');
      else if (isset($data_post['renew']))
        redirect('productMaster/renew');
    }
    // Flash Message
    $this->_data['mess'] = $this->session->flashdata($this->_flash_mess);
    $data = $this->session->all_userdata();

    // Get data from Database for company
    $list_product = $this->Mproduct->getListProductFromCompany($data['id']);
    $list_employee = $this->Memployee->getEmployeeWithPermission('4b');

    // Get data from Database for employee
    $list_product_employee = $this->Mproduct->getListProductFromCompanyEmployee($data['id']);

    // Get data from Database for admin
    $list_product_master = $this->Mproduct->getListProductFromCompanyMaster();
    $list_company = $this->Mcompany->getListCompanyFromMaster($data['id']);

    $new_register_id = addZeroToNumber (getLastRegisterId($list_product_master) + 1);

    // Set Data to View
    $this->_data['name'] = $data['name'];
    $this->_data['role'] = $data['role'];
    $this->_data['list_product'] = $list_product;
    $this->_data['list_employee'] = $list_employee;
    $this->_data['list_company'] = $list_company;
    $this->_data['list_product_master'] = $list_product_master;
    $this->_data['list_product_employee'] = $list_product_employee ;
    $this->_data['new_register_id'] = $new_register_id;
    $this->load->view('/master/product_master.php', $this->_data);
  }

  public function add () {
    $this->load->model("Mproduct");
    $this->load->model("Mcompany");
    $this->load->model("Memployee");
    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();

    $company_id = $dataUser['company_id'];
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;
    $data_insert = array(
      "register_id" => $data['register_id'],
      "name" => $data['name'],
      "estimate_cost" => $data['estimate_cost'],
      "sale_cost" => $data['sale_cost'],
      "unit" => $data['unit'],
      "invisible" => $data['invisible'],
      "available" => $available,
      "created_date" => $datetime,
      "updated_date" => $datetime,
      "company_id" => $company_id
    );
    $this->Mproduct->insertProduct($data_insert);
    $this->session->set_flashdata($this->_flash_mess, "Added");
    redirect('productmaster');
  }

  public function addEmployeeRole () {
    $this->load->model("Mproduct");
    $this->load->model("Mcompany");
    $this->load->model("Memployee");
    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();

    $company_id = $dataUser['company_id'];
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;

    $data_insert = array(
      "register_id" => $data['register_id'],
      "name" => $data['name'],
      "estimate_cost" => $data['estimate_cost'],
      "sale_cost" => $data['sale_cost'],
      "unit" => $data['unit'],
      "invisible" => $data['invisible'],
      "available" => $available,
      "created_date" => $datetime,
      "updated_date" => $datetime,
      "employee_id" => $dataUser['id'],
      "company_id" => $company_id
    );
    $this->Mproduct->insertProduct($data_insert);
    $this->session->set_flashdata($this->_flash_mess, "Added");
    redirect('productmaster');
  }

  public function addMasterRole () {
    $this->load->model("Mproduct");
    $this->load->model("Mcompany");
    $this->load->model("Memployee");
    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();

    $company = isset($data['company_id']) ? $data['company_id'] : 'none';
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;

    $data_insert = array(
      "register_id" => $data['register_id'],
      "name" => $data['name'],
      "estimate_cost" => $data['estimate_cost'],
      "sale_cost" => $data['sale_cost'],
      "unit" => $data['unit'],
      "invisible" => $data['invisible'],
      "available" => $available,
      "created_date" => $datetime,
      "updated_date" => $datetime,
      "company_id" => $company
    );
    $this->Mproduct->insertProduct($data_insert);
    $this->session->set_flashdata($this->_flash_mess, "Added");
    redirect('productmaster');
  }

  // FOR ADMIN ACCOUNT
  public function ajax_update_product_master () {
    $this->load->model("Mproduct");
    $this->load->model("Mcompany");
    $this->load->model("Memployee");
    $data = $this->input->post();
    $dataUser = $this->session->all_userdata();

    $company = isset($data['company_id']) ? $data['company_id'] : 'none';
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;
    $id = $data['id'];
    $data_update = array(
      "name" => $data['name'],
      "estimate_cost" => $data['estimate_cost'],
      "sale_cost" => $data['sale_cost'],
      "unit" => $data['unit'],
      "invisible" => $data['invisible'],
      "updated_date" => $datetime,
      "company_id" => $company,
      "available" => $available
    );
    $this->Mproduct->ajax_update_product_master_model($id, $data_update);
  }

  // FOR COMPANY ACCOUNT
  public function ajax_update_product_company () {
    $this->load->model("Mproduct");
    $this->load->model("Mcompany");
    $this->load->model("Memployee");
    $data = $this->input->post();
    $dataUser = $this->session->all_userdata();
    $company = $dataUser['id'];
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;
    $id = $data['id'];
    $data_update = array(
      "name" => $data['name'],
      "estimate_cost" => $data['estimate_cost'],
      "sale_cost" => $data['sale_cost'],
      "unit" => $data['unit'],
      "invisible" => $data['invisible'],
      "updated_date" => $datetime,
      "company_id" => $company,
      "available" => $available
    );
    $this->Mproduct->ajax_update_product_company_model($id, $data_update);
  }

  // FOR EMPLOYEE ACCOUNT
  public function ajax_update_product_employee () {
    $this->load->model("Mproduct");
    $this->load->model("Mcompany");
    $this->load->model("Memployee");
    $data = $this->input->post();
    $dataUser = $this->session->all_userdata();
    $company = $dataUser['company_id'];
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;
    $id = $data['id'];
    $data_update = array(
      "name" => $data['name'],
      "estimate_cost" => $data['estimate_cost'],
      "sale_cost" => $data['sale_cost'],
      "unit" => $data['unit'],
      "invisible" => $data['invisible'],
      "updated_date" => $datetime,
      "employee_id" => $dataUser['employee_id'],
      "company_id" => $company,
      "available" => $available
    );
    $this->Mproduct->ajax_update_product_employee_model($id, $data_update);
  }

  public function remove () {
    $this->load->model("Mproduct");

    $dataUser = $this->session->all_userdata();
    // Get data from Database
    $list_product = $this->Mproduct->getListProductFromCompany($dataUser['company_id']);

    $last_item = end ($list_product);
    if ($this->Mproduct->turnRemove ($last_item['id'])){
        redirect('productmaster');
    } else {
      echo 'error';
    }
  }

  public function renew () {
    redirect('productmaster');
  }

  private function checkValidationForm (){
    $this->form_validation->set_rules("name", "従業員名", "required|xss_clean|trim",
                                      array('required' => '「従業員名」に入力してください。'));
    $this->form_validation->set_rules("estimate_cost", "見積単価", "required|xss_clean|trim|integer",
                                      array('required' => '「見積単価」に入力してください。'));
    $this->form_validation->set_rules("sale_cost", "原価", "required|trim|xss_clean|integer",
                                      array('required' => '「原価」に入力してください。'));
    $this->form_validation->set_rules("unit", "単位", "required|trim|xss_clean",
                                      array('required' => '「単位」に入力してください。'));
  }
}

?>
