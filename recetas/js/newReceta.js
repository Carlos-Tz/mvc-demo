
var table = document.getElementById("receta_table");
var url = 'http://localhost/inomac/recetas';
/* var url = 'http://localhost:8080/local/dev/adm/mvc/recetas'; */

var subrancho = 0;
$(document).ready(function() {
    $('.subrancho_s').select2();
    $('.productos_s').select2();
    $('.clasificacion_s').select2();
    $("#form").keypress(function(e) {
        if (e.which == 13) {
            return false;
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
$('#subrancho').on('select2:select', function (e) {
    var data = e.params.data;
    subrancho = data.id;
    $('#sssub').val(subrancho);
    //console.log(data.id);
    $.ajax({
        type: "POST",
        url: 'index.php?c=recetas&action=sectores',
        data: { 'id': data.id },
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
        data: { 'id': data.id },
        success: function(response){
            $.when($('#ssectores').html(response))
        }
    })
  });

$('#clasificacion').on('select2:select', function (e) {
    var data = e.params.data;
    //console.log(data.id);
    $.ajax({
        type: "POST",
        url: 'index.php?c=recetas&action=productos',
        data: { 'clasificacion': data.id },
        success: function(response){
            $.when($('#productos').html(response)).done($('.productos_s').select2());
            
        $('#productos_lista').on('select2:select', function (evt) {
              addRow(evt.params.data);
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
        $.ajax({
            type: "POST",
            url: 'index.php?c=recetas&action=calcular',
            data: { 'id': idp, 'id_r': 0 },
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

function addRow(producto) {
    var lastrow = table.rows.length;
	var lastcol = table.rows[0].cells.length;
	var lcol = table.rows[0].cells;	//console.log(lcol[1].id);
	var row = table.insertRow(lastrow);
    row.setAttribute("id", producto.id, 0);
	var cellcol0 = row.insertCell(0);
	//cellcol0.innerHTML = lastrow;
	cellcol0.innerHTML = '<button type="button" class="btn" style="padding: 0 0.5rem !important; width: 100%;" id="'+producto.id+'">'+producto.text+'</button>';
	
	
	for(i=1; i<lastcol;i++)	{
		var cell1 = row.insertCell(i);
        cell1.setAttribute("id", lcol[i].id + producto.id ); //console.log(lcol[i].id);
        if(i % 2 == 0) {
            cell1.innerHTML = '<input type="number" id="'+lcol[i].id+ producto.id+'___2" class="form-control" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" name="pos'+(i)+'" onchange="change1(this)" value="0" min="0" step="0.01" onfocus="show('+producto.id+')" onblur="hide('+producto.id+')">';
        }else {
            //cell1.setAttribute("id", lcol[i].id + producto.id+'___1');
            cell1.innerHTML = '<input type="number" id="'+lcol[i].id+ producto.id+'___1" class="form-control" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm; height: 1.2rem;" name="pos'+(i)+'" onchange="change(this)" value="0" min="0" step="0.01" onfocus="show('+producto.id+')" onblur="hide('+producto.id+')">';
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