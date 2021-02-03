<?php
//error_reporting(E_ALL);
include 'Controllers/configGraficaIndiController.php';

$configController= new ConfigGraficaIndiController();

$configController->vistaNuevoReactivo();
//echo "********  ";
//var_dump($configController->getReactivossel()); 
?>
<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
<script src="js/jquery.multi-select.js"></script>
  <script language="JavaScript" type="text/JavaScript">
<!--

function cargaMenu(opc)
{
	document.form1.action='index.php?action=sconfiguragrafica&seccion='+opc;
	document.form1.submit();
	
}
//-->
</script>
  <section class="content-header">

<h3>REACTIVOS PARA GRAFICAR</h3>

</section>
   <section class="content container-fluid">
       <?php echo $configController->mensaje;?>
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">NUEVO REACTIVO</h3>
            </div>
            <div class="box-body">
             <form role="form" name="form1" method="post" action="index.php?action=sconfiguragrafica&admin=insertar" >
              
      <div class="row">
	 <div class="col-sm-10 form-group" ><label>SECCION ESTANDAR :</label>
	 
          <select name="seccion"  class="form-control" id="combito" onchange="cargaMenu(this.value)" >
              
		  <option value="">-Seleccione una opci&oacute;n-</option>
           
			<?php foreach($configController->getListaSecciones() as $seccion){
                            if($configController->getSeccionsel()==$seccion["sec_numseccion"])
                                $selected="selected='selected'";
                            else $selected="";
                           
			    echo  '<option value="'.$seccion["sec_numseccion"].'" '.$selected.'>'.$seccion["sec_nomsecesp"].'</option>';
			}?>
             
             
			 <!-- finBloque: buscacuenta -->
			 
          </select>
          
		
	    
	  </div>
      </div>  
                   <div class="row">
                       <div  id="multiselect" class="form-group">
                               <?php   foreach($configController->getReactivossel() as $sel){
        
        
             echo '<input type="hidden" value="'.$sel["gri_reactivo"].'" name="reactivosgraf[]">';
            }
             ?>
	 <div class="col-sm-10" >
        
     <select id="src" multiple class="form-control" style="width: 600px; height: 30em;">
        
 <?php 
 $grupoactual="";
 foreach($configController->getListareactivos() as $reactivo){
     
     if($grupoactual!=$reactivo["re_descripcionesp"])
     {    $grupoactual=$reactivo["re_descripcionesp"];
      echo ' <optgroup label="'.$grupoactual.'">';
     }
     $selected="";
     foreach($configController->getReactivossel() as $sel){
        
        if($reactivo["refer"]== $sel["gri_reactivo"]){
         //   echo "estuvo";
         
          
               $selected="selected";
            break;
        }
     }   
    //  $selected="selected";
	echo  '<option value="'.$reactivo["refer"].'" '.$selected.'>'.$reactivo["red_parametroesp"].'</option>';
                            
			}?>
</select>
    </div> 
           
                   </div>
                <div class="col-sm-12" style="padding-top: 50px; border-bottom: hidden">
                 <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
               </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
        </section>

  <script language="JavaScript" type="text/JavaScript">



 $('#src').multiSelect({ keepOrder: true,selectableOptgroup: true,
 dblClick:true,

   afterSelect: function(values){
   // alert("Select value: "+values);
    agregar_reactivo(values);
  },
  afterDeselect: function(values){
 //   alert("Deselect value: "+values);
    quitar_reactivo(values)
  }
    });
    
    function agregar_reactivo(value){
         let $input=$('<input type="hidden" value="" name="reactivosgraf[]">');
         $input.val(value);
         $("#multiselect").append($input);
    }
    function quitar_reactivo(value){
           
       inputs=$("#multiselect").children("input");
         console.log(">>"+inputs.length);
         inputs.each(function( index ) {
  console.log( index + ": " + $( this ).val() );
  if($( this ).val()==value){
             $( this ).remove();
         //lo elimino y me salgo
            // break;
         }
});
//         for(i=0;i<$inputs.length;i++){
//        console.log($inputs[i]);
//         if($inputs[i].val()==value){
//             $inputs[i].remove();
//         //lo elimino y me salgo
//             break;
//         }
//         }
    }
</script>