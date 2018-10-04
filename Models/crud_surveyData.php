<?php





class DatosSurveyData

{

    

    public function getSurveyData($datosModel, $tabla){

        

        $sSQL=" SELECT

				cnfg_surveydata.surv_valorini as res,

				cnfg_surveydata.surv_numerocol

				FROM ".

				$tabla."

				WHERE

				cnfg_surveydata.surv_numerocol =:col";

        $stmt = Conexion::conectar()->prepare($sSQL);

        

        $stmt-> bindParam(":col", $datosModel, PDO::PARAM_INT);

        

        $stmt-> execute();

        

        return $stmt->fetch();

    }

    public function listaSurveyData( $tabla){

        

        $sql1="SELECT

		cnfg_surveydata.surv_numerocol ,

		cnfg_surveydata.surv_tiporeactivo ,

		cnfg_surveydata.surv_numeroreac,

		cnfg_surveydata.surv_descripcion,

		cnfg_surveydata.surv_nombrecol,

		cnfg_surveydata.surv_numeroreng

		FROM ".

		$tabla." WHERE

cnfg_surveydata.surv_numerocol IS NOT NULL  AND

cnfg_surveydata.surv_nombrecol IS NOT NULL

		ORDER BY cnfg_surveydata.surv_numerocol ASC";

        $stmt = Conexion::conectar()->prepare($sql1);

				

		

				$stmt-> execute();

				

				return $stmt->fetchAll();

    }

}



