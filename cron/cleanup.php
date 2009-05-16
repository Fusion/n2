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
## *************** CRON - DAILY CLEANUP ************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// don't have access to database?
if(!isset($wtcDB)) {
	exit;
}

// get the tables...
$tablesQ = $wtcDB->getTables();

// form query...
$optimize = 'OPTIMIZE TABLE ';
$tables = Array();

while($table = $wtcDB->fetchArray($tablesQ, 'num')) {
	$tables[] = $table[0];
}

$optimize .= implode(', ', $tables);

new Query($optimize);

// form results...
$logtext = $lang['admin_cron_log_optimized'] . ': ' . implode(', ', $tables);


?>