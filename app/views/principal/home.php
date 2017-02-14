<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' , $datos ); ?>

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
			      	$retorno ="entornos";
			    }
			    $funcion ="validar_nuevo_entorno";
			 $attr = array('funcion'=>$funcion, 'class' => 'form-horizontal', 'id'=>'form_entornos','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
			 echo form_open($funcion, $attr);
			?>		

			
						
			<div class="container" style="background-entorno:transparent !important">
					<br>	
				
				<div class="container row" style="background-entorno:transparent !important">
					<div class="panel panel-primary">
						<div class="panel-heading">Datos de entorno</div>
						
						<div class="panel-body">


								<div class="row">
									  <div class="col-md-10 col-md-offset-1">	<!-- Centrar -->								
											<div class="col-sm-3 col-md-3">
									             <h3>Proyectos</h3>
											</div>

											<div class="col-sm-2 col-md-2">
												<h3>Anterior</h3>
											</div>

											<div class="col-sm-2 col-md-2">
												<h3>Horas</h3>
											</div>

											<div class="col-sm-5 col-md-5">
												<h3>Comentarios</h3>
											</div>
									</div>		
								</div>


							 <?php foreach ($datos["proyectos"] as $proyecto) { ?>
								<div class="row">
									  <div class="col-md-10 col-md-offset-1">	<!-- Centrar -->								
											<div class="col-sm-3 col-md-3">
												<label class="mt-checkbox">
									                <input type="checkbox" value="1" name="contrato_firmado">
									                	<?php echo $proyecto->proyecto?>
									                <span></span>
									            </label> 
											</div>

											<div class="col-sm-2 col-md-2">
												<div class="col-sm-12 col-md-12">
													<input type="text" class="form-control ttip" title="Ingresar un nuevo proyecto." id="hr_anterior" name="hr_anterior" placeholder="">
													<!--<em>Anterior.</em>-->
												</div>
											</div>

											<div class="col-sm-2 col-md-2">
												<div class="col-sm-12 col-md-12">
													<input type="text" class="form-control ttip" title="Ingresar un nuevo proyecto." id="hora" name="hora" placeholder="">
													<!-- <em>Horas.</em> -->
												</div>
											</div>

											<div class="col-sm-5 col-md-5">
												<div class="col-sm-12 col-md-12">
													<textarea id="descripcion" name="descripcion" class="form-control" rows="1"></textarea>
													<!-- <em>Nota actual para el proyecto.</em> -->
												</div>
											</div>
									</div>		
								</div>
								<br/>
							   <?php } ?>  	

							   <div class="col-sm-2 col-md-2 col-md-offset-4">
												<h3>Total:</h3>
							  </div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4 col-md-4"></div>
						<div class="col-sm-4 col-md-4 marginbuttom">
							<a href="<?php echo base_url().$retorno; ?>" type="button" class="btn btn-danger btn-block">Cancelar</a>
						</div>
						<div class="col-sm-4 col-md-4">
							<input type="submit" class="btn btn-success btn-block" value="Guardar"/>
						</div>
					</div>
				</div>
			</div>

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