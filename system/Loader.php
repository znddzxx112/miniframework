<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
* loader
*/
class Loader
{

	/**
	 * 加载 service
	 * @param  string $service [description]
	 * @return [type]          [description]
	 */
	public function service($service = '')
	{
		if( ! file_exists(BASEPATH.'service/'.$service.'.php')){
			show_error('service : ' . $service . ' not exists');
		}

		require SYSPATH . 'Service.php';

		$ci =& get_instance();
		$ci->$service = load_class($service ,BASEPATH.'/service/');
	}

	/**
	 * 加载 view
	 * @param  string $view [description]
	 * @return [type]       [description]
	 */
	public function view($view = '', $vars = array())
	{
		if( ! file_exists(BASEPATH.'view/'.$view.'.php')) {
			show_error('view : '. $view .' not exists');
		}

		foreach ($vars as $key => $value) {
			$$key = $value;
		}

		include(BASEPATH.'view/'.$view.'.php');
	}

}