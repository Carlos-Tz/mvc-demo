<?php
include 'cabecera.php';
date_default_timezone_set('America/Mexico_City');
?>
<link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous" />


<div class="card-body">
    <div class="container-fluid">
        <H1>Módulo Ejecutivo</H1>
        <button onclick="tabla()">tabla</button>
        <table id="entries" class="table table-striped table-bordered table-hover" style="width: 100%">
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

<?php include "piePagina.php";
?>

<script src="<?= DIR_S ?>js/app.js"></script>