<?php



require_once "Models/conexion.php";


class Estructura extends Conexion{

	public function vistaEstructuraCompleta($idnivel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT mee_numnivel, mee_descripcionnivelesp, mee_descripcionniveling FROM cnfg_estructura WHERE mee_numnivel=:idnivel");
				
		$stmt->bindParam(":idnivel", $idnivel, PDO::PARAM_INT);					
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}
	
	public static function listaEstructura(){
	    $stmt = Conexion::conectar()-> prepare("SELECT mee_numnivel, mee_descripcionnivelesp, mee_descripcionniveling 
FROM cnfg_estructura");
	    
	    $stmt-> execute();
	    
	    return $stmt->fetchAll();
	    
	}

	    public function getDescripcionNivel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT * FROM $tabla WHERE mee_numnivel = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		$rse= $stmt->fetch();
		
        if($_SESSION["idiomaus"]==2) 
            $val= $rse["mee_descripcionniveling"];
        else
            $val= $rse["mee_descripcionnivelesp"];
                
                return $val;
	}
        
          function nombreNivel($nivel, $vidiomau) {

        $sql = "SELECT
cnfg_estructura.mee_numnivel,
cnfg_estructura.mee_descripcionnivelesp,
cnfg_estructura.mee_descripcionniveling
FROM
cnfg_estructura
where cnfg_estructura.mee_numnivel=$nivel";

        $res = Conexion::ejecutarQuerysp($sql);
        $i = 0;

        if ($vidiomau == 2) {
            $nomcampo = "mee_descripcionniveling";
        } else {
            $nomcampo = "mee_descripcionnivelesp";
        }
        foreach ($res as $row) {

            $nombre = $row[$nomcampo];
        }

        return $nombre;
    }
        
        

}

?>	