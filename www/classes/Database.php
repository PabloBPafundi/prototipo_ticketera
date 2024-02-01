<?php

class Database {
    private $host = "localhost"; // El nombre del servidor de la base de datos
    private $db_name = "prototipo_bd"; // El nombre de la base de datos
    private $username = "root"; // Tu nombre de usuario de la base de datos
    private $password = "root"; // Tu contraseña de la base de datos
    private $conn; // La variable de conexión PDO

    public function getConn() {
        $this->conn = null;

        try {
            // Crear una instancia de PDO y establecer la conexión
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
            // Configurar el modo de errores para que PDO lance excepciones en caso de errores
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // En caso de error, capturar la excepción y mostrar un mensaje de error
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
