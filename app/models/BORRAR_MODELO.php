<?php if(! defined('BASEPATH')) exit('No tienes permiso para acceder a este archivo');

	class Modelo_reportes extends CI_Model{
		
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

              $this->catalogo_areas                         = $this->db->dbprefix('catalogo_empresas');

              
              

              

		}

public function altura_arbol( $data ){

            $id_entorno = $this->session->userdata('entorno_activo');
            $this->db->select("c.id, c.tabla");         
            $this->db->from($this->catalogo_proyectos.' As c');
            $where ='(
                    (c.id_entorno= '.$id_entorno.') AND (c.id= '.$data["id_proyecto"].')
                  )'; 
           $this->db->where($where);            
           $result = $this->db->get( );

           $tabla =$result->row()->tabla;



          $tabla_struct  = $this->db->dbprefix('pstruct_'.$tabla);
          $tabla_data  = $this->db->dbprefix('pdata_'.$tabla);


      $cons = "select MAX(profundidad.depth) max_profundida_arbol from  (
              SELECT nodo.id, (COUNT(padre.id) - 1) AS depth
              FROM ".$tabla_struct." AS nodo,
                      ".$tabla_struct." AS padre
              WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
              GROUP BY nodo.id
              ORDER BY nodo.lft
              ) profundidad
             ";
              

          $resultado = $this->db->query( $cons); 

          return $resultado->row()->max_profundida_arbol;

          //if ( $result->num_rows() > 0 ) {


}

    public function listado_proyectos(  ){

            $id_entorno = $this->session->userdata('entorno_activo');
            $this->db->select("c.id, c.proyecto nombre");         
            $this->db->from($this->catalogo_proyectos.' As c');
  
             $where ='(
                    (c.id_entorno= '.$id_entorno.')
                  )'; 

                          
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




 public function listado_niveles($data){

      if ($data["id_proyecto"] !=0) {
        $altura_arbol = self::altura_arbol($data); 
      } else {
        $altura_arbol =  3;  
      }

      

      $arreglo = array();
      for ($i=0; $i < $altura_arbol+1; $i++) { 
        $arreglo[$i]["id"] =  $i;
        $arreglo[$i]["nombre"] ="Nivel ".($i+1);

      }

       return ((object)$arreglo);
          
 } 

