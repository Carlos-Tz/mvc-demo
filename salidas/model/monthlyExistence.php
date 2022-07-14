<?php
class MonthlyExistence {
    private $table = 'mensual';
    private $table1 = 'producto';
    private $table2 = 'ciclo';
    private $Connection;
    public function __construct($Connection) { $this->Connection = $Connection; }

    public function getAll($month, $cicle) {
        $stmt = $this->Connection->prepare("SELECT mensual.id_prod, mensual.mes, mensual.anio, mensual.nom_prod, mensual.existencia, mensual.clasificacion, mensual.costo_promedio, producto.unidad_medida, ciclo.ciclo, (mensual.existencia*mensual.costo_promedio) AS importe FROM ".$this->table." , ".$this->table1." , ".$this->table2." WHERE mensual.id_prod = producto.id_prod AND mensual.mes = '".$month."' AND mensual.id_ciclo = ".$cicle." AND mensual.id_ciclo = ciclo.id_ciclo" );
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }

    public function getCicle(){
        $stmt = $this->Connection->prepare("SELECT * FROM ".$this->table2);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }
}