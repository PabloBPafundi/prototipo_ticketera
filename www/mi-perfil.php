<?php 

require_once("./includes/header.php");
require_once("./classes/Empleado.php");
require_once './classes/Departamento.php';
require_once './classes/Jerarquia.php';

// Crear una instancia de clase 
$empleado = new Empleado();
$departamentoObj = new Departamento();
$jerarquiaObj = new Jerarquia();

$perfilEmpleadoActual = $empleado->getEmpleado($empleadoActual['usuario']);


$puestoEmpleado = $empleado->getEmpleadoDepartamentoJerarquia($empleadoActual['usuario']);




if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnEditarDatos'])) {

    $nroDNI = $_POST['nroDNI'];
    $nroContacto = $_POST['nroContacto'];
    $mailLaboral = $_POST['mailLaboral'];
    $departamento = $_POST['departamento'];
    $jerarquia = $_POST['jerarquia'];
    $usuarioCampana = $_POST['usuarioCampana'];




   
   
    $valueDepartamento = $departamentoObj->obtenerDepartamentoID($departamento);
    $valuejerarquia = $jerarquiaObj->obtenerJerarquiaID($jerarquia);


    
            // Editar empleado en la base de datos
            $editExitoso = $empleado->editarEmpleado($perfilEmpleadoActual['id_empleado'], $nroDNI, $nroContacto , $mailLaboral, $valueDepartamento, $valuejerarquia, $usuarioCampana);


         
           if ($editExitoso) {
                // Almacena el mensaje en una variable de sesión
                $_SESSION['mensaje'] = "Perfil editado con éxito";
                header("Location: mi-perfil.php");
                exit; 
            } 
            else {
                // En caso de error
                $mensaje = "Error al editar el perfil";
            }
        
    

}


?>


<main class="container">


