<?php
include("../utils/cabecera.php");
date_default_timezone_set('America/Mexico_City');
?>

<div class="card-body">
    <div class="container-fluid">
        <H1>Módulo Ejecutivo</H1>
        <div class="row py-2  px-2" style="background-color: #e3e6ec">
            <div class="col-md-3">
                <a href="index.php?c=entradas&action=index" class="btn btn-outline-success btn-block" id="btn-almacen">Entradas</a>
            </div>
            <div class="col-md-3">
                <a href="index.php?c=salidas&action=index" class="btn btn-outline-success btn-block" id="btn-almacen">Salidas</a>
            </div>
            <div class="col-md-3">
                <a href="index.php?c=almacenSemanal&action=index" class="btn btn-outline-success btn-block" id="btn-almacen">Almacen Semanal</a>
            </div>
            <div class="col-md-3">
                <a href="index.php?c=almacenMensual&action=index" class="btn btn-outline-success btn-block" id="btn-almacen-mensual">Almacen Mensual</a>
            </div>
        </div>

    </div>
</div> <!-- card-body -->

<?php include_once("../utils/piePagina.php") ;?>
