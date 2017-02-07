<!-- Select2 -->
<script src="../vendors/select2/dist/js/select2.full.min.js"></script>
<!-- Chart.js -->
<script src="../vendors/Chart.js/dist/Chart.min.js"></script>
<!-- jQuery Sparklines -->
<script src="../vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- easy-pie-chart -->
<script src="../vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

<script>
    $(".select2_multiple").select2({
        placeholder: "Please Select",
        allowClear: true
    });

    $('#datatable-responsive').DataTable();
    
    $('#datatable-responsive-2').DataTable();

    $('#datatable-responsive-3').DataTable();
    
    $('#datatable-responsive-4').DataTable();

    <?php $_SESSION['search_column'] = -1; ?>

    var table = $('#datatable-responsive-5').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "?controller=command&action=link_book_requests" 
    });

    $('#datatable-responsive-5_filter').append("&nbsp;&nbsp;<select id='search_by' style='display:inline-block;' class='select2_single form-control'>"+
                                        "<option value='-1'>All</option>"+
                                        "<option value='1'>Title</option>"+
                                        "<option value='2'>Student</option>"+
                                        "<option value='3'>Coordinator</option>"+
                                        "<option value='4'>Status</option>"+
                                        "<option value='5'>Semester</option>"+
                                        "<option value='6'>ISBN10</option>"+
                                        "<option value='7'>ISBN13</option>"+
                                        "<option value='8'>Publisher</option>"+
                                        "<option value='9'>Course</option>"+
                                    "</select>");

    $('#datatable-responsive-5_length').closest('.col-sm-6').attr('class', 'col-sm-4');
    $('#datatable-responsive-5_filter').closest('.col-sm-6').attr('class', 'col-sm-8');
    $('#search_by').removeClass('select2_single');

    $('#search_by').on('change', function() {
       $.ajax({
            type: "POST",
            url: "?controller=command&action=update_search_column",
            data: {data : this.value}, 
            cache: false,

            success: function(response){
                table.ajax.reload();
            }
        });
    });

    $(document).ready(function() {
          $('#search_book_requests').on('shown.bs.modal', function() {
            $('#datatable-responsive-5').show();
            $(window).trigger('resize');
            $(window).trigger('resize');
          });
          $('#change_log_record').on('shown.bs.modal', function() {
            $(window).trigger('resize');
            $(window).trigger('resize');
          });
          $('#change_log_formats').on('shown.bs.modal', function() {
            $(window).trigger('resize');
            $(window).trigger('resize');
          });
      });

    $(document).resize();

    $(".select2_single").select2({
        dropdownAutoWidth : true
    });
    
    $('#file_path').on('input',function(event){
        var data = [];
        var params = getSearchParameters();
        data.push(params.id);
        //alert(params.id);
        data.push(event.currentTarget.value);
        //alert(event.currentTarget.value);
        var jsonString = JSON.stringify(data);
        
         $.ajax({
            type: "POST",
            url: "?controller=command&action=update_file_path", 
            data: {data : jsonString}, 
            cache: false,

            success: function(response){
                //alert(response);
            }
        });
    });

    $('.saved-formats').on('ifChanged', function(event){
        if (event.currentTarget.checked) {
            var action = "update_saved_formats";
        } else {
            var action = "delete_saved_formats";
        }
        
        var id = event.currentTarget.id.match(/\d+/)[0];
        
        var data = [];
        var params = getSearchParameters();
        data.push(params.id);
        data.push(id);
        var jsonString = JSON.stringify(data);
        
        $.ajax({
            type: "POST",
            url: "?controller=command&action="+action,
            data: {data : jsonString}, 
            cache: false,

            success: function(response){
                //alert(response);
            }
        });
    });
    
    function removeTask(e, id) {
        e.preventDefault();
        if (confirm('Are you sure you want to remove this log entry?')) {
            $("#remove_task-"+id).submit();
        }
    }

    function removeRecord(e, id) {
        e.preventDefault();
        if (confirm('This will permanently delete this record, unattach all associated requests, and redirect you to the records screen. Are you sure you want to do this?')) {
            $("#remove_record").submit();
        }
    }

    setInterval(function() {
        updateTime(<?php echo $_GET['id']; ?>);
    }, 100);
    
    function updateTime(id) {
        //event.preventDefault();
        $.ajax({
            type: "POST",
            url: "?controller=command&action=update_time", 
            data: {action : "update_time", data : id}, 
            cache: false,

            success: function(response){
                $("#show_time").html(response);
                //alert(response);
            }
        });
    }
    
    function endTask(task_id) {
         $.ajax({
            type: "POST",
            url: "?controller=command&action=end_task",
            data: {action : "end_task", data : task_id}, 
            cache: false,

            success: function(){
              //alert("OK");
              $("#show_time").hide();
            }
          });
    }

    function assignBookRequest(e, request_id) {
        e.preventDefault();
        $("#assign_request"+request_id).submit();
      }
    
    function getSearchParameters() {
        var prmstr = window.location.search.substr(1);
        return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
    }

    function transformToAssocArray( prmstr ) {
        var params = {};
        var prmarr = prmstr.split("&");
        for ( var i = 0; i < prmarr.length; i++) {
            var tmparr = prmarr[i].split("=");
            params[tmparr[0]] = tmparr[1];
        }
        return params;
    } 
    
    function updateStatus(event) {
         var new_status = event.target.value;
         
         var data = [];
         var params = getSearchParameters();
         data.push(params.id);
         data.push(new_status);
         var jsonString = JSON.stringify(data);

         $.ajax({
            type: "POST",
            url: "?controller=command&action=update_record_status", 
            data: {action : "update_record_status", data : jsonString}, 
            cache: false,

            success: function(){
              //alert("OK");
            }
          });
      }
      
      function updatePriority(event) {
         var new_priority = event.target.value;
         
         var data = [];
         var params = getSearchParameters();
         data.push(params.id);
         data.push(new_priority);
         var jsonString = JSON.stringify(data);

         $.ajax({
            type: "POST",
            url: "?controller=command&action=update_record_priority", 
            data: {action : "update_record_priority", data : jsonString}, 
            cache: false,

            success: function(){
              //alert("OK");
            }
          });
      }
      
       function checkSubmit(e, obj)
      {
        if(e && e.keyCode == 13)
        {
            obj.blur();
        }
      } 
      
      $.fn.textWidth = function(text, font) {
          if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
          $.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', font || this.css('font'));
          return $.fn.textWidth.fakeEl.width();
      }; 

      function removeRequest(e, id) {
          e.preventDefault();
          if (confirm('Are you sure you want to unassign this request?')) {
            $("#remove_request-"+id).submit();
          }
        }
      
      function openTextBox(e, obj, db_key) {
        e.preventDefault();
        var value = obj.innerHTML;
        obj.parentNode.innerHTML = "<input class='editable' onKeyPress='return checkSubmit(event, this)' type='text' style='width:120px;' autofocus />";
        $(".editable").val(value);
        
        var text_width = $(".editable").textWidth();
        if (text_width < 40)
            text_width = 40;
        $(".editable").width(text_width + 'px');
        
        $(".editable").focus(function(event) {
            //console.log('in');
        }).blur(function() {
            //console.log('out');
            var new_value = event.target.value;
            $(this).parent().html("<a href='#' onclick='openTextBox(event, this, \""+db_key+"\")'>"+new_value+"</a>");
            
            var data = [];
            var params = getSearchParameters();
            data.push(params.id);
            data.push(db_key);
            data.push(new_value);
            var jsonString = JSON.stringify(data);
            $.ajax({
              type: "POST",
              url: "?controller=command&action=update_record", 
              data: {action : "update_record", data : jsonString}, 
              cache: false,

              success: function(){
                //alert("OK");
              }
            });
        });

        
        
        $(".editable").focus();
      } 

      function openTextBoxTimeLog(e, obj, id, db_key) {
        e.preventDefault();
        var value = obj.innerHTML;
        obj.parentNode.innerHTML = "<input class='editable' onKeyPress='return checkSubmit(event, this)' type='text' style='width:120px;' autofocus />";
        $(".editable").val(value);
        
        var text_width = $(".editable").textWidth();
        if (text_width < 40)
            text_width = 40;
        $(".editable").width(text_width + 'px');
        
        $(".editable").focus(function(event) {
            //console.log('in');
        }).blur(function() {
            //console.log('out');
            var new_value = event.target.value;
            $(this).parent().html("<a href='#' onclick='openTextBoxTimeLog(event, this, "+id+", \""+db_key+"\")'>"+new_value+"</a>");
            
            var data = [];
            var params = getSearchParameters();
            data.push(id);
            data.push(db_key);
            if (db_key != 'semester_code') {
              data.push(new_value);
            } else {
              data.push(getSemesterCode(new_value));
            }
            var jsonString = JSON.stringify(data);
            $.ajax({
              type: "POST",
              url: "?controller=command&action=update_time_log", 
              data: {action : "update_time_log", data : jsonString}, 
              cache: false,

              success: function(){
                //alert("OK");
              }
            });
        });

         function getSemesterCode(semester) {
            var words = semester.split(" ");
            if (words.length == 2) {
                switch (words[0]) {
                case "Winter":
                    return words[1]+"1";
                break;
                case "Spring":
                    return words[1]+"3";
                break;
                case "Summer":
                    return words[1]+"4";
                break;
                case "Fall":
                    return words[1]+"5";
                break;
                }
            } else if (words.length == 4) {
            var word = words[0]+" "+words[1]+" "+words[2];
            switch (word) {
                case "Winter Block 2":
                return words[3]+"2";
                break;
                case "Fall Block 2":
                return words[3]+"6";
                break;
            }
            } else {
            return "20165";
            }
        }
        
        $(".editable").focus();
      }    
      
</script>