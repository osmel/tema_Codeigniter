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

						<?php //$this->load->view( 'catalogos/entornos/detalle_entorno'); ?>
			 
			 
<?php 

 	if (!isset($retorno)) {
      	$retorno ="entornos";
    }

  $hidden = array('id'=>$id);
  $attr = array('class' => 'form-horizontal', 'id'=>'form_entornos','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
  echo form_open('validacion_edicion_entorno', $attr,$hidden);
?>	

<input type="hidden" id="crea_multiple_simple" name="crea_multiple_simple" value="<?php echo $crea_multiple_simple; ?>">
<input type="hidden" id="depth_arbol" name="depth_arbol" value="<?php echo $depth_arbol; ?>">
<input type="hidden" id="ambito_app" name="ambito_app" value="<?php echo $ambito_app; ?>">

<div class="container">
		<br>
	<div class="row">
		<div class="col-sm-8 col-md-8"><h4>Edición de entorno</h4></div>
	</div>
	<br>
	<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Datos de entorno</div>
			<div class="panel-body">
				<div class="col-sm-6 col-md-6">
					<div class="form-group">
						<label for="entorno" class="col-sm-3 col-md-2 control-label">entorno</label>
						<div class="col-sm-9 col-md-10">
							<?php 
								$nomb_nom='';
								if (isset($entorno ->entorno )) 
								 {	$nomb_nom = $entorno ->entorno ;}
							?>
							<input value="<?php echo  set_value('entorno',$nomb_nom); ?>" type="text" class="form-control ttip" title="Ingresar un nuevo entorno." name="entorno" placeholder="entorno">
						</div>
					</div>

				</div>

				<div class="col-sm-6 col-md-6">
					<input type="text" value=""  id="buscar" placeholder="Buscar..." />
				</div>


				

				<div id="tree" nombre="">  </div> <!--<?php echo $entorno->tabla;?> -->


				<div id="data">
					<div class="content default" style="text-align:center;">Select a node from the tree.</div>
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
