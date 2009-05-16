<?php
/*
 * wtcBB Community Software (Open Source Freeware Version)
 * Copyright (C) 2004-2007. All Rights Reserved. wtcBB Software Solutions.
 * http://www.wtcbb.com
 *
 * Licensed under the terms of the GNU Lesser General Public License:
 * http://www.wtcbb.com/wtcbb-license-general-public-license 
 *
 * For support visit: http://forums.wtcbb.com
 *
 * Powered by wtcBB - http://www.wtcbb.com
 * Protected by ChargebackFile - http://www.chargebackfile.com
 * 
 */
// ************************************************** \\
## ************************************************** ##
## ************************************************** ##
## ******************** MySQL DBA ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class WtcDBA implements WtcDatabaseLayer {
	private $queryCount, $conn, $curr, $debug, $resultTypes;

	public function __construct($username, $password, $host = 'localhost', $debug = false) {
		$this->conn = mysql_connect($host, $username, $password);
		$this->queryCount = 0;
		$this->debug = $debug;
		$this->debugger = '';
		$this->resultTypes = Array(
								'both' => MYSQL_BOTH,
								'assoc' => MYSQL_ASSOC,
								'num' => MYSQL_NUM
							);

		if(!$this->conn) {
			exit('Could not connect to MySQL: ' . $this->err());
		}
	}

	// there seemed to be problems with apache crashing on Windows when
	// using the "register_shutdown_function" to run the cron
	public function __destruct() {
		@mysql_close($this->conn);

		if(!empty($this->debugger)) {
			print($this->debugger);
		}
	}

	public function query($string, $die = true) {
		if(!($this->curr = mysql_query($string, $this->conn))) {
			if($die) {
				die(mysql_error() . '<br /><br /><strong>Query:</strong> ' . $string . '<br /><br />');
			}

			else {
				print(mysql_error() . '<br /><br /><strong>Query:</strong> ' . $string . '<br /><br />');
			}
		}

		$this->queryCount++;

		if($this->debug) {
			$this->printCurr($string);
		}

		return $this->curr;
	}

	public function unbuffered($string) {
		$this->curr = mysql_unbuffered_query($string, $this->conn) OR die(mysql_error());
		$this->queryCount++;

		if($this->debug) {
			$this->printCurr($string);
		}

		return $this->curr;
	}

	public function fetchArray($source = null, $resultType = 'assoc') {
		if(!$source) {
			return mysql_fetch_array($this->curr, $this->resultTypes[$resultType]);
		}

		else {
			return mysql_fetch_array((($source instanceof Query) ? $source->getRes() : $source), $this->resultTypes[$resultType]);
		}
	}

	public function firstResult($string) {
		$this->curr = $this->query($string);

		return $this->fetchArray();
	}

	public function numRows($source = null) {
		if(!$source) {
			return mysql_num_rows($this->curr);
		}

		else {
			return mysql_num_rows($source->getRes());
		}
	}

	public function affectedRows($source = null) {
		if(!$source) {
			return mysql_affected_rows($this->curr);
		}

		else {
			return mysql_affected_rows($source->getRes());
		}
	}

	public function getTables() {
		return $this->query('SHOW TABLES');
	}

	public function lastInsertId() {
		return mysql_insert_id($this->conn);
	}

	public function escapeString($string, $escape = false) {
		if($escape OR !get_magic_quotes_gpc() OR (get_magic_quotes_gpc() AND ini_get('magic_quotes_sybase'))) {
			return $this->doEscaping($string);
		}

		return $string;
	}

	public function doEscaping($string) {
		return mysql_real_escape_string($string, $this->conn);
	}

	public function selectDB($dbname) {
		$test = mysql_select_db($dbname, $this->conn);

		if(!$test) {
			exit('Could not select database "' . $dbname . '": ' . $this->err());
		}

		return $test;
	}

	public function err($source = null) {
		return mysql_error();
	}

	// The mass insert and update methods are used
	// when we update tables with a massive amount
	// of fields... dynamically creating these SQL
	// statements is much easier... same with selecting
	public function massInsert($arr, $escape = false) {
		if(!is_array($arr)) {
			return false;
		}

		$fieldStr = '';
		$valueStr = '';

		foreach($arr as $field => $v) {
			$fieldStr .= $field . ', ';
			$valueStr .= '"' . $this->escapeString($v, $escape) . '", ';
		}

		// remove ending stuff
		$fieldStr = preg_replace('/,\s$/', '', $fieldStr);
		$valueStr = preg_replace('/,\s$/', '', $valueStr);

		return Array(
					'fields' => $fieldStr,
					'values' => $valueStr
				);
	}

	public function massUpdate($arr, $escape = false) {
		if(!is_array($arr)) {
			return false;
		}

		// form query...
		$update = '';

		foreach($arr as $field => $v) {
			$update .= ' ' . $field . ' = "' . $this->escapeString($v, $escape) . '" ,';
		}

		// remove last comma
		return preg_replace('/,$/', '', $update);
	}

	/* Accessors */
	public function getQueryCount() {
		return $this->queryCount;
	}

	public function getConn() {
		return $this->conn;
	}

	public function getCurr() {
		return $this->curr;
	}

	/* Debugging */
	public function printCurr($string) {
		global $startTime;

		_DEBUG($string . ' - Time: ' . pageLoadTime());
	}
}

?>