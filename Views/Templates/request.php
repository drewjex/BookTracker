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
        
        <div class="col-md-7 col-sm-7 col-xs-12 <?php if ($data['role']['id'] == 3) { echo "disabledclick"; } ?>">
        <div class="x_panel">
            <div class="x_title">
            <h2><a href='#' onclick='openTextBoxTitle(event, this, <?php echo "\"title\""; ?>)'><?php echo $data['title']; ?></a></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li class="dropdown pull-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="" class='open-modal' data-toggle="modal" data-target="#change_log_request" >View Change Log</a>
                                </li>
                            </ul>
                </li>
                <li class='pull-right'><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <p>

                <label for="heard">Status:</label>
                <select id="request_status" onchange='updateStatus(event);' class="select2_single form-control" required>
                    <?php
                    foreach ($data['statuses'] as $s) {
                        echo "<option value='".$s['id']."'";
                        if ($s['id'] == $data['model']['status_id']) {
                            echo " selected";
                        }
                        echo ">".$s['name']."</option>";
                    }
                    ?>
                </select>   
                        
            </p>   <br>  
            <div id="change_log_request" class="modal fade message-modal-sm pull-left" style='text-align:left; z-index:9999;' tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel2">Change Log</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="x_content">
                                    <br><br>
                                    <table id="datatable-responsive-2" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="control"></th>
                                            <th>Column Name</th>
                                            <th>Changed By</th>
                                            <th>Date</th>
                                            <th>Old Value</th>
                                            <th>New Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($data['logs'] as $l) {
                                            echo "<tr>";
                                            echo "<td class='first-td-2'></td>";
                                            echo "<td>".$l['column_name']."</td>";
                                            echo "<td>".$l['changed_by_name']."</td>";
                                            echo "<td>".$l['date']."</td>";
                                            echo "<td>".$l['old_value']."</td>";
                                            echo "<td>".$l['new_value']."</td>";
                                            echo "</tr>";
                                        }
                                        
                                        ?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </form>
                                </div>
                                </div>
                                </div>
                                </div>
            <table class="small-padding table table-hover mustwrap">
                <tbody>
                <tr>
                    <td class='bold'>Semester:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"semester_code\""; ?>)'><?php echo $data['semester_name']; ?></a></td>
                </tr>
                <tr>
                    <td class='bold'>Edition:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"edition\""; ?>)'><?php echo $data['model']['edition']; ?></a></td>
                </tr>
                <tr>
                    <td class='bold'>Author:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"author\""; ?>)'><?php echo $data['model']['author']; ?></a></td>
                </tr>
                <tr>
                    <td class='bold'>Publisher:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"publisher\""; ?>)'><?php echo $data['model']['publisher']; ?></a></td>
                </tr>
                <tr>
                    <td class='bold'>Publishing Year:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"publishing_year\""; ?>)'><?php echo $data['model']['publishing_year']; ?></a></td>
                </tr>
                <tr>
                    <td class='bold'>ISBN10:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"isbn10\""; ?>)'><?php echo $data['model']['isbn10']; ?></a></td>
                </tr>
                <tr>
                    <td class='bold'>ISBN13:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"isbn13\""; ?>)'><?php echo $data['model']['isbn13']; ?></a></td>
                </tr>
                <tr>
                    <td class='bold'>Page Count:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"page_count\""; ?>)'><?php echo $data['model']['page_count']; ?></a></td>
                </tr>
                <tr>
                    <td class='bold'>Course:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"course\""; ?>)'><?php echo $data['model']['course']; ?></a></td>
                </tr>
                <tr>
                    <td class='bold'>Section:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"section\""; ?>)'><?php echo $data['model']['section']; ?></a></td>
                </tr>
                <tr>
                    <td class='bold'>Instructor:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"instructor\""; ?>)'><?php echo $data['model']['instructor']; ?></a></td>
                </tr>
                <tr>
                    <td class='bold'>Submitted:</td>
                    <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"submitted\""; ?>)'><?php echo $data['model']['submitted']; ?></a></td>
                </tr>
                </tbody>
            </table>    
            
            <!--<div class='col-md-4 col-sm-6 pull-right'>
                <div style="text-align: right; margin-bottom: 17px">
                    <span class="chart" data-percent="86">
                                        <span class="percent"></span>
                    </span>
                </div>
                </div>-->
                
            
            <div id='display-record'>
        
            <?php if (!$data['result']) { ?>
            
                <a class="btn btn-success" data-toggle="modal" data-target="#search_book_records"><i class="fa fa-edit m-right-xs"></i> Assign Book Record</a>
            
            <?php } else { ?>
            
                <strong>Assigned Record: </strong> <?php echo "<u><a href='?controller=page&action=record&id=".$data['record']['id']."'>".$data['record']['title']."</a></u>"; ?>

                <form id='remove_record' style='display:none;' action='' method='post'>
                <input type='hidden' name='remove_record' value='1' />
                </form>
                <a class="btn btn-danger small-button" href='#' onclick='removeRecord(event);' ><i class="fa fa-remove m-right-xs"></i> Remove</a>
            
            <?php } ?>
            
            </div>
            
            <div class="modal fade" style="z-index:9999;" id="search_book_records" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Search Book Records - <?php echo $data['title']; ?></h4>
                </div>
                <div class="modal-body">
                    <strong>Semester:</strong> <?php echo $data['semester_name']; ?> <br>
                    <strong>Edition:</strong> <?php echo $data['model']['edition']; ?><br>
                    <strong>Author:</strong> <?php echo $data['model']['author']; ?><br>
                    <strong>Publisher:</strong> <?php echo $data['model']['publisher']; ?><br>
                    <strong>Publishing Year:</strong> <?php echo $data['model']['publishing_year']; ?><br>
                    <strong>ISBN10:</strong> <?php echo $data['model']['isbn10']; ?><br>
                    <strong>ISBN13:</strong> <?php echo $data['model']['isbn13']; ?><br>
                    <strong>Page Count:</strong> <?php echo $data['model']['page_count']; ?><br>
                    <strong>Course:</strong> <?php echo $data['model']['course']; ?><br>
                    <strong>Instructor:</strong> <?php echo $data['model']['instructor']; ?><br>
                    <strong>Submitted:</strong> <?php echo $data['model']['submitted']; ?><br>
                    <div class="x_content">
                    <br><br>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="control"></th>
                            <th>Title</th>
                            <th>ISBN10</th>
                            <th>ISBN13</th>
                            <th>Page Count</th>
                            <th>Status</th>
                            <th>Edition</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Priority</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href='?controller=page&action=create_record&id=<?php echo $data['model']['id']; ?>' role="button" target='_blank' class="btn btn-primary">Create New Book Record</a>
                </div>
                </div>
            </div>
            </div>
            </div>
        </div>
        </div>
        
        <div class="col-md-5 col-sm-5 col-xs-12 <?php if ($data['role']['id'] == 3) { echo "disabledclick"; } ?>">
        <div class="x_panel">
            <div class="x_title">
            <h2>Student Information</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li class='pull-right'><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <div class="col-md-4 col-sm-4 col-xs-12 profile_left">
                <div class='profile_img'>
                <div id="crop-avatar">
                    <!-- Current avatar -->
                    <img class="img-responsive avatar-view" src='https://<?php echo gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME'])); ?>/<?php echo $data['picture']; ?>' alt="Picture">
                </div>
                </div>
                <h3><a href='?controller=page&action=student&id=<?php echo $data['current_student']['id']; ?>'><?php echo $data['name']['preferred_first_name']." ".$data['name']['surname']; ?></a></h3>

                <ul class="list-unstyled user_data">
                <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $data['home']['home_town'].", ".$data['home']['home_state_code'].", ".$data['home']['home_country_code']; ?>
                </li>

                <li>
                    <i class="fa fa-briefcase user-profile-icon"></i> 
                    <?php 
                    
                    if ($data['student_status'][0] == 'F') {
                        echo "Full-time Student";
                    } else if ($data['student_status'][0] == 'P') {
                        echo "Part-time Student";
                    } else if ($data['student_status'][0] == 'N') {
                        echo "Non-Student";
                    } 
                    
                    ?>
                </li>

                <li class="m-top-xs">
                    <i class="fa fa-external-link user-profile-icon"></i>
                    <?php if ($data['current_student']['pdf_url'] != null) { ?>

                        <a href='<?php echo $data['current_student']['pdf_url']; ?>' target="_blank">View Format Agreement</a>
                        <form id='remove_fa' style='display:none;' action='' method='post'>
                        <input type='hidden' name='remove_fa' value='1' />
                        </form>
                        <a href='#' onclick='removeFA(event);'> [Remove]</a>
                    
                    <?php } else { ?>
                    
                          <a href="" data-toggle="modal" data-target=".format-agreement-modal-sm">Attach Format Agreement</a>
                          <div class="modal fade format-agreement-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel2">Attach File</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        Select File to attach:<br><br>
                                        <input type="hidden" name="upload_format_agreement" value="1" />
                                        <input type="file" name="fileToUpload" id="fileToUploadFA" required="required">
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Attach File</button>
                                </form>
                                </div>

                            </div>
                            </div>
                          </div>
                    
                    <?php } ?>
                </li>
                </ul>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12 profile_left">
                <div style='pointer-events: auto;'><strong>Net Id:</strong> <?php echo $data['net_id']; ?></div>
                <strong>Preferred Name:</strong> <?php echo $data['name']['preferred_first_name']; ?><br>
                <strong>Email:</strong> <a href="mailto:<?php echo $data['email']; ?>"><?php echo $data['email']; ?></a>
                <form id='requested_format' action='' method='post'>
                    <p>
                    <label for="format">Requested Format:</label>
                    <!--<input type="text" id="format"  class="form-control" name="format" />-->
                    <select class="select2_multiple form-control" style="width:100%; max-width:300px;" name="requested_formats[]" multiple="multiple"> <!-- display:inline-block; -->
                        <?php
                        //echo var_dump($request->getProvidedFormatIds($_GET['id']));
                        foreach ((new FormatDAO)->getAll() as $f) {
                            echo "<option value='".$f['id']."'";
                            if (!empty($data['requested_format_ids']) && in_array($f['id'], $data['requested_format_ids'])) {
                                echo " selected";
                            }
                            echo ">".$f['name']."</option>";
                        }
                        ?>
                    </select>
                    </p>
                    <p>
                        <label for="file_path">Student Notes:</label>
                            <textarea id="student_notes" name="student_notes" class="form-control" ><?php echo $data['current_student']['notes']; ?></textarea>
                    </p>
                    <input type='hidden' name='update_requested_formats' value='1' />
                    <a class="btn btn-success" onclick="document.getElementById('requested_format').submit();"><i class="fa fa-edit m-right-xs"></i>Save</a>
                </form>
            </div>
            </div>
        </div>
        </div>
        
        <div class="col-md-5 col-sm-5 col-xs-12 pull-right">
        <div class="x_panel">
            <div class="x_title">
            <h2>Approval <font size='1'><?php echo $data['coordinator_name']; ?> <a href="" data-toggle="modal" data-target=".edit-coordinator-modal-sm">[Edit]</a></font></h2>
            <div class="modal fade edit-coordinator-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Select Assigned Coordinator</h4>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="new_user" value="1" />
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Assigned Coordinator:</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <select class="select2_single form-control" id="assigned_coordinator" name="assigned_coordinator" required="required">
                                            <?php
                                                foreach ($data['coordinators'] as $c) {
                                                    echo "<option value='".$c['id']."'";
                                                    if ($c['id'] == $data['model']['admin_id']) {
                                                        echo " selected";
                                                    }
                                                    echo ">".$c['admin_net_id']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav navbar-right panel_toolbox">
                <li class='pull-right'><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if ($data['model']['accepted']) { ?>
                    <form id='undo_approve_request' method='post' action='' style='display:none;'>
                        <input type='hidden' name='undo_approve_request' value='1' />
                    </form>
                    <font color='green' size='3'>Approved</font> by <?php echo $data['approved_name']; ?> on <?php echo $data['model']['approval_date']; ?>.
                    <a href='#' onclick='undoRequest(event)' class="btn btn-danger"><i class="fa fa-edit m-right-xs"></i>Undo</a>
                <?php } else if ($data['model']['pending_accepted']) { ?>
                    <form id='approve_request' method='post' action='' style='display:none;'>
                        <input type='hidden' name='approve_request' value='1' />
                    </form>
                    <form id='deny_request' method='post' action='' style='display:none;'>
                        <input type='hidden' name='deny_request' value='1' />
                    </form>
                    <a href='#' onclick='approveRequest(event)' class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Approve</a>
                    <a href='#' onclick='denyRequest(event)' class="btn btn-danger"><i class="fa fa-ban m-right-xs"></i>Deny</a>
                <?php } else { ?>
                    <form id='undo_approve_request' method='post' action='' style='display:none;'>
                        <input type='hidden' name='undo_approve_request' value='1' />
                    </form>
                    <font color='red' size='3'>Denied</font> by <?php echo $data['approved_name']; ?> on <?php echo $data['model']['approval_date']; ?>.
                    <a href='#' onclick='undoRequest(event)' class="btn btn-danger"><i class="fa fa-edit m-right-xs"></i>Undo</a>
                <?php } ?>

                <?php if ($data['role']['id'] == 3) { ?>
                    <a href='https://saasta.byu.edu/auth/ymessage/employee/accessibility/' target='_blank' class="btn btn-primary"><i class="fa fa-share m-right-xs"></i>Go to SAAS</a>
                <?php } ?>
            </div>
        </div>
        </div>
        
        <div class="col-md-12 col-sm-12 col-xs-12 <?php if ($data['role']['id'] == 3) { echo "disabledbutton"; } ?>"> 
        <div class="x_panel">
            <div class="x_title">
            <h2>Notes</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li class='pull-right'><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <form id='notes_section' action='' method='post'>
            <p>
            <label for="format">Provided Format:</label>
            <!--<input type="text" id="format"  class="form-control" name="format" />-->
            <select class="select2_multiple form-control" style="width:100%; max-width:300px;" name="provided_formats[]" multiple="multiple"> <!-- display:inline-block; -->
                <?php
                //echo var_dump($request->getProvidedFormatIds($_GET['id']));
                foreach ((new FormatDAO)->getAll() as $f) {
                    echo "<option value='".$f['id']."'";
                    if (!empty($data['format_ids']) && in_array($f['id'], $data['format_ids'])) {
                        echo " selected";
                    }
                    echo ">".$f['name']."</option>";
                }
                ?>
            </select>
            </p>
            <p>
            <!--<label for="notes">Notes: </label>-->
            <textarea id="notes" required="required" class="form-control" name="notes" data-parsley-trigger="keyup" ><?php echo $data['notes']; ?></textarea>
            </p>
            <input type='hidden' name='update_notes' value='1' />
            </form>
            <a class="btn btn-success" onclick="document.getElementById('notes_section').submit();"><i class="fa fa-edit m-right-xs"></i>Save</a>
            </div>
        </div>
        </div>
        
        <div class="col-md-12 col-sm-12 col-xs-12 <?php if ($data['role']['id'] == 3) { echo "disabledbutton"; } ?>">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Tasks</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li class="dropdown pull-right">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="" data-toggle="modal" data-target="#change_log_checklist" >View Change Log</a>
                        </li>
                      </ul>
                    </li>
                    <li class='pull-right'><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div id="change_log_checklist" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel2">Change Log</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="x_content">
                                    <br><br>
                                    <table id="datatable-responsive-3" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="control"></th>
                                            <th>Column Name</th>
                                            <th>Changed By</th>
                                            <th>Date</th>
                                            <th>Old Value</th>
                                            <th>New Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($data['checklist_logs'] as $l) {
                                            echo "<tr>";
                                            echo "<td></td>";
                                            echo "<td>".$l['column_name']."</td>";
                                            echo "<td>".$l['changed_by_name']."</td>";
                                            echo "<td>".$l['date']."</td>";
                                            echo "<td>".$l['old_value']."</td>";
                                            echo "<td>".$l['new_value']."</td>";
                                            echo "</tr>";
                                        }
                                        
                                        ?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </form>
                                </div>
                                </div>
                                </div>
                                </div>
                  
                  <?php $statuses = $data['statuses']; ?>

                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <ul class="to_do">
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[1]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[1]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[3]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[3]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[5]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[5]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                        <p>
                        </p>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[8]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[8]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[10]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[10]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[12]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[12]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[14]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[14]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                        <p>
                        </p>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[17]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[17]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[19]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[19]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                        <p>
                        </p>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[22]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[22]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                        <p>
                        </p>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[25]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[25]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                        <p>
                        </p>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[28]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[28]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[30]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[30]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[31]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[31]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[33]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[33]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                    </ul>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6">

                    <ul class="to_do">
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[2]['id']; ?>"> 
                            <?php 
                            
                            if (!$data['proof_accepted'] && $data['proof_exists']) {
                                echo "<font color='#00cc00'>";
                            } 
                            
                            echo $statuses[2]['name']." "; 
                            
                            if (!$data['proof_accepted'] && $data['proof_exists']) {
                                echo "</font>";
                            }
                            
                            if ($data['proof_exists']) {
                                echo "<a href='".$data['pdf_url']."' target='_blank'>[View]</a>";
                                echo "<form id='remove' style='display:none;' action='' method='post'>";
                                echo "<input type='hidden' name='remove_pdf' value='1' />";
                                echo "</form>";
                                echo "<a href='#' onclick='removePDF(event);'> Remove</a>";
                            } else {
                          
                          ?>
                          <a href="" data-toggle="modal" data-target=".pdf-modal-sm">[Attach]</a>
                          <div class="modal fade pdf-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel2">Attach File</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        Select File to attach:<br><br>
                                        <input type="hidden" name="upload_file" value="1" />
                                        <input type="file" name="fileToUpload" id="fileToUpload" required="required">
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Attach File</button>
                                </form>
                                </div>

                            </div>
                            </div>
                          </div>
                          
                          <?php
                          }
                          ?>
                          <div class='time-checked'></div>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[4]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[4]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[6]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[6]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[7]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[7]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[9]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[9]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[11]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[11]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[13]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[13]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[15]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[15]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[16]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[16]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[18]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[18]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[20]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[20]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[21]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[21]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[23]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[23]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[24]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[24]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[26]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[26]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[27]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[27]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <hr>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[29]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[29]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <hr>
                      <li>
                        <p>
                        </p>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[32]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[32]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                      <li>
                          <input type="checkbox" class="flat" id="checkbox-<?php echo $statuses[34]['id']; ?>"> <div class='checklist-text'><?php echo $statuses[34]['name']; ?></div>
                          <div class='time-checked'></div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            </div>


    </div>
    <div class="clearfix"></div>
</div>