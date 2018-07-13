<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
class GeneradorGraficas {

    public function graficaAplica($subseccion, $tiposec, $vserviciou) {

        $usuario_act = $_SESSION ["usuarioconsulta"];
        if ($tiposec == 'E') { //consulta para secciones tipo estandar
            $sql_val = "select ide_aceptado,  red_parametroesp, 
red_parametroing,
sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as totaceptado
from ins_detalleestandar
 inner join cue_reactivosestandardetalle on  ins_detalleestandar.ide_claveservicio=cue_reactivosestandardetalle.ser_claveservicio
and  ins_detalleestandar.ide_numseccion=cue_reactivosestandardetalle.sec_numseccion  and ins_detalleestandar.ide_numreactivo=cue_reactivosestandardetalle.r_numreactivo  
and ins_detalleestandar.ide_numcomponente=cue_reactivosestandardetalle.re_numcomponente  and ins_detalleestandar.ide_numcaracteristica1=cue_reactivosestandardetalle.re_numcaracteristica and ins_detalleestandar.ide_numcaracteristica2=cue_reactivosestandardetalle.re_numcomponente2  and ins_detalleestandar.ide_numcaracteristica3=cue_reactivosestandardetalle.red_numcaracteristica2
 inner join tmp_estadistica 
on ide_numreporte=numreporte
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
where cue_reactivosestandardetalle.red_grafica=-1 AND ide_valorreal<>''
    and  ins_detalleestandar.ide_claveservicio=:vserviciou
    and concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) = :subseccion  and tmp_estadistica.usuario=:usuario_act  GROUP BY ide_aceptado ";
        }
        if ($tiposec == "P") { //consulta para secciones ponderadas
            $sql_val = "SELECT count(id_aceptado) as totaceptado, id_aceptado as ide_aceptado ,
cue_reactivos.r_descripcionesp,
cue_reactivos.r_descripcioning
FROM
ins_detalle
Inner Join cue_reactivos ON ins_detalle.id_claveservicio = cue_reactivos.ser_claveservicio AND ins_detalle.id_numseccion = cue_reactivos.sec_numseccion AND ins_detalle.id_numreactivo = cue_reactivos.r_numreactivo
Inner Join tmp_estadistica ON ins_detalle.id_numreporte = tmp_estadistica.numreporte
where 
concat(ins_detalle.id_numseccion,'.',ins_detalle.id_numreactivo)=:subseccion 
and id_noaplica>-1 and tmp_estadistica.usuario=:usuario_act  and r_grafica=-1 
    and cue_reactivos.ser_claveservicio=:vserviciou
group by ins_detalle.id_numseccion,
ins_detalle.id_numreactivo, id_aceptado";
        }
        if ($tiposec == 'V')
            $sql_val = "SELECT
SUM(`ins_detalleproducto`.`ip_numcajas`) AS totaceptado,if( ip_condicion='V',-1,0) as ide_aceptado
FROM
ins_detalleproducto
Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
WHERE
	 ins_detalleproducto.ip_numseccion = :subseccion 
AND ins_detalleproducto.ip_sinetiqueta=0  and tmp_estadistica.usuario=:usuario_act 
    and cue_secciones.ser_claveservicio=:vserviciou
GROUP BY
ins_detalleproducto.ip_numseccion, ip_condicion;	";

        $parametros = array("subseccion" => $subseccion, "usuario_act" => $usuario_act, "vserviciou" => $vserviciou);

//echo $sql_val;
     
       
     


        $result = Conexion::ejecutarQuery($sql_val,$parametros);
        $i = 1;
        $aceptados = 0;
        $noacep = 0;
        if ($result) {
            foreach ($result as $rowt) {
                //aqui ir?an los valores
                if ($rowt ["ide_aceptado"] == 0) {
                    $aceptados += $rowt ["totaceptado"];
                } else {
                    $noacep += $rowt ["totaceptado"];
                }
                $i ++;

                //echo "aplica <br> val".$rowt["totaceptado"]." ".$rowt["ide_aceptado"];
            }
            $chart [0] = array(T_("No Cumple"),$aceptados);
            $chart [1] = array(T_("Cumple"),$noacep);
        } 


