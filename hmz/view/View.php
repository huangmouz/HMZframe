<?php
/**
 * Created by PhpStorm.
 * User: 黄谋政
 * Date: 2018/3/22
 * Time: 19:55
 */

namespace hmz\view;


/**
 * View 视图层，加载模板，分配变量
 * 这个类其实没干什么，只是中转了一下
 * Class View
 *
 * @package hmz\view
 */
class View
{
	/**
	 * 当调用不存在的方法时触发这个方法
	 * @param $name 不存在的方法名
	 * @param $arguments 传入的参数（数组形式）
	 */
	public function __call ( $name , $arguments )
	{
		//echo 111;
		//return将下一级传上来的对象给上一级
		return self::runParse ( $name , $arguments );
	}

	/**
	 * 当调用不存在的静态方法时触发这个方法
	 * @param $name 不存在的方法名
	 * @param $arguments 传入的参数array
	 */
	public static function __callStatic ( $name , $arguments )
	{
		//echo 222;
		//return将下一级传上来的对象给上一级
		return self::runParse ( $name , $arguments );
	}

	/**
	 * 在这里new Base类，然后调用需要调用的方法
	 * @param $name 不存在的方法名
	 * @param $arguments 传入的参数array
	 */
	private static function runParse ( $name , $arguments )
	{
		//实例化base类，传入参数
		return call_user_func_array ( [ new Base() , $name ] , $arguments );
	}

}