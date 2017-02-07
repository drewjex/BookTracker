<div class="right_col" role="main">
    <div class="">
        <div class="page-title"></div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create New Record</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <br />
                    <form id="create-record" data-parsley-validate class="form-horizontal form-label-left" method='post' action=''>
                        <input type='hidden' name='new_record' value=1 />
                        <input type='hidden' name='request_id' value='<?php echo $data['request_id']; ?>' />
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name='title' required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Author
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text"name='author' name="last-name" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Edition
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name='edition' name="last-name" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Publisher
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name='publisher' name="last-name" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">ISBN10
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name='isbn10' name="last-name" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">ISBN13
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name='isbn13' name="last-name" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Priority
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name='priority_id' class="form-control">
                                    <?php foreach ($data['priorities'] as $p) {
                                            echo "<option value='".$p['id']."'";
                                            echo ">".$p['name']."</option>";
                                    } ?>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name='status_id' class="form-control" >
                                    <?php foreach ($data['statuses'] as $s) {
                                            echo "<option value='".$s['id']."'";
                                            /*if ($s['id'] == $data['record']['status_id']) {
                                                echo " selected";
                                            }*/
                                            echo ">".$s['name']."</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>