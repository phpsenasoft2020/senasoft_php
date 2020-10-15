<?php 
class mcompra{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}

	public function inscompra($idcom, $fechcom, $idfac, $confcom, $recibido){//Para insertar 
		$conexion = $this->conectar();
		$$sql="INSERT INTO compra (idcom, fechcom, idfac, confcom, recibido) VALUES (:idcom, :fechcom, :idfac, :confcom, :recibido);";//Consulta SQL
		$result=$conexion->prepare($sql);//Prepara nuestra consulta
		$result->bindParam(':idcom', $idcom);
		$result->bindParam(':fechcom', $fechcom);
		$result->bindParam(':idfac', $idfac);
		$result->bindParam(':confcom', $confcom);
		$result->bindParam(':recibido', $recibido);//Aseguramos los datos para evitar SQL-Injection
		if(!$result)
			echo "<script>alert('Error al registrar compra');</secript>";//Si hay errores no ejecuta y muestra mensaje alert en pantalla
		else{
			$result->execute();//Si no hay errores ingresa correctamente
			echo "<script>alert('compra registrado correctamente');</secript>";
		}
	}


	public function updcompra($idcom, $fechcom, $idfac, $confcom, $recibido){//Funcion para actualizar
		$conexion = $this->conectar();
		$sql="UPDATE compra SET idcom=:idcom, fechcom=:fechcom, idfac=:idfac, confcom=:confcom, recibido=:recibido WHERE idcom=:idcom";
		$result=$conexion->prepare($sql);
		//Reemplazo los parametro(PRECEDURE) por los recibidos desde el Controlador(funcion)
	 	$result->bindParam(':idcom',$idcom);
	 	$result->bindParam(':fechcom', $fechcom);
		$result->bindParam(':idfac', $idfac);
		$result->bindParam(':confcom', $confcom);
		$result->bindParam(':recibido', $recibido);//Aseguramos los datos para evitar SQL-Injection
		
		if(!$result)
			echo "<script>alert('Error al actualizar compra');</secript>";
		else{
			$result->execute();
			echo "<script>alert('compra actualizado correctamente');</secript>";
		}
	}
	


	public function delcompra($idcom){//Función para eliminar
		$conexion = $this->conectar();
		$sql="DELETE FROM compra where idcom=:idcom;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':idcom',$idcom);
		if(!$result)
			echo "<script>alert('Error al eliminar compra');</secript>";
		else {
			$result->execute();
			echo 'Ejecutado';
		}
	}


	public function selcompra($idcom){//Función para buscar dentro de la base de datos
		$resultado= null;
		$conexion = $this->conectar();
		$sql="SELECT * FROM compra WHERE idcom=:idcom";
		$result=$conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){//Creación de un array con los resultados de la consulta
			$resultado[] = array(
				'idcom' => $f['idcom'],
				'fechcom' => $f['fechcom'], 
				'idfac' => $f['idfac'],
				'confcom' => $f['confcom'],
				'recibido' => $f['recibido']
			);//Creación del array con los resultados
		}
		echo json_encode($resultado);//Convertimos el array de la consulta a formato JSON
	}

}
?>