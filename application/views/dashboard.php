<!DOCTYPE html>
<html lang="ja">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width" />
<meta name="keywords" content="" />
<meta name="description" content="" />

<title>原価・売価計算書 | 原価計算システム</title>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/function.js"></script>



<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>asset/css/style.css" charset="utf-8" />


<script type="text/javascript">
if(window.addEventListener) {
  window.addEventListener('load', function_onload, false);
} else if(window.attachEvent) {
  window.attachEvent('onload', function_onload);
}
function function_onload() {
}
</script>
</head>
<body>

<div id="header">
  <div class="wid">
    <h2>原価計算管理システム</h2>
    <p class="login_user"><?php echo $name; ?> | <a href="<?=base_url();?>/logout" style="color: #fff !important">ログアウト</a></p>
  </div><!-- / .wid -->
</div><!-- / #header -->

<div id="contents" class="dashboard">
  <div class="wid">


<form name="form1" action="" method="post">

<!--<div>
  <h3>原価・売価計算書</h3>
</div>-->


<div class="menu_list_a">
  <h4 class="acdn-button open" data-target="acdn-area-a">今月のデータ<i></i></h4>
  <div id="acdn-area-a" class="acdn-area">
    <table class="menu-table">
      <tr>
        <th class="t-left" colspan="2">新規入力データ</th>
        <th>前月比</th>
        <th>最大</th>
        <th>最小</th>
      </tr>
      <tr>
        <td>見積&nbsp;&nbsp;<?= $countItem; ?>&nbsp;件</td>
        <?php
          // get total current month
          $total_cur_month = 0;
          $total_cur_month = $sumEstTotalCostCurrentMonth->est_total_cost;
          echo '<td>(合計&nbsp;￥'.number_format($total_cur_month).')</td>';

          // get total last month
          $total_last_month = 0 ;
          $total_last_month = $sumEstTotalCostLastMonth->est_total_cost;
          $total = $total_cur_month - $total_last_month;
          if($total < 0){
            echo '<td class="t-right" style="color: red">￥'.number_format($total).'</td>';
          } else {
            echo '<td class="t-right">￥'.number_format($total).'</td>';
          }
          // get max cost
            echo '<td class="t-right">￥'.number_format($maxCostCurrentMonth->est_total_cost).'</td>';
          // get min cost
            $minCost = $minCostCurrentMonth->est_total_cost;
            if($minCost < 0){
              echo '<td class="t-right" style="color: red">￥'.number_format($minCost).'</td>';
            } else {
              echo '<td class="t-right"">￥'.number_format($minCost).'</td>';
            }
         ?>
      </tr>
      <tr>
        <td>売上&nbsp;&nbsp;<?= $countSaleItem; ?>&nbsp;件</td>
        <?php
          // get total current month
          $total_sale_cur_month = 0;
          $total_sale_cur_month = $sumSaleCostCurrentMonth->total_selling_price;
          echo '<td>(合計&nbsp;￥'.number_format($total_sale_cur_month).')</td>';
          // get total last month
          $total_sale_last_month = 0 ;
          $total_sale_last_month = $sumSaleCostLastMonth->total_selling_price;
          $total_sale = $total_sale_cur_month - $total_sale_last_month;
          if($total_sale < 0){
            echo '<td class="t-right" style="color: red">￥'.number_format($total_sale).'</td>';
          } else {
            echo '<td class="t-right">￥'.number_format($total_sale).'</td>';
          }
          // get max cost
          echo '<td class="t-right">￥'.number_format($maxSaleCostCurrentMonth->total_selling_price).'</td>';

          // get min cost
          $minCost = $minSaleCostCurrentMonth->total_selling_price;
          if($minCost < 0){
            echo '<td class="t-right" style="color: red">￥'.number_format($minCost).'</td>';
          } else {
            echo '<td class="t-right"">￥'.number_format($minCost).'</td>';
          }
         ?>
      </tr>
    </table>
    <div class="sort-btn">
      <a href="<?= base_url(); ?>filter">
        <input type="button" name="" id="" value="データソート" class="form-submit">
      </a>
    </div>
  </div>
</div>
<div class="menu_list_b">
  <h4 class="acdn-button open" data-target="acdn-area-b">マスターデータ管理<i></i></h4>
  <div id="acdn-area-b" class="acdn-area">
   <ul class="menu-list">
    <?php
      if ($permission_level==1){
        echo '<li class="menu-b-01"><a href="';
        echo base_url();
        echo 'companymaster">企業管理</a></li>';
      }
      if ($permission_level==1||$permission_level==2) {
        echo '<li class="menu-b-02"><a href="';
        echo base_url();
        echo 'departmentmaster">部署管理</a></li>';
        echo '<li class="menu-b-03"><a href="';
        echo base_url();
        echo 'employeemaster">従業員管理</a></li>';
      }
    ?>
    <li class="menu-b-04"><a href="<?php echo base_url(); ?>customermaster">得意先・代理店管理</a></li>
    <li class="menu-b-05"><a href="<?php echo base_url(); ?>productmaster">商品マスター管理</a></li>
   </ul>
  </div>
</div>

<div class="menu_list_c">
  <h4 class="acdn-button open" data-target="acdn-area-c">見積原価<i></i></h4>
  <div id="acdn-area-c" class="acdn-area">
   <ul class="menu-list">
    <li class="menu-c-01"><a href="<?php echo base_url(); ?>estimationlist">入力一覧</a></li>
    <li class="menu-c-02"><a href="<?php echo base_url(); ?>estimationresult">新規入力</a></li>
   </ul>
  </div>
</div>

<div class="menu_list_d">
  <h4 class="acdn-button open" data-target="acdn-area-d">売上原価<i></i></h4>
  <div id="acdn-area-d" class="acdn-area">
   <ul class="menu-list">
    <li class="menu-d-01"><a href="<?php echo base_url(); ?>salelist">入力一覧</a></li>
    <li class="menu-d-02"><a href="<?php echo base_url(); ?>saleresult">新規入力</a></li>
   </ul>
  </div>
</div>

</form>

  </div><!-- / .wid -->
</div><!-- / #contents -->

</body>
</html>
