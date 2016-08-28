<?php
/**
 * [$ACCESS_WITHOUT_LOGGIN description]
 * @var [type]
 */
$ACCESS_WITHOUT_LOGGIN = [
	'checklogin' => [
		'controller' => 'LoginController',
		'method' => 'login',
		'view' => 'CheckLogin',
	],
	'register_view' => [
		'controller' => 'LoginController',
		'method' => 'register_view',
		'view' => 'register.html',
	],
	'register' => [
		'controller' => 'LoginController',
		'method' => 'register',
		'view' => '',
	],
];

/**
 * [$ACCESS_WITHOUT_LOGGIN description]
 * @var [type]
 */
$ROUTE_MODULES = [
	'dashboard' => [
		'controller' => 'DashboardController',
		'method' => 'index',
		'view' => 'asdfasd',
	],
	'user' => [
		'controller' => 'User',
		'method' => 'index',
		'view' => 'index.html',
	],
	'logout' => [
		'controller' => 'LoginController',
		'method' => 'logout',
		'view' => 'login.html'
	],
	'connection_ssh' => [
		'controller' => 'MachineController',
		'method' => 'index',
		'view' => 'machine/index.html'
	],
	'logout' => [
		'controller' => 'LoginController',
		'method' => 'logout',
		'view' => 'login.html'
	],
	'logout' => [
		'controller' => 'LoginController',
		'method' => 'logout',
		'view' => 'login.html'
	],
];

/**
 * [$LOGIN description]
 * @var [type]
 */
$LOGIN =[
	  'controller' => 'LoginController',
	  'method' => 'index',
	  'view' => 'login.html',
	];

/**
 * Keeps the database configuration at a session avoiding to open this file more than once
 */
$_SESSION['LIB_XX_ROUTE_MODULES'] =  $ROUTE_MODULES;
$_SESSION['LIB_XX_ACCESS_LOGGIN'] =  $LOGIN;
$_SESSION['LIB_XX_ACCESS_WITHOUT_LOGGIN'] = $ACCESS_WITHOUT_LOGGIN;