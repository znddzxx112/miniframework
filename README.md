# miniframework

Service-oriented php framework

#### usage

> load view

```
	$this->load->view('home', array('foo' => 'bar'));
```

> load services

```
	$this->load->service('Tool_service');
	$this->Tool_service->hello();
```

> load model

```
	$this->load->model('User_model');
	$this->User_model->get_user();
```

> write log

```
	log_message('error', 'something');
```

> support composer

```
	config.php
	$config['support_composer'] = true; # true:支持composer false:不支持composer

	composer.json
	requeire packgist

	common command:
	composer intall
	composer install --dev # 开发环境
	composer update

```

> support Benchmark

```
	$BHK =& load_class('Benchmark');
	$BHK->mark('pre_controller');
	$cost_time = $BHK->calc_time('pre_controller','post_controller');
	if($cost_time > 1000) { // 超时执行写入info文件
		log_message('error', $class . $method . '-' . 'cost_time:' . $cost_time);
	}
```

> phpunit

```
	composer install --dev
```

#### todo list

* database driver

* hook

* common library   eg : page , image ...

* cache

* security 

* ...

i need you 
