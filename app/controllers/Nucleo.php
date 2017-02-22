<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nucleo extends CI_Controller {

    public function __construct(){ 
		parent::__construct();
		$this->load->model('Modelo_nucleo', 'modelo'); 
		$this->load->model('Modelo_administracion', 'modelo_administracion'); 
		$this->load->model('Modelo_proyecto', 'modelo_proyecto'); 
	}

	public function index(){
		if ( $this->session->userdata( 'session' ) !== TRUE ){
			$this->login();
		} else {
			$this->dashboard();
		}
	}

	public function login(){
		$this->load->view( 'login' );
	}


	function validar_login(){
	 	$params = array();
	    parse_str($_POST['formulario'], $params);
	    
					$data['email']			=	$params['correo'];
					$data['contrasena']		=	$params['contrasena'];
					$data 				= 	$this->security->xss_clean($data);  

					$login_check = $this->modelo->check_login($data);
					
					if ( $login_check != FALSE ){

						//$usuario_historico = $this->modelo->anadir_historico_acceso($login_check[0]);

						$this->session->set_userdata('session', TRUE);
						$this->session->set_userdata('email', $data['email']);
						
						if (is_array($login_check))
							foreach ($login_check as $login_element) {
								$this->session->set_userdata('id', $login_element->id);
								$this->session->set_userdata('id_cliente_asociado', $login_element->id_cliente);
								$this->session->set_userdata('id_perfil', $login_element->id_perfil);
								$this->session->set_userdata('perfil', $login_element->perfil);
								$this->session->set_userdata('operacion', $login_element->operacion);
								//$this->session->set_userdata('sala', $login_element->sala);
								$this->session->set_userdata('sala', $login_element->sala+$login_element->id_cargo);
								$this->session->set_userdata('id_cargo', $login_element->id_cargo);
								$this->session->set_userdata('coleccion_id_operaciones', $login_element->coleccion_id_operaciones);
								$this->session->set_userdata('nombre_completo', $login_element->nombre.' '.$login_element->apellidos);
								$this->session->set_userdata('modulo', 'home');				
								$this->session->set_userdata('especial', $login_element->especial);	
								$this->session->set_userdata('id_cargo_ajuste', 1);		
								$this->session->set_userdata('creando_entorno', "0"); //
								$this->session->set_userdata('creando_proyecto', "0"); //
								$this->session->set_userdata('entorno_activo', 1);		//1 es el entorno por defecto "General"
								$this->session->set_userdata('ambito_app', 0); //1- Entorno, 2-Proyecto	

								$this->session->set_userdata('id_area', $login_element->id_cliente); //1- Entorno, 2-Proyecto	
							}

							$data['id_cargo'] = $this->session->userdata('id_cargo') ;
			              	//$status_cargo  = $this->modelo->status_cargo($data);       
			              	
			            
			              		echo TRUE;	
			            

						
					} else {
						  		echo false;	
					}

	}



	//recuperar constraseña
	function forgot(){
	    $this->load->view('recuperar_password');
	}

  function validar_recuperar_password(){
		$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');

		if ( $this->form_validation->run() == FALSE ){
			echo validation_errors('<span class="error">','</span>');
		} else {
				$data['email']		=	$this->input->post('email');
				$correo_enviar      =   $data['email'];
	            $data 				= 	$this->security->xss_clean($data);  
	    		$usuario_check 		=   $this->modelo->recuperar_contrasena($data);

		        if ( $usuario_check != FALSE ){
						$data= $usuario_check[0] ;  
						$desde = 'contacto@estrategasdigitales.com';
						$this->email->from($desde,'Sistema de administración Estrategas Digitales');
						$this->email->to($correo_enviar);
						$this->email->subject('Recuperación de contraseña del Sistema de administración Estrategas Digitales');
						$this->email->message($this->load->view('correo/envio_contrasena', $data, true));
						if ($this->email->send()) {

				  			echo TRUE;
						} else 
				  			echo false;	
	            } else {
	            	echo '<span class="error">¡Ups! tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
	            }
		}
	}		
	

function dashboard() { 
		
		$id_perfil=$this->session->userdata('id_perfil');

	    if($this->session->userdata('session') === TRUE ){
	          

	    	  $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 
	    	  $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos(); 	
	    	  //print_r($data['datos']['entornos']); die;

	    	  $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	



	    	 // print_r( $data['datos']['proyectos'] ); die;


			//comienzo "cancelaciones" para ENTORNO			  
			    	//**OJO*** aqui el PROBLEMA ES QUE VA CREANDO TABLAS VACIAS CUANDO LE DA CANCELAR EN NUEVO
		 		if ($this->session->userdata('creando_entorno') != "0") { //significa que cancelo en nuevo o editar
		 			  
		 			  $data['tabla'] =  $this->session->userdata('creando_entorno');
					  $existe            =  $this->modelo_administracion->check_existente_entorno_tabla( $data );
		         	  if ( $existe !== TRUE ){	//esto significa que salio de un nuevo que no tiene "NOMBRE" 			 
		         	  		$this->load->dbforge();
		         	  		$tabla_struct  = 'struct_'.$this->session->userdata('creando_entorno');	
					        $tabla_data  =   'data_'.$this->session->userdata('creando_entorno');	

							$this->dbforge->drop_table($tabla_struct);
							$this->dbforge->drop_table($tabla_data);

					  }
				}	  
				//que aqui siempre este en cero, para cuando de cancelar que no haya session activa
		     	 $this->session->set_userdata('creando_entorno', "0");
		    //fin de "cancelaciones"	



			//comienzo "cancelaciones" para PROYECTOS			  
			    	//**OJO*** aqui el PROBLEMA ES QUE VA CREANDO TABLAS VACIAS CUANDO LE DA CANCELAR EN NUEVO
		 		if ($this->session->userdata('creando_proyecto') != "0") { //significa que cancelo en nuevo o editar
		 			  
		 			  $data['tabla'] =  $this->session->userdata('creando_proyecto');
					  $existe            =  $this->modelo_proyecto->check_existente_proyecto_tabla( $data );
		         	  if ( $existe !== TRUE ){	//esto significa que salio de un nuevo que no tiene "NOMBRE" 			 
		         	  		$this->load->dbforge();
		         	  		$tabla_struct  = 'pstruct_'.$this->session->userdata('creando_proyecto');	
					        $tabla_data  =   'pdata_'.$this->session->userdata('creando_proyecto');	

							$this->dbforge->drop_table($tabla_struct);
							$this->dbforge->drop_table($tabla_data);

					  }
				}	  
				//que aqui siempre este en cero, para cuando de cancelar que no haya session activa
		     	 $this->session->set_userdata('creando_proyecto', "0");
		    //fin de "cancelaciones"	





			    	$id_perfil = $this->session->userdata('id_perfil');
		    			//esto era solo para los trabajadores "HOME"

			    	 $data['datos']['proyectos1'] = $this->modelo_proyecto->listado_proyectos_usuarios(); 	
	    			 $dato['proyecto'] = $data['datos']['proyectos1'];
	    			 //print_r($data['datos']['proyectos1']); die;

	            	 $dato['fechapaginador'] = date('Y-m-d', strtotime('today') ); 
	            	 $dato['fechaanterior'] = date('Y-m-d', strtotime('-1 day') ); 
	            	 

	            	 $inicio='dashboard';	
	            	 if ($dato['proyecto']!=false) { //si hay proyectos
	            	 	//print_r($dato['proyecto']); die;
	            	 	$data['datos']['proyectos_salvado']= $this->modelo_proyecto->listado_registro_usuario($dato); 	
	            	 	//print_r($data['datos']['proyectos']); die;
	            	 	$inicio='home';

	            	 }
	            	 
	            	 $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	

		          switch ($id_perfil) {    
		            case 1:		            
		            case 2:
		                $this->load->view( 'principal/'.$inicio,$data); //dashboard
		              break;
		            
		             //
		            case 3: //
		            case 4: //

		            	 
		            	 //print_r($data['datos']['proyectos']);die;
		                $this->load->view( 'principal/'.$inicio,$data);
		              break;
		          
		            default:  
		              redirect('/');
		              break;
		          }

	        }
	        else{ 
	          redirect('/');
	        }	
	        
	}


 // editar
  function cambio_entorno( $id ){
      if($this->session->userdata('session') === TRUE ){
	      $id_perfil=$this->session->userdata('id_perfil');

	      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
	      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
	            $coleccion_id_operaciones = array();
	       }   

	        $id = base64_decode($id); 
      		$this->session->set_userdata('entorno_activo', $id);
	       		


	      redirect('/');
  	  }
 }   	



 // Creación de especialista o Administrador (Nuevo Colaborador)
	function nuevo_usuario(){
    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   
			  	  $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 
				  $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos(); 	
				  $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	


            	  $data['clientes']   = $this->modelo->coger_catalogo_clientes(1);
            	  $data['cargos']   = $this->modelo->coger_catalogo_cargos();
                  $data['perfiles']   = $this->modelo->coger_catalogo_perfiles();
                  $data['operaciones'] = $this->modelo->listado_operaciones();          

          switch ($id_perfil) {    
            case 1:
                  $this->load->view( 'usuarios/crud/nuevo_usuario', $data );   
                    
              break;
            case 2:
            case 3:
            case 4:
                 if  (in_array(5, $coleccion_id_operaciones))  { 
                    $this->load->view( 'usuarios/crud/nuevo_usuario', $data );   
                 }   
              break;


            default:  
              redirect('');
              break;
          }
        }
        else{ 
          redirect('index');
        }    

	}

	function validar_nuevo_usuario(){
		if ($this->session->userdata('session') !== TRUE) {
			redirect('');
		} else {

			

			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_length[180]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_length[180]|xss_clean');
			$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules( 'telefono', 'Teléfono', 'trim|numeric|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules('id_perfil', 'Rol de usuario', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules('id_cliente', 'Cliente Asociado', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'pass_1', 'Contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'pass_2', 'Confirmación de contraseña', 'required|trim|min_length[8]|xss_clean');

			//si el usuario no es un administrador entonces q sea obligatorio asociarlo a operaciones 
      //Esto YA NO HACE FALTA
			if ($this->input->post('id_perfil')!=1) {
				//$this->form_validation->set_rules('coleccion_id_operaciones','Operaciones','required|xss_clean');
				
			}	

			if ($this->form_validation->run() === TRUE){
				if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){
					$data['email']		=	$this->input->post('email');
					$data['contrasena']		=	$this->input->post('pass_1');
					$data 				= 	$this->security->xss_clean($data);  
					$login_check = $this->modelo->check_correo_existente($data);

					if ( $login_check != FALSE ){		
						$usuario['nombre']   			= $this->input->post( 'nombre' );
						$usuario['apellidos']   		= $this->input->post( 'apellidos' );
						$usuario['email']   			= $this->input->post( 'email' );
						$usuario['contrasena']				= $this->input->post( 'pass_1' );
						$usuario['telefono']   		= $this->input->post( 'telefono' );
						$usuario['id_perfil']   		= $this->input->post( 'id_perfil' );
						$usuario['id_cliente']   		= $this->input->post( 'id_cliente' );
						$usuario['activo']   		= $this->input->post( 'activo' );
						$usuario['coleccion_id_operaciones']	=	json_encode($this->input->post('coleccion_id_operaciones'));						

						$usuario['id_cargo']   				= $this->input->post( 'id_cargo' );
						

						$usuario 						= $this->security->xss_clean( $usuario );
						$guardar 						= $this->modelo->anadir_usuario( $usuario );

						if ( $guardar !== FALSE ){

									/* enviar correo
									$dato['email']   			    = $usuario['email'];   			
									$dato['contrasena']				= $usuario['contrasena'];				


									$desde = 'contacto@estrategasdigitales.com';
									$esp_nuevo = $usuario['email'];
									$this->email->from($desde, 'Sistema de administración control de inventario');
									$this->email->to( $esp_nuevo );
									$this->email->subject('Has sido dado de alta en Sistema de administración control de inventario');
									$this->email->message( $this->load->view('correos/alta_usuario', $dato, TRUE ) );

										 */
									//if ($this->email->send()) {	
									if (true) {
										echo TRUE;
									} else {
										echo '<span class="error"><b>E01</b> - El nuevo usuario no pudo ser agregado</span>';
									}	

						} else {
							echo '<span class="error"><b>E01</b> - El nuevo usuario no pudo ser agregado</span>';
						}
					} else {
						echo '<span class="error">El <b>Correo electrónico</b> ya se encuentra asignado a una cuenta.</span>';
					}
				} else { //fin de coincidencia de contraseña if ( $login_check != FALSE ){	
					echo '<span class="error">No coinciden la Contraseña </b> y su <b>Confirmación</b> </span>';
				}
			} else {	 //fin de la validacion del formulario		
				echo validation_errors('<span class="error">','</span>');
			}
		} //fin del if de la session
	}



 function editar_usuario( $uid = '' ){

	  $id=$this->session->userdata('id');

	  if ($uid=='') {
			$uid= $id;
			$data['retorno']='';
	  }

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
      }   

      $id_perfil=$this->session->userdata('id_perfil');


	  $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 
	  $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos(); 	
	  $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	
	  

	 	$data['usuarios'] = $this->modelo->listado_usuarios(); 
	 	$data['dat_usuario']  = $this->modelo->datos_usuario( $uid );
	 	$data['uid'] = $uid;
	 	$data['dat_historico_semana']  = $this->modelo->historico_acceso_semana( $data );
	 	$data['dat_historico_mes']  = $this->modelo->historico_acceso_mes( $data );
	 


		if	( ($id_perfil==1) OR (($id_perfil!=1) and ($id==$uid) ) OR (in_array(5, $coleccion_id_operaciones)) ) {
				$data['perfiles']		= $this->modelo->coger_catalogo_perfiles();
				$data['clientes']   = $this->modelo->coger_catalogo_clientes(1);
				$data['cargos']   = $this->modelo->coger_catalogo_cargos();
				//print_r($data['cargos']);die;
				$data['usuario'] = $this->modelo->coger_catalogo_usuario( $uid );

				
				$data['operaciones'] = $this->modelo->listado_operaciones();



		        $data['id']  = $uid;
				if ( $data['usuario'] !== FALSE ){
						$this->load->view('usuarios/crud/editar_usuario',$data);
				} else {
							redirect('');
				}
		} else
		{
			 redirect('');
		}	

  		
  }



