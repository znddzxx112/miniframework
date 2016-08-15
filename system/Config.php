<?php if(defined(BASEPATH)) exit('no script');

$config['version'] = 'v0.0.1';

$config['main_class'] = 'Main';

$config['main_method'] = 'index';

$config['controller_path'] = BASEPATH.'controller/';

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