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
## ********** CRON - READ INDICATOR CLEANUP ********* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// don't have access to database?
if(!isset($wtcDB)) {
	exit;
}

// make timeout be seconds
$bboptions['readTimeout'] = NOW - ($bboptions['readTimeout'] * 86400);

// just delete from read_forums and read_threads
// where older than specified time
new Query($query['read_forums']['delete_time'], Array(1 => $bboptions['readTimeout']));
new Query($query['read_threads']['delete_time'], Array(1 => $bboptions['readTimeout']));


?>