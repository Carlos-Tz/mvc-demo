<?php
require 'phpspreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class IndexController {

    private $conectar;
    private $Connection;
    public $rubros = ['acido', 'agroquimico', 'ferreteria', 'fertilizante', 'infraestructura', 'inocuidad', 'mano de obra', 'maq. agricola', 'mat. fumigacion', 'mat. riego', 'otros', 'papeleria', 'servicios', 'vehiculos'];

    public function __construct() {
        require_once  __DIR__ . "/../core/Conectar.php";
        require_once  __DIR__ . "/../model/existence.php";
        require_once  __DIR__ . "/../model/movement.php";
        $this->conectar = new Conectar();
        $this->Connection = $this->conectar->Connection();
    }

    /**
     * Ejecuta la acción correspondiente.
     *
     */
    public function run($accion) {
        switch ($accion) {
            case "index":
                $this->index();
                break;
            case "table":
                $this->table();
                break;
            case "excel":
                $this->excel();
                break;
            default:
                $this->index();
                break;
        }
    }

    public function index() {
        $this->view("index", array(
            "title" => "INDEX"
        ));
    }

    public function table() {
        $fecha = new DateTime($_POST['fechaA'], new DateTimeZone('America/Mexico_City'));
        $semana = intval($fecha->format('W'));
        $anio = intval($fecha->format('Y'));
        $f_inicio = clone $fecha->setISODate($anio, $semana);
        $f_fin = $fecha->modify('+6 days');
        $week = $semana - 1;
        $f_i = $f_inicio->format('Y-m-d');
        $f_f = $f_fin->format('Y-m-d');
        
        $data = array();
        if ($fecha){
            $existence = new Existence($this->Connection);
            $existences = $existence->getAll($week);
            $movement = new Movement($this->Connection);
            $entries = $movement->getAllEntries($f_i, $f_f);
            $outputs = $movement->getAllOutputs($f_i, $f_f);
            foreach ($this->rubros as $key_rubro => $value_rubro) :
                $rub[$key_rubro] = array_filter($existences, function ($row) use ($value_rubro) {
                return strtolower($row['clasificacion']) == $value_rubro;
            });
            $id = '';
            $corte_inicial = 0;
            $sub_entradas = 0;
            $sub_salidas = 0;
            $products = array();            
            foreach ($rub[$key_rubro] as $j => $product):
                $id = $product['id_prod'];
                $corte_inicial += $product['importe'];
                $entr[$j] = array_filter($entries, function ($row) use ($id){
                    return $row['id_prod'] == $id;
                });
                foreach ($entr[$j] as $k => $pro_i):
                    $sub_entradas += $pro_i['importe'];
                    endforeach;
                    $outp[$j] = array_filter($outputs, function ($row) use ($id){
                        return $row['id_prod'] == $id;
                    });
                    foreach ($outp[$j] as $o => $pro_o):
                        $sub_salidas += $pro_o['importe'];
                    endforeach;
                    array_push($products, array('p' => $product, 'entradas' =>  $entr[$j], 'salidas' =>  $outp[$j]));
                endforeach;
                if ($rub[$key_rubro]):
                    $corte_final = $corte_inicial + $sub_entradas - $sub_salidas;
                    array_push($data, array('rubro' => $this->rubros[$key_rubro], 'corte_inicial' => $corte_inicial, 'productos' => $products, 'sub_entradas' => $sub_entradas, 'sub_salidas' => $sub_salidas, 'corte_final' => $corte_final));
                endif;
            endforeach;
        }
        $results = array(
            "draw" => 1,
            'aaData' => $data
        );

        echo json_encode($results);
    }

    public function excel() {
        $fecha = new DateTime($_POST['fechaA'], new DateTimeZone('America/Mexico_City'));
        $semana = intval($fecha->format('W'));
        $anio = intval($fecha->format('Y'));
        $f_inicio = clone $fecha->setISODate($anio, $semana);
        $f_fin = $fecha->modify('+6 days');
        $week = $semana - 1;
        $f_i = $f_inicio->format('Y-m-d');
        $f_f = $f_fin->format('Y-m-d');
        
        $data = array();
        if ($fecha){
            $existence = new Existence($this->Connection);
            $existences = $existence->getAll($week);
            if (!$existences) return false;
            $movement = new Movement($this->Connection);
            $entries = $movement->getAllEntries($f_i, $f_f);
            $outputs = $movement->getAllOutputs($f_i, $f_f);
            foreach ($this->rubros as $key_rubro => $value_rubro) :
                $rub[$key_rubro] = array_filter($existences, function ($row) use ($value_rubro) {
                return strtolower($row['clasificacion']) == $value_rubro;
            });
            $id = '';
            $corte_inicial = 0;
            $sub_entradas = 0;
            $sub_salidas = 0;
            $products = array();            
            foreach ($rub[$key_rubro] as $j => $product):
                $id = $product['id_prod'];
                $corte_inicial += $product['importe'];
                $entr[$j] = array_filter($entries, function ($row) use ($id){
                    return $row['id_prod'] == $id;
                });
                foreach ($entr[$j] as $k => $pro_i):
                    $sub_entradas += $pro_i['importe'];
                    endforeach;
                    $outp[$j] = array_filter($outputs, function ($row) use ($id){
                        return $row['id_prod'] == $id;
                    });
                    foreach ($outp[$j] as $o => $pro_o):
                        $sub_salidas += $pro_o['importe'];
                    endforeach;
                    array_push($products, array('p' => $product, 'entradas' =>  $entr[$j], 'salidas' =>  $outp[$j]));
                endforeach;
                if ($rub[$key_rubro]):
                    $corte_final = $corte_inicial + $sub_entradas - $sub_salidas;
                    array_push($data, array('rubro' => $this->rubros[$key_rubro], 'corte_inicial' => $corte_inicial, 'productos' => $products, 'sub_entradas' => $sub_entradas, 'sub_salidas' => $sub_salidas, 'corte_final' => $corte_final));
                endif;
            endforeach;
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $titulo = "Almacen" ;
        $sheet->setTitle($titulo);
        $fila = 1;

        $sheet->setCellValue('A'.$fila, "ALMACEN") ;
        $sheet->setCellValue('B'.$fila, "SEMANA") ;
        $sheet->setCellValue('C'.$fila, $f_i) ;
        $sheet->setCellValue('D'.$fila, "---") ;
        $sheet->setCellValue('E'.$fila, $f_f) ;
        $fila++;
        $sheet->setCellValue('A'.$fila, "CONCEPTO") ;
        $sheet->setCellValue('B'.$fila, "CORTE INICIAL") ;
        $sheet->setCellValue('C'.$fila, "CORTE FINAL") ;
        $sheet->setCellValue('D'.$fila, "GASTO") ;
        $sheet->setCellValue('E'.$fila, "COMPRAS") ;
        /* $sheet->setCellValue('F'.$fila, "COSTO") ; */
        $sheet->getStyle('A1:K1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2:K2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2:K2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00ac69');
        $sheet->getStyle('A2:K2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00ac69');
        $sheet->getStyle('A1:K1')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A2:K2')->getFont()->getColor()->setRGB('FFFFFF');
        /* $sheet->getStyle('B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE); */
        $sheet->freezePane('A3') ;
        $fila++;
        $total_inicial = 0;
        $total_entradas = 0;
        $total_salidas = 0;
        $total_final = 0;
        foreach ($data as $rubro):
            $sheet->getStyle('A'.$fila.':E'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33CC66');
            $sheet->getStyle('A'.$fila.':E'.$fila)->getFont()->setSize(12);
            $sheet->getStyle('B'.$fila.':E'.$fila)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $sheet->setCellValue('A'.$fila, strtoupper($rubro['rubro']));
            $sheet->setCellValue('B'.$fila, $rubro['corte_inicial']);
            $sheet->setCellValue('C'.$fila, $rubro['corte_final']);
            $sheet->setCellValue('D'.$fila, $rubro['sub_salidas']);
            $sheet->setCellValue('E'.$fila, $rubro['sub_entradas']);
            $fila++ ;
            $sheet->getStyle('B'.$fila.':K'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DAF7A6');
            $sheet->getStyle('B'.$fila.':K'.$fila)->getAlignment()->setHorizontal('center');

            $sheet->setCellValue('B'.$fila, "PRODUCTO") ;
            $sheet->setCellValue('C'.$fila, "UNIDAD") ;
            $sheet->setCellValue('D'.$fila, "EXISTENCIA INICIAL") ;
            $sheet->setCellValue('E'.$fila, "VALOR MONETARIO INICIAL") ;
            $sheet->setCellValue('F'.$fila, "COMPRAS CANTIDAD") ;
            $sheet->setCellValue('G'.$fila, "COMPRAS VALOR MONETARIO") ;
            $sheet->setCellValue('H'.$fila, "SALIDAS CANTIDAD") ;
            $sheet->setCellValue('I'.$fila, "SALIDAS VALOR MONETARIO") ;
            $sheet->setCellValue('J'.$fila, "EXISTENCIA FINAL") ;
            $sheet->setCellValue('K'.$fila, "VALOR MONETARIO FINAL") ;
            $fila++ ;
            
            foreach ($rubro['productos'] as $producto):
                $entradas = 0;
                $entradas_valor = 0;
                $salidas = 0;
                $salidas_valor = 0;
                $existencia_final = 0;
                $valor_monetario_final = 0;
                $valor_monetario_inicial = $producto['p']['importe'];
                foreach ($producto['entradas'] as $in):
                    $entradas += $in['cantidad'];
                    $entradas_valor += $in['importe'];
                    endforeach;
                foreach ($producto['salidas'] as $ou):
                    $salidas += $ou['cantidad'];
                    $salidas_valor += $ou['importe'];
                    endforeach;
                if ($entradas > 0 || $salidas > 0){
                    $existencia_final = $producto['p']['existencia'] + $entradas - $salidas;
                    $valor_monetario_final = $valor_monetario_inicial + $entradas_valor - $salidas_valor;
                    $sheet->getStyle('D'.$fila)->getNumberFormat()->setFormatCode('#,##0.000');
                    $sheet->getStyle('E'.$fila)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                    $sheet->getStyle('F'.$fila)->getNumberFormat()->setFormatCode('#,##0.000');
                    $sheet->getStyle('G'.$fila)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                    $sheet->getStyle('H'.$fila)->getNumberFormat()->setFormatCode('#,##0.000');
                    $sheet->getStyle('I'.$fila)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                    $sheet->getStyle('J'.$fila)->getNumberFormat()->setFormatCode('#,##0.000');
                    $sheet->getStyle('K'.$fila)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                    $sheet->setCellValue('B'.$fila, strtoupper($producto['p']['nom_prod']));
                    $sheet->setCellValue('C'.$fila, strtoupper($producto['p']['unidad_medida']));
                    $sheet->getStyle('D'.$fila)->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('D'.$fila, strtoupper($producto['p']['existencia']));
                    $sheet->setCellValue('E'.$fila, strtoupper($producto['p']['importe']));
                    $sheet->getStyle('F'.$fila)->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('F'.$fila, strtoupper($entradas));
                    $sheet->setCellValue('G'.$fila, strtoupper($entradas_valor));
                    $sheet->getStyle('H'.$fila)->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('H'.$fila, strtoupper($salidas));
                    $sheet->setCellValue('I'.$fila, strtoupper($salidas_valor));
                    $sheet->getStyle('J'.$fila)->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('J'.$fila, strtoupper($existencia_final));
                    $sheet->setCellValue('K'.$fila, strtoupper($valor_monetario_final));
                    $fila++;
                }
            endforeach;
            $sheet->getStyle('D'.$fila.':K'.$fila)->getFont()->setSize(12);
            $sheet->getStyle('D'.$fila.':K'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8CE08A');
            $sheet->getStyle('E'.$fila.':K'.$fila)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $sheet->setCellValue('D'.$fila, 'SUBTOTAL: ');
            $sheet->setCellValue('E'.$fila, $rubro['corte_inicial']);
            $sheet->setCellValue('G'.$fila, $rubro['sub_entradas']);
            $sheet->setCellValue('I'.$fila, $rubro['sub_salidas']);
            $sheet->setCellValue('K'.$fila, $rubro['corte_final']);
            $fila++;
            $total_inicial += $rubro['corte_inicial'];
            $total_entradas += $rubro['sub_entradas'];
            $total_salidas += $rubro['sub_salidas'];
            $total_final += $rubro['corte_final'];
            endforeach;
            $fila++;
        $sheet->getStyle('A'.$fila.':E'.$fila)->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('B'.$fila.':E'.$fila)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        $sheet->getStyle('A'.$fila.':E'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('52BE4F');

        $sheet->setCellValue('A'.$fila, 'TOTAL: ');
        $sheet->setCellValue('B'.$fila, $total_inicial);
        $sheet->setCellValue('C'.$fila, $total_final);
        $sheet->setCellValue('D'.$fila, $total_entradas);
        $sheet->setCellValue('E'.$fila, $total_salidas);
        $sheet->getColumnDimension("A")->setAutoSize(true);
        $sheet->getColumnDimension("B")->setAutoSize(true);
        $sheet->getColumnDimension("C")->setAutoSize(true);
        $sheet->getColumnDimension("D")->setAutoSize(true);
        $sheet->getColumnDimension("E")->setAutoSize(true);
        $sheet->getColumnDimension("F")->setAutoSize(true);
        $sheet->getColumnDimension("G")->setAutoSize(true);
        $sheet->getColumnDimension("H")->setAutoSize(true);
        $sheet->getColumnDimension("I")->setAutoSize(true);
        $sheet->getColumnDimension("J")->setAutoSize(true);
        $sheet->getColumnDimension("K")->setAutoSize(true);

        $filename = 'almacen.xlsx' ;

        ob_clean();
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        echo $filename;

    }

    public function view($vista, $datos)
    {
        $data = $datos;
        require_once  __DIR__ . "/../view/" . $vista . "View.php";
    }
}
