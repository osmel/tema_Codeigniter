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
            
            $this->historico_acceso    = $this->db->dbprefix('historico_acceso');
            $this->configuraciones    = $this->db->dbprefix('catalogo_configuraciones');

      
              $this->catalogo_entornos                         = $this->db->dbprefix('catalogo_entornos');
              $this->catalogo_proyectos                        = $this->db->dbprefix('catalogo_proyectos');

              $this->catalogo_cargos                        = $this->db->dbprefix('catalogo_cargos');
              $this->catalogo_configuraciones               = $this->db->dbprefix('catalogo_configuraciones');
              $this->catalogo_areas                         = $this->db->dbprefix('catalogo_empresas');
              $this->catalogo_perfiles                      = $this->db->dbprefix('perfiles');
              

              $this->registro_proyecto                         = $this->db->dbprefix('registro_proyecto');


              
              

		}


//////////areas/////////
    
      public function buscador_cat_areas($data){

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
                        $columna = 'c.nombre';
                     break;
                   case '1':
                        $columna = 'c.monto'; //, tabla
                     break;
                   case '2':
                        $columna = 'c.telefono'; //, tabla
                     break;                 
                   default:
                        $columna = 'c.id';
                     break;
                 }                 

                                      

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          $this->db->select('c.id, c.nombre, c.monto, c.telefono');

          $this->db->from($this->catalogo_areas.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id LIKE  "%'.$cadena.'%" ) OR 
                        ( c.nombre LIKE  "%'.$cadena.'%" ) OR
                        ( c.monto LIKE  "%'.$cadena.'%" ) OR
                        ( c.telefono LIKE  "%'.$cadena.'%" ) 

                        
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
                                      1=>$row->nombre,
                                      2=>$row->monto,
                                      3=>$row->telefono,
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cat_areas() ), 
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
      
        public function total_cat_areas(){
           $this->db->from($this->catalogo_areas);
           $areas = $this->db->get();            
           return $areas->num_rows();
        }

//////////cargos/////////
    
      public function buscador_cat_cargos($data){

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
                        $columna = 'c.cargo';
                     break;
                   case '1':
                        $columna = 'c.lider'; //, tabla
                     break;
                   case '2':
                        $columna = 'c.activo'; //, tabla
                     break;                 
                   default:
                        $columna = 'c.id';
                     break;
                 }                 

                                      

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          $this->db->select('c.id, c.cargo, c.lider, c.activo');

          $this->db->from($this->catalogo_cargos.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id LIKE  "%'.$cadena.'%" ) OR 
                        ( c.cargo LIKE  "%'.$cadena.'%" )
                        
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
                                      1=>$row->cargo,
                                      2=>$row->lider,
                                      3=>$row->activo,
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cat_cargos() ), 
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
      
        public function total_cat_cargos(){
           $this->db->from($this->catalogo_cargos);
           $cargos = $this->db->get();            
           return $cargos->num_rows();
        }




//////////perfiles/////////
    
      public function buscador_cat_perfiles($data){

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
                        $columna = 'c.perfil';
                     break;
                   case '1':
                        $columna = 'c.operacion'; //, tabla
                     break;
                   default:
                        $columna = 'c.id_perfil';
                     break;
                 }                 

                                      

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          $this->db->select('c.id_perfil, c.perfil, c.operacion');

          $this->db->from($this->catalogo_perfiles.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id_perfil LIKE  "%'.$cadena.'%" ) OR 
                        ( c.perfil LIKE  "%'.$cadena.'%" ) OR
                        ( c.operacion LIKE  "%'.$cadena.'%" ) 

                        
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
                                      0=>$row->id_perfil,
                                      1=>$row->perfil,
                                      2=>$row->operacion,
                                      
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cat_perfiles() ), 
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
      
        public function total_cat_perfiles(){
           $this->db->from($this->catalogo_perfiles);
           $perfiles = $this->db->get();            
           return $perfiles->num_rows();
        }

  

//////////configuraciones/////////
    
      public function buscador_cat_configuraciones($data){

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
                        $columna = 'c.configuracion';
                     break;
                   case '1':
                        $columna = 'c.valor'; //, tabla
                     break;
                   case '2':
                        $columna = 'c.activo'; //, tabla
                     break;                 
                   default:
                        $columna = 'c.id';
                     break;
                 }                 

                                      

          $id_session = $this->db->escape($this->session->userdata('id'));

          $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE); //
          
          $this->db->select('c.id, c.configuracion, c.valor, c.activo');

          $this->db->from($this->catalogo_configuraciones.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id LIKE  "%'.$cadena.'%" ) OR 
                        ( c.configuracion LIKE  "%'.$cadena.'%" ) OR
                        ( c.valor LIKE  "%'.$cadena.'%" )

                        
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
                                      1=>$row->configuracion,
                                      2=>$row->valor,
                                      3=>$row->activo,
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cat_configuraciones() ), 
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
      
        public function total_cat_configuraciones(){
           $this->db->from($this->catalogo_configuraciones);
           $configuraciones = $this->db->get();            
           return $configuraciones->num_rows();
        }





  

} 

?>