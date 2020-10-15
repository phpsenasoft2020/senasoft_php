
<div id="aside">
	<?PHP 
            $pg = isset($_GET["pg"]) ? $_GET["pg"]:NULL;
            if(!$pg OR $pg=="101") 
                require_once("vista/vhome.php");
            if($pg=="1") 
                require_once("vista/vadministrador.php");
            if($pg=="2") 
                require_once("vista/vempresa.php");
            if($pg=="3") 
                require_once("vista/vempleado.php");
            if($pg=="4") 
                require_once("vista/vdependencia.php"); 
            if($pg=="5") 
                require_once("vista/vdocumento.php"); 
            if($pg=="6") 
                require_once("vista/vcargo.php");
            if($pg=="7") 
                require_once("vista/vpag.php");
            if($pg=="8") 
                require_once("vista/vpef.php");
            if($pg=="9") 
                require_once("vista/vtipoempresa.php");
            if($pg=="10") 
                require_once("vista/vtipo_documento.php");
            if($pg=="105") 
                require_once("vista/vart.php"); 
            ?>
</div>