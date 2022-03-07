<?php
class Movement {
    private $table = "movtos_prod";
    private $Connection;
    public function __construct($Connection) { $this->Connection = $Connection; }

    public function getAllEntries() {
        $stmt = $this->Connection->prepare("SELECT * FROM " .$this->table. " WHERE tipo = 'E'");
        $stmt->execute();
        $result = $stmt->fetchAll();
        //$this->Connection = null; //cierre de conexión
        return $result;
    }

    public function getAllOutputs() {
        $stmt = $this->Connection->prepare("SELECT * FROM " .$this->table. " WHERE tipo = 'S'");
        $stmt->execute();
        $result = $stmt->fetchAll();
        //$this->Connection = null; //cierre de conexión
        return $result;
    }
}