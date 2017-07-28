select proy.id id_proyecto, proy.id_nivel, proy.profundidad,
	 r.id_area , r.id_usuario id, r.nombre, r.apellidos 

from ( 
	select e.id_nivel, e.profundidad, e.nombre, p.id, p.tabla, id_entorno 
		from (
			 select profundidad.id id_nivel, profundidad.depth profundidad, 
			 CONCAT( REPEAT( ' ', (profundidad.depth+1)*2 ) , data.nm ) nombre1,
			 data.nm nombre from ( SELECT nodo.id, (COUNT(padre.id) - 1) AS depth 
			 	FROM inven_pstruct_20170411160013CzhA530 AS nodo, 
			 		 inven_pstruct_20170411160013CzhA530 AS padre 
			 	WHERE nodo.lft BETWEEN padre.lft AND padre.rgt 
			 	GROUP BY nodo.id ORDER BY nodo.lft) profundidad 
		INNER JOIN inven_pdata_20170411160013CzhA530 data ON data.id=profundidad.id 
		) e,
		inven_catalogo_proyectos as p 
		WHERE p.id_entorno=1 and p.tabla='20170411160013CzhA530' 
) proy 
inner join 
	



	(


	 select u.id_cliente id_area, r1.id_nivel, r1.id_usuario, u.nombre, u.apellidos 
	  from (
	    SELECT id_nivel, SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario FROM inven_registro_proyecto t CROSS JOIN ( SELECT a.N + b.N * 10 + 1 n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b ORDER BY n ) n WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', ''))) and id_entorno=1 and id_proyecto=141 union 

	    SELECT id_nivel, 
	    	SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario 
	    FROM inven_registro_nivel2 t 
	       CROSS JOIN ( SELECT a.N + b.N * 10 + 1 n FROM 
	       (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a,
	       (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b 
	   ORDER BY n ) n 

	       WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', ''))) and id_entorno=1 and id_proyecto=141 union 

	       SELECT id_nivel, SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario FROM inven_registro_nivel3 t CROSS JOIN ( SELECT a.N + b.N * 10 + 1 n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b ORDER BY n ) n WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', ''))) and id_entorno=1 and id_proyecto=141 union SELECT id_nivel, SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario FROM inven_registro_nivel4 t CROSS JOIN ( SELECT a.N + b.N * 10 + 1 n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b ORDER BY n ) n WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', ''))) and id_entorno=1 and id_proyecto=141 union SELECT id_nivel, SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario FROM inven_registro_nivel5 t CROSS JOIN ( SELECT a.N + b.N * 10 + 1 n FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b ORDER BY n ) n 
	       WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', ''))) and id_entorno=1 and id_proyecto=141 ) r1 left join inven_usuarios u on r1.id_usuario = u.id 



	       ) r 


	  on proy.id_nivel = r.id_nivel left join inven_catalogo_empresas e on e.id = r.id_area where (proy.id = 141) and (proy.profundidad = -1) group by r.id_usuario ,proy.id,proy.profundidad having r.nombre IS NOT NULL ORDER BY r.nombre asc

