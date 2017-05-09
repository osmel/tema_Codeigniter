

profundidad,
// proy.profundidad prof_proyecto,proy.id identificador,

select id_nivel, nombre, tabla, id_entorno, 
       nomb, apellidos, salario, id_area ,
       id, id_proyecto, profundidad,
       id_val, json_items, 
       id_usuario, 
        costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final,
       SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '01-05-2017', horas, 0)) AS 'a1493614800' ,
       SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '02-05-2017', horas, 0)) AS 'a1493701200' ,
       SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '03-05-2017', horas, 0)) AS 'a1493787600' ,
       SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '04-05-2017', horas, 0)) AS 'a1493874000' ,
       SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '05-05-2017', horas, 0)) AS 'a1493960400' ,
       SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '06-05-2017', horas, 0)) AS 'a1494046800' ,
       SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '07-05-2017', horas, 0)) AS 'a1494133200' ,
       SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '08-05-2017', horas, 0)) AS 'a1494219600' 
       from ( 


                  select proy.id_nivel,  proy.nombre,  proy.tabla, proy.id_entorno, 
                          
                         
                         r.nombre nomb, r.apellidos, r.salario , r.id_area, 
                         r.horas, r.fecha, 
                         r.id, r.id_proyecto, r.profundidad,
                         r.id_val, r.json_items, 
                         r.id_usuario,
                         r.costo, r.tiempo_disponible,  r.fecha_creacion, r.fecha_inicial, r.fecha_final

                  from ( 

                            select e.id_nivel, e.profundidad, e.nombre, p.id, p.tabla, id_entorno 
                            from 	( 

                                 			select profundidad.id id_nivel, profundidad.depth profundidad, CONCAT( REPEAT( ' ', (profundidad.depth+1)*2 ) , data.nm ) nombre1,
                                             data.nm nombre 
                                      from ( 
                                        			SELECT nodo.id, (COUNT(padre.id) - 1) AS depth 
                                              FROM inven_pstruct_20170406215833ILEq874 AS nodo,
                                 			              inven_pstruct_20170406215833ILEq874 AS padre 
                                 			        WHERE nodo.lft BETWEEN padre.lft AND padre.rgt 
                                 			        GROUP BY nodo.id ORDER BY nodo.lft 
                                           ) profundidad 
                                			INNER JOIN inven_pdata_20170406215833ILEq874 data ON data.id=profundidad.id 


                                  ) e,
                        			inven_catalogo_proyectos as p WHERE p.id_entorno=1 and p.tabla='20170406215833ILEq874' 


                    ) proy 

       			        inner join ( 

                            			 	select u.nombre, u.apellidos, u.id_cliente id_area, u.salario,
                                           h.horas, h.fecha, 
                                           r1.id, r1.id_entorno, r1.id_proyecto,r1.profundidad, r1.id_nivel, 
                                           r1.id_val, r1.json_items, 
                                           r1.id_usuario, 
                                           r1.costo, r1.tiempo_disponible,  r1.fecha_creacion, r1.fecha_inicial, r1.fecha_final
                            			 	from (



                                                                SELECT id, id_entorno, id_proyecto, profundidad, id_nivel, id_val, json_items,
                                                                        SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario, 
                                                                         costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final  
                                                                         
                                                                FROM   inven_registro_proyecto t 
                                                                CROSS JOIN 
                                                                       ( 
                                                                          SELECT a.N + b.N * 10 + 1 n FROM
                                                                          (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,
                                                                          (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b 
                                                                          ORDER BY n
                                                                       ) n
                                                                WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', '')))
                                                                      and id_entorno=1 and id_proyecto=113 
                                                                      and  SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) = 'd86270f7-f22e-11e6-8df6-7071bce181c3'



                                            			union 

                                                                 SELECT id, id_entorno, id_proyecto, profundidad, id_nivel, id_val, json_items,
                                                                        SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario, 
                                                                         costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final 
                                                                FROM   inven_registro_nivel2 t 
                                                                CROSS JOIN 
                                                                       ( 
                                                                          SELECT a.N + b.N * 10 + 1 n FROM
                                                          			 		      (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,
                                                                          (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b 
                                                                          ORDER BY n
                                                                       ) n
                                                                WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', '')))
                                                                      and id_entorno=1 and id_proyecto=113 
                                                                      and  SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) = 'd86270f7-f22e-11e6-8df6-7071bce181c3'

                                                  union 


                                                                SELECT id, id_entorno, id_proyecto, profundidad, id_nivel, id_val, json_items,
                                                                        SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario, 
                                                                         costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final 
                                                                FROM   inven_registro_nivel3 t 
                                                                CROSS JOIN 
                                                                       ( 
                                                                          SELECT a.N + b.N * 10 + 1 n FROM
                                                                          (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,
                                                                          (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b 
                                                                          ORDER BY n
                                                                       ) n
                                                                WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', '')))
                                                                      and id_entorno=1 and id_proyecto=113 
                                                                      and  SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) = 'd86270f7-f22e-11e6-8df6-7071bce181c3'



                                                  union 


                                                                SELECT id, id_entorno, id_proyecto, profundidad, id_nivel, id_val, json_items,
                                                                        SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario, 
                                                                         costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final 
                                                                FROM   inven_registro_nivel4 t 
                                                                CROSS JOIN 
                                                                       ( 
                                                                          SELECT a.N + b.N * 10 + 1 n FROM
                                                                          (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,
                                                                          (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b 
                                                                          ORDER BY n
                                                                       ) n
                                                                WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', '')))
                                                                      and id_entorno=1 and id_proyecto=113 
                                                                      and  SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) = 'd86270f7-f22e-11e6-8df6-7071bce181c3'


                                                  union 


                                                                SELECT id, id_entorno, id_proyecto, profundidad, id_nivel, id_val, json_items,
                                                                        SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) id_usuario, 
                                                                         costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final 
                                                                FROM   inven_registro_nivel5 t 
                                                                CROSS JOIN 
                                                                       ( 
                                                                          SELECT a.N + b.N * 10 + 1 n FROM
                                                                          (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a ,
                                                                          (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b 
                                                                          ORDER BY n
                                                                       ) n
                                                                WHERE n.n <= 1 + (LENGTH(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 )) - LENGTH(REPLACE(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', '')))
                                                                      and id_entorno=1 and id_proyecto=113 
                                                                      and  SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING(t.id_val,2, LENGTH(t.id_val)-2 ), ',', n.n), ',', -1) = 'd86270f7-f22e-11e6-8df6-7071bce181c3'






                            			 	) r1 
                            				
                                    left join inven_usuarios u on r1.id_usuario = u.id  and u.activo=1
                            				left join inven_registro_user_proy h on h.id_usuario = r1.id_usuario and h.id_entorno = r1.id_entorno
                                                                             and h.id_proyecto = r1.id_proyecto and h.id_nivel = r1.id_nivel and ( DATE_FORMAT((h.fecha),'%d-%m-%Y') >= '01-05-2017' 
                                                                             AND DATE_FORMAT((h.fecha),'%d-%m-%Y') <= '08-05-2017' )

                 where (r1.id_usuario = 'd86270f7-f22e-11e6-8df6-7071bce181c3')                                                                                 

              ) r
              on proy.id_nivel = r.id_nivel

    ) todo 

    
    
    GROUP BY id_nivel, profundidad, nombre, tabla, id_entorno, id_usuario, id, id_proyecto, costo, tiempo_disponible, fecha_creacion, fecha_inicial, fecha_final, id_val, json_items, nomb, apellidos, salario, id_area

where (id_proyecto = '113') and (id_area = 1) and (profundidad = 0)
