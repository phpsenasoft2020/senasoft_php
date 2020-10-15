<?php
    require_once('../modelo/conexion.php');//Incluimos los archivos de conexión y modelo de consultas SQL
    require_once('../modelo/mubicacion.php');
    //1.3. Instanciamos el modelo a variable php
    $pg = 12;
    //variable $arc
    $arc = "home.php";
    $mubi = new mubicacion();//Llamamos a la clase contenida en el archivo
    $operacion = isset($_POST['operacion']) ? $_POST['operacion']:NULL;
    $idubi = isset($_POST['idubi']) ? $_POST['idubi']:NULL;
    $nomubi = isset($_POST['nombre']) ? $_POST['nombre']:NULL;
    $depubi = isset($_POST['depende']) ? $_POST['depende']:NULL;
    $filtro = isset($_POST['buscar']) ? $_POST['buscar']:NULL;//Declaramos variables, en caso de no existir les asigna un valor nulo

    if ($operacion == 'ciudades') $mubi->selubicacion();
    if ($operacion == 'mosubi') $mubi->selubi($filtro);
    if ($operacion == 'Insertar') $mubi->insubicacion($idubi,$nomubi,$depubi);
    if ($operacion == 'Eliminar') $mubi->delubicacion($idubi);
    if ($operacion == 'Seleccionar') $mubi->seleccionar($idubi);
    if ($operacion == 'Actualizar') $mubi->updubicacion($idubi,$nomubi,$depubi);

    //Dependiendo la operación el sistema envía los datos hacia las funciones dentro del modelo
?>