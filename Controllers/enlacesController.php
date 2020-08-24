
<?php
class enlacesController{
	public function listaserviciosController($grupous, $user){
	
        
        $respuesta = DatosServicio::vistaServiciosModelMenu("ca_servicios",$grupous,$user);
     
		foreach ($respuesta as $row => $item){
			
     echo '<li class="treeview">
        <a href="#"><em class="fa fa-circle-o"></em>'.substr($item["ser_descripcionesp"],0,19) .'<span class="pull-right-container">
                  <em class="fa fa-angle-left pull-right"></em></span>  
                  </a>
        <ul class="treeview-menu">';
         $respcuenta = DatosCuenta::vistaCuentasModel("ca_cuentas");
        foreach($respcuenta as $row => $itemcuen){  
            echo '<li >
            <a href="index.php?action=rlistaunegocio&sv='.$item["ser_id"] .'&idc='.$itemcuen["cue_id"] .'">
<em class="fa fa-circle-o"></em>'.substr($itemcuen["cue_descripcion"],0,19) .'<span class="pull-right-container">
                 
                </span></a>
            </li>';
        }
        echo '</ul>        ';
             
      	}  // foreach servicio
    } 
  public function listanivelesController(){
      
   
     
      if(isset ($_SESSION['NombreUsuario']))
          $Usuario = $_SESSION['NombreUsuario'];
    if(!isset( $_SESSION["UsuarioInd"]))
        $_SESSION["UsuarioInd"]=$_SESSION['NombreUsuario'];
          else{
              //mandar al login
             // $_SESSION['Usuario']="marisol";
          }
          $_SESSION["servicioind"]=1;
          $_SESSION["clienteind"]=1;
  $mes= filter_input(INPUT_GET, "mes", FILTER_SANITIZE_STRING);
  $seccion=filter_input(INPUT_GET,"sec",FILTER_SANITIZE_NUMBER_INT);
 // $filx=filter_input(INPUT_GET, "filx", FILTER_SANITIZE_STRING);
  $rs_usuarios = UsuarioModel::getUsuario($Usuario,"cnfg_usuarios");
 
  foreach ($rs_usuarios as $row_usuarios ) {
      //            $html->asignar('USUARIO', "<span class='TitPost'>" . $row_usuarios ["cus_nombreusuario"] . "</span>");
      $VarNivel2 = $row_usuarios ["cus_tipoconsulta"];
      $grupo = $row_usuarios ["cus_clavegrupo"];
      $Nivel01 = $row_usuarios ["cus_nivel1"];
      $Nivel02 = $row_usuarios ["cus_nivel2"];
      //                    echo "niv".$Nivel02;
      $Nivel03 = $row_usuarios ["cus_nivel3"];
      $Nivel04 = $row_usuarios ["cus_nivel4"];
      $Nivel05 = $row_usuarios ["cus_nivel5"];
      $Nivel06 = $row_usuarios ["cus_nivel6"];
      
  }

   if ($grupo == "adm" || $grupo == 'mue'|| $grupo == 'aud')
   {   //nivel uno por default
       $VarNivel2 = 1;
       $Nivel01 = 1;
       $Nivel02 =1;
     
//       $respuesta = Datosndos::vistandosModel(1,"ca_nivel2");
   }
   
  if($grupo!="cue"){
     
  	if ($VarNivel2 ==1||$VarNivel2 ==2) {
//           $respuesta = Datosndos::vistandosModel(1,"ca_nivel2");
//           $filuni="1.";
//       }
//       if ($VarNivel2 ==2) {
          
      	$respuesta = Datosndos::nombreNivel2(1, "ca_nivel2");
     $id=1;
          $filuni="1.";
      }
      
      if ($VarNivel2 == 3) {
          $respuesta =  Datosntres::nombreNivel3($Nivel03,"ca_nivel3");
          $filuni="1.".$Nivel02.".";
           $id=$Nivel03;
      }
      
      if ($VarNivel2 == 4) {
      	$respuesta =  Datosncua::nombreNivel4($Nivel04,"ca_nivel4");
           if($grupo=="muf"){
        	
          $filuni="1.1.".$Nivel03;
                   
           }else{
        
              $filuni="1.1.".$Nivel03;
            //  $filx=$Nivel04.".";
             
        }
         
          $id=$Nivel04;
      }
      
      if ($VarNivel2 == 5) {
      	$respuesta= Datosncin::nombreNivel5($Nivel05,"ca_nivel5");
          $filuni="1.1.".$Nivel03;
          $filx=$Nivel04.".";
       $id=$Nivel05;
          
          
      }
       if ($VarNivel2 == 6) {
       	$respuesta=Datosnsei::nombreNivel6($Nivel06,"ca_nivel6");
       	$filuni="1.1.".$Nivel03;
       	$filx=$Nivel04.".".$Nivel05.".";
         $id=$Nivel06;
       }
   }
  
   //    $respuesta = Datosndos::vistandosModel(1,"ca_nivel2");
        
    if($respuesta ){
    	
        if ($VarNivel2 >=1&&$VarNivel2<= 3) {
      echo '<li >
        <a href="index.php?action=indgraficaindicadorgr&mes='.$mes."&sec=".$seccion."&filx=".$filx."&filuni=".$filuni.$id.'">
<i class="fa fa-circle-o"></i>'.substr($respuesta,0,15) .'
        </a>';
        }
        if ($VarNivel2 >=4&&$VarNivel2<= 6) {
            echo '<li >
        <a href="index.php?action=indgraficaindicadorgr&mes='.$mes."&sec=".$seccion."&filx=".$filx.$id."&filuni=".$filuni.'">
<i class="fa fa-circle-o"></i>'.substr($respuesta,0,15).'
        </a>';
        }
//   
         echo '</li>        ';
             
        }  // foreach servicio
    } 

