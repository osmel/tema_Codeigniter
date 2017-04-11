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
              
              

              $this->registro_proyecto                         = $this->db->dbprefix('registro_proyecto');


              
              

		}


     public function coger_entorno( $data ){
              
            $this->db->select("c.id, c.entorno, c.tabla,c.profundidad");         
            $this->db->from($this->catalogo_entornos.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0){
                   //$this->session->set_userdata('creando_entorno', $result->row()->tabla);
                   return $result->row();
                } else {
                   return FALSE;
                }
                    
                $result->free_result();
     }  


  public function buscador_proyectos($data){

            $id_perfil=$this->session->userdata('id_perfil');
            $id_session = $this->session->userdata('id');
            $data["id"] = $this->session->userdata('entorno_activo');
            $nombre_activo = self::coger_entorno($data)->entorno;
            $profundidad_activo = self::coger_entorno($data)->profundidad;

            $id_entorno = $this->session->userdata('entorno_activo');


            $this->db->select("c.id, c.proyecto, c.tabla, c.profundidad,c.importe");         
            $this->db->select($data["id"]." as id_activo",false);         
            $this->db->select("'".$nombre_activo."' as nombre_activo",false);         
            $this->db->select("'".$profundidad_activo."' as profundidad_activo",false);   
            
            $this->db->select('(c.id_usuario= "'.$id_session.'") as dueno_real',false);              
            $this->db->select('1 as dueno',false);  //1-todos tienen permiso a editar      

            $this->db->from($this->catalogo_proyectos.' As c');
            $this->db->join($this->registro_proyecto.' As r', 'r.id_proyecto = c.id', 'LEFT');

            $max_entornos = $profundidad_activo; //4; //maximos entornos configurados(cantidad de tablas con nivel2..4)
            $cond_niveles ='';
            for ($i=2; $i <= $max_entornos; $i++) { 
               $this->db->join($this->db->dbprefix('registro_nivel'.$i).' As n'.$i, 'n'.$i.'.id_proyecto = c.id', 'LEFT');
               $cond_niveles .= ' OR (LOCATE("'.$id_session.'",n'.$i.'.id_val)>0)' ;
            }


              switch ($id_perfil) {
                  case 1: //super
                  case 2: //Admin
                   $where ='(
                            (c.id_entorno= '.$id_entorno.')
                             and (c.proyecto LIKE  "%'.$data['key'].'%") 
                          )'; 
                   

                    break;
                  case 3: //lider
                        $where ='(
                          ( (c.id_usuario = "'.$id_session.'") OR
                          (LOCATE("'.$id_session.'",r.id_val)>0)  '.$cond_niveles.' )
                          AND (c.id_entorno= '.$id_entorno.')
                        ) and (c.proyecto LIKE  "%'.$data['key'].'%") '; 
                        
                    break;

                    case 4: //trabajadores
                        $where ='(
                          ( (c.id_usuario= "'.$id_session.'") OR
                          (LOCATE("'.$id_session.'",r.id_val)>0)  '.$cond_niveles.' )
                          AND (c.id_entorno= '.$id_entorno.')
                        ) and (c.proyecto LIKE  "%'.$data['key'].'%")'; 
                        
                    break;              

              }         
             $this->db->where($where);

              $this->db->order_by('proyecto', 'asc');
              

             $this->db->group_by('c.id');     




              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array(
                                       "value"=>$row->proyecto,
                                       "key"=>$row->id,
                                       "descripcion"=>$row->proyecto,
                                       "valor"=>"proyectos",
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();

  }  
     
      public function buscador_usuarios( $data ){

            $id_perfil=$this->session->userdata('id_perfil');
            $id=$this->session->userdata('id');
            $id_area=$this->session->userdata('id_area');

            $this->db->select('u.id, nombre,  apellidos,activo, salario');

            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->select( "AES_DECRYPT( telefono,'{$this->key_hash}') AS telefono", FALSE );

            $this->db->select('p.id_perfil,p.perfil,p.operacion');

            
            switch ($id_perfil) {
              case 1: //super
              case 2: //Admin
                  $this->db->or_like('nombre',  $data['key'], 'both'); 
                  $this->db->or_like('apellidos',  $data['key'], 'both'); 
                              // todos los usuarios
                break;
              case 3:
                    $this->db->where('u.id_cliente', $id_area);   
                  $this->db->or_like('nombre',  $data['key'], 'both'); 
                  $this->db->or_like('apellidos',  $data['key'], 'both'); 

                break;

              default:
                   $this->db->where('u.id', $id);   
                  $this->db->or_like('nombre',  $data['key'], 'both'); 
                  $this->db->or_like('apellidos',  $data['key'], 'both'); 
                break;
            }
            
            
            $this->db->from($this->usuarios.' as u');
            $this->db->join($this->perfiles.' as p', 'u.id_perfil = p.id_perfil');

            $this->db->order_by('nombre', 'asc');
            $this->db->order_by('apellidos', 'asc');

            $result = $this->db->get();
            
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array(
                                       "value"=>$row->nombre.' '.$row->apellidos,
                                       "key"=>$row->id,
                                       "descripcion"=>$row->nombre.' '.$row->apellidos,
                                       "valor"=>"usuarios",
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();

        }     



 //determina si areas, cargos o perfiles estan ocupados por algún usuario

      public function en_uso($data) {

          $this->db->select("id", FALSE);         
          $this->db->from($this->usuarios);
          
           switch ($data['campo']) {    
                case 'area':                 
                    $campo = 'id_cliente';
                  break;
                case 'cargo':                 
                    $campo = 'id_cargo';
                  break;
                case 'perfil':                 
                    $campo = 'id_perfil';
                  break;
              
                default:  
                  $campo = 'id_perfil';
                  break;
            }

          $this->db->where($campo,$data['id']);  
            
          $result = $this->db->get();          

           if ( $result->num_rows() > 0 ) {
                  return 1;
              } else 
                  return 0;
            $result->free_result();                 

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
                        $columna = 'c.area';
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
          
          $this->db->select('c.id, c.area, c.monto, c.telefono');

          $this->db->from($this->catalogo_areas.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id LIKE  "%'.$cadena.'%" ) OR 
                        ( c.area LIKE  "%'.$cadena.'%" ) OR
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
                               $dato_uso["campo"] = "area";
                                  $dato_uso["id"] = $row->id;
                               $uso = self::en_uso($dato_uso);
                               $dato[]= array(
                                      0=>$row->id,
                                      1=>$row->area,
                                      2=>$row->monto,
                                      3=>$row->telefono,
                                      4=>$uso,
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




 public function listado_areas(){
          $this->db->select("id, area", FALSE);         
          $this->db->from($this->catalogo_areas);

          $result = $this->db->get(  );
             if ( $result->num_rows() > 0 ) {
                  return $result->result();
              } else 
                  return false;
            $result->free_result();   
 } 


 //checar si el composicion ya existe
    public function check_existente_area($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->catalogo_areas);
            $this->db->where('area',$data['area']);  
            
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



      //crear
        public function anadir_area( $data ){
          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'area', $data['area'] );  
          $this->db->set( 'monto', $data['monto'] );  
          $this->db->set( 'telefono', $data['telefono'] );  

            $this->db->insert($this->catalogo_areas );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          



//edicion
     public function coger_area( $data ){
              
            $this->db->select("c.id, c.area, c.monto, c.telefono");         
            $this->db->from($this->catalogo_areas.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  


//editar
        public function editar_area( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'area', $data['area'] );  
          $this->db->set( 'monto', $data['monto'] );  
          $this->db->set( 'telefono', $data['telefono'] );  

          
          $this->db->where('id', $data['id'] );
          $this->db->update($this->catalogo_areas );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return true;
                $result->free_result();
        } 



        //eliminar area
        public function eliminar_area( $data ){
            $this->db->delete( $this->catalogo_areas, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
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
                               $dato_uso["campo"] = "cargo";
                                  $dato_uso["id"] = $row->id;
                               $uso = self::en_uso($dato_uso);
                               $dato[]= array(
                                      0=>$row->id,
                                      1=>$row->cargo,
                                      2=>$row->lider,
                                      3=>$row->activo,
                                      4=>$uso
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




 //checar si el composicion ya existe
    public function check_existente_cargo($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->catalogo_cargos);
            $this->db->where('cargo',$data['cargo']);  
            
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



      //crear
        public function anadir_cargo( $data ){
          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'cargo', $data['cargo'] );  
          $this->db->set( 'lider', $data['lider'] );  
          $this->db->set( 'activo', $data['activo'] );  

            $this->db->insert($this->catalogo_cargos );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          



//edicion
     public function coger_cargo( $data ){
              
            $this->db->select("c.id, c.cargo, c.lider, c.activo");         
            $this->db->from($this->catalogo_cargos.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  


//editar
        public function editar_cargo( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'cargo', $data['cargo'] );  
          $this->db->set( 'lider', $data['lider'] );  
          $this->db->set( 'activo', $data['activo'] );  


          $this->db->where('id', $data['id'] );
          $this->db->update($this->catalogo_cargos );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return true;
                $result->free_result();
        }   


        //eliminar cargo
        public function eliminar_cargo( $data ){
            $this->db->delete( $this->catalogo_cargos, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
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

          $this->db->from($this->perfiles.' as c');
          
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
                               $dato_uso["campo"] = "perfil";
                                  $dato_uso["id"] = $row->id_perfil;
                               $uso = self::en_uso($dato_uso);
                               $dato[]= array(
                                      0=>$row->id_perfil,
                                      1=>$row->perfil,
                                      2=>$row->operacion,
                                      3=>$uso
                                      
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
           $this->db->from($this->perfiles);
           $perfiles = $this->db->get();            
           return $perfiles->num_rows();
        }

  



 //checar si el composicion ya existe
    public function check_existente_perfil($data){
            $this->db->select("id_perfil", FALSE);         
            $this->db->from($this->perfiles);
            $this->db->where('perfil',$data['perfil']);  
            
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



      //crear
        public function anadir_perfil( $data ){
          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'perfil', $data['perfil'] );  
          $this->db->set( 'operacion', $data['operacion'] );  
          

            $this->db->insert($this->perfiles );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          



//edicion
     public function coger_perfil( $data ){
              
            $this->db->select("c.id_perfil, c.perfil, c.operacion");         
            $this->db->from($this->perfiles.' As c');
            $this->db->where('c.id_perfil',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  


//editar
        public function editar_perfil( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'perfil', $data['perfil'] );  
          $this->db->set( 'operacion', $data['operacion'] );  
          

          
          $this->db->where('id_perfil', $data['id'] );
          $this->db->update($this->perfiles );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return true;
                $result->free_result();
        } 


        //eliminar perfil
        public function eliminar_perfil( $data ){
            $this->db->delete( $this->perfiles, array( 'id_perfil' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
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
                                      4=>1, //para que aparezcan desactivado 0
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






 //checar si el composicion ya existe
    public function check_existente_configuracion($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->catalogo_configuraciones);
            $this->db->where('configuracion',$data['configuracion']);  
            
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 



      //crear
        public function anadir_configuracion( $data ){
          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'configuracion', $data['configuracion'] );  
          $this->db->set( 'valor', $data['valor'] );  
          $this->db->set( 'activo', $data['activo'] );  

            $this->db->insert($this->catalogo_configuraciones );
            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }          



//edicion
     public function coger_configuracion( $data ){
              
            $this->db->select("c.id, c.configuracion, c.valor, c.activo");         
            $this->db->from($this->catalogo_configuraciones.' As c');
            $this->db->where('c.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0)
                    return $result->row();
                else 
                    return FALSE;
                $result->free_result();
     }  


//editar
        public function editar_configuracion( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'configuracion', $data['configuracion'] );  
          $this->db->set( 'valor', $data['valor'] );  
          $this->db->set( 'activo', $data['activo'] );  

          
          $this->db->where('id', $data['id'] );
          $this->db->update($this->catalogo_configuraciones );
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }  else
                 return true;
                $result->free_result();
        } 

        //eliminar configuracion
        public function eliminar_configuracion( $data ){
            $this->db->delete( $this->configuraciones, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     

  

} 

?>