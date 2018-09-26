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

       $respuesta = Datosndos::vistadosModel(1,1,"ca_nivel2");
        
    //foreach($respuesta as $row => $item){
      echo '<li class="treeview">
        <a href="#"><em class="fa fa-circle-o"></em>'.$respuesta["n2_nombre"] .'<span class="pull-right-container">
                  <em class="fa fa-angle-left pull-right"></em></spam>  
                  </a>
        <ul class="treeview-menu">';
        $resptres = Datosntres::vistatresModel(1,6, "ca_nivel3");
        foreach($resptres as $row => $itemtres){  
            echo '<li class="treeview">
            <a href="index.php?action=rlistaunegocio&sv='.$itemtres["n3_id"].'"><em class="fa fa-circle-o"></em>'.$itemtres["n3_nombre"] .'<span class="pull-right-container">
                  <em class="fa fa-angle-left pull-right"></em>
                </span></a>';
                 echo ' 
                 <ul class="treeview-menu">';

                $respcua = Datosncua::vistancuaModel($itemtres["n3_id"],"ca_nivel4");
                foreach($respcua as $row => $itemcua){  
       
                  echo '   <li class="treeview">
                         <a href="index.php?action=rlistaunegocio&sv='.$itemcua["n4_id"].'"><em class="fa fa-circle-o"></em>'.$itemcua["n4_nombre"].' <span class="pull-right-container">
                  <em class="fa fa-angle-left pull-right"></em></spam></a> 
                    <ul class="treeview-menu">';

                       $respcin = Datosncin::vistancinModel($itemcua["n4_id"],"ca_nivel5");
                      foreach($respcin as $row => $itemcin){  

                    echo '<li class="treeview">
                         <a href="index.php?action=rlistaunegocio&sv='.$itemcin["n5_id"].'"><em class="fa fa-circle-o"></em> '.$itemcin["n5_nombre"].' <span class="pull-right-container">
                  <em class="fa fa-angle-left pull-right"></em></spam></a>
                  <ul class="treeview-menu">';

                     $respseis = Datosnsei::vistanseiModel($itemcin["n5_id"],"ca_nivel6");
                     
                      foreach($respseis as $row => $itemseis){  
                  echo '
                    <li class="treeview">
                         <a href="index.php?action=rlistaunegocio&sv="><em class="fa fa-circle-o"></em> '.$itemseis["n6_nombre"].' <span class="pull-right-container">
                  </spam></a>';
                      } // nivel seis  

                  echo ' </li>
                  </ul>
                      </li>';

                    } // foreach cinco
                   echo ' </ul> 

                   </li>
                          ';
                }  // foreach cuatro
                echo '
                 </ul>
            </li>';
        
        } // foreach tres
        
        echo '</ul>        ';
             
        //}  // foreach servicio
    }

  public function listaserviciosCues(){
    
      
        $respcuenta = DatosCuenta::vistaCuentasModel("ca_cuentas");
        foreach($respcuenta as $row => $itemcuen){  
            echo '<li>
            <a href="index.php?action=listaunegocio&idc='.$itemcuen["cue_id"] .'"><em class="fa fa-circle-o"></em>'.$itemcuen["cue_descripcion"] .'</a>
            </li>';

            
        }
   }     


}
?>