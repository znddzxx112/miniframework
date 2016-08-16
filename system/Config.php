<?php if(defined(BASEPATH)) exit('no script');

#release
$config['version'] = 'v0.0.1';

#index class
$config['main_class'] = 'Main';

#index method
$config['main_method'] = 'index';

#controller_path
$config['controller_path'] = BASEPATH.'controller/';

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
							'class'    => 'Base_hook',
						    'function' => 'hello',
						    'filename' => 'Base_hook.php',
						    'filepath' => BASEPATH.'hooks/',
						    'params'   => array('beer', 'wine', 'snacks')
						);

$config['post_controller_enable'] = false;
$config['post_controller'] =  array(
							'class'    => 'Base_hook',
						    'function' => 'hello',
						    'filename' => 'Base_hook.php',
						    'filepath' => BASEPATH.'hooks/',
						    'params'   => array('beer', 'wine', 'snacks')
						);

# autoload
$config['autoload_class'] = array('input');

#cache
$config['cache']['driver'] = 'redis';
$config['cache']['host'] = '127.0.0.1';
$config['cache']['port'] = "6379";