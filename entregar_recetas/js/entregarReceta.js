
var table = document.getElementById("receta_table");
var url = 'http://localhost/inomac/entregar_recetas';
/* var url = 'http://localhost:8080/local/dev/adm/mvc/entregar_recetas'; */
$(document).ready(function() {
    $('.subrancho_s').select2();
    $('.productos_s').select2();
    $('.clasificacion_s').select2();
    $("#form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
    var id_subrancho = $('#sssub').val();
    var id_receta = $('#id_receta').val();
    //console.log(data.id);
    $.ajax({
        type: "POST",
        url: 'index.php?c=recetas&action=sectores',
        data: { 'id': id_subrancho },
        success: function(response){
            $.when($('#sectores').html(response)).done($('.sectores_s').select2()).done(
                $('#all_p').click(function(e){
                    e.preventDefault();
                    var row = table.rows;
                    var cc = row[0].cells.length;
                    let text = "¿Confirma que desea seleccionar todos los elementos?";
                    if(row.length > 1 && cc > 1){
                        if (confirm(text) == true) {
                            //console.log('se ha confrmado');
                            for (var i = 1; i < row[0].cells.length; i++) {
                                for (var j = 1; j < row.length; j++) {
                                    if(i % 2 !== 0) {
                                        //console.log(row[j].cells[i]);
                                        var td = row[j].cells[i];
                                        var lch = td.lastChild;
                                        /* lch.addEventListener('change', function(event){
                                            if (event.target.checked) {
                                                alert(`${event.target.value} is checked`);
                                            }
                                            else {
                                                alert(`${event.target.value} is unchecked`);
                                            }
                                        }); */
                                        lch.setAttribute('checked', 'checked');
                                        lch.onchange();
                                    
                                        //lch.checked = true;
                                        //lch.trigger('change');                                        
                                    }                                        
                                }
                            }
                        }
                    }else{
                        console.log('No hay elementos');
                    }
                            
                }),
                $.ajax({
                    type: "POST",
                    url: 'index.php?c=recetas&action=get_detalles',
                    data: { 'id': id_receta }, 
                    success: function(response){                      
                        //console.log(response);
                        let data = JSON.parse(response);
                        let sectores = [];
                        let productos = [];
                        for(let va of data){
                            sectores.push(va.id_sector);
                            productos.push(va.id_prod);
                        }
                        let sectores_u = sectores.filter((item,index)=>{
                            return sectores.indexOf(item) === index;
                        })
                        let productos_u = productos.filter((item,index)=>{
                            return productos.indexOf(item) === index;
                        })
                        $('.sectores_s').val(sectores_u);
                        $(".sectores_s").trigger('select2:select');
                        $('.sectores_s').trigger('change'); 
                        $('.productos_s').val(productos_u);
                        $(".productos_s").trigger('select2:select');
                        $('.productos_s').trigger('change'); 
                        for(let va of data){  
                            let dosis_t = parseFloat(va.dosis_total).toFixed(2); //console.log(dosis_t)
                            let dosis_h = parseFloat(va.dosis_hectarea).toFixed(2); //console.log(dosis_h)
                            var inp = $('input#'+va.nombre_s+'___'+va.id_sector+'___'+va.id_prod+'___1');
                            var inp2 = $('input#'+va.nombre_s+'___'+va.id_sector+'___'+va.id_prod+'___2');
                            var inpc = $('input#'+va.nombre_s+'___'+va.id_sector+'___'+va.id_prod+'___c');

                            inp.val(dosis_t).trigger('change');
                            inp.attr('name', 'n___'+va.id_receta_detalle);
                            inp2.val(dosis_h).trigger('change');
                            if(va.status == 'Entregada'){
                            //inpc.val(dosis_h).trigger('change');
                                inpc.attr('checked', 'checked');
                                inpc.trigger('change');
                                inpc.attr("disabled", true);
                            }
                            if(dosis_t == 0){
                                inpc.attr('checked', 'checked');
                                inpc.trigger('change');
                                inpc.attr("disabled", true);
                            }
                            /* if(inpc.attr("disabled")){
                                console.log(inpc.attr("disabled"))
                            } */
                        }
                        //var inp = $('input#A1___1___2889___1'); console.log(inp)

                    }
                })
            );

            $('#sectores_lista').on('select2:select', function (evt) {
                if(evt.params){
                    addCol(evt.params.data.id, evt.params.data.text);
                } else {
                    //removeAllC();
                    for (let va of evt.target.selectedOptions){
                        //console.log(va.value + ' => ' + va.text);
                        addCol(va.value, va.text);
                    }
                }
            });
        }
      });

    $.ajax({
        type: "POST",
        url: 'index.php?c=recetas&action=sectores_list',
        data: { 'id': id_subrancho },
        success: function(response){
            $.when($('#ssectores').html(response))
        }
    })
    //var data = e.params.data;
    //console.log(data.id);
    $.ajax({
        type: "POST",
        url: 'index.php?c=recetas&action=productos',
        data: { },
        success: function(response){
            $.when($('#productos').html(response)).done($('.productos_s').select2())
            
        $('#productos_lista').on('select2:select', function (evt) {
            if(evt.params){
                addRow(evt.params.data.id, evt.params.data.text);
            } else {
                for (let va of evt.target.selectedOptions){
                    addRow(va.value, va.text);
                }
            }
              //addRow(evt.params.data);
        });

        }
      });
});
$('#form').submit(function(e){
    e.preventDefault();
    var row = table.rows;
    var cc = row[0].cells.length;
    let text = "¿Confirma que desea surtir la receta?";
    var completo = true;
    if(row.length > 1 && cc > 1){
        if (confirm(text) == true) {
            for (var i = 1; i < row[0].cells.length; i++) {
                for (var j = 1; j < row.length; j++) {
                    if(i % 2 !== 0) {
                        //console.log(row[j].cells[i]);
                        var td = row[j].cells[i];
                        var lch = td.lastChild;
                        //console.log(lch.checked);
                        var id = lch.id;
                        var arrId = id.split('___');
                        var scp = arrId[0];
                        var sicp = arrId[1];
                        var idp = parseInt(arrId[2]);
                        var inp = $('input#'+scp+'___'+sicp+'___'+idp+'___1');
                        var inpc = $('input#'+scp+'___'+sicp+'___'+idp+'___c');
                        var idd = inp.attr("name");
                        var arrIdd = idd.split('___');
                        var id_receta_det = parseInt(arrIdd[1]);
                        var va = parseFloat(inp.val());
                        if(lch.checked && va > 0 ){
                            if(!inpc.attr("disabled")){
                                $.ajax({
                                    type: "POST",
                                    url: 'index.php?c=productos&action=salida',
                                    data: { 'id_sub': $('#sssub').val(), 'id_prod': idp, 'id_sec': sicp, 'sal': va },
                                    success: function(response){
                                        //console.log(response);
                                        //location.href = url;
                                    }
                                })
                                $.ajax({
                                    type: "POST",
                                    url: 'index.php?c=productos&action=movimiento',
                                    data: { 'id_rec': $('#id_receta').val() , 'sub': $('#nombress').val(), 'id_prod': idp, 'id_sec': sicp, 'sal': va, 'nom_sec': scp },
                                    success: function(response){
                                        //console.log(response);
                                        //location.href = url;
                                    }
                                })
                                $.ajax({
                                    type: "POST",
                                    url: 'index.php?c=recetas&action=cambiar_status',
                                    data: { 'id': id_receta_det },
                                    success: function(response){
                                        //console.log(response);
                                        location.href = url;
                                    }
                                })
                            }
                            
                            //completo = true;
                            /* if(va > 0) {
                                //console.log(va)
                            } */
                        }else{
                            if(va > 0){
                                completo = false;
                                /* console.log('sin seleccionar');
                                console.log(lch.id); */
                            }
                        }
                    }
                }
            }
            if (completo){
                $.ajax({
                    url: 'index.php?c=recetas&action=actualizar',
                    type: 'post',
                    data: { 'id': $('#id_receta').val(), 'status': 'Entregada' },
                    success: function(res){ console.log(res);                        
                    }
                });
            }else{
                $.ajax({
                    url: 'index.php?c=recetas&action=actualizar',
                    type: 'post',
                    data: { 'id': $('#id_receta').val(), 'status': 'Incompleta' },
                    success: function(res){ console.log(res);                        
                    }
                });
            }
        } 
    }else{
        alert('La tabla esta vacía!');
    }
});
$('#cancel').click(function(e){
    e.preventDefault();
    let text = "¿Confirma que desea cancelar la entrega?";
    if (confirm(text) == true) {
        location.href = url;
    }
});


function addRow(producto_id, producto_text) {
    var lastrow = table.rows.length;
	var lastcol = table.rows[0].cells.length;
	var lcol = table.rows[0].cells;	//console.log(lcol[1].id);
	var row = table.insertRow(lastrow);
    row.setAttribute("id", producto_id, 0);
	var cellcol0 = row.insertCell(0);
	//cellcol0.innerHTML = lastrow;
	cellcol0.innerHTML = '<button type="button" class="btn" style="padding: 0 0.5rem !important; width: 100%;" id="'+producto_id+'">'+producto_text+'</button><p style="text-align:center;" id="'+producto_id+'___s"></p>';
	
	
	for(i=1; i<lastcol;i++)	{
		var cell1 = row.insertCell(i);
        cell1.setAttribute("id", lcol[i].id + producto_id ); //console.log(lcol[i].id);
        cell1.className = 'text-center';
        if(i % 2 == 0) {
            cell1.innerHTML = '<input type="number" id="'+lcol[i].id+ producto_id+'___2" class="form-control" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" value="0" min="0" step="0.01" readonly>';
        }else {
            //cell1.setAttribute("id", lcol[i].id + producto.id+'___1');
            cell1.innerHTML = '<input type="number" id="'+lcol[i].id+ producto_id+'___1" class="form-control" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" value="0" min="0" step="0.01" readonly><input type="checkbox" id="'+lcol[i].id+ producto_id+'___c" onchange="changeC(this)">';
        }
	}
}

function addCol(sector_value, sector_text) {
    var lastrow = table.rows.length;
    var lrow = table.rows;
	var lastcol = table.rows[0].cells.length;   //console.log(table.rows[0].cells[lastcol-1].className);
	
    //for each row add column
	for(i=0; i<lastrow;i++)	{
		var cell1 = table.rows[i].insertCell(lastcol); //if (i>0)console.log(lrow[i].id);
		var cell2 = table.rows[i].insertCell(lastcol+1);
        cell1.setAttribute("id", sector_text + '___' + sector_value + '___' + lrow[i].id );
        cell2.setAttribute('id', sector_text + '___' + sector_value + '___'  + lrow[i].id );
        cell1.className = 'text-center';
        cell2.className = 'text-center';
		if(i==0){
            cell1.innerHTML = "Sector " + sector_text;
			cell2.innerHTML = "Dosis Ha";
            cell1.className = 'td_green';
            cell2.className = 'td_white';
        }
		else  {
            cell1.innerHTML = '<input type="number" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" id="'+sector_text + '___' + sector_value + '___'+ lrow[i].id + '___1" class="form-control" value="0" min="0" step="0.01" readonly><input type="checkbox" id="'+lcol[i].id+ producto_id+'___c" onchange="changeC(this)">';
            cell2.innerHTML = '<input type="number" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" id="'+sector_text + '___' + sector_value + '___'+ lrow[i].id + '___2" class="form-control" value="0" min="0" step="0.01">';
        }
		
	}
}

function changeC(val){
    var id = val.id;
    var sum = 0;
    var proEx = 0;
    var valor = val.checked;
    var arrId = id.split('___');
    var scp = arrId[0]; 
    var sicp = arrId[1];
    var idp = arrId[2];
    var clp = arrId[3];
    var row = $('tr#'+idp);
    var cells = row[0].cells;
    for (var i = 1; i < cells.length; i++) {
        var td = cells[i];
        if(i % 2 != 0 && td.childNodes[1].checked) { 
            sum += parseFloat(td.firstChild.value); 
            //console.log(td.childNodes[1].checked)
        }
    }
    $('p#'+idp+'___s').text('Total: '+sum.toFixed(2));
}