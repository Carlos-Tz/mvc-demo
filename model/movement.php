<?php
class Movement {
    private $table = "movtos_prod";
    private $Connection;
    public function __construct($Connection) { $this->Connection = $Connection; }

    public function getAllEntries() {
        /* $stmt = $this->Connection->prepare("SELECT * FROM " .$this->table. " WHERE tipo = 'E'"); */
        $stmt = $this->Connection->prepare("SELECT movtos_prod.id_prod, movtos_prod.tipo, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto, movtos_prod.nom_prod, movtos_prod.clasificacion, (movtos_prod.cantidad*movtos_prod.precio_compra) AS importe FROM " .$this->table. " WHERE tipo='E' AND movtos_prod.fecha_movto BETWEEN '2021-11-22' AND '2021-11-28';");
        $stmt->execute();
        $result = $stmt->fetchAll();
        //$this->Connection = null; //cierre de conexión
        return $result;
    }

    public function getAllOutputs() {
        /* $stmt = $this->Connection->prepare("SELECT * FROM " .$this->table. " WHERE tipo = 'S'"); */
        $stmt = $this->Connection->prepare("SELECT movtos_prod.id_prod, movtos_prod.tipo, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto, movtos_prod.nom_prod, movtos_prod.clasificacion, (movtos_prod.cantidad*movtos_prod.precio_compra) AS importe FROM " .$this->table. " WHERE tipo='S' AND movtos_prod.fecha_movto BETWEEN '2021-11-22' AND '2021-11-28';");
        $stmt->execute();
        $result = $stmt->fetchAll();
        //$this->Connection = null; //cierre de conexión
        return $result;
    }
}