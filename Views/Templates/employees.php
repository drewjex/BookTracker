<div class="right_col" role="main">
    <div class="">
    <div class="page-title">
        <div class="title_left">
        <h3>Current Employees</h3>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-13">
        <div class="x_panel">
            <div class="x_content">
                
                
                <?php 
                
                    $employee_view = new Employee_roleView($data['active_admins'], "Administrative Assistants");
                    $employee_view->display();
                    
                    $employee_view = new Employee_roleView($data['active_abc'], "ABC Editors");
                    $employee_view->display();
                    
                    $employee_view = new Employee_roleView($data['active_coordinators'], "UAC Coordinators");
                    $employee_view->display();
                    
                ?>
                    
                    
            <button type="submit" class="btn btn-primary pull-right" data-toggle="modal" data-target=".add-admin-modal-sm">Add Another User</button>
            <div class="modal fade add-admin-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Add Another User</h4>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
                            User Info:<br><br>
                            <input type="hidden" name="new_user" value="1" />
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dashlet-title">Net Id
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="net_id" name="net_id" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Assigned Roles:</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_single form-control" id="roles" name="role" required="required">
                                        <?php
                                            foreach ($data['roles'] as $r) {
                                                echo "<option value='".$r['id']."'>".$r['name']."</option>";
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

            </div>
            </div>
            
            </div>
        </div>
        </div>
    </div>
    </div>
</div>