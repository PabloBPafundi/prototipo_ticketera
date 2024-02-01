<?php
require_once 'Database.php';
require_once 'Empleado.php';

class Ticket {
    private $conexion;

    public function __construct() {
        // Crear una instancia de la clase Database
        $database = new Database();
        // Obtener la conexión PDO y asignarla a la propiedad $conexion
        $this->conexion = $database->getConn();
    }


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ realizarPedido ------------
    public function realizarPedido($tipo_inconveniente, $estado_gestion_agente, $comentario_solicitante, $ubicacionLaboral, $posicionLaboral, $idRemoteDesktop, $proveedorInternet, $fk_id_empleado) {
        try {
            // Validar y limpiar los datos de entrada si es necesario
    
            $this->conexion->beginTransaction();
    
            $sql = "INSERT INTO ticket (tipo_inconveniente, estado_gestion_agente, comentario_solicitante, ubicacionLaboral, posicionLaboral, idRemoteDesktop, proveedorInternet, fk_id_empleado, estado_resolucion) VALUES (:tipo_inconveniente, :estado_gestion_agente, :comentario_solicitante, :ubicacionLaboral, :posicionLaboral, :idRemoteDesktop, :proveedorInternet, :fk_id_empleado, 'Enviado')";
    
            $stmt = $this->conexion->prepare($sql);
    
            // Enlazar los parámetros con los valores
            $stmt->bindParam(':tipo_inconveniente', $tipo_inconveniente, PDO::PARAM_STR);
            $stmt->bindParam(':estado_gestion_agente', $estado_gestion_agente, PDO::PARAM_STR);
            $stmt->bindParam(':comentario_solicitante', $comentario_solicitante, PDO::PARAM_STR);
            $stmt->bindParam(':ubicacionLaboral', $ubicacionLaboral, PDO::PARAM_STR);
            $stmt->bindParam(':posicionLaboral', $posicionLaboral, PDO::PARAM_STR);
            $stmt->bindParam(':idRemoteDesktop', $idRemoteDesktop, PDO::PARAM_STR);
            $stmt->bindParam(':proveedorInternet', $proveedorInternet, PDO::PARAM_STR);
            $stmt->bindParam(':fk_id_empleado', $fk_id_empleado, PDO::PARAM_INT);
    
            // Ejecutar la consulta
            $pedido = $stmt->execute();
    
            if ($pedido) {
                $ticketID = $this->conexion->lastInsertId(); // Obtenemos el ID del ticket insertado
                $this->conexion->commit(); // Confirmar la transacción
                return $ticketID;
            } else {
                $this->conexion->rollBack(); // Deshacer la transacción en caso de error
                return false;
            }
        } catch (PDOException $e) {
            $this->conexion->rollBack(); // Deshacer la transacción en caso de error
               // En caso de un error, manejarlo adecuadamente (registrar o lanzar una excepción, dependiendo de tus necesidades)
               echo "Error: " . $e->getMessage();
               return false;
        }
    }

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ cambiarEstadoSolucionado ------------

