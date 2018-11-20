<?php
////////////////////////////////////////////////////////////////////////////////
//																			  //
//   codigo que genera el reporte surveydata								  //
//   y despliega la pantalla para elegir el periodo y la cuenta				  //
//																			  //
////////////////////////////////////////////////////////////////////////////////
include "Models/crud_cuentas.php";
include "Models/crud_surveyData.php";
include "Models/crud_estandar.php";
class SurveyDataController
{  
   private $servicio;
   private $arrcolores;
   private $cuenta;
   private $aceptados,$im;
   private $letrero;
   
    public function descargarArchivo(){
        
     
        set_time_limit(500);
        ini_set("memory_limit","20M");
        define(VACIO,"&nbsp;");
        include("tablahtml.php");
        /////////////////////////////////////////////////////////////////////////////////////////////////
        $this->arrcolores=array("azul"=>"#3333CC","verde"=>"#33FF66","naranja"=>"#FF9900","amarillo"=>"#FFFF33","#9933FF","rojo"=>"#FF0000","verdeo"=>"#CCFFFF","gris"=>"#999999" );
        /////////////////////////////////////////////////////////////////////////////////////////////////
        
        
    /****************************************GENERA REPORTE POR CUENTA***************************/
   
        include ("Utilerias/leevar.php");
      
     
        $this->servicio=1;
        //$fec1="2008-10-02";
        //$fec2="2008-12-30";
        $fec1=$fechainicio.".".$fechainicio2;
        $fec2=$fechafin.".".$fechafin2;
        
        //$nomcuenta="algo33";
        $idcliente=100;
        $prueba=new tablahtml("");			//crea una nueva tabla
        //si son todas las cuentas
       
        if($consulta=="t")
        {   $this->cuenta=-1;
        $nomcuenta="Surveydata".date("dmyHi");
        }else
        {
            $this->cuenta=$cuenta;
            
            $cuenta_des=DatosCuenta::nombreCuenta($cuenta,$idcliente);
            //CREA EL ARCHIVO PARA EXPORTAR
            $nomcuenta="Surveydata".$cuenta_des.date("dmyHi")	;		//nombre del archivo
            
        }
        
        $prueba->nuevoren();
        $prueba->nuevacol($this->unegocio($fec1,$fec2),"","");		//funcion que despliega los datos de la unidad de negocio
        $prueba->nuevacol($this->principal($fec1,$fec2),"","");		//funcion que sepliega el resto del reporte
      
        $cad=$prueba->cierretabla();
   
        $arch= "Archivos/".$nomcuenta.".xlsx";
  
        $this->creaarch($arch,$cad);						//se crea el archivo
     
       
       // $letrero= "pruebas.php?f=".$arch;
     //   echo     "<a href=\"".$letrero.'" title="vinculo">Descargar archivo</a>';
         header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
//header("Content-type: application/force-download");
//         // $f="calendario.ZIP";
         header("Content-Disposition: attachment; filename=\"".$arch."\"");
         readfile($arch);
           
    }
        
        function consultaRatio($fechaini,$fechafin) {
       
            $queryren="SELECT
distinct sabor.valorreal ,
res.ide_numreporte rep,
round(res.ide_valorreal,3) res
FROM
ins_generales inner join
		ins_detalleestandar as res on res.ide_numreporte=i_numreporte and res.ide_claveservicio='1'
		inner join (select `ins_detalleestandar`.`ide_numreporte` AS `numreporte`,`ins_detalleestandar`.`ide_valorreal` AS `valorreal`,
`ins_detalleestandar`.`ide_numrenglon` AS `numrenglon`
from `ins_detalleestandar`
 where (`ins_detalleestandar`.`ide_numcaracteristica3` = '4') and (`ins_detalleestandar`.`ide_numseccion` = '8')
and (`ins_detalleestandar`.`ide_numcomponente` = '1') and (`ins_detalleestandar`.`ide_claveservicio` = '1') and (`ins_detalleestandar`.`ide_numreactivo` = '0')) as sabor
	 on numreporte=res.ide_numreporte
                
		and sabor.numrenglon=res.ide_numrenglon
where res.ide_numcaracteristica3 =  '9' and
		res.ide_numseccion =  '8' AND
		res.ide_numcomponente =  '1' and
		res.ide_claveservicio='1'
		and res.ide_numreactivo='0'";
            $parametros=array();
            if($this->cuenta!=-1)
            {    $queryren.="	and	i_clavecuenta=:cuenta";
                $parametros["cuenta"]=$this->cuenta;
            }
                $queryren.=" and str_to_date(concat('01.',i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechaini),'%d.%m.%Y')
and str_to_date(concat('01.',i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin),'%d.%m.%Y')
		group by numreporte, sabor.valorreal
order by ins_generales.i_fechavisita ASC, rep,  sabor.valorreal";
                $parametros["fechafin"]=$fechafin;
                $parametros["fechaini"]=$fechaini;
                $res=Conexion::ejecutarQuery($queryren,$parametros);
                $arr_ratio=array();
               
                foreach($res as $row){
                    
                    //echo "<br>".$row["valorreal"]."=".$row["res"];
                    //    $arr_reporte[]=$row["res"];
                    $arr_ratio[$row["rep"]][$row["valorreal"]]=$row["res"];
                    
                }
                
               
                return $arr_ratio;
        }
        
