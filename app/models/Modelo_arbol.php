<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class Modelo_arbol extends CI_Model{
		
		private $key_hash;
		private $timezone;

		function __construct(){
			parent::__construct();
			$this->load->database("default");
			$this->key_hash    = $_SERVER['HASH_ENCRYPT'];
			$this->timezone    = 'UM1';

      
      date_default_timezone_set('America/Mexico_City'); 


				//usuarios
			     $this->usuarios    = $this->db->dbprefix('usuarios');
            $this->perfiles    = $this->db->dbprefix('perfiles');
            $this->catalogo_operaciones    = $this->db->dbprefix('catalogo_operaciones');
            $this->proveedores             = $this->db->dbprefix('catalogo_empresas');
            
            $this->historico_acceso = $this->db->dbprefix('historico_acceso');

      
              $this->catalogo_entornos                         = $this->db->dbprefix('catalogo_entornos');


            if ($this->session->userdata('ambito_app')==1) { //entorno
              $this->struct                         = $this->db->dbprefix('struct_'.$this->session->userdata('creando_entorno') );
              $this->data                           = $this->db->dbprefix('data_'.$this->session->userdata('creando_entorno') );
            } else { //proyecto
              $this->struct                         = $this->db->dbprefix('pstruct_'.$this->session->userdata('creando_proyecto') );
              $this->data                           = $this->db->dbprefix('pdata_'.$this->session->userdata('creando_proyecto') );
            }
             


               $this->options   = array(
                                    'data' => array('nm'),

                              'structure'  => array(     // which field (value) maps to what in the structure (key)
                                          'id'      => 'id',
                                          'left'      => 'lft',
                                          'right'     => 'rgt',
                                          'level'     => 'lvl',
                                          'parent_id'   => 'pid',
                                          'position'    => 'pos'
                                  ),

                          ); 


               

		}

  public function get_node($id, $options = array()) {
        $this->db->select("s.id, s.lft, s.rgt, s.lvl, s.pid, s.pos, d.nm");         
        $this->db->from($this->struct.' As s');
        $this->db->join($this->data.' As d', 's.id = d.id');

         $where = '(
                      ( s.id = '.(int)$id.' ) 
         )';   

        $this->db->where($where);  

        $sql = $this->db->get();

        if ($sql->num_rows() > 0)
            $node = json_decode(json_encode($sql->row()), true);
        else
            $node = false;
        

        if(!$node) {
          throw new Exception('Este nodo no existe');
        }
        if(isset($options['with_children'])) {
          //$node['children'] = $this->get_children($id, isset($options['deep_children']));
          $node['children'] = self::get_children($id, isset($options['deep_children'])); //? quien es $options['deep_children'] ?
        }
        
        if(isset($options['with_path'])) { //para obtener solo el recorrido que esta seleccionado
           $node['path'] = self::get_path($id);
        }
       
    return $node; //return json_decode(json_encode($node), true);
  }

  public function get_children($id, $recursive = false) {
               //$this->struct                         = $this->db->dbprefix('struct_'.$this->session->userdata('creando_entorno') );
               //$this->data                         = $this->db->dbprefix('data_'.$this->session->userdata('creando_entorno') );

               //return $this->struct;

    $sql = false;

    if($recursive) {
        $node = self::get_node($id);
        
           $this->db->select("s.id, s.lft, s.rgt, s.lvl, s.pid, s.pos, d.nm");         
          $this->db->from($this->struct.' As s');
          $this->db->join($this->data.' As d', 's.id = d.id');

          $where = '(
                        ( s.lft > '.(int)$node["lft"].' ) AND
                        ( s.rgt < '.(int)$node["rgt"].' ) 
            )';   

          $this->db->where($where);  
          $this->db->order_by('s.lft', 'ASC');  //s.".$this->options['structure']['left']."
                  
          $sql = $this->db->get();

    }
    else {
     
          $this->db->select("s.id, s.lft, s.rgt, s.lvl, s.pid, s.pos, d.nm");         
          $this->db->from($this->struct.' As s');
          $this->db->join($this->data.' As d', 's.id = d.id');

          $where = '(
                        ( s.pid = '.(int)$id.' ) 
            )';   

          $this->db->where($where);  
          $this->db->order_by('s.pos', 'ASC');  //ORDER BY s.pos
                  
          $sql = $this->db->get();
    }
        
        if ($sql->num_rows() > 0)
          return json_decode(json_encode($sql->result()), true);
            
        else
            return false;

  }



