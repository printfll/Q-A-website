<?php
class DB{
	
	private $_host = '127.0.0.1' ;
	private $_username = 'root';
	private $_password = '654321' ;
	private $_dbname = 'aaa';
	
	private $_db ;
	
	
	public function __construct(){
		$dsn = "mysql:host=".$this->_host.";dbname=".$this->_dbname;
		try{
			$this->_db = new PDO($dsn,$this->_username, $this->_password,array(PDO::ATTR_PERSISTENT =>false,PDO::MYSQL_ATTR_INIT_COMMAND => "set names 'utf8';"));
			$this->_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); 
			$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		}catch(PDOException $e){
			die($e->getMessage());
			$this->_db = null;
		}
		
	} 
	
	
	   
	public function selectBySql($sql,$param){
		
		try{
			$query = $this->_db->prepare($sql);
			$query->setFetchMode(PDO::FETCH_ASSOC);
			$query->execute($param);
			$result = $query->fetchAll();	
			return $result ;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function exeSql($sql,$param){
		
		try{
			
			$stmt = $this->_db->prepare($sql);
			$res = $stmt->execute($param);
			return $this->_db->lastInsertId();;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function __destruct(){
		$this->_db = null;
	}
	
	
	
}
?>