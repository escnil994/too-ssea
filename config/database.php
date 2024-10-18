<?php
class Database
{
	private $host = '127.0.0.1';
	private $db_name = 'php_mvc';
	private $username = 'root';
	private $password = 'brandon.parrillas@ambiente.gob.sv';
	public $conn;

	public function connect()
	{
		$this->conn = null;

		try {
			$this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			// echo 'Connection Error: ' . $e->getMessage();
		}

		return $this->conn;
	}

	public function close()
	{
		$this->conn = null;
	}

	public function __destruct()
	{
		$this->close();
	}
}
