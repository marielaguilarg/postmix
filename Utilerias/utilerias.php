<?php


class Utilerias {
  
function cambiaMesGIng($mesas) {
	$lonmes = strlen ( $mesas );
	if ($lonmes == 6) { // para los meses menores a 10
		$mesasnum = substr ( $mesas, 0, 1 );
		$peras = substr ( $mesas, 2, 4 );
	} else {
		$mesasnum = substr ( $mesas, 0, 2 );
		$peras = substr ( $mesas, 3, 4 );
	}
	// cambia el mes
	switch ($mesasnum) {
		case 1 :
			$mesaslet = T_("Enero");
			break;
		case 2 :
			$mesaslet = T_("Febrero");
			break;
		case 3 :
			$mesaslet = T_("Marzo");
			break;
		case 4 :
			$mesaslet =T_("Abril");
			break;
		case 5 :
			$mesaslet = T_("Mayo");
			break;
		case 6 :
			$mesaslet = T_("Junio");
			break;
		case 7 :
			$mesaslet =T_("Julio");
			break;
		case 8 :
			$mesaslet = T_("Agosto");
			break;
		case 9 :
			$mesaslet = T_("Septiembre");
			break;
		case 10 :
			$mesaslet = T_("Octubre");
			break;
		case 11 :
			$mesaslet = T_("Noviembre");
			break;
		case 12 :
			$mesaslet =T_("Diciembre");
			break;
	}
	return strtoupper($mesaslet)." ".$peras;
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
  function fecha_res($fecha) {
    
      preg_match("/([0-9]{1,2}).([0-9]{1,4})/", $fecha, $mifecha);

            switch ($mifecha [1]) {
                case "01" :
                    $strMes = T_("Enero");
                    break;
                case "02" :
                    $strMes = T_("Febrero");
                    break;
                case "03" :
                    $strMes = T_("Marzo");
                    break;
                case "04" :
                    $strMes = T_("Abril");
                    break;
                case "05" :
                    $strMes = T_("Mayo");
                    break;
                case "06" :
                    $strMes = T_("Junio");
                    break;
                case "07" :
                    $strMes = T_("Jul");
                    break;
                case "08" :
                    $strMes = T_("Ago");
                    break;
                case "09" :
                    $strMes = T_("Sep");
                    break;
                case "10" :
                    $strMes = T_("Oct");
                    break;
                case "11" :
                    $strMes = T_("Nov");
                    break;
                case "12" :
                    $strMes = T_("Dic");
                    break;
            }
            $lafecha = strtoupper($strMes) . "-" . $mifecha [2];
            return $lafecha;
        }
     
   
   
   function mysql_fecha($fecha)	//pasa la fecha de d/m/a?o a formato a?o/m/d
   {
   		
   	
   		$nva_fecha=split('/',$fecha);
		
		return $nva_fecha[2].'/'.$nva_fecha[1].'/'.$nva_fecha[0];
	
   }

   function mysql_fecha2($fecha)	//pasa la fecha de d/m/a?o a formato a?o/m/d
   {
   		
   	
   		$nva_fecha=split('/',$fecha);
		
		return $nva_fecha[2].'-'.$nva_fecha[1].'-'.$nva_fecha[0];
	
   }

   



//funcion para crear el combolist
function llenaListBox($SQL,$html,$option,$select,$expansor) {

    /* llena listas  */

    $SQLmcu = mysql_query($SQL);
    while ($rowcu = mysql_fetch_array($SQLmcu)) {

        $html->asignar($option, "<option value='" . $rowcu[0] . "'>"
                . $rowcu[1] . "</option>");

        $html->expandir($select, '+'.$expansor);
    }
    mysql_free_result($SQLmcu);
    return $html;
}

//funcion para crear el combolist con una opcion seleccionada
function llenaListBoxSel($SQL,$html,$option,$select,$expansor,$opcion_sel) {

    /* llena listas  */

    $SQLmcu = mysql_query($SQL);
    while ($rowcu = mysql_fetch_array($SQLmcu)) {
        if( $rowcu[0]==$opcion_sel)
            $html->asignar($option, "<option value='" . $rowcu[0] . "' selected>"
                    . $rowcu[1] . "</option>");
        else
            $html->asignar($option, "<option value='" . $rowcu[0] . "'>"
                    . $rowcu[1] . "</option>");

        $html->expandir($select, '+'.$expansor);
    }
    mysql_free_result($SQLmcu);
    return $html;
}
   function creaOpcionesSel($SQL_TEM, $seleccion) {

    $RS_SQM_TE = @mysql_query($SQL_TEM);


    while ($registro = @mysql_fetch_row($RS_SQM_TE)) {
    if($registro[0]==$seleccion)
     $op.= "<option value='" . $registro[0] . "'selected='selected' >" . $registro[1] . "</option>";
    else
        $op.= "<option value='" . $registro[0] . "' >" . $registro[1] . "</option>";
    }
    return  $op ;
}

function redondear($valor) {
$float_redondeado=round($valor*1000)/1000;
return $float_redondeado;
}
}