    public function listanivelesIndicadores(){
    	
    	
    	
    	if(isset ($_SESSION['NombreUsuario']))
    		$Usuario = $_SESSION['NombreUsuario'];
    		if(!isset( $_SESSION["UsuarioInd"]))
    			$_SESSION["UsuarioInd"]=$_SESSION['NombreUsuario'];
    		
    			$_SESSION["servicioind"]=1;
    			$_SESSION["clienteind"]=1;
    			$mes= filter_input(INPUT_GET, "mes", FILTER_SANITIZE_STRING);
    			$seccion=filter_input(INPUT_GET,"sec",FILTER_SANITIZE_NUMBER_INT);
    			// $filx=filter_input(INPUT_GET, "filx", FILTER_SANITIZE_STRING);
    			$rs_usuarios = UsuarioModel::getUsuario($Usuario,"cnfg_usuarios");
    			
    			foreach ($rs_usuarios as $row_usuarios ) {
    				//            $html->asignar('USUARIO', "<span class='TitPost'>" . $row_usuarios ["cus_nombreusuario"] . "</span>");
    				$VarNivel2 = $row_usuarios ["cus_tipoconsulta"];
    				$grupo = $row_usuarios ["cus_clavegrupo"];
    				$Nivel01 = $row_usuarios ["cus_nivel1"];
    				$Nivel02 = $row_usuarios ["cus_nivel2"];
    				//                    echo "niv".$Nivel02;
    				$Nivel03 = $row_usuarios ["cus_nivel3"];
    				$Nivel04 = $row_usuarios ["cus_nivel4"];
    				$Nivel05 = $row_usuarios ["cus_nivel5"];
    				$Nivel06 = $row_usuarios ["cus_nivel6"];
    				
    			}
    			
    			if ($grupo == "adm" || $grupo == 'mue'|| $grupo == 'aud')
    			{   //nivel uno por default
    				$VarNivel2 = 1;
    				$Nivel01 = 1;
    				$Nivel02 =1;
    				
    				//       $respuesta = Datosndos::vistandosModel(1,"ca_nivel2");
    			}
    			
    			if($grupo!="cue"){
    				
    				if ($VarNivel2 ==1||$VarNivel2 ==2) {
    					//           $respuesta = Datosndos::vistandosModel(1,"ca_nivel2");
    					//           $filuni="1.";
    					//       }
    					//       if ($VarNivel2 ==2) {
    					
    					$respuesta = Datosndos::nombreNivel2(1, "ca_nivel2");
    					$id=1;
    					$filuni="1.";
    				}
    				
    				if ($VarNivel2 == 3) {
    					$respuesta =  Datosntres::nombreNivel3($Nivel03,"ca_nivel3");
    					$filuni="1.".$Nivel02.".";
    					$id=$Nivel03;
    				}
    				
    				if ($VarNivel2 == 4) {
    					$respuesta =  Datosncua::nombreNivel4($Nivel04,"ca_nivel4");
    					if($grupo=="muf"){
    						
    						$filuni="1.1.".$Nivel03;
    						
    					}else{
    						
    						$filuni="1.1.".$Nivel03;
    						//  $filx=$Nivel04.".";
    						
    					}
    					
    					$id=$Nivel04;
    				}
    				
    				if ($VarNivel2 == 5) {
    					$respuesta= Datosncin::nombreNivel5($Nivel05,"ca_nivel5");
    					$filuni="1.1.".$Nivel03;
    					$filx=$Nivel04.".";
    					$id=$Nivel05;
    					
    					
    				}
    				if ($VarNivel2 == 6) {
    					$respuesta=Datosnsei::nombreNivel6($Nivel06,"ca_nivel6");
    					$filuni="1.1.".$Nivel03;
    					$filx=$Nivel04.".".$Nivel05.".";
    					$id=$Nivel06;
    				}
    			}
    			
    			//    $respuesta = Datosndos::vistandosModel(1,"ca_nivel2");
    			
    			if($respuesta ){
    				$mes_asig = date("m.Y");
    				$aux = explode(".", $mes_asig);
    				
    				$solomes = $aux[0] - 1;
    				$soloanio = $aux[1];
    				
    				if ($solomes == 0) {
    					$solomes = 12;
    					$soloanio = $aux[1] - 1;
    				}
    				
    				$mes= $solomes . "." . $soloanio;
    				if ($VarNivel2 >=1&&$VarNivel2<= 3) {
    					echo '<li >
        <a href="index.php?action=indindicadores&mes='.$mes."&filx=".$filx."&filuni=".$filuni.$id.'">
<i class="fa fa-circle-o"></i>'.substr($respuesta,0,15) .'
        </a>';
    				}
    				if ($VarNivel2 >=4&&$VarNivel2<= 6) {
    					echo '<li >
        <a href="index.php?action=indindicadores&mes='.$mes."&filx=".$filx.$id."&filuni=".$filuni.'">
<i class="fa fa-circle-o"></i>'.substr($respuesta,0,15).'
        </a>';
    				}
    				//
    				echo '</li>        ';
    				
    			}  // foreach servicio
    }
    
  public function listaserviciosCues(){
  
    
        $respcuenta = DatosCuenta::vistaCuentasModel("ca_cuentas");
 
        foreach($respcuenta as $row => $itemcuen){  
            echo '<li>
            <a href="index.php?action=listaunegocio&idc='.$itemcuen["cue_id"] .'">
<em class="fa fa-circle-o"></em>'.substr($itemcuen["cue_descripcion"],0,16) .'</a>
            </li>';
            
        }
        echo '</ul>        ';
   }     
}
?>
