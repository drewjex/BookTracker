<div class="col-md-12 col-sm-12 col-xs-12 sortable" id="<?php echo $data['id']; ?>">
    <div class="x_panel">
        <div class="x_title dashlet_title">
            <h2><?php echo $data['title']; ?> <small><?php echo $data['small_title']; ?></small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li>
                    <a onclick="refreshdashlet(<?php echo $data['id']; ?>)"><i class="fa fa-refresh"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a data-toggle="modal" data-target="#<?php echo "id-".$data['id']; ?>">Edit</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a onclick="confirmDelete(<?php echo $data['id']; ?>)"><i class="fa fa-close"></i></a> 
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="modal fade" style="z-index:9999;" id="<?php echo "id-".$data['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-close"></i></span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Edit Dashlet</h4>
                    </div>
                    <div class="modal-body">
                        <h4>Dashlet Settings</h4>
                        <div class="x_content">
                        <br />
                            <form id="update-dashlet<?php echo "id-".$data['id']; ?>" name="update-dashlet" data-parsley-validate class="form-horizontal form-label-left" method="post">
                                <input type="hidden" name="update-dashlet" value="<?php echo $data['id']; ?>"/>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dashlet-title">Dashlet Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="dashlet-title" name="title" value="<?php echo $data['title']; ?>" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Dashlet Type <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select id="type-select<?php echo "-".$data['id']; ?>" name="type-select" class="select2_single form-control dashlet-type" tabindex="-1" required="required">
                                            <option></option>
                                            <option value="request" <?php echo ($data['blob']->type == "request") ? "selected" : ""; ?>>Book Request</option>
                                            <option value="record" <?php echo ($data['blob']->type == "record") ? "selected" : ""; ?>>Book Record</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="request-info<?php echo "-".$data['id']; ?>" class="request-info" <?php echo ($data['blob']->type == "record") ? "style='display:none;'" : "style='display:block;'"; ?>>
                                    <div class="form-group" id="column-requests">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Columns to Display <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_multiple form-control" id="request-columns<?php echo "-".$data['id']; ?>" name="request-columns[]" multiple="multiple" required="required">
                                                <?php

                                                    $options = ['title' => 'Title',  
                                                                'name' => 'Status', 
                                                                'full_name' => 'Semester', 
                                                                'submitted' => 'Submitted',
                                                                'modified' => 'Modified', 
                                                                'net_id' => 'Student'];

                                                    foreach ($options as $key => $value) {
                                                        echo "<option value=$key";
                                                        if ($data['blob']->type == "request") {
                                                            if (in_array($key, $data['blob']->columns)) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        echo ">".$value."</option>";
                                                    }
                                                    
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Semester/Term <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_multiple form-control" id="semester<?php echo "-".$data['id']; ?>" name="semester[]" multiple="multiple" required="required">
                                                <?php

                                                    foreach ((new Semester)->getSemestersDashlet(4) as $key => $value) {
                                                        echo "<option value='".$key."'";
                                                        if ($data['blob']->type == "request") {
                                                            if (in_array($key, $data['blob']->semester)) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        echo ">".$value."</option>";
                                                    }
                                                
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Request Status <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_multiple form-control" id="status<?php echo "-".$data['id']; ?>" name="status[]"  multiple="multiple" required="required">
                                                <?php

                                                    foreach ((new RequestStatusDAO)->getAll() as $s) {
                                                        echo "<option value='".$s['id']."'";
                                                        if ($data['blob']->type == "request") {
                                                            if (in_array($s['id'], $data['blob']->status)) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        echo ">".$s['name']."</option>";
                                                    }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="record-info<?php echo "-".$data['id']; ?>" class="record-info" <?php echo ($data['blob']->type == "request") ? "style='display:none;'" : "style='display:block;'"; ?>> <!-- we need to specifiy this with id so that only one works -->
                                    <div class="form-group" id="column-records">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Columns to Display <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_multiple form-control" id="record-columns<?php echo "-".$data['id']; ?>" name="record-columns[]" multiple="multiple" required="required">
                                                <?php
                                                
                                                    $options = ['title' => 'Title',  
                                                                'p.name' => 'Priority',
                                                                'rs.name' => 'Status',
                                                                'br.created' => 'Created',
                                                                'modified' => 'Modified']; 
                                                                
                                                    foreach ($options as $key => $value) {
                                                        echo "<option value=$key";
                                                        if ($data['blob']->type == "record") {
                                                            if (in_array($key, $data['blob']->columns)) {
                                                                echo " selected";
                                                            }
                                                        }
                                                        echo ">".$value."</option>";
                                                    }
                                                
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Assigned Editor <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="select2_single form-control" id="editors<?php echo "-".$data['id']; ?>" multiple="multiple" name="editors[]" tabindex="-1" required="required">
                                                    <?php
                                                        foreach ((new AdminDAO)->getActiveABC() as $a) {
                                                            echo "<option value='".$a['id']."'";
                                                            if ($data['blob']->type == "record") {
                                                                if (in_array($a['id'], $data['blob']->editor)) {
                                                                    echo " selected";
                                                                }
                                                            }
                                                            echo ">".BYULINK::getNetID($a['person_id'])."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span></label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <select class="select2_multiple form-control" id="record_status<?php echo "-".$data['id']; ?>" name="record_status[]" multiple="multiple" required="required">
                                                        <?php
                                                            foreach ((new RecordStatusDAO)->getAll() as $s) {
                                                                echo "<option value='".$s['id']."'";
                                                                if ($data['blob']->type == "record") {
                                                                    if (in_array($s['id'], $data['blob']->status)) {
                                                                        echo " selected";
                                                                    }
                                                                }
                                                                echo ">".$s['name']."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" onclick="document.getElementById('update-dashlet<?php echo "id-".$data['id']; ?>').submit();">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_content">
                    <table id="dashlet_table-<?php echo $data['id']; ?>" class="table table-striped table-bordered dt-responsive dashlet-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="control"></th>
                                <?php 
                                    if ($data['blob']->type == "request") {
                                        $options = ['title' => 'Title', 
                                                    'name' => 'Status', 
                                                    'full_name' => 'Semester', 
                                                    'submitted' => 'Submitted',
                                                    'modified' => 'Modified', 
                                                    'net_id' => 'Student'];
                                    } else if ($data['blob']->type == "record") {
                                        $options = ['title' => 'Title',  
                                                    'p.name' => 'Priority',
                                                    'rs.name' => 'Status',
                                                    'br.created' => 'Created',
                                                    'modified' => 'Modified']; 
                                    }

                                    foreach ($data['columns'] as $c) {
                                        echo "<th>".$options[$c]."</th>";
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>