//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
  //este es para obtener solo el recorrido que esta seleccionado

  /*
    Es llamado atravez de la obtencion del nodo 
  */

  public function get_path($id) {   //este es para obtener solo el recorrido que esta seleccionado
    
    $node = self::get_node($id); 
   
    $sql = false;
    if($node) {
      
        $this->db->select("s.id, s.lft, s.rgt, s.lvl, s.pid, s.pos, d.nm");         
        $this->db->from($this->struct.' As s');
        $this->db->join($this->data.' As d', 's.id = d.id');

        $where = '(
                      ( s.lft < '.(int)$node["lft"].' ) AND
                      ( s.rgt > '.(int)$node["rgt"].' ) 
          )';   

        $this->db->where($where);  
        $this->db->order_by('s.lft', 'ASC');  //ORDER BY s.lft  s.pos
                
        $sql = $this->db->get();

    }
        
        if ($sql->num_rows() > 0)
            return json_decode(json_encode($sql->result()), true);
        else
          return false; // return $node["lft"].'  - '.$node["rgt"];
       
  }






//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
  
  //este es solo para renombrar el nodo  
  public function rn($id, $data) {

        $this->db->select("1 as res",FALSE);
        $this->db->from($this->struct.' as s');
        $this->db->where('id',(int)$id);
        $cant = $this->db->count_all_results();          
        //if (!(int)json_decode(json_encode($sql->row()), true)) {
        if ($cant=0) {
            throw new Exception('no se puede renombrar un nodo que no existe');
        }

      
      $tmp = array();

      foreach($this->options['data'] as $v) {
        if(isset($data[$v])) {
          $tmp[$v] = $data[$v];
        }
      }

      if(count($tmp)) {
          $tmp['id'] = $id;

          //https://andrezgz.wordpress.com/
          $sql = "insert into  ".$this->data." (id, nm) values(".$tmp['id'].",'".$tmp['nm']."') on duplicate key update  id=".$tmp['id'].",nm='".$tmp['nm']."'";

          $result = $this->db->query($sql, array($tmp['id'], $tmp['nm'])); 
      }

      if ($this->db->affected_rows() > 0){
                return TRUE;
            } else {
                return FALSE;
       }
      $result->free_result();
         
  }







//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
  
  //Este es solo para "Eliminar el nodo, hijo, nieto, etc"


public function rm($id) {

    $id = (int)$id;

    if(!$id || $id === 1) { throw new Exception('No podra crear raices internas'); }


    //obtener el nodo con sus hijos, nietos, etc, 
    //retornará un array con un elemento [children "donde apareceran todos"]
    $data = self::get_node($id, array('with_children' => true, 'deep_children' => true)); //"con hijos" y con "profundidad"
  

    $lft = (int)$data["lft"];
    $rgt = (int)$data["rgt"];
    $pid = (int)$data["pid"];
    $pos = (int)$data["pos"];
    $dif = $rgt - $lft + 1;

   
    // Borrando el nodo y sus hijos de la tabla struct
    $this->db->delete( $this->struct, array( 'lft >=' => (int)$lft,'rgt <=' => (int)$rgt ) );
   
    
    // Desplazar los índices izquierdos de los nodos a la derecha del nodo        
      $this->db->set( 'lft', "lft -".(int)$dif, false );  
      $this->db->where('lft >', (int)$rgt );
      $this->db->update($this->struct );

    // desplazar los índices derechos de nodos a la derecha del nodo y los padres del nodo
         $this->db->set( 'rgt', "rgt -".(int)$dif, false );  
      $this->db->where('rgt >', (int)$lft );
      $this->db->update($this->struct );


    // Actualizar la posición de los hermanos debajo del nodo eliminado
      $this->db->set( 'pos', "pos - 1", false );  
      $this->db->where('pid', $pid );
      $this->db->where('pos >', (int)$pos );
      $this->db->update($this->struct );



    // Eliminar los datos de la tabla data
    if($this->data) {
      $tmp = array();
      $tmp[] = (int)$data['id'];
      if($data['children'] && is_array($data['children'])) {
        foreach($data['children'] as $v) {
          $tmp[] = (int)$v['id'];
        }
      }


      $arreglo =  "('".implode("','",$tmp)."')";
      $where = "(
                             ( id IN ".$arreglo." ) 
              )";   
      $this->db->where($where);
      $this->db->delete($this->data);

      
    }

   
    return true;
  }





