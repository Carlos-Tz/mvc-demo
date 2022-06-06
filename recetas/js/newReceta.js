// In your Javascript (external .js resource or <script> tag)
var table = document.getElementById("receta_table");
var subrancho = 0;
$(document).ready(function() {
    $('.subrancho_s').select2();
    $('.productos_s').select2();
    $('.clasificacion_s').select2();
    
    /* $.ajax({
        type: "POST",
        url: 'index.php?c=recetas&action=subrancho',
        success: function(response){
            //console.log(response);
            console.log('done!!');
        }
      }); */
});
$('#form').submit(function(e){
    e.preventDefault();
    $.ajax({
        url: 'index.php?c=recetas&action=guardar',
        type: 'post',
        data:$('#form').serialize(),
        success: function(res){
            //console.log('ok');
            var id = parseInt(res);
            console.log(id);
            var row = table.rows; // Getting the rows
            /* console.log(row);
            console.log(row.length);
            console.log(row[0].cells);
            console.log(row[0].cells.length); */
            var datos = [];
  
            for (var i = 1; i < row.length; i++) {
                //console.log(row[i]);
                for (var j = 1; j < row[i].cells.length; j+=2) {
                    var td = row[i].cells[j];
                    var td2 = row[i].cells[j+1];
                    var v1 = parseFloat(td.firstChild.value);
                    var v2 = parseFloat(td2.firstChild.value);
                    var arrId = td.id.split('___');
                    var scp = arrId[0]; console.log(scp);
                    var idp = arrId[1]; console.log(idp);
                    //datos.push({ id_receta: id, id_prod: idp, id_sector,  })
                    //console.log(td);
                   /*  console.log(td.id);
                    console.log(td.firstChild.value);
                    console.log(td2.firstChild.value); */
                }
                //row[j].deleteCell(i);
                /* if (str.id == id) { 
                } */
            }
        }
    });
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
                    let text = "¿Esta seguro que quiere reiniciar la tabla y agregar todos los sectores?";
                    if (confirm(text) == true) {
                        $(".sectores_s > option").prop("selected", "selected");
                        $(".sectores_s").trigger('select2:select');
                        $(".sectores_s").trigger('change');
                        console.log('se ha aceptado la eliminacin!');
                    } else {
                        //evt.preventDefault();
                        console.log('ha cancelado la eliminacion');
                    }
                    //if($("#all").is(':checked')){
                        //all();
                        
                       // alert('ok');
                        // } else {
                            //    $(".sectores_s > option").removeAttr("selected");
                            //   $(".sectores_s").trigger("change");
                            //} 
                            
                })
            );

            $('#sectores_lista').on('select2:select', function (evt) {
                if(evt.params){
                    addCol(evt.params.data.id, evt.params.data.text);
                } else {
                    //console.log(evt.target.selectedOptions);
                    removeAllC();
                    for (let va of evt.target.selectedOptions){
                        //console.log(va.value + ' => ' + va.text);
                        addCol(va.value, va.text);
                    }
                    //$('.sectores_s').val(null).trigger('change');
                    //addCol(evt.params.data.id, evt.params.data.text);
                }
                //console.log(evt.target.selectedOptions);
                //console.log(evt);
                //console.log(evt.params);
                //console.log(evt.params.data.id);
                //console.log(evt.params.data.text);
            });
            $('#sectores_lista').on('select2:unselecting', function (evt) {
                let text = "¿Esta seguro que quiere remover este sector de la tabla?";
                if (confirm(text) == true) {
                    //removeRow(evt.params.data.id);
                    //text = "You pressed OK!";
                    console.log('se ha aceptado la eliminacin!');
                  } else {
                      evt.preventDefault();
                    console.log('ha cancelado la eliminacion');
                  }
            });

            $('#sectores_lista').on('select2:unselect', function (evt) {
                removeCol(evt.params.data.text+'___');
                removeCol(evt.params.data.text+'___');
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
            //$('#sectores').html(response);
            
            //console.log(response);
            //console.log('done!!');
        //$('.sectores_s').select2();
        $('#productos_lista').on('select2:select', function (evt) {
            /* var args = JSON.stringify(evt.params, function (key, value) {
                if (value && value.nodeName) return "[DOM node]";
                if (value instanceof $.Event) return "[$.Event]";
                return value;
              }); */
        
              //console.log(evt.params['data']);
              //console.log(evt.params.data.id);
              //console.log(evt.params.data.text);
              addRow(evt.params.data);
        });
        $('#productos_lista').on('select2:unselecting', function (evt) {
            let text = "¿Esta seguro que quiere remover este producto de la tabla?";
            if (confirm(text) == true) {
                //removeRow(evt.params.data.id);
                //text = "You pressed OK!";
                console.log('se ha aceptado la eliminacin!');
              } else {
                  evt.preventDefault();
                console.log('ha cancelado la eliminacion');
              }
        });
        $('#productos_lista').on('select2:unselect', function (evt) {
            removeRow(evt.params.data.id);
            /* let text = "¿Esta seguro que quiere remover este producto de la tabla?";
            if (confirm(text) == true) {
                //text = "You pressed OK!";
              } else {
                console.log('ha cancelado la eliminacion');
              } */
            //console.log(evt.params.data.id);
        });

        }
      });
  });

