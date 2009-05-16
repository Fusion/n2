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
## ***************** MISCELLANEOUS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


/**
 * This file is mainly used for little miscellaneous things
 * that don't really fit anywhere else. (ie: mark forums read)
 */


if($_GET['do'] == 'markRead') {
	// Define AREA
	define('AREA', 'USER-MISC-MARKREAD');
	require_once('./includes/sessions.php');

	// marking only a single forum?
	if($User->info['userid']) {
		if($_GET['f']) {
		}

		else {
			// update any forums in the db
			new Query($query['read_forums']['update_markRead'], Array(
																	1 => NOW,
																	2 => $User->info['userid']
																));

			// update any threads in the db
			new Query($query['read_threads']['update_markRead'], Array(
																	1 => NOW,
																	2 => $User->info['userid']
																));

			// update user... acts as a marker
			$User->update(Array('markedRead' => NOW));
		}
	}

	new WtcBBThanks($lang['thanks_markRead']);
}

// get our smilies
else if($_GET['do'] == 'smilies') {
	if(!($smilies = Cache::load('smilies'))) {
		$smilies = Smiley::init();
	}

	$alt = true; $bits = ''; $bits2 = '';
	foreach($smilies as $groupid => $more) {
		foreach($more as $id => $obj) {
			if($count > $bboptions['smilies']) {
				break;
			}

			$temp = new StyleFragment('smileywin_bit');

			if($alt) {
				$bits .= $temp->dump();
			}

			else {
				$bits2 .= $temp->dump();
			}

			if($alt) {
				$alt = false;
			}

			else {
				$alt = true;
			}
		}
	}

	$header = new StyleFragment('header_smallWindow');
	$content = new StyleFragment('smileywin');
	$footer = new StyleFragment('footer_smallWindow');

	$header->output();
	$content->output();
	$footer->output();
}


?>