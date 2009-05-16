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