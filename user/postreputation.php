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
## **************** POST REPUTATION ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Define AREA
define('AREA', 'USER-POSTREPUTATION');
require_once('./includes/sessions.php');

//$Reputation = new Reputation($_GET['r']);
$reputed_id = $_GET['u'];

// make sure user exists
if(!User::exists($reputed_id)) {
	new WtcBBException($lang['error_userDoesNotExist']);
}

$error = ''; // sanity check

// Check user is logged in
if($User->isGuest()) {
	new WtcBBException('perm');
}

// we are good to go... for posting...
if($_POST) {
	// initiate the message parser
	$MessageParser = new Message();
	$MessageParser->autoOptions($User, new Reputation('', $_POST['postreputation']));

	// preview?
	if($_POST['preview']) {
		$preview = $MessageParser->parse($_POST['message'], $User->info['username']);
	}
	// either error or post message!
	else {
		// start checking
		$checking = $MessageParser->check($_POST['message'], $_POST['postreputation']['title']);

		// uh oh...
		if($checking instanceof WtcBBException) {
			$error = $checking->dump();
		}

		// flood
		else if($User->flood()) {
			$error = new WtcBBException($lang['error_flood'], false);
			$error = $error->dump();
		}

		if(empty($error)) {
			if($_POST['reputation_up'] || $_POST['reputation_up_x'])
				$up = 1;
			else if($_POST['reputation_down'] || $_POST['reputation_down_x'])
				$up = 0;
			else {
				$error = new WtcBBException($lang['error_noInfo'], false);
				$error = $error->dump();
			}
		}
		
		if(empty($error)) {
			// initiate
			$insert = Array();

			// okay we're good... get message
			$_POST['message'] = $checking;

			// sanity
			$_POST['postreputation'] = array_map('wtcspecialchars', $_POST['postreputation']);

			// now form our post insert
			$insert['up'] = $up;
			$insert['message'] = $_POST['message'];
			$insert['userid'] = $reputed_id;
			$insert['repby'] = $User->info['userid'];
			$insert['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$insert['rep_timeline'] = NOW;
			$insert['deleted'] = 0; $insert['edited_by'] = 0;
			$insert['repUsername'] = $User->info['username'];

			// now insert the reputation
			$repid = Reputation::insert($insert);
			// and now update the user's reputation grand total
			$member = new User($reputed_id);
			$member->computeReputation();

			new WtcBBThanks($lang['thanks_postReputation'], './index.php?file=profile&amp;do=reputation&amp;u=' . $reputed_id . $SESSURL);
		}
	}
}

// uh oh...
if($_POST) {
	$_POST = array_map_recursive('wtcspecialchars', $_POST);
}

$toolBar = Message::buildLiteToolBar();

// create navigation
	$Nav = new Navigation(
				Array(
					$lang['user_profile_profile'] => './index.php?file=profile&amp;u=' . $Member->info['userid'],
					$lang['reputation_title'] => './index.php?file=profile&amp;do=reputation&u=' . $reputed_id,
					$lang['reputation_adjust'] => ''
				)
			);

$header = new StyleFragment('header');
$content = new StyleFragment('profile_postreputation');
$footer = new StyleFragment('footer');

$header->output();
$content->output();
$footer->output();

?>