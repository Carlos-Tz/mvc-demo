<?php
class Producto {
    private $table = 'producto';
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
    public function getProducto($clasificacion) {
        $stmt = $this->Connection->prepare('SELECT * FROM producto WHERE clasificacion = ?');
        //$stmt->bindParam(1, $this->table);
        $stmt->bindParam(1, $clasificacion);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }
}