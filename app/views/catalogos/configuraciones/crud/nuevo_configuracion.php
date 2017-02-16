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

						<?php //$this->load->view( 'catalogos/configuraciones/detalle_configuracion'); ?>
			 
			 

			<?php 
			 	if (!isset($retorno)) {
			      	$retorno ="configuraciones";
			    }
			    $funcion ="validar_nuevo_configuracion";
			 $attr = array('funcion'=>$funcion, 'class' => 'form-horizontal', 'id'=>'form_configuraciones','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
			 echo form_open($funcion, $attr);
			?>		

			
<div class="" style="background-configuracion:transparent !important">
					<br>	
				
				<div class="col-md-10 col-md-offset-1 row" style="background-configuracion:transparent !important">
					<div class="panel panel-primary">
						<div class="panel-heading">Datos de configuracion</div>
						
						<div class="panel-body">
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label for="configuracion" class="col-sm-3 col-md-2 control-label">Nombre</label>
									<div class="col-sm-9 col-md-10">
										<input type="text" class="form-control ttip" title="Ingresar un nuevo configuración." id="configuracion" name="configuracion" placeholder="Nombre del configuración">
										<em>Nombre personalizado del configuración.</em>
									</div>
								</div>
							</div>

	 						<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<label for="valor" class="col-sm-3 col-md-2 control-label">Valor</label>
										<div class="col-sm-9 col-md-10">
											<input type="text" class="form-control ttip" title="Valor config" id="valor" name="valor" placeholder="Valor config">
											<em>Valor de configuración para ajustes generales.</em>
										</div>
									</div>

							
								<!--Checkbox -->	
										
										<div class="mt-checkbox-list">
											<label class="mt-checkbox">
								                <input type="checkbox" value="1" name="activo"> Activo
								                <span></span>
								            </label> 

										</div>

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
