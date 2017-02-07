<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_right">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
                    <div class="input-group" style="float:right; width:90%;">         
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>  
    <div class="row"> 
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2>Statistics</h2>
                <!--<div class="filter">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 0px solid #ccc">
                        <select id="semester" class="form-control" required="required">
                            <?php
                                foreach ((new Semester)->getSemestersPlusBlock(5) as $key => $value) {
                                    echo "<option value='".$key."'";
                                    echo ">".$value."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>-->
                <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id='generate_stats' action='' method='post' style='display:none;'>
                        <input type='hidden' name='generate_stats' value='1' />
                    </form>
                    <a onclick="document.getElementById('generate_stats').submit();" role="button" class="btn btn-primary">Generate Stats</a>
                    <br><br>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="control"></th>
                                <th>Semester</th>
                                <th>Submitted</th>
                                <th>Request Status Id</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($data['stats'] as $s) {
                                  foreach ($s['values'] as $v) {
                                    echo "<tr>";
                                    echo "<td></td>";
                                    echo "<td>".(new Semester)->getSemesterName($s['semester_code'])."</td>";
                                    echo "<td>".$s['submitted']."</td>";
                                    echo "<td>".(new RequestStatusDAO)->getById($v['request_status_id'])['name']."</td>";
                                    echo "<td>".$v['value']."</td>";
                                    echo "</tr>";
                                  }
                                }
                            ?>
                        </tbody>
                    </table>
                <!--<canvas id="mybarChart"></canvas>-->
                </div>
            </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Statistics</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!--<label for="heard">Request Status:</label>-->
                        <form class="form-horizontal" action="" method="post" id='update_stats' style='display:inline-block; margin-left:10px;'>
                         <div class="form-group" style='display:inline-block'>
                        <select id="request_status" name='request_status[]' style='max-width:300px' class="select2_multiple form-control" multiple='multiple' required>
                            <?php
                            foreach ($data['request_statuses'] as $s) {
                                echo "<option value='".$s['id']."'";
                                if (in_array($s['id'], $data['settings'][2])) {
                                    echo " selected";
                                }
                                echo ">".$s['name']."</option>";
                            }
                            ?>
                        </select>  
                        </div>
                         <div class="form-group" style='display:inline-block'>
                        <!--<label for="heard" style='margin-left:10px;'>Semester:</label>-->
                        <select id="semester" name='semester' style='max-width:300px' class="select2_multiple form-control" required>
                            <?php
                              foreach ((new Semester)->getFutureSemesters(2) as $key => $value) {
                                  echo "<option value='".$key."'";
                                  if ($key == $data['settings'][0]) {
                                      echo " selected";
                                  }
                                  echo ">".$value."</option>";
                              }
                            ?>
                        </select>  
                        </div>
                        <div class="form-horizontal" style='display:inline-block; margin-left:10px;'>
                          <fieldset>
                            <div class="control-group">
                              <div class="controls">
                                <div class="input-prepend input-group">
                                  <!--<span class="add-on input-group-addon" style='display:inline-block; position:relative; top:35px;'><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>-->
                                  <input type="text" style="width: 200px; position:relative; top:24px;" name="time_frame" id="time_frame" class="form-control" value="<?php echo $data['settings'][1]; ?>" /> <!-- 11/01/2016 - 12/30/2016 -->
                                </div>
                              </div>
                            </div>
                          </fieldset>
                        </div>
                        <button class='btn btn-primary' style="margin-left:10px;" onclick="document.getElementById('update_stats').submit();">Save</button>
                        <button class='btn btn-primary' onclick='updateGraph(event)'>Update</button>
                        <input type='hidden' name='update_stats_settings' value='1' />
                        </form>
                        <br><br><br>
                        <div id="container" style="height: 400px; min-width: 310px"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="clearfix"></div>
    </div>
</div>