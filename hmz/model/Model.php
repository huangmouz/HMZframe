<?php
/**
 * Created by PhpStorm.
 * User: 黄谋政
 * Date: 2018/3/22
 * Time: 19:56
 */

namespace hmz\model;


class Model
{
	public function __call ( $name , $arguments )
	{
		//echo 1;
		return self::runParse ($name,$arguments);
	}

	public static function __callStatic ( $name , $arguments )
	{
		//echo '静态调用';
		return self::runParse ($name,$arguments);
	}

	private static function runParse ( $name , $arguments )
	{
		//这个方法能返回触发这函数的类这里由子类触发父类方法触发，所以应该会返回子类的类名，即数据库的表名
		$modelClass = get_called_class ();
		//实例化base类
		return call_user_func_array ([new Base($modelClass),$name],$arguments);
	}
}