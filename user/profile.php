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
## **************** MEMBER PROFILE ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


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

?>