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
    public function getProductos() {
        $stmt = $this->Connection->prepare('SELECT * FROM producto WHERE (clasificacion = ? OR clasificacion = ?) AND (existencia >= 0.01)');
        //$stmt->bindParam(1, $this->table);
        $stmt->bindParam(1, $this->clasificacion);
        $stmt->bindParam(2, $this->clasificacion2);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }

    public function getProducto($id_prod) {
        $stmt = $this->Connection->prepare('SELECT producto.id_prod, producto.clasificacion, producto.existencia, producto.costo_promedio, producto.nom_prod FROM producto WHERE producto.id_prod = ?');
        $stmt->bindParam(1, $id_prod);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $result;
    }
    
    public function updateProducto($val, $id_prod) {
        $stmt = $this->Connection->prepare('UPDATE producto SET existencia = ? WHERE id_prod = ?');
        $stmt->bindParam(1, $val);
        $stmt->bindParam(2, $id_prod);
        $res = $stmt->execute();
        //$result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $res;
    }

    public function addMov($id_p, $val, $precio, $fecha, $id_r, $nombre, $clasificacion, $sub, $nom_s){
        $stmt = $this->Connection->prepare('INSERT INTO movtos_prod (id_prod, tipo, cantidad, precio_compra, fecha_movto, id_requisicion, nom_prod, clasificacion, subrancho, sector) VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $tipo = 'S';

        $stmt->bindParam(1, $id_p);
        $stmt->bindParam(2, $tipo);
        $stmt->bindParam(3, $val);
        $stmt->bindParam(4, $precio);
        $stmt->bindParam(5, $fecha);
        $stmt->bindParam(6, $id_r);
        $stmt->bindParam(7, $nombre);
        $stmt->bindParam(8, $clasificacion);
        $stmt->bindParam(9, $sub);
        $stmt->bindParam(10, $nom_s);
        $res = $stmt->execute();
        //$result = $stmt->fetchAll();
        $this->Connection = null; //cierre de conexión
        return $res;
    }
}