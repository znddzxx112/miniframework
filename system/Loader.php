<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
* loader
*/
class Loader
{

	public function __construct()
	{
		$this->_autoload();
	}

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
		if( ! file_exists(APPPATH.'/view/'.$view.'.php')) {
			show_error('view : '. APPPATH.'/view/'.$view .' not exists');
		}

		foreach ($vars as $key => $value) {
			$$key = $value;
		}

		include(APPPATH.'/view/'.$view.'.php');
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

	/**
	 * 加载 library
	 * @param  string $library [description]
	 * @return [type]          [description]
	 */
	public function library($library = '')
	{
		$library = ucfirst($library);

		if( ! file_exists(SYSPATH . 'library' . '/' . $library . '.php')){
			show_error("library not exist");
		}
		$ci =& get_instance();
		$ci->$library = load_class($library, SYSPATH . 'library' . '/');
	}

	/**
	 * 加载 cache
	 * @param  [type] $cache [description]
	 * @return [type]        [description]
	 */
	public function cache($pre = 'cache')
	{
		$_config = config_item();

		if(! isset($_config[$pre]) )
		{
			show_error("cache config fail");
		}

		require SYSPATH . 'Cache.php';

		$driver = $_config[$pre]['driver'] . '_driver.php';

		$ci =& get_instance();
		$ci->cache = load_class($driver, SYSPATH.'/cache_driver/');

		$ci->cache->initialize(array($_config[$pre]['host'], $_config[$pre]['port']));
	}

	// -------------------------------------------------------------------
	

	private function _autoload()
	{
		$autoload_class = config_item('autoload_class');

		$ci =& get_instance();

		foreach ($autoload_class as $class) 
		{
			require SYSPATH . ucfirst($class) . '.php';
			$ci->$class = load_class($class);
		}
	}

}