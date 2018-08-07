<?php
class enlacesController{

	public function listaserviciosController(){
        $respuesta = DatosServicio::vistaServiciosModel("ca_servicios");
      	
		foreach ($respuesta as $row => $item){
     echo '<li class="treeview">
        <a href="#"><em class="fa fa-circle-o"></em>'.$item["ser_descripcionesp"] .'<sp//an class="pull-right-container">
                  <em class="fa fa-angle-left pull-right"></em></spam>  
                  </a>

        <ul class="treeview-menu">';
         $respcuenta = DatosCuenta::vistaCuentasModel("ca_cuentas");
        foreach($respcuenta as $row => $itemcuen){  
            echo '<li >
            <a href="index.php?action=rlistaunegocio&sv='.$item["ser_id"] .'&idc='.$itemcuen["cue_id"] .'"><em class="fa fa-circle-o"></em>'.$itemcuen["cue_descripcion"] .'<span class="pull-right-container">
                  </em>
                </span></a>
            </li>';
        }
        echo '</ul>        ';
             
      	}  // foreach servicio
    } 

  public function listanivelesController(){
      
      $_SESSION['Usuario']="marisol";
      if(isset ($_SESSION['Usuario']))
          $Usuario = $_SESSION['Usuario'];
          else{
              //mandar al login
              $_SESSION['Usuario']="marisol";
          }
          
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
//  die($grupo);
   if ($grupo == "adm" || $grupo == 'mue'|| $grupo == 'aud')
   {   //nivel uno por default
       $VarNivel2 = 1;
       $Nivel01 = 1;
       $Nivel02 =1;
      
//       $respuesta = Datosndos::vistandosModel(1,"ca_nivel2");
   }
  // die($VarNivel2);
  if($grupo!="cue"){
     
      if ($VarNivel2 ==1) {
          $respuesta = Datosndos::vistandosModel(1,"ca_nivel2");
          $filuni="1.";
      }
      if ($VarNivel2 ==2) {
          
          $respuesta = Datosntres::vistantresModel(1,"ca_nivel3");
          $filuni="1.1.";
      }
      
      if ($VarNivel2 == 3) {
          
          $respuesta =  Datosncua::vistancuaModel($Nivel03,"ca_nivel4");
          $filuni="1.1.".$Nivel03;
         
      }
      
      if ($VarNivel2 == 4) {
//           if($grupo=="muf"){
//               $respuesta =  Datosncua::vistancuaModel($Nivel04,"ca_nivel4");
          
              
//           }else{
              $respuesta= Datosncin::vistancinModel($Nivel04,"ca_nivel5");
              $filuni="1.1.".$Nivel03;
              $filx=$Nivel04.".";
             
        //  }
         
          
      }
      
      if ($VarNivel2 == 5) {
          $respuesta=Datosnsei::vistanseiModel($Nivel05,"ca_nivel6");
          $filuni="1.1.".$Nivel03;
          $filx=$Nivel04.".".$Nivel05.".";
       
          
          
      }
//       if ($VarNivel2 == 6) {
//           $respuesta=nu;
          
//       }
      
  }
  
   //    $respuesta = Datosndos::vistandosModel(1,"ca_nivel2");
        
    foreach($respuesta as $row ){
        if ($VarNivel2 >=1&&$VarNivel2<= 2) {
      echo '<li >
        <a href="index.php?action=indgraficaindicadorgr&mes='.$mes."&sec=".$seccion."&filx=".$filx."&filuni=".$filuni.$row[0].'"><i class="fa fa-circle-o"></i>'.$row[1] .'
                
                  </a>';
        }
        if ($VarNivel2 >=3&&$VarNivel2<= 5) {
            echo '<li >
        <a href="index.php?action=indgraficaindicadorgr&mes='.$mes."&sec=".$seccion."&filx=".$filx.$row[0]."&filuni=".$filuni.'"><i class="fa fa-circle-o"></i>'.$row[1] .'
            
                  </a>';
        }
//        <ul class="treeview-menu">';
//        $resptres = Datosntres::vistatresModel(1,6, "ca_nivel3");
//        foreach($resptres as $row => $itemtres){  
//            echo '<li class="treeview">
//            <a onclick="Cargar(\'u\',\''. $itemtres["n3_id"]. '\',\'5\',\'1.1.3\');" href="javascript:void(0);"><em class="fa fa-circle-o"></em>'.$itemtres["n3_nombre"] .'<span class="pull-right-container">
//                  <em class="fa fa-angle-left pull-right"></em>
//                </span></a>';
//                 echo ' 
//                 <ul class="treeview-menu">';
//
//                $respcua = Datosncua::vistancuaModel($itemtres["n3_id"],"ca_nivel4");
//                foreach($respcua as $row => $itemcua){  
//       
//                  echo '   <li class="treeview">
//                         <a href="javascript:Cargar(\'u\',\''.$itemcua["n4_id"].'\',\'5\',\'1.1.3\');"><em class="fa fa-circle-o"></em>'.$itemcua["n4_nombre"].' <span class="pull-right-container">
//                  <em class="fa fa-angle-left pull-right"></em></spam></a> 
//                    <ul class="treeview-menu">';
//
//                       $respcin = Datosncin::vistancinModel($itemcua["n4_id"],"ca_nivel5");
//                      foreach($respcin as $row => $itemcin){  
//
//                    echo '<li class="treeview">
//                         <a href="javascript:Cargar(\'u\',\''.$itemcin["n5_id"].'\',\'5\',\'1.1.3\');"><em class="fa fa-circle-o"></em> '.$itemcin["n5_nombre"].' <span class="pull-right-container">
//                  <em class="fa fa-angle-left pull-right"></em></spam></a>
//                  <ul class="treeview-menu">';
//
//                     $respseis = Datosnsei::vistanseiModel($itemcin["n5_id"],"ca_nivel6");
//                     
//                      foreach($respseis as $row => $itemseis){  
//                  echo '
//                    <li class="treeview">
//                         <a href="javascript:Cargar(\'u\',\''.$itemseis["n6_id"].'\',\'5\',\'1.1.3\');"><em class="fa fa-circle-o"></em> '.$itemseis["n6_nombre"].' <span class="pull-right-container">
//                  </spam></a>';
//                      } // nivel seis  
//
//                  echo ' </li>
//                  </ul>
//                      </li>';
//
//                    } // foreach cinco
//                   echo ' </ul> 
//
//                   </li>
//                          ';
//                }  // foreach cuatro
//                echo '
//                 </ul>
//            </li>';
//        
//        } // foreach tres
        
        echo '</li>        ';
             
        }  // foreach servicio
    } 

}
?>