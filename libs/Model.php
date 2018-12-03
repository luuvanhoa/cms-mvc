<?php
class Model{
	protected $connect;
	protected $database;
	protected $table;
	protected $resultQuery;
	
	// CONNECT DATABASE
	public function __construct($params = null){
		if($params == null){
			$params['server']	= DB_HOST;
			$params['username']	= DB_USER;
			$params['password']	= DB_PASS;
			$params['database']	= DB_NAME;
			$params['table']	= DB_TABLE;
		} 

		$dsn = 'mysql:host='.$params['server'].';dbname='.$params['database'];
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);
		try {
			$this->connect = new PDO($dsn, $params['username'], $params['password'], $options);
		}catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}
	
	// SET CONNECT
	public function setConnect($connect){
		$this->connect = $connect;
	}
	
	// DISCONNECT DATABASE
	public function __destruct(){
		$this->connect = null;
	}

	// SET TABLE
	public function setTable($table){
		$this->table = $table;
	}

	// EXECUTE QUERY
    public function execute($sql)
    {

        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
	
	// INSERT
	public function insert($data, $type = 'single', $table = null){
		if($type == 'single'){
			$newQuery 	= $this->createInsertSQL($data);
			$table 		= !empty($table) ? $table : $this->table; 
			$query 		= "INSERT INTO `$table`(".$newQuery['cols'].") VALUES (".$newQuery['vals'].")";
			$this->execute($query);
		}else{
			foreach($data as $value){
				$table 		= !empty($table) ? $table : $this->table; 
				$newQuery 	= $this->createInsertSQL($value);
				$query 		= "INSERT INTO `$table`(".$newQuery['cols'].") VALUES (".$newQuery['vals'].")";
				$this->execute($query);
			}
		}
		return $this->lastID();
	}
	
	// CREATE INSERT SQL
	public function createInsertSQL($data){
		$newQuery = array();
		$cols = '';
		$vals = '';
		if(!empty($data)){
			foreach($data as $key=> $value){
				$cols .= ", `$key`";
				$vals .= ", '$value'";
			}
		}
		$newQuery['cols'] = substr($cols, 2);
		$newQuery['vals'] = substr($vals, 2);
		return $newQuery;
	}
	
	// LAST ID
	public function lastID(){
		return $this->connect->lastInsertId();
	}
	
	// UPDATE
	public function update($data, $where, $table = null){
		$newSet 	= $this->createUpdateSQL($data);
		$newWhere 	= $this->createWhereUpdateSQL($where);
		$table 		= !empty($table) ? $table : $this->table;
		$query = "UPDATE `$table` SET " . $newSet . " WHERE $newWhere";
		$this->execute($query);
	}
	
	// CREATE UPDATE SQL
	public function createUpdateSQL($data){
		$newQuery = "";
		if(!empty($data)){
			foreach($data as $key => $value){
				$newQuery .= ", `$key` = '$value'";
			}
		}
		$newQuery = substr($newQuery, 2);
		return $newQuery;
	}
	
	// CREATE WHERE UPDATE SQL
	public function createWhereUpdateSQL($data){
		$newWhere = array();
		if(!empty($data)){
			foreach($data as $value){
				$newWhere = array("`$value[0]` = '$value[1]'", @$value[2]);
				/*$newWhere[] = "`$value[0]` = '$value[1]'";
				$newWhere[] = @$value[2];*/
			}
			$newWhere = implode(" ", $newWhere);
		}
		return $newWhere;
	}
	
	
	// DELETE
	public function delete($where, $table = null){
		$newWhere 	= $this->createWhereDeleteSQL($where);
		$table 		= !empty($table) ? $table : $this->table;
		$query 		= "DELETE FROM `$table` WHERE `id` IN ($newWhere)";
		$this->execute($query);
	}
	
	// CREATE WHERE DELTE SQL
	public function createWhereDeleteSQL($data){
		$newWhere = '';
		if(!empty($data)){
			foreach($data as $id) {
				$newWhere .= "'" . $id . "', ";
			}
			$newWhere .= "'0'";
		}
		return $newWhere;
	}
	
	// LIST RECORD
	public function fetchAll($query){
		$result = array();
		if(!empty($query)){
			$stmt = $this->connect->prepare($query);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $result;
	}

	// LIST RECORD
	public function fetchPairs($query){
		$result = array();
		if(!empty($query)){
			$resultQuery = $this->execute($query);
			if($resultQuery->rowCount() > 0){				
				while($row = $resultQuery->fetch(PDO::FETCH_ASSOC)){
					$result[$row['id']] = $row['name'];
				}
			}
		}
		return $result;
	}
	
	// SINGLE RECORD
	public function fetchRow($query){
		$result = array();
		if(!empty($query)){
			$stmt = $this->connect->prepare($query);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		return $result;
	}
	
	// EXIST
	public function isExist($query){
		if($query != null) {
			$stmt = $this->connect->prepare($query);
			$stmt->execute();
			$this->resultQuery = $stmt->rowCount();
		}
		if($this->resultQuery > 0) return true;
		return false;
	}
}