<?php
class Movement {
    private $table = 'movtos_prod';
    private $Connection;
    public function __construct($Connection) { $this->Connection = $Connection; }

    public function getAllEntries($f_inicial, $f_final) {
        /* $stmt = $this->Connection->prepare("SELECT * FROM " .$this->table. " WHERE tipo = 'E'"); */
        $stmt = $this->Connection->prepare("SELECT movtos_prod.id_prod, movtos_prod.tipo, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto, movtos_prod.nom_prod, movtos_prod.clasificacion, (movtos_prod.cantidad*movtos_prod.precio_compra) AS importe FROM " .$this->table." WHERE tipo='E' AND movtos_prod.fecha_movto BETWEEN '".$f_inicial. "' AND '".$f_final. "'" );
        $stmt->execute();
        $result = $stmt->fetchAll();
        //$this->Connection = null; //cierre de conexión
        return $result;
    }

    public function getAllOutputs($f_inicial, $f_final) {
        /* $stmt = $this->Connection->prepare("SELECT * FROM " .$this->table. " WHERE tipo = 'S'"); */
        $stmt = $this->Connection->prepare("SELECT movtos_prod.id_prod, movtos_prod.tipo, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto, movtos_prod.nom_prod, movtos_prod.clasificacion, (movtos_prod.cantidad*movtos_prod.precio_compra) AS importe FROM " .$this->table." WHERE tipo='S' AND movtos_prod.fecha_movto BETWEEN '".$f_inicial. "' AND '".$f_final. "'");
        $stmt->execute();
        $result = $stmt->fetchAll();
        //$this->Connection = null; //cierre de conexión
        return $result;
    }
}