<?php 
class mpaginacion{
	var $nrini;//No reg_inicial
	var $nrfin;//No reg_final
	var $regtot;//No reg_totales
	var $nrm;//No reg_mostrar

	function mpagin($nreg){
		$this->nrini = 0;//Inicia siempre 0(posicio) debido a vectores(consultas)
		$this->nrfin = $nreg;
		$this->regtot = 0;//Inicia en 0 debido a que no se ha totalizado la cant reg
	}

	function spag($sqlnp, $nreg, $pag, $bo, $arc){
	//$sqlnp(Consult_cant_reg), $nreg(Cant_Reg_mostrar), $pag(ID_pag_visualizar), $bo(Variable_Ext(Valores adicionales)), $arc(home/index)
	//Creamos objeto conexion, hereda el metodo y realiza la consulta
		$this->nrm=$nreg;
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();

		$result=$conexion->prepare($sqlnp);
		$result->execute();

		while($f=$result->fetch()){
			$datanp[]=$f;
		}

		$this->regtot=$datanp[0]['Npe'];
		
		$this->nrfin = $nreg;
		$npag=round($datanp[0]['Npe']/$this->nrm);
		$rfal=($datanp[0]['Npe']-($npag*$this->nrm));
		if($rfal>0)
			$npag=$npag+1;
		$npg = isset($_GET["npg"]) ? $_GET["npg"]:NULL;
		
		$mpag = "<form name='f2i' action='".$arc."' method='get' class='txtbold'>";
		if (is_null($npg))
			$npg=1;
		$this->nrini=(($npg-1)*$this->nrm);
		$this->nrm=(($npg-1)*$this->nrm+($this->nrm));
		$mpag .= "Registros: ".($this->nrini+1)." - ";
		if($this->nrm<$datanp[0]['Npe'])
			$mpag .= $this->nrm; else $mpag .= $datanp[0]['Npe'];
		$mpag .= " de ".$datanp[0]['Npe']."&nbsp;&nbsp;&nbsp;  ";
		$mpag .= "<select name='npg' onChange='this.form.submit();' style='width: 60px'>";
		for ($q=1;$q<=$npag;$q++){
			if ($q==$npg)
				$sele="SELECTED";
			else
				$sele="";
			$mpag .=  "<option ".$sele.">".$q."</option>";
		}
		$mpag .= "</select>&nbsp;&nbsp;";
   		//cambiar el pag por el de la pagina a mostrar o la que se esta trabajando.
		$mpag .= "<input type='hidden' name='pg' value='".$pag."'>";
		$mpag .= $bo;
		$mpag .= "</form>";
		return $mpag;
	}

	function rvalini(){
		return $this->nrini;
	}
	
	function rvalfin(){
		return $this->nrfin;
	}
	
	function regtot(){
		return $this->regtot;
	}
}
	
?>