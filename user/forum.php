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
## ***************** FORUM DISPLAY ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// easy to access ID
$forumid = $_GET['f'];

// initiate some forum stuff
Forum::init();
ForumPerm::init(); // initiates forum permissions array
Moderator::init(); // initiates moderators array

// create forum obj
$FORUM = $forums[$forumid]; // easy to access object

// make sure forum exists
if(!isset($forums[$forumid])) {
	new WtcBBException($lang['error_forum_invalidForum']);
}

// this checks forum permissions, usergroups, and user forum access
if(!$User->canViewForum($forumid)) {
	new WtcBBException('perm');
}

// go to link AFTER perms
$FORUM->goToLink();

// (un)subscribe
if($_GET['do'] == 'subscribe') {
	// Define AREA
	define('AREA', 'USER-THREAD-SUBSCRIBING');
	require_once('./includes/sessions.php');

	// not logged in?
	if(!LOGIN) {
		new WtcBBException('perm');
	}

	// just do it...
	$FORUM->subUnsub();

	if($FORUM->isSubscribed()) {
		new WtcBBThanks($lang['thanks_unsubscribe']);
	}

	else {
		new WtcBBThanks($lang['thanks_subscribe']);
	}
}

// remove forum redirects
else if($_GET['do'] == 'removeRedirects') {
	// Define AREA
	define('AREA', 'USER-FORUM-REDIRECTS');
	require_once('./includes/sessions.php');

	// not a moderator?
	if(!$User->isMod($FORUM->info['forumid'])) {
		new WtcBBException('perm');
	}

	// just do it...
	$FORUM->removeRedirects();

	new WtcBBThanks($lang['thanks_redirects']);
}

