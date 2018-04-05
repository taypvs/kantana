<?php
class AdminCareerApplicationMaster extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
    $this->load->helper("url");
  }

  public function index(){
    $this->load->model("Madmincareerapplication");
    // echo "print : " . encrypted("kantana"); // Encrypt password
    // Flash Message
    $this->_data['mess'] = $this->session->flashdata($this->_flash_mess);
    // Validate Input Rule

    $this->_data['list_application'] = $this->Madmincareerapplication->getlistApplication();
    $this->load->view('/admin/application_list.php', $this->_data);
  }

  public function view () {
    $this->load->model("Madmincareerapplication");

    $idCipher =  $this->input->get('id');

    $id = 0;
    if ($idCipher!=null) {
      $id = decrypted($idCipher);
    }

    $application = $this->Madmincareerapplication->getApplicationAtId($id);
    $this->_data['application'] = $application[0];

    $this->load->view('/admin/application_item.php', $this->_data);
  }


}
?>
