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
## **************** USER ACCESS AREA **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

// uh oh!
if(file_exists('./install.php')) {
	exit('I found an existing <span style="color:red;font-weight:bold;">install.php</span> file.<br />If this is an omission, then please remove the file from your web server.<br />If you wish to perform a fresh install, <a href="install.php">run it</a>.');
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
