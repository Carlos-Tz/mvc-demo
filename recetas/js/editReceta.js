
var table = document.getElementById("receta_table");
var url = 'http://localhost/inomac/recetas';
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
                $('#all').click(function(e){
                    e.preventDefault();
                    var row = table.rows;
                    var cc = row[0].cells.length;
                    let text = "¿Confirma que desea borrar la tabla y agregar todos los sectores?";
                    if(row.length > 1 && cc > 1){
                        if (confirm(text) == true) {
                            $(".sectores_s > option").prop("selected", "selected");
                            $(".sectores_s").trigger('select2:select');
                            $(".sectores_s").trigger('change');
                        }
                    }else{
                        $(".sectores_s > option").prop("selected", "selected");
                        $(".sectores_s").trigger('select2:select');
                        $(".sectores_s").trigger('change');
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
                            //console.log(va);
                            //console.log(va.id_prod);
                            //var row = $('tr#'+va.id_prod); console.log(row)
                        }
                        let sectores_u = sectores.filter((item,index)=>{
                            return sectores.indexOf(item) === index;
                        })
                        let productos_u = productos.filter((item,index)=>{
                            return productos.indexOf(item) === index;
                        })
                        //console.log(sectores_u);
                        //console.log(productos_u);
                        $('.sectores_s').val(sectores_u);
                        $(".sectores_s").trigger('select2:select');
                        $('.sectores_s').trigger('change'); 
                        //productos_g = productos_u;
                        //console.log($('.productos_s'))
                        //console.log($('.sectores_s'))
                        $('.productos_s').val(productos_u);
                        $(".productos_s").trigger('select2:select');
                        $('.productos_s').trigger('change'); 
                        for(let va of data){
                            let dosis_t = parseInt(va.dosis_total).toFixed(2);
                            let dosis_h = parseInt(va.dosis_hectarea).toFixed(2);
                            var inp = $('input#'+va.nombre_s+'___'+va.id_sector+'___'+va.id_prod+'___1').val(dosis_t).trigger('change');
                            var inp2 = $('input#'+va.nombre_s+'___'+va.id_sector+'___'+va.id_prod+'___2').val(dosis_h).trigger('change');
                        }
                        //var inp = $('input#A1___1___2889___1'); console.log(inp)

                    }
                })
            );

            $('#sectores_lista').on('select2:select', function (evt) {
                if(evt.params){
                    addCol(evt.params.data.id, evt.params.data.text);
                } else {
                    removeAllC();
                    for (let va of evt.target.selectedOptions){
                        //console.log(va.value + ' => ' + va.text);
                        addCol(va.value, va.text);
                    }
                }
            });
            $('#sectores_lista').on('select2:unselecting', function (evt) {
                let text = "¿Confirma que desea eliminar este sector de la tabla?";
                if (confirm(text) == true) {
                  } else {
                      evt.preventDefault();
                  }
            });

            $('#sectores_lista').on('select2:unselect', function (evt) {
                removeCol(evt.params.data.text+'___'+evt.params.data.id+'___');
                removeCol(evt.params.data.text+'___'+evt.params.data.id+'___');
                //console.log(evt.params.data.id);
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
        $('#productos_lista').on('select2:unselecting', function (evt) {
            let text = "¿Confirma que desea eliminar este producto de la tabla?";
            if (confirm(text) == true) {
                console.log('se ha aceptado la eliminacin!');
              } else {
                  evt.preventDefault();
                console.log('ha cancelado la eliminacion');
              }
        });
        $('#productos_lista').on('select2:unselect', function (evt) {
            removeRow(evt.params.data.id);
        });

        }
      });
});
$('#form').submit(function(e){
    e.preventDefault();
    var row = table.rows;
    var cc = row[0].cells.length;
    let text = "¿Confirma que desea guardar la receta?";
    if(row.length > 1 && cc > 1){
        if (confirm(text) == true) {
            $.ajax({
                url: 'index.php?c=recetas&action=guardar',
                type: 'post',
                data:$('#form').serialize(),
                success: function(res){
                    var id = parseInt(res);
                    var datos = [];
        
                    for (var i = 1; i < row.length; i++) {
                        for (var j = 1; j < row[i].cells.length; j+=2) {
                            var td = row[i].cells[j];
                            var td2 = row[i].cells[j+1];
                            var v1 = parseFloat(td.firstChild.value);
                            var v2 = parseFloat(td2.firstChild.value);
                            var arrId = td.id.split('___');
                            var scp = arrId[0]; //console.log(scp);
                            var sicp = parseFloat(arrId[1]); //console.log(sicp);
                            var idp = parseFloat(arrId[2]); //console.log(idp);
                            var dost = parseFloat(td.firstChild.value);
                            var dosh = parseFloat(td2.firstChild.value);
                            datos.push({ id_receta: id, id_prod: idp, id_sector: sicp, dosis_total: dost, dosis_hectarea: dosh });
                        }
                    }
                    $.ajax({
                        url: 'index.php?c=recetas&action=guardar_detalles',
                        type: 'post',
                        data: { datos: datos},
                        success: function(res){
                            //console.log(res);
                            location.href = url;
                        }
                    });
                }
            });
        } 
    }else{
        alert('La tabla esta vacía!');
    }
});
$('#cancel').click(function(e){
    e.preventDefault();
    let text = "¿Confirma que desea cancelar la receta?";
    if (confirm(text) == true) {
        location.href = url;
    }
});


