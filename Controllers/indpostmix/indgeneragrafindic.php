<?php
require_once '../../Models/conexion.php';
include('../../libs/php-gettext-1.0.12/gettext.inc');
require_once '../../Utilerias/inimultilenguaje.php';

require_once '../../Utilerias/utilerias.php';
require_once "../../Controllers/indpostmix/generadorGraficas.php";
@session_start();
set_time_limit(360);


//$subseccion=$numop;
$usuario_act=$_SESSION["UsuarioInd"];
$grupo = $_SESSION["grupous"];
/*elimino barra de ubicacion */
$usuario=$_SESSION["UsuarioInd"];

 
$seccion = filter_input(INPUT_GET,"sec",FILTER_SANITIZE_SPECIAL_CHARS);

$gfilx=filter_input(INPUT_GET,"filx",FILTER_SANITIZE_SPECIAL_CHARS);

$gfily=filter_input(INPUT_GET,"fily",FILTER_SANITIZE_SPECIAL_CHARS);
$gfiluni=filter_input(INPUT_GET,"filuni",FILTER_SANITIZE_SPECIAL_CHARS);
if ($gfiluni == "") {
   $gfiluni="1.1";
}


$aux = explode(".", $gfilx);

$filx = array();

$filx["reg"] = $aux[0];

$filx["ciu"] = $aux[1];
$filx["niv6"] = $aux[2];
$gfilx=$filx["reg"].".".$filx["ciu"].".".$filx["niv6"];
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
$filuni["edo"]=$auxuni[3];
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
INNER JOIN ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
INNER JOIN ca_nivel4 ON ca_unegocios.une_cla_estado = ca_nivel4.n4_id
INNER JOIN ca_cuentas ON  ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id
WHERE ins_generales.i_claveservicio=1 and ins_generales.i_idcliente=100";
 if(isset($filuni["reg"])&&$filuni["reg"]!="")
  $sqlt.=" and  une_cla_region=".$filuni["reg"];
 if(isset($filuni["uni"])&&$filuni["uni"]!="")
  $sqlt.=" and une_cla_pais=".$filuni["uni"];
 if(isset($zona)&&$zona!="")
  $sqlt.=" and une_cla_zona=".$zona;
 if(isset($filuni["edo"])&&$filuni["edo"]!="")
  $sqlt.=" and une_cla_estado=".$filuni["edo"];

$sqlt.=" and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') <='$fmes_consulta' 
and str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y') >='$mes_consulta_ant'
AND ide_valorreal<>''
AND
ins_detalleestandar.ide_numseccion=".$seccion." 
AND `red_indicador`=-1";

   if(isset($fily["cta"])&&$fily["cta"]!="")
  $sqlt.=" and ca_unegocios.cue_clavecuenta=".$fily["cta"];
if(isset($filx["reg"])&&$filx["reg"]!="")
    $sqlt.=" and ca_unegocios.une_cla_estado=".$filx["reg"];
if(isset($filx["ciu"])&&$filx["ciu"]!="")
   $sqlt.=" and ca_unegocios.une_cla_ciudad=".$filx["ciu"];
if(isset($filx["niv6"])&&$filx["niv6"]!="")
    $sqlt.=" and ca_unegocios.une_cla_franquicia=".$filx["niv6"];
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


$chart[ 0 ][ 0 ] = "<null/>";

//$chart [ 1 ][ 0 ] = "Resultado Promedio";
$chart [ 1 ][ 0 ] = "";
// $chart [ 'chart_data' ][ 2 ][ 0 ] = "Real";

