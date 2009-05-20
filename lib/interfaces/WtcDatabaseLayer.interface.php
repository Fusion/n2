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
## ***************** DATABASE LAYER ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


interface WtcDatabaseLayer {
	public function __construct($username, $password, $host = 'localhost', $debug = false);
	
	public function __destruct();

	public function query($string);

	public function unbuffered($string);

	public function fetchArray($source = null);

	public function firstResult($string);

	public function numRows($source = null);

	public function affectedRows($source = null);
	
	public function getTables();

	public function lastInsertId();

	public function escapeString($string);

	public function selectDB($dbname);

	public function err($source = null);
	
	public function massInsert($arr);
	
	public function massUpdate($arr);
	
	/* Accessors */
	public function getQueryCount();
	
	public function getCurr();

	/* Debugging */
	public function printCurr($string);
}

?>