<?php 
class mconf{
	function selconf(){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="CALL confsel();";
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