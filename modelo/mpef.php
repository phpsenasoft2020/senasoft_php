<?php 
class mpef{
	public function inspag($pefnom,$pefbus,$pefdes,$pefedi,$pefeli){
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		//SELECT pefid, pefnom, pefbus, pefdes, pefedi, pefeli FROM perfil
		$sql="INSERT INTO perfil (pefnom, pefbus, pefdes, pefedi, pefeli) VALUES (:pefnom, :pefbus, :pefdes, :pefedi, :pefeli)";
		//echo $sql;
		$result=$conexion->prepare($sql);

		$result->bindParam(':pefnom', $pefnom);
		$result->bindParam(':pefbus', $pefbus);
		$result->bindParam(':pefdes', $pefdes);
		$result->bindParam(':pefedi', $pefedi);
		$result->bindParam(':pefeli', $pefeli);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR')</script>";
		else
			$result->execute();
	}

	public function insagre($pagid, $pefid){
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="INSERT INTO pagper(pagid, pefid) VALUES (:pagid, :pefid)";
		//echo $sql;
		$result=$conexion->prepare($sql);

		$result->bindParam(':pagid', $pagid);
		$result->bindParam(':pefid', $pefid);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR')</script>";
		else
			$result->execute();
	}

	public function selpag($filtro,$rvalini,$rvalfin){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT pefid, pefnom, pefbus, pefdes, pefedi, pefeli FROM perfil";
		if ($filtro){
			$filtro = "%".$filtro."%";
			$sql .= " WHERE pefnom LIKE :filtro";
		}
		$sql .= " ORDER  BY pefid LIMIT $rvalini, $rvalfin;";
		//echo $sql;
		$result=$conexion->prepare($sql);

		$result->bindParam(':filtro', $filtro);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function sqlcount($filtro){
		$sql="SELECT count(pefid) AS Npe FROM perfil";
		if ($filtro) 
			$sql .= " WHERE pefnom LIKE '%$filtro%';";
		return $sql;
	}

	public function selpag1($pefid){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();

		$sql="SELECT * FROM perfil WHERE pefid= :pefid";
		$result=$conexion->prepare($sql);

		$result->bindParam(':pefid', $pefid);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function updpag($campo, $valor, $pefid){
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="UPDATE perfil SET $campo= :valor WHERE pefid= :pefid";
		$result=$conexion->prepare($sql);
		$result->bindParam(':valor', $valor);
		$result->bindParam(':pefid', $pefid);

		if(!$result)
			echo "<script>alert('ERROR AL MODIFICAR')</script>";
		else
			$result->execute();
	}

	public function elipag($pefid){
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="DELETE FROM perfil WHERE pefid= :pefid";
		$result=$conexion->prepare($sql);
		$result->bindParam(':pefid', $pefid);

		if (!$result)
			echo "<script>alert('ERROR AL ELIMINAR')</script>";
		else
			$result->execute();
	}

	public function elipg($pefid){
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="DELETE FROM pagper WHERE pefid= :pefid";
		$result=$conexion->prepare($sql);
		$result->bindParam(':pefid', $pefid);

		if (!$result)
			echo "<script>alert('ERROR AL ELIMINAR')</script>";
		else
			$result->execute();
	}

	public function seltipd(){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();

		$sql="SELECT pefid, pefnom, pefbus, pefdes, pefedi, pefeli FROM perfil;";
		$result=$conexion->prepare($sql);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function selpg(){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();

		$sql="SELECT pagid, pagnom, pagarc, pagmos, pagord, pagmen FROM pagina ORDER BY pagmen, pagnom;";
		$result=$conexion->prepare($sql);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function selpxp($pefid){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();

		$sql="SELECT pagid, pefid FROM pagper WHERE pefid=:pefid;";
		$result=$conexion->prepare($sql);
		//echo $sql."<br>";
		$result->bindParam(':pefid', $pefid);

		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>