function change(val){
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
        if($('#'+idp+'_pp')[0].value){
            proEx = parseFloat($('#'+idp+'_pp')[0].value);
            if(sum > proEx) {
                alert('Existencia insuficiente de este prodcuto!');
                $('#'+scp+'___'+sicp+'___'+idp+'___'+clp).val(0).trigger('change');
            }else {
                var re = (proEx - sum);
                var ha = parseFloat($('#'+scp+'___ss')[0].value);
                $('#'+idp+'_ppp').val(parseFloat(re).toFixed(2));
                var valor2 = valor/ha; //console.log(valor2);
                if(valor > 0){
                    $('#'+scp+'___'+sicp+'___'+idp+'___'+'2').val(valor2.toFixed(2));
                }else {
                    $('#'+scp+'___'+sicp+'___'+idp+'___'+'2').val(0);
                }
            }
        }
    }
}
function change1(val){
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
}
function show(id){
    $('li#'+id+'_cc').show();
}
function hide(id){
    $('li#'+id+'_cc').hide();
}

function addRow(producto_id, producto_text) {
    var lastrow = table.rows.length;
	var lastcol = table.rows[0].cells.length;
	var lcol = table.rows[0].cells;	//console.log(lcol[1].id);
	var row = table.insertRow(lastrow);
    row.setAttribute("id", producto_id, 0);
	var cellcol0 = row.insertCell(0);
	//cellcol0.innerHTML = lastrow;
	cellcol0.innerHTML = '<button type="button" class="btn" style="padding: 0 0.5rem !important;" id="'+producto_id+'">'+producto_text+'</button>';
	
	
	for(i=1; i<lastcol;i++)	{
		var cell1 = row.insertCell(i);
        cell1.setAttribute("id", lcol[i].id + producto_id ); //console.log(lcol[i].id);
        if(i % 2 == 0) {
            cell1.innerHTML = '<input type="number" id="'+lcol[i].id+ producto_id+'___2" class="form-control" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" name="pos'+(i)+'" onchange="change1(this)" value="0" min="0" step="0.01" onfocus="show('+producto_id+')" onblur="hide('+producto_id+')">';
        }else {
            //cell1.setAttribute("id", lcol[i].id + producto.id+'___1');
            cell1.innerHTML = '<input type="number" id="'+lcol[i].id+ producto_id+'___1" class="form-control" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" name="pos'+(i)+'" onchange="change(this)" value="0" min="0" step="0.01" onfocus="show('+producto_id+')" onblur="hide('+producto_id+')">';
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
		if(i==0){
            cell1.innerHTML = "Sector " + sector_text;
			cell2.innerHTML = "Dosis Ha";
            cell1.className = 'td_green';
            cell2.className = 'td_white';
           /*  if(table.rows[0].cells[lastcol-1].className == 'td_blue'){
                cell1.className = 'td_green';
                cell2.className = 'td_green';
            }else {
                cell1.className = 'td_blue';
                cell2.className = 'td_blue';
            } */
        }
		else  {
            cell1.innerHTML = '<input type="number" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" id="'+sector_text + '___' + sector_value + '___'+ lrow[i].id + '___1" class="form-control" name="pos'+ sector_value +'" onchange="change(this)" value="0" min="0" step="0.01" onfocus="show('+lrow[i].id+')" onblur="hide('+lrow[i].id+')">';
            cell2.innerHTML = '<input type="number" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" id="'+sector_text + '___' + sector_value + '___'+ lrow[i].id + '___2" class="form-control" name="pos'+ sector_value +'" onchange="change1(this)" value="0" min="0" step="0.01" onfocus="show('+lrow[i].id+')" onblur="hide('+lrow[i].id+')">';
        }
		
	}
}

function removeRow(id){
    $("tr#"+id).remove();
}

function removeAllC(){
    var lastcol = (table.rows[0].cells.length)-1;
	var lastrow = (table.rows.length);
    for(i=0; i<lastrow;i++)	{
        for (j=lastcol; j>0; j--){
            table.rows[i].deleteCell(j);
        }
	}
}

function removeCol(id){
    var row = table.rows;
  
    for (var i = 0; i < row[0].cells.length; i++) {
        var str = row[0].cells[i];
        if (str.id == id) { 
            for (var j = 0; j < row.length; j++) {
                row[j].deleteCell(i);
            }
        }
    }
}