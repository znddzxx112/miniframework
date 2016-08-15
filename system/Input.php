<?php 

/**
* 	Input
*/
class Input
{
	protected $Security;

	function __construct()
	{
		$ci =& get_instance();
		$ci->load->library('Security');
		$this->Security = $ci->Security;
	}

	public function post($index = '')
	{
		if( $index == '')
		{
			return NULL;
		}

		if( ! empty($_POST) && is_array($_POST))
		{
			foreach ($_POST as $key => $val) 
			{
				$_POST[$this->_clean_input_keys($key)] = $this->_clean_input_data($val);
			}
		}

		return $this->_fetch_array($_POST, $index);
	}

	protected function _fetch_array(&$array, $index = '')
	{
		if( is_array($index))
		{
			$output = array();
			foreach ($index as $key) 
			{
				$output[$key] = $this->_fetch_array($array, $key);
			}
			return $output;
		}

		if (isset($array[$index]))
		{
			$value = $array[$index];
		}
		else
		{
			$value = NULL;
		}

		return is_null($value) ? NULL : $this->Security->xss_clean($value);
	}

	/**
	 * Clean Input Data
	 *
	 * Internal method that aids in escaping data and
	 * standardizing newline characters to PHP_EOL.
	 *
	 * @param	string|string[]	$str	Input string(s)
	 * @return	string
	 */
	protected function _clean_input_data($str)
	{
		if (is_array($str))
		{
			$new_array = array();
			foreach (array_keys($str) as $key)
			{
				$new_array[$this->_clean_input_keys($key)] = $this->_clean_input_data($str[$key]);
			}
			return $new_array;
		}

		// Remove control characters
		$str = remove_invisible_characters($str, FALSE);

		// Standardize newlines if needed
		return preg_replace('/(?:\r\n|[\r\n])/', PHP_EOL, $str);

	}

	// --------------------------------------------------------------------

	/**
	 * Clean Keys
	 *
	 * Internal method that helps to prevent malicious users
	 * from trying to exploit keys we make sure that keys are
	 * only named with alpha-numeric text and a few other items.
	 *
	 * @param	string	$str	Input string
	 * @param	bool	$fatal	Whether to terminate script exection
	 *				or to return FALSE if an invalid
	 *				key is encountered
	 * @return	string|bool
	 */
	protected function _clean_input_keys($str, $fatal = TRUE)
	{
		if ( ! preg_match('/^[a-z0-9:_\/|-]+$/i', $str))
		{
			if ($fatal === TRUE)
			{
				return FALSE;
			}
			else
			{
				echo 'Disallowed Key Characters.';
				exit(7); // EXIT_USER_INPUT
			}
		}

		return $str;
	}
}