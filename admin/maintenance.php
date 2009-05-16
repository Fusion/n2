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
## *************** wtcBB MAITENANCE ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-MAINTENANCE');
define('FILE_ACTION', 'Maintenance');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();


if($_GET['do'] == 'cache') {
	// update cache...
	if(isset($_GET['cache'])) {
		// not isset... already updated...
		if(is_file($_GET['cache']) AND is_readable($_GET['cache']) AND strpos($_GET['cache'], '.cache.php') !== false) {
			// bah we have to switch through all of them...
			$cacheName = basename($_GET['cache'], '.cache.php');

			switch($cacheName) {
				case 'exts':
					$cacheName = 'AttachmentExtensions';
				break;

				case 'groups':
					$cacheName = 'Usergroups';
				break;

				case 'perms':
					$cacheName = 'ForumPerms';
				break;
			}

			new Cache($cacheName);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=maintenance&amp;do=cache');
	}

	// delete cache entry...
	if(isset($_GET['delete'])) {
		// make sure it's valid...
		if(is_file($_GET['delete']) AND is_readable($_GET['delete']) AND strpos($_GET['delete'], '.cache.php') !== false) {
			@unlink($_GET['delete']);
			new WtcBBThanks($lang['admin_thanks_msg']);
		}
	}

	// update all cache data...
	if(isset($_GET['cacheAll'])) {
		// get all cache classes...
		$dir = new DirectoryIterator('./lib/Cache');

		foreach($dir as $file) {
			if(!is_file($file->getPathname()) OR strpos($file->getPathname(), '.php') === false) {
				continue;
			}

			new Cache(substr($file->getFilename(), 0, strpos($file->getFilename(), '.')));
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=maintenance&amp;do=cache');
	}

	// clear all cache data...
	if(isset($_GET['clearAll'])) {
		if($_POST['formSet']) {
			if($_POST['delConfirm']) {
				// loop through all cache data existing and WIPE...
				$dir = new DirectoryIterator('./cache');

				foreach($dir as $iter) {
					if($iter->isDot() OR !$iter->isFile() OR !$iter->isReadable()) {
						continue;
					}

					@unlink($iter->getPathname());
				}

				new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=maintenance&amp;do=cache');
			}

			else {
				new Redirect('admin.php?file=maintenance&do=cache');
			}
		}

		new Delete('', '', '', '', true);
	}

	// trim or no trim?
	if(!isset($_GET['trim']) OR $_GET['trim'] == 1) {
		$trim = true;
	}

	else {
		$trim = false;
	}

	new AdminHTML('header', $lang['admin_maint_cache'], true, Array(
																	'form' => false,
																	'extra2' => "\t" . '<p class="marBot"><a href="admin.php?file=maintenance&amp;do=cache&amp;trim=' . ($trim ? 0 : 1) . '">' . $lang['admin_maint_cache_' . ($trim ? 'notrim' : 'trim')] . '</a> - <a href="admin.php?file=maintenance&amp;do=cache&amp;cacheAll=1">' . $lang['admin_maint_cache_updateAll'] . '</a> - <a href="admin.php?file=maintenance&amp;do=cache&amp;clearAll=1">' . $lang['admin_maint_cache_clearAll'] . '</a></p>' . "\n\n"
																	));

	// only if we HAVE a cache... allow above so users can rebuild it
	$dir = new DirectoryIterator('./cache');
	$_CACHE = Array();

	foreach($dir as $iter) {
		if(!$iter->isDot() AND $iter->isFile() AND $iter->isReadable()) {
			$_CACHE[] = $iter->getPathname();
		}
	}

	if(count($_CACHE)) {
		new AdminHTML('tableBegin', $lang['admin_maint_cache'], true, Array('colspan' => 2));

		$thCells = Array(
						$lang['admin_maint_cache_cacheName'] => Array('th' => true),
						$lang['admin_maint_cache_cacheData'] => Array('th' => true)
					);

		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		ksort($_CACHE);

		foreach($_CACHE as $cacheName) {
			$printData = trim(file_get_contents($cacheName));

			// trim data...
			if($trim) {
				$printData = trimString($printData, 500);
			}

			$printData = highlight_string($printData, true);

			$cells = Array(
						'<strong>' . basename($cacheName, '.cache.php') . '</strong><br />' . (filesize($cacheName) / 1000) . 'KB<br /><a href="admin.php?file=maintenance&amp;do=cache&amp;cache=' . $cacheName . '">' . $lang['admin_maint_cache_update'] . '</a> - <a href="admin.php?file=maintenance&amp;do=cache&amp;delete=' . $cacheName . '">' . $lang['admin_maint_cache_clear'] . '</a>' => Array('class' => 'top nowrap'),
						'<pre>' . $printData . '</pre>' => Array()
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('colspan' => 2, 'form' => false));
	}

	new AdminHTML('footer', '', true);
}

// update information
else if($_GET['do'] == 'update') {
	if($_POST) {
		// forum update
		if($_POST['forums']) {
			// run through all forums...
			$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);
			$postCounts = Array();

			foreach($forumIter as $forum) {
				// just count the posts and threads; get last reply info... reupdate
				$posts = new Query($query['posts']['count_posts'], Array(1 => $forum->info['forumid']));
				$threads = new Query($query['threads']['count_threads'], Array(1 => $forum->info['forumid']));
				$lastReply = new Query($query['threads']['lastreply'], Array(1 => $forum->info['forumid']));

				$posts = $posts->fetchArray();
				$threads = $threads->fetchArray();
				$lastReply = $lastReply->fetchArray();

				$postCounts[$forum->info['forumid']] = Array(
					'posts' => $posts['total'],
					'threads' => $threads['total'],
					'lastReply' => $lastReply
				);

				// now update
				$forum->update(
					Array(
						'posts' => $posts['total'],
						'threads' => $threads['total'],
						'last_reply_username' => $lastReply['last_reply_username'],
						'last_reply_userid' => $lastReply['last_reply_userid'],
						'last_reply_threadid' => $lastReply['threadid'],
						'last_reply_threadtitle' => $lastReply['name'],
						'last_reply_date' => $lastReply['last_reply_date']
					)
				);

				// now loop through parents to update accordingly
				if($forum->info['parent'] != -1) {
					$parentIter = new ParentForumIterator($forum->info['forumid']);

					foreach($parentIter as $parent) {
						$postCounts[$parent->info['forumid']]['posts'] += $posts['total'];
						$postCounts[$parent->info['forumid']]['threads'] += $threads['total'];

						if($lastReply['last_reply_date'] > $postCounts[$parent->info['forumid']]['lastReply']['last_reply_date']) {
							$postCounts[$parent->info['forumid']]['lastReply'] = $lastReply;
						}

						// now update
						$parent->update(
							Array(
								'posts' => $postCounts[$parent->info['forumid']]['posts'],
								'threads' => $postCounts[$parent->info['forumid']]['threads'],
								'last_reply_username' => $postCounts[$parent->info['forumid']]['lastReply']['last_reply_username'],
								'last_reply_userid' => $postCounts[$parent->info['forumid']]['lastReply']['madeby'],
								'last_reply_threadid' => $postCounts[$parent->info['forumid']]['lastReply']['threadid'],
								'last_reply_threadtitle' => $postCounts[$parent->info['forumid']]['lastReply']['name'],
								'last_reply_date' => $postCounts[$parent->info['forumid']]['lastReply']['last_reply_date']
							)
						);
					}
				}
			}
		}

		// forum update
		if($_POST['threads']) {
			// run through all threads
			$getThreads = new Query($query['threads']['get_all']);

			while($t = $getThreads->fetchArray()) {
				$Thread = new Thread('', $t);

				// now get the last post for this thread...
				$lastReply = new Query($query['posts']['get_lastreply'], Array(1 => $Thread->getThreadId()));
				$lastReply = $lastReply->fetchArray();

				$updateThread['last_reply_username'] = $lastReply['postUsername'];
				$updateThread['last_reply_userid'] = $lastReply['postby'];
				$updateThread['last_reply_date'] = $lastReply['posts_timeline'];
				$updateThread['last_reply_postid'] = $lastReply['postid'];

				$getReplies = new Query($query['posts']['nondeleted_count'], Array(1 => $Thread->getThreadId()));
				$getDelReplies = new Query($query['posts']['deleted_count'], Array(1 => $Thread->getThreadId()));

				$replies = $getReplies->fetchArray();
				$delReplies = $getDelReplies->fetchArray();

				$updateThread['replies'] = ($replies['total'] - 1);
				$updateThread['deleted_replies'] = $delReplies['total'];

				$Thread->update($updateThread);
			}
		}

		else if($_POST['users']) {
			// form forumids to count posts
			$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);
			$forumids = ''; $before = '';

			foreach($forumIter as $forum) {
				if(!$forum->info['countPosts']) {
					$forumids .= $before . $forum->info['forumid'];
					$before = ',';
				}
			}

			// yikes... can't let nothing come in!
			if(empty($forumids)) {
				$forumids = '0';
			}

			// loop through all users
			$allUsers = new Query($query['user']['all_users']);

			while($user = $allUsers->fetchArray()) {
				$obj = new User('', '', $user);

				// count user posts
				$posts = new Query($query['posts']['count_posts_user'], Array(1 => $obj->info['userid'], $forumids));
				$threads = new Query($query['threads']['count_threads_user'], Array(1 => $obj->info['userid'], $forumids));
				$lastReply = new Query($query['posts']['lastreply'], Array(1 => $obj->info['userid']));

				// put into array
				$posts = $posts->fetchArray();
				$threads = $threads->fetchArray();
				$lastReply = $lastReply->fetchArray();

				// update user
				$obj->update(
					Array(
						'posts' => $posts['total'],
						'threads' => $threads['total'],
						'lastpost' => $lastReply['posts_timeline'],
						'lastpostid' => $lastReply['postid']
					)
				);
			}
		}

		else if($_POST['usernames']) {
			// loop through all users
			$allUsers = new Query($query['user']['all_users']);

			while($user = $allUsers->fetchArray()) {
				// put into object
				$obj = new User('', '', $user);

				// i'm lazy
				$name = $obj->info['username'];
				$id = $obj->info['userid'];

				// forums
				new Query($query['forum']['update_usernames'], Array(
					1 => $name, 2 => $id
				));

				// threads (two: one for starter, and one for last reply)
				new Query($query['threads']['update_usernames_starter'], Array(
					1 => $name,	2 => $id
				));

				new Query($query['threads']['update_usernames_last'], Array(
					1 => $name, 2 => $id
				));

				// posts
				new Query($query['posts']['update_usernames'], Array(
					1 => $name, 2 => $id
				));

				// sessions
				new Query($query['sessions']['update_usernames'], Array(
					1 => $name, 2 => $id
				));

				// administrator logs
				new Query($query['log_admin']['update_usernames'], Array(
					1 => $name, 2 => $id
				));

				// moderator logs
				new Query($query['log_mod']['update_usernames'], Array(
					1 => $name, 2 => $id
				));
			}
		}

		new WtcBBThanks($lang['admin_thanks_msg']);
	}

	new AdminHTML('header', $lang['admin_maint_update'], true);

	new AdminHTML('tableBegin', $lang['admin_maint_update'], true);

	new AdminHTML('tableCells', '', true, Array(
		'cells' => Array(
				'<strong>' . $lang['admin_maint_forums'] . '</strong><p class="small">' . $lang['admin_maint_forums_desc'] . '</p>' => Array(),
				'<input type="submit" name="forums" class="button" value="' . $lang['admin_maint_update_button'] . '" />' => Array()
			)
		)
	);

	new AdminHTML('tableCells', '', true, Array(
		'cells' => Array(
				'<strong>' . $lang['admin_maint_threads'] . '</strong><p class="small">' . $lang['admin_maint_threads_desc'] . '</p>' => Array(),
				'<input type="submit" name="threads" class="button" value="' . $lang['admin_maint_update_button'] . '" />' => Array()
			)
		)
	);

	new AdminHTML('tableCells', '', true, Array(
		'cells' => Array(
				'<strong>' . $lang['admin_maint_users'] . '</strong><p class="small">' . $lang['admin_maint_users_desc'] . '</p>' => Array(),
				'<input type="submit" name="users" class="button" value="' . $lang['admin_maint_update_button'] . '" />' => Array()
			)
		)
	);

	new AdminHTML('tableCells', '', true, Array(
		'cells' => Array(
				'<strong>' . $lang['admin_maint_usernames'] . '</strong><p class="small">' . $lang['admin_maint_usernames_desc'] . '</p>' => Array(),
				'<input type="submit" name="usernames" class="button" value="' . $lang['admin_maint_update_button'] . '" />' => Array()
			)
		)
	);

	new AdminHTML('tableEnd', '', true, Array('form' => 1, 'footerText' => '&nbsp;'));

	new AdminHTML('footer', '', true);
}

// php info
else if($_GET['do'] == 'phpinfo') {
	phpinfo();
}

// execute query...
else if($_GET['do'] == 'query') {
	if(!empty($_POST['queryExec'])) {
		// execute query... and attempt to catch error...
		$error = '';

		ob_start();
		new Query($_POST['queryExec'], '', 'query', true, false);
		$error = ob_get_contents();
		ob_end_clean();

		// uh oh...
		if(!empty($error)) {
			new WtcBBException($error);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=maintenance&amp;do=query');
	}

	new AdminHTML('header', $lang['admin_maint_query'], true);

	new AdminHTML('tableBegin', $lang['admin_maint_query'], true);

	new AdminHTML('bigTextarea', Array(
									'title' => '',
									'name' => 'queryExec',
									'value' => ''
								), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

else {
	new WtcBBException($lang['error_noInfo']);
}

?>