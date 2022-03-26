<?php
class Entry {
    private $table = 'movtos_prod';
    private $table1 = 'producto';
    private $Connection;
    public function __construct($Connection) { $this->Connection = $Connection; }

    public function getAllEntries($f_i, $f_f) {
        $stmt = $this->Connection->prepare("SELECT movtos_prod.id_prod, movtos_prod.clasificacion, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto , movtos_prod.nom_prod, producto.unidad_medida FROM ".$this->table." , ".$this->table1." WHERE movtos_prod.id_prod = producto.id_prod AND (movtos_prod.tipo = 'E') AND (movtos_prod.fecha_movto BETWEEN '".$f_i."' AND '".$f_f."')" );
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }
}