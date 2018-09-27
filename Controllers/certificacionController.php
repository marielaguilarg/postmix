<?php

require "Models/crud_muestras.php";

class CertificacionController{
    
    
    private $listaSolicitudes;
    private $titulo;
    private $subtitulo;
    private $listaEstados;
    private $listaCuentas;
    private $msg;
    private $unegocio;
    private $id_arc_exist;
    private $listaSolDet;
    private $listaComentarios;
    private $enc_autor;
    private $listaUnegocios;
    private $autor_ex;
    private $enc_comen;
    
   
    
    public function vistaListaCertificados(){
        include "Utilerias/leevar.php";
        if($admin=="impcert"){
            $imp=new ImprimirCertificadoController();
            $imp->reporteCERTAgua();
            
        }else
            if($admin=="impanag"){
                $imp=new ImprimirCertificadoController();
                $imp->reporteAnalisis();
        }else{
        $user = $_SESSION["Usuario"];
   
    
    // busco el grupo de usuarios
   
    $rs_sql_gpo =  UsuarioModel::getUsuario($user,"cnfg_usuarios");
    foreach($rs_sql_gpo as $row_rs_sql_gpo  ) {
        $gpo=$row_rs_sql_gpo["cus_clavegrupo"];
        $nvasol=$row_rs_sql_gpo["cus_solcer"];
        $GradoNivel = $row_rs_sql_gpo ["cus_tipoconsulta"];
        $Nivel01 = $row_rs_sql_gpo ["cus_nivel1"];
        $Nivel02 = $row_rs_sql_gpo ["cus_nivel2"];
        $Nivel03 = $row_rs_sql_gpo ["cus_nivel3"];
        $Nivel04 = $row_rs_sql_gpo ["cus_nivel4"];
        $Nivel05 = $row_rs_sql_gpo ["cus_nivel5"];
        $Nivel06 = $row_rs_sql_gpo ["cus_nivel6"];
      
        /*	echo '<script>alert("'.$gpo.'")</script>';   */
    }
    
    if ($nvasol){ //puede crear solicitud
        
        $nuevo='<a href="MENindprincipal.php?admin=cert&opi=nuevo"><img src="../img/nuevasol.gif" width="89" height="25" border="0"></a>';
        $html->asignar('areanuevob',$nuevo);
        $band=1;
    }
    
    
    $this->titulo=T_("CERTIFICACION AGUA POSTMIX NUEVO PUNTO DE VENTA");
    
  $parametros=array();
    IF ($gpo=='cue') {
        $sql_sol="SELECT sol_idsolicitud,sol_descripcion,sol_numrep,sol_fechainicio,dias_trans, sol_fechaapertura, sol_fechaterminacion, dias_antic,IF(sol_estatussolicitud=5,'CANCELADO',RESULTADO) AS RES, sol_idcuenta
FROM (SELECT cer_solicitud.sol_claveservicio, cer_solicitud.sol_idsolicitud, cer_solicitud.sol_descripcion,
cer_solicitud.sol_numrep, cer_solicitud.sol_fechainicio, cer_solicitud.sol_estatussolicitud, datediff(sol_fechaterminacion,sol_fechainicio) AS dias_trans, cer_solicitud.sol_fechaapertura, cer_solicitud.sol_fechaterminacion, datediff(sol_fechaapertura,sol_fechaterminacion) AS dias_antic, cer_solicitud.sol_idcuenta, cer_solicitud.sol_numpunto, ca_unegocios.cue_clavecuenta FROM cer_solicitud
Inner Join ca_unegocios ON  cer_solicitud.sol_numpunto = ca_unegocios.une_numpunto WHERE (cer_solicitud.sol_estatussolicitud =  3 OR cer_solicitud.sol_estatussolicitud =  5)";
        if ($GradoNivel==1) {
            $sql_sol=$sql_sol." AND ca_unegocios.cue_clavecuenta =:Nivel01 ";
            $parametros["Nivel01"]=$Nivel01;
        } else if ($GradoNivel==2) {
            $sql_sol=$sql_sol." AND ca_unegocios.cue_clavecuenta =:Nivel01 AND ca_unegocios.fc_idfranquiciacta =:Nivel02 ";
            $parametros["Nivel01"]=$Nivel01;
            $parametros["Nivel02"]=$Nivel02;
        } else if ($GradoNivel==3) {
            $sql_sol=$sql_sol." AND ca_unegocios.cue_clavecuenta =:Nivel01 AND ca_unegocios.fc_idfranquiciacta =:Nivel02 AND
cer_solicitud.sol_numpunto = :Nivel03";
            $parametros["Nivel01"]=$Nivel01;
            $parametros["Nivel02"]=$Nivel02;
            $parametros["Nivel03"]=$Nivel03;
        }
        $sql_sol=$sql_sol.") AS A LEFT JOIN (SELECT if(ins_detalle.id_aceptado=-1,'APROBADO','NO APROBADO') AS RESULTADO,  ins_detalle.id_numreporte, ins_detalle.id_claveservicio FROM ins_detalle
WHERE ins_detalle.id_claveservicio =  '3' AND ins_detalle.id_numseccion =  '5' AND ins_detalle.id_numreactivo =  '4') AS B ON  A.sol_claveservicio=B.id_claveservicio AND A.sol_numrep=B.id_numreporte ORDER BY sol_idsolicitud DESC;";
    } else if ($gpo=='muf') {
        $sql_sol="SELECT sol_idsolicitud,sol_descripcion,sol_numrep,sol_fechainicio,dias_trans, sol_fechaapertura, sol_fechaterminacion, dias_antic,IF(sol_estatussolicitud=5,'CANCELADO',RESULTADO) AS RES, sol_idcuenta
FROM (SELECT cer_solicitud.sol_claveservicio, cer_solicitud.sol_idsolicitud, cer_solicitud.sol_descripcion, cer_solicitud.sol_numrep, cer_solicitud.sol_fechainicio, cer_solicitud.sol_estatussolicitud, datediff(sol_fechaterminacion,sol_fechainicio) AS dias_trans, cer_solicitud.sol_fechaapertura, cer_solicitud.sol_fechaterminacion, datediff(sol_fechaapertura,sol_fechaterminacion) AS dias_antic, cer_solicitud.sol_idcuenta, cer_solicitud.sol_numpunto, ca_unegocios.cue_clavecuenta FROM cer_solicitud
Inner Join ca_unegocios ON 
cer_solicitud.sol_numpunto = ca_unegocios.une_numpunto WHERE (cer_solicitud.sol_estatussolicitud =  3 OR
cer_solicitud.sol_estatussolicitud =  5)";
        if ($GradoNivel==1) {
            $sql_sol=$sql_sol." AND ca_unegocios.une_cla_region =:Nivel01";
            $parametros["Nivel01"]=$Nivel01;
        } else if ($GradoNivel==2) {
            $sql_sol=$sql_sol."	AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02";
            $parametros["Nivel01"]=$Nivel01;
            $parametros["Nivel02"]=$Nivel02;
        } else if ($GradoNivel==3) {
            $sql_sol=$sql_sol."	AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02 AND ca_unegocios.une_cla_zona =:Nivel03";
            $parametros["Nivel01"]=$Nivel01;
            $parametros["Nivel02"]=$Nivel02;
            $parametros["Nivel03"]=$Nivel03;
        } else if ($GradoNivel==4) {
            $sql_sol=$sql_sol."	AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02 AND ca_unegocios.une_cla_zona =:Nivel03 AND ca_unegocios.une_cla_estado =:Nivel04";
            $parametros["Nivel01"]=$Nivel01;
            $parametros["Nivel02"]=$Nivel02;
            $parametros["Nivel03"]=$Nivel03;
            $parametros["Nivel04"]=$Nivel04;
            
        } else if ($GradoNivel==5) {
            $sql_sol=$sql_sol."	AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02 AND ca_unegocios.une_cla_zona =:Nivel03 AND ca_unegocios.une_cla_estado =:Nivel04 AND ca_unegocios.une_cla_ciudad =:Nivel05";
            $parametros["Nivel01"]=$Nivel01;
            $parametros["Nivel02"]=$Nivel02;
            $parametros["Nivel03"]=$Nivel03;
            $parametros["Nivel04"]=$Nivel04;
            $parametros["Nivel05"]=$Nivel05;
        } else if ($GradoNivel==6) {
            $sql_sol=$sql_sol."	AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02 AND ca_unegocios.une_cla_zona =:Nivel03 AND ca_unegocios.une_cla_estado =:Nivel04 AND ca_unegocios.une_cla_ciudad =:Nivel05 AND ca_unegocios.une_cla_franquicia =:Nivel06";
            $parametros["Nivel01"]=$Nivel01;
            $parametros["Nivel02"]=$Nivel02;
            $parametros["Nivel03"]=$Nivel03;
            $parametros["Nivel04"]=$Nivel04;
            $parametros["Nivel05"]=$Nivel05;
            $parametros["Nivel06"]=$Nivel06;
        }
        $sql_sol=$sql_sol.") AS A LEFT JOIN (SELECT if(ins_detalle.id_aceptado=-1,'APROBADO','NO APROBADO') AS RESULTADO,  ins_detalle.id_numreporte, ins_detalle.id_claveservicio FROM ins_detalle
WHERE ins_detalle.id_claveservicio =  '3' AND ins_detalle.id_numseccion =  '5' AND ins_detalle.id_numreactivo =  '4') AS B ON  A.sol_claveservicio=B.id_claveservicio AND A.sol_numrep=B.id_numreporte ORDER BY sol_idsolicitud DESC";
        
    } else {
        
        $sql_sol="SELECT sol_idsolicitud,sol_descripcion,sol_numrep,sol_fechainicio,dias_trans, sol_fechaapertura, sol_fechaterminacion, dias_antic,IF(sol_estatussolicitud=5,'CANCELADO',RESULTADO) AS RES, sol_idcuenta
FROM
(SELECT cer_solicitud.sol_claveservicio, cer_solicitud.sol_idsolicitud, cer_solicitud.sol_descripcion,  cer_solicitud.sol_numrep,  cer_solicitud.sol_fechainicio, sol_estatussolicitud,
datediff(sol_fechaterminacion,sol_fechainicio) as dias_trans, cer_solicitud.sol_fechaapertura, cer_solicitud.sol_fechaterminacion, datediff(sol_fechaapertura,sol_fechaterminacion) as dias_antic,
cer_solicitud.sol_idcuenta
FROM cer_solicitud WHERE (cer_solicitud.sol_estatussolicitud=3 OR cer_solicitud.sol_estatussolicitud=5)) AS A LEFT JOIN (SELECT if(ins_detalle.id_aceptado=-1,'APROBADO','NO APROBADO') AS RESULTADO, 
 ins_detalle.id_numreporte, ins_detalle.id_claveservicio FROM ins_detalle WHERE ins_detalle.id_claveservicio =  '3' AND ins_detalle.id_numseccion =  '5' AND ins_detalle.id_numreactivo =  '4') AS B 
ON  A.sol_claveservicio=B.id_claveservicio AND A.sol_numrep=B.id_numreporte ORDER BY sol_idsolicitud DESC;";
    }
    
    /* SQLGEN= 'insert into INSTRUCTIONS (textosql) values ("'.$sql_sol.'");';*/
    
    /*$rs1=@mysql_query($SQLGEN);*/
    
    
    $rs_sql_sol = Conexion::ejecutarQuery($sql_sol,$parametros);
   
    $contl=1;
    foreach($rs_sql_sol as $row_rs_sql_sol ) {
       
        $solicitudes=array();
        $solicitudes['Numcert']=  $row_rs_sql_sol ["sol_idsolicitud"]  ;
        $solicitudes['idcuen']=  $row_rs_sql_sol ["sol_idcuenta"]  ;
        $solicitudes['Punto']=  $row_rs_sql_sol ["sol_descripcion"]  ;
        $solicitudes['fechaini']= Utilerias::formato_fecha($row_rs_sql_sol ["sol_fechainicio"])  ;
        // $html->asignar ( 'fechaaper']=  formato_fecha($row_rs_sql_sol ["sol_fechaapertura"]) . "</a></td>" );
        $solicitudes['fechater']=  Utilerias::formato_fecha($row_rs_sql_sol ["sol_fechaterminacion"]) ;
        $solicitudes['diastrans']=  $row_rs_sql_sol ["dias_trans"]  ;
        //$solicitudes[ 'diasant']= "<td  class='$color'>". $row_rs_sql_sol ["dias_antic"] . "</a></td>" );
        $solicitudes[ 'Nrep']=  $row_rs_sql_sol ["sol_numrep"]  ;
        $solicitudes[ 'resul']=  $row_rs_sql_sol ["RES"]  ;
        $impreso="javascript:imprimirCER(".$row_rs_sql_sol["sol_numrep"].");";
        $solicitudes[ 'impres']=$impreso;
        $impreaa="javascript:imprimirANA(".$row_rs_sql_sol["sol_numrep"].");";
        $solicitudes[ 'impanag']= $impreaa;
        // $html->asignar('impres',"<td width='246' class='$color' ><div align='center'><a href='javascript:imprimirCER(".$row_rs_sql_sol["sol_numrep"].");'><img src='../img/print_gold.png' alt='Imprimir' width='28' height='33' border='0' /></a></div>");
        $this->listaSolicitudes[]=$solicitudes;
        $contl++;
    }
        }
    }
    public function vistaEstatusSolicitud(){
        
        $user = $_SESSION["Usuario"];
        // busco el grupo de usuarios
        $rs_sql_gpo =UsuarioModel::getUsuario($user,"cnfg_usuarios");
        foreach ($rs_sql_gpo as $row_rs_sql_gpo ) {
            $gpo=$row_rs_sql_gpo["cus_clavegrupo"];
            $nvasol=$row_rs_sql_gpo["cus_solcer"];
            $GradoNivel = $row_rs_sql_gpo ["cus_tipoconsulta"];
            $Nivel01 = $row_rs_sql_gpo ["cus_nivel1"];
            $Nivel02 = $row_rs_sql_gpo ["cus_nivel2"];
            $Nivel03 = $row_rs_sql_gpo ["cus_nivel3"];
            $Nivel04 = $row_rs_sql_gpo ["cus_nivel4"];
            $Nivel05 = $row_rs_sql_gpo ["cus_nivel5"];
            $Nivel06 = $row_rs_sql_gpo ["cus_nivel6"];
           
        }
     
        
        
        $this->titulo=T_("CERTIFICACION AGUA POSTMIX NUEVO PUNTO DE VENTA");
        $this->subtitulo=T_("ESTATUS SOLICITUD");
   
        
        // validar de acuerdi a grupo de usuarios
        
        $sql_sol="SELECT cer_solicitud.sol_claveservicio, cer_solicitud.sol_idsolicitud, cer_solicitud.sol_fechainicio, datediff(i_fechavisita, sol_fechainicio) AS dias_trans, ins_generales.i_fechavisita, cer_solicitud.sol_numrep, cer_solicitud.sol_descripcion, cer_solicitud.sol_fechaterminacion, datediff(sol_fechaterminacion,".
        " sol_fechainicio) AS dias_tot, cer_solicitud.sol_idcuenta 
FROM cer_solicitud 
Left Join ins_generales ON cer_solicitud.sol_claveservicio = ins_generales.i_claveservicio AND cer_solicitud.sol_numrep = ins_generales.i_numreporte 
Left Join ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
 WHERE ";
$parametros=array();
IF ($gpo=='cue') {
	 if ($GradoNivel==1) {
	     
		$sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2' AND ca_unegocios.cue_clavecuenta =:Nivel01";
		$parametros["Nivel01"]=$Nivel01;
		
	 } else if ($GradoNivel==2) {
		$sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2' AND ca_unegocios.cue_clavecuenta =:Nivel01 AND ca_unegocios.fc_idfranquiciacta =:Nivel02"; 
		$parametros["Nivel01"]=$Nivel01;
		$parametros["Nivel02"]=$Nivel02;
		
	 } else if ($GradoNivel==3) {
    	$sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2' AND ca_unegocios.cue_clavecuenta =:Nivel01 AND ca_unegocios.fc_idfranquiciacta =:Nivel02 AND cer_solicitud.sol_numpunto =:Nivel03"; 	 
    	$parametros["Nivel01"]=$Nivel01;
    	$parametros["Nivel02"]=$Nivel02;
    	$parametros["Nivel03"]=$Nivel03;
    	
	 } else {
	$sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2';";
	}  // fin de nivel
} else if ($gpo=='aud') { //auditor, muestra solo sus asignaciones
  $sql_sol=$sql_sol." cer_solicitud.sol_estatussolicitud=2 AND cer_solicitud.sol_claveinspector =:user";
  $parametros["user"]=$user;
} else if ($gpo=='muf') {  
	if ($GradoNivel==1) {
    $sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2' AND ca_unegocios.une_cla_region =:Nivel01"; 
    $parametros["Nivel01"]=$Nivel01;
  
	} else if ($GradoNivel==2) {
    $sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2' AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02";
    $parametros["Nivel01"]=$Nivel01;
    $parametros["Nivel02"]=$Nivel02;
 
	} else if ($GradoNivel==3) {
	$sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2' AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02 AND ca_unegocios.une_cla_zona =:Nivel03";
	$parametros["Nivel01"]=$Nivel01;
	$parametros["Nivel02"]=$Nivel02;
	$parametros["Nivel03"]=$Nivel03;

	} else if ($GradoNivel==4) {
	$sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2' AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02 AND ca_unegocios.une_cla_zona =:Nivel03 AND ca_unegocios.une_cla_estado =:Nivel04";
	$parametros["Nivel01"]=$Nivel01;
	$parametros["Nivel02"]=$Nivel02;
	$parametros["Nivel03"]=$Nivel03;
	$parametros["Nivel04"]=$Nivel04;

	} else if ($GradoNivel==5) {
	$sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2' AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02 AND ca_unegocios.une_cla_zona =:Nivel03 
AND ca_unegocios.une_cla_estado =:Nivel04 AND ca_unegocios.une_cla_ciudad =:Nivel05";
	$parametros["Nivel01"]=$Nivel01;
	$parametros["Nivel02"]=$Nivel02;
	$parametros["Nivel03"]=$Nivel03;
	$parametros["Nivel04"]=$Nivel04;
	$parametros["Nivel05"]=$Nivel05;
	
	} else if ($GradoNivel==6) {
	$sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2' AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02 AND ca_unegocios.une_cla_zona =:Nivel03 AND ca_unegocios.une_cla_estado =:Nivel04 AND ca_unegocios.une_cla_ciudad =:Nivel05 AND ca_unegocios.une_cla_franquicia =:Nivel06";	
	$parametros["Nivel01"]=$Nivel01;
	$parametros["Nivel02"]=$Nivel02;
	$parametros["Nivel03"]=$Nivel03;
	$parametros["Nivel04"]=$Nivel04;
	$parametros["Nivel05"]=$Nivel05;
	$parametros["Nivel06"]=$Nivel06;
	} else {
   $sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2'";
	} // fin de nivel   
} else {
   $sql_sol=$sql_sol."cer_solicitud.sol_estatussolicitud =  '2'";
} // fin de if de grupo
$sql_sol=$sql_sol." ORDER BY cer_solicitud.sol_idsolicitud DESC";


  $rs_sql_sol = Conexion::ejecutarQuery($sql_sol,$parametros);
        
        $contl=1;
        
        foreach($rs_sql_sol as $row_rs_sql_sol) {
          
            $solicitud=array();
            $solicitud['Nsol1']=  $row_rs_sql_sol ["sol_idsolicitud"]  ;
            $solicitud['idcuen'] = $row_rs_sql_sol ["sol_idcuenta"]  ;
            
            $solicitud['Punto1']=$row_rs_sql_sol ["sol_descripcion"];
            $solicitud['inip']=  Utilerias::formato_fecha($row_rs_sql_sol ["sol_fechainicio"])  ;
            $solicitud['fvis']=  Utilerias::formato_fecha($row_rs_sql_sol ["i_fechavisita"])  ;
            $solicitud['tres']=  $row_rs_sql_sol ["dias_trans"]  ;
            $solicitud['diasant']=  $row_rs_sql_sol ["dias_antic"] ;
            
            $nserv=$row_rs_sql_sol ["sol_claveservicio"];
            $nrep=$row_rs_sql_sol ["sol_numrep"];
          
           
            $rs_sql_rep = DatosMuestras::listaMuestrasxRep($nserv,$nrep,"aa_muestras");
            $num_reg = sizeof($rs_sql_rep);
            if ($num_reg>0) {
                foreach ($rs_sql_rep as $row_rs_sql_rep) {
                    
                    $nmues=$row_rs_sql_rep ["mue_idmuestra"];
                    // busca el laboratorio que recibio la muestra
//                     $sqllab="SELECT aa_recepcionmuestra.rm_embotelladora, aa_recepcionmuestradetalle.mue_idmuestra 
// FROM aa_recepcionmuestradetalle 
// Inner Join aa_recepcionmuestra ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra".
//                     " WHERE aa_recepcionmuestradetalle.mue_idmuestra =  '".$nmues."' GROUP BY
// aa_recepcionmuestradetalle.mue_idmuestra";
                    
                    $nlab="";
                    $rs_sql_mue = DatosRecepcionMuestra::listaRecepcionMuestraDet($nmues);
                    foreach($rs_sql_mue as $row_rs_sql_mue) {
                        $nlab=$row_rs_sql_mue["rm_embotelladora"];
                    }
                    
                    
                    // busca nombre de laboratorio
                  
                    $nlab=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",43,$nlab);
                     $solicitud['entmu']=  Utilerias::formato_fecha($row_rs_sql_rep ["mue_fecharecepcion"])  ;
                    $solicitud['lab']= $nlab;
                    $solicitud['capfis']= Utilerias::formato_fecha($row_rs_sql_rep ["mue_fechoranalisisFQ"]) ;
                    $solicitud['capmic']= Utilerias::formato_fecha($row_rs_sql_rep ["mue_fechoranalisisMB"]) ;
                    $solicitud['tresl']= $row_rs_sql_rep ["dias_trans_lab"] ;
                }
                } else {
                $solicitud['entmu']= "" ;
                $solicitud['lab']= "";
                $solicitud['capfis']="";
                $solicitud['capmic']="";
                $solicitud['tresl']="";
            }
            // $html->asignar ( 'emis', "<td  class='$color'>&nbsp;</td>" );
            // $html->asignar ( 'tt', "<td  class='$color'>&nbsp;</a></td>" );
            
            $this->listaSolicitudes[]=$solicitud;
            $contl++;
        }
    }
        public function vistaListasolicitudes(){
            
          
            
            $user = $_SESSION["Usuario"];
            
          
            
            
            // busco el grupo de usuarios
             $rs_sql_gpo =UsuarioModel::getUsuario($user,"cnfg_usuarios");
            foreach($rs_sql_gpo as $row_rs_sql_gpo) {
                $gpo=$row_rs_sql_gpo["cus_clavegrupo"];
                $nvasol=$row_rs_sql_gpo["cus_solcer"];
                $GradoNivel = $row_rs_sql_gpo ["cus_tipoconsulta"];
                $Nivel01 = $row_rs_sql_gpo ["cus_nivel1"];
                $Nivel02 = $row_rs_sql_gpo ["cus_nivel2"];
                $Nivel03 = $row_rs_sql_gpo ["cus_nivel3"];
                $Nivel04 = $row_rs_sql_gpo ["cus_nivel4"];
                $Nivel05 = $row_rs_sql_gpo ["cus_nivel5"];
                $Nivel06 = $row_rs_sql_gpo ["cus_nivel6"];
               
                /*	echo '<script>alert("'.$gpo.'")</script>';   */
            }
           
            $this->titulo=T_("CERTIFICACION AGUA POSTMIX NUEVO PUNTO DE VENTA");
            $this->subtitulo=T_("SOLICITUDES");
          $parametros=array();   
            $sql_sol="SELECT cer_solicitud.sol_idsolicitud, cer_solicitud.sol_descripcion, IF(sol_estatussolicitud=1,'     SOLICITADA     ',IF(sol_estatussolicitud=4,'  NO ACEPTADA  ','    EN PROCESO    ')) AS ESTATUS, 
cer_solicitud.sol_estatussolicitud, cer_solicitud.sol_fechainicio, datediff(now(),sol_fechainicio) AS dias_trans, 
cer_solicitud.sol_fechaapertura, cer_solicitud.sol_idcuenta, cer_solicitud.sol_claveinspector, datediff(sol_fechaapertura,now()) AS dias_restantes 
FROM cer_solicitud Left Join ca_unegocios ON  cer_solicitud.sol_numpunto = ca_unegocios.une_numpunto WHERE ";
            IF ($gpo=='cue') {
                if ($GradoNivel==1) {
                    $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4)
	 AND ca_unegocios.cue_clavecuenta =:Nivel01";
                    $parametros["Nivel01"]=$Nivel01;
                   
                } else if ($GradoNivel==2) {
                    $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4)
 AND ca_unegocios.cue_clavecuenta =:Nivel01' AND ca_unegocios.fc_idfranquiciacta =:Nivel02";
                    $parametros["Nivel01"]=$Nivel01;
                    $parametros["Nivel02"]=$Nivel02;
                    
                } else if ($GradoNivel==3) {
                    $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4) AND 
ca_unegocios.cue_clavecuenta =:Nivel01 AND ca_unegocios.fc_idfranquiciacta =:Nivel02 AND
cer_solicitud.sol_numpunto =:Nivel03";
                    $parametros["Nivel01"]=$Nivel01;
                    $parametros["Nivel02"]=$Nivel02;
                    $parametros["Nivel03"]=$Nivel03;
                   
                } else {
                    $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4)";
                  
                    
                }  // fin de nivel
            } else if ($gpo=='aud') { //auditor, muestra solo sus asignaciones
                $sql_sol=$sql_sol." cer_solicitud.sol_estatussolicitud=2 AND cer_solicitud.sol_claveinspector =:user";
                $parametros["user"]=$user;
            } else if ($gpo=='muf') {
                if ($GradoNivel==1) {
                    $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4) AND ca_unegocios.une_cla_region =:Nivel01";
                    $parametros["Nivel01"]=$Nivel01;
                
                } else if ($GradoNivel==2) {
                    $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4) AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02";
                    $parametros["Nivel01"]=$Nivel01;
                    $parametros["Nivel02"]=$Nivel02;
                   
                } else if ($GradoNivel==3) {
                    $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4) AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02 AND ca_unegocios.une_cla_zona =:Nivel03";
                    $parametros["Nivel01"]=$Nivel01;
                    $parametros["Nivel02"]=$Nivel02;
                    $parametros["Nivel03"]=$Nivel03;
                  
                } else if ($GradoNivel==4) {
                    $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4) AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02
 AND ca_unegocios.une_cla_zona =:Nivel03 AND ca_unegocios.une_cla_estado =:Nivel04";
                    $parametros["Nivel01"]=$Nivel01;
                    $parametros["Nivel02"]=$Nivel02;
                    $parametros["Nivel03"]=$Nivel03;
                    $parametros["Nivel04"]=$Nivel04;
                 
                } else if ($GradoNivel==5) {
                    $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4) AND ca_unegocios.une_cla_region =:Nivel01
 AND ca_unegocios.une_cla_pais =:Nivel02 AND ca_unegocios.une_cla_zona =:Nivel03 AND ca_unegocios.une_cla_estado =:Nivel04 AND ca_unegocios.une_cla_ciudad =:Nivel05";
                    $parametros["Nivel01"]=$Nivel01;
                    $parametros["Nivel02"]=$Nivel02;
                    $parametros["Nivel03"]=$Nivel03;
                    $parametros["Nivel04"]=$Nivel04;
                    $parametros["Nivel05"]=$Nivel05;
                   
                } else if ($GradoNivel==6) {
                    $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4) AND ca_unegocios.une_cla_region =:Nivel01 AND ca_unegocios.une_cla_pais =:Nivel02 AND ca_unegocios.une_cla_zona =:Nivel03 AND ca_unegocios.une_cla_estado =:Nivel04 AND ca_unegocios.une_cla_ciudad =:Nivel05 AND ca_unegocios.une_cla_franquicia =:Nivel06";
                    $parametros["Nivel01"]=$Nivel01;
                    $parametros["Nivel02"]=$Nivel02;
                    $parametros["Nivel03"]=$Nivel03;
                    $parametros["Nivel04"]=$Nivel04;
                    $parametros["Nivel05"]=$Nivel05;
                    $parametros["Nivel06"]=$Nivel06;
                } else {
                    $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4)";
                } // fin de nivel
            } else {
                $sql_sol=$sql_sol."(cer_solicitud.sol_estatussolicitud<3 || cer_solicitud.sol_estatussolicitud=4)";
            } // fin de if de grupo
            $sql_sol=$sql_sol." ORDER BY cer_solicitud.sol_idsolicitud DESC";
            $rs_sql_sol = Conexion::ejecutarQuery($sql_sol,$parametros);
            $contl=1;
            foreach ($rs_sql_sol as $row_rs_sql_sol ) {
                
                // busca inspector
                $nins=$row_rs_sql_sol ["sol_claveinspector"];
                if ($nins) {
                   
                //echo $sqlins;
                    $rowi = DatosInspector::getInspector($nins,"ca_inspectores");
                    
                    $num_reg = sizeof($rowi);
                    if ($rowi){
                    
                    $nominsp=$rowi['ins_nombre'];
                    
                }else{
                    $nominsp="";
                }
                }
                $solicitud=array();
                $solicitud['Numcert1']=  $row_rs_sql_sol ["sol_idsolicitud"]  ;
                $solicitud['idcuen']=  $row_rs_sql_sol ["sol_idcuenta"]  ;
                // SI SOLICITUD EN PROCESO, NO HAY LINK
                //  IF ($row_rs_sql_sol ["sol_estatussolicitud"]==2){
                $solicitud['Punto1']=  $row_rs_sql_sol ["sol_descripcion"]  ;
                //OTRO SI HY LINK
                //  } else {
                $solicitud['Punto1']=
                    "<a href='index.php?action=editasolicitud&admin=edisol&nsol=".
                    $row_rs_sql_sol ["sol_idsolicitud"] ."'>".$row_rs_sql_sol ["sol_descripcion"]."</a>";
                // }
                $solicitud['estatus']=  $row_rs_sql_sol ["ESTATUS"]  ;
                $solicitud['fechaini']=  Utilerias::formato_fecha($row_rs_sql_sol ["sol_fechainicio"])  ;
                $solicitud['dtrans']=  $row_rs_sql_sol ["dias_trans"]  ;
                //$html->asignar ( 'fechaaper2', "<td  class='$color' width='150'>". formato_fechas($row_rs_sql_sol ["sol_fechaapertura"]) . "</a></td>" );
                //$html->asignar ( 'diasres', "<td  class='$color'>". $row_rs_sql_sol ["dias_restantes"] . "</a></td>" );
                // $impreso="MENindprincipal.php?admin=nvasol".$row_rs_sql_sol ["sol_idsolicitud"];
                $solicitud['arch']=  $nominsp ;
                
                $this->listaSolicitudes[]=$solicitud;
                $contl++;
            }
            
            
        }
        
        public function vistaEditaSolicitud(){
            include ('Utilerias/leevar.php');
           
            
            $idserv=3;
          
            $cuen=1003; 
           $cliente=1;
            if($admin=="validadato"){
                $this->validarIDC();
            }else
            if ($admin=="ingsol") {
             
                $this->insertarsolicitud();
                $admin="edisol";   
            }else
            if ($admin=="ingcom") {
                $this->insertarComentario();
                $nsol=$nrepc;
                $admin="edisol";
            }else
            if($admin=="ingarc"){
                $this->insertarDetalle();
               $nsol=$reporte;
   
                $admin="edisol";
            }else
            
            if($admin=="autsol"){
                $this->autorizarSolicitud("si");
                $nsol=$reporte;
                $admin="edisol";
            }else
            if($admin=="noautsol"){
                $this->autorizarSolicitud("no");
                $nsol=$reporte;
                $admin="edisol";
            }else
            if($admin=="cancel"){
                $this->autorizarSolicitud("cancelar");
                $nsol=$reporte;
                $admin="edisol";
            }
              
            if ($admin=="nvasol") {
                    $nvonum=DatosSolicitud::getUltimaSolicitud($idserv,"cer_solicitud");
                    $nvonum++;
                    $this->unegocio['CLAVEUNINEG']=$nvonum;
                    $this->unegocio['reporte']= $nvonum;
                    $this->unegocio['servicio']= $idserv;
                    $this->unegocio['npunto']= $idc;
               
                // Llena lista de estados
                    $rs=DatosEstado::listaEstadosModel("ca_uneestados");
                    $this->listaEstados="";
                    foreach($rs as $row){
                        $this->listaEstados.="<option value='".$row["est_id"]."'>".$row["est_nombre"]."</option>";
                        
                        
                    }
                
                    // LLENAS LISTA DE CUENTAS
                    $rsc=DatosCuenta::vistaCuentasxcliente($cliente,"ca_cuentas");
                    $this->listaCuentas="";
                    foreach($rsc as $rowc){
                        $this->listaCuentas=$this->listaCuentas."<option value='".$rowc["cue_id"]."'>".$rowc["cue_descripcion"]."</option>";
                    }
                  
                    
                    if ($npun) {
                        // busc info de punto de venta
                     
                        //$html->asignar('msg',$msg);
                        $rsp=DatosUnegocio::classUnegocioCompleta($npun,"ca_unegocios");
                        foreach($rsp as $rowp){
                        $this->unegocio['NPUN'] =$npun;
                        $this->unegocio['NOMUNEG']= $rowp["une_descripcion"];
                         $this->unegocio['IDC'] =$rowp["une_idcuenta"];
                        $idc=$rowp["une_idcuenta"];
                         $this->unegocio['TELUNEG']= $rowp["une_dir_telefono"];
                         $this->unegocio['CALLEUNEG'] =$rowp["une_dir_calle"];
                         $this->unegocio['NUMEXUNEG']= $rowp["une_dir_numeroext"];
                         $this->unegocio['NUMINUNEG'] =$rowp["une_dir_numeroint"];
                         $this->unegocio['MZUNEG']= $rowp["une_dir_manzana"];
                         $this->unegocio['LTUNEG']= $rowp["une_dir_lote"];
                         $this->unegocio['COLUNEG']= $rowp["une_dir_colonia"];
                         $this->unegocio['DELEGUNEG']= $rowp["une_dir_delegacion"];
                         $this->unegocio['MUNUNEG']=$rowp["une_dir_municipio"];
                         $this->unegocio['CPUNEG']= $rowp["une_dir_cp"];
                         $this->unegocio['REFUNEG'] =$rowp["une_dir_referencia"];
                        $idedo=$rowp["une_dir_idestado"];
                        $cta=$rowp["cue_clavecuenta"];
                        
                        // LLENA DATOS ADICIONALES
                        $sqls="SELECT  MAX(cer_solicitud.sol_fechaapertura) AS FECAPER, cer_solicitud.sol_contacto, cer_solicitud.sol_correoelec, cer_solicitud.sol_dir_telefono, cer_solicitud.sol_dir_telmovil
 FROM cer_solicitud WHERE cer_solicitud.sol_idcuenta =:idc GROUP BY cer_solicitud.sol_idcuenta";
                        $rss=Conexion::ejecutarQuery($sqls,array("idc"=>$idc));
                        foreach($rss as $rows){
                            $date=Utilerias::cambiaf_a_normal($rows["FECAPER"]);
                             $this->unegocio['FECESTATUS']=$date;
                             $this->unegocio['ICON']= $rows["sol_contacto"];
                             $this->unegocio['TELUNEG']= $rows["sol_dir_telefono"];
                             $this->unegocio['TELCEL']= $rows["sol_dir_telmovil"];
                             $this->unegocio['MAIL']= $rows["sol_correoelec"];
                        }
                        
                        // Llena lista de estados
                        $rs=DatosEstado::listaEstadoModel("ca_uneestados");
                        $this->listaEstados="";
                        foreach($rs as $row_es) {
                            if($idedo==$row_es["est_id"])
                                $this->listaEstados.="<option value='".$row_es["est_id"]."' selected>".$row_es["est_nombre"]."</option>";
                                else
                                    $this->listaEstados.="<option value='".$row_es["est_id"]."' >".$row_es["est_nombre"]."</option>";
                                    
                        }  // while edo
                        
                        // LLENAS LISTA DE CUENTAS
                        $rsc=DatosCuenta::vistaCuentasxcliente($cliente,"ca_cuentas");
                        $this->listaCuentas="";
                        foreach($rsc as $rowc){
                            if($cta==$rowc["cue_clavecuenta"])
                                $this->listaCuentas.="<option value='".$rowc["cue_id"]."' selected>".$rowc["cue_descripcion"]."</option>";
                                else
                                    $this->listaCuentas.="<option value='".$rowc["cue_id"]."' >".$rowc["cue_descripcion"]."</option>";
                                    
                        }  // while cuenta
                        
                    }  // while de punto de venta
                }	// if npun
                
                if ($idcta) {
                    $this->unegocio['IDC']= $idcta;
                    // LLENAS LISTA DE CUENTAS
                    $rsc=DatosCuenta::vistaCuentasxcliente($cliente,"ca_cuentas");
                    $this->listaCuentas="";
                    foreach($rsc as $rowc){
                        if($cta==$rowc["cue_id"])
                            $this->listaCuentas.="<option value='".$rowc["cue_id"]."' selected>".$rowc["cue_descripcion"]."</option>";
                            else
                                $this->listaCuentas.="<option value='".$rowc["cue_id"]."' >".$rowc["cue_descripcion"]."</option>";
                                
                    }  // while cuenta
                    
                }
            } else {
               
                // edicion
                
             
                //$html->definirBloque('Panelbusqueda2', 'wpanel');
                
                // busca datos del establecimiento elegido nsol
                $idserv=3;
                $rowe=DatosSolicitud::getSolicitud($nsol,$idserv,"cer_solicitud");
          
               
                    $this->unegocio['CLAVEUNINEG']=$nsol;
                    $this->unegocio['reporte']= $nsol;
                    $this->unegocio['servicio']= $idserv;
                    $this->unegocio['NPUN']= $npun;
                    $this->unegocio['NOMUNEG']= $rowe["sol_descripcion"];
                    $this->unegocio['IDC']= $rowe["sol_idcuenta"];
                    $this->unegocio['NPUN']= $rowe["sol_numpunto"];
                    $npto=$rowe["sol_numpunto"];
                    $idc=$rowe["sol_idcuenta"];
                    $date=Utilerias::cambiaf_a_normal($rowe["sol_fechaapertura"]);
                    $this->unegocio['FECESTATUS']=$date;
                    //		 $this->unegocio['FECESTATUS']= $rowe["sol_fechaapertura"]);
                    $this->unegocio['ICON']= $rowe["sol_contacto"];
                    $this->unegocio['TELUNEG']= $rowe["sol_dir_telefono"];
                    $this->unegocio['TELCEL']= $rowe["sol_dir_telmovil"];
                    $this->unegocio['MAIL']= $rowe["sol_correoelec"];
                    $this->unegocio['CALLEUNEG']= $rowe["sol_dir_calle"];
                    $this->unegocio['NUMEXUNEG']= $rowe["sol_dir_numeroext"];
                    $this->unegocio['NUMINUNEG']= $rowe["sol_dir_numeroint"];
                    $this->unegocio['MZUNEG']= $rowe["sol_dir_manzana"];
                    $this->unegocio['LTUNEG']= $rowe["sol_dir_lote"];
                    $this->unegocio['COLUNEG']= $rowe["sol_dir_colonia"];
                    $this->unegocio['DELEGUNEG']= $rowe["sol_dir_delegacion"];
                    $this->unegocio['MUNUNEG']= $rowe["sol_dir_municipio"];
                    $this->unegocio['CPUNEG']= $rowe["sol_dir_cp"];
                    $this->unegocio['REFUNEG']= $rowe["sol_dir_referencia"];
                    $idedo=$rowe["sol_dir_estado"];
                    $estsol=$rowe["sol_estatussolicitud"];
                    $cta=$rowe["sol_cuenta"];
                    
                    // Llena lista de estados
                    $rs=DatosEstado::listaEstadosModel("ca_uneestados");
                    $this->listaEstados="";
                    foreach($rs as $row_es) {
                        if($idedo==$row_es["est_id"])
                            $this->listaEstados.="<option value='".$row_es["est_id"]."' selected>".$row_es["est_nombre"]."</option>";
                        else
                            $this->listaEstados.="<option value='".$row_es["est_id"]."' >".$row_es["est_nombre"]."</option>";
                               
                    }  // while edo
                   
                    // LLENAS LISTA DE CUENTAS
                    $rsc=DatosCuenta::vistaCuentasxcliente($cliente,"ca_cuentas");
                  
                    $this->listaCuentas="";
                    foreach($rsc as $rowc){
                       
                        if($cta==$rowc["cue_id"])
                            $this->listaCuentas.="<option value='".$rowc["cue_id"]."' selected>".$rowc["cue_descripcion"]."</option>";
                            else
                                $this->listaCuentas.="<option value='".$rowc["cue_id"]."' >".$rowc["cue_descripcion"]."</option>";
                                
                    }  // while cuenta
                    
             
              
                //   $_SESSION["GrupoUs"]="adm";
                if($_SESSION["GrupoUs"]=="adm"||$_SESSION["GrupoUs"]=="cli"||$_SESSION["GrupoUs"]=="muf"){
                  //  $this->msg=$msg;
                    // actualiza archivos existentes
                    $this->subtitulo='
<div class="row">
<div class="col-md-12">
<form  name="bform" action="index.php?action=editasolicitud&admin=ingarc" method="post" enctype="multipart/form-data"> 

	 <div class="form-group">
    <input type="hidden" name="servicio" size="20" maxlength="100" value="'.$idserv.'">
 	 <input type="hidden" name="reporte" size="20" maxlength="100" value="'.$nsol.'">
    <input type="hidden" name="MAX_FILE_SIZE" value="600000">
  
                        
   
   <input class="form-control-file"  type="file" name="pictures1[]" id="pictures1" />
</div> <div class="form-group">
   <button type="submit" name="submit"  class="btn btn-info pull-right"> Guardar   </button>
        
</div> 
  </form> </div></div>       
      <div class="row">     
          <div class="col-md-12 table-responsive">         
       <table class="table">    
<tr>             
<th>No.</th><th>NOMBRE</th></tr>';
                     $rsar=DatosSolicitud::listaSolicitudDetalle($nsol,$idserv,"cer_solicituddetalle");
                  
                    //$band=1;
                    foreach($rsar as $rowa){
                        $detalle=array();
                        $detalle['id_arc_exist']='<tr><td >'.$rowa["sde_idarchivo"].'</td>';
                        $detalle['arc_exist']="<td >".
                            "<a href='imprimirReporte.php?admin=descarc&nserv=".$idserv."&nsol=".$nsol."&narc=".
                            $rowa["sde_idarchivo"] ."'>".$rowa["sde_ruta"]."</a></td></tr>";
                        $this->listaSolDet[]=$detalle;
                       // $html->expandir ( 'ARCHIVOS_EX', '+PanelbusquedaA' );
                    }
                    $this->listaSolDet[]=array('id_arc_exist'=>"</table></div></div>");
               
                    // comentarios
                    
                    // encabezado de titulo
                    $this->enc_comen='
<div class="row">
<div class="col-md-12">
       <div class="form-goup" >
          <textarea class="form-control" name="coment" cols="120"></textarea>
          <input type="hidden" name="nrepc" id="nrepc" value= "'.$nsol.'" />
		  <input type="hidden" name="nserc" id="nserc" value= "'.$idserv.'"/>
      
		 
		<p class="margin">
         <button name="" type="submit" class="btn btn-info pull-right">Guardar   </button>

      </p>
  </div></div></div>
<div class="row">
   <div class="col-md-12 table-responsive">           <table class="table table-sm">
                        
  <tr>
       <th >FECHA</th>
         <th>HORA</th>
        <th >USUARIO</th>
        <th>COMENTARIOS</th>
      </tr>';
                    
                    
                   $rsco=DatosSolicitud::listaSolicitudComentario($nsol,$idserv,"cer_solicitudcomentario");
                 
                    //$msg=$sqlcom;
                    //$html->asignar('msg',$msg);
                    //$rsar=mysql_query($sqlar);
                    foreach($rsco as $rowb){
                        $comentario=array();
                        $comentario['fec']='<tr>
      <td >'.$rowb["sol_fechacom"].'</td>';
                        $comentario['hor']='<td>'.$rowb["sol_horcom"].'</td>';
                        $comentario['user']='<td >'.$rowb["sol_user"].'</td>';
                        $comentario['comen']='<td>'.$rowb["sol_comentario"].'</tr>';
                       $this->listaComentarios[]=$comentario;
                    }
                    $this->listaComentarios[]=array("fec"=>"</table></div></div>");
//                     $html->asignar ( 'fec', '');
//                     $html->asignar ( 'hor', '');
//                     $html->asignar ( 'comen', '');
//                     $html->asignar ( 'user', '');
                    
                } //if grupo
                
                // autorizacion
                if($_SESSION["GrupoUs"]=="adm"){
//                     $this->enc_autor='
//    <table class="table">';
                    // AUTORIZACIONES
                    $rsau=DatosInspector::listainspectores("ca_inspectores");
                    $this->listaInspectores="";
                    foreach($rsau as $rowa){
                        $this->listaInspectores.= $this->listaInspectores."<option value=".$rowa['cus_usuario'].">".$rowa['ins_nombre']."</option>";
                    }
                    // puntos de venta
                    $sqlpv="SELECT ca_unegocios.une_id, ca_unegocios.une_descripcion FROM ca_unegocios WHERE
ca_unegocios.cue_clavecuenta =  '$idc' GROUP BY ca_unegocios.une_id";
                    $rspv=DatosUnegocio::unegociosxNivel("","",null,array("cta"=>$idc),"","");
                    $this->listaUnegocios="";
                    $this->listaUnegocios="<option value=0> NUEVO PUNTO DE VENTA </option>";
                    foreach($rspv as $rowpv ){
                        $this->listaUnegocios= $this->listaUnegocios."<option value=".$rowpv['une_id'].">".$rowpv['une_descripcion']."</option>";
                    }
                    
                    //busca estatus
                    switch ($estsol) {
                        case 1:
                            $nomest ="SOLICITADO";
                            break;
                        case 2:
                            $nomest ="EN PROCESO";
                            break;
                        case 4:
                            $nomest ="NO ACEPTADO";
                            break;
                        case 5:
                            $nomest ="CANCELADO";
                            break;
                    }
                    $autoriza='';
                 
                    if ($estsol==1 || $estsol==4) {
                        // LISTA DE INSPECTORES
                        $rsca=DatosInspector::listainspectores("ca_inspectores");
                        $this->listaInspectores="";
                        if ($rsca) {
                            foreach($rsca as $rowca){
                                $this->listaInspectores= $this->listaInspectores."<option value='".$rowca['ins_usuario']."'>".$rowca['ins_nombre']."</option>";
                            }
                        }
                        $autoriza=$autoriza.'<div class="form-group"><label>AUDITOR :</label>
        <select class="form-control" name="INSPECTOR" id="INSPECTOR">'.$this->listaInspectores.'
         </select>
            
		 </div>
      
            
        <div class="form-group">
		<input type="hidden" name="servicio" size="20" maxlength="100" value='.$idserv.'>
 	    <input type="hidden" name="reporte" size="20" maxlength="100" value='.$nsol.'>
		<input type="hidden" name="cuenta" size="20" maxlength="100" value='.$cta.'>
		<input type="hidden" name="npunto" size="20" maxlength="100" value='.$npto.'>
		<label><h2>'.$nomest.'</h2></label></div>
		   
       <div class"col-sm-4">

		<button name="PUNVTA" type="submit" class="btn btn-info ">   Aceptar  </button>
      
          <button type="button" name="PUNVTA" id="PUNVTA"  onClick="oCargar(\'index.php?action=editasolicitud&admin=noautsol\');" class="btn btn-info">No aceptar</button>
		
		<button type="button" name="PUNVTA" id="PUNVTA"  onClick="oCargar(\'index.php?action=editasolicitud&admin=cancel\');" class="btn btn-info">Cancelar</button>
    </div>
    ';
                    }
                    $this->autor_ex=$autoriza;
                    
                } // if administrador
            } // if edit
            
         
//             $html->asignar('arc_exist','');
//             $html->asignar('id_arc_exist','');
            
            
            
          
        }
        
        public function insertarsolicitud(){
            define('RAIZ',"../solicitudes");
            $user = $_SESSION["Usuario"];
           include 'Utilerias/leevar.php';
          
            $refer=3;
            $status=1;
            
            //formato a la fecha de visita para bd
           // $fecape= Utilerias::mysql_fecha($fecaper);
            $idserv=3;
            // IDENTIFICA SI ES INSERT O UPDATE
           
            $rs=DatosSolicitud::getSolicitud($clauneg,$idserv,"cer_solicitud");
          
           
            try{
                if ($rs&&sizeof($rs)>0){
                // edita
                $sSQL=("update cer_solicitud set sol_claveservicio='$refer', sol_descripcion='$desuneg', sol_estatussolicitud='$status', sol_idcuenta='$idcta', sol_cuenta=$cta, sol_fechaapertura='".$fecape."', sol_contacto='".$conuneg."', sol_correoelec= '".$email."', sol_dir_calle='".$calle."', sol_dir_numeroext='".$numext."', sol_dir_numeroint='".$numint."', sol_dir_manzana='".$mz."', sol_dir_lote='".$lt."', sol_dir_colonia='".$col."', sol_dir_delegacion='".$del."', sol_dir_municipio='".$mun."', sol_dir_estado='".$edo."', sol_dir_cp='".$cp."', sol_dir_referencia='".$ref."', sol_dir_telefono='".$tel."', sol_dir_telmovil='".$cel."',sol_solicitante='".$user."', sol_numpunto =".$numpun." where sol_idsolicitud=".$clauneg.";");
                
                DatosSolicitud::actualizarSolicitud($refer,  $desuneg, 	 $status, 	$idcta, 	 $cta, 	 $fecape,	 $conuneg, 	 $email,  $calle, 	 $numext, 	 $numint,
                    $mz,  $lt,  $col, 	 $del, 	$mun,  $edo, $cp, 	 $ref,	 $tel,  $cel, 	 $user, 	$numpun, 	 $clauneg);
                
              
            } else{  // nuevo
                //procedimiento de insercion de  la cuenta
                if ($numpun) {
                } else {
                    $numpun=0;
                }
                $sSQL= "insert into cer_solicitud (sol_idsolicitud, sol_claveservicio, sol_descripcion, sol_estatussolicitud, sol_idcuenta,  sol_cuenta, sol_fechaapertura, sol_contacto, sol_correoelec, sol_dir_calle, sol_dir_numeroext, sol_dir_numeroint, sol_dir_manzana, sol_dir_lote, sol_dir_colonia, sol_dir_delegacion, sol_dir_municipio, sol_dir_estado, sol_dir_cp, sol_dir_referencia, sol_dir_telefono, sol_dir_telmovil, sol_solicitante, sol_numpunto)
    values (".$clauneg.", ".$refer.", '".$desuneg."', ".$status.", '".$idcta."', ".$cta.", '".$fecape."', '".$conuneg."', '".$email."','".$calle."', '".$numext."', '".$numint."', '".$mz."', '".$lt."', '".$col."', '".$del."', '".$mun."', '".$edo."', '".$cp."', '".$ref."', '".$tel."', '".$cel."','".$user."',".$numpun.")";
                //$msg=$sSQL;
                DatosSolicitud::insertarSolicitud($refer,  $desuneg, 	 $status, 	$idcta, 	 $cta, 	 $fecape,	 $conuneg, 	 $email,  $calle, 	 $numext, 	 $numint,
                    $mz,  $lt,  $col, 	 $del, 	$mun,  $edo, $cp, 	 $ref,	 $tel,  $cel, 	 $user, 	$numpun, 	 $clauneg);
                
               
            }
            }catch(Exception $ex){
                echo' <div class="alert alert-success" role="alert">'.
                $ex->getMessage()."</div>";   
            }
           
            $this->msg='<div class="alert alert-success" role="alert">
            La solicitud se guardó correctamente
            </div>';
         //   header("Location: MENindprincipal.php?admin=edisol&nsol=$clauneg&msg=$msg");
        }
        
          
            function verificaCarpeta($servicio,$reporte)
            {
                
                
                $ruta=$servicio."/".$reporte;
                
                if(!is_dir(RAIZ."/".$servicio))
                {
                    try{
                        mkdir(RAIZ."/".$ruta,0777,true);
                    }
                    catch(Exception $ex){
                        throw  $ex;
                        
                    }
                }
                
                if(!is_dir(RAIZ."/".$servicio."/".$reporte))
                {
                    // creo la carpeta
                    try{
                        mkdir(RAIZ."/".$ruta,0777,true);
                    }
                    catch(Exception $ex){
                        throw  $ex;
                        
                    }
                }
                
                return $ruta; //si existe
          }
          
          public function insertarComentario(){
              
              include 'Utilerias/leevar.php';
              
              
              $user = $_SESSION["Usuario"];
              
              // genera clave de servicio, la consulta debe estar agrupada y debera presentar el numero maximo para obtenerlo
               
              $numr=DatosSolicitud::getUltimoSolicitudComentario($nrepc,$nserc,"cer_solicitudcomentario");
             
              
              $numr++;
              
              
              //$sSQL= "insert into cue_generales (gen_claveservicio, gen_numdato, gen_lugarsyd, gen_numdatoref, gen_tipodato) values (".$ids.", ".$numr.", ".$lugarsyd." ,".$idcampo.",'V')";
              
              /*$sSQL= "insert into cer_solicitudcomentario (cer_solicitudcomentario.sol_claveservicio, cer_solicitudcomentario.sol_idsolicitud, cer_solicitudcomentario.sol_idcom, cer_solicitudcomentario.sol_fechacom, cer_solicitudcomentario.sol_horcom, cer_solicitudcomentario.sol_comentario) values (".$nserc.", ".$nrepc.", ".$numr." ,'".date()."','".localtime().",'".$coment."')";
               echo $sSQL; */
              
              try{
              DatosSolicitud::insertarSolicitudComentario($nserc, $nrepc, $numr , $coment,$user,"cer_solicitudcomentario");
              
              }catch(Exception $ex){
                  $this->msg=$ex->getMessage();
              }

              
          }
          
          public function insertarDetalle(){
              
              define('RAIZ',"../solicitudes");
              $user = $_SESSION["Usuario"];
             
              
              //echo $ncuenta;
              include ('Utilerias/leevar.php');
              $refer=3;
              $status=1;
               // valida si hay archivo para ingresar
          
               if ($_FILES ["pictures1"]){
                  $carpeta=$this->verificaCarpeta($servicio,$reporte);
                 
                  if($carpeta!=-1)
                  {
                      $ban=0;
                      foreach ( $_FILES ["pictures1"] ["error"] as $key => $error ) {
                          $name = $_FILES ["pictures1"] ["name"] [$key];
                          
                          if ($error == UPLOAD_ERR_OK) {
                              $tmp_name = $_FILES ["pictures1"] ["tmp_name"] [$key];
                              $uploadfile =RAIZ."/".$carpeta . '/'.basename ( $name );
                              if(!is_file($uploadfile))
                              {
                                  if (@move_uploaded_file ( $tmp_name, $uploadfile )) {
                                      try{
                                      $this->InsertaImagenDetalle($servicio, $reporte, $carpeta . '/'.basename ( $name ),$des,$pres);
                                      
                                      
                                      $this->msg="<div  class='alert alert-success' role='alert'><br>El archivo '" . $name . "' fue cargado exitosamente.</div>";
                                      }catch(Exception $ex){
                                          $this->msg="<div  class='alert alert-danger' role='alert'><br>".$ex->getMessage()."</div>";
                                          
                                      }
                                      //	$html->asignar('msg',$msg);
                                  } else {
                                      $this->msg="<div  class='alert alert-danger' role='alert'><br>Error al cargar el archivo, intenta de nuevo</div>";
                                      //	   $html->asignar('msg',$msg);
                                      $ban=1;
                                  }
                              }
                              else
                              {
                                  $this->msg="<div class='alert alert-danger' role='alert'><br>El archivo '" . $name . "' ya existe</div>";
                                  //  $html->asignar('msg',$msg);
                                  $ban=1;
                              }
                          }
                          else if ($error == UPLOAD_ERR_FORM_SIZE) {
                              $this->msg='<div class="alert alert-danger" role="alert"><br>El archivo "' . $name . '" excede el tamaño maximo</div>';
                              //$html->asignar('msg',$msg);
                              $ban=1;
                          }else
                              if ($error == UPLOAD_ERR_CANT_WRITE) {
                                  $this->msg='<div class="alert alert-danger" role="alert"><br>No se encontró el directorio especificado</div>';
                                  //$html->asignar('msg',$msg);
                                  
                                  $ban=1;
                              }
                          $contdes++;
                      } //termina foreach
                  }
              }
              // guarda inspector, lee punto de venta y  cambia el estatus, manda mensaje de "aceptado"
//               $sSQLa=("update cer_solicitud set cer_solicitud.sol_estatussolicitud = 1 WHERE cer_solicitud.sol_claveservicio =  '".$servicio."' AND cer_solicitud.sol_idsolicitud =  '".$reporte."';");
              
//               mysql_query($sSQLa);
              
              
            //  header("Location: MENindprincipal.php?admin=edisol&nsol=$reporte&msg=$msg");
          }
              function insertaImagenDetalle($servicio, $reporte, $ruta) {
                  //procedimiento de insercion de  la cuenta
                  //primero busco el siguiente id
                  
                  
                  $sigId=DatosSolicitud::getUltimoSolicitudDetalle($reporte,$servicio,"cer_solicituddetalle");
                  $sigId++;
                 
                      
                      $sqlcu = "INSERT INTO `cer_solicituddetalle`
(sde_claveservicio, sde_idsolicitud, sde_idarchivo, sde_ruta) VALUES ('".$servicio."','".$reporte."','".$sigId."','".$ruta."');";
                      DatosSolicitud::insertarSolicitudDetalle($servicio,$reporte,$sigId,$ruta,"cer_solicituddetalle");
                 
              }
              
             
          public function validarIDC(){
              
           include 'Utilerias/leevar.php';             
              
              $rs1=DatosUnegocio::unegocioxIdCuentaCuenta($idcta,$cta,"ca_unegocios");
              $num_reg = sizeof($rs1);
              
              if ($num_reg !=0){  // ya existe
                  //   $rst=mysql_4rowtquery($sqlt);
                  foreach($rs1 as $rowt) {
                      $npunto=$rowt["une_numpunto"];
                      // valida si existe una soicitud con el mismo idcta
                       $rs2=DatosSolicitud::getsolicitudxEstatus1($npunto,"cer_solicitud");
                      $num_reg2 = sizeof($rs2);
                      if ($num_reg2 !=0){  // ya existe
                          //mensaje de que y526
                      
                          print("<script language='javascript'>alert('Ya existe una solicitud abierta para este punto de venta. Por favor, revise'); </script>");
                          print("<script>window.location.replace('index.php?action=editasolicitud&admin=nvasol');</script>");
                      }else{ // no existe, envia info para captura
                          print("<script>window.location.replace('index.php?action=editasolicitud&admin=nvasol&npun=$npunto&idcta=$idcta&cta=$cta');</script>");
                          
                        //  header("Location: index.php?action=editasolicitud&admin=nvasol&npun=$npunto&idcta=$idcta&cta=$cta");
                      }  // if ya existe
                  }  //while
              }else{
                  
                  print("<script>window.location.replace('index.php?action=editasolicitud&admin=nvasol&npun=$npunto&idcta=$idcta&cta=$cta');</script>");
                  
                //  header("Location: index.php?action=editasolicitud&admin=nvasol&npun=$npunto&idcta=$idcta&cta=$cta");
              }	// if
              
          }
          
          public function autorizarSolicitud($opcion){
             include "Utilerias/leevar.php";
              
              $idclien=1;
              $idserv=3;
              
              $cuen=$idclien.$idserv.$cuenta;
              
              if($opcion=="no"){
                  
                  $estatus=4;
                  $fecha="null";
                  $npunto=null;
              }
              if($opcion=="si"){
                  $estatus=2;
                  $fecha="curdate()";
                  
              }
              if($opcion=="cancelar"){
                  $estatus=5;
                  $fecha="null";
                  $npunto=null;
              }
              if($opcion=="si"){
            if($npunto){
                  $msg=$npunto;
              }else{
                  // genera punto de venta
                  // asigna nuevo numero de punto de venta
                 
                  // inserta punto de venta
                   try{
                       
                      DatosUnegocio::insertarUnegociodesdeSolicitud($servicio,$reporte);
                  }catch(Exception $ex){
                      $this->msg="Error al insertar, intente de nuevo";
                  }
                  // actualiza punto de venta;
                  
              }
              }
             
              // guarda inspector, lee punto de venta y  cambia el estatus, manda mensaje de "aceptado"
              $sSQLabis=("update cer_solicitud set cer_solicitud.sol_claveinspector=:INSPECTOR, 
cer_solicitud.sol_estatussolicitud = :estatus, cer_solicitud.sol_fechainicio=".$fecha.",cer_solicitud.sol_numpunto=:npunto".
 " WHERE cer_solicitud.sol_claveservicio =:servicio AND cer_solicitud.sol_idsolicitud =:reporte");
              //$msg=$sSQLa;
              try{
             Conexion::ejecutarInsert($sSQLabis,array("estatus"=>$estatus,"INSPECTOR"=>$INSPECTOR,"servicio"=>$servicio,"npunto"=>$npunto,"reporte"=>$reporte));
             
              }catch(Exception $ex){
                  $this->msg=$ex->getMessage();
              }
              //}
              //$msg="<div align='center'><br><h2>La solicitud No.".$reporte. "  ha sido aceptada</h2>";
              //header("Location: MENindprincipal.php?admin=edisol&nsol=$clauneg&msg=$msg");
             // header("Location: MENindprincipal.php?admin=edisol&nsol=$reporte&msg=$msg");
          }
          
          public function descargarArchivo(){
              define('RAIZ',"../solicitudes");
              /*foreach($_GET as $nombre_campo => $valor){
               $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
               eval($asignacion);
               }*/
              
             include "Utilerias/leevar.php";
             
              // obtengo el archivo a descargar
         
              $rsar=DatosSolicitud::getSolicitudDetalle($nserv,$nsol,$narc,"cer_solicituddetalle");
          
              foreach($rsar as $rowa){
                  $file_name=$rowa["sde_ruta"];
              }
              $file_name =RAIZ."/".$file_name;
              
              If (file_exists($file_name)) {
                  header('Content-Description: File Transfer');
                  header('Content-Type: application/octet-stream');
                  header('Content-Disposition: attachment; filename='.basename($file_name));
                  header('Expires: 0');
                  header('Cache-Control: must-revalidate');
                  header('Pragma: public');
                  header('Content-Length: ' . filesize($file_name));
                  readfile($file_name);
                  exit;
              }
              
              
              //header("Location: MENindprincipal.php?admin=edisol&nsol=$nsol&msg=$msg");
              
          }
        /**
         * @return mixed
         */
        public function getListaSolicitudes()
        {
            return $this->listaSolicitudes;
        }
    
        /**
         * @return Ambigous <unknown, string>
         */
        public function getTitulo()
        {
            return $this->titulo;
        }
    
        /**
         * @return Ambigous <unknown, string>
         */
        public function getSubtitulo()
        {
            return $this->subtitulo;
        }
    
        /**
         * @return string
         */
        public function getListaEstados()
        {
            return $this->listaEstados;
        }
    
        /**
         * @return string
         */
        public function getListaCuentas()
        {
            return $this->listaCuentas;
        }
    
        /**
         * @return mixed
         */
        public function getMsg()
        {
            return $this->msg;
        }
    
        /**
         * @return mixed
         */
        public function getUnegocio()
        {
            return $this->unegocio;
        }
    
        /**
         * @return mixed
         */
        public function getId_arc_exist()
        {
            return $this->id_arc_exist;
        }
    
        /**
         * @return mixed
         */
        public function getListaSolDet()
        {
            return $this->listaSolDet;
        }
    
        /**
         * @return mixed
         */
        public function getListaComentarios()
        {
            return $this->listaComentarios;
        }
    
        /**
         * @return string
         */
        public function getEnc_autor()
        {
            return $this->enc_autor;
        }
    
        /**
         * @return string
         */
        public function getListaUnegocios()
        {
            return $this->listaUnegocios;
        }
    
        /**
         * @return string
         */
        public function getAutor_ex()
        {
            return $this->autor_ex;
        }
        /**
         * @return string
         */
        public function getEnc_comen()
        {
            return $this->enc_comen;
        }
    
    
        
        
      
    
    
}