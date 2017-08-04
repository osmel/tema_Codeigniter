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

						<?php //$this->load->view( 'catalogos/gastos/detalle_gasto'); ?>
			 
			 

			<?php 
			 	if (!isset($retorno)) {
			      	$retorno ="gastos";
			    }
			    $funcion ="validar_nuevo_gasto";
			 $attr = array('funcion'=>$funcion, 'class' => 'form-horizontal', 'id'=>'form_catalogos','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
			 echo form_open($funcion, $attr);
			?>		

			
			<div class="" style="background-gasto:transparent !important">
					<br>	
				
				<div class="col-md-10 col-md-offset-1 row" style="background-gasto:transparent !important">
					<div class="panel panel-primary">
						<div class="panel-heading">Dato de Categoría</div>
						
						<div class="panel-body">
							

							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label for="nombre" class="col-sm-3 col-md-2 control-label">Categoría</label>
									<div class="col-sm-9 col-md-10">
										<input type="text" class="form-control ttip" title="Ingresar una nueva categoría." id="nombre" name="nombre" placeholder="Nombre del categoría">
										<em>Nombre personalizado de categoría.</em>
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
