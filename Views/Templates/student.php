<div class="right_col" role="main">
    <div class="">
    <div class="page-title">
        <!--<div class="title_left">
        <h3>Book Request</h3><br>
        </div>-->
        <div class="title_right">
        <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
            <div class="input-group" style="float:right; width:90%;">         
            </div>
        </div>
        </div>
    </div>

    <div class="clearfix"></div>
    
    <!--<a id='hide-menu' class="back-to-top">Hide Menu</a>-->
    
    <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
            <h2>Student Information</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li class='pull-right'>
                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                <div class='profile_img'>
                <div id="crop-avatar">
                    <!-- Current avatar -->
                    <img class="img-responsive avatar-view" src='https://<?php echo gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME'])); ?>/<?php echo $data['picture']; ?>' alt="Picture">
                </div>
                </div>
                <h3><?php echo $data['name']['preferred_first_name']." ".$data['name']['surname']; ?></h3>

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
                                        <input type="file" name="fileToUpload" required="required">
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
                <a class="btn btn-success" href="/?controller=page&action=my_book_requests&id=<?php echo $data['current_student']['id']; ?>"><i class="fa fa-edit m-right-xs"></i>Student View</a>
                </ul>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12 profile_left">
                <strong>Net Id:</strong> <?php echo $data['net_id']; ?><br>
                <strong>Preferred Name:</strong> <?php echo $data['name']['preferred_first_name']; ?><br>
                <strong>Email:</strong> <?php echo $data['email']; ?>
                <form id='requested_format' action='' method='post'>
                    <p>
                    <label for="format">Requested Format:</label>
                    <!--<input type="text" id="format"  class="form-control" name="format" />-->
                    <select class="select2_multiple form-control" style=" max-width:300px;" name="requested_formats[]" multiple="multiple"> <!-- display:inline-block; -->
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

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
            <h2>Student Book Requests</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li class='pull-right'>
                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <table id="datatable-responsive" class="table table-bordered dt-responsive" cellspacing="0" width="100%"> <!-- table-striped -->
                <thead>
                <tr>
                    <th class="control"></th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Semester</th>
                    <th>Submitted</th>
                    <th>Modified</th>
                </tr>
                </thead>
                <tbody>
                <?php
                
                foreach ($data['requests'] as $r) {
                    echo "<tr>";
                    echo "<td></td>";
                    echo "<td style='min-width:250px;'><a href='?controller=page&action=request&id=".$r['id']."'>".$r['title']."</a></td>";
                    echo "<td>".(new RequestStatusDAO)->getById($r['status_id'])['name']."</td>";
                    echo "<td>".(new Semester)->getSemesterName($r['semester_code'])."</td>";
                    echo "<td>".$r['submitted']."</td>";
                    echo "<td>".$r['modified']."</td>";
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

    
    <div class="clearfix"></div>
</div>