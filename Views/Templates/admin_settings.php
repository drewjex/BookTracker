<div class="right_col" role="main">
    <div class="">
        <div class="page-title"></div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Administrator Settings</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class='pull-right'>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <h2>Record Status</h2>
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>
                                        <th style="width: 50%">Name</th>
                                        <th style="width: 50%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($data['record_statuses'] as $rs) { ?>
                                    <tr>
                                        <td>
                                            <a onclick='openTextBox(event, this, "record_status", <?php echo $rs['id']; ?>)'><?php echo $rs['name']; ?></a>
                                        </td>
                                        <td>
                                            <form id='record_status-<?php echo $rs['id']; ?>' style='display:none;' method='post' action=''>
                                                <input type='hidden' name='delete_entry' value='<?php echo $rs['id']; ?>' />
                                                <input type='hidden' name='table' value='record_status' />
                                            </form>
                                            <a href="#" onclick="if (confirm('Are you sure you want to delete this entry?')) { document.getElementById('record_status-<?php echo $rs['id']; ?>').submit(); }" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                        </td>
                                    </tr>   
                                <?php } ?>
                                </tbody>
                            </table>
                            <a href='' style='width:100px;' class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_record_status">Add</a>
                            <div id="add_record_status" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title" id="myModalLabel2">New Entry</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left" id='new_record_status'>
                                                <br>
                                                <input type="hidden" name="new_record_status" value="1" />
                                                <div class="form-group">
                                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="dashlet-title">New Entry: <span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text"  name="name"  class="form-control col-md-3 col-xs-12">
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button onclick='addRecordStatus(event)' class="btn btn-primary">Create</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <h2>Record Priority</h2>
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>
                                        <th style="width: 50%">Name</th>
                                        <th style="width: 49%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($data['priorities'] as $p) { ?>
                                    <tr>
                                        <td>
                                            <a onclick='openTextBox(event, this, "priority", <?php echo $p['id']; ?>)'><?php echo $p['name']; ?></a>
                                        </td>
                                        <td>
                                            <form id='priority-<?php echo $p['id']; ?>' style='display:none;' method='post' action=''>
                                                <input type='hidden' name='delete_entry' value='<?php echo $p['id']; ?>' />
                                                <input type='hidden' name='table' value='priority' />
                                            </form>
                                            <a href="#" onclick="if (confirm('Are you sure you want to delete this entry?')) { document.getElementById('priority-<?php echo $p['id']; ?>').submit(); }" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                        </td>
                                    </tr>   
                                <?php } ?>
                                </tbody>
                            </table>
                            <a href='' style='width:100px;' class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_record_priority">Add</a>
                            <div id="add_record_priority" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel2">New Entry</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left" id='new_record_priority'>
                                                <br>
                                                <input type="hidden" name="new_record_priority" value="1" />
                                                <div class="form-group">
                                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="dashlet-title">New Entry: <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text"  name="name"  class="form-control col-md-3 col-xs-12">
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button onclick='addRecordPriority(event)' class="btn btn-primary">Create</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <h2>Record Formats</h2>
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>
                                        <th style="width: 50%">Name</th>
                                        <th style="width: 49%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($data['record_formats'] as $f) { ?>
                                    <tr>
                                        <td>
                                            <a onclick='openTextBox(event, this, "format", <?php echo $f['id']; ?>)'><?php echo $f['name']; ?></a>
                                        </td>
                                        <td>
                                            <form id='record_format-<?php echo $f['id']; ?>' style='display:none;' method='post' action=''>
                                                <input type='hidden' name='delete_entry' value='<?php echo $f['id']; ?>' />
                                                <input type='hidden' name='table' value='record_format' />
                                            </form>
                                            <a href="#" onclick="if (confirm('Are you sure you want to delete this entry?')) { document.getElementById('record_format-<?php echo $f['id']; ?>').submit(); }" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                        </td>
                                    </tr>   
                                <?php } ?>
                                </tbody>
                            </table>
                            <a href='' style='width:100px;' class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_record_format">Add</a>
                            <div id="add_record_format" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel2">New Entry</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left" id='new_record_format'>
                                                <br>
                                                <input type="hidden" name="new_record_format" value="1" />
                                                <div class="form-group">
                                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="dashlet-title">New Entry: <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text"  name="name"  class="form-control col-md-3 col-xs-12">
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button onclick='addRecordFormat(event)' class="btn btn-primary">Create</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <!--<h2>Request Status</h2>
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th style="width: 1%">ID</th>
                                    <th style="width: 50%">Name</th>
                                    <th style="width: 49%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($data['request_statuses'] as $rs) { ?>
                                    <tr>
                                        <td><?php echo $rs['id']; ?></td>
                                        <td>
                                            <a onclick='openTextBox(event, this, "request_status", <?php echo $rs['id']; ?>)'><?php echo $rs['name']; ?></a>
                                        </td>
                                        <td>
                                            <form id='request_status-<?php echo $rs['id']; ?>' style='display:none;' method='post' action=''>
                                                <input type='hidden' name='delete_entry' value='<?php echo $rs['id']; ?>' />
                                                <input type='hidden' name='table' value='request_status' />
                                            </form>
                                            <a href="#" onclick="if (confirm('Are you sure you want to delete this entry?')) { document.getElementById('request_status-<?php echo $rs['id']; ?>').submit(); }" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                        </td>
                                    </tr>   
                                <?php } ?>
                                </tbody>
                            </table>
                            <a href='' style='width:100px;' class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_request_status">Add</a>
                            <div id="add_request_status" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel2">New Entry</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left" id='new_request_status'>
                                            <br>
                                            <input type="hidden" name="new_request_status" value="1" />
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="dashlet-title">New Entry: <span class="required">*</span>
                                                </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <input type="text"  name="name"  class="form-control col-md-3 col-xs-12">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button onclick='addRequestStatus(event)' class="btn btn-primary">Create</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>-->
                            <h2>Instructions</h2>
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th style="width: 50%">Name</th>
                                    <th style="width: 49%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($data['instructions'] as $i) { ?>
                                    <tr>
                                        <td>
                                            <a onclick='openTextBox(event, this, "instruction", <?php echo $i['id']; ?>)'><?php echo $i['name']; ?></a>
                                        </td>
                                        <td>
                                            <form id='instruction-<?php echo $i['id']; ?>' style='display:none;' method='post' action=''>
                                                <input type='hidden' name='delete_entry' value='<?php echo $i['id']; ?>' />
                                                <input type='hidden' name='table' value='instruction' />
                                            </form>
                                            <a href="#" onclick="if (confirm('Are you sure you want to delete this entry?')) { document.getElementById('instruction-<?php echo $i['id']; ?>').submit(); }" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                        </td>
                                    </tr>   
                                <?php } ?>
                                </tbody>
                            </table>
                            <a href='' style='width:100px;' class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_instruction">Add</a>
                            <div id="add_instruction" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel2">New Entry</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left" id='new_instruction'>
                                            <br>
                                            <input type="hidden" name="new_instruction" value="1" />
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="dashlet-title">New Entry: <span class="required">*</span>
                                                </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <input type="text"  name="name"  class="form-control col-md-3 col-xs-12">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button onclick='addInstruction(event)' class="btn btn-primary">Create</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <h2>Accessible Text</h2>
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th style="width: 50%">Name</th>
                                    <th style="width: 49%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($data['texts'] as $t) { ?>
                                    <tr>
                                        <td>
                                            <a onclick='openTextBox(event, this, "text", <?php echo $t['id']; ?>)'><?php echo $t['name']; ?></a>
                                        </td>
                                        <td>
                                            <form id='text-<?php echo $t['id']; ?>' style='display:none;' method='post' action=''>
                                                <input type='hidden' name='delete_entry' value='<?php echo $t['id']; ?>' />
                                                <input type='hidden' name='table' value='text' />
                                            </form>
                                            <a href="#" onclick="if (confirm('Are you sure you want to delete this entry?')) { document.getElementById('text-<?php echo $t['id']; ?>').submit(); }" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                        </td>
                                    </tr>   
                                <?php } ?>
                                </tbody>
                            </table>
                            <a href='' style='width:100px;' class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_accessible_text">Add</a>
                                <div id="add_accessible_text" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2">New Entry</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left" id='new_accessible_text'>
                                                <br>
                                                <input type="hidden" name="new_accessible_text" value="1" />
                                                <div class="form-group">
                                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="dashlet-title">New Entry: <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text"  name="name"  class="form-control col-md-3 col-xs-12">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button onclick='addAccessibleText(event)' class="btn btn-primary">Create</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Administrator Settings</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li class='pull-right'>
                                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <p>
                                    <label for="heard">On Coordinator deny, change status to:</label>
                                    <select style='max-width:300px; display:inline-block;' onchange='updateDenyStatus(event);' class="select2_single form-control">
                                        <option></option>
                                        <?php foreach ($data['request_statuses'] as $s) {
                                            echo "<option value='".$s['id']."'";
                                            if ($s['id'] == $data['settings']['coordinator_deny_status_id']) {
                                                echo " selected";
                                            }
                                            echo ">".$s['name']."</option>";
                                        } ?>
                                    </select>   
                                </p>
                                <p>
                                    <label for="heard">On Coordinator approve, change status to:</label>
                                    <select style='max-width:300px; display:inline-block;' onchange='updateApproveStatus(event);' class="select2_single form-control">
                                        <option></option>
                                        <?php foreach ($data['request_statuses'] as $s) {
                                            echo "<option value='".$s['id']."'";
                                            if ($s['id'] == $data['settings']['coordinator_approve_status_id']) {
                                                echo " selected";
                                            }
                                            echo ">".$s['name']."</option>";
                                        } ?>
                                    </select>   
                                            
                                </p>
                                <p>
                                    <label>From Email:</label>
                                    <input type="text" value='<?php echo $data['settings']['from_email']; ?>' id="from_email" name="from_email" style='max-width:300px; display:inline-block;' class="form-control">
                                </p>
                                <p>
                                    <label>Contact Phone:</label>
                                    <input type="text" value='<?php echo $data['settings']['contact_phone']; ?>' id="contact_phone" name="contact_phone" style='max-width:300px; display:inline-block;' class="form-control">
                                </p>
                                <p>
                                    <form method='post' action="">
                                    <input type='hidden' name='update_fp_text' value='1' />
                                    <label>Mass File Path Change:</label>
                                    <input type="text" id='from_text' name='from_text' style='max-width:300px; display:inline-block;' class="form-control">
                                    to 
                                    <input type="text" id='to_text' name='to_text' style='max-width:300px; display:inline-block;' class="form-control">
                                    <button type='submit' href='' style='width:100px;' class="btn btn-primary">Update</button>
                                    </form>
                                </p>
                                <form method='post' action="" style='display:inline-block;'>
                                    <input type='hidden' name='update_student_records' value='1' />
                                    <button type='submit' href='' class="btn btn-primary">Update Student Records</button>
                                </form>
                                <form method='post' action="" style='display:inline-block;'>
                                    <input type='hidden' name='update_admin_records' value='1' />
                                    <button type='submit' href='' class="btn btn-primary">Update Admin Records</button>
                                </form>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </div>