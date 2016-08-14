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

> database  driver - now only support mysql

```
	$this->load->database();
	$this->db->exec($code, $sql, $bind_param);
```
> hook

```
	config.php:
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
```

> library

```
	$this->load->library('Pagination');
	$this->Pagination->initialize($param);
```

#### library list

* pagination

* configure

* zip

* seccode

* validation

```
	$this->load->library('Validation');
	$valid_res = $this->Validation->initialize(array('left_div'=>' ','right_div'=>' '))
								->set_data(array('post_data'=>'123'))
								->set_rules('post_data', 'test_data', 'integer')
								->run();
	if($valid_res == false){ // valid error msg
		echo $this->Validation->get_error_message();
	}
```


#### todo list

* common library   eg :user_agent, cache, image, cart , encrytion, parse ...

* service  call run notify ... functions

* security input,output

* ...

join me :)


