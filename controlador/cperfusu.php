<?php
    require_once('modelo/conexion.php');
    require_once("modelo/mperfusu.php");
    require_once("modelo/mpaginacion.php");

    $pg = 10;
    $arc = "home.php";
    $musu = new musu();

      // Declaracion De Variables
    $idusu = isset($_POST['idusu']) ? $_POST['idusu']:NULL;
    if(!$idusu)
        $idusu = isset($_GET['idusu']) ? $_GET['idusu']:NULL;

        $nomusu = isset($_POST['nomusu']) ? $_POST['nomusu']:NULL;
        $apeusu = isset($_POST['apeusu']) ? $_POST['apeusu']:NULL;
        $tipdocusu = isset($_POST['tipdocusu']) ? $_POST['tipdocusu']:NULL;
        $nodocusu = isset($_POST['nodocusu']) ? $_POST['nodocusu']:NULL;
        $dirusu = isset($_POST['dirusu']) ? $_POST['dirusu']:NULL;
        $ciudusu = isset($_POST['ciudusu']) ? $_POST['ciudusu']:NULL;
        $telusu = isset($_POST['telusu']) ? $_POST['telusu']:NULL;
        $celusu = isset($_POST['celusu']) ? $_POST['celusu']:NULL;
        $emausu = isset($_POST['emausu']) ? $_POST['emausu']:NULL;
        $pasusu = isset($_POST['pasusu']) ? $_POST['pasusu']:NULL;
        $fechnac = isset($_POST['fechnac']) ? $_POST['fechnac']:NULL;
        
        $filtro = isset($_GET["filtro"]) ? $_GET["filtro"]:NULL;
        $est = isset($_GET["est"]) ? $_GET["est"]:NULL;
        $opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
    if(!$opera)
        $opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

    $dse = isset($_SESSION["pefid"]) ? $_SESSION["pefid"]:NULL;
    if($dse!=0){ 
        $idusu = isset($_SESSION["idusu"]) ? $_SESSION["idusu"]:NULL;
        $pefid = isset($dse) ? $dse:NULL;
        $pg = 10;
    }

    //--- -----Insertar---- ----
