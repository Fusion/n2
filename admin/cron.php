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
## ****************** wtcBB CRON ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-CRON');
define('FILE_ACTION', 'wtcBB Cron System');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	if($_GET['do'] == 'add') {
		$which = 'add';
		$editinfo = Array(
						'title' => 'wtcBB Cron',
						'path' => './cron/wtcBBCron.php',
						'log' => 1,
						'month' => -1,
						'dayOfWeek' => -1,
						'dayOfMonth' => -1,
						'hour' => 0,
						'minute' => 0
					);
	}

	else {
		$which = 'edit';
		$cronObj = new Cron($_GET['edit']);
		$editinfo = $cronObj->getInfo();
	}

	if(isset($_POST['formSet'])) {
		if($which == 'add') {
			// make sure we have a unique name
			if(!Cron::checkUnique($_POST['cron']['title'])) {
				new WtcBBException($lang['admin_error_uniqueName']);
			}

			// make sure we have a valid file
			if(!file_exists($_POST['cron']['path'])) {
				new WtcBBException($lang['admin_error_fileDoesNotExist']);
			}

			// add next run field...
			$_POST['cron']['nextRun'] = Cron::buildNextRun($_POST['cron']);

			// insert
			Cron::insert($_POST['cron']);
		}

		else {
			// make sure we have a unique name
			if(!Cron::checkUniqueEdit($_POST['cron']['title'], $editinfo['cronid'])) {
				new WtcBBException($lang['admin_error_uniqueName']);
			}

			// make sure we have a valid file
			if(!file_exists($_POST['cron']['path'])) {
				new WtcBBException($lang['admin_error_fileDoesNotExist']);
			}

			$_POST['cron']['nextRun'] = Cron::buildNextRun($_POST['cron']);

			// insert
			$cronObj->update($_POST['cron']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=cron');
	}

	new AdminHTML('header', $lang['admin_cron_' . $which], true);
	new AdminHTML('tableBegin', $lang['admin_cron_' . $which], true, Array('form' => true));

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_cron_ae_title'],
									'desc' => $lang['admin_cron_ae_title_desc'],
									'type' => 'text',
									'name' => 'cron[title]',
									'value' => $editinfo['title']
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_cron_ae_path'],
									'desc' => $lang['admin_cron_ae_path_desc'],
									'type' => 'text',
									'name' => 'cron[path]',
									'value' => $editinfo['path']
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_cron_ae_log'],
									'desc' => $lang['admin_cron_ae_log_desc'],
									'type' => 'checkbox',
									'name' => 'cron[log]',
									'value' => $editinfo['log']
								), true);

	$weekdays = Array();
	$weekdays["*"] = -1;
	$weekdaysBuild = array_flip(WtcDate::buildWeekdays());
	$weekdays = array_merge($weekdays, $weekdaysBuild);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_cron_ae_dayOfWeek'],
									'desc' => $lang['admin_cron_ae_dayOfWeek_desc'],
									'type' => 'select',
									'name' => 'cron[dayOfWeek]',
									'select' => Array('fields' => $weekdays, 'select' => $editinfo['dayOfWeek'])
								), true);

	$days = Array();
	$days["*"] = -1;
	$daysBuild = WtcDate::buildDays();
	$days = $days + $daysBuild;

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_cron_ae_dayOfMonth'],
									'desc' => $lang['admin_cron_ae_dayOfMonth_desc'],
									'type' => 'select',
									'name' => 'cron[dayOfMonth]',
									'select' => Array('fields' => $days, 'select' => $editinfo['dayOfMonth'])
								), true);

	$hours = Array();
	$hours["*"] = -1;
	$hoursBuild = WtcDate::buildHours();
	$hours = $hours + $hoursBuild;

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_cron_ae_hour'],
									'desc' => $lang['admin_cron_ae_hour_desc'],
									'type' => 'select',
									'name' => 'cron[hour]',
									'select' => Array('fields' => $hours, 'select' => $editinfo['hour'])
								), true);

	$minutes = Array();
	$minutes["*"] = -1;
	$minutesBuild = WtcDate::buildMinutes();
	$minutes = $minutes + $minutesBuild;

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_cron_ae_minute'],
									'desc' => $lang['admin_cron_ae_minute_desc'],
									'type' => 'select',
									'name' => 'cron[minute]',
									'select' => Array('fields' => $minutes, 'select' => $editinfo['minute'])
								), true);

	new AdminHTML('tableEnd', '', true, Array('form' => true));
	new AdminHTML('footer', '', true);
}

// delete cron
else if(isset($_GET['delete'])) {
	$cronObj = new Cron($_GET['delete']);
	$cronObj->destroy();
}

// exec cron
else if(isset($_GET['exec'])) {
	$cronObj = new Cron($_GET['exec']);
	$cronObj->exec();

	new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=cron');
}

// cron manager
else {
	// put all crons into array
	$wtcBBCrons = Array();
	$getAll = new Query($query['cron']['get_all']);

	new AdminHTML('header', $lang['admin_cron_man'], true);

	if(!$wtcDB->numRows($getAll)) {
		new AdminHTML('divit', Array(
									'content' => '<a href="admin.php?file=cron&amp;do=add">' . $lang['admin_cron_add'] . '</a>',
									'class' => 'center'
								), true);
	}

	else {
		while($cron = $wtcDB->fetchArray($getAll)) {
			$wtcBBCrons[$cron['title']] = $cron;
		}

		// sort
		ksort($wtcBBCrons);

		// do default usergroups
		new AdminHTML('tableBegin', $lang['admin_cron_man'], true, Array('form' => 0, 'colspan' => 4));

		$cells = Array(
					$lang['admin_cron_man_title'] => Array('th' => true, 'class' => 'small'),
					$lang['admin_cron_man_fileName'] => Array('th' => true, 'class' => 'small'),
					$lang['admin_cron_man_nextRun'] => Array('th' => true, 'class' => 'small'),
					$lang['admin_options'] => Array('th' => true, 'class' => 'small')
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));

		foreach($wtcBBCrons as $cronTitle => $info) {
			$nextRunDate = new WtcDate('date', $info['nextRun']);
			$nextRunTime = new WtcDate('time', $info['nextRun']);

			$cells = Array(
					'<a href="admin.php?file=cron&amp;edit=' . $info['cronid'] . '">' . $cronTitle . '</a>' => Array(),
					$info['path'] => Array(),
					$nextRunDate->getDate() . ' ' . $lang['global_at'] . ' ' . $nextRunTime->getDate() => Array(),
					'<a href="admin.php?file=cron&amp;edit=' . $info['cronid'] . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=cron&amp;delete=' . $info['cronid'] . '">' . $lang['admin_delete'] . '</a> - <a href="admin.php?file=cron&amp;exec=' . $info['cronid'] . '">' . $lang['admin_cron_man_exec'] . '</a>' => Array()
				);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('form' => 0, 'colspan' => 4, 'footerText' => '<a href="admin.php?file=cron&amp;do=add">' . $lang['admin_cron_add'] . '</a>'));
	}

	new AdminHTML('footer', '', true);
}


?>