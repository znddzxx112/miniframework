<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* database
*/
abstract class Db
{
	
	/**
	 * 执行语句
	 * @param  string $code 999122 前三位表示模块名称 第四位代表语句类型1：查找，2：插入，3：更新，4删除 第五，六位代表次序
	 * @param  string $sql [<description>]
	 * @param  array  $data 数据
	 * @param  array  $type 数据对应的类型
	 * @return [type]       [description]
	 */
	public abstract function exec($code = '', $sql = '' , $data = array());

	/**
	 * 获取报错信息和错误码
	 * @return [type] [description]
	 */
	public abstract function get_error_info();

	/**
	 * 获取基础信息
	 * @return [type] [description]
	 */
	public abstract function get_all_base_info();

	/**
	 * 设置基础信息
	 * @param array  $change_user [description]
	 * @param string $db          [description]
	 * @param string $charset     [description]
	 */
	public abstract function set_change($change_user = array(), $db = '', $charset = 'utf8');

}