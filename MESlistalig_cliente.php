<?php 
// funcion para consulta de resultados con ajax
define('RAIZ',"fotografias");
require_once "Models/crud_cuentas.php";
require_once "Models/crud_servicios.php";
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido

$listadoSelects=array(
        "crcliente"=>"ca_clientes",
        "crservicio"=>"ca_servicios",
        "mercado"=>"ca_tipomercado",
        "cuenta"=>"ca_cuentas",
     "franquiciacta"=>"ca_franquiciascuenta",
        "unidadnegocio"=>"ca_unegocios",
  );

function validaSelect($selectDestino) {
    // Se valida que el select enviado via GET exista
    global $listadoSelects;
    if(isset($listadoSelects[$selectDestino])) return true;
    else return false;
}

function validaOpcion($opcionSeleccionada) {
    // Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
    if($opcionSeleccionada!="") return true;
    else return false;
}

//include('MENinimultilenguaje.php');
$selectDestino=filter_input(INPUT_GET,"select",FILTER_SANITIZE_STRING);
$opcionSeleccionada=filter_input(INPUT_GET,"opcion",FILTER_SANITIZE_STRING);


if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada)) {
    $tabla=$listadoSelects[$selectDestino];
        //$tabla=$listadoSelects[$selectDestino];
        //conectar();
      // Comienzo a imprimir el select

    echo "<select class='form-control' name='".$selectDestino."' id='".$selectDestino."' onchange='cargaContenidoCliente(this.id)'>";
   echo "<option value='0'>- "."TODOS"." -</option>";
  
        switch($tabla){
        case 'ca_servicios':
            $sql="SELECT
`ca_servicios`.`ser_claveservicio`,
`ca_servicios`.`ser_descripcionesp`,
`ca_servicios`.`ser_descripcioning`
FROM `muestreo`.`ca_servicios`
where
`ca_servicios`.`cli_idcliente`='$opcionSeleccionada';";
           
        $consulta=DatosServicio::vistaServicioxCliente($opcionSeleccionada,"ca_servicios");

        foreach($consulta as $registro) {
     
           if(is_dir(RAIZ."/".$registro[0]))//reviso si existe la carpeta de esa cuenta
   {
        // Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
        $registro[1]=htmlentities($registro[1]);
        // Imprimo las opciones del select
        echo "<option value='".$registro[0]."'>".$registro[1]."</option>";}
    }

        break;
       case "ca_cuentas":
           $opcionSeleccionada=substr($opcionSeleccionada,1);// le quito el puntoinicial
           $sql="SELECT

`ca_cuentas`.`cue_clavecuenta`,
`ca_cuentas`.`cue_descripcion`
FROM `muestreo`.`ca_cuentas` where concat(`ca_cuentas`.`cli_idcliente`,'.',
`ca_cuentas`.`ser_claveservicio`)='$opcionSeleccionada' ";
           
           $aux=explode(".",$opcionSeleccionada);
       
           //obtengo el servicio
           $servicio=$aux[1];
           $consulta=DatosCuenta::cuentasxCliente2("ca_cuentas",$aux[0]) ;


//      echo "<option value='0'>- xxx-</option>";
    foreach($consulta as $registro) {
//        echo RAIZ."/".$servicio."/".$registro[0];
               if(is_dir(RAIZ."/".$servicio."/".$registro[0]))//reviso si existe la carpeta de esa cuenta
   {
        // Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
         $registro[1]=htmlentities($registro[1]);
        // Imprimo las opciones del select
        echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
}
    }

         break;
  
        }
      
      
    echo "</select>";

}