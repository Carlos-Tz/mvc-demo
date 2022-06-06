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
    }

    public function addRecipeDetail($id_receta, $id_prod, $id_sector, $dosis_total, $dosis_hectarea, $estatus){
        $stmt = $this->Connection->prepare('INSERT INTO receta_detalle (id_receta, id_prod, id_sector, dosis_hectarea, dosis_total, status) VALUES( ?, ?, ?, ?, ?, ?)');
        //$stmt->bindParam(1, $this->table);
        $stmt->bindParam(1, $id_receta);
        $stmt->bindParam(2, $id_prod);
        $stmt->bindParam(3, $id_sector);
        $stmt->bindParam(4, $dosis_hectarea);
        $stmt->bindParam(5, $dosis_total);
        $stmt->bindParam(6, $estatus);
        $result = $stmt->execute();
        //$id = $this->Connection->lastInsertId();
        echo $result;
    }
}