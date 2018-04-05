<?php
class MY_Controller extends CI_Controller
{
  public function __construct(){
    parent::__construct();
    $this->is_logged_in ();
  }

  public function is_logged_in(){
    // $user = $this->session->userdata('permission_level');
    // if(isset($user)) {
    //
    // }
    // else {
    //   redirect ('/');
    // }
  }
}
?>
