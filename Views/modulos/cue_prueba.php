
		<?php
		include "Controllers/pruebaController.php";
		$pruebaController = new PruebaController ();

		$pruebaController->vistaListaPruebas();

		?>

<section class="content-header">

	<h1>TIPO DE AGUA</h1>
<ol class="breadcrumb">
            <?php Navegacion::desplegarNavegacion();?>
  </ol>  
</section>

<!-- Main content -->

<section class="content container-fluid">
	<!----- Inicia contenido ----->



<?php

$i = 1;
$bac = 1;
foreach ( $pruebaController->getListaPruebas () as $seccion ) {

	if (($i - 1) % 3 == 0) {
		echo '<div class="row">';
		$bac = 0;
	}
	?>
<div class="col-md-4">

			<div class="box box-info">

				<div class="box-header with-border">

					<h3 class="box-title">NO. <?php echo $i?></h3>

					<div class="box-tools pull-right">

						<button type="button" class="btn btn-box-tool"
							data-widget="collapse">
							<i class="fa fa-minus"></i>

						</button>



					</div>

					<!-- /.box-tools -->

				</div>

				<!-- /.box-header -->

				<div class="box-body">

					<div class="row col-sm-12">
						<div class="arrow">
							<div class="box-footer no-padding">

								<ul class="nav nav-stacked">
									<li><a>SERVICIO : <strong><?php echo $seccion["ser_claveservicio"]?></strong></a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="row col-sm-12">

						<div class="arrow">

							<div class="box-footer no-padding">

								<ul class="nav nav-stacked">

									<li><a >SECCION: <strong><?php echo $seccion["sec_numseccion"]?></strong></a></li>

								</ul>

							</div>

						</div>
					</div>
					<div class="row col-sm-12">

						<div class="arrow">

							<div class="box-footer no-padding">

								<ul class="nav nav-stacked">

									<li><a>COMPONENTE: <strong><?php echo $seccion["re_descripcionesp"]?></strong></a></li>

								</ul>

							</div>

						</div>
					</div>
					<div class="row">
<div class="col-sm-4 border-right">

							<div class="description-block">
								
							</div>

							<!-- /.description-block -->
						</div>

						<div class="col-sm-4">

							<div class="description-block">
								<a class="btn btn-block btn-info"
									style="font-size: 12px"
									href="index.php?action=listapruebasdet&id=<?php echo $seccion["re_numcomponente"]."&serv=".$seccion["ser_claveservicio"]?>">
											DETALLE</a> 
							
							</div>

							<!-- /.description-block -->
						</div>
						<div class="col-sm-4">

							<div class="description-block">
								
							</div>

							<!-- /.description-block -->
						</div>
						

					<!-- /.col -->

				</div>



			</div>

			<!-- /.box-body -->

		</div>

	</div>

<?php
if(($i)%3==0){
	
	echo '</div>';
	$bac=1;
}
$i++;
} //fin foreach?>



	<!-- /.box -->

</section>
