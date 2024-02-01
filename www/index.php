

<?php 

require_once("./includes/header.php");
require_once("./classes/Empleado.php");

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
                    <li><a class="text-decoration-none text-primary"  href="./mi-perfil.php">Mi Perfil - Editar Informacion</a></li>
                    <li><a class="text-decoration-none text-primary" href="./herramientas.php">Herramientas</a></li>
                    <li><a class="text-decoration-none text-primary" href="./estado-ticket.php">Tickets Enviados</a></li>
                    <li><a class="text-decoration-none text-primary" href="./asistencia-tecnica.php">Asistencia Tecnica</a></li>
                    
                    <li><a class="text-decoration-none text-primary" href="./index.php?logout=true">Cerrar Sesión</a></li>
                    

                </ul>

                </div>

               
              
            </div>
        </div>
    </div>
</div>



<?php 

require_once("./includes/footer.php");
?>
