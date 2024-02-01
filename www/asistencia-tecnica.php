<?php 

require_once("./includes/header.php");
require_once './classes/Ticket.php';
require_once("./classes/Empleado.php");


$ticketObj = new Ticket();
$EmpleadoObj = new Empleado();




if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitBtn'])) {

  $perfilEmpleadoActual = $EmpleadoObj->getEmpleadoDNI($empleadoActual['usuario']);
  $resul = $perfilEmpleadoActual['nroDNI'];

  if ($resul == null) {
    $mensajeError = 'Perfil incompleto. Por favor <a class="text-decoration-none text-primary" href="mi-perfil.php">completar datos en su perfil</a>.';

  } else {

  $tipo_inconveniente = $_POST['tipo_inconveniente'];
  $estado_gestion_agente = $_POST['estado_gestion_agente'];
  $comentario_solicitante = $_POST['comentario_solicitante'];
  $ubicacionLaboral = $_POST['ubicacionLaboral'];
  $posicionLaboral = $_POST['posicionLaboral'];
  $idRemoteDesktop = $_POST['idRemoteDesktop'];
  $proveedorInternet = $_POST['proveedorInternet'];

  $fk_id_empleado = $empleadoActual['id_empleado'];


    $p = $ticketObj->realizarPedido($tipo_inconveniente, $estado_gestion_agente, $comentario_solicitante, $ubicacionLaboral, $posicionLaboral, $idRemoteDesktop, $proveedorInternet, $fk_id_empleado);
 
    if ($p){
    $_SESSION['mensaje'] = "Ticket enviado con exito. Revisar procedimientos autogestionables si corresponde.";
    header("Location: estado-ticket.php");
    exit;



    } else {

    $mensajeError = "Error al enviar el formulario";
    
    }

  }
  
}



?>



<!--PROCEDIMIENTOS -->

 <div class="mt-4 letraUno">

  
<div class=" container d-flex justify-content-start">

<a class="btn btn-info text-white p-2 rounded-1" href="#asistencia">Formulario de Asistencia Tecnica</a>

</div>
  
  <div class="container text-center pb-5 " id="procedimientos" >

    




    <div class=" d-flex align-items-center p-4 ">
      <hr class="flex-grow-1">
      <h2 class="text-center mx-3 fs-1 fw-bold">Procedimientos Autogestionables</h2>
      <hr class="flex-grow-1">
    </div>
    

    <div class="row align-items-center g-5 ">

        


      
