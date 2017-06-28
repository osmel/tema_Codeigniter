<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

    public function __construct(){ 
		parent::__construct();
		$this->load->model('Modelo_nucleo', 'modelo'); 
		$this->load->model('Modelo_arbol', 'modelo_arbol'); 
    $this->load->model('Modelo_administracion', 'modelo_administracion'); 
		$this->load->model('Modelo_proyecto', 'modelo_proyecto'); 
    $this->load->model('Modelo_catalogo', 'modelo_catalogo'); 
    $this->load->model('Modelo_reportes', 'modelo_reporte'); 
    
	}



 function cargar_dependencia_reportes(){
    
    $data['campo']        = $this->input->post('campo');

    $data['id_proyecto']        = $this->input->post('id_proyecto');
    $data['id_profundidad']        = $this->input->post('id_profundidad');
    $data['id_area']        = $this->input->post('id_area');
    $data['id_usuario']        = $this->input->post('id_usuario');

    $data['dependencia']        = $this->input->post('dependencia');

    //r.id_entorno, r.id_proyecto, r.id_nivel, r.id_area, ca.area, r.id_usuario, r.nombre nom, r.apellidos, cp.proyecto

    $data['campos'] = ',r.id_proyecto identificador, cp.proyecto nombre,'.$data['id_proyecto'].' activo';  
    $data['tipo'] = 'id_proyecto';
    $elementos['id_proyecto']  = $this->modelo_reporte->listado_proyectos_dependiente($data);
    
    //echo json_encode($elementos); die;
    $data['campos'] = ',r.profundidad identificador, CONCAT("Nivel ",r.profundidad) nombre,'.$data['id_profundidad'].' activo';  
    $data['tipo'] = 'profundidad';
    $elementos['id_profundidad']  = $this->modelo_reporte->listado_proyectos_dependiente($data);

    $data['campos'] = ',r.id_area identificador, ca.area nombre,'.$data['id_area'].' activo';  
    $data['tipo'] = 'id_area';
    $elementos['id_area']  = $this->modelo_reporte->listado_proyectos_dependiente($data);

    $data['campos'] = ',r.id_usuario identificador, r.nombre nombre,"'.$data['id_usuario'].'" activo';  
    $data['tipo'] = 'id_usuario';
    $elementos['id_usuario']  = $this->modelo_reporte->listado_proyectos_dependiente($data);

    echo json_encode($elementos);

  }




 public function procesando_rep_horas_personas(){
         $data=$_POST;
          echo ($this->modelo_reporte->procesando_rep_horas_personas($data));    
 } 

  
public function procesando_rep_horas_personas_detalle(){
         $data=$_POST;
         //echo json_encode($data);
         echo ($this->modelo_reporte->procesando_rep_horas_personas_detalle($data));    

 } 

 public function horas_personas(){
    
        $id_perfil=$this->session->userdata('id_perfil');
         $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
        if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
              $coleccion_id_operaciones = array();
         }   

        if($this->session->userdata('session') === TRUE ){
                        
                      $data['datos']['usuarios'] = $this->modelo->listado_usuarios();   
                      $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos();    
                      $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos();    

                      $data['areas'] = $this->modelo_catalogo->listado_areas();    
                  
                      switch ($id_perfil) {    
                        case 1:                 
                            $this->load->view( 'reportes/horas_personas',$data);
                          break;
                        case 2: //
                        case 3: //
                        case 4: //
                         if  ( (in_array(5, $coleccion_id_operaciones)) )  { 
                                $this->load->view( 'reportes/horas_personas',$data);
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

  
//***********************General **********************************//
 public function procesando_rep_general(){
         $data=$_POST;
          echo ($this->modelo_reporte->procesando_rep_general($data));    
 } 

 
public function procesando_rep_general_detalle(){
         $data=$_POST;
         echo ($this->modelo_reporte->procesando_rep_general_detalle($data));    

 } 
 
                     
  public function listado_general(){
    
        $id_perfil=$this->session->userdata('id_perfil');
         $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
        if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
              $coleccion_id_operaciones = array();
         }   

        if($this->session->userdata('session') === TRUE ){
                        
                      $data['datos']['usuarios'] = $this->modelo->listado_usuarios();   
                      $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos();    
                      $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos();    

                      $data['areas'] = $this->modelo_catalogo->listado_areas();    

                      //print_r($data['datos']['proyectos']); die;
               
                  
                      switch ($id_perfil) {    
                        case 1:                 
                            $this->load->view( 'reportes/reportes',$data);
                          
                          break;
                        
                        case 2: //
                        case 3: //
                        case 4: //
                         if  ( (in_array(5, $coleccion_id_operaciones)) )  { 
                                $this->load->view( 'reportes/reportes',$data);
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