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
                    <input type="date" class="form-control" required name="fecha" id="fecha" value="<?= (empty($_SESSION['fecha'])) ? date("Y-m-d") : $_SESSION['fecha'] ?>">
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group">
                    <label for="sub">Subrancho:</label>
                    <select class="select2 subrancho_s" style="width: 100%;" id="subrancho">
                        <option value=""></option>
                        <?php
                        foreach ($data['data'] as $key => $va) {
                            echo '<option value="' . $va['num_subrancho'] . '">' . $va['nombre'] . '</option>';
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
                        <option value="fertilizante">Fertilizante</option>
                        <option value="agroquimico">Agroquimico</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row px-2" style="background-color: #e3e6ec">
            <div class="col-sm-12">
                <label for="sub">Sectores:</label>
            </div>
        </div>
        <div class="row py-2 px-2" id="sectores" style="background-color: #e3e6ec">
        </div>
        <div class="row px-2" style="background-color: #e3e6ec">
            <div class="col-sm-12">
                <label for="sub">Productos</label>
            </div>
        </div>
        <div class="row py-2 px-2" id="productos" style="background-color: #e3e6ec">
        </div>

        <table class="main-table" id="receta_table" border="1">
            <tbody>
                <tr class="table-header">
                    <td>Nombre del producto</td>
                    <!-- <td>DOSIS POR HECTÁREA</td>
                    <td>Sector</td>
                    <td>Dosis total</td> -->
<!--                     <td>PO 1</td>
                    <td>PO 2</td> -->
                </tr>
                <!-- <tr>
                    <td></td>
                    <td></td>
                </tr> -->
                <!-- <tr class="default-row">
                    <td>1</td>
                    <td><input type="text" name="course_code[]"></td>
                    <td><input type="text" name="course_name[]"></td>
                    <td><input type="checkbox" name="po1[]" value="Po1"></td>
                    <td><input type="checkbox" name="po2[]" value="Po2"></td>
                </tr> -->
            </tbody>
        </table>
        <!-- <button onclick="addRow()">Add Row</button>
        <button onclick="addCol()">Add Column</button>


        <button onclick="removeCol()">Remove Column</button> -->
        <!-- <button onclick="removeRow(3)">Remove Row</button> -->

    </div>
</div> <!-- card-body -->

<?php include_once("../utils/piePagina.php"); ?>

<script src="<?= DIR_S ?>recetas/js/newReceta.js"></script>