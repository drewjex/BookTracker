<!-- bootstrap-wysiwyg -->
<script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
<script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
<script src="../vendors/google-code-prettify/src/prettify.js"></script>
<!-- bootstrap-wysiwyg -->

<script>

$(document).ready(function() {
  function initToolbarBootstrapBindings() {
    var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
        'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
        'Times New Roman', 'Verdana'
      ],
      fontTarget = $('[title=Font]').siblings('.dropdown-menu');
    $.each(fonts, function(idx, fontName) {
      fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
    });
    $('a[title]').tooltip({
      container: 'body'
    });
    $('.dropdown-menu input').click(function() {
        return false;
      })
      .change(function() {
        $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
      })
      .keydown('esc', function() {
        this.value = '';
        $(this).change();
      });

    $('[data-role=magic-overlay]').each(function() {
      var overlay = $(this),
        target = $(overlay.data('target'));
      overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
    });

    if ("onwebkitspeechchange" in document.createElement("input")) {
      var editorOffset = $('#editor').offset();

      $('.voiceBtn').css('position', 'absolute').offset({
        top: editorOffset.top,
        left: editorOffset.left + $('#editor').innerWidth() - 35
      });
    } else {
      $('.voiceBtn').hide();
    }
  }

  $('#datatable-responsive').DataTable({"order": []});

  function showErrorAlert(reason, detail) {
    var msg = '';
    if (reason === 'unsupported-file-type') {
      msg = "Unsupported format " + detail;
    } else {
      console.log("error uploading file", reason, detail);
    }
    $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
      '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
  }

  initToolbarBootstrapBindings();

  $('#editor').wysiwyg({
    fileUploadError: showErrorAlert
  });

  $('#editor2').wysiwyg({
    fileUploadError: showErrorAlert
  });

  window.prettyPrint;
  prettyPrint();
});

var table_list = $('#current_net_ids_responsive').DataTable();

function checkAdd(e, obj, list_id) {
    if (e && e.keyCode == 13) {
        addToList(e, obj, list_id);
    }
} 

$("#current_net_ids_responsive tbody").on('click', 'a.btn.btn-danger', function(event) {
  table_list
    .row($(this).parents('tr'))
    .remove()
    .draw();

  removeNetId($(this).attr('id').match(/\d+/)[0]); 
});

function addToList(event, obj, list_id) {
  event.preventDefault();
  var net_id = $(obj).closest(".col-sm-9").find(".net-id").val();
  var data = [];
  data.push(net_id);
  data.push(list_id);
  var jsonString = JSON.stringify(data);
  $.ajax({
      type: "POST",
      url: "?controller=command&action=add_to_list", 
      data: {data : jsonString}, 
      cache: false,

      success: function(response){
        table_list.row.add([
            net_id,
            "<a id='remove-"+response+"' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i> Delete </a>", 
        ]).draw(false);
      }
    });
}

function removeNetId(id) {
  $.ajax({
      type: "POST",
      url: "?controller=command&action=remove_from_list",
      data: {data : id}, 
      cache: false,

      success: function(response){
        //alert
      }
    });
}

function removeAssignedList(event, id) {
    event.preventDefault();
    $("#remove_list-"+id).submit();
}

function addList(e) {
      e.preventDefault();
      $("#new_list").submit();
  }

  function addEmail(e) {
      e.preventDefault();
      var editor_html = $("#editor").html();
      $("#email_content").val(editor_html);
      $("#new_email").submit();
  }

  function updateEmail(e) {
      e.preventDefault();
      var editor_html = $("#editor").html();
      $("#email_content").val(editor_html);
      $("#form_update_email").submit();
  }
  
  function deleteList(e, id) {
      e.preventDefault();
      if (confirm('Are you sure you want to delete this list?')) {
          $("#delete_list-"+id).submit();
      }
  }
  
  function deleteEmail(e, id) {
      e.preventDefault();
      if (confirm('Are you sure you want to delete this email?')) {
          $("#delete_email-"+id).submit();
      }
  }

  function viewAll(e, id) {
    e.preventDefault();
    if ($("#history_"+id).is(":hidden")) {
      $(".history_element").hide();
      $(".history_link").html("[View All]");
      $("#history_"+id).show();
      var link = $("#history_"+id).closest('td').find('.history_link');
      link.html("<font color='red'>[Collapse]</font>");
    } else {
      $(".history_element").hide();
      $(".history_link").html("[View All]");
    } 
  }
  
  function updateStudentList(event) {
      var list_id = event.target.value;
      var email_id = event.target.id.match(/\d+/)[0];

      var data = [];
      data.push(list_id);
      data.push(email_id);
      var jsonString = JSON.stringify(data);

      $.ajax({
          type: "POST",
          url: "?controller=command&action=update_student_list", 
          data: {data : jsonString}, 
          cache: false,

          success: function(){
            //alert("OK");
          }
        });
  }

  function updateEmailTrigger(event) {
    var trigger_column = event.target.value;
    var email_id = event.target.id.match(/\d+/)[0];

    var data = [];
    data.push(trigger_column);
    data.push(email_id);
    var jsonString = JSON.stringify(data);

    $.ajax({
        type: "POST",
        url: "?controller=command&action=update_email_trigger", 
        data: {data : jsonString}, 
        cache: false,

        success: function(){
          //alert("OK");
        }
      });
  }
  
  function getEmail(e, id) {
      e.preventDefault();
      $("#create_email").val(0);
      $("#update_email").val(id);
      $("#submit_button").html("Update");
      $.ajax({
          type: "POST",
          url: "?controller=command&action=get_email",
          data: {data : id}, 
          cache: false,
          success: function(response){
              var obj = JSON.parse(response);
              $("#email_subject").val(obj['subject']);
              $("#editor").html(obj['content']);
          }
      });
  }

  function clearEmail(type) {
      $("#email_subject").val("");
      $("#editor").html("");
      $("#email_type").val(type);
      $("#create_email").val(1);
      $("#update_email").val(0);
      $("#submit_button").html("Create");
  }
    
</script>