//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
  
  //Este es solo para "crear un único nodo"

    public function mk($parent, $position = 0, $data = array()) {


        
        $parent = (int)$parent;
        if($parent == 0) { throw new Exception('Padre es 0'); }

        //obtener el padre con sus hijos
        $parent = self::get_node($parent, array('with_children'=> true));

        //si padre no tiene hijos entonces posicion que va a tomar el nuevo nodo es 0
        if(!$parent['children']) { $position = 0; }

        //si el padre si tiene hijos entonces la posicion que va a tomar es la ultima de sus hijos
        if($parent['children'] && $position >= count($parent['children'])) { $position = count($parent['children']); }

        $sql = array();
        $par = array();

      
          // Preparar nuevo padre
          // Actualizar las posiciones de todos los proximos elementos 

          $this->db->set( 'pos', "pos + 1", false );  
          $this->db->where('pid', (int)$parent["id"] );
          $this->db->where('pos >=', $position );
          $this->db->update($this->struct );
        

     $par[] = false;

        // Actualizar indices izquierdos
        $ref_lft = false;
        if(!$parent['children']) {
          $ref_lft = $parent["rgt"];
        }
        else if(!isset($parent['children'][$position])) {
          $ref_lft = $parent["rgt"];
        }
        else {
          $ref_lft = $parent['children'][(int)$position]["lft"];
        }
        
    

          $this->db->set( 'lft', "lft + 2", false );  
          $this->db->where('lft >=', (int)$ref_lft );
          $this->db->update($this->struct );

        $par[] = false;

        // Actualizar indices derechos
        $ref_rgt = false;
        if(!$parent['children']) {
          $ref_rgt = $parent["rgt"];
        }
        else if(!isset($parent['children'][$position])) {
          $ref_rgt = $parent["rgt"];
        }
        else {
          $ref_rgt = $parent['children'][(int)$position]["lft"] + 1;
        }
     

          $this->db->set( 'rgt', "rgt + 2", false );  
          $this->db->where('rgt >=', (int)$ref_rgt );
          $this->db->update($this->struct );



          $this->db->set( 'id', null );  
          $this->db->set( 'lft', (int)$ref_lft );  
          $this->db->set( 'rgt', (int)$ref_lft + 1 );  
          $this->db->set( 'lvl', (int)$parent["lvl"] + 1 );  
          $this->db->set( 'pid', $parent["id"] );  
          $this->db->set( 'pos', $position );  
          $this->db->insert($this->struct );



 


        if($data && count($data)) {
          $node = $this->db->insert_id(); //obtener el id
          
          if(!self::rn($node,$data)) {  //renombrar el nodo 189
            self::rm($node); //eliminar el nodo 241
            throw new Exception('No puedes renombrar despues de crear '); //Could not rename after create
          }
          
        }
        return $node;
      }




