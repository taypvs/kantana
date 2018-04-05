<?php
class SaleResult extends MY_Controller{
  protected $_flash_mess = "flash_mess";
  protected $_flash_post = "_flash_post";
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->model("Mestcostdetail");
    $this->load->model("Mproduct");
    $this->load->model("Mcustomer");
    $this->load->model("Memployee");
    $this->load->model("Mdepartment");

    // Flash Message
    $this->_data['mess'] = $this->session->flashdata($this->_flash_mess);
    $data = $this->session->all_userdata();

    // Get Item from database
    // $list_cost_item = $this->Mestcostdetail->getListCostItemFromCompany($data['company_id']);
    $list_product = $this->Mproduct->getListProductFromCompany($data['id']);
    $list_employee = $this->Memployee->getListEmployeeFromCompany($data['id']);
    $list_customer_ag = $this->Mcustomer->getListAgencyFromCompany($data['id']);
    $list_customer_na = $this->Mcustomer->getListNotAgencyFromCompany($data['id']);
    $list_department = $this->Mdepartment->getListDepartmentFromCompany($data['id']);

    $list_product_master = $this->Mproduct->getListProductFromCompanyMaster();
    $list_employee_master = $this->Memployee->getListEmployeeFromCompanyMaster();
    $list_customer_ag_master = $this->Mcustomer->getListAgencyFromCompanyMaster();
    $list_customer_na_master = $this->Mcustomer->getListNotAgencyFromCompanyMaster();
    $list_department_master = $this->Mdepartment->getListDepartmentFromCompanyMaster();

    // Set Data to View
    $this->_data['name'] = $data['name'];
    $this->_data['role'] = $data['role'];
    // $this->_data['list_cost_item'] = $list_cost_item;
    $this->_data['list_product_master'] = $list_product_master;
    $this->_data['list_employee_master'] = $list_employee_master;
    $this->_data['list_customer_ag_master'] = $list_customer_ag_master;
    $this->_data['list_customer_na_master'] = $list_customer_na_master;
    $this->_data['list_department_master'] = $list_department_master;

    $this->_data['list_product'] = $list_product;
    $this->_data['list_employee'] = $list_employee;
    $this->_data['list_customer'] = $list_customer_ag;
    $this->_data['list_customer_na'] = $list_customer_na;
    $this->_data['list_department'] = $list_department;
    $this->load->view('/price/sale_result.php', $this->_data);
  }

  public function filterFull(){
    header('Content-Type: application/json');
    header('Content-Type: text/html');
    $this->load->model("MSaleResult");
    $fromdate = $this->input->get('fromdate');
    $todate = $this->input->get('todate');
    $project_title = $this->input->get('project_title');
    $employee_id = $this->input->get('employee_id');
    $customer_id = $this->input->get('customer_id');
    $department_id = $this->input->get('department_id');
    $agency_id = $this->input->get('agency_id');
    $result = $this->MSaleResult->getFullInfoSale($fromdate, $todate, $project_title, $employee_id, $customer_id, $department_id, $agency_id);
    $json = json_encode($result, JSON_PRETTY_PRINT);
    $fetch_data = json_decode($json,true);
    if (is_array($fetch_data) || is_object($fetch_data) || $fetch_data !== null){
      foreach ($fetch_data as $value) {
        $difference = $value['total_selling_price'] - $value['sale_est_diff'];
        echo '
          <tr>
            <td>'.addZeroToNumber($value['sale_cus_cost_id']).'</td>
            <td>'.$value['project_title'].'</td>
            <td>'.$value['cus_name'].'<br>'.$value['agency_name'].'</td>
            <td>'.$value['emp_name'].'<br>'.$value['dep_name'].'</td>
            <td> ￥'.number_format($value['total_selling_price']).'</td>
            <td> ￥'.number_format($value['sale_est_diff']).'</td>';
            if($difference < 0){
              echo '<td style="color:red" class="table03-6"> ￥'.number_format($difference).'</td>';
            }else{
              echo '<td> ￥'.number_format($difference).'</td>';
            }
            echo '
            <td>'.$value['created_date'].'</td>
          </tr>
          ';
      }
      echo '<script>$(function(){$("div.holder").jPages({containerID:"page",perPage:20,startPage:1,startRange:1,midRange:5,endRange:1})})</script>

    ';
    } else {
      echo '<script>$( "#dialog-message" ).dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });</script>
    <div id="dialog-message" title="すみません！">デタがありません。</div>';
    }
  }


}
 ?>
