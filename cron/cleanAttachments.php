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

// This cron will delete attachment files that don't have links
// do the database

// don't have access to database?
if(!isset($wtcDB)) {
	exit;
}

// form all attachments in array by path name
$getAll = new Query($query['attachments']['get_all']);
$attachs = Array();

while($attach = $getAll->fetchArray()) {
	$attachs[basename($attach['pathName'])] = $attach['attachid'];
}

// dir iterator on attach directory
$dirIter = new DirectoryIterator('./attach/');

foreach($dirIter as $file) {
	$base = basename($dirIter->getFilename());

	// weird...
	if(!preg_match('/\.attach$/', $base)) {
		continue;
	}

	// not in DB?
	if(!isset($attachs[$base])) {
		@unlink($dirIter->getPathname());
	}
}

?>