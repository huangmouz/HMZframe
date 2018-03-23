<?php
/**
 * Created by PhpStorm.
 * User: 黄谋政
 * Date: 2018/3/21
 * Time: 20:08
 */

namespace app\home\controller;


use hmz\core\Controller;
use hmz\model\Model;
use hmz\view\View;

class IndexController extends Controller
{
	public function index(){
		//echo "home index index";
		//(new View())->make();
		//这里测试分配页面和变量，在hmz/view里
		//return View::make()->with();
		//这里测试数据库的调用在hmz/model里
		//Model::query();
		$date = Model::query('select * from student');
		p ($date);

	}
	public function add(){
		//echo "home index add";
		//测试hmz/core/Controller/message方法是否被加载
		//$this->message ('1111');
	}
}