<?php 
    echo '<select class="select2 sectores_s" style="width: 100%;" name="sectores_lista[]" id="sectores_lista" multiple="multiple">';
    
    foreach ($data['sectores'] as $key => $va){
             echo '<option value="'.$va['id_sector'].'">'.$va['nombre'].'</option>';
    }
    echo '</select>';