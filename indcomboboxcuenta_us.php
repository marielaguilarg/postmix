<?php
//error_reporting(E_WARNING|E_ERROR);
@session_start();

require_once "Models/crud_cuentas.php";
require_once "Models/crud_franquicias.php";
//require_once "../Models/conexion.php";
require_once "Models/crud_unegocios.php";
include('libs/php-gettext-1.0.12/gettext.inc');
require_once "Utilerias/inimultilenguaje.php";
	
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"mercado"=>"ca_tipomercado",
"cuenta"=>"ca_cuentas",
 "franqcuenta"=>"ca_franquiciascuenta",
"unidadnegocio"=>"ca_unegocios"
);


if (isset($_SESSION["UsuarioInd"])) { //valido que este logeado
    
//$selectDestinoCuenta=$_GET["selectcuenta"];
//$opcionSeleccionadaCuenta=$_GET["opcioncuenta"];
foreach ($_GET as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . filter_input(INPUT_GET, $nombre_campo ,FILTER_SANITIZE_STRING). "';";
  
    eval($asignacion);

}


$selectDestinoCuenta=$selectcuenta;
$opcionSeleccionadaCuenta=$opcioncuenta;

if(validaSelect2($selectDestinoCuenta))
{
	$tabla=$listadoSelects[$selectDestinoCuenta];
	//echo $tabla;
	if (($listadoSelects[$selectDestinoCuenta])=='ca_cuentas')
	{
		    
             $consultaCuenta= DatosCuenta::cuentasxcliente($tabla,$opcionSeleccionadaCuenta,$scli);


	}
        if($tabla=="ca_franquiciascuenta")
            {
        
            $consultaCuenta=DatosFranquicia::franquiciasxCuentacli($scli,$opcionSeleccionadaCuenta);
           
             // consulta para clientes
            if ($_SESSION['GrupoUs'] == 'cli'||$_SESSION['GrupoUs'] == 'muf') {
                $consultaCuenta=DatosFranquicia::franquiciasxNivel($VarNivel2,$nivel,$scli,$opcionSeleccionadaCuenta);
             
             
            }
          
           
        }
	
	if ($tabla=='ca_unegocios')
	{
             $aux=explode(".",$opcionSeleccionadaCuenta);
            $franq=$aux[1];
		if(isset($mer)&&$mer==1)
		{	
                $consultaCuenta= DatosUnegocio::unegociosxTipoMercado($aux[0],$scli,$aux[1]);
                
               

  }
		else
                  {  
  DatosUnegocio::unegociosxNivel("","",null,array("cta"=>$aux[0],"fra"=>$franq),"","");
             
                    if ($_SESSION['GrupoUs'] == 'cli'||$_SESSION['GrupoUs'] == 'muf') {
            $aux2=explode(".", $nivel);
       
                    $consultaCuenta= DatosUnegocio::unegociosxNivel("","",array("pais"=>$aux2[1],"uni"=>$aux2[2],"zon"=>$aux2[3],"reg"=>$aux2[4],"ciu"=>$aux2[5],"niv6" =>$aux2[6]),array("cta"=>$aux[0],"fra"=>$franq));

     }

 }
        
	}

	// Comienzo a imprimir el select
	echo "<select class='form-control' name='".$selectDestinoCuenta."' id='".$selectDestinoCuenta."' onChange='cargaContenidoCuenta(this.id,\"uscliente\",\"usservicio\");'>";
	echo "<option value=''>- ".T_("TODOS")." -</option>";

	foreach($consultaCuenta as $registroCuenta )
	{
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		$registroCuenta[1]=htmlentities($registroCuenta[1]);
		// Imprimo las opciones del select
		echo "<option value='".$registroCuenta[0]."'>".$registroCuenta[1]."</option>";
	}			
	echo "</select>";
}

} else {
   echo "error";
}
function validaSelect2($selectDestinoCuenta)
{
    // Se valida que el select enviado via GET exista
    global $listadoSelects;
    if(isset($listadoSelects[$selectDestinoCuenta])) return true;
    else return false;
}

function validaOpcion2($opcionSeleccionadaCuenta)
{
    // Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
    if(is_numeric($opcionSeleccionadaCuenta)) return true;
    else return false;
}

?>
