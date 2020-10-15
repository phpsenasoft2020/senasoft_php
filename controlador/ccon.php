<?php
require_once('modelo/conexion.php');
require_once('modelo/mcon.php');
require_once('modelo/mpaginacion.php');
$pg = 1001;
$arc = "home.php";
$mcon = new mcon();
$idconf = isset($_POST['idconf']) ? $_POST['idconf']:NULL;
if(!$idconf){

$idconf = isset($_GET['idconf']) ? $_GET['idconf']:NULL;
}
$nit = isset($_POST['nit']) ? $_POST['nit']:NULL;
$nomemp = isset($_POST['nomemp']) ? $_POST['nomemp']:NULL;
$dircon = isset($_POST['dircon']) ? $_POST['dircon']:NULL;
$mosdir = isset($_POST['mosdir']) ? $_POST['mosdir']:NULL;
$telcon = isset($_POST['telcon']) ? $_POST['telcon']:NULL;
$mostel = isset($_POST['mostel']) ? $_POST['mostel']:NULL;
$celcon = isset($_POST['celcon']) ? $_POST['celcon']:NULL;
$moscel = isset($_POST['moscel']) ? $_POST['moscel']:NULL;
$emacon = isset($_POST['emacon']) ? $_POST['emacon']:NULL;
$mosema = isset($_POST['mosema']) ? $_POST['mosema']:NULL;
$consen = isset($_POST['consen']) ? $_POST['consen']:NULL;
$logocon = isset($_FILES['logocon'] ['name']) ? $_FILES['logocon'] ['name']:NULL;
$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
$url = NULL;
if (!$opera) {
$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;	# code...
}


// --------------------
if($logocon){
	$url="";
		$tam = $_FILES['logocon']['size']<20000;
		$tip = $_FILES['logocon']['type'];
		$ext = pathinfo($_FILES['logocon']['name'], PATHINFO_EXTENSION);
		if($ext=="jpg" or $ext=="png" or $ext=="JPG" or $ext=="PNG"){
			$target_path="image/"; //crea una carpeta si no existe
			if(!file_exists($target_path)) mkdir($target_path, 0777, true);
			$target_path =  $target_path.basename($logocon);
			if(move_uploaded_file($_FILES['logocon']['tmp_name'], $target_path)){ 
				echo "<script>alert('La imagen se a cargado exitosamente');</script>";
				$url= substr($target_path,6);
				
			}else{
				echo "<script>alert('Error al cargar la imagen');</script>";}
		}else{
			echo "<script>alert('Tipo de formato no permitido solo se admiten fotos con la extencion jpg');</script>";
		}
	}

// -------------------


// echo "<br>".$opera."_".$idconf."_".$nit."_".$nomemp."_". $dircon."_".$mosdir."_". $telcon."_". $mostel."_". $celcon."_". $moscel."_". $emacon."_". $mosema."_".$logocon."-".$consen."<br>";
if($opera=="insertar"){

	if($nit && $nomemp && $dircon  && $mosdir && $mostel  && $moscel && $mosema  && $logocon && $consen){
		$result=$mcon->insconf($nit, $nomemp, $dircon, $mosdir, $telcon, $mostel, $celcon, $moscel, $emacon, $mosema, $consen, $url);
		$idconf = "";
	}else{

		echo "<script>alert('FAVOR LLENAR TODOS LOS CAMPOS')</script>";
	}
	$opera = "";
}



if($opera=="Actualizar"){
	if ($idconf && $nit && $nomemp && $dircon  && $mosdir && $mostel  && $moscel && $mosema && $consen ){
		if(!$url){
			$j=$mcon->selconf1($idconf,2);
			$logocon = $j[0][0];
		}else{
			$logocon = $url;
		}

		$result=$mcon->updconf($idconf,$nit, $nomemp, $dircon, $mosdir, $telcon, $mostel, $celcon, $moscel, $emacon, $mosema, $logocon,$consen);
		$idconf = "";
	} else{
		echo "<script>alert('HAY CAMPOS VACIOS')</script>";
	}
	$opera = "";
}

//ELIMINAR
if($opera=="Eliminar"){
	if($idconf){
		$result=$mcon->elipag($idconf);
		$idconf = "";
	}
	else{
		echo "<script>alert('ERROR AL ELIMINAR')</script>";
	}
	$opera = "";
}

