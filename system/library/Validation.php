<?php 

class Validation
{
	protected $data = array();

	/**
	 * rules
	 * array(
	 * 		0=>[
	 *		 	'field'				=> '',
	 *			'label'				=> '',
	 *			'rules'				=> array()
	 *		],
	 *		...
	 *	);
	 * @var array
	 */
	protected $rules = array();

	/**
	 * array(
	 * 		0 => [
	 * 	    	'label'				=> '',
	 *		    'error'				=> ''
	 *		],
	 *		...
	 *	)
	 * @var array
	 */
	protected $error_data = array();

	protected $error_message = array(
								'integer' => 'must be integer',
								'required' => 'must be exist'
							);

	protected $left_div = "<p>";

	protected $right_div = "</p>";

	// ----------------------------------------------------------------------

	public function initialize($conf)
	{
		if( is_array($conf))
		{
			foreach ($conf as $k => $v) 
			{
				if(property_exists($this, $k))
				{
					$this->$k = $v;
				}
			}
		}
	}

	/**
	 * 设置 验证数据
	 * @param [type] $key [description]
	 * @param string $val [description]
	 */
	public function set_data($key, $val = '')
	{
		if( is_array($key))
		{
			foreach ($key as $k => $v) 
			{
				$this->data[$k] = $k;
			}
			
		}

		if( is_string($key))
		{
			$this->data[$key] = $val;
		}

		return $this;
	}

	/**
	 * 设置 验证字段规则
	 * @param [type] $field [description]
	 * @param string $label [description]
	 * @param string $rules [description]
	 */
	public function set_rules($field , $label = '', $rules = '')
	{
		if( is_array($rules))
		{
			$rules = $rules;
		}

		if( is_string($rules))
		{
			if( false !== strpos($rules, '|'))
			{
				$rules = explode('|', $rules);
			}
		}
		else
		{
			return false;
		}

		$this->rules[]['field'] = $field;
		$this->rules[]['label'] = $label;
		$this->rules[]['rules'] = $rules;

		return $this;
	}

	/**
	 * 执行 操作
	 * @return [type] [description]
	 */
	public function run()
	{
		if( count($this->data) == 0 OR count($this->rules) == 0)
		{
			return true;
		}

		foreach ($this->rules as $rule) 
		{
			if( !isset($this->data[$rule['field']]))
			{
				continue;
			}

			// Whether field follow rules ?
			$this->_exec($this->data[$rule['$field']], $rule['label'], $rule['rules']);
		}
	}

	/**
	 * 获取 错误信息
	 * @return [type] [description]
	 */
	public function get_error_message()
	{
		$error_msg = '';

		foreach ($this->error_data as $error) 
		{
			$error_msg .= $this->left_div. $error['label'] . $error['error'] . $this->right_div;
		}

		return $error_msg;
	}

	// ----------------------------------------------------------------------
	
	private function _exec($data, $label, $rules = array())
	{
		foreach ($rules as $rule) 
		{
			switch ($rule) 
			{
				case 'integer': // whether data is integer ?
						if( ! is_int($data) )
						{
							$this->_set_error($label, $this->error_message['integer']);
						}
					break;
				case 'required': // whether data is isset ?
						if( ! isset($data))
						{
							$this->_set_error($label, $this->error_message['required']);
						}
					break;
				default:
					# code...
					break;
			}
		}
	}

	// ----------------------------------------------------------------------

	private function _set_error($label, $error_msg)
	{
		$this->error_data[] = array('label' => $label, 'error'=> $error_msg);
	}

}