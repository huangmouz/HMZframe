<?php
/**
 * Created by PhpStorm.
 * User: 黄谋政
 * Date: 2018/3/21
 * Time: 20:26
 */

/**
 * 打印函数
 *
 * @param $var    打印的变量
 */
function p ( $var )
{
	echo '<pre style="width: 100%;padding: 5px;background: #CCCCCC;border-radius: 5px">';
	if ( is_bool ( $var ) || is_null ( $var ) ) {
		var_dump ( $var );
	} else {
		print_r ( $var );
	}
	echo '</pre>';
}

/**
 * 定义常量:IS_POST
 * 将侧是否为post请求
 */
define ( 'IS_POST' , $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ? true : false );
/**
 * 配置项函数c
 */
function c ( $var = null )
{
	//如果没有传参var=null这时候返回所有的配置项
	//如果传了参数按点拆分，只有一个的返回对应文件的配置项
	//如果拆分出两个的，返回对应文件中的对应配置
	if ( is_null ( $var ) ) {
		//return 1;
		//扫描config文件夹将其中的文件全部扫描到
		$files = glob ( '../system/config/*' );
		//定义空数组以便追加配置数据
		$data = [];
		//循环获取文件夹里的所有文件的数据，并追加到data里
		foreach ( $files as $file ) {
			//获取文件里的数据
			$content = include $file;
			//通过已知的文件路径获取文件名，然后获取配置类的名称
			$index = substr ( basename ( $file ) , 0 , strpos ( basename ( $file ) , '.php' ) );
			//追加数组
			$data[ $index ] = $content;
		}

		//返出配置项数组
		return $data;
	} else {
		//拆分字符串
		$info = explode ( '.' , $var );
		//按照拆分结果组合文件名
		$file = '../system/config/' . $info[ 0 ] . '.php';
		if ( count ( $info ) == 1 ) {
			//return 2;
			//返出对应文件里的配置数据
			return is_file ( $file ) ? include $file : null;
		}
		if ( count ( $info ) == 2 ) {
			if ( is_file ( $file ) ) {
				//抓取文件中的数据
				$data = include $file;
				//返出对应文件里的对应位置的配置数据
				return isset ( $data[ $info[ 1 ] ] ) ? $data[ $info[ 1 ] ] : null;
			}
			//如果条件都不满足返回null；
			return null;
			//return 3;
		}
		//如果条件都不满足返回null；
		return null;
	}
}