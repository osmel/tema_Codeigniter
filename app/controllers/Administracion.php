<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administracion extends CI_Controller {

    public function __construct(){ 
		parent::__construct();
		$this->load->model('Modelo_nucleo', 'modelo'); 
		$this->load->model('Modelo_arbol', 'modelo_arbol'); 
		$this->load->model('Modelo_administracion', 'modelo_administracion'); 
		$this->load->model('Modelo_proyecto', 'modelo_proyecto'); 
	}




  public function buscador(){

    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
      
       $data['key']=$_GET['key'];
	   $busqueda = $this->modelo_proyecto->buscador_usuarios($data);

       echo $busqueda;
    }  
  }


  public function validar_registro_usuario(){

    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {

        $data = $_POST;
        $data['fechapaginador']    = date("Y-m-d", strtotime($this->input->post('fechapaginador')) ); 
          
        $data         =   $this->security->xss_clean($data);  
        $guardar            = $this->modelo_proyecto->actualizar_reg_user_proy( $data );
        
        echo json_encode($guardar);
    }
  }  



/*
function listado_usuarios_niveles(  ){

                   $data['id_proyecto']     = $this->input->post('id_cat_proy');
                   $data['id_reg_proy']     = $this->input->post('id_reg_proy');
                   $data['id_nivel']        = $this->input->post('id_nivel');
          $data['profundidad']              = $this->input->post('profundidad');

                   // $data['datos'] = $this->modelo_proyecto->listado_nivel($data); 

          
          
          $usuario_json = $this->modelo_proyecto->listado_usuarios_niveles($data);

          echo $usuario_json;

} 
*/


function listado_niveles( ){
                   
                   
                   $data['id_proyecto']     = $this->input->post('id_cat_proy');
                   $data['id_reg_proy']     = $this->input->post('id_reg_proy');
                   $data['id_nivel']        = $this->input->post('id_nivel');
          $data['profundidad']              = $this->input->post('profundidad');

                    if ($data['id_nivel']==1){ //root
                      $data['datos'] = $this->modelo_proyecto->listado_nivel_proyectos($data); 
                    } else { //niveles desde el 2-n
                      $data['datos'] = $this->modelo_proyecto->listado_nivel($data); 
                   }
                    


          echo json_encode($data);
}  

  function ajax_user_proy_json(  ){

          

           $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 
           $dato['proyecto'] = $data['datos']['proyectos'];
           $dato['fechapaginador'] = date('Y-m-d', strtotime($this->input->post('fechapaginador')) ); 
           $dato['fechaanterior'] = date('Y-m-d', strtotime ( '-1 day' , strtotime($this->input->post('fechapaginador')) )  ); 
           $data['datos']['proyectos']= $this->modelo_proyecto->listado_registro_usuario($dato); 

           echo json_encode($data['datos']['proyectos']);
            //$data['id']        = $this->input->post('id');
            
            //$usuario_json = $this->modelo_proyecto->listado_usuarios_json($data);

            //echo $usuario_json;

  } 

  
          //print_r($_POST);
          //return false;

/*
$fecha = date('Y-m-j');
$nuevafecha = strtotime ( '+2 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
*/

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////Proyectos/////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



