<?php
@session_start();
class HistorialReportesController {
    private $vclienteu;
    private $vserviciou;
    private $col1;
    private $col2;
    private $listaReportes;
    private $titulo1;
    private $mes_asig;
    private $NumeroReportes;
    private $unidadneg;
    //Resumen de resultados 


    public function vistaHistorialReportes(){
       
        foreach ($_POST as $nombre_campo => $valor) {
             $asignacion = "\$" . $nombre_campo . "='" .filter_input(INPUT_POST,$nombre_campo, FILTER_SANITIZE_STRING). "';";
  
            eval($asignacion);
        }
        if($_GET) 
        { 
            $keys_get = array_keys($_GET); 
            foreach ($keys_get as $key_get) 
             { 
                $$key_get =filter_input(INPUT_GET,$key_get, FILTER_SANITIZE_STRING); 
                //error_log("variable $key_get viene desde $ _GET"); 
             } 
        } 


        $usuario_act = $_SESSION["UsuarioInd"];

        // genera info grafica

        //separamos los componentes de la seccion para hacer las consultas
        $arreglo = explode('.', $seccion);
        $seccion = $arreglo [0] . '.' . $arreglo [1] . '.' . $arreglo [2] . '.' . $arreglo [5];
        $_SESSION["prin"]="";

        $this->vclienteu=100;
        $this->vserviciou=$_SESSION["servicioind"];

        $this->col1=T_("REPORTE NO.");

        $this->titulo1=T_("HISTORIAL DE REPORTES");
        $this->mes_asig=T_("MES");


        $sql_c = "SELECT
        ins_generales.i_numreporte as NumReporte,
        ca_unegocios.une_descripcion as PuntoVenta,
        ins_generales.i_mesasignacion as MesAsignacion,
        ca_unegocios.une_idpepsi,
        ca_unegocios.une_idcuenta,
       
        ca_unegocios.une_dir_municipio,ca_unegocios.une_id FROM
        tmp_estadistica
        Inner Join ins_generales ON tmp_estadistica.numreporte = ins_generales.i_numreporte
        Inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
        where tmp_estadistica.usuario=:usuario and ins_generales.i_claveservicio=:vserviciou and (ins_generales.i_finalizado =  '1' or ins_generales.i_finalizado =  '-1')";
        $parametros=array("usuario"=>$usuario_act,"vserviciou"=>$this->vserviciou);
        
        if(isset($fil_ptoventa))
                {
                        $sql_c.=" and une_descripcion like '%:cad%' ";
                        $parametros["cad"]=$fil_ptoventa;
                }

           //     $SQLGEN= 'insert into instructions (textosql) values ("'.$sql_c.'");';
                try{
//        Conexion::ejecutarQuerysp($SQLGEN);

                $rs_sql_c = Conexion::ejecutarQuery ( $sql_c,$parametros );
                $numreportes = sizeof( $rs_sql_c );
                $cont = 0;
                $this->listaReportes=array();
                foreach($rs_sql_c as $row_rs_sql_c ) {
                      
                        $mes= Utilerias::cambiaMesGIng($row_rs_sql_c ["MesAsignacion"]);
                        $direccion="index.php?action=indresultadosxrep&numrep=" . $row_rs_sql_c ["NumReporte"]."&cser=".$this->vserviciou."&ccli=".$this->vclienteu;
                        $reporte['IdInspeccion']= "<td ><a href='".$direccion."'>" . $row_rs_sql_c ["NumReporte"] . "</a></td>" ;
                      //  $html->asignar ( 'NomPuntoVenta', "<td width='300' class='$color'><a href='".$direccion."'>" . $row_rs_sql_c ["PuntoVenta"] . "</a></td>" );
                        $reporte['MesAsignacion']= "<td ><a href='".$direccion."'>" . $mes . "</a></td>" ;
//                        $html->asignar ( 'Pepsi', "<td width='90' class='$color'><a href='".$direccion."'>" . $row_rs_sql_c ["une_idpepsi"] . "</a></td>" );
//                        $html->asignar ( 'ICuenta', "<td width='90' class='$color' ><a href='".$direccion."'>" . $row_rs_sql_c ["une_idcuenta"] . "</a></td>" );
//                        $html->asignar ( 'CiudadN', "<td width='100' class='$color' ><a href='".$direccion."'>" . $row_rs_sql_c ["une_dir_municipio"] . "</a></td>" );
//                        $html->expandir ( 'PRINCIPAL', '+Panelbusqueda' );
                        $this->listaReportes[]=$reporte;
                      
                        $cont ++;
                        $ptv = $row_rs_sql_c ["une_id"];
                        // echo "ss".$ptv;
                        $this->unidadneg=$row_rs_sql_c ["PuntoVenta"] ;
                        $mes_asig=$row_rs_sql_c ["MesAsignacion"];
                }
                if ($numreportes == 0) {
                        $this->NumeroReportes="<label style='color:#F00'>Su búsqueda no produjo ningún resultado !!!</label>" ;
                } else {
                        $this->NumeroReportes= strtoupper(T_("Total de Reportes")).": " . $numreportes ;
                }

                }catch(PDOException $ex){
                    throw new Exception("Error al consultar la bd ".$ex);
                }

       // $html->asignar('lb_Total_reportes',strtoupper(T_("Total de Reportes")));



        $num_reg = $_SESSION["fnumrep"];

      //no se para que//
      //  $html->asignar('total_res', $num_reg);

        Navegacion::borrarRutaActual("b");
         $rutaact = $_SERVER['REQUEST_URI'];
                // echo $rutaact;
         Navegacion::agregarRuta("b", $rutaact, $this->unidadneg);
        
    }
    
    function getCol1() {
        return $this->col1;
    }

    function getCol2() {
        return $this->col2;
    }

    function getListaReportes() {
        return $this->listaReportes;
    }

    function getTitulo1() {
        return $this->titulo1;
    }

    function getMes_asig() {
        return $this->mes_asig;
    }

    function getNumeroReportes() {
        return $this->NumeroReportes;
    }

    function getUnidadneg() {
        return $this->unidadneg;
    }



}
