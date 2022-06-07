<?php
class RecipeDetail {
    private $table = 'receta_detalle';
    private $Connection;
    public function __construct($Connection) { $this->Connection = $Connection; }

    public function getAll($id) {
        /* $stmt = $this->Connection->prepare("SELECT * FROM '".$this->table."'" ); */
        $stmt = $this->Connection->prepare("SELECT * FROM receta_detalle WHERE receta_detalle.id_receta = ".$id);
        //$stmt->bindParam(1, $this->table);
        //$stmt->bindParam(2, $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }

}