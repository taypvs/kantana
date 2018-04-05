<?php
class CustomerMaster extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->model("Mcustomer");
    $this->load->model("Memployee");
    $this->load->model("Mcompany");
    $data_post = $this->input->post();
    $data = $this->session->all_userdata();
    if($data_post!=null) {
      $this->session->set_flashdata($this->_flash_post,$data_post);
      if (isset($data_post['add'])){
        $this->checkValidationForm(); // Check Validation
        if ($this->form_validation->run() == TRUE) {
          if($data['role'] == 1){
            redirect('customerMaster/addMasterRole');
          } elseif($data['role'] == 2) {
            redirect('customerMaster/add');
          } elseif($data['role'] == 3) {
            redirect('customerMaster/addEmployeeRole');
          }
        }
      }
      else if (isset($data_post['remove']))
        redirect('customerMaster/remove');
      else if (isset($data_post['renew']))
        redirect('customerMaster/renew');
    }

    // Flash Message
    $this->_data['mess'] = $this->session->flashdata($this->_flash_mess);
    $data = $this->session->all_userdata();

    // Get data from Database for company
    $list_customer = $this->Mcustomer->getListCustomerFromCompany($data['id']);
    $list_employee_manager = $this->Memployee->getEmployeeWithPermission('4b');

    // Get data from Database for employee
    $list_customer_employee = $this->Mcustomer->getListCustomerFromCompanyEmployee($data['id']);

    // Get data from Database for admin
    $list_company = $this->Mcompany->getListCompanyFromMaster($data['id']);
    $list_customer_master = $this->Mcustomer->getListCustomerFromCompanyMaster();
    $new_register_id = addZeroToNumber (getLastRegisterId($list_customer_master) + 1);

    // Send Data To View
    $this->_data['name'] = $data['name'];
    $this->_data['role'] = $data['role'];
    $this->_data['new_register_id'] = $new_register_id;
    $this->_data['list_employee_manager'] = $list_employee_manager;
    $this->_data['list_customer'] = $list_customer;
    $this->_data['list_customer_employee'] = $list_customer_employee;
    $this->_data['list_customer_master'] = $list_customer_master;
    $this->_data['list_company'] = $list_company;
    $this->load->view('/master/customer_master.php', $this->_data);
  }

  public function add () {
    $this->load->model("Mcustomer");

    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();
    $employee_id_employee = $dataUser['id'];
    $company_id = $dataUser['company_id'];
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;
    $agency = isset($data['agency']) ? $data['agency'] : 'none';

    $data_insert = array(
      "register_id" => $data['register_id'],
      "name" => $data['name'],
      "phonetic" => $data['phonetic'],
      "phone_number" => $data['phone_number'],
      "postal_code" => $data['postal_code'],
      "address_1" => $data['address_1'],
      "address_2" => $data['address_2'],
      "phone_number" => $data['phone_number'],
      "fax_number" => $data['fax_number'],
      "mail_address" => $data['mail'],
      "employee_id" => $data['employee_id'],
      "multiplication_factor" => $data['multiplication_factor'],
      "agency" => $agency,
      "created_date" => $datetime,
      "updated_date" => $datetime,
      "invisible" => $data['invisible'],
      "available" => $available,
      "company_id" => $company_id
    );
    $this->Mcustomer->insertCustomer($data_insert);
    $this->session->set_flashdata($this->_flash_mess, "Added");
    redirect('customermaster');
  }


  public function addEmployeeRole () {
    $this->load->model("Mcustomer");

    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();
    $employee_id_employee = $dataUser['id'];
    $company_id = $dataUser['company_id'];
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;
    $agency = isset($data['agency']) ? $data['agency'] : 'none';

    $data_insert = array(
      "register_id" => $data['register_id'],
      "name" => $data['name'],
      "phonetic" => $data['phonetic'],
      "phone_number" => $data['phone_number'],
      "postal_code" => $data['postal_code'],
      "address_1" => $data['address_1'],
      "address_2" => $data['address_2'],
      "phone_number" => $data['phone_number'],
      "fax_number" => $data['fax_number'],
      "mail_address" => $data['mail'],
      "employee_id" => $employee_id_employee,
      "multiplication_factor" => $data['multiplication_factor'],
      "agency" => $agency,
      "created_date" => $datetime,
      "updated_date" => $datetime,
      "invisible" => $data['invisible'],
      "available" => $available,
      "company_id" => $company_id
    );
    $this->Mcustomer->insertCustomer($data_insert);
    $this->session->set_flashdata($this->_flash_mess, "Added");
    redirect('customermaster');
  }

  public function addMasterRole () {
    $this->load->model("Mcustomer");
    $this->load->model("Mcompany");
    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();

    $company = isset($data['company_id']) ? $data['company_id'] : 'none';
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;
    $agency = isset($data['agency']) ? $data['agency'] : 'none';

    $data_insert = array(
      "register_id" => $data['register_id'],
      "name" => $data['name'],
      "phonetic" => $data['phonetic'],
      "phone_number" => $data['phone_number'],
      "postal_code" => $data['postal_code'],
      "address_1" => $data['address_1'],
      "address_2" => $data['address_2'],
      "phone_number" => $data['phone_number'],
      "fax_number" => $data['fax_number'],
      "mail_address" => $data['mail'],
      "multiplication_factor" => $data['multiplication_factor'],
      "agency" => $agency,
      "created_date" => $datetime,
      "updated_date" => $datetime,
      "invisible" => $data['invisible'],
      "available" => $available,
      "employee_id" => $data['employee_id'],
      "company_id" => $company
    );
    $this->Mcustomer->insertCustomer($data_insert);
    $this->session->set_flashdata($this->_flash_mess, "Added");
    redirect('customermaster');
  }
  // FOR ADMIN ACCOUNT
  public function ajax_update_customer_master () {
    $this->load->model("Mcustomer");
    $this->load->model("Mcompany");
    $data = $this->input->post();
    $dataUser = $this->session->all_userdata();
    $company = isset($data['company_id']) ? $data['company_id'] : 'none';
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;
    $agency = isset($data['agency']) ? $data['agency'] : 'none';
    $id = $data['id'];
    $data_update = array(
      "name" => $data['name'],
      "phonetic" => $data['phonetic'],
      "phone_number" => $data['phone_number'],
      "postal_code" => $data['postal_code'],
      "address_1" => $data['address_1'],
      "address_2" => $data['address_2'],
      "phone_number" => $data['phone_number'],
      "fax_number" => $data['fax_number'],
      "mail_address" => $data['mail'],
      "multiplication_factor" => $data['multiplication_factor'],
      "agency" => $agency,
      "updated_date" => $datetime,
      "invisible" => $data['invisible'],
      "employee_id" => $data['employee_id'],
      "company_id" => $company,
      "available" => $available
    );
    $this->Mcustomer->ajax_update_customer_master_model($id, $data_update);
  }
  // FOR COMPANY ACCOUNT
  public function ajax_update_customer_company () {
    $this->load->model("Mcustomer");
    $this->load->model("Mcompany");
    $data = $this->input->post();
    $dataUser = $this->session->all_userdata();
    $company = $dataUser['company_id'];
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;
    $agency = isset($data['agency']) ? $data['agency'] : 'none';
    $id = $data['id'];
    $data_update = array(
      "name" => $data['name'],
      "phonetic" => $data['phonetic'],
      "phone_number" => $data['phone_number'],
      "postal_code" => $data['postal_code'],
      "address_1" => $data['address_1'],
      "address_2" => $data['address_2'],
      "phone_number" => $data['phone_number'],
      "fax_number" => $data['fax_number'],
      "mail_address" => $data['mail'],
      "multiplication_factor" => $data['multiplication_factor'],
      "agency" => $agency,
      "updated_date" => $datetime,
      "invisible" => $data['invisible'],
      "employee_id" => $data['employee_id'],
      "company_id" => $company,
      "available" => $available
    );
    $this->Mcustomer->ajax_update_customer_company_model($id, $data_update);
  }

  // FOR EMPLOYEE ACCOUNT
  public function ajax_update_customer_employee () {
    $this->load->model("Mcustomer");
    $this->load->model("Mcompany");
    $data = $this->input->post();
    $dataUser = $this->session->all_userdata();
    $company = $dataUser['company_id'];
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['available']) ? 0 : 1;
    $agency = isset($data['agency']) ? $data['agency'] : 'none';
    $id = $data['id'];
    $data_update = array(
      "name" => $data['name'],
      "phonetic" => $data['phonetic'],
      "phone_number" => $data['phone_number'],
      "postal_code" => $data['postal_code'],
      "address_1" => $data['address_1'],
      "address_2" => $data['address_2'],
      "phone_number" => $data['phone_number'],
      "fax_number" => $data['fax_number'],
      "mail_address" => $data['mail'],
      "multiplication_factor" => $data['multiplication_factor'],
      "agency" => $agency,
      "updated_date" => $datetime,
      "invisible" => $data['invisible'],
      "employee_id" => $dataUser['id'],
      "company_id" => $company,
      "available" => $available
    );
    $this->Mcustomer->ajax_update_customer_employee_model($id, $data_update);
  }

  public function remove () {
    $this->load->model("Mcustomer");

    $dataUser = $this->session->all_userdata();
    // Get data from Database
    $list_customer = $this->Mcustomer->getListCustomerFromCompany($dataUser['company_id']);

    $last_item = end ($list_customer);
    if ($this->Mcustomer->turnRemove ($last_item['id'])){
        redirect('customermaster');
    } else {
      echo 'error';
    }
  }

  public function renew () {
    redirect('customermaster');
  }

  private function checkValidationForm (){
    $this->form_validation->set_rules("name", "企業名", "required|xss_clean|trim",
                                      array('required' => '「企業名」に入力してください。'));
    $this->form_validation->set_rules("register_id", "企業管理用ID", "required|xss_clean|trim",
                                      array('required' => '「企業管理用ID」に入力してください。'));
    $this->form_validation->set_rules("postal_code", "郵便番号", "required|trim|xss_clean|max_length[8]",
                                      array('required' => '「郵便番号」に入力してください。'));
    $this->form_validation->set_rules("address_1", "住所1", "required|trim|xss_clean",
                                      array('required' => '「住所1」に入力してください。'));
    $this->form_validation->set_rules("phone_number", "電話番号", "required|trim|xss_clean",
                                      array('required' => '「電話番号」に入力してください。'));
    $this->form_validation->set_rules("fax_number", "FAX番号", "required|trim|xss_clean",
                                      array('required' => '「FAX番号」に入力してください。'));
    $this->form_validation->set_rules("mail", "メールアドレス", "required|trim|xss_clean|valid_email",
                                      array('required' => '「メールアドレス」に入力してください。'));
    $this->form_validation->set_rules("multiplication_factor", "掛け率", "required|trim|xss_clean|numeric",
                                      array('required' => '「掛け率」に入力してください。'));
  }
}

?>
