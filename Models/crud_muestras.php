<?php

require_once "Models/conexion.php";
class DatosMuestras
{
    
    public function listaMuestrasxRep($servicio, $reporte,$tabla){
        $sql_rep="SELECT aa_muestras.mue_fechahora, aa_muestras.mue_fecharecepcion, aa_muestras.mue_fechoranalisisFQ, aa_muestras.mue_fechoranalisisMB, aa_muestras.mue_numreporte, aa_muestras.mue_claveservicio, aa_muestras.mue_idmuestra, if(aa_muestras.mue_fechoranalisisFQ>aa_muestras.mue_fechoranalisisMB,aa_muestras.mue_fechoranalisisFQ,aa_muestras.mue_fechoranalisisMB) as ulfeclab,  if((aa_muestras.mue_fechoranalisisFQ ='0000-00-00 00:00:00') or (aa_muestras.mue_fechoranalisisMB ='0000-00-00 00:00:00'),null,datediff(if(aa_muestras.mue_fechoranalisisFQ>aa_muestras.mue_fechoranalisisMB,aa_muestras.mue_fechoranalisisFQ,aa_muestras.mue_fechoranalisisMB),mue_fecharecepcion) ) AS dias_trans_lab
FROM
$tabla WHERE aa_muestras.mue_claveservicio =:nserv AND aa_muestras.mue_numreporte =:nrep";
        $stmt=Conexion::conectar()->prepare($sql_rep);
        $stmt->bindParam("nserv", $servicio,PDO::PARAM_INT);
        $stmt->bindParam("nserv", $reporte,PDO::PARAM_INT);
        
        $stmt-> execute();
        return $stmt->fetchall();
        
   
    }
}

