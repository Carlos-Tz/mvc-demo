
var table = document.getElementById("receta_table");
var url = 'http://localhost/inomac/entregar_recetas';
/* var url = 'http://localhost:8080/local/dev/adm/mvc/entregar_recetas'; */
//var productos_g = []
//var subrancho = 0;
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
                                //var str = row[0].cells[i];
                                //if (str.id == id) { 
                                    for (var j = 1; j < row.length; j++) {
                                        if(i % 2 !== 0) {
                                            //console.log(row[j].cells[i]);
                                            var td = row[j].cells[i];
                                            var lch = td.lastChild
                                            lch.checked = true;                                        
                                        }
                                        
                                        //row[j].deleteCell(i);
                                    }//console.log('ok');
                                //}
                            }
                            /* $(".sectores_s > option").prop("selected", "selected");
                            $(".sectores_s").trigger('select2:select');
                            $(".sectores_s").trigger('change'); */
                        }
                    }else{
                        console.log('No hay elementos');
                        /* $(".sectores_s > option").prop("selected", "selected");
                        $(".sectores_s").trigger('select2:select');
                        $(".sectores_s").trigger('change'); */
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
                            var inp = $('input#'+va.nombre_s+'___'+va.id_sector+'___'+va.id_prod+'___1');//.val(dosis_t).trigger('change');
                            var inp2 = $('input#'+va.nombre_s+'___'+va.id_sector+'___'+va.id_prod+'___2');//.val(dosis_h).trigger('change');

                            inp.val(dosis_t).trigger('change');
                            inp.attr('name', 'n___'+va.id_receta_detalle);
                            inp2.val(dosis_h).trigger('change');
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
           /*  $('#sectores_lista').on('select2:unselecting', function (evt) {
                let text = "¿Confirma que desea eliminar este sector de la tabla?";
                if (confirm(text) == true) {
                  } else {
                      evt.preventDefault();
                  }
            }); */

            /* $('#sectores_lista').on('select2:unselect', function (evt) {
                removeCol(evt.params.data.text+'___'+evt.params.data.id+'___');
                removeCol(evt.params.data.text+'___'+evt.params.data.id+'___');
                //console.log(evt.params.data.id);
            }); */
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
        /* $('#productos_lista').on('select2:unselecting', function (evt) {
            let text = "¿Confirma que desea eliminar este producto de la tabla?";
            if (confirm(text) == true) {
                console.log('se ha aceptado la eliminacin!');
              } else {
                  evt.preventDefault();
                console.log('ha cancelado la eliminacion');
              }
        }); */
        /* $('#productos_lista').on('select2:unselect', function (evt) {
            removeRow(evt.params.data.id);
        }); */

        }
      });
});
$('#form').submit(function(e){
    e.preventDefault();
    var row = table.rows;
    var cc = row[0].cells.length;
    let text = "¿Confirma que desea surtir la receta?";
    if(row.length > 1 && cc > 1){
        if (confirm(text) == true) {
            for (var i = 1; i < row[0].cells.length; i++) {
                for (var j = 1; j < row.length; j++) {
                    if(i % 2 !== 0) {
                        //console.log(row[j].cells[i]);
                        var td = row[j].cells[i];
                        var lch = td.lastChild;
                        //console.log(lch.checked);
                        if(lch.checked){
                            var id = lch.id;
                            var arrId = id.split('___');
                            var scp = arrId[0];
                            var sicp = arrId[1];
                            var idp = parseInt(arrId[2]);
                            var inp = $('input#'+scp+'___'+sicp+'___'+idp+'___1');
                            var idd = inp.attr("name");
                            //console.log(idd);
                            var arrIdd = idd.split('___');
                            console.log(arrIdd[1]);
                            var id_receta_det = parseInt(arrIdd[1]);
                            var va = parseFloat(inp.val());
                            if(va > 0) {
                                //console.log(va)
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
                        }
                    }
                }
            }
            $.ajax({
                url: 'index.php?c=recetas&action=actualizar',
                type: 'post',
                data: { 'id': $('#id_receta').val() },
                success: function(res){ console.log(res);
                    
                }
            });
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


/* function change(val){
    var id = val.id;
    var sum = 0;
    var proEx = 0;
    var valor = val.value; 
    if (valor >= 0){
        var arrId = id.split('___');
        var scp = arrId[0]; //console.log(id);
        var sicp = arrId[1]; //console.log(id);
        var idp = arrId[2]; //console.log(idp);
        var clp = arrId[3]; //console.log(idp);
        var row = $('tr#'+idp);
        var cells = row[0].cells;
        for (var i = 1; i < cells.length; i++) {
            var td = cells[i];
            if(i % 2 != 0) { sum += parseFloat(td.firstChild.value); }
        }
        $.ajax({
            type: "POST",
            url: 'index.php?c=recetas&action=calcular',
            data: { 'id': idp, 'id_r': $('#id_receta').val() },
            success: function(response){
                //console.log(parseFloat(response))
                var total_p = parseFloat(response);
                var programada;
                if (total_p){
                    programada = sum + total_p;
                }else{
                    programada = sum;
                }
                //console.log(row)
                if($('#'+idp+'_pp')[0].value){
                    proEx = parseFloat($('#'+idp+'_pp')[0].value);
                    if(programada > proEx) {
                        alert('Existencia insuficiente de este producto!');
                        $('#'+scp+'___'+sicp+'___'+idp+'___'+clp).val(0).trigger('change');
                    }else {
                        var re = (proEx - programada);
                        var ha = parseFloat($('#'+scp+'___ss')[0].value);
                        $('#'+idp+'_ppp').val(parseFloat(re).toFixed(2));
                        $('#'+idp+'_pppp').val(parseFloat(programada).toFixed(2));
                        var valor2 = valor/ha; //console.log(valor2);
                        if(valor > 0){
                            $('#'+scp+'___'+sicp+'___'+idp+'___'+'2').val(valor2.toFixed(2));
                        }else {
                            $('#'+scp+'___'+sicp+'___'+idp+'___'+'2').val(0);
                        }
                    }
                }
            }
        })
    }
} */
/* function change1(val){
    var id = val.id;
    var sum = 0;
    var proEx = 0;
    var valor = val.value; //console.log(subrancho);
    //console.log(val.value);
    if (valor >= 0){
        var arrId = id.split('___');
        var scp = arrId[0]; //console.log(id);
        var sicp = arrId[1]; //console.log(id);
        var idp = arrId[2]; //console.log(idp);
        var clp = arrId[3]; 
        var ha = parseFloat($('#'+scp+'___ss')[0].value);
        var valor2 = valor*ha; 
        if(valor > 0){
            $('#'+scp+'___'+sicp+'___'+idp+'___'+'1').val(valor2.toFixed(2)).trigger('change');
        }else {
            $('#'+scp+'___'+sicp+'___'+idp+'___'+'1').val(0).trigger('change');
        }
    }
} */
/* function show(id){
    $('li#'+id+'_cc').show();
}
function hide(id){
    $('li#'+id+'_cc').hide();
} */

function addRow(producto_id, producto_text) {
    var lastrow = table.rows.length;
	var lastcol = table.rows[0].cells.length;
	var lcol = table.rows[0].cells;	//console.log(lcol[1].id);
	var row = table.insertRow(lastrow);
    row.setAttribute("id", producto_id, 0);
	var cellcol0 = row.insertCell(0);
	//cellcol0.innerHTML = lastrow;
	cellcol0.innerHTML = '<button type="button" class="btn" style="padding: 0 0.5rem !important; width: 100%;" id="'+producto_id+'">'+producto_text+'</button>';
	
	
	for(i=1; i<lastcol;i++)	{
		var cell1 = row.insertCell(i);
        cell1.setAttribute("id", lcol[i].id + producto_id ); //console.log(lcol[i].id);
        cell1.className = 'text-center';
        if(i % 2 == 0) {
            cell1.innerHTML = '<input type="number" id="'+lcol[i].id+ producto_id+'___2" class="form-control" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" value="0" min="0" step="0.01" readonly>';
        }else {
            //cell1.setAttribute("id", lcol[i].id + producto.id+'___1');
            cell1.innerHTML = '<input type="number" id="'+lcol[i].id+ producto_id+'___1" class="form-control" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" value="0" min="0" step="0.01" readonly><input type="checkbox" id="'+lcol[i].id+ producto_id+'___c">';
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
            cell1.innerHTML = '<input type="number" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" id="'+sector_text + '___' + sector_value + '___'+ lrow[i].id + '___1" class="form-control" value="0" min="0" step="0.01" readonly><input type="checkbox" id="'+lcol[i].id+ producto_id+'___c">';
            cell2.innerHTML = '<input type="number" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" id="'+sector_text + '___' + sector_value + '___'+ lrow[i].id + '___2" class="form-control" value="0" min="0" step="0.01">';
        }
		
	}
}

/* function removeRow(id){
    $("tr#"+id).remove();
} */

/* function removeAllC(){
    var lastcol = (table.rows[0].cells.length)-1;
	var lastrow = (table.rows.length);
    for(i=0; i<lastrow;i++)	{
        for (j=lastcol; j>0; j--){
            table.rows[i].deleteCell(j);
        }
	}
} */

/* function removeCol(id){
    var row = table.rows;
  
    for (var i = 0; i < row[0].cells.length; i++) {
        var str = row[0].cells[i];
        if (str.id == id) { 
            for (var j = 0; j < row.length; j++) {
                row[j].deleteCell(i);
            }
        }
    }
} */