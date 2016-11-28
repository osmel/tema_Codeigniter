<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class Modelo_nucleo extends CI_Model{
		
		private $key_hash;
		private $timezone;

		function __construct(){
			parent::__construct();
			$this->load->database("default");
			$this->key_hash    = $_SERVER['HASH_ENCRYPT'];
			$this->timezone    = 'UM1';

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

		}





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
            $this->db->select($this->usuarios.'.id_almacen');         

                
			$this->db->from($this->usuarios);
			$this->db->join($this->perfiles, $this->usuarios.'.id_perfil = '.$this->perfiles.'.id_perfil');
            


			$this->db->where('contrasena', "AES_ENCRYPT('{$data['contrasena']}','{$this->key_hash}')", FALSE);
			$this->db->where('email',"AES_ENCRYPT('{$data['email']}','{$this->key_hash}')",FALSE);


			$login = $this->db->get();

			if ($login->num_rows() > 0)
				return $login->result();
			else 
				return FALSE;
			$login->free_result();
		}

      //Lista de todos los usuarios 

        public function listado_usuarios(  ){

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
            $result->free_result();
        }       
   

     public function datos_usuario( $uid ){
            $this->db->select('u.id, nombre, apellidos, u.id_perfil,  coleccion_id_operaciones, id_cliente,id_almacen');
            $this->db->select( "AES_DECRYPT( email,'{$this->key_hash}') AS email", FALSE );
            $this->db->select( "AES_DECRYPT( telefono,'{$this->key_hash}') AS telefono", FALSE );
            $this->db->select( "AES_DECRYPT( contrasena,'{$this->key_hash}') AS contrasena", FALSE );

            $this->db->select( "p.perfil", FALSE );
            
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



	} 
?>