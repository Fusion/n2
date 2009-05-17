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
## **************** THREAD DISPLAY ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Some global permissions
// and initiate required information
$Thread = new Thread($_GET['t']);

// easy to access IDs
$threadid = $Thread->getThreadId();
$forumid = $Thread->getForumId();

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
if(!$User->canViewForum($forumid) OR !$Thread->canView()) {
	new WtcBBException('perm');
}

// forum is a link?
$FORUM->goToLink();

// trying to perform an action?
if($Thread->isDeleted() AND $_GET['do'] AND $_GET['do'] != 'restore' AND $_GET['do'] != 'newest') {
	new WtcBBException($lang['user_thread_delMessage']);
}

// moved?
if($Thread->movedTo()) {
	// Define AREA
	define('AREA', 'USER-THREAD');
	require_once('./includes/sessions.php');

	//  update views and make read
	$Thread->update(Array('views' => ($Thread->getViews() + 1)));

	// insert read... if need be...
	if(LOGIN) {
		new Query($query['read_threads']['insert'], Array(
														1 => $User->info['userid'],
														2 => $Thread->getThreadId(),
														3 => NOW
													));
	}

	new Redirect('./index.php?file=thread&t=' . $Thread->movedTo() . $SESSURL);
}

// adding/editing poll
// just a redirect
else if($_GET['do'] == 'poll') {
	// Define AREA
	define('AREA', 'USER-THREAD');
	require_once('./includes/sessions.php');

	// permissions are checked elsewhere
	if($Thread->isPoll()) {
		new Redirect('./index.php?file=poll&poll=' . $Thread->isPoll() . $SESSURL);
	}

	else {
		new Redirect('./index.php?file=poll&t=' . $Thread->getThreadId() . $SESSURL);
	}
}

// delete poll
else if($_GET['do'] == 'delPoll') {
	// Define AREA
	define('AREA', 'USER-THREAD');
	require_once('./includes/sessions.php');

	if($Thread->isPoll()) {
		new Redirect('./index.php?file=poll&poll=' . $Thread->isPoll() . '&do=delete' . $SESSURL);
	}

	else {
		new Redirect();
	}
}

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
	$Thread->subUnsub();

	if($Thread->isSubscribed()) {
		new WtcBBThanks($lang['thanks_unsubscribe']);
	}

	else {
		new WtcBBThanks($lang['thanks_subscribe']);
	}
}

// split thread?
else if($_GET['do'] == 'split') {
	// Define AREA
	define('AREA', 'USER-THREAD-SPLITTING');
	require_once('./includes/sessions.php');

	// no permissions?
	if(!$Thread->canSplit()) {
		new WtcBBException('perm');
	}

	// no error!... yet...
	$error = '';

	if($_POST) {
		// thread title checking
		// do checking
		$MessageParser = new Message();
		$checking = $MessageParser->check(false, $_POST['splitthread']['name']);

		// tsk tsk
		if($checking instanceof WtcBBException) {
			$error = $checking;
		}

		// no posts selected? o_0
		else if(!is_array($_POST['delete']) OR !count($_POST['delete'])) {
			$error = new WtcBBException($lang['error_noSelection'], false);
		}

		// we're going to cheat...
		// get the posts and feed them to copy
		else {
			// sanity
			$_POST['splitthread'] = array_map('wtcspecialchars', $_POST['splitthread']);

			// loop through selected posts...
			foreach($_POST['delete'] as $postid => $yes) {
				if($yes) { // sanity
					$postids[] = $postid;
				}
			}

			// do the split
			$Splitted = $Thread->split($_POST['splitthread']['name'], $postids);

			// wait... do we want to do anything to old thread?
			if($_POST['do']) {
				if($_POST['do'] == 'delete' AND $Thread->canDelete()) {
					$Thread->softDelete();
				}

				else if($_POST['do'] == 'permDelete' AND $Thread->canPermDelete()) {
					$Thread->permDelete();
				}

				else if($_POST['do'] == 'close' AND $Thread->canClose() AND !$Thread->isClosed()) {
					$Thread->openClose();
				}
			}

			// thanks! -_-
			new WtcBBThanks($lang['thanks_splitThread'], './index.php?file=thread&amp;t=' . $Splitted->getThreadId() . $SESSURL);
		}

		// errors?
		if($error instanceof WtcBBException) {
			$error = $error->dump();
			$_POST['splitthread'] = array_map('wtcspecialchars', $_POST['splitthread']); // sanity
		}
	}

	// set if we should show deleted messages or not
	// reversing the value (meh, it's a hack so what)
	$showDeleted = 1;

	// should we show deleted?
	if($User->check('canViewDelNotices', $Thread->getForumId())) {
		$showDeleted = 2; // kind of a hack
	}

	$displayPosts = new Query($query['posts']['get_display_small'], Array(
																	1 => $threadid,
																	2 => $showDeleted
																));

	$post = $wtcDB->fetchArray($displayPosts);

	do {
		// get our post and user
		$post = new Post('', $post);
		$postUser = new User('', '', $post->getInfo());

		$joined = new WtcDate('date', $postUser->info['joined']);
		$timeline = new WtcDate('dateTime', $post->getTimeline());
		$editedTime = '';

		if($post->actionTimeline()) {
			$editedTime = new WtcDate('dateTime', $post->actionTimeline());
		}

		// user ranks?
		$ranks = $postUser->getUserRank();

		// bare bones message
		$message = nl2br(trimString(BBCode::stripAll($post->getMessage()), 500));

		$temp = new StyleFragment('threaddisplay_smallbit');
		$postBits .= $temp->dump();
	} while($post = $wtcDB->fetchArray($displayPosts));

	// create navigation
	$Nav = new Navigation(
		Array(
			$Thread->getName() => './index.php?file=thread&amp;t=' . $Thread->getThreadId(),
			$lang['user_thread_splitThread'] => ''
		),
	'forum');

	$header = new StyleFragment('header');
	$content = new StyleFragment('threaddisplay_split');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}

