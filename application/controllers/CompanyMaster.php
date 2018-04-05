<?php
class CompanyMaster extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
    $this->load->helper("url");
  }

  public function index(){
    $this->load->model("Mcompany");
    $this->load->model("Mcustomer");

    $data_post = $this->input->post();
    $filter = $this->input->post('filter');
    if($data_post!=null) {
      $this->session->set_flashdata($this->_flash_post,$data_post);
      if (isset($data_post['add'])){
        $this->checkValidationForm(); // Check Validation
        if ($this->form_validation->run() == TRUE) {
          redirect('companyMaster/add');
        }
      }
      else if (isset($data_post['remove']))
        redirect('companyMaster/remove');
      else if (isset($data_post['renew']))
        redirect('companyMaster/renew');
    }

    $data = $this->session->all_userdata();
    $this->_data['name'] = $data['name'];
    // Flash Message
    $this->_data['mess'] = $this->session->flashdata($this->_flash_mess);

    $this->_data['list_company'] = $this->Mcompany->getListCompanyFromMaster($data['id']);
    $this->_data['list_company_w_multiplication'] = $this->Mcompany->getListCompanyFromMaster2($data['id']);
    $this->load->view('/master/company_master.php', $this->_data);

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
    $this->form_validation->set_rules("name", "企業名", "required|xss_clean|trim",
                                      array('required' => '「企業名」に入力してください。'));
    $this->form_validation->set_rules("company_id", "企業管理用ID", "required|xss_clean|trim",
                                      array('required' => '「企業管理用ID」に入力してください。'));
    $this->form_validation->set_rules("password", "パスワド", "required|trim|xss_clean",
                                      array('required' => '「パスワド」に入力してください。'));
    $this->form_validation->set_rules("postal_code", "郵便番号", "required|trim|xss_clean",
                                      array('required' => '「郵便番号」に入力してください。'));
    $this->form_validation->set_rules("address_1", "住所1", "required|trim|xss_clean",
                                      array('required' => '「住所1」に入力してください。'));
    $this->form_validation->set_rules("phone_number", "電話番号", "required|trim|xss_clean",
                                      array('required' => '「電話番号」に入力してください。'));
    $this->form_validation->set_rules("fax_number", "FAX番号", "required|trim|xss_clean",
                                      array('required' => '「FAX番号」に入力してください。'));
    $this->form_validation->set_rules("mail", "メールアドレス", "required|trim|xss_clean|valid_email",
                                      array('required' => '「メールアドレス」に入力してください。'));
    $this->form_validation->set_rules("multiplication", "初期掛け率", "required|trim|xss_clean|numeric",
                                      array('required' => '「初期掛け率」に入力してください。'));
  }

  public function close(){
    redirect('dashboard');
  }


}
?>
