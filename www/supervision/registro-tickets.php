<?php 

require_once("includes/header.php");
require_once '../classes/Ticket.php';
require_once '../classes/Empleado.php';

$ticketObj = new Ticket();
$EmpleadoObj = new Empleado();


$estadoTicketeraSA = $ticketObj->getCountTicketEnviados();
$estadoTicketeraA = $ticketObj->getCountTicketAtendidos();
$estadoTicketeraE = $ticketObj->getCountTicketElevados();

if (!empty($_POST['busqueda'])) {
    $termino_busqueda = $_POST['busqueda'];
    $resulBusqueda = $ticketObj->searchTicket($termino_busqueda);
} else {
    // Si no se ha realizado una búsqueda, muestra todos los tickets.
    $resulBusqueda = $ticketObj->getAllTickets();
}



?>
<div class="d-flex justify-content-start mt-2 container">
    
           
    <button class="btn btn-info" type="submit" name="btnActualizar" id="btnActualizar" onclick="actualizarBtn()">Actualizar estado</button>

</div>
<script>

function actualizarBtn() {
 
    
    // Recargamos la página
    location.reload();

}
</script>
<div class="container border border-dark my-4 rounded-3 ">


<div class="row p-2 d-flex justify-content-center">

<div class="col-4 text-center">
<p class="m-0">Ticket enviados sin atender: <strong class="font-weight-bold"><?php echo $estadoTicketeraSA ?></strong></p>
</div>


<div class="col-4 text-center">
<p class="m-0">Ticket enviados atendidos: <strong class="font-weight-bold"><?php echo $estadoTicketeraA ?></strong></p>
</div>

<div class="col-4 text-center">
<p class="m-0">Ticket enviados elevados: <strong class="font-weight-bold"><?php echo $estadoTicketeraE ?></strong></p>

</div>


</div>

</div>

<div class="container mt-5 border border-dark">




<div class="container border p-2 d-flex justify-content-between mt-2">

<form class="d-flex" method="POST">
    <div class="d-flex">
        <input class="form-control me-2" type="search" name="busqueda" placeholder="Buscar" aria-label="Search" value="<?php echo isset($_POST['busqueda']) ? $_POST['busqueda'] : ''; ?>">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
    </div>
</form>


 
</div>
<?php if (!empty($resulBusqueda)) { ?>
<div class="table-responsive">

    <table class="table table-bordered table-hover align-middle">
        <thead>
        <tr class="ticketeraTR">
                <th scope="col">Nro Ticket</th>
                <th scope="col">Tecnico asignado</th>
                <th scope="col">Estado de Resolución</th>
                <th scope="col">Fecha y Hora de Pedido</th>
                <th scope="col">Fecha y Hora de Inicio</th>
                <th scope="col">Fecha y Hora de Cierre</th>
                <th scope="col">Descripción Técnico</th>
                <th scope="col">DNI Empleado</th>

                <th scope="col">Tipo de Inconveniente</th>
                <th scope="col">Comentario del Solicitante</th>
                <th scope="col">Ubicación Laboral</th>
                
                <th scope="col">Agente Gestionando</th>
                <th scope="col">Posición Laboral</th>
                <th scope="col">Proveedor de Internet</th>
                <th scope="col">ID de Remote Desktop</th>
                <th scope="col">Campaña</th>
                <th scope="col">Jerarquia</th>
                
            </tr>
        </thead>
        <tbody>
        <?php 
        
        foreach ($resulBusqueda as $ticket) : 
            ?>
            <tr>

            
                <td><?php echo $ticket['id_ticket']; ?></td>

                <td><?php 


                
                if (!empty($ticket['fk_id_tecnico'])) {
                    $i = $ticket['fk_id_tecnico'];
                    $infoTecnico = $EmpleadoObj->buscarEmpleadoID($i);  
                    echo $infoTecnico['nombre'];
                } else {
                    echo  "Sin tecnico asignado";
                }



                ?></td>

                    <td><?php echo $ticket['estado_resolucion']; ?></td>    
                    <td><?php echo $ticket['fecha_hora_pedido']; ?></td>
                <td><?php echo $ticket['fechaHora_inicio']; ?></td>
                <td><?php echo $ticket['fechaHora_cierre']; ?></td>
                <td><?php echo $ticket['descripcion_tecnico']; ?></td>
                <td><?php echo $ticket['nroDNI']; ?></td>
                <td><?php echo $ticket['tipo_inconveniente']; ?></td>
                <td><?php echo $ticket['comentario_solicitante']; ?></td>
                <td><?php echo $ticket['ubicacionLaboral']; ?></td>
               
                <td><?php echo $ticket['estado_gestion_agente'] ? 'Sí' : 'No'; ?></td>
                <td><?php echo $ticket['posicionLaboral']; ?></td>
                <td><?php echo $ticket['proveedorInternet']; ?></td>
                <td><?php echo $ticket['idRemoteDesktop']; ?></td>
                <td><?php echo $ticket['nombreDepartamento']; ?></td>
                <td><?php echo $ticket['rol']; ?></td>
               
            </tr>
        <?php endforeach; ?>

        <?php } else { ?>


            <div class="d-flex justify-content-center vh-100 align-items-center">
                <i class="fa-solid fa-magnifying-glass fa-9x"></i>
                <h3>No se datos con esas caracteristicas</h3>
                </div>


            <?php }   ?>
            
         
          
        </tbody>
    </table>



</div>
</div>
<?php 

require_once("includes/footer.php");
?>