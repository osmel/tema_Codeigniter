<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogos extends CI_Controller {

    public function __construct(){ 
		parent::__construct();
		$this->load->model('Modelo_nucleo', 'modelo'); 
		//$this->load->model('Modelo_catalogo', 'modelo_catalogo'); 
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

public function get_node() {


require_once(dirname(__FILE__) . '/class.db.php');
require_once(dirname(__FILE__) . '/class.tree.php');

if(isset($_GET['operation'])) {
	$fs = new tree(db::get('mysqli://root@127.0.0.1/inventarios'), array('structure_table' => 'inven_struct', 'data_table' => 'inven_data', 'data' => array('nm')));

	//print_r(($fs));
	//echo json_encode($fs);

/*
object(tree)#23 (3) { ["db":protected]=> object(vakata\database\DBC)#24 (2) { ["drv":protected]=> object(vakata\database\mysqli_driver)#26 (5) { ["iid":protected]=> int(0) ["aff":protected]=> int(0) ["mnd":protected]=> bool(false) ["lnk":protected]=> NULL ["settings":protected]=> object(vakata\database\Settings)#25 (9) { ["type"]=> string(6) "mysqli" ["username"]=> string(4) "root" ["password"]=> string(4) "root" ["database"]=> string(11) "inventarios" ["servername"]=> string(9) "127.0.0.1" ["serverport"]=> int(3306) ["persist"]=> bool(false) ["timezone"]=> NULL ["charset"]=> string(4) "UTF8" } } ["que":protected]=> NULL } ["options":protected]=> array(5) { ["structure_table"]=> string(12) "inven_struct" ["data_table"]=> string(10) "inven_data" ["data2structure"]=> string(2) "id" ["structure"]=> array(6) { ["id"]=> string(2) "id" ["left"]=> string(3) "lft" ["right"]=> string(3) "rgt" ["level"]=> string(3) "lvl" ["parent_id"]=> string(3) "pid" ["position"]=> string(3) "pos" } ["data"]=> array(1) { [0]=> string(2) "nm" } } ["default":protected]=> array(5) { ["structure_table"]=> string(9) "structure" ["data_table"]=> string(9) "structure" ["data2structure"]=> string(2) "id" ["structure"]=> array(6) { ["id"]=> string(2) "id" ["left"]=> string(3) "lft" ["right"]=> string(3) "rgt" ["level"]=> string(3) "lvl" ["parent_id"]=> string(3) "pid" ["position"]=> string(3) "pos" } ["data"]=> array(0) { } } }

*/

	//die;
	try {
		$rslt = null;
		switch($_GET['operation']) {
			case 'analyze':
				var_dump($fs->analyze(true));
				die();
				break;
			case 'get_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$temp = $fs->get_children($node);
				$rslt = array();
				foreach($temp as $v) {
					$rslt[] = array('id' => $v['id'], 'text' => $v['nm'], 'children' => ($v['rgt'] - $v['lft'] > 1));
				}
				break;
			case "get_content":
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : 0;
				$node = explode(':', $node);
				if(count($node) > 1) {
					$rslt = array('content' => 'Multiple selected');
				}
				else {
					$temp = $fs->get_node((int)$node[0], array('with_path' => true));
					$rslt = array('content' => 'Selected: /' . implode('/',array_map(function ($v) { return $v['nm']; }, $temp['path'])). '/'.$temp['nm']);
				}
				break;
			case 'create_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$temp = $fs->mk($node, isset($_GET['position']) ? (int)$_GET['position'] : 0, array('nm' => isset($_GET['text']) ? $_GET['text'] : 'New node'));
				$rslt = array('id' => $temp);
				break;
			case 'rename_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$rslt = $fs->rn($node, array('nm' => isset($_GET['text']) ? $_GET['text'] : 'Renamed node'));
				break;
			case 'delete_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$rslt = $fs->rm($node);
				break;
			case 'move_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? (int)$_GET['parent'] : 0;
				$rslt = $fs->mv($node, $parn, isset($_GET['position']) ? (int)$_GET['position'] : 0);
				break;
			case 'copy_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? (int)$_GET['parent'] : 0;
				$rslt = $fs->cp($node, $parn, isset($_GET['position']) ? (int)$_GET['position'] : 0);
				break;
			default:
				throw new Exception('Unsupported operation: ' . $_GET['operation']);
				break;
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
	}
	catch (Exception $e) {
		header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
		header('Status:  500 Server Error');
		echo $e->getMessage();
	}
	die();
}


}


	public function obtener_nodo() {

		$padre = isset($_POST['id']) && $_POST['id'] !== '#' ? (int)$_POST['id'] : 0;

		

		$temp= $this->modelo_catalogo->crear_nodo(
						$padre, //padre
						isset($_POST['position']) ? (int)$_POST['position'] : 0, //posicion
				        array('nm' => isset($_POST['text']) ? $_POST['text'] : 'Nuevo node') //data
				);




		$rslt = array('id' => 8, 'exito' => true);

		//header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
	}



	public function crear_nodo() {

		$padre = isset($_POST['id']) && $_POST['id'] !== '#' ? (int)$_POST['id'] : 0;

		

		$temp= $this->modelo_catalogo->crear_nodo(
						$padre, //padre
						isset($_POST['position']) ? (int)$_POST['position'] : 0, //posicion
				        array('nm' => isset($_POST['text']) ? $_POST['text'] : 'Nuevo node') //data
				);




		$rslt = array('id' => 8, 'exito' => true);

		//header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
	}



/*
case 'create_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$temp = $fs->mk(

						 $node, //padre
						 isset($_GET['position']) ? (int)$_GET['position'] : 0, //posicion
				         array('nm' => isset($_GET['text']) ? $_GET['text'] : 'New node') //data

				         );


				$rslt = array('id' => $temp);
				
				break;



*/


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
