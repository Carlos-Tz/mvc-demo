<?php
include 'cabecera.php';
date_default_timezone_set('America/Mexico_City');
?>

<div class="card-body">
    <div class="container-fluid">
        <H1>Módulo Ejecutivo</H1>
        <div class="row py-2  px-2" style="background-color: #e3e6ec">
            <div class="col-md-3">
                <a href="index.php?controller=entradas&action=index" class="btn btn-outline-success btn-block" id="btn-almacen">Entradas</a>
            </div>
            <div class="col-md-3">
                <a href="index.php?controller=salidas&action=index" class="btn btn-outline-success btn-block" id="btn-almacen">Salidas</a>
            </div>
            <div class="col-md-3">
                <a href="index.php?controller=almacenSemanal&action=index" class="btn btn-outline-success btn-block" id="btn-almacen">Almacen</a>
            </div>
        </div>

    </div>
</div> <!-- card-body -->

<?php include "piePagina.php";
?>

<!-- <script src="<?= DIR_S ?>js/app.js"></script> -->