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
    console.log(data.id);
    $.ajax({
        type: "POST",
        url: 'index.php?c=recetas&action=sectores',
        data: { 'id': data.id },
        success: function(response){
            $.when($('#sectores').html(response)).done($('.sectores_s').select2())
            //$('#sectores').html(response);
            
            //console.log(response);
            console.log('done!!');
        //$('.sectores_s').select2();

        }
      });
  });
$('#clasificacion').on('select2:select', function (e) {
    var data = e.params.data;
    console.log(data.id);
    $.ajax({
        type: "POST",
        url: 'index.php?c=recetas&action=productos',
        data: { 'clasificacion': data.id },
        success: function(response){
            $.when($('#productos').html(response)).done($('.productos_s').select2())
            //$('#sectores').html(response);
            
            //console.log(response);
            console.log('done!!');
        //$('.sectores_s').select2();

        }
      });
  });


var table = document.getElementById("po-table");

function change(val){
    console.log(val.value);
}

function addRow() {
    
    var lastrow = table.rows.length;
	var lastcol = table.rows[0].cells.length;	
	var row = table.insertRow(lastrow);
	var cellcol0 = row.insertCell(0);
	cellcol0.innerHTML = lastrow;
	var cellcol1 = row.insertCell(1);
	cellcol1.innerHTML = '<input type="text" name="course_code'+lastrow+'" onkeyup="change(this)"></input>';
	var cellcol2 = row.insertCell(2);
	cellcol2.innerHTML = '<input type="text" name="course_name'+lastrow+'"></input>';
	
	for(i=3; i<lastcol;i++)
	{
		var cell1 = row.insertCell(i);
		cell1.innerHTML = '<input type="checkbox" name="pos'+(i-2)+'"></input>';
	}
    
}
function addCol() {
    
    var lastrow = table.rows.length;
	var lastcol = table.rows[0].cells.length;
	var headertxt = table.rows[0].cells[lastcol-1].innerHTML;
	var headernum = headertxt.slice(headertxt.indexOf("PO")+2);
	headernum = headernum.trim();
	
    //for each row add column
	for(i=0; i<lastrow;i++)
	{
		
		var cell1 = table.rows[i].insertCell(lastcol);
		if(i==0)
			cell1.innerHTML = "PO " + (Number(headernum)+1);
		else
			cell1.innerHTML = '<input type="checkbox" name="pos'+(Number(headernum)+1)+'"></input>';
		
	}
}

function removeRow(){
	var lastrow = table.rows.length;
	if(lastrow<2){
		alert("You have reached the minimal required rows.");
		return;
	}
	table.deleteRow(lastrow-1);
}

function removeCol(){

	var lastcol = (table.rows[0].cells.length)-1;
	var lastrow = (table.rows.length);
	//disallow first two column removal unless code is add to re-add text box columns vs checkbox columns
	if(lastcol<3){
		alert("You have reached the minimal required columns.");
		return;
	}
	
	 //for each row remove column
	for(i=0; i<lastrow;i++)
	{
		table.rows[i].deleteCell(lastcol);
	}
}