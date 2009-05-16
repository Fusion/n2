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
## ***************** QUERY FORMATION **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Query {
	private $sql, $addins, $sqlArray, $finalSql, $res, $addslashes, $die;

	// constructor, intialize query SQL
	// possibly put in vars
	// possibly exectute
	public function __construct($query, $vars = '', $execute = 'query', $slashes = true, $die = true) {
		$this->sql = $query;
		$this->addins = $vars;
		$this->sqlArray = preg_split('/\?/isU', $this->sql);
		$this->finalSql = '';
		$this->res = '';
		$this->die = $die;
		$this->addslashes = $slashes;

		if(is_array($this->addins)) {
			foreach($this->addins as $count => $v) {
				if(is_numeric($v)) {
					$this->setNum($v, $count);
				}

				else {
					$this->setString($v, $count);
				}
			}
		}

		if($execute) {
			$this->execute($execute);
		}
	}

	// Public Methods
	public function setNum($value, $which) {
		global $wtcDB;

		$index = $which - 1;
		$this->finalSql .= $this->sqlArray[$index] . (($this->addslashes) ? $wtcDB->escapeString($value) : $value);
	}

	public function setString($value, $which) {
		global $wtcDB;

		$index = $which - 1;
		$this->finalSql .= $this->sqlArray[$index] . (($this->addslashes) ? $wtcDB->escapeString($value) : $value);
	}

	public function execute($type = 'query') {
		global $wtcDB;

		// add in the rest!
		$this->finalizeSql();

		switch($type) {
			case 'query':
				$this->res = $wtcDB->query($this->finalSql, $this->die);
			break;

			case 'unbuffered':
				$this->res = $wtcDB->query($this->finalSql, $this->die);
			break;

			default:
				$this->res = $wtcDB->query($this->finalSql, $this->die);
			break;
		}

		return $this->res;
	}

	// Private Methods
	private function finalizeSql() {
		$lastIndex = count($this->sqlArray) - 1;

		// no addins... o_0
		if(!$lastIndex) {
			$this->finalSql = $this->sqlArray[$lastIndex];
			return;
		}

		$this->finalSql .= $this->sqlArray[$lastIndex];
	}

	// Accessors
	public function getSql() {
		return $this->sql;
	}

	public function getAddins() {
		return $this->addins;
	}

	public function getRes() {
		return $this->res;
	}

	public function getFinalSql() {
		return $this->finalSql;
	}

	public function numRows() {
		global $wtcDB;

		return $wtcDB->numRows($this);
	}

	public function fetchArray() {
		global $wtcDB;

		if(!$this->numRows()) {
			return false;
		}

		return $wtcDB->fetchArray($this);
	}
}

?>