<?php
/*require('conexion.php');
$mprod = new mproducto();
$mprod->selprod('');*/
class mproducto{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}

	public function insproducto($nomprod,$precioprod,$unidprod,$cantprod,$idbod){//Para insertar 
		$conexion = $this->conectar();
		$sql="INSERT INTO producto(nomprod,precioprod,unidprod,cantprod,idbod) VALUES (:nomprod,:precioprod,:unidprod,:cantprod,:idbod);";//Consulta SQL
		$result=$conexion->prepare($sql);//Prepara nuestra consulta
		$result->bindParam(':nomprod',$nomprod);
		$result->bindParam(':precioprod',$precioprod);
		$result->bindParam(':unidprod',$unidprod);
		$result->bindParam(':cantprod',$cantprod);
		$result->bindParam(':idbod',$idbod);
		//Aseguramos los datos para evitar SQL-Injection
		if(!$result)
			echo "<script>alert('Error al actualizar producto');</secript>";
		else{
			$result->execute();
			echo "Regitstro";
		}
	}


	public function updproducto($idprod,$nomprod,$precioprod,$cantprod,$unidprod,$idbod){//Funcion para actualizar
		$conexion = $this->conectar();
		$sql="UPDATE producto SET nomprod=:nomprod, precioprod=:precioprod, cantprod=:cantprod, unidprod=:unidprod, idbod=:idbod where idprod=:idprod;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':idprod',$idprod);
		$result->bindparam(':nomprod',$nomprod);
		$result->bindparam(':cantprod',$cantprod);
		$result->bindparam(':unidprod',$unidprod);
		$result->bindparam(':idbod',$idbod);
		$result->bindparam(':precioprod',$precioprod);//Aseguramos los datos para evitar SQL-Injection
		
		if(!$result)
			echo "<script>alert('Error al actualizar producto');</secript>";
		else{
			$result->execute();
			echo "<script>alert('producto actualizado correctamente');</secript>";
		}
	}
	


	public function delproducto($id){//Función para eliminar
		$conexion = $this->conectar();
		$sql="DELETE FROM producto where idprod=:id;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':id',$id);
		if(!$result)
			echo "<script>alert('Error al eliminar producto');</secript>";
		else {
			$result->execute();
			echo 'Ejecutado';
		}
	}

	public function selproducto(){//Función para buscar dentro de la base de datos
		$resultado= null;
		$conexion = $this->conectar();
		$sql="SELECT a.idprod,a.nomprod,a.precioprod,a.cantprod,a.unidprod,b.nombod FROM producto as a INNER JOIN bodega AS b ON a.idbod = b.idbod;";
		$result=$conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){//Creación de un array con los resultados de la consulta
			$resultado[] = array(
				'idprod' => $f['idprod'],
				'nombre' => $f['nomprod'], 
				'precio' => $f['precioprod'],
				'cant' => $f['cantprod'],
				'unid' => $f['unidprod'],
				'bodega' => $f['nombod']
			);//Creación del array con los resultados
		}
		echo json_encode($resultado);//Convertimos el array de la consulta a formato JSON
	}

	public function selprod($fi){
		$resultado = null;
		$filtro = '%'.$fi.'%';
		$conexion = $this->conectar();
		$sql="SELECT a.idprod,a.nomprod,a.precioprod,a.cantprod,a.unidprod,b.nombod FROM producto as a INNER JOIN bodega AS b ON a.idbod = b.idbod";
		if ($fi) $sql .= ' WHERE a.nomprod LIKE :filtro';
		//echo $sql;
		$result=$conexion->prepare($sql);
		if ($fi) $result->bindParam(':filtro',$filtro);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[] = array(
				'idprod' => $f['idprod'],
				'nombre' => $f['nomprod'], 
				'precio' => $f['precioprod'],
				'cant' => $f['cantprod'],
				'unid' => $f['unidprod'],
				'bodega' => $f['nombod']
			);//Creación del array con los resultados
		}
		echo json_encode($resultado);
	}

	public function selprodID($fi){
		$resultado = null;
		$filtro = '%'.$fi.'%';
		$conexion = $this->conectar();
		$sql="SELECT a.idprod,a.nomprod,a.precioprod,a.cantprod,a.unidprod,b.nombod FROM producto as a INNER JOIN bodega AS b ON a.idbod = b.idbod";
		if ($fi) $sql .= ' WHERE a.nomprod LIKE :filtro OR a.idprod = :fi';
		//echo $sql;
		$result=$conexion->prepare($sql);
		if ($fi){
			$result->bindParam(':filtro',$filtro);
			$result->bindParam(':fi',$fi);
		}
		$result->execute();
		while($f=$result->fetch()){
			$resultado[] = array(
				'idprod' => $f['idprod'],
				'nombre' => $f['nomprod'], 
				'precio' => $f['precioprod'],
				'cant' => $f['cantprod'],
				'unid' => $f['unidprod'],
				'bodega' => $f['nombod']
			);//Creación del array con los resultados
		}
		echo json_encode($resultado);
	}

	public function seleccionar($id){
		$conexion = $this->conectar();
		$sql="SELECT a.idprod,a.nomprod,a.precioprod,a.cantprod,a.unidprod,b.nombod FROM producto as a INNER JOIN bodega AS b ON a.idbod = b.idbod WHERE a.idprod = :id";
		$result = $conexion->prepare($sql);
		$result->bindParam(':id',$id);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[] = array(
				'idprod' => $f['idprod'],
				'nombre' => $f['nomprod'], 
				'precio' => $f['precioprod'],
				'cant' => $f['cantprod'],
				'unid' => $f['unidprod'],
				'bodega' => $f['nombod']
			);//Creación del array con los resultados
		}
		echo json_encode($resultado[0]);
	}



}
?>