//echo $opera."-".$nodocemp."-".$nomusu."-".$pefid."-".$pass."-".$diremp."-".$telemp."-".$actemp;
    if($opera=="insertar"){
        if ($nomusu && $apeusu && $tipdocusu && $nodocusu && $dirusu && $ciudusu && $telusu && $celusu && $emausu && $pasusu){
            $result=$musu->usuins($nomusu, $apeusu, $tipdocusu, $nodocusu, $dirusu, $ciudusu, $telusu, $celusu, $emausu, sha1(md5($pasusu)));
            $idusu = "";
             echo "<script>alert('¡Todos Los Valores Han Sido Añadidos!')</script>";
             echo "<script type='text/javascript'>window.location='home.php?pg=10'</script>";
        }else{
            echo "<script>alert('FAVOR LLENAR TODOS LOS CAMPOS')</script>";
        }
        $opera = "";
    }

    //--- -----Actualizar---- ----
    // & $pass & $diremp & $telemp & $actemp
    //echo $opera."-".$idusu."-".$nodocemp."-".$edad."-".$nomusu."-".$pass."-".$diremp."-".$telemp."-".$emaem."-".$genem."-".$descr."-".$foto."-".$fotant."-".$fotdes;
    if($opera=="actualizar"){
        if ($idusu && $nomusu && $apeusu && $tipdocusu && $nodocusu && $dirusu && $ciudusu && $telusu && $celusu && $emausu){
            if($pasusu) $pasusu=sha1(md5($pasusu));
            $result=$musu->updusu($idusu, $nomusu, $apeusu, $tipdocusu, $nodocusu, $dirusu, $ciudusu, $telusu, $celusu, $emausu);
            $idusu = "";
            echo "<script>alert('¡Todos Los Valores Han Sido Actualizados!')</script>";
            echo "<script type='text/javascript'>window.location='home.php?pg=10'</script>";
        }else{
            echo "<script>alert('HAY CAMPOS VACIOS')</script>";
        }
        $opera = "";
    }

    //carga de datos
    function seleccionar($idusu, $pg){
        $musu=new musu();
        $sele = $musu->seltip();
        if($idusu){
            $result=$musu->selusu1($idusu);
        }
        $sel = $musu->selperf();
        $dse = isset($_SESSION["pefid"]) ? $_SESSION["pefid"]:NULL;

        $txt = '<form action="home.php?pg='.$pg.'" method="POST" id="form" enctype="multipart/form-data">
            <div class="container">';
                    $txt .= '<div class="col-md-12 col">';
                    $txt .= '<center>';
                    $txt .= '<h1>Perfil</h1>';
                    $txt .= '</center>';
                    $txt .= '<hr>';
                    $txt .= '</div>';
                    $txt .= '<div class="container">';
                    foreach ($result as $f){
                $txt .= '<center>';
                    $txt .= '<br>';
                    $txt .= "<strong>¡Hola! </strong> <big>".$f['nomusu'];
                    $txt .= '</big>';
                    $txt .= '<br>';
                    $txt .= '<br>';
                $txt .= '</center>';
                    }
                $txt .= '</div>';
                $txt .= '<div class="container cont6">';
                $txt .= '<br>';
                $txt .= '<br>';

                $txt .= '<label>Contraseña</label>';
                $txt .= '<input type="password" maxlength="50" name="pasusu" class="form-control">';

                $txt .= '<label>Dirección</label>';
                $txt .= '<input type="text" maxlength="70" name="dirusu" value="';
                    if($idusu){ $txt .= $result[0]['dirusu']; }
                $txt .= '" required class="form-control">';

                $txt .= '<label>Ciudad</label>';
                $txt .= '<input type="text" maxlength="70" name="ciudusu" value="';
                    if($idusu){ $txt .= $result[0]['ciudusu']; }
                $txt .= '" required class="form-control">';

                $txt .= '<label>Teléfono</label>';
                $txt .= '<input type="number" min="0" max="9999999999" name="telusu" value="';
                    if($idusu){ $txt .= $result[0]['telusu']; }
                $txt .= '" required class="form-control">';

                $txt .= '<label>Celular</label>';
                $txt .= '<input type="number" min="0" max="9999999999" name="celusu" value="';
                    if($idusu){ $txt .= $result[0]['celusu']; }
                $txt .= '" required class="form-control">';

                $txt .= '<label>Email</label>';
                $txt .= '<input type="email" max-length="150" name="emausu" value="';
                    if($idusu){ $txt .= $result[0]['emausu']; }
                $txt .= '" required class="form-control">';
                    $txt .= '</div>';

                    

                    $txt .= '<div class="container cont5">';
                        if ($idusu){
                $txt .= '<label>C&oacute;digo</label>';
                $txt .= '<input type="number" name="idusu" value="';
                    if($idusu) $txt .= $result[0]['idusu'];
                $txt .= '"';
                    if($idusu) $txt .= ' readonly';
                $txt .= ' required class="form-control">';
                    }

                $txt .= '<label>Edad</label>';
                $txt .= '<input type="text" name="edaemp" value="';
                        if($idusu){ $txt .= $result[0]['edaemp']; }
                $txt .= '" required class="form-control" readonly>';

                date_default_timezone_set('America/Bogota');
                $fec = date("Y-m-d");
                $txt .= '<label>Fecha De Nacimiento</label>';
                $txt .= '<input type="date" name="fechnac" value="';
                    if($idusu){ $txt .= $result[0]['fechnac']; } else { $txt .= $fec; }
                $txt .= '" required class="form-control">';

                $txt .= '<label>Tipo de documento</label>';
                $txt .= '<select name="tipdocusu" class="form-control">';
                $txt .= '<option value="">Seleccionar</option>';
                if($sel){
                    foreach($sele AS $tds){
                        $txt .= '<option value="'.$tds["idval"].'"';
                        $txt .= '>'.utf8_encode($tds["nomval"]).'</option>';
                    }       
                }
                $txt .= '</select>';

                $txt .= '<label>No. Documento</label>';
                $txt .= '<input type="number" min="0" max="9999999999" name="nodocusu" value="';
                    if($idusu){ $txt .= $result[0]['nodocusu']; }
                $txt .= '" required class="form-control">';

                $txt .= '<label>Nombre</label>';
                $txt .= '<input type="text" max-length="50" name="nomusu" value="';
                    if($idusu){ $txt .= $result[0]['nomusu']; }
                $txt .= '" required class="form-control">';

                $txt .= '<label>Apellido</label>';
                $txt .= '<input type="text" max-length="50" name="apeusu" value="';
                    if($idusu){ $txt .= $result[0]['apeusu']; }
                $txt .= '" required class="form-control">';

                $txt .= '</div>';
                $txt .= '<div class="container cont2">';

                

                $txt .= '</div>';
                $txt .= '</div>';

                // $txt .= '<label>Orden</label>';
                // $txt .= '<input type="number" name="pagord" value="';
                //  if($idusu){ $txt .= $result[0]['pagord']; }
                // $txt .= '" required class="form-control">';
                $txt .= '<br>';
                $txt .= '<br>';
                $txt .= '<br>';
                $txt .= '<br>';

                $txt .= '<input type="hidden" name="opera" value="';
                    if($idusu){ $txt .= "actualizar"; } else { $txt .= "insertar"; }
                $txt .= '"><br><center><button type="submit" class="btn btn-outline-primary">';
                    if($idusu){ $txt .= "Actualizar"; } else { $txt .= "Registrar"; }
                $txt .= '</button>';
                $txt .= '<br><br><br>';
                $txt .= '&nbsp;&nbsp;&nbsp;';
                
                $txt .= '</center>
            </div>
        </form>';

        echo $txt;
    }


?>