<div class="col-lg-6 center">




    <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
    <div class=" py-2">
      <h4 class="cOrange p-lg-0 p-3">Error Citrix Logueo/Credenciales</h4>
      <p>Ingresamos credenciales para loguearse en citrix y aparece un error.</p>
      <hr>
      <p class="text-start"> 
        Mensajes de error: <br>
    - Vuelva a intentarlo o contacte con la asistencia técnica/administrador.<br>
    - Ha excedido el número máximo de intentos de sesión. <br>
    - Nombre de usuario o contraseña incorrectos.   
      </p>
      <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#div1"><i class="fa-solid fa-arrow-down"></i></button>
    </div>
    </div> 


      <div class="container">
      
      <div id="div1" class="collapse mt-4">

        <div class="accordion accordion-flush text-start" id="paccordionuno">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne1">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne1" aria-expanded="false" aria-controls="1flush-collapseOne">
                Procedimiento 1
              </button>
            </h2>
            <div id="flush-collapseOne1" class="accordion-collapse collapse" aria-labelledby="flush-headingOne1" data-bs-parent="#paccordionuno">
              <div class="accordion-body">
                Revice que se esta logueando correctamente: Instructivo <a href="" target="_blank">Citrix Logueo Iniciar-Finalizar sesión</a> <br>
                Si ya tiene citrix configurado correctamente. Continue con el procedimiento 2

              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo1">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo1" aria-expanded="false" aria-controls="flush-collapseTwo1">
                Procedimiento 2
              </button>
            </h2>
            <div id="flush-collapseTwo1" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo1" data-bs-parent="#paccordionuno">
              <div class="accordion-body">
                Cambiar contraseña: 

                <p>
                <strong>Opcion 1:</strong> <a href="" target="_blank">Cambiar contraseña por TUID</a>. <br>
                - No es posible en todos los casos, si no lo permite hacer el blanqueo.
                </p>

                <p>
                <strong>Opcion 2:</strong> <a href="" target="_blank">Blanquear contraseña</a>.
                
               

                </p>
                - Una vez finalizado el proceso de restablecimiento de contraseña, es fundamental cerrar el navegador o la ventana de Tuid para garantizar la correcta aplicación del blanqueo. Si no se lleva a cabo esta acción, los cambios realizados en la contraseña no serán efectivos.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree1">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree1" aria-expanded="false" aria-controls="flush-collapseThree1">
                Procedimiento 3
              </button>
            </h2>
            <div id="flush-collapseThree1" class="accordion-collapse collapse" aria-labelledby="flush-headingThree1" data-bs-parent="#paccordionuno">
              <div class="accordion-body">
                <p class="pb-1">- Para verificar si el blanqueo de contraseña se ha aplicado correctamente, es necesario realizar una prueba ingresando la contraseña en <a href="" target="_blank">Tuid</a> . Si se logra acceder exitosamente, se confirma que el blanqueo ha sido exitoso. Sin embargo, cabe destacar que el inconveniente puede encontrarse en el autenticador.</p>
                 
                <p>Paso 1: Sincronizar reloj con Google. Instructivo <a href="" target="_blank">Error Authenticator</a></p>
                <p>Paso 2: Volver a configurar el google authenticator: Solicitar token a sistemas de ser necesario. Instructivo <a href="" target="_blank">Configuración  Authenticator</a></p>
               
              </div>
            </div>
          </div>
        </div>







  
    </div>






  </div>



</div>












<div class="col-lg-6 center">




  <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
  <div class=" py-2">
    <h4 class="cOrange p-lg-0 p-3">Error Citrix Ingreso Remoto</h4>
    <p>
      Hacemos click en el remoto y aparece un error. <br>
    </p>

    <hr>
      <p class="text-start"> 
        Errores: <br>
    - Remoto no inicia y muestra un error en la pantalla. <br>
    - Mensaje de Error: Se ha intentado iniciar sesión pero el servicio de inicio de sesión de la red no se ha iniciado.<br>
    - Error 3500, Store, 3504, 2425, ERROR PIC, etc.
    
      </p>
    
    <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#div2"><i class="fa-solid fa-arrow-down"></i></button>
  </div>
  </div> 


    <div class="container">
    
    <div id="div2" class="collapse mt-4">

      <div class="accordion accordion-flush text-start" id="paccordiondos">
        <div class="accordion-item">
          <h2 class="accordion-header" id="2flush-headingOne">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne2" aria-expanded="false" aria-controls="flush-collapseOne2">
              Procedimiento 1
            </button>
          </h2>
          <div id="flush-collapseOne2" class="accordion-collapse collapse" aria-labelledby="flush-headingOne2" data-bs-parent="#paccordiondos">
            <div class="accordion-body">
                <p>
                  Si aparecen errores como el Error 3500, Store, 3504 u otros en Citrix, sigue estos pasos: <br>
                  1. Configuración requerida de Citrix: <a href="" target="_blank">Instructivo</a>.<br>
                  2. Cierra Citrix por completo <strong>cerrando sesión</strong> y seleccionando la opción <strong>"Salir"</strong> en los iconos ocultos de la barra de tareas (Ubicados en la esquina inferior derecha de la pantalla, junto al reloj)<br>
                  3. Espera 6 minutos con Citrix <strong>completamente cerrado.</strong><br>
                  4. Después de este tiempo, intenta nuevamente. <br>
                  5. Antes de abrir una conexión remota, asegúrate de refrescar Citrix. Puedes hacerlo seleccionando la opción <strong>"Actualizar aplicaciones"</strong> en la parte superior derecha de la ventana de Citrix. <br>
                    
                  <span class="fst-italic">* Si se encuentra insite, no aparecen los iconos ocultos. Cerrar sesión de citrix, luego la ventana de citrix completamente y esperar 7 minutos. Recuerde que tiene WDE de manera local.</span>
                </p>

                <p>Mas informacion detallada en <a href="" target="_blank">Errores Citrix-Remoto</a></p>
               
            </div>
          </div>
        </div>
  
       
      </div>







  </div>
