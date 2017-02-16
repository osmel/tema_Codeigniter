<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogos extends CI_Controller {

    public function __construct(){ 
		parent::__construct();
		$this->load->model('Modelo_nucleo', 'modelo'); 
		$this->load->model('Modelo_arbol', 'modelo_arbol'); 
    $this->load->model('Modelo_administracion', 'modelo_administracion'); 
		$this->load->model('Modelo_proyecto', 'modelo_proyecto'); 
    $this->load->model('Modelo_catalogo', 'modelo_catalogo'); 
	}




  
//***********************areas **********************************//


    public function listado_areas(){
    
        $id_perfil=$this->session->userdata('id_perfil');

        if($this->session->userdata('session') === TRUE ){
                        
                      $data['datos']['usuarios'] = $this->modelo->listado_usuarios();   
                      $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos();    
                      $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos();    
                      
                  
                      switch ($id_perfil) {    
                        case 1:                 
                            $this->load->view( 'catalogos/areas/areas',$data);
                          
                          break;
                        
                        case 2: //
                        case 3: //
                        case 4: //

                            $this->load->view( 'catalogos/areas/areas',$data);
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




 public function procesando_cat_areas(){

    $data=$_POST;
    $busqueda = $this->modelo_catalogo->buscador_cat_areas($data);
    echo $busqueda;
  }     




//***********************Cargos **********************************//


	public function listado_cargos(){
	
		$id_perfil=$this->session->userdata('id_perfil');

	    if($this->session->userdata('session') === TRUE ){
	    				
	    			  $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 	
	    			  $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos(); 	
	    			  $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	
	    			  
	    

			          switch ($id_perfil) {    
			            case 1:		            
			                $this->load->view( 'catalogos/cargos/cargos',$data);
			              break;
			            
			            case 2: //
			            case 3: //
			            case 4: //

			                $this->load->view( 'catalogos/cargos/cargos',$data);
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

 public function procesando_cat_cargos(){

    $data=$_POST;
    $busqueda = $this->modelo_catalogo->buscador_cat_cargos($data);
    echo $busqueda;
  } 




//***********************perfiles **********************************//


    public function listado_perfiles(){
    
        $id_perfil=$this->session->userdata('id_perfil');

        if($this->session->userdata('session') === TRUE ){
                        
                      $data['datos']['usuarios'] = $this->modelo->listado_usuarios();   
                      $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos();    
                      $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos();    
                      
        

                      switch ($id_perfil) {    
                        case 1:                 
                            $this->load->view( 'catalogos/perfiles/perfiles',$data);
                          break;
                        
                        case 2: //
                        case 3: //
                        case 4: //

                            $this->load->view( 'catalogos/perfiles/perfiles',$data);
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



 public function procesando_cat_perfiles(){

    $data=$_POST;
    $busqueda = $this->modelo_catalogo->buscador_cat_perfiles($data);
    echo $busqueda;
  } 

//***********************configuraciones **********************************//


    public function listado_configuraciones(){
    
        $id_perfil=$this->session->userdata('id_perfil');

        if($this->session->userdata('session') === TRUE ){
                        

                      $data['datos']['usuarios'] = $this->modelo->listado_usuarios();   
                      $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos();    
                      $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos();    
                      
                      

                      switch ($id_perfil) {    
                        case 1:                 
                            $this->load->view( 'catalogos/configuraciones/configuraciones',$data);
                          break;
                        
                        case 2: //
                        case 3: //
                        case 4: //

                            $this->load->view( 'catalogos/configuraciones/configuraciones',$data);
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


 public function procesando_cat_configuraciones(){

    $data=$_POST;
    $busqueda = $this->modelo_catalogo->buscador_cat_configuraciones($data);
    echo $busqueda;
  } 




    // crear
  function nuevo_cargo(){
	if($this->session->userdata('session') === TRUE ){
	      $id_perfil=$this->session->userdata('id_perfil');
	      $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 	
	      $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos(); 	
	      $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	

	      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
	      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
	            $coleccion_id_operaciones = array();
	       }   

	      
	       
       
	      switch ($id_perfil) {    
	        case 1:
	            $this->load->view( 'catalogos/cargos/crud/nuevo_cargo',$data);
	          break;
	        case 2:
	        case 3:
	        case 4:
	             if  ( (in_array(1, $coleccion_id_operaciones)) )  { 
	                $this->load->view( 'catalogos/cargos/crud/nuevo_cargo',$data);
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



  function validar_nuevo_cargo(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
      $this->form_validation->set_rules('cargo', 'Cargo', 'trim|required|min_length[1]|max_length[80]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          $data['cargo']   = $this->input->post('cargo');

         $existe            =  $this->modelo_catalogo->check_existente_cargo( $data );
         if ( $existe !== TRUE ){

            $data         =   $this->security->xss_clean($data);  
            $guardar            = $this->modelo_catalogo->anadir_cargo( $data );
            if ( $guardar !== FALSE ){
              echo true;
            } else {
              echo '<span class="error"><b>E01</b> - El nuevo cargo no pudo ser agregada</span>';
            }
          } else {
            echo '<span class="error"><b>E01</b> - El cargo que desea agregar ya existe. No es posible agregar dos cargos iguales.</span>';
          }  

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
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
