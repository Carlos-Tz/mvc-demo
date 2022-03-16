function formatEntradas(d) {
    var tr = '';
    for (const p in d) {
        tr += '<tr><td>' + d[p].p.toUpperCase() + '</td><td>' + d[p].cantidad.toFixed(3) + '</td><td>' + d[p].u.toUpperCase() + '</td><td>' + formatter.format(d[p].subtotal) + '</td></tr>';
    }
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr><td>Producto</td><td>Cantidad</td><td>Unidad</td><td>Subtotal</td></tr>' +
        tr +
        '</table>';
}

function getTableEntradas(fechaI, fechaF){
    var table = $('#table-entradas').DataTable({
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
            'url': 'table-entradas.php',
            'data': { 'fechaI': fechaI, 'fechaF': fechaF },
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
                data: 'rubro',
                render: function (data, type) {
                    return data.toUpperCase();
                }
            },
            {
                data: 'total',
                render: function (data, type) {
                    var number = $.fn.dataTable.render.number(',', '.', 2, '$').display(data);
                    return number;
                }
            },
        ],
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
        }
    });
    
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
    });
}

$(document).ready(function () {     
    /* $('#cont_e').hide();   
    $('#cont_s').hide(); */   
    $("#entradas").click(function() {
        if($('#cont_e').is(':hidden')){
            $('#cont_e').show();
        }
        if($('#cont_s').is(':visible')){
            $('#cont_s').hide();
        }
        if ($.fn.DataTable.isDataTable("#table-entradas")) {
            $("#table-entradas").dataTable().fnDestroy();
            $('#table-entradas tbody').remove();
            getTableEntradas($('#fechaInicio').val(), $('#fechaFin').val());
        }else{
            getTableEntradas($('#fechaInicio').val(), $('#fechaFin').val());
        }
    });
    $("#salidas").click(function() {
        if($('#cont_e').is(':visible')){
            $('#cont_e').hide();
        }
        if($('#cont_s').is(':hidden')){
            $('#cont_s').show();
        }
        if ($.fn.DataTable.isDataTable("#table-salidas")) {
            $("#table-salidas").dataTable().fnDestroy();
            $('#table-salidas tbody').remove();
            getTableSalidas($('#fechaInicio').val(), $('#fechaFin').val());
        }else{
            getTableSalidas($('#fechaInicio').val(), $('#fechaFin').val());
        }
    });
});

function entradas_excel() {
     $.ajax({
        url: 'table-entradas-excel.php',
        method: 'POST',
        data: { 'fechaI': $('#fechaInicio').val(), 'fechaF': $('#fechaFin').val() },
        success: function(data) {
            if (!data.error) {
                console.log(data);
                window.location.href = "http://inomac.test/entradas.xlsx";
            } else { console.log("Error en funcion") }
      }
  })
}
