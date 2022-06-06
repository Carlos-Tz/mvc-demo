<?php
include("../utils/cabecera.php");
date_default_timezone_set('America/Mexico_City');
?>

<div class="card-body">
    <div class="container-fluid">
        <H1>Módulo Recetas</H1>
        <div class="row py-2  px-2" style="background-color: #e3e6ec">
            <div class="col-md-3">
                <a href="index.php?c=recetas&action=nueva" class="btn btn-outline-success btn-block" id="btn-almacen">Nueva Receta</a>
            </div>
            <!-- <div class="col-md-3">
                <a href="index.php?c=salidas&action=index" class="btn btn-outline-success btn-block" id="btn-almacen">Salidas</a>
            </div>
            <div class="col-md-3">
                <a href="index.php?c=almacenSemanal&action=index" class="btn btn-outline-success btn-block" id="btn-almacen">Almacen Semanal</a>
            </div>
            <div class="col-md-3">
                <a href="index.php?c=almacenMensual&action=index" class="btn btn-outline-success btn-block" id="btn-almacen-mensual">Almacen Mensual</a>
            </div> -->
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="container mt-1" id="cont_e">
                    <!-- <h2 style="margin-bottom: 30px;">Recetas</h2> -->
                    <!-- <button type="button" class="btn btn-secondary" onclick="entradas_excel()">Excel</button> -->
                    <table class="table table-striped table-bordered table-hover" id="table-recipes" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Subrancho</th>
                                <th>Fecha</th>
                                <th>Estatus</th>
                                <th>Justificación</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <!-- <tfoot>
                            <tr>
                                <th colspan="2" style="text-align:right">Total:</th>
                                <th></th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>
            </div>
        </div>

    </div>
</div> <!-- card-body -->

<?php include_once("../utils/piePagina.php"); ?>

<script src="<?= DIR_S ?>recetas/js/recetas.js"></script>
