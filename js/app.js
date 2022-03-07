$(document).ready(function () {
    
});

const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2
});
function formatE(d) {
    var tr = '';
    for (const p in d) {
        var valor_monetario_inicial = d[p].p['existencia'] * d[p].p['costo_promedio'];
        var entradas = 0;
        var salidas = 0;
        var valor_monetario_final = 0;
        var existencia_final = 0;
        var existencia_utilizada = 0;
        /*tr += '<tr><td>' + d[p].nom_prod.toUpperCase() + '</td><td>'+ d[p].unidad_medida.toUpperCase() +'</td><td>' + d[p].existencia + '</td><td>'+ formatter.format(valor_monetario_inicial) +'</td><td>' + formatter.format(d[p].costo_promedio) + '</td></tr>'; */
        for (const m in d[p].entradas){
            entradas += parseFloat(d[p].entradas[m].cantidad);
            //tr += '<tr><td></td><td>' + d[p].entradas[m].tipo + '</td><td>' + d[p].entradas[m].nom_prod + '</td><td>' + d[p].entradas[m].fecha_movto + '</td><td>' + d[p].entradas[m].cantidad + '</td><td></td></tr>';
        }
        for (const m in d[p].salidas){
            salidas += parseFloat(d[p].salidas[m].cantidad);
            //tr += '<tr><td></td><td>' + d[p].salidas[m].tipo + '</td><td>' + d[p].salidas[m].nom_prod + '</td><td>' + d[p].salidas[m].fecha_movto + '</td><td>' + d[p].salidas[m].cantidad + '</td><td></td></tr>';
        }
        existencia_final = parseFloat(d[p].p['existencia']) + entradas - salidas;
        valor_monetario_final = existencia_final * d[p].p['costo_promedio'];
        existencia_utilizada = parseFloat(d[p].p['existencia']) - existencia_final;
        tr += '<tr><td>' + d[p].p['nom_prod'].toUpperCase() + '</td><td>' + d[p].p['unidad_medida'].toUpperCase() + '</td><td>' + parseFloat(d[p].p['existencia']).toFixed(5) + '</td><td>'+ formatter.format(valor_monetario_inicial) +'</td><td>' + entradas + '</td><td>'+ salidas +'</td><td>' + existencia_final.toFixed(5) + '</td><td>'+ formatter.format(valor_monetario_final) +'</td><td>' + existencia_utilizada.toFixed(5) + '</td></tr>';
        /* tr += '<tr><td></td><td></td><td></td><td>Total</td><td>' + entradas + '</td></tr>'; */
    }
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr><td>Producto</td><td>Unidad</td><td>Existencia Inicial</td><td>Valor Monetario Inicial</td><td>Entradas</td><td>Salidas</td><td>Existencia Final</td><td>Valor Monetario Final</td><td>Existencia Utilizada</td></tr>' +
        tr +
        '</table>';
}

function tabla(){
    var table = $('#entries').DataTable({
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
            'url': 'index.php?controller=index&action=table',
            'type': 'post',
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
            { data: 'rubro'},
            /* { data: 'semana'},
            { data: 'id_prod'},
            { data: 'nom_prod'},
            { data: 'existencia'},
            { data: 'costo_promedio'},
            { data: 'clasificacion'}, */
        ]
    });
    $('#entries tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(formatE(row.data().productos)).show();
            tr.addClass('shown');
        }
    });
}