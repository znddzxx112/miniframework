<?php if(defined(BASEPATH)) exit('no script');

#release
$config['version'] = 'v0.0.1';

#controller_path
$config['controller_path'] = '/controller/';

#composer
$config['support_composer'] = false;#支持composer


#mysql
$config['default']['drive'] = 'mysqli';
$config['default']['host'] = '127.0.0.1';
$config['default']['username'] = "root";
$config['default']['passwd'] = "";
$config['default']['dbname'] = "caocms";
$config['default']['port'] = "3306";

#hook 
$config['pre_controller_enable'] = false;
$config['pre_controller'] = array(
							'class'    => 'BaseHook',
						    'function' => 'hello',
						    'filename' => 'BaseHook.php',
						    'filepath' => APPPATH.'/hooks/',
						    'params'   => array('beer', 'wine', 'snacks')
						);

$config['post_controller_enable'] = false;
$config['post_controller'] =  array(
							'class'    => 'BaseHook',
						    'function' => 'hello',
						    'filename' => 'BaseHook.php',
						    'filepath' => APPPATH.'/hooks/',
						    'params'   => array('beer', 'wine', 'snacks')
						);

# autoload
//$config['autoload_class'] = array('Input');
$config['autoload_class'] = array();

#cache
$config['cache']['driver'] = 'redis';
$config['cache']['host'] = '127.0.0.1';
$config['cache']['port'] = "6379";
#cache file
$config['cache']['root_dir'] = '';