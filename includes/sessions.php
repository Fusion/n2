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
## ******************** SESSIONS ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


/**
 * Make sure we aren't caching...
 */
header('Expires: Sun, 05 Jul 1987 22:45:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');


/**
 * Create a SESSION ID
 */
$SESSURL = '';

if(!Cookie::get('SID')) {
	if(!isset($_REQUEST['session'])) {
		// if user, base SID on static info
		if($User->info['userid']) {
			define('SID', md5($User->info['userid'] . $User->info['username'] . $User->info['passTime'] . $User->info['salt']));
		}

		// guest- use client info
		else {
			define('SID', md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']));
		}

		new Cookie('SID', SID, 0);

		if(strpos($_SERVER['REQUEST_URI'], '?') === false) {
			$newUrl = $_SERVER['REQUEST_URI'] . '?session=' . SID;
		}

		else {
			$newUrl = $_SERVER['REQUEST_URI'] . '&session=' . SID;
		}

		// we should never be unidentified...
		// only redirect if guest or cookies are disabled
		if(!Cookie::get('userid')) {
			new Redirect($newUrl);
		}
	}

	else {
		// whoa whoa whoa... whoa...
		if(LOGIN AND $_REQUEST['session'] != md5($User->info['userid'] . $User->info['username'] . $User->info['passTime'] . $User->info['salt'])) {
			// wipe out past sessions first...
			new Query($query['sessions']['delete_byId'], Array(1 => $_REQUEST['session']));

			$_REQUEST['session'] = md5($User->info['userid'] . $User->info['username'] . $User->info['passTime'] . $User->info['salt']);
		}

		else if(!LOGIN AND $_REQUEST['session'] != md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'])) {
			// wipe out past sessions first...
			new Query($query['sessions']['delete_byId'], Array(1 => $_REQUEST['session']));

			$_REQUEST['session'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
		}

		define('SID', $_REQUEST['session']);
		$SESSURL = '&amp;session=' . SID;

		// still try to set a cookie...
		new Cookie('SID', SID, 0);
	}
}

else {
	// what if the cookie isn't what it's supposed to be? o_0
	$maybeSID = Cookie::get('SID');

	// naughty naughty
	if(LOGIN AND $maybeSID != md5($User->info['userid'] . $User->info['username'] . $User->info['passTime'] . $User->info['salt'])) {
		// wipe out past sessions first...
		new Query($query['sessions']['delete_byId'], Array(1 => $maybeSID));

		// assign new ID
		$maybeSID = md5($User->info['userid'] . $User->info['username'] . $User->info['passTime'] . $User->info['salt']);

		new Cookie('SID', $maybeSID, 0);
	}

	// tsk tsk
	else if(!LOGIN AND $maybeSID != md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'])) {
		// wipe out past sessions first...
		new Query($query['sessions']['delete_byId'], Array(1 => $maybeSID));

		$maybeSID = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
		new Cookie('SID', $maybeSID, 0);
	}

	define('SID', $maybeSID);
}


/**
 * Put into sessions table
 */

// first get our location/details
// convert AREA to lang var
$langVar = strtolower(str_replace('-', '_', AREA));
$location = stripSessionId($_SERVER['REQUEST_URI']); // prevent session hijacking

// if we don't have one or the other, then we're just using one...
if(!isset($lang[$langVar])) {
	$details = 'N/A';
}

else {
	$details = $lang[$langVar];
}

// do we want to carry anything over?
$findPrev = new Query($query['sessions']['get_noUser'], Array(1 => SID));
$lastaction = NOW - $bboptions['floodcheck'] - 100; // no unappropriate floodcheck violations

if($findPrev->numRows()) {
	$find = $findPrev->fetchArray();
	$lastaction = $find['lastaction'];
}

// get our values into array
$replace = Array(1 => SID, $User->info['username'], $User->info['userid'], NOW, $location, $details, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $lastaction);
new Query($query['sessions']['replace'], $replace);


/**
 * Initialize Session Hidden Input Template
 */
$SESSION_INPUT = new StyleFragment('sessionInput');
$SESSION_INPUT = $SESSION_INPUT->dump();

?>