// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2();
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
            $('#sectores').html(response);
            
            //console.log(response);
            console.log('done!!');
        }
      });
  });