<?php 

/**
* redis
*/
class Redis_driver extends Cache
{

	protected $host = NULL;

	protected $port = NULL;

	private $_redis;

	public function __construct()
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

		if( isset($this->host) AND isset($this->port))
		{
			$this->_redis = new \Redis();
			$this->_redis->connect($this->host, $this->port);
		}
	}


	public function save($key,$val,$ttl=3600)
	{
		return $this->_redis->set($key,$ttl,$val);
	}

	public function get($key)
	{
		return $this->_redis->get($key);
	}

	public function exists($key)
	{
		return $this->_redis->exists($key);
	}

	// -------------------------------------------------------

	public function rpush($key,$value)
	{
		return $this->_redis->rpush($key,$value);
	}

	public function lpop($key)
	{
		return $this->_redis->lpop($key);
	}

	public function lrange($key,$offset,$limit)
	{
		return $this->_redis->lrange($key,$offset,$limit);
	}


}