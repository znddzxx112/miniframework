<?php
class Pagination
{
	/**
	 * 每页显示的条目数
	 * @var integer
	 */
	protected $page_num = 10;

	/**
	 * 总条目数
	 * @var [type]
	 */
	protected $total_num;

	/**
	 * 当前被选中的页
	 * @var integer
	 */
	protected $current_page = 1;

	/**
	 * 每次显示的页数
	 * @var integer
	 */
	protected $show_pages_num = 3;

	/**
	 * 总页数
	 * @var integer
	 */
	protected $total_page = 0;

	/**
	 * 每个分页的链接
	 * @var string
	 */
	protected $base_url = '';

	// ------------------------------------------------------
	
	public function initialize($param = array())
	{
		if( is_array($param) && !empty($param))
		{
			foreach ($param as $key => $val) 
			{
				if(property_exists($this, $key))
				{
					$this->$key = $val;
				}
			}
		}
	}

	public function creat_links()
	{
		if($this->total_num == 0 OR $this->page_num == 0){
			return false;
		}

		$this->total_page = ceil($this->total_num / $this->page_num);

		if($this->total_page == 1) {
			return '';
		}

		$start	= (($this->current_page - $this->show_pages_num) > 0) ? $this->current_page - ($this->show_pages_num - 1) : 1;
		$end	= (($this->current_page + $this->show_pages_num) < $this->total_page) ? $this->current_page + $this->show_pages_num : $this->total_page;

		$output = '';

		// first_page
		if( $this->current_page != 1){
			$output .= sprintf('<a href="%s">%s</a>', $this->base_url . 1, '首页');
		}

		// prev_page
		if( $this->current_page != 1){
			$output .= sprintf('<a href="%s">%s</a>', $this->base_url . ($this->current_page - 1), '上一页');
		}

		// start_num to end_num
		for($loop = $start; $loop <= $end; $loop++)
		{
			if( $this->current_page == $loop)
			{
				$output .= sprintf('<a href="%s">%s</a>', $this->base_url . $loop, "<strong>" . $loop . "</strong>");
			}
			else
			{
				$output .= sprintf('<a href="%s">%s</a>', $this->base_url . $loop, $loop);
			}
		}

		// next_page
		if( $this->current_page < $this->total_page){
			$output .= sprintf('<a href="%s">%s</a>', $this->base_url . ($this->current_page + 1), '下一页');
		}

		// end_page
		if( $this->current_page != $this->total_page){
			$output .= sprintf('<a href="%s">%s</a>', $this->base_url . ($this->total_page), '末页');
		}
		
		return $output;
	}

}