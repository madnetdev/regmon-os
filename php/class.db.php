<?php // class db 

/**
 * Abstract database wrapper
 * Interact with databases with one line of code
 */
abstract class db {
	/**
	 * Stores the database name
	 * @var mixed
	 */
	protected $database;
	/**
	 * Stores the database connection
	 * @var mixed
	 */
	protected $connection;
	/**
	 * Stores the last query
	 * @var string
	 */
	protected $query;
	/**
	 * Stores the last query result
	 * @var bool|mysqli_result
	 */
	protected $result;
	/**
	 * Stores the last Error
	 * @var mixed
	 */
	public $myError;
	/**
	 * Stores the logFile filename
	 * @var string
	 */
	protected $logFile;
	/**
	 * Log_Slow_DB_Query_Seconds is the time after which the query will logged as slow
	 * @var mixed
	 */
	protected $Log_Slow_DB_Query_Seconds = false;
	/**
	 * Enable/Disable the addition of Quotes when we prepare the query
	 * @var bool
	 */
	protected $addQuotes = true;
	/**
	 * Enable/Disable the filtering of Invalid Fields (fields not exist in DB)
	 * @var bool
	 */
	public $filterInvalidFields = true;
	/**
	 * Stores the DB schema
	 * @var array|null
	 */
	protected $schema = array();
	/**
	 * Stores the last created instance
	 * @var mixed
	 */
	public static $instance;

	/**
	 * abstract functions 
	 * 
	 * implement these methods when creating driver subclasses
	 * need to add _open() to the mix somehow
	 *  
	 */

	 /**
	 * abstract function beginTransaction - Starts a transaction
	 * @return void
	 */
	public abstract function beginTransaction();
	/**
	 * abstract function commitTransaction - Commits the current transaction
	 * @return void
	 */
	public abstract function commitTransaction();
	/**
	 * abstract function rollbackTransaction - Rolls back current transaction
	 * @return void
	 */
	public abstract function rollbackTransaction();
	/**
	 * abstract function _query
	 * @param mixed $sql
	 * @param mixed $buffered
	 * @return bool|mysqli_result
	 */
	protected abstract function _query($sql, $buffered = true);
	/**
	 * abstract function _fetchRow
	 * @return array|bool|null
	 */
	protected abstract function _fetchRow();
	/**
	 * abstract function _fetch
	 * @return array
	 */
	protected abstract function _fetch();
	/**
	 * abstract function _fetchAll
	 * @return array
	 */
	protected abstract function _fetchAll();
	/**
	 * abstract function _fetchAllwithKey
	 * @param mixed $key
	 * @return array<array>
	 */
	protected abstract function _fetchAllwithKey($key);
	/**
	 * abstract function _fetchAllwithKey2
	 * @param mixed $key
	 * @param mixed $key2
	 * @return array<array>
	 */
	protected abstract function _fetchAllwithKey2($key, $key2);
	/**
	 * abstract function _fetchAllwithKey3
	 * @param mixed $key
	 * @param mixed $key2
	 * @param mixed $key3
	 * @return array<array>
	 */
	protected abstract function _fetchAllwithKey3($key, $key2, $key3);
	/**
	 * abstract function close
	 * @return void
	 */
	public abstract function close();
	/**
	 * abstract function _error
	 * @return string
	 */
	protected abstract function _error();
	/**
	 * abstract function _numberRows - Gets the number of rows in the result set
	 * @return bool|int|string
	 */
	protected abstract function _numberRows();
	/**
	 * abstract function _affectedRows
	 * @return int|string
	 */
	protected abstract function _affectedRows();
	/**
	 * abstract function _lastID
	 * @return int|string
	 */
	protected abstract function _lastID();
	/**
	 * abstract function _free_result
	 * @return void
	 */
	protected abstract function _free_result();
	/**
	 * abstract function _escapeString
	 * @param mixed $string
	 * @return string
	 */
	protected abstract function _escapeString($string);
	/**
	 * abstract function _fields
	 * @param mixed $table
	 * @return array<array>
	 */
	protected abstract function _fields($table);
	/**
	 * abstract function _quoteField
	 * @param mixed $field
	 * @return void
	 */
	protected abstract function _quoteField($field);
	/**
	 * abstract function _quoteFields
	 * @param mixed $fields
	 * @return array
	 */
	protected abstract function _quoteFields($fields);

