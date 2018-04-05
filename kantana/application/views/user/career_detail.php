<?php include 'common/header.php' ?>

<?php
$title = '';
$type = '';
$location = '';
$maxSalary = '';
$minSalary = '';
$startDate = '';
$endDate = '';
$isActive = '';
$id = '';
if(isset($career)){
  $title = $career['title'];
  $location = $career['location'];
  $type = $career['type'];
  $maxSalary = $career['salary_max'];
  $minSalary = $career['salary_min'];
  $startDate = date("dS F Y", strtotime($career['start_date']));
  $endDate = date("dS F Y", strtotime($career['close_date']));
  $postOn = date("dS F Y", strtotime($career['updated_date']));
  $isActive = $career['active'];
  $id = $career['id'];
}
?>
    <section class="slide whiteSlide" name="job-details" data-jq-clipthru="color" data-midnight="white">
      <div class="content">
        <div class="container">
          <div class="wrap">
            <div class="katana-12-12">
              <div class="ae-3">
                <div class="title_job_detail">
                  <a href="career.html" class="back_job_list"><i class="fas fa-angle-left"></i> SEE LATEST JOBS</a>
                  <h3><?php echo $title; ?></h3>
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <!-- Job detail -->
            <div class="katana-8-12">
              <div class="ae-3">
                <div class="info_job">
                  <div class="job_detail">
                    <ul>
                      <li>Work location: <?php echo $location; ?></li>
                      <li><?php echo $type; ?></li>
                      <li>Salary: <?php echo number_format($minSalary); ?> - <?php echo number_format($maxSalary); ?> VND</li>
                    </ul>
                  </div>
                  <div class="job_detail">
                    <ul>
                      <li>Start date: <?php echo $startDate; ?></li>
                      <li>Closing date: <?php echo $endDate; ?></li>
                      <li>Posted on: <?php echo $postOn; ?></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Job detail -->
            <!-- Apply Button -->
            <div class="katana-12-12">
              <div class="ae-3">
                <div class="apply_button">
                  <a href="#inline" class="btn default btn-block" data-lity ><span>APPLY</span></a>
                </div>
              </div>
            </div>
            <!-- End Apply Button -->

            <!-- Job description -->
            <div class="clear"></div>
             <div class="katana-8-12">
              <div class="ae-3">
                <div class="job_info_detail">
                  <div class="job_description">
                    <h5>Job Description</h4>
                      <ul>
                        <?php
                        if (isset($description)){
                          $i = 0;
                          foreach ($description as $item){
                            $i++;
                            echo '<li>'.$item['content'].'</li>';
                          }
                        }
                        ?>
                    </ul>
                  </div>
                  <div class="clear"></div>
                  <div class="job_requirement">
                    <h5>Job Requirements</h4>
                    <ul>
                      <?php
                      if (isset($requirement)){
                        $i = 0;
                        foreach ($requirement as $item){
                          $i++;
                          echo '<li>'.$item['content'].'</li>';
                        }
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- End description -->
            <div class="clear"></div>
            <!-- Apply Button -->
            <div id="inline" style="overflow:auto;background:#fff;padding:20px;max-width:100%;border-radius:6px" class="lity-hide">
              <div class="apply_form">
                <form action="add" method="post" class="form_cv" enctype="multipart/form-data">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="career_id" value="<?php echo $id;?>">
                  <ul>
                    <li class="row_form">
                      <label style="margin-left: 10px;">Attach your CV...</label>
                      <input type="file" name="file" id="file" class="inputfile">
                      <label for="file"><span><i class="fa fa-upload" aria-hidden="true"></i> Choose a file...</span></label>
                    </li>
                    <li class="or">Or*</li>
                    <li class="row_form">
                      <label for="cv" style="margin-left: 10px;">Provide a link to your CV</label>
                      <input type="text" name="cv" id="cv">
                    </li>

                  </ul>
                  <ul>
                    <li class="single_row">
                      <label for="portfolio_url" style="margin-left: 10px;">Provide a link to your Porfolio / Reel</label>
                      <input type="text" name="portfolio_url" id="portfolio_url">
                    </li>
                  </ul>
                  <ul>
                    <li class="row_form">
                      <label for="start_date" style="margin-left: 10px;">When are you available to start?</label>
                      <input type="text" name="start_date" id="start_date" data-toggle="start_date">
                    </li>
                    <li class="row_form">
                      <label for="where_hear" style="margin-left: 30px;">Where did you hear about us?</label>
                      <select name="where_hear" id="where_hear" class="where_select" style="color: #000 !important">
                        <option value="linkedin">Linkedin</option>
                        <option value="facebook">Facebook</option>
                        <option value="google">Google</option>
                      </select>
                    </li>

                  </ul>
                  <ul>
                    <li class="row_form" style="width: 100%;padding-right: 20px;">
                      <input type="submit" class="btn default" style="width: 100%;">APPLY FOR THIS ROLE</button>
                    </li>
                  </ul>

                </form>

              </div>


            </div>
            <!-- End Apply Button -->
            <div class="clear"></div>
            <div class="katana-12-12 toCenter margin-top-10 ae-1">
              <p class="copyright_text">&copy; 2018 Kantana Ltd Terms & Conditions</p>
            </div>
          </div>
        </div>
      </div>
      </section>
<?php include 'common/footer.php' ?>