$result = Conexion::ejecutarQuerysp($sqlt);
$i=1;
$banok=0;
$row="";
if (sizeof($result)>0)	//si hay datos los despliegan	
{

	foreach ($result as $rowt){
	   $chart [ 0 ][ $i ] = $rowt["red_parametroesp"];
	   $chart [ 1 ][ $i ] = Utilerias::redondear( $rowt["porc"]);
           $chart[2][$i]=htmlentities($rowt["red_estandar"], ENT_COMPAT ,"ISO-8859-1");
           $chart[2][$i]=str_replace("&deg;","°",$chart[2][$i]);
          // echo $rowt["red_parametroesp"];
          //echo  $rowt["red_estandar"]."xx".htmlentities($rowt["red_estandar"], ENT_COMPAT ,"ISO-8859-1");
          //echo "<br>";
           $refer[$i]= $rowt["refer"];
           //  echo "--".$refer[$i];
           $i++;
	   //echo "<br>val ".$rowt["i_fechavisita"];
	}
        $banok=1;
} 
else
{ 		//sino ponemos un valor por omision para que no marque error
//echo "default";
	$chart [ 0 ][ 1 ] = "Cuenta total";
	$chart [ 0 ][ 2 ] = "Coliformes totales";
	$chart[ 0 ][ 3 ] = "E coli";
	$chart [ 1 ][ 1 ] = 0;
	$chart [ 1 ][ 2 ] = 0;
	$chart[ 1 ][ 3 ] = 0;
      	$draw="<text transition='slide_left'
            delay='1'
            duration='1'
            x='150'
            y='150'
            width='250'
            height='100'
            h_align='center'
            v_align='top'
            rotation='0'
            size='20'
            color='aaaaaa'
            alpha='90'
            >".T_("No hay datos suficientes para generar la grafica")."</text>
";

	
}

//$sufijo=(strlen($unidades[$subseccion])<4)?$unidades[$subseccion]:"";
print "<chart>";
 print "<license>ITQ-8Q3JXHEOASZ0B6SVMYWHM5SXBL</license> ";

print "<axis_category  size='9'  />
        <axis_value shadow='low' min='0' max='110' size='10' alpha='50' steps='11' />
        <link_data url='string'           target='_self'           legend='true'           category='false'     spinning_wheel='true'          /> 
        <series transfer='true' />
        <chart_border color='000000'  top_thickness='0' bottom_thickness='2' left_thickness='0' right_thickness='0' />        
<chart_data>
        ";
for($k=0;$k<2;$k++)
{
     $row.="<row>";
    // echo count($datos[$k]);
     for($i=0;$i<count($chart[$k]);$i++)
	{
	// $row.=creaRow($k, $i, $chart);
         $nomseccion=Utilerias::cortarPalabra ($chart[$k][$i]);
         if($k==0) // es cadena
         { if($i==0)
                $row.= $chart[$k][$i];
            else
               $row.= "<string>".$nomseccion."\r".($chart[2][$i])."</string>";
            
         }
         else if($i==0)
            $row.= "<string>".$nomseccion."\r".($chart[2][$i])."</string>";
         else
         //es numerica
		       if ($grupo == "cue") {
			               $row.= "<number tooltip='".$chart[$k][$i]."'   bevel='bevel1' link='MENindprincipal.php?op=mindi&admin=cons&mes=".$mes_asig."&sec=".$seccion."&filx=".$gfilx.
            "&fily=".$gfily."&ref=".$refer[$i]."&niv=".filter_input(INPUT_GET, "niv",FILTER_SANITIZE_NUMBER_INT)."&ren=F&niv=2&rdata=0.0.1&bg=1&filuni=".$gfiluni."' >".$chart[$k][$i]."</number>";
			} else {
            $row.= "<number tooltip='".$chart[$k][$i]."'   bevel='bevel1' link='MENindprincipal.php?op=mindi&admin=cons&mes=".$mes_asig."&sec=".$seccion."&filx=".$gfilx.
            "&fily=".$gfily."&ref=".$refer[$i]."&niv=".filter_input(INPUT_GET, "niv",FILTER_SANITIZE_NUMBER_INT)."&bg=1&filuni=".$gfiluni."' >".$chart[$k][$i]."</number>";
			}
         }

	 $row.="</row>";
           //     echo "<br>xx-".$row;
}
print $row;
//print creaChartData($chart);
//print "
//			<null/>
//			<string>".$chart [ 0 ][ 1 ]."</string>
//			<string>".$chart [ 0 ][ 2 ]."</string>
//			<string>".$chart [ 0 ][ 3 ]."</string>
//			
//		</row>
//		<row>
//			<string>Rojo</string>
//			<number bevel='gray' shadow='low'>50</number>
//			<number bevel='gray' shadow='low' >71</number>
//			<number bevel='gray' shadow='low'>80</number>
//		</row>";