	/**
	 * Class init method
	 * @param mixed $handle
	 */
	public function __construct($handle = null) {
		$this->connection = $handle;
		$this->query = null;
		$this->result = null;
		$this->logFile = null;
		$this->schema = null;
		db::$instance = $this;
	}

	/**
	 * __destruct
	 * Close log file
	 * @return void
	 */
	public function __destruct() {
		if($this->logFile) {
			fclose($this->logFile);
		}
	}
	
	/**
	 * logToFile - Open log file for append
	 * @param mixed $file
	 * @param mixed $method
	 * @return void
	 */
	public function logToFile($file, $method = 'a+') {
		$this->logFile = fopen($file, $method);
	}

	/**
	 * Open a Conection with the Database
	 * @param mixed $type
	 * @param mixed $database
	 * @param mixed $user
	 * @param mixed $password
	 * @param mixed $host
	 * @return mixed
	 */
	public static function open($type, $database, $user = '', $password = '', $host = 'localhost', $Log_Slow_DB_Query_Seconds = false) {
		$db = false;
		switch($type) {
			//case 'mysql':
			case 'mysqli':
				$name = 'db_' . $type;
				if(is_resource($database)) {
					$db = new $name($database);
				}
				if(is_string($database)) {
					$db = new $name();
					$db->_open($database, $user, $password, $host, $Log_Slow_DB_Query_Seconds);
				}
				break;
		}
		return $db;
	}

	/**
	 * execute - Performs a query using the given string
	 * Used by the other _query functions.
	 * @param mixed $sql
	 * @param mixed $parameters
	 * @param mixed $buffered
	 * @return bool
	 */
	public function execute($sql, $parameters = array(), $buffered = true) {
		$time_start = microtime(true);

		$fullSql = $this->makeQuery($sql, $parameters);
		$this->query = $sql;
		$this->result = $this->_query($fullSql, $buffered); // sets $this->result

		$time_end = microtime(true);
		$seconds = number_format($time_end - $time_start, 8);
		//if slow (more than 10sec) write to error log
		if ($this->Log_Slow_DB_Query_Seconds AND $seconds > $this->Log_Slow_DB_Query_Seconds) {
			error_log(date("Y-m-d H:i:s")."\n".$fullSql."\n***************SLOW***************\n".$seconds." seconds\n\n");
		}
		if ($this->logFile) {
			fwrite($this->logFile, date("Y-m-d H:i:s")."\n".$fullSql."\n".$seconds." seconds\n\n");
		}

		$this->myError = false;
		if (!$this->result && (error_reporting() & 1)) {
			$this->myError = $this->_error(); 
		}

		if ($this->result) {
			return true;
		}
		return false;
	}
	
	/**
	 * insert - Insert data to DB table
	 * 
	 * Passed an array and a table name, it attempts to insert the data into the table.
	 * Returns the insert_id. If insert failed it will return false or the error
	 * 
	 * @param array $data
	 * @param string $table
	 * @return bool|int|string - false|insert_id|error
	 */
	public function insert($data, $table) {
		if (is_string($data) && is_array($table)) {
			error_log(date("Y-m-d H:i:s").'db - Parameters passed to insert() were in reverse order');
		}
		// remove invalid fields
		if ($this->filterInvalidFields) {
			$data = $this->filterFields($data, $table);
		}
			
		// appropriately quote input data
		$sql = 'INSERT INTO ' . $table . ' (' . implode(',', $this->_quoteFields(array_keys($data))) . ') VALUES(' . implode(',', $this->placeHolders($data)) . ')';

		/**
		 * don't wrap single inserts in transactions 
		 * By forcing each insert to be in a transaction, 
		 * the user is denied control over transaction granularity. 
		 * As a side-note, users can now diagnose failed inserts, since the rollback cleared errors.
		 * 
		 * If you have rows that need to be inserted together and are dependent on each other, 
		 * those are the records you wrap in a transaction.
		 */
		// $this->beginTransaction();	
		$this->myError = false;
		if ($this->execute($sql, $data)) {
			$id = $this->_lastID();
			// $this->commitTransaction();
			return $id;
		} else {
			// $this->rollbackTransaction();
			//return false;
			return $this->myError; //false or error
		}
	}