function validacion_edicion_usuario(){
		
		if ( $this->session->userdata('session') !== TRUE ) {
			redirect('/');
		} else {
			
			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_length[180]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_length[180]|xss_clean');
			$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules( 'telefono', 'Teléfono', 'trim|numeric|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules('id_perfil', 'Rol de usuario', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules('id_cliente', 'Cliente Asociado', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'pass_1', 'Contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'pass_2', 'Confirmación de contraseña', 'required|trim|min_length[8]|xss_clean');

      //si el usuario no es un administrador entonces q sea obligatorio asociarlo a operaciones 
      //Esto YA NO HACE FALTA
      if ($this->input->post('id_perfil')!=1) {
        //$this->form_validation->set_rules('coleccion_id_operaciones','Operaciones','required|xss_clean');
        
      } 


			if ( $this->form_validation->run() === TRUE ){
				if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){
					$uid 				=   $this->input->post( 'id_p' ); 
					$data['id']							= $uid;
					$data['email']		=	$this->input->post('email');
					$data 				= 	$this->security->xss_clean($data);  
					$login_check = $this->modelo->check_usuario_existente($data);
					if ( $login_check === TRUE ){
						$usuario['nombre']   					= $this->input->post( 'nombre' );
						$usuario['apellidos']   				= $this->input->post( 'apellidos' );
						$usuario['email']   					= $this->input->post( 'email' );
						$usuario['contrasena']						= $this->input->post( 'pass_1' );
						$usuario['telefono']   				= $this->input->post( 'telefono' );
						$usuario['id_perfil']   				= $this->input->post( 'id_perfil' );
						$usuario['id_cliente']   				= $this->input->post( 'id_cliente' );
						$usuario['activo']   		= $this->input->post( 'activo' );

						$usuario['coleccion_id_operaciones']	=	json_encode($this->input->post('coleccion_id_operaciones'));						

						$usuario['id_cargo']   				= $this->input->post( 'id_cargo' );
						

						
						$usuario['id']							= $uid;
						$usuario 								= $this->security->xss_clean( $usuario );
						$guardar 								= $this->modelo->edicion_usuario( $usuario );
						if ( $guardar !== FALSE ){
							echo TRUE;
						} else {
							echo '<span class="error"><b>E02</b> - La información del usuario no puedo ser actualizada no hubo cambios</span>';
						}
					} else {
						echo '<span class="error">El <b>Correo electrónico</b> ya se encuentra asignado a una cuenta.</span>';
					}
				} else {
					echo '<span class="error">La <b>Contraseña</b> y la <b>Confirmación</b> no coinciden, verificalas.</span>';
				}
			} else {			
				echo validation_errors('<span class="error">','</span>');
			}
		}
	}	
	

	function eliminar_usuario($uid = '', $nombrecompleto=''){

    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   



          switch ($id_perfil) {    
            case 1:
                      if ($uid=='') {
                          $uid= $this->session->userdata('id');
                      }   
                      $data['nombrecompleto']   = base64_decode($nombrecompleto);
                      $data['uid']        = $uid;
                      $this->load->view( 'usuarios/eliminar_usuario', $data );                
              break;
            case 2:
            case 3:
            case 4:
                 if  (in_array(5, $coleccion_id_operaciones))  { 
                      if ($uid=='') {
                          $uid= $this->session->userdata('id');
                      }   
                      $data['nombrecompleto']   = $nombrecompleto;
                      $data['uid']        = $uid;

                      $this->load->view( 'usuarios/eliminar_usuario', $data );

                 }   
              break;


            default:  
              redirect('/');
              break;
          }
        }
        else{ 
          redirect('/');
        }
		
	}


	function validar_eliminar_usuario(){
		if (!empty($_POST['uid_retorno'])){ 
			$uid = $_POST['uid_retorno'];
		}
		$eliminado = $this->modelo->borrar_usuario(  $uid );
		if ( $eliminado !== FALSE ){
			echo TRUE;
		} else {
			echo '<span class="error">No se ha podido eliminar al usuario</span>';
		}
	}

  


  function ajaxAgents(){
  		$data['uid'] = 	$this->input->post('uid');
  	 	$dato['dat_historico_mes']  = $this->modelo->historico_acceso_mes( $data );
  		//$this->load->view('usuarios/editar_usuario',$data);
  		echo json_encode($dato) ; 
  }
  	

 

	//recuperar constraseña
	function session(){
		if($this->session->userdata('session') === TRUE ){
			$data['id']=$this->session->userdata('id');
			$data['id_perfil']=$this->session->userdata('id_perfil');
			$data['perfil']=$this->session->userdata('perfil');
			$data['coleccion_id_operaciones']=$this->session->userdata('coleccion_id_operaciones');
			$data['nombre_completo']=$this->session->userdata('nombre_completo');
			$data['sala']=$this->session->userdata('sala');
			$data['exito']=true;
	    }	else {
	    	$data['exito']=false;
	    }	
		echo json_encode($data);

	}

	//lista de todos los usuarios
	function listado_usuarios(){
    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   



          switch ($id_perfil) {    
            case 1:
                  ob_start();
                  $this->paginacion_ajax_usuario(0);
                  $initial_content = ob_get_contents();
                  ob_end_clean();    
                  $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
                  $this->load->view( 'paginacion/paginacion',$data);        
                    
              break;
            case 2:
            case 3:
            case 4:
                 if  (in_array(5, $coleccion_id_operaciones))  { 
                     ob_start();
                          $this->paginacion_ajax_usuario(0);
                          $initial_content = ob_get_contents();
                          ob_end_clean();    
                          $data['table'] = "<div id='paginacion'>" . $initial_content . "</div>" ;
                          $this->load->view( 'paginacion/paginacion',$data);        
                 }   
              break;


            default:  
              redirect('/');
              break;
          }
        }
        else{ 
          redirect('/'); //index
        }
	}

	



