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
## ***************** WHO'S ONLINE ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Define AREA
define('AREA', 'USER-ONLINE');
require_once('./includes/sessions.php');

// check permissions...
if(!$User->check('canViewOnline')) {
	new WtcBBException('perm');
}

// setup some variables
if(!$_GET['perpage'] OR !is_numeric($_GET['perpage'])) {
	$perpage = $bboptions['threadsPerPage'];
}

else {
	$perpage = $_GET['perpage'];
}

if(!$_GET['resolve']) {
	$resolve = false;
}

else {
	$resolve = true;
}

if(!$_GET['display'] OR $_GET['display'] == 'all' OR ($_GET['display'] != 'members' AND $_GET['display'] != 'guests' AND $_GET['display'] != 'robots')) {
	$display = 'all';
}

else {
	$display = $_GET['display'];
}

// get our users...
$sessions = new Query($query['sessions']['get_all']);

$whoBits = '';
$before = '';
$members = 0; $guests = 0; $robots = 0;
$type = '';
$hostName = '';

// form robots array
$detect = preg_split('/(\r\n|\r|\n)/', $bboptions['robotDetect']);
$desc = preg_split('/(\r\n|\r|\n)/', $bboptions['robotDesc']);

// if someone is viewing, which they are, then we
// must have rows...
while($session = $wtcDB->fetchArray($sessions)) {
	$session['username'] = $session['sessUsername'];
	$session['userid'] = $session['sessUserid'];
	$userObj = new User('', '', $session);

	// member, guest, robot count
	if($userObj->info['userid']) {
		$type = 'members';
		$members++;
	}

	else {
		$type = 'guests';

		foreach($detect as $index => $bot) {
			if(stripos($userObj->info['userAgent'], $bot) !== false) {
				$robots++;
				$guests--;

				$userObj->info['username'] = $desc[$index];
				$type = 'robots';
				break;
			}
		}

		$guests++;
	}

	$time = new WtcDate('time', $userObj->info['lastactive']);
	$userAgent = wordwrap($userObj->info['userAgent'], 60, '</p><p class="small noMar">');

	if($resolve AND $User->check('canViewOnlineIp')) {
		$hostName = gethostbyaddr($userObj->info['ip']);
	}

	if($type == $display OR $display == 'all') {
		$temp = new StyleFragment('whosOnline_whoBit');
		$whoBits .= $temp->dump();
	}
}

$REDURI = $_SERVER['REQUEST_URI'];
$REDTIME = 60;
$meta = new StyleFragment('meta');
$meta = $meta->dump();

// do nav
$Nav = new Navigation(
			Array(
				$lang['user_index_whosOnline'] => ''
			)
		);

$header = new StyleFragment('header');
$content = new StyleFragment('whosOnline');
$footer = new StyleFragment('footer');

$header->output();
$content->output();
$footer->output();

?>