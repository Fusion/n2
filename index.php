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
## **************** USER ACCESS AREA **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

// uh oh!
if(file_exists('./install.php')) {
	exit('Please remove the install.php file from your web server!');
}

// Require Files
require_once('./includes/init.php');
require_once('./includes/global.php');

// file not set?
if(!isset($_GET['file']) OR !file_exists(USER_DIR . '/' . $_GET['file'] . '.php')) {
	$_GET['file'] = 'boardIndex';
}

// require the user file
require_once(USER_DIR . '/' . $_GET['file'] . '.php');

// execute the next cron
Cron::execNextCron();

?>