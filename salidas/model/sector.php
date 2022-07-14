<?php
class Sector {
    private $table = 'sector';
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
    public function getSector($id) {
        $stmt = $this->Connection->prepare('SELECT * FROM sector WHERE num_subrancho = ?');
        //$stmt->bindParam(1, $this->table);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }
}