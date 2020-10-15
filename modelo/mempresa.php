<?php 
class mempresa{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}

	public function insempresa($razsocialemp, $nitemp, $clasemp, $sedecentemp, $ciudemp, $emailemp, $telemp, $logemp){//Para insertar 
		$conexion = $this->conectar();
		$sql="INSERT INTO empresa (razsocialemp, nitemp, clasemp, sedecentemp, ciudemp, emailemp, telemp, logemp) VALUES (:razsocialemp, :nitemp, :clasemp, :sedecentemp, :ciudemp, :emailemp, :telemp, :logemp);";//Consulta SQL
		$result=$conexion->prepare($sql);//Prepara nuestra consulta
		$result->bindParam(':razsocialemp', $razsocialemp);
		$result->bindParam(':nitemp', $nitemp);
		$result->bindParam(':clasemp', $clasemp);
		$result->bindParam(':sedecentemp', $sedecentemp);
		$result->bindParam(':ciudemp', $ciudemp);
		$result->bindParam(':emailemp', $emailemp);
		$result->bindParam(':telemp', $telemp);
		$result->bindParam(':logemp',$logemp);//Aseguramos los datos para evitar SQL-Injection
		if(!$result)
	  		echo "<script>alert('ERROR al insertar Empresa');</script>";
	  	else
	  	$result->execute();
	  		echo "<script>alert('Empresa registrada correctamente...');</script>";
		}

	public function updempresa($idemp, $razsocialemp, $nitemp, $clasemp, $sedecentemp, $ciudemp, $emailemp, $telemp, $logemp){//Funcion para actualizar
		$conexion = $this->conectar();
		$sql="UPDATE empresa SET razsocialemp=:razsocialemp, nitemp=:nitemp, clasemp=:clasemp, sedecentemp=:sedecentemp, ciudemp=:ciudemp, emailemp=:emailemp, telemp=:telemp, logemp=:logemp WHERE idemp=:idemp";
		$result=$conexion->prepare($sql);
		//Reemplazo los parametro(PRECEDURE) por los recibidos desde el Controlador(funcion)
	 	$result->bindParam(':idemp',$idemp);
	 	$result->bindParam(':razsocialemp',$razsocialemp);
	 	$result->bindParam(':nitemp',$nitemp);
	 	$result->bindParam(':clasemp',$clasemp);
	 	$result->bindParam(':sedecentemp',$sedecentemp);
	 	$result->bindParam(':ciudemp',$ciudemp);
	 	$result->bindParam(':emailemp',$emailemp);
	 	$result->bindParam(':telemp',$telemp);
	 	$result->bindParam(':logemp',$logemp);//Aseguramos los datos para evitar SQL-Injection
		
		if(!$result)
			echo "<script>alert('Error al actualizar');</script>";
		else
			$result->execute();
			echo "<script>alert('Empresa Actualizado');</script>";
		}
	
	


	public function delempresa($idemp){//Función para eliminar
		$conexion = $this->conectar();
		$sql="DELETE FROM empresa where idemp=:idemp;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':idemp',$idemp);
		if(!$result)
			echo "<script>alert('Error al ELIMINAR');</script>";
		else
			$result->execute();
	}


	//1.3.5.2. Crear Funcion Cargar datos de un usuario al formulario para (Actualizar)
	public function sel_empresa_act($idemp){
		$resultado1 = NULL;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idemp, razsocialemp, nitemp, clasemp, sedecentemp, ciudemp, emailemp, telemp, logemp FROM empresa WHERE idemp=:idemp;";
		$result1 = $conexion->prepare($sql);
		$result1->bindParam(':idemp',$idemp);
		$result1->execute();
		while ($f1=$result1->fetch()){
			$resultado1[]=$f1;
		}
		return $resultado1;
	}



	public function sel_empresa($filtro,$rvini,$rvfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion(); 
		$sql = 'SELECT idemp, razsocialemp, nitemp, clasemp, sedecentemp, ciudemp, emailemp, telemp, logemp FROM empresa';
		if($filtro){
			$filtro = '%'.$filtro.'%';
			$sql .= ' WHERE razsocialemp LIKE :filtro';
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
		$sql = 'SELECT COUNT(idemp) AS Npe FROM empresa';
		if($filtro){
			$filtro = '%'.$filtro.'%';
			$sql .= ' WHERE razsocialemp LIKE "'.$filtro.'";';
		}
		//echo $sql;
		return $sql;
	}

	//1.3.5.1. Crear Funcion CARGA_DATOS [COMBOBOX]
	public function list_Tipodeempresa(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idval, nomval FROM valor;";
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