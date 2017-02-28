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

              
              

              

		}


/*
  $data['id_proyecto']
*/

    public function procesando_rep_general($data) {

      /*
          $cadena = addslashes($data['search']['value']);
          $inicio = $data['start'];
          $largo = $data['length'];
          

          $columa_order = $data['order'][0]['column'];
                 $order = $data['order'][0]['dir'];
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


          $id_session = $this->session->userdata('id');      
          $id_perfil=$this->session->userdata('id_perfil');

          */





        if  ( ($data['fecha_inicial'] !="") and  ($data['fecha_final'] !="")) {
                $cond_fecha = " and ( DATE_FORMAT((h.fecha),'%d-%m-%Y')  >= '".$data['fecha_inicial']."' AND  DATE_FORMAT((h.fecha),'%d-%m-%Y')  <= '".$data['fecha_final']."' ) ";
        } else {
           $cond_fecha ="";
        }




             $cons = 'SELECT id id_proyecto, id_entorno, tabla  FROM  '.$this->catalogo_proyectos .' as c where  
             c.id='.$data['id_proyecto'].' AND c.id_entorno='.$this->session->userdata('entorno_activo');
            $result = $this->db->query( $cons); 
            $proyectos = $result->result();

            foreach ($proyectos as $key => $value) {

                $tabla_struct  = $this->db->dbprefix('pstruct_'.$value->tabla);
                $tabla_data  = $this->db->dbprefix('pdata_'.$value->tabla);

                

                $sql=" select 
                        id_nivel, profundidad, nombre, tabla, id_entorno,
                        id_usuario, id,  id_proyecto,  costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items,
                        nomb, apellidos, salario ,
                            

                            SUM(IF(day(fecha) = 26, horas, 0)) AS a26,
                            SUM(IF(day(fecha) = 27, horas, 0)) AS a27,
                            SUM(IF(day(fecha) = 28, horas, 0)) AS a28,
                            SUM(IF(day(fecha) = 29, horas, 0)) AS a29,
                            SUM(IF(day(fecha) = 30, horas, 0)) AS a30,
                            SUM(IF(day(fecha) = 31, horas, 0)) AS a31
                         from (
                        select proy.id_nivel, proy.profundidad, proy.nombre, proy.id identificador, proy.tabla, proy.id_entorno,
                        r.id_usuario, r.id, r.id_proyecto,  r.costo, r.tiempo_disponible, r.fecha_creacion, r.fecha_inicial, r.fecha_final, r.id_val, r.json_items,
                        r.nombre nomb, r.apellidos, r.salario , r.horas, r.fecha
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
                             ) e, inven_catalogo_proyectos as p
                            WHERE p.id_entorno=".$value->id_entorno." and  p.tabla='".$value->tabla."'
                            )
                         proy  inner join 




                        (
                        select u.nombre, u.apellidos, u.salario, r1.id, r1.id_entorno, r1.id_proyecto, r1.id_nivel, r1.costo, r1.tiempo_disponible, r1.fecha_creacion, r1.fecha_inicial,
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
                          left join  inven_usuarios u  on r1.id_usuario = u.id
                          left join  inven_registro_user_proy h  on h.id_usuario = r1.id_usuario and 
                          h.id_entorno = r1.id_entorno and 
                          h.id_proyecto = r1.id_proyecto and 
                          h.id_nivel = r1.id_nivel ".$cond_fecha.
                         ") r 
                        on proy.id_nivel = r.id_nivel

                        ) todo

                        GROUP BY 
                        id_nivel, profundidad, nombre, tabla, id_entorno,
                        id_usuario, id,  id_proyecto,  costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items,
                        nomb, apellidos, salario 
                ";

                //return $sql;

               $result = $this->db->query( $sql); 






                //$proyectos = $result->result();
                //return $proyectos;
              //$result = $this->db->get();

              if ( $result->num_rows() > 0 ) {

                    /*
                    $cantidad_consulta = $this->db->query("SELECT FOUND_ROWS() as cantidad");
                    $found_rows = $cantidad_consulta->row(); 
                    $registros_filtrados =  ( (int) $found_rows->cantidad);

                  $retorno= " ";  
                  */

                      foreach ($result->result() as $row) {
                               $dato[]= array(
                                      0=>$row->id_nivel,
                                      1=>$row->id_entorno,
                                      2=>$row->id_proyecto,
                                      3=>$row->profundidad,
                                      4=>$row->nombre,
                                      5=>$row->nomb,
                                      6=>$row->apellidos,
                                      7=>$row->salario,
                                      8=>$row->a26,
                                      9=>$row->a27,
                                      10=>$row->a28,
                                      //4=>self::entornos_en_uso($row->id),
                                    );
                      }




                      return json_encode ( array(
                        "draw"            => 0, //intval( $data['draw'] ),
                        "recordsTotal"    => 10, //intval( self::total_cat_entornos() ), 
                        "recordsFiltered" => 10,  //$registros_filtrados, 
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