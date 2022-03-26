<?php
include("../utils/cabecera.php");
date_default_timezone_set('America/Mexico_City');
?>
<link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous" />


<div class="card-body">
    <div class="container-fluid">
        <H1>Salidas</H1>
        <div class="row py-2  px-2" style="background-color: #e3e6ec">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sub">Fecha Inicio :</label>
                    <input type="date" class="form-control" required name="fechaInicio" id="fechaInicio" value="<?= (empty($_SESSION['concentradoFechaInicio'])) ? date("Y-m-d", strtotime(date('Y-m-d') . "- 28 days")) : $_SESSION['concentradoFechaInicio'] ?>">
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group ">
                    <label for="sub">Fecha Fin:</label>
                    <input type="date" class="form-control" required name="fechaFin" id="fechaFin" value="<?= (empty($_SESSION['concentradoFechaFin'])) ? date("Y-m-d") : $_SESSION['concentradoFechaFin'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="sub"></label>
                    <button class="btn btn-outline-success btn-block" id="salidas">GENERAR</button>
                </div>
                <!-- <button class="btn btn-outline-primary btn-block" id="salidas" name="salidas">SALIDAS</button> -->
            </div>
        </div>
        
        <div class="container mt-5" id="cont_s" style="display:none;">
            <h2 style="margin-bottom: 30px;">Salidas</h2>
            <button type="button" class="btn btn-secondary" onclick="salidas_excel()">Excel</button>
            <table class="table table-striped table-bordered table-hover" id="table-salidas" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Rubro</th>
                        <th>Costo</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align:right">Total:</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div> <!-- card-body -->

<?php include_once("../utils/piePagina.php") ;?>

<script src="<?= DIR_S ?>ejecutivo/js/salidas.js"></script>