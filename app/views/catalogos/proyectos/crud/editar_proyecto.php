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

				   

			 $funcion = "validacion_edicion_nivel";	
			 //$hidden = array('id'=>$proy_salvado->id_proyecto);			    
			 $hidden = array('id'=>$id);
			 				    
			 $attr = array('funcion'=>$funcion, 'class' => 'form-horizontal', 'id'=>'form_nuevo_proyectos','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
			 echo form_open($funcion, $attr,$hidden);
  
			?>	
			 

<input type="hidden" id="crea_multiple_simple" name="crea_multiple_simple" value="<?php echo $crea_multiple_simple; ?>">
<input type="hidden" id="depth_arbol" name="depth_arbol" value="<?php echo $depth_arbol; ?>">
<input type="hidden" id="ambito_app" name="ambito_app" value="<?php echo $ambito_app; ?>">

<input type="hidden" id="profundidad" name="profundidad" value="1">
<input type="hidden" id="id_nivel" name="id_nivel" value="1">


<input type="hidden" id="dueno" name="dueno" value="<?php echo $proy_salvado->dueno; ?>">
<!-- <input type="hidden" id="dueno" name="dueno" value="1"> -->
<input type="hidden" id="id_proy" name="id_proy" value="<?php echo $proy_salvado->id_proy; ?>"> 

<input type="hidden" id="nombre" name="nombre" value="">

<input type="hidden" id="id_scroll_proy" name="id_scroll_proy" value="<?php echo $id; ?>">



			
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
					                                        <div class="caption col-md-12">
					                                            <i class="icon-equalizer font-dark hide"></i>


					                                            <div class="col-md-4">	
					                                              	<span class="caption-subject font-dark bold uppercase">Proyecto</span>

					                                            </div>

																<div class="col-md-4">
																	
																		<span class="caption-subject font-dark bold uppercase">Creación</span>

					                                            </div>

																<div class="col-md-4">
																	
																		<span class="caption-subject font-dark bold uppercase">Costo Proyecto</span>

					                                            </div>


					                                        </div>
					                                    </div>
					                                     		<div class="col-md-4">	
					                                               <?php 
																			$nomb_nom='';
																			if (isset($proy_salvado ->proyecto )) 
																			 {	$nomb_nom = $proy_salvado ->proyecto ;}
																		?>

																		<fieldset disabled>
																			<input value="<?php echo  set_value('proyecto',$nomb_nom); ?>"  type="text" class="form-control" title="Ingresar un nuevo proyecto." id="proyecto" name="proyecto" placeholder="Nombre del proyecto">
																		</fieldset>	

					                                            </div>

																<div class="col-md-4">
																	<?php 
																			$nomb_nom=date("d-m-Y"); 
																			if (isset($proy_salvado ->fecha_creacion )) 
																			 {	$nomb_nom = $proy_salvado ->fecha_creacion ;}
																		?>
																		<fieldset disabled>
																			<input value="<?php echo  set_value('fecha_creacion',$nomb_nom); ?>" type="text" class="fecha  form-control" id="fecha_creacion" name="fecha_creacion" placeholder="DD-MM-YYYY">
																		</fieldset>	
					                                            </div>

					                                     		<div class="col-md-4">	
					                                               <?php 
																			$nomb_nom='0.00';
																			if (isset($proy_salvado ->importe )) 
																			 {	$nomb_nom = $proy_salvado ->importe ;}
																		?>

																		<fieldset>
																			<input value="<?php echo  set_value('importe',$nomb_nom); ?>"  restriccion="decimal" type="text" class="form-control ttip" title="Números y puntos decimales."  id="importe" name="importe" placeholder="0.00">
																		</fieldset>	


					                                            </div>
					                                            <div class="col-md-12"> Presupuesto Disponible: <span class="presupuesto_disponible"></span>	</div>
					                                            




					                                    <div class="portlet-body">

													
														<h3>Defina las tareas a realizar</h3>
														<input type="text" value=""  id="buscar" placeholder="Buscar..." />
														<div style="font-size:20px;" id="tree" nombre="">  </div> 
														<div id="data">
															<div class="content default" style="text-align:center;">Seleccione un nodo desde el arbol.</div>
														</div>

															

				
					
				

				



					                                    </div>

					                                </div>    



	                                            	

                                            	</div>
												
										

                                            	<!-- cuadrante2-->          
												
												<div class="col-sm-6 col-md-6" id="cuadrante2">
													<div class="portlet light bordered">
					                                    <div class="portlet-title">
					                                        <div class="caption">
					                                            <i class="icon-equalizer font-dark hide"></i>
					                                            <span class="caption-subject font-dark bold uppercase">Detalles</span>
					                                            <span class="caption-helper"></span>
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

					                                     		<!--participantes -->	
																<div class="etiquetas_usuarios objeto_como_tags">
															          <h3>Participantes</h3>
															          <p>
															            Personas que participaran en el proyecto
															          </p>
															          <div class="bs-etiquetas_usuarios">
															            	<input id="etiq_usuarios" type="text" />
															          </div>
															    </div>
																

															    <!--descripcion -->
																<div class="form-group">
																	<label for="descripcion" class="col-sm-3 col-md-2 control-label">Descripción</label>
																	<?php 
																		$nomb_nom='';
																		if (isset($proy_salvado ->descripcion )) 
																		 {	$nomb_nom = $proy_salvado ->descripcion ;}
																	?>
								                                       <div class="col-sm-12 col-md-12">
								                                            <textarea id="descripcion" name="descripcion" class="form-control" rows="3"><?php echo  set_value('descripcion',$nomb_nom); ?></textarea>
								                                        </div>
																</div>

																<!--costo -->
																<div class="form-group" style="display:none;">
																	
																	<!--costo -->
																	<div class="col-sm-3 col-md-3">
																			<?php 
																				$nomb_nom='';
																				if (isset($costo ->costo )) 
																				 {	$nomb_nom = $costo ->costo ;}
																			?>
																		<input value="<?php echo  set_value('costo',$nomb_nom); ?>" restriccion="decimal" type="text" class="form-control ttip" title="Números y puntos decimales." id="costo" name="costo" placeholder="0.00">

																		<em>Costo del proyecto.</em>
																	</div>
																	
																	<!--tiempo planificado -->
																	<div class="col-sm-3 col-md-3">
																			<?php 
																				$nomb_nom='';
																				if (isset($costo ->tiempo_disponible )) 
																				 {	$nomb_nom = $costo ->tiempo_disponible ;}
																			?>
																		<input value="<?php echo  set_value('tiempo_disponible',$nomb_nom); ?>" restriccion="decimal" type="text" class="form-control ttip" title="Números y puntos decimales." id="tiempo_disponible" name="tiempo_disponible" placeholder="0.00">

																		<em>Tiempo disponible.</em>
																	</div>

																	<!--fecha inicial -->
																	<div class="col-sm-3 col-md-3">
																		<?php 
																			$nomb_nom='';
																			if (isset($costo ->fecha_inicial )) 
																			if (strtotime($costo ->fecha_inicial )>0) 
																			 {	$nomb_nom = $costo ->fecha_inicial ;}
																			
																		?>
																		<input value="<?php echo  set_value('fecha_inicial',$nomb_nom); ?>" type="text" class="fecha  input-sm form-control" id="fecha_inicial" name="fecha_inicial" placeholder="DD-MM-YYYY">
																		<em>Fecha Inicial.</em>
																			
																	</div>		

																	<!--fecha final -->

																	<div class="col-sm-3 col-md-3">
																		<?php 
																			$nomb_nom='';
																			if (isset($costo ->fecha_final )) 
																			if (strtotime($costo ->fecha_final )>0)  
																			 {	$nomb_nom = $costo ->fecha_final ;}
																			
																		?>
																		<input value="<?php echo  set_value('fecha_final',$nomb_nom); ?>" type="text" class="fecha  input-sm form-control" id="fecha_final" name="fecha_final" placeholder="DD-MM-YYYY">
																		<em>Fecha Final.</em>
																	</div>	

																</div>	



						                                </div>    
													</div>	
	                                            </div>

                                            </div>



 											<!-- Pestaña Ficha Tecnica-->          
                                            <div class="tab-pane fade" id="tab_1_2">
                                            			<!-- cuadrante3-->              
                                            		<div class="col-sm-6 col-md-6" id="cuadrante3"></div>

                                            		<!-- cuadrante4-->          
													<div class="col-sm-6 col-md-6" id="cuadrante4"></div>
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

