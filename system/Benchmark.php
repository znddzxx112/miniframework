<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* benchmark
*/
class Benchmark
{
	
	private $marks = array();

	/**
	 * mark point
	 * @param  string $point [description]
	 * @return [type]        [description]
	 */
	public function mark($point = '')
	{
		$this->marks[$point] = microtime(true);
	}

	/**
	 * calc point2 point1 time
	 * @param  string $point1 [description]
	 * @param  string $point2 [description]
	 * @return [type]         [description]
	 */
	public function calc_time($point1 = '', $point2 = '')
	{
		if( ! isset($this->marks[$point1]))
		{
			return '';
		}

		if( ! isset($this->marks[$point2]))
		{
			$this->mark($point2);
		}

		return number_format($this->marks[$point2] - $this->marks[$point1], 4);
	}
	
}