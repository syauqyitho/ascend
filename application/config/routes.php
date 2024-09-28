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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

# Reservation
$route['reservation'] = 'reservation';
$route['reservation/create'] = 'reservation/create';
$route['reservation/store'] = 'reservation/store';
$route['reservation/show/(:num)'] = 'reservation/show/$1';
$route['reservation/update/(:num)'] = 'reservation/update/$1';
$route['reservation/delete/(:num)'] = 'reservation/delete/$1';

# Room
$route['room'] = 'room';
$route['room/create'] = 'room/create';
$route['room/store'] = 'room/store';
$route['room/show/(:num)'] = 'room/show/$1';
$route['room/update/(:num)'] = 'room/update/$1';

# History
$route['history'] = 'history';
$route['history/date'] = 'history/date';

# Report
$route['report'] = 'report';
$route['report/create'] = 'report/create';
$route['report/store'] = 'report/store';
$route['report/show/(:num)'] = 'repot/show/$1';
$route['report/update/(:num)'] = 'report/update/$1';
$route['report/delete/(:num)'] = 'report/delete/$1';
$route['report/delete/(:num)'] = 'repot/delete/$1';