	/**
	 * update - update date to DB table
	 * 
	 * Passed an array, table name, where clause 
	 * and placeholder parameters, it attempts to update a record.
	 * Returns the number of affected rows
	 * 
	 * @param mixed $data
	 * @param mixed $table
	 * @param mixed $where
	 * @param mixed $parameters
	 * @return int|string
	 */
	public function update($data, $table, $where = null, $parameters = array()) {
		if (is_string($data) && is_array($table)) {
			error_log(date("Y-m-d H:i:s").'db - Parameters passed to update() were in reverse order');
		}
		// remove invalid fields
		if ($this->filterInvalidFields) {
			$data = $this->filterFields($data, $table);
		}

		$sql = 'UPDATE ' . $table . ' SET ';
		// merge field placeholders with actual $parameters
		foreach($data as $key => $value) {
			// wrap quotes around keys
			$sql .= $this->_quoteField($key) . '=:' . $key . ',';
		}
		$sql = substr($sql, 0, -1); // strip off last comma

		if ($where) {
			$sql .= ' WHERE ' . $where;
			$data = array_merge($data, $parameters);
		}

		$this->execute($sql, $data);
		return $this->_affectedRows();
	}

	/**
	 * delete - DELETE query
	 * @param mixed $table
	 * @param mixed $where
	 * @param mixed $parameters
	 * @return int|string
	 */
	public function delete($table, $where = null, $parameters = array()) {
		$sql = 'DELETE FROM ' . $table;
		if($where) {
			$sql .= ' WHERE ' . $where;
		}
		$this->execute($sql, $parameters);
		return $this->_affectedRows();
	}

	/**
	 * fetchAll - Fetches all of the rows where each is an associative array.
	 * @param mixed $sql
	 * @param mixed $parameters
	 * @return array
	 */
	public function fetchAll($sql, $parameters = array()) {
		$this->execute($sql, $parameters, false);
		if ($this->result) {
			return $this->_fetchAll();
		}
		return array();
	}
	
	/**
	 * fetchAllwithKey - The same as fetchAll but grouped by key
	 * @param mixed $sql
	 * @param mixed $parameters
	 * @param mixed $key
	 * @return array
	 */
	public function fetchAllwithKey($sql, $parameters = array(), $key = '') {
		$this->execute($sql, $parameters, false);
		if ($this->result) {
			return $this->_fetchAllwithKey($key);
		}
		return array();
	}

	/**
	 * fetchAllwithKey2 - The same as fetchAll but grouped by 2 keys
	 * @param mixed $sql
	 * @param mixed $parameters
	 * @param mixed $key
	 * @param mixed $key2
	 * @return array
	 */
	public function fetchAllwithKey2($sql, $parameters = array(), $key = '', $key2 = '') {
		$this->execute($sql, $parameters, false);
		if ($this->result) {
			return $this->_fetchAllwithKey2($key, $key2);
		}
		return array();
	}

	/**
	 * fetchAllwithKey3 - The same as fetchAll but grouped by 3 keys
	 * @param mixed $sql
	 * @param mixed $parameters
	 * @param mixed $key
	 * @param mixed $key2
	 * @param mixed $key3
	 * @return array
	 */
	public function fetchAllwithKey3($sql, $parameters = array(), $key = '', $key2 = '', $key3 = '') {
		$this->execute($sql, $parameters, false);
		if ($this->result) {
			return $this->_fetchAllwithKey3($key, $key2, $key3);
		}
		return array();
	}

	/**
	 * fetch
	 * This is intended to be the method used for large result sets.
	 * It is intended to return an iterator, and act upon buffered data.
	 * @param mixed $sql
	 * @param mixed $parameters
	 * @return array
	 */
	public function fetch($sql, $parameters = array()) {
		$this->execute($sql, $parameters);
		return $this->_fetch();
	}

	/**
	 * fetchRow - Fetch just 1 row
	 * @param mixed $sql
	 * @param mixed $parameters
	 * @return array
	 */
	public function fetchRow($sql = null, $parameters = array()) {
		if($sql != null) {
			$this->execute($sql, $parameters);
		}
		if($this->result) {
			return $this->_fetchRow();
		}
		return array();
	}

	/**
	 * fetchCell - Fetches the first cell from the first row returned by the query
	 * @param mixed $sql
	 * @param mixed $parameters
	 * @return mixed
	 */
	public function fetchCell($sql, $parameters = array()) {
		if($this->execute($sql, $parameters)) {
			$Row = $this->_fetchRow();
			return array_shift($Row); // shift first field off first row
		}
		return null;
	}

