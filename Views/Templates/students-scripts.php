<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

<script>
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

    $('#datatable').dataTable();

    $('#datatable-keytable').DataTable({
        keys: true
    });

    $('#datatable-responsive').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "?controller=command&action=ajax_students" 
    });
    
    $('#datatable-responsive-2').DataTable();
    
    $(document).resize();

    $("[type='search']").on('input', function (e) {
          $(document).resize();
      });

    $("[name='datatable-responsive_length']").on('change', function (e) {
        $(document).resize();
    });

    $("#datatable-responsive_paginate").on('click', function(e) {
        $(document).resize();
    });

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

    $("#search_byu").keyup(function() {
        var search_value = $(this).val();
        $.ajax({
            type: "POST",
            url: "?controller=command&action=search_byu", 
            data: {data : search_value}, 
            cache: false,

            success: function(response){
                if (response != " ") {
                    $("#results_byu").html("<strong>"+response+"</strong> &nbsp;&nbsp;&nbsp;<button type='submit' class='btn btn-primary' style='padding:3px;'>Add to BookTracker</button>");
                    $(window).unbind('keydown');
                } else {
                    $("#results_byu").html("");
                    $(window).keydown(function(event){
                        if(event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                        }
                    });
                }
            }
        });
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
</script>