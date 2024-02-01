<?php 

require_once("includes/header.php");
require_once '../classes/Ticket.php';

?>







<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                <h3 class="card-title">Bienvenid@!</h3>
                    <p class="card-text fs-4"><?php echo $empleadoActual['nombre'] . " " . $empleadoActual['apellido']; ?></p>

<hr>

                    <ul >
                    <li><a class="text-decoration-none text-primary" href="./registro-tickets.php">Registro de Tickets</a></li>
                    <li><a class="text-decoration-none text-primary" href="./empleados.php">Empleados</a></li>
                    <li><a class="text-decoration-none text-primary" href="./mis-casos.php">Mis Casos</a></li>

                    <li><a class="text-decoration-none text-primary" href="./ticketera.php">Ticketera</a></li>
                    
                    <li><a class="text-decoration-none text-primary" href="./index.php?logout=true">Cerrar Sesión</a></li>
                    

                </ul>

                </div>
       
              
            </div>
        </div>
    </div>
</div>



    
<?php 

require_once("includes/footer.php");
?>
