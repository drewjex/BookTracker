<div class="right_col" role="main">
    <div class="clearfix"></div>
        <div class="row">    
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>All Alerts</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>To</th>
                                    <th>From</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['alerts'] as $a) {
                                        echo "<tr>";
                                        echo "<td>".$a['created']."</td>";
                                        echo "<td>".$a['to_net_id']."</td>";
                                        echo "<td>".$a['from_net_id']."</td>";
                                        if ($a['type'] != "private") {
                                            echo "<td style='min-width:250px;'><a href='?controller=page&action=".$a['type']."&id=".$a['link_id']."' target='_blank'>".$a['content']."</a></td>";
                                        } else {
                                            echo "<td style='min-width:250px;'>".$a['content']."</td>";
                                        }
                                        echo "</tr>";
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>