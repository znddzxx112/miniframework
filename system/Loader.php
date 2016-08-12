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
	 * 加载 model
	 * @param  [type] $model [description]
	 * @return [type]        [description]
	 */
	public function model($model = '')
	{
		if( ! file_exists(BASEPATH.'model/'.$model.'.php')){
			show_error('model : ' . $model . ' not exists');
		}

		require SYSPATH . 'Model.php';

		$ci =& get_instance();
		$ci->$model =& load_class($model ,BASEPATH.'/model/');
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

	/**
	 * 加载 database
	 * @return [type] [description]
	 */
	public function database($pre = 'default')
	{
		$_config = config_item();

		if(! isset($_config[$pre]) )
		{
			show_error("database config fail");
		}

		require SYSPATH . 'Db.php';

		$ci =& get_instance();
		$ci->db = load_class('Mysqli_drive' ,SYSPATH.'/database/');

		$ci->db->init($_config[$pre]['host'], $_config[$pre]['username'], $_config[$pre]['passwd'], $_config[$pre]['dbname'], $_config[$pre]['port']);
	}

}