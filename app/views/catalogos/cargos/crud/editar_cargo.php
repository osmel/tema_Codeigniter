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
      	$retorno ="cargos";
    }

  $hidden = array('id'=>$id);
  $attr = array('class' => 'form-horizontal', 'id'=>'form_catalogos','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
  echo form_open('validacion_edicion_cargo', $attr,$hidden);
?>	


<div class="container">
		<br>
	<div class="row">
		<div class="col-sm-8 col-md-8"><h4>Edición de cargo</h4></div>
	</div>
	<br>
	<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Datos de cargo</div>
			<div class="panel-body">
				<div class="col-sm-6 col-md-6">
					<div class="form-group">
						<label for="cargo" class="col-sm-3 col-md-2 control-label">cargo</label>
						<div class="col-sm-9 col-md-10">
							<?php 
								$nomb_nom='';
								if (isset($cargo ->cargo )) 
								 {	$nomb_nom = $cargo ->cargo ;}
							?>
							<input value="<?php echo  set_value('cargo',$nomb_nom); ?>" type="text" class="form-control ttip" title="Ingresar un nuevo cargo." name="cargo" placeholder="cargo">
						</div>
					</div>




						<!--Checkbox -->	
							
							<div class="mt-checkbox-list">
								<label class="mt-checkbox">
									  <?php   
			                                if ($cargo->lider==1) {$marca='checked';} else {$marca='';}
			                          ?>
					                <input <?php echo $marca; ?> type="checkbox" value="1" name="lider">Lider
					                <span></span>
					            </label> 
								<label class="mt-checkbox">
									  <?php   
			                                if ($cargo->activo==1) {$marca='checked';} else {$marca='';}
			                          ?>
					                <input <?php echo $marca; ?> type="checkbox" value="1" name="activo"> Activo
					                <span></span>
					            </label> 

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
