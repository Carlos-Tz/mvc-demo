<?php
class IndexController {

	private $conectar;
	private $Connection;
	public function __construct(){
		require_once  __DIR__ . "/../core/Conectar.php";
		require_once  __DIR__ . "/../model/entry.php";
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
            /* case "alta":
                $this->crear();
                break;
            case "detalle":
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

	public function index() {
        $entrie = new Entry($this->Connection);
        $entries = $entrie->getAll();
        $this->view("index", array(
            "entries" => $entries,
            "title" => "INDEX"
        ));
    }

	public function view($vista, $datos) {
        $data = $datos;
        require_once  __DIR__ . "/../view/" . $vista . "View.php";
        echo json_encode($datos); 
    }
}
