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
## ******************** POST EDIT ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Define AREA
define('AREA', 'USER-POSTEDIT');
require_once('./includes/sessions.php');

$Post = new Post($_GET['p']);
$Thread = new Thread($Post->getThreadId());

// easy to access IDs
$postid = $Post->getPostId();
$threadid = $Thread->getThreadId();
$forumid = $Thread->getForumId();

// initiate forum info
Forum::init();

// make sure forum exists
if(!isset($forums[$forumid])) {
	new WtcBBException($lang['error_forum_invalidForum']);
}

// create forum obj
$FORUM = $forums[$forumid]; // easy to access object
$error = ''; // sanity check

ForumPerm::init(); // initiates forum permissions array
Moderator::init(); // initiates moderators array

// this checks forum permissions, usergroups, and user forum access
if(!$User->canViewForum($forumid) OR !$Post->canEdit() OR !$Thread->canView()) {
	new WtcBBException('perm');
}

// forum is a link?
$FORUM->goToLink();

// thread or post deleted?
if($Thread->isDeleted()) {
	new WtcBBException($lang['error_forum_threadDel']);
}

// can't allow if post is deleted either
if($Post->isDeleted()) {
	new WtcBBException($lang['error_forum_postDel']);
}

// we are good to go... for posting...
if($_POST) {
	// initiate the message parser
	$MessageParser = new Message();
	$MessageParser->autoOptions($User, new Post('', $_POST['postedit']));

	// preview?
	if($_POST['preview']) {
		$preview = $MessageParser->parse($_POST['message'], $User->info['username']);
	}

	// either error or post message!
	else {
		// deleting? o_0
		if($_POST['delete']) {
			// sanity
			$_POST['postedit'] = array_map('wtcspecialchars', $_POST['postedit']);

			// soft delete
			if($_POST['delete'] == 1) {
				// no perms?
				if(!$Post->canDelete($Thread)) {
					new WtcBBException('perm');
				}

				// thread delete?
				if($Thread->getFirstPostId() == $Post->getPostId()) {
					$Thread->softDelete($_POST['postedit']['edited_reason']);

					new WtcBBThanks($lang['thanks_threadDelete'], './index.php?file=thread&amp;t=' . $Thread->getThreadId() . '&amp;do=newest');
				}

				else {
					$Post->softDelete($Thread, $_POST['postedit']['edited_reason']);

					new WtcBBThanks($lang['thanks_postDelete'], './index.php?file=thread&amp;t=' . $Thread->getThreadId() . '&amp;do=newest');
				}
			}

			// perm delete
			else if($_POST['delete'] == 2) {
				// no perms?
				if(!$Post->canPermDelete($Thread)) {
					new WtcBBException('perm');
				}

				if($Thread->getFirstPostId() == $Post->getPostId()) {
					$Thread->permDelete();

					new WtcBBThanks($lang['thanks_threadDelete'], './index.php?file=forum&amp;f=' . $FORUM->getForumId());
				}

				else {
					$Post->permDelete($Thread);

					new WtcBBThanks($lang['thanks_postDelete'], './index.php?file=forum&amp;f=' . $FORUM->getForumId());
				}
			}
		}

		// start checking
		// wait, is there a name change? for thread?
		$checking = $MessageParser->check($_POST['message'], $_POST['postedit']['title']);

		// uh oh...
		if($checking instanceof WtcBBException) {
			$error = $checking->dump();
		}

		// flood
		else if($User->flood()) {
			$error = new WtcBBException($lang['error_flood'], false);
			$error = $error->dump();
		}

		else {
			// initiate
			$update = Array();

			// okay we're good... get message
			$_POST['message'] = $checking;

			// sanity
			$_POST['postedit'] = array_map('wtcspecialchars', $_POST['postedit']);

			// now form our post insert
			$update['message'] = $_POST['message'];
			$update['title'] = (empty($_POST['postedit']['title']) ? 'Re: ' . $Thread->getName() : $_POST['postedit']['title']);
			$update['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$update['posticon'] = wtcspecialchars($_POST['posticon']);
			$update['edited_by'] = $User->info['username']; $update['edited_timeline'] = NOW; $update['edited_reason'] = $_POST['postedit']['edited_reason'];

			// options
			$update['sig'] = $_POST['postedit']['sig'];
			$update['smilies'] = $_POST['postedit']['smilies'];
			$update['bbcode'] = $_POST['postedit']['bbcode'];
			$update['defBBCode'] = 0; $update['edited_show'] = 0;

			if($_POST['postedit']['edited_show'] AND $User->check('canEditedNotice', $FORUM->getForumId())) {
				$update['edited_show'] = 1;
			}

			// now update the post
			$Post->update($update);

			// open close thread?
			if($_POST['closedStatus'] AND $Thread->canClose()) {
				$Thread->openClose();
			}

			// stick unstick thread?
			if($_POST['stickyStatus'] AND $Thread->canSticky()) {
				$Thread->stickUnstick();
			}

			// subscribe?
			if(LOGIN AND $_POST['sub']) {
				$Thread->subUnsub();
			}

			// what if title/post icon changes, and has perms to change thread title?
			// and make sure first post
			if($Post->getPostId() == $Thread->getFirstPostId() AND $Thread->canEditThreadTitle()) {
				$Thread->update(
					Array(
						'name' => $update['title'],
						'posticon' => wtcspecialchars($_POST['posticon'])
					)
				);
			}

			// mark read
			if(LOGIN) {
				new Query($query['read_threads']['insert'], Array(
																1 => $User->info['userid'],
																2 => $Thread->getThreadId(),
																3 => NOW
															));
			}

			new WtcBBThanks($lang['thanks_postEdit'], './index.php?file=thread&amp;t=' . $Thread->getThreadId() . '&amp;p=' . $postid . $SESSURL);
		}
	}
}

// uh oh...
if($_POST) {
	$_POST = array_map_recursive('wtcspecialchars', $_POST);
}

// get the attachments and load them in
// needs to come before toolbar build
$attachments = new Query($query['attachments']['get_postid'], Array(1 => $Post->getPostId()));
$attachBits = '';

while($attach = $attachments->fetchArray()) {
	$Attachment = new Attachment('', $attach);

	$temp = new StyleFragment('message_attachBit');
	$attachBits .= $temp->dump();
}

// build icons and toolbar
$postIcon = PostIcon::constructPostIcons($Post->getPostIcon());
$toolBar = Message::buildToolBar();

// create navigation
$Nav = new Navigation(
			Array(
				$Thread->getName() => './index.php?file=thread&amp;t=' . $Thread->getThreadId(),
				$lang['user_thread_postEdit'] => ''
			),
			'forum'
		);

$header = new StyleFragment('header');
$content = new StyleFragment('message_postedit');
$footer = new StyleFragment('footer');

$header->output();
$content->output();
$footer->output();

?>