   print json_encode($chart);
    }

    public function graficaComportamiento($subseccion, $vserviciou, $tiposec) {

        $usuario_act = $_SESSION["usuarioconsulta"];


        $campoorder = "mes_asignacion";





        $unidades = array("8.0.1.0.0.9" => T_("Partes de agua por cada una de jarabe"),
            "8.0.2.0.0.9" => T_("Volumenes de CO2"),
            "8.0.2.0.0.6" => "°C",
            "5.0.2.0.0.4" => "pH",
            "5.0.2.0.0.5" => "ppm(CaCO3)",
            "5.0.2.0.0.6" => "ppm(CaCO3)",
            "5.0.2.0.0.7" => "ppm",
            "5.0.2.0.0.8" => "ppm",
            "5.0.2.0.0.9" => "ppm",
            "5.0.2.0.0.10" => "°C",
            "2.8.1.0.0.1" => "psi",
            "2.8.1.0.0.2" => "psi",
            "2.8.1.0.0.3" => "psi",
            "2.8.1.0.0.4" => "psi",
            "6" => T_("Semanas"),
            "7" => T_("Semanas"));

      
        /*         * **************************************CONSULTA PARA SECCIONES ESTANDAR******************************** */
        $i = 0;
        switch ($tiposec) {

            case 'E':


                $sqlt = " SELECT 
sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,ide_valorreal,0),ide_valorreal))/sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as nivaceptren,
tmp_estadistica.mes_asignacion, 
tmp_estadistica.usuario,
date_format(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y'),'%b-%y') as fecha
FROM
ins_detalleestandar
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join tmp_estadistica ON ins_detalleestandar.ide_numreporte = tmp_estadistica.numreporte
Inner Join ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
WHERE cue_reactivosestandar.re_tipoevaluacion > 0 AND ide_valorreal<>'' AND
concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente
,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) = :subseccion
 and cue_reactivosestandardetalle.red_grafica=-1 and tmp_estadistica.usuario=:usuario_act and ins_generales.i_claveservicio=:vserviciou  GROUP BY
ins_detalleestandar.ide_claveservicio,
ins_detalleestandar.ide_numseccion,
cue_reactivosestandar.re_tipoevaluacion,

ins_detalleestandar.ide_numreactivo,
ins_detalleestandar.ide_numcomponente,
ins_detalleestandar.ide_numcaracteristica3,
tmp_estadistica.usuario,
tmp_estadistica.mes_asignacion
ORDER BY
tmp_estadistica.mes_asignacion ASC";
                break;
            case 'V':
                $sqlt = "SELECT

sum(ip_semana)/SUM(`ins_detalleproducto`.`ip_numcajas`) as nivaceptren,
date_format(mes_asignacion,'%b-%y') as fecha
FROM
ins_detalleproducto
Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
WHERE
	 ins_detalleproducto.ip_numseccion = :subseccion
AND ins_detalleproducto.ip_sinetiqueta=0  and tmp_estadistica.usuario=:usuario_act
    and ins_detalleproducto.ip_claveservicio=:vserviciou
GROUP BY
ins_detalleproducto.ip_numseccion,
tmp_estadistica.mes_asignacion

ORDER BY
tmp_estadistica.mes_asignacion ASC;	";
                break;
        }
        $parametros = array("subseccion" => $subseccion, "usuario_act" => $usuario_act, "vserviciou" => $vserviciou);

//echo "<br>comportamiento<br>";
//echo $sqlt;
     

//$chart [ 1 ][ 0 ] = "Resultado Promedio";
    
