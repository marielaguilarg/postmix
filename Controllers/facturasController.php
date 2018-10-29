<?php


class FacturasController
{
    private $listaFacturas;
    private $cclien ;
    private $cserv;
    private $mesini;
    private $mesfin;
    private $mfin;
    private $mensaje;
    public function actualizarFactura(){
        include "Utilerias/leevar.php";
        echo $cserv;
        if ($mesfin=1 || $mesfin=3 || $mesfin=5 || $mesfin=7 || $mesfin=8 || $mesfin=10 || $mesfin=12) {
            $diafin=31;
        } else if ($mesfin=4 || $mesfin=6 || $mesfin=9 || $mesfin=12) {
            $diafin=30;
        } else if ($mesfin=2) {
            $diafin=28;
        }
        
        $sql="SELECT  i_numreporte  
FROM `ins_generales` WHERE (str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')) >= 
str_to_date(concat('01.','$mini'),'%d.%m.%Y')
 AND (str_to_date(concat('$mesfin.',ins_generales.i_mesasignacion),'%d.%m.%Y')) <= 
str_to_date(concat('$mesfin.','$mfin'),'%d.%m.%Y') and i_idcliente=".$cclien." and i_claveservicio=$cserv 
ORDER BY i_numreporte";
        //echo $sql;
        $rs=DatosGenerales::getReportexPeriodo($cserv,$mini,$mesfin,$mfin,"ins_generales");
        try{
        foreach ($rs as $row){
            $nrep=$row["i_numreporte"];
            $comenom="numfac".$nrep;
            //echo $comenom;
            $comnom=${$comenom};
            //echo $comnom;
            $chknom="chk".$nrep;
            $valchk=${$chknom};
            // finalizar
            $finnom="fin".$nrep;
            $valfin=${$finnom};
            if ($valchk) {	  //si
                //  echo "se selecciono ".$valchk;
                $sqlv="UPDATE `ins_generales` SET `i_sincobro` = -1, `i_numfactura` = ''
WHERE i_claveservicio=$cserv and i_numreporte=$nrep";
                $parametros=array("idser"=>$cserv,
                    "numrep"=>$nrep,
                    "cobro"=>-1,
                    "factura"=>""
                );
                DatosGenerales::actualizarDatosFactura($parametros,"ins_generales");
            } else {   // es con cobro
                $comnom=${$comenom};
                if ($comnom) {
                    $sqln="UPDATE `ins_generales` SET `i_numfactura` = '".$comnom."', `i_sincobro` =0 WHERE i_claveservicio=$cserv and i_numreporte=".$nrep.";";
                    $parametros=array("idser"=>$cserv,
                        "numrep"=>$nrep,
                        "cobro"=>0,
                        "factura"=>$comnom
                    );
                }else{
                    $sqln="UPDATE `ins_generales` SET `i_numfactura` = null, `i_sincobro` =0 WHERE i_claveservicio=$cserv and i_numreporte=".$nrep.";";
                    $parametros=array("idser"=>$cserv,
                        "numrep"=>$nrep,
                        "cobro"=>0,
                        "factura"=>null
                    );
                    }
                DatosGenerales::actualizarDatosFactura($parametros,"ins_generales");
            }
            
            if ($valfin) {	  //si
                //  echo "se selecciono ".$valchk;
                $sqlf="UPDATE `ins_generales` SET `i_finalizado` = -1
WHERE i_claveservicio=$cserv and i_numreporte=$nrep";
                $parametros=array("idser"=>$cserv,
                    "numrep"=>$nrep,
                    "fin"=>-1,
                    "factura"=>$comnom
                );
            } else {
                //  echo "se selecciono ".$comenom;
                $sqlf="UPDATE `ins_generales` SET `i_finalizado` = 0
WHERE i_claveservicio=$cserv and i_numreporte=$nrep";
                $parametros=array("idser"=>$cserv,
                    "numrep"=>$nrep,
                    "fin"=>0,
                    "factura"=>$comnom
                );
            }
            //echo $sqlf;
            DatosGenerales::actualizarDatosFactura($parametros,"ins_generales");
        }
        $this->mensaje='<div class="alert aler-success" role="alert">Los datos se actualizaron correctamente</div>';
        
        }
        catch(Exception $ex){
            $this->mensaje='<div class="alert alert-danger">'.$ex." intente nuevamente</div>";
        }
        
        header("Location: MENprincipal.php?op=panfac&fechaasig=".$mini."&fechaasig_fin=".$mfin."&cserv=".$cserv."&cclien=".$cclien);
        
    }
    public function vistaListaFacturas(){
        include "Utilerias/leevar.php";
    switch($_GET["admin"]) {
        case "crear" :
            //  include('./MEIcreaponderado.php');
            $this->actualizarFactura();
         //   break;
      
        default:
            
            $fechaasig=$fechainicio.".".$fechainicio2;
            $fechaasig_fin=$fechafin.".".$fechafin2;
            
            $cclien=$claclien;
            //echo $cclien;
            $cserv=$idserv;
            $mesfin=$fechafin;
            
          
            
            
            $i=1;
            
            if ($mesfin=1 || $mesfin=3 || $mesfin=5 || $mesfin=7 || $mesfin=8 || $mesfin=10 || $mesfin=12) {
                $diafin=31;
            } else if ($mesfin=4 || $mesfin=6 || $mesfin=9 || $mesfin=12) {
                $diafin=30;
            } else if ($mesfin=2) {
                $diafin=28;
            }
            $this->cclien=$cclien;
           $this->cserv=$cserv;
           $this->mesini=$fechaasig;
           $this->mfin=$fechaasig_fin;
           $this->mesfin=$mesfin;    
         
            $ssql=" SELECT i_claveservicio,
  i_numreporte,
  i_unenumpunto,
  i_mesasignacion,
  i_sincobro,
  i_numfactura,
  i_finalizado,
  i_estatusfactura,
  une_descripcion 
FROM
  `ins_generales` 
  INNER JOIN ca_unegocios 
    ON i_unenumpunto = une_id 
WHERE (str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')) >= str_to_date(concat('01.',:fechaasig),'%d.%m.%Y')
AND (str_to_date(concat('31.',ins_generales.i_mesasignacion),'%d.%m.%Y')) <= str_to_date(concat('31.',:fechaasig_fin),'%d.%m.%Y')
and i_claveservicio=:cserv ORDER BY i_numreporte";
            //echo $ssql;
            $parametros=array("fechaasig"=>$fechaasig,"fechaasig_fin"=>$fechaasig_fin,"cserv"=>$cserv);
          
            // asignar cliente, servicio, periodo inicial y periodo final
       
            
            $rs=Conexion::ejecutarQuery($ssql,$parametros);
            //die();
         
            foreach ($rs as $row){
                
                
                $mesasi= $row["i_mesasignacion"];
                
                
                // ADATA MES ASIGNACION
                $datinima=SubnivelController::obtienedato($mesasi,1);
                $londatma=SubnivelController::obtienelon($mesasi,1);
                $mes_mesas=substr($mesasi,$datinima,$londatma);
                //echo $mes_mesas;
                
                $datiniye=SubnivelController::obtienedato($mesasi,2);
                $londatye=SubnivelController::obtienelon($mesasi,2);
                $year_mesas=substr($mesasi,$datiniye,$londatye);
                
                $nrep=$row["i_numreporte"];
                //echo $mes_mesas;
                //echo $year_mesas;
                
                
                switch ($mes_mesas) {
                    case 1:
                        $mesnom="ENERO";
                        break;
                    case 2:
                        $mesnom="FEBRERO";
                        break;
                    case 3:
                        $mesnom="MARZO";
                        break;
                    case 4:
                        $mesnom="ABRIL";
                        break;
                    case 5:
                        $mesnom="MAYO";
                        break;
                    case 6:
                        $mesnom="JUNIO";
                        break;
                    case 7:
                        $mesnom="JULIO";
                        break;
                    case 8:
                        $mesnom="AGOSTO";
                        break;
                    case 9:
                        $mesnom="SEPTIEMBRE";
                        break;
                    case 10:
                        $mesnom="OCTUBRE";
                        break;
                    case 11:
                        $mesnom="NOVIEMBRE";
                        break;
                    case 12:
                        $mesnom="DICIEMBRE";
                        break;
                }
                
                
                $mesas2=$mesnom."-".$year_mesas;
                $factura['num']=$i;
                $nrep=$row["i_numreporte"];
                $factura['nrep']=$nrep;
                $factura['punvta']=$row["une_descripcion"];
                //$html->asignar('fecvis',cambiaf_a_normal($row["i_fechavisita"])."</a></div></td>");
                $factura['mesas']=$mesas2;
                
                // BUSCA NUMERO DE MUESTRA Y EMBOTELLADORA
                if ($cserv==1) {
                    $nsecc=5;
                } else {
                    $nsecc=3;
                }
                // buscar embotelladora en catalogo
                $sqlm="SELECT  ide_idmuestra, cad_descripcionesp
FROM ins_detalleestandar
LEFT JOIN  `aa_recepcionmuestradetalle` ON ide_idmuestra = mue_idmuestra
INNER JOIN aa_recepcionmuestra ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra
INNER JOIN `ca_catalogosdetalle` ON rm_embotelladora = cad_idopcion
where cad_idcatalogo=43
AND ide_numrenglon =1
AND ide_numseccion =:nsecc
AND ide_claveservicio =:cserv
AND ide_numreporte =:nrep
group by ide_idmuestra";
                //echo $sqlm;
                $parametros=array("nsecc"=>$nsecc,"cserv"=>$cserv,"nrep"=>$nrep);
                $rsm=Conexion::ejecutarQuery($sqlm,$parametros);
                $totreg=sizeof($rsm);
                if ($totreg>0) {
                    foreach ($rsm as $rowe){
                        $factura['idemb']=$rowe["cad_descripcionesp"];
                        $factura['nmue']=$rowe["ide_idmuestra"];
                    }
                } else {
                    $factura['idemb']="";
                    $factura['nmue']="";
                    
                }
                
                $tipocampo="<div align='center'><input type='input' name='numfac".$row['i_numreporte']."' maxlength='10' size='10' value=".$row['i_numfactura']."></div>";
                
                $factura['numfac']=$tipocampo;
                
                if ($row['i_sincobro']) {
                    $cob="checked";
                }else{
                    $cob="";
                }
                $tipocampo2="<div align='center'><input type='checkbox' name='chk".$row['i_numreporte']."' ".$cob." maxlength='10' size='10'></div>";
                
                $factura['sincob']=$tipocampo2;
                //asigna finalizado	para seccion 1
                //echo $cserv;
                if ($cserv==3){
                    // busca finalizado para seccion 3
                    $sqles = "SELECT cer_solicitud.sol_estatussolicitud
 FROM cer_solicitud WHERE cer_solicitud.sol_numrep =  '".$row['i_numreporte']."' AND cer_solicitud.sol_claveservicio =  '3'";
                    $rses = DatosSolicitud::cuentasolicitudModel($row['i_numreporte'],3,"cer_solicitud");
                    foreach ($rses as $rowes){
                     //   $final=$rowes['sol_estatussolicitud'];
                        if ($rowes['sol_estatussolicitud']==3) {
                            $fina="checked";
                        }else{
                            $fina="";
                        }
                    }
                }else{
                    //echo $row['i_finalizado'];
                    if ($row['i_finalizado']) {
                        $fina="checked";
                    }else{
                        $fina="";
                    }
                    //echo $fina;
                }
                
                $finn="<div align='center'><input type='checkbox' name='fin".$row['i_numreporte']."' ".$fina." maxlength='10' size='10'></div>";
                
            
                $factura['final']=$finn;	  
                $i++;
                $this->listaFacturas[]=$factura;
              
            }
           
          
            // }
            
            
    } //switch
    }
    /**
     * @return mixed
     */
    public function getListaFacturas()
    {
        return $this->listaFacturas;
    }
    /**
     * @return mixed
     */
    public function getCclien()
    {
        return $this->cclien;
    }

    /**
     * @return mixed
     */
    public function getCserv()
    {
        return $this->cserv;
    }

    /**
     * @return string
     */
    public function getMesini()
    {
        return $this->mesini;
    }

    /**
     * @return string
     */
    public function getMesfin()
    {
        return $this->mesfin;
    }

    /**
     * @return Ambigous <boolean, number>
     */
    public function getMfin()
    {
        return $this->mfin;
    }
    /**
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }



    
    
}

