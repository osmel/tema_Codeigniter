<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class Modelo_catalogo extends CI_Model{
		
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

      
              $this->registros_temporales               = $this->db->dbprefix('temporal_registros');
              $this->registros_cambios               = $this->db->dbprefix('registros_cambios');
              $this->registros_entradas             = $this->db->dbprefix('registros_entradas');
              $this->registros_salidas       = $this->db->dbprefix('registros_salidas');
              $this->historico_registros_entradas = $this->db->dbprefix('historico_registros_entradas');
              $this->historico_registros_salidas    = $this->db->dbprefix('historico_registros_salidas');
              $this->almacenes                         = $this->db->dbprefix('catalogo_almacenes');


               $this->struct                         = $this->db->dbprefix('struct');
               $this->data                         = $this->db->dbprefix('data');
               

		}


  public function get_children($id, $recursive = false) {
    $sql = false;
    if($recursive) {
      $node = $this->get_node($id);
      $sql = "
        SELECT
          s.".implode(", s.", $this->options['structure']).",
          d.".implode(", d.", $this->options['data'])."
        FROM
          ".$this->options['structure_table']." s,
          ".$this->options['data_table']." d
        WHERE
          s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
          s.".$this->options['structure']['left']." > ".(int)$node[$this->options['structure']['left']]." AND
          s.".$this->options['structure']['right']." < ".(int)$node[$this->options['structure']['right']]."
        ORDER BY
          s.".$this->options['structure']['left']."
      ";
    }
    else {
      $sql = "
        SELECT
          s.".implode(", s.", $this->options['structure']).",
          d.".implode(", d.", $this->options['data'])."
        FROM
          ".$this->options['structure_table']." s,
          ".$this->options['data_table']." d
        WHERE
          s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
          s.".$this->options['structure']['parent_id']." = ".(int)$id."
        ORDER BY
          s.".$this->options['structure']['position']."
      ";
    }
    return $this->db->all($sql);
  }

























  public function obtener_path($id) {
    $node = $this->get_node($id);
    $sql = false;
    if($node) {
      $sql = "
        SELECT
          s.".implode(", s.", $this->options['structure']).",
          d.".implode(", d.", $this->options['data'])."
        FROM
          ".$this->options['structure_table']." s,
          ".$this->options['data_table']." d
        WHERE
          s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
          s.".$this->options['structure']['left']." < ".(int)$node[$this->options['structure']['left']]." AND
          s.".$this->options['structure']['right']." > ".(int)$node[$this->options['structure']['right']]."
        ORDER BY
          s.".$this->options['structure']['left']."
      ";
    }
    return $sql ? $this->db->all($sql) : false;
  }


/*
Array ( 
    [structure_table] => tree_struct 
    [data_table] => tree_data 

    [data2structure] => id
     
    [structure] => Array (
                           [id] => id 
                         [left] => lft 
                        [right] => rgt 
                        [level] => lvl 
                    [parent_id] => pid 
                    [position] => pos 
           )

     [data] => Array ( [0] => nm ) )
*/

               /*
            $this->db->select('u.id, nombre,  apellidos');

            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->select( "AES_DECRYPT( telefono,'{$this->key_hash}') AS telefono", FALSE );
            $this->db->select('p.id_perfil,p.perfil,p.operacion');
            
            $this->db->from($this->usuarios.' as u');
            $this->db->join($this->perfiles.' as p', 'u.id_perfil = p.id_perfil');

            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();*/    

    

/*
    $node = $this->db->one("
      SELECT
        s.".implode(", s.", $this->options['structure']).",
        d.".implode(", d.", $this->options['data'])."
      FROM
        ".$this->options['structure_table']." s,
        ".$this->options['data_table']." d
      WHERE
        s.".$this->options['structure']['id']." = d.".$this->options['data2structure']."
         AND
        s.".$this->options['structure']['id']." = ".(int)$id
    );
*/