else {
	// Define AREA
	define('AREA', 'USER-FORUMS');
	require_once('./includes/sessions.php');

	// more forum stuff
	$forumBits = ''; $whoBits = '';
	$first = true;
	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator($forumid), true);

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
			$tempName = 'forumdisplay_linkbit_depth' . ($forumIter->getDepth() + 1);
		}

		else if($forum->info['isCat']) {
			$tempName = 'forumdisplay_catbit_depth' . ($forumIter->getDepth() + 1);
		}

		else {
			$tempName = 'forumdisplay_forumbit_depth' . ($forumIter->getDepth() + 1);
		}

		$temp = new StyleFragment($tempName);
		$forumBits .= $temp->dump();

		if($forum->info['isCat']) {
			$first = false;
		}
	}

	// get our forum list... only if we looped...
	if(!empty($forumBits)) {
		$forumList = new StyleFragment('forumdisplaylist');
		$forumList = $forumList->dump();
	}

	// start the announcements now...
	$allAnnounce = new Query($query['announce']['get_forum'], Array(1 => $FORUM->getParentIds()));
	$announceBits = ''; $ALT = 1;

	while($announce = $allAnnounce->fetchArray()) {
		$obj = new Announcement('', $announce);
		$lastUpdated = new WtcDate('dateTime', $obj->lastUpdated());

		$temp = new StyleFragment('forumdisplay_announce_bit');
		$announceBits .= $temp->dump();

		if($ALT === 1) {
			$ALT = 2;
		}

		else {
			$ALT = 1;
		}
	}

	// get all threads...
	$allThreads = new Query($query['threads']['get_all_forum'], Array(
															1 => $forumid
														));

	// now fetch array (just total threads)
	$allThreads = $wtcDB->fetchArray($allThreads);

	// build page number, start, and per page
	// get our page number
	if(!$_GET['page'] OR !is_numeric($_GET['page'])) {
		$page = 1;
	}

	else {
		$page = $_GET['page'];
	}

	// now get our start and end...
	$start = $bboptions['threadsPerPage'] * ($page - 1);
	$perPage = $bboptions['threadsPerPage'];

	// now build our threads
	switch($_GET['sort']) {
		case 'name':
			$orderBy = 'name';
		break;

		case 'replies':
			$orderBy = 'replies';
		break;

		case 'views':
			$orderBy = 'views';
		break;

		default:
			$orderBy = 'last_reply_date';
		break;
	}

	switch($_GET['order']) {
		case 'ASC':
			$orderBy .= ' ASC';
		break;

		default:
			$orderBy .= ' DESC';
		break;
	}

	$threadBits = '';
	$stickySep = false; $first = true;
	$ALT = 1;

	// construct SORT URL (remove &sort and &order)
	$SORT_URL = preg_replace('/&amp;order=.+?(&|$)/i', '$1', $_SERVER['REQUEST_URI']);
	$SORT_URL = preg_replace('/&amp;sort=.+?(&|$)/i', '$1', $SORT_URL);

	// get all our attachments for this forum...
	$forumAttachments = new Query($query['attachments']['get_forumid'], Array(1 => $forumid));
	$attachs = Array();

	while($attach = $forumAttachments->fetchArray()) {
		$attachs[$attach['threadid']] = true;
	}

	// query for actual threads
	$displayThreads = new Query($query['threads']['get_display_forum'], Array(
																	1 => $User->info['userid'],
																	2 => $User->info['userid'],
																	3 => $forumid,
																	4 => $orderBy,
																	5 => $start,
																	6 => $perPage
																));

	// if we end up being completely read, mark forum read
	$forumRead = true;

	while($thread = $displayThreads->fetchArray()) {
		// get thread object
		$obj = new Thread('', $thread);

		// can't view?
		if(!$obj->canView()) {
			continue;
		}

		// not read? o_0
		if($obj->getLastReplyDate() >= $bboptions['readTimeout'] AND (!$obj->lastRead() OR ($obj->lastRead() AND $obj->lastRead() < $obj->getLastReplyDate()))) {
			$forumRead = false;
		}

		// get date
		$replyDate = new WtcDate('dateTime', $obj->getLastReplyDate());

		// get page numbers (and force an URL)
		$pages = new PageNumbers(1, ($obj->getRealReplies() + 1), $bboptions['postsPerPage'], './index.php?file=thread&amp;t=' . $obj->getThreadId() . $SESSURL);
		$pages = $pages->getPageNumbers(true);

		// thread marker
		$markerName = $obj->getFolderName($thread['postid']);

		// any stickies?
		if(empty($threadBits) AND !$obj->isSticky()) {
			$stickySep = true;
		}

		// wait... sticky separator? o_0
		if(!$stickySep AND !$obj->isSticky()) {
			$temp = new StyleFragment('forumdisplay_thread_stickySeparator');
			$threadBits .= $temp->dump();

			$stickySep = true;
		}

		$temp = new StyleFragment('forumdisplay_thread_bit');
		$threadBits .= $temp->dump();

		if($ALT === 1) {
			$ALT = 2;
		}

		else {
			$ALT = 1;
		}

		$first = false;
	}

	// insert forum read marker
	if(LOGIN) {
		new Query($query['read_forums']['insert'], Array(
													1 => $User->info['userid'],
													2 => $FORUM->info['forumid'],
													3 => NOW
												));

		if($FORUM->isSubscribed()) {
			$FORUM->updateSubscription();
		}
	}

	$temp = new StyleFragment('forumdisplay_thread');
	$threadList = $temp->dump();

	// build moderator bits...
	$modBits = '';
	$separator = false;

	if(isset($moderators[$forumid])) {
		foreach($moderators[$forumid] as $userid => $obj) {
			$Mod = new User('', '', $obj->getInfo(), false);

			$temp = new StyleFragment('moderator_bit');
			$modBits .= $temp->dump();
			$separator = true;
		}
	}

	// create page numbers
	$pages = new PageNumbers($page, $allThreads['total'], $bboptions['threadsPerPage']);

	// what about users browsing?
	if($bboptions['browsingForum']) {
		// get the users in this thread...
		$whoBits = User::getOnlineUsers($forumid);
	}

	// create navigation
	$Nav = new Navigation('', 'forum');

	$header = new StyleFragment('header');
	$content = new StyleFragment('forumdisplay');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}

?>