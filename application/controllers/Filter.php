<?php
class Filter extends MY_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->helper("url");
  }

  public function index(){
    redirect('/filter/date', 'location');
  }

  public function date()
	{
    $year = date("Y");
    $month = date("m");
    $date = date("Y-m-d");
    $fromdate = formatDate($this->input->get('fromdate'));
    $todate = formatDate($this->input->get('todate'));
    $data_post = $this->input->get();

    $data = $this->session->all_userdata();
    $this->_data['name'] = $data['name'];
    $this->_data['permission_level'] = $data['permission_level'];
		$this->load->view('filter/date.php', $this->_data);
	}

  public function filterByDate(){
    header('Content-Type: application/json');
    header('Content-Type: text/html');
    $this->load->model("Mfilter");
    $fromdate = $this->input->get('fromdate');
    $todate = $this->input->get('todate');
    $result = $this->Mfilter->getInfoByDate($fromdate,$todate);
    $json = json_encode($result);
    $fetch_data = json_decode($json,true);
      if (is_array($fetch_data) || is_object($fetch_data)){
  			foreach ($fetch_data as $value) {
          $difference = $value['total_selling_price'] - $value['sale_est_diff'];
          echo '
            <tr>
              <td>'.$value['created_date'].'</td>
              <td> ￥'.number_format($value['total_selling_price']).'</td>
              <td> ￥'.number_format($value['sale_est_diff']).'</td>';
              if($difference < 0){
                echo '<td style="color:red"> ￥'.number_format($difference).'</td>';
              }else{
                echo '<td> ￥'.number_format($difference).'</td>';
              }
              echo '<td> ￥'.number_format($value['gross_profit']).'</td>
              <td> ￥'.number_format($value['max_selling_cost']).'</td>
              <td> ￥'.number_format($value['min_selling_cost']).'</td>
            </tr>
          ';
  			}
      }
  }

  public function name()
	{
    $year = date("Y");
    $month = date("m");
    $date = date("Y-m-d");
    $fromdate = formatDate($this->input->get('fromdate'));
    $todate = formatDate($this->input->get('todate'));
    $data = $this->session->all_userdata();
    $this->_data['name'] = $data['name'];
    $this->_data['permission_level'] = $data['permission_level'];
		$this->load->view('filter/name.php', $this->_data);
	}

  public function filterByName(){
    header('Content-Type: application/json');
    header('Content-Type: text/html');
    $this->load->model("Mfilter");
    $fromdate = $this->input->get('fromdate');
    $todate = $this->input->get('todate');
    $result = $this->Mfilter->getInfoByName($fromdate,$todate);
    $json = json_encode($result, JSON_PRETTY_PRINT);
    $fetch_data = json_decode($json,true);
      if (is_array($fetch_data) || is_object($fetch_data)){
  			foreach ($fetch_data as $value) {
          $difference = $value['total_selling_price'] - $value['sale_est_diff'];
          echo '
            <tr>
              <td>'.$value['name'].'</td>
              <td> ￥'.number_format($value['total_selling_price']).'</td>
              <td> ￥'.number_format($value['sale_est_diff']).'</td>';
              if($difference < 0){
                echo '<td style="color:red"> ￥'.number_format($difference).'</td>';
              }else{
                echo '<td> ￥'.number_format($difference).'</td>';
              }
              echo '<td> ￥'.number_format($value['gross_profit']).'</td>
              <td> ￥'.number_format($value['max_selling_cost']).'</td>
              <td> ￥'.number_format($value['min_selling_cost']).'</td>
            </tr>
          ';
  			}
      }
  }

  public function project()
	{
    $year = date("Y");
    $month = date("m");
    $date = date("Y-m-d");
    $fromdate = formatDate($this->input->get('fromdate'));
    $todate = formatDate($this->input->get('todate'));
    $data = $this->session->all_userdata();
    $this->_data['name'] = $data['name'];
    $this->_data['permission_level'] = $data['permission_level'];
		$this->load->view('filter/project.php', $this->_data);
	}
  public function filterByProject(){
    header('Content-Type: application/json');
    header('Content-Type: text/html');
    $this->load->model("Mfilter");
    $fromdate = $this->input->get('fromdate');
    $todate = $this->input->get('todate');
    $result = $this->Mfilter->getInfoByProject($fromdate,$todate);
    $json = json_encode($result);
    $fetch_data = json_decode($json,true);
      if (is_array($fetch_data) || is_object($fetch_data)){
  			foreach ($fetch_data as $value) {
          $difference = $value['total_selling_price'] - $value['sale_est_diff'];
          echo '
            <tr>
              <td>'.$value['project_title'].'</td>
              <td> ￥'.number_format($value['total_selling_price']).'</td>
              <td> ￥'.number_format($value['sale_est_diff']).'</td>';
              if($difference < 0){
                echo '<td style="color:red"> ￥'.number_format($difference).'</td>';
              }else{
                echo '<td> ￥'.number_format($difference).'</td>';
              }
              echo '<td> ￥'.number_format($value['gross_profit']).'</td>
              <td> ￥'.number_format($value['max_selling_cost']).'</td>
              <td> ￥'.number_format($value['min_selling_cost']).'</td>
            </tr>
          ';
  			}
      }
  }

  public function department()
	{
    $year = date("Y");
    $month = date("m");
    $date = date("Y-m-d");
    $fromdate = formatDate($this->input->get('fromdate'));
    $todate = formatDate($this->input->get('todate'));
    $data = $this->session->all_userdata();
    $this->_data['name'] = $data['name'];
    $this->_data['permission_level'] = $data['permission_level'];
		$this->load->view('filter/department.php', $this->_data);
	}

  public function filterByDepartment(){
    header('Content-Type: application/json');
    header('Content-Type: text/html');
    $this->load->model("Mfilter");
    $fromdate = $this->input->get('fromdate');
    $todate = $this->input->get('todate');
    $result = $this->Mfilter->getInfoByDepartment($fromdate,$todate);
    $json = json_encode($result, JSON_PRETTY_PRINT);
    $fetch_data = json_decode($json,true);
      if (is_array($fetch_data) || is_object($fetch_data)){
  			foreach ($fetch_data as $value) {
          $difference = $value['total_selling_price'] - $value['sale_est_diff'];
          echo '
            <tr>
              <td>'.$value['name'].'</td>
              <td> ￥'.number_format($value['total_selling_price']).'</td>
              <td> ￥'.number_format($value['sale_est_diff']).'</td>';
              if($difference < 0){
                echo '<td style="color:red"> ￥'.number_format($difference).'</td>';
              }else{
                echo '<td> ￥'.number_format($difference).'</td>';
              }
              echo '<td> ￥'.number_format($value['gross_profit']).'</td>
              <td> ￥'.number_format($value['max_selling_cost']).'</td>
              <td> ￥'.number_format($value['min_selling_cost']).'</td>
            </tr>
          ';
  			}
      }
  }

  public function customer()
	{
    $year = date("Y");
    $month = date("m");
    $date = date("Y-m-d");
    $fromdate = formatDate($this->input->get('fromdate'));
    $todate = formatDate($this->input->get('todate'));
    $agency = $this->input->get('agency');
    $data = $this->session->all_userdata();
    $this->_data['name'] = $data['name'];
    $this->_data['permission_level'] = $data['permission_level'];
		$this->load->view('filter/customer.php', $this->_data);
	}
  public function filterByCustomer(){
    header('Content-Type: application/json');
    header('Content-Type: text/html');
    $this->load->model("Mfilter");
    $fromdate = $this->input->get('fromdate');
    $todate = $this->input->get('todate');
    $agency = $this->input->get('agency');
    $result = $this->Mfilter->getInfoByCustomer($fromdate,$todate,$agency);
    $json = json_encode($result, JSON_PRETTY_PRINT);
    $fetch_data = json_decode($json,true);
      if (is_array($fetch_data) || is_object($fetch_data)){
  			foreach ($fetch_data as $value) {
          $difference = $value['total_selling_price'] - $value['sale_est_diff'];
          echo '
            <tr>
              <td>'.$value['name'].'</td>
              <td> ￥'.number_format($value['total_selling_price']).'</td>
              <td> ￥'.number_format($value['sale_est_diff']).'</td>';
              if($difference < 0){
                echo '<td style="color:red"> ￥'.number_format($difference).'</td>';
              }else{
                echo '<td> ￥'.number_format($difference).'</td>';
              }
              echo '<td> ￥'.number_format($value['gross_profit']).'</td>
              <td> ￥'.number_format($value['max_selling_cost']).'</td>
              <td> ￥'.number_format($value['min_selling_cost']).'</td>
            </tr>
          ';
  			}
      }
  }
}
