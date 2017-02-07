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
        <div class="col-md-7 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <a href='#' onclick='openTextBox(event, this, <?php echo "\"title\""; ?>)'><?php echo $data['record']['title']; ?></a>
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="" data-toggle="modal" data-target="#change_log_record" >View Change Log</a>
                                </li>
                            </ul>
                        </li>
                        <li class='pull-right'>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="change_log_record" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
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
                                    <table id="datatable-responsive-4" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
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
                                            echo "<td class='first-td-4'></td>";
                                            echo "<td>".$l['column_name']."</td>";
                                            echo "<td>".BYULINK::getNetID((new AdminDAO)->getById($l['changed_by'])['person_id'], 'PERSON_ID')."</td>";
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
                                    
                        <div class="col-md-6 col-sm-6 col-xs-12 pull-left" style='margin-bottom:10px;'>
                            <label for="heard">Status:</label>
                            <select style="width:70%; display:inline-block; margin-right:10px; margin-bottom:10px;" onchange='updateStatus(event);' class="select2_single form-control" required>
                                <option value='0'>&nbsp;</option>
                                <?php
                                    foreach ($data['statuses'] as $s) {
                                        echo "<option value='".$s['id']."'";
                                        if ($s['id'] == $data['record']['status_id']) {
                                            echo " selected";
                                        }
                                        echo ">".$s['name']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 pull-left" style='margin-bottom:10px;'>
                            <label for="heard">Priority:</label>
                            <select style="width:70%; display:inline-block;" onchange='updatePriority(event);' class="select2_single form-control" required>
                                <option value='0'>&nbsp;</option>
                                <?php
                                    foreach ($data['priorities'] as $p) {
                                        echo "<option value='".$p['id']."'";
                                        if ($p['id'] == $data['record']['priority_id']) {
                                            echo " selected";
                                        }
                                        echo ">".$p['name']."</option>";
                                    }
                                ?>
                            </select>     
                        </div>
                    <br><br><br>
                
                    <br>  
                    <div style="overflow-x:auto; width:100%;">
                    <table class="small-padding table table-hover">
                        <tbody>
                            <tr>
                                <td class='bold'>Edition:</td>
                                <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"edition\""; ?>)'><?php echo $data['record']['edition']; ?></a></td>
                            </tr>
                            <tr>
                                <td class='bold'>Author:</td>
                                <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"author\""; ?>)'><?php echo $data['record']['author']; ?></a></td>
                            </tr>
                            <tr>
                                <td class='bold'>Publisher:</td>
                                <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"publisher\""; ?>)'><?php echo $data['record']['publisher']; ?></a></td>
                            </tr>
                            <tr>
                                <td class='bold'>Publishing Year:</td>
                                <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"publishing_year\""; ?>)'><?php echo $data['record']['publishing_year']; ?></a></td>
                            </tr>
                            <tr>
                                <td class='bold'>ISBN10:</td>
                                <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"isbn10\""; ?>)'><?php echo $data['record']['isbn10']; ?></a></td>
                            </tr>
                            <tr>
                                <td class='bold'>ISBN13:</td>
                                <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"isbn13\""; ?>)'><?php echo $data['record']['isbn13']; ?></a></td>
                            </tr>
                            <tr>
                                <td class='bold'>Page Count:</td>
                                <td><a href='#' onclick='openTextBox(event, this, <?php echo "\"page_count\""; ?>)'><?php echo $data['record']['page_count']; ?></a></td>
                            </tr>
                        </tbody>
                    </table>   
                    </div> 
                    <div class="form-group">
                        <label for="file_path">File Path:
                        </label>
                            <input type="text" id='file_path' name="file_path" style='width:100%; max-width:300px;' value='<?php echo $data['record']['file_path']; ?>' >
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-5 col-sm-6 col-xs-6">
            <div class="x_panel">
                <div class="x_title">
                <h2>Saved Formats</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="" data-toggle="modal" data-target="#change_log_formats" >View Change Log</a>
                        </li>
                    </ul>
                    </li>
                    <li class='pull-right'>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <div id="change_log_formats" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
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
                                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
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
                                        foreach ($data['format_logs'] as $l) {
                                            echo "<tr>";
                                            echo "<td class='first-td'></td>";
                                            echo "<td>".$l['column_name']."</td>";
                                            echo "<td>".BYULINK::getNetID((new AdminDAO)->getById($l['changed_by'])['person_id'], 'PERSON_ID')."</td>";
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
                    <form id='saved_formats' action='' method='post'>
                    <input type='hidden' name='save_formats' id='1' />
                    <p>
                        <?php
                            foreach ((new FormatDAO)->getAll() as $f) {
                                $check = "";
                                if (in_array($f['id'], $data['saved_formats'])) { 
                                    $check = "checked='checked'"; 
                                }
                                echo "<div class='checkbox'>
                                            <label>
                                            <input name=format-".$f['id']." id=format-".$f['id']." type='checkbox' class='flat saved-formats' ".$check." value='".$f['id']."'> ".$f['name']."
                                            </label>
                                        </div>";
                            }
                        ?>
                    </p>
                    </form>
                </div>
                <!--<a class="btn btn-success pull-right" onclick="document.getElementById('saved_formats').submit();"><i class="fa fa-edit m-right-xs"></i>Save</a>-->
            </div>
        </div>
        
        <div class="col-md-12 col-sm-6 col-xs-6">
            <div class="x_panel">
                <div class="x_title">
                <h2>Instructions</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class='pull-right'>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <form class="form-horizontal" id='instructions_section' action='' method='post'>
                    <input type='hidden' name='update_instructions' value='1' />
                <div class="form-group">
                    <label for="instructions" style='text-align:left;' class="col-sm-2 control-label instruction-label">Assigned Editor:</label>
                        <select class="select2_multiple form-control" style=" max-width:300px;" name="assigned_admins[]" multiple="multiple"> <!-- display:inline-block; -->
                            <?php
                                foreach ($data['admins'] as $a) {
                                    echo "<option value='".$a['id']."'";
                                    if (in_array($a['id'], $data['admin_ids'])) {
                                        echo " selected";
                                    }
                                    echo ">".BYULINK::getNetID($a['person_id'])."</option>";
                                }
                            ?>
                        </select>
                </div>   
                <div class="form-group">
                    <label for="instructions" style='text-align:left;' class="col-sm-2 control-label instruction-label">Instructions:</label>
                        <select class="select2_multiple form-control" style=" max-width:300px;" name="instructions[]" multiple="multiple"> <!-- display:inline-block; -->
                            <?php
                                foreach ((new InstructionDAO)->getAll() as $i) {
                                    echo "<option value='".$i['id']."'";
                                    if (in_array($i['id'], $data['instruction_ids'])) {
                                        echo " selected";
                                    }
                                    echo ">".$i['name']."</option>";
                                }
                            ?>
                        </select>
                </div>   
                <div class="form-group">
                        <label for="additional_text" style='text-align:left;' class="col-sm-2 control-label instruction-label">Accessible Text:</label>
                            <select class="select2_multiple form-control" style=" max-width:300px;" name="additional_text[]" multiple="multiple"> <!-- display:inline-block; -->
                                <?php
                                    foreach ((new TextDAO)->getAll() as $t) {
                                        echo "<option value='".$t['id']."'";
                                        if (in_array($t['id'], $data['text_ids'])) {
                                            echo " selected";
                                        }
                                        echo ">".$t['name']."</option>";
                                    }
                                ?>
                            </select>
                </div>
                <p>
                   <label for="additional_instructions">Notes:</label>
                   <textarea id="additional_instructions" required="required" class="form-control" name="notes" data-parsley-trigger="keyup" ><?php echo $data['notes']; ?></textarea>
                </p>
                <input type='hidden' name='update_notes' value='1' />
                </form>
                <a class="btn btn-success" onclick="document.getElementById('instructions_section').submit();"><i class="fa fa-edit m-right-xs"></i>Save</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2>Time Log</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class='pull-right'>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                </ul>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    
                    <?php if (!$data['is_doing_task']) { ?>
                    <form id='new_task' method='post'>
                        <input type='hidden' name='new_task' value='1' />    
                    </form>
                    <a class="btn btn-success" onclick="$('#show_time').show(); document.getElementById('new_task').submit();"><i class="fa fa-edit m-right-xs"></i>New Task</a>
                    <?php } else { ?>
                    <a class="btn btn-danger" onclick="endTask(<?php echo $data['is_doing_task']['id']; ?>)" data-toggle="modal" data-target="#end_task_modal"><i class="fa fa-edit m-right-xs"></i>End Task</a>
                    <div style='display:inline-block;'>
                        <h2>Duration: <span id='show_time'><?php echo $data['current_time']; ?></span> <font size='1' style='margin-bottom:50px'></font></h2> <!-- <a href='#' onclick='updateTime(event, <?php echo $_GET['id']; ?>)'>[Update]</a> -->
                    </div>
                    <div id="end_task_modal" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel2">Task Information</h4>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
                                    Fill out the task form:<br><br>
                                    <input type="hidden" name="finish_task" value="1" />
                                    <input type="hidden" name="task_id" value='<?php echo $data['is_doing_task']['id']; ?>' />
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Task:<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_single form-control" style='width:100%;' name="instruction_id" required="required"> <!-- display:inline-block; -->
                                                <option>&nbsp;</option>
                                                <?php
                                                    foreach ((new InstructionDAO)->getAll() as $i) {
                                                        echo "<option value='".$i['id']."'";
                                                        echo ">".$i['name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Semester:<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_single form-control" style='width:100%;' name="semester_code" required="required"> <!-- display:inline-block; -->
                                                <option>&nbsp;</option>
                                                <?php
                                                    foreach ((new Semester)->getFutureSemesters(2) as $key => $value) {
                                                        echo "<option value='".$key."'";
                                                        echo ">".$value."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dashlet-title">Chapter <span class="required">*</span>
                                        </label>
                                        <div class="col-md-2 col-sm-3 col-xs-12">
                                        <input type="text"  name="chapter"  class="form-control col-md-3 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dashlet-title">Starting Page <span class="required">*</span>
                                        </label>
                                        <div class="col-md-2 col-sm-3 col-xs-12">
                                        <input type="number"  name="start_page"  class="form-control col-md-3 col-xs-12">
                                        </div>
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dashlet-title">Ending Page <span class="required">*</span>
                                        </label>
                                        <div class="col-md-2 col-sm-3 col-xs-12">
                                        <input type="number"  name="end_page"  class="form-control col-md-3 col-xs-12">
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

                    <?php } ?>
                    <br><br>
                    <table id="datatable-responsive-2" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="control"></th>
                            <th>Editor</th>
                            <th>Task</th>
                            <th>Semester</th>
                            <th>Chapter</th>
                            <th>Starting Page</th>
                            <th>Ending Page</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duration</th>
                            <th width='10px'></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                                foreach ($data['tasks'] as $t) {
                                    echo "<tr>";
                                    echo "<td class='first-td-2'></td>";
                                    echo "<td><a href='#' onclick='openTextBoxTimeLog(event, this, ".$t['id'].", \"admin_id\")'>".$t['admin']."</a></td>";
                                    echo "<td><a href='#' onclick='openTextBoxTimeLog(event, this, ".$t['id'].", \"instruction_id\")'>".$t['instruction']."</a></td>";
                                    echo "<td><a href='#' onclick='openTextBoxTimeLog(event, this, ".$t['id'].", \"semester_code\")'>".(new Semester)->getSemesterName($t['semester_code'])."</a></td>";
                                    echo "<td><a href='#' onclick='openTextBoxTimeLog(event, this, ".$t['id'].", \"chapter\")'>".$t['chapter']."</a></td>";
                                    echo "<td><a href='#' onclick='openTextBoxTimeLog(event, this, ".$t['id'].", \"start_page\")'>".$t['start_page']."</a></td>";
                                    echo "<td><a href='#' onclick='openTextBoxTimeLog(event, this, ".$t['id'].", \"end_page\")'>".$t['end_page']."</a></td>";
                                    echo "<td><a href='#' onclick='openTextBoxTimeLog(event, this, ".$t['id'].", \"start_time\")'>".date("m/d/Y g:i a", strtotime($t['start_time']))."</a></td>";
                                    echo "<td><a href='#' onclick='openTextBoxTimeLog(event, this, ".$t['id'].", \"end_time\")'>".date("m/d/Y g:i a", strtotime($t['end_time']))."</a></td>";
                                    echo "<td>".$t['duration']."</td>";
                                    echo "<td>";
                                    echo "<form id=remove_task-".$t['id']." style='display:none;' action='' method='post'>";
                                    echo "<input type='hidden' name='remove_task' value=".$t['id']." />";
                                    echo "</form>";
                                    echo "<a href='#' onclick='removeTask(event,".$t['id'].")'><i class='fa fa-close'></i></a></td>";
                                    echo "</tr>";
                                }
                        
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2>Requests</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class='pull-right'>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable-responsive-3" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="control"></th>
                            <th>Title</th>
                            <th>Student</th>
                            <th>Coordinator</th>
                            <th>Status</th>
                            <th>Semester</th>
                            <th>Edition</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Publishing Year</th>
                            <th>ISBN10</th>
                            <th>ISBN13</th>
                            <th>Course</th>
                            <th>Section</th>
                            <th>Instructor</th>
                            <th>Submitted</th>
                            <th width='10px'></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            foreach ($data['requests'] as $r) {
                                echo "<tr>";
                                echo "<td>".$r['id']."</td>";
                                echo "<td style='min-width:250px;'><a href='?controller=page&action=request&id=".$r['id']."'>".$r['title']."</a></td>";
                                echo "<td>".BYULINK::getNetID((new StudentDAO)->getById($r['student_id'])['person_id'], 'PERSON_ID')."</td>";
                                echo "<td>".BYULINK::getNetID((new AdminDAO)->getById($r['admin_id'])['person_id'], 'PERSON_ID')."</td>";
                                echo "<td>".(new RequestStatusDAO)->getById($r['status_id'])['name']."</td>";
                                echo "<td>".(new Semester)->getSemesterName($r['semester_code'])."</td>";
                                echo "<td>".$r['edition']."</td>";
                                echo "<td>".$r['author']."</td>";
                                echo "<td>".$r['publisher']."</td>";
                                echo "<td>".$r['publishing_year']."</td>";
                                echo "<td>".$r['isbn10']."</td>";
                                echo "<td>".$r['isbn13']."</td>";
                                echo "<td>".$r['course']."</td>";
                                echo "<td>".$r['section']."</td>";
                                echo "<td>".$r['instructor']."</td>";
                                echo "<td>".$r['submitted']."</td>";
                                echo "<td>";
                                echo "<form id=remove_request-".$r['id']." style='display:none;' action='' method='post'>";
                                echo "<input type='hidden' name='remove_request' value=".$r['id']." />";
                                echo "</form>";
                                echo "<a href='#' onclick='removeRequest(event,".$r['id'].")'><i class='fa fa-close'></i></a></td>";
                                echo "</tr>";
                            }
                        
                            ?>
                        </tbody>
                    </table>
                </div>
                <a class="btn btn-success" data-toggle="modal" data-target="#search_book_requests"><i class="fa fa-edit m-right-xs"></i>Link Requests</a>
                <button type="button" onclick='removeRecord(event, <?php echo $data['record']['id']; ?>)' class="btn btn-danger pull-right">Delete this Record</button>
                <form id="remove_record" style='display:none;' action='' method='post'>
                    <input type='hidden' name='remove_record' value='1' />
                </form>
                <div class="modal fade" style="z-index:9999;" id="search_book_requests" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Search Book Requests - <?php echo $data['record']['title']; ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="x_content">
                            <br><br>
                            <table id="datatable-responsive-5" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="control"></th>
                                    <th>Title</th>
                                    <th>Student</th>
                                    <th>Coordinator</th>
                                    <th>Status</th>
                                    <th>Semester</th>
                                    <th>Edition</th>
                                    <th>Author</th>
                                    <th>Publisher</th>
                                    <th>Publishing Year</th>
                                    <th>ISBN10</th>
                                    <th>ISBN13</th>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Instructor</th>
                                    <th>Submitted</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                /*foreach ($data['all_requests'] as $r) {
                                    echo "<tr>";
                                    echo "<td></td>";
                                    echo "<td style='min-width:250px;'>";
                                    echo "<form id='assign_request".$r['id']."' style='display:none;' action='' method='post'>";
                                    echo "<input type='hidden' name='assign_request' value='".$r['id']."' />";
                                    echo "</form>";
                                    echo "<a href='#' onclick='assignBookRequest(event, ".$r['id'].");'>".$r['title']."</a></td>"; //data-dismiss='modal'
                                    echo "<td>".BYULINK::getNetID((new StudentDAO)->getById($r['student_id'])['person_id'], 'PERSON_ID')."</td>";
                                    echo "<td>".BYULINK::getNetID((new AdminDAO)->getById($r['admin_id'])['person_id'], 'PERSON_ID')."</td>";
                                    echo "<td>".(new RequestStatusDAO)->getById($r['status_id'])['name']."</td>";
                                    echo "<td>".(new Semester)->getSemesterName($r['semester_code'])."</td>";
                                    echo "<td>".$r['edition']."</td>";
                                    echo "<td>".$r['author']."</td>";
                                    echo "<td>".$r['publisher']."</td>";
                                    echo "<td>".$r['publishing_year']."</td>";
                                    echo "<td>".$r['isbn10']."</td>";
                                    echo "<td>".$r['isbn13']."</td>";
                                    echo "<td>".$r['course']."</td>";
                                    echo "<td>".$r['section']."</td>";
                                    echo "<td>".$r['instructor']."</td>";
                                    echo "<td>".$r['submitted']."</td>";
                                    echo "</tr>";
                                }*/
                                
                                ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <!--<a href='?controller=page&action=create_record' role="button" class="btn btn-primary" target="_blank">Assign Book Request</a>-->
                        </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>

        </div>
        
    </div>   
    </div>
    <div class="clearfix"></div>     
</div>