// merging thread
else if($_GET['do'] == 'merge') {
	// Define AREA
	define('AREA', 'USER-THREAD-MERGING');
	require_once('./includes/sessions.php');

	// no error... yet
	$error = '';

	if($_POST) {
		// find the thread id in the URL...
		preg_match('/t=([0-9]+)/', $_POST['url'], $matches);

		// get the thread
		$Merger = new Thread($matches[1]);

		// merging into self? o_0
		if($Merger->getThreadId() == $Thread->getThreadId()) {
			$error = new WtcBBException($lang['error_forum_mergingToSelf'], false);
		}

		// deleted or moved
		else if($Merger->isDeleted() OR $Merger->movedTo()) {
			$error = new WtcBBException($lang['error_forum_threadDel'], false);
		}

		else {
			// merge it
			$Thread->merge($Merger);

			// redirect to thread
			new WtcBBThanks($lang['thanks_mergedThread'], './index.php?file=thread&amp;t=' . $Thread->getThreadId() . $SESSURL);
		}

		if($error instanceof WtcBBException) {
			$error = $error->dump();
			$_POST['url'] = wtcspecialchars($_POST['url']); // sanity
		}
	}

	// create navigation
	$Nav = new Navigation(
		Array(
			$Thread->getName() => './index.php?file=thread&amp;t=' . $Thread->getThreadId(),
			$lang['user_thread_mergeThread'] => ''
		),
	'forum');

	$header = new StyleFragment('header');
	$content = new StyleFragment('threaddisplay_merge');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}

// moving a thread
else if($_GET['do'] == 'move') {
	// Define AREA
	define('AREA', 'USER-THREAD-MOVING');
	require_once('./includes/sessions.php');

	// no error!... yet...
	$error = '';

	// no permissions?
	if(!$Thread->canMove()) {
		new WtcBBException('perm');
	}

	if($_POST) {
		// nothing selected?
		if(!$_POST['moveType']) {
			$error = new WtcBBException($lang['error_noSelection'], false);
		}

		else if($forums[$_POST['forum']]->info['isCat']) {
			$error = new WtcBBException($lang['error_forum_moveToCat'], false);
		}

		else {
			// copy, move, or move w/ redirect?
			// redirect
			if($_POST['moveType'] == 1) {
				$Thread->copy($forums[$_POST['forum']], true, true);
			}

			// move
			else if($_POST['moveType'] == 2) {
				$Thread->copy($forums[$_POST['forum']], true, false);
			}

			else if($_POST['moveType'] == 3) {
				$Thread->copy($forums[$_POST['forum']]);
			}

			new WtcBBThanks($lang['thanks_movedThread']);
		}

		// error? o_0
		if($error instanceof WtcBBException) {
			$error = $error->dump();
		}
	}

	// create navigation
	$Nav = new Navigation(
		Array(
			$Thread->getName() => './index.php?file=thread&amp;t=' . $Thread->getThreadId(),
			$lang['user_thread_moveCopyThread'] => ''
		),
	'forum');

	// construct forum selection bits
	$forumSelect = Forum::constructForumSelect();

	$header = new StyleFragment('header');
	$content = new StyleFragment('threaddisplay_move');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}

