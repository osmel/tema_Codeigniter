<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'nucleo';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login']							= 'nucleo/login';
$route['validar_login']					= 'nucleo/validar_login';

$route['forgot']						= 'nucleo/forgot';
$route['session']						= 'nucleo/session';

$route['usuarios']						= 'nucleo/listado_usuarios';
$route['nuevo_usuario']                 = 'nucleo/nuevo_usuario';
$route['validar_nuevo_usuario']         = 'nucleo/validar_nuevo_usuario';
$route['eliminar_usuario/(:any)/(:any)']		= 'nucleo/eliminar_usuario/$1/$2';
$route['validando_eliminar_usuario']    = 'nucleo/validar_eliminar_usuario';
$route['actualizar_perfil']		         = 'nucleo/actualizar_perfil';
$route['editar_usuario/(:any)']			= 'nucleo/editar_usuario/$1';
$route['validacion_edicion_usuario']    = 'nucleo/validacion_edicion_usuario';
$route['salir']							= 'nucleo/logout';

$route['validar_recuperar_password']	= 'nucleo/validar_recuperar_password';

$route['ajaxAgents']	= 'nucleo/ajaxAgents';

$route['facebook']							= 'nucleo/facebook';


/////////////////////////////////Reportes///////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
$route['general']							= 'Reportes/listado_general';
$route['procesando_rep_general']			= 'Reportes/procesando_rep_general';
$route['cargar_dependencia_reportes']		= 'Reportes/cargar_dependencia_reportes';





/////////////////////////////////administracion///////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
$route['crear_proyecto']						= 'administracion/crear_proyecto';


$route['get_node']				= 'administracion/get_node';

//
$route['obtener_nodo']							= 'administracion/obtener_nodo';
$route['obtener_contenido']						= 'administracion/obtener_contenido';
$route['renombrar_nodo']						= 'administracion/renombrar_nodo';
$route['eliminar_nodo']							= 'administracion/eliminar_nodo';
$route['crear_nodo']							= 'administracion/crear_nodo';
$route['mover_nodo']							= 'administracion/mover_nodo';





//Entornos
$route['entornos']					     = 'administracion/listado_entornos';

$route['nuevo_entorno']                  = 'administracion/nuevo_entorno';
$route['crear_tabla/(:any)']			 = 'administracion/crear_tabla/$1';

$route['procesando_cat_entornos']        = 'administracion/procesando_cat_entornos';

$route['validar_nuevo_entorno']          = 'administracion/validar_nuevo_entorno';

$route['editar_entorno/(:any)']			 = 'administracion/editar_entorno/$1';
$route['validacion_edicion_entorno']     = 'administracion/validacion_edicion_entorno';

$route['eliminar_entorno/(:any)/(:any)'] = 'administracion/eliminar_entorno/$1/$2';
$route['validar_eliminar_entorno']    	 = 'administracion/validar_eliminar_entorno';
//Cambio de entorno
$route['cambio_entorno/(:any)']			 = 'nucleo/cambio_entorno/$1';



//Proyectos
$route['proyectos']					     = 'administracion/listado_proyectos';

$route['nuevo_proyecto']                  = 'administracion/nuevo_proyecto';
$route['crear_tabla/(:any)']			 = 'administracion/crear_tabla/$1';

$route['procesando_cat_proyectos']        = 'administracion/procesando_cat_proyectos';

$route['validar_nuevo_proyecto']          = 'administracion/validar_nuevo_proyecto';

$route['editar_proyecto/(:any)']			 = 'administracion/editar_proyecto/$1';
$route['validacion_edicion_proyecto']     = 'administracion/validacion_edicion_proyecto';

$route['eliminar_proyecto/(:any)/(:any)'] = 'administracion/eliminar_proyecto/$1/$2';
$route['validar_eliminar_proyecto']    	 = 'administracion/validar_eliminar_proyecto';


$route['validacion_edicion_nivel']     = 'administracion/validacion_edicion_nivel';


//buscador
$route['buscador']						     = 'administracion/buscador';
$route['listado_usuarios_json']			     = 'administracion/listado_usuarios_json';






//registro usuario
$route['validar_registro_usuario']    	 = 'administracion/validar_registro_usuario';
$route['ajax_user_proy_json']    	 = 'administracion/ajax_user_proy_json';
$route['listado_usuarios_niveles']			     = 'administracion/listado_usuarios_niveles';


//niveles
$route['listado_niveles']    	 			= 'administracion/listado_niveles';
$route['listado_fechas']    	 			= 'administracion/listado_fechas';




/////////////////Catalogos/////////////////

//Cargos
$route['cargos']					     = 'catalogos/listado_cargos';
$route['procesando_cat_cargos']        = 'catalogos/procesando_cat_cargos';

$route['nuevo_cargo']                  = 'catalogos/nuevo_cargo';
$route['validar_nuevo_cargo']          = 'catalogos/validar_nuevo_cargo';

$route['editar_cargo/(:any)']			 = 'catalogos/editar_cargo/$1';
$route['validacion_edicion_cargo']     = 'catalogos/validacion_edicion_cargo';

$route['eliminar_cargo/(:any)/(:any)'] = 'catalogos/eliminar_cargo/$1/$2';
$route['validar_eliminar_cargo']    	 = 'catalogos/validar_eliminar_cargo';



//areas
$route['areas']					     = 'catalogos/listado_areas';
$route['procesando_cat_areas']        = 'catalogos/procesando_cat_areas';

$route['nuevo_area']                  = 'catalogos/nuevo_area';
$route['validar_nuevo_area']          = 'catalogos/validar_nuevo_area';

$route['editar_area/(:any)']			 = 'catalogos/editar_area/$1';
$route['validacion_edicion_area']     = 'catalogos/validacion_edicion_area';

$route['eliminar_area/(:any)/(:any)'] = 'catalogos/eliminar_area/$1/$2';
$route['validar_eliminar_area']    	 = 'catalogos/validar_eliminar_area';




//perfiles
$route['perfiles']					     = 'catalogos/listado_perfiles';
$route['procesando_cat_perfiles']        = 'catalogos/procesando_cat_perfiles';

$route['nuevo_perfil']                  = 'catalogos/nuevo_perfil';
$route['validar_nuevo_perfil']          = 'catalogos/validar_nuevo_perfil';

$route['editar_perfil/(:any)']			 = 'catalogos/editar_perfil/$1';
$route['validacion_edicion_perfil']     = 'catalogos/validacion_edicion_perfil';

$route['eliminar_perfil/(:any)/(:any)'] = 'catalogos/eliminar_perfil/$1/$2';
$route['validar_eliminar_perfil']    	 = 'catalogos/validar_eliminar_perfil';



//configuraciones
$route['configuraciones']					     = 'catalogos/listado_configuraciones';
$route['procesando_cat_configuraciones']        = 'catalogos/procesando_cat_configuraciones';

$route['nuevo_configuracion']                  = 'catalogos/nuevo_configuracion';
$route['validar_nuevo_configuracion']          = 'catalogos/validar_nuevo_configuracion';

$route['editar_configuracion/(:any)']			 = 'catalogos/editar_configuracion/$1';
$route['validacion_edicion_configuracion']     = 'catalogos/validacion_edicion_configuracion';

$route['eliminar_configuracion/(:any)/(:any)'] = 'catalogos/eliminar_configuracion/$1/$2';
$route['validar_eliminar_configuracion']    	 = 'catalogos/validar_eliminar_configuracion';



