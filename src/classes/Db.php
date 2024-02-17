<?php

class Db {

	private $_db;
	protected static Db $_instance;

	/**
	 * @return Db
	 * @throws \Exception
	 */
	public static function instance() {
		if (!isset(self::$_instance) || !self::$_instance) {
			self::$_instance = new static();
			self::$_instance->init(self::getDSN(), env('DB_USERNAME'), env('DB_PASSWORD'));
		}
		return self::$_instance;
	}

	/**
	 * @param string $dsn
	 * @return void
	 */
	public function init($dsn, $username = null, $password = null) {
		$db = new PDO($dsn, $username, $password);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->_db = $db;
	}

	/**
	 * @param string $sql
	 * @return PDOStatement
	 */
	public function prepare($sql) {
		return $this->_db->prepare($sql);
	}

	/**
	 * @param string $sql
	 * @param array $params
	 * @return PDOStatement
	 */
	public function query($sql, $params = []) {
		$stmt = $this->_db->prepare($sql);
		$stmt->execute($params);
		return $stmt;
	}

	/**
	 * @param string $sql
	 * @param array $params
	 * @return array|null
	 */
	public function first($sql, $params = []) {
		$stmt = $this->query($sql, $params);
		return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
	}

	/**
	 * @param $sql
	 * @param $params
	 * @return array
	 */
	public function all($sql, $params = []) {
		$stmt = $this->query($sql, $params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	protected static function getDSN() {
		return sprintf(
			'%s:host=%s;port=%s;dbname=%s',
			env('DB_CONNECTION'),
			env('DB_HOST'),
			env('DB_PORT'),
			env('DB_DATABASE')
		);
	}

}
