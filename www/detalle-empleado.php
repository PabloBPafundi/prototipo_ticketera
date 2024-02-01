<?php 

require_once("./includes/header.php");
require_once("./classes/Empleado.php");
require_once("./classes/Calificacion.php");

// Crear una instancia de la clase Empleado
$empleadoObj = new Empleado();

$calificacionObj = new Calificacion();

if (isset($_GET['usuario']) && !empty($_GET['usuario'])) {

  if ($_GET['usuario'] == $empleadoActual['usuario']) {

    header('Location: ./mi-perfil.php'); 
  
} else {
  $usuario = $_GET['usuario'];

  $empleadoDetalle = $empleadoObj->usuarioEmpleados($usuario);

  $id = $empleadoDetalle['id_empleado'];

  $empleadoCal = $calificacionObj->obtenerCalificacion($id);;
  
}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnEnviar'])) {
  $comentario = $_POST['comentario'];
  $calificacion = $_POST['calificacion'];

  if (empty($calificacion)) {
      $errorCalificacion = "La calificación es obligatoria";
  } elseif (!is_numeric($calificacion) || $calificacion < 1 || $calificacion > 5) {
      $errorCalificacion = "La calificación debe estar en el rango de 1 a 5.";
  } else {
      $fk_id_empleado_calificado = $empleadoDetalle['id_empleado'];
      $fk_id_empleado_calificador = $empleadoActual['id_empleado'];

      // Llama al método para insertar la calificación (incluyendo la verificación de calificación duplicada)
      $calificacionExitosa = $calificacionObj->insertarCalificacion($comentario, $calificacion, $fk_id_empleado_calificado, $fk_id_empleado_calificador);

      if ($calificacionExitosa) {
          $_SESSION['mensajes'] = "Calificación enviada con éxito";
          $u = $empleadoDetalle['usuario'];
          header("Location: ./detalle-empleado.php?usuario=$u");
          exit;
      } else {
          $errorCalificacion = "Ya has calificado a este empleado en los últimos 30 días.";
      }
  }
}

?>

<?php 
if (!empty($empleadoDetalle)) {
  ?>




<main class="container">




<div class="container  rounded-3 mt-5">
    <?php if (isset($_SESSION['mensajes']) ) { ?>
        <div id="mensaje" class="alert <?php echo $cambioExitoso ? 'alert-danger' : 'alert-success'; ?>">
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


<div class="card mb-3 mt-3">
  <div class="row g-0">

  
    <div class="col-md-4 d-flex justify-content-center">
    <i class="fa-solid fa-user-tie fa-10x p-5"></i>
    </div>


    <div class="col-md-8">
      <div class="card-body row">
        <div class="card-title col-10 border-bottom">
        <h1 class="card-title">
        <?php 
            echo  $empleadoDetalle['nombre'] ." " . $empleadoDetalle['apellido'] ;
            
            ?>
       
        </h1>
        </div>
        <div class="">
          <h2 class="fs-4">Usuario</h2>
          <p>
          <?php 
            echo  $empleadoDetalle['usuario'] ;
            
            ?>
            </p>
        </div>

        <div class="mt-5 col-12 d-flex justify-content-end" >
        <button class="btn btn-warning" id="calificarButton">Calificar</button>
        </div>
        
      </div>
    </div>
  </div>
</div>




     
          <!-- Formulario oculto para calificar -->
          <div id="calificarForm" style="display: none; " >
          <div class="container d-flex justify-content-end">
          <form method="POST"  class="col-8" novalidate>

<div class="border border-dark row d-flex justify-content-center rounded-4 p-4 row">

    <div class="row col-8">

        <div class="form-floating mb-3 col-12">
    <input type="number" class="form-control" id="floatingInput" placeholder="name@example.com" name="calificacion" required min="1" max="5" step="1">
    <label for="floatingInput">Calificación (de 1 a 5)</label>
</div>

  
    </div>

    <div class="col-4 d-flex justify-content-end align-items-end">
        <button type="submit" class="btn btn-success mx-1" name="btnEnviar">Enviar</button>
        <button type="button" class="btn btn-info" id="cancelar">Cancelar</button>
    </div>
</div>

</form>

            </div>
          </div>

 <!-- Mensaje de error si el campo "calificacion" está vacío -->
<?php if (isset($errorCalificacion)) : ?>
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <?php echo $errorCalificacion; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<script>

// JavaScript para mostrar/ocultar el formulario de calificación
const calificarButton = document.getElementById("calificarButton");
const calificarForm = document.getElementById("calificarForm");
const cancelarCalificarButton = document.getElementById("cancelar");

calificarButton.addEventListener("click", function() {
  calificarForm.style.display = "block";
});

cancelarCalificarButton.addEventListener("click", function() {
  calificarForm.style.display = "none";
});


</script>


<h2 class="mt-5">Calificaciones de  <?php echo  $empleadoDetalle['nombre'] ;?> </h2>
<hr>


<div class="row d-flex justify-content-center">




<?php foreach ($empleadoCal as $resulCali) : ?>
  <div class="card col-3 m-3">
    
    <div class="card-body">
      <h5 class="card-title"><?php echo  $resulCali['calificacion']; ?></h5>
      <p class="card-text"><?php echo  $resulCali['comentario']; ?></p>
      <p class="card-text"><small class="text-body-secondary"><?php echo  $resulCali['fecha_creacion']; ?></small></p>
    </div>
  </div>


  <?php endforeach; ?>

  




</div>


</main>




<?php 
}else {

  ?>

  <div class="d-flex justify-content-center vh-100 align-items-center">
  <i class="fa-solid fa-magnifying-glass fa-9x"></i>
  <h3>No se encontraron empleados con ese usuario</h3>
  </div>
<?php
}
?>











<?php 

require_once("./includes/footer.php");
?>
