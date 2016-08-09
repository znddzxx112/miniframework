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
	$config['support_composer'] = true; # true:支持composer false:不支持composer
```

#### todo list

* database driver

* Benchmark

* phpunit test ( composer )

* hook

* common library   eg : page , image ...

* cache

* security 

* ...

i need you 
