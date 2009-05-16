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
## ****************** CRON - TIMEOUT **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

// This cron exists to wipe out records from sessions table
// that exceed the imout

// don't have access to database?
if(!isset($wtcDB)) {
	exit;
}

// only need to run one query...
new Query($query['sessions']['delete'], Array(1 => (NOW - $bboptions['cookTimeout'])));

?>