public function crear_tabla_proyecto($nombre) {

		$this->load->dbforge();
		//creamos la estructura de una tabla con un 
		//id autoincremental, un campo varchar(255) para el nm
		//y otro para el passwords también varchar
		$this->dbforge->add_field(
			array(
				"id"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
					//"auto_increment"	=>		TRUE,
 
				),
				"nm"	=>		array(
					"type"				=>		"VARCHAR",
					"constraint"		=>		255,
				),
			)
		);



 
		$this->dbforge->add_key('id', TRUE);//establecemos id como primary_key
		$this->dbforge->create_table('pdata_'.$nombre);//creamos la tabla inven_prueba



		$this->dbforge->add_field(
			array(
				"id"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
					"auto_increment"	=>		TRUE,
				),
				"lft"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
				),
				"rgt"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
				),
				"lvl"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
				),
				"pid"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
				),
				"pos"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
				),
			)
		);


		$this->dbforge->add_key('id', TRUE);//establecemos id como primary_key
		$this->dbforge->create_table('pstruct_'.$nombre);//creamos la tabla inven_prueba


		//insertar registro en cada tabla

			$data["nombre"]="Proyectos_".$nombre;
			$data["tabla"]=$nombre;
			$this->modelo_proyecto->insertar_registro_nuevas_tablas($data); 	
		 
		//$this->dbforge->drop_table('prueba');

}	


 function crear_nuevo_proyecto($data){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
          //$data['id_proyecto']       = $this->input->post('id_proyecto');

          $data['proyecto']         = "Proyectos_".$data['nombre'];
          $data['descripcion']      = 'Nuevo Proyecto';
          $data['privacidad']       = 1; //publico
          $data['costo']            = 0;
          $data['fecha_creacion']   = date("Y-m-d", strtotime(date("d-m-Y")) );
          $data['fecha_inicial']    = date("Y-m-d", strtotime('') );
          $data['fecha_final']      = date("Y-m-d", strtotime('') );
          $data['contrato_firmado'] = 0;
          $data['pago_anticipado']  = 0;
          $data['factura_enviada']  = 0;
          $data['id_val']           = '';  //no hay usuarios
          $data['json_items']       = '';  //no hay usuarios


         $existe            =  $this->modelo_proyecto->check_existente_proyecto( $data );
         if ( $existe !== TRUE ){

            //$data               = $this->security->xss_clean($data);  
            $guardar            = $this->modelo_proyecto->anadir_proyecto( $data );
           
          }  

      }
   }
  



    // crear
  function crear_proyecto(){
	if($this->session->userdata('session') === TRUE ){

	      $id_perfil=$this->session->userdata('id_perfil');
	      $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 	
	      $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos(); 	
	      $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	

	      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
	      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
	            $coleccion_id_operaciones = array();
	       }   

	     // $this->session->set_userdata('creando_proyecto', "20170220080309SdRV410"); 
	      //crear la tabla	
	      if ($this->session->userdata('creando_proyecto') == "0") {
	      			   $data['nombre'] = date('Y').date('m').date('d').date('H').date('i').date('s').random_string('alpha',4).random_string('numeric',3);
	      			   $this->session->set_userdata('creando_proyecto', $data['nombre']);	
				      self::crear_tabla_proyecto($data['nombre']);
              self::crear_nuevo_proyecto($data);

	      }
	      $data['nombre'] = $this->session->userdata('creando_proyecto');

        $data['proy_salvado'] = $this->modelo_proyecto->buscar_proyecto($data);
	       
		  $dato["id"] = $this->session->userdata('entorno_activo');
          $data['depth_arbol'] =$this->modelo_proyecto->coger_entorno($dato)->profundidad;
          $dato['id'] = 3;
	      $data['crea_multiple_simple'] = $this->modelo_administracion->coger_configuracion($dato)->valor; //1 multiple
	      
	      $data['ambito_app'] =2;  //proyecto
	      $this->session->set_userdata('ambito_app', $data['ambito_app']);	
       	  
        
	      switch ($id_perfil) {    
	        case 1:
          case 2:
          case 3:

	            $this->load->view( 'catalogos/proyectos/crud/nuevo_proyecto',$data);
	          break;
	        case 4:
	             if  ( (in_array(1, $coleccion_id_operaciones)) )  { 
	                $this->load->view( 'catalogos/proyectos/crud/nuevo_proyecto',$data);
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

  
  function validar_nuevo_proyecto(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
      $this->form_validation->set_rules('proyecto', 'proyecto', 'trim|required|min_length[1]|max_length[80]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          


		
		 // $data['id_entorno']   		 = $this->input->post('id_entorno');
      	 //$this->db->set( 'id_entorno', $this->session->userdata('entorno_activo') );
		      $data['id_proyecto']   		 = $this->input->post('id_proyecto');

          $data['proyecto']   		 = $this->input->post('proyecto');
          $data['descripcion']   	 = $this->input->post('descripcion');
          $data['privacidad']   	 = $this->input->post('privacidad');
          $data['costo']   			 = $this->input->post('costo');
          $data['fecha_creacion']  	 = date("Y-m-d", strtotime($this->input->post('fecha_creacion')) );
          $data['fecha_inicial']  	 = date("Y-m-d", strtotime($this->input->post('fecha_inicial')) );
          $data['fecha_final']   	 = date("Y-m-d", strtotime($this->input->post('fecha_final')) );
          $data['contrato_firmado']  = $this->input->post('contrato_firmado');
          $data['pago_anticipado']   = $this->input->post('pago_anticipado');
          $data['factura_enviada']   = $this->input->post('factura_enviada');
          $data['id_val']  			 = $this->input->post('id_val');
          $data['json_items']   	 = $this->input->post('json_items');






         $existe            =  $this->modelo_proyecto->check_existente_proyecto( $data );
         if ( $existe !== TRUE ){

            $data         =   $this->security->xss_clean($data);  
            $guardar            = $this->modelo_proyecto->anadir_proyecto( $data );
            if ( $guardar !== FALSE ){
              //$this->session->set_userdata('creando_proyecto', "0");	 //listo para crear otro proyecto
              echo true;
            } else {
              echo '<span class="error"><b>E01</b> - El nuevo proyecto no pudo ser agregada</span>';
            }
          } else {
            echo '<span class="error"><b>E01</b> - El proyecto que desea agregar ya existe. No es posible agregar dos proyectos iguales.</span>';
          }  

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }





function listado_usuarios_json(  ){

          $data['id']        = $this->input->post('id');
          
          $usuario_json = $this->modelo_proyecto->listado_usuarios_json($data);

          echo $usuario_json;

} 



 // editar
  function editar_proyecto( $id ){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = base64_decode($id); 

         
  		if ($data['id']!=0) {
  			
  	       $data['proy_salvado'] = $this->modelo_proyecto->coger_proyecto($data);
  	   
  			//lo pase 
  			if ( $data['proy_salvado'] !== FALSE ){       
  	       			$this->session->set_userdata('creando_proyecto', $data['proy_salvado']->tabla);
  	       	}		

  		}   


       $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 	
       $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos();  
       $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	

	       
		  
		    $dato["id"] = $this->session->userdata('entorno_activo');
        $data['depth_arbol'] =$this->modelo_proyecto->coger_entorno($dato)->profundidad;
        $dato['id'] = 3;
	      $data['crea_multiple_simple'] = $this->modelo_administracion->coger_configuracion($dato)->valor; //1 multiple
	      $data['ambito_app'] =2; 
	      $this->session->set_userdata('ambito_app', $data['ambito_app']);	

      switch ($id_perfil) {    
        case 1:
        case 2:
        case 3:        
                  
                  if ( $data['proy_salvado'] !== FALSE ){
                      $this->load->view( 'catalogos/proyectos/crud/editar_proyecto', $data );
                  } else {
                        redirect('/');
                  }       

          break;

        case 4:
               if  ( (in_array(1, $coleccion_id_operaciones)) )  { 
                  
                  if ( $data['proy_salvado'] !== FALSE ){
                      $this->load->view( 'catalogos/proyectos/crud/editar_proyecto', $data );
                  } else {
                        redirect('/');
                  }       
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




function validacion_edicion_nivel(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
      //echo $_POST[];
      //die;
        $this->form_validation->set_rules('proyecto', 'proyecto', 'trim|required|min_length[1]|max_length[80]|xss_clean');
          
        if ($this->form_validation->run() === TRUE){

          $data['id']           = $this->input->post('id');  //catalogo_proyecto
          $data['id_proy']       = $this->input->post('id_proy'); //registro_proyecto
          $data['id_nivel']       = $this->input->post('id_nivel'); //registro_proyecto
          $data['profundidad']       = $this->input->post('profundidad'); //registro_proyecto

          $data['proyecto']         = $this->input->post('proyecto'); //nombre_proyecto o niveles
          $data['descripcion']     = $this->input->post('descripcion'); //descripcion_proyecto o niveles
          $data['costo']         = $this->input->post('costo'); //costo_proyecto o niveles
          $data['fecha_creacion']    = date("Y-m-d", strtotime($this->input->post('fecha_creacion')) );
          $data['fecha_inicial']     = date("Y-m-d", strtotime($this->input->post('fecha_inicial')) );
          $data['fecha_final']     = date("Y-m-d", strtotime($this->input->post('fecha_final')) );
          $data['id_val']        = $this->input->post('id_val');  //participantes_proyectos o niveles
          $data['json_items']      = $this->input->post('json_items'); //participantes_proyectos o niveles

           $existe            =  $this->modelo_proyecto->check_existente_proyecto( $data );
           //if ( $existe !== TRUE ){
           if ( TRUE ){

              $data               = $this->security->xss_clean($data);  

              if ($data['id_nivel']==1){ //root
                     $guardar            = $this->modelo_proyecto->editar_proyecto( $data );
              } else { //niveles desde el 2-n

                  $existe            = $this->modelo_proyecto->existe_nivel( $data );
                  if ($existe == true){ //editar
                      $guardar1            = $this->modelo_proyecto->editar_registro_nivel( $data );
                  } else { //agregar
                      $guardar1            = $this->modelo_proyecto->anadir_registro_nivel( $data );
                  }
                      
              }
              
              //die;

              //if ( $guardar !== FALSE ){
              if ( true ){  
               // $this->session->set_userdata('creando_proyecto', "0");   //listo para crear otro proyecto
                echo true;
              } else {
                echo '<span class="error"><b>E01</b> - El nuevo proyecto no pudo ser agregada</span>';
              }

           } else {
              echo '<span class="error"><b>E01</b> - El proyecto que desea agregar ya existe. No es posible agregar dos proyectos iguales.</span>';
           }  


      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  

function validacion_edicion_proyecto(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
      //echo $_POST[];
      //die;
        $this->form_validation->set_rules('proyecto', 'proyecto', 'trim|required|min_length[1]|max_length[80]|xss_clean');
	        
	      if ($this->form_validation->run() === TRUE){

          $data['id']           = $this->input->post('id');
          $data['proyecto']         = $this->input->post('proyecto');
		      $data['id_proy']   		 = $this->input->post('id_proy');
          $data['descripcion']   	 = $this->input->post('descripcion');
          $data['privacidad']   	 = $this->input->post('privacidad');
          $data['costo']   			 = $this->input->post('costo');
          $data['fecha_creacion']  	 = date("Y-m-d", strtotime($this->input->post('fecha_creacion')) );
          $data['fecha_inicial']  	 = date("Y-m-d", strtotime($this->input->post('fecha_inicial')) );
          $data['fecha_final']   	 = date("Y-m-d", strtotime($this->input->post('fecha_final')) );
          $data['contrato_firmado']  = $this->input->post('contrato_firmado');
          $data['pago_anticipado']   = $this->input->post('pago_anticipado');
          $data['factura_enviada']   = $this->input->post('factura_enviada');
          $data['id_val']  			 = $this->input->post('id_val');
          $data['json_items']   	 = $this->input->post('json_items');




	         $existe            =  $this->modelo_proyecto->check_existente_proyecto( $data );
	         //if ( $existe !== TRUE ){
	         if ( TRUE ){

	            $data               = $this->security->xss_clean($data);  
	            $guardar            = $this->modelo_proyecto->editar_proyecto( $data );
              //die;

	            if ( $guardar !== FALSE ){
	             // $this->session->set_userdata('creando_proyecto', "0");	 //listo para crear otro proyecto
	              echo true;
	            } else {
	              echo '<span class="error"><b>E01</b> - El nuevo proyecto no pudo ser agregada</span>';
	            }

	         } else {
	            echo '<span class="error"><b>E01</b> - El proyecto que desea agregar ya existe. No es posible agregar dos proyectos iguales.</span>';
	         }  


      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  




  function eliminar_proyecto($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

        $data['id']         = base64_decode($id);
        $data['nombrecompleto']   = base64_decode($nombrecompleto);
        
        $data['datos']['usuarios'] = $this->modelo->listado_usuarios();   
        $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos();  
        $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos();  
        //obtener la tabla a eliminar
        $data['proyecto'] = $this->modelo_proyecto->coger_proyecto($data);

      switch ($id_perfil) {    
        case 1:
                 $this->load->view( 'catalogos/proyectos/crud/eliminar_proyecto', $data );

          break;
        case 2:
        case 3:
        case 4:
              if  ( (in_array(1, $coleccion_id_operaciones)) )  { 
                     $this->load->view( 'catalogos/proyectos/crud/eliminar_proyecto', $data );
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


  function validar_eliminar_proyecto(){
    

       $data['id'] = $this->input->post('id');
            $tabla = $this->input->post('tabla');

    $eliminado = $this->modelo_proyecto->eliminar_proyecto(  $data );
    if ( $eliminado !== FALSE ){
    $this->load->dbforge();

    $tabla_struct  = ('struct_'.$tabla);
        $tabla_data  = ('data_'.$tabla); //$this->db->dbprefix

    $this->dbforge->drop_table($tabla_struct);
    $this->dbforge->drop_table($tabla_data);

      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la proyecto</span>';
    }
  }   



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////ENTORNOS/////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//***********************Entornos **********************************//


	public function listado_entornos(){
	
		$id_perfil=$this->session->userdata('id_perfil');

	    if($this->session->userdata('session') === TRUE ){
	    				
	    			  $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 	
	    			  $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos(); 	
	    			  $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	
	    			  
	    
	    	//comienzo "cancelaciones"			  
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



			          switch ($id_perfil) {    
			            case 1:		            
			                $this->load->view( 'catalogos/entornos/entornos',$data);
			              break;
			            
			            case 2: //
			            case 3: //
			            case 4: //

			                $this->load->view( 'catalogos/entornos/entornos',$data);
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






 public function procesando_cat_entornos(){

    $data=$_POST;
    $busqueda = $this->modelo_administracion->buscador_cat_entornos($data);
    echo $busqueda;
  } 




public function crear_tabla($nombre) {
/*
https://www.uno-de-piera.com/migraciones-en-codeigniter/
CREATE TABLE IF NOT EXISTS `tree_data` (
  `id` int(10) unsigned NOT NULL,
  `nm` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

*/			

		$this->load->dbforge();


		//creamos la estructura de una tabla con un 
		//id autoincremental, un campo varchar(255) para el nm
		//y otro para el passwords también varchar
		$this->dbforge->add_field(
			array(
				"id"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
					//"auto_increment"	=>		TRUE,
 
				),
				"nm"	=>		array(
					"type"				=>		"VARCHAR",
					"constraint"		=>		255,
				),
			)
		);



 
		$this->dbforge->add_key('id', TRUE);//establecemos id como primary_key
		$this->dbforge->create_table('data_'.$nombre);//creamos la tabla inven_prueba



		$this->dbforge->add_field(
			array(
				"id"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
					"auto_increment"	=>		TRUE,
				),
				"lft"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
				),
				"rgt"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
				),
				"lvl"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
				),
				"pid"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
				),
				"pos"		=>		array(
					"type"				=>		"INT",
					"constraint"		=>		11,
					"unsigned"			=>		TRUE,
				),
			)
		);


		$this->dbforge->add_key('id', TRUE);//establecemos id como primary_key
		$this->dbforge->create_table('struct_'.$nombre);//creamos la tabla inven_prueba


		//insertar registro en cada tabla

			$data["nombre"]="Proyecto";
			$data["tabla"]=$nombre;
			$this->modelo_administracion->insertar_registro_nuevas_tablas($data); 	
		 
		//$this->dbforge->drop_table('prueba');

}	


    // crear
  function nuevo_entorno(){
	if($this->session->userdata('session') === TRUE ){
	      $id_perfil=$this->session->userdata('id_perfil');
	      $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 	
	      $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos(); 	
	      $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	

	      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
	      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
	            $coleccion_id_operaciones = array();
	       }   

	      
	      //crear la tabla	
	      if ($this->session->userdata('creando_entorno') == "0") {
	      			   $data['nombre'] = date('Y').date('m').date('d').date('H').date('i').date('s').random_string('alpha',4).random_string('numeric',3);
	      			   $this->session->set_userdata('creando_entorno', $data['nombre']);	
				      self::crear_tabla($data['nombre']);
	      }
	      $data['nombre'] = $this->session->userdata('creando_entorno');
	       
		  $dato['id'] = 1;
          $data['depth_arbol'] =$this->modelo_administracion->coger_configuracion($dato)->valor; 
          $dato['id'] = 2;
	      $data['crea_multiple_simple'] =$this->modelo_administracion->coger_configuracion($dato)->valor; 
	      $data['ambito_app'] =1; 
	      $this->session->set_userdata('ambito_app', $data['ambito_app']);	
       	  
        
	      switch ($id_perfil) {    
	        case 1:
          case 2:
          case 3: //fa-expeditedssl
	            $this->load->view( 'catalogos/entornos/crud/nuevo_entorno',$data);
	          break;
	        case 4:
	             if  ( (in_array(1, $coleccion_id_operaciones)) )  { 
	                $this->load->view( 'catalogos/entornos/crud/nuevo_entorno',$data);
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



  function validar_nuevo_entorno(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
      $this->form_validation->set_rules('entorno', 'Entorno', 'trim|required|min_length[1]|max_length[80]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          $data['entorno']   = $this->input->post('entorno');

         $existe            =  $this->modelo_administracion->check_existente_entorno( $data );
         if ( $existe !== TRUE ){

            $data         =   $this->security->xss_clean($data);  
            $guardar            = $this->modelo_administracion->anadir_entorno( $data );
            if ( $guardar !== FALSE ){
              $this->session->set_userdata('creando_entorno', "0");	 //listo para crear otro entorno
              echo true;
            } else {
              echo '<span class="error"><b>E01</b> - El nuevo entorno no pudo ser agregada</span>';
            }
          } else {
            echo '<span class="error"><b>E01</b> - El entorno que desea agregar ya existe. No es posible agregar dos entornos iguales.</span>';
          }  

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }



  // editar
  function editar_entorno( $id ){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = base64_decode($id); 
       
		if ($data['id']!=0) {
			
	       $data['entorno'] = $this->modelo_administracion->coger_entorno($data) ;

			//lo pase 
			if ( $data['entorno'] !== FALSE ){       
	       			$this->session->set_userdata('creando_entorno', $data['entorno']->tabla);
	       	}		


		}       

   
/*
       print_r($data['id']);
       print_r($data['entorno']);
       print_r($this->session->userdata('creando_entorno'));
       
       die;
  */ 

       $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 	
       $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos(); 	
       $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	

		  $dato['id'] = 1;
          $data['depth_arbol'] =$this->modelo_administracion->coger_configuracion($dato)->valor; 
          $dato['id'] = 2;
	      $data['crea_multiple_simple'] =$this->modelo_administracion->coger_configuracion($dato)->valor; 
	      $data['ambito_app'] =1; 
	      $this->session->set_userdata('ambito_app', $data['ambito_app']);	

      switch ($id_perfil) {    
        case 1:
        case 2:
        case 3:

                  
                  if ( $data['entorno'] !== FALSE ){
                      $this->load->view( 'catalogos/entornos/crud/editar_entorno', $data );
                  } else {
                        redirect('/');
                  }       

          break;
        case 4:
               if  ( (in_array(1, $coleccion_id_operaciones)) )  { 
                  
                  if ( $data['entorno'] !== FALSE ){
                      $this->load->view( 'catalogos/entornos/crud/editar_entorno', $data );
                  } else {
                        redirect('/');
                  }       
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


function validacion_edicion_entorno(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
        $this->form_validation->set_rules('entorno', 'entorno', 'trim|required|min_length[1]|max_length[80]|xss_clean');
	        
	      if ($this->form_validation->run() === TRUE){
	            $data['id']           = $this->input->post('id');
	          $data['entorno']         = $this->input->post('entorno');

	         $existe            =  $this->modelo_administracion->check_existente_entorno( $data );
	         //if ( $existe !== TRUE ){
	         if ( TRUE ){

	            $data               = $this->security->xss_clean($data);  
	            $guardar            = $this->modelo_administracion->editar_entorno( $data );

              //print_r($guardar); die;
	            if ( $guardar !== FALSE ){
	              $this->session->set_userdata('creando_entorno', "0");	 //listo para crear otro entorno
	              echo true;
	            } else {
	              echo '<span class="error"><b>E01</b> - El nuevo entorno no pudo ser agregada</span>';
	            }

	         } else {
	            echo '<span class="error"><b>E01</b> - El entorno que desea agregar ya existe. No es posible agregar dos entornos iguales.</span>';
	         }  


      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }
  




  function eliminar_entorno($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

        $data['id']         = base64_decode($id);
        $data['nombrecompleto']   = base64_decode($nombrecompleto);
        
        $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 	
        $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos(); 	
        $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	
        //obtener la tabla a eliminar
        $data['entorno'] = $this->modelo_administracion->coger_entorno($data);

      switch ($id_perfil) {    
        case 1:
                 $this->load->view( 'catalogos/entornos/crud/eliminar_entorno', $data );

          break;
        case 2:
        case 3:
        case 4:
              if  ( (in_array(1, $coleccion_id_operaciones)) )  { 
                     $this->load->view( 'catalogos/entornos/crud/eliminar_entorno', $data );
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


  function validar_eliminar_entorno(){
    

       $data['id'] = $this->input->post('id');
            $tabla = $this->input->post('tabla');

    $eliminado = $this->modelo_administracion->eliminar_entorno(  $data );
    if ( $eliminado !== FALSE ){
		$this->load->dbforge();

		$tabla_struct  = ('struct_'.$tabla);
        $tabla_data  = ('data_'.$tabla); //$this->db->dbprefix

		$this->dbforge->drop_table($tabla_struct);
		$this->dbforge->drop_table($tabla_data);

      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la entorno</span>';
    }
  }   




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////












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
		$temp = $this->modelo_arbol->get_children($node);

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
			 $temp = $this->modelo_arbol->get_node((int)$node[0], array('with_path' => true));

			 //aqui se conforma el formato q voy a presentar del recorrido seleccionado
			 $rslt = array('content' => 'Seleccionado: /' . 
			 			                       implode('/',array_map(function ($v) { return $v['nm']; }, $temp['path'])).
			 			                       '/'.$temp['nm']
                    );
			 }
		 
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
		
	}


	// Este es solo para "renombrar el nodo"
	public function renombrar_nodo() {

		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;

		$rslt = $this->modelo_arbol->rn($node, //id
			 			array('nm' => isset($_GET['text']) ? $_GET['text'] : 'Renamed node') //data
			 );

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
		
	}




	//Eliminar el nodo, hijo, nieto, etc
	public function eliminar_nodo() {

				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;

				$rslt = $this->modelo_arbol->rm(
									$node //id
								);

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);

	}


	//crear un único nodo
	public function crear_nodo() {

		$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
		
		$temp = $this->modelo_arbol->mk($node,  //padre
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

		$rslt = $this->modelo_arbol->mv($node, //id
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
		redirect('/');
	}		



}