	/**
	 * fetchColumn
	 * This method is quite different from fetchCell(), actually
	 * it fetches one cell from each row and places all the values in 1 array
	 * @param mixed $sql
	 * @param mixed $parameters
	 * @return array
	 */
	public function fetchColumn($sql, $parameters = array()) {
		if($this->execute($sql, $parameters)) {
			$cells = array();
			foreach($this->_fetchAll() as $row) {
				$cells[] = array_shift($row);
			}
			return $cells;
		} else {
			return array();
		}
	}

	/**
	 * makeQuery
	 * This combines a query and parameter array into a final query string for execution
	 * PDO drivers don't need to use this
	 * @param mixed $sql
	 * @param mixed $parameters
	 * @return mixed
	 */
	protected function makeQuery($sql, $parameters) {
		// bypass extra logic if we have no parameters
		if(sizeof($parameters) == 0) {
			return $sql;
		}
		
		$parameters = $this->prepareData($parameters);
		// separate the two types of parameters for easier handling
		$questionParams = array();
		$namedParams = array();
		foreach($parameters as $key => $value) {
			if(is_numeric($key)) {
				$questionParams[] = $value;
			} else {
				$namedParams[ ':' . $key ] = $value;
			}
		}
		// sort namedParams in reverse to stop substring squashing
		krsort($namedParams);
		
		// split on question-mark and named placeholders
		$result = preg_split('/(\?|:[a-zA-Z0-9_-]+)/', $sql, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		
		// every-other item in $result will be the placeholder that was found
		
		$query = '';
		for($i = 0; $i < sizeof($result); $i+=2) {
			$query .= $result[ $i ];
			
			$j = $i+1;
			if (array_key_exists($j, $result)) {
				$test = $result[ $j ];
				if ($test == '?') {
					$query .= array_shift($questionParams);
				}
				else {
					$query .= $namedParams[ $test ]; 
				}
			}
		}
		return $query;
	}

	/**
	 * debugging
	 * Return query and other debugging data if error_reporting to right settings
	 * @return mixed|null
	 */
	private function debugging() {
		if (in_array(error_reporting(), array(E_ALL))) {
			return $this->query;
		}
	}

	/**
	 * numberRows - Returns the number of rows of the last query
	 * @return bool|int|string
	 */
	public function numberRows() {
		return $this->_numberRows();
	}

	/**
	 * free_result - Frees the memory associated with a result
	 * @return void
	 */
	public function free_result() {
		$this->_free_result(); 
	}
	
	/**
	 * filterFields
	 * Used by insert() and update() to filter invalid fields from a data array
	 * @param mixed $data
	 * @param mixed $table
	 * @return mixed
	 */
	private function filterFields($data, $table) {
		$this->buildSchema($table); // builds if not previously built
		$fields = $this->schema[ $table ]['fields'];
		foreach($data as $field => $value) {
			if(!array_key_exists($field, $fields))
				unset($data[ $field ]);
		}
		return $data;
	}
	
	/**
	 * prepareData
	 * This should be protected and overloadable by driver classes
	 * @param mixed $data
	 * @return array
	 */
	private function prepareData($data) {
		$values = array();
		foreach($data as $key => $value) {
			$escape = true;
			// don't quote or esc if value is an array, we treat it as a "decorator" 
			// that tells us not to escape the value contained in the array
			if(is_array($value) && !is_object($value)) {
				$escape = false;
				$value = array_shift($value);
			}
			// it's not right to worry about invalid fields in this method because we may be operating 
			// on fields that are aliases, or part of other tables through joins 
			// if(!in_array($key, $columns)) { continue; } // skip invalid fields
			if ($escape) {
				if ($this->addQuotes) {
					if (is_null($value)) {
						$values[$key] = "NULL";
					}
					else {
						$values[$key] = "'" . $this->_escapeString($value) . "'";
					}
				}
				else {
					$values[$key] = $this->_escapeString($value);
				}
			}
			else {
				$values[$key] = $value;
			}
		}
		return $values;
	}

	/**
	 * placeHolders
	 * Given a data array, this returns an array of placeholders
	 * These may be question marks "?", or ":email" type
	 * @param mixed $values
	 * @return array<string>
	 */
	private function placeHolders($values) {
		$data = array();
		foreach($values as $key => $value) {
			if(is_numeric($key))
				$data[] = '?';
			else
				$data[] = ':' . $key;
		}
		return $data;
	}
	
	
	/**
	 * buildSchema
	 * We build the DB Table Schema so we can use it later to filter the fields
	 * @param mixed $table
	 * @return void
	 */
	public function buildSchema($table) {
		if(isset($this->schema[ $table ]) AND $this->schema[ $table ] != null) {
			return;
		}
		$schema = $this->schema;
		$schema[ $table ] = array(
			'fields' => array(),
			'primaryKey' => null
		);

		$fields = $this->_fields($table);
		$schema[ $table ]['fields'] = $fields;
		foreach($fields as $name => $field) {
			if($field['primaryKey']) {
				$schema[ $table ]['primaryKey'] = $name;
			}
		}
		$this->schema = $schema;
	}
}


/**
 * db_mysqli
 */
class db_mysqli extends db {

