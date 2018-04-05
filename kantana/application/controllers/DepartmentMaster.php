<?php
class DepartmentMaster extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->model("Mdepartment");
    $this->load->model("Mcompany");
    $data = $this->session->all_userdata();

    $data_post = $this->input->post();

    if($data_post!=null) {
      $this->session->set_flashdata($this->_flash_post,$data_post);
      if (isset($data_post['add'])){
        $this->checkValidationForm(); // Check Validation
        if ($this->form_validation->run() == TRUE) {
          if($data['role'] == 1){
            redirect('departmentMaster/addMasterRole');
          } elseif($data['role'] == 2) {
            redirect('departmentMaster/add');
          }
        }
      }
      else if (isset($data_post['remove']))
        redirect('departmentMaster/remove');
      else if (isset($data_post['renew']))
        redirect('departmentMaster/renew');
    }

    // Get data from Database
    $list_department = $this->Mdepartment->getListDepartmentFromCompany($data['id']);
    $list_department_master = $this->Mdepartment->getListDepartmentFromCompanyMaster();
    $list_company = $this->Mcompany->getListCompanyFromMaster($data['id']);
    $new_register_id = addZeroToNumber (getLastRegisterId($list_department_master) + 1);

    $this->_data['new_register_id'] = $new_register_id;
    $this->_data['list_department'] = $list_department;
    $this->_data['list_department_master'] = $list_department_master;
    $this->_data['list_company'] = $list_company;
    $this->_data['permission'] = $data['permission_level'];
    $this->_data['name'] = $data['name'];
    $this->_data['role'] = $data['role'];
    $this->load->view('/master/department_master.php', $this->_data);
  }

  public function add () {
    $this->load->model("Mdepartment");
    $this->load->model("Mcompany");
    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();

    $master_id = $dataUser['login_id'];
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['delete']) ? 0 : 1;

    $data_insert = array(
      "register_id" => $data['register_id'],
      "name" => $data['name'],
      "phonetic" => $data['phonetic'],
      "created_date" => $datetime,
      "updated_date" => $datetime,
      "company_master_id" => $dataUser['id'],
      "invisible" => $data['view'],
      "available" => $available
    );
    $this->Mdepartment->insertDepartment($data_insert);
    $this->session->set_flashdata($this->_flash_mess, "Added");
    redirect('departmentmaster');
  }

  public function addMasterRole () {
    $this->load->model("Mdepartment");
    $this->load->model("Mcompany");
    $data = $this->session->flashdata($this->_flash_post);
    $company = isset($data['company_master_id']) ? $data['company_master_id'] : 'none';
    $datetime = date('Y-m-d H:i:s');
    $available = isset($data['delete']) ? 0 : 1;

    $data_insert = array(
      "register_id" => $data['register_id'],
      "name" => $data['name'],
      "phonetic" => $data['phonetic'],
      "created_date" => $datetime,
      "updated_date" => $datetime,
      "company_master_id" => $company,
      "invisible" => $data['view'],
      "available" => $available
    );
    $this->Mdepartment->insertDepartment($data_insert);
    $this->session->set_flashdata($this->_flash_mess, "Added");
    redirect('departmentmaster');
  }

  public function ajax_update_department_master () {
    $this->load->model("Mdepartment");

    $data = $this->input->post();
    $dataUser = $this->session->all_userdata();
    $datetime = date('Y-m-d H:i:s');
    $company = isset($data['company_master_id']) ? $data['company_master_id'] : 'none';
    $id = $data['id'];
    $available = isset($data['available']) ? 0 : 1;
    $data_update = array(
      "name" => $data['name'],
      "phonetic" => $data['phonetic'],
      "updated_date" => $datetime,
      "company_master_id" => $company,
      "invisible" => $data['view'],
      "available" => $available
    );
    $this->Mdepartment->ajax_update_department_master_model($id,$data_update);
  }

  public function ajax_update_department_company () {
    $this->load->model("Mdepartment");

    $data = $this->input->post();
    $dataUser = $this->session->all_userdata();
    $datetime = date('Y-m-d H:i:s');
    $company = isset($data['company_master_id']) ? $data['company_master_id'] : 'none';
    $id = $data['id'];
    $available = isset($data['available']) ? 0 : 1;
    $data_update = array(
      "name" => $data['name'],
      "phonetic" => $data['phonetic'],
      "updated_date" => $datetime,
      "company_master_id" => $dataUser['id'],
      "invisible" => $data['view'],
      "available" => $available
    );
    $this->Mdepartment->ajax_update_department_company_model($id,$data_update);
  }

  public function remove () {
    $this->load->model("Mdepartment");

    $dataUser = $this->session->all_userdata();
    // Get data from Database
    $list_product = $this->Mdepartment->getListDepartmentFromCompany($dataUser['company_id']);

    $last_item = end ($list_product);
    if ($this->Mdepartment->turnRemove ($last_item['id'])){
        redirect('departmentmaster');
    } else {
      echo 'error';
    }
  }

  private function checkValidationForm (){
    $this->form_validation->set_rules("name", "部署名", "required|xss_clean|trim",
                                      array('required' => '「部署名」に入力してください。'));
  }

  public function renew () {
    redirect('departmentmaster');
  }
}

?>
