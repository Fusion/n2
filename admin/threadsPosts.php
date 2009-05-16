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
## **************** wtcBB BB Code ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-THREADS_POSTS');
define('FILE_ACTION', 'Threads & Posts');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

if($_GET['do'] == 'prunePosts') {
	if($_POST['formSet']) {
		// start forming query...
		$sql = 'SELECT ' . WTC_TP . 'posts.*, ' . WTC_TP . 'threads.* FROM ' . WTC_TP . 'posts LEFT JOIN ' . WTC_TP . 'threads ON ' . WTC_TP . 'threads.threadid = ' . WTC_TP . 'posts.threadid';
		$sqlparts = Array();
		$dateAfter = $_POST['dateAfter'];
		$dateBefore = $_POST['dateBefore'];
		$massprune = array_map('trim', $_POST['massprune']);

		// dates?
		if($dateAfter['month'] AND $dateAfter['day'] AND $dateAfter['year']) {
			$sqlparts[] = WTC_TP . 'posts.posts_timeline >= \'' . mktime(0, 0, 0, $dateAfter['month'], $dateAfter['day'], $dateAfter['year']) . '\'';
		}

		if($dateBefore['month'] AND $dateBefore['day'] AND $dateBefore['year']) {
			$sqlparts[] = WTC_TP . 'posts.posts_timeline <= \'' . mktime(0, 0, 0, $dateBefore['month'], $dateBefore['day'], $dateBefore['year']) . '\'';
		}

		if(!empty($massprune['username'])) {
			$sqlparts[] = WTC_TP . 'posts.postUsername = \'' . $wtcDB->escapeString($massprune['username']) . '\'';
		}

		if($massprune['start'] > 0) {
			$sqlparts[] = WTC_TP . 'posts.forumid = \'' . $wtcDB->escapeString($massprune['start']) . '\'';
		}

		if(count($sqlparts)) {
			$sql .= ' WHERE ';
			$before = '';

			foreach($sqlparts as $formed) {
				$sql .= $before . $formed;
				$before = ' AND ';
			}
		}

		// run it...
		$posts = new Query($sql);

		// uh oh...
		if(!$posts->numRows()) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		// good to go!
		while($mypost = $posts->fetchArray()) {
			$Post = new Post('', $mypost);
			$Thread = new Thread('', $mypost);

			// make sure it isn't the first post... if so, delete thread...
			if($Post->getPostId() == $Thread->getFirstPostId()) {
				$Thread->permDelete();
			}

			else {
				// easy peasy
				$Post->permDelete($Thread);
			}
		}

		new WtcBBThanks($lang['admin_thanks_msg']);
	}

	new AdminHTML('header', $lang['admin_threadsPosts_massPruneP'], true);
	new AdminHTML('tableBegin', $lang['admin_threadsPosts_massPruneP'], true, Array('form' => true));

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_threadsPosts_massPrune_postAfter'],
									'desc' => $lang['admin_threadsPosts_massPrune_postAfter_desc'],
									'type' => 'date',
									'month' => Array(
										'name' => 'dateAfter[month]',
										'value' => 0
									),
									'day' => Array(
										'name' => 'dateAfter[day]',
										'value' => 0
									),
									'year' => Array(
										'name' => 'dateAfter[year]',
										'value' => 0
									)
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_threadsPosts_massPrune_postBefore'],
									'desc' => $lang['admin_threadsPosts_massPrune_postBefore_desc'],
									'type' => 'date',
									'month' => Array(
										'name' => 'dateBefore[month]',
										'value' => 0
									),
									'day' => Array(
										'name' => 'dateBefore[day]',
										'value' => 0
									),
									'year' => Array(
										'name' => 'dateBefore[year]',
										'value' => 0
									)
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_threadsPosts_massPrune_postUser'],
									'desc' => $lang['admin_threadsPosts_massPrune_postUser_desc'],
									'type' => 'text',
									'name' => 'massprune[username]',
									'value' => ''
								), true);

	// get forum select...
	$forumSelect = Array();
	$forumSelect[$lang['admin_allForums']] = -1;

	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

	foreach($forumIter as $forum) {
		$forumSelect[str_repeat('-', $forumIter->getDepth()) . ' ' . $forum->info['name']] = $forum->info['forumid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_threadsPosts_massPrune_postStartForum'],
								'desc' => $lang['admin_threadsPosts_massPrune_postStartForum_desc'],
								'type' => 'select',
								'name' => 'massprune[start]',
								'select' => Array('fields' => $forumSelect, 'select' => -1)
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => true));
	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'pruneThreads') {
	if($_POST['formSet']) {
		// start forming query...
		$sql = 'SELECT * FROM ' . WTC_TP . 'threads';
		$sqlparts = Array();
		$dateAfter = $_POST['dateAfter'];
		$dateBefore = $_POST['dateBefore'];
		$massprune = array_map('trim', $_POST['massprune']);

		// dates?
		if($dateAfter['month'] AND $dateAfter['day'] AND $dateAfter['year']) {
			$sqlparts[] = WTC_TP . 'threads.last_reply_date >= \'' . mktime(0, 0, 0, $dateAfter['month'], $dateAfter['day'], $dateAfter['year']) . '\'';
		}

		if($dateBefore['month'] AND $dateBefore['day'] AND $dateBefore['year']) {
			$sqlparts[] = WTC_TP . 'threads.last_reply_date <= \'' . mktime(0, 0, 0, $dateBefore['month'], $dateBefore['day'], $dateBefore['year']) . '\'';
		}

		if(!empty($massprune['username'])) {
			$sqlparts[] = WTC_TP . 'threads.threadUsername = \'' . $wtcDB->escapeString($massprune['username']) . '\'';
		}

		if($massprune['start'] > 0) {
			$sqlparts[] = WTC_TP . 'threads.forumid = \'' . $wtcDB->escapeString($massprune['start']) . '\'';
		}

		if(count($sqlparts)) {
			$sql .= ' WHERE ';
			$before = '';

			foreach($sqlparts as $formed) {
				$sql .= $before . $formed;
				$before = ' AND ';
			}
		}

		// run it...
		$threads = new Query($sql);

		// uh oh...
		if(!$threads->numRows()) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		// good to go!
		while($mythread = $threads->fetchArray()) {
			$Thread = new Thread('', $mythread);

			// easy peasy
			$Thread->permDelete();
		}

		new WtcBBThanks($lang['admin_thanks_msg']);
	}

	new AdminHTML('header', $lang['admin_threadsPosts_massPruneT'], true);
	new AdminHTML('tableBegin', $lang['admin_threadsPosts_massPruneT'], true, Array('form' => true));

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_threadsPosts_massPrune_threadAfter'],
									'desc' => $lang['admin_threadsPosts_massPrune_threadAfter_desc'],
									'type' => 'date',
									'month' => Array(
										'name' => 'dateAfter[month]',
										'value' => 0
									),
									'day' => Array(
										'name' => 'dateAfter[day]',
										'value' => 0
									),
									'year' => Array(
										'name' => 'dateAfter[year]',
										'value' => 0
									)
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_threadsPosts_massPrune_threadBefore'],
									'desc' => $lang['admin_threadsPosts_massPrune_threadBefore_desc'],
									'type' => 'date',
									'month' => Array(
										'name' => 'dateBefore[month]',
										'value' => 0
									),
									'day' => Array(
										'name' => 'dateBefore[day]',
										'value' => 0
									),
									'year' => Array(
										'name' => 'dateBefore[year]',
										'value' => 0
									)
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_threadsPosts_massPrune_user'],
									'desc' => $lang['admin_threadsPosts_massPrune_user_desc'],
									'type' => 'text',
									'name' => 'massprune[username]',
									'value' => ''
								), true);

	// get forum select...
	$forumSelect = Array();
	$forumSelect[$lang['admin_allForums']] = -1;

	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

	foreach($forumIter as $forum) {
		$forumSelect[str_repeat('-', $forumIter->getDepth()) . ' ' . $forum->info['name']] = $forum->info['forumid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_threadsPosts_massPrune_startForum'],
								'desc' => $lang['admin_threadsPosts_massPrune_startForum_desc'],
								'type' => 'select',
								'name' => 'massprune[start]',
								'select' => Array('fields' => $forumSelect, 'select' => -1)
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => true));
	new AdminHTML('footer', '', true);
}

