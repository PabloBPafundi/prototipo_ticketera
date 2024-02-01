
<?php 

require_once("includes/header.php");
require_once("../classes/Empleado.php");
require_once '../classes/Departamento.php';
require_once '../classes/Jerarquia.php';

// Crear una instancia de la clase Empleado
$empleado = new Empleado();

$departamentoObj = new Departamento();
$jerarquiaObj = new Jerarquia();

if (isset($_GET['id_empleado'])){

  $userIDEdit = $_GET['id_empleado'];
  $infoEmpleado = $empleado->getEmpleadoConID($userIDEdit);
 



  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnEditar']) && !empty($infoEmpleado) ) {

   
    $nroDNI = $_POST['nroDNI'];
    $nroContacto = $_POST['nroContacto'];
    $mailLaboral = $_POST['mailLaboral'];
    $departamento = $_POST['departamento'];
    $jerarquia = $_POST['jerarquia'];
    $usuarioCampana = $_POST['usuarioCampana'];


   
   
    $valueDepartamento = $departamentoObj->obtenerDepartamentoID($departamento);
    $valuejerarquia = $jerarquiaObj->obtenerJerarquiaID($jerarquia);

  
    // Validar los datos
  
    
            // Editar empleado en la base de datos
            $editExitoso = $empleado->editarEmpleado($infoEmpleado['id_empleado'], $nroDNI, $nroContacto, $mailLaboral, $valueDepartamento, $valuejerarquia, $usuarioCampana);


         
           if ($editExitoso) {
                // Almacena el mensaje en una variable de sesión
                $_SESSION['mensaje'] = "Empleado editado con éxito";
                header("Location: empleados.php");
                exit; 
            } 
            else {
                // En caso de error
                $mensaje = "Error al editar al empleado";
            }
        
    



  }

}


?>