</div></div>











<div class="col-lg-6 center">




  <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
  <div class=" py-2">
    <h4 class="cOrange p-lg-0 p-3">FAN no abre en el Remoto</h4>
    <p class="">Error de privacidad, pantalla en blanco</p>
    <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#InternetInsite"><i class="fa-solid fa-arrow-down"></i></button>
  </div>
  </div> 


    <div class="container">
    
    <div id="InternetInsite" class="collapse mt-4">

      <div class="accordion accordion-flush text-start" id="InternetInsiteAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="InternetInsiteHeading">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#InternetInsiteflush" aria-expanded="false" aria-controls="InternetInsiteflush">
              Procedimiento 1
            </button>
          </h2>
          <div id="InternetInsiteflush" class="accordion-collapse collapse" aria-labelledby="InternetInsiteHeading" data-bs-parent="#InternetInsiteAccordion"> 
            <div class="accordion-body">Refrescar pagina y/o ingresar con ventana de incognito.</div>
          </div>
        </div>
  
       
      </div>







  </div>
</div></div>




























<div class="col-lg-6 center">




  <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
  <div class=" py-2 ">
    <h4 class="cOrange p-lg-0 p-3">No aparece Carpeta compartida/No tengo internet InSite</h4>
    <p class="">No aparece la carpeta compartida y/o no tengo internet</p>
    <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#CPROXY"><i class="fa-solid fa-arrow-down"></i></button>
  </div>
  </div> 


    <div class="container">
    
    <div id="CPROXY" class="collapse mt-4">

      <div class="accordion accordion-flush text-start" id="CPROXYAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="aAHeading">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flushCPROXY" aria-expanded="false" aria-controls="flushCPROXY1">
              Procedimiento 1
            </button>
          </h2>
          <div id="flushCPROXY" class="accordion-collapse collapse" aria-labelledby="aAHeading" data-bs-parent="#CPROXYAccordion">
            <div class="accordion-body">Revisar instructivo <a href="" target="_blank">Carpeta Compartida y proxy</a></div>
          </div>
        </div>
  
       
      </div>







  </div>
</div></div>













<div class="col-lg-6 center">
  <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
    <div class="py-2">
      <h4 class="cOrange p-lg-0 p-3">Falla sonido InSite</h4>
      <p>Auricular/Sonido no funciona correctamente</p>
      <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#audioInsite"><i class="fa-solid fa-arrow-down"></i></button>
    </div>
  </div> 
  <div class="container">
    <div id="audioInsite" class="collapse mt-4">
      <div class="accordion accordion-flush text-start" id="AudioInsiteAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="AudioInsiteheadingOne">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#AudioInsitecollapseOne" aria-expanded="false" aria-controls="AudioInsitecollapseOne">
              Procedimiento 1
            </button>
          </h2>
          <div id="AudioInsitecollapseOne" class="accordion-collapse collapse" aria-labelledby="AudioInsiteheadingOne" data-bs-parent="#AudioInsiteAccordion">
            <div class="accordion-body">
             * Revisar Instructivo <a href="" target="_blank">Configuración de Sonido y audio</a> 
             <hr>
             Soluciones Frecuentes: <br>
             * Reconectar auricular (Volver a conectarlo en la PC).<br>
             * Probar abrir WDE desde dentro o fuera del remoto.<br>
             * Si no detecta el auricular, pero esta conectado a la pc, reiniciar la PC.<br>
             * Revisar el volumen del dispositivo.
             <hr>
             Ruta de Configuracion de sonidos y audio: Share\ops\Telecom\Tecnicos
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="AudioInsiteheadingTwo">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#AudioInsitecollapseTwo" aria-expanded="false" aria-controls="AudioInsitecollapseTwo">
              Procedimiento 2
            </button>
          </h2>
          <div id="AudioInsitecollapseTwo" class="accordion-collapse collapse" aria-labelledby="AudioInsiteheadingTwo" data-bs-parent="#AudioInsiteAccordion">
            <div class="accordion-body">
               Si WDE solo esta disponible dentro del remoto, revisar instructivo <a href="" target="_blank">Reinicio Citrix </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> 





