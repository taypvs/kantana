<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
  }

  function index()
  {
    $user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            if ($key != 'id' && $key != 'login_id' && $key != 'password' && $key != 'name') {
                $this->session->unset_userdata($key);
            }
        }
    $this->session->sess_destroy();
    redirect('/');
  }

}
