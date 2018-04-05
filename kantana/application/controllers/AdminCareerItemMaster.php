<?php
class AdminCareerItemMaster extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
    $this->load->helper("url");
  }

  public function index(){
    $this->load->model("Madmincareer");
    $this->load->model("Madmincareerdescription");
    $this->load->model("Madmincareerrequirement");
    // Flash Message
    $this->_data['mess'] = $this->session->flashdata($this->_flash_mess);
    // Validate Input Rule

    $idCipher =  $this->input->get('id');

    $isUpdate = 0;
    $id = 0;
    if ($idCipher!=null) {
      $id = decrypted($idCipher);
      $this->session->set_userdata('update', 1);
      $this->session->set_userdata('updateId', $id);
      $isUpdate = 1;
    }
    else {
      $this->session->unset_userdata('update');
    }
    $data_post = $this->input->post();

    if($data_post!=null) {
      $this->session->set_flashdata($this->_flash_post,$data_post);
      if (isset($data_post['add'])){
        // $this->checkValidationForm(); // Check Validation
        if ($this->form_validation->run() == TRUE) {
          // redirect('admincareeritem/add');
        }
      }
      if ($isUpdate == 0) {
        redirect('adminCareerItemMaster/add');
      } else {
        redirect('adminCareerItemMaster/update');
      }
      // else if (isset($data_post['remove']))
      //   redirect('departmentMaster/remove');
      // else if (isset($data_post['renew']))
      //   redirect('departmentMaster/renew');
    }

    if ($isUpdate == 1) {
      $career = $this->Madmincareer->getCareerAtId($id);
      $description = $this->Madmincareerdescription->getCareerDescriptionAtCareerId($id);
      $requirement = $this->Madmincareerrequirement->getCareerRequirementAtCareerId($id);
      $this->_data['career'] = $career[0];
      $this->_data['description'] = $description;
      $this->_data['requirement'] = $requirement;
    }

    $this->load->view('/admin/career_item.php', $this->_data);
  }

  public function add () {
    $this->load->model("Madmincareer");
    $this->load->model("Madmincareerdescription");
    $this->load->model("Madmincareerrequirement");

    $data = $this->session->flashdata($this->_flash_post);

    $currentDate = date('Y-m-d');
    $startDate = date("Y-m-d", strtotime($data['start_date']));
    $endtDate = date("Y-m-d", strtotime($data['end_date']));
    $active = isset($data['active']) ? $data['active'] : 0;

    $data_insert = array(
      "title" => $data['title'],
      "type" => $data['optionTypeCareer'],
      "location" => $data['location'],
      "salary_min" => $data['min_salary'],
      "salary_max" => $data['max_salary'],
      "start_date" => $startDate,
      "close_date" => $endtDate,
      "created_date" => $currentDate,
      "updated_date" => $currentDate,
      "active" => $active,
      "delete" => 0
    );

    // print("<pre>".print_r($data_insert,true)."</pre>");

    $this->Madmincareer->insertNewCareer($data_insert);

    $maxId = $this->Madmincareer->selectMaxIdCareer()[0];

    $this->addJobDescription($maxId['id'], $data);
    $this->addJobRequirement($maxId['id'], $data);

    $this->session->set_flashdata($this->_flash_mess, "New Career Added!");

    redirect('admincareer');
  }

  public function update () {
    $this->load->model("Madmincareer");
    $this->load->model("Madmincareerdescription");
    $this->load->model("Madmincareerrequirement");

    $data = $this->session->flashdata($this->_flash_post);
    $updateId = $this->session->userdata("updateId");

    $currentDate = date('Y-m-d');
    $startDate = date("Y-m-d", strtotime($data['start_date']));
    $endtDate = date("Y-m-d", strtotime($data['end_date']));
    $active = isset($data['active']) ? $data['active'] : 0;

    $data_insert = array(
      "title" => $data['title'],
      "type" => $data['optionTypeCareer'],
      "location" => $data['location'],
      "salary_min" => $data['min_salary'],
      "salary_max" => $data['max_salary'],
      "start_date" => $startDate,
      "close_date" => $endtDate,
      "updated_date" => $currentDate,
      "active" => $active,
      "delete" => 0
    );

    $this->Madmincareer->updateCareerInfo($updateId, $data_insert);

    $this->Madmincareerdescription->removeDescriptionDataAtCareerId($updateId);
    $this->Madmincareerrequirement->removeRequirementDataAtCareerId($updateId);

    $this->addJobDescription($updateId, $data);
    $this->addJobRequirement($updateId, $data);

    $this->session->set_flashdata($this->_flash_mess, "Career Updated!");

    redirect('admincareer');
  }

  public function remove () {
    $this->load->model("Madmincareer");
    $this->load->model("Madmincareerdescription");
    $this->load->model("Madmincareerrequirement");

    $idCipher =  $this->input->get('id');
    $id = decrypted($idCipher);

    $this->Madmincareerdescription->removeDescriptionDataAtCareerId($id);
    $this->Madmincareerrequirement->removeRequirementDataAtCareerId($id);
    $this->Madmincareer->removeCareerAtId($id);

    redirect('admincareer');
  }

  // Add List DESCRIPTION
  private function addJobDescription ($maxId, $postData) {
    $countDe = $postData['deCount'];
    $currentDate = date('Y-m-d');

    $data_insert = array ();
    for ($i = 0; $i < $countDe; $i++) {
      $param = 'description_item_'.$i;
      $data_line = array(
        "career_id" => $maxId,
        "content" => $postData[$param],
        "created_date" => $currentDate
      );
      array_push ($data_insert, $data_line);
    }

    $this->Madmincareerdescription->insertListCareerDescription($data_insert);
  }


  // Add List REQUIREMENT
  private function addJobRequirement ($maxId, $postData) {
    $countDe = $postData['reCount'];
    $currentDate = date('Y-m-d');

    $data_insert = array ();
    for ($i = 0; $i < $countDe; $i++) {
      $param = 'requirement_item_'.$i;
      $data_line = array(
        "career_id" => $maxId,
        "content" => $postData[$param],
        "created_date" => $currentDate
      );
      array_push ($data_insert, $data_line);
    }

    $this->Madmincareerrequirement->insertListCareerRequirement($data_insert);
  }

}
?>
