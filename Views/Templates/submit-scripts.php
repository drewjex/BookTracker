<!-- bootstrap-daterangepicker -->
<script src="js/moment/moment.min.js"></script>
<script src="js/datepicker/daterangepicker.js"></script>
<!-- bootstrap-wysiwyg -->
<script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
<script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
<script src="../vendors/google-code-prettify/src/prettify.js"></script>
<!-- jQuery Tags Input -->
<script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<!-- Switchery -->
<script src="../vendors/switchery/dist/switchery.min.js"></script>
<!-- Select2 -->
<script src="../vendors/select2/dist/js/select2.full.min.js"></script>
<!-- Parsley -->
<script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
<!-- Autosize -->
<script src="../vendors/autosize/dist/autosize.min.js"></script>
<!-- jQuery autocomplete -->
<script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
<!-- starrr -->
<script src="../vendors/starrr/dist/starrr.js"></script>

<script>

$( "#semester" ).on('change', function() {
  checkSemester();
});

function checkSemester() {
  if($('#semester').val() != "-Select-") {

      $("#pending_response").show();

      $.ajax({
        type: "POST",
        url: "?controller=command&action=get_courses", 
        data: {data : $('#semester').val()}, 
        cache: false,

        success: function(response){

          $("#pending_response").hide();
          var obj = JSON.parse(response);
          $("#course_schedule").empty();
          $("#course_schedule").append($("#copyable_div1").html());

          if (obj.length == 0) {
              $("#course_schedule").append("<div style='margin: 0 auto; width:48%;'> <strong>No courses were found for the selected semester.</strong></div>");
          } else {

              for (var i=0; i<obj.length; i++) {

                var label = "<strong>"+obj[i].department+" "+obj[i].courseNumber+" Section "+obj[i].sections+"</strong>";
                $("#course_schedule").append($("#copyable_div2").html());
                var div2_elements = $(".course_label");
                var element = div2_elements.eq(div2_elements.length-1);
                element.html(label);

                for (var j=0; j<obj[i].adoptions.length; j++) {

                  var book_label = obj[i].adoptions[j].title;
                  var submitted = obj[i].adoptions[j].submitted;

                  if (submitted || book_label.indexOf("iClicker") !== -1 || book_label.indexOf("ICLICKER") !== -1 || book_label.indexOf("LDS SCRIPTURES") !== -1 || book_label.indexOf("LDS Scriptures") !== -1) {
                    $("#course_schedule").append($("#copyable_div5").html());
                  } else {
                    $("#course_schedule").append($("#copyable_div3").html());
                  }

                  var div3_elements = $(".book_label");
                  var element = div3_elements.eq(div3_elements.length-1);

                  element.html(book_label);
                  if (submitted) {
                    element.append("<font color='red'> [Already Submitted]</font>");
                  }
                  
                  var element = $(".flat").eq($(".flat").length-1);
                  element.attr('name', i+"-"+j);
                }

                if (obj[i].adoptions.length == 0) {
                  $("#course_schedule").append("<div style='margin: 0 auto; width:48%;'>No books currently listed as required on BYU Booklist. Please contact your professor to confirm if you need a book for this course.</div><br>"); //No books required for this course. Please contact your professor.
                }
            }

            $('.checkable').iCheck({checkboxClass: 'icheckbox_flat-green',radioClass: 'iradio_flat-green'});
            $('.uncheckable').iCheck('disable');
            
            $('#course_schedule').iCheck({checkboxClass: 'icheckbox_flat-green',radioClass: 'iradio_flat-green'});
            $("#submitted_books").append("<input id='json' type='hidden' name='json' value="+JSON.stringify(obj)+" />");
            
            $('<input type="hidden" name="json"/>').val(response).appendTo('#submitted_books');

            $(".flat").on('ifChecked', function() {
                var form_element = $("#submitted_books");
                var input_id = $(this).attr("name");
                form_element.append("<input id='"+input_id+"' type='hidden' name='selected_books[]' value='"+input_id+"' />");
            });
            
            $(".flat").on('ifUnchecked', function() {
                var input_id = $(this).attr("name");
                $("#"+input_id).remove();
            });
          }
        }
      });
  }
}

</script>