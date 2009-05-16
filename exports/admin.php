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

	<frameset cols="220px,*" border="1" frameborder="1" framespacing="0">
		<frame src="admin.php?file=navigation" name="nav" style="border-right: 1px solid #000; cursor: w-resize;" frameborder="0" />
		<frame src="admin.php?file=main" name="content" frameborder="0" />
	</frameset>

	<body>
	</body>
	</html>

	<?php

}

Cron::execNextCron();

?>