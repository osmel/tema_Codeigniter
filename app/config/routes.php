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


/////////////////////////////////catalogos///////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
$route['crear_proyecto']						= 'catalogos/crear_proyecto';
$route['crear_nodo']							= 'catalogos/crear_nodo';
$route['obtener_nodo']							= 'catalogos/obtener_nodo';
//$route['get_node/(:any)/(:any)']				= 'catalogos/get_node/$1/$2';

$route['get_node']				= 'catalogos/get_node';




///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////

// $route['historicoaccesos']                 = 'nucleo/historicoaccesos';  //falta por actualizar 
/*
$route['establecer_modulo']				= 'nucleo/establecer_modulo';

/////////////////////////////////////////HOME///////////////////
$route['procesando_home']    		= 'nucleo/procesando_home';
$route['procesando_inicio']    		= 'nucleo/procesando_inicio';
$route['detalles_grupo/(:any)/(:any)']   = 'nucleo/detalles_grupo/$1/$2';
$route['marcando_apartado']    		= 'nucleo/marcando_apartado';
$route['procesar_apartados']    		    = 'nucleo/procesar_apartados';
$route['tabla_apartado_vendedores']    		= 'nucleo/tabla_apartado_vendedores';
$route['eliminar_apartado_vendedores/(:any)/(:any)'] = 'nucleo/eliminar_apartado_vendedores/$1/$2';
$route['validar_eliminar_apartado_vendedores']    			= 'nucleo/validar_eliminar_apartado_vendedores';
$route['apartado_definitivo']    		= 'nucleo/apartado_definitivo';
$route['procesando_producto_color']    		= 'nucleo/procesando_producto_color';
$route['procesando_producto_color2']    		= 'nucleo/procesando_producto_color2';
$route['imprimir_reportes_apartado']    		= 'nucleo/imprimir_reportes_apartado';
$route['detalles_imagen/(:any)/(:any)']    		= 'nucleo/detalles_imagen/$1/$2';

*/