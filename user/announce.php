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
## ************* ANNOUNCEMENT DISPLAY *************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Some global permissions
// and initiate required information
$Announce = new Announcement($_GET['a']);

// easy to access IDs
$announceid = $Announce->getAnnounceId();
$forumid = $_GET['f'];

// initiate forum info
Forum::init(); // initiates forums
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


// Define AREA
define('AREA', 'USER-ANNOUNCEMENT');
require_once('./includes/sessions.php');

// now build our announcements
$allAnnounce = new Query($query['announce']['get_forum'], Array(1 => $FORUM->getParentIds()));
$postBits = ''; $announceIds = ''; $before = '';

// initialize the message parser
$MessageParser = new Message();

while($post = $allAnnounce->fetchArray()) {
	$post = new Announcement('', $post);
	$postUser = new User('', '', $post->getInfo());

	// get dates
	$joined = new WtcDate('date', $postUser->info['joined']);
	$timeline = new WtcDate('dateTime', $post->lastUpdated());

	// soo.... what can we do for options?
	$MessageParser->setOptions($post->showBBCode(), $post->showSmilies(), $post->showBBCode(), $post->showHtml());
	$message = $MessageParser->parse($post->getMessage(), $postUser->info['username']);

	// online or offline
	if($postUser->info['isOnline']) {
		$temp = new StyleFragment('status_online');
	}

	else {
		$temp = new StyleFragment('status_offline');
	}

	$status = $temp->dump();

	$temp = new StyleFragment('announcedisplay_bit');
	$postBits .= $temp->dump();

	$announceIds .= $before . $post->getAnnounceId();
	$before = ',';
}

// create navigation
$Nav = new Navigation(Array(
						$lang['user_forum_announcements'] => ''
					), 'forum');

// update the number of views...
$Announce->update(Array('views' => ($Announce->getViews() + 1)));

$header = new StyleFragment('header');
$content = new StyleFragment('announcedisplay');
$footer = new StyleFragment('footer');

$header->output();
$content->output();
$footer->output();

?>