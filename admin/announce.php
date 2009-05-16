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
## ************** wtcBB ANNOUNCEMENTS *************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-LOGS');
define('FILE_ACTION', 'Announcements');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();


if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	$nows = WtcDate::buildNows();
	
	if($_GET['do'] == 'add') {
		$which = 'add';
		
		$editinfo = Array(
						'forumid' => -1, 'parseBBCode' => 1, 'parseSmilies' => 1, 'parseHtml' => 0,
						'inherit' => 1
					);
					
		// dates and stuff...
		$editinfo['dateStart'] = Array(
									'month' => $nows['month'],
									'day' => $nows['date'],
									'year' => $nows['year']
								);
								
		$editinfo['dateEnd'] = Array(
									'month' => (($nows['month'] + 1) % 12),
									'day' => $nows['date'],
									'year' => (($nows['month'] + 1) > 12) ? ($nows['year'] + 1) : $nows['year']
								);
								
		// if forumid set... use that
		if(isset($_GET['f'])) {
			$editinfo['forumid'] = $_GET['f'];
		}
	}
	
	else {
		$which = 'edit';
		
		$announceObj = new Announcement($_GET['edit']);
		$editinfo = $announceObj->info;
		
		// get our dates...
		$dateStart = $editinfo['dateStart'];
		$dateEnd = $editinfo['dateEnd'];
		
		$editinfo['dateStart'] = Array(
									'month' => new WtcDate('m', $dateStart),
									'day' => new WtcDate('d', $dateStart),
									'year' => new WtcDate('Y', $dateStart)
								);
								
		$editinfo['dateEnd'] = Array(
									'month' => new WtcDate('m', $dateEnd),
									'day' => new WtcDate('d', $dateEnd),
									'year' => new WtcDate('Y', $dateEnd)
								);
								
		// bah turn them into actual dates
		foreach($editinfo['dateStart'] as $key => $val) {
			$editinfo['dateStart'][$key] = $val->getDate();
		}
		
		foreach($editinfo['dateEnd'] as $key => $val) {
			$editinfo['dateEnd'][$key] = $val->getDate();
		}
								
		// if forumid set, use that
		if(isset($_GET['f'])) {
			$editinfo['forumid'] = $_GET['f'];
		}
	}
	
	if($_POST['formSet']) {
		// must specify day and year...
		if(empty($_POST['dateStart']['day']) OR empty($_POST['dateStart']['year']) OR empty($_POST['dateEnd']['day']) OR empty($_POST['dateEnd']['year'])) {
			new WtcBBException($lang['admin_error_invalidDates']);
		}
		
		// make sure we have a title... and that's it
		if(empty($_POST['announce']['title'])) {
			new WtcBBException($lang['admin_error_noTitle']);
		}
		
		// form timestamps
		$_POST['announce']['dateStart'] = mktime(0, 0, 0, $_POST['dateStart']['month'], $_POST['dateStart']['day'], $_POST['dateStart']['year']);
		$_POST['announce']['dateEnd'] = mktime(0, 0, 0, $_POST['dateEnd']['month'], $_POST['dateEnd']['day'], $_POST['dateEnd']['year']);
		$_POST['announce']['dateUpdated'] = NOW;
		
		// set userid
		$_POST['announce']['userid'] = $User->info['userid'];
		
		// insert?
		if($which == 'add') {			
			// set views = 0
			$_POST['announce']['views'] = 0;
			
			Announcement::insert($_POST['announce']);
		}
		
		else {
			// errrmm... insert?
			if(isset($_GET['f'])) {
				// don't forget to set views...
				$_POST['announce']['views'] = 0;
				
				Announcement::insert($_POST['announce']);
			}
			
			else {
				$announceObj->update($_POST['announce']);
			}
		}
		
		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=announce');
	}
	
	new AdminHTML('header', $lang['admin_announce_add'], true, Array('form' => true));
	
	new AdminHTML('tableBegin', $lang['admin_announce_ae_config'], true, Array('form' => false));
	
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_announce_ae_title'],
								'desc' => $lang['admin_announce_ae_title_desc'],
								'type' => 'text',
								'name' => 'announce[title]',
								'value' => $editinfo['title']
							), true);
							
	// get forum select...
	$forumSelect = Array();
	$forumSelect[$lang['admin_allForums']] = -1;
	
	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);
	
	foreach($forumIter as $forum) {
		$forumSelect[str_repeat('-', $forumIter->getDepth()) . ' ' . $forum->info['name']] = $forum->info['forumid'];
	}
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_announce_ae_forum'],
								'desc' => $lang['admin_announce_ae_forum_desc'],
								'type' => 'select',
								'name' => 'announce[forumid]',
								'select' => Array('fields' => $forumSelect, 'select' => $editinfo['forumid'])
							), true);
							
	// start and end dates...
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_announce_ae_dateStart'],
								'desc' => $lang['admin_announce_ae_dateStart_desc'],
								'type' => 'date',
								'month' => Array(
											'name' => 'dateStart[month]',
											'value' => $editinfo['dateStart']['month']
										),
								'day' => Array(
											'name' => 'dateStart[day]',
											'value' => $editinfo['dateStart']['day']
										),
								'year' => Array(
											'name' => 'dateStart[year]',
											'value' => $editinfo['dateStart']['year']
										)
							), true);
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_announce_ae_dateEnd'],
								'desc' => $lang['admin_announce_ae_dateEnd_desc'],
								'type' => 'date',
								'month' => Array(
											'name' => 'dateEnd[month]',
											'value' => $editinfo['dateEnd']['month']
										),
								'day' => Array(
											'name' => 'dateEnd[day]',
											'value' => $editinfo['dateEnd']['day']
										),
								'year' => Array(
											'name' => 'dateEnd[year]',
											'value' => $editinfo['dateEnd']['year']
										)
							), true);
							
	// config options
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_announce_ae_bb'],
								'desc' => $lang['admin_announce_ae_bb_desc'],
								'type' => 'checkbox',
								'name' => 'announce[parseBBCode]',
								'value' => $editinfo['parseBBCode']
							), true);
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_announce_ae_smi'],
								'desc' => $lang['admin_announce_ae_smi_desc'],
								'type' => 'checkbox',
								'name' => 'announce[parseSmilies]',
								'value' => $editinfo['parseSmilies']
							), true);
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_announce_ae_html'],
								'desc' => $lang['admin_announce_ae_html_desc'],
								'type' => 'checkbox',
								'name' => 'announce[parseHtml]',
								'value' => $editinfo['parseHtml']
							), true);
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_announce_ae_inherit'],
								'desc' => $lang['admin_announce_ae_inherit_desc'],
								'type' => 'checkbox',
								'name' => 'announce[inherit]',
								'value' => $editinfo['inherit']
							), true);
							
	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	
	new AdminHTML('tableBegin', $lang['admin_announce_ae_announcement'], true, Array('form' => false));
	
	new AdminHTML('bigTextarea', Array(
									'title' => '',
									'name' => 'announce[message]',
									'value' => $editinfo['message']
								), true);
	
	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	
	new AdminHTML('footer', '', true, Array('form' => true));
}

