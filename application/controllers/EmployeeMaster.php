<?php
class EmployeeMaster extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->model("Memployee");
    $this->load->model("Mdepartment");
    $this->load->model("Mjob");
    $this->load->model("Mcustomer");
    $this->load->model("Mcompany");
    $data = $this->session->all_userdata();
    $data_post = $this->input->post();

    if($data_post!=null) {
      $this->session->set_flashdata($this->_flash_post,$data_post);
      if (isset($data_post['add'])){
        $this->checkValidationForm(); // Check Validation
        if ($this->form_validation->run() == TRUE) {
          if($data['role'] == 1){
            redirect('employeeMaster/addMasterRole');
          } elseif($data['role'] == 2){
            redirect('employeeMaster/add');
          }

        }
      }
      else if (isset($data_post['remove']))
        redirect('employeeMaster/remove');
      else if (isset($data_post['renew']))
        redirect('employeeMaster/renew');
    }

    // Flash Message
    $this->_data['mess'] = $this->session->flashdata($this->_flash_mess);
    $data = $this->session->all_userdata();

    // Get data from Database for company
    $list_employee = $this->Memployee->getListEmployeeFromCompany($data['id']); // Get employee list for company
    $list_job =  $this->Mjob->getJobList($data['id']); // Get job list for company
    $list_department =  $this->Mdepartment->getListDepartmentFromCompany($data['id']); // Get department list for company
    $list_customer = $this->Mcustomer->getListCustomerFromCompany($data['id']); // Get customer list for company

    // Get data from Database for company
    $list_company = $this->Mcompany->getListCompanyFromMaster($data['id']); // Get company list for admin
    $list_employee_master = $this->Memployee->getListEmployeeFromCompanyMaster(); // Get employee list for admin
    $list_job_master =  $this->Mjob->getJobListMaster(); // Get employee list for admin
    $list_department_master = $this->Mdepartment->getListDepartmentFromCompanyMaster(); // Get department list for admin
    $list_customer_master = $this->Mcustomer->getListCustomerFromCompanyMaster();// Get customer list for admin
    $new_register_id = addZeroToNumber (getLastRegisterId($list_employee_master) + 1);

    // Set Data to View
    $this->_data['name'] = $data['name'];
    $this->_data['list_job'] = $list_job;
    $this->_data['list_job_master'] = $list_job_master;
    $this->_data['list_department'] = $list_department;
    $this->_data['list_department_master'] = $list_department_master;
    $this->_data['list_employee'] = $list_employee;
    $this->_data['list_employee_master'] = $list_employee_master;
    $this->_data['list_customer'] = $list_customer;
    $this->_data['list_customer_master'] = $list_customer_master;
    $this->_data['list_company'] = $list_company;
    $this->_data['new_register_id'] = $new_register_id;
    $this->_data['role'] = $data['role'];
    $this->load->view('/master/employee_master.php', $this->_data);
  }

  public function add () {
    $this->load->model("Memployee");

    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();

    $company_id = $dataUser['company_id'];
    $datetime = date('Y-m-d H:i:s');
    $permission = $this->listPermission($data['permission']);
    $available = isset($data['available']) ? 0 : 1;
    $login_pass_decode = md5(md5(sha1($data['password'])));

    $data_insert = array(
      "register_id" => $data['register_id'],
      "name" => $data['name'],
      "login_id" => $data['login_id'],
      "password" => $login_pass_decode,
      "department_id" => $data['department_id'],
      "job_name" => $data['job_name'],
      "permission" => $permission,
      "invisible" => $data['invisible'],
      "available" => $available,
      "created_date" => $datetime,
      "updated_date" => $datetime,
      "company_id" => $company_id,
      "role" => 3
    );
    $this->Memployee->insertEmployee($data_insert);
    $this->session->set_flashdata($this->_flash_mess, "Added");
    redirect('employeemaster');
  }

  public function addMasterRole () {
    $this->load->model("Memployee");
    $this->load->model("Mcompany");

    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();
    $company = isset($data['company_id']) ? $data['company_id'] : 'none';
    $datetime = date('Y-m-d H:i:s');
    $permission = $this->listPermission($data['permission']);
    $available = isset($data['available']) ? 0 : 1;
    $login_pass_decode = md5(md5(sha1($data['password'])));

    $data_insert = array(
      "register_id" => $data['register_id'],
      "name" => $data['name'],
      "login_id" => $data['login_id'],
      "password" => $login_pass_decode,
      "department_id" => $data['department_id'],
      "job_name" => $data['job_name'],
      "permission" => $permission,
      "invisible" => $data['invisible'],
      "available" => $available,
      "created_date" => $datetime,
      "updated_date" => $datetime,
      "company_id" => $company,
      "role" => 3
    );
    $this->Memployee->insertEmployee($data_insert);
    $this->session->set_flashdata($this->_flash_mess, "Added");
    redirect('employeemaster');
  }

  public function ajax_update_employee_master () {
    $this->load->model("Memployee");

    $data = $this->input->post();
    $dataUser = $this->session->all_userdata();
    $datetime = date('Y-m-d H:i:s');
    $company = isset($data['company_id']) ? $data['company_id'] : 'none';
    $id = $data['id'];
    $permission = $this->listPermission($data['permission']);
    $available = isset($data['available']) ? 0 : 1;
    $data_update = array(
      "name" => $data['name'],
      "login_id" => $data['login_id'],
      "department_id" => $data['department_id'],
      "job_name" => $data['job'],
      "permission" => $permission,
      "invisible" => $data['invisible'],
      "updated_date" => $datetime,
      "company_id" => $company,
      "available" => $available
    );
    $this->Memployee->ajax_update_employee_master_model($id,$data_update);
  }

  public function ajax_update_employee_company () {
    $this->load->model("Memployee");

    $data = $this->input->post();
    $dataUser = $this->session->all_userdata();
    $datetime = date('Y-m-d H:i:s');
    $company = $dataUser['company_id'];
    $id = $data['id'];
    $permission = $this->listPermission($data['permission']);
    $available = isset($data['available']) ? 0 : 1;
    $data_update = array(
      "name" => $data['name'],
      "login_id" => $data['login_id'],
      "department_id" => $data['department_id'],
      "job_name" => $data['job'],
      "permission" => $permission,
      "invisible" => $data['invisible'],
      "updated_date" => $datetime,
      "company_id" => $company,
      "available" => $available
    );
    $this->Memployee->ajax_update_employee_company_model($id,$data_update);
  }

  public function remove () {
    $this->load->model("Memployee");

    $dataUser = $this->session->all_userdata();
    // Get data from Database
    $list_employee = $this->Memployee->getListEmployeeFromCompany($dataUser['company_id']);

    $last_item = end ($list_employee);
    if ($this->Memployee->turnRemove ($last_item['id'])){
        redirect('employeemaster');
    } else {
      echo 'error';
    }
  }


  private function checkValidationForm (){
    $this->form_validation->set_rules("name", "従業員名", "required|xss_clean|trim|min_length[2]",
                                      array('required' => '「従業員名」に入力してください。'));
    $this->form_validation->set_rules("login_id", "ログインID", "required|xss_clean|trim|min_length[4]",
                                      array('required' => '「ログインID」に入力してください。'));
    $this->form_validation->set_rules("password", "パスワド", "required|trim|xss_clean",
                                      array('required' => '「パスワド」に入力してください。'));
  }

  // For User When check multiple checkbox g
  private function listPermission ($list) {
    if (isset($list)){
      $prefix = $permission = '';
      foreach($list as $item){
        $permission .= $prefix. '' . $item . '';
        $prefix = ',';
      }
      return $permission;
    } else {
      return 5;
    }
  }

  public function renew () {
    redirect('employeemaster');
  }
}
 ?>
