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



}
