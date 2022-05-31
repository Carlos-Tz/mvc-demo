// In your Javascript (external .js resource or <script> tag)
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
$('#subrancho').on('select2:select', function (e) {
    var data = e.params.data;
    //console.log(data.id);
    $.ajax({
        type: "POST",
        url: 'index.php?c=recetas&action=sectores',
        data: { 'id': data.id },
        success: function(response){
            $.when($('#sectores').html(response)).done($('.sectores_s').select2()).done(
                $('#all').click(function(){
                    //if($("#all").is(':checked')){
                        //all();
                        $(".sectores_s > option").prop("selected", "selected");
                        $(".sectores_s").trigger('select2:select');
                        $(".sectores_s").trigger('change');
                       // alert('ok');
                        // } else {
                            //    $(".sectores_s > option").removeAttr("selected");
                            //   $(".sectores_s").trigger("change");
                            //} 
                            
                })
            );
            
            //$('#sectores').html(response);
            
            //console.log(response);
            //console.log('done!!');
        //$('.sectores_s').select2();

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
        /* $('#sectores_lista').on('change', function (evt) {
            for (let va of evt.target.selectedOptions){
                //console.log(va.value + ' => ' + va.text);
                addCol(va.value, va.text);
            }
            //console.log(evt.target.selectedOptions);
        }); */

        $('#sectores_lista').on('select2:unselect', function (evt) {
            removeCol(evt.params.data.id+'_1');
            removeCol(evt.params.data.id+'_2');
            //console.log(evt.params.data.id);
        });

        }
      });
  });

/* function all(){
    $('#sectores_lista').on('select2:select', function (evt) {
        var values = [];
        // copy all option values from selected
        $(evt.currentTarget).find("option:selected").each(function(i, selected){
            console.log($(selected)[0].value); 
            values[i] = $(selected)[0].value; .text();
        });
        // doing a diff of old_values gives the new values selected
        //var last = $(values).not(old_values).get();
        // update old_values for future use
        //old_values = values;
        // output values (all current values selected)
        console.log("selected values: ", values);
        // output last added value
        //console.log("last added: ", last);
    });
} */

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
        $('#productos_lista').on('select2:unselect', function (evt) {
            removeRow(evt.params.data.id);
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

var table = document.getElementById("receta_table");

function change(val){
    console.log(val.value);
}

function addRow(producto) {
    var lastrow = table.rows.length;
	var lastcol = table.rows[0].cells.length;	
	var row = table.insertRow(lastrow);
    row.setAttribute("id", producto.id, 0);
	var cellcol0 = row.insertCell(0);
	//cellcol0.innerHTML = lastrow;
	cellcol0.innerHTML = producto.text;
	/* var cellcol1 = row.insertCell(1);
	cellcol1.innerHTML = '<input type="text" name="course_code'+lastrow+'" onkeyup="change(this)"></input>';
	var cellcol2 = row.insertCell(2);
	cellcol2.innerHTML = '<input type="text" name="course_name'+lastrow+'"></input>'; */
	
	for(i=1; i<lastcol;i++)	{
		var cell1 = row.insertCell(i);
		cell1.innerHTML = '<input type="number" class="form-control" name="pos'+(i)+'"></input>';
	}
    
}

function addCol(sector_value, sector_text) {
    var lastrow = table.rows.length;
	var lastcol = table.rows[0].cells.length;
	/* var headertxt = table.rows[0].cells[lastcol-1].innerHTML;
	var headernum = headertxt.slice(headertxt.indexOf("PO")+2);
	headernum = headernum.trim(); */
	
    //for each row add column
	for(i=0; i<lastrow;i++)	{
		var cell1 = table.rows[i].insertCell(lastcol);
        cell1.setAttribute("id", sector_value + '_1');
		var cell2 = table.rows[i].insertCell(lastcol+1);
        cell2.setAttribute('id', sector_value + '_2');
		if(i==0){
            cell1.innerHTML = "Sector " + sector_text;
			cell2.innerHTML = "Dosis " + sector_text;
        }
		else  {
            cell1.innerHTML = '<input type="number" class="form-control" name="pos'+ sector_value +'"></input>';
            cell2.innerHTML = '<input type="number" class="form-control" name="pos'+ sector_value +'"></input>';
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
    $("#"+id).remove();
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

        console.log(str.id);
        // If 'Geek_id' matches with the columnName 
        if (str.id == id) { 
            for (var j = 0; j < row.length; j++) {

                // Deleting the ith cell of each row
                row[j].deleteCell(i);
            }
        }
    }

	/* var lastcol = (table.rows[0].cells.length)-1; //console.log(lastcol);*/
	var lastrow = (table.rows.length);
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