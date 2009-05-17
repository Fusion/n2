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