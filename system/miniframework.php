<?php if(defined(BASEPATH)) exit('no script');

	/**
	 * 加载常用函数
	 */
	require SYSPATH.'Common.php';

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
	 * suport composer
	 */
	$support_composer = config_item('support_composer');
	if($support_composer === true)
	{
		file_exists(BASEPATH.'vendor/autoload.php') && require_once(BASEPATH.'vendor/autoload.php');
	}

	/**
	 * 加载路由类
	 */
	$RTR = load_class('Router');

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
	$BHK = load_class('Benchmark');
	$BHK->mark('pre_controller');

	/**
	 * 加载 系统扩展
	 */
	$EXT = load_class('Hooks');

	// 执行 pre_controller
	$EXT->call_hook('pre_controller');

	/**
	 * 实例化
	 */
	$app = $RTR->getApp();

	$class = $RTR->getClass();
	
	$method = $RTR->getMethod();

	$params = $RTR->getParams();

	include( BASEPATH . $app . config_item('controller_path') . $class . '.php');

	$class_instance = new $class();

	/**
	 * 执行方法
	 */
	call_user_func_array(array(&$class_instance, $method), $params);


	// 执行 post_controller
	$EXT->call_hook('post_controller');

	/**
	 * 性能基准
	 */
	$cost_time = $BHK->calc_time('pre_controller','post_controller');
	if($cost_time > 1000) {
		log_message('error', $class . $method . '-' . 'cost_time:' . $cost_time);
	}