        /******************************Genera consulta a la base de datos**********************************/
        function consulta($columna,$fechaini,$fechafin,$reactivo,$ren) {
           
            //echo "<br>".$columna." ".$reactivo;
            $arregloaux=explode('.',$reactivo);
            switch($columna)				//elige la consulta de acuredo al tipo de reactivo
            {
                case 'P':
                    /************************* PARA SECCIONES PONDERADAS ************************/
                    //desglosa el reactivo para conocer la seccion
                    //el reactivo
                    //y la caracteristica
                    $sec=$arregloaux[0];		//seccion
                    $reac=$arregloaux[1];
                   
                    $cad="SELECT
            if(ins_detalle.id_noaplica=-1,'N/A',if(ins_detalle.id_aceptado=-1,1,0)) as res,
			ins_detalle.id_numreporte as rep,
			ins_generales.i_unenumpunto,
			ins_detalle.id_numreactivo,
			ins_detalle.id_numseccion
			FROM
			ins_detalle
			Inner Join ins_generales ON ins_detalle.id_claveservicio = ins_generales.i_claveservicio AND ins_generales.i_numreporte = ins_detalle.id_numreporte
			 INNER JOIN `ca_unegocios` ON `une_id`=i_unenumpunto
  INNER JOIN `ca_cuentas` ON `cue_id`=`cue_clavecuenta`
WHERE
			 ins_generales.i_claveservicio=:servicio";
                    $parametros=array("servicio"=>$this->servicio);
                    if($this->cuenta!=-1)
                    {  $cad.="		and cue_id=:cuenta";
                    $parametros["cuenta"]=$this->cuenta;
                    }
                        $cad.=" and
			 str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechafin),'%d.%m.%Y')
 and str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin),'%d.%m.%Y') and
			ins_detalle.id_numseccion =:sec AND
			ins_detalle.id_numreactivo=:reac order by ins_generales.i_fechavisita ASC, rep";
                        // echo $cad;
                        $parametros["sec"]=$sec;
                        $parametros["reac"]=$reac;
                        $parametros["fechaini"]=$fechaini;
                        $parametros["fechafin"]=$fechafin;
                        break;
                case 'E':
                    /****************************PARA SECCIONES ESTANDAR***************************/
                    
                    $sec=$arregloaux[0];	//desglosa el reactivo para conocer la seccion
                    //el reactivo
                    //la caracteristica
                    //y el componente
                    $reac=$arregloaux[1];
                    $com1=$arregloaux[2];
                    $car1=$arregloaux[3];
                    $com2=$arregloaux[4];
                    $car2=$arregloaux[5];
                    
                    
                    $cadaux="SELECT
                    
cue_reactivosestandardetalle.red_tipodato as tipodato,
cue_reactivosestandardetalle.red_clavecatalogo as clavecat
FROM
cue_reactivosestandardetalle
where
cue_reactivosestandardetalle.ser_claveservicio=:servicio and
cue_reactivosestandardetalle.sec_numseccion=:sec and
cue_reactivosestandardetalle.r_numreactivo=:reac and
cue_reactivosestandardetalle.re_numcomponente=:com1 and
cue_reactivosestandardetalle.red_numcaracteristica2=:car2 ";
                    //echo $cadaux;
                    $row1=DatosEst::editaEstDetalleModel($sec.$reac.$com1.$car1.$com2.$car2,$this->servicio,"cue_reactivosestandardetalle");
                    if ($row1["tipodato"]=='C') {
                        $cat=$row1["clavecat"];
                        //		echo $row1["tipodato"];
                    }
                    
                    $cad="SELECT
ins_detalleestandar.ide_numreactivo,
ins_detalleestandar.ide_numcomponente,
ins_detalleestandar.ide_numcaracteristica1,
ins_detalleestandar.ide_numcaracteristica2,
ins_detalleestandar.ide_numcaracteristica3,
ins_detalleestandar.ide_valorreal as res,
ins_detalleestandar.ide_aceptado,
ins_detalleestandar.ide_comentario,
ins_detalleestandar.ide_numrenglon,
ins_detalleestandar.ide_numcolarc,
ins_detalleestandar.ide_numseccion, ins_detalleestandar.ide_numreporte as rep
FROM
ins_generales
Inner Join ins_detalleestandar ON ins_generales.i_claveservicio = ins_detalleestandar.ide_claveservicio 
AND ins_generales.i_numreporte = ins_detalleestandar.ide_numreporte
 INNER JOIN `ca_unegocios` ON `une_id`=i_unenumpunto
  INNER JOIN `ca_cuentas` ON `cue_id`=`cue_clavecuenta`
