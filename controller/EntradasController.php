<?php

class EntradasController {
    private $conectar;
    private $Connection;

    public function __construct() {
        require_once  __DIR__ . "/../core/Conectar.php";
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
            default:
                $this->index();
                break;
        }
    }

    public function index() {
        $this->view("entradas", array(
            "title" => "INDEX"
        ));
    }

    public function view($vista, $datos)
    {
        $data = $datos;
        require_once  __DIR__ . "/../view/" . $vista . "View.php";
    }
}