public function obtener_hijo($id, $recursive = false) {
    $sql = false;
    if($recursive) {
      $node = $this->get_node($id);
      $sql = "
        SELECT
          s.".implode(", s.", $this->options['structure']).",
          d.".implode(", d.", $this->options['data'])."
        FROM
          ".$this->options['structure_table']." s,
          ".$this->options['data_table']." d
        WHERE
          s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
          s.".$this->options['structure']['left']." > ".(int)$node[$this->options['structure']['left']]." AND
          s.".$this->options['structure']['right']." < ".(int)$node[$this->options['structure']['right']]."
        ORDER BY
          s.".$this->options['structure']['left']."
      ";
    }
    else {
      $sql = "
        SELECT
          s.".implode(", s.", $this->options['structure']).",
          d.".implode(", d.", $this->options['data'])."
        FROM
          ".$this->options['structure_table']." s,
          ".$this->options['data_table']." d
        WHERE
          s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
          s.".$this->options['structure']['parent_id']." = ".(int)$id."
        ORDER BY
          s.".$this->options['structure']['position']."
      ";
    }
    return $this->db->all($sql);
  }

  public function obtener_nodo($id, $options = array()) {

              $this->db->select('s.id, s.lft, s.rgt, s.lvl, s.pid, s.pos');
              $this->db->select('d.id, d.nm');

              $this->db->from($this->struct.' as s');
              $this->db->join($this->data.' as d', 'd.id = s.id');

              $where = '(
                          (
                           ( s.id = '.(int)$id.' )
                          )
                   )';   

                $this->db->where($where);             


    if(!$node) {
      throw new Exception('Node does not exist');
    }
    if(isset($options['con_hijo'])) {
      $node['hijo'] = $this->obtener_hijo($id, isset($options['profundidad_hijo']));
    }
    if(isset($options['con_path'])) {
      $node['path'] = $this->obtener_path($id);
    }
    return $node;

}


    public function crear_nodo($padre, $posicion = 0, $dato_nodo = array()) {
        $padre = (int)$padre;
        if($padre == 0) { throw new Exception('Padre is 0'); }

        $padre = $this->obtener_nodo($padre, array('con_hijo'=> true));











        if(!$padre['hijo']) { $posicion = 0; }
        if($padre['hijo'] && $posicion >= count($padre['hijo'])) { $posicion = count($padre['hijo']); }

        $sql = array();
        $par = array();

        // PREPARE NEW PARENT
        // update positions of all next elements
        $sql[] = "
          UPDATE ".$this->options['structure_table']."
            SET ".$this->options['structure']["position"]." = ".$this->options['structure']["position"]." + 1
          WHERE
            ".$this->options['structure']["parent_id"]." = ".(int)$padre[$this->options['structure']['id']]." AND
            ".$this->options['structure']["position"]." >= ".$posicion."
          ";
        $par[] = false;

        // update left indexes
        $ref_lft = false;
        if(!$padre['hijo']) {
          $ref_lft = $padre[$this->options['structure']["right"]];
        }
        else if(!isset($padre['hijo'][$posicion])) {
          $ref_lft = $padre[$this->options['structure']["right"]];
        }
        else {
          $ref_lft = $padre['hijo'][(int)$posicion][$this->options['structure']["left"]];
        }
        $sql[] = "
          UPDATE ".$this->options['structure_table']."
            SET ".$this->options['structure']["left"]." = ".$this->options['structure']["left"]." + 2
          WHERE
            ".$this->options['structure']["left"]." >= ".(int)$ref_lft."
          ";
        $par[] = false;

        // update right indexes
        $ref_rgt = false;
        if(!$padre['hijo']) {
          $ref_rgt = $padre[$this->options['structure']["right"]];
        }
        else if(!isset($padre['hijo'][$posicion])) {
          $ref_rgt = $padre[$this->options['structure']["right"]];
        }
        else {
          $ref_rgt = $padre['hijo'][(int)$posicion][$this->options['structure']["left"]] + 1;
        }
        $sql[] = "
          UPDATE ".$this->options['structure_table']."
            SET ".$this->options['structure']["right"]." = ".$this->options['structure']["right"]." + 2
          WHERE
            ".$this->options['structure']["right"]." >= ".(int)$ref_rgt."
          ";
        $par[] = false;

        // INSERT NEW NODE IN STRUCTURE
        $sql[] = "INSERT INTO ".$this->options['structure_table']." (".implode(",", $this->options['structure']).") VALUES (?".str_repeat(',?', count($this->options['structure']) - 1).")";
        $tmp = array();
        foreach($this->options['structure'] as $k => $v) {
          switch($k) {
            case 'id':
              $tmp[] = null;
              break;
            case 'left':
              $tmp[] = (int)$ref_lft;
              break;
            case 'right':
              $tmp[] = (int)$ref_lft + 1;
              break;
            case 'level':
              $tmp[] = (int)$padre[$v] + 1;
              break;
            case 'parent_id':
              $tmp[] = $padre[$this->options['structure']['id']];
              break;
            case 'position':
              $tmp[] = $posicion;
              break;
            default:
              $tmp[] = null;
          }
        }
        $par[] = $tmp;

        foreach($sql as $k => $v) {
          try {
            $this->db->query($v, $par[$k]);
          } catch(Exception $e) {
            $this->reconstruct();
            throw new Exception('Could not create');
          }
        }
        if($dato_nodo && count($dato_nodo)) {
          $node = $this->db->insert_id();
          if(!$this->rn($node,$dato_nodo)) {
            $this->rm($node);
            throw new Exception('Could not rename after create');
          }
        }
        return $node;
      }
          




	} 
?>