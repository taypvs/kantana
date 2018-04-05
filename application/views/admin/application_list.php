<?php include 'common/header.php' ?>
<?php include 'common/sidebar.php' ?>
  <!-- Left side column. contains the logo and sidebar -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Career List
      </h1>
    </section>

    <?php
      if(isset($mess) && $mess != ''){
        echo '<div class="callout callout-info">';
        echo $mess;
        echo "</div>";
      }
    ?>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List </h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Position Title</th>
                  <th>Apply Date</th>
                  <th>Start Date</th>
                  <th>Status</th>
                </tr>
                <?php
                // print("<pre>".print_r($list_career,true)."</pre>");
                foreach ($list_application as $item) {
                  $status = '';
                  $class  = '';
                  if ($item['status'] == 0 ) {
                    $status = 'NEW';
                    $class= 'label-primary';
                  } else if ($item['status'] == 1 ) {
                    $status = 'ON PROCESS';
                    $class= 'label-warning';
                  } else if ($item['status'] == 2 ) {
                    $status = 'PASSED';
                    $class= 'label-success';
                  } else if ($item['status'] == 3 ) {
                    $status = 'Failed';
                    $class= 'label-danger';
                  }
                  $cipherID = encrypted($item['id']);
                  echo "<tr>";
                  echo "<td>".$item['id']."</td>";
                  echo "<td>".$item['title']."</td>";
                  echo "<td>".$item['post_date']."</td>";
                  echo "<td>".$item['start_date']."</td>";
                  echo '<td><span class="label '.$class.'">'.$status.'</span></td>';
                  echo "<td>";
                  echo "<div class='btn-group'>";
                  echo '<a href="'.base_url().'admincareeritem?id='.$cipherID.'"><button type="button" class="btn btn-info">View</button></a>';
                  echo "</div>";
                  echo "</td>";
                  echo "</tr>";
                }
                ?>

              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include 'common/footer.php' ?>
