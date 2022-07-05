<?php
include("../utils/cabecera.php");
date_default_timezone_set('America/Mexico_City');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="card-body">
    <div class="container-fluid">
        <H1>Módulo Ejecutar Recetas</H1>
        <div class="row">
            <div class="col-sm-12">
                <div class="container mt-1" id="cont_e">
                    <table class="table table-striped table-bordered table-hover" id="table-recipes" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Subrancho</th>
                                <th>Fecha</th>
                                <th>Estatus</th>
                                <th>Justificación</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div> <!-- card-body -->

<?php include_once("../utils/piePagina.php"); ?>

<script src="<?= DIR_S ?>ejecutar_recetas/js/recetas.js"></script>
