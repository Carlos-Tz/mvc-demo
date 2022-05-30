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
            $.when($('#sectores').html(response)).done($('.sectores_s').select2());
            //$('#sectores').html(response);
            
            //console.log(response);
            //console.log('done!!');
        //$('.sectores_s').select2();

        $('#sectores_lista').on('select2:select', function (evt) {
              //console.log(evt.params['data']);
              console.log(evt.params.data.id);
              console.log(evt.params.data.text);
              addCol(evt.params.data);
        });

        }
      });
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
              console.log(evt.params.data.id);
              console.log(evt.params.data.text);
              addRow(evt.params.data);
        });
        $('#productos_lista').on('select2:unselect', function (evt) {
            removeRow(evt.params.data);
            console.log(evt.params.data.id);
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
		cell1.innerHTML = '<input type="text" name="pos'+(i-2)+'"></input>';
	}
    
}

function addCol(sector) {
    var lastrow = table.rows.length;
	var lastcol = table.rows[0].cells.length;
	/* var headertxt = table.rows[0].cells[lastcol-1].innerHTML;
	var headernum = headertxt.slice(headertxt.indexOf("PO")+2);
	headernum = headernum.trim(); */
	
    //for each row add column
	for(i=0; i<lastrow;i++)	{
		var cell1 = table.rows[i].insertCell(lastcol);
		if(i==0)
			cell1.innerHTML = "Sector " + sector.text;
		else
			cell1.innerHTML = '<input type="text" name="pos'+ sector.id +'"></input>';
		
	}
}

function removeRow(row){
	/* var lastrow = table.rows.length;
	if(lastrow<2){
		alert("You have reached the minimal required rows.");
		return;
	}
	table.deleteRow(lastrow-1); */
	//table.deleteRow(row);
    $("#"+row.id).remove();
}

function removeCol(){
	var lastcol = (table.rows[0].cells.length)-1; //console.log(lastcol);
	var lastrow = (table.rows.length);
	//disallow first two column removal unless code is add to re-add text box columns vs checkbox columns
	if(lastcol<4){
		alert("You have reached the minimal required columns.");
		return;
	}
	
	 //for each row remove column
	for(i=0; i<lastrow;i++)	{
		table.rows[i].deleteCell(lastcol);
	}
}