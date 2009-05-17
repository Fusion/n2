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