<?php 
    echo '<ul>';
    
    foreach ($data['sectores'] as $key => $va){
        echo '<li hidden>';
        echo '<input type="number" readonly id="' . $va['nombre'] . '___ss" value="' . $va['hectareas'] .'">';
        echo '</li>';
    }
    echo '</ul>';