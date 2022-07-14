<?php
/* include("../utils/cabecera.php");
date_default_timezone_set('America/Mexico_City'); */

/* define('DIR_A', 'http://localhost:8080/local/dev/adm/mvc/cap_humano/'); */
define('DIR_A', 'http://localhost/inomac/cap_humano/');

/* define('DIR_S', 'http://localhost:8080/local/dev/adm/mvc/'); */
define('DIR_S', 'http://localhost/inomac/');

?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta NAME="robots" CONTENT="noindex, nofollow">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>INOMAC</title>
    <style>
        .td_green {
            /* background-color: #76be73; */
            /* color: white; */
            font-weight: 500;
            text-align: center;
            /* min-width: 2cm; */
        }

        .td_white {
            text-align: center;
            font-weight: 500;
            /* min-width: 2cm; */
        }
        /* .table  {
            width: 100%;
            overflow-x: auto;
        } */
        .text-center {
            text-align: center;
        }
        .text-center-p{
            text-align: center;
            padding: 0 0.3rem;
        }
        .text-center2{
            text-align: center;
            font-size: 12px;
        }
        .h11{
            height: 1.2rem;
        }

        @media print {
            body {
                padding: 1rem;
                color: #222;
                /* transform: translate(8.5in, -100%) rotate(90deg);
                transform-origin: bottom left;
                display: block;*/
                /* transform: scale(0.8, 0.8);
                transform-origin: top left;  */               
            }

            #receta_table tr, #receta_table2 tr {
                height: 1.6cm;
                max-height: 1.6cm;
                min-height: 1.6cm;
                font-size: 9px;
            }
            #receta_table td input, #receta_table td button, #receta_table2 td input, #receta_table2 td button, #receta_table1 td input {
                font-size: 9px;
                font-weight: 400;
            }
        }
    </style>
</head>


<body>
    <div>
        <table border="1" style="width:100%; border: solid 1px #ccc; border-collapse: collapse;">
            <tr style="padding-bottom: 1.5rem;">
                <td style="padding: 1rem 0.5rem;">REPORTE DE APLICACIÓN DE FERTILIZANTES</td>
                <td style="text-align:right; padding: 1rem 0.5rem;">FOLIO: <?php echo str_pad($data['receta'][0]['id_receta'], 6, "0", STR_PAD_LEFT);  ?></td>
            </tr>
            <tr>
                <td style="width: 50%; padding: 0.5rem;">Fecha: <?php echo $data['receta'][0]['fecha'] ?></td>
                <td style="width: 50%; padding: 0.5rem;">Rancho: <?php echo $data['receta'][0]['nombre'] ?></td>
            </tr>
            <tr>
                <td style="width: 50%; padding: 0.5rem;">Encargado: <?php echo $data['receta'][0]['encargado'] ?></td>
                <td style="width: 50%; padding: 0.5rem;">Equipo de aplicación: <?php echo $data['receta'][0]['equipo'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 0.5rem;">Justificación: <?php echo $data['receta'][0]['justificacion'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 0.5rem;">Receta: <?php echo $data['receta'][0]['status'] ?></td>
            </tr>
        </table>
    </div>
    <input type="number" value="<?php echo $data['receta'][0]['num_subrancho'] ?>" id="sssub" hidden>
    <input type="text" value="<?php echo $data['receta'][0]['nombre'] ?>" id="nombress" hidden>
    <input type="number" value="<?php echo $data['receta'][0]['id_receta'] ?>" id="id_receta" hidden>
    <input type="text" name="estatus" value="<?php echo $data['receta'][0]['status'] ?>" id="estatus" hidden>
    <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $data['receta'][0]['fecha'] ?>" required readonly hidden>

    <div style="display: none;">
        <div>
            <label for="sub">Subrancho:</label>
            <select class="select2 subrancho_s" style="width: 100%;" id="subrancho" name="subrancho" required disabled>
                <option value="<?php echo $data['receta'][0]['num_subrancho'] ?>"><?php echo $data['receta'][0]['nombre'] ?></option>
            </select>
        </div>
    </div>
    <div style="display: none;">
        <div>
            <label for="sub">Clasificación:</label>
            <select class="select2 clasificacion_s" style="width: 100%;" id="clasificacion" required disabled>
                <option value="fertilizante">Fertilizante y Agroquimico</option>
            </select>
        </div>
    </div>

    <div id="sectores" style="background-color: #e3e6ec" hidden></div>
    <div id="productos" style="background-color: #e3e6ec" hidden></div>

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

    <div class="table" style="display: flex;">
        <table id="receta_table" border="1" style="border: solid 1px #ccc; border-collapse: collapse; margin-top: 1rem;">
            <tbody>
                <tr class="table-header">
                    <td style="min-width: 4cm; text-align: center;">Nombre del producto</td>
                </tr>
            </tbody>
        </table>
        <table id="receta_table2" border="1" style="border: solid 1px #ccc; border-collapse: collapse; margin-top: 1rem;">
            <tr class="table-header">
                <td class="h11" style="text-align: center;">IngredienteActivo</td>
                <td class="h11" style="text-align: center;">Intervalo</td>
                <td class="h11" style="text-align: center;">Reentrada</td>
            </tr>
        </table>
    </div>

    <div class="fix-width scroll-inner py-2" style="display: <?php ($data['receta'][0]['status'] == 'Ejecutada') ? print_r('block'): print_r('none') ?>">
        <table id="receta_table1" border="1" style="border: solid 1px #ccc; border-collapse: collapse; width:100%; margin-top: 1rem; ">
            <tbody>
                <tr>
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
    <?php include_once("../utils/piePagina.php"); ?>

    <script src="<?= DIR_S ?>ejecutar_recetas/js/imprimirReceta.js"></script>