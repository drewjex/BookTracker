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
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
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

<?php
    
      foreach ($data['checked'] as $c) {
        ?>
        
        <script>
        
          checkbox_id = "checkbox-<?php echo $c['status_id']; ?>";
          var checkbox = document.getElementById(checkbox_id);
          if (checkbox != null) {
            checkbox.checked = true;
            parent_obj = checkbox.parentNode;
            parent_obj.getElementsByClassName("time-checked")[0].innerHTML = "<div class='input-group date datetimepicker' id='picker-<?php echo $c['status_id']; ?>'><input type='text' class='form-control' style='height:30px' /><span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span></div>"; 
          }
          
          timestamp = new Date("<?php echo $c['completed']; ?>");
          $('.datetimepicker').datetimepicker({
              defaultDate:timestamp,
          });
        
        </script>
        
        <?php
      }
      
?>

<script>
    
      $(function() {
        $('.chart').easyPieChart({
          easing: 'easeOutElastic',
          delay: 3000,
          barColor: '#26B99A',
          trackColor: '#fff',
          scaleColor: false,
          lineWidth: 20,
          trackWidth: 16,
          lineCap: 'butt',
          onStep: function(from, to, percent) {
            $(this.el).find('.percent').text(Math.round(percent));
          }
        });
      });

      <?php $_SESSION['search_column'] = -1; ?>

      var dbtable = $('#datatable-responsive').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "?controller=command&action=link_book_records" 
      });

      $('#datatable-responsive_filter').append("&nbsp;&nbsp;<select id='search_by' style='display:inline-block;' class='select2_single form-control'>"+
                                                    "<option value='-1'>All</option>"+
                                                    "<option value='1'>Title</option>"+
                                                    "<option value='2'>ISBN10</option>"+
                                                    "<option value='3'>ISBN13</option>"+
                                                    "<option value='4'>Publisher</option>"+
                                                    "<option value='5'>Priority</option>"+
                                                "</select>");

    $('#datatable-responsive_length').closest('.col-sm-6').attr('class', 'col-sm-4');
    $('#datatable-responsive_filter').closest('.col-sm-6').attr('class', 'col-sm-8');
    $('#search_by').removeClass('select2_single');

    $('#search_by').on('change', function() {
       $.ajax({
            type: "POST",
            url: "?controller=command&action=update_search_column",
            data: {data : this.value}, 
            cache: false,

            success: function(response){
                dbtable.ajax.reload();
            }
        });
    });

      $('#datatable-responsive-2').DataTable();
      $('#datatable-responsive-3').DataTable();
      
      $(document).ready(function() {
          $('#search_book_records').on('shown.bs.modal', function() {
            $('#datatable-responsive').show();
            $(window).trigger('resize');
            $(window).trigger('resize');
          });
          $('#change_log_request').on('shown.bs.modal', function() {
            $(window).trigger('resize');
            $(window).trigger('resize');
          });
          $('#change_log_checklist').on('shown.bs.modal', function() {
            $(window).trigger('resize');
            $(window).trigger('resize');
          });
      });
      
      $(window).resize(function(){
        var width = $(window).width();
        if(width <= 927){ //1100
            $('body').toggleClass('nav-md nav-sm');
            $('body').toggleClass('nav-md nav-sm');
        }
      });
      
      $(document).resize();
      $(document).resize();
        
        $(".datetimepicker").on("dp.change", function(event) {
            var checklist_id = $(this)[0].id.match(/\d+/)[0];
            var moment_obj = $(this).data("DateTimePicker").date();
            timestamp = moment_obj.unix();
            var checklist = [];
            var params = getSearchParameters();
            checklist.push(params.id);
            checklist.push(checklist_id);
            checklist.push(timestamp);
            var jsonString = JSON.stringify(checklist);
            $.ajax({
                type: "POST",
                url: "?controller=command&action=add_checklist", 
                data: {action : "add_checklist", data : jsonString}, 
                cache: false,

                success: function(result){
                    //alert(result);
                }
            });
        });
        
        function removeRecord(e) {
          e.preventDefault();
          if (confirm('Are you sure you want to remove this record?')) {
            $("#remove_record").submit();
          }
        }
        
        function removePDF(e) {
          e.preventDefault();
          if (confirm('Are you sure you want to remove this file?')) {
            $("#remove").submit();
          }
        }

        function removeFA(e) {
          e.preventDefault();
          if (confirm('Are you sure you want to remove this file?')) {
            $("#remove_fa").submit();
          }
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
      
      var selections = [];
      selections.push(document.getElementById("request_status").value);

      function updateStatus(event) {
         var new_status = event.target.value;
         selections.push(new_status);
         
         var data = [];
         var params = getSearchParameters();
         data.push(params.id);
         data.push(new_status);
         var jsonString = JSON.stringify(data);

         $.ajax({
            type: "POST",
            url: "?controller=command&action=update_request_status", 
            data: {action : "update_request_status", data : jsonString}, 
            cache: false,

            success: function(){
              //alert("OK");
            }
          });
      }
      
      function checkSubmit(e, obj) {
          if (e && e.keyCode == 13) {
              obj.blur();
          }
      } 
      
      function assignBookRecord(e, record_id) {
        e.preventDefault();
        $("#assign_record"+record_id).submit();
      }

      function approveRequest(e) {
        e.preventDefault();
        $("#approve_request").submit();
      }

      function denyRequest(e) {
        e.preventDefault();
        $("#deny_request").submit();
      }

      function undoRequest(e) {
        e.preventDefault();
        $("#undo_approve_request").submit();
      }
      
      $.fn.textWidth = function(text, font) {
          if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
          $.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', font || this.css('font'));
          return $.fn.textWidth.fakeEl.width();
      }; 

      function addslashes( str ) {
          return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
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
        }).blur(function() {
            var new_value = event.target.value;
            $(this).parent().html("<a href='#' onclick='openTextBox(event, this, \""+db_key+"\")'>"+new_value+"</a>");
            
            var data = [];
            var params = getSearchParameters();
            data.push(params.id);
            data.push(db_key);
            if (db_key != 'semester_code') {
              data.push(new_value);
            } else {
              data.push(getSemesterCode(new_value));
            }
            var jsonString = JSON.stringify(data);
            $.ajax({
              type: "POST",
              url: "?controller=command&action=update_request", 
              data: {action : "update_request", data : jsonString}, 
              cache: false,

              success: function(){
                //alert("OK");
              }
            });
        });
        
        $(".editable").focus();
      }   

      function openTextBoxTitle(e, obj, db_key) {
        e.preventDefault();
        var value = obj.innerHTML;
        obj.parentNode.innerHTML = "<input class='editable' onKeyPress='return checkSubmit(event, this)' type='text' style='width:120px;' autofocus />";
        $(".editable").val(value);
        
        var text_width = $(".editable").textWidth();
        if (text_width < 40)
            text_width = 40;

        var new_width = $(".editable").parent().parent().width();
        $(".editable").width(new_width-80 + 'px');
        
        $(".editable").focus(function(event) {
        }).blur(function() {
            var new_value = event.target.value;
            $(this).parent().html("<a href='#' onclick='openTextBoxTitle(event, this, \""+db_key+"\")'>"+new_value+"</a>");
            
            var data = [];
            var params = getSearchParameters();
            data.push(params.id);
            data.push(db_key);
            if (db_key != 'semester_code') {
              data.push(new_value);
            } else {
              data.push(getSemesterCode(new_value));
            }
            var jsonString = JSON.stringify(data);
            $.ajax({
              type: "POST",
              url: "?controller=command&action=update_request", 
              data: {action : "update_request", data : jsonString}, 
              cache: false,

              success: function(){
                //alert("OK");
              }
            });
        });
        
        $(".editable").focus();
      }     

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

      $(document).ready(function() {
        Chart.defaults.global.legend = {
          enabled: false
        };
        $(".select2_single").select2({
          width: '300px',
          dropdownAutoWidth : true
        });
      });
      
      $('.flat').on('ifChecked', function(event) {
          var caller = event.target;
          var check_id = caller.id.match(/\d+/)[0];
          
          if (check_id == 18) {
            if (!confirm('Are you sure you want to send an automatic email to this student?')) {
                setTimeout(function() {
                  $(caller).iCheck('uncheck');
                }, 0);
                return;
            }
            //send automatic email
            $.ajax({
              type: "POST",
              url: "?controller=command&action=send_18_email",
              cache: false,
              data : {data : <?php echo $data['model']['student_id']; ?>},
              success: function(response){
                 new PNotify({
                    title: 'Successfully sent email!',
                    type: 'success',
                    styling: 'bootstrap3',
                    width: "350px",
                    delay: "1500"
                });
              }
            });
          } else if (check_id == 2) {
            if (!confirm('Are you sure you want to send an automatic email to this student?')) {
                setTimeout(function() {
                  $(caller).iCheck('uncheck');
                }, 0);
                return;
            }
            $.ajax({
              type: "POST",
              url: "?controller=command&action=send_2_email",
              cache: false,
              data : {data : <?php echo $data['model']['student_id']; ?>},
              success: function(response){
                 new PNotify({
                    title: 'Successfully sent email!',
                    /*text: 'An email was sent to the submitter of this request.',*/
                    type: 'success',
                    styling: 'bootstrap3',
                    width: "350px",
                    delay: "1500"
                });
              }
            });
          } else if (check_id == 21) {
            if (!confirm('Are you sure you want to send an automatic email to this student?')) {
                setTimeout(function() {
                  $(caller).iCheck('uncheck');
                }, 0);
                return;
            }
            $.ajax({
              type: "POST",
              url: "?controller=command&action=send_21_email",
              cache: false,
              data : {data : <?php echo $data['model']['student_id']; ?>},
              success: function(response){
                 new PNotify({
                    title: 'Successfully sent email!',
                    /*text: 'An email was sent to the submitter of this request.',*/
                    type: 'success',
                    styling: 'bootstrap3',
                    width: "350px",
                    delay: "1500"
                });
              }
            });
          }
          
          var parent_obj = caller.parentNode.parentNode;
          parent_obj.getElementsByClassName("time-checked")[0].innerHTML = "<div class='input-group date datetimepicker' id='picker-"+caller.id.match(/\d+/)[0]+"'><input type='text' class='form-control' style='height:30px' /><span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span></div>";  
          var dateNow = new Date();
          $('.datetimepicker').datetimepicker({
              defaultDate:dateNow,
          });
          
          var checklist = [];
          var params = getSearchParameters();
          checklist.push(params.id);
          checklist.push(check_id);
          checklist.push(dateNow);
          var jsonString = JSON.stringify(checklist);
          $.ajax({
              type: "POST",
              url: "?controller=command&action=add_checklist", 
              data: {action : "add_checklist", data : jsonString}, 
              cache: false,

              success: function(){
                  $(window).trigger('resize');
                  $(".datetimepicker").on("dp.change", function(event) {
                    var checklist_id = $(this)[0].id.match(/\d+/)[0];
                    var moment_obj = $(this).data("DateTimePicker").date();
                    timestamp = moment_obj.unix();
                    var checklist = [];
                    var params = getSearchParameters();
                    checklist.push(params.id);
                    checklist.push(checklist_id);
                    checklist.push(timestamp);
                    var jsonString = JSON.stringify(checklist);
                    $.ajax({
                        type: "POST",
                        url: "?controller=command&action=add_checklist", 
                        data: {action : "add_checklist", data : jsonString}, 
                        cache: false,

                        success: function(result){
                            //alert(result);
                        }
                    });
                });
              }
          });
          
          
      });
      
      $('.flat').on('ifUnchecked', function(event){
          var caller = event.target;
          var parent_obj = caller.parentNode.parentNode;
          parent_obj.getElementsByClassName("time-checked")[0].innerHTML = "";

          var checklist = [];
          var params = getSearchParameters();
          checklist.push(params.id);
          checklist.push(caller.id.match(/\d+/)[0]);
          var jsonString = JSON.stringify(checklist);
          $.ajax({
              type: "POST",
              url: "?controller=command&action=delete_checklist", 
              data: {action : "delete_checklist", data : jsonString}, 
              cache: false,

              success: function(){
                  //alert("OK");
              }
          });
      });
      
      $(".select2_multiple").select2({
          placeholder: "Please Select",
          allowClear: true
        });

      $(document).ready(function() {
        var cnt = 10;

        TabbedNotification = function(options) {
          var message = "<div id='ntf" + cnt + "' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
            "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";

          if (!document.getElementById('custom_notifications')) {
            alert('doesnt exists');
          } else {
            $('#custom_notifications ul.notifications').append("<li><a id='ntlink" + cnt + "' class='alert-" + options.type + "' href='#ntf" + cnt + "'><i class='fa fa-bell animated shake'></i></a></li>");
            $('#custom_notifications #notif-group').append(message);
            cnt++;
            CustomTabs(options);
          }
        };

        CustomTabs = function(options) {
          $('.tabbed_notifications > div').hide();
          $('.tabbed_notifications > div:first-of-type').show();
          $('#custom_notifications').removeClass('dsp_none');
          $('.notifications a').click(function(e) {
            e.preventDefault();
            var $this = $(this),
              tabbed_notifications = '#' + $this.parents('.notifications').data('tabbed_notifications'),
              others = $this.closest('li').siblings().children('a'),
              target = $this.attr('href');
            others.removeClass('active');
            $this.addClass('active');
            $(tabbed_notifications).children('div').hide();
            $(target).show();
          });
        };

        CustomTabs();

        var tabid = idname = '';

        $(document).on('click', '.notification_close', function(e) {
          idname = $(this).parent().parent().attr("id");
          tabid = idname.substr(-2);
          $('#ntf' + tabid).remove();
          $('#ntlink' + tabid).parent().remove();
          $('.notifications a').first().addClass('active');
          $('#notif-group div').first().css('display', 'block');
        });
      });
      
      jQuery(window).load(function () {
        $(window).trigger('resize'); 
      });
      
</script>