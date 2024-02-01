
<?php 

require_once("includes/header.php");
require_once '../classes/Ticket.php';

$ticketObj = new Ticket();

$idTecnico = $empleadoActual['id_empleado'];
$tickets = $ticketObj->getTicketsSinAsignar();





// Logica Asociar ticket a tecnico 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['id_ticket'])) {

    $idTicket = $_POST['id_ticket'];
    
   
    $asignarTicket = $ticketObj->asociarTicketaTecnico($idTicket, $idTecnico) ;

    if($asignarTicket) { 
        $_SESSION['mensajes'] = "Ticket Asignado con exito";
        header('Location: mis-casos.php');
        exit();
    } else {

        $_SESSION['mensajes'] = "Ya se asigno un tecnico al caso";
        header('Location: ticketera.php');
        exit();
    }
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



<div class=" d-flex align-items-center">
    <hr class="flex-grow-1">
    <h2 class="text-center mx-3 fs-3 fw-bold titulos">Ticketera</h2>
    <hr class="flex-grow-1">
</div>


<div class="p-3 rounded-3 mb-5 border">


<!-- Ticketera -->




<div class="table-responsive">
<?php if ($tickets != null) { ?>



    <table class="table table-bordered align-middle">
    <thead>
    
    <tr class="ticketeraTR">
  <th scope="col">Asignar</th>
  <th scope="col">NroTicket</th>
  <th scope="col">Nombre Apellido</th>
  <th scope="col">Fecha y Hora de Pedido</th>
  <th scope="col">Tipo de Inconveniente</th>
  <th scope="col">Comentario del Solicitante</th>
  <th scope="col">Ubicación Laboral</th>
  <th scope="col">Agente Gestionando</th>

</tr>
  </thead>
        <tbody class="table-group-divider">
        
        <?php foreach ($tickets as $ticket) : ?>
            <tr>
                <td class="text-center">
                    <form method="POST" action="ticketera.php">
                        <input type="hidden" name="id_ticket" value="<?php echo $ticket['id_ticket']; ?>">
                        <button type="submit" class="btn" style="color: blue;">
                        <i class="fa-solid fa-check"></i>
                        </button>
                    </form>
                </td>

              
                <td ><?php echo $ticket['id_ticket']; ?></td>
                <td ><?php echo $ticket['nombre'] . ' ' . $ticket['apellido']; ?></td>
                <td ><?php echo $ticket['fecha_hora_pedido']; ?></td>
                <td ><?php echo $ticket['tipo_inconveniente']; ?></td>
                <td><?php echo $ticket['comentario_solicitante']; ?></td>
                <td><?php echo $ticket['ubicacionLaboral']; ?></td>
                <td><?php echo $ticket['estado_gestion_agente'] ? 'Sí' : 'No'; ?></td>

                
            </tr>
        <?php endforeach; ?>
            
        </tbody>


        
    </table>

    <?php } else { ?>
        
        <div class="d-flex justify-content-center align-items-center my-5">
        <h3>No hay Tickets por el momento...</h3>
        </div>


        <?php  }; ?>
    </div>

    </div>
    


<hr>
<!-- -------------------------------------------------------------------------------------------------------------------------------------  -->

    
    
    
    <script>

        // Esta función refrescará la página cada 10 segundos (10000 milisegundos).
function refrescarPagina() {
    location.reload();
}

// Establecemos un temporizador que ejecutará la función cada 10 segundos.
setInterval(refrescarPagina, 10000);
    </script>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    </div>
  
    
<?php 

require_once("includes/footer.php");
?>
