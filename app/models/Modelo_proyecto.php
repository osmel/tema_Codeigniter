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
      
            
              
               $this->catalogo_entornos                         = $this->db->dbprefix('catalogo_entornos');
              $this->catalogo_proyectos                         = $this->db->dbprefix('catalogo_proyectos');
              $this->registro_proyecto                         = $this->db->dbprefix('registro_proyecto');

              $this->registro_user_proy                        = $this->db->dbprefix('registro_user_proy');

              $this->bitacora_proyectos                         = $this->db->dbprefix('bitacora_proyectos');

              
              $this->registro_nivel2                         = $this->db->dbprefix('registro_nivel2');
              $this->registro_nivel3                         = $this->db->dbprefix('registro_nivel3');
              $this->registro_nivel4                         = $this->db->dbprefix('registro_nivel4');
              $this->registro_nivel5                         = $this->db->dbprefix('registro_nivel5');
              $this->registro_nivel6                         = $this->db->dbprefix('registro_nivel6');

              
              

              

		}



//SELECT replace(id_val,'"','') FROM `inven_registro_proyecto` WHERE 1
//SELECT REPLACE( id_val,  '"',  '' )  FROM  `inven_registro_proyecto` 

/*
SELECT SPLIT_STRING('apple, pear, melon', ',', 1)

select REPLACE(SUBSTRING(SUBSTRING_INDEX('apple, pear, melon', ',', pos),
       LENGTH(SUBSTRING_INDEX('apple, pear, melon', ',', pos-1)) + 1),
       ',', '')

select subtring('apple, pear, melon',1,locate(',', 'apple, pear, melon' )-1)

select substring('apple, pear, melon',1,locate(',', 'apple, pear, melon' )-1)



select u.salario,substring(REPLACE( id_val,  '"',  '' ),1,locate(',', REPLACE( id_val,  '"',  '' ) )-1) id_user
FROM  `inven_registro_proyecto` up inner join inven_usuarios u on substring(REPLACE( id_val,  '"',  '' ),1,locate(',', REPLACE( id_val,  '"',  '' ) )-1) = u.id


select u.salario,substring(REPLACE( id_val,  '"',  '' ),1,locate(',', REPLACE( id_val,  '"',  '' ) )-1) id_user
FROM  `inven_registro_proyecto` up inner join inven_usuarios u on substring(REPLACE( id_val,  '"',  '' ),1,locate(',', REPLACE( id_val,  '"',  '' ) )-1) = u.id



*/

   //checar si el entorno ya existe
    public function ruta_suma($data){
            

            //lista de las tablas que se ven afectadas
              $tabla_struct  = $this->db->dbprefix('pstruct_'.$data["tabla"]);
              $tabla_data  = $this->db->dbprefix('pdata_'.$data["tabla"]);
              $sql="
                    SELECT nodo.id id_nivel, (COUNT(padre.id) ) AS id_tabla
                    FROM ".$tabla_struct." AS nodo,
                            ".$tabla_struct." AS padre
                    WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                    GROUP BY nodo.id
                    ORDER BY nodo.lft
              ";                
             $query = $this->db->query($sql);                
             $registros = $query->result();

          $total=0;
         foreach ($registros as $key => $value) {
            if ($data['id_nivel'] != $value->id_nivel) //excluyendo el nivel actual
              if ( $value->id_tabla ==1) {



                  $cons = "SELECT sum(n.tiempo_disponible *
                  (SELECT u.salario
                    FROM  ".$this->registro_proyecto ." up inner join ".$this->usuarios ." u on SUBSTRING(  id_val , locate(   '\"', id_val)+1 , CASE WHEN (   locate(   ',',id_val,2)-2    > 0) THEN locate(   ',',id_val,2)-2 ELSE locate(   '\"',id_val,2)-2 END         ) = u.id
                   where  id_nivel = ".$value->id_nivel." AND id_proyecto=".$data['id_proyecto']." AND id_entorno=".$this->session->userdata('entorno_activo')."
                    ) 
                  ) total 

                    FROM  ".$this->registro_proyecto ." as n where  n.id_nivel = ".$value->id_nivel." 
                   AND n.id_proyecto=".$data['id_proyecto']." AND n.id_entorno=".$this->session->userdata('entorno_activo');


                   //return $cons;
                  $result = $this->db->query( $cons); 
                 $total += $result->row()->total;





              } else {  

                /*
              SELECT id_val, locate(   '\"', id_val)+1 , locate(   '\"',id_val,2) , SUBSTRING(  id_val , locate(   '\"', id_val)+1 , locate(   '\"',id_val,2)-2)
                */
                  $cons = "SELECT sum(tiempo_disponible*
                  (SELECT u.salario
                    FROM  inven_registro_nivel". $value->id_tabla." up inner join ".$this->usuarios ." u on SUBSTRING(  id_val , locate(   '\"', id_val)+1 , CASE WHEN (   locate(   ',',id_val,2)-2    > 0) THEN locate(   ',',id_val,2)-2 ELSE locate(   '\"',id_val,2)-2 END         ) = u.id
                   where  id_nivel = ".$value->id_nivel." AND id_proyecto=".$data['id_proyecto']." AND id_entorno=".$this->session->userdata('entorno_activo')."
                    ) 
                  ) total 
                                     FROM  inven_registro_nivel". $value->id_tabla." as n where  n.id_nivel = ".$value->id_nivel." 
                   AND n.id_proyecto=".$data['id_proyecto']." AND n.id_entorno=".$this->session->userdata('entorno_activo');
                  
                   //return $cons;
                  $result = $this->db->query( $cons); 
                  $total += $result->row()->total;
              }
        }  


            $cons = 'SELECT importe total FROM  '.$this->catalogo_proyectos .' as c where  
             c.id='.$data['id_proyecto'].' AND c.id_entorno='.$this->session->userdata('entorno_activo');
            $result = $this->db->query( $cons); 
            $total = $result->row()->total-$total;

            /*
            $this->db->where('c.id_proyecto',$data['id_proyecto']);
            $this->db->where('c.id_nivel',$data['id_nivel']);
            $this->db->where('c.profundidad',$data['profundidad']);
            $this->db->where('c.id_entorno', $this->session->userdata('entorno_activo') );
            */



        return  $total;   

            if ($query->num_rows() > 0)
                return $query->row()->ruta;
            else
                return 'vacio';
            $login->free_result();
    } 





     public function listado_nivel_proyectos($data){
              
            $id_session = $this->session->userdata('id');  
            
            $this->db->select("c.id, c.id_entorno, c.id_proyecto, c.id_nivel, c.profundidad");         
            $this->db->select("c.proyecto nombre, c.descripcion, c.costo, c.tiempo_disponible");         
            $this->db->select("( CASE WHEN UNIX_TIMESTAMP(c.fecha_creacion) > 0 THEN DATE_FORMAT((c.fecha_creacion),'%d-%m-%Y') ELSE '' END ) AS fecha_creacion", FALSE);
            //$this->db->select("c.importe");         

            $this->db->select("( CASE WHEN UNIX_TIMESTAMP(c.fecha_inicial) > 0 THEN DATE_FORMAT((c.fecha_inicial),'%d-%m-%Y') ELSE '' END ) AS fecha_inicial", FALSE);


            
            $this->db->select("( CASE WHEN UNIX_TIMESTAMP(c.fecha_final) > 0 THEN DATE_FORMAT((c.fecha_final),'%d-%m-%Y') ELSE '' END ) AS fecha_final", FALSE);

            $this->db->select("c.id_val, c.json_items, c.id_usuario, c.id_user_cambio");       

            $this->db->select("c.contrato_firmado, c.pago_anticipado, c.factura_enviada");  
            $this->db->select("c.privacidad");  

            $this->db->from($this->db->dbprefix('registro_proyecto').' As c');


            $this->db->where('c.id_proyecto',$data['id_proyecto']);
            $this->db->where('c.id_nivel',$data['id_nivel']);
            $this->db->where('c.profundidad',$data['profundidad']);
            $this->db->where('c.id_entorno', $this->session->userdata('entorno_activo') );

            $result = $this->db->get(  );
                if ($result->num_rows() > 0){
                   return $result->row();
                } else {
                   return FALSE;
                }                    
                $result->free_result();
     }         



     public function listado_nivel($data){
              
            $id_session = $this->session->userdata('id');  
            
            $this->db->select("c.id, c.id_entorno, c.id_proyecto, c.id_nivel, c.profundidad");         
            $this->db->select("c.nombre, c.descripcion, c.costo, c.tiempo_disponible");         
            $this->db->select("( CASE WHEN UNIX_TIMESTAMP(c.fecha_creacion) > 0 THEN DATE_FORMAT((c.fecha_creacion),'%d-%m-%Y') ELSE '' END ) AS fecha_creacion", FALSE);
            //$this->db->select("c.importe");         
            
            $this->db->select("( CASE WHEN UNIX_TIMESTAMP(c.fecha_inicial) > 0 THEN DATE_FORMAT((c.fecha_inicial),'%d-%m-%Y') ELSE '' END ) AS fecha_inicial", FALSE);
            $this->db->select("( CASE WHEN UNIX_TIMESTAMP(c.fecha_final) > 0 THEN DATE_FORMAT((c.fecha_final),'%d-%m-%Y') ELSE '' END ) AS fecha_final", FALSE);

            $this->db->select("c.id_val, c.json_items, c.id_usuario, c.id_user_cambio");         

            $this->db->from($this->db->dbprefix('registro_nivel'.$data["profundidad"]).' As c');


            $this->db->where('c.id_proyecto',$data['id_proyecto']);
            $this->db->where('c.id_nivel',$data['id_nivel']);
            $this->db->where('c.profundidad',$data['profundidad']);
            $this->db->where('c.id_entorno', $this->session->userdata('entorno_activo') );

            $result = $this->db->get(  );
                if ($result->num_rows() > 0){
                   return $result->row();
                } else {
                   return FALSE;
                }                    
                $result->free_result();
     }      




     public function buscar_proyecto( $data ){
              
            $id_session = $this->session->userdata('id');  
            $this->db->select("c.id, c.proyecto, c.tabla,c.profundidad");         

            //$this->db->select("");         
            $this->db->select("r.id id_proy, r.id_proyecto, r.id_entorno,  r.descripcion, r.privacidad, r.costo, r.tiempo_disponible");         
            $this->db->select("DATE_FORMAT((r.fecha_creacion),'%d-%m-%Y') as fecha_creacion",false);
            $this->db->select("DATE_FORMAT((r.fecha_inicial),'%d-%m-%Y') as fecha_inicial",false);
            $this->db->select("DATE_FORMAT((r.fecha_final),'%d-%m-%Y') as fecha_final",false);
            $this->db->select("c.importe");         

            $this->db->select("r.contrato_firmado, r.pago_anticipado, r.factura_enviada");
            $this->db->select("r.id_val, r.json_items");

            $this->db->select('(c.id_usuario= "'.$id_session.'") as dueno_real',false);              
            $this->db->select('1 as dueno',false);  //1-todos tienen permiso a editar             


            $this->db->from($this->catalogo_proyectos.' As c');
            $this->db->join($this->registro_proyecto.' As r', 'r.id_proyecto = c.id');
            $this->db->where('c.tabla',$data['nombre']);

            $result = $this->db->get(  );
                if ($result->num_rows() > 0){
                   return $result->row();
                } else {
                   return FALSE;
                }                    
                $result->free_result();
     }      

    public function actualizar_reg_user_proy($data){
        $id_session = $this->session->userdata('id');
        for ($i=0; $i < count($data["id_user_proy"] ); $i++) { 
          //$this->db->set( 'id', 0 );  
          $this->db->set( 'id_entorno', $data['id_entorno'][$i] );  
          $this->db->set( 'id_proyecto', $data['id_proyecto'][$i] );  
          
          $this->db->set( 'identificador', $data['identificador'][$i] );  
          $this->db->set( 'id_nivel', $data['id_nivel'][$i] );  
          $this->db->set( 'profundidad', $data['profundidad'][$i] );  

          $this->db->set( 'descripcion', $data['descripcion'][$i]);  
          $this->db->set( 'horas', $data['hora'][$i] );  
          $this->db->set( 'id_usuario', $id_session );  
          $this->db->set( 'fecha', $data['fechapaginador'] );  

          if  (!($data['id_user_proy'][$i])) {
              $this->db->insert($this->registro_user_proy );  
              $data['id_user_proy'][$i] = $this->db->insert_id(); //obtener el id
          } else {
            $this->db->where('id', $data['id_user_proy'][$i]  );  
            $this->db->update($this->registro_user_proy );  
          }
          
        }  
        return $data;

    }
      


    //id, id_entorno, id_proyecto, descripcion, horas, fecha, id_usuario, fecha_mac





 


