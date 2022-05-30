<?php 
    echo '<select class="select2 sectores_s" style="width: 100%;" name="sectores_lista[]" id="sectores_lista" multiple="multiple">';
    
    foreach ($data['sectores'] as $key => $va){
        /* echo '<div class="col-sm-3 col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="'.$va['num_subrancho'].'" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        '.$va['nombre'].'
                    </label>
                </div>
             </div>'; */
             echo '<option value="'.$va['id_sector'].'">'.$va['nombre'].'</option>';
    }
    echo '</select>';