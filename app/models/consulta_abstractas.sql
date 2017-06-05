/*
  Lista todos los usuarios que tiene un proyecto o nivel
*/


select * from (
		SELECT  t.id, t.id_entorno, t.id_proyecto, t.profundidad, t.id_nivel, t.id_val, t.json_items,
		    SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario, 
		     t.costo, t.tiempo_disponible, t.fecha_creacion, t.fecha_inicial, t.fecha_final,
		     u.nombre, u.apellidos,u.id_cliente id_area  

		FROM   inven_registro_proyecto t 
		CROSS JOIN 
		   ( 
		      SELECT a.N + b.N * 10 + 1 n FROM
		      (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,
		      (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b 
		      ORDER BY n
		   ) n
		left join inven_usuarios u on u.id= SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1)
		and u.activo=1       
		WHERE 
		  n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', ''))) and 
		  
		  id_entorno=1 and 
		  t.id_proyecto=113 and  
		  (SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) = 'd86270f7-f22e-11e6-8df6-7071bce181c3') and
		  t.id_nivel=1 and  
		  u.id_cliente=8


) r	  
left join inven_registro_user_proy h 
     on  h.id_usuario = r.id_usuario and h.id_entorno = r.id_entorno
     and h.id_proyecto = r.id_proyecto and h.id_nivel = r.id_nivel 
     and ( DATE_FORMAT((h.fecha),'%d-%m-%Y') >= '01-05-2017' 
     AND DATE_FORMAT((h.fecha),'%d-%m-%Y') <= '08-05-2017' )  




***********para poder convertir a columnas los usuarios
  n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', ''))) and 

***********id_entorno
  id_entorno=1 and 

***********id_proyecto
  t.id_proyecto=113 and  

***********id_usuario  
  (SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) = 'd86270f7-f22e-11e6-8df6-7071bce181c3') and

***********id_nivel
  t.id_nivel=1 and  

***********id_area
  u.id_cliente=8







u.id_cliente=8

select r.id_entorno, r.id_proyecto, r.id_nivel, u.id_cliente id_area, r.id_usuario, u.nombre, u.apellidos from (
		SELECT  t.id_proyecto, t.id_nivel,
				
		    SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario, 
		     t.id_entorno

		FROM   inven_registro_proyecto t 
		CROSS JOIN 
		   ( 
		      SELECT a.N + b.N * 10 + 1 n FROM
		      (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,
		      (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b 
		      ORDER BY n
		   ) n
		
		WHERE 
		  n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', ''))) and 
		  
		  id_entorno=1 and 
		  t.id_proyecto=113 and  
		  (SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) = 'd86270f7-f22e-11e6-8df6-7071bce181c3') and
		  t.id_nivel=1 
		  

		  
) r	  

left join inven_usuarios u on u.id= r.id_usuario
		and u.activo=1 
		and u.id_cliente = 8
left join inven_registro_user_proy h 
     on  h.id_usuario = r.id_usuario and h.id_entorno = r.id_entorno
     and h.id_proyecto = r.id_proyecto and h.id_nivel = r.id_nivel 
     and ( DATE_FORMAT((h.fecha),'%d-%m-%Y') >= '01-05-2017' 
     AND DATE_FORMAT((h.fecha),'%d-%m-%Y') <= '08-05-2017' )  



//////////////////////////////////

 $filtro="";        

      if  ($data['id_proyecto']!=0){
        $filtro.= (($filtro!="") ? " and " : "") . " (t.id_proyecto = ".$data["id_proyecto"].") ";
        $filtro_agrupamiento.= (($filtro_agrupamiento!="") ? "," : "") . "t.id_proyecto";
      } 

      if  ($data['id_profundidad']!=-1){
         $filtro.= (($filtro!="") ? " and " : "") . " (t.id_nivel = ".(((int)$data['id_profundidad'])-1).") ";
         $filtro_agrupamiento.= (($filtro_agrupamiento!="") ? "," : "") . "t.id_nivel";
      }

      if  ($data['id_area']!=0){
         $filtro.= (($filtro!="") ? " and " : "") . " (u.id_cliente = ".$data['id_area'].") ";
         $filtro_agrupamiento.= (($filtro_agrupamiento!="") ? "," : "") . "u.id_cliente";
      }

      if  ($data['id_usuario']!=0){
          $filtro.= (($filtro!="") ? " and " : "") . " ( (SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) = '".$data['id_usuario']."') ";  
          $filtro_agrupamiento.= (($filtro_agrupamiento!="") ? "," : "") . "(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) = '".$data['id_usuario']."')";
      }


select r.id_entorno, r.id_proyecto, r.id_nivel, r.id_area, r.id_usuario, u.nombre, u.apellidos from (
		"SELECT  t.id_proyecto, t.id_nivel,
		    SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario, 
		     t.id_entorno,  u.id_cliente id_area
		FROM   ".$this->registro_proyecto ."  t 
		CROSS JOIN 
		   ( 
		      SELECT a.N + b.N * 10 + 1 n FROM
		      (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,
		      (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b 
		      ORDER BY n
		   ) n
		left join inven_usuarios u on u.id= SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) and u.activo=1 			
		WHERE 
		  n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', ''))) and 
		  id_entorno=".$id_entorno.$filtro."

		for ($i=2; $i <= 5; $i++) { 
	         $sql .=" union
	          SELECT  t.id_proyecto, t.id_nivel,
		    		SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario, 
		     			t.id_entorno, u.id_cliente id_area
	                     FROM inven_registro_nivel".$i."  
	                    t CROSS JOIN 
	                      (
	                         SELECT a.N + b.N * 10 + 1 n
	                           FROM 
	                          (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
	                         ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
	                          ORDER BY n
	                      ) n
	                      left join inven_usuarios u on u.id= SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) and u.activo=1 			
	                      	WHERE 
		  n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', ''))) and 
		  
		  id_entorno=".$id_entorno.$filtro."

        }
		  
) r	  


left join inven_registro_user_proy h 
     on  h.id_usuario = r.id_usuario and h.id_entorno = r.id_entorno
     and h.id_proyecto = r.id_proyecto and h.id_nivel = r.id_nivel 
     and ( DATE_FORMAT((h.fecha),'%d-%m-%Y') >= '01-05-2017' 
     AND DATE_FORMAT((h.fecha),'%d-%m-%Y') <= '08-05-2017' )  