	/**
	 * beginTransaction - Starts a transaction
	 * @return void
	 */
	public function beginTransaction() {
		// Turn autocommit off
		mysqli_autocommit($this->connection, false);
	}

	/**
	 * commitTransaction - Commits the current transaction
	 * @return void
	 */
	public function commitTransaction() {
		// Commit transaction
		mysqli_commit($this->connection);
		// Turn autocommit on
		mysqli_autocommit($this->connection, true);
	}

	/**
	 * rollbackTransaction - Rolls back current transaction
	 * @return void
	 */
	public function rollbackTransaction() {
		// Rollback transaction
		mysqli_rollback($this->connection);
		// Turn autocommit on
		mysqli_autocommit($this->connection, true);
	}

	/**
	 * _open - Open a new connection to the MySQL server
	 * aslo set the encoding to UTF8
	 * @param mixed $database
	 * @param mixed $user
	 * @param mixed $password
	 * @param mixed $host
	 * @return bool|mysqli
	 */
	protected function _open($database, $user, $password, $host, $Log_Slow_DB_Query_Seconds) {
		$this->database = $database;
		$this->connection = mysqli_connect($host, $user, $password, $database);
		$this->Log_Slow_DB_Query_Seconds = $Log_Slow_DB_Query_Seconds;
		// Check connection
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			exit();
		}
		if($this->connection) {
			mysqli_query($this->connection, "SET NAMES 'UTF8'");
			return $this->connection;
		}
		else return false;
		
	}


	/**
	 * _query - Performs a query on the database
	 * 	 * @param mixed $sql
	 * @param mixed $buffered
	 * @return bool|mysqli_result
	 */
	protected function _query($sql, $buffered = true) {
		if ($buffered) {
			return mysqli_query($this->connection, $sql);
		}
		// This tries to use unbuffered queries to cut down on execution time and memory usage,
		// but you'll only see a benefit with extremely large result sets.
		return mysqli_query($this->connection, $sql, MYSQLI_USE_RESULT);
	}

	/**
	 * _fetchRow
	 * Fetch the next row of a result set as an associative array
	 * @return array|bool|null
	 */
	protected function _fetchRow() {
		if (!$this->result) {
			$this->_log_error('_fetchRow', $this->_error());
			return false;
		}
		return mysqli_fetch_assoc($this->result);
	}

	/**
	 * _fetch - alias for _fetchAll
	 * @return array
	 */
	protected function _fetch() {
		return $this->_fetchAll();
	}

	/**
	 * _fetchAll - Get all rows
	 * @return array
	 */
	protected function _fetchAll() {
		$data = array();
		if (!$this->result) {
			$this->_log_error('_fetchAll', $this->_error());
			return array();
		}
		else {
			while($row = mysqli_fetch_assoc($this->result)) {
				$data[] = $row;
			}
		}
		return $data;
	}
	
	/**
	 * _fetchAllwithKey
	 * Get all rows in a multidimensional array grouped by $key field
	 * @param mixed $key
	 * @return array
	 */
	protected function _fetchAllwithKey($key='') {
		$data = array();
		if (!$this->result) {
			$this->_log_error('_fetchAllwithKey', $this->_error());
			return array();
		}
		else {
			while($row = mysqli_fetch_assoc($this->result)) {
				$data[$row[$key]] = $row;
			}
		}
		return $data;
	}

