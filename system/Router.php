<?php if(defined(BASEPATH)) exit('no scripts');

/**
* Route
*/
class Router
{

    private $app = 'mainapp';

	private $class  = 'Main';

	private $method = 'index';

	private $params = array();

	function __construct()
	{
		$this->_fetch_class_method();
	}

	public function getApp()
    {
        return lcfirst($this->app);
    }

	public function getClass()
	{
		return ucfirst($this->class);
	}

	public function getMethod()
	{
		return ucfirst($this->method);
	}

	public function getParams()
	{
		return $this->params;
	}

	private function _fetch_class_method()
	{
		$request_info = $this->_parse_request_uri();
		if(!empty($request_info)){
		    $this->app = $request_info['app'];
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
		// uri => array (size=4)
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
		    $app = $this->app;
			$class  = $this->class;
			$method = $this->method;
		}
		elseif(strpos($uri, '/') === false)
		{
		    $app = strtolower($uri);
			$class = $this->class;
			$method = $this->method;
		}
		else
		{
			$uri_arr = explode('/', $uri);
			$app = strtolower($uri_arr[0]);
            $class = strtolower($uri_arr[1]);
            $method = strtolower($uri_arr[2]);
		}

		// uri params
		parse_str($query, $_GET);

		return array(
		        'app' => $app,
				'class' => $class,
				'method' => $method,
			);
	}

}