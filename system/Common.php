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
	function &load_class($class = '', $folder = SYSPATH)
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
 * 获取配置项
 *
 *
 * @access	public
 * @param	type	name
 * @return	type	
 */
 
if (! function_exists('config_item'))
{
	function config_item($item = '')
	{
		static $_config = array();

		if( $item === '' && !empty($_config)){
			return $_config;
		}

		include(SYSPATH.'Config.php');

		$_config = $config;

		if( $item !== '' && isset($_config[$item])){
			return $_config[$item];
		}

		return $_config;
	}
}

/**
 * Write Log File
 *
 * Generally this function will be called using the global log_message() function
 *
 * @access	public
 * @param	string	the error level: 'error', 'debug' or 'info'
 * @param	string	the error message
 * @return	type	
 */
 
if (! function_exists('log_message'))
{
	function log_message($level, $msg)
	{
		$level = strtoupper($level);

		$filepath = BASEPATH.'logs/'.date('Y-m-d').'.php';
		$message = '';

		if ( ! file_exists($filepath))
		{
			$newfile = TRUE;
			// Only add protection to php files
			if ($this->_file_ext === 'php')
			{
				$message .= "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n\n";
			}
		}

		if ( ! $fp = @fopen($filepath, 'ab'))
		{
			return FALSE;
		}

		$date = date('Y-m-d H:i:s');

		$message .= $level.' - '.$date.' --> '.$msg."\n";

		flock($fp, LOCK_EX);

		for ($written = 0, $length = strlen($message); $written < $length; $written += $result)
		{
			if (($result = fwrite($fp, substr($message, $written))) === FALSE)
			{
				break;
			}
		}

		flock($fp, LOCK_UN);
		fclose($fp);

		if (isset($newfile) && $newfile === TRUE)
		{
			chmod($filepath, 0644);
		}

		return is_int($result);
	}
}


// --------------------------------------------------------------------

if ( ! function_exists('remove_invisible_characters'))
{
	/**
	 * Remove Invisible Characters
	 *
	 * This prevents sandwiching null characters
	 * between ascii characters, like Java\0script.
	 *
	 * @param	string
	 * @param	bool
	 * @return	string
	 */
	function remove_invisible_characters($str, $url_encoded = TRUE)
	{
		$non_displayables = array();

		// every control character except newline (dec 10),
		// carriage return (dec 13) and horizontal tab (dec 09)
		if ($url_encoded)
		{
			$non_displayables[] = '/%0[0-8bcef]/';	// url encoded 00-08, 11, 12, 14, 15
			$non_displayables[] = '/%1[0-9a-f]/';	// url encoded 16-31
		}

		$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

		do
		{
			$str = preg_replace($non_displayables, '', $str, -1, $count);
		}
		while ($count);

		return $str;
	}
}