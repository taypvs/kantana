<?php
class AdminCareerApplicationItemMaster extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
    $this->load->helper("url");
  }

  public function index(){
    $this->load->model("Madmincareerapplication");

    // Flash Message
    $this->_data['mess'] = $this->session->flashdata($this->_flash_mess);

    $idCipher =  $this->input->get('id');

    $isUpdate = 0;
    $id = 0;
    if ($idCipher!=null) {
      $id = decrypted($idCipher);
    }

    $this->_data['application'] = $this->Madmincareerapplication->getApplicationAtId($id)[0];
    $this->load->view('/admin/application_item.php', $this->_data);
  }

  public function download () {
    $this->load->model("Madmincareerapplication");

    $fileCipher =  $this->input->get('id');
    $file = '';
    $id = 0;
    if ($fileCipher!=null) {
      $file = decrypted($fileCipher);
    }
    echo base_url('/application/files/cv/'.$file);
    $this->load->helper('download');
    // ob_clean();

    $downloadFile = $_SERVER['DOCUMENT_ROOT'] . '/files/cv/'.$file;
    force_download($downloadFile, NULL);

    // $this->load->view('/admin/application_item.php', $this->_data);
  }


}
?>
