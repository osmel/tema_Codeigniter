select * from 
(
SELECT c1.id,c1.id_cliente,c1.area, c1.proyecto, c1.importe,c1.hora_asignado, c1.salario_gasto, c1.presupuesto, c2.utilizado,c1.fecha_creacion, c1.importe-c1.presupuesto as ganancia_proyeccion, c1.importe-c2.utilizado as ganancia_perdida from (SELECT p.id, u.id_cliente, pr.area, p.proyecto, p.importe, sum(c.tiempo_disponible) as hora_asignado, (((u.salario+3333.3333333333)/20)/8) as salario_gasto, (((u.salario+3333.3333333333)/20)/8)*sum(c.tiempo_disponible) as presupuesto, DATE_FORMAT((p.fecha_mac), '%d-%m-%Y') as fecha_creacion FROM inven_catalogo_proyectos as p LEFT JOIN inven_registro_costos As c ON p.id = c.id_proyecto and c.id_entorno= p.id_entorno JOIN inven_usuarios As u ON u.id = c.id_user_seleccion JOIN inven_catalogo_empresas As pr ON pr.id = u.id_cliente WHERE ( (p.id_entorno= 1) ) GROUP BY p.id, u.id_cliente) c1 JOIN (SELECT up.id_proyecto, sum(up.horas) as hora_asignado, u.id_cliente, (((u.salario+3333.3333333333)/20)/8) as salario_gasto, (((u.salario+3333.3333333333)/20)/8)*sum(up.horas) as utilizado FROM inven_registro_user_proy as up JOIN inven_usuarios As u ON u.id = up.id_usuario WHERE ( (up.id_entorno= 1) ) GROUP BY up.id_proyecto, u.id_cliente) as c2 ON c2.id_proyecto = c1.id

) aaa

where proyecto="Impacto Textil Bajío"


Bajio
	lucero 1 3 
	ariadna 1 15
	osmel 8 30 100 

	marketing digital
		lucero ->4   (10000)      83.333  * 4	   =  333.33
		ariadna -> 16  (10000)	  83.333  * 16	   = 1333.33
													==========
													1666.66
	Desarrollo web
		osmel ->138  (5000)		 52.083	  * 138   = 7187.454
											    ---------------
													8854.104 (error esta en que se esta multiplicando por 83.33 todos)



select * from 
(
SELECT c1.id,c1.id_cliente,c1.area, c1.proyecto, c1.importe,c1.hora_asignado, c1.salario_gasto, c1.presupuesto, c2.utilizado,c1.fecha_creacion, c1.importe-c1.presupuesto as ganancia_proyeccion, c1.importe-c2.utilizado as ganancia_perdida from (SELECT p.id, u.id_cliente, pr.area, p.proyecto, p.importe, sum(c.tiempo_disponible) as hora_asignado, (((u.salario+3333.3333333333)/20)/8) as salario_gasto, (((u.salario+3333.3333333333)/20)/8)*sum(c.tiempo_disponible) as presupuesto, DATE_FORMAT((p.fecha_mac), '%d-%m-%Y') as fecha_creacion FROM inven_catalogo_proyectos as p LEFT JOIN inven_registro_costos As c ON p.id = c.id_proyecto and c.id_entorno= p.id_entorno JOIN inven_usuarios As u ON u.id = c.id_user_seleccion JOIN inven_catalogo_empresas As pr ON pr.id = u.id_cliente WHERE ( (p.id_entorno= 1) ) GROUP BY p.id, u.id_cliente) c1 JOIN (SELECT up.id_proyecto, sum(up.horas) as hora_asignado, u.id_cliente, (((u.salario+3333.3333333333)/20)/8) as salario_gasto, (((u.salario+3333.3333333333)/20)/8)*sum(up.horas) as utilizado FROM inven_registro_user_proy as up JOIN inven_usuarios As u ON u.id = up.id_usuario WHERE ( (up.id_entorno= 1) ) GROUP BY up.id_proyecto, u.id_cliente) as c2 ON c2.id_proyecto = c1.id

) aaa

where proyecto="Administración"

Administracion
	  Administracion
		margarita (2+4+4+20+5+10+15+10)= 70 * 83.333   = 5833.33
		maritza (2+10+15)=  27 * 83.333   =  2249.991
											=========
											8083.321
	  Direccion	
		Jorge 	     (15)=  15 * 83.333   =  1249.95
											--------------
											 9333.32




select * from 
(

SELECT  c1.id,c1.id_cliente,c1.area, c1.proyecto, c1.importe,c1.hora_asignado, c1.salario_gasto, c1.presupuesto, c2.utilizado,c1.fecha_creacion, c1.importe-c1.presupuesto as ganancia_proyeccion, c1.importe-c2.utilizado as ganancia_perdida from (SELECT p.id, u.id_cliente, pr.area, p.proyecto, p.importe, sum(c.tiempo_disponible) as hora_asignado, (((u.salario+3333.3333333333)/20)/8) as salario_gasto, (((u.salario+3333.3333333333)/20)/8)*sum(c.tiempo_disponible) as presupuesto, DATE_FORMAT((p.fecha_mac), '%d-%m-%Y') as fecha_creacion FROM inven_catalogo_proyectos as p LEFT JOIN inven_registro_costos As c ON p.id = c.id_proyecto and c.id_entorno= p.id_entorno JOIN inven_usuarios As u ON u.id = c.id_user_seleccion JOIN inven_catalogo_empresas As pr ON pr.id = u.id_cliente WHERE ( (p.id_entorno= 1) ) GROUP BY p.id, u.id_cliente) c1 JOIN (SELECT up.id_proyecto, sum(up.horas) as hora_asignado, u.id_cliente, (((u.salario+3333.3333333333)/20)/8) as salario_gasto, (((u.salario+3333.3333333333)/20)/8)*sum(up.horas) as utilizado FROM inven_registro_user_proy as up JOIN inven_usuarios As u ON u.id = up.id_usuario WHERE ( (up.id_entorno= 1) ) 
GROUP BY up.id_proyecto, u.id_cliente ) as c2 
ON c2.id_proyecto = c1.id 
group by c2.id_proyecto

) aaa

where proyecto="Impacto Textil Bajío"

where proyecto="Administración"



select * from 
(

SELECT up.id_proyecto, 
		sum(up.horas) as hora_asignado, 
		(((u.salario+3333.3333333333)/20)/8) as salario_gasto, 
		(((	u.salario+3333.3333333333)/20)/8)*sum(up.horas) as utilizado 
FROM inven_registro_user_proy as up 
left JOIN inven_usuarios As u ON u.id = up.id_usuario 
WHERE ( (up.id_entorno= 1) ) 
GROUP BY up.id_proyecto, up.id_usuario

) aaa


where id_proyecto=120



SELECT sum(horas)
FROM  `inven_registro_user_proy` where id_proyecto=120
