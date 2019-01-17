<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class BaseHook
{
	
	public function hello($param1, $param2, $param3)
	{
		echo $param1;
		echo "\n<hr>";
		echo $param2;
		echo "\n<hr>";
		echo $param3;
		echo "\n<hr>";
	}
}