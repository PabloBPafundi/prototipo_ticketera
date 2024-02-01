
<?php 

require_once("includes/header.php");
require_once '../classes/Ticket.php';

$ticketObj = new Ticket();

$idTecnico = $empleadoActual['id_empleado'];

$ticketsA = $ticketObj->getTicketsEnProceso($idTecnico);

$ticketsE = $ticketObj->getTicketsElevado($idTecnico);




// Logica cambiar estado de ticket
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['id_ticketA'])) {

//     $idTicket = $_POST['id_ticketA'];
//     $ct = $_POST['comentarioTecnico'];

//     if (!empty($_POST['nroElevado'])){
//         $nroElevado = $_POST['nroElevado'];
//     }

    

//     if (isset($_POST['btnCerrar'])){

//         $estado = $_POST['cerrar'];

//     } elseif (isset($_POST['btnElevar'])){

//         $estado = $_POST['elevar']; 

//     }
    
   
//     $asignarTicket = $ticketObj->cambiarEstadoTicket($idTicket, $estado, $ct, $nroElevado) ;

//     if($asignarTicket) { 
//         $_SESSION['mensajes'] = "Cambio realizado con exito";
//         header('Location: mis-casos.php');
//         exit();
//     } 
//     else {

//         $_SESSION['mensajes'] = "Error";
//         header('Location: mis-casos.php');
//         exit();
//     }

  
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id_ticketA'])) {
  
    $idTicket = $_POST['id_ticketA'];
    $ct = $_POST['comentarioTecnico'];
    $nroElevado = !empty($_POST['nroElevado']) ? $_POST['nroElevado'] : null;

    if (isset($_POST['btnCerrar'])) {
        $estado = $_POST['cerrar'];
    } elseif (isset($_POST['btnElevar'])) {
        $estado = $_POST['elevar'];
    } else {
        // Manejo de estado no definido
        die("Error: Estado no definido");
    }

    // Cambiar el estado del ticket
    $asignarTicket = $ticketObj->cambiarEstadoTicket($idTicket, $estado, $ct, $nroElevado);

    if ($asignarTicket) {
        $mensaje = "Cambio realizado con éxito";
    } else {
        $mensaje = "Error";
    }

    // Establecer el mensaje y redirigir
    $_SESSION['mensajes'] = $mensaje;
    header('Location: mis-casos.php');
    exit();
}


?>
<div class=" container">

<div class="container  rounded-3 mt-5">
    <?php if (isset($_SESSION['mensajes']) ) { ?>
        <div id="mensaje" class="alert <?php echo $asignarTicket ? 'alert-danger' : 'alert-success'; ?>">
            <?php

if (isset($_SESSION['mensajes'])) {
  $mensaje = $_SESSION['mensajes'];
  echo $mensaje;
  unset($_SESSION['mensajes']); // Elimina el mensaje de la sesión para que no se muestre nuevamente

}
            
             
             ?>
        </div>
        <script>
            // Ocultar la alerta después de 5 segundos (5000 milisegundos)
            setTimeout(function() {
                var mensaje = document.getElementById('mensaje');
                if (mensaje) {
                    mensaje.style.display = 'none';
                }
            }, 6000);
        </script>
    <?php } ?>
</div>


<div class=" d-flex justify-content-start bg- p-3 bg-warning mt-5">

    <h2 class="text-center mx-3 fs-3 fw-bold titulos">Casos Asignados</h2>

</div>

<div class="border px-3 pb-3  mb-5">