// restoring a thread
else if($_GET['do'] == 'restore') {
	// Define AREA
	define('AREA', 'USER-THREAD-RESTORE');
	require_once('./includes/sessions.php');

	// not deleted?
	if(!$Thread->isDeleted()) {
		new WtcBBException($lang['error_forum_threadNotDel']);
	}

	// alright... restore it
	$Thread->restore();

	new WtcBBThanks($lang['thanks_restoredThread']);
}

// deleting thread
else if($_GET['do'] == 'delete') {
	// Define AREA
	define('AREA', 'USER-THREAD-DELETING');
	require_once('./includes/sessions.php');

	// no error... yet!
	$error = '';

	// make sure we have perms...
	if(!$Thread->canDelete() AND !$Thread->canPermDelete()) {
		new WtcBBException('perm');
	}

	// make sure it's not already deleted...
	if($Thread->isDeleted()) {
		new WtcBBException($lang['error_forum_threadDel']);
	}

	// do the deletion
	if($_POST) {
		// nothing selected?
		if(!$_POST['delete']) {
			$error = new WtcBBException($lang['error_noSelection'], false);
		}

		else if($_POST['delete'] == 1 AND !$Thread->canDelete()) {
			$error = new WtcBBException('perm');
		}

		else if($_POST['delete'] == 2 AND !$Thread->canPermDelete()) {
			$error = new WtcBBException('perm');
		}

		else {
			// do the delete...
			// soft delete
			if($_POST['delete'] == 1) {
				$Thread->softDelete();
				$redUri = './index.php?file=thread&amp;t=' . $Thread->getThreadId() . $SESSURL;
			}

			// perm delete
			else if($_POST['delete'] == 2) {
				$Thread->permDelete();
				$redUri = './index.php?file=forum&amp;f=' . $Thread->getForumId() . $SESSURL;
			}

			// update reason
			$Thread->update(Array('deleted_reason' => wtcspecialchars($_POST['delthread']['deleted_reason'])));

			new WtcBBThanks($lang['thanks_threadDelete'], $redUri);
		}

		if($error instanceof WtcBBException) {
			$error = $error->dump();
		}
	}

	// create navigation
	$Nav = new Navigation(
		Array(
			$Thread->getName() => './index.php?file=thread&amp;t=' . $Thread->getThreadId(),
			$lang['user_thread_deleteThread'] => ''
		),
	'forum');

	$header = new StyleFragment('header');
	$content = new StyleFragment('threaddisplay_delete');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}

// editing thread
else if($_GET['do'] == 'edit') {
	// Define AREA
	define('AREA', 'USER-THREAD-EDITING');
	require_once('./includes/sessions.php');

	// only moderator
	if(!$User->modAction('canEditThreads', $Thread->getForumId())) {
		new WtcBBException('perm');
	}

	// now update
	if($_POST) {
		// do checking
		$MessageParser = new Message();
		$checking = $MessageParser->check(false, $_POST['editthread']['name']);

		// tsk tsk
		if($checking instanceof WtcBBException) {
			$error = $checking->dump();
		}

		else {
			// update our thread...
			$_POST['postthread'] = array_map('wtcspecialchars', $_POST['editthread']);
			$update = $_POST['postthread'];
			$update['posticon'] = wtcspecialchars($_POST['posticon']);

			// just do the update
			$Thread->update($update);

			// thanks!
			new WtcBBThanks($lang['thanks_editThread'], './index.php?file=thread&amp;t=' . $Thread->getThreadId() . $SESSURL);
		}

		$_POST['editthread'] = array_map('wtcspecialchars', $_POST['editthread']);
	}

	// do post icons
	$postIcon = PostIcon::constructPostIcons(($_POST ? $_POST['posticon'] : $Thread->getPostIconPath()));

	// create navigation
	$Nav = new Navigation(
		Array(
			$Thread->getName() => './index.php?file=thread&amp;t=' . $Thread->getThreadId(),
			$lang['user_thread_editThread'] => ''
		),
	'forum');

	$header = new StyleFragment('header');
	$content = new StyleFragment('threaddisplay_edit');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}

