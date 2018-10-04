<?php





class DatosRecepcionMuestra

{



    

    function listaRecepcionMuestraDet($muestra) {

        

        $sqllab="SELECT aa_recepcionmuestra.rm_embotelladora, aa_recepcionmuestradetalle.mue_idmuestra

FROM aa_recepcionmuestradetalle

Inner Join aa_recepcionmuestra ON aa_recepcionmuestradetalle.rm_idrecepcionmuestra = aa_recepcionmuestra.rm_idrecepcionmuestra".

" WHERE aa_recepcionmuestradetalle.mue_idmuestra =:nmue

GROUP BY

aa_recepcionmuestradetalle.mue_idmuestra";

        

        $stmt = Conexion::conectar()-> prepare($sqllab);

        

        $stmt-> bindParam(":nmue", $muestra, PDO::PARAM_INT);

        $stmt-> execute();

        

        return $stmt->fetchall();

        

    }

    

}



