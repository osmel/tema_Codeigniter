<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nucleo extends CI_Controller {


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
			$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules( 'contrasena', 'Contraseña', 'required|trim|min_length[8]|xss_clean');

			echo true;
/*
			if ( $this->form_validation->run() == FALSE ){
					echo validation_errors('<span class="error">','</span>');
				} else {
					$data['email']		=	$this->input->post('email');
					$data['contrasena']		=	$this->input->post('contrasena');
					$data 				= 	$this->security->xss_clean($data);  

					$login_check = $this->modelo->check_login($data);
					
					if ( $login_check != FALSE ){

						$usuario_historico = $this->modelo->anadir_historico_acceso($login_check[0]);

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
								$this->session->set_userdata('sala', $login_element->sala+$login_element->id_almacen);
								$this->session->set_userdata('id_almacen', $login_element->id_almacen);
								$this->session->set_userdata('coleccion_id_operaciones', $login_element->coleccion_id_operaciones);
								$this->session->set_userdata('nombre_completo', $login_element->nombre.' '.$login_element->apellidos);
								$this->session->set_userdata('modulo', 'home');				
								$this->session->set_userdata('especial', $login_element->especial);	
								$this->session->set_userdata('id_almacen_ajuste', 1);		
							}

							$data['id_almacen'] = $this->session->userdata('id_almacen') ;
			              	$status_almacen  = $this->modelo->status_almacen($data);       
			              	
			              	if ($data['id_almacen']!=0) {	
			              		if   ($status_almacen->activo==0) {
			              				$this->session->sess_destroy();		              		
			            			echo '<span class="error"><b>Actualmente el sistema se encuentra desactivado. Se esta realizando un conteo físico del inventario. Contacte al Administrador.</b> </span>';  		
			              		} else {
			              			echo TRUE;		
			              		}

			              	} else {
			              		echo TRUE;	
			              	}


						
					} else {
						echo '<span class="error">¡Ups! tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
					}
				}

*/				
	}	


	//recuperar constraseña
	function forgot(){
	    $this->load->view('recuperar_password');
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
              redirect('');
              break;
          }
        }
        else{ 
          redirect('index');
        }
	}

	function dashboard() { 
		/*
	    if($this->session->userdata('session') === TRUE ){
	          $id_perfil=$this->session->userdata('id_perfil');

	          $data['nodefinido_todavia']        = '';
	          $data['estatuss']  = $this->catalogo->listado_estatus(-1,-1,-1);
	          $data['productos'] = $this->catalogo->listado_productos_unico();
	          $data['almacenes']   = $this->modelo->coger_catalogo_almacenes(2);
	          $data['facturas']   = $this->catalogo->listado_tipos_facturas(-1,-1,'1');
	          
			  $dato['id'] = 7;
			  $data['configuracion'] = $this->catalogo->coger_configuracion($dato); 

			    	$id_perfil = $this->session->userdata('id_perfil');
			          switch ($id_perfil) {    
			            case 1:		            
			            case 2:
			            case 4:
			                $this->load->view( 'principal/dashboard',$data );
			              break;
			            
			            case 3: //vendedor
			                $data['colores'] =  $this->catalogo->listado_colores(  );
			            	$data['estatuss']  = $this->catalogo->listado_estatus(-1,-1,'1');
			                $this->load->view( 'principal/inicio',$data );
			              break;
			          
			            default:  
			              redirect('');
			              break;
			          }

	        }
	        else{ 
	          redirect('');
	        }	
	        */
	}

 // Creación de especialista o Administrador (Nuevo Colaborador)
	function nuevo_usuario(){
    if($this->session->userdata('session') === TRUE ){
          $id_perfil=$this->session->userdata('id_perfil');

          $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
          if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
                $coleccion_id_operaciones = array();
           }   

            	  $data['clientes']   = $this->modelo->coger_catalogo_clientes(2);
            	  $data['almacenes']   = $this->modelo->coger_catalogo_almacenes(2);
                  $data['perfiles']   = $this->modelo->coger_catalogo_perfiles();
                  $data['operaciones'] = $this->modelo->listado_operaciones();          

          switch ($id_perfil) {    
            case 1:
                  $this->load->view( 'usuarios/nuevo_usuario', $data );   
                    
              break;
            case 2:
            case 3:
            case 4:
                 if  (in_array(5, $coleccion_id_operaciones))  { 
                    $this->load->view( 'usuarios/nuevo_usuario', $data );   
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

			

			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
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
						$usuario['coleccion_id_operaciones']	=	json_encode($this->input->post('coleccion_id_operaciones'));						

						$usuario['id_almacen']   				= $this->input->post( 'id_almacen' );
						

						$usuario 						= $this->security->xss_clean( $usuario );
						$guardar 						= $this->modelo->anadir_usuario( $usuario );

						if ( $guardar !== FALSE ){

									/*
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



	//edicion del especialista o el perfil del especialista o administrador activo
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
			$data['perfiles']		= $this->modelo->coger_catalogo_perfiles();
			$data['clientes']   = $this->modelo->coger_catalogo_clientes(2);
			$data['almacenes']   = $this->modelo->coger_catalogo_almacenes(2);
			$data['usuario'] = $this->modelo->coger_catalogo_usuario( $uid );

			
			$data['operaciones'] = $this->modelo->listado_operaciones();



	        $data['id']  = $uid;
			if ( $data['usuario'] !== FALSE ){
					$this->load->view('usuarios/editar_usuario',$data);
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
			redirect('');
		} else {
			
			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_lenght[180]|xss_clean');
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

						$usuario['coleccion_id_operaciones']	=	json_encode($this->input->post('coleccion_id_operaciones'));						

						$usuario['id_almacen']   				= $this->input->post( 'id_almacen' );
						

						
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
              redirect('');
              break;
          }
        }
        else{ 
          redirect('');
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
		redirect('');
	}		



}
