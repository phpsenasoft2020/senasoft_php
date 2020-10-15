<?php
	require_once('modelo/conexion.php');
	require_once('modelo/mmen.php');

	$mmen = new mmen();
	$pagmen = isset($_POST['pagmen']) ? $_POST['pagmen']:NULL;
	function mosmen($pagmen,$pefid,$nombre){
		$mmen=new mmen();
		$result = $mmen->selmen($pagmen, $pefid);
		$noti = $mmen->selnot();
		$noti2 = $mmen->selnot2();
		$pm = strtolower($pagmen);
				//Inicializamos la variable
				$txt ='';
				if ($result){
				$txt .='<div class="d-flex" id="content-wrapper">';
				$txt .='<div id="sidebar-container" class="bg-light border-right">';
				$txt .='<div class="logo">';
				$txt .='<h4 class="font-weight-bold mb-0">Menú</h4>';
				$txt .='</div>';
				//Imprimimos el menu
				foreach ($result as $f){
						$txt .='<div class="menu list-group-flush">';
							$txt .= "<a  href='".$pm.".php?pg=".$f['pagid']."' class='list-group-item list-group-item-action text-muted bg-light p-2.5 border-0'><i style='margin-left: 5px;margin-top: 5px;width: 25px;' class='".$f["icono"]."'></i><small>".strtoupper($f['pagnom'])."</small></a>";
						$txt .='</div>';
					}
				$txt .='</div>';
				$txt .='<div id="page-content-wrapper" class="w-100 bg-light-blue">';

      		$txt .='<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">';
        	$txt .='<div class="container">';

        	$txt .='<button class="btn btn-primary text-primary" id="menu-toggle"><i class="fas fa-ellipsis-v"></i></button>';

          	$txt .='<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
            	$txt .='<span class="navbar-toggler-icon"></span>';
          	$txt .='</button>';

          	$txt .='<div class="collapse navbar-collapse" id="navbarSupportedContent">';
            	$txt .='<ul class="navbar-nav ml-auto mt-2 mt-lg-0">';
              	$txt .='<li class="nav-item active">';
                $txt .='<a class="nav-link text-dark" href="home.php">Inicio</a>';
              	$txt .='</li>';

              	foreach ($noti as $fi){
              	$txt .='<li class="nav-item dropdown no-arrow mx-1">';
              $txt .='<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $txt .='<i class="fas fa-bell fa-fw"></i>';
                $txt .='<span class="badge badge-danger badge-counter">'.$fi["cont"].'</span>';
              $txt .='</a>';
              $txt .='<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">';
                $txt .='<h6 class="dropdown-header">';
                  $txt .='Centro de alertas';
                $txt .='</h6>';
                $txt .='<a class="dropdown-item d-flex align-items-center" href="#">';
                  $txt .='<div class="mr-3">';
                    $txt .='<div class="icon-circle bg-warning">';
                      $txt .='<i class="fas fa-exclamation-triangle text-white"></i>';
                    $txt .='</div>';
                  $txt .='</div>';
                  $txt .='<div>';
                  if ($fi["fechanoti"]){
                  	$txt .='<div class="small text-gray-500">'.$fi["fechanoti"].'</div>';
                  }
                    
                    /*
                    foreach ($noti2 as $fii){
                    $txt .='<div>'.$fii["contnoti"].'</div>';
                  $txt .='</div>';
                  */
                $txt .='</a>';
              $txt .='</div>';
            $txt .='</li>';
            }





              	$txt .='<li class="nav-item dropdown">';
                $txt .='<a class="nav-link text-dark dropdown-toggle" href="#" id="navbarDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
      				//Colocamos el nick de la sesion y MNSde bienvenida
                  echo $txt;
        			$txt ="<span style='font-size: 15px; padding-left: 20px;'>".$nombre."</span>";


                	$txt .='</a>';

                	$txt .='<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">';
                  	$txt .='<a class="dropdown-item" href="home.php?pg=10">Mi perfil</a>';
                  	/*$txt .='<a class="dropdown-item" href="home.php?pg=11">Configuracion</a>';*/
                  	$txt .='<div class="dropdown-divider"></div>';
                  	$txt .='<a class="dropdown-item" href="home.php?pg=150">Cerrar sesión</a>';
                	$txt .='</div>';
              	$txt .='</li>';
            	$txt .='</ul>';
          	$txt .='</div>';
        	$txt .='</div>';
      	$txt .='</nav>';
      	
			 echo $txt;	
		}
	}
	
function moscon($pefid, $pg){
		$mmen=new mmen();

		if($pefid==1){
			if(!$pg) $pg=8;
		}else if($pefid==2){
			if(!$pg) $pg=107;
		}elseif($pefid==3){
			if(!$pg) $pg=004;
		}elseif($pefid==4){
			if(!$pg) $pg=004;
		}elseif($pefid==5){
			if(!$pg) $pg=004;
		}else{
			if(!$pg) $pg=150;
		}
		$result = $mmen->selpgact($pg, $pefid);

		if ($result){
			foreach ($result as $f){
				require_once($f['pagarc']);
			}
		}else{
			echo "<br><br><br><br><br><center><span class='txtbold'>&nbsp;&nbsp;&nbsp;&nbsp;<h4>Usted no tiene permisos para ingresar a este formulario. Por favor comuniquese con su administrador.</h4></span></center><br><br><br><br><br><br>";
		}
	}




	function mosini($pg){
		$mmen=new mmen();
		
		if(!$pg) $pg=150;

		$result = $mmen->selpgini($pg);

		if ($result){
			foreach ($result as $f){
				require_once($f['pagarc']);
			}
		}else{
			echo "<br><br><br><br><br><span class='txtbold'>&nbsp;&nbsp;&nbsp;&nbsp;Usted no tiene permisos para ingresar a este formulario. Por favor comuniquese con su administrador.</span><br><br><br><br><br><br>";
		}
	}
?>