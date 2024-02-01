<?php
require_once 'Database.php';

class Auth {
    private $conexion;

    public function __construct() {
        // Crear una instancia de la clase Database
        $database = new Database();
        // Obtener la conexión PDO y asignarla a la propiedad $conexion
        $this->conexion = $database->getConn();
    }

    
    
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ logout ------------

    public function logout() {
        // Iniciar la sesión si no se ha iniciado aún
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        // Destruir la sesión actual
        session_destroy();
    
        // Redirigir al usuario a la página de inicio de sesión
        header('Location: ./login.php');
        exit();
    }
    

}
