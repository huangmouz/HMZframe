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
		return call_user_func_array ([new Base(),$name],$arguments);
	}
}