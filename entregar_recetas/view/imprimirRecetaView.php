<?php
/* include("../utils/cabecera.php");
date_default_timezone_set('America/Mexico_City'); */

define('DIR_A', 'http://localhost:8080/local/dev/adm/mvc/cap_humano/');
/* define('DIR_A', 'http://localhost/inomac/cap_humano/'); */

define('DIR_S', 'http://localhost:8080/local/dev/adm/mvc/');
/* define('DIR_S', 'http://localhost/inomac/'); */

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
            min-width: 2cm;
        }

        .td_white {
            text-align: center;
            font-weight: 500;
            min-width: 2cm;
        }

        @media print {
            body {
                padding: 1rem;
                color: #222;
            }

            /* .td_green {
                background-color: #222 !important;
                color: #222;
                font-weight: 500;
                text-align: center;
                min-width: 2cm;
            } */

            /*
            .td_white {
                text-align: center;
                font-weight: 500;
                min-width: 2cm;
            } */
        }
    </style>
</head>


<body>
    <div>
        <table style="width:100%;">
            <tr style="padding-bottom: 1.5rem;">
                <td style="padding-bottom: 2rem;">REPORTE DE APLICACIÓN DE PlAGUICIDAS</td>
                <td style="text-align:right; padding-bottom: 2rem;">FOLIO: <?php echo str_pad($data['receta'][0]['id_receta'], 6, "0", STR_PAD_LEFT);  ?></td>
            </tr>
            <tr>
                <td style="width: 50%">Fecha: <?php echo $data['receta'][0]['fecha'] ?></td>
                <td style="width: 50%">Subrancho: <?php echo $data['receta'][0]['nombre'] ?></td>
            </tr>
            <tr>
                <td colspan="2">Encargado: <?php echo $data['receta'][0]['encargado'] ?></td>
            </tr>
            <tr>
                <td colspan="2">Equipo de aplicación: <?php echo $data['receta'][0]['equipo'] ?></td>
            </tr>
            <tr>
                <td colspan="2">Justificación: <?php echo $data['receta'][0]['justificacion'] ?></td>
            </tr>
        </table>
    </div>
    <input type="number" value="<?php echo $data['receta'][0]['num_subrancho'] ?>" id="sssub" hidden>
    <input type="text" value="<?php echo $data['receta'][0]['nombre'] ?>" id="nombress" hidden>
    <input type="number" value="<?php echo $data['receta'][0]['id_receta'] ?>" id="id_receta" hidden>
    <input type="text" name="estatus" value="Programada" hidden>
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

    <table class="table" id="receta_table" border="1" style="border: solid 1px #ccc; border-collapse: collapse; margin-top: 1rem;">
        <tbody>
            <tr class="table-header">
                <td style="min-width: 4cm;">Nombre del producto</td>
            </tr>
        </tbody>
    </table>
    <?php include_once("../utils/piePagina.php"); ?>

    <script src="<?= DIR_S ?>entregar_recetas/js/imprimirReceta.js"></script>