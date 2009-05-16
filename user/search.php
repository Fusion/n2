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
## ******************* SEARCHING ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// initiate forum info
Forum::init(); // initiates forums
ForumPerm::init(); // initiates forum permissions array
Moderator::init(); // initiates moderators array

// this checks forum permissions, usergroups, and user forum access
if(!$User->check('canSearch')) {
	new WtcBBException('perm');
}

// build search and display...
if($_GET['q'] OR $_GET['u']) {
	// Define AREA
	define('AREA', 'USER-VIEWSEARCH');
	require_once('./includes/sessions.php');

	// bad search?
	if(!$_GET['q'] AND !$_GET['u']) {
		new WtcBBException($lang['error_search_userQuery']);
	}

	// we're good to go... start forming query...
	$sql = '';

	// LOTS of switch
	switch($_GET['show']) {
		case 'posts':
			$sql = '';
			$parts = Array();

			// query?
			if($_GET['q']) {
				if($_GET['titles']) {
					$parts[] = WTC_TP . 'threads.name LIKE \'%' . $wtcDB->escapeString($_GET['q']) . '%\'';
				}

				else {
					$parts[] = WTC_TP . 'posts.message LIKE \'%' . $wtcDB->escapeString($_GET['q']) . '%\'';
				}
			}

			// username?
			if($_GET['u']) {
				if($_GET['tu']) {
					if($_GET['eu']) {
						$parts[] = WTC_TP . 'threads.threadUsername = \'' . $wtcDB->escapeString($_GET['u']) . '\'';
					}

					else {
						$parts[] = WTC_TP . 'threads.threadUsername LIKE \'%' . $wtcDB->escapeString($_GET['u']) . '%\'';
					}
				}

				else {
					if($_GET['eu']) {
						$parts[] = WTC_TP . 'posts.postUsername = \'' . $wtcDB->escapeString($_GET['u']) . '\'';
					}

					else {
						$parts[] = WTC_TP . 'posts.postUsername LIKE \'%' . $wtcDB->escapeString($_GET['u']) . '%\'';
					}
				}
			}

			if($_GET['date']) {
				switch($_GET['when']) {
					case 'older':
						$parts[] = WTC_TP . 'posts.posts_timeline <= \'' . $wtcDB->escapeString($_GET['date']) . '\'';
					break;

					// newer
					default:
						$parts[] = WTC_TP . 'posts.posts_timeline >= \'' . $wtcDB->escapeString($_GET['date']) . '\'';
					break;
				}
			}

			if(is_array($_GET['f']) AND count($_GET['f'])) {
				$before = '';
				$fids = '';

				foreach($_GET['f'] as $forumid) {
					if(!is_numeric($forumid) OR strpos($forumid, ',') !== false OR strpos($forumid, ')') !== false OR strpos($forumid, '(') !== false) {
						continue;
					}

					$fids .= $before . $wtcDB->escapeString($forumid);
					$before = ',';
				}

				if(!empty($fids)) {
					$parts[] = WTC_TP . 'posts.forumid IN (' . $fids . ')';
				}
			}

			// now form the SQL...
			$before = '';

			foreach($parts as $cond) {
				$sql .= $before . $cond;
				$before = ' AND ';
			}

			// do sort and order...
			switch(strtolower($_GET['sort'])) {
				case 'author':
					$sort = 'postUsername';
				break;

				// date
				default:
					$sort = 'posts_timeline';
				break;
			}

			switch(strtolower($_GET['order'])) {
				case 'asc':
					$order = 'ASC';
				break;

				// descending
				case 'desc':
					$order = 'DESC';
				break;
			}

			// get all threads...
			$getAllPosts = new Query($query['posts']['search_all'], Array(
				1 => $sql
			), 'query', false);

			// now fetch array (just total threads)
			$allPosts = Array();
			$allPosts['total'] = $getAllPosts->numRows();

			// build page number, start, and per page
			// get our page number
			if(!$_GET['page'] OR !is_numeric($_GET['page'])) {
				$page = 1;
			}

			else {
				$page = $_GET['page'];
			}

			$start = $bboptions['postsPerPage'] * ($page - 1);
			$perPage = $bboptions['postsPerPage'];
			$ALT = 1;
			$post = Array();
			$postBits = '';

			// whoops!
			if(($start + $perPage) > 500 AND ($start + $perPage) < (500 + $perPage)) {
				$perPage = (500 - $start);
			}

			else if(($start + $perPage) > 500) {
				new WtcBBException($lang['error_search_noResults']);
			}

			$search = new Query($query['posts']['search'], Array(
				1 => $sql,
				2 => $sort,
				3 => $order,
				4 => $start,
				5 => $perPage
			), 'query', false);

			// initialize the message parser
			$post = $wtcDB->fetchArray($search);
			$MessageParser = new Message();

			do {
				// get our post and user
				$post = new Post('', $post);
				$postUser = new User('', '', $post->getInfo());
				$Thread = new Thread('', $post->getInfo());

				// can't view?
				if(!$Thread->canView()) {
					continue;
				}

				// get dates
				$joined = new WtcDate('date', $postUser->info['joined']);
				$timeline = new WtcDate('dateTime', $post->getTimeline());
				$editedTime = '';

				if($post->actionTimeline()) {
					$editedTime = new WtcDate('dateTime', $post->actionTimeline());
				}

				// soo.... what can we do for options?
				$MessageParser->autoOptions($postUser, $post);
				$message = $MessageParser->parse($post->getMessage(), $post->getStarterName());
				$quoteText = BBCode::stripMe($post->getMessageTextArea(), 'quote');

				// highlight?
				if($_GET['q']) {
					$message = str_replace($_GET['q'], '<span style="background: #ff0;">' . wtcspecialchars($_GET['q']) . '</span>', $message);
				}

				// online or offline
				if($postUser->info['isOnline']) {
					$temp = new StyleFragment('status_online');
				}

				else {
					$temp = new StyleFragment('status_offline');
				}

				$status = $temp->dump();

				$temp = new StyleFragment('search_posts_bit');
				$postBits .= $temp->dump();

				if($ALT === 1) {
					$ALT = 2;
				}

				else {
					$ALT = 1;
				}
			} while($post = $wtcDB->fetchArray($displayPosts));

			// hmm...
			if(empty($postBits)) {
				new WtcBBException($lang['error_search_noResults']);
			}

			// create page numbers
			$pages = new PageNumbers($page, $allPosts['total'], $bboptions['postsPerPage']);

			$content = new StyleFragment('search_posts');
		break;

		// threads
		default:
			$sql = '';
			$parts = Array();

			// query?
			if($_GET['q']) {
				if($_GET['titles']) {
					$parts[] = WTC_TP . 'threads.name LIKE \'%' . $wtcDB->escapeString($_GET['q']) . '%\'';
				}

				else {
					$parts[] = WTC_TP . 'posts.message LIKE \'%' . $wtcDB->escapeString($_GET['q']) . '%\'';
				}
			}

			// username?
			if($_GET['u']) {
				if($_GET['tu']) {
					if($_GET['eu']) {
						$parts[] = WTC_TP . 'threads.threadUsername = \'' . $wtcDB->escapeString($_GET['u']) . '\'';
					}

					else {
						$parts[] = WTC_TP . 'threads.threadUsername LIKE \'%' . $wtcDB->escapeString($_GET['u']) . '%\'';
					}
				}

				else {
					if($_GET['eu']) {
						$parts[] = '(' . WTC_TP . 'threads.threadUsername = \'' . $wtcDB->escapeString($_GET['u']) . '\' OR ' . WTC_TP . 'posts.postUsername = \'' . $wtcDB->escapeString($_GET['u']) . '\')';
					}

					else {
						$parts[] = '(' . WTC_TP . 'threads.threadUsername LIKE \'%' . $wtcDB->escapeString($_GET['u']) . '%\' OR ' . WTC_TP . 'posts.postUsername LIKE \'%' . $wtcDB->escapeString($_GET['u']) . '%\')';
					}
				}
			}

			if($_GET['date']) {
				switch($_GET['when']) {
					case 'older':
						$parts[] = WTC_TP . 'threads.last_reply_date <= \'' . $wtcDB->escapeString($_GET['date']) . '\'';
					break;

					// newer
					default:
						$parts[] = WTC_TP . 'threads.last_reply_date >= \'' . $wtcDB->escapeString($_GET['date']) . '\'';
					break;
				}
			}

			if(is_array($_GET['f']) AND count($_GET['f'])) {
				$before = '';
				$fids = '';

				foreach($_GET['f'] as $forumid) {
					if(!is_numeric($forumid) OR strpos($forumid, ',') !== false OR strpos($forumid, ')') !== false OR strpos($forumid, '(') !== false) {
						continue;
					}

					$fids .= $before . $wtcDB->escapeString($forumid);
					$before = ',';
				}

				if(!empty($fids)) {
					$parts[] = WTC_TP . 'threads.forumid IN (' . $fids . ')';
				}
			}

			// now form the SQL...
			$before = '';

			foreach($parts as $cond) {
				$sql .= $before . $cond;
				$before = ' AND ';
			}

			// do sort and order...
			switch(strtolower($_GET['sort'])) {
				case 'author':
					$sort = 'threadUsername';
				break;

				case 'replies':
					$sort = 'replies';
				break;

				// date
				default:
					$sort = 'last_reply_date';
				break;
			}

			switch(strtolower($_GET['order'])) {
				case 'asc':
					$order = 'ASC';
				break;

				// descending
				case 'desc':
					$order = 'DESC';
				break;
			}

			// get all threads...
			$getAllThreads = new Query($query['threads']['search_all'], Array(
				1 => $sql
			), 'query', false);

			// now fetch array (just total threads)
			$allThreads = Array();
			$allThreads['total'] = $getAllThreads->numRows();

			// build page number, start, and per page
			// get our page number
			if(!$_GET['page'] OR !is_numeric($_GET['page'])) {
				$page = 1;
			}

			else {
				$page = $_GET['page'];
			}

			$start = $bboptions['threadsPerPage'] * ($page - 1);
			$perPage = $bboptions['threadsPerPage'];
			$ALT = 1;
			$threadBits = '';

			// whoops!
			if(($start + $perPage) > 500 AND ($start + $perPage) < (500 + $perPage)) {
				$perPage = (500 - $start);
			}

			else if(($start + $perPage) > 500) {
				new WtcBBException($lang['error_search_noResults']);
			}

			$search = new Query($query['threads']['search'], Array(
				1 => $sql,
				2 => $sort,
				3 => $order,
				4 => $start,
				5 => $perPage
			), 'query', false);

			while($thread = $search->fetchArray()) {
				// get thread object
				$obj = new Thread('', $thread);

				// can't view?
				if(!$obj->canView()) {
					continue;
				}

				// get date
				$replyDate = new WtcDate('dateTime', $obj->getLastReplyDate());

				// get page numbers (and force an URL)
				$pages = new PageNumbers(1, ($obj->getReplies() + 1), $bboptions['postsPerPage'], './index.php?file=thread&amp;t=' . $obj->getThreadId() . $SESSURL);
				$pages = $pages->getPageNumbers(true);

				// thread marker
				$markerName = $obj->getFolderName(false);

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

			// hmm...
			if(empty($threadBits)) {
				new WtcBBException($lang['error_search_noResults']);
			}

			// create page numbers
			$pages = new PageNumbers($page, $allThreads['total'], $bboptions['threadsPerPage']);

			$content = new StyleFragment('search_threads');
		break;
	}

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_search'] => './index.php?file=search',
							str_replace(':', '', $lang['user_search_results']) => ''
						));

	$header = new StyleFragment('header');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}

