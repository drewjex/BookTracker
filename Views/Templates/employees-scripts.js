function removeUser(e, id) {
    e.preventDefault();
    if (confirm('Are you sure you want to remove this user?')) {
        $("#remove_user"+id).submit();
    }
} 