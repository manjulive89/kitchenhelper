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
$route['default_controller'] = 'dashboard_frontend';
$route['sheet'] = 'dashboard_frontend/sheet';
$route['messages'] = 'dashboard_frontend/messages';
$route['mealplan'] = 'dashboard_frontend/mealplan';
$route['backend'] = 'dashboard_backend';
$route['backend/archive'] = 'dashboard_backend/archive';
$route['backend/user/logout'] = 'dashboard_backend/logout';
$route['backend/signoffsheet'] = 'signoffsheet_backend';
$route['backend/user/groups'] = 'user/groups/backend';
$route['groupmanagment'] = 'user/groups/frontend';
$route['backend/messages'] = 'messages_backend';
$route['backend/messages/pdf/(:num)'] = 'messages_backend/pdf/$1';
$route['backend/notifications'] = 'notifications';
$route['backend/user'] = 'user';
$route['backend/settings'] = 'settings';
$route['backend/test/(:any)'] = 'cronjob/dojob/$1';
$route['backend/mealplanner'] = 'mealplanner';
$route['backend/messages/show/(:num)'] = 'messages_backend/show/$1';
$route['backend/export/sheet/pdf/week/sheet_(:num).pdf'] = 'export/weekpdf/$1';
$route['backend/export/sheet/pdf/month/sheet_(:num).pdf'] = 'export/monthpdf/$1';
$route['backend/export/sheet/excel/month/sheet_(:num).xls'] = 'export/monthexcel/$1';

/**
 * #############################################################
 * 							JSON API
 * #############################################################
 **/
//backend:
$route['backend/api/request/settings']['GET'] = 'ajax/action/settings/$1';
$route['backend/api/(:any)/(:any)']['GET'] = 'ajax/action/$1/$2';
$route['backend/api/(:any)/(:any)/(:num)']['GET'] = 'ajax/action/$1/$2/$3';
$route['backend/api/(:any)/(:any)']['POST'] = 'ajax/action/$1/$2';
//frontend
$route['frontend/api/request/settings']['GET'] = 'ajax/action/settings/$1';
$route['frontend/api/request/(:any)']['GET'] = 'ajax/action/front_request/$1';
$route['frontend/api/request/(:any)/(:num)']['GET'] = 'ajax/action/front_request/$2/$3';
$route['frontend/api/update/(:any)']['POST'] = 'ajax/action/update_frontend/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
