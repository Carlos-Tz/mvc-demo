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
        require_once  __DIR__ . "/../model/producto.php";
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
            case "guardar":
                $this->guardar();
                break;
            case "table":
                $this->table();
                break;
            case "sectores":
                $this->sectores();
                break;
            case "sectores_list":
                $this->sectores_list();
                break;
            case "productos":
                $this->productos();
                break;
            case "getProducts":
                $this->getProducts()();
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
        $subrancho = new Subrancho($this->Connection);
        $s_data = $subrancho->getAll();
        $data1 = array();

        foreach ($s_data as $row) {
            $data1[] = array(
                "id_subrancho" => $row['id_subrancho'],
                "num_subrancho" => $row['num_subrancho'],
                "nombre" => $row['nombre'],
            );
        }

        $producto = new Producto($this->Connection);
        $p_data = $producto->getProducto();
        $productos = array();

        foreach ($p_data as $row) {
            $productos[] = array(
                "id_prod" => $row['id_prod'],
                "existencia" => $row['existencia'],
                "nom_prod" => $row['nom_prod'],
                "costo_promedio" => $row['costo_promedio'],
                "unidad_medida" => $row['unidad_medida'],
                "clasificacion" => $row['clasificacion'],
            );
        }
        $this->view("newReceta", array(
            "title" => "Nueva Receta",
            "data" => $data1,
            "productos" => $productos
            //"sectores" => $sectores
        ));
    }

    public function sectores() {
        $id = $_POST['id'];
        $sector = new Sector($this->Connection);
        $s_data = $sector->getSector($id);
        $sectores = array();

        foreach ($s_data as $row) {
            $sectores[] = array(
                "id_sector" => $row['id_sector'],
                "num_subrancho" => $row['num_subrancho'],
                "nombre" => $row['nombre'],
                "hectareas" => $row['hectareas'],
            );
        }
        
        $this->view("sectores", array(
            "title" => "Sectores",
            "sectores" => $sectores
        ));
    }

    public function sectores_list() {
        $id = $_POST['id'];
        $sector = new Sector($this->Connection);
        $s_data = $sector->getSector($id);
        $sectores = array();

        foreach ($s_data as $row) {
            $sectores[] = array(
                "id_sector" => $row['id_sector'],
                "num_subrancho" => $row['num_subrancho'],
                "nombre" => $row['nombre'],
                "hectareas" => $row['hectareas'],
            );
        }
        
        $this->view("sectores_list", array(
            "title" => "Sectores",
            "sectores" => $sectores
        ));
    }

    public function productos() {
        //$clasificacion = $_POST['clasificacion'];
        $producto = new Producto($this->Connection);
        $s_data = $producto->getProducto();
        $productos = array();

        foreach ($s_data as $row) {
            $productos[] = array(
                "id_prod" => $row['id_prod'],
                "existencia" => $row['existencia'],
                "nom_prod" => $row['nom_prod'],
                "costo_promedio" => $row['costo_promedio'],
                "unidad_medida" => $row['unidad_medida'],
                "clasificacion" => $row['clasificacion'],
            );
        }
        $this->view("productos", array(
            "title" => "productos",
            "productos" => $productos
        ));
    }

    public function getProducts() {
        $producto = new Producto($this->Connection);
        $data = $producto->getProducto();
        $productos = array();

        foreach ($data as $row) {
            $productos[] = array(
                "id_prod" => $row['id_prod'],
                "existencia" => $row['existencia'],
                "nom_prod" => $row['nom_prod'],
                "costo_promedio" => $row['costo_promedio'],
                "unidad_medida" => $row['unidad_medida'],
                "clasificacion" => $row['clasificacion'],
            );
        }
        $response = array(
            "data" => $productos
        );
        echo json_encode($response);
        //header("location:".urlsite);
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

    public function guardar(){
        $subrancho 	=	$_REQUEST['subrancho'];
    	$fecha 	=	$_REQUEST['fecha'];
    	$estatus 	=	$_REQUEST['estatus'];
    	$justificacion 	=	$_REQUEST['justificacion'];
    	$encargado 	=	$_REQUEST['encargado'];
    	$equipo 	=	$_REQUEST['equipo'];
        //$data       =   $subrancho.",'".$fecha."','".$estatus."','".$justificacion."','".$encargado."','".$equipo."'";
        $recipe = new Recipe($this->Connection);
    	$res = $recipe->addRecipe($subrancho, $fecha, $estatus, $justificacion, $encargado, $equipo);
        //print_r($res);
        return $res;
    }

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
                "id_receta" => $row['id_receta'],
                "num_subrancho" => $row['num_subrancho'],
                "fecha" => $row['fecha'],
                "status" => $row['status'],
                "justificacion" => $row['justificacion'],
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

    public function view($vista, $datos){
        $data = $datos;
        require_once  __DIR__ . "/../view/" . $vista . "View.php";
    }
}
