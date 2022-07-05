<?php 
    echo '<select class="select2 productos_s" style="width: 100%;" name="productos_lista[]" id="productos_lista" multiple="multiple">';
    
    foreach ($data['productos'] as $key => $va){
             echo '<option value="'.$va['id_prod'].'">'.$va['nom_prod'].'</option>';
    }
    echo '</select>';
