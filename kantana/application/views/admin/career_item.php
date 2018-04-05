<?php include 'common/header.php' ?>
<script src="<?php echo base_url(); ?>asset/js/admin/index.js"></script>
<script src="<?php echo base_url(); ?>asset/css/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<?php include 'common/sidebar.php' ?>
  <!-- Left side column. contains the logo and sidebar -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Career Item
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">

          <?php
          $title = '';
          $typeFullTime = '';
          $typePartTime = '';
          $location = '';
          $maxSalary = '';
          $minSalary = '';
          $startDate = '';
          $endDate = '';
          $isActive = '';

          if(isset($career)){
            $title = $career['title'];
            $location = $career['location'];
            $typeFullTime = $career['type'] == 'Full Time' ? 'checked' : '';
            $typePartTime = $career['type'] == 'Part Time' ? 'checked' : '';
            $maxSalary = $career['salary_max'];
            $minSalary = $career['salary_min'];
            $startDate = date("m/d/Y", strtotime($career['start_date']));
            $endDate = date("m/d/Y", strtotime($career['close_date']));
            $isActive = $career['active'];
          }
          ?>

          <form action="" method="post">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="deCount" name="deCount" value="0">
            <input type="hidden" id="reCount" name="reCount" value="0">
            <!-- ==== GENERAL ITEM ====== -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Create New Career Item</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- text input -->
                <div class="form-group">
                  <label>Title</label>
                  <input type="text" class="form-control" placeholder="Job Position ..." name="title" value="<?php echo $title;?>">
                </div>

                <!-- radio -->
                <div class="form-group">
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionTypeCareer" id="optionsRadios1" value="Full Time" <?php echo $typeFullTime;?>>
                      Full Time
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionTypeCareer" id="optionsRadios2" value="Part Time" <?php echo $typePartTime;?>>
                      Part Time
                    </label>
                  </div>
                </div>

                <div class="form-group" id="selectLocation">
                  <label>Location</label>
                  <select class="form-control" name="location" >
                    <option value="none">Please select location</option>
                    <option value="Ho Chi Minh">Ho Chi Minh</option>
                    <option value="Ha Noi">Ha Noi</option>
                    <option value="Da Nang">Da Nang</option>
                  </select>
                </div>

                <script>
                  $("#selectLocation select").val('<?php echo $location; ?>');
                </script>

                <div class="form-group">
                  <label>Salary</label>
                  <div class="row">

                    <div class="col-xs-3">
                      <input type="text" class="form-control" placeholder="Min salary" name="min_salary" value="<?php echo $minSalary;?>">
                    </div>
                    <div class="col-xs-3">
                      <input type="text" class="form-control" placeholder="Max salary" name="max_salary" value="<?php echo $maxSalary;?>">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>Start Date:</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker" name="start_date" value="<?php echo $startDate;?>">
                  </div>
                  <label>End Date:</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker_end" name="end_date" value="<?php echo $endDate;?>">
                  </div>
                </div>

                <div class="form-group">
                  <label>Active:</label>
                  <label>
                    <input type="checkbox" name="active" class="minimal-red" value="1" checked>
                  </label>
                </div>

              </div>
              <!-- /.box general Item -->
            </div>


            <!-- ==== DESCRIPTION ITEM ====== -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Description</h3>
                <button id="add_description" type="button" style="margin-left:100px"class="btn btn-primary">Add New</button>
              </div>
              <!-- /.box-header -->
              <div class="box-body"  id="description_body">
                <?php
                if (isset($description)){
                  $i = 0;
                  foreach ($description as $item){
                    $i++;
                    echo '<div class="input-group margin">';
                    echo '<input type="text" name="description_item_' . $i . '" class="form-control description_item" placeholder="Description ..." value="' . $item['content']  . '">';
                    echo '<span class="input-group-btn">';
                    echo '<button type="button" class="btn btn-info btn-flat remove-line">X</button>';
                    echo '</span>';
                    echo '</div>';
                  }
                }
                ?>
                <script>
                  $('#deCount').val(<?php echo $i?>);
                  sortDescriptionName();
                </script>
              </div>
              <!-- /.box DESCRIPTION Item -->
            </div>


            <!-- ==== REQUIREMENT ITEM ====== -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Requirement</h3>
                <button id="add_requirement" type="button" style="margin-left:100px"class="btn btn-primary">Add New</button>
              </div>
              <!-- /.box-header -->
              <div class="box-body" id="requirement_body">
                <?php
                if (isset($requirement)){
                  $j = 0;
                  foreach ($requirement as $item){
                    $j++;
                    echo '<div class="input-group margin">';
                    echo '<input type="text" name="requirement_item_' . $j . '" class="form-control requirement_item" placeholder="Requirement ..." value="' . $item['content']  . '">';
                    echo '<span class="input-group-btn">';
                    echo '<button type="button" class="btn btn-info btn-flat remove-line">X</button>';
                    echo '</span>';
                    echo '</div>';
                  }
                }
                ?>
              </div>
              <script>
                $('#reCount').val(<?php echo $j?>);
                sortRequirementName();
              </script>
              <!-- /.box REQUIREMENT Item -->
            </div>
            <input type="submit" class="btn btn-primary" value="Submit"/>
          </form>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <?php include 'common/footer.php' ?>
