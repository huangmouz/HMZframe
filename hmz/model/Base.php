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

/**
 * 用来处理数据库的类
 * Class Base
 *
 * @package hmz\model
 */
class Base
{
	/**
	 * @var null 静态链接数据库所用，保存链接状态，以免多次链接
	 */
	private static $pdo = null;
	/**
	 * @var string 表名，由Model类里的get_called_class方法传过来
	 */
	private $table;
	/**
	 * @var string 接收传过来的参数用于where查找方法
	 */
	private $where = '';
	/**
	 * @var string 接收传过来的参数用于order排序方法
	 */
	private $order = '';
	/**
	 * @var string 接收传过来的参数用于规定查找类型方法
	 */
	private $field = '*';
	/**
	 * @var string 接收传过来的参数用于截取方法
	 */
	private $limit = '';
	/**
	 * @var string 接收传过来的参数用于having方法
	 */
	private $having = '';
	private $group  = '';
	private $join   = '';

	/**
	 * 构造函数 用于在方法调用之前触发
	 * Base constructor.
	 *
	 * @param $class 表名
	 *
	 * @throws Exception
	 */
	public function __construct ( $class )
	{
		//链接数据库
		$this->connect ();
		//处理传过来的参数，处理成需要的表名
		$this->table = strtolower ( ltrim ( strrchr ( $class , '\\' ) , '\\' ) );
	}

	/**
	 * 链接数据库方法
	 *
	 * @throws Exception
	 */
	public function connect ()
	{
		if ( is_null ( self::$pdo ) ) {
			try {
				//链接数据库PDO('数据库地址；数据库名称 ',用户名,密码)
				self::$pdo = new PDO(
					'mysql:host=' . c ( 'database.DB_HOST' ) . ';dbname=' .
					c ( 'database.DB_NAME' ) , c ( 'database.DB_USER' ) , c ( 'database.DB_PASS' ) );
				self::$pdo->query ( 'set names ' . c ( 'database.DB_CHAR' ) );
				self::$pdo->setAttribute ( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
			} catch ( Exception $e ) {
				throw new Exception( $e->getMessage () );
			}
		}
	}

	/**
	 * 执行有结果集的方法
	 *
	 * @param $sql sql语句
	 *
	 * @return mixed 返出获得的结果
	 * @throws Exception
	 */
	public function query ( $sql )
	{
		try {
			$res = self::$pdo->query ( $sql );

			return $res->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( Exception $e ) {
			throw new Exception( $e->getMessage () );
		}
	}

	/**
	 * 执行无结果集的方法
	 *
	 * @param $sql sql语句
	 *
	 * @return mixed 返出受影响的条数
	 * @throws Exception
	 */
	public function exec ( $sql )
	{
		try {
			return self::$pdo->exec ( $sql );
		} catch ( Exception $e ) {
			throw new Exception( $e->getMessage () );
		}
	}

	/**
	 * 根据主键获取单一数据
	 *
	 * @param $pri 主键
	 *
	 * @return mixed 返出查找到的数据
	 * @throws Exception
	 */
	public function find ( $pri )
	{
		$priField = $this->getPriField ();
		$sql      = 'select ' . $this->field . ' from ' . $this->table . ' where ' . $priField . '=' . $pri;

		return current ( $this->query ( $sql ) );
	}

	/**
	 * 多表关联方法
	 *
	 * @param $table 表名
	 * @param $a     a表关联属性
	 * @param $b     b表关联属性
	 */
	public function join ( $table , $a , $b )
	{
		$this->join = $table ? ' join on ' . $table . ' at ' . $a . '=' . $b : '';
		return $this;
	}

	/**
	 * 获取指定列数据方法
	 *
	 * @param $field
	 *
	 * @return $this
	 */
	public function field ( $field )
	{
		$this->field = $field;

		return $this;
	}

	/**
	 * 查询where条件
	 *
	 * @param $where
	 *
	 * @return $this
	 */
	public function where ( $where )
	{
		$this->where = $where ? ' where ' . $where : '';

		return $this;
	}

	/**
	 * 排序方法
	 *
	 * @param $order
	 *
	 * @return $this
	 */
	public function orderBy ( $order )
	{
		//p ( $order );
		$this->order = $order ? ' order by ' . $order : '';

		return $this;
	}

	/**
	 * 分组方法
	 *
	 * @param $group
	 *
	 * @return $this
	 */
	public function groupBy ( $group )
	{
		$this->group = $group ? ' group by ' . $group : '';

		return $this;
	}

	/**
	 * groupBy后在使用的方法
	 *
	 * @param $having
	 */
	public function having ( $having )
	{
		$this->having = $having ? ' having ' . $having : '';
	}

	/**
	 * 截取方法
	 *
	 * @param $limit
	 */
	public function limit ( $limit )
	{
		$this->limit = $limit ? ' limit ' . $limit : '';
	}

	/**
	 * 获取所有的数据
	 *
	 * @return mixed 返出数据
	 * @throws Exception
	 */
	public function get ()
	{
		$sql = 'select ' . $this->field . ' from ' . $this->table .$this->join. $this->where . $this->group . $this->having .
			   $this->order . $this->limit;

		p ( $sql );die;

		return $this->query ( $sql );
	}

	/**
	 * 截取第一条
	 */
	public function first(){
		$sql = 'select ' . $this->field . ' from ' . $this->table .$this->join. $this->where . $this->group . $this->having .
			   $this->order . ' limit 1';

		return $this->query ( $sql );
	}

	/**
	 * 写入数据方法
	 * @param $data
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function insert( $data ){
		$fields = '';
		$values = '';
		//循环数据，将数据处理成sql需要的形式
		foreach ($data as $k=>$v){
			$fields .= $k . ',';
			$values .= is_int ($v) ? $v .',':"'$v'".',';
		}
		$fields = rtrim ($fields,',');
		$values = rtrim ($values,',');
		$sql = 'insert into'.$this->table.'('.$fields.') values ('.$values.')';
		return $this->exec ($sql);
	}

	/**
	 * 更新数据方法
	 * @param $data
	 *
	 * @return bool|mixed
	 * @throws Exception
	 */
	public function update( $data ){
		if (!$this->where) return false;
		$fields = '';
		foreach ($data as $k=>$v){
			$fields .= $k .'='.(is_int ($v)?$v:"'$v'") .',';
		}
		$fields = rtrim ($fields,',');
		$sql = 'update '.$this->table.' set '.$fields .$this->where;
		p ($sql);die('语句正确的话就去hmz/model/base里的update方法注释掉die');
		return $this->exec ($sql);
	}

	/**
	 * 数据删除方法
	 */
	public function delete(){
		if (!$this->where) return false;
		$sql = 'delete from '.$this->table.$this->where;
		p ($sql);die('语句正确的话就去hmz/model/base里的delete方法注释掉die');
		return $this->exec ($sql);
	}

	/**
	 * 获取主键ID方法
	 *
	 * @return mixed
	 * @throws Exception
	 */
	private function getPriField ()
	{
		$res = $this->query ( 'desc ' . $this->table );
		//p ($res);
		foreach ( $res as $v ) {
			if ( $v[ 'Key' ] == 'PRI' )
				return $v[ 'Field' ];
		}
	}
}