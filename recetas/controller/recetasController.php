<?php
require '../phpspreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RecetasController {
    private $conectar;
    private $Connection;
    private $rubros = ['acido', 'agroquimico', 'ferreteria', 'fertilizante', 'infraestructura', 'inocuidad', 'mano de obra', 'maq. agricola', 'mat. fumigacion', 'mat. riego', 'otros', 'papeleria', 'servicios', 'vehiculos'];


    public function __construct() {
        require_once  __DIR__ . "/../core/Conectar.php";
        require_once  __DIR__ . "/../model/recipe.php";
        require_once  __DIR__ . "/../model/subrancho.php";
        require_once  __DIR__ . "/../model/sector.php";
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
            case "nueva":
                $this->nueva();
                break;
            case "table":
                $this->table();
                break;
            case "sectores":
                $this->sectores();
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

    public function nueva() {
        /* $sectores = array();

        if (isset($_POST['id'])){ //echo $_POST['id'];
            $id = $_POST['id'];
            $sector = new Sector($this->Connection);
            $s_data = $sector->getSector($id); //print_r($s_data);
    
            foreach ($s_data as $row) {
                $sectores[] = array(
                    "id_sector"=>$row['id_sector'],
                    "num_subrancho"=>$row['num_subrancho'],
                    "nombre"=>$row['nombre'],
                    "hectareas"=>$row['hectareas'],
                );
            }
        } */

            $subrancho = new Subrancho($this->Connection);
            $s_data = $subrancho->getAll();
            $data1 = array();

            foreach ($s_data as $row) {
                $data1[] = array(
                    "id_subrancho"=>$row['id_subrancho'],
                    "num_rancho"=>$row['num_rancho'],
                    "nombre"=>$row['nombre'],
                );
            }
        $this->view("newReceta", array(
            "title" => "Nueva Receta",
            "data" => $data1,
            //"sectores" => $sectores
        ));
    }

    public function sectores (){
        $id = $_POST['id'];
        $sector = new Sector($this->Connection);
        $s_data = $sector->getSector($id); //print_r($s_data);
        $sectores = array();

		foreach ($s_data as $row) {
			$sectores[] = array(
				"id_sector"=>$row['id_sector'],
				"num_subrancho"=>$row['num_subrancho'],
				"nombre"=>$row['nombre'],
				"hectareas"=>$row['hectareas'],
			);
		}
        $this->view("sectores", array(
            "title" => "Sectores",
            "sectores" => $sectores
        ));
    }
    
    /* public function subrancho (){
        $subrancho = new Subrancho($this->Connection);
        $s_data = $subrancho->getAll();
        $data1 = array();

		foreach ($s_data as $row) {
			$data1[] = array(
				"id_subrancho"=>$row['id_subrancho'],
				"num_subrancho"=>$row['num_subrancho'],
				"nombre"=>$row['nombre'],
			);
		}
        $response = array(
            "data1" => $data1
        );

        echo json_encode($response);
    } */

    public function table() {
        /* $subrancho = new Subrancho($this->Connection);
        $s_data = $subrancho->getAll();
        print_r($s_data);
 */
        $recipe = new Recipe($this->Connection);
        $data = $recipe->getAll();
        $data1 = array();

		foreach ($data as $row) {
			$data1[] = array(
				"id_receta"=>$row['id_receta'],
				"num_subrancho"=>$row['num_subrancho'],
				"fecha"=>$row['fecha'],
				"status"=>$row['status'],
				"justificacion"=>$row['justificacion'],
			);
		}
        $response = array(
            "draw" => 1,
            //  "iTotalRecords" => $totalRecords,
            // "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data1
        );

        echo json_encode($response);
    
    }

    /* public function excel() {
        $fechaI = $_POST['fechaI'];
        $fechaF = $_POST['fechaF'];

        $entry = new Entry($this->Connection);
        $data = $entry->getAllEntries($fechaI, $fechaF);
        $data1 = array();
        $total_entradas = 0;

        foreach ($this->rubros as $key_rubro => $value_rubro) :
            $rub[$key_rubro] = array_filter($data, function ($row) use ($value_rubro) {
                return strtolower($row['clasificacion']) == $value_rubro;
            });
            $tot[$key_rubro] = 0;
            $ids_prod_all = array();
            foreach ($rub[$key_rubro] as $j => $v) :
                $tot[$key_rubro] += $v['precio_compra']*$v['cantidad'];            
                array_push($ids_prod_all, $v['id_prod']);
                endforeach;
                $ids_prod_unique = array_unique($ids_prod_all, SORT_STRING);
                $prod_rubro = array();
                $total_entradas += $tot[$key_rubro];
            foreach ($ids_prod_unique as $j => $v) :
                $pro[$j] = array_filter($rub[$key_rubro], function ($row) use ($v){
                return $row['id_prod'] == $v;
                });
                $subtotal = 0;
                $index = 0;
                $cantidad = 0;
                $p = '';
                $u = '';
                foreach ($pro[$j] as $l => $val) :
                    if ($index == 0): 
                        $p = $val['nom_prod'];
                        $u = $val['unidad_medida'];
                    endif;
                    $subtotal += $val['cantidad']*$val['precio_compra'];
                    $cantidad += $val['cantidad'];
                    $index++;
                endforeach;
                array_push($prod_rubro, array('p'=>$p, 'subtotal'=>$subtotal, 'cantidad'=>$cantidad, 'u'=>$u));               

                endforeach;
                array_push($data1, array('rubro'=> $this->rubros[$key_rubro], 'total'=> $tot[$key_rubro], 'productos' => $prod_rubro));
            endforeach;


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $titulo = "Entradas" ;
        $sheet->setTitle($titulo);
        $fila = 1;

        $sheet->setCellValue('A'.$fila, "ENTRADAS") ;
        $sheet->setCellValue('B'.$fila, $fechaI) ;
        $sheet->setCellValue('C'.$fila, "---") ;
        $sheet->setCellValue('D'.$fila, $fechaF) ;
        $fila++;
        $sheet->setCellValue('A'.$fila, "RUBRO") ;
        $sheet->setCellValue('B'.$fila, "SUBTOTAL") ;
        $sheet->setCellValue('C'.$fila, "PRODUCTO") ;
        $sheet->setCellValue('D'.$fila, "CANTIDAD") ;
        $sheet->setCellValue('E'.$fila, "UNIDAD") ;
        $sheet->setCellValue('F'.$fila, "COSTO") ;
        $sheet->getStyle('A1:F1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2:F2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2:F2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00ac69');
        $sheet->getStyle('A2:F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00ac69');
        $sheet->getStyle('A1:F1')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A2:F2')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('F')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        $sheet->getStyle('B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        //$sheet->freezePane("A2") ;
        $fila++;
        foreach ($data1 as $rubro):
        if ($rubro['total'] > 0):
                $sheet->getStyle('A'.$fila.':F'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DAF7A6');
                $sheet->setCellValue('A'.$fila, strtoupper($rubro['rubro']));
                $sheet->setCellValue('B'.$fila, $rubro['total']);
                $fila++ ;
                foreach ($rubro['productos'] as $producto):
                    $sheet->setCellValue('C'.$fila, strtoupper($producto['p']));
                    $sheet->getStyle('D'.$fila)->getAlignment()->setHorizontal('center');
                    $sheet->setCellValue('D'.$fila, $producto['cantidad']);
                    $sheet->setCellValue('E'.$fila, strtoupper($producto['u']));
                    $sheet->setCellValue('F'.$fila, $producto['subtotal']);
                    $fila++;
                endforeach;
            endif;
            endforeach;
        $sheet->getStyle('E'.$fila.':F'.$fila)->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('E'.$fila.':F'.$fila)->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('E'.$fila.':F'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00ac69');

        $sheet->setCellValue('E'.$fila, 'TOTAL: ');
        $sheet->setCellValue('F'.$fila, $total_entradas);
        $sheet->getColumnDimension("A")->setAutoSize(true);
        $sheet->getColumnDimension("B")->setAutoSize(true);
        $sheet->getColumnDimension("C")->setAutoSize(true);
        $sheet->getColumnDimension("D")->setAutoSize(true);
        $sheet->getColumnDimension("E")->setAutoSize(true);
        $sheet->getColumnDimension("F")->setAutoSize(true);

        $filename = 'entradas.xlsx' ;

        ob_clean();
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        echo $filename;

    } */

    public function view($vista, $datos)
    {
        $data = $datos;
        require_once  __DIR__ . "/../view/" . $vista . "View.php";
    }
}