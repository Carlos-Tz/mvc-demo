<?php
class Existence {
    private $table = 'semanal';
    private $table1 = 'producto';
    private $Connection;
    public function __construct($Connection) { $this->Connection = $Connection; }

    public function getAll($week) {
        $stmt = $this->Connection->prepare("SELECT semanal.id_prod, semanal.semana, semanal.fecha, semanal.nom_prod, semanal.existencia, semanal.clasificacion, semanal.costo_promedio, producto.unidad_medida, (semanal.existencia*semanal.costo_promedio) AS importe FROM ".$this->table." , ".$this->table1." WHERE semanal.id_prod = producto.id_prod AND semanal.semana = ".$week );
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }
}