WHERE
ins_generales.i_claveservicio =:servicio AND";
                    $parametros["servicio"]=$this->servicio;
                    if($this->cuenta!=-1)
                    {    $cad.=" cue_id =:cuenta AND";
                    $parametros["cuenta"]=$this->cuenta;}
                    
                     $cad.="
 str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechaini),'%d.%m.%Y') 
and str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin),'%d.%m.%Y') AND
ins_detalleestandar.ide_numseccion =:sec AND
ins_detalleestandar.ide_numreactivo =:reac AND
ins_detalleestandar.ide_numcomponente =:com1 and
ins_detalleestandar.ide_numcaracteristica3=:car2 and
ins_detalleestandar.ide_numrenglon=:ren order by ins_generales.i_fechavisita ASC, rep";
                     $parametros["sec"]=$sec;
                     $parametros["reac"]=$reac;
                     $parametros["com1"]=$com1;
                     $parametros["car2"]=$car2;
                     $parametros["ren"]=$ren;
                     $parametros["fechaini"]=$fechaini;
                     $parametros["fechafin"]=$fechafin;
                        //si es otro tipo de dato lo busca en el catalogo
                        if ($row1["tipodato"]=='C') {
                            $cad="SELECT
ins_detalleestandar.ide_numreporte AS rep,
ca_catalogosdetalle.cad_descripcioning as res
FROM
ins_generales
Inner Join ins_detalleestandar ON ins_generales.i_claveservicio = ins_detalleestandar.ide_claveservicio 
AND ins_generales.i_numreporte = ins_detalleestandar.ide_numreporte
Inner Join ca_catalogosdetalle ON ins_detalleestandar.ide_valorreal = ca_catalogosdetalle.cad_idopcion
 INNER JOIN `ca_unegocios` ON `une_id`=i_unenumpunto
  INNER JOIN `ca_cuentas` ON `cue_id`=`cue_clavecuenta`
WHERE
ins_generales.i_claveservicio =:servicio AND";
                           
                            $parametros["servicio"]=$this->servicio;
                         
                            if($this->cuenta!=-1)
                                $cad.=" cue_id =:cuenta AND";
                                {   $parametros["cuenta"]=$this->cuenta;}
                                
                                $cad.=" str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechaini),'%d.%m.%Y') and str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin),'%d.%m.%Y') AND
ins_detalleestandar.ide_numseccion =:sec AND
ins_detalleestandar.ide_numreactivo =:reac AND
ins_detalleestandar.ide_numcomponente =:com1 AND
ins_detalleestandar.ide_numcaracteristica3 =:car2 AND
ca_catalogosdetalle.cad_idcatalogo =:cat and
ins_detalleestandar.ide_numrenglon=:ren order by ins_generales.i_fechavisita ASC, rep";
                                $parametros["cat"]=$cat;
                                
                        }
                        
                        
                        break;
                        /****************************ABIERTA***************************/
                        
                case 'A':
                    //desglosa el reactivo para conocer la seccion
                    //el reactivo
                    //y la caracteristica
                    $sec=$arregloaux[0];
                    $reac=$arregloaux[1];
                    $com1=$arregloaux[2];
                    $car1=$arregloaux[3];
                    $com2=$arregloaux[4];
                    $car2=$arregloaux[5];
                    
                    
                    $cad="SELECT
ins_detalleabierta.ida_numreporte AS rep,
ins_detalleabierta.ida_numcaracteristica3,
cue_reactivosabiertosdetalle.rad_descripcionesp,
ins_detalleabierta.ida_descripcionreal AS res,
ins_detalleabierta.ida_numreactivo,
cue_reactivosabiertosdetalle.rad_tiporeactivo,
cue_reactivosabiertosdetalle.rad_formatoreactivo as formato,
cue_reactivosabiertosdetalle.rad_clavecatalogo as cat
FROM
ins_detalleabierta

Inner Join ins_generales ON ins_generales.i_numreporte = ins_detalleabierta.ida_numreporte 
AND ins_detalleabierta.ida_claveservicio = ins_generales.i_claveservicio
 INNER JOIN `ca_unegocios` ON `une_id`=i_unenumpunto
  INNER JOIN `ca_cuentas` ON `cue_id`=`cue_clavecuenta`
Inner Join cue_reactivosabiertosdetalle ON ins_detalleabierta.ida_claveservicio = cue_reactivosabiertosdetalle.ser_claveservicio 
AND ins_detalleabierta.ida_numseccion = cue_reactivosabiertosdetalle.sec_numseccion 
AND ins_detalleabierta.ida_numreactivo = cue_reactivosabiertosdetalle.r_numreactivo AND ins_detalleabierta.ida_numcomponente = cue_reactivosabiertosdetalle.ra_numcomponente
 AND ins_detalleabierta.ida_numcaracteristica3 = cue_reactivosabiertosdetalle.rad_numcaracteristica2
