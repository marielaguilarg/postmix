<?php
include 'Utilerias/leevar.php';
include "Models/conexion.php";
if($estado!=0)
{	$sql="SELECT  une_dir_municipio from ca_unegocios
	 where cue_clavecuenta =:referuni
	and ca_unegocios.une_dir_idestado=:estado group by une_dir_municipio 
order by une_dir_municipio;";
$parametros["referuni"]=$referuni;
$parametros["estado"]=$estado;
}
	else
	{$sql="SELECT  une_dir_municipio from ca_unegocios
 where cue_clavecuenta =:referuni
 group by une_dir_municipio order by une_dir_municipio;";
	$parametros["referuni"]=$referuni;
	}
		//echo $sql;
		$rs=Conexion::ejecutarQuery($sql,$parametros);
		$opcion="<select class=\"form-control\" name=\"ciudad\" id=\"ciudad\"><option value=\"\">TODAS</option>";
		foreach ($rs as $row){
			$opcion.="<option value=\"".$row["une_dir_municipio"]."\">".$row["une_dir_municipio"]."</option>";
			//$opcion.=$row["une_dir_municipio"]."*";
		}
		$opcion=str_replace('á',"&aacute;",$opcion);
		$opcion=str_replace('é',"&eacute;",$opcion);
		$opcion=str_replace('í',"&iacute;",$opcion);
		$opcion=str_replace('ó',"&oacute;",$opcion);
		$opcion=str_replace('ú',"&uacute;",$opcion);
		$opcion=str_replace('Ñ',"&Ntilde;",$opcion);
		echo $opcion."</select>";
		