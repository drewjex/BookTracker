<table class="table table-striped responsive">
    <thead>
    <tr>
        <th style="width: 30%">Book Title</th>
        <th style="width: 1%">Approved</th>
        <th style="width: 1%">Proof of Purchase Received</th>
        <th style="width: 1%">Proof of Purchase Accepted</th>
        <th style="width: 1%">Posted</th>
        <th>Status</th>
        <th style="width: 35%">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php 
    
        if ($data['requests'] != null) {
        foreach ($data['requests'] as $r) {
            ?>
            
            <tr>
                <td>
                <a><strong><?php echo $r['title']; ?></strong>
                <?php 
                
                    if ($r['status_id'] == 31) { //REQUEST STATUS
                        echo "<font size='2' color='red'> [Requested to Cancel]</font>"; 
                    } else if ($r['status_id'] == 32 || $r['status_id'] == 33) { //REQUEST STATUS
                        if (!$r['accepted'] && !$r['pending_accepted']) { 
                            echo "<font size='2' color='red'> [Denied]</font>";
                        } else {
                            echo "<font size='2' color='red'> [Cancelled]</font>";
                        }
                    } else if (!$r['accepted'] && !$r['pending_accepted']) { 
                        echo "<font size='2' color='red'> [Denied]</font>";
                    } else if (isset($r['std_pvd_cpy']) && $r['std_pvd_cpy']) {
                        echo "<font size='2' color='blue'> [Bring in Physical Copy of Book]</font>";
                    } else if (isset($r['cut_scn_end']) && $r['cut_scn_end']) {
                        echo "<font size='2' color='blue'> [Ready for Student Pickup]</font>";
                    }
                
                ?>
                </a>
                <br />
                <small><?php echo $r['submitted']; ?></small>
                </td>
                <td>
                <ul class="list-inline">
                    <li>
                    <?php if ($r['accepted']) { ?>
                        <i class="fa fa-check-square-o"></i> 
                    <?php } else { ?>
                        <i class="fa fa-square-o"></i>
                    <?php } ?>
                    <span class='head-text'>Approved </span>
                    </li>
                </ul>
                </td>
                <td>
                <ul class="list-inline">
                    <li>
                    <?php if ($r['proof_exists']) { ?>
                        <i class="fa fa-check-square-o"></i> 
                    <?php } else { ?>
                        <i class="fa fa-square-o"></i>
                    <?php } ?>
                    <span class='head-text'>Proof of Purchase Received </span>
                    </li>
                </ul>
                </td>
                <td>
                <ul class="list-inline">
                    <li>
                    <?php if ($r['proof']) { ?>
                        <i class="fa fa-check-square-o"></i>
                    <?php } else { ?>
                        <i class="fa fa-square-o"></i>
                    <?php } ?>
                    <span class='head-text'>Proof of Purchase Accepted </span>
                    </li>
                </ul>
                </td>
                <td>
                <ul class="list-inline">
                    <li>
                    <?php if ($r['posted']) { ?>
                        <i class="fa fa-check-square-o"></i>
                    <?php } else { ?>
                        <i class="fa fa-square-o"></i>
                    <?php } ?>
                    <span class='head-text'>Posted to Web </span>
                    </li>
                </ul>
                </td>
                <!--<td class="project_progress">
                <div class="progress progress_sm">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="57"></div>
                </div>
                <small>57% Complete</small>
                </td>-->
                <td>
                <button type="button" class="btn btn-success btn-xs"><?php echo $r['status']; ?></button>
                </td>
                <td>
                <?php 

                //if current semester...
                if ($r['semester_code'] == BYULINK::getYearTerm()) {
                
                    if ($r['proof_exists']) {
                        echo "<a href='".$r['pofp_obj']['pdf_url']."' class='btn btn-primary btn-xs' target='_blank'><i class='fa fa-folder'></i> View Proof of Purchase </a>";
                        echo "<form id='remove-".$r['id']."' style='display:none;' action='' method='post'>";
                        echo "<input type='hidden' name='remove_pdf' value='1' />";
                        echo "<input type='hidden' name='request_id' value='".$r['id']."' />";
                        echo "</form>";
                        echo "<a href='#' onclick='removePDF(event, ".$r['id'].");' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i> Remove Proof of Purchase </a>";
                    } else {
                        
                    ?> 
                    
                    <a href="" data-toggle="modal" data-target="#pofp-modal-sm-<?php echo $r['id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Submit Proof of Purchase </a>
                    <div id="pofp-modal-sm-<?php echo $r['id']; ?>"class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Attach File</h4>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                Select File to attach <strong><font color='red'>(only .pdf, .jpg, .jpeg, or .png accepted):</font></strong><br><br>
                                <input type="hidden" name="upload_file" value="1" />
                                <input type='hidden' name='request_id' value='<?php echo $r['id']; ?>' />
                                <input type="file" accept=".jpg,.png,.jpeg,.pdf" name="fileToUpload" id="fileToUpload" required="required">
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        </div>

                    </div>
                    </div>
                    </div>
                    
                    <?php } 
                    
                    if ($r['status_id'] == 31) { //REQUEST STATUS ?>
                    <!--<a class="btn btn-danger btn-xs cancelled"><i class="fa fa-trash-o"></i> Cancellation Request Sent </a>-->
                    <?php } else if ($r['status_id'] == 32 || $r['status_id'] == 33) { //REQUEST STATUS ?>
                    <!--<a class="btn btn-danger btn-xs cancelled"><i class="fa fa-trash-o"></i> Cancelled</a>-->
                    <?php } else { ?>
                    <form id='cancel-<?php echo $r['id']; ?>' style='display:none;' action='' method='post'>
                        <input type='hidden' name='request_cancel' value='1' />
                        <input type='hidden' name='request_id' value='<?php echo $r['id']; ?>' />
                    </form>
                    <a href="#" onclick='requestCancel(event, <?php echo $r['id']; ?>);' class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Request to Cancel </a>
                <?php 
                    } 
                }    
                ?>
                </td>
            </tr>

            <?php
        }
        } 

    ?>
    </tbody>
</table>