<?php 
class mmen{
	public function selmen($pagmen, $pefid){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT g.pagid, g.pagnom, g.pagarc, g.pagmos, g.pagord, g.pagmen, g.icono, e.pefid FROM pagina AS g INNER JOIN pagper AS e ON g.pagid=e.pagid WHERE g.pagmen=:pagmen and e.pefid=:pefid and g.pagmos=1 ORDER BY g.pagord";
		//echo $sql;
		$result=$conexion->prepare($sql);

		$result->bindParam(':pagmen', $pagmen);
		$result->bindParam(':pefid', $pefid);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selpgact($pagid, $pefid){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT p.pagid, p.pagnom, p.pagarc, p.pagmos, p.pagord, p.pagmen FROM pagina AS p INNER JOIN pagper AS g ON p.pagid=g.pagid WHERE p.pagid=:pagid AND g.pefid=:pefid;";
		//echo $sql;
		$result=$conexion->prepare($sql);

		$result->bindParam(':pagid', $pagid);
		$result->bindParam(':pefid', $pefid);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selpgini($pagid){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT p.pagid, p.pagnom, p.pagarc, p.pagmos, p.pagord, p.pagmen FROM pagina AS p WHERE p.pagmen='Index' AND p.pagid=:pagid;";
		//echo $sql;
		$result=$conexion->prepare($sql);

		$result->bindParam(':pagid', $pagid);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selnot(){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT idnoti, contnoti, fechanoti, idusu, leido, COUNT((idnoti-leido)) AS cont FROM notificacion ORDER BY idnoti DESC LIMIT 6";
		//echo $sql;
		$result=$conexion->prepare($sql);

		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selnot2(){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT idnoti, contnoti, fechanoti, idusu, leido FROM notificacion ORDER BY idnoti DESC LIMIT 6";
		//echo $sql;
		$result=$conexion->prepare($sql);

		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>