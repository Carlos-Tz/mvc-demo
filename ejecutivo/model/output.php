<?php
class Output {
    private $table = 'movtos_prod';
    private $table1 = 'producto';
    private $table2= 'sector';
    private $Connection;
    public function __construct($Connection) { $this->Connection = $Connection; }

    public function getAllOutputs($f_i, $f_f) {
        $stmt = $this->Connection->prepare("SELECT movtos_prod.id_prod, movtos_prod.clasificacion, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto , movtos_prod.nom_prod, movtos_prod.subrancho, movtos_prod.sector, producto.unidad_medida, sector.hectareas, sector.nombre from ".$this->table." , ".$this->table1." , ".$this->table2." WHERE movtos_prod.id_prod = producto.id_prod AND (movtos_prod.tipo = 'S') AND (sector.nombre = movtos_prod.sector) AND (movtos_prod.fecha_movto BETWEEN '".$f_i."' AND '".$f_f."')" );
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }
}