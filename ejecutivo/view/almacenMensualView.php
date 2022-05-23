<?php
include("../utils/cabecera.php");
date_default_timezone_set('America/Mexico_City');
?>
<link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous" />


<div class="card-body">
    <div class="container-fluid">
        <H1> <?php echo $datos['title'] ?></H1>
        <div class="row py-2  px-2" style="background-color: #e3e6ec">
            <div class="col-md-1">
                <label for="sub">Mes :</label>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <!-- <input type="date" class="form-control" required name="fechaAlmacen" id="fechaAlmacen" value="<?= date("Y-m-d")?>"> -->
                    <select name="mes" id="mes" class="form-control">
                        <option value="ENERO">Enero</option>
                        <option value="FEBRERO">Febrero</option>
                        <option value="MARZO">Marzo</option>
                        <option value="ABRIL">Abril</option>
                        <option value="MAYO">Mayo</option>
                        <option value="JUNIO">Junio</option>
                        <option value="JULIO">Julio</option>
                        <option value="AGOSTO">Agosto</option>
                        <option value="SEPTIEMBRE">Septiembre</option>
                        <option value="OCTUBRE">Octubre</option>
                        <option value="NOVIEMBRE">Noviembre</option>
                        <option value="DICIEMBRE">Diciembre</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <label for="sub">Ciclo :</label>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select name="ciclo" id="ciclo" class="form-control">
                        <?php foreach ($datos["cicles"] as $cicle) { ?>
                            <option value="<?php echo $cicle['id_ciclo']; ?>"><?php echo $cicle['ciclo']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-outline-success btn-block" id="almacen-mensual">Generar</button>
            </div>
        </div>
        <div id="btn_excel_mensual" style="display:none;" class="row">
            <div class="col-md-2">
                <button type="button" class="btn btn-secondary mt-2" onclick="almacen_mensual_excel()">Excel</button>
            </div>
        </div>
        <table id="table-almacen-mensual" class="table table-striped table-bordered table-hover" style="width: 100%">
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