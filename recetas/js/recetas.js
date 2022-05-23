function getTableRecetas(){
    var table = $('#table-recipes').DataTable({
        /* 'processing': true,
        'serverSide': true, */
        'serverMethod': 'post',
        'info': false,
        'dom': 'frti',
        'stateSave': true,
        'responsive': true,
        "autoWidth": true,
        "scrollX": "auto",
        'searching': false,
        "ordering": false,
        'ajax': {
            'url': 'index.php?c=recetas&action=table',
            'data': { /* 'fechaI': fechaI, 'fechaF': fechaF */ },
            'type': 'post',
        },
        'columns': [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: ''
            },
            {
                data: 'num_subrancho',
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
        ]/* ,
        'footerCallback': function (row, data, start, end, display) {
            var api = this.api();
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            // Total over all pages
            total = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            // Total over this page
            pageTotal = api
                .column(2, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            // Update footer
            $(api.column(2).footer()).html(
                formatter.format(total)
            );
        } */
    });
    /* 
    $('#table-entradas tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(formatEntradas(row.data().productos)).show();
            tr.addClass('shown');
        }
    }); */
}

$(document).ready(function () {     
    getTableRecetas();
});