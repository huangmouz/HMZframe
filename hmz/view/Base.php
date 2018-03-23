<?php
/**
 * Created by PhpStorm.
 * User: 黄谋政
 * Date: 2018/3/22
 * Time: 19:56
 */

namespace hmz\view;


/**
 * 加载模板类的主体方法
 * Class Base
 *
 * @package hmz\view
 */
class Base
{
	/**
	 * @var 加载的模板的路径
	 */
	private $file;
	/**
	 * 传过来的是数组
	 * @var array 需要分配的变量
	 */
	private $date =[];

	/**
	 * 加载模板方法
	 * @param string $tpl 模板名称
	 *
	 * @return $this 返出当前对象
	 */
	public function make( $tpl=''){
		//echo 13;
		//判断tpl的值，如果是空就走默认值与调用的方法同名，否则按传入的值走
		$tpl = $tpl?:ACTION;
		//组合模板路径，参考单入口public/index
		$this->file='../app/'.MODULE.'/view/'.CONTROLLER.'/'.$tpl.'.php';
		return $this;
	}

	/**
	 * 分配变量方法
	 * @param array $var
	 *
	 * @return $this
	 */
	public function with( $var=[]){
		//获取传入进来的参数
		$this->date = $var;
		return $this;
	}

	/**
	 * 在echo一个对象的时候触发的方法
	 * @return string 必须要有返回值，否则会报错，这里默认用空字符串
	 */
	public function __toString ()
	{
		//分配变量
		//p ($this->file);die;
		extract ($this->date);
		//判断是否调用了分配模板方法，如果有就分配模板
		if(!is_null ($this->file)){
			include $this->file;
		}
		return '';
	}
}