<div class="col-lg-6 center">




  <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
  <div class=" py-2">
    <h4 class="cOrange p-lg-0 p-3">No tengo el Authenticator/Token configurado</h4>
    <p class="">Doble factor para mail, Citrix, Itickets</p>
    <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#AA"><i class="fa-solid fa-arrow-down"></i></button>
  </div>
  </div> 


    <div class="container">
    
    <div id="AA" class="collapse mt-4">

      <div class="accordion accordion-flush text-start" id="authenticatorAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="aAHeading">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flushAA" aria-expanded="false" aria-controls="2flush-collapseOne">
              Procedimiento 1
            </button>
          </h2>
          <div id="flushAA" class="accordion-collapse collapse" aria-labelledby="aAHeading" data-bs-parent="#authenticatorAccordion"> 
            <div class="accordion-body">Revisar instructivo <a href="" target="_blank">Google Authenticator</a></div>
          </div>
        </div>
  
       
      </div>


  </div>
</div></div>








  <div class="col-lg-6 center">




    <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
    <div class=" py-2">
      <h4 class="cOrange p-lg-0 p-3">Error Open Logueo/Credenciales</h4>
      <p class="">Contraseña incorrecta. Cuenta bloqueada</p>
      <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#div3"><i class="fa-solid fa-arrow-down"></i></button>
    </div>
    </div> 


      <div class="container">
      
      <div id="div3" class="collapse mt-4">


        <div class="accordion accordion-flush text-start" id="paccordiontres">
          <div class="accordion-item">
            <h2 class="accordion-header" id="3flush-headingOne">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne3" aria-expanded="false" aria-controls="flush-collapseOne3">
                Procedimiento 1
              </button>
            </h2>
            <div id="flush-collapseOne3" class="accordion-collapse collapse" aria-labelledby="flush-headingOne3" data-bs-parent="#paccordiontres">
              <div class="accordion-body">
                Revisar que la base de datos este configurada correctamente: <br>
                * Para operadores en gestión: oppro.<br>
                * Para Capacitación es: opcap.<br>

              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo3">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo3" aria-expanded="false" aria-controls="flush-collapseTwo3">
                Procedimiento 2
              </button>
            </h2>
            <div id="flush-collapseTwo3" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo3" data-bs-parent="#paccordiontres">
              <div class="accordion-body">Blanquear o desbloquear usuario de Open: Instructivo <a href="" target="_blank">Open</a></div>
            </div>
          </div>
     
        </div>

  
    </div>
  </div></div>


  <div class="col-lg-6 center">




    <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
    <div class=" py-2">
      <h4 class="cOrange p-lg-0 p-3">Falla Audio/Remoto Lento</h4>
      <p class="">Audio entrecortado, rebotico, eco, fritura, mudo. Tarda en caer el dato</p>
      <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#div4"><i class="fa-solid fa-arrow-down"></i></button>
    </div>
    </div> 


      <div class="container">
      
      <div id="div4" class="collapse mt-4">

        <div class="accordion accordion-flush text-start" id="paccordioncuatro">
          <div class="accordion-item">
            <h2 class="accordion-header" id="4flush-headingOne">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne4" aria-expanded="false" aria-controls="flush-collapseOne4">
               Procedimiento 1
              </button>
            </h2>
            <div id="flush-collapseOne4" class="accordion-collapse collapse" aria-labelledby="flush-headingOne4" data-bs-parent="#paccordioncuatro">
              <div class="accordion-body">Revisar conexión a internet: <a href="" target="_blank">Velocidad internet</a> y <a href="" target="_blank">Estabilidad de internet (Opcional)</a></div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="4flush-headingTwo">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo4" aria-expanded="false" aria-controls="flush-collapseTwo4">
               Procedimiento 2
              </button>
            </h2>
            <div id="flush-collapseTwo4" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo4" data-bs-parent="#paccordioncuatro">
              <div class="accordion-body">Revisar sonido y audio: Instructivo <a href="" target="_blank">Sonido y audio</a></div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree4">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree4" aria-expanded="false" aria-controls="flush-collapseThree4">
                Procedimiento 3
              </button>
            </h2>
            <div id="flush-collapseThree4" class="accordion-collapse collapse" aria-labelledby="flush-headingThree4" data-bs-parent="#paccordioncuatro">
              <div class="accordion-body">Renovar sesión del remoto: Instructivo <a href="" target="_blank">Reinicio Citrix</a></div>
            </div>
          </div>
        </div>

  
    </div>
  </div></div>


  <div class="col-lg-6 center">




    <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
    <div class=" py-2">
      <h4 class="cOrange p-lg-0 p-3">Agregar cuenta en Citrix</h4>
      <p class="">No permite agregar cuenta</p>
      <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#div5"><i class="fa-solid fa-arrow-down"></i></button>
    </div>
    </div> 


      <div class="container">
      
      <div id="div5" class="collapse mt-4">


        <div class="accordion accordion-flush text-start" id="paccordiocinco">
          <div class="accordion-item">
            <h2 class="accordion-header" id="5flush-headingOne">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne5" aria-expanded="false" aria-controls="flush-collapseOne5">
                Procedimiento 1
              </button>
            </h2>
            <div id="flush-collapseOne5" class="accordion-collapse collapse" aria-labelledby="flush-headingOne5" data-bs-parent="#paccordiocinco">
              <div class="accordion-body">

                * En agregar cuenta va la url:<br>
                  - virtualaccess.telecom.com.ar <br>
                  - En el caso de estar <strong>insite</strong> puede que solo funcione estos url http://virtualapp.telecom.com.ar/ o virtualapp.telecom.com.ar (Probar en el Citrix y/o en el navegador web)<br>
                * La opcion luego del primer logueo es <strong>Store</strong> <br>
                * Mas informacion revisar instructivo <a href="" target="_blank">Citrix Logueo Iniciar-Finalizar sesión</a>

              </div>
            </div>
          </div>
                       
        </div>

  
    </div>
  </div></div>


  <div class="col-lg-6 center">




    <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
    <div class=" py-2">
      <h4 class="cOrange p-lg-0 p-3">Sonido Bloqueado dentro del Remoto</h4>
      <p class="">El sonido (Dentro del remoto) figura bloqueado.</p>
      <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#div6"><i class="fa-solid fa-arrow-down"></i></button>
    </div>
    </div> 


      <div class="container">
      
      <div id="div6" class="collapse mt-4">


        <div class="accordion accordion-flush text-start" id="paccordioseis">
          <div class="accordion-item">
            <h2 class="accordion-header" id="6flush-headingOne">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne6" aria-expanded="false" aria-controls="flush-collapseOne6">
                Procedimiento 1
              </button>
            </h2>
            <div id="flush-collapseOne6" class="accordion-collapse collapse" aria-labelledby="flush-headingOne6" data-bs-parent="#paccordioseis">
              <div class="accordion-body">Renovar sesion del remoto: Instructivo <a href="" target="_blank">Reinicio Citrix</a></div>
            </div>
          </div>
          
      
        </div>

  
    </div>
  </div></div>

  <div class="col-lg-6 center">




    <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
    <div class=" py-2">
      <h4 class="cOrange p-lg-0 p-3">Error de proxy dentro del remoto</h4>
      <p class="">Errores referidos al proxy dentro del remoto</p>
      <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#div7"><i class="fa-solid fa-arrow-down"></i></button>
    </div>
    </div> 


      <div class="container">
      
      <div id="div7" class="collapse mt-4">


        <div class="accordion accordion-flush text-start" id="paccordionsiete">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne7">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne7" aria-expanded="false" aria-controls="flush-collapseOne7">
                Procedimiento 1
              </button>
            </h2>
            <div id="flush-collapseOne7" class="accordion-collapse collapse" aria-labelledby="flush-headingOne7" data-bs-parent="#paccordionsiete">
              <div class="accordion-body">Renovar sesion del remoto: Instructivo <a href="" target="_blank">Reinicio Citrix</a></div>
            </div>
          </div>
         
      
        </div>



    </div>
  </div></div>


  <div class="col-lg-6 center">




    <div class="rounded-5 bg-white text-dark px-5 bg-opacity-75 shadow">
    <div class=" py-2">
      <h4 class="cOrange p-lg-0 p-3">Error de "lugar" en Workspace/WDE</h4>
      <p class="">En Workspace nos aparece para ingresar <strong>Lugar</strong></p>
      <button type="button" class="btn cbgOrange rounded-5" data-bs-toggle="collapse" data-bs-target="#div8"><i class="fa-solid fa-arrow-down"></i></button>
    </div>
    </div> 


      <div class="container">
      
      <div id="div8" class="collapse mt-4">


        <div class="accordion accordion-flush text-start" id="paccordionocho">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne8">
              <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne8" aria-expanded="false" aria-controls="flush-collapseOne8">
                Procedimiento 1
              </button>
            </h2>
            <div id="flush-collapseOne8" class="accordion-collapse collapse" aria-labelledby="flush-headingOne8" data-bs-parent="#paccordionocho">
              <div class="accordion-body">Elevar a lider: Instructivo <a href="" target="_blank">Errores WDE</a></div>
            </div>
          </div>
          
        
        </div>



        
  
    </div>
  </div></div>

  </div>



  

