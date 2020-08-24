<?php
//error_reporting(E_ERROR | E_PARSE | E_NOTICE);
require '../../Models/conexion.php';
require_once('../../libs/php-gettext-1.0.12/gettext.inc');
require '../../Utilerias/inimultilenguaje.php';
require '../../Utilerias/utilerias.php';
//error_reporting(0);

require_once "../../Controllers/indpostmix/generadorGraficas.php";
@session_start();
set_time_limit(400);


//$subseccion=$numop;

$grupo = $_SESSION["GrupoUs"];
/*elimino barra de ubicacion */
$usuario=$_SESSION["UsuarioInd"];
$coloresgraf=array("#5cd65c","#ff1a1a","#6600ff","#ffff66","#ff4d4d"," #00e6e6"," #ff9900");
 
$seccion = filter_input(INPUT_GET,"sec",FILTER_SANITIZE_NUMBER_INT);
//$nivel = filter_input(INPUT_GET,"niv",FILTER_SANITIZE_NUMBER_INT);

$gfilx=filter_input(INPUT_GET,"filx",FILTER_SANITIZE_SPECIAL_CHARS);

$gfily=filter_input(INPUT_GET,"fily",FILTER_SANITIZE_SPECIAL_CHARS);
$gfiluni=filter_input(INPUT_GET,"filuni",FILTER_SANITIZE_SPECIAL_CHARS);
if ($gfiluni == "") {
   $gfiluni="1.1";
}

$servicio=1;
$aux = explode(".", $gfilx);

$filx = array();

$filx["edo"] = $aux[0];

$filx["ciu"] = $aux[1];
$filx["niv6"] = $aux[2];
$gfilx=$filx["edo"].".".$filx["ciu"].".".$filx["niv6"];
$auxy = explode(".", $gfily);

$fily = array();

$fily["cta"] = $auxy[0];
$fily["fra"] = $auxy[1];
$fily["pv"] = $auxy[2];
$auxuni=explode(".",$gfiluni);

$filuni=array();
$filuni["reg"]=$auxuni[0];
$filuni["uni"]=$auxuni[1];
$filuni["zon"]=$auxuni[2];

$zona=$filuni["zon"];
$mes_asig=filter_input(INPUT_GET,"mes",FILTER_SANITIZE_SPECIAL_CHARS);
$mes_consulta=$mes_asig;
$aux=explode('.', $mes_consulta);
  
$mes = $aux[0];

$soloanio = $aux[1];

if($mes-12>=0) { // calculo para los 12m
        $z=$mes-12+1;

        $mes_consulta_ant=$aux[1]."-".$z."-01";
      
    }
    else {
        $z=$mes+1;

        $mes_consulta_ant=($aux[1]-1)."-".$z."-01";
    
}
    $fmes_consulta=$aux[1]."-".$aux[0]."-01";
  
  
  //  $mes_consulta_ant= $fmes_consulta;
/****************************************CONSULTA*********************************/
$i=0;

	

$sqlt =" SELECT
 SUM(
    IF(re_tipoevaluacion=1,IF(ide_numrenglon=1,IF(ide_aceptado<0,1,0),0),IF(ide_aceptado<0,1,0))
  ) /  SUM(IF(re_tipoevaluacion=1,IF( ide_numrenglon=1,1, 0),1)) * 100 AS porc,
trim(cue_reactivosestandardetalle.red_parametroesp) red_parametroesp,trim(cue_reactivosestandardetalle.red_parametroing) red_parametroing,
cue_reactivosestandardetalle.red_estandar,
`red_rangor`,`red_rangoa`,`red_rangov`,
concat(cue_reactivosestandardetalle.sec_numseccion,'.',
cue_reactivosestandardetalle.r_numreactivo,'.',
cue_reactivosestandardetalle.re_numcomponente,'.',
cue_reactivosestandardetalle.re_numcaracteristica,'.',
cue_reactivosestandardetalle.re_numcomponente2,'.',
cue_reactivosestandardetalle.red_numcaracteristica2) as refer
FROM
ins_detalleestandar
INNER JOIN cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion 
   AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica 
   AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica

INNER JOIN ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
INNER JOIN ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
WHERE ins_generales.i_claveservicio=$servicio  ";
 if(isset($filuni["reg"])&&$filuni["reg"]!="")
 { $sqlt.=" and  une_cla_region=".$filuni["reg"];
 $nivel=1;}
 if(isset($filuni["uni"])&&$filuni["uni"]!="")
 {$sqlt.=" and une_cla_pais=".$filuni["uni"];
 $nivel=2;}
 if(isset($zona)&&$zona!="")
 { $sqlt.=" and une_cla_zona=".$zona;
 $nivel=3;}

 
