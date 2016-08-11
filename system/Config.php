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