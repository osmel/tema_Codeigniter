<?php
  public function procesando_cat_entornos(){

    $data=$_POST;
    $busqueda = $this->modelo_catalogo->buscador_cat_entornos($data);
    echo $busqueda;
  } 







  // eliminar



  function eliminar_entorno($id = '', $nombrecompleto='', $tabla=''){
      if($this->session->userdata('session') === TRUE ){
      $id_perfil=$this->session->userdata('id_perfil');

      $coleccion_id_operaciones= json_decode($this->session->userdata('coleccion_id_operaciones')); 
      if ( (count($coleccion_id_operaciones)==0) || (!($coleccion_id_operaciones)) ) {
            $coleccion_id_operaciones = array();
       }   

        $data['nombrecompleto']   = base64_decode($nombrecompleto);
        $data['tabla']   = base64_decode($tabla);
        $data['id']         = $id;

      switch ($id_perfil) {    
        case 1:
                 $this->load->view( 'catalogos/entornos/eliminar_entorno', $data );

          break;
        case 2:
        case 3:
        case 4:
              if  ( (in_array(8, $coleccion_id_operaciones))  || (in_array(12, $coleccion_id_operaciones))  )  { 
                     $this->load->view( 'catalogos/entornos/eliminar_entorno', $data );
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


  function validar_eliminar_entorno(){
    if (!empty($_POST['id'])){ 
      $data['id'] = $_POST['id'];
    }
    $eliminado = $this->modelo_catalogo->eliminar_entorno(  $data );
    if ( $eliminado !== FALSE ){
      echo TRUE;
    } else {
      echo '<span class="error">No se ha podido eliminar la entorno</span>';
    }
  }   
