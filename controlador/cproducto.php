<?php
    //require_once('..modelo/mseguridad.php');
    require_once('../modelo/conexion.php');//Incluimos los archivos de conexión y modelo de consultas SQL
    require_once('../modelo/mproducto.php');
    //1.3. Instanciamos el modelo a variable php
    $pg = 5;
    //variable $arc
    $arc = "home.php";

    $mprod = new mproducto();//Llamamos a la clase contenida en el archivo
    $operacion = isset($_POST['operacion']) ? $_POST['operacion']:NULL;
    $idprod = isset($_POST['idprod']) ? $_POST['idprod']:NULL;
    $nomprod = isset($_POST['nombre']) ? $_POST['nombre']:NULL;
    $precioprod = isset($_POST['precio']) ? $_POST['precio']:NULL;
    $cantprod = isset($_POST['cantidad']) ? $_POST['cantidad']:NULL;
    $unidprod = isset($_POST['paq']) ? $_POST['paq']:0;
    $idbod = 1;
    //$idbod = isset($_POST['idbod']) ? $_POST['idbod']:NULL;
    $filtro = isset($_POST['buscar']) ? $_POST['buscar']:NULL;//Declaramos variables, en caso de no existir les asigna un valor nulo
    
    if ($operacion == 'ciudades') $mprod->selproducto();
    if ($operacion == 'mosprod') $mprod->selprod($filtro);
    if ($operacion == 'mosprodID') $mprod->selprodID($filtro);
    if ($operacion == 'Insertar'){
        if($nomprod and $precioprod and $cantprod and $idbod) $mprod->insproducto($nomprod,$precioprod,$cantprod,$unidprod,$idbod);
        else echo 'Llenar todos los campo';
    }
    if ($operacion == 'Eliminar') $mprod->delproducto($idprod);
    if ($operacion == 'Seleccionar') $mprod->seleccionar($idprod);
    if ($operacion == 'Actualizar') $mprod->updproducto($idprod,$nomprod,$precioprod,$cantprod,$unidprod,$idbod);

    //Dependiendo la operación el sistema envía los datos hacia las funciones dentro del modelo
?>