<?php 

/**
 * see https://github.com/znddzxx112/ziphp
 */
class Zip
{
	private $zip = null;

	private $filepath = '';

	private $zipfilelist = array();
	
	private $ziprootfilelist = array();
	/**
	 * 文件路径错误
	 */
	const ERROR_FILEPATH_INVALID = 'filepath is invalid';
	/**
	 * 目标文件路径错误
	 */
	const ERROR_DEST_FILEPATH_INVALID = 'dest filepath is invalid';
	/**
	 * 打开失败
	 */
	const ERROR_OPEN_FAIL = 'open fail';
	/**
	 * 待压缩文件夹名称
	 */
	const ERROR_SOURCE_FILEPATH = 'source_filepath is fail';
	/**
	 * 参数错误
	 */
	const ERROR_PARAM_INVAILD = 'param invalid';
	/**
	 * 文件不存在
	 */
	const ERROR_FILE_NOT_EXISTS = 'file not exist';
	
	function __construct($conf='')
	{
		if( isset($conf) OR is_array($conf))
		{
			foreach ($conf as $k => $v) 
			{
				if(property_exists($this, $k))
				{
					$this->$k = $v;
				}
			}
		}
		$this->zip=new \ZipArchive();
		if($this->filepath!=''){
			$open_res = $this->_open();
			if(!$open_res){
				throw new \Exception(self::ERROR_OPEN_FAIL);
			}
		}
	}
	/**
	 * 载入zip压缩包
	 * @param  string $conf [description]
	 * @return [type]       [description]
	 */
	public static function load($conf=''){
		return new self($conf);
	}
	/**
	 * 打开zip压缩包
	 * @param  string $filepath [description]
	 * @return [type]           [description]
	 */
	public function open($filepath=''){
		if($filepath==''){
			throw new \Exception(self::ERROR_FILEPATH_INVALID);
		}
		$this->filepath=$filepath;
		$this->_open();
	}
	/**
	 * 返回zip root文件列表
	 */
	public function get_zip_root_file_list(){
		if(empty($this->ziprootfilelist)){
			for($i=0;$i<$this->zip->numFiles;$i++){
				$this->ziprootfilelist[] = $this->zip->getNameIndex($i);
			}
		}
		return $this->ziprootfilelist;
	}
	/**
	 * 获取压缩包中文件通过索引
	 * @param integer $index 索引号
	 * @return 
	 */
	public function decompress_file_from_index($index){
		$data=$this->zip->getFromIndex($index);
		$filename=$this->zip->getNameIndex($index);
		return file_put_contents($filename, $data);
	}
	/**
	 * 获取压缩包中文件通过文件名称
	 */
	public function decompress_file_from_name($filename=''){
		$data=$this->zip->getFromName($filename);
		return file_put_contents($filename, $data);
	}
	/**
	 * 返回压缩包文件数量
	 * @return [type] [description]
	 */
	public function get_zip_file_num(){
		return $this->zip->numFiles;
	}
	/**
	 * 解压缩文件
	 */
	public function decompression($destination=''){
		if($destination==''){
			throw new \Exception(self::ERROR_DEST_FILEPATH_INVALID);
		}
		$this->_extractTo($destination);
	}
	/**
	 * 压缩磁盘文件
	 * @param string $source 待压缩文件夹名称
	 * @param string $destination 压缩后zip文件名称
	 * @param boolean $need_folder 是否需要将待压缩文件夹名称放入 true 需要
	 */
	public function compress($source='',$destination='',$need_folder=true){
		if($source == ''){
			throw new \Exception(self::ERROR_SOURCE_FILEPATH);
		}
		if($destination!=''){
			$this->filepath = $destination;
			$this->_open(\ZIPARCHIVE::OVERWRITE);
		}
		$dir_handle = opendir($source);
		while(($file = readdir($dir_handle)) !== false){
			if($file == '.' || $file == '..'){
				continue;
			}elseif(is_dir($file)){
				$this->compress($source.$file);
			}else{
				$_target_file = $source.$file;
				if($need_folder==true){
					$local_name = $_target_file;
				}else{
					$local_name = str_replace($source, '', $_target_file);
				}
				$this->zip->addFile($_target_file,$local_name);
			}
		}
	}
	/**
	 * 压缩磁盘文件夹内容
	 * @return [type] [description]
	 */
	public function compress_from_directory($directory,$mask='*'){
		$cwd = getcwd();
		chdir($directory);
		$directory = rtrim($directory,'/');
		foreach (glob($mask) as $file) {
			$this->zip->addFile("$directory/$file",$file);
		}
		chdir($cwd);
		return $this;
	}
	/**
	 * zip包追加文件来自字符串
	 * @param  string $local_name  压缩包文件名
	 * @param  string $destination 压缩包
	 * @param  string $content     字符串
	 * @return boolean             
	 */
	public function append_from_string($local_name='',$destination='',$content=''){
		if($local_name == '' || $content == ''){
			throw new \Exception(self::ERROR_PARAM_INVAILD);
		}
		if($destination!=''){
			$this->filepath = $destination;
			$this->_open(\ZIPARCHIVE::CREATE);
		}
		return $this->zip->addFromString($local_name,$content);
	}
	/**
	 * zip包追加文件来自文件
	 * @param  string $local_name  压缩包文件名
	 * @param  string $destination 压缩包
	 * @param  string $sourcefile  文件路径
	 * @return boolean             
	 */
	public function append_from_file($local_name='',$destination='',$sourcefile=''){
		if($local_name == '' || $sourcefile == ''){
			throw new \Exception(self::ERROR_PARAM_INVAILD);
		}
		if(!file_exists($sourcefile)){
			throw new Exception(self::ERROR_FILE_NOT_EXISTS);
		}
		if($destination!=''){
			$this->filepath = $destination;
			$this->_open(\ZIPARCHIVE::CREATE);
		}
		return $this->zip->addFile($sourcefile,$local_name);
	}
	/**
	 * 打开文件
	 * @return boolean true 打开成功 false 打开失败
	 */
	private function _open($flag=\ZIPARCHIVE::CREATE){
		$open_res = $this->zip->open($this->filepath,$flag);
		if($open_res!=true){
			return false;#create fail
		}
		return true;#success
	}
	/**
	 * 解压缩
	 * @param  string $destination [description]
	 * @return [type]              [description]
	 */
	private function _extractTo($destination=''){
		$this->zip->extractTo($destination);
	}
	/**
	 * 读取某个目录中的所有文件
	 * @param  string $temp [description]
	 * @return [type]       [description]
	 */
	private function _read_dir_list($temp='',$need_folder=true){
		$dirlist = array();
		$temp_handle = opendir($temp);
		while (($file = readdir($temp_handle))!==false) {
			if($file == '.' || $file == '..'){
				$_target_file = $temp.$file;
				// $dirlist[] = $temp.$file;
			}elseif(is_dir($file)){
				$this->_read_dir_list($temp.$file);
			}else{
				$_target_file = $temp.$file;
				// $dirlist[] = $temp.$file;
			}
			$dirlist[] = str_replace($temp, '', $_target_file);
		}
		return $dirlist;
	}
	public function __destruct(){
		if($this->zip!=null && $this->filepath!=''){
			$this->zip->close();
		}
	}
}