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