//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
  //Este es solo para "mover un nodo, en caso de tener hijos, nietos, etc, se moveran tambien"

  public function mv($id, $parent, $position = 0) {
    $id     = (int)$id;
    $parent   = (int)$parent;
    if($parent == 0 || $id == 0 || $id == 1) {
      throw new Exception('No se puede mover dentro de cero o mover el nodo raiz');
    }

    //devolver al padre, junto con todos sus hijos, nietos, etc y el path
    $parent   = self::get_node($parent, array('with_children'=> true, 'with_path' => true));

    //devolcer al padre, junto con todos sus hijos, nietos, etc, la profundida y el path
    $id     = self::get_node($id, array('with_children'=> true, 'deep_children' => true, 'with_path' => true));
    if(!$parent['children']) {
      $position = 0;
    }

    if($id["pid"] == $parent["id"] && $position > $id["pos"]) {
      $position ++;
    }
    if($parent['children'] && $position >= count($parent['children'])) {
      $position = count($parent['children']);
    }
    if($id["lft"] < $parent["lft"] && $id["rgt"] > $parent["rgt"]) {
      throw new Exception('No se pudo mover al padre dentro del hijo');
    }

  

    $tmp = array();
    $tmp[] = (int)$id["id"];
    if($id['children'] && is_array($id['children'])) {
      foreach($id['children'] as $c) {
        $tmp[] = (int)$c["id"];
      }
    }
    $width = (int)$id["rgt"] - (int)$id["lft"] + 1;

    $sql = array();

     
     //PREPARAR NUEVOS PADRES
     //actualizar las posiciones de todos los proximos elementos 

      $this->db->set( "pos", "pos + 1", false );  
      
      $this->db->where('id !=', (int)$id["id"] );
      $this->db->where('pid =', (int)$parent["id"] );
      $this->db->where('pos >=', $position );

      $this->db->update($this->struct );


    // update left indexes
    $ref_lft = false;
    if(!$parent['children']) {
      $ref_lft = $parent["rgt"];
    }
    else if(!isset($parent['children'][$position])) {
      $ref_lft = $parent["rgt"];
    }
    else {
      $ref_lft = $parent['children'][(int)$position]["lft"];
    }


      $this->db->set( 'lft', "lft + ".$width, false );  
      $arreglo =  "('".implode("','",$tmp)."')";
      $where = "(
                             ( id NOT IN ".$arreglo." ) AND 
                             ( lft >=".(int)$ref_lft." )
              )";   
      $this->db->where($where);
      $this->db->update($this->struct );


    // update right indexes
    $ref_rgt = false;
    if(!$parent['children']) {
      $ref_rgt = $parent["rgt"];
    }
    else if(!isset($parent['children'][$position])) {
      $ref_rgt = $parent["rgt"];
    }
    else {
      $ref_rgt = $parent['children'][(int)$position]["lft"] + 1;
    }


      $this->db->set( 'rgt', "rgt + ".$width, false );  
      $arreglo =  "('".implode("','",$tmp)."')";
      $where = "(
                             ( id NOT IN ".$arreglo." ) AND 
                             ( rgt >=".(int)$ref_rgt." )
              )";   
      $this->db->where($where);
      $this->db->update($this->struct );



    // MOVE THE ELEMENT AND CHILDREN
    // left, right and level
    $diff = $ref_lft - (int)$id["lft"];

    if($diff > 0) { $diff = $diff - $width; }
    $ldiff = ((int)$parent["lvl"] + 1) - (int)$id["lvl"];
    
       $this->db->set( 'rgt', "rgt + ".$diff, false );  
      $this->db->set( 'lft', "lft + ".$diff, false );  
      $this->db->set( 'lvl', "lvl + ".$ldiff, false );  

      $arreglo =  "('".implode("','",$tmp)."')";
      $where = "(
                             ( id IN ".$arreglo." ) 
                             
              )";   
      $this->db->where($where);
      $this->db->update($this->struct );



    // position and parent_id
  
      $this->db->set( 'pos', $position );  
      $this->db->set( 'pid', (int)$parent["id"]);  
      $this->db->where('id', (int)$id["id"] );
      $this->db->update($this->struct );



    // CLEAN OLD PARENT
    // position of all next elements
  
      $this->db->set( 'pos', "pos - 1", false ); 
      $this->db->where('pid', (int)$id["pid"] );
      $this->db->where('pos >', (int)$id["pos"] );
      $this->db->update($this->struct );


    // left indexes

      $this->db->set( 'lft', "lft - ".$width, false );  
      $arreglo =  "('".implode("','",$tmp)."')";
      $where = "(
                             ( id NOT IN ".$arreglo." ) AND 
                             ( lft >".(int)$id["rgt"]." )
              )";   
      $this->db->where($where);
      $this->db->update($this->struct );


    // right indexes
       $this->db->set( 'rgt', "rgt - ".$width, false );  
      $arreglo =  "('".implode("','",$tmp)."')";
      $where = "(
                             ( id NOT IN ".$arreglo." ) AND 
                             ( rgt >".(int)$id["rgt"]." )
              )";   
      $this->db->where($where);
      $this->db->update($this->struct );

    return true;
  }


} 
?>