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