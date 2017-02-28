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




  
//***********************areas **********************************//
 public function procesando_rep_general(){

//$data['fecha_inicial'] = date('d-m-Y',strtotime("first day of this month"));   //1er dia del mes



/*
$data['fecha_inicial'] = date('d-m-Y', strtotime('26-01-2017') ); 
$data['fecha_final'] = date('d-m-Y', strtotime('today') ); 






    $arreglo_fechas = array();

    if (is_string($data['fecha_inicial']) === true) $data['fecha_inicial'] = strtotime($data['fecha_inicial']);
    if (is_string($data['fecha_final']) === true ) $data['fecha_final'] = strtotime($data['fecha_final']);

    if ($data['fecha_inicial'] > $data['fecha_final']) return createDateRangeArray($data['fecha_final'], $data['fecha_inicial']);

    do {
        $arreglo_fechas[] = date('Y-m-d', $data['fecha_inicial']);
        $data['fecha_inicial'] = strtotime("+ 1 day", $data['fecha_inicial']);
    } while($data['fecha_inicial'] <= $data['fecha_final']);




    print_r($arreglo_fechas);



  die;

*/
         $dato=$_POST;
         $dato['id_proyecto'] = 79;

         print_r($this->modelo_reporte->procesando_rep_general($dato));    


 } 



    public function listado_general(){

  
                      //die;

    
        $id_perfil=$this->session->userdata('id_perfil');

        if($this->session->userdata('session') === TRUE ){
                        
                      $data['datos']['usuarios'] = $this->modelo->listado_usuarios();   
                      $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos();    
                      $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos();    
               
                  
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