</div>



  





</div>


 
  


<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

<!--Inicio Formulario --> 
<div class="bg-secondary py-5 mt-5 bg-opacity-10" id="asistencia">
 
  <h1 class="container text-dark d-flex rounded-bottom p-3 mb-4">Solicitud de Asistencia</h1>

 
 
 
  
 <div class="container p-3 rounded-3">

 
 <?php if (isset($mensajeError)) : ?>
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <?php echo $mensajeError; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


 
<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

<!--Formulario --> 
<form  class="needs-validation" novalidate method="post" >



<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

<!-- Motivo Solicitud --> 
  
  
    <h5><i class="fa-solid fa-ticket"></i> Motivo de Solicitud</h5>
 
  
    <!-- Fila -->
    <div class="row my-3 g-2">








<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->



    <div class="col-lg-6 ">
         <div class="form-floating">
           <select class="form-select"  name="tipo_inconveniente" required>
            <option selected disabled value="">Seleccionar...</option>
          
            <optgroup label="GENERAL">

            <option value="Credenciales Mail">Credenciales Mail</option>
            <option value="Mail">Mail</option>
            <option value="Actualización Herramienta/Falla Instalación">Actualización Herramienta/Falla Instalación</option>
            <option value="Cambie de PC">Cambie de PC</option>
            <option value="Falla Hardware (HEADSET, Monitor, teclado, mouse)">Falla Hardware (HEADSET, Monitor, teclado, mouse)</option>
            <option value="Falla PC">Falla PC</option>
            <option value="Doble Factor (Token, Authenticator)">Doble Factor (Token, Authenticator)</option>
            <option value="Pantalla Negra">Pantalla Negra</option>
            <option value="Carpeta Compartida">Carpeta Compartida</option>
            <option value="VPN">VPN</option>
            <option value="Escritorio Remoto Empresa">Escritorio Remoto Empresa</option>
            <option value="Microsoft Office">Microsoft Office</option>

            </optgroup>


            <optgroup label="INCOVENIENTES TECO">

             <option value="Citrix: Falla Logueo/Credenciales">Citrix: Falla Logueo/Credenciales</option>
             <option value="Remoto: Falla Audio">Remoto: Falla Audio</option>
             <option value="Falla Logueo WDE">Falla Logueo WDE</option>
             <option value="TABULACIONES PIC">TABULACIONES PIC</option>
             <option value="PAD De Atención WDE/PIC: Falla Aplicación">PAD De Atención WDE/PIC: Falla Aplicación</option>
             <option value="Citrix: Ingreso Remoto">Citrix: Ingreso Remoto (Error 3500, Error Store, ERROR PIC, Error 3504, etc)</option>
             <option value="Citrix: Falla Aplicación">Citrix: Falla Aplicación</option>
             <option value="FAN">FAN</option>
             <option value="OPEN">OPEN</option>
             <option value="Siebel">Siebel</option>
             <option value="Pulse">Pulse</option>
             

            </optgroup>

             <optgroup label="INCOVENIENTES OTRAS CAMPAÑAS">
             
             <option value="CRM CLARIN (Webcall, Agea)">CRM CLARIN (Webcall, Agea)</option>
             <option value="XLITE: Falla Logueo">XLITE: Falla Logueo</option>
             <option value="XLITE: Falla Audio">XLITE: Falla Audio</option>
             <option value="Keepcon">Keepcon</option>

            </optgroup>

           </select>
           <label for="Sinconveniente">Incoveniente</label>
           <div class="invalid-feedback">
            Elija una opcion valida.
          </div>
         </div>
       </div>



