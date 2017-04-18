<?php

class Database {
	private $pdo;

	public function __destruct()
	{
		$this->pdo = null;
	}


	public function getConn()
	{
		if( is_object($this->pdo) ){
			return($this->pdo);
		}

		try{
			$this->pdo = new PDO(
				sprintf('%s:host=%s;dbname=%s;port=%s;charset=%s', 'mysql', '127.0.0.1', 'blog_android', '8889', 'utf8'),
				'root',
				'root' );
		}
		catch(PDOException $e){
			exit($e->getMessage());
		}
		return($this->pdo);
	}
}
