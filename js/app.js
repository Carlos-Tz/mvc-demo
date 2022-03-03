$(document).ready(function () {
    $('#entries').DataTable({
        ajax: {
            url: 'index.php?controller=index&action=index',
            type: 'post',
            success: function(data) {
                if (!data.error) { alert(data); }
                else { alert("Error en funcion") }
          }
        }
        
        /* colums: [
            { data: 'entries'}
        ] */
    });
});