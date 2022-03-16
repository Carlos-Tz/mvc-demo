$(document).ready(function () {   
    $("#almacen").click(function() {
        if($('#btn_excel').is(':hidden')){
            $('#btn_excel').show();
        }
        if ($.fn.DataTable.isDataTable("#table-almacen")) {
            $("#table-almacen").dataTable().fnDestroy();
            $('#table-almacen tbody').remove();
            tablaAlmacen();
        }else{
            tablaAlmacen();
        }
    });
});

/* const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2
}); */
function formatAlmacen(data) {
    var tr = '';
    var products = data.productos;
    for (const p in products) {
        var valor_monetario_inicial = parseFloat(products[p].p['importe']);
        var entradas = 0;
        var entradas_valor = 0;
        var salidas = 0;
        var salidas_valor = 0;
        var valor_monetario_final = 0;
        var existencia_final = 0;
        for (const m in products[p].entradas){
            entradas += parseFloat(products[p].entradas[m].cantidad);
            entradas_valor += parseFloat(products[p].entradas[m].importe);
        }
        for (const m in products[p].salidas){
            salidas += parseFloat(products[p].salidas[m].cantidad);
            salidas_valor += parseFloat(products[p].salidas[m].importe);
        }
        if (entradas > 0 || salidas > 0){
            existencia_final = parseFloat(products[p].p['existencia']) + entradas - salidas;
            valor_monetario_final = valor_monetario_inicial + entradas_valor - salidas_valor;
            tr += '<tr><td>' + products[p].p['nom_prod'].toUpperCase() + '</td><td>' + products[p].p['unidad_medida'].toUpperCase() + '</td><td>' + parseFloat(products[p].p['existencia']).toFixed(3) + '</td><td>'+ formatter.format(valor_monetario_inicial) +'</td><td>' + entradas.toFixed(3) + '</td><td>' + formatter.format(entradas_valor) + '</td><td>'+ salidas.toFixed(3) +'</td><td>'+ formatter.format(salidas_valor) +'</td><td>' + existencia_final.toFixed(3) + '</td><td>'+ formatter.format(valor_monetario_final) +'</td></tr>';
        }
    }
    tr += '<tr><td></td><td></td><td>Subtotal:</td><td>' + formatter.format(data.corte_inicial) + '</td><td></td><td>' + formatter.format(data.sub_entradas) + '</td><td></td><td>' + formatter.format(data.sub_salidas) + '</td><td></td><td>' + formatter.format(data.corte_final) + '</td></tr>';
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr><td>Producto</td><td>Unidad</td><td>Existencia Inicial</td><td>Valor Monetario Inicial</td><td>Compras Cantidad</td><td>Compras Valor Monetario</td><td>Salidas Cantidad</td><td>Salidas Valor Monetario</td><td>Existencia Final</td><td>Valor Monetario Final</td></tr>' +
        tr +
        '</table>';
}

function startOfWeek(date) {
    var diff = date.getDate() - date.getDay() + 1;
    return new Date(date.setDate(diff));
  }

function tablaAlmacen(){
    var fecha = $('#fechaAlmacen').val();
    var f = new Date($('#fechaAlmacen').val());
    var inicio = startOfWeek(f);
    var f_inicio =  inicio.getDate() + "/" + (inicio.getMonth() + 1) + "/" + inicio.getFullYear();
    var fin = inicio;
    var dias = 6;
    fin.setDate(fin.getDate() + dias);
    var f_fin = fin.getDate() + "/" + (fin.getMonth() + 1) + "/" + fin.getFullYear();
    if (f_inicio && f_fin){
        $('#f_i').text(f_inicio);
        $('#f_f').text(f_fin);
    }

    var table = $('#table-almacen').DataTable({
        /* 'processing': true, */
        /* 'serverSide': true, */
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
            'url': 'index.php?controller=almacenSemanal&action=table',
            'type': 'post',
            'data': { 'fechaA': fecha },
            /* success: function(data) {
                if (!data.error) { console.log(data); }
                else { alert("Error en funcion") }
            } */
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
                data: 'corte_inicial',
                render: function (data, type) {
                    var number = $.fn.dataTable.render.number(',', '.', 2, '$').display(data);
                    return number;
                }
            },
            { 
                data: 'corte_final',
                render: function (data, type) {
                    var number = $.fn.dataTable.render.number(',', '.', 2, '$').display(data);
                    return number;
                }
            },
            { 
                data: 'sub_salidas',
                render: function (data, type) {
                    var number = $.fn.dataTable.render.number(',', '.', 2, '$').display(data);
                    return number;
                }
            },
            { 
                data: 'sub_entradas',
                render: function (data, type) {
                    var number = $.fn.dataTable.render.number(',', '.', 2, '$').display(data);
                    return number;
                }
            }
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
            total_inicial = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            // Total over this page
            total_final = api
                .column(3)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total_gasto = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total_compras = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            // Update footer
            $(api.column(2).footer()).html( formatter.format(total_inicial) );
            $(api.column(3).footer()).html( formatter.format(total_final) );
            $(api.column(4).footer()).html( formatter.format(total_gasto) );
            $(api.column(5).footer()).html( formatter.format(total_compras) );
        }
    });
    $('#table-almacen tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(formatAlmacen(row.data()/* .productos, row.data().corte_inicial */)).show();
            tr.addClass('shown');
        }
    });
}

function almacen_excel() {
    var fecha = $('#fechaAlmacen').val();
    $.ajax({
       url: 'index.php?controller=almacenSemanal&action=excel',
       method: 'POST',
       data: { 'fechaA': fecha },
       success: function(data) {
           if (data) {
               console.log(data);
               window.location.href = "http://localhost:8080/local/dev/adm/demo2/almacenSemanal.xlsx";
               /* window.location.href = "http://demo.test/almacenSemanal.xlsx"; */
           } else { console.log("Sin datos") }
     }
 })
}