WHERE ins_detalleabierta.ida_claveservicio =:servicio and";
                    if($this->cuenta!=-1)
                    {   $cad.=" cue_id =:cuenta AND ";
                       $parametros["cuenta"]=$this->cuenta;
                    }
                        $cad.=" str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechafin),'%d.%m.%Y') 
and str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin),'%d.%m.%Y')  AND
		ins_detalleabierta.ida_numseccion =:sec AND
		ins_detalleabierta.ida_numreactivo=:reac and
		ins_detalleabierta.ida_numcomponente =:com1  and
		ins_detalleabierta.ida_numcaracteristica3=:car2 and
		ins_detalleabierta.ida_numrenglon=:ren
		order by ins_generales.i_fechavisita ASC,
		ins_detalleabierta.ida_numreporte  ";
                        $parametros["sec"]=$sec;
                        $parametros["reac"]=$reac;
                        $parametros["com1"]=$com1;
                        $parametros["car2"]=$car2;
                        $parametros["ren"]=$ren;
                        $parametros["fechaini"]=$fechaini;
                        $parametros["fechafin"]=$fechafin;
                        $rsc=Conexion::ejecutarQuery($cad,$parametros);
                        
                        //buscamos el tipo de dato del resulatado para buscarlo en el catalogo
                        //si es diferente se cambia la consulta
                        foreach($rsc as $rowdet) {
                            $tipocat=$rowdet["formato"];
                        
                            if($tipocat=="C" )
                                $cad="SELECT
ins_detalleabierta.ida_numreporte AS rep,
ins_detalleabierta.ida_numcaracteristica3,
cue_reactivosabiertosdetalle.rad_descripcionesp,
ins_detalleabierta.ida_descripcionreal,
ca_catalogosdetalle.cad_descripcioning AS res,
ins_detalleabierta.ida_numreactivo,
cue_reactivosabiertosdetalle.rad_tiporeactivo,
cue_reactivosabiertosdetalle.rad_clavecatalogo,
ca_catalogosdetalle.cad_idcatalogo,
ca_catalogosdetalle.cad_idopcion,
cue_reactivosabiertosdetalle.rad_formatoreactivo
FROM ins_detalleabierta Inner Join ins_generales ON ins_generales.i_numreporte = ins_detalleabierta.ida_numreporte 

AND ins_detalleabierta.ida_claveservicio = ins_generales.i_claveservicio 
 INNER JOIN `ca_unegocios` ON `une_id`=i_unenumpunto
  INNER JOIN `ca_cuentas` ON `cue_id`=`cue_clavecuenta`
Inner Join cue_reactivosabiertosdetalle 
ON ins_detalleabierta.ida_claveservicio = cue_reactivosabiertosdetalle.ser_claveservicio 
AND ins_detalleabierta.ida_numseccion = cue_reactivosabiertosdetalle.sec_numseccion 
AND ins_detalleabierta.ida_numreactivo = cue_reactivosabiertosdetalle.r_numreactivo 
AND ins_detalleabierta.ida_numcomponente = cue_reactivosabiertosdetalle.ra_numcomponente 
AND ins_detalleabierta.ida_numcaracteristica3 = cue_reactivosabiertosdetalle.rad_numcaracteristica2 
Inner Join ca_catalogosdetalle ON cue_reactivosabiertosdetalle.rad_clavecatalogo = ca_catalogosdetalle.cad_idcatalogo 
AND ins_detalleabierta.ida_descripcionreal = ca_catalogosdetalle.cad_idopcion
WHERE ";
                            $parametros=array();
                                if($this->cuenta!=-1)
                                {   $cad.=" cue_id =:cuenta AND";
                                $parametros["cuenta"]=$this->cuenta;
                                }
                                    $cad.="	 str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechaini),'%d.%m.%Y') 
and str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin),'%d.%m.%Y')  AND
			ins_generales.i_mesasignacion <=:fechafin  AND
		ins_detalleabierta.ida_numseccion =:sec AND
		ins_detalleabierta.ida_numreactivo=:reac and
		ins_detalleabierta.ida_numcomponente =:com1  and
		ins_detalleabierta.ida_numcaracteristica3=:car2 and
		ins_detalleabierta.ida_numrenglon=:ren' order by ins_generales.i_fechavisita ASC,ins_detalleabierta.ida_numreporte ";
                                    $parametros["sec"]=$sec;
                                    $parametros["reac"]=$reac;
                                    $parametros["com1"]=$com1;
                                    $parametros["car2"]=$car2;
                                    $parametros["ren"]=$ren;
                                    $parametros["fechaini"]=$fechaini;
                                    $parametros["fechafin"]=$fechafin;
                        }
                        
                        //echo $cad;
                        break;
                        /********************************secciones de producto***********************************/
                case 'Prod':
                    $sec=$arregloaux[0];
                    $prod=$arregloaux[1];
                    $cad="SELECT
	ins_detalleproducto.ip_numreporte AS rep,
	ins_detalleproducto.ip_fechacaducidad as res
	FROM
	ins_detalleproducto
	Inner Join ins_generales ON ins_generales.i_claveservicio = ins_detalleproducto.ip_claveservicio 