function actualizar_perfil( $uid = '' ){

      $id=$this->session->userdata('id');

	  if ($uid=='') {
			$uid= $id;
			$data['retorno']='';
	  }

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
      }   


	  $id_perfil=$this->session->userdata('id_perfil');
		
    //Administrador con permiso a todo ($id_perfil==1)
    //usuario solo viendo su PERFIL  OR (($id_perfil!=1) and ($id==$uid) )
    //Con permisos de usuarios OR (in_array(5, $coleccion_id_operaciones)) 
		if	( ($id_perfil==1) OR (($id_perfil!=1) and ($id==$uid) ) OR (in_array(5, $coleccion_id_operaciones)) ) {
			/*
			$data['perfiles']		= $this->modelo->coger_catalogo_perfiles();
			$data['clientes']   = $this->modelo->coger_catalogo_clientes(2);
			$data['cargos']   = $this->modelo->coger_catalogo_cargos(2);
			$data['usuario'] = $this->modelo->coger_catalogo_usuario( $uid );

			
			$data['operaciones'] = $this->modelo->listado_operaciones();
			*/	

				$this->load->view('usuarios/edicion');
			/*
	        $data['id']  = $uid;
			if ( $data['usuario'] !== FALSE ){
					$this->load->view('usuarios/edicion',$data);
			} else {
						redirect('/');
			}*/
		} else
		{
			 redirect('/');
		}	
	}

	
	
	




