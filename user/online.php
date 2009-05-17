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