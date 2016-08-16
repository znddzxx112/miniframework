<?php 

/**
* 缓存类
*/
abstract class Cache
{

	abstract public function initialize($conf = array());

	abstract public function save($key, $val, $ttl = 3600);

	abstract public function get($key);
}