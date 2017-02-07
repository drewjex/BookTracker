<div class="right_col" role="main">
    <div class="">
    <div class="page-title">

    </div>
    
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Student Lists</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li class='pull-right'>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <!-- start project list -->
                    <table class="table table-striped projects">
                      <thead>
                        <tr>
                          <th style="width: 30%">List Description</th>
                          <th style="width: 20%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                          
                          <?php 
                          
                            foreach ($data['email_lists'] as $list) {
                                
                                ?>
                                <tr>
                                <td><?php echo $list['name']; ?></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#edit_list_modal-<?php echo $list['id']; ?>"  class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit List </a>
                                    <div id="edit_list_modal-<?php echo $list['id']; ?>" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                            <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel2">List of NetIDs</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left" id='update_list'>
                                                    <br>
                                                    <input type="hidden" name="update_list" value="<?php echo $list['id']; ?>" />
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="dashlet-title">List Name: 
                                                        </label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text"  name="name" value='<?php echo $list['name']; ?>'  class="form-control col-md-3 col-xs-12">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="dashlet-title">Add Net ID:
                                                        </label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" onKeyPress='return checkAdd(event, this, <?php echo $list['id']; ?>)' style='width:85%;' class="form-control col-md-3 col-xs-12 net-id" />
                                                        <button type="button" onclick='addToList(event, this, <?php echo $list['id']; ?>);' class="btn btn-primary pull-right">Add</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="dashlet-title">Current Net IDs: 
                                                      </label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                          <table id='current_net_ids_responsive' style='width:100%;' class="table table-striped table-bordered dt-responsive">
                                                            <thead>
                                                              <tr>
                                                                <th style="width: 30%">Net ID</th>
                                                                <th style="width: 70%">Delete</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody id='tbody-<?php echo $list['id']; ?>'>
                                                              <?php 
                                                              
                                                                foreach ($list['people'] as $l) {
                                                                  ?>
                                                                  
                                                                    <tr id="tr-<?php echo $l['id']; ?>">
                                                                      <td><?php echo BYULINK::getNetID($l['person_id'], 'PERSON_ID'); ?></td>
                                                                      <td><a id='remove-<?php echo $l['id']; ?>' class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a></td> <!-- onclick='removeNetId(event, <?php echo $l['id']; ?>)' -->
                                                                    </tr>
                                                                  
                                                                  <?php
                                                                }
                                                              
                                                              ?>
                                                            </tbody>
                                                          </table>
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
                                     <form id='delete_list-<?php echo $list['id']; ?>' style='display:none;' method='post' action=''>
                                        <input type='hidden' name='delete_list' value='<?php echo $list['id']; ?>' />
                                    </form>
                                    <a href="#" onclick='deleteList(event, <?php echo $list['id']; ?>)' class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                </td>
                                </tr>
                                <?php
                                
                            }
                          
                          ?>
                       
                        
                      </tbody>
                    </table>
                    <a href='' data-toggle="modal" data-target="#create_list_modal" style='display:inline-block' class="btn btn-success pull-right">Create New List</a>
                    <div id="create_list_modal" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel2">New List</h4>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left" id='new_list'>
                                    <br>
                                    <input type="hidden" name="create_list" value="1" />
                                    <div class="form-group">
                                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="dashlet-title">New List Name: 
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text"  name="name"  class="form-control col-md-3 col-xs-12">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button onclick='addList(event)' class="btn btn-primary">Create</button>
                            </form>
                            </div>
                            </div>
                            </div>
                            </div>
                </div>
              </div>
        </div>

              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Semester Emails</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class='pull-right'>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- start project list -->
                    <table class="table table-striped projects">
                      <thead>
                        <tr>
                          <th style="width: 20%">Email Title</th>
                          <th style="width: 20%">Student List</th>
                          <th style="width: 20%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                          
                          <?php 
                          
                            foreach ($data['semester_emails'] as $email) {
                                
                                ?>
                                <tr>
                                <td><?php echo $email['title']; ?></td>
                                <td>
                                  <select id="list-<?php echo $email['id']; ?>" class="select2_single form-control" onchange='updateStudentList(event);' style='max-width:300px;'>
                                      <option></option>
                                      <?php
                                        foreach ($data['email_lists'] as $t) {
                                            echo "<option value='".$t['id']."'";
                                            if ($email['email_list_id'] == $t['id']) {
                                                echo " selected";
                                            }
                                            echo ">".$t['name']."</option>";
                                        }
                                      ?>
                                  </select> 
                                </td>
                                <td>
                                    <a onclick='getEmail(event, <?php echo $email['id']; ?>)' data-toggle="modal" data-target="#create_email_modal" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> View/Edit </a>
                                    <form id='send_email_form-<?php echo $email['id']; ?>' style='display:none;' method='post' action=''>
                                        <input type='hidden' name='send_email' value='<?php echo $email['id']; ?>' />
                                    </form>
                                    <?php if ($email['email_list_id'] != null && $email['email_list_id'] != 0) { ?>
                                        <a onclick="if (confirm('Are you sure you want to send this email?')) { document.getElementById('send_email_form-<?php echo $email['id']; ?>').submit(); }" class="btn btn-primary btn-xs"><i class="fa fa-send"></i> Send to List </a>
                                    <?php } ?>
                                    <form id='delete_email-<?php echo $email['id']; ?>' style='display:none;' method='post' action=''>
                                        <input type='hidden' name='delete_email' value='<?php echo $email['id']; ?>' />
                                    </form>
                                    <a onclick='deleteEmail(event, <?php echo $email['id']; ?>)' class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                </td>
                                </tr>
                                <?php
                                
                            }
                          
                          ?>
                       
                      </tbody>
                    </table>
                    <!-- end project list -->
                    <a href='#' onclick='clearEmail(0);' data-toggle="modal" data-target="#create_email_modal" style='display:inline-block' class="btn btn-success pull-right">Create New email</a>
                    
                  </div>
                </div>
              </div>

        <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Automatic Emails</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class='pull-right'>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- start project list -->
                    <table class="table table-striped projects">
                      <thead>
                        <tr>
                          <th style="width: 20%">Email Title</th>
                          <th style="width: 20%">Trigger</th>
                          <th style="width: 20%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                          
                          <?php 
                          
                            foreach ($data['automatic_emails'] as $email) {
                                
                                ?>
                                <tr>
                                <td><?php echo $email['title']; ?></td>
                                <td>
                                  <select id="trigger-<?php echo $email['id']; ?>" class="select2_single form-control" onchange='updateEmailTrigger(event);' style='max-width:300px;'>
                                      <option></option>
                                      <?php
                                        foreach ($data['triggers'] as $t) {
                                            echo "<option value='".$t['column_name']."'";
                                            if ($email['id'] == $data['settings'][$t['column_name']]) {
                                                echo " selected";
                                            }
                                            echo ">".$t['name']."</option>";
                                        }
                                      ?>
                                  </select> 
                                </td>
                                <td>
                                    <a href="#" onclick='getEmail(event, <?php echo $email['id']; ?>)' data-toggle="modal" data-target="#create_email_modal" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> View/Edit </a>
                                    <form id='delete_email-<?php echo $email['id']; ?>' style='display:none;' method='post' action=''>
                                        <input type='hidden' name='delete_email' value='<?php echo $email['id']; ?>' />
                                    </form>
                                    <a href="#" onclick='deleteEmail(event, <?php echo $email['id']; ?>)' class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                </td>
                                </tr>
                                <?php
                                
                            }
                          
                          ?>
                       
                        
                      </tbody>
                    </table>
                    <!-- end project list -->
                    <a href='#' onclick='clearEmail(1);' data-toggle="modal" data-target="#create_email_modal" style='display:inline-block' class="btn btn-success pull-right">Create New email</a>
                    <div id="create_email_modal" class="modal fade message-modal-sm pull-left" style='text-align:left;' tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel2">Email Information</h4>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left" id='new_email'>
                                    <br>
                                    <input type="hidden" id='create_email' name="create_email" value="" />
                                    <input type='hidden' name='update_email' id='update_email' value="" />
                                    <input type='hidden' id='email_content' name='email_content' value='' />
                                    <input type='hidden' id='email_type' name='email_type' value='0' />
                                    <div class="form-group">
                                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="email_subject">Email Subject: 
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="email_subject" name='email_subject' class="form-control col-md-3 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="dashlet-title">Email Content: 
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">

                                          <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                                            <div class="btn-group">
                                              <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                              <ul class="dropdown-menu">
                                              </ul>
                                            </div>

                                            <div class="btn-group">
                                              <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                              <ul class="dropdown-menu">
                                                <li>
                                                  <a data-edit="fontSize 5">
                                                    <p style="font-size:17px">Huge</p>
                                                  </a>
                                                </li>
                                                <li>
                                                  <a data-edit="fontSize 3">
                                                    <p style="font-size:14px">Normal</p>
                                                  </a>
                                                </li>
                                                <li>
                                                  <a data-edit="fontSize 1">
                                                    <p style="font-size:11px">Small</p>
                                                  </a>
                                                </li>
                                              </ul>
                                            </div>

                                            <div class="btn-group">
                                              <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                              <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                              <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                              <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                            </div>

                                            <div class="btn-group">
                                              <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                              <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                              <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                              <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                            </div>

                                            <div class="btn-group">
                                              <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                              <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                              <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                              <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                            </div>

                                            <div class="btn-group">
                                              <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                                              <div class="dropdown-menu input-append">
                                                <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                                                <button class="btn" type="button">Add</button>
                                              </div>
                                              <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                            </div>

                                            <div class="btn-group">
                                              <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                                              <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                                            </div>

                                            <div class="btn-group">
                                              <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                              <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                            </div>
                                          </div>

                                            <div id="editor" class="editor-wrapper"></div>

                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button onclick='addEmail(event)' id='submit_button' class="btn btn-primary">Create</button>
                            </form>
                            </div>
                            </div>
                            </div>
                            </div>
                  </div>
                </div>
              </div>
        

        <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Email History</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style='width:20%;'>Email</th>
                                    <th style='width:20%;'>Date</th>
                                    <th style='width:60%;'>Recipients</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                                foreach ($history as $h) {
                                  $array = json_decode($h['recipients']);
                                  echo "<tr>";
                                  echo "<td>".$h['email_name']."</td>";
                                  echo "<td>".$h['date']."</td>";
                                  if (count($array) == 1) {
                                      echo "<td>".$array[0]."</td>";
                                  } else {
                                    echo "<td><a class='history_link' href='' onclick='viewAll(event, ".$h['id'].");'>[View All]</a><div class='history_element' id='history_".$h['id']."'>";
                                    foreach ($array as $a) {
                                      echo $a."<br>";
                                    }
                                  }
                                  echo "</div></td>"; 
                                  echo "</tr>";
                                }
                              ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
    </div>
</div>
<!-- /page content -->