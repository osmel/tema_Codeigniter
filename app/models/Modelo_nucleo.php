<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class Modelo_nucleo extends CI_Model{
		
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

      
            
               $this->cargos                         = $this->db->dbprefix('catalogo_cargos');

              $this->catalogo_entornos                         = $this->db->dbprefix('catalogo_entornos');
              $this->catalogo_proyectos                         = $this->db->dbprefix('catalogo_proyectos');
              $this->registro_proyecto                         = $this->db->dbprefix('registro_proyecto');


		}



    public function check_correo_existente($data){
      $this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);      
      $this->db->from($this->usuarios);
      $this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
      $login = $this->db->get();
      if ($login->num_rows() > 0)
        return FALSE;
      else
        return TRUE;
      $login->free_result();
    }

    public function check_usuario_existente($data){
      
      $this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);      
      $this->db->from($this->usuarios);
      $this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
      $this->db->where('id !=',$data['id']);
      $login = $this->db->get();
      if ($login->num_rows() > 0)
        return FALSE;
      else
        return TRUE;
      $login->free_result();
    }        


    public function anadir_usuario( $data ){
            $timestamp = time();

            $id_session = $this->session->userdata('id');
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->set( 'id_usuario',  $id_session );

            $this->db->set( 'id', "UUID()", FALSE);
            $this->db->set( 'nombre', $data['nombre'] );
            $this->db->set( 'apellidos', $data['apellidos'] );
            $this->db->set( 'email', "AES_ENCRYPT('{$data['email']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'telefono', "AES_ENCRYPT('{$data['telefono']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'id_perfil', $data['id_perfil']);
            $this->db->set( 'id_cliente', $data['id_cliente']);
            
            $this->db->set( 'coleccion_id_operaciones', $data['coleccion_id_operaciones']);

            $this->db->set( 'id_cargo', $data['id_cargo']);    
            $this->db->set( 'activo', $data['activo']);    

            $this->db->set( 'contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'creacion',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->insert($this->usuarios );

            if ($this->db->affected_rows() > 0){
                return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
            
        }


        public function edicion_usuario( $data ){

            $timestamp = time();

            $id_session = $this->session->userdata('id');
            $this->db->set( 'fecha_pc',  gmt_to_local( $timestamp, $this->timezone, TRUE) );
            $this->db->set( 'id_usuario',  $id_session );

            $this->db->set( 'nombre', $data['nombre'] );
            $this->db->set( 'apellidos', $data['apellidos'] );
            $this->db->set( 'email', "AES_ENCRYPT('{$data['email']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'telefono', "AES_ENCRYPT('{$data['telefono']}','{$this->key_hash}')", FALSE );
            $this->db->set( 'id_perfil', $data['id_perfil']);
            $this->db->set( 'id_cliente', $data['id_cliente']);
            
            $this->db->set( 'coleccion_id_operaciones', $data['coleccion_id_operaciones']);

            $this->db->set( 'id_cargo', $data['id_cargo']);    
            $this->db->set( 'activo', $data['activo']);    
                      
            $this->db->set( 'contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE );
            $this->db->where('id', $data['id'] );
            $this->db->update($this->usuarios );
            if ($this->db->affected_rows() > 0) {
        return TRUE;
      }  else
         return FALSE;
        }   

//----------------**************catalogos-------------------************------------------
        public function coger_catalogo_perfiles(){
            $this->db->select( 'id_perfil, perfil, operacion' );
            $perfiles = $this->db->get($this->perfiles );
            if ($perfiles->num_rows() > 0 )
               return $perfiles->result();
            else
               return FALSE;
            $perfiles->free_result();
        }       


//----------------**************clientes_asociados-------------------************------------------
        public function coger_catalogo_clientes( $id_actividad){

              $this->db->select('p.id id_cliente, p.area cliente'); 
              $this->db->from($this->proveedores.' as p');

             
              $this->db->where('(LOCATE("'.$id_actividad.'", p.coleccion_id_actividad) >0)' );

              $result = $this->db->get();

                if ( $result->num_rows() > 0 )
                   return $result->result();
                else
                   return False;
                $result->free_result();
        }  


        public function coger_catalogo_cargos( ){

              $this->db->select('a.id id_cargo, a.cargo cargo'); 
              $this->db->from($this->cargos.' as a');

              $this->db->where('a.activo', 1);

              $result = $this->db->get();

                if ( $result->num_rows() > 0 )
                   return $result->result();
                else
                   return False;
                $result->free_result();
        } 



       //editar 
        public function coger_catalogo_usuario( $uid ){
            $this->db->select('id, nombre, apellidos, id_perfil,  coleccion_id_operaciones, id_cliente,id_cargo,activo');
            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->select( "AES_DECRYPT( telefono,'{$this->key_hash}') AS telefono", FALSE );
            $this->db->select( "AES_DECRYPT( contrasena,'{$this->key_hash}') AS contrasena", FALSE );
            $this->db->where('id', $uid);
            $result = $this->db->get($this->usuarios );
            if ($result->num_rows() > 0)
              return $result->row();
            else 
              return FALSE;
            $result->free_result();
        }  


        //Lista de todas las operaciones

        public function listado_operaciones(  ){

            $this->db->select('id, operacion, tooltip, grupo');
            $this->db->from($this->catalogo_operaciones);

            $this->db->order_by('orden', 'asc'); 

            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }    


//----------------*****************-------------------************------------------


		//login
		public function check_login($data){
			$this->db->select("AES_DECRYPT(email,'{$this->key_hash}') AS email", FALSE);			
			$this->db->select("AES_DECRYPT(contrasena,'{$this->key_hash}') AS contrasena", FALSE);			
			$this->db->select($this->usuarios.'.nombre,'.$this->usuarios.'.apellidos');			
			$this->db->select($this->usuarios.'.id,'.$this->perfiles.'.id_perfil,'.$this->perfiles.'.perfil,'.$this->perfiles.'.operacion');
            $this->db->select($this->usuarios.'.coleccion_id_operaciones');         
            $this->db->select($this->usuarios.'.id_cliente');         
            $this->db->select($this->usuarios.'.sala');         
            $this->db->select($this->usuarios.'.especial');      
            $this->db->select($this->usuarios.'.id_cargo');         
            $this->db->select($this->usuarios.'.activo');         

                
			$this->db->from($this->usuarios);
			$this->db->join($this->perfiles, $this->usuarios.'.id_perfil = '.$this->perfiles.'.id_perfil');
            


			$this->db->where('contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE);
			$this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);
      $this->db->where('activo',1,FALSE);


			$login = $this->db->get();

			if ($login->num_rows() > 0)
				return $login->result();
			else 
				return FALSE;
			$login->free_result();
		}

      //Lista de todos los usuarios 

        public function listado_usuarios(  ){

            $id_perfil=$this->session->userdata('id_perfil');
            $id=$this->session->userdata('id');
            $id_area=$this->session->userdata('id_area');

            $this->db->select('u.id, nombre,  apellidos,activo');

            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->select( "AES_DECRYPT( telefono,'{$this->key_hash}') AS telefono", FALSE );
            $this->db->select('p.id_perfil,p.perfil,p.operacion');

            
            switch ($id_perfil) {
              case 1: //super
              case 2: //Admin
                              // todos los usuarios
                break;
              case 3:
                    $this->db->where('u.id_cliente', $id_area);   
                break;

              default:
                   $this->db->where('u.id', $id);   
                break;
            }
            
            
            $this->db->from($this->usuarios.' as u');
            $this->db->join($this->perfiles.' as p', 'u.id_perfil = p.id_perfil');

            $result = $this->db->get();
            
            if ( $result->num_rows() > 0 )
               return $result->result();
            else
               return False;
            $result->free_result();
        }       
   

     public function datos_usuario( $uid ){
            $this->db->select('u.id, nombre, apellidos, u.id_perfil,  coleccion_id_operaciones, id_cliente,id_cargo');
            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->select( "AES_DECRYPT( telefono,'{$this->key_hash}') AS telefono", FALSE );
            $this->db->select( "AES_DECRYPT( contrasena,'{$this->key_hash}') AS contrasena", FALSE );

            $this->db->select( "p.perfil, activo", FALSE );
            
            $this->db->from($this->usuarios.' as u');
            $this->db->join($this->perfiles.' as p', 'u.id_perfil = p.id_perfil');
            $this->db->where('id', $uid);

            $result = $this->db->get();            
            
            
            
            if ($result->num_rows() > 0)
              return $result->row();
            else 
              return FALSE;
            $result->free_result();
        }  



/*
    
    
    

    $fecha = date('Y-m-j');
    $primer_dia_semana = date ( 'Y-m-j' ,strtotime ( '-'.$dia_hoy_semana.' day' , strtotime ( $fecha ) ) );
    $ultimo_dia_semana = date ( 'Y-m-j' ,strtotime ( '+'.(6-$dia_hoy_semana).' day' , strtotime ( $fecha ) ) );
     
    echo $primer_dia_semana.'<br/>';
    echo $ultimo_dia_semana;
//    die;


    // la primera semana empieza con 0, por lo tanto, la forma correcta de llamar la primera semana se logra de esta forma
    $semana = date('W',  mktime(0, 0, 0, date("m")  , date("d"), date("Y"))  );  

    for($i=1; $i<8; $i++){  //2--9 es de lunes a viernes 1--8 domingo a sabado
        echo date('Y-m-d', strtotime('01/01 +' . ($semana - 1) . ' weeks first day +' . $i . ' day')) . '<br />';
    }



SELECT id, FROM_UNIXTIME( fecha,  '%Y-%m-%d %H:%i:%s' ) , fecha, DATE_FORMAT( FROM_UNIXTIME( fecha ) ,  "%Y-%m-%d %H:%i:%s" ) AS fecha1
FROM  `inven_historico_acceso` 



SELECT id, FROM_UNIXTIME(  fecha ,  '%Y-%m-%d %H:%i:%s' ) , fecha,
DATE_FORMAT(FROM_UNIXTIME(fecha),"%Y-%m-%d %H:%i:%s") AS fecha1,
DATE_SUB(FROM_UNIXTIME(fecha),INTERVAL -6 HOUR ) aaa

FROM  `inven_historico_acceso` 
WHERE 1 

            //SELECT FROM_UNIXTIME( UNIX_TIMESTAMP( ) ,  '%Y-%m-%d %H:%i:%s' )

            $fecha = date_create(date('Y-m-j'));
            date_add($fecha, date_interval_create_from_date_string('-1 month'));
            
            $data['fecha_inicial'] = date_format($fecha, 'm');
            $data['fecha_final'] = $data['fecha_final'] = (date('m'));

            //$this->db->select("h.id, DATE_FORMAT(FROM_UNIXTIME(h.fecha),'%Y-%m-%d %H:%i:%s') AS fecha", FALSE);   
            //$this->db->select("h.id, DATE_FORMAT(FROM_UNIXTIME(h.fecha),'%Y-%m-%d %H:%i:%s') AS fecha", FALSE);   


*/


          /*
            $this->db->select("AES_DECRYPT(h.email,'{$this->key_hash}') AS email", FALSE);            
            $this->db->select('p.id_perfil, p.perfil, p.operacion');
            $this->db->select('u.nombre,u.apellidos');         
            $this->db->select('h.ip_address, h.user_agent, h.id_usuario');
            $this->db->select("( CASE WHEN h.fecha = 0 THEN '' ELSE DATE_FORMAT(FROM_UNIXTIME(h.fecha),'%d-%m-%Y %H:%i:%s') END ) AS fecha", FALSE);   
            */



     //cantidad de veces conectadas en la semana
        public function historico_acceso_semana($data){

          //devuelve el día de la semana de la fecha actual
            $dia_hoy_semana = date('w',  mktime(0, 0, 0, date("m")  , date("d"), date("Y"))  );  
            //$fecha = date('Y-m-d');
            $fecha = date('Y-m-d H:i:s');  
            $primer_dia_semana = date ( 'Y-m-d' ,strtotime ( '-'.$dia_hoy_semana.' day' , strtotime ( $fecha ) ) );
            $ultimo_dia_semana = date ( 'Y-m-d' ,strtotime ( '+'.(6-$dia_hoy_semana).' day' , strtotime ( $fecha ) ) );
   

            
            //$this->db->select("DATE_FORMAT(DATE_SUB(FROM_UNIXTIME(h.fecha),INTERVAL -6 HOUR ),'%d-%m-%Y %H:%i:%s') AS fecha", FALSE);   
            $this->db->select("DATE_FORMAT(DATE_SUB(FROM_UNIXTIME(h.fecha),INTERVAL -6 HOUR ),'%d-%m-%Y') AS fecha", FALSE);   
            $this->db->select('count(fecha) cantidad');         

            $this->db->from($this->historico_acceso.' As h');
            $this->db->join($this->usuarios.' As u' , 'u.id = h.id_usuario','LEFT');
            $this->db->join($this->perfiles.' As p', 'u.id_perfil = p.id_perfil','LEFT');
            

                         
             $fechas = ' AND  ( ( DATE_FORMAT(DATE_SUB(FROM_UNIXTIME(h.fecha),INTERVAL -6 HOUR ),"%Y-%m-%d")  >=  "'.$primer_dia_semana.'" )  AND  ( DATE_FORMAT(DATE_SUB(FROM_UNIXTIME(h.fecha),INTERVAL -6 HOUR ),"%Y-%m-%d")  <=  "'.$ultimo_dia_semana.'" ) )'; 

            $where =' h.id_usuario = "'.$data['uid'].'"'.$fechas; 
                          
             $this->db->where($where);  

             $this->db->group_by( 'DATE_FORMAT(DATE_SUB(FROM_UNIXTIME(h.fecha),INTERVAL -6 HOUR ),"%Y-%m-%d")'  );

            $this->db->order_by('h.fecha', 'desc'); 



          $result = $this->db->get();

          $objeto = $result->result();

          for($i=0; $i<7; $i++){
              $dia[$i] =0;
          }  


          //la semana en la que estamos
          $semana = date('W',  mktime(0, 0, 0, date("m")  , date("d"), date("Y"))  );  
          for($i=1; $i<8; $i++){  //2--9 es de lunes a viernes 1--8 domingo a sabado
              $dia[$i-1] = (object) array(
                              "fecha" => date('Y-m-d', strtotime('01/01 +' . ($semana - 1) . ' weeks first day +' . $i . ' day')),
                              "cantidad" =>0
                            );
          }

          //copiar a tabla "historico_conteo_cargo"
          foreach ($objeto as $key => $value) {
             $dia1 = date('w',  mktime(0, 0, 0, date("m",strtotime($value->fecha) )  , date("d",strtotime($value->fecha)), date("Y",strtotime($value->fecha)))  );  
                $dia[$dia1] = $value;
              
          }


          return $dia; 
        }


//cantidad de veces conectadas en el mes
        public function historico_acceso_mes($data){

            $mes_actual = date('Y-m');  
            $this->db->select("DATE_FORMAT(DATE_SUB(FROM_UNIXTIME(h.fecha),INTERVAL -6 HOUR ),'%d-%m-%Y') AS fecha", FALSE);   
            $this->db->select('count(fecha) cantidad');         

            $this->db->from($this->historico_acceso.' As h');
            $this->db->join($this->usuarios.' As u' , 'u.id = h.id_usuario','LEFT');
            $this->db->join($this->perfiles.' As p', 'u.id_perfil = p.id_perfil','LEFT');
            

                         
             $fechas = ' AND  ( ( DATE_FORMAT(DATE_SUB(FROM_UNIXTIME(h.fecha),INTERVAL -6 HOUR ),"%Y-%m")  =  "'.$mes_actual.'" ) )'; 

            $where =' h.id_usuario = "'.$data['uid'].'"'.$fechas; 
                          
             $this->db->where($where);  

              $this->db->group_by( 'DATE_FORMAT(DATE_SUB(FROM_UNIXTIME(h.fecha),INTERVAL -6 HOUR ),"%Y-%m-%d")'  );

            $this->db->order_by('h.fecha', 'desc'); 



          $result = $this->db->get();

          $objeto = $result->result();


          //la semana en la que estamos
          for($i=1; $i<=cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); $i++){  //2--9 es de lunes a viernes 1--8 domingo a sabado
              $dia[$i] = (object) array(
                              "fecha" => date('Y-m-d', strtotime(date("Y").'-'.date("m").'-'.   str_pad($i, 1, "0", STR_PAD_BOTH )  )),
                              "cantidad" =>0
                            );
          }
          
          //copiar a tabla "historico_conteo_cargo"
          foreach ($objeto as $key => $value) {
                $dia[date('j', strtotime($value->fecha) )] =$value; //j: dia sin ceros
          }

          return $dia; 
        }







	} 
?>