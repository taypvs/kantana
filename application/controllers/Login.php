<?php
class Login extends CI_Controller{
  protected $_flash_mess = "flash_mess";
  public function __construct(){
    parent::__construct();
    if($this->session->userdata('name')){
      redirect('dashboard');
    }
  }

  public function index(){
    // Flash Message
    $this->_data['mess'] = $this->session->flashdata($this->_flash_mess);
    // Validate Input Rule
    $this->form_validation->set_rules("login_id", "ユーザーID", "required|xss_clean|trim");
    $this->form_validation->set_rules("login_pass", "パスワード", "required|xss_clean|trim");

    if ($this->form_validation->run() == TRUE) {
      // Load Model
      $this->load->model("Memployee");
      $this->load->model("Mmaster");
      $this->load->model("Mcompany");
      // Get Post Data
      $login_id = $this->input->post("login_id");
      $login_pass = $this->input->post("login_pass");
      $login_pass_decode = md5(md5(sha1($login_pass)));
      if ($this->Mmaster->checkMaster($login_id, $login_pass_decode) == TRUE) {    // Check If Company Account
        $data = $this->getDataLogin(1, $login_id);
        $this->loginSucessRedirect ($data); // Login with master
      } else {                                                                        // If Not Master Account
        if ($this->Mcompany->checkCompany($login_id, $login_pass_decode) == TRUE) {    // Check If Company Account
          $data = $this->getDataLogin(2, $login_id);
          $this->loginSucessRedirect ($data); // Login with company
        } else {                                                                        // If Not Company Account
          if ($this->Memployee->checkUser($login_id, $login_pass_decode) == TRUE) {    // Check If Employee Account
            $data = $this->getDataLogin(3, $login_id);
            $this->loginSucessRedirect ($data); // // Login with employee
          } else {
            $this->session->set_flashdata($this->_flash_mess, "User does not exist");
            //redirect ("/");
            // echo "login not sucess";
            //var_dump($login_pass_decode);
          }
        }
      }
    }
    $this->load->view('login.php', $this->_data);
  }

  private function getDataLogin ($user, $login_id) {
    // user == 1 : Master
    // user == 2 : Company
    // user == 3 : Employee
    $data;
    if ($user==1) {
      $master_info = $this->Mmaster->getMaster($login_id)[0];
      $data=array(
        "name" => $master_info['name'],
        "login_id" => $master_info['login_id'],
        "id" => $master_info['id'],
        "role" => $master_info['role'],
        "permission_level" => 1
      );
    } else if ($user==2) {
      $company_info = $this->Mcompany->getCompany($login_id)[0];
      $data=array(
        "name" => $company_info['name'],
        "login_id" => $company_info['management_id'],
        "id" => $company_info['id'],
        "company_id" => $company_info['id'],
        "role" => $company_info['role'],
        "permission_level" => 2
      );
    } else {
      $employee_info = $this->Memployee->getEmployee($login_id)[0];
      $data=array(
        "name" => $employee_info['name'],
        "login_id" => $employee_info['login_id'],
        "id" => $employee_info['id'],
        "company_id" => $employee_info['company_id'],
        "role" => $employee_info['role'],
        "permission_level" => 3
      );
      $this->session->set_userdata('permission_level',3);
    }
    return $data;
  }

  private function loginSucessRedirect ($data) {
    $this->load->model("Mestcostdetail");

    // Init Cost Items Default
    if($data['permission_level']>1){
      // if (!$this->Mestcostdetail->hasDefaultItem ($data['company_id']))
        // $this->generateEmptyDefaulItem ($data['company_id']);

        $this->session->set_userdata($data);
        redirect ("/dashboard");
    }
    else {
      $this->session->set_userdata($data);
      redirect ("/companymaster");
    }
  }
  private function generateEmptyDefaulItem ($company_id) {
    $this->load->model("Mestcostdetail");
    $data = array ();
    for ($i = 1; $i <=10; $i++){
      $data_insert = array(
        "line_number" => $i,
        "note" => '',
        "cost_per_item" => '',
        "quantity" => '',
        "unit" => '',
        "cost_total" => '',
        "multiplication_factor" => '',
        "price_per_item" => '',
        "price_total" => '',
        "customer_id" => '',
        "product_id" => '',
        "company_id" => $company_id
      );
      array_push ($data, $data_insert);
    }
    $this->Mestcostdetail->inserMultiItem($data);
  }
}
 ?>
