<?php
require '../phpspreadsheet/vendor/autoload.php';


class ProductosController {
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
            case "salida":
                $this->salida();
                break;
            case "movimiento":
                $this->movimiento();
                break;
            default:
                $this->index();
                break;
        }
    }
    public function salida() {
        $id_s = intval($_POST['id_sub']);
        $id_p = intval($_POST['id_prod']);
        $id_se = intval($_POST['id_sec']);
        $val = $_POST['sal'];
        $prod = new Producto($this->Connection);
        $producto = $prod->getProducto($id_p);
        if ($producto[0]){
            print_r($producto[0]);
            $exis = floatval($producto[0]['existencia']);
            $nexis = $exis - $val;
            $prod2 = new Producto($this->Connection);
            $producto2 =  $prod2->updateProducto($nexis, $id_p);
            print_r($producto2);
        }else return 0;
        //print_r($producto[0]['existencia']);
        
    }
    public function movimiento() {
        $id_r = intval($_POST['id_rec']);
        $sub = $_POST['sub'];
        $id_p = $_POST['id_prod'];
        $id_se = intval($_POST['id_sec']);
        $val = $_POST['sal'];
        $nom_s = $_POST['nom_sec'];
        $prod = new Producto($this->Connection);
        $producto = $prod->getProducto($id_p);
        if ($producto[0]){
            print_r($producto[0]);
            $precio = floatval($producto[0]['costo_promedio']);
            $nombre = $producto[0]['nom_prod'];
            $clasificacion = $producto[0]['clasificacion'];
            $fecha = date("Y-m-d"); 
            /* $exis = floatval($producto[0]['existencia']);
            $nexis = $exis - $val;*/
            $prod2 = new Producto($this->Connection);
            $producto2 =  $prod2->addMov($id_p, $val, $precio, $fecha, $id_r, $nombre, $clasificacion, $sub, $nom_s);
            print_r($producto2);
        }else return 0;
    }

    public function index() {
        $this->view("index", array(
            "title" => "INDEX"
        ));
    }

    public function view($vista, $datos){
        $data = $datos;
        require_once  __DIR__ . "/../view/" . $vista . "View.php";
    }
}
