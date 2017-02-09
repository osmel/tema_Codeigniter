<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogos extends CI_Controller {

    public function __construct(){ 
		parent::__construct();
		$this->load->model('Modelo_nucleo', 'modelo'); 
		$this->load->model('Modelo_catalogo', 'modelo_catalogo'); 
	}

	public function crear_proyecto(){
	
		$id_perfil=$this->session->userdata('id_perfil');

	    if($this->session->userdata('session') === TRUE ){
	    				
	    			  $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 	

			          switch ($id_perfil) {    
			            case 1:		            
			                $this->load->view( 'catalogos/proyectos/proyectos',$data);
			              break;
			            
			            case 2: //
			            case 3: //
			            case 4: //

			                $this->load->view( 'catalogos/proyectos/proyectos',$data);
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



	//para obtener cada nodo e hijos y mostrarlo
	public function obtener_nodo() {
		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
		$temp = $this->modelo_catalogo->get_children($node);
		$rslt = array();
		
		
		foreach($temp as $v) {
			//if (derecho -izquierdo >1) significa que tiene hijos y por tanto envia "true"
			$rslt[] = array('id' => $v['id'], 'text' => $v['nm'], 'children' => ($v['rgt'] - $v['lft'] > 1));
		}

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
		
	}



	//este es solo para obtener el recorrido seleccionado
	public function obtener_contenido() {

		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : 0;
		
		$node = explode(':', $node);

		if(count($node) > 1) {
				$rslt = array('content' => 'Multiples Seleccionados');
		} else {
			 //en este caso $temp[path] es agregado para el recorrido seleccionado
			 $temp = $this->modelo_catalogo->get_node((int)$node[0], array('with_path' => true));

			 //aqui se conforma el formato q voy a presentar del recorrido seleccionado
			 $rslt = array('content' => 'Seleccionado: /' . 
			 			implode('/',array_map(function ($v) { return $v['nm']; }, $temp['path'])).
			 			 '/'.$temp['nm']);
			 }
		 
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
		
	}


	// Este es solo para "renombrar el nodo"
	public function renombrar_nodo() {

		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;

		$rslt = $this->modelo_catalogo->rn($node, //id
			 			array('nm' => isset($_GET['text']) ? $_GET['text'] : 'Renamed node') //data
			 );

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
		
	}




	//Eliminar el nodo, hijo, nieto, etc
	public function eliminar_nodo() {

				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;

				$rslt = $this->modelo_catalogo->rm(
									$node //id
								);

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);

	}


	//crear un único nodo
	public function crear_nodo() {

		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
		
		$temp = $this->modelo_catalogo->mk($node,  //padre
						isset($_GET['position']) ? (int)$_GET['position'] : 0,  //posicion
				      	array('nm' => isset($_GET['text']) ? $_GET['text'] : 'New node') //data
				      );
		$rslt = array('id' => $temp);

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);

	}





	//crear un único nodo
	public function mover_nodo() {

		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
		$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? (int)$_GET['parent'] : 0;

		$rslt = $this->modelo_catalogo->mv($node, //id
										   $parn, //padre
										   isset($_GET['position']) ? (int)$_GET['position'] : 0 //posicion
										  );

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);

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
