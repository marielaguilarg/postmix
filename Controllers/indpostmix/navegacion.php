<?php

// session_start();
// session_destroy();
// $nav=new Navegacion();
// $nav->agregarRuta("a", "hola.com", "primera");
// $nav->agregarRuta("b", "hola.com", "segunda");
// $nav->agregarRuta("c", "hola.com", "tercera");
// var_dump($_SESSION["histonav"]);
// echo $nav->desplegarNavegacion();
// $nav->borrarRutaActual("b");
// echo "---";
// echo $nav->desplegarNavegacion();
// $nav->borrarRutaActual("c");
// $nav->agregarRuta("d", "hola.com", "cuarta");
// echo "---";
// echo $nav->desplegarNavegacion();
// $nav->agregarRuta("d", "hola.com", "cuarta");
// echo "---";
// echo $nav->desplegarNavegacion();
class Navegacion {
    
     private $listaSeccion;
    private $listaPeriodo;
    private $listaNivel;
    private $servicio;
    private $cliente;
    private $pilanav;
    
    
   
  
// function borrarRutaActual(){ 
//   $this->pilanav=$_SESSION["histonav"] ; //pila de navegacion
// //  echo "antes";
// //  print_r($this->pilanav);
// //   if(is_array($this->pilanav))
// //   { $rpila=array_reverse($this->pilanav); //pila de reversa
// //   foreach($rpila as $key=>$ruta)
// //   { if(key($rpila)>=$indice)
// //       //lo borro
// //       unset($rpila[$key]);
// //   }
//   //actualizo pila
//   $valor=array_pop($this->pilanav);
//   $_SESSION["histonav"]=$this->pilanav;  
//   return $valor;
  
// }

// function agregarRuta($indice, $ruta, $descripcion){
//     if(isset($_SESSION["histonav"]))
//     {  $this->pilanav=$_SESSION["histonav"] ; //pila de navegacion
//     }
//     $this->pilanav[]=array($indice,$ruta,$descripcion);
// //     //busco ultima posicion
// //     if(is_array($this->pilanav))
// //         $ultimo=end($this->pilanav);
// //     //reviso que haya algo
// //     if($ultimo!=false)
// //     {   $ultpos=$ultimo["pos"]+1;
// //     }
// //     else
// //     {// es el primero
// //         $ultpos=0;
// //     }
// //     //agrego ruta
// //     $this->pilanav[$indice]=array("pos"=>$ultpos,"ruta"=>$ruta,"desc"=>$descripcion);
//      $_SESSION["histonav"]=$this->pilanav;
     
    
// }
// public function length(){
//     $this->pilanav=$_SESSION["histonav"];
//     return count($this->pilanav);
// }
// public function  peek(){
//     $this->pilanav=$_SESSION["histonav"];
//    return $this->pilanav[$this->length()-1];
// }

// function  desplegarNavegacion(){
    
//     $navegacion=""    ;
//     $this->pilanav=$_SESSION["histonav"] ; 
//     $contzindex=9;
//     foreach ($this->pilanav as $historial){
         
//          $navegacion.='<li><a href="'.$historial[1].'" style="z-index:'.($contzindex--).';">'.($historial[2]).'</a></li>';

//      }
//      return $navegacion;
    
    
    
    
// }
public function iniciar(){
    unset($_SESSION["histonav"] );
}
function borrarRutaActual($indice){
    $pilanav=$_SESSION["histonav"] ; //pila de navegacion
    //  echo "antes";
    //  print_r($pilanav);
    if(is_array($pilanav))
    { $rpila=array_reverse($pilanav); //pila de reversa
    if(array_key_exists($indice, $rpila))
    foreach($rpila as $key=>$pos)
    { 
        unset($rpila[$key]);
       
        if($key==$indice)
            break;
        //lo borro
       
    }
    //actualizo pila
    $_SESSION["histonav"]=array_reverse($rpila);
    }
}

function agregarRuta($indice, $ruta, $descripcion){
    if(isset($_SESSION["histonav"]))
         {  
    $pilanav=$_SESSION["histonav"] ; //pila de navegacion
         }else $pilanav=array();

    //busco ultima posicion
//     if(is_array($pilanav))
//         $ultimo=end($pilanav);
//         //reviso que haya algo
//         if($ultimo!=false)
//         {   $ultpos=$ultimo["pos"]+1;
//         }
//         else
//         {// es el primero
//             $ultpos=0;
//         }
        //agrego ruta
        $pilanav[$indice]=array("ruta"=>$ruta,"desc"=>$descripcion);
        $_SESSION["histonav"]=$pilanav;
        
}

function  desplegarNavegacion(){
    
    $navegacion='<em class="fa fa-dashboard"></em> '    ;
    $pilanav=$_SESSION["histonav"] ;
    $cont=sizeof($pilanav);
    $i=0;
    foreach ($pilanav as $historial){
        if($i!=$cont-1)
        $navegacion.='<li><a href="'.$historial["ruta"].'" >'.($historial["desc"]).'</a></li>';
        else
            $navegacion.='<li class="active">'.($historial["desc"]).'</li>';
            
      $i++;
    }
    echo $navegacion;
    
    
    
    
}
 
}
