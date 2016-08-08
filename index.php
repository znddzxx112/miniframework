<?php 
/**
 * mini框架
 */
// if( ! preg_match("/^127./", $_SERVER['REMOTE_ADDR'])) exit('system update...');

@date_default_timezone_set("Asia/Shanghai");

/**
 * 环境定义
 */
define('ENV', 'development');

switch (ENV) {
case 'development':
	error_reporting(E_ALL);
	break;
case 'testing':
	error_reporting(E_ALL & ~E_NOTICE & ~E_ERROR & ~E_WARNING & ~E_PARSE);
	break;
case 'production':
	error_reporting(-1);
	break;
}

/**
 * 常量定义
 */
define('BASEPATH' ,__dir__.'/');

define('SYSPATH' ,__dir__.'/system/');

require SYSPATH.'/miniframework.php';