// $chart [ 'chart_data' ][ 2 ][ 0 ] = "Real";

        $result = Conexion::ejecutarQuery($sqlt,$parametros);
        $i = 1;
        if ($result) { //si hay datos los depliegan	

            foreach ($result as $rowt) {
                $chart []= array($rowt["fecha"], Utilerias::redondear($rowt["nivaceptren"]),$unidades[$subseccion]);
                $i++;
                //echo "<br>val ".$rowt["i_fechavisita"];
            }
        } else {   //sino ponemos un valor por omision para que no marque error
//echo "default";
            $chart [0][1] = "17-10-2011";
            $chart [0][2] = "22-10-2011";
            $chart[0][3] = "28-10-2011";
            
        }

print json_encode($chart);
    }

    public function graficaCumplimiento($seccion, $vserviciou, $tiposec) {

        $usuario_act = $_SESSION["usuarioconsulta"];


//separamos los componentes de la seccion para hacer las consultas
//$cuenta=1;



       
// genera info grafica


        /*         * **************************************CONSULTA PARA SECCIONES ESTANDAR******************************** */
        $i = 0;
        switch ($tiposec) {

            case 'E':
                $arreglo = explode('.', $seccion);
                $seccion = $arreglo[0] . '.' . $arreglo[1] . '.' . $arreglo[2] . '.' . $arreglo[5];

                $sql_reporte_e = "SELECT
sum(If(re_tipoevaluacion=1,If(ide_numrenglon=1,if(ide_aceptado<0,100,0),0),if(ide_aceptado<0,100,0)))/sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as nivaceptren,
tmp_estadistica.mes_asignacion, 
tmp_estadistica.usuario,
date_format(str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y'),'%b-%y') as fecha
FROM
ins_detalleestandar
Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
Inner Join tmp_estadistica ON ins_detalleestandar.ide_numreporte = tmp_estadistica.numreporte
Inner Join ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
WHERE cue_reactivosestandar.re_tipoevaluacion > 0 AND ins_detalleestandar.ide_claveservicio AND ide_valorreal<>''
and ins_detalleestandar.ide_claveservicio=:vserviciou and
concat(cue_reactivosestandar.sec_numseccion,'.', ins_detalleestandar.ide_numreactivo,'.' ,ins_detalleestandar.ide_numcomponente,'.',ins_detalleestandar.ide_numcaracteristica3 )=:seccion and cue_reactivosestandardetalle.red_grafica=-1 and tmp_estadistica.usuario=:usuario_act GROUP BY
ins_detalleestandar.ide_claveservicio,
ins_detalleestandar.ide_numseccion,
cue_reactivosestandar.re_tipoevaluacion,

ins_detalleestandar.ide_numreactivo,
ins_detalleestandar.ide_numcomponente,
ins_detalleestandar.ide_numcaracteristica3,
tmp_estadistica.usuario,
tmp_estadistica.mes_asignacion
ORDER BY
tmp_estadistica.mes_asignacion ASC";
                break;
            case 'P': /*   para secciones ponderadas   */
                $sql_reporte_e = "SELECT Sum(if(ins_detalle.id_aceptado=-1,1,0)) /(count(ins_detalle.id_noaplica))*100 AS nivaceptren,
date_format(mes_asignacion,'%b-%y') as fecha
from
ins_detalle
Inner Join cue_reactivos ON ins_detalle.id_claveservicio = cue_reactivos.ser_claveservicio AND ins_detalle.id_numseccion = cue_reactivos.sec_numseccion AND ins_detalle.id_numreactivo = cue_reactivos.r_numreactivo
Inner Join tmp_estadistica ON ins_detalle.id_numreporte = tmp_estadistica.numreporte
where 
concat(ins_detalle.id_numseccion,'.',ins_detalle.id_numreactivo)=:seccion
            and ins_detalle.id_claveservicio=:vserviciou
and id_noaplica>-1 and tmp_estadistica.usuario=:usuario_act and r_grafica=-1
group by ins_detalle.id_numseccion,
ins_detalle.id_numreactivo,
mes_asignacion;";
                break;

            case 'V': /*  para secciones de producto   */
                $sql_reporte_e = "SELECT (((SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)))*100)/(SUM(`ins_detalleproducto`.`ip_numcajas`))) AS nivaceptren,
date_format(mes_asignacion,'%b-%y') as fecha
FROM
ins_detalleproducto
Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
WHERE
	 ins_detalleproducto.ip_numseccion = :seccion 
AND ins_detalleproducto.ip_sinetiqueta=0  and tmp_estadistica.usuario=:usuario_act
            and cue_secciones.ser_claveservicio=:vserviciou
GROUP BY
ins_detalleproducto.ip_numseccion,
tmp_estadistica.mes_asignacion

ORDER BY
tmp_estadistica.mes_asignacion ASC;	";
                break;
        }

        $parametros = array("seccion" => $seccion, "usuario_act" => $usuario_act, "vserviciou" => $vserviciou);

        $result = Conexion::ejecutarQuery($sql_reporte_e,$parametros);
        $i = 0;
        foreach ($result as $row_rs_sql_reporte_e) {
            //$chart [ 'chart_data' ][ 2][ 0 ] = "aqui";

            $nivel[$i] = Utilerias::redondear($row_rs_sql_reporte_e ['nivaceptren']);
            $fechas[$i] = $row_rs_sql_reporte_e["fecha"];
            $i++;
        }

       
//$chart [ 'chart_data' ][ 2 ][ 0 ] =$usuario_act;
        if (sizeof($result) > 0) {
            for ($j = 0; $j < $i; $j++) {
                //aqui ir?an los valores	
                $chart [$j][0] = $fechas[$j];
                $chart [$j][1] = Utilerias::redondear($nivel[$j]);

                //  echo "<br>val".  $chart [ 'chart_data' ][ 0 ][ $j+1 ] ."   ".$chart [ 'chart_data' ][ 1 ][ $j+1 ]; 
                //  $i++;
            }
        } else { //asignamos datos por omision
            //echo "default";
            $chart [0][1] = 0;
            $chart [1][1] = 0;
            $draw = "<draw> <text transition='slide_left'
            delay='1'
            duration='1'
            x='50'
            y='50'
            width='250'
            height='100'
            h_align='center'
            v_align='center'
            rotation='0'
            size='20'
            color='4400ff'
            alpha='90'
            >No hay datos suficientes para generar la grafica</text>

      </draw>";
        }

           print json_encode($chart);
      
	
    }

// licencia de las graficas
//$GLOBALS["swf"]="CTA6HQR7UFV9TQ-5CWK-2XOI1X0-7L";
//echo $vista2;
    function InsertChart($url) {
        return "<script language=\"JavaScript\" type=\"text/javascript\">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert(\"This page requires AC_RunActiveContent.js.\");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,45,2',
			'width', '600',
			'height', '300',
			'scale', 'noscale',
			'salign', 'TL',
			'bgcolor', '#FFFFFF',
			'wmode', 'opaque',
			'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&timeout=60&retry=2&xml_source=" . urlencode($url) . "',
			'id', 'my_chart',
			'name', 'my_chart',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>";
    }

    public function graficaCumpliminetoAJ($seccion, $vserviciou) {

        $usuario_act = $_SESSION["usuarioconsulta"];

// genera info grafica
//$seccion='2.8.1.0.0.1 ';
//$usuario_act="admin";
//separamos los componentes de la seccion para hacer las consultas
//$cuenta=1;



    

        /*         * **************************************CONSULTA PARA SECCIONES ESTANDAR******************************** */
        $i = 0;
       
        $sql_reporte_e = "SELECT
/*sabor.valorreal,
res.ide_numreporte,
res.ide_valorreal*/

avg(if(ide_aceptado<0,100,0)) as nivaceptren ,
sabor.sab as producto
FROM
		ins_detalleestandar as res
inner join tmp_estadistica on tmp_estadistica.numreporte=res.ide_numreporte
		inner join (select `ins_detalleestandar`.`ide_numreporte` AS `numreporte`,`ins_detalleestandar`.`ide_valorreal` AS `valorreal`,`ins_detalleestandar`.`ide_numrenglon` AS `numrenglon` ,
ca_catalogosdetalle.cad_descripcionesp as sab
from `ins_detalleestandar`
	Inner Join ca_catalogosdetalle ON ide_valorreal = ca_catalogosdetalle.cad_idopcion AND
		ca_catalogosdetalle.cad_idcatalogo =  '2'
 where (`ins_detalleestandar`.`ide_numcaracteristica3` = '4') and (`ins_detalleestandar`.`ide_numseccion` = '8')
and (`ins_detalleestandar`.`ide_numcomponente` = '1') and (`ins_detalleestandar`.`ide_claveservicio` = '1') and (`ins_detalleestandar`.`ide_numreactivo` = '0')) as sabor
	 on sabor.numreporte=res.ide_numreporte

		and sabor.numrenglon=res.ide_numrenglon
where res.ide_numcaracteristica3 =  '9' and
		res.ide_numseccion =  '8' AND
		res.ide_numcomponente =  '1' and
		res.ide_claveservicio='1'
		and res.ide_numreactivo='0'
and tmp_estadistica.usuario=:usuario_act
	group by sabor.valorreal
order by nivaceptren desc; ";
        $parametros = array("usuario_act" => $usuario_act);
        $result = Conexion::ejecutarQuery($sql_reporte_e, $parametros);


        foreach ($result as $row_rs_sql_reporte_e) {

            $nivel[$i] = Utilerias::redondear($row_rs_sql_reporte_e ['nivaceptren']);
            $sabor[$i] = $row_rs_sql_reporte_e["producto"];
            $i++;
        }


//$chart [ 'chart_data' ][ 2 ][ 0 ] =$usuario_act;
        $cad = "";

        if (sizeof($result) > 0) {
            for ($j = 0; $j < $i; $j++) {
                //aqui ir?an los valores	
                $chart [$j][0] = $sabor[$j];
                $chart [$j][1] = $nivel[$j];
                $cad .= $sabor[$j];
            }
        } else { //asignamos datos por omision
            $chart [0][1] = 0;
            $chart [1][1] = 0;

            $draw = "<draw> <text transition='slide_left'
            delay='1'
            duration='1'
            x='50'
            y='50'
            width='250'
            height='100'
            h_align='center'
            v_align='top'
            rotation='0'
            size='20'
            color='4400ff'
            alpha='90'
            >" . T_("No hay datos suficientes para generar la grafica") . "</text>

      </draw>";
        }

//$chart[ 'chart_data' ][0] = array ( "","S","M","T","W","T","F","S","A","b" );
//$chart[ 'axis_category' ] = array ( 'font'=>"arial", 'bold'=>true, 'size'=>8, 'color'=>"000000", 'alpha'=>90, 'skip'=>0, 'orientation'=>  "diagonal_up" );
//$chart[ 'axis_value' ] = array (  'font'=>"arial", 'bold'=>true, 'size'=>11,  'steps'=>3, 'prefix'=>"", 'suffix'=>"%", 'decimals'=>0, 'separator'=>"",  'show_min' =>  true );
//$chart[ 'legend_label' ] = array ( 'layout'=>"vertical", 'bullet'=>"square", 'font'=>"arial", 'bold'=>true, 'size'=>11, 'color'=>"000000", 'alpha'=>100 );
//
//$chart[ 'chart_value' ] = array (  'color'=>"000000", 'background_color'=>"aaff00",  'alpha'=>90, 'font'=>"arial", 'bold'=>true, 'size'=>12, 'position'=>"cursor", 'prefix'=>"", 'suffix'=>"", 'decimals'=>2, 'separator'=>"", 'as_percentage'=>true );
//
//$chart [ 'chart_rect' ] = array ( 'width'=>400, 'height'=>150  );
//
//$chart[ 'series_color' ] = array (  "88dd11","ddaa41", );
//$chart[ 'series_gap' ] = array ( 'set_gap'=>0, 'bar_gap'=>0 );
         print json_encode($chart);
      
       
    }

    public function graficaFrecuencia($subseccion, $vserviciou) {

        $unidades = array("8.0.1.0.0.9" => T_("Partes de agua por cada una de jarabe"),
            "8.0.2.0.0.9" => T_("Volumenes de CO2"),
            "8.0.2.0.0.6" => "°C",
            "5.0.2.0.0.4" => "pH",
            "5.0.2.0.0.5" => "ppm(CaCO3)",
            "5.0.2.0.0.6" => "ppm(CaCO3)",
            "5.0.2.0.0.7" => "ppm",
            "5.0.2.0.0.8" => "ppm",
            "5.0.2.0.0.9" => "ppm",
            "5.0.2.0.0.10" => "°C",
            "2.8.1.0.0.1" => T_("psi"),
            "2.8.1.0.0.2" => "psi",
            "2.8.1.0.0.3" => "psi",
            "2.8.1.0.0.4" => "psi",
            "6" => T_("semanas"),
            "7" => T_("semanas"));

        $usuario_act = $_SESSION["usuarioconsulta"];

    
//obtengo rangos
        $sqlrangos = "SELECT
cnfg_rangosgrafica.rg_valinicial,
cnfg_rangosgrafica.rg_valfinal
FROM
cnfg_rangosgrafica
where cnfg_rangosgrafica.red_servicio='1' and
concat(cnfg_rangosgrafica.red_numseccion,'.',cnfg_rangosgrafica.red_numreactivo,'.',cnfg_rangosgrafica.red_numcomponente,'.',cnfg_rangosgrafica.red_numcaracteristica,'.',cnfg_rangosgrafica.red_numcomponente2,'.',cnfg_rangosgrafica.red_numcaracteristica2)= :subseccion
order by cnfg_rangosgrafica.rg_valinicial";
        $parametros = array("subseccion" => $subseccion);
        $res = Conexion::ejecutarQuery($sqlrangos, $parametros);


        $i = 1;

        if (sizeof($res) > 0) {
            foreach ($res as $rowr) {
                $min = $rowr[0];
                $max = $rowr[1];

                $chart [$i][0] = $min . " - " . $max;


                $sqlt = "SELECT  sum(if(re_tipoevaluacion=1,if( ide_numrenglon=1,1, 0),1)) as cuenta
    FROM
    ins_detalleestandar
    Inner Join cue_reactivosestandar ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandar.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandar.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandar.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandar.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandar.re_numcaracteristica
    Inner Join cue_reactivosestandardetalle ON ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente AND ins_detalleestandar.ide_numcaracteristica1 = cue_reactivosestandardetalle.re_numcaracteristica AND ins_detalleestandar.ide_numcaracteristica2 = cue_reactivosestandardetalle.re_numcomponente2 AND ins_detalleestandar.ide_numcaracteristica3 = cue_reactivosestandardetalle.red_numcaracteristica2
    Inner Join tmp_estadistica ON ins_detalleestandar.ide_numreporte = tmp_estadistica.numreporte
    Inner Join ins_generales ON ins_detalleestandar.ide_claveservicio = ins_generales.i_claveservicio AND ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
    WHERE cue_reactivosestandar.re_tipoevaluacion > 0 AND ide_valorreal<>'' AND
    concat(cue_reactivosestandardetalle.sec_numseccion,'.',cue_reactivosestandardetalle.r_numreactivo,'.',cue_reactivosestandardetalle.re_numcomponente
    ,'.',cue_reactivosestandardetalle.re_numcaracteristica,'.',cue_reactivosestandardetalle.re_numcomponente2,'.',cue_reactivosestandardetalle.red_numcaracteristica2) =:subseccion 
     and cue_reactivosestandardetalle.red_grafica=-1 and tmp_estadistica.usuario=:usuario_act
         and ins_detalleestandar.ide_claveservicio=:vserviciou
    and ide_valorreal>=:min  and ide_valorreal<:max ;";
                $parametros2 = array("vserviciou" => $vserviciou, "usuario_act" => $usuario_act, "min" => $min, "max" => $max,"subseccion"=>$subseccion );
                $result = Conexion::ejecutarQuery($sqlt, $parametros2);


                if (sizeof($result) > 0) {
                    foreach ($result as $rowt) {

                        if ($rowt["cuenta"] == null)
                            $rowt["cuenta"] = 0;
                        $chart [$i][1] = $rowt["cuenta"];
                      //  $chart [$i][2] = $rowt["cuenta"];
                    }
                }
               

                $i++;
            }
        }


//---------------------------------------------------------------------


         print json_encode($chart);
      
	
    }

    public function graficaPromedioJarabe($seccion, $vserviciou) {

        $usuario_act = $_SESSION["usuarioconsulta"];



        /*         * **************************************CONSULTA ******************************** */
        $i = 0;

      

        $sql_reporte_e = "SELECT
(Sum(ip_semana)/SUM(`ins_detalleproducto`.`ip_numcajas`))  as nivaceptren,
ca_catalogosdetalle.cad_idopcion,
left(ca_catalogosdetalle.cad_descripcionesp,16) as sabor
FROM
ins_detalleproducto
Inner Join tmp_estadistica ON tmp_estadistica.numreporte = ins_detalleproducto.ip_numreporte
Inner Join cue_secciones ON ins_detalleproducto.ip_claveservicio = cue_secciones.ser_claveservicio AND ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
Inner Join ca_catalogosdetalle ON ins_detalleproducto.ip_descripcionproducto = ca_catalogosdetalle.cad_idopcion
WHERE
	 ins_detalleproducto.ip_numseccion =:seccion  and ins_detalleproducto.ip_claveservicio=:vserviciou
AND ins_detalleproducto.ip_sinetiqueta=0  and tmp_estadistica.usuario=:usuario_act and ca_catalogosdetalle.cad_idcatalogo=2
GROUP BY
ins_detalleproducto.ip_numseccion,

ins_detalleproducto.ip_descripcionproducto
ORDER BY
nivaceptren ASC;";


        $parametros = array("seccion" => $seccion, "usuario_act" => $usuario_act, "vserviciou" => $vserviciou);


        $rs_sql_reporte_e = Conexion::ejecutarQuery($sql_reporte_e,$parametros);
        $i = 0;
        foreach ($rs_sql_reporte_e as $row_rs_sql_reporte_e) {

            $nivel[$i] = Utilerias::redondear($row_rs_sql_reporte_e ['nivaceptren']);
            $sabor[$i] = $row_rs_sql_reporte_e["sabor"];
            $i++;
        }


        if (sizeof($rs_sql_reporte_e) > 0) {
            for ($j = 0; $j < $i; $j++) {
                //aqui ir?an los valores	
                $chart [$j][0] = $sabor[$j];
                $chart [$j][1] = $nivel[$j];
            }
        } else { //asignamos datos por omision
            $chart [0][1] = 0;
            $chart [0][2] = 0;

            $draw = "<draw> <text transition='slide_left'
            delay='1'
            duration='1'
            x='0'
            y='50'
            width='550'
            height='100'
            h_align='center'
            v_align='center'
            rotation='0'
            size='30'
            color='4400ff'
            alpha='90'
            >" . T_("No hay datos suficientes para generar la grafica") . "</text>

      </draw>";
        }


         print json_encode($chart);
     
    }
    
 

function lineaSemaforo($alto,$x1,$referencia){
    $y1=62;
    $y2=89;
  
   //RESTO EL 10% DE MAS
    $y0=1/11*($alto);
    $alto=$alto+26;
    $ancho=$alto-$y0-32;
 
     $arrsemaforo=$this->buscaRangosSem($referencia);
     //calculos para el rojo
     $y2=$alto;
     $y1=$alto-($ancho*($arrsemaforo["r2"]/100));
  //   echo "--".$alto;
//     echo $y2."--".$y1."<br>";
     $rojo=" <line transition='slide_right' delay='0' duration='1' x1='".$x1."' y1='".$y1."' x2='".$x1."' y2='".$y2."' line_color='ff0000' line_thickness='6' line_alpha='100' />";
     $y2=$y1-5;
     $y1=$y2-($ancho*(($arrsemaforo["a2"]-$arrsemaforo["a1"])/100))+5;
//     echo $y2."--".$y1."<br>";
     $amarillo=" <line transition='slide_right' delay='0' duration='1' x1='".$x1."' y1='".$y1."' x2='".$x1."' y2='".$y2."' line_color='ffff00' line_thickness='6' line_alpha='100' />";
  
     $y2=$y1-5;
     $y1=$y2-($ancho*(($arrsemaforo["v2"]-$arrsemaforo["v1"])/100))+5;
//   var_dump($arrsemaforo);
// echo $y2."--".$y1."<br>";
     $verde=" <line transition='slide_right' delay='0' duration='1' x1='".$x1."' y1='".$y1."' x2='".$x1."' y2='".$y2."' line_color='00ff00' line_thickness='6' line_alpha='100' />";
          return $verde." ".$amarillo." ".$rojo;       
}

function buscaRangosSem($referencia)
{
  // echo "<br>####".$referencia;
      $aux_sec=explode(".", $referencia);
    $seccion=$aux_sec[0];
    $reac=$aux_sec[1];
    $com=$aux_sec[2];
    $carac1=$aux_sec[3];
    $carac2=$aux_sec[4];
    $carac3=$aux_sec[5];
    $sql="SELECT
  SUBSTRING_INDEX(red_rangor, '^', -1) as rangor1,SUBSTRING_INDEX(red_rangor, '^', -1) as rangor2,
    SUBSTRING_INDEX(red_rangoa, '^', 1) as rangoa1, SUBSTRING_INDEX(red_rangoa, '^', -1) as rangoa2,
      SUBSTRING_INDEX(red_rangov, '^', 1) as rangov1, SUBSTRING_INDEX(red_rangov, '^', -1) as rangov2
    , `sec_numseccion`
    , `r_numreactivo`
    , `re_numcomponente`
    , `re_numcaracteristica`
    , `re_numcomponente2`
    , `red_numcaracteristica2`
FROM
    `cue_reactivosestandardetalle`
WHERE (`ser_claveservicio` =1
    AND `sec_numseccion` =:seccion
    AND `r_numreactivo` =:reac
    AND `re_numcomponente` =:com
    AND `re_numcaracteristica` =:carac1
    AND `re_numcomponente2` =:carac2
    AND `red_numcaracteristica2` =:carac3);";
        $parametros=array("seccion"=>$seccion,"reac"=>$reac,"com"=>$com,"carac1"=>$carac1,"carac2"=>$carac2,"carac3"=>$carac3);
      $res = Conexion::ejecutarQuery($sql,$parametros);
     //echo $sql;
    foreach ($res as $row) {
        $arr =array("r1"=>$row[0],"r2"=> $row[1] ,"a1"=>$row[2] ,"a2"=>$row[3],"v1"=> $row[4] ,"v2"=>$row[5]);
        
    }
   
     return $arr;
}



//llega m�ximo de 30
function cortarPalabra($cadena){
  // echo strlen($cadena);
    if(strlen($cadena)>15){ //corto
        //primero dejo en 30
        if(strlen($cadena)>32)
            $cadena=substr($cadena,0,32);
        $palabras=explode(" ", $cadena);
        //print_r($palabras);
        $contpedazos=0;
        $reng1="";
        foreach ($palabras as $pedazo){
            $reng1.=$pedazo." ";
            $long=strlen($reng1);
           
            $contpedazos++;
            if($long>15)//cuando se pase de 15 paro y quito la ultima
            {
                $aux=explode(" ", $reng1);
                $reng1=substr($reng1, 0, strrpos($reng1," "));
                $long=strlen($reng1);
                break;
            }
        }
        //el renglon 2 ser�a el resto de la cadena
        $reng2=substr($cadena,$long);
        $cadena=$reng1."\r".$reng2;
        
        
    }
    else
        $cadena=$cadena."\r";
    //echo $cadena;
        return $cadena;
}
    



}
