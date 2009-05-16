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
## ****************** wtcBB LOGS ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-LOGS');
define('FILE_ACTION', 'Logs');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

// admin logs
if($_GET['do'] == 'admin') {
	// make sure we have appropriate permissions...
	if(!$User->canAdmin('logAdmin') AND !$User->canAdmin('pruneLogs')) {
		new WtcBBException($lang['admin_error_privilegesAdmin']);
	}
	
	// build nows
	$nows = WtcDate::buildNows();
	
	if(isset($_REQUEST['type'])) {
		if($_REQUEST['type'] == 'view') {
			// all users?
			if($_REQUEST['log']['userid'] == -1) {
				$userCond = '%';
			}
			
			else {
				$userCond = $_REQUEST['log']['userid'];
			}
			
			// all scripts?
			if($_REQUEST['log']['script'] == -1) {
				$scriptCond = '%';
			}
			
			else {
				$scriptCond = $_REQUEST['log']['script'];
			}
			
			// invalid order?
			if($_REQUEST['log']['orderBy'] != 'log_date' AND $_REQUEST['log']['orderBy'] != 'log_username' AND $_REQUEST['log']['orderBy'] != 'log_ip') {
				$_REQUEST['log']['orderBy'] = 'log_date';
			}
			
			// add DESC to log_date...
			if($_REQUEST['log']['orderBy'] == 'log_date') {
				$_REQUEST['log']['orderBy'] .= ' DESC';
			}
			
			// form query...
			$search = new Query($query['log_admin']['search'], Array(1 => $userCond, $scriptCond, $_REQUEST['log']['orderBy']));
			
			// nothin? o_0
			if(!$wtcDB->numRows($search)) {
				new WtcBBException($lang['admin_error_noResults']);
			}
			
			new AdminHTML('header', $lang['admin_log_admin_results'] . ' ' . $wtcDB->numRows($search), true);
			
			new AdminHTML('tableBegin', $lang['admin_log_admin_showing'], true, Array('form' => false, 'colspan' => 6));
			
			$thCells = Array(
						$lang['admin_log_logid'] => Array('th' => true),
						$lang['users_username'] => Array('th' => true),
						$lang['admin_log_date'] => Array('th' => true),
						$lang['admin_log_admin_filePath'] => Array('th' => true),
						$lang['admin_log_admin_fileAction'] => Array('th' => true),
						$lang['users_ip'] => Array('th' => true)
					);
			
			new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

			$count = -1;
			$start = ($_REQUEST['page'] - 1) * $_REQUEST['log']['perpage'];
			$end = $start + $_REQUEST['log']['perpage'];		
			
			while($log = $wtcDB->fetchArray($search)) {
				$count++;
						
				// should we skip..?
				if($count < $start) {
					continue;
				}

				// save some time and break
				if($count >= $end) {
					break;
				}
						
				$logDate = new WtcDate('date', $log['log_date']);
				$logTime = new WtcDate('time', $log['log_date']);
				
				$cells = Array(
							$log['log_adminid'] => Array('class' => 'center'),
							'<a href="admin.php?file=user&amp;edit=' . $log['log_userid'] . '">' . $log['log_username'] . '</a>' => Array(),
							$logDate->getDate() . ' ' . $lang['global_at'] . ' ' . $logTime->getDate() => Array('class' => 'small'),
							$log['log_filePath'] => Array(),
							$log['log_fileAction'] => Array(),
							$log['log_ip'] => Array()
						);
						
				new AdminHTML('tableCells', '', true, Array('cells' => $cells));
			}
			
			// form our URL...
			$url = 'admin.php?file=log&amp;do=admin&amp;type=view';
			
			// loop through our request...
			foreach($_REQUEST['log'] as $key => $v) {
				$url .= '&amp;log%5B' . $key . '%5D=' . $v;
			}
			
			// instantiate page numbers
			$pageNums = new PageNumbers($_REQUEST['page'], $wtcDB->numRows($search), $_REQUEST['log']['perpage'], $url, true);

			new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => $pageNums->getPageNumbers(), 'colspan' => 6));		
			
			new AdminHTML('footer', '', true);
			
			exit;
		}
		
		// prune
		else {
			// invalid date?
			if(empty($_POST['delete']['day']) OR empty($_POST['delete']['year'])) {
				new WtcBBException($lang['admin_error_invalidDates']);
			}
			
			// form date stamp
			$dateStamp = mktime(0, 0, 0, $_POST['delete']['month'], $_POST['delete']['day'], $_POST['delete']['year']);
			
			// all users?
			if($_POST['log']['userid'] == -1) {
				$userCond = '%';
			}
			
			else {
				$userCond = $_POST['log']['userid'];
			}
			
			// all scripts?
			if($_POST['log']['script'] == -1) {
				$scriptCond = '%';
			}
			
			else {
				$scriptCond = $_POST['log']['script'];
			}
			
			// form query...
			$delete = new Query($query['log_admin']['delete'], Array(1 => $userCond, $scriptCond, $dateStamp));
			
			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=log&amp;do=admin');
		}
	}
	
	new AdminHTML('header', $lang['admin_log_admin'], true);
	
	if($User->canAdmin('logAdmin')) {
		new AdminHTML('tableBegin', $lang['admin_log_view'], true, Array(
																			'hiddenInputs' => Array(
																								'type' => 'view',
																								'page' => 1
																							)
																		));
																		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_perpage'],
									'desc' => $lang['admin_log_perpage_desc'],
									'type' => 'text',
									'name' => 'log[perpage]',
									'value' => 15
								), true);
								
		// get usernames...
		$getUsernames = new Query($query['log_admin']['get_usernames']);
		
		$logUsers = Array();
		$logUsers[$lang['admin_allUsers']] = -1;
		
		while($logger = $wtcDB->fetchArray($getUsernames)) {
			$logUsers[$logger['log_username']] = $logger['log_userid'];
		}
		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_admin_user'],
									'desc' => $lang['admin_log_admin_user_desc'],
									'type' => 'select',
									'name' => 'log[userid]',
									'select' => Array('fields' => $logUsers, 'select' => -1)
								), true);
								
		// get file scripts...
		$getScripts = new Query($query['log_admin']['get_scripts']);
		
		$logScripts = Array();
		$logScripts[$lang['admin_log_allScripts']] = -1;
		
		while($script = $wtcDB->fetchArray($getScripts)) {
			$logScripts[$script['log_fileAction']] = $script['log_fileAction'];
		}
		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_admin_script'],
									'desc' => $lang['admin_log_admin_script_desc'],
									'type' => 'select',
									'name' => 'log[script]',
									'select' => Array('fields' => $logScripts, 'select' => -1)
								), true);
	
		// form order by
		$orderBy = Array(
					$lang['admin_log_date'] => 'log_date',
					$lang['admin_log_username'] => 'log_username',
					$lang['admin_log_ip'] => 'log_ip'
				);
				
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_orderBy'],
									'desc' => $lang['admin_log_orderBy_desc'],
									'type' => 'select',
									'name' => 'log[orderBy]',
									'select' => Array('fields' => $orderBy, 'select' => 'log_date')
								), true);
		
		new AdminHTML('tableEnd', '', true);
	}
	
	if($User->canAdmin('pruneLogs')) {
		new AdminHTML('tableBegin', $lang['admin_log_prune'], true, Array(
																			'hiddenInputs' => Array(
																								'type' => 'prune'
																							)
																		));
																		
		// get usernames...
		$getUsernames = new Query($query['log_admin']['get_usernames']);
		
		$logUsers = Array();
		$logUsers[$lang['admin_allUsers']] = -1;
		
		while($logger = $wtcDB->fetchArray($getUsernames)) {
			$logUsers[$logger['log_username']] = $logger['log_userid'];
		}
		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_admin_user'],
									'desc' => $lang['admin_log_admin_user_desc'],
									'type' => 'select',
									'name' => 'log[userid]',
									'select' => Array('fields' => $logUsers, 'select' => -1)
								), true);
								
		// get file scripts...
		$getScripts = new Query($query['log_admin']['get_scripts']);
		
		$logScripts = Array();
		$logScripts[$lang['admin_log_allScripts']] = -1;
		
		while($script = $wtcDB->fetchArray($getScripts)) {
			$logScripts[$script['log_fileAction']] = $script['log_fileAction'];
		}
		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_admin_script'],
									'desc' => $lang['admin_log_admin_script_desc'],
									'type' => 'select',
									'name' => 'log[script]',
									'select' => Array('fields' => $logScripts, 'select' => -1)
								), true);
								
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_delete'],
									'desc' => $lang['admin_log_delete_desc'],
									'type' => 'date',
									'month' => Array(
												'name' => 'delete[month]',
												'value' => $nows['month']
											),
									'day' => Array(
												'name' => 'delete[day]',
												'value' => ((($nows['date'] + 1) > $nows['numDays']) ? 1 : (date('j', NOW) + 1))
											),
									'year' => Array(
												'name' => 'delete[year]',
												'value' => $nows['year']
											)
									), true);
		
		new AdminHTML('tableEnd', '', true);
	}
	
	new AdminHTML('footer', '', true);
}