<div class="container  rounded-3 mt-5">
    <?php if (isset($_SESSION['mensaje']) ) { ?>
        <div id="mensaje" class="alert <?php echo $editExitoso ? 'alert-danger' : 'alert-success'; ?>">
            <?php

if (isset($_SESSION['mensaje'])) {
  $mensaje = $_SESSION['mensaje'];
  echo $mensaje;
  unset($_SESSION['mensaje']); // Elimina el mensaje de la sesión para que no se muestre nuevamente

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
              <?php echo $perfilEmpleadoActual['nombre'] . " " . $perfilEmpleadoActual['apellido']; ?>
            </h1>
          </div>



          <div class="row g-3">


             <div class="col-4">
            <h2 class="fs-6">Usuario</h2>
            <p>
                <?php echo $perfilEmpleadoActual['usuario']; ?>
            </p>
        </div>

        <div class="col-4">
            <h2 class="fs-6">DNI</h2>
            <p>
                <?php echo $perfilEmpleadoActual['nroDNI']; ?>
            </p>
        </div>


        <div class="col-4">
            <h2 class="fs-6">Número de Contacto</h2>
            <p>
                <?php echo $perfilEmpleadoActual['nroContacto']; ?>
            </p>
        </div>


        <div class="col-4">
            <h2 class="fs-6">Mail Laboral</h2>
            <p>
                <?php echo $perfilEmpleadoActual['mail_laboral']; ?>
            </p>
        </div>


        <div class="col-4">
            <h2 class="fs-6">Departamento</h2>
            <p>
                <?php echo $puestoEmpleado['nombreDepartamento']; ?>
            </p>
        </div>

        


        <div class="col-4">
            <h2 class="fs-6">Jerarquia</h2>
            <p>
                <?php echo $puestoEmpleado['rol']; ?>
            </p>
        </div>

        <div class="col-4">
            <h2 class="fs-6">Usuario de Campaña</h2>
            <p>
                <?php echo $perfilEmpleadoActual['usuarioCampana']; ?>
            </p>
        </div>







          </div>

          <div class="mt-5 col-12 d-flex justify-content-end">
          <button class="btn btn-info" id="btnDisplayEditForm">Editar informacion</button>

            </div>

          
        </div>
      </div>
    </div>
  </div>




     <!-- Formulario oculto para editar datos -->
     <div id="editarPerfilForm" class="bg-warning p-3 rounded-3" style="display: none">
    


   <form action="mi-perfil.php" class="needs-validation" method="POST" novalidate>
        <div class="row container d-flex justify-content-center g-3 py-3">


            <div class="form-floating mb-3 col-6">
                <input type="text" class="form-control rounded-4" id="DNIInput" placeholder="Nro de DNI" name="nroDNI" value="<?php  echo $perfilEmpleadoActual['nroDNI']; ?>" maxlength="20" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                <label for="DNIInput">Nro de DNI</label>
                <div class="invalid-feedback">Por favor, ingrese un número de DNI válido.</div>
            </div>


            <div class="form-floating mb-3 col-6">
                <input type="text" class="form-control rounded-4" id="usuarioCampanaInput" placeholder="Nro de DNI" name="usuarioCampana" value="<?php  echo $perfilEmpleadoActual['usuarioCampana']; ?>" maxlength="20" required>
                <label for="usuarioCampanaInput">Usuario de Campaña</label>
                <div class="invalid-feedback">Por favor, ingrese un número de usuario válido.</div>
            </div>



            <div class="form-floating mb-3 col-6">
                <input type="email" class="form-control rounded-4" id="MailInput" placeholder="nombre@ejemplo.com" name="mailLaboral" value="<?php  echo $perfilEmpleadoActual['mail_laboral']; ?>" maxlength="65" required>
                <label for="MailInput">Correo Laboral</label>
                <div class="invalid-feedback">Por favor, ingrese una dirección de correo válida.</div>
            </div>


            <div class="form-floating mb-3 col-6">
                <input type="text" class="form-control rounded-4" id="NroContactoInput" placeholder="Nro de DNI" name="nroContacto" value="<?php  echo $perfilEmpleadoActual['nroContacto']; ?>" maxlength="30" required>
                <label for="NroContactoInput">NroContacto</label>
                <div class="invalid-feedback">Por favor, ingrese un número de contacto válido.</div>
            </div>

      




            <div class="form-floating col-6">



        <select class="form-select" id="departamentoID" aria-label="Floating label select example" name="departamento">
            <option  disabled value="">Seleccionar...</option>
        <optgroup label="Teco">
            <option value="Sin campaña" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'Sin campaña') ? 'selected' : ''; ?>>Sin campaña</option>
            <option value="Retencion Movil" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'Retencion Movil') ? 'selected' : ''; ?>>Retención Móvil</option>
            <option value="Retencion Fija" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'Retencion Fija') ? 'selected' : ''; ?>>Retención Fija</option>
            <option value="Ventas OUT" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'Ventas OUT') ? 'selected' : ''; ?>>Ventas OUT</option>
            <option value="Ventas IN" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'Ventas IN') ? 'selected' : ''; ?>>Ventas IN</option>
            <option value="HBO" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'HBO') ? 'selected' : ''; ?>>HBO</option>
            <option value="Star" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'Star') ? 'selected' : ''; ?>>Star</option>
            <option value="Adultos" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'Adultos') ? 'selected' : ''; ?>>Adultos</option>
        </optgroup>
        <optgroup label="Clarín">
            <option value="Retencion Clarín 365" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'Retencion Clarín 365') ? 'selected' : ''; ?>>Retención Clarín 365</option>
            <option value="Clarín 365" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'Clarín 365') ? 'selected' : ''; ?>>Clarín 365</option>
        </optgroup>
        <optgroup label="Otras Campañas">
            <option value="Zurich" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'Zurich') ? 'selected' : ''; ?>>Zurich</option>
            <option value="Pfizer" <?php echo ($puestoEmpleado['nombreDepartamento'] == 'Pfizer') ? 'selected' : ''; ?>>Pfizer</option>
        </optgroup>
    </select>
            <label for="departamentoID">Departamento</label>
            <div class="invalid-feedback">Por favor, ingrese una valor valido</div>
            </div>



            <div class="form-floating col-6">
            <select class="form-select" id="jerarquiaID" aria-label="Floating label select example" name="jerarquia">
            <option  disabled value="">Seleccionar...</option>
            <option value="S/ Rol"<?php echo ($puestoEmpleado['rol'] == "S/ Rol") ? 'selected' : ''; ?>>S/ Rol</option>
            <option value="Ejecutivo de Ventas"<?php echo ($puestoEmpleado['rol'] == 'Ejecutivo de Ventas') ? 'selected' : ''; ?>>Ejecutivo de Ventas</option>
            <option value="TeamLeader Ventas"<?php echo ($puestoEmpleado['rol'] == 'TeamLeader Ventas') ? 'selected' : ''; ?>>TeamLeader Ventas</option>
            </select>

            <label for="jerarquiaID">Jerarquia</label>
            <div class="invalid-feedback">Por favor, ingrese una valor valido</div>
            </div>




        <div class="d-flex justify-content-start">
           
            <button type="submit" class="btn btn-success mx-1" name="btnEditarDatos">Guardar Cambios</button>
            
            <button type="button" class="btn btn-secondary" id="btnCancelar">Cancelar</button>

        </div>
    </form>
</div>









</main>


<script>
    // Obtén una referencia a los botones y al formulario
    const btnDisplayEditForm = document.getElementById("btnDisplayEditForm");
    const btnCancelar = document.getElementById("btnCancelar");
    const editarPerfilForm = document.getElementById("editarPerfilForm");

    // Agrega un manejador de eventos al botón "Editar información"
    btnDisplayEditForm.addEventListener("click", () => {
        // Muestra el formulario y el botón "Cancelar"
        editarPerfilForm.style.display = "block";
        btnCancelar.style.display = "block";
    });

    // Agrega un manejador de eventos al botón "Cancelar"
    btnCancelar.addEventListener("click", () => {
        // Oculta el formulario y el botón "Cancelar"
        editarPerfilForm.style.display = "none";
        btnCancelar.style.display = "none";
    });
</script>






<?php 

require_once("./includes/footer.php");
?>
