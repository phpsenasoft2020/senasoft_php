<?php 
//Inicializando la sesion y destruyendola
$car = isset($_GET['c']) ? $_GET['c']:NULL;
if($car){
	session_start();
	session_destroy();
	echo "<script type='text/javascript'>window.location='../index.php';</script>";
		}else{
	session_destroy();
	echo "<script type='text/javascript'>window.location='index.php';</script>";
		//Salimos del Sistema
		exit();
}	