public function listado_todas_areas($data){
        $this->db->select("id, area nombre", FALSE);         
          $this->db->from($this->catalogo_areas);

          $result = $this->db->get(  );
             if ( $result->num_rows() > 0 ) {
                  return $result->result();
              } else 
                  return false;
            $result->free_result(); 
 }            


 public function listado_areas($data){

        $id_entorno = $this->session->userdata('entorno_activo');
        $this->db->select("c.id, c.tabla");         
        $this->db->from($this->catalogo_proyectos.' As c');
        $where ='(
                (c.id_entorno= '.$id_entorno.') AND (c.id= '.$data["id_proyecto"].')
              )'; 
       $this->db->where($where);            
       $result = $this->db->get( );

       $tabla =$result->row()->tabla;


       
       $filtro_profundidad = "";
       $filtro_agrupamiento = " group by r.id_area ";
      if  ($data['id_profundidad']!=-1){
         //$filtro.= (($filtro!="") ? " and " : "") . " (profundidad = ".$data['id_profundidad'].") ";
         $filtro_profundidad = " where proy.profundidad =".$data['id_profundidad']; 
         $filtro_agrupamiento = " group by proy.profundidad,r.id_area ";
      }


      $tabla_struct  = $this->db->dbprefix('pstruct_'.$tabla);
      $tabla_data  = $this->db->dbprefix('pdata_'.$tabla);

      $sql ="  select r.id_area id, e.area nombre, proy.profundidad
        from (
          select e.id_nivel, e.profundidad, e.nombre, p.id, p.tabla, id_entorno  from (
              select profundidad.id id_nivel, profundidad.depth profundidad,
              CONCAT( REPEAT(  ' ', (profundidad.depth+1)*2 ) , data.nm ) nombre1,
               data.nm  nombre
               from (
                  SELECT nodo.id, (COUNT(padre.id) - 1) AS depth
                        FROM ".$tabla_struct." AS nodo,
                                ".$tabla_struct." AS padre
                  WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                  GROUP BY nodo.id
                  ORDER BY nodo.lft
              ) profundidad
              INNER JOIN ".$tabla_data." data ON data.id=profundidad.id
           ) e, ".$this->catalogo_proyectos." as p
          WHERE p.id_entorno=".$id_entorno." and  p.tabla='".$tabla."'
          )
       proy  inner join 
      (
      select u.id_cliente id_area, r1.id_nivel, r1.id_usuario
       from 
       (SELECT  id_nivel,
        SUBSTRING(  id_val , locate(   '\"', id_val)+1 , CASE WHEN (   locate(   ',',id_val,2)-2    > 0) THEN locate(   ',',id_val,2)-2 ELSE locate(   '\"',id_val,2)-2 END) id_usuario
       FROM ".$this->registro_proyecto ."  WHERE id_entorno=".$id_entorno." and id_proyecto=".$data["id_proyecto"];

              for ($i=2; $i <= 5; $i++) { 
                     $sql .=" union
                      SELECT id_nivel,
                        SUBSTRING(  id_val , locate(   '\"', id_val)+1 , CASE WHEN (   locate(   ',',id_val,2)-2    > 0) THEN locate(   ',',id_val,2)-2 ELSE locate(   '\"',id_val,2)-2 END) id_usuario
                        FROM inven_registro_nivel".$i."  WHERE id_entorno=".$id_entorno." and id_proyecto=".$data["id_proyecto"];
              }

      $sql .="
       ) r1

         left join   ".$this->usuarios." u  on r1.id_usuario = u.id) r on proy.id_nivel = r.id_nivel
         left join  ".$this->catalogo_areas."  e  on e.id = r.id_area
       ".$filtro_profundidad." 
        ".$filtro_agrupamiento." 
      having r.id_area IS NOT NULL";

      

      $result = $this->db->query( $sql); 

      if ( $result->num_rows() > 0 ) {
                  return $result->result();
              } else 
                  return false;
            $result->free_result();   


 } 



    //Lista de todos los usuarios 

  public function listado_usuarios($data){

        $id_entorno = $this->session->userdata('entorno_activo');
        $this->db->select("c.id, c.tabla");         
        $this->db->from($this->catalogo_proyectos.' As c');
        $where ='(
                (c.id_entorno= '.$id_entorno.') AND (c.id= '.$data["id_proyecto"].')
              )'; 
       $this->db->where($where);            
       $result = $this->db->get( );

       $tabla =$result->row()->tabla;


       
       $filtro_profundidad = "";
       //$filtro_agrupamiento = " group by proy.profundidad,r.id_area, r.id_usuario  ";
       $filtro_agrupamiento = " r.id_usuario  ";

    $filtro="";        

      if  ($data['id_proyecto']!=0){
        $filtro.= (($filtro!="") ? " and " : "") . " (proy.id = ".$data["id_proyecto"].") ";
        $filtro_agrupamiento.= (($filtro_agrupamiento!="") ? "," : "") . "proy.id";
      } 

      if  ($data['id_profundidad']!=-1){
         $filtro.= (($filtro!="") ? " and " : "") . " (proy.profundidad = ".$data['id_profundidad'].") ";
         $filtro_agrupamiento.= (($filtro_agrupamiento!="") ? "," : "") . "proy.profundidad";
      }

      if  ($data['id_area']!=0){
         $filtro.= (($filtro!="") ? " and " : "") . " (r.id_area = ".$data['id_area'].") ";
         $filtro_agrupamiento.= (($filtro_agrupamiento!="") ? "," : "") . "r.id_area";
      }

      if  ($data['id_usuario']!=0){
          $filtro.= (($filtro!="") ? " and " : "") . " (r.id_usuario = '".$data['id_usuario']."') ";  
         // $filtro_agrupamiento.= (($filtro_agrupamiento!="") ? "," : "") . "r.id_usuario";
      }


      $filtro= (($filtro!="") ? " where " : "") . $filtro;
      $filtro_profundidad = $filtro;


      $filtro_agrupamiento= (($filtro_agrupamiento!="") ? " group by " : "") . $filtro_agrupamiento;











      $tabla_struct  = $this->db->dbprefix('pstruct_'.$tabla);
      $tabla_data  = $this->db->dbprefix('pdata_'.$tabla);

      $sql =" select proy.id id_proyecto, proy.id_nivel, proy.profundidad, r.id_area , r.id_usuario id, r.nombre, r.apellidos
        from (
          select e.id_nivel, e.profundidad, e.nombre, p.id, p.tabla, id_entorno  from (
              select profundidad.id id_nivel, profundidad.depth profundidad,
              CONCAT( REPEAT(  ' ', (profundidad.depth+1)*2 ) , data.nm ) nombre1,
               data.nm  nombre
               from (
                  SELECT nodo.id, (COUNT(padre.id) - 1) AS depth
                        FROM ".$tabla_struct." AS nodo,
                                ".$tabla_struct." AS padre
                  WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                  GROUP BY nodo.id
                  ORDER BY nodo.lft
              ) profundidad
              INNER JOIN ".$tabla_data." data ON data.id=profundidad.id
           ) e, ".$this->catalogo_proyectos." as p
          WHERE p.id_entorno=".$id_entorno." and  p.tabla='".$tabla."'
          )
       proy  inner join 
      (
      select u.id_cliente id_area, r1.id_nivel, r1.id_usuario, u.nombre, u.apellidos
       from 
       (SELECT  id_nivel,
        SUBSTRING(  id_val , locate(   '\"', id_val)+1 , CASE WHEN (   locate(   ',',id_val,2)-2    > 0) THEN locate(   ',',id_val,2)-2 ELSE locate(   '\"',id_val,2)-2 END) id_usuario
       FROM ".$this->registro_proyecto ."  WHERE id_entorno=".$id_entorno." and id_proyecto=".$data["id_proyecto"];

              for ($i=2; $i <= 5; $i++) { 
                     $sql .=" union
                      SELECT id_nivel,
                        SUBSTRING(  id_val , locate(   '\"', id_val)+1 , CASE WHEN (   locate(   ',',id_val,2)-2    > 0) THEN locate(   ',',id_val,2)-2 ELSE locate(   '\"',id_val,2)-2 END) id_usuario
                        FROM inven_registro_nivel".$i."  WHERE id_entorno=".$id_entorno." and id_proyecto=".$data["id_proyecto"];
              }

      $sql .="
       ) r1

         left join   ".$this->usuarios." u  on r1.id_usuario = u.id ) r on proy.id_nivel = r.id_nivel
         left join  ".$this->catalogo_areas."  e  on e.id = r.id_area
       ".$filtro_profundidad." 
        ".$filtro_agrupamiento." 
      having r.nombre IS NOT NULL
      ORDER BY r.nombre asc
      ";

      

      $result = $this->db->query( $sql); 

      if ( $result->num_rows() > 0 ) {
                  return $result->result();
              } else 
                  return false;
            $result->free_result();   


 } 

      public function listado_todo_usuarios( $data ){

          $id_perfil=$this->session->userdata('id_perfil');
          $id=$this->session->userdata('id');
          $id_area=$this->session->userdata('id_area');
          $this->db->select('u.id, nombre,  apellidos');
          
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

           $this->db->where('u.activo', 1);   //solo usuarios activos

          $this->db->from($this->usuarios.' as u');

           $this->db->order_by('nombre', 'asc');
            $this->db->order_by('apellidos', 'asc');

          $result = $this->db->get();
          
          if ( $result->num_rows() > 0 )
             return $result->result();
          else
             return False;
          $result->free_result();
    }       
 



