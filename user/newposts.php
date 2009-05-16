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
## ****************** MEMBER LIST ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Define AREA
define('AREA', 'USER-NEWPOSTS');
require_once('./includes/sessions.php');

// initiate forums
Forum::init();

// alternation
$ALT = 1;
$threadBits = '';

// query for actual threads
$displayThreads = new Query($query['threads']['get_newPosts'], Array(
	1 => $User->info['userid'],
	2 => $User->info['userid'],
	3 => $User->info['userid'],
	4 => $User->info['lastvisit']
));

while($thread = $displayThreads->fetchArray()) {
	// get thread object
	$obj = new Thread('', $thread);

	// can't view?
	if(!$obj->canView() OR $obj->isRead()) {
		continue;
	}

	// get date
	$replyDate = new WtcDate('dateTime', $obj->getLastReplyDate());

	// get page numbers (and force an URL)
	$pages = new PageNumbers(1, ($obj->getReplies() + 1), $bboptions['threadsPerPage'], './index.php?file=thread&amp;t=' . $obj->getThreadId() . $SESSURL);
	$pages = $pages->getPageNumbers(true);

	// thread marker
	$markerName = $obj->getFolderName($thread['postid']);

	$temp = new StyleFragment('forumdisplay_newThreads_bit');
	$threadBits .= $temp->dump();

	if($ALT === 1) {
		$ALT = 2;
	}

	else {
		$ALT = 1;
	}
}

if(empty($threadBits)) {
	new WtcBBException($lang['error_noNewPosts']);
}

// do nav
$Nav = new Navigation(
			Array(
				$lang['user_index_newPosts'] => ''
			)
		);

$header = new StyleFragment('header');
$content = new StyleFragment('forumdisplay_newThreads');
$footer = new StyleFragment('footer');

$header->output();
$content->output();
$footer->output();

?>