<?php
class Producto {
    private $table = 'producto';
    private $clasificacion = 'fertilizante';
    private $clasificacion2 = 'agroquimico';
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
    public function getProducto() {
        $stmt = $this->Connection->prepare('SELECT * FROM producto WHERE (clasificacion = ? OR clasificacion = ?) AND (existencia > 0.009)');
        //$stmt->bindParam(1, $this->table);
        $stmt->bindParam(1, $this->clasificacion);
        $stmt->bindParam(2, $this->clasificacion2);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }
}