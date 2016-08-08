<?php if(defined(BASEPATH)) exit('no script');

/**
 * 类加载
 *
 * Function description
 *
 * @access	public
 * @param	type	name
 * @return	type	
 */
 
if (! function_exists('load_class'))
{
	function load_class($class = '', $folder = SYSPATH)
	{
		static $classes;

		if(isset($classes[$class])){
			return $classes[$class];
		}

		if( ! file_exists($folder.$class.'.php')){
			exit($class . ' not exists');
		}

		require $folder.$class.'.php';

		is_loaded($class);

		$class = ucfirst($class);
		$classes[$class] = new $class();

		return $classes[$class];
	}
}


/**
 * Function Name
 *
 * Function description
 *
 * @access	public
 * @param	type	name
 * @return	type	
 */
 
if (! function_exists('_error_handler'))
{
	function _error_handler($errno, $errstr, $errfile, $errline)
	{
		if (!(error_reporting() & $errno)) {
	        // This error code is not included in error_reporting
	        return;
	    }

	    switch ($errno) {
	    case E_USER_ERROR:
	        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
	        echo "  Fatal error on line $errline in file $errfile";
	        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
	        echo "Aborting...<br />\n";
	        exit(1);
	        break;

	    case E_USER_WARNING:
	        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
	        break;

	    case E_USER_NOTICE:
	        echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
	        break;

	    default:
	        echo "Unknown error type: [$errno] $errstr<br />\n";
	        break;
	    }

	    /* Don't execute PHP internal error handler */
	    return true;
	}
}

/**
 * 错误显示
 *
 * @access	public
 * @param	type	name
 * @return	type	
 */
 
if (! function_exists('show_error'))
{
	function show_error($msg = '')
	{
		header("Content-Type:text-html;charset=utf-8");
		exit($msg);
	}
}

/**
 * Function Name
 *
 * Function description
 *
 * @access	public
 * @param	type	name
 * @return	type	
 */
 
if (! function_exists('is_loaded'))
{
	function &is_loaded($class = '')
	{
		static $_is_loaded = array();

		if ($class !== '')
		{
			$_is_loaded[strtolower($class)] = $class;
		}

		return $_is_loaded;
	}
}

/**
 * 获取配置
 *
 * Function description
 *
 * @access	public
 * @param	type	name
 * @return	type	
 */
 
if (! function_exists('config_item'))
{
	function config_item($item = '')
	{
		include(SYSPATH.'Config.php');

		if( ! isset($config)){
			return array();
		}

		if( $item !== '' && isset($config[$item])){
			return $config[$item];
		} else {
			return '';
		}

		return $config;
		
	}
}