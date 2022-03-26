<?php
include("../utils/cabecera.php");
date_default_timezone_set('America/Mexico_City');
?>
<link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous" />


<div class="card-body">
    <div class="container-fluid">
        <H1>Almacen Mensual</H1>
        <div class="row py-2  px-2" style="background-color: #e3e6ec">
            <div class="col-md-2">
                <label for="sub">Fecha :</label>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="date" class="form-control" required name="fechaAlmacen" id="fechaAlmacen" value="<?= date("Y-m-d")?>">
                </div>
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-success btn-block" id="almacen">Generar</button>
            </div>
        </div>
        <div id="btn_excel" style="display:none;" class="row">
            <div class="col-md-2">
                <button type="button" class="btn btn-secondary mt-2" onclick="almacen_mensual_excel()">Excel</button>
            </div>
            <div class="col-md-8 mt-3">
                <h6>Mes de: <span id="f_i"></span> a <span id="f_f"></span> </h6>
            </div>
        </div>
        <table id="table-almacen" class="table table-striped table-bordered table-hover" style="width: 100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Concepto</th>
                    <th>Corte Inicial</th>
                    <th>Corte Final</th>
                    <th>GASTO</th>
                    <th>COMPRAS</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align:right">Total:</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>
</div> <!-- card-body -->

<?php include_once("../utils/piePagina.php") ;?>

<script src="<?= DIR_S ?>ejecutivo/js/almacenMensual.js"></script>