/* $('#productos_lista').on('select2:select', function (e) {
    var args = JSON.stringify(evt.params, function (key, value) {
        if (value && value.nodeName) return "[DOM node]";
        if (value instanceof $.Event) return "[$.Event]";
        return value;
      });

      console.log(args);
});
 */


function change(val){
    var id = val.id;
    var sum = 0;
    var proEx = 0;
    var valor = val.value; //console.log(subrancho);
    //console.log(val.value);
    if (valor >= 0){
        var arrId = id.split('___');
        var scp = arrId[0]; //console.log(id);
        var idp = arrId[1]; //console.log(idp);
        var clp = arrId[2]; //console.log(idp);
        var row = $('tr#'+idp);
        var cells = row[0].cells;
        for (var i = 1; i < cells.length; i++) {
            var td = cells[i];
            if(i % 2 != 0) { sum += parseFloat(td.firstChild.value); }
        }
        if($('#'+idp+'_pp')[0].value){
            proEx = parseFloat($('#'+idp+'_pp')[0].value);
            if(sum > proEx) {
                alert('Existencia faltante!');
                $('#'+scp+'___'+idp+'___'+clp).val(0).trigger('change');
            }else {
                var re = (proEx - sum);
                var ha = parseFloat($('#'+scp+'___ss')[0].value);
                $('#'+idp+'_ppp').val(parseFloat(re).toFixed(2));//console.log($('#'+scp+'___ss'));console.log($('#'+scp+'___ss')[0]);console.log($('#'+scp+'___ss')[0].value);
                var valor2 = valor/ha; //console.log(valor2);
                if(valor > 0){
                    $('#'+scp+'___'+idp+'___'+'2').val(valor2.toFixed(2));
                }else {
                    $('#'+scp+'___'+idp+'___'+'2').val(0);
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
        var idp = arrId[1]; //console.log(idp);
        var clp = arrId[2]; //console.log(idp);
        //var row = $('tr#'+idp);
        /* var cells = row[0].cells;
        for (var i = 1; i < cells.length; i++) {
            var td = cells[i];
            if(i % 2 != 0) { sum += parseFloat(td.firstChild.value); }
        } */
        //if($('#'+idp+'_pp')[0].value){
          //  proEx = parseFloat($('#'+idp+'_pp')[0].value);
            //if(sum > proEx) {
              //  alert('Existencia faltante!');
                //$('#'+scp+'___'+idp+'___'+'1').val(0).trigger('change');
            //}else {
              //  var re = (proEx - sum);
                var ha = parseFloat($('#'+scp+'___ss')[0].value);
                //$('#'+idp+'_ppp').val(parseFloat(re).toFixed(2));
                var valor2 = valor*ha; //console.log(valor2); console.log(ha);
                if(valor > 0){
                    $('#'+scp+'___'+idp+'___'+'1').val(valor2.toFixed(2)).trigger('change');
                }else {
                    $('#'+scp+'___'+idp+'___'+'1').val(0).trigger('change');
                }
            //}
        //}
    }
}
function show(id){
    //console.log('id => ' +id);
    $('li#'+id+'_cc').show();
}
function hide(id){
    //console.log('id => ' +id);
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
	cellcol0.innerHTML = '<button type="button" class="btn" style="padding: 0 0.5rem !important;" id="'+producto.id+'" onmouseover="show('+producto.id+')" onmouseout="hide('+producto.id+')">'+producto.text+'</button>';
	/* var cellcol1 = row.insertCell(1);
	cellcol1.innerHTML = '<input type="text" name="course_code'+lastrow+'" onkeyup="change(this)"></input>';
	var cellcol2 = row.insertCell(2);
	cellcol2.innerHTML = '<input type="text" name="course_name'+lastrow+'"></input>'; */
	
	for(i=1; i<lastcol;i++)	{
		var cell1 = row.insertCell(i);
        cell1.setAttribute("id", lcol[i].id + producto.id );
        if(i % 2 == 0) {
            cell1.innerHTML = '<input type="number" id="'+lcol[i].id+ producto.id+'___2" class="form-control" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm;" name="pos'+(i)+'" onchange="change1(this)" value="0" min="0" step="0.01">';
        }else {
            //cell1.setAttribute("id", lcol[i].id + producto.id+'___1');
            cell1.innerHTML = '<input type="number" id="'+lcol[i].id+ producto.id+'___1" class="form-control" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm;" name="pos'+(i)+'" onchange="change(this)" value="0" min="0" step="0.01">';
        }
	}
}

function addCol(sector_value, sector_text) {
    var lastrow = table.rows.length;
    var lrow = table.rows;
	var lastcol = table.rows[0].cells.length;
	/* var headertxt = table.rows[0].cells[lastcol-1].innerHTML;
	var headernum = headertxt.slice(headertxt.indexOf("PO")+2);
	headernum = headernum.trim(); */
	
    //for each row add column
	for(i=0; i<lastrow;i++)	{
		var cell1 = table.rows[i].insertCell(lastcol); //if (i>0)console.log(lrow[i].id);
        cell1.setAttribute("id", sector_text + '___' + lrow[i].id );
		var cell2 = table.rows[i].insertCell(lastcol+1);
        cell2.setAttribute('id', sector_text + '___' + lrow[i].id );
		if(i==0){
            cell1.innerHTML = "Sector " + sector_text;
            //cell1.classList.add("w-2cm");
			cell2.innerHTML = "Dosis Ha";
        }
		else  {
            cell1.innerHTML = '<input type="number" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm;" id="'+sector_text + '___'+ lrow[i].id + '___1" class="form-control" name="pos'+ sector_value +'" onchange="change(this)" value="0" min="0" step="0.01">';
            cell2.innerHTML = '<input type="number" style="padding: 0 0.3rem; border: none; text-align: center; min-width: 1.8cm;" id="'+sector_text + '___'+ lrow[i].id + '___2" class="form-control" name="pos'+ sector_value +'" onchange="change1(this)" value="0" min="0" step="0.01">';
        }
		
	}
}

function removeRow(id){
	/* var lastrow = table.rows.length;
	if(lastrow<2){
		alert("You have reached the minimal required rows.");
		return;
	}
	table.deleteRow(lastrow-1); */
	//table.deleteRow(row);
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
    var row = table.rows; // Getting the rows
  
    for (var i = 0; i < row[0].cells.length; i++) {

        // Getting the text of columnName
        //var str = row[0].cells.namedItem(id);
        var str = row[0].cells[i];

        //console.log(str.id);
        // If 'Geek_id' matches with the columnName 
        if (str.id == id) { 
            for (var j = 0; j < row.length; j++) {

                // Deleting the ith cell of each row
                row[j].deleteCell(i);
            }
        }
    }

	/* var lastcol = (table.rows[0].cells.length)-1; //console.log(lastcol);*/
	//var lastrow = (table.rows.length);
    //console.log(lastcol + ' => ' + lastrow);
	//disallow first two column removal unless code is add to re-add text box columns vs checkbox columns
	/* if(lastcol<4){
		alert("You have reached the minimal required columns.");
		return;
	} */
	
	 //for each row remove column
	/* for(i=0; i<lastrow;i++)	{
		table.rows[i].deleteCell(lastcol);
	} */
    //$("#"+id).remove();
}