<?php if(defined(BASEPATH)) exit('no script');

/**
* hello class
* http://127.0.0.1/basecode/index.php/hello/world?foo=bar&foo1=bar1
*/
class Hello extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function world()
	{

		$this->load->service('Tool_service');
		$bar = $this->Tool_service->hello();
		
		$this->load->view('home', array('foo' => $bar));
	}
}