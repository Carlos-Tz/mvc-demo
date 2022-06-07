function getTableRecetas(){
    var table = $('#table-recipes').DataTable({
        dom: 'ltrip',
        order: [[0, 'desc']],
        ajax: {
            'url': 'index.php?c=recetas&action=table',
            'data': { },
            'type': 'post',
        },
        columns: [
            {
                data: 'id_receta',
                render: function(data, type){
                    return  String(data).padStart(6, '0');
                }
            },
            {
                data: 'nombre',
                render: function (data, type) {
                    return data.toUpperCase();
                }
            },
            {
                data: 'fecha'/* ,
                render: function (data, type) {
                    var number = $.fn.dataTable.render.number(',', '.', 2, '$').display(data);
                    return number;
                } */
            },
            {
                data: 'status'
            },
            {
                data: 'options'
            }
        ]
    });
}

$(document).ready(function () {     
    getTableRecetas();
});