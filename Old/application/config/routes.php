<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Pages/view';


$route['Messages/sendMessage'] = 'Messages/sendMessage';
$route['Home'] = 'Pages/view';
$route['users/online'] = 'users/online';
$route['404_override'] = '';
$route['users/acceptrequest/(:any)'] = 'users/acceptrequest/$1';
$route['posts/like2'] = 'posts/like2';
$route['posts/like/(:any)'] = 'posts/like/$1';
$route['users/viewprofile/(:any)'] = 'users/viewprofile/$1';
$route['users/editprofile/(:any)'] = 'users/editprofile/$1';
$route['posts/delete/(:any)'] = 'posts/deletePost/$1';
$route['users/edit/(:any)'] = 'users/editaccount/$1';
$route['Message/(:any)'] = 'Messages/getMessages/$1';
$route['Messages/(:any)'] = 'Messages/getMessagesadmin/$1';
$route['translate_uri_dashes'] = FALSE;
