<?php
/**
 * Created by PhpStorm.
 * User: 黄谋政
 * Date: 2018/3/22
 * Time: 15:40
 */

namespace hmz\core;


/**
 * 公共控制器，用来提示或跳转页面使用
 * Class Controller
 *
 * @package hmz\core
 */
class Controller
{
	/**
	 * @var 跳转地址
	 */
	private $url;

	/**
	 * 提示信息方法
	 * @param $msg 提示信息
	 *
	 * @return $this 返出自身对象，方便链式操作
	 */
	public function message ( $msg)
	{
		//基本上加载模板都要参考单入口文件
		//p($msg);
		include './view/message.php';
		return $this;
	}

	/**
	 * 跳转地址
	 * @param $url 跳转地址
	 *
	 * @return $this 返出自身对象，方便链式操作
	 */
	public function setRedirect( $url='')
	{

		if ($url){
			//跳转到指定地址
			$this->url=$url;
		}else{
			//跳回上一页
			$this->url = 'javascript:history.back();';
		}
		return $this;
	}
}