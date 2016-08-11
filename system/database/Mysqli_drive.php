<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* mysqli
* see basecode/mysqlfun/mysqliClient.php
*/
class Mysqli_drive extends Db
{
	
	/**
	 * 客户端随机编号
	 * @var integer
	 */
	public $client_id = 0;

	/**
	 * mysqli对象
	 * @var null
	 */
	private $_mysqli = null;

	/**
	 * mysqli_stmt对象
	 * @var null
	 */
	private $_mysqli_stmt = null;

	/**
	 * mysqli_result对象
	 * @var null
	 */
	private $_mysqli_result= null;

	/**
	 * 所有基础信息
	 * @var array
	 */
	public $all_base_info = array();

	/**
	 * 执行错误信息
	 * @var array
	 */
	private $error_info = array();

	/* *************** *
	 * magic functions * 
	 * *************** */

	public function __construct()
	{
		
	}

	public function __destruct()
	{
		if($this->_mysqli != null){
			$this->_mysqli->close();
		}
	}

	/* **************** *
	 * public functions * 
	 * **************** */

	public function init($host, $username, $passwd, $dbname, $port = 3306)
	{
		$this->_mysqli = new \mysqli($host, $username, $passwd, $dbname, $port);
		if($this->_mysqli->connect_errno){
			$this->set_error_info($this->_mysqli->connet_error, $this->_mysqli->connect_errno);
			throw new Exception($this->_mysqli->connet_error, $this->_mysqli->connect_errno);
		}
		$this->_pre_func();
	}

	/**
	 * 执行语句
	 * @param  string $code 999122 前三位表示模块名称 第四位代表语句类型1：查找，2：插入，3：更新，4删除 第五，六位代表次序
	 * @param  string $sql [<description>]
	 * @param  array  $data 数据
	 * @param  array  $type 数据对应的类型
	 * @return [type]       [description]
	 */
	public function exec($code = '', $sql = '' , $data = array())
	{
		$this->_mysqli_stmt = $this->_mysqli->prepare($sql);

		//绑定变量
		if(count($data)>0){
			try{
				call_user_func_array(array($this->_mysqli_stmt, 'bind_param'), $this->makeValuesReferenced($data));
			}catch(Exception $e){
				$this->set_error_info($this->_mysqli->connet_error, $e->getMessage());
				return false;
			}
		}

		$exec_result = $this->_mysqli_stmt->execute();
		if($exec_result == false){
			$this->set_error_info($this->_mysqli->connet_error, $this->_mysqli->connect_errno);
			return false;
		}

		$this->_mysqli_result = $this->_mysqli_stmt->get_result();

		$this->_num_rows = @$this->_mysqli_result->num_rows;

		$this->_affected_rows = $this->_mysqli_stmt->affected_rows;

		$this->_insert_id = $this->_mysqli_stmt->insert_id;

		$this->_mysqli_stmt->close();

		$ob = substr($code, 3, 1);
		switch ($ob) {
			case '1':
				return $this->get_arrayresult();
				break;
			case '2':
				return $this->_insert_id;
				break;
			case '3':
			case '4':
				return $this->_affected_rows;
				break;
			default:
				return false;
				break;
		}

		
	}

	/**
	 * 获取报错信息和错误码
	 * @return [type] [description]
	 */
	public function get_error_info()
	{
		return $this->error_info;
	}

	/**
	 * 获取基础信息
	 * @return [type] [description]
	 */
	public function get_all_base_info()
	{
		return $this->all_base_info;
	}

	/**
	 * 设置基础信息
	 * @param array  $change_user [description]
	 * @param string $db          [description]
	 * @param string $charset     [description]
	 */
	public function set_change($change_user = array(), $db = '', $charset = 'utf8')
	{
		if(count($change_user) > 0) {
			$this->_mysqli->change_user($change_user['username'], $change_user['password'], $change_user['db']);
		}
		if($db != ''){
			$this->_mysqli->select_db($db);
		}
		if($charset != ''){
			$this->_mysqli->set_charset($charset);
		}
	}

	/* ***************** *
	 * private functions * 
	 * ***************** */

	/**
	 * 返回关联数组结果
	 * @return [type] [description]
	 */
	private function get_arrayresult()
	{
		$array_result = array();
		if ($this->_num_rows == 1){
			$array_result = $this->_mysqli_result->fetch_assoc();
		} elseif($this->_num_rows > 1){
			while ($row = $this->_mysqli_result->fetch_assoc()) {
				$array_result[] = $row;
			}
		}
		$this->_mysqli_result->close();
		return $array_result;
	}

	/**
	 * 设置错误信息
	 * @param [type] $error [description]
	 * @param [type] $errno [description]
	 */
	private function set_error_info($error, $errno)
	{
		$this->error_info = array(
							'error' => $error,
							'errno' => $errno,
							'connect_errno'=> $this->_mysqli->connect_errno,
							'connect_error'=> $this->_mysqli->connect_error,
							'real_errno' => $this->_mysqli->errno,
							'real_error' => $this->_mysqli->error,
							'sqlstate' => $this->_mysqli->sqlstate,
							'warning_count' => $this->_mysqli->get_warnings(),
							'charset'=>$this->_mysqli->get_charset(),
							'server_info'=>$this->_mysqli->get_server_info(),
							'system_stat'=>$this->_mysqli->stat(),
							'thread_id'=>$this->thread_id(),
							'thread_safe'=>$this->thread_safe(),

						);
	}

	/**
	 * 预处理
	 * @return [type] [description]
	 */
	private function _pre_func()
	{
		$this->_mysqli->set_charset('utf8');
		$this->client_id = mt_rand(1000,9999);
		$this->all_base_info['host_info'] = $this->_mysqli->host_info;
		$this->all_base_info['protocol_version'] = $this->_mysqli->protocol_version;
		$this->all_base_info['server_info'] = $this->_mysqli->server_info;
		$this->all_base_info['server_version'] = $this->_mysqli->server_version;
		$this->all_base_info['info'] = $this->_mysqli->info;
	}

	/**
	 * 数组值引用
	 * @param  [type] $arr [description]
	 * @return [type]      [description]
	 */
	private function makeValuesReferenced($arr = array()){
	    $refs = array();
	    foreach($arr as $key => $value){
	        $refs[$key] = &$arr[$key];
	    }
	    return $refs;
	}
}