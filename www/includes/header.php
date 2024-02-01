<?php
require_once './classes/Database.php';
require_once './classes/Auth.php';
// Iniciar la sesión
session_start();

 // Comprueba si el usuario ha iniciado sesión
 if (!isset($_SESSION['empleado'])) {
  // El usuario no ha iniciado sesión, redirige a la página de inicio de sesión
   header('Location: login.php'); 
 exit();
} else {

  //Guardo en una variable el array empleado que tiene los datos de la sesion actual. Toda la tabla empleado
  $empleadoActual = $_SESSION['empleado'];
  //var_dump($_SESSION); // Muestra las variables de sesión para depuración
}

//Cerrar sesion
 if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
  $auth = new Auth();
   $auth->logout();
 }

// //Crear una instancia de la clase Database
//  $database = new Database();

// // Obtener la conexión PDO
//  $conn = $database->getConn();


?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa</title>
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <!-- icono -->
    <link rel="icon" href="./assets/Activo-favicon.png" type="image/png" sizes="32x32 16x16">
</head>
<body>

<header class="cnav">








<nav class="navbar navbar-expand-lg">
      <div class="container d-flex justify-content-between">
          
          <div class="text-center">
      <a class="navbar-brand fs-3 m-0 fw-bold"  href="index.php">Prototipo Ticketera</a> 
  </div>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navresponsiva" aria-controls="navresponsiva" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navresponsiva">
        <ul class="navbar-nav nav-pills" >

        

        <li class="nav-item">

<a class="nav-link active bg-black text-white p-2 rounded-end" href="./asistencia-tecnica.php">Asistencia Tecnica <i class="fa-solid fa-wrench"></i> </a>

</li>
          

          <li class="nav-item dropdown">

        <div class="d-flex align-items-center">

        
        <ul class="p-0 m-0 ">


        <a class="nav-link dropdown-toggle text-dark" href="#" role="" data-bs-toggle="dropdown" aria-expanded="false">

        

        <i class="fa-solid fa-circle-user fa-lg"></i>
      
        <?php echo  $empleadoActual['nombre'] ." " . $empleadoActual['apellido'] ; ?>
            
            
          </a>
          
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="./mi-perfil.php">Mi Perfil</a></li>
            <li><a class="dropdown-item" href="./herramientas.php">Herramientas</a></li>
            <li><a class="dropdown-item" href="./estado-ticket.php">Tickets Enviados</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="./index.php?logout=true">Cerrar Sesión</a></li>

          </ul>
          </li>



        </ul>
      </div>
  </div>
    </nav>

</header>