// open/close thread... cake and pie!
else if($_GET['do'] == 'openClose') {
	// Define AREA
	define('AREA', 'USER-THREAD-OPENCLOSE');
	require_once('./includes/sessions.php');

	// check perms first...
	if(!$Thread->canClose()) {
		new WtcBBException('perm');
	}

	// dooo it!
	$Thread->openClose();

	// gotta thank'em
	new WtcBBThanks($lang['thanks_openClose']);
}

// are your hands sticky?
// i'm bad....
else if($_GET['do'] == 'stickUnstick') {
	// Define AREA
	define('AREA', 'USER-THREAD-STICKUNSTICK');
	require_once('./includes/sessions.php');

	// check perms first...
	if(!$Thread->canSticky()) {
		new WtcBBException('perm');
	}

	// dooo it!
	$Thread->stickUnstick();

	// gotta thank'em
	new WtcBBThanks($lang['thanks_stickUnstick']);
}

// go to newest post
else if($_GET['do'] == 'newest') {
	// Define AREA
	define('AREA', 'USER-THREAD');
	require_once('./includes/sessions.php');

	// brand spanken new...
	if(!LOGIN OR !$Thread->lastRead()) {
		new Redirect('./index.php?file=thread&t=' . $Thread->getThreadId() . $SESSURL);
	}

	// fully read?
	if($Thread->lastRead() >= $Thread->getLastReplyDate()) {
		new Redirect('./index.php?file=thread&t=' . $Thread->getThreadId() . '&p=' . $Thread->getLastReplyPostId() . $SESSURL);
	}

	// find the newest post and redirect...
	$getNewest = new Query($query['posts']['get_upto'], Array(1 => $Thread->lastRead(), $Thread->getThreadId()));

	// calc page number
	$page = ceil((($Thread->getRealReplies()) - $getNewest->numRows()) / $bboptions['postsPerPage']);

	// now get the postid...
	$Post = new Post('', $getNewest->fetchArray());

	new Redirect('./index.php?file=thread&t=' . $Thread->getThreadId() . '&page=' . $page . $SESSURL . '#' . $Post->getPostId());
}

// go to last post
else if($_GET['do'] == 'lastpost') {
	// Define AREA
	define('AREA', 'USER-THREAD');
	require_once('./includes/sessions.php');

	new Redirect('./index.php?file=thread&t=' . $Thread->getThreadId() . '&p=' . $Thread->getLastReplyPostId() . $SESSURL);
}

// go to specific post
else if($_GET['p'] AND is_numeric($_GET['p'])) {
	// Define AREA
	define('AREA', 'USER-THREAD');
	require_once('./includes/sessions.php');

	// get post info
	$Post = new Post($_GET['p']);
	$Thread = new Thread($Post->getThreadId());

	// now get all posts up UNTIL...
	$allUpTo = new Query($query['posts']['get_upto'], Array(1 => $Post->getTimeline(), $Post->getThreadId()));

	// calc page number
	$page = ceil((($Thread->getRealReplies() + 1) - $allUpTo->numRows()) / $bboptions['postsPerPage']);

	new Redirect('./index.php?file=thread&t=' . $Post->getThreadId() . '&page=' . $page . $SESSURL . '#' . $Post->getPostId());
}

