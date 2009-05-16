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
## **************** POST DISPLAY ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

if($_GET['do'] == 'restore') {
	// Define AREA
	define('AREA', 'USER-POST-RESTORE');
	require_once('./includes/sessions.php');

	// get the post and the thread
	$Post = new Post($_GET['p']);
	$Thread = new Thread($Post->getThreadId());

	// can only do this if they can view deletion notices
	if(!$Thread->canView() OR !$User->check('canViewDelNotices', $Thread->getForumId())) {
		new WtcBBException('perm');
	}

	// not deleted?
	if(!$Post->isDeleted()) {
		new WtcBBException($lang['error_forum_postNotDel']);
	}

	Forum::init();

	// alright... restore it
	$Post->restore($Thread);

	new WtcBBThanks($lang['thanks_restoredPost']);
}

// post deletion
else if($_GET['do'] == 'delete') {
	// Define AREA
	define('AREA', 'USER-POST-DELETING');
	require_once('./includes/sessions.php');

	// no selection?
	if(!is_array($_GET['p']) OR !count($_GET['p'])) {
		new WtcBBException($lang['error_noSelection']);
	}

	// no thread yet
	$Thread = null;

	// get all the posts
	$posts = new Query($query['posts']['get_manyById'], Array(1 => implode(',', $_GET['p'])));

	if(!$posts->numRows()) {
		new WtcBBException($lang['error_noSelection']);
	}

	// initiate forum info
	Forum::init(); // initiates forums
	ForumPerm::init(); // initiates forum permissions array
	Moderator::init(); // initiates moderators array

	// now iterate
	while($post = $posts->fetchArray()) {
		// create new object
		$postObj = new Post('', $post);

		// create a thread object if we haven't already
		if(!($Thread instanceof Thread)) {
			$Thread = new Thread($postObj->getThreadId());
		}

		// if they can't delete, just skip it
		if(!$postObj->canDelete($Thread)) {
			continue;
		}

		// delete!
		$postObj->softDelete($Thread);
	}

	// thanks
	new WtcBBThanks($lang['thanks_postsDeleted'], './index.php?file=thread&amp;t=' . $Thread->getThreadId() . '&amp;do=newest' . $SESSURL);
}

else if($_GET['p']) {
	// Define AREA
	define('AREA', 'USER-VIEWINGPOST');
	require_once('./includes/sessions.php');

	// initiate forums
	Forum::init();
	$post = new Post($_GET['p']);
	$postUser = new User($post->getStarterId());
	$Thread = new Thread($post->getThreadId());
	$forumid = $Thread->getForumId();

	// make sure forum exists
	if(!isset($forums[$forumid])) {
		new WtcBBException($lang['error_forum_invalidForum']);
	}

	$FORUM = $forums[$Thread->getForumId()];

	// this checks forum permissions, usergroups, and user forum access
	if(!$User->canViewForum($forumid) OR !$Thread->canView() OR ($post->isDeleted() AND !$User->check('canViewDelNotices', $Thread->getForumId()))) {
		new WtcBBException('perm');
	}

	// forum is a link?
	$FORUM->goToLink();

	// start parser
	$MessageParser = new Message();

	// get dates
	$joined = new WtcDate('date', $postUser->info['joined']);
	$timeline = new WtcDate('dateTime', $post->getTimeline());
	$editedTime = ''; $signature = '';

	if($post->actionTimeline()) {
		$editedTime = new WtcDate('dateTime', $post->actionTimeline());
	}

	// soo.... what can we do for options?
	$MessageParser->autoOptions($postUser, $post);
	$message = $MessageParser->parse($post->getMessage(), $post->getStarterName());
	$quoteText = BBCode::stripMe($post->getMessageTextArea(), 'quote');

	// online or offline
	if($postUser->info['isOnline']) {
		$temp = new StyleFragment('status_online');
	}

	else {
		$temp = new StyleFragment('status_offline');
	}

	$status = $temp->dump();

	// any attachments?
	$attachBits = '';
	if(isset($attaching[$post->getPostId()])) {
		foreach($attaching[$post->getPostId()] as $attach) {
			$Attach = new Attachment('', $attach);

			$temp = new StyleFragment('threaddisplay_attachbit');
			$attachBits .= $temp->dump();
		}
	}

	// user ranks?
	$ranks = $postUser->getUserRank();

	// parse signature?
	$MessageParser->setOptions($postUser->check('canBBCode'), $postUser->check('canSmilies'), $postUser->check('canImg'), $postUser->info['allowHtml']);
	$signature = $MessageParser->parse($postUser->info['sig'], $postUser->info['username']);

	// create navigation
	$Nav = new Navigation(Array(
							$Thread->getName() => './index.php?file=thread&amp;t=' . $Thread->getThreadId() . '&amp;p=' . $post->getPostId(),
							$lang['user_thread_viewingPost'] => ''
						), 'forum');

	$header = new StyleFragment('header');
	$content = new StyleFragment('threaddisplay_smallbit');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}

?>
