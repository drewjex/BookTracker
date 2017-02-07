function removePDF(e, id) {
    e.preventDefault();
    if (confirm('Are you sure you want to remove this proof of purchase file?')) {
        $("#remove-"+id).submit();
    }
}

function requestCancel(e, id) {
    e.preventDefault();
    if (confirm('Are you sure you want to send a cancellation request?')) {
        $("#cancel-"+id).submit();
    }
}

$("#select_semester").change(function() {
    $("#select_semester").submit();
});
    