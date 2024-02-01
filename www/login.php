<?php
require_once './classes/LDAP.php'; 
require_once("./classes/Empleado.php");


session_start();
// Comprueba si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $username = $_POST["usuario"];
    $password = $_POST["pass"];
    //$domain = "prototipo"; 

    // Crea una instancia de la clase LDAP
    $ldap = new LDAP();


if ($ldap->connect()) { // Intenta conectar al servidor LDAP



   
    if ($ldap->authenticateUser($username, $password)) {  // Intenta autenticar al usuario


        
        $userInfo = $ldap->getUserInfo($username); // Obtiene el nombre y apellido del usuario

        if ($userInfo) {
     
       // Crear una instancia de la clase Empleado
        $empleadoObj = new Empleado();

        $resul = $empleadoObj->usuarioExiste($userInfo['usuario']);
       

        if(!$resul)
        {
            //Empleado no existe, se crea
            $empleadoObj->registrarEmpleadoBase($userInfo['nombre'], $userInfo['apellido'], $userInfo['usuario']);

        } 


        $empleado = $empleadoObj->getEmpleado($userInfo['usuario']);

        if (!empty($empleado)){

            $_SESSION['empleado'] = $empleado;
            header('Location: index.php');
            exit();
        } else {

            $error_message =  "Usuario se encuentra deshabilitado. Contactese con el administrador";
        }

       

    



      
        } else {
            $error_message =  "Error al obtener la información del usuario.";
        }
    } else {
        $error_message = "Inicio de sesión fallido. Por favor, inténtalo de nuevo.";
    }
} else {
    $error_message =  "No se pudo conectar al servidor LDAP";
}

    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Empresa</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
    

    <!-- icono -->
    <link rel="icon" href="./assets/Activo-favicon.png" type="image/png" sizes="32x32 16x16">
</head>
<body >

<main class="d-flex justify-content-center">


<div>



<div class="container vh-100 d-flex align-items-center ">

       
        <div class="p-4 border  rounded-3 p-5">

            <div class="d-flex justify-content-center mb-5">
                <h1>Prototipo Ticketera</h1>
            </div>
            <div class="d-flex justify-content-center">
                <form method="post" action="login.php">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" autocomplete="off">

                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" name="pass" class="form-control" autocomplete="off">

                    <div class="text-center mt-1">
                    <button type="submit" class="btn btn-warning mt-3">Iniciar Sesión</button>

                    
                    </div>
                    

                </form>
            </div>

            <?php
                            if (isset($error_message)) {
                                echo '<div class="text-danger mt-2">' . $error_message . '</div>';
                            }
                            ?>
        </div>

        

</div>






</div>

</main>




<?php 
require_once("./includes/footer.php");
?>

