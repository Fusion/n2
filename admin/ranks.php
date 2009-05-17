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
## *************** wtcBB USER RANKS ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-RANKS');
define('FILE_ACTION', 'User Ranks');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();


if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	if($_GET['do'] == 'add') {
		$which = 'add';
		$editinfo = Array();
	}
	
	else {
		$which = 'edit';
		$rankObj = new Rank($_GET['edit']);
		$editinfo = Array(
						'title' => $rankObj->getTitle(),
						'minPosts' => $rankObj->getMinPosts()
					);
	}
	
	// update rank table
	if($_POST['formSet']) {
		// no title?
		if(empty($_POST['rank']['title'])) {
			new WtcBBException($lang['admin_error_noTitle']);
		}
		
		// set min posts to 0 if not set
		if(empty($_POST['rank']['minPosts'])) {
			$_POST['rank']['minPosts'] = 0;
		}
		
		// add?
		if($which == 'add') {
			// just insert...
			Rank::insert($_POST['rank']);
		}
		
		// update
		else {
			$rankObj->update($_POST['rank']);
		}
		
		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=ranks');
	}
	
	new AdminHTML('header', $lang['admin_ranks_' . $which], true);
	
	new AdminHTML('tableBegin', $lang['admin_ranks_' . $which], true);
	
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_ranks_ae_rankTitle'],
								'desc' => $lang['admin_ranks_ae_rankTitle_desc'],
								'type' => 'text',
								'name' => 'rank[title]',
								'value' => $editinfo['title']
							), true);
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_ranks_ae_minPosts'],
								'desc' => $lang['admin_ranks_ae_minPosts_desc'],
								'type' => 'text',
								'name' => 'rank[minPosts]',
								'value' => $editinfo['minPosts']
							), true);
	
	new AdminHTML('tableEnd', '', true);
	
	new AdminHTML('footer', '', true);
}

// delete rank
else if(isset($_GET['delete'])) {
	$rankObj = new Rank($_GET['delete']);
	$rankObj->destroy();
}

else {
	// check if we have any ranks...
	$getRanks = new Query($query['rank']['get_all']);
	
	// check if we have any...
	if(!$wtcDB->numRows($getRanks)) {
		new WtcBBException($lang['admin_error_noResults']);
	}
	
	new AdminHTML('header', $lang['admin_ranks_man'], true);
	
	new AdminHTML('tableBegin', $lang['admin_ranks_man'], true, Array('form' => false, 'colspan' => 3));
	
	$thCells = Array(
				$lang['admin_ranks_man_rankTitle'] => Array('th' => true),
				$lang['admin_ranks_man_minPosts'] => Array('th' => true),
				$lang['admin_options'] => Array('th' => true)
			);
			
	new AdminHTML('tableCells', '', true, Array('cells' => $thCells));
	
	// loop and display
	while($rank = $wtcDB->fetchArray($getRanks)) {		
		$cells = Array(
					'<a href="admin.php?file=ranks&amp;edit=' . $rank['rankid'] . '">' . $rank['title'] . '</a>' => Array(),
					$rank['minPosts'] => Array(),
					'<a href="admin.php?file=ranks&amp;edit=' . $rank['rankid'] . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=ranks&amp;delete=' . $rank['rankid'] . '">' . $lang['admin_delete'] . '</a>' => Array()
				);
				
		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}		
	
	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => '<a href="admin.php?file=ranks&amp;do=add">' . $lang['admin_ranks_add'] . '</a>', 'colspan' => 3));
	
	new AdminHTML('footer', $lang['admin_ranks_man'], true);
}


?>