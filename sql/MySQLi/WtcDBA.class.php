<?php
/*
 * "n2" - Forum Software - a nBBS v0.6 + wtcBB remix.
 * Copyright (C) 2009 Chris F. Ravenscroft
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 * 
 * Questions? We can be reached at http://www.nextbbs.com
 */
// ************************************************** \\
## ************************************************** ##
## ************************************************** ##
## ******************* MySQLi DBA ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class WtcDBA implements WtcDatabaseLayer {
	private $queryCount, $conn, $curr, $debug, $resultTypes, $debugger;

	public function __construct($username, $password, $host = 'localhost', $debug = false) {
		$this->conn = mysqli_connect($host, $username, $password);
		$this->queryCount = 0;
		$this->debug = $debug;
		$this->debugger = '';
		$this->resultTypes = Array(
								'both' => MYSQLI_BOTH,
								'assoc' => MYSQLI_ASSOC,
								'num' => MYSQLI_NUM
							);

		if(!$this->conn) {
			exit('Could not connect to MySQL: ' . mysqli_connect_error());
		}
	}

	// there seemed to be problems with apache crashing on Windows when
	// using the "register_shutdown_function" to run the cron
	public function __destruct() {
		@mysqli_close($this->conn);

		if(!empty($this->debugger)) {
			print($this->debugger);
		}
	}

	public function query($string, $die = true) {
		if(!($this->curr = mysqli_query($this->conn, $string))) {
			if($die) {
				die($this->err() . '<br /><br /><strong>Query:</strong> ' . $string . '<br /><br />');
			}

			else {
				print($this->err() . '<br /><br /><strong>Query:</strong> ' . $string . '<br /><br />');
			}
		}

		$this->queryCount++;

		if($this->debug) {
			$this->printCurr($string);
		}

		return $this->curr;
	}

	public function unbuffered($string) {
		return $this->query($string);
	}

	public function fetchArray($source = null, $resultType = 'assoc') {
		if(!$source) {
			return mysqli_fetch_array($this->curr, $this->resultTypes[$resultType]);
		}

		else {
			return mysqli_fetch_array((($source instanceof Query) ? $source->getRes() : $source), $this->resultTypes[$resultType]);
		}
	}

	public function firstResult($string) {
		$this->curr = $this->query($string);

		return $this->fetchArray();
	}

	public function numRows($source = null) {
		if(!$source) {
			return mysqli_num_rows($this->curr);
		}

		else {
			return mysqli_num_rows($source->getRes());
		}
	}

	public function affectedRows($source = null) {
		if(!$source) {
			return mysqli_affected_rows($this->curr);
		}

		else {
			return mysqli_affected_rows($source->getRes());
		}
	}

	public function getTables() {
		return new Query('SHOW TABLES');
	}

	public function lastInsertId() {
		return mysqli_insert_id($this->conn);
	}

	// 051709: we are now getting rid of magic_quotes_gpc's evilness
	// in includes/init.php therefore we will always escape strings...
	public function escapeString($string, $escape = false) {
		return $this->doEscaping($string);
	}

	public function doEscaping($string) {
		return mysqli_real_escape_string($this->conn, $string);
	}

	public function selectDB($dbname) {
		$test = mysqli_select_db($this->conn, $dbname);

		if(!$test) {
			exit('Could not select database "' . $dbname . '": ' . $this->err());
		}

		return $test;
	}

	public function err($source = null) {
		return mysqli_error($this->conn);
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

		ob_start();
		_DEBUG($string . ' - Time: ' . pageLoadTime());
		$this->debugger .= ob_get_contents();
		ob_end_clean();
	}
}

?>