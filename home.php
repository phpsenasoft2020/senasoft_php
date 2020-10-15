 <?php
    require_once('modelo/mseguridad.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
      date_default_timezone_set('America/Bogota');
      $ano = date('Y');
      $hoy = date('Y-m-d');
  ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <title>Siigo | Página principal</title>
  <link rel="shortcut icon" href="image/favicon.png">
  <link rel="stylesheet" type="text/css" href="css/sb-admin-2.css">
  <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/background.css">
  <link rel="stylesheet" type="text/css" href="css/botonesp.css">
  <link rel="stylesheet" type="text/css" href="css/search.css">
  <link rel="stylesheet" type="text/css" href="css/carga.css">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/scroll.css">
  <!-- Fuentes -->
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/carini.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <!-- Iconos del menu -->
  <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
  <link rel="stylesheet" type="text/css" href="css/icon.css">
  <link rel="stylesheet" href="css/main.css">
  <!-- Hoja de estilos -->
  <link href="css/style1.css" rel="stylesheet">
  <!-- Google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Muli:400,700&display=swap" rel="stylesheet">
  <!-- Ionic icons -->
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
  <script type="text/javascript" src="js/valida.js"></script>
</head>
<body>
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
 <?php
  $nombre = isset($_SESSION["nomusu"]) ? $_SESSION["nomusu"]:NULL;
  $perfil = isset($_SESSION["pefid"]) ? $_SESSION["pefid"]:NULL;
 require_once("vista/vmenuh.php") ?>
 <div id="content" class="container-fluid espca">
  <?php 
      $pg = isset($_GET["pg"]) ? $_GET["pg"]:NULL;
      //Llamamos metodo
      if ($pg == 14) require_once('vista/vfact.html');
      moscon($perfil, $pg);
  ?>
  <div class="pie">
 </div>
 </div>
 <!-- Bootstrap y JQuery -->
  <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <!--Llamamos la libreria - JQUERY [Comportamiento SW]-->
  <script type="text/javascript" src="js/chosen.jquery.js"></script>
    <!--Llamamos la libreria - JQUERY [Po]-->
  <script type="text/javascript" src="js/personal.js"></script>
  <script src="js/jquery1.js"></script>
  <script src="js/bootstrap.min1.js"></script>
  <!-- Abrir / cerrar menu -->
  <script>
    $("#menu-toggle").click(function (e) {
      e.preventDefault();
      $("#content-wrapper").toggleClass("toggled");
    });
  </script>
  <script>
      window.onload = function(){
        var contenedor = document.getElementById('loader-wrapper');

        contenedor.style.visibility = 'hidden';
        contenedor.style.opacity = '0';
      }

      $(document).ready(function() {
 
      // Fakes the loading setting a timeout
      setTimeout(function() {
        $('body').addClass('loaded');
      }, 'loader-wrapper');

      });
    </script>
</body>
</html>