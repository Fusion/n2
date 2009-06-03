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

if($_GET['do'] == 'poll') {
	define('AREA', 'USER-PROFILE');
	require_once('./includes/sessions.php');

	// this just gets the number of posts (so we can do a limit)
	$allReps = new Query($query['posts']['get_all_thread'], Array(1 => $_GET['t'], $showDeleted));
	$allReps = $wtcDB->fetchArray($allReps);
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