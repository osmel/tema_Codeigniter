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

						<?php //$this->load->view( 'catalogos/proyectos/detalle_proyecto'); ?>
			 
			 

			<?php 
			 	if (!isset($retorno)) {
			      	$retorno ="";
			    }

			    if (isset($proy_salvado->id_proyecto )) {
			    	$funcion = "validacion_edicion_proyecto";	
			    	$hidden = array('id'=>$proy_salvado->id_proyecto);
			    } else {
			    	$funcion = "validar_nuevo_proyecto";	
			    	$hidden = array('id'=>0);
			    }
			    
			 				    
			 $attr = array('funcion'=>$funcion, 'class' => 'form-horizontal', 'id'=>'form_nuevo_proyectos','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
			 echo form_open($funcion, $attr,$hidden);
  
			?>		

<input type="hidden" id="crea_multiple_simple" name="crea_multiple_simple" value="<?php echo $crea_multiple_simple; ?>">
<input type="hidden" id="depth_arbol" name="depth_arbol" value="<?php echo $depth_arbol; ?>">
<input type="hidden" id="ambito_app" name="ambito_app" value="<?php echo $ambito_app; ?>">
<input type="hidden" id="dueno" name="dueno" value="1">

<?php 
$nomb_nom='';
if (isset($proy_salvado ->id_proy )) 
 {	$nomb_nom = $proy_salvado ->id_proy ;}
?>
<input value="<?php echo  set_value('id_proy',$nomb_nom); ?>" type="hidden" id="id_proy" name="id_proy" >



			
			<div class="container" style="background-proyecto:transparent !important">
					<br>	
				
		<div class="container row" style="background-proyecto:transparent !important">
			<div class="panel panel-primary">
				<div class="panel-heading">Datos de proyecto</div>
				
				<div class="panel-body">

  						<div class="col-md-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-body">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab"> Crear </a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_2" data-toggle="tab"> Ficha Técnica </a>
                                            </li>
                                           
                                        </ul>

                                        
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_1_1">
			                                                
                                            	<div class="col-sm-6 col-md-6" id="cuadrante1">

													<div class="portlet light bordered">
					                                    <div class="portlet-title">
					                                        <div class="caption">
					                                            <i class="icon-equalizer font-dark hide"></i>
					                                            <span class="caption-subject font-dark bold uppercase">
																	
																		<?php 
																			$nomb_nom='Proyectos_'.$nombre;
																			if (isset($proy_salvado ->proyecto )) 
																			 {	$nomb_nom = $proy_salvado ->proyecto ;}
																		?>
																		<fieldset disabled>
																		<input value="<?php echo  set_value('proyecto',$nomb_nom); ?>"  type="text" class="form-control ttip" title="Ingresar un nuevo proyecto." id="proyecto" name="proyecto" placeholder="Nombre del proyecto">
																		</fieldset>	

					                                            Proyecto
																	<?php 
																		$nomb_nom=date("d-m-Y"); 
																		if (isset($proy_salvado ->fecha_creacion )) 
																		 {	$nomb_nom = $proy_salvado ->fecha_creacion ;}
																	?>
																	<fieldset disabled>
																		<input value="<?php echo  set_value('fecha_creacion',$nomb_nom); ?>" type="text" class="fecha  input-sm form-control" id="fecha_creacion" name="fecha_creacion" placeholder="DD-MM-YYYY">
																	</fieldset>	

					                                            </span>
					                                        </div>
					                                    </div>

					                                    <div class="portlet-body">

															
																<h3>Defina las tareas a realizar</h3>
																<input type="text" value=""  id="buscar" placeholder="Buscar..." />
																<div style="font-size:20px;" id="tree" nombre="<?php echo $nombre;?>">  </div>
																<div id="data">
																	<div class="content default" style="text-align:center;">Seleccione un nodo desde el arbol.</div>
																</div>

															

					                                    </div>

					                                </div>    



	                                            	

                                            	</div>
												
												<div class="col-sm-6 col-md-6" id="cuadrante2">

													<div class="portlet light bordered">
					                                    <div class="portlet-title">
					                                        <div class="caption">
					                                            <i class="icon-equalizer font-dark hide"></i>
					                                            <span class="caption-subject font-dark bold uppercase">Detalles</span>
					                                            <span class="caption-helper">xxxx...</span>
					                                        </div>
					                                        <div class="tools">
					                                            <!--
					                                            <a href="" class="collapse" data-original-title="" title=""> </a>
					                                            <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
					                                            <a href="" class="reload" data-original-title="" title=""> </a> -->
					                                            <a href="" class="eliminar" data-original-title="" title=""> </a>
					                                        </div>
					                                    </div>

					                                     <div class="portlet-body">
																<div class="etiquetas_usuarios objeto_como_tags">
															          <h3>Participantes</h3>
															          <p>
															            Personas que participaran en el proyecto
															          </p>
															          <div class="bs-etiquetas_usuarios">
															            	<input id="etiq_usuarios" type="text" />
															          </div>
															    </div>
																

																<div class="form-group">
																	<label for="descripcion" class="col-sm-3 col-md-2 control-label">Descripción</label>
																	<?php 
																		$nomb_nom='';
																		if (isset($proy_salvado ->descripcion )) 
																		 {	$nomb_nom = $proy_salvado ->descripcion ;}
																	?>
								                                       <div class="col-sm-9 col-md-10">
								                                            <textarea id="descripcion" name="descripcion" class="form-control" rows="3"><?php echo  set_value('descripcion',$nomb_nom); ?></textarea>
								                                        </div>
																</div>
														</div>	


					                                </div>    
													
														
												</div>	

                                            </div>
                                            <div class="tab-pane fade" id="tab_1_2">
                                                
                                            		<div class="col-sm-6 col-md-6" id="cuadrante3">


															<!--Privacidad -->	
															<div class="form-group">
							                                    <label>Privacidad</label>
							                                    <div class="mt-radio-list">
								  									<label class="mt-radio mt-radio-outline"> Público

								                                        <?php  
																		  		$marca='checked';
																		  		if (isset($proy_salvado ->privacidad )) 	 
												                                if ($proy_salvado->privacidad==1) {$marca='checked';} else {$marca='';}
												                          ?>

														                <input <?php echo $marca; ?>  type="radio" value="1" name="privacidad">
								                                        <span></span>
								                                    </label>
								                                    <label class="mt-radio mt-radio-outline"> Privado
								                                    	<?php  

																		  		$marca='';
																		  		if (isset($proy_salvado ->privacidad )) 	 
												                                if ($proy_salvado->privacidad==2) {$marca='checked';} 
												                          ?>

								                                        <input <?php echo $marca; ?> type="radio" value="2" name="privacidad">
								                                        <span></span>
								                                    </label>
							                                    </div>
							                                </div>

															
															<div class="form-group">
																<label for="costo" class="col-sm-3 col-md-2 control-label">Costo</label>
																<div class="col-sm-9 col-md-10">
																		<?php 
																			$nomb_nom='';
																			if (isset($proy_salvado ->costo )) 
																			 {	$nomb_nom = $proy_salvado ->costo ;}
																		?>
																	<input value="<?php echo  set_value('costo',$nomb_nom); ?>" restriccion="decimal" type="text" class="form-control ttip" title="Números y puntos decimales." id="costo" name="costo" placeholder="0.00">

																	<em>Costo del proyecto.</em>
																</div>
															</div>	


                                            		</div>


													<div class="col-sm-6 col-md-6" id="cuadrante4">
														


															

															<div class="form-group">
																<label for="fecha_inicial" class="col-sm-12 col-md-12">Fecha Inicial:<span class="obligatorio"> *</span></label>
																<div class="col-sm-12 col-md-12">
																	<?php 
																		$nomb_nom='';
																		if (isset($proy_salvado ->fecha_inicial )) 
																		if (strtotime($proy_salvado ->fecha_inicial )>0) 
																		 {	$nomb_nom = $proy_salvado ->fecha_inicial ;}
																		
																	?>
																	<input value="<?php echo  set_value('fecha_inicial',$nomb_nom); ?>" type="text" class="fecha  input-sm form-control" id="fecha_inicial" name="fecha_inicial" placeholder="DD-MM-YYYY">
																		
																</div>
															</div>

															<div class="form-group">
																<label for="fecha_final" class="col-sm-12 col-md-12">Fecha Final:<span class="obligatorio"> *</span></label>
																<div class="col-sm-12 col-md-12">
																	<?php 
																		$nomb_nom='';
																		if (isset($proy_salvado ->fecha_final )) 
																		if (strtotime($proy_salvado ->fecha_final )>0)  
																		 {	$nomb_nom = $proy_salvado ->fecha_final ;}
																		
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
												 						  		$marca='';
												 						  		if (isset($proy_salvado ->contrato_firmado )) 	
												                                if ($proy_salvado->contrato_firmado==1) {$marca='checked';} 
												                          ?>
														                <input <?php echo $marca; ?> type="checkbox" value="1" name="contrato_firmado"> Contrato firmado
														                <span></span>
														            </label> 
																	<label class="mt-checkbox">
																		  <?php  
																		  		$marca='';
																		  		if (isset($proy_salvado ->pago_anticipado )) 	 
												                                if ($proy_salvado->pago_anticipado==1) {$marca='checked';} 
												                          ?>

														                <input <?php echo $marca; ?> type="checkbox" value="1" name="pago_anticipado"> Pago anticipado
														                <span></span>
														            </label> 
																	<label class="mt-checkbox">
												 						  <?php   
												 						  		$marca='';
												 						  		if (isset($proy_salvado ->factura_enviada )) 	 
												                                if ($proy_salvado->factura_enviada==1) {$marca='checked';} 
												                          ?>

														                <input <?php echo $marca; ?> type="checkbox" value="1" name="factura_enviada"> Factura enviada
														                <span></span>
														            </label> 

																</div>
														</div>		



													</div>




                                            </div>
                                        </div>
                                        <div class="clearfix margin-bottom-20"> </div>
                                </div>
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
