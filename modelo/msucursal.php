<?php 
class msucursal{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}

	public function inssucursal($nomsuc,$dirsuc,$ciusuc,$telsuc){//Para insertar 
		$conexion = $this->conectar();
		$sql="INSERT INTO sucursal(nomsuc,dirsuc,ciusuc,telsuc) values (:nomsuc,:dirsuc,:ciusuc,:telsuc);";//Consulta SQL
		$result=$conexion->prepare($sql);//Prepara nuestra consulta
		$result->bindparam(':nomsuc',$nomsuc);
		$result->bindparam(':dirsuc',$dirsuc);
		$result->bindparam(':ciusuc',$ciusuc);
		$result->bindparam(':telsuc',$telsuc);//Aseguramos los datos para evitar SQL-Injection
		if(!$result)
	  		echo "<script>alert('ERROR al insertar Sucursal');</script>";
	  	else
	  	$result->execute();
	  		echo "<script>alert('Sucursal registrado correctamente...');</script>";
		}


	public function updsucursal($idsuc,$nomsuc,$dirsuc,$ciusuc,$telsuc){//Funcion para actualizar
		$conexion = $this->conectar();
		$sql="UPDATE sucursal SET nomsuc=:nomsuc,dirsuc=:dirsuc,ciusuc=:ciusuc,telsuc=:telsuc where idsuc=:idsuc;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':idsuc',$idsuc);
		$result->bindparam(':nomsuc',$nomsuc);
		$result->bindparam(':dirsuc',$dirsuc);
		$result->bindparam(':ciusuc',$ciusuc);
		$result->bindparam(':telsuc',$telsuc);//Aseguramos los datos para evitar SQL-Injection
		
		if(!$result)
			echo "<script>alert('Error al actualizar');</script>";
		else
			$result->execute();
			echo "<script>alert('Sucursal Actualizado');</script>";
		}
	


	public function delsucursal($idsuc){//Función para eliminar
		$conexion = $this->conectar();
		$sql="DELETE FROM sucursal where idsuc=:idsuc;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':idsuc',$idsuc);
		if(!$result)
			echo "<script>alert('Error al ELIMINAR');</script>";
		else
			$result->execute();
	}


	//1.3.5.2. Crear Funcion Cargar datos de un usuario al formulario para (Actualizar)
	public function sel_sucursal_act($idsuc){
		$resultado1 = NULL;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idsuc, nomsuc, dirsuc, ciusuc, telsuc FROM sucursal WHERE idsuc=:idsuc;";
		$result1 = $conexion->prepare($sql);
		$result1->bindParam(':idsuc',$idsuc);
		$result1->execute();
		while ($f1=$result1->fetch()){
			$resultado1[]=$f1;
		}
		return $resultado1;
	}



	public function sel_sucursal($filtro,$rvini,$rvfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion(); 
		$sql = 'SELECT idsuc,nomsuc,dirsuc,ciusuc,telsuc FROM sucursal';
		if($filtro){
			$filtro = '%'.$filtro.'%';
			$sql .= ' WHERE nomsuc LIKE :filtro';
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
		$sql = 'SELECT COUNT(idsuc) AS Npe FROM sucursal';
		if($filtro){
			$filtro = '%'.$filtro.'%';
			$sql .= ' WHERE nomsuc LIKE "'.$filtro.'";';
		}
		//echo $sql;
		return $sql;
	}


	//1.3.5.1. Crear Funcion CARGA_DATOS [COMBOBOX]
	public function list_Empresa(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idemp, razsocialemp FROM empresa;";
		$result = $conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
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

}
?>