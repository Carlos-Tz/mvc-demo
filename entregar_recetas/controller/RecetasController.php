<?php
require '../phpspreadsheet/vendor/autoload.php';


class RecetasController {
    private $conectar;
    private $Connection;

    public function __construct() {
        require_once  __DIR__ . "/../core/Conectar.php";
        require_once  __DIR__ . "/../model/recipe.php";
        require_once  __DIR__ . "/../model/detailrecipe.php";
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
            case "entregar":
                $this->entregar();
                break;
            case "imprimir":
                $this->imprimir();
                break;
            case "resurtir":
                $this->resurtir();
                break;
            case "guardar":
                $this->guardar();
                break;
            case "actualizar":
                $this->actualizar();
                break;
            case "eliminar":
                $this->eliminar();
                break;
            case "guardar_detalles":
                $this->guardar_detalles();
                break;
            case "get_detalles":
                $this->get_detalles();
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
                $this->getProducts();
                break;
            case "calcular":
                $this->calcular();
                break;
            case "cambiar_status":
                $this->cambiar_status();
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
                //"id_subrancho" => $row['id_subrancho'],
                "num_subrancho" => $row['num_subrancho'],
                "nombre" => $row['nombre'],
            );
        }

        $producto = new Producto($this->Connection);
        $p_data = $producto->getProductos();
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

    public function calcular(){
        $id = $_POST['id']; //echo $id;
        $id_r = $_POST['id_r']; //echo $id;
        $det_rec = new RecipeDetail($this->Connection);
        $res = $det_rec->calcular($id, $id_r);
        echo $res;
    }

    public function actualizar() {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $rec = new Recipe($this->Connection);
        $receta = $rec->updateRecipe($id, $status);
        print_r($receta);
    }

    public function cambiar_status() {
        $id = $_POST['id'];
        $d_rec = new RecipeDetail($this->Connection);
        $d_receta = $d_rec->updateStatus($id, 'Entregada');
        print_r($d_receta);
    }

    public function imprimir() {
        $recipe = new Recipe($this->Connection);
        $id = $_GET['id'];
        $receta_data = $recipe->getRecipe($id); 
        $receta = array();
        foreach ($receta_data as $row) {
            $receta[] = array(
                //"id_subrancho" => $row['id_subrancho'],
                "id_receta" => $row['id_receta'],
                "num_subrancho" => $row['num_subrancho'],
                "nombre" => $row['nombre'],
                "fecha" => $row['fecha'],
                "status" => $row['status'],
                "justificacion" => $row['justificacion'],
                "encargado" => $row['encargado'],
                "equipo" => $row['equipo'],
            );
        }
        //print_r($receta);

        $subrancho = new Subrancho($this->Connection);
        $s_data = $subrancho->getAll();
        $data1 = array();

        foreach ($s_data as $row) {
            $data1[] = array(
                //"id_subrancho" => $row['id_subrancho'],
                "num_subrancho" => $row['num_subrancho'],
                "nombre" => $row['nombre'],
            );
        }

        $producto = new Producto($this->Connection);
        $p_data = $producto->getProductos();
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
        $this->view("imprimirReceta", array(
            "title" => "Imprimir Receta",
            "data" => $data1,
            "productos" => $productos,
            "receta" => $receta
            //"sectores" => $sectores
        ));
    }
    public function entregar() {
        $recipe = new Recipe($this->Connection);
        $id = $_GET['id'];
        $receta_data = $recipe->getRecipe($id); 
        $receta = array();
        foreach ($receta_data as $row) {
            $receta[] = array(
                //"id_subrancho" => $row['id_subrancho'],
                "id_receta" => $row['id_receta'],
                "num_subrancho" => $row['num_subrancho'],
                "nombre" => $row['nombre'],
                "fecha" => $row['fecha'],
                "status" => $row['status'],
                "justificacion" => $row['justificacion'],
                "encargado" => $row['encargado'],
                "equipo" => $row['equipo'],
            );
        }
        //print_r($receta);

        $subrancho = new Subrancho($this->Connection);
        $s_data = $subrancho->getAll();
        $data1 = array();

        foreach ($s_data as $row) {
            $data1[] = array(
                //"id_subrancho" => $row['id_subrancho'],
                "num_subrancho" => $row['num_subrancho'],
                "nombre" => $row['nombre'],
            );
        }

        $producto = new Producto($this->Connection);
        $p_data = $producto->getProductos();
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
        $this->view("entregarReceta", array(
            "title" => "Entregar Receta",
            "data" => $data1,
            "productos" => $productos,
            "receta" => $receta
            //"sectores" => $sectores
        ));
    }
    public function resurtir() {
        $recipe = new Recipe($this->Connection);
        $id = $_GET['id'];
        $receta_data = $recipe->getRecipe($id); 
        $receta = array();
        foreach ($receta_data as $row) {
            $receta[] = array(
                //"id_subrancho" => $row['id_subrancho'],
                "id_receta" => $row['id_receta'],
                "num_subrancho" => $row['num_subrancho'],
                "nombre" => $row['nombre'],
                "fecha" => $row['fecha'],
                "status" => $row['status'],
                "justificacion" => $row['justificacion'],
                "encargado" => $row['encargado'],
                "equipo" => $row['equipo'],
            );
        }
        //print_r($receta);

        $subrancho = new Subrancho($this->Connection);
        $s_data = $subrancho->getAll();
        $data1 = array();

        foreach ($s_data as $row) {
            $data1[] = array(
                //"id_subrancho" => $row['id_subrancho'],
                "num_subrancho" => $row['num_subrancho'],
                "nombre" => $row['nombre'],
            );
        }

        $producto = new Producto($this->Connection);
        $p_data = $producto->getProductos();
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
        $this->view("resurtirReceta", array(
            "title" => "Resurtir Receta",
            "data" => $data1,
            "productos" => $productos,
            "receta" => $receta
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
        $s_data = $producto->getProductos();
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
        $data = $producto->getProductos();
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
    }

    public function guardar(){
        $subrancho 	=	$_REQUEST['subrancho'];
    	$fecha 	=	$_REQUEST['fecha'];
    	$estatus 	=	$_REQUEST['estatus'];
    	$justificacion 	=	$_REQUEST['justificacion'];
    	$encargado 	=	$_REQUEST['encargado'];
    	$equipo 	=	$_REQUEST['equipo'];
        $recipe = new Recipe($this->Connection);
    	$res = $recipe->addRecipe($subrancho, $fecha, $estatus, $justificacion, $encargado, $equipo);
        //print_r($res);
        return $res;
    }

    public function eliminar(){
        $id = $_POST['id']; //echo $id;
        $det_rec = new RecipeDetail($this->Connection);
        $res = $det_rec->delete($id);
    }

    public function guardar_detalles(){
        $data =	$_REQUEST['datos'];
        //print_r($data);
        foreach ($data as $val){
            $id_receta = $val['id_receta'];
            $id_prod = $val['id_prod'];
            $id_sector = $val['id_sector'];
            $dosis_total = $val['dosis_total'];
            $dosis_hectarea = $val['dosis_hectarea'];
            $estatus = 'Programada';
            print_r($val);
            print_r($val['id_receta']);
            $recipe = new Recipe($this->Connection);
            $res = $recipe->addRecipeDetail($id_receta, $id_prod, $id_sector, $dosis_total, $dosis_hectarea, $estatus);
        }
        return $res;
    }

    public function get_detalles(){
        $id = intval($_REQUEST['id']);
        $det_rec = new RecipeDetail($this->Connection);
        $data_det = $det_rec->getAll($id);
        $data = array();
        foreach ($data_det as $row) {
            $data[] = array(
                "id_receta_detalle" => $row['id_receta_detalle'],
                "id_receta" => $row['id_receta'],
                "id_prod" => $row['id_prod'],
                "id_sector" => $row['id_sector'],
                "dosis_hectarea" => $row['dosis_hectarea'],
                "dosis_total" => $row['dosis_total'],
                "status" => $row['status'],
                "nombre_s" => $row['nombre_s'],
            );
        }
        echo json_encode($data);
        //print_r($data);
    }

    public function table() {
        $recipe = new Recipe($this->Connection);
        $data = $recipe->getAll();
        $data1 = array();

        foreach ($data as $row) {
            if($row['status'] == 'Programada' || $row['status'] == 'Incompleta'){
                $a = '<a href="index.php?c=recetas&action=entregar&id='.$row['id_receta'].'"  data-toggle="tooltip" title="Entregar" class="btn btn-sm btn-info"> Entregar </a>';
            }elseif($row['status'] == 'Entregada'){
                $a = '<a href="index.php?c=recetas&action=resurtir&id='.$row['id_receta'].'"  data-toggle="tooltip" title="Resurtir" class="btn btn-sm btn-secondary"> Resurtir </a>';
            }else {
                $a = '';
            }
            $a1 = '<a href="index.php?c=recetas&action=imprimir&id='.$row['id_receta'].'"  data-toggle="tooltip" title="Imprimir" class="btn btn-sm btn-primary"> Imprimir </a>';
            $data1[] = array(
                "id_receta" => $row['id_receta'],
                "nombre" => $row['nombre'],
                "fecha" => $row['fecha'],
                "status" => $row['status'],
                "justificacion" => $row['justificacion'],
                "options" => $a . $a1
                /* '<a href="index.php?c=recetas&action=entregar&id='.$row['id_receta'].'"  data-toggle="tooltip" title="Entregar" class="btn btn-sm btn-info"> Entregar </a>' */
            );
        }
        $response = array(
            "draw" => 1,
            "aaData" => $data1
        );

        echo json_encode($response);
    }

    public function view($vista, $datos){
        $data = $datos;
        require_once  __DIR__ . "/../view/" . $vista . "View.php";
    }
}
