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
## ****************** POST THREAD ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Define AREA
define('AREA', 'USER-POSTTHREAD');
require_once('./includes/sessions.php');

// easy to access ID
$id = $_GET['f'];

// create a hash for attachments
if(empty($_POST['myHash'])) {
	$myHash = md5(time() . $id . $User->info['userid'] . microtime() . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
}

else {
	$myHash = $_POST['myHash'];
}

// initiate some forum stuff
Forum::init();

// make sure forum exists
if(!isset($forums[$id])) {
	new WtcBBException($lang['error_forum_invalidForum']);
}

// create forum obj
$FORUM = $forums[$id]; // easy to access object
$error = ''; // sanity check
$preview = ''; // sanity check

ForumPerm::init(); // initiates forum permissions array
Moderator::init(); // initiates moderators array

// this checks forum permissions, usergroups, and user forum access
if(!$User->canViewForum($id) OR !$FORUM->canPost()) {
	new WtcBBException('perm');
}

// forum is a link?
$FORUM->goToLink();

// we are good to go... for posting...
if($_POST) {
	// initiate the message parser
	$MessageParser = new Message();
	$MessageParser->autoOptions($User, new Post('', $_POST['postthread']));

	// preview?
	if($_POST['preview']) {
		$preview = $MessageParser->parse($_POST['message'], $User->info['username']);
	}

	else {
		$checking = $MessageParser->check($_POST['message'], $_POST['postthread']['name']);

		// uh oh...
		if($checking instanceof WtcBBException) {
			$error = $checking->dump();
		}

		// flood
		else if($User->flood()) {
			$error = new WtcBBException($lang['error_flood'], false);
			$error = $error->dump();
		}

		else if(!$User->info['userid'] AND $_POST['postthread']['threadUsername'] != $User->info['username']) {
			// check unique username...
			$check = new Query($query['user']['checkUniqueName'], Array(1 => $_POST['postthread']['threadUsername']));
			$check = $wtcDB->fetchArray($check);

			if($check['checking']) {
				$error = new WtcBBException($lang['error_message_uniqueName'], false);
				$error = $error->dump();
			}

			// what about length of username?
			if($_POST['postthread']['threadUsername'] < $bboptions['usernameMin']) {
				$error = new WtcBBException($lang['error_message_nameLengthMin'], false);
				$error = $error->dump();
			}

			else if($_POST['postthread']['threadUsername'] > $bboptions['usernameMax']) {
				$error = new WtcBBException($lang['error_message_nameLengthMax'], false);
				$error = $error->dump();
			}
		}

		else {
			// initiate
			$insert = Array();

			// okay we're good... get message
			$_POST['message'] = $checking;

			// insert our thread...
			$_POST['postthread'] = array_map('wtcspecialchars', $_POST['postthread']);
			$insert = $_POST['postthread'];
			$insert['posticon'] = wtcspecialchars($_POST['posticon']);
			$insert['forumid'] = $id;
			$insert['madeby'] = $User->info['userid'];
			$insert['threadUsername'] = $User->info['username'];
			$insert['views'] = 0; $insert['replies'] = 0;
			$insert['deleted'] = 0;	$insert['moved'] = 0; $insert['sticky'] = 0;
			$insert['closed'] = 0; $insert['poll'] = 0;
			$insert['thread_timeline'] = NOW;

			// username
			if(!$User->info['userid']) {
				$insert['threadUsername'] = $_POST['postthread']['threadUsername'];
			}

			else {
				$insert['threadUsername'] = $User->info['username'];
			}

			// last reply stuff
			$insert['last_reply_userid'] = $User->info['userid'];
			$insert['last_reply_date'] = NOW;
			$insert['last_reply_username'] = $insert['threadUsername'];

			// if no desc...
			if(empty($insert['descript'])) {
				$insert['descript'] = Message::buildDesc($_POST['message']);
			}

			// get rid of bb code, smilies, and sig first...
			unset($insert['bbcode'], $insert['sig'], $insert['smilies']);

			// insert thread...
			$threadid = Thread::insert($insert);
			$insert['threadid'] = $threadid;
			$insert['subid'] = 0;
			$threadObj = new Thread('', $insert);

			// restart insert
			$oldInsert = $insert;
			$insert = Array();

			// now form our post insert
			$insert['threadid'] = $threadid;
			$insert['message'] = $_POST['message'];
			$insert['forumid'] = $id;
			$insert['postby'] = $User->info['userid'];
			$insert['postUsername'] = $oldInsert['threadUsername'];
			$insert['title'] = $_POST['postthread']['name'];
			$insert['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$insert['posts_timeline'] = NOW;
			$insert['posticon'] = wtcspecialchars($_POST['posticon']);
			$insert['deleted'] = 0; $insert['edited_by'] = 0; $insert['edited_show'] = 1;

			// options
			$insert['sig'] = $_POST['postthread']['sig'];
			$insert['smilies'] = $_POST['postthread']['smilies'];
			$insert['bbcode'] = $_POST['postthread']['bbcode'];
			$insert['defBBCode'] = 0;

			// now insert the post
			$postid = Post::insert($insert);

			// now update our thread...
			$threadObj->update(Array('first_postid' => $postid, 'last_reply_postid' => $postid));

			// update any attachments?
			new Query($query['attachments']['update_hash'],
				Array(
					1 => $threadObj->getThreadId(),
					2 => $postid,
					3 => $myHash
				)
			);

			// open close thread?
			if($_POST['closedStatus'] AND $threadObj->canClose()) {
				$threadObj->openClose();
			}

			// stick unstick thread?
			if($_POST['stickyStatus'] AND $threadObj->canSticky()) {
				$threadObj->stickUnstick();
			}

			// subscribe?
			if(LOGIN AND $_POST['sub']) {
				$threadObj->subUnsub();
			}

			// update forum...
			$forumUpdate = Array(
								'last_reply_username' => $oldInsert['threadUsername'],
								'last_reply_userid' => $User->info['userid'],
								'last_reply_date' => NOW,
								'last_reply_threadid' => $threadid,
								'last_reply_threadtitle' => $_POST['postthread']['name']
							);

			$FORUM->updateLastReplyAndCounts($forumUpdate, true);

			// update user post counts
			$User->update(
				Array(
					'posts' => (($FORUM->info['countPosts']) ? $User->info['posts'] + 1 : $User->info['posts']),
					'threads' => (($FORUM->info['countPosts']) ? $User->info['threads'] + 1 : $User->info['threads']),
					'lastpost' => NOW,
					'lastpostid' => $postid
				)
			);

			// mark read
			if(LOGIN) {
				new Query($query['read_threads']['insert'], Array(
																1 => $User->info['userid'],
																2 => $threadid,
																3 => NOW
															));
			}

			// cache forums
			new Cache('Forums');

			new WtcBBThanks($lang['thanks_postThread'], './index.php?file=thread&amp;t=' . $threadid . $SESSURL);
		}
	}
}

// uh oh...
if($_POST) {
	$_POST = array_map_recursive('wtcspecialchars', $_POST);
}

$postIcon = PostIcon::constructPostIcons();
$toolBar = Message::buildToolBar();

// create navigation
$Nav = new Navigation(
			Array(
				$lang['user_forum_postThread'] => ''
			),
			'forum'
		);

$header = new StyleFragment('header');
$content = new StyleFragment('message_postthread');
$footer = new StyleFragment('footer');

$header->output();
$content->output();
$footer->output();

?>