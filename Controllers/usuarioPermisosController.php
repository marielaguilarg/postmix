<?php
include "Models/crud_grupo.php";
include "Models/crud_usuarios.php";

class UsuarioPermisosController
{
    private $TITULO5;
    private $idnum;
    private $op2;
    private $listaUsuarios;
    private $lista_servicios;
    private $NOMBRENIVEL;
    private $nivelfr;
    private $nivel11;
    private $mensaje;
    private $usuario;
    private $op;
    private $NV;
    private $lista_clientes;
    private $IDIOMAS;
  
    private $nivel;
    private $accion;
 
    private $Posicion01;
    private $Posicion02;
    private $Posicion03;
    private $Posicion04;
    private $Posicion05;
    private $Posicion06;
    private $Posicion;
    private $TipoNivel_1;
    private $TipoNivel_2;
    private $TipoNivel_3;
    private $TipoNivel_4;
    private $TipoNivel_5;
    private $TipoNivel_6;
    private $sc;
    private $insp;
    private $lista_tecnicos;
    private $francta;
    private $Nivelpv;
    
    public function vistaListausuarios(){
        include "Utilerias/leevar.php";
       
        switch ($admin) {
            
        case "NUEVO" :
           $this->insertarUsuario();
            break;
        case "borrar" :
            $this->eliminarUsuario();
            break;
        case "EDITAR" :
            $this->actualizarUsuario();
            break;
        }
       
       
         $op2 = $id;
         if (!isset($op2))
            $op2 = $grupo;
                
                
         $this->idnum= $op2;
         $this->op2= $op2;
                
                   
         $rowt = DatosGrupo::getGrupo($op2,"cnfg_grupos");
        
         $this->TITULO5="* GRUPO  " . $rowt["cgr_nombregrupo"] . " * ";
               
                    //		 echo $ssqlt;
         $rst = UsuarioModel::getUsuariosxGpo($op2,"cnfg_usuarios");
     
        
         $cont = 0;
         foreach ($rst as$row) {
            $usuario=array();
            $usuario['claveusuario']="<a href='index.php?action=snuevousuario&nuevo=E&usu=".$row["cus_usuario"]."&id=".$op2."'>".$row["cus_usuario"]."</a>";
             
            $usuario['editausuario']= "<div align='left'>" . $row["cus_nombreusuario"] . "</div>";
            if ($op2 == 'ext' && $row["cus_tipoconsulta"] > 0)
                $tipo = "Cliente";
                if ($op2 == 'ext' && $row["cus_tipoconsulta"] < 0)
                    $tipo = "Cuenta";
                    if ($op2 == 'mue' && $row["cus_tipoconsulta"] == 1)
                        $tipo = "Administrador";
                       if ($op2 == 'mue' && $row["cus_tipoconsulta"] == 2)
                            $tipo = "Auditor";
                            if ($op2 == 'mue' && $row["cus_tipoconsulta"] == 3)
                                $tipo = "Muesmerc";
                                $usuario['tipo']=  $tipo ;
                                $usuario['borrarusurario']= $row["cus_usuario"];
           $this->listaUsuarios[]=$usuario ;                   
                     
        }
      
                
    }
    
   
    public function vistaNuevoUsuario(){
        include "Utilerias/leevar.php";
        /* * ******** VARIABLES GLOBALES ******** */
       if($nuevo=="E")
           $this->vistaEditaUsuario();
           else{
        if(isset($nvel))
            $VarNivel2 = $nvel;
            else
                if(isset($SelectNivel)) {
                    $VarNivel2=$SelectNivel;
                }
            //echo "varniuve".$VarNivel2;
            $this->accion="NUEVO";
            $claveg = $id;
            if (!isset($grupo)) {
                $grupo = $id;
            }
           
                $claveg=$grupo;
                $rowt = DatosGrupo::getGrupo($claveg,"cnfg_grupos");
                
                $this->TITULO5="* GRUPO  " . $rowt["cgr_nombregrupo"] . " * ";
                
                $this->op=$claveg;
                $aux = $nvel;
                $this->NV= $aux;
                $this->usuario['grupo']= $grupo;
                if ($nomusu) {
                    $this->usuario['nombre']= $nomusu;
                }
                if ($login) {
                    $this->usuario['log']= $login;
                }
                if ($contras) {
                    $this->usuario['pass']= $contras;
                }
                if ($empresa) {
                    $this->usuario['empres']= $empresa;
                }
                if ($cargo) {
                    $this->usuario['carg']= $cargo;
                }
                if ($tel) {
                    $this->usuario['tele']= $tel;
                }
                if ($email) {
                    $this->usuario['correo']= $email;
                }
                if ($clave) {
                    $this->usuario['clav']= $claveg;
                }
                //echo $aux2;
                //$html->asignar('op', $VarNivel2);
                /* * ********************************* */
                // crea lista de clientes
                $sql_cli="SELECT
`ca_clientes`.`cli_id`,
`ca_clientes`.`cli_nombrecliente`
FROM `ca_clientes`;";
                $sql_cli=Datos::vistaClientesModel("ca_clientes");
                if(isset($uscliente)&&($uscliente!=0&&$uscliente!=-1))    // ya esta seleccionado el cliente
                {
                    
                    $this->lista_clientes=Utilerias::llenaListBoxSel($sql_cli,$uscliente);
                    // llena servicios
                    $sql_serv="SELECT
`ca_servicios`.`ser_claveservicio`,`ca_servicios`.`ser_descripcionesp` FROM `ca_servicios`
where `ca_servicios`.`cli_idcliente`=:uscliente;";
                    $sql_serv=DatosServicio::vistaServicioxCliente($uscliente,"ca_servicios");
                    $parametros=array("uscliente"=>$uscliente);
                    if(isset($usservicio)&&($usservicio!=0&&$usservicio!=-1))    // ya esta seleccionado el cliente
                    {
                        $this->lista_servicios=Utilerias::llenaListBoxSel($sql_serv,  $usservicio);
                    }else
                        $this->lista_servicios=Utilerias::llenaListBoxSel($sql_serv,  '');
                }
                else
                    
                    $this->lista_clientes=Utilerias::llenaListBoxSel($sql_cli,'');
                 
                    if ($claveg == 'cli' || $claveg == 'cue' || $claveg == 'muf') {
                        /* actualiza idioma */
                        $this->IDIOMAS[]=" <option value=''>- Seleccione una opcion - </option>";
                     
                        if ($idioma == 1) {
                            $this->IDIOMAS[]= "<option value='1' selected='selected'>Espa&ntilde;ol</option>";
                         
                        } else {
                            $this->IDIOMAS[]= "<option value='1'>Espa&ntilde;ol</option>";
                          
                        }
                        if ($idioma == 2) {
                            $this->IDIOMAS[]= "<option value='2' selected='selected'>Ingles</option>";
                           
                        } else {
                            $this->IDIOMAS[]="<option value='2'>Ingles</option>";
                           
                        }
                    } else {
                        $this->IDIOMAS[]="<option value='1'>Espa&ntilde;ol</option>";
                     
                    }
                  //  var_dump($this->IDIOMAS);
                    
                  
                    if ($claveg == 'lab') {
                        $this->NOMBRENIVEL= "LABORATORIO: ";
                        $this->nivel11= "<select class='form-control' name='laboratorio'>
		     					       <option value=\"0\">- Seleccione una opcion -</option>";
                        // opciones del laboratorio
                        $numcat=43;
                        $rsca=DatosCatalogoDetalle::listaCatalogoDetalle($numcat,"ca_catalogosdetalle");
                        foreach ($rsca as $rowc){
                            $opcionn=$rowc["cad_idopcion"];
                            if ($opcionn == $row["mee_numnivel"]) {
                                $opcionc="<option value='".$rowc[cad_idopcion]."' selected>".$rowc[cad_descripcionesp]."</option>";
                                $this->nivel[]= $opcionc;
                            } else {
                                $opcionc="<option value='".$rowc[cad_idopcion]."'>".$rowc[cad_descripcionesp]."</option>";
                                $this->nivel[]= $opcionc;
                            }
                            
                        }
                        $this->nivel[]="</select>";
                    }
                   
                    if ($claveg == 'cue') {
                        
                        
                        /* llena listas de cuentas y puntos de venta */
                        if(isset($uscliente)&&($uscliente!=0||$uscliente!=-1)) {// busco las cuentas de ese servicio
                            
                            
                            $SQLcu = "SELECT
                `ca_cuentas`.`cue_id`,
                `ca_cuentas`.`cue_descripcion`
                FROM `ca_cuentas`
                where `ca_cuentas`.`cli_idcliente`='$uscliente' and
                `ca_cuentas`.`ser_claveservicio`='$usservicio';";
                            $SQLmcu = DatosCuenta::cuentasxCliente2("ca_cuentas",$uscliente);
                           
                            foreach ($SQLmcu as $rowcu ) {
                                if ($rowcu["cue_id"] == $cta) {
                                    $this->nivelfr[]= "<option value=" . $rowcu["cue_id"] . " selected='selected'>"
                                        . $rowcu["cue_descripcion"] . "</option>";
                                } else {
                                    $this->nivelfr[]= "<option value='" . $rowcu["cue_id"] . "'>"
                                        . $rowcu["cue_descripcion"] . "</option>";
                                }
                             
                            }
                     
                        }
                    }
                    
                    //CONSULTA DE CATALAGO ESTRUCTURAS
                  //  $SQL = "SELECT * FROM cnfg_estructura";
                    $SQLe = Estructura::listaEstructura();
                    if ($claveg == 'cli' || $claveg == 'muf') {
                        
                        $this->NOMBRENIVEL= "NIVEL DE CONSULTA: ";
                        $this->nivel11="<select  class='form-control' name='SelectNivel' onchange='cargaNivel(this,\"N\");'>
		     					       <option value=\"0\">- Seleccione una opcion -</option>";
                        foreach ( $SQLe as $row ) {
                            if ($VarNivel2 == $row["mee_numnivel"])
                                $this->nivel[]= "<option value='" . $row["mee_numnivel"] . "' selected>"
                                    . $row["mee_descripcionnivelesp"] . "</option>";
                                else
                                    $this->nivel[]= "<option value='" . $row["mee_numnivel"] . "'>"
                                        . $row["mee_descripcionnivelesp"] . "</option>";
                                   
                        }
                        $this->nivel[]= "</select>";
                       
                  
                        if ($VarNivel2 >= 1) {
                            /*             * **NUEVO MODULO PHP** */
                            
                            $SQL_TEM = "SELECT reg_clave, reg_nombre FROM ca_regiones where
ca_regiones.cli_idcliente='$uscliente'";
                            
                            $RS_SQM_TE =  Datosnuno::listaxCliente($uscliente,"ca_nivel1");
                          
                            if($RS_SQM_TE)
                                $row=$RS_SQM_TE[0];
                                $region=$row[0];
                                echo "............".$select1;
                                
                                $this->Posicion01= '<select class="form-control cascada" name="select1" id="select1"
                                data-group="niv-1"
                                    data-id="niv-1"
                                    data-target="niv-2"
                                    data-url="getNivelUnegocioUsu.php?"
                                        data-replacement="container1"
                                            data-default-label="-TODOS-" >
 <option value="0">- Seleccione Una Opcion -</option>';
                                $this->Posicion=Utilerias::llenaListBoxSel($RS_SQM_TE,$select1);
                              
                                $this->Posicion.= "</select>";
                          
                             
                                    $this->TipoNivel_1=Estructura::nombreNivel($VarNivel2,1);
                               
                        }
                        if ($VarNivel2 >= 2) {
                         
                            $SQL_P=Datosndos::vistandosModel($region,"ca_nivel2");
                            
                            $this->Posicion02= "<select class='form-control cascada' name='select2' id='select2'
 data-group='niv-1'
                                    data-id='niv-2'
                                    data-target='niv-3'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option>".  $this->creaOpcionesSel($SQL_P, "")."</select>";
                            /*             * ******************************************************************* */
                            
                            
                         
                            $this->TipoNivel_1=Estructura::nombreNivel($VarNivel2-1,1);
                         
                            $this->TipoNivel_2=Estructura::nombreNivel($VarNivel2,1);
                            
                        }
                        if ($VarNivel2 == 3) {
                                 $this->Posicion03= "<select class='form-control cascada' name='select3' id='select3'
data-group='niv-1'
                                    data-id='niv-3'
                                    data-target='niv-4'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option></select>";
                            /*             * ******************************************************************* */
                          
                            $this->TipoNivel_1= Estructura::nombreNivel($VarNivel2-2,1);
                            
                          
                            $this->TipoNivel_2= Estructura::nombreNivel($VarNivel2-1,1);
                           
                          
                            $this->TipoNivel_3= Estructura::nombreNivel($VarNivel2,1);
                           
                        }
                        if ($VarNivel2 == 4) {
                         					
                            $this->Posicion03= "<select class='form-control cascada' name='select3' id='select3'
data-group='niv-1'
                                    data-id='niv-3'
                                    data-target='niv-4'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option></select>";
                            $this->Posicion04= "<select class='form-control cascada' name='select4' id='select4'
data-group='niv-1'
                                    data-id='niv-4'
                                    data-target='niv-5'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option></select>";
                            /*             * ******************************************************************* */
                          
                                $this->TipoNivel_1= Estructura::nombreNivel($VarNivel2-3,1);
                           
                                $this->TipoNivel_2= Estructura::nombreNivel($VarNivel2-2,1);
                          
                                $this->TipoNivel_3=Estructura::nombreNivel($VarNivel2-1,1);
                           
                                $this->TipoNivel_4= Estructura::nombreNivel($VarNivel2,1);
                            }
                        }
                        
                        if ($VarNivel2 == 5) {
                           $this->Posicion03= "<select class='form-control cascada' name='select3' id='select3'
data-group='niv-1'
                                    data-id='niv-3'
                                    data-target='niv-4'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option></select>";
                            $this->Posicion04= "<select class='form-control cascada' name='select4' id='select4'
data-group='niv-1'
                                    data-id='niv-4'
                                    data-target='niv-5'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option></select>";
                            $this->Posicion05= "<select class='form-control cascada' name='select5' id='select5'
data-group='niv-1'
                                    data-id='niv-5'
                                    data-target='niv-5'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option></select>";
                            /*             * ******************************************************************* */
                              $this->TipoNivel_1= Estructura::nombreNivel($VarNivel2-4,1);
                           
                                $this->TipoNivel_2= Estructura::nombreNivel($VarNivel2-3,1);
                          
                                $this->TipoNivel_3=Estructura::nombreNivel($VarNivel2-2,1);
                           
                                $this->TipoNivel_4= Estructura::nombreNivel($VarNivel2-1,1);
                          
                                $this->TipoNivel_5=Estructura::nombreNivel($VarNivel2,1);
                            
                        }
                        if ($VarNivel2 == 6) {
                            $this->Posicion03= "<select class='form-control cascada' name='select3' id='select3'
data-group='niv-1'
                                    data-id='niv-3'
                                    data-target='niv-4'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option></select>";
                            $this->Posicion04= "<select class='form-control cascada' name='select4' id='select4'
data-group='niv-1'
                                    data-id='niv-4'
                                    data-target='niv-5'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option></select>";
                            $this->Posicion05= "<select class='form-control cascada' name='select5' id='select5'
data-group='niv-1'
                                    data-id='niv-5'
                                    data-target='niv-6'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option></select>";
                            $this->Posicion06= "<select class='form-control' name='select6' id='select6'
data-group='niv-1'
                                    data-id='niv-6'
                                 
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option></select>";
                            /*             * ******************************************************************* */
                            
                            $this->TipoNivel_1= Estructura::nombreNivel($VarNivel2-5,1);
                            
                            $this->TipoNivel_2= Estructura::nombreNivel($VarNivel2-4,1);
                            
                            $this->TipoNivel_3=Estructura::nombreNivel($VarNivel2-3,1);
                            
                            $this->TipoNivel_4= Estructura::nombreNivel($VarNivel2-2,1);
                            
                            $this->TipoNivel_5=Estructura::nombreNivel($VarNivel2-1,1);
                          
                                $this->TipoNivel_6= Estructura::nombreNivel($VarNivel2,1);
                            
                            
                            /*             * ************************************************** */
                        }
                        
                    
                    
                    if ($claveg == 'cli' || $claveg == 'muf' || $claveg == 'adm') {
                        $solcert='<div clas="form-group col-md-6"><label>PUEDE SOLICITAR CERTIFICACION :</label>
       
          <input class="form-check-input" type="checkbox" name="solicer" id="solicer" />
        
      </div>';
                        $this->sc= $solcert;
                        
                    }
                    
                    
                    // agrega el tecnico
                    if ($claveg == 'aud' || $claveg == 'adm') {
                        $solcert='
 <div class="form-group col-md-6"><label>INSPECTOR :</label>
		<select class="form-control" name="ntec" id="ntec">
		 <option value="0">- Seleccione Una Opcion -</option>';
                        // vamos a validar si es nuevo o edicion para colocar las opciones
                        $this->insp= $solcert;
                        
                        $sql_ins = "SELECT * FROM ca_inspectores";
                        $rs_ins = DatosInspector::listainspectores("ca_inspectores");
                        foreach ($rs_ins as $row_ins) {
                            //$this->lista_tecnicos', $row_ins["ins_nombre"]);
                            if ($ntec == $row["ins_clave"])
                                $this->lista_tecnicos[]= "<option value='" . $row_ins["ins_clave"] . "' selected>"
                                    . $row_ins["ins_nombre"] . "</option>";
                                else
                                    $this->lista_tecnicos[]= "<option value='" . $row_ins["ins_clave"] . "'>"
                                        . $row_ins["ins_nombre"] . "</option>";
                                   
                        }
                        $this->lista_tecnicos[]= "</select></div>";
                     
                    }  //if
                    
           }
        
    }
    public function vistaEditaUsuario(){
        include "Utilerias/leevar.php";
        /* * ******** VARIABLES GLOBALES ******** */
       $this->accion="EDITAR";
       $logino=$login;
        $login = $usu;
        echo "***".$usu;
        if (! isset ( $usu)) //viene de recarga
        {
           
            $this->usuario['log']= $logino ;
            $this->usuario['login_ant']= $login_ant ;
            $login=$logino;
            $this->usuario['pass']= $contras ;
            $this->usuario['nombre']= $nomusu ;
    
            $this->usuario['empres']= $empresa ;
            $this->usuario['carg']= $cargo ;
            $this->usuario['tele']= $tel ;
            $this->usuario['correo']= $email ;
            $this->usuario['cclav']= $grupo ;
            $gpo = $grupo;
    
            $Nivel1 = $select1;
            $Nivel2 = $select2;
            $Nivel3 = $select3;
            $Nivel4 = $select4;
            $Nivel5 = $select5;
            $Nivel6 = $select6;
            $idioma = $idioma;
    
    
    
    
        }
    
       else
            {
            $sql = "SELECT * FROM cnfg_usuarios where cus_usuario='$login'";
               
            $res_us = UsuarioModel::getUsuario( $login,"cnfg_usuarios");
          
            foreach ( $res_us as $rowu) {
                $this->usuario['log']= $login ;
                $this->usuario['login_ant']= $login ;
    
                $this->usuario['pass']= $rowu ["cus_contrasena"] ;
                $this->usuario['nombre']=$rowu ["cus_nombreusuario"] ;
    
                $this->usuario['empres']= $rowu ["cus_empresa"] ;
                $this->usuario['carg']= $rowu ["cus_cargo"] ;
                $this->usuario['tele']= $rowu ["cus_telefono"] ;
                $this->usuario['correo']= $rowu ["cus_email"] ;
                $this->usuario['clav']= $rowu ["cus_clavegrupo"] ;
                $gpo = $rowu ["cus_clavegrupo"];
                $solcer = $rowu ["cus_solcer"];
                $tipo_usu = $rowu ["cus_tipoconsulta"];
                $this->usuario['nivel']= $rowu ["cus_tipoconsulta"] ;
    
                $this->usuario['tipo_usu']= $rowu ["cus_tipoconsulta"] ;
    
                $Nivel1 = $rowu ["cus_nivel1"];
                $Nivel2 = $rowu ["cus_nivel2"];
                $Nivel3 = $rowu ["cus_nivel3"];
                $Nivel4 = $rowu ["cus_nivel4"];
                $Nivel5 = $rowu ["cus_nivel5"];
                $Nivel6 = $rowu ["cus_nivel6"];
                $idioma = $rowu ["cus_idioma"];
                if(!isset($uscliente))
                        $uscliente=$rowu["cus_cliente"];
                    if(!isset($usservicio))
                            $usservicio=$rowu["cus_servicio"];
                        //es cuenta
                        if(!isset($cta))
                                $cta=$rowu["cus_nivel1"];
                            if(!isset($franqcuenta))
                                    $franqcuenta=$rowu["cus_nivel2"];
                                if(!isset($pvta))
                                        $pvta=$rowu["cus_nivel3"];
    
    
                                    /*     * ************************************ */
            }
        }
    
      
            $claveg=$id;
            if(isset($grupo))
            {
                $claveg=$grupo;
            }
            $rowt = DatosGrupo::getGrupo($claveg,"cnfg_grupos");
            
            $this->TITULO5="* GRUPO  " . $rowt["cgr_nombregrupo"] . " * ";
            
            $this->op=$claveg;
            $aux = $nvel;
            $this->NV= $aux;
      
            //echo $aux2;
            //$html->asignar('op', $VarNivel2);
            /* * ********************************* */
            // crea lista de clientes
            $sql_cli="SELECT
`ca_clientes`.`cli_id`,
`ca_clientes`.`cli_nombrecliente`
FROM `ca_clientes`;";
            $sql_cli=Datos::vistaClientesModel("ca_clientes");
            if(isset($uscliente)&&($uscliente!=0&&$uscliente!=-1))    // ya esta seleccionado el cliente
            {
                
                $this->lista_clientes=Utilerias::llenaListBoxSel($sql_cli,$uscliente);
                // llena servicios
                $sql_serv="SELECT
`ca_servicios`.`ser_claveservicio`,`ca_servicios`.`ser_descripcionesp` FROM `ca_servicios`
where `ca_servicios`.`cli_idcliente`=:uscliente;";
                $sql_serv=DatosServicio::vistaServicioxCliente($uscliente,"ca_servicios");
            
                if(isset($usservicio)&&($usservicio!=0&&$usservicio!=-1))    // ya esta seleccionado el cliente
                {
                    $this->lista_servicios=Utilerias::llenaListBoxSel($sql_serv,  $usservicio);
                }else
                    $this->lista_servicios=Utilerias::llenaListBoxSel($sql_serv,  '');
            }
            else
                
                $this->lista_clientes=Utilerias::llenaListBoxSel($sql_cli,'');
                
                if ($claveg == 'cli' || $claveg == 'cue' || $claveg == 'muf') {
                    /* actualiza idioma */
                    $this->IDIOMAS[]=" <option value=''>- Seleccione una opcion - </option>";
                    
                    if ($idioma == 1) {
                        $this->IDIOMAS[]= "<option value='1' selected='selected'>Espa&ntilde;ol</option>";
                        
                    } else {
                        $this->IDIOMAS[]= "<option value='1'>Espa&ntilde;ol</option>";
                        
                    }
                    if ($idioma == 2) {
                        $this->IDIOMAS[]= "<option value='2' selected='selected'>Ingles</option>";
                        
                    } else {
                        $this->IDIOMAS[]="<option value='2'>Ingles</option>";
                        
                    }
                } else {
                    $this->IDIOMAS[]="<option value='1'>Espa&ntilde;ol</option>";
                    
                }
                //  var_dump($this->IDIOMAS);
                
                
                if ($claveg == 'lab') {
                    $this->NOMBRENIVEL= "LABORATORIO: ";
                    $this->nivel11= "<select class='form-control' name='laboratorio'>
		     					       <option value=\"0\">- Seleccione una opcion -</option>";
                    // opciones del laboratorio
                    $numcat=43;
                    $rsca=DatosCatalogoDetalle::listaCatalogoDetalle($numcat,"ca_catalogosdetalle");
                    foreach ($rsca as $rowc){
                        $opcionn=$rowc["cad_idopcion"];
                        if ($opcionn == $tipo_usu) {
                            $opcionc="<option value='".$rowc[cad_idopcion]."' selected>".$rowc[cad_descripcionesp]."</option>";
                            $this->nivel[]= $opcionc;
                        } else {
                            $opcionc="<option value='".$rowc[cad_idopcion]."'>".$rowc[cad_descripcionesp]."</option>";
                            $this->nivel[]= $opcionc;
                        }
                        
                    }
                    $this->nivel[]="</select>";
                }
                
                if ($claveg == 'cue') {
                    
                    
                    /* llena listas de cuentas y puntos de venta */
                    if(isset($uscliente)&&($uscliente!=0||$uscliente!=-1)) {// busco las cuentas de ese servicio
                        
                        
                        $SQLcu = "SELECT
                `ca_cuentas`.`cue_id`,
                `ca_cuentas`.`cue_descripcion`
                FROM `ca_cuentas`
                where `ca_cuentas`.`cli_idcliente`='$uscliente' and
                `ca_cuentas`.`ser_claveservicio`='$usservicio';";
                        $SQLmcu = DatosCuenta::cuentasxCliente2("ca_cuentas",$uscliente);
                   
                        foreach ($SQLmcu as $rowcu ) {
                            if ($rowcu["cue_id"] == $cta) {
                                $this->nivelfr[]= "<option value=" . $rowcu["cue_id"] . " selected='selected'>"
                                    . $rowcu["cue_descripcion"] . "</option>";
                            } else {
                                $this->nivelfr[]= "<option value='" . $rowcu["cue_id"] . "'>"
                                    . $rowcu["cue_descripcion"] . "</option>";
                            }
                            
                        }
                        
                    
                   // llena lista de franquicias
                     $ssql_fran=("SELECT
                    `ca_franquiciascuenta`.`fc_idfranquiciacta`,
                    `ca_franquiciascuenta`.`cf_descripcion`
                    FROM `ca_franquiciascuenta` where `ca_franquiciascuenta`.`cli_idcliente`='$uscliente' and
                    `ca_franquiciascuenta`.`ser_claveservicio`='$usservicio'
                    and `ca_franquiciascuenta`.`cue_clavecuenta` ='".$cta."';");
                    
                     $rs_fran=DatosFranquicia::franquiciasxCuentaCli($uscliente,$cta);
                    
                     foreach ($rs_fran as $row_fran) {
                        if($row_fran[0]==$franqcuenta)
                                $op.= "<option value='" . $row_fran[0] . "' selected='selected' >" . $row_fran[1] . "</option>";
                                else
                                        $op.= "<option value='" . $row_fran[0] . "' >" . $row_fran[1] . "</option>";
    
                            }
    
                            $this->francta=$op;
    
                            /* llena listas de  puntos de venta */
                            $SQLpv = "select `ca_unegocios`.`une_claveunegocio`,
        `ca_unegocios`.`une_descripcion` from ca_unegocios where `ca_unegocios`.`cli_idcliente`='$uscliente' and
        `ca_unegocios`.`ser_claveservicio`='$usservicio' and
        `ca_unegocios`.`cue_clavecuenta`='$cta' and fc_idfranquiciacta='$franqcuenta';";
                            $SQLpv=DatosUnegocio::unegocioxCuentaFranq($cta,$franqcuenta);
                          
                            $html=Utilerias::llenaListBoxSel($SQLpv,  $pvta);
                            //        $SQLpv = mysql_query($SQLpv);
                            //        while ($rowpv = mysql_fetch_array($SQLpv)) {
                            //            $html->asignar('nivelpv', "<option value='" . $rowpv["une_claveunegocio"] . "'>"
                            //                    . $rowpv["une_descripcion"] . "</option>");
                            $this->Nivelpv=$html;
                          
                            //        }
                        }
    
    
                        /* termina llenado de listas punto de venta y cuentas */
                    } //finaliza para externos
    
       
                //CONSULTA DE CATALAGO ESTRUCTURAS
                //  $SQL = "SELECT * FROM cnfg_estructura";
                $SQLe = Estructura::listaEstructura();
                if ($claveg == 'cli' || $claveg == 'muf') {
                    if (isset ( $nvel))
                        $VarNivel2 = $nvel;
                   else
                      $VarNivel2 = $tipo_usu;
                    $this->NOMBRENIVEL= "NIVEL DE CONSULTA: ";
                    $this->nivel11="<select  class='form-control' name='SelectNivel' onchange='cargaNivel(this,\"EDITAR\");'>
		     					       <option value=\"0\">- Seleccione una opcion -</option>";
                    foreach ( $SQLe as $row ) {
                        if ($VarNivel2 == $row["mee_numnivel"])
                            $this->nivel[]= "<option value='" . $row["mee_numnivel"] . "' selected>"
                                . $row["mee_descripcionnivelesp"] . "</option>";
                                else
                                    $this->nivel[]= "<option value='" . $row["mee_numnivel"] . "'>"
                                        . $row["mee_descripcionnivelesp"] . "</option>";
                                        
                    }
                    $this->nivel[]= "</select>";
                    
                    
                    if ($VarNivel2 >= 1) {
                    /*                 * **NUEVO MODULO PHP** */
                
                         $SQL_TEM="SELECT reg_clave, reg_nombre FROM ca_regiones where
ca_regiones.cli_idcliente='$uscliente'";

                          $RS_SQM_TE = Datosnuno::listaxCliente($uscliente,"ca_nivel1");
                          $this->Posicion01= '<select class="form-control cascada" name="select1" id="select1"
                                data-group="niv-1"
                                    data-id="niv-1"
                                    data-target="niv-2"
                                    data-url="getNivelUnegocioUsu.php?"
                                        data-replacement="container1"
                                            data-default-label="-TODOS-" >
 <option value="0">- Seleccione Una Opcion -</option>';
                          $this->Posicion=Utilerias::llenaListBoxSel($RS_SQM_TE,$Nivel1);
                                
                          $this->Posicion.= "</select>";
                                
                          
                          $this->TipoNivel_1=Estructura::nombreNivel(1,1);
                                }
                  if ($VarNivel2 >= 2) {
                                /*                 * **NUEVO MODULO PHP** */

                               
                                $SQL_P=Datosndos::vistandosModel($Nivel1,"ca_nivel2");
                                $this->TipoNivel_2=Estructura::nombreNivel(2,1);
                                $this->Posicion02= "<select class='form-control cascada' name='select2' id='select2'
data-group='niv-1'
                                data-id='niv-2'
                                data-target='niv-3'
                                data-url='getNivelUnegocioUsu.php?'
                                    data-replacement='container1'
                                        data-default-label='-TODOS-'>
		  						 <option value='0'>- Seleccione Una Opcion -</option>".
                                $this->creaOpcionesSel($SQL_P, $Nivel2)."</select>";
                                /*             * ******************************************************************* */
                                

                                /*                 * ************************************************** */
                         }
                                if ($VarNivel2 >= 3) {
                                    /*                 * **NUEVO MODULO PHP** */
    
                                    $this->TipoNivel_3= Estructura::nombreNivel(3,1);
                                    $SQL_P=Datosntres::vistantresModel($Nivel2,"ca_nivel3");
                                    
                                    $this->Posicion03= "<select class='form-control cascada' name='select3' id='select3'
data-group='niv-1'
                                    data-id='niv-3'
                                    data-target='niv-4'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option>".  $this->creaOpcionesSel($SQL_P, $Nivel3)."</select>";
                                   
 /*             * ******************************************************************* */
                                    
                                }
                                if ($VarNivel2 >= 4) {
                                    /*                 * **NUEVO MODULO PHP** */
    
                                    $this->TipoNivel_4= Estructura::nombreNivel(4,1);
                                    $SQL_P=Datosncua::vistancuaModel($Nivel3,"ca_nivel4");
                                    
                                    $this->Posicion04= "<select class='form-control cascada' name='select4' id='select4'
data-group='niv-1'
                                    data-id='niv-4'
                                    data-target='niv-5'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option>".
                                    $this->creaOpcionesSel($SQL_P, $Nivel5)."</select>";
                                    
                                }
                                if ($VarNivel2 >= 5) {
                                    /*                 * **NUEVO MODULO PHP** */
                                    $this->TipoNivel_5= Estructura::nombreNivel(5,1);
                                    $SQL_P=Datosncin::vistancinModel($Nivel4,"ca_nivel5");
                                    
                                    $this->Posicion05= "<select class='form-control cascada' name='select5' id='select5'
data-group='niv-1'
                                    data-id='niv-5'
                                    data-target='niv-6'
                                    data-url='getNivelUnegocioUsu.php?'
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option>".
			  						 $this->creaOpcionesSel($SQL_P, $Nivel5)."</select>";
			  						 
                                 
    
                                }
    
                                if ($VarNivel2 >= 6) {
                                    /*                 * **NUEVO MODULO PHP** */
                                    $this->TipoNivel_6= Estructura::nombreNivel(6,1);
                                    $SQL_P=Datosnsei::vistanseiModel($Nivel5,"ca_nivel6");
                                    
                                    $this->Posicion06= "<select class='form-control cascada' name='select6' id='select6'
data-group='niv-1'
                                    data-id='niv-6'
                                  
                                        data-replacement='container1'
                                            data-default-label='-TODOS-'>
			  						 <option value='0'>- Seleccione Una Opcion -</option>".
			  						 $this->creaOpcionesSel($SQL_P, $Nivel6)."</select>";
			  						 
			  					
                                }
    
                }
                if ($gpo == 'cli' || $gpo == 'muf' || $gpo == 'adm') {
                    if ($solcer) {
                        $solcert='<div clas="form-group col-md-6">
       <label>PUEDE SOLICITAR CERTIFICACION :</label>
                
                  <input class="form-check-input"  type="checkbox" name="solicer" id="solicer" checked /></div> ';
                        
                    }else {
                        $solcert='<div clas="form-group col-md-6">
        <label>PUEDE SOLICITAR CERTIFICACION :</label>
               
                  <input class="form-check-input"  type="checkbox" name="solicer" id="solicer" /></div>';
                    }
                    
                    $this->sc= $solcert;
                    
                }
                
                
                
                if ($gpo == 'aud' || $gpo == 'adm') {
                    $solcert='<div class="form-group col-md-6">
                    <label>INSPECTOR :</label>
                           <select class="form-control" name="ntec" id="ntec">
                    		<option value="0">- Seleccione Una Opcion -</option>';
                                    // vamos a validar si es nuevo o edicion para colocar las opciones
                    $this->insp= $solcert;
    
                    $sql_ins = "SELECT * FROM ca_inspectores";
                    $rs_ins = DatosInspector::listainspectores("ca_inspectores");
                    foreach ($rs_ins as $row_ins) {
                        //$html->asignar('lista_tecnicos', $row_ins["ins_nombre"]);
                     
                        if ($login == $row_ins["ins_usuario"])
                            $this->lista_tecnicos[]=  "<option value='" . $row_ins["ins_clave"] . "' selected>"
                                    . $row_ins["ins_nombre"] . "</option>";
                        else
                             $this->lista_tecnicos[]=  "<option value='" . $row_ins["ins_clave"] . "'>"
                                            . $row_ins["ins_nombre"] . "</option>";
                                      
                       }
                     $this->lista_tecnicos[]=  "</select></div>";
                       
                 }  //if


                
    }
//     public function editarusuario(){
//         include "Utilerias/leevar.php";
//         $login = $usu;
//         if (! isset ( $usu)) //viene de recarga
//         {
//             $login_ant = $login_ant;
//             $this->login= $login ;
//             $this->login_ant= $login_ant ;
            
//             $this->contras= $contras ;
//             $this->nomusu= $nomusu ;
            
//             $this->empresa= $empresa ;
//             $this->cargo= $cargo ;
//             $this->tel= $tel ;
//             $this->mail= $email ;
//             $this->grupo= $grupo ;
//             $gpo = $grupo;
            
       
            
            
//             $Nivel1 = $select1;
//             $Nivel2 = $select2;
//             $Nivel3 = $select3;
//             $Nivel4 = $select4;
//             $Nivel5 = $select5;
//             $Nivel6 = $select6;
//             $idioma = $idioma;
            
            
            
            
//         }
  
//         if (! isset ( $login ))
//         {
//             $sql = "SELECT * FROM cnfg_usuarios where cus_usuario='$login'";
//             //    echo $sql;
//             $res_us = UsuarioModel::getUsuario( $login,"cnfg_usuarios");
//             foreach ( $res_us as $rowu) {
//                 $this->usuario['login']= $login ;
//                 $this->usuario['login_ant']= $login ;
                
//                 $this->usuario['contras']= $rowu ["cus_contrasena"] ;
//                 $this->usuario['nomusu']=$rowu ["cus_nombreusuario"] ;
                
//                 $this->usuario['empresa']= $rowu ["cus_empresa"] ;
//                 $this->usuario['cargo']= $rowu ["cus_cargo"] ;
//                 $this->usuario['tel']= $rowu ["cus_telefono"] ;
//                 $this->usuario['mail']= $rowu ["cus_email"] ;
//                 $this->usuario['grupo']= $rowu ["cus_clavegrupo"] ;
//                 $gpo = $rowu ["cus_clavegrupo"];
//                 $solcer = $rowu ["cus_solcer"];
//                 $tipo_usu = $rowu ["cus_tipoconsulta"];
//                 $this->usuario['nivel']= $rowu ["cus_tipoconsulta"] ;
                
//                 $this->usuario['tipo_usu']= $rowu ["cus_tipoconsulta"] ;
                
//                 $Nivel1 = $rowu ["cus_nivel1"];
//                 $Nivel2 = $rowu ["cus_nivel2"];
//                 $Nivel3 = $rowu ["cus_nivel3"];
//                 $Nivel4 = $rowu ["cus_nivel4"];
//                 $Nivel5 = $rowu ["cus_nivel5"];
//                 $Nivel6 = $rowu ["cus_nivel6"];
//                 $idioma = $rowu ["cus_idioma"];
//                 if(!isset($uscliente))
//                     $uscliente=$rowu["cus_cliente"];
//                     if(!isset($usservicio))
//                         $usservicio=$rowu["cus_servicio"];
//                         //es cuenta
//                         if(!isset($cta))
//                             $cta=$rowu["cus_nivel1"];
//                             if(!isset($franqcuenta))
//                                 $franqcuenta=$rowu["cus_nivel2"];
//                                 if(!isset($pvta))
//                                     $pvta=$rowu["cus_nivel3"];
                                    
                                    
//                                     /*     * ************************************ */
//             }
//         }
        
//         // crea lista de clientes
//         $sql_cli="SELECT
// `ca_clientes`.`cli_idcliente`,
// `ca_clientes`.`cli_nombrecliente`
// FROM `ca_clientes`;";
//         if(isset($uscliente)&&($uscliente!=0&&$uscliente!=-1))    // ya esta seleccionado el cliente
//         {
            
//             $html=Utilerias::llenaListBoxSel($sql_cli,$html,'lista_clientes','LCLIENTES','buscacliente',$uscliente);
//             // llena servicios
//             $sql_serv="SELECT
// `ca_servicios`.`ser_claveservicio`,`ca_servicios`.`ser_descripcionesp` FROM `ca_servicios`
// where `ca_servicios`.`cli_idcliente`='$uscliente';";
//             if(isset($usservicio)&&($usservicio!=0&&$usservicio!=-1))    // ya esta seleccionado el cliente
//             {
//                 $html=Utilerias::llenaListBoxSel($sql_serv, $html, 'lista_servicios', 'LSERVICIOS', 'buscaservicios',$usservicio);
//             }else
//                 $html=Utilerias::llenaListBoxSel($sql_serv, $html, 'lista_servicios', 'LSERVICIOS', 'buscaservicios');
//         }
//         else
            
//             $html=Utilerias::llenaListBoxSel($sql_cli,$html,'lista_clientes','LCLIENTES','buscacliente');
            
//             /*     * **CONSULTA QUE GENERA LA VISTA DE USUARIOS**** */
            
//             if ($gpo == 'cli' || $gpo == 'cue' || $gpo == 'muf') {
//                 /* actualiza idioma */
//                 $this->cidioma= " <option value=''>- Seleccione una opcion - </option>" );
//                 $html->expandir ( 'IDIOMAS', '+buscaidioma' );
//                 if ($idioma == 1) {
//                     $this->cidioma', "<option value=1 selected='selected'>Espa&ntilde;ol</option>" );
//                     $html->expandir ( 'IDIOMAS', '+buscaidioma' );
//                 } else {
//                     $this->cidioma', "<option value=1>Espa&ntilde;ol</option>" );
//                     $html->expandir ( 'IDIOMAS', '+buscaidioma' );
//                 }
//                 if ($idioma == 2) {
//                     $this->cidioma', "<option value=2 selected='selected'>Ingles</option>" );
//                     $html->expandir ( 'IDIOMAS', '+buscaidioma' );
//                 } else {
//                     $this->cidioma', "<option value=2>Ingles</option>" );
//                     $html->expandir ( 'IDIOMAS', '+buscaidioma' );
//                 }
//             } else {
//                 $this->cidioma', "<option value=1>Espa&ntilde;ol</option>" );
//                 $html->expandir ( 'IDIOMAS', '+buscaidioma' );
//             }
//             //actualiza grupo laboratorio
//             if ($gpo== 'lab') {
//                 $html->asignar('NOMBRENIVEL', "LABORATORIO: ");
//                 $html->asignar('nivel11', "<select name='laboratorio'>
// 		     					       <option value=\"0\">- Seleccione una opcion -</option>");
//                 // opciones del laboratorio
//                 $numcat=43;
//                 $sqlca="select * from ca_catalogosdetalle where cad_idcatalogo=".$numcat.";";
//                 $rsca=mysql_query($sqlca);
//                 foreach ($rowc=mysql_fetch_array($rsca)){
//                     $opcionn=$rowc["cad_idopcion"];
//                     if ($opcionn == $tipo_usu) {
//                         $opcionc="<option value=".$rowc[cad_idopcion]."' selected>".$rowc[cad_descripcionesp]."</option>";
//                         $html->asignar('nivel', $opcionc);
//                     } else {
//                         $opcionc="<option value=".$rowc[cad_idopcion].">".$rowc[cad_descripcionesp]."</option>";
//                         $html->asignar('nivel', $opcionc);
//                     }
//                     $html->expandir('NIVELES', '+buscanivel');
//                 }
//             }
            
            
//             if ($gpo == 'cli' || $gpo == 'muf') { //es cliente
                
//                 $SQL = "SELECT *  FROM cnfg_estructura";
//                 $result = mysql_query ( $SQL );
//                 if (isset ( $_GET ["nvel"] ))
//                     $VarNivel2 = $_GET ["nvel"];
//                     else
//                         $VarNivel2 = $tipo_usu;
//                         $this->NOMBRENIVEL', "NIVEL DE CONSULTA: " );
//                         $this->nivel11', "<select name='SelectNivel' onChange='cargaNivel(this);'>
// 		     					       <option value='0'>- Selectione Una Opcion -</option>" );
//                         foreach ( $row = mysql_fetch_array ( $result ) ) {
//                             if ($row ["mee_numnivel"] == $VarNivel2)
//                                 $this->nivel', "<option value='" . $row ["mee_numnivel"] . "' selected>" . $row ["mee_descripcionnivelesp"] . "</option>" );
                                
//                                 else
//                                     $this->nivel', "<option value='" . $row ["mee_numnivel"] . "'>" . $row ["mee_descripcionnivelesp"] . "</option>" );
//                                     $html->expandir ( 'NIVELES', '+buscanivel' );
//                         }
//                         $this->nivel', "</select>" );
//                         $html->expandir ( 'NIVELES', '+buscanivel' );
                        
//                         if ($VarNivel2 >= 1) {
//                             /*                 * **NUEVO MODULO PHP** */
//                             //        if($Nivel1>0)
//                                 //            $SQL_TEM = "SELECT reg_clave, reg_nombre FROM ca_regiones where reg_clave='$Nivel1'";
//                                 //        else
//                                 $SQL_TEM="SELECT reg_clave, reg_nombre FROM ca_regiones where
// ca_regiones.cli_idcliente='$uscliente'";
                                
//                                 $RS_SQM_TE = @mysql_query ( $SQL_TEM );
//                                 $this->Posicion01', "<select name='select1' id='select1' onChange='cargaContenido(this.id)'>
// 					   				 " );
//                                 foreach ( $registro = mysql_fetch_row ( $RS_SQM_TE ) ) {
//                                     if ($Nivel1 == $registro[0])
//                                         $this->Posicion', "<option value='" . $registro [0] . "' selected>" . $registro [1] . "</option>" );
//                                         else
//                                             $this->Posicion', "<option value='" . $registro [0] . "'>" . $registro [1] . "</option>" );
//                                             $Nivel1 = $registro[0];
                                            
//                                             $html->expandir ( 'PRINCIPAL', '+PanelNvel01' );
//                                 }
//                                 $this->Posicion', "</select>" );
//                                 $html->expandir ( 'PRINCIPAL', '+PanelNvel01' );
                                
//                                 $sql_Niveles = "SELECT * FROM cnfg_estructura WHERE mee_numnivel =1";
//                                 $rs_Niveles = @mysql_query ( $sql_Niveles );
//                                 foreach ( $row_niveles = @mysql_fetch_array ( $rs_Niveles ) ) {
//                                     $this->TipoNivel_1', $row_niveles ["mee_descripcionnivelesp"] );
//                                 }
//                         }
//                         if ($VarNivel2 >= 2) {
//                             /*                 * **NUEVO MODULO PHP** */
                            
//                             $SQL_TEM = "SELECT
// ca_paises.pais_clave,
// ca_paises.pais_nombre
// FROM
// ca_paises
// where
// ca_paises.reg_clave=$Nivel1 ";
                            
                            
//                             /*                 * **************************************************** */
//                             $this->Posicion02', creaOpcion ( $SQL_TEM, "select2", $Nivel2 ) );
//                             /*                 * ******************************************************************* */
                            
//                             $sql_Niveles = "SELECT * FROM cnfg_estructura WHERE mee_numnivel = 2";
//                             $rs_Niveles = @mysql_query ( $sql_Niveles );
//                             foreach ( $row_niveles = @mysql_fetch_array ( $rs_Niveles ) ) {
//                                 $this->TipoNivel_2', $row_niveles ["mee_descripcionnivelesp"] );
//                             }
                            
//                             /*                 * ************************************************** */
//                         }
//                         if ($VarNivel2 >= 3) {
//                             /*                 * **NUEVO MODULO PHP** */
                            
//                             $SQL_TEM = "SELECT zona_clave, zona_nombre FROM ca_zonas
// 						WHERE reg_clave='" . $Nivel1 . "' and pais_clave ='" . $Nivel2 . "'";
                            
//                             //echo $SQL_TEM;
//                             /*                 * **************************************************** */
//                             $this->Posicion03', creaOpcion ( $SQL_TEM, "select3", $Nivel3 ) );
//                             /*                 * ******************************************************************* */
                            
//                                 $sql_Niveles = "SELECT * FROM cnfg_estructura WHERE mee_numnivel =3 ";
//                             $rs_Niveles = @mysql_query ( $sql_Niveles );
//                             foreach ( $row_niveles = @mysql_fetch_array ( $rs_Niveles ) ) {
//                                 $this->TipoNivel_3', $row_niveles ["mee_descripcionnivelesp"] );
//                             }
//                         }
//                         if ($VarNivel2 >= 4) {
//                             /*                 * **NUEVO MODULO PHP** */
                            
//                             $SQL_TEM = "SELECT est_clave, est_nombre FROM ca_estados
//                     WHERE reg_clave='" . $Nivel1 . "' and pais_clave ='" . $Nivel2 . "' and zona_clave='" . $Nivel3 . "'";
                            
//                             $this->Posicion04', creaOpcion ( $SQL_TEM, "select4", $Nivel4 ) );
                            
//                             $sql_Niveles = "SELECT * FROM cnfg_estructura WHERE mee_numnivel = 4";
//                             $rs_Niveles = @mysql_query ( $sql_Niveles );
//                             foreach ( $row_niveles = @mysql_fetch_array ( $rs_Niveles ) ) {
//                                 $this->TipoNivel_4', $row_niveles ["mee_descripcionnivelesp"] );
//                             }
//                         }
//                         if ($VarNivel2 >= 5) {
//                             /*                 * **NUEVO MODULO PHP** */
                            
//                             $SQL_TEM = "SELECT ciu_clave, ciu_nombre
// 					 FROM ca_ciudades
// 					WHERE reg_clave='" . $Nivel1 . "'
// 					  AND pais_clave ='" . $Nivel2 . "'
// 					  AND zona_clave='" . $Nivel3 . "'
// 					  AND est_clave='" . $Nivel4 . "'";
                            
//                             $this->Posicion05', creaOpcion ( $SQL_TEM, "select5", $Nivel5 ) );
//                             /*                 * ******************************************************************* */
//                             $sql_Niveles = "SELECT * FROM cnfg_estructura WHERE mee_numnivel = 5";
//                             $rs_Niveles = @mysql_query ( $sql_Niveles );
//                             foreach ( $row_niveles = @mysql_fetch_array ( $rs_Niveles ) ) {
//                                 $this->TipoNivel_5', $row_niveles ["mee_descripcionnivelesp"] );
//                             }
                            
//                         }
                        
//                         if ($VarNivel2 >= 6) {
//                             /*                 * **NUEVO MODULO PHP** */
                            
//                             $SQL_TEM = "SELECT niv6_clave, niv6_nombre
// 					 FROM ca_nivelseis
// 					WHERE reg_clave='" . $Nivel1 . "'
// 					  AND pais_clave ='" . $Nivel2 . "'
// 					  AND zona_clave='" . $Nivel3 . "'
// 					  AND est_clave='" . $Nivel4 . "'
// 					  AND ciu_clave='" . $Nivel5 . "'  order by niv6_nombre asc;";
//                             $this->Posicion06', creaOpcion ( $SQL_TEM, "select6", $Nivel6 ) );
//                             /*                 * ******************************************************************* */
                            
//                             $sql_Niveles = "SELECT * FROM cnfg_estructura WHERE mee_numnivel = 6";
//                             $rs_Niveles = @mysql_query ( $sql_Niveles );
//                             foreach ( $row_niveles = @mysql_fetch_array ( $rs_Niveles ) ) {
//                                 $this->TipoNivel_6', $row_niveles ["mee_descripcionnivelesp"] );
//                             }
//                         }
                        
//             } else if ($gpo == 'cue') {
                
                
//                 /* llena listas de cuentas y puntos de venta */
//                 if(isset($usservicio)&&($usservicio!=0||$usservicio!=-1)) {// busco las cuentas de ese servicio
                    
                    
//                     $SQLcu = "SELECT
//                 `ca_cuentas`.`cue_id`,
//                 `ca_cuentas`.`cue_descripcion`
//                 FROM `ca_cuentas`
//                 where `ca_cuentas`.`cli_idcliente`='$uscliente' and
//                 `ca_cuentas`.`ser_claveservicio`='$usservicio';";
//                     $SQLmcu = mysql_query($SQLcu);
//                     foreach ($rowcu = mysql_fetch_array($SQLmcu)) {
//                         if ($rowcu["cue_id"] == $cta) {
//                             $html->asignar('nivelfr', "<option value=" . $rowcu["cue_id"] . " selected='selected'>"
//                                 . $rowcu["cue_descripcion"] . "</option>");
//                         } else {
//                             $html->asignar('nivelfr', "<option value='" . $rowcu["cue_id"] . "'>"
//                                 . $rowcu["cue_descripcion"] . "</option>");
//                         }
//                         $html->expandir('NIVELESFR', '+buscanivelfr');
//                     }
//                     // llena lista de franquicias
//                     $ssql_fran=("SELECT
// `ca_franquiciascuenta`.`fc_idfranquiciacta`,
// `ca_franquiciascuenta`.`cf_descripcion`
// FROM `ca_franquiciascuenta` where `ca_franquiciascuenta`.`cli_idcliente`='$uscliente' and
// `ca_franquiciascuenta`.`ser_claveservicio`='$usservicio'
// and `ca_franquiciascuenta`.`cue_clavecuenta` ='".$cta."';");
                    
//                     $rs_fran=mysql_query($ssql_fran);
                    
//                     foreach ($row_fran=@mysql_fetch_array($rs_fran)) {
//                         if($row_fran[0]==$franqcuenta)
//                             $op.= "<option value='" . $row_fran[0] . "' selected='selected' >" . $row_fran[1] . "</option>";
//                             else
//                                 $op.= "<option value='" . $row_fran[0] . "' >" . $row_fran[1] . "</option>";
                                
//                     }
                    
//                     $html->asignar("francta",$op);
                    
//                     /* llena listas de  puntos de venta */
//                     $SQLpv = "select `ca_unegocios`.`une_claveunegocio`,
// `ca_unegocios`.`une_descripcion` from ca_unegocios where `ca_unegocios`.`cli_idcliente`='$uscliente' and
// `ca_unegocios`.`ser_claveservicio`='$usservicio' and
// `ca_unegocios`.`cue_clavecuenta`='$cta' and fc_idfranquiciacta='$franqcuenta';";
                    
//                     $html=Utilerias::llenaListBoxSel($SQLpv, $html, 'nivelpv', 'NIVELESPV', 'buscanivelpv', $pvta);
//                     //        $SQLpv = mysql_query($SQLpv);
//                     //        while ($rowpv = mysql_fetch_array($SQLpv)) {
//                     //            $html->asignar('nivelpv', "<option value='" . $rowpv["une_claveunegocio"] . "'>"
//                     //                    . $rowpv["une_descripcion"] . "</option>");
//                     //            $html->expandir('NIVELESPV', '+buscanivelpv');
//                     //        }
//                 }
                
                
//                 /* termina llenado de listas punto de venta y cuentas */
//             } //finaliza para externos
            
            
//             if ($gpo == 'cli' || $gpo == 'muf' || $gpo == 'adm') {
//                 if ($solcer) {
//                     $solcert='
// <tr>
//         <td class="EtiAreatxt"><span class="NuevoEtiqueta">PUEDE SOLICITAR CERTIFICACION :</span></td>
//         <td><span class="AreaCampos">
//           <input type="checkbox" name="solicer" id="solicer" checked />
                        
//         </span></td>
//       </tr>';
                    
//                 }else {
//                     $solcert='
// <tr>
//         <td class="EtiAreatxt"><span class="NuevoEtiqueta">PUEDE SOLICITAR CERTIFICACION :</span></td>
//         <td><span class="AreaCampos">
//           <input type="checkbox" name="solicer" id="solicer" />
                        
//         </span></td>
//       </tr>';
//                 }
                
//                 $html->asignar('sc', $solcert);
//                 $html->expandir('LSOLI', 'solicitudes');
//             }
            
            
//             if ($gpo == 'aud' || $gpo == 'adm') {
//                 $solcert='
// <tr>
//         <td class="EtiAreatxt"><span class="NuevoEtiqueta">INSPECTOR :</span></td>
//         <td>
// 		<select name="ntec" id="ntec">
// 		<option value="0">- Seleccione Una Opcion -</option>';
//                 // vamos a validar si es nuevo o edicion para colocar las opciones
//                 $html->asignar('insp', $solcert);
                
//                 $sql_ins = "SELECT * FROM ca_inspectores";
//                 $rs_ins = @mysql_query($sql_ins);
//                 foreach ($row_ins = @mysql_fetch_array($rs_ins)) {
//                     //$html->asignar('lista_tecnicos', $row_ins["ins_nombre"]);
//                     if ($login == $row_ins["ins_usuario"])
//                         $html->asignar('lista_tecnicos', "<option value='" . $row_ins["ins_clave"] . "' selected>"
//                             . $row_ins["ins_nombre"] . "</option>");
//                         else
//                             $html->asignar('lista_tecnicos', "<option value='" . $row_ins["ins_clave"] . "'>"
//                                 . $row_ins["ins_nombre"] . "</option>");
//                             $html->expandir('LTECNICOS', '+buscatecnicos');
//                 }
//                 $html->asignar('lista_tecnicos', "</select></td></tr>");
//                 $html->expandir('LTECNICOS', '+buscatecnicos');
//             }  //if
            
            
            
            
//             //$html->expandir('FILAS', 'tbusqueda');
//             $html->expandir ( 'areanuevo', 'tnuevo' );
            
//     }
//             /********************** seccion de funciones ******************************/
            
//             function creaOpcion($SQL_TEM, $select, $nivel) {
                
//                 $RS_SQM_TE = @mysql_query ( $SQL_TEM );
//                 $cad = "<select name='$select' id='$select' onChange='cargaContenido(this.id)'>" . "<option>- Seleccione Una Opcion -</option>";
                
//                 foreach ( $registro = @mysql_fetch_row ( $RS_SQM_TE ) ) {
//                     if ($nivel == $registro [0])
//                         $select = 'selected';
//                         else
//                             $select = '';
                            
//                             $op .= "<option value='" . $registro [0] . "' " . $select . ">" . $registro [1] . "</option>";
//                 }
//                 return $cad . $op . "</select>";
                
//             }
            
    
    public function insertarUsuario(){
        include "Utilerias/leevar.php";
        
        // solicita certificadion
        if ($solicer) {
            $solcer=-1;
        } else {
            $solcer=0;
        }
        
        $op2=$grupo;
        echo "+++".$op2;
        try{
        if($op2=='cli' ){
            $sql2 = "INSERT INTO cnfg_usuarios(cus_usuario,cus_contrasena,cus_nombreusuario,cus_empresa,cus_cargo,cus_telefono,cus_email,cus_clavegrupo,
            cus_tipoconsulta,cus_nivel1,cus_nivel2,cus_nivel3,cus_nivel4,cus_nivel5,cus_nivel6,cus_idioma,
`cus_cliente`, `cus_servicio`, cus_solcer)
            VALUES('".$login."','".$contras."', '".$nomusu."', '".$empresa."', '".$cargo."', '".$tel."','".$email."','".$op2."',
                '".$SelectNivel."','".$select1."','".$select2."','".$select3."','".$select4."','".$select5."','".$select6."','$idioma','$uscliente','$usservicio', $solcer)";
            
            UsuarioModel::insertarUsuario($login, $contras, $nomusu, $empresa, $cargo, $tel, $email, $op2, $SelectNivel, $select1, 
                $select2, $select3, $select4, $select5, $select6, $idioma, $uscliente, $usservicio, $solcer, "cnfg_usuarios");
        }else
            if($op2=='cue' || $op2 == 'muf')
            {
                //busco tipo de consulta
                if($cta>0)
                    $nivel=1;
                if($franqcuenta>0)
                     $nivel++;
                 if($unidadnegocio>0)
                      $nivel++;
                            
                            /*   $sql2 = "INSERT INTO cnfg_usuarios(cus_usuario,cus_contrasena,cus_nombreusuario,cus_empresa,cus_cargo,cus_telefono,cus_email,cus_clavegrupo,
                             cus_tipoconsulta,cus_nivel1,cus_nivel2,cus_nivel3,cus_idioma,
                             `cus_cliente`,
                             `cus_servicio`, cus_solcer)
                             VALUES('".$login."','".$contras."', '".$nomusu."', '".$empresa."', '".$cargo."', '".$tel."','".$email."','".$grupo."','".
                             $nivel."','".$cta."','".$franqcuenta."','".$unidadnegocio."','".$idioma."','$uscliente','$usservicio', $solcer)";
                             // }  */
                            
                 $sql2 = "INSERT INTO cnfg_usuarios(cus_usuario,cus_contrasena,cus_nombreusuario,cus_empresa,cus_cargo,cus_telefono,cus_email,cus_clavegrupo,
            cus_tipoconsulta,cus_nivel1,cus_nivel2,cus_nivel3,cus_nivel4,cus_nivel5,cus_nivel6,cus_idioma,
`cus_cliente`, `cus_servicio`, cus_solcer)
            VALUES('".$login."','".$contras."', '".$nomusu."', '".$empresa."', '".$cargo."', '".$tel."','".$email."','".$op2."',
                '".$SelectNivel."','".$select1."','".$select2."','".$select3."','".$select4."','".$select5."','".$select6."','$idioma','$uscliente','$usservicio', $solcer)";
                 UsuarioModel::insertarUsuario($login, $contras, $nomusu, $empresa, $cargo, $tel, $email, $op2, $SelectNivel, $select1,
                     $select2, $select3, $select4, $select5, $select6, $idioma, $uscliente, $usservicio, $solcer, "cnfg_usuarios");
                            
                            
                          
                            
                            
                         
            } else if($op2=='lab'){
                //
                //
                $sql2 = "INSERT INTO cnfg_usuarios(cus_usuario,cus_contrasena,cus_nombreusuario,cus_empresa,cus_cargo,cus_telefono,cus_email,cus_clavegrupo,
            cus_tipoconsulta,cus_idioma,
`cus_cliente`,
`cus_servicio`)
            VALUES('".$login."','".$contras."', '".$nomusu."', '".$empresa."', '".$cargo."', '".$tel."','".$email."','".$op2."',
                '".$laboratorio."','$idioma','$uscliente','$usservicio')";
                UsuarioModel::insertarUsuario($login, $contras, $nomusu, $empresa, $cargo, $tel, $email, $op2, $laboratorio,null, null, null, null, null, null, $idioma, $uscliente, $usservicio, null, "cnfg_usuarios");
            }
            else if($op2=='aud' || $op2 == 'adm'){
                
                $sql2 = "INSERT INTO cnfg_usuarios(cus_usuario,cus_contrasena,cus_nombreusuario,cus_empresa,cus_cargo,cus_telefono,cus_email,cus_clavegrupo,
    cus_tipoconsulta,cus_idioma, cus_nivel1,cus_nivel2,cus_nivel3, cus_nivel4, cus_nivel5, cus_nivel6,
`cus_cliente`,`cus_servicio`, cus_solcer) VALUES('".$login."','".$contras."', '".$nomusu."', '".$empresa."', '".$cargo."', '".$tel."','".$email."','".$op2."','".$SelectNivel."','".$idioma."','".$select1."','".$select2."','".$select3."','".$select4."','".$select5."','".$select6."' ,'$uscliente','$uscuenta', $solcer)";
                
