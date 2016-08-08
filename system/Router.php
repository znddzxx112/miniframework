<?php if(defined(BASEPATH)) exit('no scripts');

/**
* Route
*/
class Router
{

	private $class = '';

	private $method = 'index';

	function __construct()
	{
		$this->_fetch_class_method();
	}

	public function getClass()
	{
		return ucfirst($this->class);
	}

	public function getMethod()
	{
		return $this->method;
	}

	private function _fetch_class_method()
	{
		$request_info = $this->_parse_request_uri();
		if(!empty($request_info)){
			$this->class = $request_info['class'];
			$this->method = $request_info['method'];
		}
	}

	private function _parse_request_uri()
	{
		if ( ! isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']))
		{
			return '';
		}

		// http://dummy/index.php/hello/word?foo=bar&foo1=bar1
		// array (size=4)
		// 'scheme' => string 'http' (length=4)
		// 'host' => string 'dummy' (length=5)
		// 'path' => string '/basecode/index.php/hello/word' (length=30)
		// 'query' => string 'foo=bar&foo1=bar1' (length=17)
		$uri = parse_url('http://dummy'.$_SERVER['REQUEST_URI']);
		$query = isset($uri['query']) ? $uri['query'] : '';
		$uri = isset($uri['path']) ? $uri['path'] : '';

		//fetch class method
		$uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
		$uri = trim($uri,'/');

		if($uri === '')
		{
			$class = 'index';
			$method = 'index';
		}
		elseif(strpos($uri, '/') === false)
		{
			$class = strtolower($uri);
			$method = 'index';
		}
		else
		{
			$uri_arr = explode('/', $uri);
			$class = strtolower($uri_arr[0]);
			$method = strtolower($uri_arr[1]);
		}

		// uri params
		parse_str($query, $_GET);

		return array(
				'class' => $class,
				'method' => $method
			);
	}

}