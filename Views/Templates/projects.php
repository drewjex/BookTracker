<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Assigned Records</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <p>List of current assigned book records and their current status.</p>

                    <!-- start project list -->
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive"> <!-- table table-striped projects -->
                      <thead>
                        <tr>
                          <th style="width: 30%">Book Record Name</th>
                          <th>Assigned Editor(s)</th>
                          <th>Time Worked (H:m:s):</th>
                          <th style='width: 15%'>Status</th>
                          <th style="width: 20%">Priority</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        
                          foreach ($data['assigned_records'] as $a) {
                            ?>
                              <tr>
                              <td>
                                <a href='?controller=page&action=record&id=<?php echo $a['id']; ?>'><?php echo $a['title']; ?></a>
                                <br />
                                <small>Assigned <?php echo $a['created']; ?></small>
                              </td>
                              <td>
                                <ul class="list-inline">
                                  <?php 
                                      foreach ($a['editors'] as $e) {

                                        ?>

                                          <li>
                                            <?php echo $e['net_id']; ?>
                                            <!--<img src='https://<?php echo gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME'])); ?>/<?php echo $e['picture']; ?>' class="avatar" alt="Avatar">-->
                                          </li>

                                        <?php
                                      }
                                  ?>
                                  
                                  <!--<li>
                                    <img src="images/user.png" class="avatar" alt="Avatar">
                                  </li>
                                  <li>
                                    <img src="images/user.png" class="avatar" alt="Avatar">
                                  </li>
                                  <li>
                                    <img src="images/user.png" class="avatar" alt="Avatar">
                                  </li>-->
                                </ul>
                              </td>
                              <!--<td class="project_progress">
                                <div class="progress progress_sm">
                                  <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="57"></div>
                                </div>
                                <small>57% Complete</small>
                              </td>-->
                              <td>
                                 <?php echo $a['total_time']; ?>
                              </td>
                              <td>
                                <button type="button" class="btn btn-success btn-xs"><?php echo $a['status']; ?></button>
                              </td>
                              <td>
                                <?php echo (new PriorityDAO)->getById($a['priority_id'])['name']; ?>
                                <!--<a href="?controller=page&action=record&id=<?php echo $a['id']; ?>" target='_blank' class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>-->
                                <!--<a href="#" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>-->
                              </td>
                            </tr>

                            <?php
                          }

                        ?>
                  
                      </tbody>
                    </table>
                    <!-- end project list -->

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->