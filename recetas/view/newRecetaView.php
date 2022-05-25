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
                    <select class="select2 subrancho_s" style="width: 100%;" id="subrancho">
                        <option value=""></option>
                        <?php
                            foreach ($data['data'] as $key => $va){
                                echo '<option value="'.$va['num_subrancho'].'">'.$va['nombre'].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group">
                    <label for="sub">Clasificación:</label>
                    <select class="select2 clasificacion_s" style="width: 100%;" id="clasificacion">
                        <option value=""></option>                        
                        <option value="Fertilizante">Fertilizante</option>                        
                        <option value="Agroquimico">Agroquimico</option>                        
                    </select>
                </div>
            </div>
        </div>
        <div class="row px-2" style="background-color: #e3e6ec">
            <div class="col-sm-12">
                <label for="sub">Productos</label>
                    <!-- <button class="btn btn-outline-success btn-block" id="entradas">GENERAR</button> -->
                    <!-- <select class="select2 productos_s" style="width: 100%;" name="states[]" multiple="multiple">
                        <option value="AL">Alabama</option>
                        <option value="BL">Blabama</option>
                        <option value="CL">Clabama</option>
                        <option value="DL">Dlabama</option>
                        <option value="EL">Elabama</option>
                        <option value="FL">Flabama</option>
                        <option value="WY">Wyoming</option>
                    </select> -->
                <!-- <button class="btn btn-outline-primary btn-block" id="salidas" name="salidas">SALIDAS</button> -->
            </div>
        </div>
        <div class="row py-2 px-2" id="productos" style="background-color: #e3e6ec">
        </div>
        <div class="row px-2" style="background-color: #e3e6ec">
            <div class="col-sm-12">
                <label for="sub">Sectores:</label>
                <!-- <select class="select2 productos_s" id="sectores" style="width: 100%;" name="states[]" multiple="multiple">
                </select> -->
            </div>
        </div>
        <div class="row py-2 px-2" id="sectores" style="background-color: #e3e6ec">
            <!-- <select class="select2 sectores_s" style="width: 100%;" name="states[]" multiple="multiple">
            </select> -->
        </div>
    </div>
</div> <!-- card-body -->

<?php include_once("../utils/piePagina.php") ;?>

<script src="<?= DIR_S ?>recetas/js/newReceta.js"></script>