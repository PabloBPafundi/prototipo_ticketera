<?php 
//Para pruebas Asignar al menos fk_id_tecnico y estado para que no se rompa el codigo
require_once("./includes/header.php");
require_once './classes/Ticket.php';

$ticketObj = new Ticket();

$idEmpleado = $empleadoActual['id_empleado'];

$ticketsAbiertos = $ticketObj->getTicketabiertos($idEmpleado);
$tCerrados = $ticketObj->getTicketCerrado($idEmpleado);

// $registrosPorPagina = 1; // Define la cantidad de registros por página

// // Obtiene el número de página actual
// $pagina = isset($_GET['page']) ? $_GET['page'] : 1;


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnCerrar'])) {
      $idTicket = $_POST['id_ticket'];
 

    
    $resul= $ticketObj->cambiarEstadoSolucionado($idTicket);
    if($resul) { 
        header('Location: estado-ticket.php');
        exit();
    } else {

        $mensajeError = "Ya se asigno un tecnico al caso";
    }

}


?>


<div class="container my-5 rounded-3">








<?php if (isset($_SESSION['mensaje'])) { ?>
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <?php 
        $mensaje = $_SESSION['mensaje'];
        echo $mensaje;
        unset($_SESSION['mensaje']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } elseif (isset($mensajeError)) {  ?>

    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">

    <?php echo  $mensajeError; ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>










<div class="container d-flex align-items-center mt-5">
    <hr class="flex-grow-1">
    <h2 class="text-center mx-3 fs-3 fw-bold titulos">Ticket en Curso</h2>
    <hr class="flex-grow-1">
</div>

<?php if (!empty($ticketsAbiertos)) : ?>

    <div class="d-flex justify-content-start">
    
           
            <button class="btn btn-info" type="submit" name="btnActualizar" id="btnActualizar" onclick="actualizarBtn()">Actualizar estado</button>
    
    </div>
    <script>

        function actualizarBtn() {
         
            
            // Recargamos la página
            location.reload();

        }
    </script>

<?php foreach ($ticketsAbiertos  as $infoTicket) : ?>

<div class="border border-dark p-2 my-3 rounded-3">

<!-- Nro de ticket -->
<div class="d-flex justify-content-between py-3">
<h2 class="">Nro de Ticket: <?php echo $infoTicket['id_ticket']  ?> </h2>



<?php if ($infoTicket['estado_resolucion'] == "Enviado") { ?>
<form method="POST"  >
<input type="text" hidden value="<?php echo $infoTicket['id_ticket']  ?>" name="id_ticket">
<button class="btn btn-warning" type="submit" name="btnCerrar">Solucione Incoveniente - Cerrar Ticket</button>
</form>
<?php }  ?>
</div>





<!-- Estado enviado  -->
<?php if ($infoTicket['estado_resolucion'] == "Enviado") { ?> 

<div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
  <div class="progress-bar bg-success" style="width: 25%">Ticket Enviado</div>
</div>

<div class="row mt-4">

<div class="col-4">
<p>Fecha y hora envio de Ticket: <strong class="font-weight-bold"><?php echo $infoTicket['fecha_hora_pedido'] ?></strong></p>

</div>

</div>









<!-- Estado en proceso  -->
<?php } elseif ($infoTicket['estado_resolucion'] == "En proceso") {
$infoTicketA = $ticketObj->actualizarInfoTicket($infoTicket['id_ticket']);      
?>

<div class="progress" role="progressbar" aria-label="Info example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
  <div class="progress-bar bg-info text-dark" style="width: 50%">Ticket atendido</div>
</div>


<div class="row mt-4">

<div class="col-6">
<p>Nombre de Tecnico asignado: <strong class="font-weight-bold"><?php echo $infoTicketA['nombre'] ?></strong></p>
</div>

<div class="col-6">
<p>Fecha y hora envio de Ticket: <strong class="font-weight-bold"><?php echo $infoTicketA['fecha_hora_pedido'] ?></strong></p>

</div>

<div class="col-6">
<p>Fecha y hora de Ticket atendido: <strong class="font-weight-bold"><?php echo $infoTicketA['fechaHora_inicio'] ?></strong></p>
</div>

</div>

<!-- Estado enviado  -->
<?php } elseif ($infoTicket['estado_resolucion'] == "Elevado") {
$infoTicketA = $ticketObj->actualizarInfoTicket($infoTicket['id_ticket']);      
?>
<div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
  <div class="progress-bar bg-warning text-dark" style="width: 75%">Ticket elevado</div>
</div>

<div class="row mt-3">

<div class="col-6">
<p>Nombre de Tecnico asignado: <strong class="font-weight-bold"><?php echo $infoTicketA['nombre'] ?></strong></p>
</div>


<div class="col-6">
<p>Nro de ticket Elevado: <strong class="font-weight-bold"><?php echo $infoTicketA['nroElevado'] ?></strong></p>
</div>

<div class="col-6">
<p>Fecha y hora envio de Ticket: <strong class="font-weight-bold"><?php echo $infoTicketA['fecha_hora_pedido'] ?></strong></p>

</div>

<div class="col-6">
<p>Fecha y hora de Ticket atendido: <strong class="font-weight-bold"><?php echo $infoTicketA['fechaHora_inicio'] ?></strong></p>
</div>


</div>




<?php } ?>
</div>
<?php endforeach; ?>



<?php else : ?>
    <div class="d-flex justify-content-center my-5">
        <i class="fa-solid fa-magnifying-glass fa-5x"></i>
        <h3>No hay ticket abiertos actualmente</h3>
    </div>
<?php endif; ?>









<!-- Ticket cerrados -->
    <div class="container d-flex align-items-center pt-5">
    <hr class="flex-grow-1">
    <h2 class="text-center mx-3 fs-3 fw-bold titulos">Ticket cerrados</h2>
    <hr class="flex-grow-1">
    </div>



<div class="table-responsive container">
<table class="table table-striped">
        <thead>
            <tr class="ticketeraTR">
                <th scope="col">Nro Ticket</th>
                <th scope="col">Nro Elevado</th>
                <th scope="col">Fecha y Hora Pedido</th>
                <th scope="col">Fecha y Hora Asignado</th>
                <th scope="col">Fecha y Hora Cerrado</th>
                <th scope="col">Tecnico</th>
                
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($tCerrados)) : ?> 
    <?php foreach ($tCerrados as $tc) : ?>
        <tr>
            <td>
                <?php echo $tc['id_ticket']; ?>
            </td>
            <td>
                <?php echo ($tc['nroElevado'] !== null) ? $tc['nroElevado'] : '-'; ?>
            </td>
            <td>
                <?php echo $tc['fecha_hora_pedido']; ?>
            </td>
            <td>
                <?php echo $tc['fechaHora_inicio']; ?>
            </td>
            <td>
                <?php echo $tc['fechaHora_cierre']; ?>
            </td>
            <td>
                <?php echo $tc['nombre_tecnico']; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>

    </table>










<?php 

require_once("./includes/footer.php");





?>