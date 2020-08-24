 <?php
 
 
 $idcat=filter_input(INPUT_GET, "cat",FILTER_SANITIZE_STRING);
 if($idcat=="")
 { 	$idcat=$catalogo["cad_idcatalogo"];
 }
 ?> 
 
     <div class="form-group col-md-6">
       <label >NOMBRE EN ESPA&Ntilde;OL : </label> 
        <input name="nomopesp" type="text" class="form-control" id="nomopesp" size="70" value="<?php echo $catalogo["cad_descripcionesp"]?>">
                </div>
                <div class="form-group col-md-6">
       <label >NOMBRE EN INGLES : </label> 
         <input name="clavecat" type="hidden" value="<?php echo $idcat?>">
           <input name="idopcion" type="hidden" value="<?php echo $catalogo["cad_idopcion"]?>">
 
     <input name="nomoping" type="text" class="form-control" id="nomoping" size="70" value="<?php echo $catalogo["cad_descripcioning"]?>">
   </div>
      <?php echo $catalogo->nomotro?>
      <?php echo $catalogo->datotro?>
   