//PAGINACION




//FUNCION SELECCIONAR

function seleccionar($idconf, $pg){
	$mcon=new mcon();
	if($idconf){
		$result=$mcon->selconf5($idconf);
	}

	$result=$mcon->selconf5();
	$dttipd = $mcon->seltipd();
	$txt = '<form action="home.php?pg='.$pg.'" enctype="multipart/form-data" method="POST" id="form" id="form">';
	$txt .='<div class="container">';
	$txt .= '<div class="row">';
	$txt .= '<div class="col-md-12">';
	$txt .= '<center>';
	$txt .= '<h1>Configuraci&oacuten</h1>';
	$txt .= '</center>';
	$txt .= '</div>';
	$txt .= '</div>';
	$txt .= '<hr>';
	$txt .= '<div class="form-group">';
	$txt .= '<label>Id</label>';
	$txt .= '<input class="form-control" type="number" name="idconf" maxlenght="11" value="';
	if($idconf OR $result) $txt .= $result[0]['idconf'];	
	$txt .= '"required readonly>';
	$txt .= '</div>';



	$txt .= '<div class="form-group">';
	$txt .= '<label>Nit</label>';
	$txt .= '<input class="form-control" type="text" name="nit" maxlength="13"  value="';
	if($idconf OR $result) $txt .= $result[0]['nit'];
	$txt .= '"required>';
	$txt .= '</div>';

	$txt .= '<div class="form-group">';
	$txt .= '<label>Nombre empresa</label>';
	//$txt .= '<input class="form-control" type="text" name="nomemp" maxlength="200" value="';
	$txt .= '<textarea class="form-control" name="nomemp">';
		if($idconf OR $result) $txt .= $result[0]['nomemp'];
	$txt .= '</textarea>';
	//$txt .= '" required>';
	$txt .= '</div>';

	$txt .= '<div class="form-group">';
	$txt .= '<label>Direcci&oacute;n</label>';
	$txt .= '<input class="form-control" type="text" name="dircon" maxlength="150"  value="';
	if($idconf OR $result) $txt .= $result[0]['dircon'];
	$txt .= '"required>';
	$txt .= '</div>';


$txt .= '<label>Mostrar Direcci&oacute;n</label>';

$txt .= 	'<div class="radio">';
 $txt .=  '<label>';
 $txt .=    '<input type="radio" name="mosdir" value="1"';
 if($result[0]['mosdir']==1){
 	$txt .= ' checked>';
 }else{
 	$txt .= '>';
 }
 $txt .=    'Si';
 $txt .=  '</label>';
 $txt .= "&nbsp;&nbsp;&nbsp;";$txt .= "&nbsp;&nbsp;&nbsp;";
  $txt .=  '<label>';
 $txt .=    '<input type="radio" name="mosdir"  value="2"';
 if($result[0]['mosdir']==2){
 	$txt .= ' checked>';
 }else{
 	$txt .= '>';
 }
 $txt .=    'No';
 $txt .=  '</label>';
$txt .=  '</div>';



$txt .= '<div class="form-group">';
	$txt .= '<label>Tel&eacute;fono</label>';
	$txt .= '<input class="form-control" type="number" name="telcon" min="0" max="9999999999" value="';
	if($idconf OR $result) $txt .= $result[0]['telcon'];
	$txt .= '">';
	$txt .= '</div>';

 $txt .= '<label>Mostrar Tel&eacute;fono</label>';
 $txt .= 	'<div class="radio">';
 $txt .=  '<label>';
 $txt .=    '<input type="radio" name="mostel"  value="1"';
if($result[0]['mostel']==1){
 	$txt .= ' checked>';
 }else{
 	$txt .= '>';
 }
 $txt .=    'Si ';
 $txt .=  '</label>';
 $txt .= "&nbsp;&nbsp;&nbsp;";
$txt .= "&nbsp;&nbsp;&nbsp;";
  $txt .=  '<label>';
 $txt .=    '<input type="radio" name="mostel"  value="2"';
if($result[0]['mostel']==2){
 	$txt .= ' checked>';
 }else{
 	$txt .= '>';
 }
 $txt .=    ' No';
 $txt .=  '</label>';
$txt .=  '</div>';




$txt .= '<div class="form-group">';
	$txt .= '<label>celular</label>';
	$txt .= '<input class="form-control" type="number" name="celcon" min="0" max="9999999999" value="';
	if($idconf OR $result) $txt .= $result[0]['celcon'];
	$txt .= '">';
	$txt .= '</div>';

$txt .= '<label>Mostrar celular</label>';


$txt .= 	'<div class="radio">';
 $txt .=  '<label>';
 $txt .=    '<input type="radio" name="moscel" value="1"';
if($result[0]['moscel']==1){
 	$txt .= ' checked>';
 }else{
 	$txt .= '>';
 }
 $txt .=    'Si';
 $txt .=  '</label>';
 $txt .= "&nbsp;&nbsp;&nbsp;";
$txt .= "&nbsp;&nbsp;&nbsp;";
  $txt .=  '<label>';
 $txt .=    '<input type="radio" name="moscel"  value="2"';
 if($result[0]['moscel']==2){
 	$txt .= ' checked>';
 }else{
 	$txt .= '>';
 }
 $txt .=    'No';
 $txt .=  '</label>';
$txt .=  '</div>';



$txt .= '<div class="form-group">';
	$txt .= '<label>E-mail</label>';
	$txt .= '<input class="form-control" type="Email" name="emacon" maxlength="100" value="';
	if($idconf OR $result) $txt .= $result[0]['emacon'];
	$txt .= '">';
	$txt .= '</div>';

$txt .= '<label>Mostrar E-mail</label>';
$txt .= 	'<div class="radio">';
 $txt .=  '<label>';
 $txt .=    '<input type="radio" name="mosema" value="1"';
 if($result[0]['mosema']==1){
 	$txt .= ' checked>';
 }else{
 	$txt .= '>';
 }
 $txt .=    'Si';
 $txt .=  '</label>';
 $txt .= "&nbsp;&nbsp;&nbsp;";
$txt .= "&nbsp;&nbsp;&nbsp;";
  $txt .=  '<label>';
 $txt .=    '<input type="radio" name="mosema"  value="2"';
 if($result[0]['mosema']==2){
 	$txt .= ' checked>';
 }else{
 	$txt .= '>';
 }
 $txt .=    'No';
 $txt .=  '</label>';
$txt .=  '</div>';


	$txt .= '<div class="form-group">';
	$txt .= '<label>Consentimiento  Informado</label>';
	//$txt .= '<input class="form-control" type="text" name="consen"   value="';
	$txt .= '<textarea class="form-control" name="consen">';
	if($idconf OR $result) $txt .= $result[0]['consen'];
	$txt .= '</textarea>';
	//$txt .= '" required>';
	$txt .= '</div>';

$txt .= '<input type="hidden" name="opera" value="';
if($idconf OR $result){ $txt .= 'Actualizar">'; } else { $txt .= 'insertar">'; }



$txt .= '<div class="form-group">';
	$txt .= '<label>Logo</label>';
	$txt .= '<input type="hidden" name="MAX_FILE_SIZE" value="200000" />';
	$txt .= '<input type="file"  maxlength="100"  name="logocon">';
	$txt .='<img style="padding: 10px;width: 150px;" src="image/';
	if($result[0]["logocon"]){
		$txt .=$result[0]["logocon"].'">';
		}else{
			$txt.='">';
	}
$txt .=  '</div>';

	$txt .= '<input type="hidden" name="opera" value="';
		if($idconf OR $result){ $txt .= "Actualizar"; } else { $txt .= "insertar"; }
	$txt .= '"><br><center><button type="submit" class="btn btn-outline-primary"">';
		if($idconf OR $result){ $txt .= "Actualizar"; } else { $txt .= "Registrar"; }
	$txt .= '</button>';
	$txt .= '&nbsp;&nbsp;&nbsp;';

	/*$txt .= '<input type="reset" class="btn btn-success" value="';
		if($idconf OR $result){ $txt .= "Cancelar"; } else { $txt .= "Limpiar"; }
	$txt .= '"';
		if($idconf OR $result) $txt .= " onclick='window.history.back();' ";
	$txt .= ' />';*/
	$txt .= ' </div>';
	$txt .= '<BR>';
					$txt .= '<BR>';
					$txt .= '<BR>';
					
	$txt .= '</form></div>';



	echo $txt;
	}
?>