	/**
	 * _fetchAllwithKey2
	 * Get all rows in a multidimensional array grouped by $key, $key2 fields
	 * @param mixed $key
	 * @param mixed $key2
	 * @return array<array>
	 */
	protected function _fetchAllwithKey2($key='',$key2='') {
		$data = array();
		if (!$this->result) {
			$this->_log_error('_fetchAllwithKey2', $this->_error());
			return array();
		}
		else {
			while($row = mysqli_fetch_assoc($this->result)) {
				$data[$row[$key]][$row[$key2]] = $row;
			}
		}
		return $data;
	}

	/**
	 * _fetchAllwithKey3
	 * Get all rows in a multidimensional array grouped by $key, $key2, $key3 fields
	 * @param mixed $key
	 * @param mixed $key2
	 * @param mixed $key3
	 * @return array<array>
	 */
	protected function _fetchAllwithKey3($key='',$key2='',$key3='') {
		$data = array();
		if (!$this->result) {
			$this->_log_error('_fetchAllwithKey3', $this->_error());
			return array();
		}
		else {
			while ($row = mysqli_fetch_assoc($this->result)) {
				$data[$row[$key]][$row[$key2]][$row[$key3]] = $row;
			}
		}
		return $data;
	}

	/**
	 * close - Closes a previously opened database connection
	 * @return void
	 */
	public function close() {
		mysqli_close($this->connection);
	}

	/**
	 * _error - Returns a string description of the last error
	 * @return string
	 */
	public function _error() {
		return mysqli_error($this->connection);
	}

	/**
	 * _escapeString - Escapes special characters in a string for use in an SQL statement, 
	 * taking into account the current charset of the connection
	 * @param mixed $string
	 * @return string
	 */
	protected function _escapeString($string) {
		return mysqli_real_escape_string($this->connection, $string);
	}

	/**
	 * _free_result - Frees the memory associated with a result
	 * @return void
	 */
	protected function _free_result() {
		//if ($this->result) { 
		//if (is_resource($this->result)) { 
		if ($this->result instanceof mysqli_result) {
			mysqli_free_result($this->result); 
		} 
		$this->result = 0; 
	}
	
	/**
	 * _numberRows - Gets the number of rows in the result set
	 * @return bool|int|string
	 */
	protected function _numberRows() {
		if (!$this->result) {
			$this->_log_error('_numberRows', $this->_error());
			return false;
		}
		return mysqli_num_rows($this->result);
		/*
		if(mysqli_affected_rows($this->connection)) { // for insert, update, delete
			$this->numberRecords = mysqli_affected_rows($this->connection);
		} elseif(!is_bool($this->result)) { // for selects
			$this->numberRecords = mysqli_num_rows($this->result);
		} else { // will be boolean for create, drop, and other
			$this->numberRecords = 0;
		}
		*/
	}

	/**
	 * _affectedRows - Gets the number of affected rows in a previous MySQL operation
	 * @return int|string
	 */
	protected function _affectedRows() {
		return mysqli_affected_rows($this->connection);
	}

	/**
	 * _lastID - Returns the insert_id
	 * Returns the value generated for an AUTO_INCREMENT column by the last query
	 * @return int|string
	 */
	protected function _lastID() {
		return mysqli_insert_id($this->connection);
	}
	
	/**
	 * _quoteField - Add quotes to a field
	 * @param mixed $field
	 * @return string
	 */
	protected function _quoteField($field) {
		return '`' . $field . '`';
	}

	/**
	 * _quoteFields - Add quotes to an array of fields
	 * @param mixed $fields
	 * @return array
	 */
	protected function _quoteFields($fields) {
		return array_map(array($this, '_quoteField'), $fields);
	}

	/**
	 * _fields - Get the fields of a table
	 * @param mixed $table
	 * @return array<array>
	 */
	protected function _fields($table) {
		$fields = array();
		$this->execute('describe ' . $table, array(), false);
		foreach($this->_fetchAll() as $row) {
			$type = strtolower(preg_replace('/\(.*\)/', '', $row['Type'])); // remove size specifier
			$name = $row['Field'];
			$fields[ $name ] = array('type' => $type, 'primaryKey' => ($row['Key'] == 'PRI'));
		}
		return $fields;
	}
	
	/**
	 * _log_error - Logs the error to the error_log
	 * @return void
	 */
	protected function _log_error($method, $error) {
		error_log('MySQL Error ('.$method.') : ' . $error. ' ... '. $this->query);
	}
}
?>