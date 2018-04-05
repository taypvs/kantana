<?php
class Dashboard extends MY_Controller {
  public function __construct(){
    parent::__construct();
  }

  public function index()
	{
    $year = date("Y");
    $month = date("m");
    $date = date("Y-m-d");
    $this->load->model("Mestcost");
    $this->load->model("Msale");
    $data = $this->session->all_userdata();
    $this->_data['name'] = $data['name'];
    $this->_data['permission_level'] = $data['permission_level'];

    //
    $sumEstTotalCostCurrentMonth = $this->Mestcost->getSumEstTotalCostCurrentMonth($year, $month);
    $sumEstTotalCostLastMonth = $this->Mestcost->getSumEstTotalCostLastMonth($year, getLastMonth($date));
    $maxCostCurrentMonth = $this->Mestcost->getMaxCostCurrentMonth($year, $month);
    $minCostCurrentMonth = $this->Mestcost->getMinCostCurrentMonth($year, $month);
    $countItem = $this->Mestcost->countItem($year, $month);
    $this->_data['sumEstTotalCostCurrentMonth'] = $sumEstTotalCostCurrentMonth;
    $this->_data['sumEstTotalCostLastMonth'] = $sumEstTotalCostLastMonth;
    $this->_data['maxCostCurrentMonth'] = $maxCostCurrentMonth;
    $this->_data['minCostCurrentMonth'] = $minCostCurrentMonth;
    $this->_data['countItem'] = $countItem;

    //
    $sumSaleCostCurrentMonth = $this->Msale->getSumSaleCostCurrentMonth($year, $month);
    $sumSaleCostLastMonth = $this->Msale->getSumSaleCostLastMonth($year, getLastMonth($date));
    $maxSaleCostCurrentMonth = $this->Msale->getMaxSaleCostCurrentMonth($year, $month);
    $minSaleCostCurrentMonth = $this->Msale->getMinSaleCostCurrentMonth($year, $month);
    $countSaleItem = $this->Msale->countSaleItem($year, $month);
    $this->_data['sumSaleCostCurrentMonth'] = $sumSaleCostCurrentMonth;
    $this->_data['sumSaleCostLastMonth'] = $sumSaleCostLastMonth;
    $this->_data['maxSaleCostCurrentMonth'] = $maxSaleCostCurrentMonth;
    $this->_data['minSaleCostCurrentMonth'] = $minSaleCostCurrentMonth;
    $this->_data['countSaleItem'] = $countSaleItem;
		$this->load->view('dashboard.php', $this->_data);
	}
}
