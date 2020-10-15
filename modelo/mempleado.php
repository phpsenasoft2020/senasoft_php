<?php 
class mempleado{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}

	public function insempleado($nomusu, $apeusu, $tipdocusu, $nodocusu, $fechnac, $dirusu, $ciudusu, $telusu, $celusu, $emausu, $pasusu, $idsuc, $tipusu){//Para insertar 
		$conexion = $this->conectar();
		$sql="INSERT INTO usuario (nomusu, apeusu, tipdocusu, nodocusu, fechnac, dirusu, ciudusu, telusu, celusu, emausu, pasusu, idsuc, tipusu) VALUES (:nomusu, :apeusu, :tipdocusu, :nodocusu, :fechnac, :dirusu, :ciudusu, :telusu, :celusu, :emausu, :pasusu, :idsuc, :tipusu);";//Consulta SQL
		$result=$conexion->prepare($sql);//Prepara nuestra consulta
		$result->bindParam(':nomusu', $nomusu);
		$result->bindParam(':apeusu', $apeusu);
		$result->bindParam(':tipdocusu', $tipdocusu);
		$result->bindParam(':nodocusu', $nodocusu);
		$result->bindParam(':fechnac', $fechnac);
		$result->bindParam(':dirusu', $dirusu);
		$result->bindParam(':ciudusu', $ciudusu);
		$result->bindParam(':telusu',$telusu);
		$result->bindParam(':celusu',$celusu);
		$result->bindParam(':emausu',$emausu);
		$result->bindParam(':pasusu',$pasusu);
		$result->bindParam(':idsuc',$idsuc);
		$result->bindParam(':tipusu',$tipusu);//Aseguramos los datos para evitar SQL-Injection
		if(!$result)
	  		echo "<script>alert('ERROR al insertar empleado');</script>";
	  	else
	  	$result->execute();
	  		echo "<script>alert('empleado registrada correctamente...');</script>";
		}

	public function updempleado( $idusu, $nomusu, $apeusu, $tipdocusu, $nodocusu, $fechnac, $dirusu, $ciudusu, $telusu, $celusu, $emausu, $pasusu, $idsuc, $tipusu){//Funcion para actualizar
		$conexion = $this->conectar();
		$sql="UPDATE usuario SET nomusu=:nomusu, apeusu=:apeusu, tipdocusu=:tipdocusu, nodocusu=:nodocusu, fechnac=:fechnac, dirusu=:dirusu, ciudusu=:ciudusu, telusu=:telusu, celusu=:celusu, emausu=:emausu, pasusu=:pasusu, idsuc=:idsuc, tipusu=:tipusu WHERE idusu=:idusu";
		$result=$conexion->prepare($sql);
		//Reemplazo los parametro(PRECEDURE) por los recibidos desde el Controlador(funcion)
	 	$result->bindParam(':idusu',$idusu);
	 	$result->bindParam(':nomusu', $nomusu);
		$result->bindParam(':apeusu', $apeusu);
		$result->bindParam(':tipdocusu', $tipdocusu);
		$result->bindParam(':nodocusu', $nodocusu);
		$result->bindParam(':fechnac', $fechnac);
		$result->bindParam(':dirusu', $dirusu);
		$result->bindParam(':ciudusu', $ciudusu);
		$result->bindParam(':telusu',$telusu);
		$result->bindParam(':celusu',$celusu);
		$result->bindParam(':emausu',$emausu);
		$result->bindParam(':pasusu',$pasusu);
		$result->bindParam(':idsuc',$idsuc);
		$result->bindParam(':tipusu',$tipusu);//Aseguramos los datos para evitar SQL-Injection
		
		if(!$result)
			echo "<script>alert('Error al actualizar');</script>";
		else
			$result->execute();
			echo "<script>alert('empleado Actualizado');</script>";
		}
	
	


	public function delempleado($idusu){//Función para eliminar
		$conexion = $this->conectar();
		$sql="DELETE FROM usuario where idusu=:idusu;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':idusu',$idusu);
		if(!$result)
			echo "<script>alert('Error al ELIMINAR');</script>";
		else
			$result->execute();
	}


	//1.3.5.2. Crear Funcion Cargar datos de un usuario al formulario para (Actualizar)
	public function sel_empleado_act($idusu){
		$resultado1 = NULL;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT(idusu, nomusu, apeusu, tipdocusu, nodocusu, fechnac, dirusu, ciudusu, telusu, celusu, emausu, pasusu, actusu, idsuc, tipusu FROM usuario WHERE idusu=:idusu;";
		$result1 = $conexion->prepare($sql);
		$result1->bindParam(':idusu',$idusu);
		$result1->execute();
		while ($f1=$result1->fetch()){
			$resultado1[]=$f1;
		}
		return $resultado1;
	}



	public function sel_empleado($filtro,$rvini,$rvfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion(); 
		$sql = 'SELECT idusu, nomusu, apeusu, tipdocusu, nodocusu, fechnac, dirusu, ciudusu, telusu, celusu, emausu, pasusu, actusu, idsuc, tipusu FROM usuario';
		if($filtro){
			$filtro = '%'.$filtro.'%';
			$sql .= ' WHERE nomusu LIKE :filtro';
		}
		$sql .= ' LIMIT '.$rvini.', '.$rvfin.';';
		$result = $conexion->prepare($sql);
		if($filtro){
			$result->bindParam(':filtro',$filtro);
		}
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}


	public function selcount($filtro){
		$sql = 'SELECT COUNT(idusu) AS Npe FROM usuario';
		if($filtro){
			$filtro = '%'.$filtro.'%';
			$sql .= ' WHERE nomusu LIKE "'.$filtro.'";';
		}
		//echo $sql;
		return $sql;
	}

	//1.3.5.1. Crear Funcion CARGA_DATOS [COMBOBOX]
	public function list_Perfil(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pefid, pefnom FROM perfil;";
		$result = $conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	//1.3.5.1. Crear Funcion CARGA_DATOS [COMBOBOX]
	public function list_Tipodedocumento(){
		$resultado2 = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idval, nomval FROM valor where idparam=1;";
		$result2 = $conexion->prepare($sql);
		$result2->execute();
		while($f=$result2->fetch()){
			$resultado2[]=$f;
		}
		return $resultado2;
	}


	//1.3.5.1. Crear Funcion CARGA_DATOS [COMBOBOX]
	public function list_Sucursal(){
		$resultado3 = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idsuc, nomsuc FROM sucursal;";
		$result3 = $conexion->prepare($sql);
		$result3->execute();
		while($f=$result3->fetch()){
			$resultado3[]=$f;
		}
		return $resultado3;
	}

	//... Consultamos los departamentos
	public function selubi(){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT * FROM ubicacion WHERE depende=0;";
		$result=$conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}


	//... Crear Funciona ACTUALIZAR_estado Usuario()
	public function upd_act_emp($activo,$idusu){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion(); 
		$sql = "UPDATE usuario SET actusu=:activo WHERE idusu=:idusu;";
		$result = $conexion->prepare($sql);
		$result->bindParam(':activo',$activo);
		$result->bindParam(':idusu',$idusu);
		if(!$result)
			echo "<script>alert('Error al actualizar');</script>";
		else
			$result->execute();
			//echo "<script>alert('Usuario Actualizado');</script>";
	}

}
?>