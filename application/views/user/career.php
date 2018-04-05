<?php include 'common/header.php' ?>
    <section class="slide whiteSlide" name="career" data-midnight="white">
      <div class="content">
        <div class="container">
          <div class="wrap career_wrap">
            <div class="katana-12-12">
              <div class="ae-3">
                <div class="user_quote">
                  <p class="quote_text">"People are not your most important asset. The right people are"</p>
                  <span class="quote_by">Jim Collins</span>
                </div>
              </div>
            </div>
            <div class="katana-12-12">
              <div class="ae-3">
                <div class="search_form">
                  <form method="post">
                    <div class="form_inline">
                      <div class="triangle"><div class="empty"></div></div>
                      <input type="text" id="search" name="search" class="search_input">
                      <label for="search">Search</label>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <div class="katana-12-12">
              <div class="ae-3">
                <div class="post_list">
                  <div class="job_table" style="width: 100%;">
                    <div class="job_table_body">
                      <!-- Start job -->
                      <?php
                      // print("<pre>".print_r($list_career,true)."</pre>");
                      foreach ($list_career as $career) {
                        $cipherID = encrypted($career['id']);
                        $endDate = date("dS F Y", strtotime($career['close_date']));
                        $startDate = date("dS F Y", strtotime($career['start_date']));
                        echo '<div class="job_table_row">';
                        echo '<div class="job_table_cell">';
                        echo '<div class="job_type">'.$career['type'].'</div>';
                        echo '<div class="job_title"><a href="'.base_url().'career/detail?id='.$cipherID.'">'.$career['title'].'</a></div>';
                        echo '</div>';
                        echo '<div class="job_table_cell job_date">';
                        echo '<div class="job_time">';
                        echo '<div class="job_start">Start date : '.$startDate.'</div>';
                        echo '<div class="job_closing">Close date : '.$endDate.'</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                      }
                      ?>

                      <!-- End job -->
                    </div>
                  </div>
                </div>

                <!-- end job list -->
                <!-- Pagination -->
                <div class="pagination">
                  <a href="#"><i class="fas fa-angle-left"></i></a>
                  <a href="#" class="active">1</a>
                  <a href="#">2</a>
                  <a href="#">3</a>
                  <a href="#">4</a>
                  <a href="#"><i class="fas fa-angle-right"></i></a>
                </div>
                <!-- End Pagination -->
              </div>
            </div>
            <div class="clear"></div>
            <div class="katana-12-12">
              <div class="ae-3">
                <div class="contact_us">
                  <div class="contact_text">
                    <h3>CAN'T FIND your ROLE ?</h3>
                    <span>Drop us a line, we're up for partnerships. <br> Candidates can also opt for internship.</span>
                  </div>
                  <div class="contact_button">
                    <a href="#" class="btn primary"> CONTACT </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <div class="katana-12-12 toCenter margin-top-10 ae-1">
              <p class="copyright_text">&copy; 2018 Kantana Ltd Terms & Conditions</p>
            </div>
          </div>
        </div>
      </div>
      </section>
  <?php include 'common/footer.php' ?>
