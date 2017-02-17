<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header', $datos ); ?>

 
 

	<!-- Comienzo del contenedor -->
	<div class="page-container">
	    
	    <!--Menu Izquierdo-->	
			<?php $this->load->view( 'menu_izquierdo',$datos ); ?>	
		<!--Fin menu Izquierdo-->	

	    <!--Contenido de la pagina -->
	        <div class="page-content-wrapper">
	        	<div class="page-content">
						<?php $this->load->view( 'navegacion' ); ?>

			 
			 
<?php 

 	if (!isset($retorno)) {
      	$retorno ="areas";
    }

  $hidden = array('id'=>$id);
  $attr = array('class' => 'form-horizontal', 'id'=>'form_catalogos','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
  echo form_open('validacion_edicion_area', $attr,$hidden);
?>	


<div class="container">
		<br>
	<div class="row">
		<div class="col-sm-8 col-md-8"><h4>Edición de area</h4></div>
	</div>
	<br>
	<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Datos de area</div>
			<div class="panel-body">
				<div class="col-sm-6 col-md-6">
					<div class="form-group">
						<label for="area" class="col-sm-3 col-md-2 control-label">area</label>
						<div class="col-sm-9 col-md-10">
							<?php 
								$nomb_nom='';
								if (isset($area ->area )) 
								 {	$nomb_nom = $area ->area ;}
							?>
							<input value="<?php echo  set_value('area',$nomb_nom); ?>" type="text" class="form-control ttip" title="Ingresar un nuevo area." name="area" placeholder="area">
						</div>
					</div>

				</div>



			    <div class="col-sm-6 col-md-6">
					<div class="form-group">
						<label for="monto" class="col-sm-3 col-md-2 control-label">Monto</label>
						<div class="col-sm-9 col-md-10">
							<?php 
								$nomb_nom='';
								if (isset($area->monto )) 
								 {	$nomb_nom = $area->monto ;}
							?>
							<input value="<?php echo  set_value('monto',$nomb_nom); ?>" type="text" class="form-control ttip" title="Monto de área." id="monto" name="monto" placeholder="Monto de área">
							<em>Monto total del área.</em>
						</div>
					</div>

					<div class="form-group">
						<label for="telefono" class="col-sm-3 col-md-2 control-label">Télefono</label>
						<div class="col-sm-9 col-md-10">
							<?php 
								$nomb_nom='';
								if (isset($area->telefono )) 
								 {	$nomb_nom = $area->telefono ;}
							?>
							<input value="<?php echo  set_value('telefono',$nomb_nom); ?>" type="text" class="form-control ttip" title="telefono de teléfono." id="telefono" name="telefono" placeholder="Teléfono de teléfono">
							<em>Teléfono total del teléfono.</em>
						</div>
					</div>



				</div>					


			</div>
		</div>
		
		

		<div class="row">
			<div class="col-sm-4 col-md-4"></div>
			<div class="col-sm-4 col-md-4 marginbuttom">
				<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" type="button" class="btn btn-danger btn-block">Cancelar</a>
			</div>
			<div class="col-sm-4 col-md-4">
				<input type="submit" class="btn btn-success btn-block" value="Guardar"/>
			</div>
		</div>
		<br>
		
	</div></div>
  <?php echo form_close(); ?>







	        	</div>
	        </div>
	    <!--Fin Contenido de la pagina-->
	    	
	    <!-- Barra lateral rapida de menu "que esta en esquina derecha superior"-->
	    	<?php $this->load->view( 'barra_lateral_rapida_menu' ); ?>
	    <!-- Fin Barra lateral rapida de menu "que esta en esquina derecha superior"-->

	</div>
<!-- Fin del Contenedor -->



<?php $this->load->view( 'footer' ); ?>
