<?php
    session_start();
    require_once('../modelo/conexion.php');//Incluimos los archivos de conexión y modelo de consultas SQL
    require_once('../modelo/mfact.php');
    $mfact = new mfact();//Llamamos a la clase contenida en el archivo

    $idprod = isset($_POST['idprod']) ? $_POST['idprod']:NULL;
    //$idemp = isset($_SESSION['idusu']) ? $_SESSION['idusu']:NULL;
    //$tipemp = isset($_SESSION['tipusu']) ? $_SESSION['tipusu']:NULL;
    $idfact = isset($_SESSION['idfac']) ? $_SESSION['idfac']:NULL;
    $idfac = isset($_POST['idfact']) ? $_POST['idfact']:NULL;
    $idemp = 1;
    $subtotal = isset($_POST['subtotal']) ? $_POST['subtotal']:NULL;
    $iva = isset($_POST['iva']) ? $_POST['iva']:NULL;
    $total = isset($_POST['total']) ? $_POST['total']:NULL;
    $operacion = isset($_POST['operacion']) ? $_POST['operacion']:NULL;
    //Declaramos variables, en caso de no existir les asigna un valor nulo

    if ($operacion == 'AddProduct') $mfact->seleccionar($idfact);
    if ($operacion == 'AddProd') $mfact->detalleadd($idfact,$idprod);
    if ($operacion == 'QuitProd') $mfact->detallequit($idfact,$idprod);
    if ($operacion == 'AddFact'){
        if($idfac)
            $mfact->insertar($idemp,0,0,0,'1');
        else {
            $_SESSION['idfac'] = $idfac;
            echo 'Listo';
        }
    }
    if ($operacion == 'UpdFact') $mfact->actualizar($idemp,$subtotal,$iva,$total,$idfact);
    //echo $idemp.' - '.$subtotal.' - '.$iva.' - '.$total.' - '.$idfact
    /*if ($operacion == 'Insertar') $mfact->insfact($idfact,$nomfact,$depfact);
    if ($operacion == 'Eliminar') $mfact->delfact($idfact);
    if ($operacion == 'Seleccionar') $mfact->seleccionar($idfact);
    if ($operacion == 'Actualizar') $mfact->updfact($idfact,$nomfact,$depfact);*/

    //Dependiendo la operación el sistema envía los datos hacia las funciones dentro del modelo
?>