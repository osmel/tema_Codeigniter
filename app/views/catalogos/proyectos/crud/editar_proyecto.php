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

						<?php //$this->load->view( 'catalogos/proyectos/detalle_proyecto'); ?>
			 
			 
<?php 

 	if (!isset($retorno)) {
      	$retorno =""; //proyectos
    }

  $hidden = array('id'=>$id);
  $attr = array('class' => 'form-horizontal', 'id'=>'form_nuevo_proyectos','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
  echo form_open('validacion_edicion_proyecto', $attr,$hidden);
?>	

<input type="hidden" id="crea_multiple_simple" name="crea_multiple_simple" value="<?php echo $crea_multiple_simple; ?>">
<input type="hidden" id="depth_arbol" name="depth_arbol" value="<?php echo $depth_arbol; ?>">
<input type="hidden" id="ambito_app" name="ambito_app" value="<?php echo $ambito_app; ?>">
<input type="hidden" id="id_proy" name="id_proy" value="<?php echo $proyecto->id_proy; ?>">
<input type="hidden" id="dueno" name="dueno" value="<?php echo $proyecto->dueno; ?>">


<div class="container">
		<br>
	<div class="row">
		<div class="col-sm-8 col-md-8"><h4>Edición de proyecto</h4></div>
	</div>
	<br>
	<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Datos de proyecto</div>
			<div class="panel-body">
				<div class="col-sm-6 col-md-6">
					<div class="form-group">
						<label for="proyecto" class="col-sm-3 col-md-2 control-label">proyecto</label>
						<div class="col-sm-9 col-md-10">
							<?php 
								$nomb_nom='';
								if (isset($proyecto ->proyecto )) 
								 {	$nomb_nom = $proyecto ->proyecto ;}
							?>
							<input value="<?php echo  set_value('proyecto',$nomb_nom); ?>" type="text" class="form-control ttip" title="Ingresar un nuevo proyecto." name="proyecto" placeholder="proyecto">
							<em>Nombre personalizado del proyecto.</em>
						</div>
					</div>


							<div class="form-group">
								<label for="descripcion" class="col-sm-3 col-md-2 control-label">Descripción</label>
                                   <div class="col-sm-9 col-md-10">
	                                   <?php 
											$nomb_nom='';
											if (isset($proyecto ->descripcion )) 
											 {	$nomb_nom = $proyecto ->descripcion ;}
										?>
                                        <textarea id="descripcion" name="descripcion" class="form-control" rows="3"><?php echo  set_value('descripcion',$nomb_nom); ?></textarea>
                                    </div>
							</div>

							<!--Privacidad -->	
							<div class="form-group">
                                <label>Privacidad</label>
                                <div class="mt-radio-list">
                                    <label class="mt-radio mt-radio-outline"> Público
										  <?php   
				                                if ($proyecto->privacidad==1) {$marca='checked';} else {$marca='';}
				                          ?>                                    
                                        <input <?php echo (($proyecto->privacidad==1) ? 'checked' :'' ); ?> type="radio" value="1" name="privacidad" checked>
                                        <span></span>
                                    </label>
                                    <label class="mt-radio mt-radio-outline"> Privado
                                        <input <?php echo (($proyecto->privacidad==2) ? 'checked' :'' ); ?> type="radio" value="2" name="privacidad">
                                        <span></span>
                                    </label>
                                </div>
                            </div>

							
							<div class="form-group">
								<label for="costo" class="col-sm-3 col-md-2 control-label">Costo</label>
								<div class="col-sm-9 col-md-10">
								  		<?php 
											$nomb_nom='';
											if (isset($proyecto ->costo )) 
											 {	$nomb_nom = $proyecto ->costo ;}
										?>
									<input value="<?php echo  set_value('costo',$nomb_nom); ?>" restriccion="decimal" type="text" class="form-control ttip" title="Números y puntos decimales." id="costo" name="costo" placeholder="0.00">

									<em>Costo del proyecto.</em>
								</div>
							</div>	

						  <div class="etiquetas_usuarios objeto_como_tags">
						          <h3>Participantes</h3>
						          <p>
						            Personas que participaran en el proyecto
						          </p>
						          <div class="bs-etiquetas_usuarios">
						            	
						          <input id="etiq_usuarios" type="text"  />
						          </div>
						   </div>	


				</div>



				<div class="col-sm-6 col-md-6">
								

									<div class="form-group">
										<label for="fecha_creacion" class="col-sm-12 col-md-12">Fecha de creación:<span class="obligatorio"> *</span></label>
										<div class="col-sm-12 col-md-12">
											<?php 
												$nomb_nom='';
												if (isset($proyecto ->fecha_creacion )) 
												 {	$nomb_nom = $proyecto ->fecha_creacion ;}
											?>
											<fieldset disabled>
												<input value="<?php echo  set_value('fecha_creacion',$nomb_nom); ?>" type="text" class="fecha  input-sm form-control" id="fecha_creacion" name="fecha_creacion" placeholder="DD-MM-YYYY">
											<fieldset disabled>	
												
										</div>
									</div>

									<div class="form-group">
										<label for="fecha_inicial" class="col-sm-12 col-md-12">Fecha Inicial:<span class="obligatorio"> *</span></label>
										<div class="col-sm-12 col-md-12">

											<?php 
												$nomb_nom='';
												if (strtotime(($proyecto ->fecha_inicial )>0)) 
												 {	$nomb_nom = $proyecto ->fecha_inicial ;}
											?>
											<input value="<?php echo  set_value('fecha_inicial',$nomb_nom); ?>" type="text" class="fecha  input-sm form-control" id="fecha_inicial" name="fecha_inicial" placeholder="DD-MM-YYYY">
												
										</div>
									</div>

									<div class="form-group">
										<label for="fecha_final" class="col-sm-12 col-md-12">Fecha Final:<span class="obligatorio"> *</span></label>
										<div class="col-sm-12 col-md-12">
											<?php 
												$nomb_nom='';
												if (strtotime(($proyecto ->fecha_final )>0))  
												 {	$nomb_nom = $proyecto ->fecha_final ;}
											?>
											<input value="<?php echo  set_value('fecha_final',$nomb_nom); ?>" type="text" class="fecha  input-sm form-control" id="fecha_final" name="fecha_final" placeholder="DD-MM-YYYY">
												
										</div>
									</div>


									<!--Checkbox -->	

								<div class="form-group">
								    <label>Otros...</label>				
										
										<div class="mt-checkbox-list">
											<label class="mt-checkbox">
						 						  <?php   
						                                if ($proyecto->contrato_firmado==1) {$marca='checked';} else {$marca='';}
						                          ?>
								                <input <?php echo $marca; ?> type="checkbox" value="1" name="contrato_firmado"> Contrato firmado
								                <span></span>
								            </label> 
											<label class="mt-checkbox">
												  <?php   
						                                if ($proyecto->pago_anticipado==1) {$marca='checked';} else {$marca='';}
						                          ?>

								                <input <?php echo $marca; ?> type="checkbox" value="1" name="pago_anticipado"> Pago anticipado
								                <span></span>
								            </label> 
											<label class="mt-checkbox">
						 						  <?php   
						                                if ($proyecto->factura_enviada==1) {$marca='checked';} else {$marca='';}
						                          ?>

								                <input <?php echo $marca; ?> type="checkbox" value="1" name="factura_enviada"> Factura enviada
								                <span></span>
								            </label> 

										</div>
								</div>		



				</div>



				<div class="col-sm-12 col-md-12">
					<h3>Defina las tareas a realizar</h3>
					<input type="text" value=""  id="buscar" placeholder="Buscar..." />
					<div id="tree" nombre="">  </div>
					<div id="data">
						<div class="content default" style="text-align:center;">Seleccione un nodo desde el arbol.</div>
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
