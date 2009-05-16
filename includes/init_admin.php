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
define('ADMIN', (strpos($_SERVER['PHP_SELF'], 'admin.php') !== false));
define('ADAY', 60 * 60 * 24);
define('AWEEK', ADAY * 7);
define('AMONTH', ADAY * 31);
define('AYEAR', ADAY * 365);
define('FAQ_LANG_CAT', 119);


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


/**
 * Initialize Cache
 */
$dir = new DirectoryIterator('./cache');

foreach($dir as $iter) {
	if($iter->isDot() OR !$iter->isFile() OR !$iter->isReadable()) {
		continue;
	}

	$base = basename($iter->getPathname(), '.cache.php');

	${$base} = Cache::load($base);
}

/**
 * grab options
 */
if(!isset($bboptions)) {
	$getOptions = new Query($query['global']['options']);

	while($option = $wtcDB->fetchArray($getOptions)) {
		$bboptions[$option['name']] = $option['value'];
	}
}


/**
 * Initialize Styles
 */
if(!isset($styles)) {
	$getStyles = new Query($query['styles']['get_all']);
	$styles = Array();
	$orderedStyles = Array();

	while($style = $wtcDB->fetchArray($getStyles)) {
		$styles[$style['styleid']] = new Style('', $style);
		$orderedStyles[$style['parentid']][$style['styleid']] = $style['styleid'];
	}
}

// only ordered?
else if(!isset($orderedStyles)) {
	$orderedStyles = Array();

	foreach($styles as $style) {
		$styles[$style->getStyleId()] = new Style('', $style->getInfo());
		$orderedStyles[$style->getParentId()][$style->getStyleId()] = $style->getStyleId();
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
 * Initialize Moderators
 */
if(!isset($moderators)) {
	$modQ = new Query($query['moderator']['get_all']);
	$moderators = Array();

	while($mod = $wtcDB->fetchArray($modQ)) {
		$moderators[$mod['forumid']][$mod['userid']] = new Moderator('', $mod);
	}
}

// find mods that inherit?
$solidMods = $moderators; // no inherited mods
$moderators = Moderator::getInheritMods($moderators, $solidMods);


/**
 * Initialize Forum Permissions
 */
if(!isset($perms)) {
	$permsQ = new Query($query['perm']['get_all']);
	$perms = Array();

	while($perm = $wtcDB->fetchArray($permsQ)) {
		$perms[$perm['forumid']][$perm['usergroupid']] = new ForumPerm('', $perm);
	}
}

// get inherited forum perms...
$solidPerms = $perms; // no inherited perms
$perms = ForumPerm::getInheritPerms($perms);


/**
 * Initialize Usergroups
 */
if(!isset($groups)) {
	$usergroups = new Query($query['usergroups']['get_groups']);

	while($group = $wtcDB->fetchArray($usergroups)) {
		$groups[$group['usergroupid']] = new Usergroup('', $group);
	}
}


/**
 * Initialize Crons
 */
if(!isset($crons)) {
	$cronsQ = new Query($query['cron']['get_all']);

	while($cron = $wtcDB->fetchArray($cronsQ)) {
		$crons[$cron['cronid']] = new Cron('', $cron);
	}
}

if(!isset($avatars)) {
	Avatar::init();
}

if(!isset($smilies)) {
	$smilies = Smiley::init();
}

if(!isset($posticons)) {
	PostIcon::init();
}

if(!isset($profs)) {
	CustomPro::init();
}

if(!isset($generalGroups)) {
	Group::init();
}

?>