<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class Modelo_proyecto extends CI_Model{
		
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
      
            //usuarios
            $this->usuarios    = $this->db->dbprefix('usuarios');
      
              
               $this->catalogo_entornos                         = $this->db->dbprefix('catalogo_entornos');
              $this->catalogo_proyectos                         = $this->db->dbprefix('catalogo_proyectos');
              $this->registro_proyecto                         = $this->db->dbprefix('registro_proyecto');

              $this->registro_user_proy                        = $this->db->dbprefix('registro_user_proy');

              
              

		}

    //id, id_entorno, id_proyecto, descripcion, horas, fecha, id_usuario, fecha_mac

  public function listado_registro_usuario($data){

        $id_session = $this->session->userdata('id');

        //$tmp = array();
        //$tmp[] = (int)$id["id"];
        foreach ($data['proyecto'] as $key => $value) {
               
//hoy
               $this->db->select( 'r.id, r.id_entorno, r.id_proyecto, r.descripcion, r.horas,  r.id_usuario' );
               $this->db->select("DATE_FORMAT((r.fecha),'%d-%m-%Y') as fecha",false);

               $this->db->select("r.horas as hr_anterior",false);
               
               $this->db->from($this->registro_user_proy.' as r');


              $where = '(

                          (
                            (r.id_usuario= "'.$id_session.'") AND
                            (r.id_entorno = '.$value->id_activo.' ) AND
                            (r.id_proyecto = '.$value->id.'  ) AND
                            ( DATE_FORMAT((r.fecha),"%Y-%m-%d")  =  "'.$data['fechapaginador'].'" ) 
                           )
              )';   

              $this->db->where($where);
               $result = $this->db->get();
                  if ( $result->num_rows() > 0 ) {
                    $value->reg_user = $result->row();
                  }  else {
                    $value->reg_user = null;
                  }
                $result->free_result();


//Anterior

               //$this->db->select( 'r.id, r.id_entorno, r.id_proyecto, r.descripcion, r.horas,  r.id_usuario' );
               //$this->db->select("DATE_FORMAT((r.fecha),'%d-%m-%Y') as fecha",false);
               $this->db->select("r.horas as hr_anterior",false);
               
               $this->db->from($this->registro_user_proy.' as r');


              $where = '(

                          (
                            (r.id_usuario= "'.$id_session.'") AND
                            (r.id_entorno = '.$value->id_activo.' ) AND
                            (r.id_proyecto = '.$value->id.'  ) AND
                            ( DATE_FORMAT((r.fecha),"%Y-%m-%d")  =  "'.$data['fechaanterior'].'" ) 
                           )
              )';   

              $this->db->where($where);
               $result = $this->db->get();
                  if ( $result->num_rows() > 0 ) {
                    $value->anterior = $result->row();
                  }  else {
                    $value->anterior = null;
                  }
                $result->free_result();







        }

        return $data['proyecto'];
  }    

      public function buscador_usuarios($data){
            $this->db->select( 'id' );
            $this->db->select("nombre", FALSE);  
            $this->db->from($this->usuarios);
            $this->db->like("nombre" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) 
                      {
                            $dato[]= array("id"=>$row->id, 
                                            "nombre"=>$row->nombre, 
                                    );
                      }
                      return json_encode($dato);
              }   
              else 
                 return False;
              $result->free_result();
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
          $this->db->insert("pstruct_".$data["tabla"] );

          $this->db->set( 'id', 1 );  
          $this->db->set( 'nm',  $data["nombre"] );  
          $this->db->insert("pdata_".$data["tabla"] );      

          return true;    

        }  


   //checar si el proyecto por TABLA ya existe
    public function check_existente_proyecto_tabla($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->catalogo_proyectos);
            $this->db->where('tabla',$data['tabla']);  
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 


   //checar si el proyecto ya existe
    public function check_existente_proyecto($data){
            $this->db->select("id", FALSE);         
            $this->db->from($this->catalogo_proyectos);
            $this->db->where('proyecto',$data['proyecto']);  
            $login = $this->db->get();
            if ($login->num_rows() > 0)
                return true;
            else
                return false;
            $login->free_result();
    } 






   //checar si el proyecto ya existe
    public function profundidad($tabla){
            
              $tabla  = $this->db->dbprefix('pstruct_'.$tabla);
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



   //checar si el proyecto ya existe
    public function ruta($tabla){
            //http://www.teacupapps.com/blog/mysql/concatenar-varias-filas-en-una-con-mysql
              $tabla_struct  = $this->db->dbprefix('pstruct_'.$tabla);
              $tabla_data  = $this->db->dbprefix('pdata_'.$tabla);
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
        public function anadir_proyecto( $data ){
          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'proyecto', $data['proyecto'] );  
          $this->db->set( 'tabla', $this->session->userdata('creando_proyecto') );  

          $profundidad = self::profundidad($this->session->userdata('creando_proyecto'));
          $ruta = self::ruta($this->session->userdata('creando_proyecto'));

          $this->db->set( 'profundidad', $profundidad );  
          $this->db->set( 'ruta', $ruta );  

          $this->db->set( 'id_entorno', $this->session->userdata('entorno_activo') );

            

          $this->db->insert($this->catalogo_proyectos );
          

          



            if ($this->db->affected_rows() > 0){
                    $data['id_proyecto'] = $this->db->insert_id(); //obtener el id
                    $data['id_entorno'] = $this->session->userdata('entorno_activo');
                    self::anadir_registro_proyecto( $data );


                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }    


         public function anadir_registro_proyecto( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          
          
          $this->db->set( 'id_entorno', $data['id_entorno'] );
          $this->db->set( 'id_proyecto', $data['id_proyecto'] );
          $this->db->set( 'proyecto', $data['proyecto'] );  

          $this->db->set( 'descripcion', $data['descripcion'] );  
          $this->db->set( 'privacidad', $data['privacidad'] );  
          $this->db->set( 'costo', $data['costo'] );  

          $this->db->set( 'fecha_creacion', $data['fecha_creacion'] );  
          $this->db->set( 'fecha_inicial', $data['fecha_inicial'] );  
          $this->db->set( 'fecha_final', $data['fecha_final'] );  

          $this->db->set( 'contrato_firmado', $data['contrato_firmado'] );  
          $this->db->set( 'pago_anticipado', $data['pago_anticipado'] );  
          $this->db->set( 'factura_enviada', $data['factura_enviada'] );  
          $this->db->set( 'id_val', $data['id_val'] );  
          $this->db->set( 'json_items', $data['json_items'] );  



            

          $this->db->insert($this->registro_proyecto );
          

          



            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();          

         } 




      public function buscador_cat_proyectos($data){

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
                        $columna = 'c.proyecto';
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
          
          $this->db->select('c.id, c.proyecto, c.tabla, c.profundidad, c.ruta');

          $this->db->from($this->catalogo_proyectos.' as c');
          
          //filtro de busqueda
       
          $where = '(

                      (
                        ( c.id LIKE  "%'.$cadena.'%" ) OR 
                        ( c.ruta LIKE  "%'.$cadena.'%" ) OR (c.proyecto LIKE  "%'.$cadena.'%") OR (c.tabla LIKE  "%'.$cadena.'%") 
                        
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
                                      1=>$row->proyecto,
                                      2=>$row->tabla,
                                      3=>$row->profundidad,
                                      4=>$row->ruta,

                                      //4=>self::proyectos_en_uso($row->id),
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => intval( self::total_cat_proyectos() ), 
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
      
        public function total_cat_proyectos(){
           $this->db->from($this->catalogo_proyectos);
           $proyectos = $this->db->get();            
           return $proyectos->num_rows();
        }


     public function coger_proyecto( $data ){
              
            $this->db->select("c.id, c.proyecto, c.tabla,c.profundidad");         

            //$this->db->select("");         
            $this->db->select("r.id id_proy, r.id_entorno,  r.descripcion, r.privacidad, r.costo");         
            $this->db->select("DATE_FORMAT((r.fecha_creacion),'%d-%m-%Y') as fecha_creacion",false);
            $this->db->select("DATE_FORMAT((r.fecha_inicial),'%d-%m-%Y') as fecha_inicial",false);
            $this->db->select("DATE_FORMAT((r.fecha_final),'%d-%m-%Y') as fecha_final",false);
            
            $this->db->select("r.contrato_firmado, r.pago_anticipado, r.factura_enviada");
            $this->db->select("r.id_val, r.json_items");


            $this->db->from($this->catalogo_proyectos.' As c');
            $this->db->join($this->registro_proyecto.' As r', 'r.id_proyecto = c.id');
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


        public function listado_usuarios_json( $data ){
            
            $this->db->select("r.json_items");
            $this->db->from($this->registro_proyecto.' As r');
            $this->db->where('r.id',$data['id']);
            $result = $this->db->get(  );
                if ($result->num_rows() > 0){
                   return $result->row()->json_items;
                } else {
                   return FALSE;
                }
                    
                $result->free_result();
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


    public function listado_proyectos(  ){
            $id_session = $this->session->userdata('id');
            $data["id"] = $this->session->userdata('entorno_activo');
            $nombre_activo = self::coger_entorno($data)->entorno;
            $profundidad_activo = self::coger_entorno($data)->profundidad;

            $id_entorno = $this->session->userdata('entorno_activo');

            $this->db->select("c.id, c.proyecto, c.tabla, c.profundidad");         
            $this->db->select($data["id"]." as id_activo",false);         
            $this->db->select("'".$nombre_activo."' as nombre_activo",false);         
            $this->db->select("'".$profundidad_activo."' as profundidad_activo",false);         
            $this->db->from($this->catalogo_proyectos.' As c');
            $this->db->join($this->registro_proyecto.' As r', 'r.id_proyecto = c.id', 'LEFT');

            $where ='(

                        ( (c.id_usuario= "'.$id_session.'") OR (LOCATE("'.$id_session.'",r.id_val)>0) ) AND
                        (c.id_entorno= '.$id_entorno.')

                      )'; 
                          
             $this->db->where($where);

            $result = $this->db->get(  );
                if ($result->num_rows() > 0){
                   return $result->result();
                } else {
                   return FALSE;
                }
                    
                $result->free_result();
     }  



           


        //editar
        public function editar_proyecto( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'proyecto', $data['proyecto'] );  
          //$this->db->set( 'tabla', $data['tabla'] );  
          $this->db->set( 'tabla', $this->session->userdata('creando_proyecto') );

          $profundidad = self::profundidad($this->session->userdata('creando_proyecto'));
          $ruta = self::ruta($this->session->userdata('creando_proyecto'));
          $this->db->set( 'profundidad', $profundidad );  
          $this->db->set( 'ruta', $ruta );  
          $this->db->set( 'id_entorno', $this->session->userdata('entorno_activo') );

          $this->db->where('id', $data['id'] );
          $this->db->update($this->catalogo_proyectos );
            
            
              $data['id_entorno'] = $this->session->userdata('entorno_activo');
              self::editar_registro_proyecto( $data );

              return TRUE;

           if ($this->db->affected_rows() > 0){
                    


                    return TRUE;
                } else {
                    return TRUE;
                }
                $result->free_result();
        }    


         public function editar_registro_proyecto( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'id_entorno', $data['id_entorno'] );
          $this->db->set( 'id_proyecto', $data['id'] );
          $this->db->set( 'proyecto', $data['proyecto'] );  

          $this->db->set( 'descripcion', $data['descripcion'] );  
          $this->db->set( 'privacidad', $data['privacidad'] );  
          $this->db->set( 'costo', $data['costo'] );  

          $this->db->set( 'fecha_creacion', $data['fecha_creacion'] );  
          $this->db->set( 'fecha_inicial', $data['fecha_inicial'] );  
          $this->db->set( 'fecha_final', $data['fecha_final'] );  

          $this->db->set( 'contrato_firmado', $data['contrato_firmado'] );  
          $this->db->set( 'pago_anticipado', $data['pago_anticipado'] );  
          $this->db->set( 'factura_enviada', $data['factura_enviada'] );  
          $this->db->set( 'id_val', $data['id_val'] );  
          $this->db->set( 'json_items', $data['json_items'] );  

          $this->db->where('id', $data['id_proy'] );
          $this->db->update($this->registro_proyecto );



            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();          

         } 














        //eliminar proyecto
        public function eliminar_proyecto( $data ){
            $this->db->delete( $this->catalogo_proyectos, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }  
       
          



  

} 
?>