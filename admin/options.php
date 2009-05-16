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
## ************ BOARD OPTIONS AND CONFIG ************ ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-OPTIONS');
define('FILE_ACTION', 'Options');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

// Create array of categories...
// in case we're viewing all options
$categories = Array(
	'attachments',
	'boardAccess',
	'cookieSettings',
	'dateTime',
	'forumHome',
	'forumSettings',
	'information',
	'message',
	'posting',
	'robots',
	'setup',
	'threadSettings',
	'userOptions'
);

sort($categories);

// gotta run options query again
$grabOptions = new Query($query['global']['options']);
$cache = Array();

while($setting = $wtcDB->fetchArray($grabOptions)) {
	// no need if hidden...
	if($setting['hidden']) {
		continue;
	}

	$options[$setting['settingGroup']][$setting['displayOrder']][$setting['settingid']] = $setting;
}

// sort by display order...
foreach($options as $group => $meh) {
	ksort($options[$group]);
}

if(isset($_POST['formSet'])) {
	foreach($options as $catName => $arr) {
		if(isset($_GET['do']) AND $_GET['do'] != $catName) {
			continue;
		}

		foreach($arr as $displayOrder => $arr2) {
			foreach($arr2 as $id => $opt) {
				// we only need to update if value has changed...
				if($_POST[$opt['settingid']] == $opt['value']) {
					continue;
				}

				new Query($query['admin']['options_update'], Array(
															1 => $_POST[$opt['settingid']],
															2 => $opt['settingid']
														), 'unbuffered');
			}
		}
	}

	new Cache('BBOptions');

	$thanks = new WtcBBThanks($lang['admin_thanks_msg']);
}

// start HTML header
new AdminHTML('header', $lang['admin_options_all'], true, Array('form' => 1));

foreach($categories as $catName) {
	if(isset($_GET['do']) AND $_GET['do'] != $catName) {
		continue;
	}

	new AdminHTML('tableBegin', $lang['admin_options_' . $catName], true, Array('form' => 0));

	foreach($options[$catName] as $order => $arr) {
		foreach($arr as $settingid => $opt) {
			$fields = Array(); $selection = 0;

			// we have some drop downs here...
			if($opt['settingType'] == 'select') {
				switch($opt['name']) {
					case 'defLang':
						// get all languages
						$selection = $bboptions['defLang'];
						$fields = Language::buildLanguages();
					break;

					case 'defStyle':
						// get all styles
						Style::init();

						$selection = $bboptions['defStyle'];

						foreach($styles as $id => $obj) {
							$fields[$obj->getName()] = $id;
						}
					break;

					case 'timezone':
						$selection = $bboptions['timezone'];
						$fields = array_flip(WtcDate::buildTimeZones());
					break;

					case 'postsPerPage':
						$kaboom = preg_split('/\s+/', $bboptions['settablePostsPerPage']);
						$selection = 15;

						foreach($kaboom as $v) {
							if($opt['value'] == $v) {
								$selection = $v;
							}

							$fields[$v] = $v;
						}
					break;
				}
			}

			new AdminHTML('tableRow', Array(
											'title' => $lang[$opt['settingName']],
											'desc' => $lang[$opt['settingName'] . '_desc'],
											'type' => $opt['settingType'],
											'name' => $opt['settingid'],
											'value' => $opt['value'],
											'select' => Array(
															'fields' => $fields,
															'select' => $selection
														)
										), true);
		}
	}

	new AdminHTML('tableEnd', '', true, Array('form' => -1));
}

new AdminHTML('footer', '', true, Array('form' => 1));

?>