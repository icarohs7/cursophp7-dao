<?php

class Sql extends PDO {

	private $conn;

	public function __construct(){
		
		$this->conn = new PDO('mysql:host=localhost;dbname=dbphp7','root','0000');
	}

	private function setParams(PDOStatement $statement, array $parameters){

		foreach ($parameters as $key=>$value){
			$this->setParam($statement, $key, $value);
		}
	}

	private function setParam(PDOStatement $statement, string $paramName, $paramValue){

		$statement->bindParam($paramName, $paramValue);
	}

	public function query(string $rawQuery, array $params): PDOStatement{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt;
	}

	public function select(string $rawQuery, array $params = []): array{
		$stmt = $this->query($rawQuery, $params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>