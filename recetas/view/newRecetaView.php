<?php
include("../utils/cabecera.php");
date_default_timezone_set('America/Mexico_City');
?>
<link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous" />
<link rel="stylesheet" href="<?= DIR_S ?>recetas/css/style.css">


<div class="card-body">
    <div class="container-fluid">
        <H1>Nueva Receta</H1>
        <div class="row py-2  px-2" style="background-color: #e3e6ec">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sub">Fecha:</label>
                    <input type="date" class="form-control" required name="fechaInicio" id="fechaInicio" value="<?= (empty($_SESSION['concentradoFechaInicio'])) ? date("Y-m-d", strtotime(date('Y-m-d') . "- 28 days")) : $_SESSION['concentradoFechaInicio'] ?>">
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group">
                    <label for="sub">Subrancho:</label>
                    <select class="select2" style="width: 100%;">
                        <option value="AL">Alabama</option>                    
                        <option value="WY">Wyoming</option>
                        <option value="ok">ok</option>
                        <option value="in">ing</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="sub"><?php echo data1 ?></label>
                    <button class="btn btn-outline-success btn-block" id="entradas">GENERAR</button>
                </div>
                <!-- <button class="btn btn-outline-primary btn-block" id="salidas" name="salidas">SALIDAS</button> -->
            </div>
        </div>
    </div>
</div> <!-- card-body -->

<?php include_once("../utils/piePagina.php") ;?>

<script src="<?= DIR_S ?>recetas/js/newReceta.js"></script>