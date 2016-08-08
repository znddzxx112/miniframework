<?php if(defined(BASEPATH)) exit('no script');

	/**
	 * 加载常用函数
	 */
	require SYSPATH.'common.php';

	/**
	 * 错误处理函数
	 */
	switch (ENV) {
		case 'development':
			
			break;
		
		default:
			set_error_handler("_error_handler");
			break;
	}

	/**
	 * 加载路由类
	 */
	$RTR = load_class('router');

	/**
	 * 单例函数
	 */
	require SYSPATH . 'Controller.php';
	function &get_instance()
	{
		return Controller::get_instance();
	}

	/**
	 * 加载性能类
	 */

	/**
	 * 实例化
	 */
	$class = $RTR->getClass();
	
	$method = $RTR->getMethod();

	$params = $RTR->getParams();

	include( config_item('controller_path') . $class . '.php');

	$class_instance = new $class();

	/**
	 * 执行方法
	 */
	call_user_func_array(array(&$class_instance, $method), $params);




