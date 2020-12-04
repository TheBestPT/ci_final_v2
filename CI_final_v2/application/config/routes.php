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
$route['default_controller'] = 'home';
$route['EnfermeiroController'] = 'EnfermeiroController';
$route['MedicoController'] = 'MedicoController';
$route['UtenteController'] = 'UtenteController';
$route['ContatosController'] = 'ContatosController';
$route['UsersController'] = 'UsersController';
$route['UsersController/(:num)'] = 'UsersController';
$route['ConsultaController'] = 'ConsultaController';
$route['ProdutoController']  ='ProdutoController';
$route['ProdutoController/(:num)'] = $route['ProdutoController'];
$route['ProdutoController/editar/(:num)'] = $route['ProdutoController'].'/editar/$1';
$route['ProdutoController/del/(:num)'] = $route['ProdutoController'].'/del/$1';
$route['ConsultaController/muda/(:num)'] = $route['ConsultaController'].'/muda/$1';
$route['ConsultaController/guardarEnf/(:num)/(:num)'] = $route['ConsultaController'].'/guardarEnf/$1/$2';
$route['ConsultaController/remEnf/(:num)'] = $route['ConsultaController'].'/remEnf/$1';
$route['ConsultaController/delRec/(:num)'] = $route['ConsultaController'].'/delRec/$1';
$route['ReceitaController'] = 'ReceitaController';
$route['ReceitaController/(:num)'] = 'ReceitaController';
$route['ReceitaController/(:num)/del/(:num)'] = $route['ReceitaController'].'del/$2';
$route['ConsultaController/receita/(:num)'] = $route['ConsultaController'].'/receita/$1';
$route['ConsultaController/(:num)'] = 'ConsultaController';
$route['ConsultaController/details/(:num)'] = $route['ConsultaController'].'/details/$1';
$route['ConsultaController/editar/(:num)'] = $route['ConsultaController'].'/editar/$1';
$route['ConsultaController/del/(:num)'] = $route['ConsultaController'].'/del/$1';
$route['MedicoController/details/(:num)'] = $route['MedicoController'].'/details/$1';
$route['EnfermeiroController/details/(:num)'] = $route['EnfermeiroController'].'/details/$1';
$route['UsersController/editar/(:num)'] = $route['UsersController'].'/editar/$1';
$route['UsersController/del/(:num)'] = $route['UsersController'].'/del/$1';
$route['ContatosController/del/(:num)'] = $route['ContatosController'].'/del/$1';
$route['UtenteController/editar/(:num)'] = $route['UtenteController'].'/editar/$1';
$route['UtenteController/del/(:num)'] = $route['UtenteController'].'/del/$1';
$route['UtenteController/guardar'] = $route['UtenteController'].'/guardar';
$route['MedicoController/editar/(:num)'] = $route['MedicoController'].'/editar/$1';
$route['EnfermeiroController/editar/(:num)'] = $route['EnfermeiroController'].'/editar/$1';
$route['EnfermeiroController/del/(:num)'] = $route['EnfermeiroController'].'/del/$1';
$route['EnfermeiroController/(:num)'] = $route['EnfermeiroController'];
$route['UtenteController/(:num)'] = $route['UtenteController'];
$route['MedicoController/(:num)'] = $route['MedicoController'];
$route['EnfermeiroController/guardar'] = $route['EnfermeiroController'].'/guardar';
$route['Login'] = 'login/login';
$route['Logout'] = 'login/logout';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
