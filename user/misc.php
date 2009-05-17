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