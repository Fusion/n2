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
## ****************** SEND EMAIL ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Define AREA
define('AREA', 'USER-SENDEMAIL');
require_once('./includes/sessions.php');

// no error yet!
$error = '';

// report post
if($_GET['do'] == 'report') {
	// get the post...
	$Post = new Post($_GET['p']);

	// no post...
	if(!$Post->exists()) {
		new WtcBBException($lang['error_noInfo']);
	}

	// no error... yet
	$error = '';

	// send email
	if($_POST['sende']) {
		$_POST['sende'] = array_map('trim', $_POST['sende']);

		// no message?
		if(empty($_POST['sende']['message'])) {
			$error = new WtcBBException($lang['error_sende_noReason'], false);
		}

		// flood
		else if($User->flood()) {
			$error = new WtcBBException($lang['error_flood'], false);
		}

		else {
			// initialize the forum (and mods) and thread just for names...
			Forum::init();
			Moderator::init();
			$Thread = new Thread($Post->getThreadId());

			// build the post information...
			$content = Array(
				'username' => $User->info['username'],
				'forum' => $forums[$Post->getForumId()]->info['name'],
				'thread' => $Thread->getName(),
				'link' => 'http://wtcbb2.com/index.php?file=thread&t=' . $Thread->getThreadId() . '&p=' . $Post->getPostId(),
				'reason' => $_POST['sende']['message']
			);

			// first, email it to all moderators...
			$mods = $forums[$Post->getForumId()]->getModerators();

			if(is_array($mods)) {
				foreach($mods as $modid => $obj) {
					new Email('report', $obj->getUserid(), '', $content);
				}
			}

			new WtcBBThanks($lang['thanks_sendReport'], $_POST['sende']['myref']);
		}
	}

	if($error instanceof WtcBBException) {
		$error = $error->dump();
	}

	$content = new StyleFragment('sendemail_report');
}

// send email to member
else {
	// no error... yet
	$error = '';

	// send email
	if($_POST['sende']) {
		$_POST['sende'] = array_map('trim', $_POST['sende']);

		if(empty($_POST['sende']['username'])) {
			$error = new WtcBBException($lang['error_sende_noUser'], false);
		}

		// user does not exist?
		else if(!User::exists(0, $_POST['sende']['username'])) {
			$error = new WtcBBException($lang['error_sende_userNoExist'], false);
		}

		// no message?
		else if(empty($_POST['sende']['message'])) {
			$error = new WtcBBException($lang['error_sende_noMessage'], false);
		}

		// flood
		else if($User->flood()) {
			$error = new WtcBBException($lang['error_flood'], false);
		}

		else {
			$userObj = new User('', $_POST['sende']['username']);

			new Email('user', $userObj->info['userid'], '', $_POST['sende']['message'], $User->info['email']);

			new WtcBBThanks($lang['thanks_sendEmail'], $_POST['sende']['myref']);
		}
	}

	if($error instanceof WtcBBException) {
		$error = $error->dump();
	}

	// if user is specified, use it
	if($_GET['u']) {
		$userObj = new User($_GET['u']);

		if(!isset($_POST['sende'])) {
			$_POST['sende']['username'] = $userObj->info['username'];
		}

		$_POST['sende'] = array_map('wtcspecialchars', $_POST['sende']);
	}

	$content = new StyleFragment('sendemail_member');
}

// do nav
$Nav = new Navigation(
			Array(
				$lang['user_sende_sende'] => ''
			)
		);

$header = new StyleFragment('header');
$footer = new StyleFragment('footer');

$header->output();
$content->output();
$footer->output();

?>