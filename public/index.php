<?php
/**
 * Created by PhpStorm.
 * User: 黄谋政
 * Date: 2018/3/21
 * Time: 11:02
 */
/**
 * 单一入口文件，所有的东西必须要以这个为入口
 */
//使用composer里的自动加载类加载类文件，这样比较方便
//但是使用这个要到vendor/composer.json里去添加一个自动加载配置
//"autoload":{
//	"files":[
//		"system/helper.php"
//	],
//    "psr-4":{
//		"hmz\\":"hmz",
//            "app\\":"app"
//        }
//    }
//psr-4是一种代码规范，规定用什么方式去加载类和文件等
//写完后需要在terminal里跑一下composer dump 让文件自动加载出来
//这时候就加载成功了
require_once '../vendor/autoload.php';
//运行Boot类，加载出初始页面
\hmz\core\Boot::run ();