AND ins_generales.i_numreporte = ins_detalleproducto.ip_numreporte
	WHERE
	ins_detalleproducto.ip_claveservicio =:servicio AND
	ins_detalleproducto.ip_numseccion =:sec AND
	 str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechaini),'%d.%m.%Y') 
and str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin),'%d.%m.%Y')  AND
ins_detalleproducto.ip_descripcionproducto=:prod order by ins_generales.i_fechavisita ASC,rep";
                    $parametros["sec"]=$sec;
                    $parametros["prod"]=$prod;
                   
                    $parametros["servicio"]=$this->servicio;
                    $parametros["fechaini"]=$fechaini;
                    $parametros["fechafin"]=$fechafin;
                    break;
                default: $cad=-1;				//si no corresponde a ninguna seccion de estas devuelve -1
                break;
                
            }
    
            return Conexion::ejecutarQuery($cad,$parametros);
        }
        
        /****************************despliega el nombre de la unidad de negocio y fecha de visita********/
        
        function unegocio($fechaini,$fechafin) {
            
          
            ///encabezados de la columna 1 a la 9
            ////////////////////////////////////////////////////////////////////////////////////////////////
            $nomcolumna=array("ID CLIENTE","FRANQUICIA DEL CLIENTE","CUENTA","REGION","ESTADO","CIUDAD",
                "FRANQUICIA DE LA CUENTA","PUNTO DE VENTA","DIRECCION COMPLETA", "MES ASIGNACION",
                "NO. REPORTE", "FECHA VISITA");
            /////////////////////////////////////////////////////////////////////////////////////////////////
            $i=$columna-1;
            
            $tbltemp=new tablahtml("");			//se declara el objeto de la clase tablahtml
          
            
            //consulta para seleccionar los datos de la unidad de negocio
            $sSQL="SELECT
ca_unegocios.une_idpepsi,
ca_nivel3.n3_nombre,ca_cuentas.cue_descripcion,
ca_nivel4.n4_nombre,
ca_nivel5.n5_nombre,
ca_nivel6.n6_nombre,
ca_franquiciascuenta.cf_descripcion,
ca_unegocios.une_descripcion,
                
concat(ca_unegocios.une_dir_calle,' ',
ca_unegocios.une_dir_numeroext,' ',
ca_unegocios.une_dir_numeroint,' ',
ca_unegocios.une_dir_manzana,' ',
ca_unegocios.une_dir_lote,' ',
ca_unegocios.une_dir_colonia,' ',
ca_unegocios.une_dir_delegacion,' ',
ca_unegocios.une_dir_municipio,' ',
ca_unegocios.une_dir_estado,' ',
ca_unegocios.une_dir_cp) dir,
concat(case SUBSTRING_INDEX( ins_generales.i_mesasignacion,'.',1) when 1 THEN 'ENERO' WHEN 2 THEN 'FEBRERO' when 3 THEN 'MARZO' WHEN 4 THEN 'ABRIL' when 5 THEN 'MAYO'
 WHEN 6 THEN 'JUNIO' when 7 THEN 'JULIO' WHEN 8 THEN 'AGOSTO' WHEN 9 THEN 'SEPTIEMBRE' when 10 THEN 'OCTUBRE' WHEN 11 THEN 'NOVIEMBRE' WHEN 12 THEN 'DICIEMBRE'
END,'.',SUBSTRING_INDEX( ins_generales.i_mesasignacion,'.',-1)),
ins_generales.i_numreporte,
date_format( ins_generales.i_fechavisita ,'%d-%m-%Y')
FROM
ins_generales
inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
 inner Join ca_cuentas ON  cue_clavecuenta = ca_cuentas.cue_id
 inner Join ca_nivel3 ON  ca_unegocios.une_cla_zona = ca_nivel3.n3_id
 inner Join ca_nivel4 ON  ca_unegocios.une_cla_estado = ca_nivel4.n4_id
left Join ca_nivel5 ON  ca_unegocios.une_cla_ciudad = ca_nivel5.n5_id
left Join ca_nivel6 ON  ca_unegocios.une_cla_franquicia = ca_nivel6.n6_id
 left Join ca_franquiciascuenta ON ca_unegocios.fc_idfranquiciacta = ca_franquiciascuenta.fc_idfranquiciacta 
 where ins_generales.i_claveservicio=:servicio ";
            $parametros=array("servicio"=>$this->servicio);
            if($this->cuenta!=-1)
            {    $sSQL.="  and ca_unegocios.cue_clavecuenta=:cuenta";
            $parametros["cuenta"]=$this->cuenta;  }
                $sSQL.=" and  str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechaini),'%d.%m.%Y') 
and str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin),'%d.%m.%Y')
order by ins_generales.i_fechavisita ASC, i_numreporte";
               
                $parametros["fechaini"]=$fechaini;
                $parametros["fechafin"]=$fechafin;
                $tbltemp->nuevoren();		//se crea un nuevo renglon en la tabla tbltemp
                for($i=0;$i<sizeof($nomcolumna);$i++) {
                    $tbltemp->nuevacol($nomcolumna[$i],$this->arrcolores["gris"],"");			//se crea una columna para cada encabezado	 con la funcion nueva col, se indica el color
                }
                $tbltemp->finren();				//fin del renglon
                $res=Conexion::ejecutarQuery($sSQL,$parametros);
               
                if($res) {
                     
                   foreach($res  as $row) {
                      
                        $tbltemp->nuevoren();			//se crea un nuevo renglon en la tabla tbltemp
                        for ($i=0;$i<sizeof($row)/2;$i++) {
                            $val=$row[$i];
                            $tbltemp->nuevacol($val,'',"");			//se crea una nueva columna para cada dato	devuelto por la consulta
                        }
                        $tbltemp->finren();
                        
                    }
                    
                 
                }
             
                   
                    
                    return $tbltemp->cierretabla();		//funcion que cierra la tabla tbltemp
                 
                    
        }
        /*************************************funcion que crea cada columna del reporte*********************/
        
        function columna($fechaini,$fechafin,$tiporeac,$reactivo,$ren,$col) {
            
            //verificamos l$this->cuentartes que se hicieron en el periodo de tiempo indicado
            
            $sql2="SELECT
	ins_generales.i_unenumpunto,
	ins_generales.i_numreporte as rep
	FROM
	ins_generales
 INNER JOIN `ca_unegocios` ON `une_id`=i_unenumpunto
  INNER JOIN `ca_cuentas` ON `cue_id`=`cue_clavecuenta`
	WHERE
	ins_generales.i_claveservicio =:servicio AND";
            $parametros=array("servicio"=>$this->servicio);
            if($this->cuenta!=-1)
            {  $sql2.=" cue_id =:cuenta AND";

            $parametros["cuenta"]=$this->cuenta;}
                $sql2.=" str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechafin),'%d.%m.%Y')
        and str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin),'%d.%m.%Y') order by ins_generales.i_fechavisita ASC,rep";
                $parametros["fechaini"]=$fechaini;
                $parametros["fechafin"]=$fechafin;
                $i=0;
                $res2=Conexion::ejecutarQuery($sql2,$parametros);
                $num_reg2 = sizeof($res2);
                if($num_reg2!=0) {
                   foreach($res2 as $row2) {
                        $reportes[$i++]=$row2["rep"];		//el numero del reporte se asignan al arreglo reportes parta comparar despues
                        //echo $reportes[$i-1];
                    }
                }
                //    if($reactivo=='8.0.1.0.0.9')// ren sera el sabor
                //          $sSQL=consultaRatio($fechaini,$fechafin,$ren);
                //        else
                
                $res=$this->consulta($tiporeac,$fechaini,$fechafin,$reactivo,$ren);		//realiza la consulta
                // para cada columna que aparecerá en el reporte
                $otabla=new tablahtml("");					//crea un objeto tablahtml
                
                //echo "<br>blabla ".$recativo;
                if($res=='-1')				//si la consulta no es de ningun tipo de reactivo
                // busca las especificaciones en la tabla de configuracion del surveydata
                {
                    //echo "2";
                 
                    for($i=0;$i<$num_reg2;$i++) {
                        $band=0;
                        $otabla->nuevoren();
                        $color='';
                        //echo "VEZ".$i;
                        $res=DatosSurveyData::getSurveyData($col,"cnfg_surveydata");
                       
                        $val=$res["res"];
                        $otabla->nuevacol($val,$color,"");		//crea una columna para cada dato que tiene
                        //un valor por omisión
                        //$band=1;
                        $otabla->finren();
                    }
                }
                else						//si la consulta fue exitosa
                {							//la ejecuta
                    //echo "<br> VEZ".$i;
                    for($i=0;$i<$num_reg2;$i++) {
                        $band=0;
                        $otabla->nuevoren();
                        $color='';
                        //echo "<br> VEZ".$i;
                     
                       foreach($res as $row) {
                            //echo "<br>reporte "." ".$reportes[$i].$row["rep"];
                            if($reportes[$i]==$row["rep"])			//verificamos que sea del reporte en el que vamos
                            {
                                $val=$row["res"];
                                $otabla->nuevacol($val,$color,"");		//despliega el resultado de cada prueba
                                $band=1;
                                //	echo "sale";
                                break;
                                
                            }
                            /*else
                             {$otabla->nuevacol(VACIO,$color,"");
                             
                             }*/
                        }
                        if($band==0) {
                            //verificamos si hay valor por omisión para esa columna
                            //echo "<br>entró aqui";
                            $sql1=" SELECT
					cnfg_surveydata.surv_valorini as res,
					cnfg_surveydata.surv_numerocol
					FROM
					cnfg_surveydata
					WHERE
					cnfg_surveydata.surv_numerocol =:col'";
                            //echo $sql1;
                            $res1=DatosSurveyData::getSurveyData($col,"cnfg_surveydata");
                            
                            if (sizeof($res1)>0) {
                                
                                
                                $val=$res1["res"];
                                
                            }
                            else				//si este reporte no tiene dato en la tabla
                                // ni valor por omisión quedará en blanco
                                $val=VACIO;
                                $otabla->nuevacol($val,$color,"");
                        }
                        
                        $otabla->finren();
                    }
                }
                
                
                
                return $otabla->cierretabla();			//finaliza la tabla por columna
                //return $otabla;
                
                
        }
        
        /*************************************funcion que crea cada columna ratio del reporte*********************/
        
        function columnasRatio($fechaini,$fechafin,$tiporeac,$reactivo,$col) {
          
            $opcion_sabor=array(1=>"RATIO PEPSI",
                2=>  "RATIO PEPSI LIGHT",
                4=> "RATIO MIRINDA",
                3=>"RATIO SEVEN UP",
                6=>"RATIO MANZANITA",
                5=>"RATIO KAS",
                11=>"RATIO BE LIGHT JAMAICA",
                12=>"RATIO BE LIGHT LIMON",
                15=>"RATIO BE LIGHT MANGO",
                13=>"RATIO LIPTON");
            //verificamos los reportes que se hicieron en el periodo de tiempo indicado
            
            $sql2="SELECT
	ins_generales.i_unenumpunto,
	ins_generales.i_numreporte as rep
	FROM
	ins_generales
 INNER JOIN `ca_unegocios` ON `une_id`=i_unenumpunto
  INNER JOIN `ca_cuentas` ON `cue_id`=`cue_clavecuenta`
	WHERE
	ins_generales.i_claveservicio =:servicio AND";
            $parametros=array();
            if($this->cuenta!=-1)
            {   $sql2.=" cue_id =:cuenta AND";
            
            
                $parametros["cuenta"]=$this->cuenta;}
            
                $sql2.=" str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechafin),'%d.%m.%Y')
        and str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechafin),'%d.%m.%Y')
     order by ins_generales.i_fechavisita ASC,rep";
                $parametros["servicio"]=$this->servicio;
              
                $parametros["fechaini"]=$fechaini;
                $parametros["fechafin"]=$fechafin;
                $i=0;
                $res2=Conexion::ejecutarQuery($sql2,$parametros);
                $num_reg2 = sizeof($res2);
                if($num_reg2!=0) {
                    foreach($res2 as $row2) {
                        $reportes[$i++]=$row2["rep"];		//el numero del reporte se asignan al arreglo reportes para comparar despues
                        //echo $reportes[$i-1];
                    }
                }
                $arr_ratio=$this->consultaRatio($fechaini,$fechafin);
                
                // para cada columna que aparecerá en el reporte
                $otabla=new tablahtml("");					//crea un objeto tablahtml
                
                //echo "<br>blabla ".$recativo;
                if(sizeof($arr_ratio)<=0)				//si la consulta no es de ningun tipo de reactivo
                // busca las especificaciones en la tabla de configuracion del surveydata
                {
                    //echo "2";
                    $sSQL=" SELECT
				cnfg_surveydata.surv_valorini as res,
				cnfg_surveydata.surv_numerocol
				FROM
				cnfg_surveydata
				WHERE
				cnfg_surveydata.surv_numerocol =:col";
                    for($i=0;$i<$num_reg2;$i++) {
                     
                        $otabla->nuevoren();
                        $color='';
                        //echo "VEZ".$i;
                       
                        $row=DatosSurveyData::getSurveyData($col,"cnfg_surveydata");
                        
                        $val=$row["res"];
                        $otabla->nuevacol($val,$color,"");		//crea una columna para cada dato que tiene
                        //un valor por omisión
                        //$band=1;
                        $otabla->finren();
                    }
                }
                else						//si la consulta fue exitosa
                {							//la ejecuta
                    //echo "<br> VEZ".$i;
                    
                    $i=0;
                    
                    foreach($arr_ratio as $numrep=>$arr_sab ) {
                     
                        
                        $color='';
                        
                        
                        if($reportes[$i]==$numrep)			//verificamos que sea del reporte en el que vamos
                        {
                            $otabla->nuevoren();
                            
                            foreach($opcion_sabor as $key=>$sabor) {
                                $val="";
                                $val=$arr_sab[$key];
                                
                                $otabla->nuevacol($val,$color,"");		//despliega el resultado de cada prueba
                                
                            }
                        
                            $i++;
                            $otabla->finren();
                        }
                       
                    }//finaliza para todos los reportes
                 
                    
                    
                }
                
                
                
                
                return $otabla->cierretabla();			//finaliza la tabla por columna
                //return $otabla;
                
                
        }
        
        
        /***********************************ABRE Y ESCRIBE ARCHIVO EN EXCEL*****************/
        function creaarch($archivo,$cadena) {
            //$archivo= "c:\\".$cuenta."_".$fecha.".xls";
            $fp = fopen($archivo, "w");				//abre el archivo para escritura
            $write = fputs($fp, $cadena);			//escribe en el archivo
            fclose($fp);
            //echo "ya";
        }
        
        /******************DESPLIEGUE DE CADA PRUEBA*****************************/
        
        function principal($fechaini,$fechafin) {
           
            $opcion_sabor=array(1=>"RATIO PEPSI",
                2=>  "RATIO PEPSI LIGHT",
                4=> "RATIO MIRINDA",
                3=>"RATIO SEVEN UP",
                6=>"RATIO MANZANITA",
                5=>"RATIO KAS",
                11=>"RATIO BE LIGHT JAMAICA",
                12=>"RATIO BE LIGHT LIMON",
                15=>"RATIO BE LIGHT MANGO",
                13=>"RATIO LIPTON");
          
            $tablota = new tablahtml("");			//creamos una nueva tablahtml
            $tablota->nuevoren();				//creamos un nuevo renglon en la tabla $tablota
            
            //consultamos la configuracion del reporte, los reactivos y las columnas
            $sql1="SELECT
		cnfg_surveydata.surv_numerocol ,
		cnfg_surveydata.surv_tiporeactivo ,
		cnfg_surveydata.surv_numeroreac,
		cnfg_surveydata.surv_descripcion,
		cnfg_surveydata.surv_nombrecol,
		cnfg_surveydata.surv_numeroreng
		FROM
		cnfg_surveydata WHERE
cnfg_surveydata.surv_numerocol IS NOT NULL  AND
cnfg_surveydata.surv_nombrecol IS NOT NULL
		ORDER BY cnfg_surveydata.surv_numerocol ASC";
            
            $res1=DatosSurveyData::listaSurveyData("cnfg_surveydata");
            $num_reg = sizeof($res1);
           
            if ($num_reg>1) {
             foreach($res1 as $row1) {
                    $col=$row1[0];
                    
                    $encabezado=$row1[4];			//se busca el nombre de cada columna
                    //				echo $col;
                    if($row1["surv_numeroreac"]=='8.0.1.0.0.9')// para proporcion agua jarabe
                    {
                        foreach($opcion_sabor as $key=>$sabor) {
                            $tablota->nuevacol($sabor,$this->arrcolores["gris"],"");		//se crea cada columna
                            
                        }
                    }
                    else
                        $tablota->nuevacol($encabezado,$this->arrcolores["gris"],"");		//se crea cada columna
                }
            }
            
            $tablota->finren();
            
        
            $tablota->nuevoren();		//un nuevo renglon para cada reporte
           
            $fecha=$fechaini;
            
            
            $res1=DatosSurveyData::listaSurveyData("cnfg_surveydata ");
            $num_reg = sizeof($res1);
            $aumentar=0;
            if ($num_reg>1) {
             foreach($res1 as $row1) {
                    //$tablatemp->nuevoren();
                    
                    $col=$row1[0]+$aumentar;
                    $tiporeac=$row1[1];
                    $reactivo=$row1[2];
                    $renglon=$row1[5];
                    //se llama a la funcion columna que hace las consultas y despliega los datos
                    // cuando sea la proporcion mandara todas
                    if($reactivo=='8.0.1.0.0.9')//
                    {
                        
                        $tablota->nuevacol($this->columnasRatio($fecha,$fechafin,$tiporeac,$reactivo,$col),"",sizeof($opcion_sabor));
                        
                        
                        $aumentar=10; // aumentariamos 10 col al num de col actual
                    }
                    else
                    {
                        $tablota->nuevacol($this->columna($fecha,$fechafin,$tiporeac,$reactivo,$renglon,$col),"","");
                    }
                    //}
                    
                }
            }
            $tablota->finren();
            return $tablota->cierretabla();
            
            
            
        }
        /**
         * @return string
         */
        public function getLetrero()
        {
            return $this->letrero;
        }
    
        
        
}

