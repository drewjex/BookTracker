<!-- Select2 -->
<script src="../vendors/select2/dist/js/select2.full.min.js"></script>
<script>
    
    function removeFA(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to remove this file?')) {
            $("#remove_fa").submit();
        }
    }
    
    $(".select2_multiple").select2({
          placeholder: "Please Select",
          allowClear: true
        });

    $('#datatable-responsive').DataTable();

    $(window).resize(function(){
        
        if (!$('#datatable-responsive').hasClass('collapsed')) {
            $('.first-td').hide();
            $('.first-th').hide();
        } else {
            $('.first-td').show();
            $('.first-th').show();
        }
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
    
</script>