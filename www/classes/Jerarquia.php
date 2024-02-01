<?php
require_once 'Database.php';

class Jerarquia {
    private $conexion;

    public function __construct() {
        // Crear una instancia de la clase Database
        $database = new Database();
        // Obtener la conexión PDO y asignarla a la propiedad $conexion
        $this->conexion = $database->getConn();
    }


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ obtenerJerarquiaID ------------
   
    public function obtenerJerarquiaID($valueSelect) {
        try {
            // Preparar la consulta SQL para verificar el usuario
            $query = "SELECT id_Jerarquia FROM Jerarquia WHERE rol = :valueSelect";
            $stmt = $this->conexion->prepare($query);
    
            // Vincular los parámetros de manera segura
            $stmt->bindParam(':valueSelect', $valueSelect, PDO::PARAM_STR);
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener el resultado como un escalar (el ID de la jerarquía)
            $idJerarquia = $stmt->fetch(PDO::FETCH_COLUMN);
    
            return $idJerarquia;
    
        } catch (PDOException $e) {
            throw new Exception("Error al ejecutar la consulta SQL: " . $e->getMessage());
            return null;
        }
    
       
    }

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
    
    
    


}
