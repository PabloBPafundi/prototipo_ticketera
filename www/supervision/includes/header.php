<?php
require_once '../classes/Database.php';
require_once '../classes/Auth.php';
// Iniciar la sesión
session_start();

 // Comprueba si el usuario ha iniciado sesión
 if (!isset($_SESSION['empleadoSupervision'])) {
  // El usuario no ha iniciado sesión, redirige a la página de inicio de sesión
   header('Location: login.php'); // Reemplaza 'login.php' con la URL de tu página de inicio de sesión.
 exit();
} else {

  //Guardo en una variable el array empleado que tiene los datos de la sesion actual. Toda la tabla empleado
  $empleadoActual = $_SESSION['empleadoSupervision'];
  //var_dump($_SESSION); // Muestra las variables de sesión para depuración
}

//Cerrar sesion
 if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
  $auth = new Auth();
   $auth->logout();
 }







?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa</title>
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <!-- icono -->
    <link rel="icon" href="../assets/Activo-favicon.png" type="image/png" sizes="32x32 16x16">
</head>
<body>

<header class="cnav">
<nav class="navbar container d-flex justify-content-between ">
  <div >
    <a class="navbar-brand" href="./index.php">
      <!-- <img src="" alt="Logo" width="30" height="24" class="d-inline-block align-text-top"> -->
      Prototipo Ticketera
    </a>
  </div>

    <div class="d-flex">


    <div class="d-flex align-items-center">

    <div class="px-2">
    
    <i class="fa-solid fa-circle-user fa-lg"></i>
    </div>
    
    <ul class="p-0 m-0 ">




    <li class="nav-item dropdown">
        
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php 
            echo  $empleadoActual['nombre'] ." " . $empleadoActual['apellido'] ;
            
            ?>
          </a>
          <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="./registro-tickets.php">Registro de Tickets</a></li>  
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="./index.php?logout=true">Cerrar Sesión</a></li>

          </ul>
        </li>
        </ul>
    </div>
    


    </div>
</nav>

</header>
