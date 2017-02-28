<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' , $datos ); ?>

<?php
 	if (!isset($retorno)) {
      	$retorno ="/";
    }
?>   

            <!-- Comienzo del contenedor -->
	            <div class="page-container">
	                
	                <!--Menu Izquierdo-->	
	            		<?php $this->load->view( 'menu_izquierdo',$datos ); ?>	
	            	<!--Fin menu Izquierdo-->	

	                <!--Contenido de la pagina -->
		                <div class="page-content-wrapper">
		                	<div class="page-content">
									<?php //$this->load->view( 'navegacion' ); ?>












		<!-- Aqui comienza filtro	-->

				<div class="col-md-12 form-horizontal" id="tab_filtro">      
						
						<h4>Filtros</h4>	
						<hr style="padding: 0px; margin: 15px;"/>					

						<div id="fecha_id" class="col-xs-12 col-sm-6 col-md-3">
								<label id="label_proveedor" for="descripcion" class="col-sm-12 col-md-12">Rango de fecha</label>
								<div class="input-prepend input-group  form-group" style="padding-left:15px !important;padding-right:15px !important;">
		                       		<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									<input id="foco" type="text" name="permisos"  class="form-control col-sm-12 col-md-12 fecha_reporte ttip" title="Seleccione un rango de fechas para filtrar los resultados." value="" format = "DD-MM-YYYY"/> 
								</div>	
		                </div>

						<div id="estatus_id" class="col-xs-12 col-sm-6 col-md-2">
							<div class="form-group">
								<label for="estructura" class="col-sm-12 col-md-12">Estructura</label>
								<div class="col-sm-12 col-md-12">
									<select name="id_estructura" id="id_estructura" class="form-control ttip" title="Seleccione la estructura a consultar.">
											<?php if ( $estructuras) ?>
											<?php foreach ( $estructuras as $estructura ){ ?>
													<option value="<?php echo $estructura->id; ?>"><?php echo $estructura->nombre; ?></option>
											<?php } ?>
									</select>
								</div>
							</div>
						</div>	


						<div id="estatus_id" class="col-xs-12 col-sm-6 col-md-3">
							<div class="form-group">
								<label for="proyecto" class="col-sm-12 col-md-12">Proyecto</label>
								<div class="col-sm-12 col-md-12">
									<select name="id_proyecto" id="id_proyecto" class="form-control ttip" title="Seleccione la proyecto a consultar.">
											<?php if ( $proyectos) ?>
											<?php foreach ( $proyectos as $proyecto ){ ?>
													<option value="<?php echo $proyecto->id; ?>"><?php echo $proyecto->nombre; ?></option>
											<?php } ?>
									</select>
								</div>
							</div>
						</div>	



						<div id="estatus_id" class="col-xs-12 col-sm-6 col-md-2">
							<div class="form-group">
								<label for="persona" class="col-sm-12 col-md-12">persona</label>
								<div class="col-sm-12 col-md-12">
									<select name="id_persona" id="id_persona" class="form-control ttip" title="Seleccione la persona a consultar.">
											<?php if ( $personas) ?>
											<?php foreach ( $personas as $persona ){ ?>
													<option value="<?php echo $persona->id; ?>"><?php echo $persona->nombre; ?></option>
											<?php } ?>
									</select>
								</div>
							</div>
						</div>	

						<div id="estatus_id" class="col-xs-12 col-sm-6 col-md-2">
							<div class="form-group">
								<label for="area" class="col-sm-12 col-md-12">Área</label>
								<div class="col-sm-12 col-md-12">
									<select name="id_area" id="id_area" class="form-control ttip" title="Seleccione la area a consultar.">
											<?php if ( $areas) ?>
											<?php foreach ( $areas as $area ){ ?>
													<option value="<?php echo $area->id; ?>"><?php echo $area->nombre; ?></option>
											<?php } ?>
									</select>
								</div>
							</div>
						</div>	
			

			<br>
			<div class="col-md-12">
				<div class="table-responsive">

					<section>
						<table id="tabla_rep_general" class="display table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th class="text-center cursora" width="22%">Nombre</th>
									<th class="text-center cursora" width="22%">Usuarios</th>
									
									<th class="text-center cursora" width="8%">26</th>
									<th class="text-center cursora" width="8%">27</th>
									<th class="text-center cursora" width="8%">28</th>
									<!--
									<th class="text-center cursora" width="8%">4</th>
									<th class="text-center cursora" width="8%">5</th>
									<th class="text-center cursora" width="8%">6</th>
									<th class="text-center cursora" width="8%">7</th>
									-->
									

									
								</tr>
							</thead>
						</table>
					</section>
				</div>
			</div>



		            
				</div>

<!-- Hasta aqui el filtro	-->




		
		
			













		                	</div>
		                </div>
	                <!--Fin Contenido de la pagina-->
	                	
	                <!-- Barra lateral rapida de menu "que esta en esquina derecha superior"-->
	                	<?php $this->load->view( 'barra_lateral_rapida_menu' ); ?>
	                <!-- Fin Barra lateral rapida de menu "que esta en esquina derecha superior"-->

	            </div>
            <!-- Fin del Contenedor -->

<?php $this->load->view( 'footer' ); ?>