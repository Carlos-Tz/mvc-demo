<?php
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

    public function index()
    {
        $entry = new Existence($this->Connection);
        $entries = $entry->getAll();
        /* print_r($entries); */
        /* $data = array(); */
        $this->view("index", array(
            "entries" => $entries,
            "title" => "INDEX"
        ));
    }

    public function table()
    {
        $existence = new Existence($this->Connection);
        $existences = $existence->getAll();
        $movement = new Movement($this->Connection);
        $entries = $movement->getAllEntries();
        $outputs = $movement->getAllOutputs();
        $data = array();
        foreach ($this->rubros as $key_rubro => $value_rubro) :
            $rub[$key_rubro] = array_filter($existences, function ($row) use ($value_rubro) {
                return strtolower($row['clasificacion']) == $value_rubro;
            });
            $id = '';
            $products = array();            
            foreach ($rub[$key_rubro] as $j => $v):
                $id = $v['id_prod'];
                $entr[$j] = array_filter($entries, function ($row) use ($id){
                    return $row['id_prod'] == $id;
                });
                $outp[$j] = array_filter($outputs, function ($row) use ($id){
                    return $row['id_prod'] == $id;
                });
                array_push($products, array('p' => $v, 'entradas' =>  $entr[$j], 'salidas' =>  $outp[$j]));
                endforeach;
            if ($rub[$key_rubro]):
                array_push($data, array('rubro' => $this->rubros[$key_rubro], 'productos' => $products));
                /* array_push($data, array('rubro' => $this->rubros[$key_rubro], 'productos' => $rub[$key_rubro])); */
            endif;
        endforeach;
        $results = array(
            "draw" => 1,
            'aaData' => $data
        );

        echo json_encode($results);
    }

    public function view($vista, $datos)
    {
        $data = $datos;
        require_once  __DIR__ . "/../view/" . $vista . "View.php";
        $results = array(
            'aaData' => $datos['entries']
        );
        //echo json_encode($results); 
    }
}
