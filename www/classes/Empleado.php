<?php
require_once 'Database.php';

class Empleado {
    private $conexion;

    public function __construct() {
        // Crear una instancia de la clase Database
        $database = new Database();
        // Obtener la conexión PDO y asignarla a la propiedad $conexion
        $this->conexion = $database->getConn();
    }


    public function buscarEmpleadoID($i) {
        try {
            $query = "SELECT * FROM empleado WHERE id_empleado = :idEmpleado";
    
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':idEmpleado', $i);
    
            // Ejecutar la consulta
            $statement->execute();
    
            $empleados = $statement->fetch(PDO::FETCH_ASSOC);
    
            // Retornar el resultado
            return $empleados;
        } catch (PDOException $e) {
            // En caso de un error, lanzar una excepción
            throw new Exception("Error al buscar empleado: " . $e->getMessage());
        }
    }





    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

    // ------------ usuarioExiste ------------

    public function usuarioExiste($usuario) {
        // Comprobar si el usuario ya existe
        $sql = "SELECT COUNT(*) FROM empleado WHERE usuario = :usuario";
        $stmt = $this->conexion->prepare($sql);
    
        $stmt->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
    
        return (bool) $stmt->fetchColumn();
    }
    

    // ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
    // ------------ registrarEmpleadoBase ------------

    public function registrarEmpleadoBase($nombre, $apellido, $usuario) {
        try {
            $this->conexion->beginTransaction(); // Iniciar la transacción
    
            // Realiza las operaciones de la base de datos dentro de la transacción
            $sql = "INSERT INTO empleado (nombre, apellido, usuario, fk_id_departamento, fk_id_jerarquia) VALUES (:nombre, :apellido, :usuario, 1 ,1)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $this->conexion->commit(); // Confirmar la transacción
                return true;
            } else {
                $this->conexion->rollBack(); // Deshacer la transacción en caso de error
                return false;
            }
        } catch (PDOException $e) {
            $this->conexion->rollBack(); // Deshacer la transacción en caso de excepción
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ editarEmpleado ------------


    public function editarEmpleado($idEmpleado, $nroDNI, $nroContacto, $mailLaboral, $departamento, $jerarquia, $usuarioCampana) {
        try {
            $this->conexion->beginTransaction(); // Iniciar la transacción
    
            // Realiza las operaciones de la base de datos dentro de la transacción
            $sql = "UPDATE empleado SET nroDNI = :nroDNI, nroContacto = :nroContacto, mail_laboral = :mailLaboral, fk_id_departamento = :departamento, fk_id_jerarquia = :jerarquia, usuarioCampana = :usuarioCampana WHERE id_empleado = :idEmpleado";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nroDNI', $nroDNI, PDO::PARAM_STR);
            $stmt->bindParam(':nroContacto', $nroContacto, PDO::PARAM_STR);
            $stmt->bindParam(':mailLaboral', $mailLaboral, PDO::PARAM_STR);
            $stmt->bindParam(':departamento', $departamento, PDO::PARAM_INT); 
            $stmt->bindParam(':jerarquia', $jerarquia, PDO::PARAM_INT); 
            $stmt->bindParam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
            $stmt->bindParam(':usuarioCampana', $usuarioCampana, PDO::PARAM_STR);
    
            if ($stmt->execute()) {
                $this->conexion->commit(); // Confirmar la transacción
                return true;
            } else {
                $this->conexion->rollBack(); // Deshacer la transacción en caso de error
                return false;
            }
        } catch (PDOException $e) {
            $this->conexion->rollBack(); // Deshacer la transacción en caso de excepción
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    


// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getEmpleado ------------

public function getEmpleado($usuario) {
    try {
        // Preparar la consulta SQL para buscar empleados por nombre, apellido, nroLegajo o nroDNI
        $query = "SELECT * FROM empleado WHERE usuario = :u AND activo = 1";

       

        $statement = $this->conexion->prepare($query);
        $statement->bindParam(':u', $usuario, PDO::PARAM_STR);

      

        // Ejecutar la consulta
        $statement->execute();

        //fetch, devuelve una sola fila ya que se espera un empleado solo
        $resultados = $statement->fetch(PDO::FETCH_ASSOC);

        return $resultados;
    } catch (PDOException $e) {
      
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getEmpleado ------------

public function getEmpleadoDNI($usuario) {
    try {
        // Preparar la consulta SQL para buscar empleados por nombre, apellido, nroLegajo o nroDNI
        $query = "SELECT nroDNI FROM empleado WHERE usuario = :u AND activo = 1";

       

        $statement = $this->conexion->prepare($query);
        $statement->bindParam(':u', $usuario, PDO::PARAM_STR);

      

        // Ejecutar la consulta
        $statement->execute();

        //fetch, devuelve una sola fila ya que se espera un empleado solo
        $resultados = $statement->fetch(PDO::FETCH_ASSOC);

        return $resultados;
    } catch (PDOException $e) {
      
        echo "Error: " . $e->getMessage();
        return false;
    }
}





// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getEmpleadoDepartamentoJerarquia ------------

public function getEmpleadoDepartamentoJerarquia($usuario) {
    try {
        // Preparar la consulta SQL
        $query = "SELECT d.nombre AS nombreDepartamento , j.rol AS rol
        FROM empleado e
        INNER JOIN departamento d ON e.fk_id_departamento = d.id_departamento
        INNER JOIN jerarquia j ON e.fk_id_jerarquia = j.id_jerarquia
        WHERE e.usuario = :u";

        $statement = $this->conexion->prepare($query);
        $statement->bindParam(':u', $usuario);

        // Ejecutar la consulta
        $statement->execute();

        //  // Obtener el resultado. Fetchall es Obtener todos los empleados como un array asociativo
        $empleados = $statement->fetch(PDO::FETCH_ASSOC);

        // Retornar el resultado
        

        if ($empleados) {
            // Autenticación exitosa, el usuario y contraseña coinciden y la cuenta está activa
            return $empleados;
        } else {
            // Autenticación fallida
            return null;
        }
    } catch (PDOException $e) {
     
        echo "Error: " . $e->getMessage();
    }
}



// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ deshabilitarEmpleado ------------

public function deshabilitarEmpleado($id) {
    try {
        // Preparar la consulta SQL para deshabilitar un empleado por su ID
        $query = "UPDATE empleado SET activo = 0 WHERE id_empleado = :id";
        $statement = $this->conexion->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $statement->execute();

        // Retornar true si la deshabilitación se realizó con éxito
        return true;
    
    } catch (PDOException $e) {
      
        echo "Error: " . $e->getMessage();
        return false;
    }
}


// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ habilitarEmpleado ------------
public function habilitarEmpleado($id) {
    try {
        // Preparar la consulta SQL para deshabilitar un empleado por su ID
        $query = "UPDATE empleado SET activo = 1 WHERE id_empleado = :id";
        $statement = $this->conexion->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $statement->execute();

        // Retornar true si la deshabilitación se realizó con éxito
        return true;
    
    } catch (PDOException $e) {
      
        echo "Error: " . $e->getMessage();
        return false;
    }
}


// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ buscarEmpleado ------------
public function buscarEmpleado($termino_busqueda) {
    try {
        // Preparar la consulta SQL
          $query = "SELECT d.nombre AS nombreDepartamento , j.rol AS rol, e.*
          FROM empleado e
          INNER JOIN departamento d ON e.fk_id_departamento = d.id_departamento
          INNER JOIN jerarquia j ON e.fk_id_jerarquia = j.id_jerarquia
          WHERE 
          CONCAT(e.nombre, ' ', e.apellido) LIKE :busqueda 
          OR nroDNI LIKE :busqueda 
          OR e.nombre LIKE :busqueda 
          OR e.apellido LIKE :busqueda 
          OR d.nombre LIKE :busqueda 
          OR j.rol LIKE :busqueda 
          OR e.usuarioCampaña LIKE :busqueda 
          LIMIT 30";

        $stmt = $this->conexion->prepare($query);

        $termino_busqueda = "%" . $termino_busqueda . "%"; 

        $stmt->bindParam(':busqueda', $termino_busqueda, PDO::PARAM_STR);
        $stmt->execute();

        // Obtener el resultado como un arreglo asociativo
        $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $empleados; // Devolver un arreglo de resultados
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return array(); // Devolver un arreglo vacío en caso de error
    }
}


// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getEmpleados ------------
public function getEmpleados() {
    try {
        
          $query = "SELECT d.nombre AS nombreDepartamento , j.rol AS rol, e.*
          FROM empleado e
          INNER JOIN departamento d ON e.fk_id_departamento = d.id_departamento
          INNER JOIN jerarquia j ON e.fk_id_jerarquia = j.id_jerarquia";

        $stmt = $this->conexion->prepare($query);
        $stmt->execute();

        // Obtener el resultado como un arreglo asociativo
        $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $empleados; // Devolver un arreglo de resultados
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return array(); // Devolver un arreglo vacío en caso de error
    }
}



// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getEmpleados ------------

public function getEmpleadoConID($i) {
    try {
        // Preparar la consulta SQL
        $query = "SELECT empleado.*, departamento.nombre AS nombreDepartamento , jerarquia.rol AS rol
        FROM empleado
        INNER JOIN departamento ON empleado.fk_id_departamento = departamento.id_departamento
        INNER JOIN jerarquia ON empleado.fk_id_jerarquia = jerarquia.id_jerarquia
        WHERE empleado.id_empleado = :i AND empleado.activo = true";

        $statement = $this->conexion->prepare($query);
        $statement->bindParam(':i', $i);

        // Ejecutar la consulta
        $statement->execute();

        //  // Obtener el resultado. Fetchall es Obtener todos los empleados como un array asociativo
        $empleados = $statement->fetch(PDO::FETCH_ASSOC);

        // Retornar el resultado
        

        if ($empleados) {
            // Autenticación exitosa, el usuario y contraseña coinciden y la cuenta está activa
            return $empleados;
        } else {
            // Autenticación fallida
            return null;
        }
    } catch (PDOException $e) {
      
        echo "Error: " . $e->getMessage();
    }
}


}