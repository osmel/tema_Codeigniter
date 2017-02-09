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


/*


crear, modificar, eliminar tablas 
https://www.codeigniter.com/userguide2/database/table_data.html

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

**funciones que permiten traer datos de las tabla.

	 --Devuelve una array que contiene los nombres de todas las tablas de la BD que está activa actualmente. Ejemplo:

	   $tables = $this->db->list_tables();
		foreach ($tables as $table) {
		   echo $table;
		}


	 --Devuelve un valor booleano. Si la tabla existe o no
		 if ($this->db->table_exists('table_name')) {
	   			// some code...
		 }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		https://www.codeigniter.com/userguide2/database/fields.html
*****DATOS DE CAMPOS 

	--Devuelve un array que contiene los nombres de campo. Esta consulta se puede llamar de dos maneras:

	   --1. Se puede suministrar el nombre de tabla y llamarlo desde  el objeto   $this->db-> 

	   $fields = $this->db->list_fields('table_name');

		foreach ($fields as $field)	{
		   echo $field;
		}

	   --2. Usted puede reunir los nombres de los campos asociados con cualquier consulta que se ejecute
	       llamando a la función desde su objeto de resultado de la consulta:

	   $query = $this->db->query('SELECT * FROM some_table'); 

		foreach ($query->list_fields() as $field) {
		   echo $field;
		}

   --Devuelve un valor booleano. Si el campo existe o no
		
		if ($this->db->field_exists('field_name', 'table_name'))	{
		   // some code...
		}


	---Devuelve un array de objetos que contienen información de campo.
	A veces es útil para recopilar los nombres de campo u otros metadatos, como el tipo de columna, longitud máxima, etc.

	$fields = $this->db->field_data('table_name');

	foreach ($fields as $field)	{
	   echo $field->name;
	   echo $field->type;
	   echo $field->max_length;
	   echo $field->primary_key;
	}

    ----Si ha ejecutado una consulta se puede utilizar el objeto de resultado en lugar de suministrar el nombre de tabla:
	    $query = $this->db->query("YOUR QUERY");
		$fields = $query->field_data();

	
	name - Nombre de la columna
	max_length - longitud máxima de la columna
	primary_key - 1 si la columna es una clave primaria
	type - el tipo de la columna


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

https://www.codeigniter.com/userguide2/database/forge.html

La Clase Forge de Base de Datos contiene funciones que ayudan a administrar su base de datos.
Para inicializar la clase Forge, el controlador de base de datos ya debe estar funcionando, ya que la clase forja se basa en ella.
 
 Cargar la clase Forge como sigue:
 	$this->load->dbforge()

 Una vez inicializado se accede a las funciones utilizando el objeto $this->dbForge:
	$this->dbforge->alguna_funcion()

	-----------------BD-----------------
		 crea bd. Devuelve TRUE / FALSE basado en el éxito o el fracaso:
		 	if ($this->dbforge->create_database('my_db')){
		       echo 'Database created!';
			}

		 Elimina bd. Devuelve TRUE / FALSE basado en el éxito o el fracaso:	
			if ($this->dbforge->drop_database('my_db')) {
		    	echo 'Database deleted!';
			}
	-----------------CREAR Y ELIMINAR TABLAS-----------------

	**Cosas que puede desear hacer al crear tablas. add campos, add claves, alter columnas.

	Los campos que se crean a través de un ARRAY asociativo. 
	Dentro del array debe incluir una clave "type" que se relaciona con el tipo de datos del campo. Por ejemplo, INT, VARCHAR, TEXT, etc.  Muchos tipos de datos (por ejemplo VARCHAR) también requiere una clave de 'restricción'('constraint' key.)


	$fields = array(
                        'usuario' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => '100', //VARCHAR(100)
                                          ),
                );


	**Adicionalmente los siguientes key/values se pueden usar:

	unsigned/true : para generar "UNSIGNED" en la definicion de campo
	default/value : para generar un valor "default" en la definicion de campo
	    null/true : para generar "NULL" en la definicion de campo. Sin esto, el campo será por defecto "NOT NULL".
	auto_increment/true : Genera una bandera auto_increment en el campo.  Tenga en cuenta que el tipo de campo debe ser un tipo que soporte este, tales como un número entero.

	$fields = array(
	                        'blog_id' => array(
	                                                 'type' => 'INT',
	                                                 'constraint' => 5, 
	                                                 'unsigned' => TRUE,
	                                                 'auto_increment' => TRUE
	                                          ),
	                        'blog_title' => array(
	                                                 'type' => 'VARCHAR',
	                                                 'constraint' => '100',
	                                          ),
	                        'blog_author' => array(
	                                                 'type' =>'VARCHAR',
	                                                 'constraint' => '100',
	                                                 'default' => 'King of Town',
	                                          ),
	                        'blog_description' => array(
	                                                 'type' => 'TEXT',
	                                                 'null' => TRUE,
	                                          ),
	                );


		Una vez que se han definido los campos, pueden ser añadidos usando $this->dbforge->add_field($fields); seguido de una llamada a la función create_table().

		$this->dbforge->add_field(): Esta funcion aceptará el array anterior.

		

		**Pasar las cadenas como campos
		Si usted sabe exactamente cómo desea que un campo sea creado, se puede pasar la cadena en las definiciones de campo con add_field ()

		$this->dbforge->add_field("label varchar(100) NOT NULL DEFAULT 'default label'");

		Nota: Las llamadas múltiples para add_field () son acumulativos.




	  **Creación de un campo id
	  Hay una excepción especial para la creación de campos "id". Un campo con el tipo de id será automáticamente assinged como 
	   INT(9) auto_incrementing Primary Key.

	   $this->dbforge->add_field('id'); // id INT(9) NOT NULL AUTO_INCREMENT


	 **La adición de llaves

	 En términos generales, usted quiere que su tabla tenga llaves. Esto se logra con  $this->dbforge->add_key('field') . Un segundo parámetro opcional establecido en TRUE hará que sea una clave principal. Tenga en cuenta que add_key () debe ser seguido por una llamada a CREATE_TABLE () .

	  llaves no primarios columnas múltiples  deben ser enviados como una matriz. Salida de ejemplo a continuación es para MySQL.

		$this->dbforge->add_key('blog_id', TRUE);
		//  PRIMARY KEY `blog_id` (`blog_id`)

		$this->dbforge->add_key('blog_id', TRUE);
		$this->dbforge->add_key('site_id', TRUE);
		//  PRIMARY KEY `blog_id_site_id` (`blog_id`, `site_id`)

		$this->dbforge->add_key('blog_name');
		//  KEY `blog_name` (`blog_name`)

		$this->dbforge->add_key(array('blog_name', 'blog_label'));
		//  KEY `blog_name_blog_label` (`blog_name`, `blog_label`)



	**Creación de una tabla
	Después de que los campos y claves han sido declarados, se puede crear una nueva tabla con:

		$this->dbforge->create_table('table_name');
		// CREATE TABLE table_name
		
	Un segundo parámetro opcional establecido en TRUE añade un "SI NO EXISTE" cláusula en la definición

		$this->dbforge->create_table('table_name', TRUE);
		// CREATE TABLE IF NOT EXISTS table_name


	***Eliminar una tabla

		$this->dbforge->drop_table('table_name');
		//  DROP TABLE IF EXISTS table_name

	
	***Cambiar el nombre de una tabla
		$this->dbforge->rename_table('old_table_name', 'new_table_name');
		//  ALTER TABLE old_table_name RENAME TO new_table_name
	

	-----------------MODIFICAR TABLAS-----------------

		esto lo veo despues


*/



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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
