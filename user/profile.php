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
## **************** MEMBER PROFILE ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

if($_GET['do'] == 'restorereputation') {
	define('AREA', 'USER-PROFILE');
	require_once('./includes/sessions.php');

	// get the post and the thread
	$Reputation = new Reputation($_GET['p']);

	// can only do this if they can view deletion notices
	if(!$User->check('canViewDelNotices')) {
		new WtcBBException('perm');
	}

	// not deleted?
	if(!$Reputation->isDeleted()) {
		new WtcBBException($lang['error_forum_postNotDel']);
	}

	// alright... restore it
	$Reputation->restore();

	new WtcBBThanks($lang['thanks_restoredPost']);
}

// post deletion
else if($_GET['do'] == 'deletereputation') {
	define('AREA', 'USER-PROFILE');
	require_once('./includes/sessions.php');

	// can only do this if they can view deletion notices
	if(!$User->check('canViewDelNotices')) {
		new WtcBBException('perm');
	}

	// no selection?
	if(!is_array($_GET['p']) OR !count($_GET['p'])) {
		new WtcBBException($lang['error_noSelection']);
	}

	// get all the posts
	$reputations = new Query($query['reputations']['get_manyById'], Array(1 => implode(',', $_GET['p'])));

	if(!$reputations->numRows()) {
		new WtcBBException($lang['error_noSelection']);
	}


	// now iterate
	while($reputation = $reputations->fetchArray()) {
		// create new object
		$reputationObj = new Reputation('', $reputation);

		// delete!
		$reputationObj->softDelete();
	}

	// thanks
	new WtcBBThanks($lang['thanks_postsDeleted'], './index.php?file=profile&amp;do=reputation&amp;u=' . 1 . $SESSURL);
}
else if($_GET['do'] == 'reputation') {
	define('AREA', 'USER-PROFILE');
	require_once('./includes/sessions.php');

	// Who?	
	$Member = new User($_GET['u']);
	$showDeleted = 1;
	// should we show deleted?
	if($User->check('canViewDelNotices')) {
		$showDeleted = 2; // kind of a hack
	}	
	
	// this just gets the number of reputations (so we can do a limit)
	$allReps = new Query($query['reputations']['get_all_member'], Array(1 => $Member->info['userid'], $showDeleted));
	$allReps = $wtcDB->fetchArray($allReps);

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
	$orderBy = 'rep_timeline';
	$postBits = ''; $whoBits = '';
	$ALT = 1;
	$rep = Array();

	$MessageParser = new Message();
	$toolBar = Message::buildLiteToolBar();
		
	$displayReps = new Query($query['reputations']['get_display_reputation'], Array(
																	1 => $Member->info['userid'],
																	2 => $showDeleted,
																	3 => $orderBy,
																	4 => 'DESC',
																	5 => $start,
																	6 => $perPage
																));
	$rep = $wtcDB->fetchArray($displayReps);
	if($rep)
	{
		do {
			// get our post and user
			$rep = new Reputation('', $rep);
			$repUser = new User('', '', $rep->getInfo());
	
			// get dates
			$joined = new WtcDate('date', $repUser->info['joined']);
			$timeline = new WtcDate('dateTime', $rep->getTimeline());
			$editedTime = ''; $signature = '';
	
			$MessageParser->autoOptions($repUser, $rep);
			$message = $MessageParser->parse($rep->getMessage(), $rep->getReputationGiverName());
	
			// online or offline
			if($repUser->info['isOnline']) {
				$temp = new StyleFragment('status_online');
			}
	
			else {
				$temp = new StyleFragment('status_offline');
			}
	
			$status = $temp->dump();
	
			// user ranks?
			$ranks = $repUser->getUserRank();
	
			$temp = new StyleFragment('reputationdisplay_bit');
			$repBits .= $temp->dump();
	
			if($ALT === 1) {
				$ALT = 2;
			}
	
			else {
				$ALT = 1;
			}
		} while($rep = $wtcDB->fetchArray($displayReps));	
	}

	// create page numbers
	$pages = new PageNumbers($page, $allReps['total'], $bboptions['postsPerPage']);

	// create navigation
	$Nav = new Navigation(Array(
							'Reputation Nav' => ''
						), 'forum');

	$header = new StyleFragment('header');
	$content = new StyleFragment('reputationdisplay');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}
else {
	// Define AREA
	define('AREA', 'USER-PROFILE');
	require_once('./includes/sessions.php');
	
	// get our member...
	$Member = new User($_GET['u']);
	
	$joined = new WtcDate('dateTime', $Member->info['joined']);
	$lastPost = ''; $lastActive = ''; $birthday = '';
	
	if($Member->info['lastpost']) {
		$lastPost = new WtcDate('dateTime', $Member->info['lastpost']);
	}
	
	if($Member->info['lastactivity']) {
		$lastActive = new WtcDate('dateTime', $Member->info['lastactivity']);
	}
	
	if($Member->info['birthday']) {
		$birthday = new WtcDate('date', $Member->info['birthday']);
	}
	
	// start the ALT... it is maintained in IF conditionals
	// inside the profile template
	// so we can maintain alternating row colors if a field is missing
	$ALT = 2; $ALT_USE = 2; $GROUP_ALT = 1;
	
	// now start fetching custom profile field data...
	$customBits = '';
	$fieldBits = '';
	$haveFields = false;
	
	// initialize our categories and fields...
	Group::init();
	CustomPro::init();
	
	if(is_array($generalGroups['custom_pro'])) {
		$groupIter = new GroupIterator('custom_pro');
	
		foreach($groupIter as $group) {
			$haveFields = false;
			$fieldBits = '';
			$GROUP_ALT = 1;
	
			if(is_array($profs[$group->getGroupId()])) {
				foreach($profs[$group->getGroupId()] as $id => $prof) {
					$fieldName = $prof->getName();
					$fieldValue = trim($Member->info[$prof->getColName()]);
					$fieldDesc = trim($prof->getDesc());
	
					if(!empty($fieldValue)) {
						$haveFields = true;
						$temp = new StyleFragment('profile_category_field');
						$fieldBits .= $temp->dump();
	
						if($GROUP_ALT == 1) {
							$GROUP_ALT = 2;
						}
	
						else {
							$GROUP_ALT = 1;
						}
					}
				}
			}
	
			// only continue if we have at least one field...
			if(!$haveFields) {
				continue;
			}
	
			$temp = new StyleFragment('profile_category');
			$customBits .= $temp->dump();
		}
	}
	
	// do nav
	$Nav = new Navigation(
				Array(
					$lang['user_profile_profile'] => ''
				)
			);
	
	$header = new StyleFragment('header');
	$content = new StyleFragment('profile');
	$footer = new StyleFragment('footer');
	
	$header->output();
	$content->output();
	$footer->output();
}

?>