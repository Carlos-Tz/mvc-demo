<?php 
    foreach ($data['sectores'] as $key => $va){
        echo '<div class="col-sm-1"
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="'.$va['num_subrancho'].'" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        '.$va['nombre'].'
                    </label>
                </div>
             </div>';
    }