// view thread
else {
	// Define AREA
	define('AREA', 'USER-THREAD');
	require_once('./includes/sessions.php');

	// poll?
	if($Thread->isPoll()) {
		$Poll = new Poll($Thread->isPoll());
	}

	else {
		$Poll = NULL;
	}

	// set if we should show deleted messages or not
	// reversing the value (meh, it's a hack so what)
	$showDeleted = 1;

	// should we show deleted?
	if($User->check('canViewDelNotices', $Thread->getForumId())) {
		$showDeleted = 2; // kind of a hack
	}

	// this just gets the number of posts (so we can do a limit)
	$allPosts = new Query($query['posts']['get_all_thread'], Array(1 => $_GET['t'], $showDeleted));
	$allPosts = $wtcDB->fetchArray($allPosts);

	// make sure we HAVE posts
	if(!$allPosts['total']) {
		new WtcBBException($lang['error_thread_invalidThread']);
	}

	// get our page number
	if($_GET['page'] <= 0 OR !is_numeric($_GET['page'])) {
		$page = 1;
	}

	else {
		$page = $_GET['page'];
	}

	// now get our start and end...
	$start = $bboptions['postsPerPage'] * ($page - 1);
	$perPage = $bboptions['postsPerPage'];

	// now build our posts
	$orderBy = 'posts_timeline';
	$postBits = ''; $whoBits = '';
	$ALT = 1;
	$post = Array();

	$displayPosts = new Query($query['posts']['get_display_thread'], Array(
																	1 => $User->info['userid'],
																	2 => $threadid,
																	3 => $showDeleted,
																	4 => $orderBy,
																	5 => $User->info['displayOrder'],
																	6 => $start,
																	7 => $perPage
																));

	// get all attachments for thread and group into array
	$attachments = new Query($query['attachments']['get_threadid'], Array(1 => $Thread->getThreadId()));

	while($attach = $attachments->fetchArray()) {
		$attaching[$attach['postid']][] = $attach;
	}

	// initialize the message parser
	$post = $wtcDB->fetchArray($displayPosts);
	$MessageParser = new Message();

	// build this for quick edit...
	$toolBar = Message::buildLiteToolBar();

	do {
		// get our post and user
		$post = new Post('', $post);
		$postUser = new User('', '', $post->getInfo());

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
		$thumbBits = '';

		if(isset($attaching[$post->getPostId()])) {
			foreach($attaching[$post->getPostId()] as $attach) {
				$Attach = new Attachment('', $attach);

				if(file_exists($Attach->getThumbPath())) {
					$temp = new StyleFragment('threaddisplay_attachThumbBit');
					$thumbBits .= $temp->dump();
				}

				$temp = new StyleFragment('threaddisplay_attachbit');
				$attachBits .= $temp->dump();
			}
		}

		// user ranks?
		$ranks = $postUser->getUserRank();

		// parse signature?
		$MessageParser->setOptions($postUser->check('canBBCode'), $postUser->check('canSmilies'), $postUser->check('canImg'), $postUser->info['allowHtml']);
		$signature = $MessageParser->parse($postUser->info['sig'], $postUser->info['username']);

		$temp = new StyleFragment('threaddisplay_bit');
		$postBits .= $temp->dump();

		if($ALT === 1) {
			$ALT = 2;
		}

		else {
			$ALT = 1;
		}
	} while($post = $wtcDB->fetchArray($displayPosts));

	// create page numbers
	$pages = new PageNumbers($page, $allPosts['total'], $bboptions['postsPerPage']);

	// what about users browsing?
	if($bboptions['browsingThread']) {
		// get the users in this thread...
		$whoBits = User::getOnlineUsers(false, $Thread->getThreadId());
	}

	// what about polls?
	// form the option bits
	if($Poll instanceof Poll AND !$Poll->isDisabled()) {
		$optionBits = ''; $ALT = 1; $public = '';

		foreach($Poll->getPollOptions() as $option) {
			// show users?
			$public = '';

			if($Poll->isPublic() AND is_array($option['voters'])) {
				$before = '';

				foreach($option['voters'] as $userid => $username) {
					$temp = new StyleFragment('threaddisplay_pollbit_pubbit');
					$public .= $temp->dump();

					$before = ', ';
				}
			}

			// do some math! YEA!
			if($Poll->getNumVotes()) {
				$percentage = floor(($option['votes'] / $Poll->getNumVotes()) * 100);
			}

			else {
				$percentage = 0;
			}

			$temp = new StyleFragment('threaddisplay_pollbit');
			$optionBits .= $temp->dump();

			if($ALT === 1) {
				$ALT = 2;
			}

			else {
				$ALT = 1;
			}
		}
	}

	// create navigation
	$Nav = new Navigation(Array(
							$Thread->getName() => ''
						), 'forum');

	// update the number of views...
	$Thread->update(Array('views' => ($Thread->getViews() + 1)));

	// insert read... if need be...
	// subscription too
	if(LOGIN) {
		new Query($query['read_threads']['insert'], Array(
														1 => $User->info['userid'],
														2 => $Thread->getThreadId(),
														3 => NOW
													));

		if($Thread->isSubscribed()) {
			$Thread->updateSubscription();
		}
	}

	$header = new StyleFragment('header');
	$content = new StyleFragment('threaddisplay');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}

?>