$alto=350;
$ancho=700;
$xu=700+155;
$x1=$xu;

$razon=(($xu-150)/(sizeof($chart[0])-1));
print "

</chart_data>

	<chart_grid_h alpha='20' color='000000' thickness='1' type='dashed' />
	<chart_label color='000000' suffix='%'    bold='true'   alpha='70' size='11'  position='middle' />

	<chart_rect x='160' y='30' width='".$ancho."' height='".$alto."' positive_alpha='0' />
        <chart_transition type='scale' delay='3' duration='1' order='series' />
     
	<draw> ".$draw."
                     <text shadow='high' color='000000' alpha='50' rotation='-90' size='12' x='65' y='350' width='300' height='200' h_align='center'>"."% ".T_("DE  ESTABLECIMIENTOS  QUE  CUMPLEN   CON   EL   ESTANDAR")."</text>";
if($banok){
    $gf=new GeneradorGraficas;
for($z=sizeof($chart[0])-1;$z>0;$z--){
  

     print $gf->lineaSemaforo($alto,$x1,$refer[$z]);
      $x1=$x1-($razon);
}
}
   print " 
       <rect shadow='down' layer='background' x='160' y='".(30+$alto)."' width='".($ancho+1)."' height='18' fill_color='0080B9' fill_alpha='60' />
       <rect shadow='down' layer='background' x='160' y='".(48+$alto)."' width='".($ancho+1)."' height='28' fill_color='0080B9' fill_alpha='60' />
      ";
 //  <rect x='".($ancho+200)."' y='50' width='66' height='25' fill_color='dddddd' />
  //    <text x='".($ancho+200)."' y='54' size='12'>print</text>
   print "     </draw>
	  <filter>
		<shadow id='low' distance='2' angle='45' color='0' alpha='50' blurX='5' blurY='5' />
		<shadow id='high' distance='7' angle='45' color='0' alpha='40' blurX='15' blurY='15' />
		<shadow id='bg' inner='true' quality='1' distance='50' angle='135' color='000000' alpha='10' blurX='300' blurY='200' knockout='true' />
		<bevel id='bevel1' angle='0' blurX='20' blurY='0' distance='10' highlightAlpha='30' highlightColor='ffffff' shadowAlpha='15' type='inner' />
	</filter>
	<series_color>
		<color>3388ff</color>
		<color>FF8844</color>
		<color>6ac04d</color>
                <color>d41b4f</color>
                <color>f0f233</color>
	</series_color>
	 <legend layout='hide' />
	
	";
//<legend shadow='low' transition='scale' delay='1' duration='1' x='50' y='10' width='200' height='5' layout='horizontal' margin='5' bullet='line' size='12' color='000000' alpha='75' fill_color='FFFF66' fill_alpha='20' line_color='000000' line_alpha='0' line_thickness='0' />

print"
<link>
       <area x='380' y='225' width='20' height='15' target='toggle_fullscreen' tooltip='Screen Mode' />
                       
      <area x='".($ancho+200)."' y='54'
            width='66'  
            height='25' 
            target='print'
            />
	</link>
	

    <context_menu save_as_bmp='true' save_as_jpeg='true' save_as_png='true' />

	
	

</chart>";
