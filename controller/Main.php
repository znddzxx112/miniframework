<?php if(defined(BASEPATH)) exit('no script');

/**
* hello class
* http://127.0.0.1/basecode/index.php/main/index?foo=bar&foo1=bar1
*/
class Main extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		$this->load->service('Tool_service');
		$bar = $this->Tool_service->hello();

		$this->load->view('home', array('foo' => $bar));
	}
}