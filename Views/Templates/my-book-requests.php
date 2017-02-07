<div class="right_col" role="main">
  <div class="">
    <div class="page-title"></div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>My Book Requests</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id='select_semester' method='post' action=''>
            <input type='hidden' name='update_semester' value='1' />
            <label for='semester' >Select Semester:</label>
              <select style="width:100%; max-width:300px; display:inline-block;" id='semester' name='semester' class="form-control">
                  <?php 
                    foreach ($data['semesters'] as $key => $value) {
                      echo "<option value='".$key."'";
                      if ($key == $data['selected_semester']) {
                          echo " selected";
                      }
                      echo ">".$value."</option>";
                    }
                  ?>
              </select><br><br>
              <!--<label for='view_posted_books' >For current semester only:</label>-->
              <a href='http://abcbookrequests.byu.edu/<?php echo $_SESSION['phpCAS']['user']; ?>' id='view_posted_books' target='_blank' type="submit" style='display:inline-block' class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Only books which have been completed from the current semester will be posted.">View Posted Books</a>
            </form>
            <?php
              if ($data['selected_semester'] == 'all') {
                  if (!empty($data['requests'])) {
                    foreach ($data['requests'] as $key => $value) {
                        echo "<br><br>";
                        echo "<h2>".$key."</h2><hr>";
                        $student_request_view = new Student_requestView($value);
                        $student_request_view->display();
                        echo "<br>";
                    }
                  } else {
                      echo "<br><strong>You do not have any book requests. Click <a href='?controller=page&action=submit'><u>here</u></a> to submit a new request.</strong>";
                  }
              } else {
                  $student_request_view = new Student_requestView($data['requests']);
                  $student_request_view->display();
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>