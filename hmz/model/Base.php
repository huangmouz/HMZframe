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
	private static $pdo    = null;
	/**
	 * @var string 表名，由
	 */
	private $table;
	/**
	 * @var string
	 */
	private $where  = '';
	/**
	 * @var string
	 */
	private $order  = '';
	/**
	 * @var string
	 */
	private $field  = '*';
	/**
	 * @var string
	 */
	private $limit  = '';
	/**
	 * @var string
	 */
	private $having = '';

	/**
	 * Base constructor.
	 *
	 * @param $class
	 *
	 * @throws Exception
	 */
	public function __construct ( $class )
	{
		$this->connect ();
		$this->table = strtolower ( ltrim ( strrchr ( $class , '\\' ) , '\\' ) );
	}

	/**
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
	 * @param $sql
	 *
	 * @return mixed
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
	 * @param $sql
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function exec ( $sql )
	{
		try {
			return self::$pdo->exec ( '$sql' );
		} catch ( Exception $e ) {
			throw new Exception( $e->getMessage () );
		}
	}

	/**
	 * @param $pri
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function find ( $pri )
	{
		$priField = $this->getPriField ();
		$sql      = 'select * from ' . $this->table . ' where ' . $priField . '=' . $pri;

		return current ( $this->query ( $sql ) );
	}

	/**
	 * @return mixed
	 * @throws Exception
	 */
	public function get ()
	{
		$sql = 'select ' . $this->field . ' from ' . $this->table . $this->where . $this->order . $this->limit;

		p ( $sql );

		return $this->query ( $sql );
	}

	/**
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
	 * @param $limit
	 */
	public function limit ( $limit )
	{
		$this->limit = $limit ? ' limit ' . $limit : '';
	}

	/**
	 * @param $having
	 */
	public function having ( $having )
	{
		$this->having = $having ? ' having ' . $having : '';
	}

	/**
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