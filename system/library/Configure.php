<?php 

class Configure
{
	protected $config = array();

	protected $is_loaded = array();

	/**
	 * 
	 */
	public function load($file, $space = '')
	{
		if( in_array($file, $this->is_loaded))
		{
			return true;
		}

		if( ! file_exists($file))
		{
			return false;
		}

		include($file);

		if( ! isset($config) OR ! is_array($config))
		{
			return false;
		}

		if( $space != '')
		{
			$this->config[$space] = isset($this->config[$space]) ? 
							array_merge($this->config[$space], $config) : $config;
		}
		else
		{
			$this->config = array_merge($this->config, $config);
		}

		$this->is_loaded[] = $file;

		return true;
	}

	public function item($item, $space = '')
	{
		if($space != '')
		{
			return isset($this->config[$space][$item]) ? 
						$this->config[$space][$item] : NULL;
		}
		else
		{
			return isset($this->config[$item]) ?
						$this->config[$item] : NULL;
		}
	}

	public function set_item($item, $val, $space = '')
	{
		if($space != '')
		{
			$this->config[$space][$item] = $val;
		}
		else
		{
			$this->config[$item] = $val;
		}
	}

}