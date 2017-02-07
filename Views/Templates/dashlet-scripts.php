<script>
    
    $(document).ready(function() {
        $("#dashlet_table-"+<?php echo $data['id']; ?>).DataTable({ 
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            "ajax": {
                'type' : 'GET',
                'url' : '?controller=command&action=dashlet_data',
                'data' : {
                    data : JSON.stringify(<?php echo $this->data['settings_blob']; ?>)
                }, 
            }
        }); 
    });

    function refreshdashlet(id) {
        $("#dashlet_table-"+id).DataTable().ajax.reload();
    }
    
</script>