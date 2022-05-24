// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2();
    $.ajax({
        type: "POST",
        url: 'index.php?c=recetas&action=subrancho',
        /* dataType:"jsonp", */
        success: function(response){
            //console.log(response);
            console.log('done!!');
        }
      });
});