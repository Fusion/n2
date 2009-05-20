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
## ******************* GLOBAL INIT ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


/**
 * First thing... start execution time...
 */
$startTime = microtime();

/**
 * Constant time throughout script... in case it drags
 */
define('NOW', time());

/**
 * Attempt to disable magic_quotes
 */
set_magic_quotes_runtime(0);

/**
 * Set error reporting
 */
error_reporting(E_ALL ^ E_NOTICE);

/**
 * Require Necessary Files
 */
require_once('./includes/config.php');
require_once('./includes/classPath.lib.php');
require_once('./includes/functions.php');

// CONSTANTS \\
define('WTC_TP', $tablePrefix);
define('WTC_COOKIE_PREFIX', $cookiePrefix);
define('CWD', getcwd());
define('DB_ENGINE', $dbType); unset($dbType);
define('ADMIN_DIR', './admin');
define('USER_DIR', './user');
define('ADMIN', (strpos($_SERVER['PHP_SELF'], 'admin.php') !== false));
define('ADAY', 60 * 60 * 24);
define('AWEEK', ADAY * 7);
define('AMONTH', ADAY * 31);
define('AYEAR', ADAY * 365);
define('FAQ_LANG_CAT', 119);
define('DEV', false);


/**
 * Surpress XSS in _SERVER
 */
$_SERVER = array_map_recursive('wtcspecialchars', $_SERVER);

/**
 * From php.net: get rid of the evil assumptions of magic_quotes_gpc()
 * Note: this only fixes values, not keys.
 */
if (get_magic_quotes_gpc())
{
	function stripslashes_deep($value)
	{
		$value = is_array($value) ?
			array_map('stripslashes_deep', $value) :
			stripslashes($value);
		
		return $value;
	}

	$_POST    = array_map('stripslashes_deep', $_POST);
	$_GET     = array_map('stripslashes_deep', $_GET);
	$_COOKIE  = array_map('stripslashes_deep', $_COOKIE);
	$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

/**
 * Get DBA class
 */
getDBAClass();


/**
 * Connect and select database
 */
if(strtolower(DB_ENGINE) == 'mysql') {
	require_once('./sql/MySQL/sql.lib.php');

	$wtcDB = new WtcDBA($username, $password, $host);
	unset($username, $password, $host, $tablePrefix, $cookiePrefix);

	$wtcDB->selectDB($database);
}

else if(strtolower(DB_ENGINE) == 'mysqli') {
	require_once('./sql/MySQLi/sql.lib.php');

	$wtcDB = new WtcDBA($username, $password, $host);
	unset($username, $password, $host, $tablePrefix, $cookiePrefix);

	$wtcDB->selectDB($database);
}

else if(strtolower(DB_ENGINE) == 'sqlite') {
	require_once('./sql/SQLite/sql.lib.php');

	$wtcDB = new WtcDBA($sqlitePath);
	unset($sqlitePath);

	// must get rid of the 'tableName.fieldName' format
	// for results sets from join queries (changed format to 'fieldName')
	new Query('PRAGMA short_column_names = ON');
}


/**
 * grab options
 */
if(!($bboptions = Cache::load('bboptions'))) {
	$getOptions = new Query($query['global']['options']);

	while($option = $wtcDB->fetchArray($getOptions)) {
		$bboptions[$option['name']] = $option['value'];
	}
}


/**
 * Initialize Styles
 */
if(!($styles = Cache::load('styles'))) {
	$getStyles = new Query($query['styles']['get_all']);
	$styles = Array();

	while($style = $wtcDB->fetchArray($getStyles)) {
		$styles[$style['styleid']] = new Style('', $style);
	}
}

/**
 * Initialize Languages
 */
if(!($langs = Cache::load('langs'))) {
	$getLangs = new Query($query['admin']['get_langs']);
	$langs = Array();

	while($lang = $wtcDB->fetchArray($getLangs)) {
		$langs[$lang['langid']] = new Language('', $lang);
	}
}

/**
 * Initialize Usergroups
 */
if(!($groups = Cache::load('groups'))) {
	$usergroups = new Query($query['usergroups']['get_groups']);

	while($group = $wtcDB->fetchArray($usergroups)) {
		$groups[$group['usergroupid']] = new Usergroup('', $group);
	}
}


/**
 * Initialize Crons
 */
if(!($crons = Cache::load('crons'))) {
	$cronsQ = new Query($query['cron']['get_all']);

	while($cron = $wtcDB->fetchArray($cronsQ)) {
		$crons[$cron['cronid']] = new Cron('', $cron);
	}
}

?>