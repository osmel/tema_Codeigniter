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




  public function busqueda_predictiva(){

    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {

   
       $data['key']=$_GET['key'];
       $data['nombre']=$_GET['nombre'];
       
       if (isset($_GET['idusuario'])) { 
        $data['idusuario']=$_GET['idusuario'];
       } 

       switch ($data['nombre']) {

        case 'editando_proyectos':
            $busqueda = $this->modelo_catalogo->buscador_proyectos($data);
          break;
        case 'editando_usuarios':
            $busqueda = $this->modelo_catalogo->buscador_usuarios($data);
              
          break;


       }
       

       echo $busqueda;
    }  
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


 // crear area
  function nuevo_area(){
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
              $this->load->view( 'catalogos/areas/crud/nuevo_area',$data);
            break;
          case 2:
          case 3:
          case 4:
               if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
                  $this->load->view( 'catalogos/areas/crud/nuevo_area',$data);
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



    
/////////



  function validar_nuevo_area(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
      $this->form_validation->set_rules('area', 'area', 'trim|required|min_length[1]|max_length[80]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          $data['area']   = $this->input->post('area');
          $data['monto']   = $this->input->post('monto');
          $data['telefono']   = $this->input->post('telefono');

         $existe            =  $this->modelo_catalogo->check_existente_area( $data );
         if ( $existe !== TRUE ){

            $data         =   $this->security->xss_clean($data);  
            $guardar            = $this->modelo_catalogo->anadir_area( $data );
            if ( $guardar !== FALSE ){
              echo true;
            } else {
              echo '<span class="error"><b>E01</b> - El nuevo area no pudo ser agregada</span>';
            }
          } else {
            echo '<span class="error"><b>E01</b> - El area que desea agregar ya existe. No es posible agregar dos areas iguales.</span>';
          }  

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }






 // editar
  function editar_area( $id ){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = base64_decode($id); 
       


       $data['datos']['usuarios'] = $this->modelo->listado_usuarios();  
       $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos();   
       $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos();   


       $data['area'] = $this->modelo_catalogo->coger_area($data);
        

      switch ($id_perfil) {    
        case 1:
                  
                
                      $this->load->view( 'catalogos/areas/crud/editar_area', $data );
                
          break;
        case 2:
        case 3:
        case 4:
               if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
                  
                
                      $this->load->view( 'catalogos/areas/crud/editar_area', $data );
                
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


function validacion_edicion_area(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
       $this->form_validation->set_rules('area', 'area', 'trim|required|min_length[1]|max_length[80]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          
          $data['id']           = $this->input->post('id'); 
          $data['area']   = $this->input->post('area');
          $data['monto']   = $this->input->post('monto');
          $data['telefono']   = $this->input->post('telefono');
          
          

            $data               = $this->security->xss_clean($data);  
            $guardar            = $this->modelo_catalogo->editar_area( $data );

            if ( $guardar !== FALSE ){
              echo true;

            } else {
              echo '<span class="error"><b>E01</b> - El nuevo area no pudo ser agregado</span>';
            }

         

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }



 function eliminar_area($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

            $data['id']         	= base64_decode($id);
            $data['nombrecompleto']  = base64_decode($nombrecompleto);

           
      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/areas/crud/eliminar_area', $data );

          break;
        case 2:
        case 3:
        case 4:
              if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
                $this->load->view( 'catalogos/areas/crud/eliminar_area', $data );
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





  function validar_eliminar_area(){
    
    $data['id']           = $this->input->post('id');

    $eliminado = $this->modelo_catalogo->eliminar_area(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar el area</span>';
    }
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



    // crear cargo
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
	             if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
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



    
/////////



  function validar_nuevo_cargo(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
      $this->form_validation->set_rules('cargo', 'Cargo', 'trim|required|min_length[1]|max_length[80]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          $data['cargo']   = $this->input->post('cargo');
          $data['lider']   = $this->input->post('lider');
          $data['activo']   = $this->input->post('activo');

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






 // editar
  function editar_cargo( $id ){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = base64_decode($id); 
       


       $data['datos']['usuarios'] = $this->modelo->listado_usuarios(); 	
       $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos(); 	
       $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos(); 	


       $data['cargo'] = $this->modelo_catalogo->coger_cargo($data);
        

      switch ($id_perfil) {    
        case 1:
                  
                
                      $this->load->view( 'catalogos/cargos/crud/editar_cargo', $data );
                
          break;
        case 2:
        case 3:
        case 4:
               if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
                  
                
                      $this->load->view( 'catalogos/cargos/crud/editar_cargo', $data );
                
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


function validacion_edicion_cargo(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
       $this->form_validation->set_rules('cargo', 'Cargo', 'trim|required|min_length[1]|max_length[80]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          
      	  $data['id']           = $this->input->post('id');	
          $data['cargo']   = $this->input->post('cargo');
          $data['lider']   = $this->input->post('lider');
          $data['activo']   = $this->input->post('activo');
          

            $data               = $this->security->xss_clean($data);  
            $guardar            = $this->modelo_catalogo->editar_cargo( $data );

            if ( $guardar !== FALSE ){
              echo true;

            } else {
              echo '<span class="error"><b>E01</b> - El nuevo cargo no pudo ser agregado</span>';
            }



      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }




function eliminar_cargo($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

            $data['id']           = base64_decode($id);
            $data['nombrecompleto']  = base64_decode($nombrecompleto);

           
      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/cargos/crud/eliminar_cargo', $data );

          break;
        case 2:
        case 3:
        case 4:
              if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
                $this->load->view( 'catalogos/cargos/crud/eliminar_cargo', $data );
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





  function validar_eliminar_cargo(){
    
    $data['id']           = $this->input->post('id');

    $eliminado = $this->modelo_catalogo->eliminar_cargo(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar el cargo</span>';
    }
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




 // crear perfil
  function nuevo_perfil(){
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
              $this->load->view( 'catalogos/perfiles/crud/nuevo_perfil',$data);
            break;
          case 2:
          case 3:
          case 4:
               if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
                  $this->load->view( 'catalogos/perfiles/crud/nuevo_perfil',$data);
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



    
/////////



  function validar_nuevo_perfil(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
      $this->form_validation->set_rules('perfil', 'perfil', 'trim|required|min_length[1]|max_length[80]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          $data['perfil']   = $this->input->post('perfil');
          $data['operacion']   = $this->input->post('operacion');
          

         $existe            =  $this->modelo_catalogo->check_existente_perfil( $data );
         if ( $existe !== TRUE ){

            $data         =   $this->security->xss_clean($data);  
            $guardar            = $this->modelo_catalogo->anadir_perfil( $data );
            if ( $guardar !== FALSE ){
              echo true;
            } else {
              echo '<span class="error"><b>E01</b> - El nuevo perfil no pudo ser agregada</span>';
            }
          } else {
            echo '<span class="error"><b>E01</b> - El perfil que desea agregar ya existe. No es posible agregar dos perfiles iguales.</span>';
          }  

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }






 // editar
  function editar_perfil( $id ){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = base64_decode($id); 
       


       $data['datos']['usuarios'] = $this->modelo->listado_usuarios();  
       $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos();   
       $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos();   


       $data['perfil'] = $this->modelo_catalogo->coger_perfil($data);
        

      switch ($id_perfil) {    
        case 1:
                  
                
                      $this->load->view( 'catalogos/perfiles/crud/editar_perfil', $data );
                
          break;
        case 2:
        case 3:
        case 4:
               if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
                  
                
                      $this->load->view( 'catalogos/perfiles/crud/editar_perfil', $data );
                
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


function validacion_edicion_perfil(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
       $this->form_validation->set_rules('perfil', 'perfil', 'trim|required|min_length[1]|max_length[80]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          
          $data['id']           = $this->input->post('id'); 
          $data['perfil']   = $this->input->post('perfil');
          $data['operacion']   = $this->input->post('operacion');
          
          

            $data               = $this->security->xss_clean($data);  
            $guardar            = $this->modelo_catalogo->editar_perfil( $data );

            if ( $guardar !== FALSE ){
              echo true;

            } else {
              echo '<span class="error"><b>E01</b> - El nuevo perfil no pudo ser agregado</span>';
            }



      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }


function eliminar_perfil($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

            $data['id']           = base64_decode($id);
            $data['nombrecompleto']  = base64_decode($nombrecompleto);

           
      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/perfiles/crud/eliminar_perfil', $data );

          break;
        case 2:
        case 3:
        case 4:
              if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
                $this->load->view( 'catalogos/perfiles/crud/eliminar_perfil', $data );
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





  function validar_eliminar_perfil(){
    
    $data['id']           = $this->input->post('id');

    $eliminado = $this->modelo_catalogo->eliminar_perfil(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar el perfil</span>';
    }
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






 // crear configuracion
  function nuevo_configuracion(){
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
              $this->load->view( 'catalogos/configuraciones/crud/nuevo_configuracion',$data);
            break;
          case 2:
          case 3:
          case 4:
               if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
                  $this->load->view( 'catalogos/configuraciones/crud/nuevo_configuracion',$data);
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



    
/////////



  function validar_nuevo_configuracion(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('/');
    } else {
      $this->form_validation->set_rules('configuracion', 'configuracion', 'trim|required|min_length[1]|max_length[80]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          $data['configuracion']   = $this->input->post('configuracion');
          $data['valor']   = $this->input->post('valor');
          $data['activo']   = $this->input->post('activo');

         $existe            =  $this->modelo_catalogo->check_existente_configuracion( $data );
         if ( $existe !== TRUE ){

            $data         =   $this->security->xss_clean($data);  
            $guardar            = $this->modelo_catalogo->anadir_configuracion( $data );
            if ( $guardar !== FALSE ){
              echo true;
            } else {
              echo '<span class="error"><b>E01</b> - El nuevo configuracion no pudo ser agregada</span>';
            }
          } else {
            echo '<span class="error"><b>E01</b> - El configuracion que desea agregar ya existe. No es posible agregar dos configuraciones iguales.</span>';
          }  

      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }






 // editar
  function editar_configuracion( $id ){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

       $data['id']  = base64_decode($id); 
       


       $data['datos']['usuarios'] = $this->modelo->listado_usuarios();  
       $data['datos']['entornos'] = $this->modelo_administracion->listado_entornos();   
       $data['datos']['proyectos'] = $this->modelo_proyecto->listado_proyectos();   


       $data['configuracion'] = $this->modelo_catalogo->coger_configuracion($data);
        

      switch ($id_perfil) {    
        case 1:
                  
                
                      $this->load->view( 'catalogos/configuraciones/crud/editar_configuracion', $data );
                
          break;
        case 2:
        case 3:
        case 4:
               if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
                  
                
                      $this->load->view( 'catalogos/configuraciones/crud/editar_configuracion', $data );
                
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


function validacion_edicion_configuracion(){
    if ($this->session->userdata('session') !== TRUE) {
      redirect('');
    } else {
       $this->form_validation->set_rules('configuracion', 'configuracion', 'trim|required|min_length[1]|max_length[80]|xss_clean');
      
      if ($this->form_validation->run() === TRUE){
          
          $data['id']           = $this->input->post('id'); 
          $data['configuracion']   = $this->input->post('configuracion');
          $data['valor']   = $this->input->post('valor');
          $data['activo']   = $this->input->post('activo');
          

            $data               = $this->security->xss_clean($data);  
            $guardar            = $this->modelo_catalogo->editar_configuracion( $data );

            if ( $guardar !== FALSE ){
              echo true;

            } else {
              echo '<span class="error"><b>E01</b> - El nuevo configuracion no pudo ser agregado</span>';
            }



      } else {      
        echo validation_errors('<span class="error">','</span>');
      }
    }
  }




function eliminar_configuracion($id = '', $nombrecompleto=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

            $data['id']           = base64_decode($id);
            $data['nombrecompleto']  = base64_decode($nombrecompleto);

           
      switch ($id_perfil) {    
        case 1:
            $this->load->view( 'catalogos/configuraciones/crud/eliminar_configuracion', $data );

          break;
        case 2:
        case 3:
        case 4:
              if  ( (in_array(4, $coleccion_id_operaciones)) )  { 
                $this->load->view( 'catalogos/configuraciones/crud/eliminar_configuracion', $data );
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





  function validar_eliminar_configuracion(){
    
    $data['id']           = $this->input->post('id');

    $eliminado = $this->modelo_catalogo->eliminar_configuracion(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar el configuracion</span>';
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

