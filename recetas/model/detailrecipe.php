<?php
class RecipeDetail {
    private $table = 'receta_detalle';
    private $Connection;
    public function __construct($Connection) { $this->Connection = $Connection; }

    public function getAll($id) {
        /* $stmt = $this->Connection->prepare("SELECT * FROM '".$this->table."'" ); */
        //$stmt = $this->Connection->prepare("SELECT * FROM receta_detalle WHERE receta_detalle.id_receta = ".$id);
        $stmt = $this->Connection->prepare("SELECT receta_detalle.id_receta_detalle, receta_detalle.id_receta, receta_detalle.id_prod, receta_detalle.id_sector, receta_detalle.dosis_hectarea, receta_detalle.dosis_total, receta_detalle.status, sector.nombre as nombre_s FROM receta_detalle, sector WHERE receta_detalle.id_receta = ".$id." AND sector.id_sector = receta_detalle.id_sector");
        //$stmt->bindParam(1, $this->table);
        //$stmt->bindParam(2, $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }

    public function delete($id){
        $stmt = $this->Connection->prepare("DELETE FROM receta_detalle WHERE id_receta = ". $id );
        $res = $stmt->execute();
        if ($res) {
            return true; 
        }else {
            return false;
        }
    }

}