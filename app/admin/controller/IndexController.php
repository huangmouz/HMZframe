<?php
/**
 * Created by PhpStorm.
 * User: 黄谋政
 * Date: 2018/3/21
 * Time: 20:05
 */

namespace app\admin\controller;


use hmz\core\Controller;

class IndexController extends Controller
{
	public function index(){
		echo "admin index index";
	}
	public function add(){
		echo "admin index add";
	}
}