<?php 
if (!empty($infoEmpleado)) {
  ?>


<div class="container d-flex align-items-center mt-5">
    <hr class="flex-grow-1">
    <h2 class="text-center mx-3 fs-3 fw-bold titulos">Editar Empleado <?php  echo $infoEmpleado['usuario']; ?></h2>
    <hr class="flex-grow-1">
</div>




<div class="container  rounded-3 mt-5">





<form action="./editar-usuario.php?id_empleado=<?php  echo $infoEmpleado['id_empleado']; ?>" class="needs-validation" method="POST" novalidate>
        <div class="row container d-flex justify-content-center g-3 py-3">


            <div class="form-floating mb-3 col-6">
                <input type="text" class="form-control rounded-4" id="DNIInput" placeholder="Nro de DNI" name="nroDNI" value="<?php  echo $infoEmpleado['nroDNI']; ?>" maxlength="30">
                <label for="DNIInput">Nro de DNI</label>
                <div class="invalid-feedback">Por favor, ingrese un número de DNI válido.</div>
            </div>

            <div class="form-floating mb-3 col-6">
                <input type="text" class="form-control rounded-4" id="nroContactoInput" placeholder="Nro de Contacto" name="nroContacto" value="<?php  echo $infoEmpleado['nroContacto']; ?>" maxlength="40" >
                <label for="nroContactoInput">Nro de Contacto</label>
                <div class="invalid-feedback">Por favor, ingrese un número de contacto válido.</div>
            </div>

            <div class="form-floating mb-3 col-6">
                <input type="text" class="form-control rounded-4" id="usuarioCampanaInput" placeholder="Usuario campaña" name="usuarioCampana" value="<?php  echo $infoEmpleado['usuarioCampana']; ?>" maxlength="30" >
                <label for="usuarioCampanaInput">Usuario campaña</label>
                <div class="invalid-feedback">Por favor, ingrese un número de usuario válido.</div>
            </div>



            <div class="form-floating mb-3 col-6">
                <input type="email" class="form-control rounded-4" id="MailInput" placeholder="nombre@ejemplo.com" name="mailLaboral" value="<?php  echo $infoEmpleado['mail_laboral']; ?>" maxlength="65" >
                <label for="MailInput">Correo Laboral</label>
                <div class="invalid-feedback">Por favor, ingrese una dirección de correo válida.</div>
            </div>




            <div class="form-floating col-6">



        <select class="form-select" id="departamentoID" aria-label="Floating label select example" name="departamento">
            <option  disabled value="">Seleccionar...</option>
        <optgroup label="Teco">
            <option value="Sin campaña" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Sin campaña') ? 'selected' : ''; ?>>Sin campaña</option>
            <option value="Retencion Movil" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Retencion Movil') ? 'selected' : ''; ?>>Retención Móvil</option>
            <option value="Retencion Fija" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Retencion Fija') ? 'selected' : ''; ?>>Retención Fija</option>
            <option value="Ventas OUT" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Ventas OUT') ? 'selected' : ''; ?>>Ventas OUT</option>
            <option value="Ventas IN" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Ventas IN') ? 'selected' : ''; ?>>Ventas IN</option>
            <option value="HBO" <?php echo ($infoEmpleado['nombreDepartamento'] == 'HBO') ? 'selected' : ''; ?>>HBO</option>
            <option value="Star" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Star') ? 'selected' : ''; ?>>Star</option>
            <option value="Adultos" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Adultos') ? 'selected' : ''; ?>>Adultos</option>
        </optgroup>
        <optgroup label="Clarín">
            <option value="Retencion Clarín 365" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Retencion Clarín 365') ? 'selected' : ''; ?>>Retención Clarín 365</option>
            <option value="Clarín 365" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Clarín 365') ? 'selected' : ''; ?>>Clarín 365</option>
        </optgroup>
        <optgroup label="Otras Campañas">
            <option value="Zurich" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Zurich') ? 'selected' : ''; ?>>Zurich</option>
            <option value="Pfizer" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Pfizer') ? 'selected' : ''; ?>>Pfizer</option>
        </optgroup>
        <optgroup label="Staff">
            <option value="Sistemas" <?php echo ($infoEmpleado['nombreDepartamento'] == 'Sistemas') ? 'selected' : ''; ?>>Sistemas</option>
 
        </optgroup>
    </select>
            <label for="departamentoID">Departamento</label>
            <div class="invalid-feedback">Por favor, ingrese una valor valido</div>
            </div>



            <div class="form-floating col-6">
            <select class="form-select" id="jerarquiaID" aria-label="Floating label select example" name="jerarquia">
            <option  disabled value="">Seleccionar...</option>
                <option value="S/ Rol"<?php echo ($infoEmpleado['rol'] == 'S/ Rol') ? 'selected' : ''; ?>>S/ Rol</option>
                <option value="Ejecutivo de Ventas"<?php echo ($infoEmpleado['rol'] == 'Ejecutivo de Ventas') ? 'selected' : ''; ?>>Ejecutivo de Ventas</option>
                <option value="TeamLeader Ventas"<?php echo ($infoEmpleado['rol'] == 'TeamLeader Ventas') ? 'selected' : ''; ?>>TeamLeader Ventas</option>
                <option value="HelpDesk"<?php echo ($infoEmpleado['rol'] == 'HelpDesk') ? 'selected' : ''; ?>>HelpDesk</option>
            </select>

            <label for="jerarquiaID">Jerarquia</label>
            <div class="invalid-feedback">Por favor, ingrese una valor valido</div>
            </div>






            <div class="d-flex justify-content-end col-12">
                <button class="btn btn-primary mx-2" type="submit" name="btnEditar">Editar</button>
                <a href="./empleados.php" class="btn btn-warning mx-2">Cancelar</a>
            </div>
        </div>
   

    
    <div class="container  rounded-3 mt-5">
    <?php if (isset($mensaje)) { ?>
        <div class=" alert alert-danger">
            <?php echo $mensaje; ?>
        </div>
    <?php } ?>






<div>







</div>





</form>


</div>























































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

require_once("includes/footer.php");
?>
