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
## ****************** MEMBER LIST ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Define AREA
define('AREA', 'USER-MEMBERLIST');
require_once('./includes/sessions.php');

// get all members
$allMembers = new Query($query['user']['memList_count']);
$allMembers = $allMembers->fetchArray();
$memberCount = $allMembers['total'];
$realMemberCount = 0;

// sort and order
switch($_GET['sort']) {
	case 'username':
		$sortBy = 'username';
	break;

	case 'lastpost':
		$sortBy = 'lastpost';
	break;

	case 'joined':
		$sortBy = 'joined';
	break;

	default:
		$sortBy = 'posts';
	break;
}

switch($_GET['order']) {
	case 'ASC':
		$orderBy = 'ASC';
	break;

	default:
		$orderBy = 'DESC';
	break;
}

// get our page number
if($_GET['page'] <= 0 OR !is_numeric($_GET['page'])) {
	$page = 1;
}

else {
	$page = $_GET['page'];
}

// now get our start and end...
$start = $bboptions['threadsPerPage'] * ($page - 1);
$perPage = $bboptions['threadsPerPage'];
$ALT = 1; $memberBits = '';

// construct SORT URL (remove &sort and &order)
$SORT_URL = preg_replace('/&amp;order=.+?(&|$)/i', '$1', $_SERVER['REQUEST_URI']);
$SORT_URL = preg_replace('/&amp;sort=.+?(&|$)/i', '$1', $SORT_URL);

// now iterate through all users...
$members = new Query($query['user']['memList'], Array(
	1 => $sortBy,
	2 => $orderBy
));

while($member = $members->fetchArray()) {
	$userObj = new User('', '', $member);

	// completely ignore
	if(!$userObj->check('showMemberList')) {
		continue;
	}

	// increment real member count
	$realMemberCount++;

	// before the start?
	if($realMemberCount <= $start) {
		continue;
	}

	// after the end?
	if($realMemberCount > ($start + $perPage)) {
		continue;
	}

	// get dates
	$joined = new WtcDate('date', $userObj->info['joined']);

	if(!$userObj->info['lastpost']) {
		$lastPost = $lang['user_memList_never'];
	}

	else {
		$lastPost = new WtcDate('dateTime', $userObj->info['lastpost']);
	}

	// online or offline
	if($userObj->info['isOnline']) {
		$temp = new StyleFragment('status_online');
	}

	else {
		$temp = new StyleFragment('status_offline');
	}

	$status = $temp->dump();

	// do the bit!
	$temp = new StyleFragment('memList_bit');
	$memberBits .= $temp->dump();

	if($ALT == 2) {
		$ALT = 1;
	}

	else {
		$ALT = 2;
	}
}

// create page numbers
$pages = new PageNumbers($page, $realMemberCount, $bboptions['threadsPerPage']);

// do nav
$Nav = new Navigation(
			Array(
				$lang['user_memList_memList'] => ''
			)
		);

$header = new StyleFragment('header');
$content = new StyleFragment('memList');
$footer = new StyleFragment('footer');

$header->output();
$content->output();
$footer->output();

?>