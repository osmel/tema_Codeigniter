<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' , $datos ); ?>
<style type="text/css">
	td.details-control {
	    background: url('../img/details_open.png') no-repeat center center;
	    cursor: pointer;
	}
	tr.shown td.details-control {
	    background: url('../img/details_close.png') no-repeat center center;
	}

</style>

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
		<div class="row">      
			<div class="col-md-12 form-horizontal" id="tab_filtro">      
						
						<h4>Filtros</h4>	
						<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-2">
							<div class="form-group">
								<label class="col-sm-12 col-md-12">Cambiar Status</label>
								<div class="col-sm-12 col-md-12">
									<button id="horas_pesos"  type="button" class="horas_pesos btn btn-danger btn-block ttip" title="Mostrar Horas/Pesos">Horas</button>	
								</div>
							</div>							
							<hr/>					
						</div>												
						</div>	

						

						<div id="fecha_id" class="col-xs-12 col-sm-6 col-md-3">
								<label id="label_proveedor" for="descripcion" class="col-sm-12 col-md-12">Rango de fecha</label>
								<div class="input-prepend input-group  form-group" style="padding-left:15px !important;padding-right:15px !important;">
		                       		<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									<input id="foco" type="text" name="permisos" tipo="horas_personas" class="form-control col-sm-12 col-md-12 fecha_reporte ttip" title="Seleccione un rango de fechas para filtrar los resultados." value="" format = "DD-MM-YYYY"/> 
								</div>	
		                </div>

						<div id="estatus_id" class="col-xs-12 col-sm-6 col-md-3">
							<div class="form-group">
								<label for="proyecto" class="col-sm-12 col-md-12">Proyecto</label>
								<div class="col-sm-12 col-md-12">
									<select name="id_proyecto" id="id_proyecto" class="form-control ttip" title="Seleccione la proyecto a consultar."
									 dependencia="">

											<option value="-1">Todos</option>
											<?php if ( $datos['proyectos']) { ?>
											<?php foreach ( $datos['proyectos'] as $proyecto ){ ?>
													<option value="<?php echo $proyecto->id; ?>"><?php echo $proyecto->proyecto; ?></option>
											<?php } } ?>
									</select>
								</div>
							</div>
						</div>	

						<div id="estatus_id" class="col-xs-12 col-sm-6 col-md-2">
							<div class="form-group">
								<label for="estructura" class="col-sm-12 col-md-12">Niveles</label>
								<div class="col-sm-12 col-md-12">
									<select name="id_profundidad" id="id_profundidad" class="form-control ttip" title="Seleccione la estructura a consultar."
									dependencia="">
											<option value="-1">Todos</option>
											
											
									</select>
								</div>
							</div>
						</div>	

						<div id="estatus_id" class="col-xs-12 col-sm-6 col-md-2">
							<div class="form-group">
								<label for="area" class="col-sm-12 col-md-12">Área</label>
								<div class="col-sm-12 col-md-12">
									<select name="id_area" id="id_area" class="form-control ttip" title="Seleccione la area a consultar."
									dependencia="">
											<option value="-1">Todos</option>
											
									</select>
								</div>
							</div>
						</div>	



						<div id="estatus_id" class="col-xs-12 col-sm-6 col-md-2">
							<div class="form-group">
								<label for="persona" class="col-sm-12 col-md-12">Usuarios</label>
								<div class="col-sm-12 col-md-12">
									<select name="id_usuario" id="id_usuario" class="form-control ttip" title="Seleccione la persona a consultar."
									dependencia="">
											<option value="-1">Todos</option>
											
									</select>
								</div>
							</div>
						</div>							
			

						<br>
						<div class="col-md-12">
							<div class="table-responsive">

								<section>
									<table id="tabla_rep_horas_personas" class="display table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
										<thead>
											<tr>
												
												
											</tr>
										</thead>
									</table>
								</section>
							</div>
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