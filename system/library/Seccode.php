<?php 

class Seccode 
{

	protected $width = 100;

	protected $height = 50;

	protected $num = 4;

	protected $code = false;

	public function initialize($conf = array())
	{
		if( isset($conf) && is_array($conf))
		{
			foreach ($conf as $key => $val) 
			{
				if(property_exists($this, $key))
				{
					$this->$key = $val;
				}
			}
		}
	}

	public function getCode()
	{
		return $this->code;
	}

	public function show()
	{
		@header("Content-type: image/png");
		// 画出基本骨架
		$im = imagecreate($this->width, $this->height);

		// 填充背景
		$bgcolor = imagecolorallocate($im, 255, 255, 255);

		imagefill($im, 0, 0, $bgcolor);

		// 画上随机字符
		$tmp_str = '';
		$alpha   = "abcdefghijkmnpqrstuvwxyz";
		$nums    = "123456789";
		for ($i=0; $i < $this->num; $i++) 
		{ 
			$is_alpha = mt_rand(0,1);
			$tmp_str = $is_alpha == 1 ? $alpha : $nums;
			$code = substr($tmp_str, rand(0,strlen($tmp_str)), 1);
			$j = !$i ? 4 : $j + $this->width / $this->num ;
			$font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imagechar($im, 15, $j, mt_rand(4, 30), $code, $font_color);
			$this->code .= $code;
		}

		/*
		* 添加干扰
		*/
		//*	
		for($i=0; $i<5; $i++)//绘背景干扰线
		{   
			$color1 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //干扰线颜色
			ImageArc($im, mt_rand(-5,$this->width), mt_rand(-5,$this->height), mt_rand(20,300), mt_rand(20,200), 55, 44, $color1); //干扰线
		}
		// */  
		for($i=0; $i<$this->num * 5; $i++)//绘背景干扰点
		{   
			$color2 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //干扰点颜色 
			ImageSetPixel($im, mt_rand(0,$this->width), mt_rand(0,$this->height), $color2); //干扰点
		}

		// 输出在浏览器上
		imagepng($im);

		imagedestroy($im);
	}

}