// deletes announcement
else if(isset($_GET['delete'])) {
	$announceObj = new Announcement($_GET['delete']);
	$announceObj->destroy();
}

// announcements manager
else {
	// get all announcements
	$allAnnounce = new Query($query['announce']['get_all']);
	
	// no announcements?
	if(!$wtcDB->numRows($allAnnounce)) {
		new WtcBBException($lang['admin_error_noResults']);
	}
	
	// loop through and sort them by forumid...
	$announcements = Array();
	$announceTitles = Array();
	
	while($announce = $wtcDB->fetchArray($allAnnounce)) {
		$announcements[$announce['forumid']][$announce['dateUpdated']] = $announce;
		$announceTitles[$announce['forumid']][$announce['title']] = $announce;
	}
	
	// now sort...
	foreach($announcements as $forumid => $meh) {
		krsort($announcements["$forumid"]);
	}
	
	$solidAnnounce = $announcements;
	$announcements = Announcement::getInheritAnnounce($announcements);
	
	new AdminHTML('header', $lang['admin_announce_man'], true);
	
	// global announcements...
	if(isset($announcements["-1"])) {
		new AdminHTML('tableBegin', $lang['admin_announce_man_global'], true, Array('form' => false));
		
		$thCells = Array(
					$lang['admin_announce_man_announce'] => Array('th' => true),
					$lang['admin_options'] => Array('th' => true)
				);
				
		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));
		
		// loop...
		foreach($announcements["-1"] as $lastUpdate => $info) {
			$lastUpdateDate = new WtcDate('date', $info['dateUpdated']);
			$lastUpdateTime = new WtcDate('time', $info['dateUpdated']);
			
			$cells = Array(
						'<a href="admin.php?file=announce&amp;edit=' . $info['announceid'] . '">' . $info['title'] . '</a> <span class="small">(' . $lang['admin_lastUpdated'] . ': ' . $lastUpdateDate->getDate() . ' ' . $lang['global_at'] . ' ' . $lastUpdateTime->getDate() . ')</span>' => Array(),
						'<a href="admin.php?file=announce&amp;delete=' . $info['announceid'] . '">' . $lang['admin_delete'] . '</a>' => Array()
					);
					
			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}
		
		new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => '<a href="admin.php?file=announce&amp;do=add">' . $lang['admin_announce_man_addGlobal'] . '</a>'));
	}
	
	new AdminHTML('tableBegin', $lang['admin_announce_man_specific'], true, Array('form' => false));
	
	$thCells = Array(
					$lang['admin_forums_man_name'] => Array('th' => true),
					$lang['admin_announce_man_announce'] => Array('th' => true)
				);
	
	// loop through forums...
	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);
	
	foreach($forumIter as $forum) {
		if(($forumIter->getDepth() + 1) == 1) {
			new AdminHTML('tableCells', '', true, Array('cells' => $thCells));
		}
		
		// loop announcements and form list...
		$announceList = '';
		
		if(isset($announcements[$forum->info['forumid']])) {
			$announceList .= '<ul class="noBullets">' . "\n";
			
			foreach($announcements[$forum->info['forumid']] as $lastUpdate => $info) {
				$lastUpdateDate = new WtcDate('date', $info['dateUpdated']);
				$lastUpdateTime = new WtcDate('time', $info['dateUpdated']);
				
				// if not inherited, then put delete link...
				$delete = '';
				
				if(isset($solidAnnounce[$forum->info['forumid']][$lastUpdate])) {
					$delete =  ' - <a href="admin.php?file=announce&amp;delete=' . $info['announceid'] . '">' . $lang['admin_delete'] . '</a>';
				}
				
				$announceList .= "\t" . '<li><a href="admin.php?file=announce&amp;edit=' . $info['announceid'] . '">' . $info['title'] . '</a>' . $delete . ' <span class="small">(' . $lang['admin_lastUpdated'] . ': ' . $lastUpdateDate->getDate() . ' ' . $lang['global_at'] . ' ' . $lastUpdateTime->getDate() . ')</span></li>' . "\n";
			}
			
			$announceList .= '</ul>' . "\n";
		}		
		
		$cells = Array(
					str_repeat('-- ', $forumIter->getDepth()) . '<a href="admin.php?file=forum&amp;editForum=' . $forum->info['forumid'] . '">' . $forum->info['name'] . '</a> - <a href="admin.php?file=announce&amp;do=add&amp;f=' . $forum->info['forumid'] . '">' . $lang['admin_add'] . '</a>' => Array(),
					$announceList => Array()
				);
				
		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}
	
	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => '<a href="admin.php?file=announce&amp;do=add">' . $lang['admin_announce_add'] . '</a>'));
	
	new AdminHTML('footer', '', true);
}
	

?>