public function obtener_contenido() {

    $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : 0;
    
    $node = explode(':', $node);

    if(count($node) > 1) {
        $rslt = array('content' => 'Multiples Seleccionados');
    } else {
       //en este caso $temp[path] es agregado para el recorrido seleccionado
       $temp = $this->modelo_arbol->get_node((int)$node[0], array('with_path' => true));

       //aqui se conforma el formato q voy a presentar del recorrido seleccionado
       $rslt = array('content' => 'Seleccionado: /' . 
                                   implode('/',array_map(function ($v) { return $v['nm']; }, $temp['path'])).
                                   '/'.$temp['nm']
                    );
       }
     
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($rslt);
    
  }    


//checar si el entorno ya existe
    public function ruta_elemento($data){
            //http://www.teacupapps.com/blog/mysql/concatenar-varias-filas-en-una-con-mysql
              $tabla_struct  = $this->db->dbprefix('pstruct_'.$data["tabla"]);
              $tabla_data  = $this->db->dbprefix('pdata_'.$data["tabla"]);
              $sql="
              select GROUP_CONCAT(data.nm SEPARATOR ' / ') ruta 
                 from(
                    SELECT padre.id
                    FROM ".$tabla_struct." AS nodo,
                            ".$tabla_struct." AS padre
                   WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                                    AND nodo.id = ".$data['id']."
                   ORDER BY padre.lft 
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


/*
SELECT parent.name
FROM nested_category AS node,
        nested_category AS parent
WHERE node.lft BETWEEN parent.lft AND parent.rgt
        AND node.name = 'FLASH'
ORDER BY parent.lft;    

*/
  public function listado_registro_usuario($data){

        $id_session = $this->session->userdata('id');



        foreach ($data['proyecto'] as $key => $value) {
          
              
              $cons = 'SELECT nm as nombre FROM  inven_pdata_'. $value->tabla.' where  id = '.$value->id_nivel;
              $result = $this->db->query( $cons); 

               $value->proyecto = $result->row()->nombre;


              $data["id"] = $value->id_nivel;
              $data["tabla"] = $value->tabla;
              $value->ruta = self::ruta_elemento($data); 

            


         

        }  

    
        foreach ($data['proyecto'] as $key => $value) {
               
//hoy
               $this->db->select( 'r.id, r.id_entorno, r.id_proyecto, r.descripcion, r.horas,  r.id_usuario, r.profundidad, r.id_nivel' );
               $this->db->select("DATE_FORMAT((r.fecha),'%d-%m-%Y') as fecha",false);

               $this->db->select("r.horas as hr_anterior",false);
               
               $this->db->from($this->registro_user_proy.' as r');


              $where = '(

                          (
                            (r.id_usuario= "'.$id_session.'") AND
                            (r.id_entorno = '.$value->id_activo.' ) AND
                            (r.id_proyecto = '.$value->id_proyecto.'  ) AND
                            (r.identificador = '.$value->id.'  ) AND
                            (r.id_nivel = '.$value->id_nivel.'  ) AND
                            (r.profundidad = '.$value->profundidad.'  ) AND
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

               
               $this->db->select("r.horas as hr_anterior",false);
               
               $this->db->from($this->registro_user_proy.' as r');


              $where = '(

                          (
                            (r.id_usuario= "'.$id_session.'") AND
                            (r.id_entorno = '.$value->id_activo.' ) AND
                            (r.id_proyecto = '.$value->id_proyecto.'  ) AND
                            (r.identificador = '.$value->id.'  ) AND
                            (r.id_nivel = '.$value->id_nivel.'  ) AND
                            (r.profundidad = '.$value->profundidad.'  ) AND
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


/*


SELECT id_entorno, id_proyecto, id_nivel, profundidad, d.nm nombre, descripcion, costo, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items, id_usuario, id_user_cambio
FROM inven_registro_nivel2 n
inner join inven_pdata_20170222143013ZLwX960 d on n.id_nivel= d.id
WHERE ( ( ( n.id_usuario =  "00e10de5-f491-11e6-b097-7071bce181c3" ) OR ( LOCATE(  "00e10de5-f491-11e6-b097-7071bce181c3", n.id_val ) >0 ) ) AND ( n.id_entorno =1 ))





(
SELECT id_entorno, id_proyecto, id_nivel, profundidad, proyecto nombre, descripcion, costo, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items, id_usuario, id_user_cambio
FROM inven_registro_proyecto n
WHERE ( ( ( n.id_usuario =  "d86270f7-f22e-11e6-8df6-7071bce181c3" ) OR ( LOCATE(  "d86270f7-f22e-11e6-8df6-7071bce181c3", n.id_val ) >0 ) ) AND ( n.id_entorno =1 ))
)
UNION


(
SELECT id_entorno, id_proyecto, id_nivel, profundidad, nombre, descripcion, costo, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items, id_usuario, id_user_cambio
FROM inven_registro_nivel2 n
WHERE ( ( ( n.id_usuario =  "d86270f7-f22e-11e6-8df6-7071bce181c3" ) OR ( LOCATE(  "d86270f7-f22e-11e6-8df6-7071bce181c3", n.id_val ) >0 ) ) AND ( n.id_entorno =1 ))
)
UNION
(
SELECT id_entorno, id_proyecto, id_nivel, profundidad, nombre, descripcion, costo, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items, id_usuario, id_user_cambio
FROM inven_registro_nivel3 n
WHERE ( ( ( n.id_usuario =  "d86270f7-f22e-11e6-8df6-7071bce181c3" ) OR ( LOCATE(  "d86270f7-f22e-11e6-8df6-7071bce181c3", n.id_val ) >0 ) ) AND ( n.id_entorno =1 ))
)

UNION
(
SELECT id_entorno, id_proyecto, id_nivel, profundidad, nombre, descripcion, costo, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items, id_usuario, id_user_cambio
FROM inven_registro_nivel4 n
WHERE ( ( ( n.id_usuario =  "d86270f7-f22e-11e6-8df6-7071bce181c3" ) OR ( LOCATE(  "d86270f7-f22e-11e6-8df6-7071bce181c3", n.id_val ) >0 ) ) AND ( n.id_entorno =1 ))
)


*/


    public function listado_proyectos_usuarios(  ){
            $id_perfil=$this->session->userdata('id_perfil');
            $id_session = $this->session->userdata('id');
            $data["id"] = $this->session->userdata('entorno_activo');
            $nombre_activo = self::coger_entorno($data)->entorno;
            $profundidad_activo = self::coger_entorno($data)->profundidad;

            $id_entorno = $this->session->userdata('entorno_activo');



              switch ($id_perfil) {
                case 1: //super
                case 2: //Admin
                                // todos los usuarios
                 
                 $where =' WHERE  (n.id_entorno= '.$id_entorno.') '; 
                 

                  break;
                case 3: //lider
                      
                    $where=' WHERE (
                                  ( (n.id_usuario = "'.$id_session.'") OR (LOCATE("'.$id_session.'",n.id_val)>0)  )
                                    AND (n.id_entorno= '.$id_entorno.')
                          )';
                      
                  break;

                  case 4: //trabajadores
                        $where=' WHERE (
                                  ( (n.id_usuario = "'.$id_session.'") OR (LOCATE("'.$id_session.'",n.id_val)>0)  )
                                    AND (n.id_entorno= '.$id_entorno.')
                          )';
                      
                  break;              

                default:
                     //nada
                  break;
              }   


                $where=' WHERE (
                                  ( (LOCATE("'.$id_session.'",n.id_val)>0)  )
                                    AND (n.id_entorno= '.$id_entorno.')
                          )';


            //$this->db->select(',false);         
            //$this->db->select("'".$nombre_activo."' as nombre_activo",false);         
            //$this->db->select("'".$profundidad_activo."' as profundidad_activo",false);   
            
            //$this->db->select('(c.id_usuario= "'.$id_session.'") as dueno_real',false);              
            //$this->db->select('1 as dueno',false);  //1-todos tienen permiso a editar      

              //$this->db->select("c.id, c.proyecto, c.tabla, c.profundidad");         


            $campos_proy = $data["id"].' as id_activo, '.'"'.$nombre_activo.'" as nombre_activo, '.'"'.$profundidad_activo.'" as profundidad_activo, 1 as dueno, n.id_usuario = "'.$id_session.'", (n.id_usuario= "'.$id_session.'") as dueno_real, n.id, n.id_entorno, n.id_proyecto, n.id_nivel, n.profundidad, n.proyecto, n.descripcion, n.costo, n.tiempo_disponible, n.fecha_creacion, n.fecha_inicial, n.fecha_final, n.id_val, n.json_items, n.id_usuario, n.id_user_cambio, cp.tabla,cp.importe';
            
            $campos_niveles = $data["id"].' as id_activo, '.'"'.$nombre_activo.'" as nombre_activo, '.'"'.$profundidad_activo.'" as profundidad_activo, 1 as dueno, n.id_usuario = "'.$id_session.'", (n.id_usuario= "'.$id_session.'") as dueno_real, n.id,  n.id_entorno, n.id_proyecto, n.id_nivel, n.profundidad, n.nombre as proyecto, n.descripcion, n.costo, n.tiempo_disponible, n.fecha_creacion, n.fecha_inicial, n.fecha_final, n.id_val, n.json_items, n.id_usuario, n.id_user_cambio, cp.tabla,cp.importe';



                $consulta = '(select '.$campos_proy.' from '.$this->registro_proyecto.' As n 
                  inner join '.$this->catalogo_proyectos.' As cp  on cp.id = n.id_proyecto
                  '.$where.')';
                $max_entornos = $profundidad_activo; //4; //maximos entornos configurados(cantidad de tablas con nivel2..4)
                for ($i=2; $i <= $max_entornos; $i++) { 
                  $consulta .= ' union (select '.$campos_niveles.' from '.$this->db->dbprefix('registro_nivel'.$i).' As n 
                      inner join '.$this->catalogo_proyectos.' As cp  on cp.id = n.id_proyecto
                  '.$where.')';
                   
                }


                /*
                  SELECT cp.tabla FROM inven_registro_nivel2 r
                    inner join inven_catalogo_proyectos cp  on cp.id = r.id_proyecto
                    where r.id_proyecto=78
                */


             
                     
            $result = $this->db->query( $consulta);  

             if ( $result->num_rows() > 0 ) {
                  return $result->result();
              } else 
                  return false;
            $result->free_result();   
             
     }  


    public function listado_proyectos(  ){
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
                                  // todos los usuarios
                   
                   $where ='(
                            (c.id_entorno= '.$id_entorno.')
                          )'; 
                   

                    break;
                  case 3: //lider
                        $where ='(
                          ( (c.id_usuario = "'.$id_session.'") OR
                          (LOCATE("'.$id_session.'",r.id_val)>0)  '.$cond_niveles.' )
                          AND (c.id_entorno= '.$id_entorno.')
                        )'; 
                        
                    break;

                    case 4: //trabajadores
                        $where ='(
                          ( (c.id_usuario= "'.$id_session.'") OR
                          (LOCATE("'.$id_session.'",r.id_val)>0)  '.$cond_niveles.' )
                          AND (c.id_entorno= '.$id_entorno.')
                        )'; 
                        
                    break;              

                  default:
                       //nada
                    break;
                }         


                          
             $this->db->where($where);

             $this->db->group_by('c.id');

             

            $result = $this->db->get(  );
                if ($result->num_rows() > 0){
                   return $result->result();
                } else {
                   return FALSE;
                }
                    
                $result->free_result();
     }  




  


      public function buscador_usuarios($data){
            $this->db->select( 'id' );
            $this->db->select("nombre", FALSE);  
            $this->db->from($this->usuarios);
            $this->db->where("activo" ,1);
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
          $this->db->set( 'id_user_cambio',  $id_session );
          $this->db->set( 'proyecto', $data['proyecto'] );  
          $this->db->set( 'importe', $data['importe'] );  
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

                    $data['fila_insertada'] = $data['id_proyecto'];
                    $data['operacion'] = 'c';
                    self::bitacora_proyecto($data);
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();
        }    


        public function bitacora_proyecto($data){
          $id_session = $this->session->userdata('id');

          $this->db->select('"'.$id_session.'"'.' as id_user', false);
          $this->db->select('"'.$data['operacion'].'"'.' as operacion', false);
          $this->db->select('id as id_proyecto, id_entorno,importe, Proyecto, tabla, profundidad, ruta, tooltip, id_usuario, id_user_cambio');

          $this->db->from($this->catalogo_proyectos);
          $this->db->where('id',$data['fila_insertada']);
          $result = $this->db->get();

          $objeto = $result->result();
          //copiar a tabla "registros_cambios"
          foreach ($objeto as $key => $value) {
            $this->db->insert($this->bitacora_proyectos, $value); 
          }    
        }         


         public function anadir_registro_proyecto( $data ){

          $id_session = $this->session->userdata('id');
          $this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'id_user_cambio',  $id_session );
          
          
          $this->db->set( 'id_entorno', $data['id_entorno'] );
          $this->db->set( 'id_proyecto', $data['id_proyecto'] );
          $this->db->set( 'proyecto', $data['proyecto'] );  

          $this->db->set( 'descripcion', $data['descripcion'] );  
          $this->db->set( 'privacidad', $data['privacidad'] );  
          $this->db->set( 'costo', $data['costo'] );  
          $this->db->set( 'tiempo_disponible', $data['tiempo_disponible'] );  
          

          $this->db->set( 'fecha_creacion', $data['fecha_creacion'] );  
          //$this->db->set( 'importe', $data['importe'] );  

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
          
          $this->db->select('c.id, c.proyecto, c.importe,c.tabla, c.profundidad, c.ruta');

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
            $this->db->select("r.id id_proy, r.id_entorno,  r.descripcion, r.privacidad, r.costo, r.tiempo_disponible,c.importe");         
            $this->db->select("DATE_FORMAT((r.fecha_creacion),'%d-%m-%Y') as fecha_creacion",false);
            $this->db->select("DATE_FORMAT((r.fecha_inicial),'%d-%m-%Y') as fecha_inicial",false);
            $this->db->select("DATE_FORMAT((r.fecha_final),'%d-%m-%Y') as fecha_final",false);
            
            $this->db->select("r.contrato_firmado, r.pago_anticipado, r.factura_enviada");
            $this->db->select("r.id_val, r.json_items");

            //$this->db->select('(c.id_usuario= "'.$id_session.'") as dueno',false);              
            $this->db->select('1 as dueno',false);  //1-todos tienen permiso a editar             


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



           


        //editar
        public function editar_proyecto_borrar( $data ){

          $id_session = $this->session->userdata('id');
          //$this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'id_user_cambio',  $id_session );
          $this->db->set( 'proyecto', $data['proyecto'] );  
          $this->db->set( 'importe', $data['importe'] );  
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
              

           if ($this->db->affected_rows() > 0){
                    $data['fila_insertada'] = $data['id'];
                    $data['operacion'] = 'm';
                    self::bitacora_proyecto($data);   

                    return TRUE;
                } else {
                    return TRUE;
                }
                $result->free_result();
        }    



        public function editar_proyecto( $data ){

          $id_session = $this->session->userdata('id');
          //$this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'id_user_cambio',  $id_session );
          $this->db->set( 'proyecto', $data['proyecto'] );  
          $this->db->set( 'importe', $data['importe'] );  

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
              

           if ($this->db->affected_rows() > 0){
                    $data['fila_insertada'] = $data['id'];
                    $data['operacion'] = 'm';
                    self::bitacora_proyecto($data);   

                    return TRUE;
                } else {
                    return TRUE;
                }
                $result->free_result();
        }    




         public function editar_registro_proyecto( $data ){

          $id_session = $this->session->userdata('id');
          //$this->db->set( 'id_usuario',  $id_session );
          $this->db->set( 'id_user_cambio',  $id_session );
          $this->db->set( 'id_entorno', $data['id_entorno'] );
          $this->db->set( 'id_proyecto', $data['id'] );
          $this->db->set( 'proyecto', $data['proyecto'] );  

          $this->db->set( 'descripcion', $data['descripcion'] );  
          
          $this->db->set( 'costo', $data['costo'] );  
          $this->db->set( 'tiempo_disponible', $data['tiempo_disponible'] );  

          $this->db->set( 'fecha_creacion', $data['fecha_creacion'] );  
          //$this->db->set( 'importe', $data['importe'] );  
          $this->db->set( 'fecha_inicial', $data['fecha_inicial'] );  
          $this->db->set( 'fecha_final', $data['fecha_final'] );  

          /*$this->db->set( 'privacidad', $data['privacidad'] );  
          $this->db->set( 'contrato_firmado', $data['contrato_firmado'] );  
          $this->db->set( 'pago_anticipado', $data['pago_anticipado'] );  
          $this->db->set( 'factura_enviada', $data['factura_enviada'] );  
          */
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



     public function existe_nivel($data){
            
            $this->db->select("c.id");         
            $this->db->from($this->db->dbprefix('registro_nivel'.$data["profundidad"]).' As c');

            $this->db->where('c.id_proyecto',$data['id']);
            $this->db->where('c.id_nivel',$data['id_nivel']);
            $this->db->where('c.profundidad',$data['profundidad']);
            $this->db->where('c.id_entorno', $this->session->userdata('entorno_activo') );

            $result = $this->db->get(  );
                if ($result->num_rows() > 0){
                   return TRUE;
                } else {
                   return FALSE;
                }                    
                $result->free_result();
     }  

     /*
        `id`, 
        `id_entorno`, `id_proyecto`, `id_nivel`, `profundidad`,
         `nombre`, `descripcion`, `costo`, `fecha_creacion`, `fecha_inicial`, `fecha_final`, 
         `id_val`, `json_items`, `id_usuario`, `id_user_cambio`
     */

        public function editar_registro_nivel( $data ){

          $id_session = $this->session->userdata('id');
          //$this->db->set( 'id_usuario',  $id_session );
          
          $this->db->set( 'id_user_cambio',  $id_session );

          $this->db->set( 'id_entorno', $this->session->userdata('entorno_activo') );
          $this->db->set( 'id_proyecto', $data['id'] );
          $this->db->set( 'id_nivel', $data['id_nivel'] );
          $this->db->set( 'profundidad', $data['profundidad'] );

          $this->db->set( 'nombre', $data['nombre'] );  
          $this->db->set( 'descripcion', $data['descripcion'] );  
          $this->db->set( 'costo', $data['costo'] );  
          $this->db->set( 'tiempo_disponible', $data['tiempo_disponible'] );  
          $this->db->set( 'fecha_creacion', $data['fecha_creacion'] );  
          //$this->db->set( 'importe', $data['importe'] );  
          $this->db->set( 'fecha_inicial', $data['fecha_inicial'] );  
          $this->db->set( 'fecha_final', $data['fecha_final'] );  

          
          $this->db->set( 'id_val', $data['id_val'] );  
          $this->db->set( 'json_items', $data['json_items'] );  

           $this->db->where('id_proyecto',$data['id']);
           $this->db->where('id_nivel',$data['id_nivel']);
           $this->db->where('profundidad',$data['profundidad']);
           $this->db->where('id_entorno', $this->session->userdata('entorno_activo') );
           $this->db->update($this->db->dbprefix('registro_nivel'.$data["profundidad"]));

         //actualizar solo "importe" 
          $this->db->set( 'importe', $data['importe'] );  
          $this->db->where('id', $data['id'] );
          $this->db->update($this->catalogo_proyectos );



            if ($this->db->affected_rows() > 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
                $result->free_result();          

         } 




















  public function anadir_registro_nivel( $data ){

          $id_session = $this->session->userdata('id');
          
          $this->db->set( 'id_usuario',  $id_session );          
          $this->db->set( 'id_user_cambio',  $id_session );

          $this->db->set( 'id_entorno', $this->session->userdata('entorno_activo') );
          $this->db->set( 'id_proyecto', $data['id'] );
          $this->db->set( 'id_nivel', $data['id_nivel'] );
          $this->db->set( 'profundidad', $data['profundidad'] );

          //$this->db->set( 'nombre', $data['proyecto'] );  
          $this->db->set( 'nombre', $data['nombre'] );  
          $this->db->set( 'descripcion', $data['descripcion'] );  
          $this->db->set( 'costo', $data['costo'] );  
          $this->db->set( 'tiempo_disponible', $data['tiempo_disponible'] );  
          $this->db->set( 'fecha_creacion', $data['fecha_creacion'] );  
          //$this->db->set( 'importe', $data['importe'] );  
          $this->db->set( 'fecha_inicial', $data['fecha_inicial'] );  
          $this->db->set( 'fecha_final', $data['fecha_final'] );  

          
          $this->db->set( 'id_val', $data['id_val'] );  
          $this->db->set( 'json_items', $data['json_items'] );  

          $this->db->insert($this->db->dbprefix('registro_nivel'.$data["profundidad"]));



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
            
            if ( $this->db->affected_rows() > 0 ) {
                    $data['fila_insertada'] = $data['id'];
                    $data['operacion'] = 'e';
                    self::bitacora_proyecto($data);          
                    return TRUE;              
              
            }
            else return FALSE;



        }  
       
          



  

} 
?>