    public function cambiarEstadoSolucionado($idTicket) {
        try {
            // Validar y limpiar los datos de entrada si es necesario
    
            $this->conexion->beginTransaction();
    
            // Consulta para verificar si existe un fk_id_tecnico asignado
            $checkSql = "SELECT fk_id_tecnico FROM ticket WHERE id_ticket = :id_ticket";
            $checkStmt = $this->conexion->prepare($checkSql);
            $checkStmt->bindParam(':id_ticket', $idTicket);
            $checkStmt->execute();
            $fkIdTecnico = $checkStmt->fetchColumn();
    
            if ($fkIdTecnico === null) {
                // No hay un fk_id_tecnico asignado, puedes realizar la actualización
                $updateSql = "UPDATE ticket SET estado_resolucion = 'Soluciono Agente' WHERE id_ticket = :id_ticket";
                $updateStmt = $this->conexion->prepare($updateSql);
                $updateStmt->bindParam(':id_ticket', $idTicket);
    
                // Ejecutar la consulta de actualización
                if ($updateStmt->execute()) {
                    $this->conexion->commit(); // Confirmar la transacción
                    return true;
                } else {
                    $this->conexion->rollBack(); // Deshacer la transacción en caso de error
                    return false;
                }
            } else {
                // Existe un fk_id_tecnico asignado, no se puede realizar la actualización
                $this->conexion->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            $this->conexion->rollBack(); // Deshacer la transacción en caso de error
    
            // En caso de un error, manejarlo adecuadamente (puedes registrar o lanzar una excepción, dependiendo de tus necesidades)
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ cambiarEstadoTicket ------------

    public function cambiarEstadoTicket($idTicket, $estado, $ct, $nroElevado) {
        try {
           
            // Comienza una transacción
            $this->conexion->beginTransaction();
    
            // Prepara la consulta SQL
            $sql = "UPDATE ticket SET estado_resolucion = :estado, descripcion_tecnico = :ct";


            if ($estado == 'Cerrado') {
                $sql .= ", fechaHora_cierre = CURRENT_TIMESTAMP";
            }


            if (!empty($nroElevado)) {
                $sql .= ", nroElevado = :nroElevado";
            }



            $sql .= " WHERE id_ticket = :id_ticket";
    
            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(':id_ticket', $idTicket);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':ct', $ct);

            if (!empty($nroElevado)) {
                $stmt->bindParam(':nroElevado', $nroElevado);
            }
           
           
    
            // Ejecuta la consulta de actualización
            if ($stmt->execute()) {
                // Confirma la transacción
                $this->conexion->commit();
                return true;
            } else {
                // Deshace la transacción en caso de error
                $this->conexion->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            $this->conexion->rollBack();
    
            // En caso de un error, manejarlo adecuadamente (puedes registrar o lanzar una excepción, dependiendo de tus necesidades)
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getTicketsSinAsignar ------------ 
    

    public function getTicketsSinAsignar() {
        try {
            // Preparar la consulta SQL para obtener los tickets sin asignar
            $query = "SELECT t.*, e.nombre, e.apellido FROM ticket t INNER JOIN empleado e ON t.fk_id_empleado = e.id_empleado WHERE t.estado_resolucion = 'Enviado' ORDER BY t.fecha_hora_pedido ASC LIMIT 30";
            $stmt = $this->conexion->prepare($query);
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener el resultado como un arreglo asociativo
            $infoTicket = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Verificar si hay resultados
            if (count($infoTicket) > 0) {
                return $infoTicket;
            } else {
                // No hay tickets sin asignar
                return null; 
            }
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getTicketsA ------------
    public function getTicketsEnProceso($id_tecnico) {
        try {
            // Preparar la consulta SQL para verificar el usuario
            $query = "SELECT * FROM ticket t INNER JOIN empleado e on t.fk_id_empleado = e.id_empleado WHERE estado_resolucion = 'En proceso' && fk_id_tecnico = :id_tecnico ORDER BY fecha_hora_pedido DESC";
            $stmt = $this->conexion->prepare($query);
            $stmt ->bindParam(':id_tecnico', $id_tecnico);
    
           // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener el resultado como un arreglo asociativo
            $infoTicket = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $infoTicket; // Puedes devolver el resultado directamente, sin necesidad de comprobar si existe un resultado o no.
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getTicketsA ------------
        public function getTicketsElevado($id_tecnico) {
            try {
                // Preparar la consulta SQL para verificar el usuario
                $query = "SELECT * FROM ticket t INNER JOIN empleado e on t.fk_id_empleado = e.id_empleado WHERE estado_resolucion = 'Elevado' && fk_id_tecnico = :id_tecnico ORDER BY fecha_hora_pedido DESC";
                $stmt = $this->conexion->prepare($query);
                $stmt ->bindParam(':id_tecnico', $id_tecnico);

            // Ejecutar la consulta
                $stmt->execute();

                // Obtener el resultado como un arreglo asociativo
                $infoTicket = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $infoTicket; // Puedes devolver el resultado directamente, sin necesidad de comprobar si existe un resultado o no.

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        }



// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getAllTickets ------------

    public function getAllTickets() {
        try {

          
            // Preparar la consulta SQL para verificar el usuario
            $query = 
            "SELECT e.nroDNI, d.nombre AS nombreDepartamento , j.rol AS rol, t.*
             FROM ticket t
             INNER JOIN empleado e on t.fk_id_empleado = e.id_empleado 
             INNER JOIN departamento d ON e.fk_id_departamento = d.id_departamento
             INNER JOIN jerarquia j ON e.fk_id_jerarquia = j.id_jerarquia
             ORDER BY t.id_ticket DESC LIMIT 50";

            $stmt = $this->conexion->prepare($query);

     
            $stmt->execute();
    
            // Obtener el resultado como un arreglo asociativo
            $infoTicket = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $infoTicket; // Puedes devolver el resultado directamente, sin necesidad de comprobar si existe un resultado o no.
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ obtenerJerarquiaID ------------

    public function searchTicket($termino_busqueda) {
        try {
            $query = "SELECT e.nroDNI, d.nombre AS nombreDepartamento , j.rol AS rol, t.* FROM ticket t
                      INNER JOIN empleado e on t.fk_id_empleado = e.id_empleado 
                      INNER JOIN departamento d ON e.fk_id_departamento = d.id_departamento
                      INNER JOIN jerarquia j ON e.fk_id_jerarquia = j.id_jerarquia

                      WHERE t.id_ticket LIKE :busqueda 
                      OR CONCAT(e.nombre, ' ', e.apellido) LIKE :busqueda 
                      OR t.estado_resolucion LIKE :busqueda 
                      OR e.usuarioCampana LIKE :busqueda 
                      OR nroDNI LIKE :busqueda 
                      OR e.nombre LIKE :busqueda 
                      OR e.apellido LIKE :busqueda 
                      OR d.nombre LIKE :busqueda 
                      OR j.rol LIKE :busqueda 
                      ORDER BY t.id_ticket DESC LIMIT 30  ";
    
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':busqueda', $termino_busqueda);
            $stmt->execute();
    
            // Obtener el resultado como un arreglo asociativo
            $infoTickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $infoTickets; // Devolver un arreglo de resultados
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return array(); // Devolver un arreglo vacío en caso de error
        }
    }
    
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ obtenerJerarquiaID ------------
    public function getTicketabiertos($id) {
        try {
            // Preparar la consulta SQL para verificar el usuario
            $query = "SELECT * FROM ticket WHERE (estado_resolucion != 'Cerrado' && estado_resolucion != 'Soluciono Agente') && fk_id_empleado = :id ORDER BY fecha_hora_pedido DESC LIMIT 8";
            $stmt = $this->conexion->prepare($query);
    
            // Vincular los parámetros de manera segura
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener el resultado como un arreglo asociativo
            $infoTicket = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $infoTicket; 
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

 // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ obtenerJerarquiaID ------------


    public function asociarTicketaTecnico($idTicket, $idTecnico) {
        try {
            // Validar y limpiar los datos de entrada si es necesario
    
            $this->conexion->beginTransaction();
    
            // Consulta para verificar si existe un fk_id_tecnico asignado
            $checkSql = "SELECT fk_id_tecnico, estado_resolucion FROM ticket WHERE id_ticket = :id_ticket";
            $checkStmt = $this->conexion->prepare($checkSql);
            $checkStmt->bindParam(':id_ticket', $idTicket);
            $checkStmt->execute();
            $resul = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
            if ($resul['estado_resolucion'] == 'Enviado' && $resul['fk_id_tecnico'] === null) {
                
    
                $updateSql = "UPDATE ticket SET estado_resolucion = 'En proceso', fk_id_tecnico = :idTecnico, fechaHora_inicio = CURRENT_TIMESTAMP WHERE id_ticket = :id_ticket";
                $updateStmt = $this->conexion->prepare($updateSql);
                $updateStmt->bindParam(':id_ticket', $idTicket);
                $updateStmt->bindParam(':idTecnico', $idTecnico);
    
                // Ejecutar la consulta de actualización
                if ($updateStmt->execute()) {
                    $this->conexion->commit(); // Confirmar la transacción
                    return true;
                } else {
                    $this->conexion->rollBack(); // Deshacer la transacción en caso de error
                    return false;
                }
            } else {
                // Existe un fk_id_tecnico asignado, no se puede realizar la actualización
                $this->conexion->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            $this->conexion->rollBack(); // Deshacer la transacción en caso de error
    
           
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ obtenerJerarquiaID ------------

    public function actualizarInfoTicket($id) {
        try {
            // Preparar la consulta SQL para verificar el usuario
            $query = "SELECT * FROM ticket t INNER JOIN empleado e ON t.fk_id_tecnico = e.id_empleado WHERE t.id_ticket = :id";
            $stmt = $this->conexion->prepare($query);
    
            // Vincular los parámetros de manera segura
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Ejecutar la consulta
            $stmt->execute();
    
           
            $infoTicket = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($infoTicket) {
            
                return $infoTicket;
            } else {
               
                return null;
            }
    
    
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ obtenerJerarquiaID ------------
    public function getTicketCerrado($id) {
        try {
            // Preparar la consulta SQL para verificar el usuario
            $query = "SELECT
            t.id_ticket,
            t.nroElevado,
            t.fecha_hora_pedido,
            t.fechaHora_cierre,
            t.fechaHora_inicio,
            t.estado_resolucion,
            tecnico.nombre AS nombre_tecnico
           FROM ticket t INNER JOIN  empleado tecnico ON t.fk_id_tecnico = tecnico.id_empleado  WHERE (t.estado_resolucion = 'Cerrado' OR t.estado_resolucion = 'Soluciono Agente' ) && t.fk_id_empleado = :id ORDER BY fecha_hora_pedido DESC LIMIT 10";


            $stmt = $this->conexion->prepare($query);
    
            // Vincular los parámetros de manera segura
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Ejecutar la consulta
            $stmt->execute();
    
           
            $tCerrados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($tCerrados) {
            
                return $tCerrados;
            } else {
               
                return null;
            }
    
    
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getCountTicketEnviados ------------ 


public function getCountTicketEnviados() {
    try {
        // Preparar la consulta SQL para obtener los tickets sin atender
        $query = "SELECT COUNT(estado_resolucion) FROM ticket WHERE estado_resolucion = 'Enviado'";
        $stmt = $this->conexion->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado como un valor escalar (número de tickets)
        $count = $stmt->fetchColumn();

        return $count;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getCountTicketAtendidos ------------ 


public function getCountTicketAtendidos() {
    try {
        // Preparar la consulta SQL para obtener los tickets sin atender
        $query = "SELECT COUNT(estado_resolucion) FROM ticket WHERE estado_resolucion = 'En proceso'";
        $stmt = $this->conexion->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado como un valor escalar (número de tickets)
        $count = $stmt->fetchColumn();

        return $count;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

// ------------ getCountTicketAtendidos ------------ 


public function getCountTicketElevados() {
    try {
        // Preparar la consulta SQL para obtener los tickets sin atender
        $query = "SELECT COUNT(estado_resolucion) FROM ticket WHERE estado_resolucion = 'Elevado'";
        $stmt = $this->conexion->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado como un valor escalar (número de tickets)
        $count = $stmt->fetchColumn();

        return $count;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}


}