// moderator logs
else if($_GET['do'] == 'mod') {
	// make sure we have appropriate permissions...
	if(!$User->canAdmin('logMod') AND !$User->canAdmin('pruneLogs')) {
		new WtcBBException($lang['admin_error_privilegesAdmin']);
	}
	
	// build nows
	$nows = WtcDate::buildNows();
	
	if(isset($_REQUEST['type'])) {
		if($_REQUEST['type'] == 'view') {
			// all users?
			if($_REQUEST['log']['userid'] == -1) {
				$userCond = '%';
			}
			
			else {
				$userCond = $_REQUEST['log']['userid'];
			}
			
			// all scripts?
			if($_REQUEST['log']['modAction'] == -1) {
				$actionCond = '%';
			}
			
			else {
				$actionCond = $_REQUEST['log']['modAction'];
			}
			
			// invalid order?
			if($_REQUEST['log']['orderBy'] != 'log_date' AND $_REQUEST['log']['orderBy'] != 'log_username' AND $_REQUEST['log']['orderBy'] != 'log_ip' AND $_REQUEST['log']['orderBy'] != 'log_modAction') {
				$_REQUEST['log']['orderBy'] = 'log_date';
			}
			
			// add DESC to log_date...
			if($_REQUEST['log']['orderBy'] == 'log_date') {
				$_REQUEST['log']['orderBy'] .= ' DESC';
			}
			
			// form query...
			$search = new Query($query['log_mod']['search'], Array(1 => $userCond, $actionCond, $_REQUEST['log']['orderBy']));
			
			// nothin? o_0
			if(!$wtcDB->numRows($search)) {
				new WtcBBException($lang['admin_error_noResults']);
			}
			
			new AdminHTML('header', $lang['admin_log_mod_results'] . ' ' . $wtcDB->numRows($search), true);
			
			new AdminHTML('tableBegin', $lang['admin_log_admin_showing'], true, Array('form' => false, 'colspan' => 6));
			
			$thCells = Array(
						$lang['admin_log_logid'] => Array('th' => true),
						$lang['users_username'] => Array('th' => true),
						$lang['admin_log_date'] => Array('th' => true),
						$lang['admin_log_mod_oAction'] => Array('th' => true),
						$lang['admin_log_cron_cronResult'] => Array('th' => true),
						$lang['users_ip'] => Array('th' => true)
					);
			
			new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

			$count = -1;
			$start = ($_REQUEST['page'] - 1) * $_REQUEST['log']['perpage'];
			$end = $start + $_REQUEST['log']['perpage'];		
			
			while($log = $wtcDB->fetchArray($search)) {
				$count++;
						
				// should we skip..?
				if($count < $start) {
					continue;
				}

				// save some time and break
				if($count >= $end) {
					break;
				}
						
				$logDate = new WtcDate('date', $log['log_date']);
				$logTime = new WtcDate('time', $log['log_date']);
				
				$cells = Array(
							$log['log_modid'] => Array('class' => 'center'),
							'<a href="admin.php?file=user&amp;edit=' . $log['log_userid'] . '">' . $log['log_username'] . '</a>' => Array(),
							$logDate->getDate() . ' ' . $lang['global_at'] . ' ' . $logTime->getDate() => Array('class' => 'small'),
							$log['log_modAction'] => Array(),
							$log['log_results'] => Array('class' => 'small'),
							$log['log_ip'] => Array()
						);
						
				new AdminHTML('tableCells', '', true, Array('cells' => $cells));
			}
			
			// form our URL...
			$url = 'admin.php?file=log&amp;do=mod&amp;type=view';
			
			// loop through our request...
			foreach($_REQUEST['log'] as $key => $v) {
				$url .= '&amp;log%5B' . $key . '%5D=' . $v;
			}
			
			// instantiate page numbers
			$pageNums = new PageNumbers($_REQUEST['page'], $wtcDB->numRows($search), $_REQUEST['log']['perpage'], $url, true);

			new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => $pageNums->getPageNumbers(), 'colspan' => 6));		
			
			new AdminHTML('footer', '', true);
			
			exit;
		}
		
		// prune
		else {
			// invalid date?
			if(empty($_POST['delete']['day']) OR empty($_POST['delete']['year'])) {
				new WtcBBException($lang['admin_error_invalidDates']);
			}
			
			// form date stamp
			$dateStamp = mktime(0, 0, 0, $_POST['delete']['month'], $_POST['delete']['day'], $_POST['delete']['year']);
			
			// all users?
			if($_POST['log']['userid'] == -1) {
				$userCond = '%';
			}
			
			else {
				$userCond = $_POST['log']['userid'];
			}
			
			// all scripts?
			if($_POST['log']['modAction'] == -1) {
				$actionCond = '%';
			}
			
			else {
				$actionCond = $_POST['log']['modAction'];
			}
			
			// form query...
			$delete = new Query($query['log_mod']['delete'], Array(1 => $userCond, $actionCond, $dateStamp));
			
			_DEBUG($delete->getFinalSql());
			
			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=log&amp;do=mod');
		}
	}
	
	new AdminHTML('header', $lang['admin_log_admin'], true);
	
	if($User->canAdmin('logMod')) {
		new AdminHTML('tableBegin', $lang['admin_log_view'], true, Array(
																			'hiddenInputs' => Array(
																								'type' => 'view',
																								'page' => 1
																							)
																		));
																		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_perpage'],
									'desc' => $lang['admin_log_perpage_desc'],
									'type' => 'text',
									'name' => 'log[perpage]',
									'value' => 15
								), true);
								
		// get usernames...
		$getUsernames = new Query($query['log_mod']['get_usernames']);
		
		$logUsers = Array();
		$logUsers[$lang['admin_allUsers']] = -1;
		
		while($logger = $wtcDB->fetchArray($getUsernames)) {
			$logUsers[$logger['log_username']] = $logger['log_userid'];
		}
		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_admin_user'],
									'desc' => $lang['admin_log_admin_user_desc'],
									'type' => 'select',
									'name' => 'log[userid]',
									'select' => Array('fields' => $logUsers, 'select' => -1)
								), true);
								
		// get mod actions...
		$getActions = new Query($query['log_mod']['get_actions']);
		
		$logActions = Array();
		$logActions[$lang['admin_log_mod_allActions']] = -1;
		
		while($action = $wtcDB->fetchArray($getActions)) {
			$logActions[$action['log_modAction']] = $action['log_modAction'];
		}
		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_mod_action'],
									'desc' => $lang['admin_log_mod_action_desc'],
									'type' => 'select',
									'name' => 'log[modAction]',
									'select' => Array('fields' => $logActions, 'select' => -1)
								), true);
	
		// form order by
		$orderBy = Array(
					$lang['admin_log_date'] => 'log_date',
					$lang['admin_log_username'] => 'log_username',
					$lang['admin_log_ip'] => 'log_ip',
					$lang['admin_log_mod_oAction'] => 'log_modAction'
				);
				
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_orderBy'],
									'desc' => $lang['admin_log_orderBy_desc'],
									'type' => 'select',
									'name' => 'log[orderBy]',
									'select' => Array('fields' => $orderBy, 'select' => 'log_date')
								), true);
		
		new AdminHTML('tableEnd', '', true);
	}
	
	if($User->canAdmin('pruneLogs')) {
		new AdminHTML('tableBegin', $lang['admin_log_prune'], true, Array(
																			'hiddenInputs' => Array(
																								'type' => 'prune'
																							)
																		));
																		
		// get usernames...
		$getUsernames = new Query($query['log_mod']['get_usernames']);
		
		$logUsers = Array();
		$logUsers[$lang['admin_allUsers']] = -1;
		
		while($logger = $wtcDB->fetchArray($getUsernames)) {
			$logUsers[$logger['log_username']] = $logger['log_userid'];
		}
		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_admin_user'],
									'desc' => $lang['admin_log_admin_user_desc'],
									'type' => 'select',
									'name' => 'log[userid]',
									'select' => Array('fields' => $logUsers, 'select' => -1)
								), true);
								
		// get mod actions...
		$getActions = new Query($query['log_mod']['get_actions']);
		
		$logActions = Array();
		$logActions[$lang['admin_log_mod_allActions']] = -1;
		
		while($action = $wtcDB->fetchArray($getActions)) {
			$logActions[$action['log_modAction']] = $action['log_modAction'];
		}
		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_mod_action'],
									'desc' => $lang['admin_log_mod_action_desc'],
									'type' => 'select',
									'name' => 'log[modAction]',
									'select' => Array('fields' => $logActions, 'select' => -1)
								), true);
								
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_delete'],
									'desc' => $lang['admin_log_delete_desc'],
									'type' => 'date',
									'month' => Array(
												'name' => 'delete[month]',
												'value' => $nows['month']
											),
									'day' => Array(
												'name' => 'delete[day]',
												'value' => ((($nows['date'] + 1) > $nows['numDays']) ? 1 : ($nows['date'] + 1))
											),
									'year' => Array(
												'name' => 'delete[year]',
												'value' => $nows['year']
											)
									), true);
		
		new AdminHTML('tableEnd', '', true);
	}
	
	new AdminHTML('footer', '', true);
}

