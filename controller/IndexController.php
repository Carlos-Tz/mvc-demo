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
            case "table":
                $this->table();
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
        $entry = new Entry($this->Connection);
        $entries = $entry->getAll();
        /* print_r($entries); */
        /* $data = array(); */
        $this->view("index", array(
            "entries" => $entries,
            "title" => "INDEX"
        ));
    }

    public function table(){
        $entry = new Entry($this->Connection);
        $entries = $entry->getAll();
        $data = array();
        foreach ($entries as $entry){
            array_push($data, array('fecha' => $entry['fecha'], 'semana' => $entry['semana'], 'id_prod' => $entry['id_prod'], 'nom_prod' => $entry['nom_prod'], 'existencia' => $entry['existencia'], 'costo_promedio' => $entry['costo_promedio'], 'clasificacion' => $entry['clasificacion']));
        }
        $results = array(
            "draw" => 1,
            'aaData' => $data
        );
        echo json_encode($results); 
    }

	public function view($vista, $datos) {
        $data = $datos;
        require_once  __DIR__ . "/../view/" . $vista . "View.php";
        $results = array(
            'aaData' => $datos['entries']
        );
        //echo json_encode($results); 
    }
}