// move threads
else {
	if($_POST['formSet']) {
		// start forming query...
		$sql = 'SELECT * FROM ' . WTC_TP . 'threads';
		$sqlparts = Array();
		$dateAfter = $_POST['dateAfter'];
		$dateBefore = $_POST['dateBefore'];
		$massmove = array_map('trim', $_POST['massmove']);

		// dates?
		if($dateAfter['month'] AND $dateAfter['day'] AND $dateAfter['year']) {
			$sqlparts[] = WTC_TP . 'threads.last_reply_date >= \'' . mktime(0, 0, 0, $dateAfter['month'], $dateAfter['day'], $dateAfter['year']) . '\'';
		}

		if($dateBefore['month'] AND $dateBefore['day'] AND $dateBefore['year']) {
			$sqlparts[] = WTC_TP . 'threads.last_reply_date <= \'' . mktime(0, 0, 0, $dateBefore['month'], $dateBefore['day'], $dateBefore['year']) . '\'';
		}

		if(!empty($massmove['username'])) {
			$sqlparts[] = WTC_TP . 'threads.threadUsername = \'' . $wtcDB->escapeString($massmove['username']) . '\'';
		}

		if($massmove['start'] > 0) {
			$sqlparts[] = WTC_TP . 'threads.forumid = \'' . $wtcDB->escapeString($massmove['start']) . '\'';
		}

		if(count($sqlparts)) {
			$sql .= ' WHERE ';
			$before = '';

			foreach($sqlparts as $formed) {
				$sql .= $before . $formed;
				$before = ' AND ';
			}
		}

		// run it...
		$threads = new Query($sql);

		// uh oh...
		if(!$threads->numRows()) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		// moving to...
		$MoveTo = new Forum($massmove['destination']);

		// good to go!
		while($mythread = $threads->fetchArray()) {
			$Thread = new Thread('', $mythread);

			// easy peasy
			$Thread->copy($MoveTo, true);
		}

		new WtcBBThanks($lang['admin_thanks_msg']);
	}

	new AdminHTML('header', $lang['admin_threadsPosts_massMove'], true);
	new AdminHTML('tableBegin', $lang['admin_threadsPosts_massMove'], true, Array('form' => true));

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_threadsPosts_massMove_threadAfter'],
									'desc' => $lang['admin_threadsPosts_massMove_threadAfter_desc'],
									'type' => 'date',
									'month' => Array(
										'name' => 'dateAfter[month]',
										'value' => 0
									),
									'day' => Array(
										'name' => 'dateAfter[day]',
										'value' => 0
									),
									'year' => Array(
										'name' => 'dateAfter[year]',
										'value' => 0
									)
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_threadsPosts_massMove_threadBefore'],
									'desc' => $lang['admin_threadsPosts_massMove_threadBefore_desc'],
									'type' => 'date',
									'month' => Array(
										'name' => 'dateBefore[month]',
										'value' => 0
									),
									'day' => Array(
										'name' => 'dateBefore[day]',
										'value' => 0
									),
									'year' => Array(
										'name' => 'dateBefore[year]',
										'value' => 0
									)
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_threadsPosts_massMove_user'],
									'desc' => $lang['admin_threadsPosts_massMove_user_desc'],
									'type' => 'text',
									'name' => 'massmove[username]',
									'value' => ''
								), true);

	// get forum select...
	$forumSelect = Array();
	$forumSelect[$lang['admin_allForums']] = -1;

	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

	foreach($forumIter as $forum) {
		$forumSelect[str_repeat('-', $forumIter->getDepth()) . ' ' . $forum->info['name']] = $forum->info['forumid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_threadsPosts_massMove_startForum'],
								'desc' => $lang['admin_threadsPosts_massMove_startForum_desc'],
								'type' => 'select',
								'name' => 'massmove[start]',
								'select' => Array('fields' => $forumSelect, 'select' => -1)
							), true);

	// get forum select...
	$forumSelect = Array();
	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

	foreach($forumIter as $forum) {
		$forumSelect[str_repeat('-', $forumIter->getDepth()) . ' ' . $forum->info['name']] = Array(
			'value' => $forum->info['forumid'],
			'disabled' => $forum->info['isCat']
		);
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_threadsPosts_massMove_destination'],
								'desc' => $lang['admin_threadsPosts_massMove_destination_desc'],
								'type' => 'select',
								'name' => 'massmove[destination]',
								'select' => Array('fields' => $forumSelect, 'select' => 0)
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => true));
	new AdminHTML('footer', '', true);
}


?>