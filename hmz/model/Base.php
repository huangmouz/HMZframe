<?php
/**
 * Created by PhpStorm.
 * User: 黄谋政
 * Date: 2018/3/22
 * Time: 19:56
 */

namespace hmz\model;

use PDO;
use Exception;
class Base
{
	private static $pdo = null;
	public function __construct ()
	{
		if (is_null (self::$pdo)){
			try{
				$dsn = 'mysql:host=127.0.0.1;dbname=hmz';
				self::$pdo=new PDO($dsn,'root','root');
				self::$pdo->query ('set names utf8');
				self::$pdo->setAttribute (PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			}catch (Exception $e){
				throw new Exception($e->getMessage ());
			}
		}
	}
	public function query($sql){
		try{
			$res = self::$pdo->query ($sql);
			return $res->fetchAll (PDO::FETCH_ASSOC);
		}catch (Exception $e){
			throw new Exception($e->getMessage ());
		}
	}
	public function exec($sql){
		try{
			return self::$pdo->exec ('$sql');
		}catch (Exception $e){
			throw new Exception($e->getMessage ());
		}
	}
}