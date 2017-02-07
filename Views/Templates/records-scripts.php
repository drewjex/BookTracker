<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

<!-- Datatables -->
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

    <?php $_SESSION['search_column'] = -1; ?>

    var table = $('#datatable-responsive').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "?controller=command&action=ajax_book_records"
    });

    $('.dataTables_filter').append("&nbsp;&nbsp;<select id='search_by' style='display:inline-block;' class='select2_single form-control'>"+
                                        "<option value='-1'>All</option>"+
                                        "<option value='1'>Title</option>"+
                                        "<option value='2'>ISBN10</option>"+
                                        "<option value='3'>ISBN13</option>"+
                                        "<option value='4'>Publisher</option>"+
                                        "<option value='5'>Priority</option>"+
                                    "</select>");

    $('#datatable-responsive_length').closest('.col-sm-6').attr('class', 'col-sm-4');
    $('#datatable-responsive_filter').closest('.col-sm-6').attr('class', 'col-sm-8');

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
    
    $('#datatable-responsive-2').DataTable();
    
    $(window).resize(function(){
        
        /*if (!$('#datatable-responsive').hasClass('collapsed')) {
        $('.first-td').hide();
        $('.first-th').hide();
        } else {
        $('.first-td').show();
        $('.first-th').show();
        }*/
    });
    
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
<!-- /Datatables -->