// search form
else {
	// Define AREA
	define('AREA', 'USER-SEARCHING');
	require_once('./includes/sessions.php');

	// no error...
	// yet...
	$error = '';

	// we just need to construct a URL from data... then send off to powerhouse!
	if($_POST) {
		$_POST['search'] = array_map('urlencode', $_POST['search']);
		$_POST['search'] = array_map('trim', $_POST['search']);

		$search = $_POST['search']; // i'm lazy
		$parts = '';
		$url = './index.php?file=search';

		// uh oh!
		if(empty($search['query']) AND empty($search['username'])) {
			$error = new WtcBBException($lang['error_search_userQuery'], false);
		}

		// flood
		else if($User->flood()) {
			$error = new WtcBBException($lang['error_flood'], false);
		}

		else {
			if($search['query']) {
				$parts .= '&amp;q=' . $search['query'];
			}

			if($search['titlesOnly']) {
				$parts .= '&amp;titles=1';
			}

			if($search['username']) {
				$parts .= '&amp;u=' . $search['username'];
			}

			if($search['exact']) {
				$parts .= '&amp;eu=1';
			}

			if($search['byUser']) {
				$parts .= '&amp;tu=1';
			}

			$parts .= '&amp;show=' . $search['showAs'];
			$parts .= '&amp;sort=' . $search['sort'];
			$parts .= '&amp;order=' . $search['order'];

			if($search['year'] AND $search['month'] AND $search['day']) {
				$parts .= '&amp;date=' . mktime(0, 0, 0, $search['month'], $search['day'], $search['year']);
				$parts .= '&amp;when=' . $search['when'];
			}

			if(is_array($_POST['forum']) AND count($_POST['forum'])) {
				foreach($_POST['forum'] as $forumid) {
					$parts .= '&amp;f%5B%5D=' . $forumid;
				}
			}

			$full = $url . $parts;

			new Redirect($full . $SESSURL);
		}

		// must be an error
		if($error instanceof WtcBBException) {
			$error = $error->dump();
		}
	}

	// construct date bits
	$monthBits = WtcDate::getMonths('search[month]', 1);
	$dayBits = WtcDate::getDays('search[day]', 1);
	$yearBits = WtcDate::getYears('search[year]', 0);

	// construct forum selection bits
	$forumSelect = Forum::constructForumSelect(true);

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_search'] => ''
						));

	$header = new StyleFragment('header');
	$content = new StyleFragment('search');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}

?>