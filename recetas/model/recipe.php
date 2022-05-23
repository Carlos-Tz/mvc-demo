<?php
class Recipe {
    private $table = 'receta';
    private $Connection;
    public function __construct($Connection) { $this->Connection = $Connection; }

    public function getAll() {
        $stmt = $this->Connection->prepare("SELECT * FROM ".$this->table."')" );
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }
}