<?php
require_once 'Database.php';

class Departamento {
    private $conexion;

    public function __construct() {
        // Crear una instancia de la clase Database
        $database = new Database();
        // Obtener la conexión PDO y asignarla a la propiedad $conexion
        $this->conexion = $database->getConn();
    }

   
    public function obtenerDepartamentoID($valueSelect) {
       try {
            // Preparar la consulta SQL para verificar el usuario
            $query = "SELECT id_departamento FROM departamento WHERE nombre = :valueSelect";
            $stmt = $this->conexion->prepare($query);
        
            // Vincular los parámetros de manera segura
            $stmt->bindParam(':valueSelect', $valueSelect, PDO::PARAM_STR);
        
            // Ejecutar la consulta
            $stmt->execute();
        
       
        $idDepartamento = $stmt->fetch(PDO::FETCH_COLUMN);

        return $idDepartamento;

    } catch (PDOException $e) {
        throw new Exception("Error al ejecutar la consulta SQL: " . $e->getMessage());
        return null;
    }
}
    
    


}