$sqlt.=" and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <='$fmes_consulta'


and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >='$mes_consulta_ant'

 AND ide_valorreal<>''
AND
ins_detalleestandar.ide_numseccion=".$seccion." 
AND `red_indicador`=-1";

   if(isset($fily["cta"])&&$fily["cta"]!="")
  $sqlt.=" and ca_unegocios.cue_clavecuenta=".$fily["cta"];
if(isset($filx["edo"])&&$filx["edo"]!="")
{  $sqlt.=" and ca_unegocios.une_cla_estado=".$filx["edo"];
$nivel=4;}

if(isset($filx["ciu"])&&$filx["ciu"]!="")
{   $sqlt.=" and ca_unegocios.une_cla_ciudad=".$filx["ciu"];
$nivel=5;}
if(isset($filx["niv6"])&&$filx["niv6"]!="")
{   $sqlt.=" and ca_unegocios.une_cla_franquicia=".$filx["niv6"];
$nivel=6;}
if(isset($fily["fra"])&&$fily["fra"]!="")
    $sqlt.=" and ca_unegocios.fc_idfranquiciacta=".$fily["fra"];
if(isset($fily["pv"])&&$fily["pv"]!="")
    $sqlt.=" and ca_unegocios.une_id =".$fily["pv"];
$sqlt.=" GROUP BY
cue_reactivosestandardetalle.sec_numseccion,
cue_reactivosestandardetalle.r_numreactivo,
cue_reactivosestandardetalle.re_numcomponente,
cue_reactivosestandardetalle.re_numcaracteristica,
cue_reactivosestandardetalle.re_numcomponente2,
cue_reactivosestandardetalle.red_numcaracteristica2
ORDER BY cue_reactivosestandardetalle.red_lugarindicador";
//echo $sqlt;
$result = Conexion::ejecutarQuerysp($sqlt);

$banok=0;
$row="";
$i=0;
if (isset($result)&&sizeof($result)>0)	//si hay datos los despliegan	
{
  if($_SESSION["idiomaus"]==2)
      $campo="red_parametroing";
   else $campo="red_parametroesp";
	foreach ($result as $rowt){
	   
	    $chart [  ] =array( $rowt[$campo],$rowt["red_estandar"],Utilerias::redondear( $rowt["porc"]));
	  // echo "*************".htmlentities(str_replace("&deg;","º",$rowt["red_estandar"]), ENT_COMPAT ,"ISO-8859-1") ;
           $refer[]= $rowt["refer"];
          //  echo "--".$refer[];
           
	   //echo "<br>val ".$rowt["i_fechavisita"];
	}
        $banok=1;
} 
else
{ 		//sino ponemos un valor por omision para que no marque error
//echo "default";
	$chart [  ]=null;
      	$draw=T_("No hay datos suficientes para generar la grafica");


	
}
$nivel=$nivel+1;
//var_dump($refer);
if($banok){
    $gf=new GeneradorGraficas;
  //  var_dump($chart);
for($z=0;$z<sizeof($chart);$z++){
  

   //  print //$gf->lineaSemaforo($alto,$x1,$refer[$z]);
     $arrsemaforo=$gf->buscaRangosSem($refer[$z]);
     $chart[$z][3]=$arrsemaforo["r1"];
     $chart[$z][4]=$arrsemaforo["r2"];
     $chart[$z][5]=$arrsemaforo["a1"];
     $chart[$z][6]=$arrsemaforo["a2"];
     $chart[$z][7]=$arrsemaforo["v1"];
     $chart[$z][8]=$arrsemaforo["v2"];
     
     $chart[$z]["fill"]= $coloresgraf[$z];
     $chart[$z]["label"]["enabled"]=" true";
      if ($grupo == "cue") {
                 $chart[$z][9]= "index.php?action=indindicadoresgrid&admin=cons&mes=".$mes_asig."&sec=".$seccion."&filx=".$gfilx.
            "&fily=".$gfily."&ref=".$refer[$z]."&niv=".$nivel."&ren=F&rdata=0.0.1&bg=1&filuni=".$gfiluni;
			} else {
             $chart[$z][9]= "index.php?action=indindicadoresgrid&admin=cons&mes=".$mes_asig."&sec=".$seccion."&filx=".$gfilx.
            "&fily=".$gfily."&ref=".$refer[$z]."&niv=".$nivel."&bg=1&filuni=".$gfiluni;
			}
   
}
}
//$sufijo=(strlen($unidades[$subseccion])<4)?$unidades[$subseccion]:"";
//echo "<pre>";
////print_r($chart);
//echo "</pre>";


print json_encode($chart);


  