               UsuarioModel::insertarUsuario($login, $contras, $nomusu, $empresa, $cargo, $tel, $email, $op2, $SelectNivel, $select1,
                   $select2, $select3, $select4, $select5, $select6, $idioma, $uscliente, $usservicio, $solcer, "cnfg_usuarios");
                
                // limpia usuario
                $sql3 = "UPDATE `ca_inspectores`
SET `ins_usuario` = ''
WHERE `ins_usuario` = '".$login."'";
                
                DatosInspector::borrarInspector($login, "ca_inspectores");
                
                
                $sql3 = "UPDATE `ca_inspectores`
SET `ins_usuario` = '".$login."'
WHERE `ins_clave` = '".$ntec."'";
                
                DatosInspector::editarInspector($login, $ntec, "ca_inspectores");
                
            }
            else
                
            {   $sql2 = "INSERT INTO cnfg_usuarios(cus_usuario,cus_contrasena,cus_nombreusuario,cus_empresa,cus_cargo,cus_telefono,cus_email,cus_clavegrupo,
    cus_tipoconsulta,cus_idioma, cus_nivel1,cus_nivel2,cus_nivel3, cus_nivel4, cus_nivel5, cus_nivel6,
`cus_cliente`,`cus_servicio`, cus_solcer) VALUES('".$login."','".$contras."', '".$nomusu."', '".$empresa."', '".$cargo."', '".$tel."','".$email."','".$op2."','".$SelectNivel."','".$idioma."','".$select1."','".$select2."','".$select3."','".$select4."','".$select5."','".$select6."' ,'$uscliente','$uscuenta', $solcer)";
                
                //echo $sql2;
                
               UsuarioModel::insertarUsuario($login, $contras, $nomusu, $empresa, $cargo, $tel, $email, $op2, $SelectNivel, $select1, $select2, $select3, $select4, $select5, $select6, $idioma, $uscliente, $usservicio, $solcer, "cnfg_usuarios");
            }
               $this->mensaje='<div class="alert alert-success">Se insertó el usuario</div>';
        }catch(Exception $ex){
            $this->mensaje='<div class="alert alert-danger">'.$ex->getMessage().'. Intente de nuevo</div>';
        }
    }
    
    public function eliminarUsuario(){
        include "Utilerias/leevar.php";
     
        
  
        try{
       UsuarioModel::eliminarUsuario($usu,"cnfg_usuarios");
       $this->mensaje='<div class="alert alert-success">Se eliminó el usuario</div>';
        }catch(Exception $ex){
            $this->mensaje='<div class="alert alert-danger">'.$ex->getMessage().'. Intente de nuevo</div>';
        }
    }
    
    public function actualizarUsuario(){
        include "Utilerias/leevar.php";
        try{
           
        if($grupo=='cue'){
            
            //busco tipo de consulta
            if($cta>0)
                $nivel=1;
            if($franqcuenta>0)
                $nivel++;
            if($pvta>0)
                $nivel++;
            $sql = "UPDATE cnfg_usuarios SET cus_usuario = '".$login."', cus_contrasena = '".$contras."', cus_nombreusuario ='".$nomusu."', cus_empresa = '".$empresa."', cus_cargo='".$cargo."',cus_telefono = '".$tel."', cus_email = '".$email."', cus_clavegrupo = '".$grupo."', cus_tipoconsulta = '".$nivel."',
        cus_nivel1 = '".$cta."', cus_nivel2 = '".$franqcuenta."', cus_nivel3 = '".$pvta."', cus_idioma='".$idioma."',`cus_cliente` = '$uscliente',
`cus_servicio` = '$usservicio' WHERE cus_usuario = '".$login_ant."'";
            UsuarioModel::editarUsuario($login_ant,$login,$contras,$nomusu,$empresa,$cargo,$tel,$email,$grupo,$nivel,$cta,
                            $franqcuenta,$pvta,null,null,null,$idioma,$uscliente,$usservicio,null,'');
        }else{
        
        if ($solicer) {
            $solcer=-1;
        }else{
            $solcer=0;
        }
        
        if($grupo=='lab'){
            $sql = "UPDATE cnfg_usuarios SET cus_usuario = '".$login."', cus_contrasena = '".$contras."', cus_nombreusuario ='".$nomusu."', cus_empresa = '".$empresa."', cus_cargo='".$cargo."',cus_telefono = '".$tel."', cus_email = '".$email."', cus_clavegrupo = '".$grupo."', cus_tipoconsulta = '".$laboratorio."',
        cus_idioma='".$idioma."',`cus_cliente` = '$uscliente',
`cus_servicio` = '$usservicio' WHERE cus_usuario = '".$login_ant."'";
            UsuarioModel::editarUsuario($login_ant,$login,$contras,$nomusu,$empresa,$cargo,$tel,$email,$grupo,$laboratorio,'',
            '','','','','',$idioma,$uscliente,$usservicio,null,'');
        }
        else
        {    $sql = "UPDATE cnfg_usuarios SET cus_usuario = '".$login."', cus_contrasena = '".$contras."', cus_nombreusuario ='".$nomusu."', cus_empresa = '".$empresa."', cus_cargo='".$cargo."', cus_telefono = '".$tel."', cus_email = '".$email."', cus_clavegrupo = '".$grupo."', cus_tipoconsulta = '".$SelectNivel."', cus_nivel1 = '".$select1."', cus_nivel2 = '".$select2."', cus_nivel3 = '".$select3."', cus_nivel4 = '".$select4."', cus_nivel5 = '".$select5."', cus_nivel6 = '".$select6."' , cus_idioma='".$idioma."' ,`cus_cliente` = '$uscliente', cus_solcer=$solcer,
`cus_servicio` = '$usservicio' WHERE cus_usuario = '".$login_ant."'";
            UsuarioModel::editarUsuario($login_ant,$login,$contras,$nomusu,$empresa,$cargo,$tel,$email,$grupo,$SelectNivel,$select1,
                $select2,$select3,$select4,$select5,$select6,$idioma,$uscliente,$usservicio,$solcer,'');
            
        }
            
            if($grupo=='aud' || $grupo == 'adm'){
//                 $sql3 = "UPDATE `ca_inspectores`
// SET `ins_usuario` = ''
// WHERE `ins_usuario` = '".$login."'";
                
//                 $rst3=mysql_query($sql3);
                
                
                $sql3 = "UPDATE `ca_inspectores`
SET `ins_usuario` = '".$login."'
WHERE `ins_clave` = '".$ntec."'";
               
                $rst3=DatosInspector::editarInspector($login,$ntec,"ca_inspectores");
                
                
            }
        }
            $this->mensaje='<div class="alert alert-success">Se actualizó el usuario</div>';
        }catch(Exception $ex){
            $this->mensaje='<div class="alert alert-danger">'.$ex->getMessage().'. Intente de nuevo</div>';
        }
    }
    
    function creaOpcionesSel($RS_SQM_TE, $seleccion) {
        
       foreach ($RS_SQM_TE as $registro) {
            if($registro[0]==$seleccion)
                $op.= "<option value='" . $registro[0] . "'selected='selected' >" . $registro[1] . "</option>";
                else
                    $op.= "<option value='" . $registro[0] . "' >" . $registro[1] . "</option>";
        }
        return  $op ;
    }
    /**
     * @return string
     */
    public function getTITULO5()
    {
        return $this->TITULO5;
    }

    /**
     * @return mixed
     */
    public function getIdnum()
    {
        return $this->idnum;
    }

    /**
     * @return mixed
     */
    public function getOp2()
    {
        return $this->op2;
    }

    /**
     * @return mixed
     */
    public function getListaUsuarios()
    {
        return $this->listaUsuarios;
    }

    /**
     * @return string
     */
    public function getLista_servicios()
    {
        return $this->lista_servicios;
    }

    /**
     * @return string
     */
    public function getNOMBRENIVEL()
    {
        return $this->NOMBRENIVEL;
    }

    /**
     * @return string
     */
    public function getNivelfr()
    {
        return $this->nivelfr;
    }

    /**
     * @return string
     */
    public function getNivel11()
    {
        return $this->nivel11;
    }

    /**
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    /**
     * @return mixed
     */
    public function getOp()
    {
        return $this->op;
    }

    /**
     * @return mixed
     */
    public function getNV()
    {
        return $this->NV;
    }

    /**
     * @return string
     */
    public function getLista_clientes()
    {
        return $this->lista_clientes;
    }

    /**
     * @return mixed
     */
    public function getIDIOMAS()
    {
        return $this->IDIOMAS;
    }

    /**
     * @return mixed
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @return string
     */
    public function getPosicion01()
    {
        return $this->Posicion01;
    }

    /**
     * @return string
     */
    public function getPosicion02()
    {
        return $this->Posicion02;
    }

    /**
     * @return string
     */
    public function getPosicion03()
    {
        return $this->Posicion03;
    }

    /**
     * @return string
     */
    public function getPosicion04()
    {
        return $this->Posicion04;
    }

    /**
     * @return string
     */
    public function getPosicion05()
    {
        return $this->Posicion05;
    }

    /**
     * @return string
     */
    public function getPosicion06()
    {
        return $this->Posicion06;
    }

    /**
     * @return string
     */
    public function getPosicion()
    {
        return $this->Posicion;
    }

    /**
     * @return mixed
     */
    public function getTipoNivel_1()
    {
        return $this->TipoNivel_1;
    }

    /**
     * @return mixed
     */
    public function getTipoNivel_2()
    {
        return $this->TipoNivel_2;
    }

    /**
     * @return mixed
     */
    public function getTipoNivel_3()
    {
        return $this->TipoNivel_3;
    }

    /**
     * @return mixed
     */
    public function getTipoNivel_4()
    {
        return $this->TipoNivel_4;
    }

    /**
     * @return mixed
     */
    public function getTipoNivel_5()
    {
        return $this->TipoNivel_5;
    }

    /**
     * @return mixed
     */
    public function getTipoNivel_6()
    {
        return $this->TipoNivel_6;
    }

    /**
     * @return string
     */
    public function getSc()
    {
        return $this->sc;
    }

    /**
     * @return string
     */
    public function getInsp()
    {
        return $this->insp;
    }

    /**
     * @return mixed
     */
    public function getLista_tecnicos()
    {
        return $this->lista_tecnicos;
    }
    /**
     * @return mixed
     */
    public function getFrancta()
    {
        return $this->francta;
    }
    /**
     * @return string
     */
    public function getAccion()
    {
        return $this->accion;
    }
    /**
     * @return string
     */
    public function getNivelpv()
    {
        return $this->Nivelpv;
    }





    
    
}

