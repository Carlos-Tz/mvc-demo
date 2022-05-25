<?php 
    echo '<select class="select2 productos_s" style="width: 100%;" name="states[]" multiple="multiple">';
    
    foreach ($data['productos'] as $key => $va){
        /* echo '<div class="col-sm-3 col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="'.$va['num_subrancho'].'" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        '.$va['nombre'].'
                    </label>
                </div>
             </div>'; */
             echo '<option value="'.$va['id_prod'].'">'.$va['nom_prod'].'</option>';
    }
    echo '</select>';