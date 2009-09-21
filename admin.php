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
## **************** ADMIN ACCESS AREA *************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

// uh oh!
if(file_exists('./install.php')) {
	exit('Please remove the install.php file from your web server!');
}

// Require Files
require_once('./includes/init_admin.php');

if(isset($_GET['file'])) {
	require_once(ADMIN_DIR . '/' . $_GET['file'] . '.php');
}

else {
	// Do CONSTANTS
	define('AREA', 'ADMIN-INDEX');

	require_once('./includes/global_admin.php');

	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
	<head>
		<title> <?php print($lang['admin_title']); ?> </title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	</head>

	<frameset cols="220px,*">
		<frame src="admin.php?file=navigation" name="nav" frameborder="no" scrolling="no" noresize marginwidth="0" marginheight="0" />
		<frame src="admin.php?file=main" name="content" frameborder="no" scrolling="no" noresize marginwidth="0" marginheight="0" />
	</frameset>

	<body>
	</body>
	</html>

	<?php

}

Cron::execNextCron();

?>
