<?php 

/**
* 	Input
*/
class Input
{
	
	function __construct()
	{
		
	}

	public function post($index = '')
	{
		return isset($_POST[$index]) ? $_POST[$index] : NULL;
	}
}