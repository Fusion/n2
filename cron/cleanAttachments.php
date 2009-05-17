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