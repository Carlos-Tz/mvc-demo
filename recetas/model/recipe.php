<?php
class Recipe {
    private $table = 'receta';
    private $Connection;
    public function __construct($Connection) { $this->Connection = $Connection; }

    public function getAll() {
        /* $stmt = $this->Connection->prepare("SELECT * FROM '".$this->table."'" ); */
        $stmt = $this->Connection->prepare("SELECT * FROM ".$this->table );
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }

    public function addRecipe($subrancho, $fecha, $estatus, $justificacion, $encargado, $equipo){
        $stmt = $this->Connection->prepare('INSERT INTO receta (num_subrancho, fecha, status, justificacion, encargado, equipo) VALUES( ?, ?, ?, ?, ?, ?)');
        //$stmt->bindParam(1, $this->table);
        $stmt->bindParam(1, $subrancho);
        $stmt->bindParam(2, $fecha);
        $stmt->bindParam(3, $estatus);
        $stmt->bindParam(4, $justificacion);
        $stmt->bindParam(5, $encargado);
        $stmt->bindParam(6, $equipo);
        $result = $stmt->execute();
        $id = $this->Connection->lastInsertId();
        echo $id;
        //$consulta="insert into ".$tabla." values(null,". $data .")";
        //$resultado=$this->db->query($consulta);
        /* if ($id) {
            return $id;
        }else {
            return '';
        } */
    }
}