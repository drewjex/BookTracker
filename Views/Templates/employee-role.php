<div class="row">
<div class="clearfix"></div>
<h2><?php echo $data['role']; ?></h2>
<?php 

if (!empty($data['current_admins'])) {        
foreach ($data['current_admins'] as $admin) {
    
    ?>

    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
        <div class="well profile_view">
            <div class="col-sm-12">
            <h4 class="brief"><i><?php echo ucwords($admin['role_name']); ?></i></h4>
            <div class="left col-xs-7">
                <h2><?php echo $admin['first_name']." ".$admin['last_name']; ?></h2>
                <p><strong>Net Id: </strong> <?php echo $admin['net_id']; ?> </p>
                <ul class="list-unstyled">
                <li><i class="fa fa-building"></i> Email: <?php echo $admin['email']; ?></li>
                <li><i class="fa fa-phone"></i> Phone #: <?php echo $admin['phone']; ?></li>
                </ul>
            </div>
            <div class="right col-xs-5 text-center">
                <img src='https://<?php echo gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME'])); ?>/<?php echo $admin['picture']; ?>'alt="" class="img-circle img-responsive">
            </div>
            </div>
            <div class="col-xs-12 bottom text-center">
            <div class="col-xs-12 col-sm-8 emphasis">
                <button type="button" class="btn btn-primary btn-sm pull-left" data-toggle="modal" data-target="<?php echo "#edit-modal-".$admin['id']; ?>">
                    <i class="fa fa-user"> </i> Edit
                </button>
                <div id="<?php echo "edit-modal-".$admin['id']; ?>" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">

                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Edit User</h4>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
                                User Info:<br><br>
                                <input type="hidden" name="edit_user" value="1" />
                                <input type="hidden" name="admin_id" value='<?php echo $admin['id']; ?>' />
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dashlet-title">Net Id <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="net_id" name="net_id" value='<?php echo $admin['net_id']; ?>' class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Assigned Roles:<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="select2_single form-control" id="roles" name="role" required="required">
                                            <?php
                                                foreach ($data['roles'] as $r) {
                                                    echo "<option value='".$r['id']."'";
                                                    if ($r['id'] == $admin['role_id']) {
                                                        echo " selected";
                                                    }
                                                    echo ">".$r['name']."</option>";
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
                <form id='remove_user<?php echo $admin['id']; ?>' style='display:none;' action='' method='post'>
                    <input type='hidden' name='remove_user' value='<?php echo $admin['id']; ?>' />
                </form>
                <button type="button" class="btn btn-danger btn-sm pull-left" onclick='removeUser(event, <?php echo $admin['id']; ?>);'>
                    <i class="fa fa-user"> </i> Remove
                </button>
            </div>
                <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="<?php echo "#message-modal-".$admin['id']; ?>"> <i class="fa fa-user">
                </i> <i class="fa fa-comments-o"></i> </button>
                <div id="<?php echo "message-modal-".$admin['id']; ?>" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                <div class="modal-content">

                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Send Private Message</h4>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            Type Private Message:<br><br>
                            <input type="hidden" name="new_message" value="1" />
                            <input type="hidden" name="to_admin_id" value=<?php echo $admin['id']; ?> />
                            <p>
                                <label for="Message">Message:</label>
                                <textarea id="Message" required="required" class="form-control" name="message_content"  ></textarea>
                            </p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                    </div>

                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    
    <?php
}
} else {
    echo "There are no assigned users to this role.";
}

?>
</div>