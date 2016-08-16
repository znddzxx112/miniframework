<?php 


/**
 * 文件缓存
 */
class File_driver
{
	/**
	 * 缓存根目录
	 * @var string
	 */
	public $root_dir = '';

	function __construct()
	{

	}

	public function initialize($conf = array())
	{
		if ( is_array($conf)) 
		{
			foreach ($conf as $key => $val) 
			{
				if(property_exists($this, $key))
				{
					$this->$key = $val;
				}
			}
		}
	}

	public function save($key, $val, $ttl = 3600)
	{
		$dir = $this->root_dir;
		if(!is_dir($dir))
		{
			mkdir($dir,0764,true);
		}
		$path = rtrim($dir,'/').'/'.$key;
		return file_put_contents($path, $val);
	}

	public function get($key)
	{
		$path = rtrim($this->root_dir,'/').'/'.$key;
		if(file_exists($path) && filemtime($path) + 3600 >= time()){
			return file_get_contents($path);
		}else{
			return false;
		}
	}


}


