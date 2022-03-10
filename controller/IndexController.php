<?php
require 'phpspreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class IndexController
{

    private $conectar;
    private $Connection;
    public $rubros = ['acido', 'agroquimico', 'ferreteria', 'fertilizante', 'infraestructura', 'inocuidad', 'mano de obra', 'maq. agricola', 'mat. fumigacion', 'mat. riego', 'otros', 'papeleria', 'servicios', 'vehiculos'];

    public function __construct()
    {
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
    public function run($accion)
    {
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
            /*case "detalle":
                $this->detalle();
                break;
            case "actualizar":
                $this->actualizar();
                break; */
            default:
                $this->index();
                break;
        }
    }

    public function index()
    {
        /* $entry = new Existence($this->Connection);
        $entries = $entry->getAll(); */
        /* print_r($entries); */
        /* $data = array(); */
        $this->view("index", array(
            /* "entries" => $entries, */
            "title" => "INDEX"
        ));
    }

    public function table()
    {
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
            $entries = $movement->getAllEntries($f_i, $f_f); /* print_r($entries); */
            $outputs = $movement->getAllOutputs($f_i, $f_f); /* print_r($outputs); */
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
                    /* array_push($data, array('rubro' => $this->rubros[$key_rubro], 'productos' => $rub[$key_rubro])); */
                endif;
            endforeach;
        }
        $results = array(
            "draw" => 1,
            'aaData' => $data
        );

        echo json_encode($results);
    }

    public function excel()
    {
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
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $titulo = "Almacen" ;
        $sheet->setTitle($titulo);
        $fila = 1;

        $sheet->setCellValue('A'.$fila, "ALMACEN") ;
        $sheet->setCellValue('B'.$fila, $f_i) ;
        $sheet->setCellValue('C'.$fila, "---") ;
        $sheet->setCellValue('D'.$fila, $f_f) ;
        $fila++;
        $sheet->setCellValue('A'.$fila, "CONCEPTO") ;
        $sheet->setCellValue('B'.$fila, "CORTE INICIAL") ;
        $sheet->setCellValue('C'.$fila, "CORTE FINAL") ;
        $sheet->setCellValue('D'.$fila, "GASTO") ;
        $sheet->setCellValue('E'.$fila, "COMPRAS") ;
        $sheet->setCellValue('F'.$fila, "COSTO") ;
        $sheet->getStyle('A1:F1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2:F2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2:F2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00ac69');
        $sheet->getStyle('A2:F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00ac69');
        $sheet->getStyle('A1:F1')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A2:F2')->getFont()->getColor()->setRGB('FFFFFF');
        /* $sheet->getStyle('F')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        $sheet->getStyle('B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE); */
        $fila++;
        foreach ($data as $rubro):
        /* if ($rubro['total'] > 0): */
                $sheet->getStyle('A'.$fila.':F'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DAF7A6');
                $sheet->setCellValue('A'.$fila, strtoupper($rubro['rubro']));
                $sheet->setCellValue('B'.$fila, $rubro['corte_inicial']);
                $sheet->setCellValue('C'.$fila, $rubro['corte_final']);
                $sheet->setCellValue('D'.$fila, $rubro['sub_salidas']);
                $sheet->setCellValue('E'.$fila, $rubro['sub_entradas']);
                $fila++ ;
                foreach ($rubro['productos'] as $producto):
                    $sheet->setCellValue('C'.$fila, strtoupper($producto['p']));
                    /* $sheet->getStyle('D'.$fila)->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('D'.$fila, $producto['cantidad']);
                    $sheet->setCellValue('E'.$fila, strtoupper($producto['u']));
                    $sheet->setCellValue('F'.$fila, $producto['subtotal']); */
                    $fila++;
                endforeach;
            /* endif; */
            endforeach;
        $sheet->getStyle('E'.$fila.':F'.$fila)->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('E'.$fila.':F'.$fila)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('E'.$fila.':F'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00ac69');

       /*  $sheet->setCellValue('E'.$fila, 'TOTAL: ');
        $sheet->setCellValue('F'.$fila, $total_entradas); */
        $sheet->getColumnDimension("A")->setAutoSize(true);
        $sheet->getColumnDimension("B")->setAutoSize(true);
        $sheet->getColumnDimension("C")->setAutoSize(true);
        $sheet->getColumnDimension("D")->setAutoSize(true);
        $sheet->getColumnDimension("E")->setAutoSize(true);
        $sheet->getColumnDimension("F")->setAutoSize(true);

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
        /* $results = array(
            'aaData' => $datos['entries']
        ); */
        //echo json_encode($results); 
    }
}
