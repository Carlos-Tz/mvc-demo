<?php
include 'cabecera.php';
date_default_timezone_set('America/Mexico_City');
?>


<div class="card-body">
    <div class="container-fluid">
        <H1>Módulo Ejecutivo</H1>
        <button onclick="tabla()">tabla</button>
        <table id="entries" class="display" style="width: 100%">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <!-- <th>Semana</th>
                    <th>Id Producto</th>
                    <th>Nombre Producto</th>
                    <th>Existencia</th>
                    <th>Costo Promedio</th>
                    <th>Clasificación</th> -->
                </tr>
            </thead>
            <tfoot>
            </tfoot>
        </table>
        <!-- <section class="col-lg-7" style="height:400px;overflow-y:scroll;"> -->
            <?php /* foreach ($datos["entries"] as $entry) { ?>
                <?php echo $entry["fecha"]; ?> -
                <?php echo $entry["semana"]; ?> -
                <?php echo $entry["id_prod"]; ?> -
                <?php echo $entry["nom_prod"]; ?>
                <?php echo $entry["existencia"]; ?>
                <?php echo $entry["costo_promedio"]; ?>
                <?php echo $entry["clasificacion"]; ?>
                <div class="right">
                </div>
                <hr />
            <?php } */ ?>
        <!-- </section> -->

    </div>
</div> <!-- card-body -->

<?php include "piePagina.php";
?>

<script src="<?= DIR_S ?>js/app.js"></script>