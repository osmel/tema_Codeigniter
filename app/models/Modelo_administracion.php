<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class Modelo_administracion extends CI_Model{
		
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
            
            $this->historico_acceso    = $this->db->dbprefix('historico_acceso');
            $this->configuraciones    = $this->db->dbprefix('catalogo_configuraciones');

      
              $this->catalogo_entornos                         = $this->db->dbprefix('catalogo_entornos');
              $this->catalogo_proyectos                         = $this->db->dbprefix('catalogo_proyectos');
              $this->registro_proyecto                         = $this->db->dbprefix('registro_proyecto');


              
              

		}



      public function coger_configuracion( $data ){
                
              $this->db->select("c.id, c.configuracion,c.activo,c.valor");         
              $this->db->from($this->configuraciones.' As c');
              $this->db->where('c.id',$data['id']);
              $result = $this->db->get(  );
                  if ($result->num_rows() > 0)
                      return $result->row();
                  else 
                      return FALSE;
                  $result->free_result();
       }  

        public function insertar_registro_nuevas_tablas($data) {
                
          $this->db->set( 'id', 1 );  
          $this->db->set( 'lft', 1 );  
          $this->db->set( 'rgt', 2 );  
          $this->db->set( 'lvl', 0 );  
          $this->db->set( 'pid', 0 );  
          $this->db->set( 'pos', 0 );  
          $this->db->insert("struct_".$data["tabla"] );

          $this->db->set( 'id', 1 );  
          $this->db->set( 'nm',  $data["nombre"] );  
          $this->db->insert("data_".$data["tabla"] );      

          return true;    

        }  


   //checar si el entorno por TABLA ya existe
    public function check_existente_entorno_tabla($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->catalogo_entornos);
            $this->db->where('tabla',$data['tabla']);  
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 


   //checar si el entorno ya existe
    public function check_existente_entorno($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->catalogo_entornos);
            $this->db->where('entorno',$data['entorno']);  
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 






   //checar si el entorno ya existe
    public function profundidad($tabla){
            
              $tabla  = $this->db->dbprefix('struct_'.$tabla);
              $sql = "select MAX(profundidad.depth) max_profundida_arbol from  (
                            SELECT nodo.id, (COUNT(padre.id) - 1) AS depth
                            FROM ".$tabla." AS nodo,
                                    ".$tabla." AS padre
                            WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                            GROUP BY nodo.id
                            ORDER BY nodo.lft
                            )
                             profundidad";

             $query = $this->db->query($sql);                




            if ($query->num_rows() > 0)
                return $query->row()->max_profundida_arbol+1;
            else
                return 0;
            $login->free_result();
    } 



   //checar si el entorno ya existe
    public function ruta($tabla){
            //http://www.teacupapps.com/blog/mysql/concatenar-varias-filas-en-una-con-mysql
              $tabla_struct  = $this->db->dbprefix('struct_'.$tabla);
              $tabla_data  = $this->db->dbprefix('data_'.$tabla);
              $sql="
              select GROUP_CONCAT(data.nm SEPARATOR ' / ') ruta 
                 from(
                    SELECT nodo.id, (COUNT(padre.id) - 1) AS depth
                    FROM ".$tabla_struct." AS nodo,
                            ".$tabla_struct." AS padre
                    WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                    GROUP BY nodo.id
                    ORDER BY nodo.lft
                ) profundidad
                INNER JOIN ".$tabla_data." data ON data.id=profundidad.id
              ";                

             $query = $this->db->query($sql);                

            if ($query->num_rows() > 0)
                return $query->row()->ruta;
            else
                return 'vacio';
            $login->free_result();
    } 






      //crear
        public function anadir_entorno( $data ){
          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'entorno', $data['entorno'] );  
          $this->db->set( 'tabla', $this->session->userdata('creando_entorno') );  

          $profundidad = self::profundidad($this->session->userdata('creando_entorno'));
          $ruta = self::ruta($this->session->userdata('creando_entorno'));

          $this->db->set( 'profundidad', $profundidad );  
          $this->db->set( 'ruta', $ruta );  


          $this->db->insert($this->catalogo_entornos );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }    




      public function buscador_cat_entornos($data){

          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];
                 /*
           if ($data['draw'] ==1) { //que se ordene por el ultimo
                 $columa_order ='-1';
                 $order = 'desc';
           } */



          switch ($columa_order) {
                   case '0':
                        $columna = 'c.entorno';
                     break;
                   case '1':
                        $columna = 'c.tabla'; //, tabla
                     break;
                   case '2':
                        $columna = 'c.profundidad'; //, tabla
                     break;                 
                  case '3':
                        $columna = 'c.ruta'; //, tabla
                     break;                     
                   default:
                        $columna = 'c.id';
                     break;
                 }                 

                                      

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          $this->db->select('c.id, c.entorno, c.tabla, c.profundidad, c.ruta');

          $this->db->from($this->catalogo_entornos.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id LIKE  "%'.$cadena.'%" ) OR 
                        ( c.ruta LIKE  "%'.$cadena.'%" ) OR (c.entorno LIKE  "%'.$cadena.'%") OR (c.tabla LIKE  "%'.$cadena.'%") 
                        
                       )
            )';   



  
          $this->db->where($where);
    
          //ordenacion
          $this->db->order_by($columna, $order); 

          //paginacion
          $this->db->limit($largo,$inicio); 


          $result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  foreach ($result->result() as $row) {
                               $dato[]= array(
                                      0=>$row->id,
                                      1=>$row->entorno,
                                      2=>$row->tabla,
                                      3=>$row->profundidad,
                                      4=>$row->ruta,

                                      //4=>self::entornos_en_uso($row->id),
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cat_entornos() ), 
                        "recordsFiltered" =>   $registros_filtrados, 
                        "data"            =>  $dato 
                      ));
                    
              }   
              else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();           

      }  
      
        public function total_cat_entornos(){
           $this->db->from($this->catalogo_entornos);
           $entornos = $this->db->get();            
           return $entornos->num_rows();
        }



     public function coger_entorno( $data ){
              
            $this->db->select("c.id, c.entorno, c.tabla,c.profundidad");         
            $this->db->from($this->catalogo_entornos.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0){
                 
                   return $result->row();
                } else {
                   return FALSE;
                }
                    
                $result->free_result();
     }  


    public function listado_entornos(  ){
            $id_session = $this->session->userdata('id');
            $data["id"] = $this->session->userdata('entorno_activo');
            $nombre_activo = self::coger_entorno($data)->entorno;
            $profundidad_activo = self::coger_entorno($data)->profundidad;


            $this->db->select("c.id, c.entorno, c.tabla, c.profundidad");         
            $this->db->select($data["id"]." as id_activo",false);         
            $this->db->select("'".$nombre_activo."' as nombre_activo",false);         
            $this->db->select("'".$profundidad_activo."' as profundidad_activo",false);         
            $this->db->from($this->catalogo_entornos.' As c');
            $this->db->join($this->registro_proyecto.' As r', 'r.id_entorno = c.id', 'LEFT');
            
            
            $where ='(
                        (c.id_usuario= "'.$id_session.'") OR
                        (LOCATE("'.$id_session.'",r.id_val)>0)
                      )'; 
                          
             $this->db->where($where);

             $this->db->group_by("c.id");

             

           // $this->db->where('c.id_usuario',$id_session);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0){
                   return $result->result();
                } else {
                   return FALSE;
                }
                    
                $result->free_result();
     }  



           


        //editar
        public function editar_entorno( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'entorno', $data['entorno'] );  
          //$this->db->set( 'tabla', $data['tabla'] );  
          $this->db->set( 'tabla', $this->session->userdata('creando_entorno') );

          $profundidad = self::profundidad($this->session->userdata('creando_entorno'));
          $ruta = self::ruta($this->session->userdata('creando_entorno'));
          $this->db->set( 'profundidad', $profundidad );  
          $this->db->set( 'ruta', $ruta );  

          $this->db->where('id', $data['id'] );
          $this->db->update($this->catalogo_entornos );
            
            return TRUE;

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return FALSE;
                $result->free_result();
        }   





        //eliminar entorno
        public function eliminar_entorno( $data ){
            $this->db->delete( $this->catalogo_entornos, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }  
       
          



  

} 
?>