/////////////////validaciones/////////////////////////////////////////	


	public function valid_cero($str)
	{
		return (  preg_match("/^(0)$/ix", $str)) ? FALSE : TRUE;
	}

	function nombre_valido( $str ){
		 $regex = "/^([A-Za-z ñáéíóúÑÁÉÍÓÚ]{2,60})$/i";
		//if ( ! preg_match( '/^[A-Za-zÁÉÍÓÚáéíóúÑñ \s]/', $str ) ){
		if ( ! preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'nombre_valido','<b class="requerido">*</b> La información introducida en <b>%s</b> no es válida.' );
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function valid_phone( $str ){
		if ( $str ) {
			if ( ! preg_match( '/\([0-9]\)| |[0-9]/', $str ) ){
				$this->form_validation->set_message( 'valid_phone', '<b class="requerido">*</b> El <b>%s</b> no tiene un formato válido.' );
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	function valid_option( $str ){
		if ($str == 0) {
			$this->form_validation->set_message('valid_option', '<b class="requerido">*</b> Es necesario que selecciones una <b>%s</b>.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function valid_date( $str ){

		$arr = explode('-', $str);
		if ( count($arr) == 3 ){
			$d = $arr[0];
			$m = $arr[1];
			$y = $arr[2];
			if ( is_numeric( $m ) && is_numeric( $d ) && is_numeric( $y ) ){
				return checkdate($m, $d, $y);
			} else {
				$this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD-MM-YYYY.');
				return FALSE;
			}
		} else {
			$this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD/MM/YYYY.');
			return FALSE;
		}
	}

	public function valid_email($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}

////////////////////////////////////////////////////////////////
	//salida del sistema
	public function logout(){
		$this->session->sess_destroy();
		redirect('/');
	}		



}
