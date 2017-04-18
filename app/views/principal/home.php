<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' , $datos ); ?>
<style type="text/css">
	
	.pagina-contenido{
		min-height:  !important;
	}

	.dp-item-lg {
		     padding: 0px 0!important; 
	}
</style>


            <!-- Comienzo del contenedor -->
	            <div class="page-container">
	                
	                <!--Menu Izquierdo-->	
	            		<?php $this->load->view( 'menu_izquierdo',$datos ); ?>	
	            	<!--Fin menu Izquierdo-->	

	                <!--Contenido de la pagina osmel-->
		                <div class="page-content-wrapper">
		                	<div class="page-content" >
									<?php $this->load->view( 'navegacion' ); ?>




			<?php 
			 	if (!isset($retorno)) {
			      	$retorno ="";
			    }
			    $funcion ="validar_registro_usuario";
			 $attr = array('funcion'=>$funcion, 'class' => 'form-horizontal', 'id'=>'form_registro_usuario','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
			 echo form_open($funcion, $attr);
			 $total=0;
			?>		

			
						
<div class="" style="background-entorno:transparent !important">
					<br>	
				<div class="row">
				<div class="col-md-10 col-md-offset-1" style="background-color:transparent !important">
					<div class="panel panel-primary">
						<div class="panel-heading">Datos de entorno</div>
							

						<div class="panel-body">


								<div class="row">
									  <div class="col-md-10 col-md-offset-1">	<!-- Centrar -->								
											
				                            <fieldset disabled>
				                            	<div id="fecha_paginador"> </div>
				                            </fieldset>	

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



							 <?php foreach ($datos["proyectos_salvado"] as $key => $proyecto) { ?>
								<div class="row">
									  <div class="col-md-10 col-md-offset-1">	<!-- Centrar -->					<!--
									  texto+='<input restriccion="decimal" value="'+row[4]+'" identificador="'+row[0]+'" type="text" class="form-control ttip cantidad_um" title="Números y puntos decimales."  placeholder="0.00">';							
										Proyecto con checkbox
									  -->			
											<div class="col-sm-3 col-md-3">
												<label class="mt-checkbox">
									                <input class="contrato_firmado<?php echo $key; ?>" type="checkbox" value="1" name="contrato_firmado[]">
									                	<as class="ttip" title="<?php echo $proyecto->ruta;?>"><?php echo $proyecto->proyecto;?></as>
									                 
									                <h6 class="help-block" style="color:#666;" id="<?php echo $key; ?>"><?php echo 
									                substr( $proyecto->ruta , 0, strpos( $proyecto->ruta, "/") );
									                ?> </h6> 
									            </label> 
											</div>


											<!-- id del registro_user_proy -->			
											<input type="hidden" class="id_user_proy<?php echo $key; ?>" name="id_user_proy[]" value="<?php echo ( ( isset($proyecto->reg_user->id)) ? $proyecto->reg_user->id : null) ; ?>">

											<!-- id del registro_user_proy -->			
											<input type="hidden" class="id_proyecto<?php echo $key; ?>"  name="id_proyecto[]" value="<?php echo ( ( isset($proyecto->id_proyecto)) ? $proyecto->id_proyecto : null) ; ?>">

											<input type="hidden" class="id_nivel<?php echo $key; ?>"  name="id_nivel[]" value="<?php echo ( ( isset($proyecto->id_nivel)) ? $proyecto->id_nivel : null) ; ?>">

											<input type="hidden" class="profundidad<?php echo $key; ?>"  name="profundidad[]" value="<?php echo ( ( isset($proyecto->profundidad)) ? $proyecto->profundidad : null) ; ?>">

											<input type="hidden" class="identificador<?php echo $key; ?>"  name="identificador[]" value="<?php echo ( ( isset($proyecto->id)) ? $proyecto->id : null) ; ?>">

											<!-- id del registro_user_proy -->			
											<input type="hidden" class="id_entorno<?php echo $key; ?>" name="id_entorno[]" value="<?php echo ( ( isset($proyecto->id_activo)) ? $proyecto->id_activo : null) ; ?>">

											<!-- hr_anterior -->			
											<div class="col-sm-2 col-md-2">
											   <fieldset disabled>
													<div class="col-sm-12 col-md-12">
														<input type="text"  title="Ingresar un nuevo proyecto." class=" form-control ttip hr_anterior<?php echo $key; ?>" name="hr_anterior[]" placeholder=""  value="<?php echo ( ( isset($proyecto->anterior->hr_anterior)) ? $proyecto->anterior->hr_anterior : '0') ; ?>">
														<!--<em>Anterior.</em>-->
													</div>
												</fieldset>
											</div>

											
											<!-- hora -->			
											<div class="col-sm-2 col-md-2">
												<div class="col-sm-12 col-md-12">
													<input restriccion="decimal" type="text" id="hora<?php echo $key; ?>" name="hora[]" placeholder="" value="<?php echo ( ( isset($proyecto->reg_user->horas)) ? $proyecto->reg_user->horas : '0') ; ?>" title="Números y puntos decimales." class=" form-control ttip hora_decimal hora<?php echo $key; ?>" name="hora[]" placeholder="" value="<?php echo ( ( isset($proyecto->reg_user->horas)) ? $proyecto->reg_user->horas : '0') ; ?>"> 
													
												</div>
											</div>

											<!-- descripción -->			
											<div class="col-sm-5 col-md-5">
												<div class="col-sm-12 col-md-12">
													<textarea  class="descripcion<?php echo $key; ?>"  name="descripcion[]" class="form-control" rows="1"><?php echo ( ( isset($proyecto->reg_user->descripcion)) ? $proyecto->reg_user->descripcion : '') ; ?></textarea>
													<!-- <em>Nota actual para el proyecto.</em> -->
												</div>
											</div>
									</div>		
								</div>
								<br/>
								
								<?php if ( isset($proyecto->reg_user->horas)) {$total = $total+$proyecto->reg_user->horas;} ?>  	
							   <?php } ?>  	

							   <div class="col-sm-2 col-md-2 col-md-offset-4">
												<h3>Total:</h3>
							  </div>
							  <div class="col-sm-1 col-md-1">
												<h3 id="total"><?php echo number_format($total, 2, '.', ','); ?>  	</h3>
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