<div class="table-responsive">
<?php if (!empty($ticketsA)) { ?>
    <table class="table table-bordered align-middle">
        <thead>
            <tr class="ticketeraTR">
                <th scope="col">Cerrar Ticket</th>
                <th scope="col">Elevar</th>
                <th scope="col">Nro Ticket</th>
                <th scope="col">Descripción Técnico</th>
                <th scope="col">Nro elevado</th>
                <th scope="col">Nro De Contacto</th>
                <th scope="col">Nombre y Apellido</th>
                <th scope="col">Fecha y Hora de Inicio</th>
                <th scope="col">Fecha y Hora de Cierre</th>
                <th scope="col">Tipo de Inconveniente</th>
                <th scope="col">Comentario del Solicitante</th>
                <th scope="col">Ubicación Laboral</th>

                <th scope="col">Posición Laboral</th>
                <th scope="col">Proveedor de Internet</th>

                <th scope="col">ID de Remote Desktop</th>
                
               
            </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php foreach ($ticketsA  as $ticket) : ?>
            <tr>


                <td class="text-center">
                    <form method="POST">
                        <input type="hidden" name="cerrar" value="Cerrado">
                        <input type="hidden" name="id_ticketA" value="<?php echo $ticket['id_ticket']; ?>">
                        <button type="submit" class="btn" style="color: blue;" name="btnCerrar">
                        <i class="fa-solid fa-xmark"></i>
                        </button>
                    
                </td>

                <td class="text-center">

                    <input type="hidden" name="elevar" value="Elevado">
                    <button type="submit" class="btn" style="color: blue;" name="btnElevar">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    </button>

                    </td>


                <td><?php echo $ticket['id_ticket']; ?></td>



                <td>

                
                    <div class="mb-3">
                    <textarea class="form-control" name="comentarioTecnico"  rows="4" required maxlength="255"></textarea>
                    </div>
                 
            
            
            
                </td>

                <td>

                <input type="text" name="nroElevado" class="form-control" maxlength="100">
                   
                </form>



                        </td>

                <td >
                    <?php
                if (!empty($ticket['nroContacto'])){
                
                echo $ticket['nroContacto']; 
                } else{
                    echo "No hay nro de Contacto";
                }
                ?>
                </td>

                <td ><?php echo $ticket['nombre'] . ' ' . $ticket['apellido']; ?></td>



                <td ><?php echo $ticket['fechaHora_inicio']; ?></td>
                <td><?php echo $ticket['fechaHora_cierre']; ?></td>
                <td><?php echo $ticket['tipo_inconveniente']; ?></td>

                <td><?php echo $ticket['comentario_solicitante']; ?></td>
                <td><?php echo $ticket['ubicacionLaboral']; ?></td>

                <td><?php echo $ticket['posicionLaboral']; ?></td>
                <td><?php echo $ticket['proveedorInternet']; ?></td>

                <td><?php echo $ticket['idRemoteDesktop']; ?></td>
            

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php } else { ?>
        
        <div class="d-flex justify-content-center align-items-center my-5">
        <h3>No hay ningun caso asignado</h3>
        </div>


        <?php  }; ?>
    </div>

    </div>







    <hr>




    <!-- -------------------------------------------------------------------------------------------------------------------------------------  -->

<!-- Ticketera -->




<div class=" d-flex justify-content-start p-3 bg-primary mt-5">

    <h2 class="text-center mx-3 fs-3 fw-bold titulos">Casos Elevados</h2>

</div>

<div class="border px-3 pb-3  mb-5">

<div class="table-responsive">
<?php if (!empty($ticketsE)) { ?>
    <table class="table table-bordered align-middle">
        <thead>
            <tr class="ticketeraTR">
                <th scope="col">Cerrar Ticket</th>
                <th scope="col">Nro Ticket</th>
                <th scope="col">Descripción Técnico</th>
                <th scope="col">Nro elevado</th>
                <th scope="col">Fecha y Hora de Inicio</th>
                <th scope="col">Fecha y Hora de Cierre</th>
                <th scope="col">Tipo de Inconveniente</th>
                <th scope="col">Comentario del Solicitante</th>
                <th scope="col">Ubicación Laboral</th>
 
                <th scope="col">Posición Laboral</th>
                <th scope="col">Proveedor de Internet</th>

                <th scope="col">ID de Remote Desktop</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php foreach ($ticketsE  as $ticket) : ?>
            <tr>


                <td class="text-center">
                    <form method="POST">
                        <input type="hidden" name="cerrar" value="Cerrado">
                        <input type="hidden" name="id_ticketA" value="<?php echo $ticket['id_ticket']; ?>">
                        <button type="submit" class="btn" style="color: blue;" name="btnCerrar">
                        <i class="fa-solid fa-xmark"></i>
                        </button>
                    
                </td>


                <td><?php echo $ticket['id_ticket']; ?></td>



                <td>

                
                    <div class="mb-3">
                    <textarea class="form-control" maxlength="255" name="comentarioTecnico"  rows="4" required><?php echo $ticket['descripcion_tecnico']; ?>  </textarea>
                    </div>
       
            
            
            
                </td>

                <td>

                
                <input type="text" name="nroElevado" class="form-control" value="<?php echo $ticket['nroElevado']; ?>" maxlength="60">
                   
                        </form>

                        </form>



                        </td>





                <td ><?php echo $ticket['fechaHora_inicio']; ?></td>
                <td><?php echo $ticket['fechaHora_cierre']; ?></td>
                <td><?php echo $ticket['tipo_inconveniente']; ?></td>

                <td><?php echo $ticket['comentario_solicitante']; ?></td>
                <td><?php echo $ticket['ubicacionLaboral']; ?></td>
     
                <td><?php echo $ticket['posicionLaboral']; ?></td>
                <td><?php echo $ticket['proveedorInternet']; ?></td>

                <td><?php echo $ticket['idRemoteDesktop']; ?></td>
 

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php } else { ?>
        
        <div class="d-flex justify-content-center align-items-center my-5">
        <h3>No hay ningun caso elevado</h3>
        </div>


        <?php  }; ?>
        </div>
    
        </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    </div>
  
    
<?php 

require_once("includes/footer.php");
?>
