<script language="JavaScript" type="text/JavaScript">
<!--




function oCargar(action){
document.form1.action=action;
document.form1.submit();

}

function cargaContenidoCliente(a)
{
	if(a>0){
	var parametro={"claclien":a};

	$.ajax({
		data:parametro,
	url:"comboboxclienteserv.php",
	type:"post",
	beforeSend:function(){
		$("#idserv").html("cargando...");
	},
	success:function(response){
		$("#idserv").append("<option value='0'>- TODOS -</option>");
		$("#idserv").append(response);
	}
	});
	}else
	{	
		$("#idserv").html("cargando...");
		$("#idserv").append("<option value='0'>- TODOS -</option>");
	}
}
//-->
</script>
<?php 

include 'Controllers/repFacturacionController.php';

$repFacturaController=new RepFacturacionController;
        $repFacturaController->vistaRepFacturacion();
        ?>
 <section class="content-header">

                <h2><?php echo $repFacturaController->getTitulo()?></h2>

     

    </section>

<section class="content container-fluid">

<!--  filtros -->

    <div class="box box-info">

        <div class="box-header with-border">

            <h3 class="box-title">ESTIMADO USUARIO, PARA EXPORTAR EL ARCHIVO DEFINA EL PERIODO Y EL CLIENTE</h3>
  </div>

        <div class="box-body">
<form name="form1" id="form1" method="post" action="<?php echo $repFacturaController->getAction()?>" >
   <div class="row">
   <div class="col-md-2">
        
    <label>INDICE DE : </label></div>
       <div class="col-md-2"><select class="form-control"  name="fechainicio"  id="fechainicio" >
	
    
         <?php foreach($repFacturaController->getMini() as $mini){ 
          
             echo $mini;}?>
      
             
       
	</select></div>
	<div class="col-md-2">
	 <select class="form-control" name="fechainicio2">
 
      
      <?php foreach($repFacturaController->getPini() as $pini){
              
              echo $pini;
              
              
      } ?>
             
       </select></div>
          <div class="col-md-2">
    <label>AL INDICE DE :</label></div>
       <div class="col-md-2">
   <select class="form-control"   id="fechafin" name="fechafin" >
    <?php foreach($repFacturaController->getMfin() as $mfin){ 
             echo $mfin;}
      
           ?>
	</select></div>
       <div class="col-md-2">
       <select class="form-control" name="fechafin2">
	  <?php foreach($repFacturaController->getPini() as $pini){
              
              echo $pini;
              
              
	  }  ?>   
       </select>
      
       
  </div></div>
  <div class="row">
    <div class="col-md-2">
    <label>CLIENTE :</label></div>
       <div class="col-md-4">
       <select class="form-control" id="claclien" name="claclien" onChange='cargaContenidoCliente(this.value)'>
   
      
          <?php foreach($repFacturaController->getCinsp() as $cinsp){ 
              echo $cinsp;
	  }?>
      
           
	</select></div>
    
    <div class="col-md-2">
    <label>SERVICIO :</label></div>
       <div class="col-md-4">
   <select class="form-control"   id="idserv" name="idserv" >
    <option value='0'>- TODOS -</option>
  
      
            
	</select>
 </div>
 </div>
    <div class="col-md-12 form-group">
                
                  <button type="submit" class="btn btn-info pull-right">Generar</button>  
              

                 </div>
 
</form>
</div>
</div>
</section>