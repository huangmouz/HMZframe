<?php
/**
 * Created by PhpStorm.
 * User: 黄谋政
 * Date: 2018/3/21
 * Time: 20:26
 */

/**
 * 打印函数
 * @param $var	打印的变量
 */
function p($var){
	echo '<pre style="width: 100%;padding: 5px;background: #CCCCCC;border-radius: 5px">';
	if(is_bool ($var) || is_null ($var)){
		var_dump ($var);
	}else{
		print_r ($var);
	}
	echo '</pre>';
}

/**
 * 定义常量:IS_POST
 * 将侧是否为post请求
 */
define ('IS_POST',$_SERVER['REQUEST_METHOD']=='POST'?true:false);