/*
  $data['id_proyecto']
*/

    public function procesando_rep_general($data) {

        $cant_filtrada = array();
        $cant_filtrada = self::total_rep_general($data);

        $total_registros =0;
        foreach ($cant_filtrada as $llave => $valor) {
             $total_registros +=$valor;
        }


      
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
        

          $id_session = $this->session->userdata('id');      
          $id_perfil=$this->session->userdata('id_perfil');

      



        if  ( ($data['fecha_inicial'] =="") || ($data['fecha_final'] =="")) {
              $data['fecha_inicial'] = date('d-m-Y',strtotime("first day of this month"));   //1er dia del mes
              $data['fecha_final'] = date('d-m-Y', strtotime('today') );  //dia de hoy
              // $cond_fecha ="";
        }

        $intervalo_dia = (new DateTime($data['fecha_inicial']))->diff(new DateTime($data['fecha_final']));

        $cond_fecha = " and ( DATE_FORMAT((h.fecha),'%d-%m-%Y')  >= '".$data['fecha_inicial']."' AND  DATE_FORMAT((h.fecha),'%d-%m-%Y')  <= '".$data['fecha_final']."' ) ";


          $arreglo_fechas = array();  //"arreglo de fechas" entre un "rango de fechas"

          if (is_string($data['fecha_inicial']) === true) $data['fecha_inicial'] = strtotime($data['fecha_inicial']);
          if (is_string($data['fecha_final']) === true ) $data['fecha_final'] = strtotime($data['fecha_final']);

          if ($data['fecha_inicial'] > $data['fecha_final']) return createDateRangeArray($data['fecha_final'], $data['fecha_inicial']);

          do {
              $arreglo_fechas[] = date('d-m-Y', $data['fecha_inicial']);
              $data['fecha_inicial'] = strtotime("+ 1 day", $data['fecha_inicial']);
          } while($data['fecha_inicial'] <= $data['fecha_final']);







             $cons = 'SELECT id id_proyecto, id_entorno, tabla  FROM  '.$this->catalogo_proyectos .' as c where  
              c.id_entorno='.$this->session->userdata('entorno_activo'); //c.id='.$data['id_proyecto'].' AND
            $result = $this->db->query( $cons); 
            $proyectos = $result->result();


    $filtro="";        
if  ($data['id_usuario']!=0){
    $filtro.= (($filtro!="") ? " and " : "") . " (id_usuario = '".$data['id_usuario']."') ";  
}

if  ($data['id_proyecto']!=0){
  $filtro.= (($filtro!="") ? " and " : "") . " (id_proyecto = '".$data["id_proyecto"]."') ";
} 


if  ($data['id_area']!=0){
   $filtro.= (($filtro!="") ? " and " : "") . " (id_area = ".$data['id_area'].") ";
}

if  ($data['id_profundidad']!=-1){
   $filtro.= (($filtro!="") ? " and " : "") . " (profundidad = ".$data['id_profundidad'].") ";
}

$filtro= (($filtro!="") ? " where " : "") . $filtro;


//$filtro=" ";




   foreach ($proyectos as $key => $value) {

                $tabla_struct  = $this->db->dbprefix('pstruct_'.$value->tabla);
                $tabla_data  = $this->db->dbprefix('pdata_'.$value->tabla);

                

                $sql=" select 
                        id_nivel, profundidad, nombre, tabla, id_entorno,
                        id_usuario, id,  id_proyecto,  costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items,
                        nomb, apellidos, salario, id_area"; 
                            
                            foreach ($arreglo_fechas as $key1 => $value1) {
                                  $sql .=" ,SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '".$value1."', horas, 0)) AS 'a".strtotime($value1)."'";
                            }

                            


                 $sql .="   from (
                        select proy.id_nivel, proy.profundidad, proy.nombre, proy.id identificador, proy.tabla, proy.id_entorno,
                        r.id_usuario, r.id, r.id_proyecto,  r.costo, r.tiempo_disponible, r.fecha_creacion, r.fecha_inicial, r.fecha_final, r.id_val, r.json_items,
                        r.nombre nomb, r.apellidos, r.salario , r.id_area, r.horas, r.fecha
                          from (
                            select e.id_nivel, e.profundidad, e.nombre, p.id, p.tabla, id_entorno  from (
                                select profundidad.id id_nivel, profundidad.depth profundidad,
                                CONCAT( REPEAT(  ' ', (profundidad.depth+1)*2 ) , data.nm ) nombre1,
                                 data.nm  nombre
                                 from (
                                    SELECT nodo.id, (COUNT(padre.id) - 1) AS depth
                                    FROM ".$tabla_struct." AS nodo,
                                            ".$tabla_struct." AS padre
                                    WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                                    GROUP BY nodo.id
                                    ORDER BY nodo.lft
                                ) profundidad
                                INNER JOIN ".$tabla_data." data ON data.id=profundidad.id
                             ) e, ".$this->catalogo_proyectos." as p
                            WHERE p.id_entorno=".$value->id_entorno." and  p.tabla='".$value->tabla."'
                            )
                         proy  inner join 




                        (
                        select u.nombre, u.apellidos, u.salario, u.id_cliente id_area, r1.id, r1.id_entorno, r1.id_proyecto, r1.id_nivel, r1.costo, r1.tiempo_disponible, r1.fecha_creacion, r1.fecha_inicial,
                        r1.fecha_final, r1.id_val, r1.json_items, r1.id_usuario, h.horas, h.fecha
                         from 
                         (SELECT id, id_entorno, id_proyecto, id_nivel, costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items,
                         SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario 
                         FROM ".$this->registro_proyecto ." 

                              t CROSS JOIN 
                                  (
                                     SELECT a.N + b.N * 10 + 1 n
                                       FROM 
                                      (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                                     ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                                      ORDER BY n
                                  ) n
                                   WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', '')))   and id_entorno=".$value->id_entorno." and id_proyecto=".$value->id_proyecto."
                                   ";


                          


                          for ($i=2; $i <= 5; $i++) { 
                             $sql .=" union
                              SELECT id, id_entorno, id_proyecto, id_nivel, costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items,
                                SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario 

                                FROM inven_registro_nivel".$i."  
                                t CROSS JOIN 
                                  (
                                     SELECT a.N + b.N * 10 + 1 n
                                       FROM 
                                      (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                                     ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                                      ORDER BY n
                                  ) n
                                   WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', '')))   and id_entorno=".$value->id_entorno." and id_proyecto=".$value->id_proyecto."
                                   ";





                          }

                          $sql .="
                        ) r1 
                          left join  ".$this->usuarios." u  on r1.id_usuario = u.id
                          left join  ".$this->registro_user_proy." h  on h.id_usuario = r1.id_usuario and 
                          h.id_entorno = r1.id_entorno and 
                          h.id_proyecto = r1.id_proyecto and 
                          h.id_nivel = r1.id_nivel ".$cond_fecha.
                         ") r 
                        on proy.id_nivel = r.id_nivel

                        ) todo 
                        ".$filtro."                           
                          
                         GROUP BY 
                        id_nivel, profundidad, nombre, tabla, id_entorno, id_usuario, id,  id_proyecto,  costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items, nomb, apellidos, salario, id_area
                        LIMIT ".$inicio.",".$largo." 
                        
                ";

                //
                //LIMIT 0 OFFSET 10
              

               $result = $this->db->query( $sql); 



              if ( $result->num_rows() > 0 ) {


                      

                      foreach ($result->result() as $key2 => $row) {
                               $dato[]= array(
                                      0=>$row->id_nivel,
                                      1=>$row->id_entorno,
                                      2=>$row->id_proyecto,
                                      3=>$row->profundidad,
                                      4=>($row->nombre!=null) ? ($row->nombre) : '',
                                      5=>($row->nomb!=null) ? ($row->nomb) : '',
                                      6=>($row->apellidos!=null) ? ($row->apellidos) : '',
                                      7=>$row->salario,
                                      8=>$intervalo_dia->format('%a'),
                                    );

                                for ($i=0; $i <31 ; $i++) { 
                                   //$dato[$key][9+$i] = 0;
                                    $dato[count($dato)-1][9+$i] = 0;
                                }

                                foreach ($arreglo_fechas as $key1 => $value1) {
                                    $dato[count($dato)-1][9+$key1] = $row->{ "a".strtotime($arreglo_fechas[$key1]) };
                                }    
                      }

            }

              //return $inicio+($result->num_rows());
            //$inicio = $inicio+($result->num_rows()+1);


//return $key;

            if ($result->num_rows() <>0 ) {
                if ( $largo-($result->num_rows())<=0 ) {  //si ya acabo de desplazarse completamente
                        break;
                } else {  //recortar el largo
                    $inicio=0;
                    $largo = $largo-($result->num_rows());    
                }
            } else { //si no hubo ocupado, porq ya fue cubierto la vez anterior
                $inicio = $inicio - ( $cant_filtrada[$key]);   //$cant_filtrada = todos los registros que se tuvieron en cuenta 

            }
            

  }   //fin del foreach de proyectos



               if ( isset($dato) ) {
                      return json_encode ( array(
                        "draw"            => intval( $data['draw'] ),
                        "recordsTotal"    => $total_registros, //intval( self::total_cat_entornos() ), 
                        "recordsFiltered" => $total_registros,  //$registros_filtrados, 
                                 "intervalo"=>$intervalo_dia->format('%a'),
                        "data"            =>  $dato 
                      ));
                    
              } else {
                  //cuando este vacio la tabla que envie este
                //http://www.datatables.net/forums/discussion/21311/empty-ajax-response-wont-render-in-datatables-1-10
                  $output = array(
                  "draw" =>  intval( $data['draw'] ),
                  "recordsTotal" => 0,
                  "recordsFiltered" =>0,
                  "intervalo"=>$intervalo_dia->format('%a'),
                  "aaData" => array()
                  );
                  $array[]="";
                  return json_encode($output);
                  

              }

              $result->free_result();   
  
  }       





public function total_rep_general($data) {

      
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
        

          $id_session = $this->session->userdata('id');      
          $id_perfil=$this->session->userdata('id_perfil');

        if  ( ($data['fecha_inicial'] =="") || ($data['fecha_final'] =="")) {
              $data['fecha_inicial'] = date('d-m-Y',strtotime("first day of this month"));   //1er dia del mes
              $data['fecha_final'] = date('d-m-Y', strtotime('today') );  //dia de hoy
        }

        $intervalo_dia = (new DateTime($data['fecha_inicial']))->diff(new DateTime($data['fecha_final']));

        $cond_fecha = " and ( DATE_FORMAT((h.fecha),'%d-%m-%Y')  >= '".$data['fecha_inicial']."' AND  DATE_FORMAT((h.fecha),'%d-%m-%Y')  <= '".$data['fecha_final']."' ) ";


          $arreglo_fechas = array();  //"arreglo de fechas" entre un "rango de fechas"

          if (is_string($data['fecha_inicial']) === true) $data['fecha_inicial'] = strtotime($data['fecha_inicial']);
          if (is_string($data['fecha_final']) === true ) $data['fecha_final'] = strtotime($data['fecha_final']);

          if ($data['fecha_inicial'] > $data['fecha_final']) return createDateRangeArray($data['fecha_final'], $data['fecha_inicial']);

          do {
              $arreglo_fechas[] = date('d-m-Y', $data['fecha_inicial']);
              $data['fecha_inicial'] = strtotime("+ 1 day", $data['fecha_inicial']);
          } while($data['fecha_inicial'] <= $data['fecha_final']);


             $cons = 'SELECT id id_proyecto, id_entorno, tabla  FROM  '.$this->catalogo_proyectos .' as c where  
              c.id_entorno='.$this->session->userdata('entorno_activo'); //c.id='.$data['id_proyecto'].' AND
            $result = $this->db->query( $cons); 
            $proyectos = $result->result();


                $filtro="";        
            if  ($data['id_usuario']!=0){
                $filtro.= (($filtro!="") ? " and " : "") . " (id_usuario = '".$data['id_usuario']."') ";  
            }

            if  ($data['id_proyecto']!=0){
              $filtro.= (($filtro!="") ? " and " : "") . " (id_proyecto = '".$data["id_proyecto"]."') ";
            } 


            if  ($data['id_area']!=0){
               $filtro.= (($filtro!="") ? " and " : "") . " (id_area = ".$data['id_area'].") ";
            }

            if  ($data['id_profundidad']!=-1){
               $filtro.= (($filtro!="") ? " and " : "") . " (profundidad = ".$data['id_profundidad'].") ";
            }

            $filtro= (($filtro!="") ? " where " : "") . $filtro;


   $arreglo_total= array();

   foreach ($proyectos as $key => $value) {

                $tabla_struct  = $this->db->dbprefix('pstruct_'.$value->tabla);
                $tabla_data  = $this->db->dbprefix('pdata_'.$value->tabla);

                

                $sql=" select 
                        id_nivel, profundidad, nombre, tabla, id_entorno,
                        id_usuario, id,  id_proyecto,  costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items,
                        nomb, apellidos, salario, id_area"; 
                            
                            foreach ($arreglo_fechas as $key1 => $value1) {
                                  $sql .=" ,SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '".$value1."', horas, 0)) AS 'a".strtotime($value1)."'";
                            }

                            


                 $sql .="   from (
                        select proy.id_nivel, proy.profundidad, proy.nombre, proy.id identificador, proy.tabla, proy.id_entorno,
                        r.id_usuario, r.id, r.id_proyecto,  r.costo, r.tiempo_disponible, r.fecha_creacion, r.fecha_inicial, r.fecha_final, r.id_val, r.json_items,
                        r.nombre nomb, r.apellidos, r.salario , r.id_area, r.horas, r.fecha
                          from (
                            select e.id_nivel, e.profundidad, e.nombre, p.id, p.tabla, id_entorno  from (
                                select profundidad.id id_nivel, profundidad.depth profundidad,
                                CONCAT( REPEAT(  ' ', (profundidad.depth+1)*2 ) , data.nm ) nombre1,
                                 data.nm  nombre
                                 from (
                                    SELECT nodo.id, (COUNT(padre.id) - 1) AS depth
                                    FROM ".$tabla_struct." AS nodo,
                                            ".$tabla_struct." AS padre
                                    WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                                    GROUP BY nodo.id
                                    ORDER BY nodo.lft
                                ) profundidad
                                INNER JOIN ".$tabla_data." data ON data.id=profundidad.id
                             ) e, ".$this->catalogo_proyectos." as p
                            WHERE p.id_entorno=".$value->id_entorno." and  p.tabla='".$value->tabla."'
                            )
                         proy  inner join 




                        (
                        select u.nombre, u.apellidos, u.salario, u.id_cliente id_area, r1.id, r1.id_entorno, r1.id_proyecto, r1.id_nivel, r1.costo, r1.tiempo_disponible, r1.fecha_creacion, r1.fecha_inicial,
                        r1.fecha_final, r1.id_val, r1.json_items, r1.id_usuario, h.horas, h.fecha
                         from 
                         (SELECT id, id_entorno, id_proyecto, id_nivel, costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items,
                          SUBSTRING(  id_val , locate(   '\"', id_val)+1 , CASE WHEN (   locate(   ',',id_val,2)-2    > 0) THEN locate(   ',',id_val,2)-2 ELSE locate(   '\"',id_val,2)-2 END) id_usuario
                         FROM ".$this->registro_proyecto ."  WHERE id_entorno=".$value->id_entorno." and id_proyecto=".$value->id_proyecto;


                          for ($i=2; $i <= 5; $i++) { 
                             $sql .=" union
                              SELECT id, id_entorno, id_proyecto, id_nivel, costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items,
                                SUBSTRING(  id_val , locate(   '\"', id_val)+1 , CASE WHEN (   locate(   ',',id_val,2)-2    > 0) THEN locate(   ',',id_val,2)-2 ELSE locate(   '\"',id_val,2)-2 END) id_usuario
                                FROM inven_registro_nivel".$i."  WHERE id_entorno=".$value->id_entorno." and id_proyecto=".$value->id_proyecto;
                          }

                          $sql .="
                        ) r1 
                          left join  ".$this->usuarios." u  on r1.id_usuario = u.id
                          left join  ".$this->registro_user_proy." h  on h.id_usuario = r1.id_usuario and 
                          h.id_entorno = r1.id_entorno and 
                          h.id_proyecto = r1.id_proyecto and 
                          h.id_nivel = r1.id_nivel ".$cond_fecha.
                         ") r 
                        on proy.id_nivel = r.id_nivel

                        ) todo 
                        ".$filtro."                           
                          
                         GROUP BY 
                        id_nivel, profundidad, nombre, tabla, id_entorno, id_usuario, id,  id_proyecto,  costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items, nomb, apellidos, salario, id_area
                       
                ";

              

              $result = $this->db->query( $sql); 


              $arreglo_total[] = $result->num_rows();



    }   //fin del foreach de proyectos

    return $arreglo_total;
  
  }       




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
                  $result = $this->db->query( $cons); 
                 $total += $result->row()->total;

              } else {  

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
            $datoss['total'] = $result->row()->total-$total;


            //fin  de total de tiempo disponible

            
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //Fecha creacion
            $cons = 'SELECT ( CASE WHEN UNIX_TIMESTAMP(c.fecha_creacion) > 0 THEN DATE_FORMAT((c.fecha_creacion),"%Y-%m-%d 0:00") ELSE "" END ) AS fecha_creacion
              FROM  '.$this->registro_proyecto .' as c where  
             c.id_proyecto='.$data['id_proyecto'].' AND c.id_entorno='.$this->session->userdata('entorno_activo');
            $result = $this->db->query( $cons); 
            $fecha_creacion = $result->row()->fecha_creacion;


          //listado de sus padres, abuelos, etc en orden descendente
          $cons = "SELECT estructura.id id_nivel, data.nm,
                                ( SELECT  (COUNT(padre.id)) AS id_tabla
                                FROM ".$tabla_struct."  AS nodo,
                                        ".$tabla_struct."  AS padre
                                WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                                AND nodo.id = estructura.id
                                GROUP BY nodo.id
                                ORDER BY nodo.lft
                                ) id_tabla
           from (
            SELECT padre.id
            FROM ".$tabla_struct."  AS nodo,
                    ".$tabla_struct."  AS padre
            WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                    AND nodo.id =  ".$data['id_nivel']."
            ORDER BY padre.lft desc
          ) estructura
          INNER JOIN ".$tabla_data."  data ON data.id=estructura.id
          ";

           $result = $this->db->query( $cons); 
           $padres = $result->result();

            //listados de hijos, nietos, etc
            $cons = "SELECT estructura.id id_nivel, data.nm, 
                                ( SELECT  (COUNT(padre.id)) AS id_tabla
                                FROM ".$tabla_struct."  AS nodo,
                                        ".$tabla_struct."  AS padre
                                WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                                AND nodo.id = estructura.id
                                GROUP BY nodo.id
                                ORDER BY nodo.lft
                                ) id_tabla
            from ( 
            SELECT nodo.id
            FROM ".$tabla_struct." AS nodo ,
                 ".$tabla_struct." AS padre
            WHERE nodo.lft BETWEEN padre.lft AND padre.rgt
                    AND padre.id = ".$data['id_nivel']."
            ORDER BY nodo.lft ) estructura
            INNER JOIN ".$tabla_data." data ON data.id=estructura.id
            ";
            $result = $this->db->query( $cons); 
            $hijos = $result->result();
            


            $fecha_inicial= array();
            $fecha_final= array();
          foreach ($padres as $key => $value) {
              
              //if ($data['id_nivel'] != $value->id_nivel) //excluyendo el nivel actual
                
                if ( $value->id_tabla ==1) {
                    
                    $cons = "SELECT ( CASE WHEN UNIX_TIMESTAMP(n.fecha_inicial) > 0 THEN DATE_FORMAT((n.fecha_inicial),'%Y-%m-%d 0:00') ELSE '' END ) AS fecha_inicial,
                                    ( CASE WHEN UNIX_TIMESTAMP(n.fecha_final) > 0 THEN DATE_FORMAT((n.fecha_final),'%Y-%m-%d 0:00') ELSE '' END ) AS fecha_final
                      FROM  ".$this->registro_proyecto ." as n where  n.id_nivel = ".$value->id_nivel." 
                     AND n.id_proyecto=".$data['id_proyecto']." AND n.id_entorno=".$this->session->userdata('entorno_activo');
                    $result = $this->db->query( $cons); 
                    
                    if ($data['id_nivel'] != $value->id_nivel) {
                            if ($result->row()->fecha_inicial!="")
                              $fecha_inicial[] = $result->row()->fecha_inicial;

                            if ($result->row()->fecha_final!="")
                              $fecha_final[] = $result->row()->fecha_final;
                    } else {
                      $fecha_inicio = $result->row()->fecha_inicial;
                         $fecha_fin = $result->row()->fecha_final;
                    }


                } else {  

                    $cons = "SELECT ( CASE WHEN UNIX_TIMESTAMP(n.fecha_inicial) > 0 THEN DATE_FORMAT((n.fecha_inicial),'%Y-%m-%d 0:00') ELSE '' END ) AS fecha_inicial,
                                    ( CASE WHEN UNIX_TIMESTAMP(n.fecha_final) > 0 THEN DATE_FORMAT((n.fecha_final),'%Y-%m-%d 0:00') ELSE '' END ) AS fecha_final
                          FROM  inven_registro_nivel". $value->id_tabla." as n where  n.id_nivel = ".$value->id_nivel." 
                     AND n.id_proyecto=".$data['id_proyecto']." AND n.id_entorno=".$this->session->userdata('entorno_activo');
                    $result = $this->db->query( $cons); 

                    if ($data['id_nivel'] != $value->id_nivel) {
                        if ($result->row()->fecha_inicial!="")
                          $fecha_inicial[] = $result->row()->fecha_inicial;

                        if ($result->row()->fecha_final!="")
                          $fecha_final[] = $result->row()->fecha_final;
                    } else {
                      $fecha_inicio = $result->row()->fecha_inicial;
                         $fecha_fin = $result->row()->fecha_final;
                    }


                }









          }  


           if  (!($fecha_inicial))  //sino hay ninguna fecha_inicial entonces tomará la de creacion
                $fecha_inicial_padre = $fecha_creacion; //$fecha_inicial[] = $fecha_creacion;
           else      
                $fecha_inicial_padre = $fecha_inicial[0]; 


           if  (!($fecha_final)) { //sino hay ninguna fecha_final entonces tomará la de fecha inicial
                //$fecha_final_padre = $fecha_inicial_padre; //$fecha_final[] = $fecha_inicial[0];
                $fecha_final_padre = '';
           } else {      
                $fecha_final_padre = $fecha_final[0]; 
           }

 

                //>= $fecha_inicial[0]   and  <= $fecha_final[0]




            $fecha_inicial= array();
            $fecha_final= array();

          foreach ($hijos as $key => $value) {
              if ($data['id_nivel'] != $value->id_nivel) //excluyendo el nivel actual
                if ( $value->id_tabla ==1) {
                    
                    $cons = "SELECT ( CASE WHEN UNIX_TIMESTAMP(n.fecha_inicial) > 0 THEN DATE_FORMAT((n.fecha_inicial),'%Y-%m-%d 0:00') ELSE '' END ) AS fecha_inicial,
                                    ( CASE WHEN UNIX_TIMESTAMP(n.fecha_final) > 0 THEN DATE_FORMAT((n.fecha_final),'%Y-%m-%d 0:00') ELSE '' END ) AS fecha_final
                      FROM  ".$this->registro_proyecto ." as n where  n.id_nivel = ".$value->id_nivel." 
                     AND n.id_proyecto=".$data['id_proyecto']." AND n.id_entorno=".$this->session->userdata('entorno_activo');
                    $result = $this->db->query( $cons); 
                    
                    if ($result->row()->fecha_inicial!="")
                      $fecha_inicial[] = $result->row()->fecha_inicial;

                    if ($result->row()->fecha_final!="")
                      $fecha_final[] = $result->row()->fecha_final;

                } else {  

                    $cons = "SELECT ( CASE WHEN UNIX_TIMESTAMP(n.fecha_inicial) > 0 THEN DATE_FORMAT((n.fecha_inicial),'%Y-%m-%d 0:00') ELSE '' END ) AS fecha_inicial,
                                    ( CASE WHEN UNIX_TIMESTAMP(n.fecha_final) > 0 THEN DATE_FORMAT((n.fecha_final),'%Y-%m-%d 0:00') ELSE '' END ) AS fecha_final
                          FROM  inven_registro_nivel". $value->id_tabla." as n where  n.id_nivel = ".$value->id_nivel." 
                     AND n.id_proyecto=".$data['id_proyecto']." AND n.id_entorno=".$this->session->userdata('entorno_activo');
                    $result = $this->db->query( $cons); 


                    if ($result->row()->fecha_inicial!="")
                      $fecha_inicial[] = $result->row()->fecha_inicial;

                    if ($result->row()->fecha_final!="")
                      $fecha_final[] = $result->row()->fecha_final;

                }
          }  





          sort($fecha_inicial);

          $fecha_final_hijo_mayor ="";
          $fecha_inicial_hijo_mayor="";

          if  ($fecha_inicial) {
             $fecha_inicial_hijo_menor =  $fecha_inicial[0]; 
             $fecha_inicial_hijo_mayor =  $fecha_inicial[count($fecha_inicial)-1]; 
          } else {
            $fecha_inicial_hijo_menor ='';
             //$fecha_inicial_hijo_menor =  $fecha_final_padre; 
          }

          sort($fecha_final);

          if  ($fecha_final) {
             $fecha_final_hijo_menor =  $fecha_final[0]; 
             $fecha_final_hijo_mayor =  $fecha_final[count($fecha_final)-1]; 
          } else {
            $fecha_final_hijo_menor = '';
             //$fecha_final_hijo_menor =  $fecha_final_padre; 
          }


          //<= $fecha_inicial[0]   and  <= $fecha_final[0]




/*
 $cond =' fecha_inicial >="'.$fecha_creacion.'"' ;
$cond .= ($fecha_inicial_padre!='') ? ' AND fecha_inicial >="'.$fecha_inicial_padre.'"' : '' ; 
$cond .= ($fecha_final_padre!='') ? ' AND fecha_inicial <="'.$fecha_final_padre.'"' : '' ; 
$cond .= ($fecha_inicial_hijo_menor!='') ? ' AND fecha_inicial <="'.$fecha_inicial_hijo_menor.'"' : '' ;  
$cond .= ($fecha_final_hijo_menor!='') ? ' AND fecha_inicial <="'.$fecha_final_hijo_menor.'"' : '' ; 
$cond .= ($fecha_fin!='') ? ' AND fecha_inicial <="'.$fecha_fin.'"' : '' ; 
*/


/*
//fecha_inicial
$datos['cond_finicial']  = " fecha_inicial >='".$fecha_creacion."'" ;
$datos['cond_finicial'] .= ($fecha_inicial_padre!="") ? " AND fecha_inicial >='".$fecha_inicial_padre."'" : "" ; 

$datos['cond_finicial'] .= ($fecha_final_padre!="") ? " AND fecha_inicial <='".$fecha_final_padre."'" : "" ; 
$datos['cond_finicial'] .= ($fecha_inicial_hijo_menor!="") ? " AND fecha_inicial <='".$fecha_inicial_hijo_menor."'" : "" ;  
$datos['cond_finicial'] .= ($fecha_final_hijo_menor!="") ? " AND fecha_inicial <='".$fecha_final_hijo_menor."'" : "" ; 
$datos['cond_finicial'] .= ($fecha_fin!="") ? " AND fecha_inicial <='".$fecha_fin."'" : "" ; 


//fecha_final
$datos['cond_ffinal'] =" fecha_final >='".$fecha_creacion."'" ;
$datos['cond_ffinal'] .= ($fecha_inicial_padre!="") ? " AND fecha_final >='".$fecha_inicial_padre."'" : "" ; 
$datos['cond_ffinal'] .= ($fecha_final_padre!="") ? " AND fecha_final <='".$fecha_final_padre."'" : "" ; 
$datos['cond_ffinal'] .= ($fecha_inicial_hijo_mayor!="") ? " AND fecha_final >='".$fecha_inicial_hijo_mayor."'" : "" ;  
$datos['cond_ffinal'] .= ($fecha_final_hijo_mayor!="") ? " AND fecha_final >='".$fecha_final_hijo_mayor."'" : "" ; 
$datos['cond_ffinal'] .= ($fecha_inicio!="") ? " AND fecha_final >='".$fecha_inicio."'" : "" ; 
*/


$datos['cond_finicial_mayor']= array();
$datos['cond_ffinal_mayor']= array();
$datos['cond_finicial_menor']= array();
$datos['cond_ffinal_menor'] = array();



if ($fecha_creacion!="") {
    $datos['cond_finicial_mayor'][] = $fecha_creacion;
    $datos['cond_ffinal_mayor'][] = $fecha_creacion;
}

if ($fecha_inicial_padre!="") {
    $datos['cond_finicial_mayor'][] = $fecha_inicial_padre;
    $datos['cond_ffinal_mayor'][] = $fecha_inicial_padre;
}

if ($fecha_final_padre!="") {
  $datos['cond_finicial_menor'][] = $fecha_final_padre;
  $datos['cond_ffinal_menor'][] = $fecha_final_padre;

}  

if ($fecha_inicial_hijo_menor!="") {
  $datos['cond_finicial_menor'][] = $fecha_inicial_hijo_menor;
}

if ($fecha_final_hijo_menor!="") {
  $datos['cond_finicial_menor'][] = $fecha_final_hijo_menor;
}


if ($fecha_fin!="") {
   $datos['cond_finicial_menor'][] = $fecha_fin;
}  

if ($fecha_inicial_hijo_mayor!="") {
   $datos['cond_ffinal_mayor'][] = $fecha_inicial_hijo_mayor;
}  


if ($fecha_final_hijo_mayor!="") {
   $datos['cond_ffinal_mayor'][] = $fecha_final_hijo_mayor;
}  

if ($fecha_inicio!="") {
    $datos['cond_ffinal_mayor'][] = $fecha_inicio;
}  


sort($datos['cond_finicial_mayor']);
sort($datos['cond_ffinal_mayor']);

sort($datos['cond_finicial_menor']);
sort($datos['cond_ffinal_menor']);


$datoss['inicial_start'] = $datos['cond_finicial_mayor'][count($datos['cond_finicial_mayor'])-1];
$datoss['inicial_end'] = (isset($datos['cond_finicial_menor'][0])) ? ($datos['cond_finicial_menor'][0]) : null;

$datoss['final_start'] = (isset($datos['cond_ffinal_mayor'][count($datos['cond_ffinal_mayor'])-1])) ? $datos['cond_ffinal_mayor'][count($datos['cond_ffinal_mayor'])-1] : null;
$datoss['final_end']=    (isset($datos['cond_ffinal_menor'][0])) ? $datos['cond_ffinal_menor'][0] : null;













           


        return  ($datoss);   




            if ($query->num_rows() > 0)
                return $query->row()->ruta;
            else
                return 'vacio';
            $login->free_result();
    } 



       
          



  

} 
?>