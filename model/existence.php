<?php
class Existence {
    private $table = "semanal";
    private $table1 = "producto";
    private $Connection;/* 
    private $fecha;
    private $semana;
    private $id_prod;
    private $nom_prod;
    private $existencia;
    private $costo_promedio;
    private $clasificacion; */
    public function __construct($Connection) { $this->Connection = $Connection; }
    /* public function getFecha() { return $this->fecha; }
    public function setFecha($fecha) { $this->fecha = $fecha; }
    public function getSemana() { return $this->semana; }
    public function setSemana($semana) { $this->semana = $semana; }
    public function getIdProduct() { return $this->id_prod; }
    public function setIdProduct($id_prod) { $this->id_prod = $id_prod; }
    public function getNomProd() { return $this->nom_prod; }
    public function setNomProd($nom_prod) { $this->nom_prod = $nom_prod; }
    public function getExist() { return $this->existencia; }
    public function setExist($existencia) { $this->existencia = $existencia; }
    public function getCosto() { return $this->costo_promedio; }
    public function setCosto($costo_promedio) { $this->costo_promedio = $costo_promedio; }
    public function getClasificacion() { return $this->clasificacion; }
    public function setClasificacion($clasificacion) { $this->clasificacion = $clasificacion; } */

    public function getAll() {
        $stmt = $this->Connection->prepare("SELECT semanal.id_prod, semanal.fecha, semanal.nom_prod, semanal.existencia, semanal.clasificacion, semanal.costo_promedio, producto.unidad_medida FROM " .$this->table. "," .$this->table1. " WHERE semanal.id_prod = producto.id_prod");
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }
}