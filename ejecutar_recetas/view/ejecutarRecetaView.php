<?php
include("../utils/cabecera.php");
date_default_timezone_set('America/Mexico_City');
?>
<!-- <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous" /> -->
<link rel="stylesheet" href="<?= DIR_S ?>ejecutar_recetas/css/style.css">


<div class="card-body">
    <div class="container-fluid">
        <form action="" method="POST" id="form">
        <H1>Ejecutar Receta</H1>
        <div class="row py-2  px-2" style="background-color: #e3e6ec">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sub">Fecha:</label>
                    <input type="number" value="<?php echo $data['receta'][0]['num_subrancho'] ?>" id="sssub" hidden>
                    <input type="text" value="<?php echo $data['receta'][0]['nombre'] ?>" id="nombress" hidden>
                    <input type="number" value="<?php echo $data['receta'][0]['id_receta'] ?>" id="id_receta" hidden>
                    <input type="text" name="estatus" value="Programada" hidden>
                    <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $data['receta'][0]['fecha'] ?>" required readonly>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group">
                    <label for="sub">Subrancho:</label>
                    <select class="select2 subrancho_s" style="width: 100%;" id="subrancho" name="subrancho" required disabled>
                        <option value="<?php echo $data['receta'][0]['num_subrancho'] ?>"><?php echo $data['receta'][0]['nombre'] ?></option>
                        <!-- <?php
                        foreach ($data['data'] as $key => $va) {
                            echo '<option value="' . $va['num_subrancho'] . '">' . $va['nombre'] . '</option>';
                        }
                        ?> -->
                    </select>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group">
                    <label for="sub">Clasificación:</label>
                    <select class="select2 clasificacion_s" style="width: 100%;" id="clasificacion" required disabled>
                        <!-- <option value=""></option> -->
                        <option value="fertilizante">Fertilizante y Agroquimico</option>
                        <!-- <option value="agroquimico">Agroquimico</option> -->
                    </select>
                </div>
            </div>
        </div>
        <div class="row py-2 px-2" style="background-color: #e3e6ec">
            <div class="col-md-4 ">
                <div class="form-group">
                    <label for="sub">Encargado:</label>
                    <textarea name="encargado" id="" rows="2" class="form-control" style="resize: none;" required readonly><?php echo $data['receta'][0]['encargado'] ?></textarea>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group">
                    <label for="sub">Equipo de aplicación:</label>
                    <textarea name="equipo" id="" rows="2" class="form-control" style="resize: none;" required readonly><?php echo $data['receta'][0]['equipo'] ?></textarea>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group">
                    <label for="sub">Justificación:</label>
                    <textarea name="justificacion" id="" rows="2" class="form-control" style="resize: none;" required readonly><?php echo $data['receta'][0]['justificacion'] ?></textarea>
                </div>
            </div>
        </div>
        <!-- <div class="row px-2" style="background-color: #e3e6ec">
            <div class="col-sm-12">
                <button type="button" id="all_p" style="margin-bottom: 0.5rem; padding: 0 0.5rem !important;" class="btn btn-outline-success">Seleccionar todo</button>
            </div>
        </div> -->
        <div class="row py-2 px-2" id="sectores" style="background-color: #e3e6ec" hidden>
        </div>
        <div class="row py-2 px-2" id="productos" style="background-color: #e3e6ec" hidden>
        </div>
        <div class="row px-2" style="background-color: #e3e6ec">
            <div class="col-sm-12 col-md-2" style="display: none;">
                <label for="sub">Productos</label>
            </div>
            <div class="col-sm-12 col-md-10">
            <?php
            echo '<ul style="list-style-type: none; margin-bottom: 0; padding: 0;">';
            foreach ($data['productos'] as $key => $va) {
                echo '<li id="' . $va['id_prod'] . '_cc" style="display: none;">Existencia: ';
                echo '<input type="number" readonly style="width: 20%; height:1.2rem; border:0; background-color:transparent;" id="' . $va['id_prod'] . '_pp" value="' . $va['existencia'] .'" hidden>';
                echo '<span> '.number_format($va['existencia'], 2, '.', ',').' </span>';
                echo '<span style="padding-right: 2rem">'.$va['unidad_medida'].'</span>';
                echo ' Ingrediente activo: ';
                echo '<input type="text" readonly style="width: 12%; height:1.2rem; border:0; background-color:transparent;" id="' . $va['id_prod'] . '_iia" value="' . $va['ingrediente_activo'] .'">';
                echo ' Intervalo: ';
                echo '<input type="number" readonly style="height:1.2rem; border:0; background-color:transparent;" id="' . $va['id_prod'] . '_iii" value="' . $va['intervalo'] .'">';
                echo ' Plazo intervalo: ';
                echo '<input type="text" readonly style="height:1.2rem; border:0; background-color:transparent;" id="' . $va['id_prod'] . '_pii" value="' . $va['plazo_intervalo'] .'">';
                echo ' Reentrada: ';
                echo '<input type="number" readonly style="height:1.2rem; border:0; background-color:transparent;" id="' . $va['id_prod'] . '_rrr" value="' . $va['reentrada'] .'">';
                echo ' Plazo reentrada: ';
                echo '<input type="text" readonly style="height:1.2rem; border:0; background-color:transparent;" id="' . $va['id_prod'] . '_prr" value="' . $va['plazo_reentrada'] .'">';
                //echo '<span> '.number_format($va['existencia'], 2, '.', ',').' </span>';
                /* echo $va['unidad_medida']. */'</li>';
            }
            echo '</ul>';
            ?>
            </div>
        </div>
        <!-- <div id="pp">
            
        </div> -->
        <div class="fix-width scroll-inner" style="display: flex;">
            <table id="receta_table" border="1">
                <tbody>
                    <tr class="table-header">
                        <td style="min-width: 4cm;">Nombre del producto</td>
                    </tr>
                </tbody>
            </table>
            <table id="receta_table2" border="1">
                <tr class="table-header">
                    <td style="height: 1.2rem;">Ingr.activo</td>
                    <td>Intervalo</td>
                    <td>Reentrada</td>
                </tr>
            </table>
        </div>

        <div class="fix-width scroll-inner py-2">
            <table class="table" id="receta_table1" border="1">
                <tbody>
                    <tr class="table-header">
                        <td style="text-align: center;">Fecha</td>
                        <td style="text-align: center;">Sector</td>
                        <td style="text-align: center;">Hora de inicio</td>
                        <td style="text-align: center;">Hora de termino</td>
                        <td style="text-align: center;">Minutos de riego</td>
                        <td style="text-align: center;">Firma del responsable</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row py-4 px-2">
            <div class="col-sm-4">
                <button type="submit" class="btn btn-outline-success btn-block">Ejecutar Receta</button>
            </div>
            <div class="col-sm-4">
                <button id="cancel" class="btn btn-outline-danger btn-block">Cancelar</button>
            </div>
        </div>

        </form>
    </div>
</div> <!-- card-body -->

<?php include_once("../utils/piePagina.php"); ?>

<script src="<?= DIR_S ?>ejecutar_recetas/js/ejecutarReceta.js"></script>