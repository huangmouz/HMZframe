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
use system\model\Student;

class IndexController extends Controller
{
	public function index(){
		//echo "home index index";
		//(new View())->make();
		//这里测试分配页面和变量，在hmz/view里
		return View::make()->with();
		//这里测试数据库的调用在hmz/model里
		//Model::query();
		//$date = Model::query('select * from student');
		//p ($date);
		//p(c ());
		//p (c('database'));
		//p (c('database.DB_NAME'));
		//$data = Student::where('id=3')->field('name')->groupBy('name')->join('age',1,1)->get();
		//$data = Student::where('name=1')->delete();
		//$data = Student::find(4);
		//sdfas//我是搞事情的
		//p ($data);
	}
	//public function add(){
		//echo "home index add";
		//测试hmz/core/Controller/message方法是否被加载
		//$this->message ('1111');
	//}
}