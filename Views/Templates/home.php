<div class="right_col" role="main" id="main-content">
  <!-- top tiles -->
  <!--<div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Requests Completed</span>
      <div class="count">2500</div>
      <span class="count_bottom"><i class="green">4% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
      <div class="count">123.50</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
      <div class="count green">2,500</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
      <div class="count">4,567</div>
      <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
      <div class="count">2,315</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
      <div class="count">7,325</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
  </div>-->

    <div class="clearfix"></div>

    <div class="row sortable" id="item-sort">    

      <?php
        
        foreach ($data['models'] as $model) {
            $dashlet = new DashletView($model['id']);
            $dashlet->display();
        }

      ?>
      
      <div class="col-md-12 col-sm-12 col-xs-12 sortable">
        <div class="x_panel">
          <div class="x_title collapse-link add_dashlet">
            <h2>Add Another Dashlet</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content" style="display:none;">
            <br />
            <form id="add-dashlet" name="add-dashlet" data-parsley-validate class="form-horizontal form-label-left" method="post">
              <input type="hidden" name="add-dashlet" value=""/>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dashlet-title">Dashlet Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="dashlet-title" name="title" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Dashlet Type <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="type-select" name="type-select" class="select2_single form-control" tabindex="-1" onchange="updateForm()" required="required">
                    <option></option>
                    <option value="request">Book Request</option>
                    <option value="record">Book Record</option>
                  </select>
                </div>
              </div>
              <div id="request-info" style="display:none;">
                <div class="form-group" id="column-requests">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Columns to Display <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_multiple form-control" id="request-columns" name="request-columns[]" multiple="multiple" required="required">
                      <option value="title">Title</option>
                      <option value="name">Status</option>
                      <option value="full_name">Semester</option>
                      <option value="submitted">Submitted</option>
                      <option value="modified">Modified</option>
                      <option value="net_id">Student</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Semester/Term <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_multiple form-control" id="semester" name="semester[]" multiple="multiple" required="required">
                      <?php
                          foreach ((new Semester)->getSemestersDashlet(4) as $key => $value) {
                              echo "<option value='".$key."'";
                              echo ">".$value."</option>";
                          }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Request Status <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_multiple form-control" id="status" name="status[]"  multiple="multiple" required="required">
                      <?php
                        foreach ($data['statuses'] as $s) {
                          echo "<option value='".$s['id']."'>".$s['name']."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div id="record-info" style="display:none;">
                <div class="form-group" id="column-records">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Columns to Display <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_multiple form-control" id="record-columns" name="record-columns[]" multiple="multiple" required="required">
                      <option value="title">Title</option>
                      <option value="p.name">Priority</option>
                      <option value="rs.name">Status</option>
                      <option value="br.created">Created</option>
                      <option value="modified">Modified</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Assigned Editor <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_single form-control" id="editors" multiple="multiple" name="editors[]" tabindex="-1" required="required">
                      <?php
                        foreach ($data['admins'] as $a) {
                          echo "<option value=".$a['id'].">".BYULINK::getNetID($a['person_id'])."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Record Status <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_multiple form-control" id="record_status" name="record_status[]" multiple="multiple" required="required">
                      <?php
                        foreach ($data['record_statuses'] as $s) {
                          echo "<option value=".$s['id'].">".$s['name']."</option>";
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

        