<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* controller
*/
class Controller
{
	private static $instance;

	public function __construct()
	{
		self::$instance =& $this;

		$this->load = load_class('Loader');
	}

	public static function &get_instance()
	{
		return self::$instance;
	}

}