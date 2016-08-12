<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* hooks
*/
class Hooks
{
	
	public function call_hook($pos = '')
	{
		$_config = config_item();

		if( ! isset($_config) || ! isset($_config[$pos]))
		{
			return false;
		}

		if($_config[$pos.'_enable'] == false)
		{
			return false;
		}

		if( ! isset($_config) || ! isset($_config[$pos]))
		{
			return false;
		}

		require $_config[$pos]['filepath'] . $_config[$pos]['filename'];

		$hook_class = new $_config[$pos]['class']();

		return call_user_func_array(array($hook_class, $_config[$pos]['function']), $_config[$pos]['params']);

	}
}