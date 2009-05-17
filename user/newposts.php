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