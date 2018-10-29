<script>
<!--
$("document").ready(function(){
	var op=$("#formareac").val();
alert(op);
	if(op=="C")
	{	$("#tipocatalogo").toggle(true);
	    $(".tiponum").toggle(false);
	} 
	else if(op=="N")
	{	$("#tipocatalogo").toggle(false);
	    $(".tiponum").toggle(true);
	} else {
	$("#tipocatalogo").hide();
    $(".tiponum").hide();}
});
$(function(){
$("#formareac").change(function(){
	
var op=this.value;

if(op=="C")
{	$("#tipocatalogo").toggle('slow');
    $(".tiponum").toggle(false);
} 
else if(op=="N")
{	$("#tipocatalogo").toggle(false);
    $(".tiponum").toggle(true);
} else {
	$("#tipocatalogo").toggle(false);
    $(".tiponum").toggle(false);
}
});

$("#estandar").click(function() {
	  alert( "Handler for .change() called." );
	});
});
//-->
</script>
<!-- Content Header (Page header) -->

    <section class="content-header">
      <h1> ACTUALIZA CARACTERISTICA ESTANDAR</h1>
      
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
              <form role="form" method="post" onsubmit="return validar(this)">
                  <?php
                      $registro = New EstandarController();     
                      $registro->editaEstandarDetController();
                    ?>

                <!-- Datos alta de cuenta -->
         
                


                 <!-- Pie de formulario -->
                 <div class="box-footer col-md-12">
                  <?php
                 $registro = New EstandarController();
                  $registro->botonRegresaEdEstDetController() ?>
                  <button type="submit" class="btn btn-info pull-right">Guardar</button>  
                  <?php
                 $registro = New EstandarController();     
                 $registro-> actualizaEstandarDetalleController();  
                // $registro->botonRegresaabdetController() ?>

                 </div>

              </form>
        </div>
	    </div>
	    </div>


	  
   <script type='text/javascript'>         
function validar(form) {
  if((form.desesp.value=='')){
    alert("Por favor, escribe la descripcion en espanol");
    form.desesp.focus();
    form.desesp.select();
    return false;
  }else if(form.desing.value==''){
    alert("Por favor, escribe la descripcion en ingles");
    form.desing.focus();
    form.desing.select();
    return false;
  }else if(form.pon.value==''){
    alert("Por favor, escribe la Ponderacion");
    form.pon.focus();
    form.pon.select();
    return false;
  }else if(isNaN(form.pon.value)){
    alert("Por favor, escribe un porcentaje de Ponderacion válido");
    form.pon.focus();
    form.pon.select();
    return false;
  }else if(form.lugarsyd.value!=''){ 
    if(isNaN(form.lugarsyd.value)){
    alert("Por favor, escribe un Lugar en Survey Data correcto");
    form.lugarsyd.focus();
    form.lugarsyd.select();
    return false;
  }}else
    //Si el codigo llega hasta aquí, todo estará bien  y realizamos el Submit
    return true;
}
</script>
 <script src="js/jquery.cascading-drop-down.js"></script>

    <script>

    $('.cascada').ssdCascadingDropDown({

        nonFinalCallback: function(trigger, props, data, self) {



            trigger.closest('form')

                    .find('input[type="submit"]')

                    .attr('disabled', true);



        },

        finalCallback: function(trigger, props, data) {



            if (props.isValueEmpty()) {

                trigger.closest('form')

                        .find('input[type="submit"]')

                        .attr('disabled', true);

            } else {

                trigger.closest('form')

                        .find('input[type="submit"]')

                        .attr('disabled', false);

            }



        }

    });

</script>
  

  </div>
  
