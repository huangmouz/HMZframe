<?php
/**
 * Created by PhpStorm.
 * User: 黄谋政
 * Date: 2018/3/21
 * Time: 20:12
 */

namespace hmz\core;


/**
 * 用于框架刚进来时启动
 * Class Boot
 *
 * @package hmz\core
 */
class Boot
{
	/**
	 * 执行应用启动框架
	 */
	public static function run(){
		//echo 1;
		//在public/index里调试出打印的数据
	    //初始化框架
		self::init();
		//执行应用类
		self::appRun();
	}

	/**
	 * 初始化
	 * 发送头部，设置时区，开启session
	 */
	public static function init(){
		//echo "init";
		//头部
		header ('Content-type:text/html;charset=utf8');
		//设置时区
		date_default_timezone_set ('PRC');
		//开启session，短路写法，如果已经开启就不再开启
		session_id ()||session_start ();
	}

	/**
	 * 运行app/类，加载app里面的类
	 */
	public static function appRun(){
		//echo 'appRun';
		//判断是否存在get参数s，如果有的情况下对其进行处理，加载对应的页面，否则的话默认是入口页
		if (isset($_GET['s'])){
			//拆分get参数将需要的三个参数分离出来
			$info = explode ('/',$_GET['s']);
			//p ($info);
			//m指代model模型，c指代controller控制器，a指代action方法
			$m = $info[0];
			$c = $info[1];
			$a = $info[2];
		}else{
			$m = 'home';
			$c = 'index';
			$a = 'index';
		}
		define ('MODULE',$m);
		define ('CONTROLLER',strtolower ($c));
		define ('ACTION',$a);
		//(new \app\home\controller\IndexController())->index ()
		//组装需要的路径，因为加入了命名空间的概念，所以现在需要将命名空间也组起来
		$controller = '\app\\'.$m.'\controller\\'.ucfirst ($c).'Controller';
		echo call_user_func_array ([new $controller,$a],[]);
	}
}