<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->




       <div class="col-lg-6">
        <div class="form-floating">
          <select class="form-select"  name="estado_gestion_agente" required>
            <option selected disabled value="">Seleccionar...</option>
            <option value="1">Gestionando</option>
            <option value="0">Sin Gestionar</option>
          </select>
          <label for="Estado">Estado</label>
          <div class="invalid-feedback">
            Ingrese una opcion valida.
          </div>
        </div>

       </div>

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->



       <div class="col-lg-12">
   <label for="comentario" class="form-label text-black">Comentario: Describa brevemente el incoveniente.</label>
   <textarea class="form-control" id="comentario" rows="2" maxlength="140" name="comentario_solicitante" required></textarea>
 </div>

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->


       </div>

 <!-- Fin de la fila -->


 
<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

<!--Ubicacion --> 

 <h5><i class="fa-solid fa-ticket"></i> Ubicacion</h5>

 <!-- Fila -->
    <div class="row my-3 g-2">


<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->


    <div class="col-lg-8">
         <div class="form-floating">
           <select class="form-select" name="ubicacionLaboral" required >
            <option selected disabled value="">Seleccionar...</option>
             <option value="Home Office">Home Office</option>
             <option value="In site (Presencial) Florida 129">In site (Presencial) Florida 129</option>
             <option value="In site (Presencial) Florida 141, 1er Piso, Isla Arriba">In site (Presencial) Florida 141, 1er Piso, Isla Arriba</option>
             <option value="In site (Presencial) Florida 141, 1er Piso, Isla Abajo">In site (Presencial) Florida 141, 1er Piso, Isla Abajo</option>
             <option value="In site (Presencial) Florida 141, 8vo Piso">In site (Presencial) Florida 141, 8vo Piso</option>
             <option value="In site (Presencial) Florida 141, 7mo Piso">In site (Presencial) Florida 141, 7mo Piso</option>
           </select>
           <label for="Smodalidad">Modalidad/Ubicación</label>
           <div class="invalid-feedback">
            Elegir una opción
          </div>
           
         </div>
        
       </div>

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
       

  <div class="col-lg-4">

