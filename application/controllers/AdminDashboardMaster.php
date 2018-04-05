<?php
class AdminDashboardMaster extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
    $this->load->helper("url");
  }

  public function index(){
    $this->load->model("MadminLogin");
    // echo "print : " . encrypted("kantana"); // Encrypt password
    // Flash Message
    $this->_data['mess'] = $this->session->flashdata($this->_flash_mess);
    // Validate Input Rule

    $data_post = $this->input->post();
    if($data_post!=null) {
      $this->checkValidationForm(); // Check Validation
      if ($this->form_validation->run() == TRUE) {

        // Post data
        $login_id = $this->input->post("login_id");
        $login_pass = $this->input->post("login_pass");

        $result = $this->MadminLogin->getInfoAdmin($login_id);

        if ($result == null) {
          $this->session->set_flashdata($this->_flash_mess, "Sai tài khoản hoặc mật khẩu đăng nhập!");
          redirect('adminlogin');
        } else  {
          $adInfo = $result[0];
          $login_pass_decode = decrypted($adInfo['password']);
          if ($login_pass == $login_pass_decode){
            $this->session->set_flashdata($this->_flash_mess, "Sai tài khoản hoặc mật khẩu đăng nhập!");
            redirect('adminlogin');
          } else {
            redirect('admindashboard');
          }
        }

      }
    }
    $this->load->view('/admin/index.php', $this->_data);
  }

  public function add () {
    $this->load->model("Mcompany");

    $data = $this->session->flashdata($this->_flash_post);
    $dataUser = $this->session->all_userdata();

    $master_id = $dataUser['id'];
    $datetime = date('Y-m-d H:i:s');
    $login_pass_decode = md5(md5(sha1($data['password'])));
    $company_id = $data['management_id'];

    $data_insert = array(
      "management_id" => $company_id,
      "name" => $data['name'],
      "Phonetic" => $data['name_phonetic'],
      "password" => $login_pass_decode,
      "postal_code" => $data['postal_code'],
      "address_1" => $data['address_1'],
      "address_2" => $data['address_2'],
      "phone_number" => $data['phone_number'],
      "fax_number" => $data['fax_number'],
      "mail_address" => $data['mail'],
      "multiplication_factor_init" => $data['multiplication'],
      "created_date" => $datetime,
      "updated_date" => $datetime,
      "available" => 1,
      "master_id" => $master_id,
      "role" => 2,
      "invisible" => 1,
    );
    $this->Mcompany->insertCompany($data_insert);
    $this->session->set_flashdata($this->_flash_mess, "Added");
    redirect('companymaster');
  }

  public function ajax_update_company () {
    $this->load->model("Mcompany");

    $data = $this->input->post();
    $dataUser = $this->session->all_userdata();
    $datetime = date('Y-m-d H:i:s');
    $id = $data['id'];
    $data_update = array(
      "management_id" => $data['management_id'],
      "name" => $data['name'],
      "Phonetic" => $data['name_phonetic'],
      "postal_code" => $data['postal_code'],
      "address_1" => $data['address_1'],
      "address_2" => $data['address_2'],
      "phone_number" => $data['phone_number'],
      "fax_number" => $data['fax_number'],
      "mail_address" => $data['mail'],
      "multiplication_factor_init" => $data['multiplication'],
      "updated_date" => $datetime,
    );
    $this->Mcompany->ajax_update_company_model($id,$data_update);
  }

  public function remove () {
    $this->load->model("Mcompany");

    $dataUser = $this->session->all_userdata();
    // Get data from Database
    $list_company = $this->Mcompany->getListCompanyFromMaster($dataUser['id']);

    $last_item = end ($list_company);
    if ($this->Mcompany->turnRemove ($last_item['id'])){
        redirect('companymaster');
    } else {
      echo 'error';
    }
  }

  public function renew () {
    redirect('companymaster');
  }

  private function checkValidationForm (){
    $this->form_validation->set_rules("login_id", "login_id", "required|xss_clean|trim");
    $this->form_validation->set_rules("login_pass", "login_pass", "required|xss_clean|trim");
  }

  public function close(){
    redirect('dashboard');
  }


}
?>