// cron logs
else if($_GET['do'] == 'cron') {
	// make sure we have appropriate permissions...
	if(!$User->canAdmin('logCron') AND !$User->canAdmin('pruneLogs')) {
		new WtcBBException($lang['admin_error_privilegesAdmin']);
	}
	
	$nows = WtcDate::buildNows();
	
	if(isset($_REQUEST['type'])) {
		if($_REQUEST['type'] == 'view') {
			// all scripts?
			if($_REQUEST['log']['script'] == -1) {
				$scriptCond = '%';
			}
			
			else {
				$scriptCond = $_REQUEST['log']['script'];
			}
			
			// invalid order?
			if($_REQUEST['log']['orderBy'] != 'log_date' AND $_REQUEST['log']['orderBy'] != 'log_file' AND $_REQUEST['log']['orderBy'] != 'log_crontitle') {
				$_REQUEST['log']['orderBy'] = 'log_date';
			}
			
			// add DESC to log_date...
			if($_REQUEST['log']['orderBy'] == 'log_date') {
				$_REQUEST['log']['orderBy'] .= ' DESC';
			}
			
			// form query...
			$search = new Query($query['log_cron']['search'], Array(1 => $scriptCond, $_REQUEST['log']['orderBy']));
			
			// nothin? o_0
			if(!$wtcDB->numRows($search)) {
				new WtcBBException($lang['admin_error_noResults']);
			}
			
			new AdminHTML('header', $lang['admin_log_cron_results'] . ' ' . $wtcDB->numRows($search), true);
			
			new AdminHTML('tableBegin', $lang['admin_log_admin_showing'], true, Array('form' => false, 'colspan' => 5));
			
			$thCells = Array(
						$lang['admin_log_logid'] => Array('th' => true),
						$lang['admin_log_cron_title'] => Array('th' => true),
						$lang['admin_log_date'] => Array('th' => true),
						$lang['admin_log_cron_file'] => Array('th' => true),
						$lang['admin_log_cron_cronResult'] => Array('th' => true)
					);
			
			new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

			$count = -1;
			$start = ($_REQUEST['page'] - 1) * $_REQUEST['log']['perpage'];
			$end = $start + $_REQUEST['log']['perpage'];		
			
			while($log = $wtcDB->fetchArray($search)) {
				$count++;
						
				// should we skip..?
				if($count < $start) {
					continue;
				}

				// save some time and break
				if($count >= $end) {
					break;
				}
						
				$logDate = new WtcDate('date', $log['log_date']);
				$logTime = new WtcDate('time', $log['log_date']);
				
				$cells = Array(
							$log['log_cronid'] => Array('class' => 'center'),
							$log['log_crontitle'] => Array(),
							$logDate->getDate() . ' ' . $lang['global_at'] . ' ' . $logTime->getDate() => Array('class' => 'small'),
							$log['log_file'] => Array(),
							$log['log_results'] => Array('class' => 'small')
						);
						
				new AdminHTML('tableCells', '', true, Array('cells' => $cells));
			}
			
			// form our URL...
			$url = 'admin.php?file=log&amp;do=cron&amp;type=view';
			
			// loop through our request...
			foreach($_REQUEST['log'] as $key => $v) {
				$url .= '&amp;log%5B' . $key . '%5D=' . $v;
			}
			
			// instantiate page numbers
			$pageNums = new PageNumbers($_REQUEST['page'], $wtcDB->numRows($search), $_REQUEST['log']['perpage'], $url, true);

			new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => $pageNums->getPageNumbers(), 'colspan' => 5));		
			
			new AdminHTML('footer', '', true);
			
			exit;
		}
		
		// prune
		else {
			// invalid date?
			if(empty($_POST['delete']['day']) OR empty($_POST['delete']['year'])) {
				new WtcBBException($lang['admin_error_invalidDates']);
			}
			
			// form date stamp
			$dateStamp = mktime(0, 0, 0, $_POST['delete']['month'], $_POST['delete']['day'], $_POST['delete']['year']);
						
			// all scripts?
			if($_POST['log']['script'] == -1) {
				$scriptCond = '%';
			}
			
			else {
				$scriptCond = $_POST['log']['script'];
			}
			
			// form query...
			$delete = new Query($query['log_cron']['delete'], Array(1 => $scriptCond, $dateStamp));
			
			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=log&amp;do=cron');
		}
	}
	
	new AdminHTML('header', $lang['admin_log_cron'], true);
	
	if($User->canAdmin('logCron')) {
		new AdminHTML('tableBegin', $lang['admin_log_view'], true, Array(
																			'hiddenInputs' => Array(
																								'type' => 'view',
																								'page' => 1
																							)
																		));
																		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_perpage'],
									'desc' => $lang['admin_log_perpage_desc'],
									'type' => 'text',
									'name' => 'log[perpage]',
									'value' => 15
								), true);
								
		// get cron scripts...
		$getScripts = new Query($query['log_cron']['get_scripts']);
		
		$logScripts = Array();
		$logScripts[$lang['admin_log_cron_allCrons']] = -1;
		
		while($logger = $wtcDB->fetchArray($getScripts)) {
			$logScripts[$logger['log_file']] = $logger['log_file'];
		}
		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_cron_cron'],
									'desc' => $lang['admin_log_cron_cron_desc'],
									'type' => 'select',
									'name' => 'log[script]',
									'select' => Array('fields' => $logScripts, 'select' => -1)
								), true);
	
		// form order by
		$orderBy = Array(
					$lang['admin_log_date'] => 'log_date',
					$lang['admin_log_cron_file'] => 'log_file',
					$lang['admin_log_cron_title'] => 'log_crontitle'
				);
				
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_orderBy'],
									'desc' => $lang['admin_log_orderBy_desc'],
									'type' => 'select',
									'name' => 'log[orderBy]',
									'select' => Array('fields' => $orderBy, 'select' => 'log_date')
								), true);
		
		new AdminHTML('tableEnd', '', true);
	}
	
	if($User->canAdmin('pruneLogs')) {
		new AdminHTML('tableBegin', $lang['admin_log_prune'], true, Array(
																			'hiddenInputs' => Array(
																								'type' => 'prune'
																							)
																		));
																		
		// get cron scripts...
		$getScripts = new Query($query['log_cron']['get_scripts']);
		
		$logScripts = Array();
		$logScripts[$lang['admin_log_cron_allCrons']] = -1;
		
		while($logger = $wtcDB->fetchArray($getScripts)) {
			$logScripts[$logger['log_file']] = $logger['log_file'];
		}
		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_cron_cron'],
									'desc' => $lang['admin_log_cron_cron_desc'],
									'type' => 'select',
									'name' => 'log[script]',
									'select' => Array('fields' => $logScripts, 'select' => -1)
								), true);
								
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_log_delete'],
									'desc' => $lang['admin_log_delete_desc'],
									'type' => 'date',
									'month' => Array(
												'name' => 'delete[month]',
												'value' => $nows['month']
											),
									'day' => Array(
												'name' => 'delete[day]',
												'value' => ((($nows['date'] + 1) > $nows['numDays']) ? 1 : ($nows['date'] + 1))
											),
									'year' => Array(
												'name' => 'delete[year]',
												'value' => $nows['year']
											)
									), true);
		
		new AdminHTML('tableEnd', '', true);
	}
	
	new AdminHTML('footer', '', true);
}


?>