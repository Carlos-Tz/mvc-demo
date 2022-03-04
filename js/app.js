$(document).ready(function () {
    
});

function tabla(){
    $('#entries').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'info': false,
        'dom': 'frti',
        'stateSave': true,
        'responsive': true,
        "autoWidth": true,
        "scrollX": "auto",
        'searching': false,
        'ajax': {
            url: 'index.php?controller=index&action=table',
            type: 'post',
            success: function(data) {
                if (!data.error) { console.log(data); }
                else { alert("Error en funcion") }
          }
        },
        'columns': [
            { data: 'semana'},
            /* { data: 'semana'},
            { data: 'id_prod'},
            { data: 'nom_prod'},
            { data: 'existencia'},
            { data: 'costo_promedio'},
            { data: 'clasificacion'}, */
        ]
    });
}