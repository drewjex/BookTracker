function updateForm() {
      var value = document.getElementById("type-select").value;
      if (value == "request") {
        document.getElementById("request-info").style.display = "block";
        document.getElementById("record-info").style.display = "none";  
        document.getElementById("record-columns").required = false;
        document.getElementById("editors").required = false;
        document.getElementById("record_status").required = false;
        document.getElementById("request-columns").required = true;
        document.getElementById("semester").required = true;
        document.getElementById("status").required = true;
      } else if (value == "record") {
        document.getElementById("request-info").style.display = "none";
        document.getElementById("record-info").style.display = "block";
        document.getElementById("request-columns").required = false;
        document.getElementById("semester").required = false;
        document.getElementById("status").required = false;
        document.getElementById("record-columns").required = true;
        document.getElementById("editors").required = true;
        document.getElementById("record_status").required = true;
      }
  }
  
  function confirmDelete(dashlet_id) {
    if (confirm('Are you sure you want to delete this dashlet?')) {
        $.ajax({
            type: "POST",
            url: "?controller=command&action=delete", 
            data: {action : "delete", data : dashlet_id}, 
            cache: false,

            success: function(){
                document.getElementById(dashlet_id).style.display = "none";
                new PNotify({
                    title: 'Successfully deleted Dashlet!',
                    type: 'success',
                    styling: 'bootstrap3',
                    width: "350px",
                    delay: "1500"
                });
            }
        });
    } 
  }
  
  $(document).ready(function() {
    $(".dashlet-type").change(function(event) {
      var id = event.target.id.match(/\d+/)[0];
      var type = document.getElementById(event.target.id).value;
      if (type == "request") {
        document.getElementById("request-info-"+id).style.display = "block";
        document.getElementById("record-info-"+id).style.display = "none";  
      } else if (type == "record") {
        document.getElementById("request-info-"+id).style.display = "none";
        document.getElementById("record-info-"+id).style.display = "block";
      }
    });
  });
  
  $(document).ready(function() {
    var handleDataTableButtons = function() {
      if ($("#datatable-buttons").length) {
        $("#datatable-buttons").DataTable({
          dom: "Bfrtip",
          buttons: [
            {
              extend: "copy",
              className: "btn-sm"
            },
            {
              extend: "csv",
              className: "btn-sm"
            },
            {
              extend: "excel",
              className: "btn-sm"
            },
            {
              extend: "pdfHtml5",
              className: "btn-sm"
            },
            {
              extend: "print",
              className: "btn-sm"
            },
          ],
          responsive: true
        });
      }
    };

    TableManageButtons = function() {
      "use strict";
      return {
        init: function() {
          handleDataTableButtons();
        }
      };
    }();
    
    jQuery(function($) {
        var panelList = $('#item-sort');

        panelList.sortable({
            handle: '.dashlet_title', 
            update: function() {
                var elem_order = [];
                $('.sortable', panelList).each(function(index, elem) {
                    var $listItem = $(elem),
                        newIndex = $listItem.index();
                            
                    elem_order.push(elem.id);
                });
                
                var jsonString = JSON.stringify(elem_order);
                $.ajax({
                    type: "POST",
                    url: "?controller=command&action=update_order", 
                    data: {action : "update_order", data : jsonString}, 
                    cache: false,

                    success: function(){
                        //alert("OK");
                    }
                });
            }
        });
    });

    $('#datatable').dataTable();

    $('#datatable-keytable').DataTable({
      keys: true
    });

    $('#datatable-responsive').DataTable();
    
    $('#datatable-responsive-2').DataTable(); 

    $('#datatable-scroller').DataTable({
      ajax: "js/datatables/json/scroller-demo.json",
      deferRender: true,
      scrollY: 380,
      scrollCollapse: true,
      scroller: true
    });

    $('#datatable-fixed-header').DataTable({
      fixedHeader: true
    });

    var $datatable = $('#datatable-checkbox');

    $datatable.dataTable({
      'order': [[ 1, 'asc' ]],
      'columnDefs': [
        { orderable: false, targets: [0] }
      ]
    });
    $datatable.on('draw.dt', function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_flat-green'
      });
    });

    TableManageButtons.init();
  });
  
  jQuery(window).load(function () {
    $(window).trigger('resize'); 
  });