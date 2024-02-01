<?php
require_once("includes/header.php");
require_once("../classes/Empleado.php");

// Crear una instancia de la clase Empleado
$EmpleadoObj = new Empleado();


// Foreach tabla empleados
if (!empty($_POST['busqueda'])) {
    $termino_busqueda = $_POST['busqueda'];
    $resulBusqueda = $EmpleadoObj->buscarEmpleado($termino_busqueda);
} else {
    // Si no se ha realizado una búsqueda, muestra todos los tickets.
    $resulBusqueda = $EmpleadoObj->getEmpleados();
}





//Deshabilitar empleado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deshabilitar'])) {
    $id_empleado = $_POST['id_empleado'];
    // Llama al método eliminarEmpleado con $id_empleado para eliminar al empleado
    $EmpleadoObj->deshabilitarEmpleado($id_empleado);

    // Redirige a la misma página
    header("Location: empleados.php");
    exit; 

}


//habilitar empleado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['habilitar'])) {
    $id_empleado = $_POST['id_empleado'];
    // Llama al método eliminarEmpleado con $id_empleado para eliminar al empleado
    $EmpleadoObj->habilitarEmpleado($id_empleado);

    // Redirige a la misma página
    header("Location: empleados.php");
    exit; 
}






?>

<div class="container d-flex align-items-center mt-5">
    <hr class="flex-grow-1">
    <h2 class="text-center mx-3 fs-3 fw-bold titulos">Empleados</h2>
    <hr class="flex-grow-1">
</div>



<div class="container rounded-3 mt-5">
    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-success" id="mensaje">
            <?php 
            $mensaje = $_SESSION['mensaje'];
            echo $mensaje;
            unset($_SESSION['mensaje']);
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


<div class="container border rounded-3 p-2 d-flex justify-content-between">
   
<form class="d-flex"  method="POST" >

    
        <div class="d-flex">
       
            <input class="form-control me-2" type="search" name="busqueda" placeholder="Buscar" aria-label="Search" value="<?php echo isset($_POST['busqueda']) ? $_POST['busqueda'] : ''; ?>">
            <button class="btn btn-outline-success" type="submit">Buscar</button>

        </div>
</form>
 
</div>

<div class="container mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Usuario</th>
                <th scope="col">Nro. de Contacto</th>
                <th scope="col">Mail</th>
                <th scope="col">Usuario de Campaña</th>
                <th scope="col">DNI</th>
                <th scope="col">Departamento</th>
                <th scope="col">Jerarquia</th>
                <th scope="col" class="text-center">Editar Datos</th>
                <th scope="col" class="text-center">Estado</th>

            </tr>
        </thead>
        <tbody>
        <?php foreach ($resulBusqueda as $empleado) : ?>

        <?php             ?>
    <tr>
        <td <?php if (!$empleado['activo']) echo 'style="text-decoration: line-through;"'; ?>>
            <?php echo $empleado['nombre']; ?>
        </td>
        <td <?php if (!$empleado['activo']) echo 'style="text-decoration: line-through;"'; ?>>
            <?php echo $empleado['apellido']; ?>
        </td>
        <td <?php if (!$empleado['activo']) echo 'style="text-decoration: line-through;"'; ?>>
            <?php echo $empleado['usuario']; ?>
        </td>
        <td <?php if (!$empleado['activo']) echo 'style="text-decoration: line-through;"'; ?>>
            <?php echo $empleado['nroContacto']; ?>
        </td>
        <td <?php if (!$empleado['activo']) echo 'style="text-decoration: line-through;"'; ?>>
            <?php echo $empleado['mail_laboral']; ?>
        </td>
        <td <?php if (!$empleado['activo']) echo 'style="text-decoration: line-through;"'; ?>>
            <?php echo $empleado['usuarioCampana']; ?>
        </td>
        <td <?php if (!$empleado['activo']) echo 'style="text-decoration: line-through;"'; ?>>
            <?php echo $empleado['nroDNI']; ?>
        </td>

        <td <?php if (!$empleado['activo']) echo 'style="text-decoration: line-through;"'; ?>>
            <?php echo $empleado['nombreDepartamento']; ?>
        </td>
        <td <?php if (!$empleado['activo']) echo 'style="text-decoration: line-through;"'; ?>>
             <?php echo $empleado['rol']; ?>
        </td>
                <td class="text-center">
                                <form action="./editar-usuario.php" method="GET">
                                <input type="hidden" name="id_empleado" value="<?php echo $empleado['id_empleado']; ?>">
                                <button type="submit" class="btn btn-link" style="color: blue;">
                                <i class="fa-solid fa-pen"></i>
                                </button>
                            
                                </form>    
                </td>
        <td>
        <form method="post" action="empleados.php" >
                <div class="text-center">
                    <input type="hidden" name="id_empleado" value="<?php echo $empleado['id_empleado']; ?>">
                    <?php if (!$empleado['activo']) : ?>
                        <button type="submit" name="habilitar" class="btn btn-link" style="color: red;">
                            <i class="fa-solid fa-xmark fa-xl"></i>
                        </button>
                    <?php else: ?>
                        <button type="submit" name="deshabilitar" class="btn btn-link" style="color: green;">
                            <i class="fa-solid fa-check fa-xl"></i>
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </td>
    </tr>
<?php endforeach; ?>

</tbody>

    </table>




</div>


<?php 

require_once("includes/footer.php");
?>
