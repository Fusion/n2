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