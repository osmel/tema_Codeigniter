<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' , $datos ); ?>
	

			<input type="hidden" id="uid" name="uid" value="<?php echo $uid; ?>">		


            <!-- Comienzo del contenedor -->
	            <div class="page-container">
	                
	                <!--Menu Izquierdo-->	
	            		<?php $this->load->view( 'menu_izquierdo' ); ?>	
	            	<!--Fin menu Izquierdo-->	

	                <!--Contenido de la pagina -->
		                <div class="page-content-wrapper">
		                	<div class="page-content">
									<?php $this->load->view( 'navegacion' ); ?>
									<?php //$this->load->view( 'usuarios/crud/editar_usuario'); ?>








					<?php 
					 	
					 	if (!isset($retorno)) {
					      	$retorno ="";
					    }

					  $hidden = array('id_p'=>$id);

						  $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 


						  if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) )  {
						  			$coleccion_id_operaciones = array();
						  } 	


					  //$attr = array('class' => 'form-horizontal', 'id'=>'form_usuarios','name'=>'form_editar','method'=>'POST','autocomplete'=>'off','role'=>'form');
					  //echo form_open('validacion_edicion_usuario', $attr,$hidden);

					 $hidden = array('id_p'=>$id);
					 $attr = array( 'id' => 'form_usuarios','name'=>$retorno, 'class' => 'form-horizontal', 'method' => 'POST', 'autocomplete' => 'off', 'role' => 'form' );
					 echo form_open('validacion_edicion_usuario', $attr,$hidden);


					?>
					<div class="container">
						<div class="row">
							<div class="col-sm-8 col-md-8"><h4>Edición de Usuario</h4></div>
						</div>
						<br>
						<div class="container row">
							<div class="panel panel-primary">
								<div class="panel-heading">Datos del Usuario</div>
								<div class="panel-body">
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label for="nombre" class="col-sm-3 col-md-2 control-label">Nombre</label>
											<div class="col-sm-9 col-md-10">
												<?php 
													$nomb_nom='';
													if (isset($usuario->nombre)) 
													 {	$nomb_nom = $usuario->nombre;}
												?>
												<input value="<?php echo  set_value('nombre',$nomb_nom); ?>" type="text" class="form-control" name="nombre" placeholder="Nombre">
											</div>
										</div>
										<div class="form-group">
											<label for="apellidos" class="col-sm-3 col-md-2 control-label">Apellido(s)</label>
											<div class="col-sm-9 col-md-10">
												<?php 
													$nomb_nom='';
													if (isset($usuario->apellidos)) 
													 {	$nomb_nom = $usuario->apellidos;}
												?>
												<input value="<?php echo  set_value('apellidos',$nomb_nom); ?>" type="text" class="form-control" name="apellidos" placeholder="Apellido (s)">
											</div>
										</div>
										<div class="form-group">
											<label for="email" class="col-sm-3 col-md-2 control-label">Email</label>
											<div class="col-sm-9 col-md-10">
												<?php 
													$nomb_nom='';
													if (isset($usuario->email)) 
													 {	$nomb_nom = $usuario->email;}
												?>
												<input value="<?php echo  set_value('email',$nomb_nom); ?>" type="text" class="form-control" name="email" placeholder="Email">
											</div>
										</div>
										<div class="form-group">
											<label for="telefono" class="col-sm-3 col-md-2 control-label">Número Teléfono</label>
											<div class="col-sm-9 col-md-10">
												<?php 
													$nomb_nom='';
													if (isset($usuario->telefono)) 
													 {	$nomb_nom = $usuario->telefono;}
												?>
												<input value="<?php echo  set_value('telefono',$nomb_nom); ?>" type="text" class="form-control" name="telefono" placeholder="Número Teléfono">
											</div>
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label for="pass_1" class="col-sm-3 col-md-2 control-label">Contraseña</label>
											<div class="col-sm-9 col-md-10">
												<?php 
													$nomb_nom='';
													if (isset($usuario->contrasena)) 
													 {	$nomb_nom = $usuario->contrasena;}
												?>
												<input value="<?php echo  set_value('pass_1',$nomb_nom); ?>" type="password" class="form-control" name="pass_1" placeholder="Contraseña">
											</div>
										</div>
										<div class="form-group">
											<label for="pass_2" class="col-sm-3 col-md-2 control-label">Confirmar Contraseña</label>
											<div class="col-sm-9 col-md-10">
												<?php 
													$nomb_nom='';
													if (isset($usuario->contrasena)) 
													 {	$nomb_nom = $usuario->contrasena;}
												?>
												<input value="<?php echo  set_value('pass_2',$nomb_nom); ?>" type="password" class="form-control" name="pass_2" placeholder="Contraseña">
												
											</div>
										</div>

										<div class="form-group">
											<label for="id_perfil" class="col-sm-3 col-md-2 control-label">Rol de usuario</label>
											<div class="col-sm-9 col-md-10">
											<?php  if ( $this->session->userdata( 'id_perfil' ) != 1 ){ ?>											
												<fieldset disabled>

													<?php if ( $this->session->userdata( 'id_perfil' ) != 1 ){ ?>		
														<select disabled="disabled" name="id_perfil" id="id_perfil" class="form-control">
													<?php } else { ?>	
														<select  name="id_perfil" id="id_perfil" class="form-control">
													<?php } ?>	

														<?php foreach ( $perfiles as $perfil ){ ?>
															<?php 
															   if  ($perfil->id_perfil==$usuario->id_perfil)
																 {$seleccionado='selected';} else {$seleccionado='';}
															?>

																 <option value="<?php echo $perfil->id_perfil; ?>" <?php echo $seleccionado; ?> ><?php echo $perfil->perfil; ?></option>
																	



														<?php } ?>
													</select>
												</fieldset>		
										    <?php } elseif ( $this->session->userdata( 'id_perfil' ) == 1 ){ ?>											
													

													<?php if ( $this->session->userdata( 'id_perfil' ) != 1 ){ ?>		
														<select disabled="disabled" name="id_perfil" id="id_perfil" class="form-control">
													<?php } else { ?>	
														<select name="id_perfil" id="id_perfil" class="form-control">
													<?php } ?>	

														<?php foreach ( $perfiles as $perfil ){ ?>
															<?php 
															   if  ($perfil->id_perfil==$usuario->id_perfil)
																 {$seleccionado='selected';} else {$seleccionado='';}
															?>
																<option value="<?php echo $perfil->id_perfil; ?>" <?php echo $seleccionado; ?> ><?php echo $perfil->perfil; ?></option>

														<?php } ?>
													</select>
										    <?php } ?>									    
											</div>
										</div>


										<!--Cliente Asociado -->
										<div class="form-group">
											<label for="id_cliente" class="col-sm-3 col-md-2 control-label">Áreas</label>
											<div class="col-sm-9 col-md-10">
											<?php  if ( $this->session->userdata( 'id_perfil' ) != 1 ){ ?>											
												<fieldset disabled>

													<?php if ( $this->session->userdata( 'id_perfil' ) != 1 ){ ?>		
														<select disabled="disabled" name="id_cliente" id="id_cliente" class="form-control">
													<?php } else { ?>	
														<select name="id_cliente" id="id_cliente" class="form-control">
													<?php } ?>	

														<?php foreach ( $clientes as $cliente ){ ?>
															<?php 
															   if  ($cliente->id_cliente==$usuario->id_cliente)
																 {$seleccionado='selected';} else {$seleccionado='';}
															?>

																	<option value="<?php echo $cliente->id_cliente; ?>" <?php echo $seleccionado; ?> ><?php echo $cliente->cliente; ?></option>


														<?php } ?>
													</select>
												</fieldset>		

										    <?php } elseif ( $this->session->userdata( 'id_perfil' ) == 1 ){ ?>											
													

													<?php if ( $this->session->userdata( 'id_perfil' ) != 1 ){ ?>		
														<select disabled="disabled" name="id_cliente" id="id_cliente" class="form-control">
													<?php } else { ?>	
														<select name="id_cliente" id="id_cliente" class="form-control">
													<?php } ?>	

														<?php foreach ( $clientes as $cliente ){ ?>
															<?php 
															   if  ($cliente->id_cliente==$usuario->id_cliente)
																 {$seleccionado='selected';} else {$seleccionado='';}
															?>
															
																	<option value="<?php echo $cliente->id_cliente; ?>" <?php echo $seleccionado; ?> ><?php echo $cliente->cliente; ?></option>
															

														<?php } ?>
													</select>
										    <?php } ?>									    
										    
											</div>
										</div>		




										<!--cargo Asociado -->
										<div id="rol_cargo" style="display:block;" class="form-group">
											<label for="id_cargo" class="col-sm-3 col-md-2 control-label">Cargo</label>
											<div class="col-sm-9 col-md-10">

											    <?php if ( ( $this->session->userdata( 'id_perfil' ) == 1  ) || (in_array(5, $coleccion_id_operaciones)) ) { ?>
														<select name="id_cargo" id="id_cargo" class="form-control">
												<?php } else { ?>	
													    <select disabled="disabled" name="id_cargo" id="id_cargo" class="form-control">
												<?php } ?>	
															<!--<option value="0">Selecciona una opción</option>-->
																<?php foreach ( $cargos as $cargo ){ ?>
																		<?php 
																		   if  ($cargo->id_cargo==$usuario->id_cargo)
																			 {$seleccionado='selected';} else {$seleccionado='';}
																		?>
																			<option value="<?php echo $cargo->id_cargo; ?>" <?php echo $seleccionado; ?> ><?php echo $cargo->cargo; ?></option>
																<?php } ?>
															<!--rol de usuario -->
														</select>
											</div>
										</div>
									</div>
								</div>
							</div>



							<br>

							<!--SOLO LOS USUARIOS ADMINISTRADORES TENDRAN PERMISO DE OPERACIONES -->	
							<?php if ( $this->session->userdata( 'id_perfil' ) != 1 ){ ?>		
								<fieldset disabled>
							<?php } ?>		
								<div id="rol_perfil" style="display:block;" class="container row">
									<div class="panel panel-primary">
										<div class="panel-heading">Permisos de operaciones</div>
										<div class="panel-body">
										  <div class="col-sm-12 col-md-12">
											<?php
											$colab_id_array =(json_decode($usuario->coleccion_id_operaciones) );				
											if (count($colab_id_array)==0) {  //si el valor esta vacio
												$colab_id_array = array();
											}
											if (!($colab_id_array)) {
												$colab_id_array = array();	
											}
											
											?>

											<?php $grupo=''; 
												foreach ($operaciones as $operacion){ ?>
												<?php 

													if ($grupo!=$operacion->grupo) {
														//echo '<hr> <b>'.$operacion->grupo.'</b><br/>'; 	
															

														$grupo=$operacion->grupo; 	
													}
												?>						
												<div class="checkbox">
													<label for="coleccion_id_operaciones" class="ttip" title="<?php echo $operacion->tooltip; ?>">
																<?php		
																   if (in_array($operacion->id, $colab_id_array)) {$marca='checked';} else {$marca='';}
																?>
																	<?php if ( $this->session->userdata( 'id_perfil' ) != 1 ){ ?>		
																		<input disabled type="checkbox"  value="<?php echo $operacion->id; ?>" name="coleccion_id_operaciones[]" <?php echo $marca; ?>>
																	<?php } else { ?>	
																		<input type="checkbox"  value="<?php echo $operacion->id; ?>" name="coleccion_id_operaciones[]" <?php echo $marca; ?>>
																	<?php } ?>	
															<?php echo $operacion->operacion; ?> 
													</label>
												</div>
											<?php } ?>
										  </div>	
										</div>
									</div>
								</div>		
							<?php if ( $this->session->userdata( 'id_perfil' ) != 1 ){ ?>		
								</fieldset>
							<?php } ?>		
							

							<div class="row">
								<div class="col-sm-4 col-md-4"></div>
								<div class="col-sm-4 col-md-4 marginbuttom">
									<a href="<?php echo base_url().$retorno; ?>" type="button" class="btn btn-danger btn-block">Cancelar</a>
								</div>
								<div class="col-sm-4 col-md-4">
									<input  type="submit" class="btn btn-success btn-block" value="Guardar"/>
								</div>
							</div>
							<br>		
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