<div class="input-group">
  <span class="input-group-text">BOX</span>
  <div class="form-floating">
    <input type="text" class="form-control" id="NroPuesto" name="posicionLaboral" placeholder="Username"  maxlength="6" required>
    <label for="posicionLaboral">Nro de Puesto</label>
  </div>
</div>

</div>


<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->






</div>

<!-- Fin de la Fila -->
 


<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

<!--Datos puesto de trabajo --> 
<h5><i class="fa-solid fa-ticket"></i> Datos Puesto de Trabajo</h5>
<hr>



 <!-- Fila -->
 <div class="row my-3">


 <!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
  <div class="col-lg-6">


    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="Anydesk" placeholder="ejemplo" name="idRemoteDesktop" required pattern="[0-9]{9,10}"
          oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="9" maxlength="10">
      <label for="Anydesk">Nro. de Anydesk</label>
      <div class="invalid-feedback" id="anydesk-error">
        Ingrese un número válido de 9 a 10 dígitos.
      </div>
      
    </div>

 
  </div>
  <!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
  <div class="col-lg-6">
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="Pinternet" placeholder="ejemplo" name="proveedorInternet" maxlength="20" required>
      <label for="Pinternet">Proveedor de Internet</label>
      <div class="invalid-feedback">
        Ingrese un dato valido
       </div>
    </div>
    
  </div>
