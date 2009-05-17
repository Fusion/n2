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
## ****************** BOARD INDEX ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Define AREA
define('AREA', 'USER-INDEX');
require_once('./includes/sessions.php');

// iterate through forums...
$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);
$forumBits = ''; $whoBits = '';
$first = true;

ForumPerm::init();
Moderator::init();

foreach($forumIter as $forum) {
	$fid = $forum->info['forumid'];

	if($forumIter->getDepth() > 1 OR !$forum->isActive()) {
		continue;
	}

	$canView = $User->canViewForum($fid);

	// this checks forum permissions, usergroups, and user forum access
	if(!$canView AND $bboptions['hidePrivateForums']) {
		continue;
	}

	$replyDate = new WtcDate('dateTime', $forum->info['last_reply_date']);
	$formattedThreadTitle = trimString($forum->info['last_reply_threadtitle'], 35);

	if(!empty($forum->info['link'])) {
		$tempName = 'forumhome_linkbit_depth' . ($forumIter->getDepth() + 1);
	}

	else if($forum->info['isCat']) {
		$tempName = 'forumhome_catbit_depth' . ($forumIter->getDepth() + 1);
	}

	else {
		$tempName = 'forumhome_forumbit_depth' . ($forumIter->getDepth() + 1);
	}

	$temp = new StyleFragment($tempName);
	$forumBits .= $temp->dump();

	$first = false;
}

// do who's online
if($bboptions['whosOnline']) {
	$whoBits = User::getOnlineUsers();
}

// do stats
if($bboptions['stats']) {
	$memberCount = new Query($query['user']['count']);
	$memberCount = $memberCount->fetchArray();
	$memberCount = $memberCount['total'];

	$threadCount = new Query($query['threads']['count']);
	$threadCount = $threadCount->fetchArray();
	$threadCount = $threadCount['total'];

	$postCount = new Query($query['posts']['count']);
	$postCount = $postCount->fetchArray();
	$postCount = $postCount['total'];

	$newMember = new Query($query['user']['newest']);
	$newMember = $newMember->fetchArray();
}

// get our forum list...
$forumList = new StyleFragment('forumhomelist');
$forumList = $forumList->dump();

$header = new StyleFragment('header');
$content = new StyleFragment('forumhome');
$footer = new StyleFragment('footer');

$header->output();
$content->output();
$footer->output();

?>