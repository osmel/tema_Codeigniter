 public function procesando_rep_horas_personas($data) {

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
        if  ($data['id_usuario']!="-1"){
            $filtro.= (($filtro!="") ? " and " : "") . " (r1.id_usuario = '".$data['id_usuario']."') ";  
        }

        if  ($data['id_proyecto']!="-1"){
          $filtro.= (($filtro!="") ? " and " : "") . " (r1.id_proyecto = '".$data["id_proyecto"]."') ";
        } 


        if  ($data['id_area']!="-1"){
           $filtro.= (($filtro!="") ? " and " : "") . " (u.id_cliente = ".$data['id_area'].") ";
        }

        if  ($data['id_profundidad']!="-1"){
           $filtro.= (($filtro!="") ? " and " : "") . " (r1.profundidad = ".$data['id_profundidad'].") ";
        }

        $filtro= (($filtro!="") ? " where " : "") . $filtro;
  
       foreach ($proyectos as $key => $value) {
                $tabla_struct  = $this->db->dbprefix('pstruct_'.$value->tabla);
                $tabla_data  = $this->db->dbprefix('pdata_'.$value->tabla);
                $sql=" select 
                        id_nivel, nombre, tabla, id_entorno, 
                        nomb, apellidos, salario, id_area,
                        id, id_proyecto, profundidad,
                        id_val, json_items, 
                        id_usuario, 
                        costo, tiempo_disponible, fecha_creacion, fecha_inicial,fecha_final "; 
                            
                        foreach ($arreglo_fechas as $key1 => $value1) {
                              $sql .=" ,SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '".$value1."', horas, 0)) AS 'a".strtotime($value1)."'";
                        }

                 $sql .="   from (
                         select proy.id_nivel,  proy.nombre,  proy.tabla, proy.id_entorno, 
                                 r.nombre nomb, r.apellidos, r.salario , r.id_area, 
                                 r.horas, r.fecha, 
                                 r.id, r.id_proyecto, r.profundidad,
                                 r.id_val, r.json_items, 
                                 r.id_usuario,
                                 r.costo, r.tiempo_disponible,  r.fecha_creacion, r.fecha_inicial, r.fecha_final

                          from (
                            select e.id_nivel, e.profundidad, e.nombre, p.id, p.tabla, id_entorno 
                            from (
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
                        select u.nombre, u.apellidos, u.id_cliente id_area, u.salario,
                                           h.horas, h.fecha, 
                                           r1.id, r1.id_entorno, r1.id_proyecto,r1.profundidad, r1.id_nivel, 
                                           r1.id_val, r1.json_items, 
                                           r1.id_usuario, 
                                           
                                           r1.costo, r1.tiempo_disponible,  r1.fecha_creacion, r1.fecha_inicial, r1.fecha_final
                         from 
                         (
                          SELECT id, id_entorno, id_proyecto, profundidad, id_nivel, id_val, json_items,
                                      SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario, 
                                       costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final  
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
                                     SELECT id, id_entorno, id_proyecto, profundidad, id_nivel, id_val, json_items,
                                            SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario, 
                                            costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final  
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
                          left join  ".$this->usuarios." u  on r1.id_usuario = u.id  and u.activo=1
                          left join  ".$this->registro_user_proy." h  on h.id_usuario = r1.id_usuario and 
                          h.id_entorno = r1.id_entorno and 
                          h.id_proyecto = r1.id_proyecto and 
                          h.id_nivel = r1.id_nivel ".$cond_fecha.
                          $filtro.
                         ") r 
                        on proy.id_nivel = r.id_nivel

                        ) todo 
                          
                         GROUP BY 
                        id_nivel, profundidad,  id_entorno,   id_proyecto, id_val, json_items
                      LIMIT ".$inicio.",".$largo."       
                        
                ";
                

               $result = $this->db->query( $sql); 

              if ( $result->num_rows() > 0 ) {

                      foreach ($result->result() as $key2 => $row) {
                               $dato[]= array(
                                      0=>$row->id_nivel,
                                      1=>$row->id_entorno,
                                      2=>$row->id_proyecto,
                                      3=>$row->profundidad,
                                      4=>($row->nombre!=null) ? ($row->nombre) : '',
                                      5=> count(json_decode($row->json_items,true) ),
                                      6=>$row->id,
                                      7=>$row->salario,
                                      8=>$intervalo_dia->format('%a'),
                                    );

                                for ($i=0; $i <=31 ; $i++) { //iniciar en cero las fechas
                                    $dato[count($dato)-1][9+$i] = 0;
                                }

                                foreach ($arreglo_fechas as $key1 => $value1) { //sumatoria por fecha
                                  if ($row->{ "a".strtotime($arreglo_fechas[$key1]) }!=0 ){
                                    $dato[count($dato)-1][9+$key1] = $row->{ "a".strtotime($arreglo_fechas[$key1]) };
                                  } else {
                                    $dato[count($dato)-1][9+$key1] = '<span style="color:#bfbfbf">'.$row->{ "a".strtotime($arreglo_fechas[$key1]) }.'</span>';
                                  }
                                }   
                      }
            }

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



SELECT u.id, u.nombre, u.apellidos, u.salario, AES_DECRYPT(u.email,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS email, h.id_nivel, h.id_entorno, h.id_proyecto, h.profundidad ,SUM(IF(DATE_FORMAT((h.fecha),'%d-%m-%Y') = '01-06-2017', horas, 0)) AS 'a1496293200' 
  FROM inven_usuarios u 
  left join inven_registro_user_proy h on u.id = h.id_usuario and ( DATE_FORMAT((h.fecha),'%d-%m-%Y') >= '01-06-2017' AND DATE_FORMAT((h.fecha),'%d-%m-%Y') <= '27-06-2017' ) 
  where (h.id_nivel = 8) group by u.id order by AES_DECRYPT(u.email,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5')