<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->






</div>

<!-- Fin de la Fila -->













   <!-- Fila -->
    <div class="row my-3">
 
      
 
 <div class="col">


   <div class="border p-3 border-2 border-secondary">

     <div>

      

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

<!--Aclaraciones --> 
        
        <h5 > <i class="fa-solid fa-circle-exclamation"></i>Aclaraciones</h5>


       <div>
          <p class="mb-1">- Si el anydesk figura cerrado al momento de enviar solicitud y en el formulario no hay nada que indique que no se tiene acceso a dicha herramienta, se cierra el ticket.</p> <br>
           <p class="mb-1">- Si no se responde la solicitud de anydesk o contacto por Whatsapp por un tiempo determinado, se cierra el ticket.</p> <br>
           <p class="mb-1">- Si el motivo del inconveniente es auto gestionable y el agente no intento resolverlo, se le envían indicaciones y se cierra el ticket.</p> <br>
           <p class="mb-1">- Si el inconveniente no es un error, sino no una falta de conocimiento sobre el uso de la herramienta. Se eleva el caso a su superior y se cierra el ticket.</p> <br>
           <p class="mb-1">- Si el incoveniente es autogestionable, describir en el campo comentario que impidio hacerlo.</p>
         </p>
       </div>

     </div>
    <div>
   <div class="form-check ">
     <input class="form-check-input" type="checkbox" id="acepto" required>
     <label class="form-check-label" for="acepto">
     Acepto
     </label>
     <div class="invalid-feedback">
      Debe aceptar los terminos
    </div>
   </div>
 </div>

 </div>



 </div>

 

</div>
<!-- Fin de la Fila -->

    <!-- Fila -->
    <div class="row">
     <div class="col-sm-12 py-3">
 
 
       <div class="form-check form-switch">
         <input class="form-check-input" type="checkbox" role="switch" id="itemuno" required>
         <label class="form-check-label" for="itemuno">Declaro la veracidad de la información que ingresé en este formulario.</label>
         <div class="invalid-feedback">
          Debe aceptar los terminos
        </div>
       </div>
     
 
       <div class="form-check form-switch">
         <input class="form-check-input" type="checkbox" role="switch" id="itemdos" required>
         <label class="form-check-label" for="itemdos">Declaro que en el caso que sea autogestionable revisé los <a href="#procedimientos" class="text-decoration-none text-primary">instructivos y procedimientos.</a></label>
         <div class="invalid-feedback">
          Debe aceptar los terminos
        </div>
       </div>
 
 
       <div class="mt-2">
        <button name="submitBtn" type="submit" class="btn btn-primary">Enviar</button>
        
      </div>

 
       
      </div>

    


</div>
<!-- Fin de la Fila -->









     
 </form>

 </div>
 <?php 

require_once("./includes/footer.php");
?>
