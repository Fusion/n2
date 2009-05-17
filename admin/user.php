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
## ********************** USER ********************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-USERS');
define('FILE_ACTION', 'Users');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

if(isset($_GET['delete'])) {
	$userObj = new User($_GET['delete']);

	if($_POST['formSet']) {
		if($_POST['delConfirm']) {
			$userObj->destroy();

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=user&amp;do=search');
		}

		else {
			new Redirect('admin.php?file=user&do=search');
		}
	}

	new Delete('', '', '', '', true);
}

else if($_GET['do'] == 'merge') {
	if($_POST['formSet']) {
		// two user objs...
		$mergeInto = new User('', $_POST['mergeInto']);
		$merged = new User('', $_POST['merged']);

		// lets make a list of tables to update to make this easy...
		$updateTables = Array(
							'logger_admin', 'logger_ips', 'logger_mods', 'moderators',
							'personal_folders', 'personal_msg', 'personal_msg2', 'personal_receipt',
							'personal_rules', 'subscriptions', 'warn', 'warn2',
							'userinfo_ban', 'posts', 'threads'
						);

		foreach($updateTables as $tblName) {
			new Query($query['user']['merge'][$tblName], Array(1 => $mergeInto->info['userid'], $merged->info['userid']), 'unbuffered');
		}

		new Query($query['user']['merge']['update_postcount'], Array(1 => $merged->info['posts'], $merged->info['threads'], $mergeInto->info['userid']), 'unbuffered');

		$merged->destroy();

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=user&amp;edit=' . $mergeInto->info['userid']);
	}

	new AdminHTML('header', $lang['admin_users_merge'], true);
	new AdminHTML('tableBegin', $lang['admin_users_merge'], true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_merge_merged'],
								'desc' => $lang['admin_users_merge_merged_desc'],
								'type' => 'text',
								'name' => 'merged',
								'value' => ''
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_merge_into'],
								'desc' => $lang['admin_users_merge_into_desc'],
								'type' => 'text',
								'name' => 'mergeInto',
								'value' => ''
							), true);

	new AdminHTML('tableEnd', '', true);
	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'searchIp') {
	new AdminHTML('header', $lang['admin_users_ip'], true);

	if($_POST['formSet']) {
		if(!empty($_POST['ip'])) {
			// run query...
			$findIp = new Query($query['user']['ip_ip'], Array(1 => $_POST['ip']));
			$ips = Array();

			if($wtcDB->numRows($findIp)) {
				while($user = $wtcDB->fetchArray($findIp)) {
					$ips[$user['username']] = $user;
				}

				ksort($ips);

				new AdminHTML('tableBegin', $lang['admin_users_ip_ipResults'] . ': ' . count($ips), true, Array('form' => 0));

				$cells = Array(
							$lang['users_username'] => Array('th' => true),
							$lang['users_ip'] => Array('th' => true)
						);

				new AdminHTML('tableCells', '', true, Array('cells' => $cells));

				foreach($ips as $username => $info) {
					$cells = Array(
								'<a href="admin.php?file=user&amp;edit=' . $info['userid'] . '">' . $info['username'] . '</a>' => Array(),
								$info['ip_address'] => Array('class' => 'center')
							);

					new AdminHTML('tableCells', '', true, Array('cells' => $cells));
				}

				new AdminHTML('tableEnd', '', true, Array('form' => 0));
			}
		}

		if(!empty($_POST['username'])) {
			// get userid...
			$userObj = new User('', $_POST['username'], '', '', true);

			// run query...
			$findUser = new Query($query['user']['ip_userid'], Array(1 => $userObj->info['userid']));
			$users = Array();

			if($wtcDB->numRows($findUser)) {
				while($user = $wtcDB->fetchArray($findUser)) {
					$users[$user['ip_address']] = $user;
				}

				ksort($users);

				new AdminHTML('tableBegin', $lang['admin_users_ip_usernameResults'] . ': ' . count($users), true, Array('form' => 0));

				$cells = Array(
							$lang['users_username'] => Array('th' => true),
							$lang['users_ip'] => Array('th' => true)
						);

				new AdminHTML('tableCells', '', true, Array('cells' => $cells));

				foreach($users as $ip => $info) {
					$cells = Array(
								'<a href="admin.php?file=user&amp;edit=' . $info['userid'] . '">' . $info['username'] . '</a>' => Array(),
								$ip => Array('class' => 'center')
							);

					new AdminHTML('tableCells', '', true, Array('cells' => $cells));
				}

				new AdminHTML('tableEnd', '', true, Array('form' => 0));
			}
		}
	}

	new AdminHTML('tableBegin', $lang['admin_users_ip'], true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ip_ip'],
								'desc' => $lang['admin_users_ip_ip_desc'],
								'type' => 'text',
								'name' => 'ip',
								'value' => $_POST['ip']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ip_username'],
								'desc' => $lang['admin_users_ip_username_desc'],
								'type' => 'text',
								'name' => 'username',
								'value' => $_POST['username']
							), true);

	new AdminHTML('tableEnd', '', true);
	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'pruneMove') {
	// form group array (used more than once throughout)
	$groupSelect = Array();

	foreach($groups as $groupid => $obj) {
		$groupSelect[$obj->getName()] = $groupid;
	}

	ksort($groupSelect);

	if($_REQUEST['formSet']) {
		// bleh...
		if(!isset($_REQUEST['go'])) {
			new Redirect('admin.php?file=user&do=pruneMove');
		}

		switch($_REQUEST['go']) {
			case 'move':
				// no users?
				if(!is_array($_GET['ticked']) OR count($_GET['ticked']) <= 0 OR !is_object($groups[$_GET['moveTo']])) {
					new WtcBBException($lang['admin_error_notEnoughInfo']);
				}

				// we should only be here with $_GET and no $_POST
				if($_POST['formSet']) {
					if($_POST['delConfirm']) {
						foreach($_GET['ticked'] as $userid) {
							// grab user obj
							$userObj = new User($userid); // meh... what's another query?

							$newGroup['usergroupid'] = $_GET['moveTo'];
							$userObj->update($newGroup);
						}

						new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=user&amp;do=pruneMove');
					}

					else {
						new Redirect('admin.php?file=user&do=pruneMove');
					}
				}

				new Delete('', '', '', '', true, false, 'admin_users_pm_move');
			break;

			case 'delete':
				// no users?
				if(!is_array($_GET['ticked']) OR count($_GET['ticked']) <= 0) {
					new WtcBBException($lang['admin_error_notEnoughInfo']);
				}

				// we should only be here with $_GET and no $_POST
				if($_POST['formSet']) {
					if($_POST['delConfirm']) {
						foreach($_GET['ticked'] as $userid) {
							$userObj = new User($userid); // meh... what's another query?
							$userObj->destroy();
						}

						new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=user&amp;do=pruneMove');
					}

					else {
						new Redirect('admin.php?file=user&do=pruneMove');
					}
				}

				new Delete('', '', '', '', true);
			break;

			case 'search':
				// form query...
				$queryStr = '';

				if($_POST['posts'] > 0) {
					$queryStr .= 'posts < "' . $_POST['posts'] . '" AND ';
				}

				if($_POST['logged'] > 0) {
					$queryStr .= 'lastvisit <= "' . (NOW - ($_POST['logged'] * ADAY)) . '" AND ';
				}

				if(!empty($_POST['joined']['day']) AND !empty($_POST['joined']['year'])) {
					$stamp = WtcDate::mktime(0, 0, 0, $_POST['joined']['month'], $_POST['joined']['day'], $_POST['joined']['year']);

					$queryStr .= 'joined < "' . $stamp . '" AND ';
				}

				if($_POST['usergroupid'] > 0) {
					$queryStr .= 'usergroupid = "' . $_POST['usergroupid'] . '" AND ';
				}

				// uh oh...
				if(empty($queryStr)) {
					new WtcBBException($lang['admin_error_notEnoughInfo']);
				}

				$queryStr = preg_replace('/AND\s+$/', '', $queryStr);

				$find = new Query($query['user']['searchUsers'], Array(1 => $queryStr), 'query', false);
				$results = Array();

				// no results...
				if(!$wtcDB->numRows($find)) {
					new WtcBBException($lang['admin_error_noResults']);
				}

				// form array and sort results by username...
				while($user = $wtcDB->fetchArray($find)) {
					$results[$user['username']] = $user;
				}

				ksort($results);

				new AdminHTML('header', $lang['admin_users_searchResults'], true);
				new AdminHTML('tableBegin', $lang['admin_users_searchResults'] . ': ' . count($results), true, Array('colspan' => 6, 'method' => 'get', 'hiddenInputs' => Array('file' => 'user', 'do' => 'pruneMove', 'formSet' => 1)));

				$cells = Array(
							'<input type="checkbox" onclick="wtcBB.tickBoxes(this.form, this);" name="tickAll" />' => Array('th' => true),
							$lang['users_username'] => Array('th' => true, 'class' => 'small'),
							$lang['users_usergroup'] => Array('th' => true, 'class' => 'small'),
							$lang['users_regDate'] => Array('th' => true, 'class' => 'small'),
							$lang['users_posts'] => Array('th' => true, 'class' => 'small'),
							$lang['users_lastvisit'] => Array('th' => true, 'class' => 'small')
						);

				new AdminHTML('tableCells', '', true, Array('cells' => $cells));

				foreach($results as $username => $info) {
					$date = new WtcDate('date', $info['joined']);
					$dateVisit = new WtcDate('date', $info['lastvisit']);
					$userObj = new User('', '', $info);
					$ticker = '';

					// tick or alert?
					if($userObj->isAdmin() OR $userObj->isGlobal() OR $userObj->isMod() OR $userObj->isSuperAdmin() OR $userObj->untouchable()) {
						$ticker = '<input type="button" value="!" class="button" onclick="alert(\'' . $lang['admin_users_pm_alert'] . '\');" />';
					}

					else {
						$ticker = '<input type="checkbox" name="ticked[]" value="' . $info['userid'] . '" />';
					}

					$cells = Array(
								$ticker => Array('class' => 'center'),
								'<a href="admin.php?file=user&amp;edit=' . $info['userid'] . '">' . $info['username'] . '</a>' => Array(),
								$groups[$info['usergroupid']]->getName() => Array('class' => 'center'),
								$date->getDate() => Array('class' => 'center'),
								$info['posts'] => Array('class' => 'center'),
								$dateVisit->getDate() . '&nbsp;' => Array('class' => 'center')
							);

					new AdminHTML('tableCells', '', true, Array('cells' => $cells));
				}

				$footerText = '<label for="delete"><input type="radio" name="go" value="delete" id="delete" /> ' . $lang['admin_delete'] . '</label>&nbsp;';
				$footerText .= '<label for="move"><input type="radio" name="go" value="move" id="move" checked="checked" /> ' . $lang['admin_users_pm_moveTo'] . '</label>&nbsp;&nbsp;';
				$footerText .= '<select name="moveTo">' . "\n";

				foreach($groupSelect as $groupName => $groupid) {
					$footerText .= "\t" . '<option value="' . $groupid . '">' . $groupName . '</option>' . "\n";
				}

				$footerText .= '</select>&nbsp;';
				$footerText .= '<input type="submit" class="button" value="' . $lang['admin_go'] . '" />';

				new AdminHTML('tableEnd', '', true, Array('colspan' => 6, 'footerText' => $footerText));
				new AdminHTML('footer', '', true);

				exit;
			break;
		}
	}

	new AdminHTML('header', $lang['admin_users_pm_search'], true);
	new AdminHTML('tableBegin', $lang['admin_users_pm_criteria'], true, Array(
																			'hiddenInputs' => Array(
																								'go' => 'search'
																							)
																		));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_pm_posts'],
								'desc' => $lang['admin_users_pm_posts_desc'],
								'type' => 'text',
								'name' => 'posts',
								'value' => 0
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_pm_logged'],
								'desc' => $lang['admin_users_pm_logged_desc'],
								'type' => 'text',
								'name' => 'logged',
								'value' => 0
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_pm_joined'],
								'desc' => $lang['admin_users_pm_joined_desc'],
								'type' => 'date',
								'month' => Array(
											'name' => 'joined[month]',
											'value' => ''
										),
								'day' => Array(
											'name' => 'joined[day]',
											'value' => ''
										),
								'year' => Array(
											'name' => 'joined[year]',
											'value' => ''
										)
							), true);

	// form group array
	$start['All Usergroups'] = 0;
	$groupSelect = $start + $groupSelect;

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_pm_usergroup'],
								'desc' => $lang['admin_users_pm_usergroup_desc'],
								'type' => 'select',
								'name' => 'usergroupid',
								'select' => Array('fields' => $groupSelect, 'select' => 0)
							), true);

	new AdminHTML('tableEnd', '', true);
	new AdminHTML('footer', '', true);
}

else if(isset($_GET['banLift'])) {
	$get = new Query($query['user']['get_banned_user'], Array(1 => $_GET['banLift']));

	if(!$wtcDB->numRows($get)) {
		new WtcBBException($lang['error_noInfo']);
	}

	$userObj = new User('', '', $wtcDB->fetchArray($get));

	// update user
	$update['usergroupid'] = $userObj->info['previousGroupId'];
	$userObj->update($update);

	new Delete('userinfo_ban', 'banid', $userObj->info['banid'], '', true, true);

	new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=user&amp;do=viewBanned');
}

else if($_GET['do'] == 'viewBanned') {
	$getBannedUsers = new Query($query['user']['get_banned']);
	$count = 0; $endCount = $wtcDB->numRows($getBannedUsers);
	$sorted = Array();

	// uh oh...
	if(!$endCount) {
		new WtcBBException($lang['admin_error_noBannedUsers']);
	}

	// loop through and sort by usergroup... then username...
	while($user = $wtcDB->fetchArray($getBannedUsers)) {
		$sorted[$user['title']][$user['username']] = $user;
	}

	ksort($sorted);

	foreach($sorted as $groupName => $meh) {
		ksort($sorted[$groupName]);
	}

	new AdminHTML('header', $lang['admin_users_viewBan'], true);

	$headers = Array(
					$lang['users_username'] => Array('th' => true),
					$lang['admin_users_viewBan_type'] => Array('th' => true),
					$lang['admin_users_viewBan_liftDate'] . ' <span class="small">(' . $lang['global_approx'] . ')</span>' => Array('th' => true),
					$lang['admin_options'] => Array('th' => true)
				);

	foreach($sorted as $groupName => $users) {
		new AdminHTML('tableBegin', $lang['admin_users_viewBan_inGroup'] . ' <em>' . $groupName . '</em>', true, Array('form' => false, 'colspan' => 4));

		new AdminHTML('tableCells', '', true, Array('cells' => $headers));

		foreach($users as $username => $info) {
			$banType = ($info['banLength'] > 0) ? $lang['admin_users_viewBan_temp'] : $lang['admin_users_viewBan_perm'];

			if($info['banLength'] > 0) {
				$banLiftDate = new WtcDate('date', $info['banStart'] + $info['banLength'], false);
				$banLiftTime = new WtcDate('time', $info['banStart'] + $info['banLength'], false);
				$dateText = $banLiftDate->getDate() . ' ' . $lang['global_at'] . ' ' . $banLiftTime->getDate();
			}

			else {
				$dateText = $lang['global_perpetual'];
			}

			$cells = Array(
						'<a href="admin.php?file=user&amp;edit=' . $info['userid'] . '">' . $username . '</a>' => Array(),
						$banType => Array(),
						$dateText => Array(),
						'<a href="admin.php?file=user&amp;banEdit=' . $info['banid'] . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=user&amp;banLift=' . $info['banid'] . '">' . $lang['admin_users_viewBan_lift'] . '</a>' => Array()
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('form' => 0, 'footerText' => '<a href="admin.php?file=user&amp;do=ban">' . $lang['admin_users_ban'] . '</a>', 'colspan' => 4));
	}

	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'ban' OR isset($_GET['banEdit'])) {
	if($_GET['do'] == 'ban') {
		$which = 'add';

		$editinfo = Array(
						'username' => '',
						'usergroupid' => 5,
						'banLength' => 0
					);
	}

	else {
		$which = 'edit';

		// get banned info...
		$get = new Query($query['user']['get_banned_user'], Array(1 => $_GET['banEdit']));

		if(!$wtcDB->numRows($get)) {
			new WtcBBException($lang['error_noInfo']);
		}

		$editinfo = $wtcDB->fetchArray($get);
	}

	if($_POST['formSet']) {
		if($which == 'add') {
			// create user by username...
			// also checks if user exists
			$userObj = new User('', $_POST['username']);

			// make sure user isn't already banned!
			if($userObj->info['usergroupid'] == $_POST['groupid'] OR in_array($_POST['groupid'], $userObj->getSecGroups())) {
				new WtcBBException($lang['admin_error_alreadyBanned']);
			}

			// check to make sure not already in the banned table!
			$checkBanned = new Query($query['user']['check_banned'], Array(1 => $userObj->info['userid']));
			$check = $wtcDB->fetchArray($checkBanned);

			if($check['checking']) {
				new WtcBBException($lang['admin_error_alreadyBanned']);
			}

			// update user's info...
			$update['usergroupid'] = $_POST['groupid'];
			$userObj->update($update);

			// now insert into ban table... strictly
			// for keeping track of banned users and to
			// reduce looping mechanisms' lengths
			new Query($query['user']['ban_user_insert'], Array(1 => $userObj->info['userid'], $_POST['groupid'], $_POST['banLength'], NOW, $userObj->info['usergroupid']));
		}

		else {
			// create user by id...
			$userObj = new User($editinfo['userid']);

			// make sure user isn't already banned!
			if($_POST['groupid'] != $editinfo['usergroupid'] AND ($userObj->info['usergroupid'] == $_POST['groupid'] OR in_array($_POST['groupid'], $userObj->getSecGroups()))) {
				new WtcBBException($lang['admin_error_alreadyBanned']);
			}

			// update user's info...
			$update['usergroupid'] = $_POST['groupid'];
			$userObj->update($update);

			// now insert into ban table... strictly
			// for keeping track of banned users and to
			// reduce looping mechanisms' lengths
			new Query($query['user']['ban_user_update'], Array(1 => $_POST['groupid'], $_POST['banLength'], (($_POST['banLength'] == $editinfo['banLength']) ? $editinfo['banStart'] : NOW), $userObj->info['userid']));
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=user&amp;do=viewBanned');
	}

	if($which == 'add') {
		new AdminHTML('header', $lang['admin_users_ban'], true);
	}

	else {
		new AdminHTML('header', $lang['admin_users_editBan'], true, Array(
																	'extra2' => "\t" . '<p class="marBot">' . $lang['admin_users_editBan_details'] . '</p>' . "\n\n"
																	));
	}

	if($which == 'add') {
		new AdminHTML('tableBegin', $lang['admin_users_ban'], true, Array('form' => true));
	}

	else {
		new AdminHTML('tableBegin', $lang['admin_users_editBan'], true, Array('form' => true));
	}

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ban_username'],
									'desc' => $lang['admin_users_ban_username_desc'],
									'type' => ($which == 'add') ? 'text' : 'plainText',
									'name' => 'username',
									'value' => $editinfo['username']
								), true);

	// get all banned usergroups
	$banned = Usergroup::groupAndSort($query['usergroups']['get_banned_groups']);
	$bannedGroups = Array();

	foreach($banned as $name => $info) {
		$bannedGroups[$name] = $info['usergroupid'];
	}

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ban_group'],
									'desc' => $lang['admin_users_ban_group_desc'],
									'type' => 'select',
									'name' => 'groupid',
									'select' => Array('fields' => $bannedGroups, 'select' => $editinfo['usergroupid'])
								), true);

	// form temporary banning options...
	$banTypes = Array(
					$lang['admin_users_ban_types_perm'] => 0,
					$lang['admin_users_ban_types_temp_1day'] => ADAY,
					$lang['admin_users_ban_types_temp_2days'] => ADAY * 2,
					$lang['admin_users_ban_types_temp_3days'] => ADAY * 3,
					$lang['admin_users_ban_types_temp_1week'] => AWEEK,
					$lang['admin_users_ban_types_temp_2weeks'] => AWEEK * 2,
					$lang['admin_users_ban_types_temp_3weeks'] => AWEEK * 3,
					$lang['admin_users_ban_types_temp_1month'] => AMONTH,
					$lang['admin_users_ban_types_temp_2months'] => AMONTH * 2,
					$lang['admin_users_ban_types_temp_3months'] => AMONTH * 3,
					$lang['admin_users_ban_types_temp_6months'] => AMONTH * 6,
					$lang['admin_users_ban_types_temp_1year'] => AYEAR
				);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ban_type'],
									'desc' => $lang['admin_users_ban_type_desc'],
									'type' => 'select',
									'name' => 'banLength',
									'select' => Array('fields' => $banTypes, 'select' => $editinfo['banLength'])
								), true);

	new AdminHTML('tableEnd', '', true, Array('form' => true));
	new AdminHTML('footer', '', true);
}

// just a quick redirect
else if(isset($_GET['block'])) {
	new Redirect('admin.php?file=forum&do=block&u=' . $_GET['block']);
}

else if($_GET['do'] == 'add' OR $_GET['do'] == 'search' OR isset($_GET['edit'])) {
	$which = '';
	$nows = WtcDate::buildNows();

	if($_GET['do'] == 'add') {
		$which = $_GET['do'];
		$submitText = $lang['admin_users_ae_insertUser'];

		// the below just sets the default values... (dates too)
		// only need to specify "0" if you want to display 0, or
		// if something with a value of "0" needs to be selected
		// if it's a checkbox, it can be left blank
		$editinfo = Array(
						'posts' => 0, 'threads' => 0, 'warn' => 0,
						'ip' => '0.0.0.0', 'referrals' => 0, 'timezone' => $bboptions['timezone'],
						'toolbar' => 1, 'disSigs' => 1, 'disImgs' => 1,
						'disAttach' => 1, 'disAv' => 1, 'disSmi' => 1,
						'emailContact' => 1, 'adminEmails' => 1, 'receivePm' => 1,
						'receivePmEmail' => 1, 'receivePmAlert' => 1, 'displayOrder' => 'ASC',
						'postsPerPage' => 0, 'styleid' => 0, 'threadViewAge' => 0,
						'dst' => $nows['dst'], 'usergroupid' => 4, 'defAuto' => 0, 'lang' => -1,
						'avatar' => ''
					);

		// set default dates...
		$editinfo['birthday'] = Array(
									'month' => 1,
									'day' => '',
									'year' => $nows['year']
								);
		$editinfo['joined'] = Array(
									'month' => $nows['month'],
									'day' => $nows['date'],
									'year' => $nows['year']
								);
		$editinfo['lastvisit'] = Array(
									'month' => '',
									'day' => '',
									'year' => '',
									'hour' => '',
									'minute' => '',
									'ampm' => ''
								);
		$editinfo['lastactivity'] = Array(
									'month' => '',
									'day' => '',
									'year' => '',
									'hour' => '',
									'minute' => '',
									'ampm' => ''
								);
		$editinfo['lastpost'] = Array(
									'month' => '',
									'day' => '',
									'year' => '',
									'hour' => '',
									'minute' => '',
									'ampm' => ''
								);
	}

	else if($_GET['do'] == 'search') {
		$which = 'search';
		$submitText = $lang['admin_users_ae_searchUser'];

		// the below just sets the default values... (dates too)
		// only need to specify "0" if you want to display 0, or
		// if something with a value of "0" needs to be selected
		// if it's a checkbox, it can be left blank
		$editinfo = Array(
						'posts' => 0, 'threads' => 0, 'warn' => 0,
						'ip' => '0.0.0.0', 'referrals' => 0, 'timezone' => $bboptions['timezone'],
						'toolbar' => 1, 'disSigs' => 1, 'disImgs' => 1,
						'disAttach' => 1, 'disAv' => 1, 'disSmi' => 1,
						'emailContact' => 1, 'adminEmails' => 1, 'receivePm' => 1,
						'receivePmEmail' => 1, 'receivePmAlert' => 1, 'displayOrder' => 'ASC',
						'postsPerPage' => 0, 'styleid' => 0, 'threadViewAge' => 0,
						'dst' => $nows['dst'], 'usergroupid' => 0, 'defAuto' => 0, 'lang' => -1,
						'avatar' => ''
					);

		// set default dates...
		$editinfo['birthday'] = Array(
									'month' => '',
									'day' => '',
									'year' => ''
								);
		$editinfo['joined'] = Array(
									'month' => '',
									'day' => '',
									'year' => ''
								);
		$editinfo['lastvisit'] = Array(
									'month' => '',
									'day' => '',
									'year' => '',
									'hour' => '',
									'minute' => '',
									'ampm' => ''
								);
		$editinfo['lastactivity'] = Array(
									'month' => '',
									'day' => '',
									'year' => '',
									'hour' => '',
									'minute' => '',
									'ampm' => ''
								);
		$editinfo['lastpost'] = Array(
									'month' => '',
									'day' => '',
									'year' => '',
									'hour' => '',
									'minute' => '',
									'ampm' => ''
								);
	}

	else if(isset($_GET['edit'])) {
		$which = 'edit';
		$submitText = $lang['admin_users_ae_updateUser'];

		// get user info
		$editObj = new User($_GET['edit']);
		$editinfo = $editObj->info;

		// do dates
		$dates = Array(
					'birthday' => 'date',
					'joined' => 'date',
					'lastvisit' => 'dateTime',
					'lastactivity' => 'dateTime',
					'lastpost' => 'dateTime'
				);

		foreach($dates as $fieldName => $type) {
			if($editinfo[$fieldName] == NULL OR !$editinfo[$fieldName]) {
				$editinfo[$fieldName] = Array(
											'month' => '',
											'day' => '',
											'year' => '',
											'hour' => '',
											'minute' => '',
											'ampm' => ''
										);

				continue;
			}

			$stamp = $editinfo[$fieldName];

			if($type == 'date') {
				$editinfo[$fieldName] = Array(
											'month' => new WtcDate('m', $stamp),
											'day' => new WtcDate('d', $stamp),
											'year' => new WtcDate('Y', $stamp)
										);
			}

			else {
				$editinfo[$fieldName] = Array(
											'month' => new WtcDate('m', $stamp),
											'day' => new WtcDate('d', $stamp),
											'year' => new WtcDate('Y', $stamp),
											'hour' => new WtcDate('h', $stamp),
											'minute' => new WtcDate('i', $stamp),
											'ampm' => new WtcDate('a', $stamp)
										);

			}

			foreach($editinfo[$fieldName] as $key => $val) {
				if($val instanceof WtcDate) {
					$editinfo[$fieldName][$key] = $val->getDate();
				}
			}
		}
	}

	if(isset($_REQUEST['formSet']) OR isset($_GET['emailSql'])) {
		if($which == 'add') {
			$insert = Array();

			// check errors...
			if(empty($_POST['user']['username']) OR empty($_POST['password']) OR empty($_POST['user']['email'])) {
				new WtcBBException($lang['admin_error_notEnoughInfo']);
			}

			$checkNameQ = new Query($query['user']['checkUniqueName'], Array(1 => $_POST['user']['username']));
			$checkName = $wtcDB->fetchArray($checkNameQ);

			if($checkName['checking']) {
				new WtcBBException($lang['admin_error_uniqueName']);
			}

			if($bboptions['uniqueEmail']) {
				$checkEmailQ = new Query($query['user']['checkUniqueEmail'], Array(1 => $_POST['user']['email']));
				$checkEmail = $wtcDB->fetchArray($checkEmailQ);

				if($checkEmail['checking']) {
					new WtcBBException($lang['admin_error_uniqueEmailInEffect']);
				}
			}

			// get password
			$passObj = new Password($_POST['password']);
			$insert['password'] = $passObj->getHashedPassword();
			$insert['salt'] = $passObj->getSalt();
			$insert['passTime'] = NOW;

			// now... do dates... yuck
			if(is_array($_POST['userdate'])) {
				// form proper array
				foreach($_POST['userdate'] as $splitter => $v) {
					$kaboom = explode('_', $splitter);
					$userDates[$kaboom[0]][$kaboom[1]] = $v;
				}

				foreach($userDates as $field => $vals) {
					if($field != 'birthday' AND (empty($vals['month']) OR empty($vals['day']) OR empty($vals['year']))) {
						$insert[$field] = 0;
					}

					else {
						switch($field) {
							case 'birthday':
								if(!$vals['day']) {
									$insert[$field] = '';
								}

								else {
									$insert[$field] = WtcDate::mktime(0, 0, 0, $vals['month'], $vals['day'], $vals['year']);
								}
							break;

							default:
								if($vals['ampm'] AND $vals['hour'] != 12) {
									$vals['hour'] += 12;
								}

								else if(!$vals['ampm'] AND $vals['hour'] == 12) {
									$vals['hour'] = 0;
								}

								$insert[$field] = WtcDate::mktime($vals['hour'], $vals['minute'], 0, $vals['month'], $vals['day'], $vals['year']);
							break;
						}
					}
				}
			}

			foreach($_POST['user'] as $field => $v) {
				switch($field) {
					case 'usertitle':
						$insert[$field] = User::getUserTitle($_POST['user']['usertitle_opt'], $_POST['user']['posts'], $v, $_POST['user']['usergroupid']);
					break;

					default:
						$insert[$field] = $v;
					break;
				}
			}

			if(is_array($_POST['secgroupids'])) {
				$arr = '';

				foreach($_POST['secgroupids'] as $index => $id) {
					if($id != $_POST['user']['usergroupid']) {
						$arr[] = $id;
					}
				}

				if(is_array($arr)) {
					$insert['secgroupids'] = serialize($arr);
				}

				else {
					$insert['secgroupids'] = '';
				}
			}

			else {
				$insert['secgroupids'] = '';
			}

			User::insert($insert);
			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=user&amp;do=search');
		}

		else if($which == 'search') {
			$search = Array();

			// now... do dates... yuck
			if(is_array($_REQUEST['userdate'])) {
				// form proper array
				foreach($_REQUEST['userdate'] as $splitter => $v) {
					$kaboom = explode('_', $splitter);
					$userDates[$kaboom[0]][$kaboom[1]] = $v;
				}

				foreach($userDates as $field => $vals) {
					if($field != 'birthday' AND (empty($vals['month']) OR empty($vals['day']) OR empty($vals['year']))) {
						continue;
					}

					else if($field == 'birthday' AND empty($vals['day'])) {
						continue;
					}

					else {
						switch($field) {
							case 'birthday':
							case 'joined':
								$search[$field] = WtcDate::mktime(0, 0, 0, $vals['month'], $vals['day'], $vals['year']);
							break;

							default:
								if($vals['ampm'] AND $vals['hour'] != 12) {
									$vals['hour'] += 12;
								}

								else if(!$vals['ampm'] AND $vals['hour'] == 12) {
									$vals['hour'] = 0;
								}

								$search[$field] = WtcDate::mktime($vals['hour'], $vals['minute'], 0, $vals['month'], $vals['day'], $vals['year']);
							break;
						}
					}
				}
			}

			if(is_array($_REQUEST['user'])) {
				foreach($_REQUEST['user'] as $field => $v) {
					if(!$v OR $v == NULL OR $v == '0.0.0.0' OR $v < 0) {
						continue;
					}

					switch($field) {
						case 'usertitle':
							$search[$field] = User::getUserTitle($_REQUEST['user']['usertitle_opt'], $_REQUEST['user']['posts'], $v, $_REQUEST['user']['usergroupid']);
						break;

						default:
							$search[$field] = $v;
						break;
					}
				}
			}

			if(isset($_REQUEST['secgroupid'])) {
				$results = User::getSecUsers($_REQUEST['secgroupid']);
			}

			else {
				if($_GET['go'] != 'email') {
					$results = User::searchUsers($search);
				}

				else if(!isset($_GET['emailSql'])) {
					$moreResults = User::searchUsers($search, '', true, false, ' ORDER BY username');
					$results = $moreResults['return'];
					$sendSql = $moreResults['ref']->getFinalSql();
					$page = 1;
				}

				else if($_GET['go'] == 'email') {
					$moreResults = User::searchUsers('', $_GET['emailSql']);
					$results = $moreResults['return'];
					$sendSql = $moreResults['ref']->getFinalSql();
					$page = $_GET['page'];
				}
			}

			// only one match? redirect automagically...
			if(isset($results["-1"]) AND $_GET['go'] != 'email') {
				new Redirect('admin.php?file=user&edit=' . $results["-1"]['userid']);
			}

			else {
				new AdminHTML('header', $lang['admin_users_searchResults'], true);

				if($_GET['go'] == 'email') {
					new AdminHTML('tableBegin', $lang['admin_users_searchResults'], true, Array('form' => 0, 'colspan' => 2));

					$cells = Array(
								$lang['users_username'] => Array('th' => true),
								$lang['admin_users_mail_status'] => Array('th' => true)
							);

					new AdminHTML('tableCells', '', true, Array('cells' => $cells));
					$count = -1;
					$start = ($page - 1) * $_REQUEST['massE']['num'];
					$end = $start + $_REQUEST['massE']['num'];

					foreach($results as $userid => $info) {
						$count++;

						// should we skip..?
						if($count < $start) {
							continue;
						}

						// save some time and break
						if($count >= $end) {
							break;
						}

						$status = '';

						// test?
						if($_REQUEST['massE']['testEmail']) {
							if(empty($info['email'])) {
								$status = $lang['admin_users_mail_status_failed'];
							}

							else {
								$status = $lang['admin_users_mail_status_success'];
							}
						}

						else {
							// set some vars
							$userid = $info['userid'];
							$username = $info['username'];
							$email = $info['email'];

							eval('$mySubject = "' . wtcslashes($_REQUEST['massE']['subject']) . '";');
							eval('$myMessage = "' . wtcslashes($_REQUEST['massE']['message']) . '";');

							$mail = new Email('admin', $info, $mySubject, $myMessage, $_REQUEST['massE']['from']);

							if($mail->isSent()) {
								$status = $lang['admin_users_mail_status_success'];
							}

							else {
								$status = $lang['admin_users_mail_status_failed'];
							}
						}

						$cells = Array(
									'<strong>' . $info['username'] . '</strong>' => Array(),
									$status => Array()
								);

						new AdminHTML('tableCells', '', true, Array('cells' => $cells));
					}

					// more pages?
					if(count($results) > $end) {
						$massELinks = '';

						foreach($_REQUEST['massE'] as $keyName => $v) {
							$massELinks .= '&amp;massE%5B' . $keyName . '%5D=' . $v;
						}

						$footerText = '<a href="admin.php?file=user&amp;do=search&amp;go=email&amp;page=' . ($page + 1) . '&amp;emailSql=' . urlencode($sendSql) . $massELinks . '">' . $lang['admin_users_mail_nextBatch'] . '</a>';
					}

					else {
						$footerText = '<a href="admin.php?file=user&amp;do=search&amp;go=email">' . $lang['admin_users_mail_backToEmail'] . '</a>';
					}

					new AdminHTML('tableEnd', '', true, Array('form' => 0, 'colspan' => 2, 'footerText' => $footerText));
				}

				else {
					new AdminHTML('tableBegin', $lang['admin_users_searchResults'] . ': ' . count($results), true, Array('form' => 0, 'colspan' => 5));

					$cells = Array(
								$lang['users_username'] => Array('th' => true, 'class' => 'small'),
								$lang['users_usergroup'] => Array('th' => true, 'class' => 'small'),
								$lang['users_regDate'] => Array('th' => true, 'class' => 'small'),
								$lang['users_posts'] => Array('th' => true, 'class' => 'small'),
								$lang['admin_options'] => Array('th' => true, 'class' => 'small')
							);

					new AdminHTML('tableCells', '', true, Array('cells' => $cells));

					foreach($results as $userid => $info) {
						$date = new WtcDate('date', $info['joined']);

						$cells = Array(
									'<a href="admin.php?file=user&amp;edit=' . $info['userid'] . '">' . $info['username'] . '</a>' => Array(),
									$groups[$info['usergroupid']]->getName() => Array('class' => 'center'),
									$date->getDate() => Array('class' => 'center'),
									$info['posts'] => Array('class' => 'center'),
									'<a href="admin.php?file=user&amp;edit=' . $info['userid'] . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=user&amp;delete=' . $info['userid'] . '">' . $lang['admin_delete'] . '</a>' => Array()
								);

						new AdminHTML('tableCells', '', true, Array('cells' => $cells));
					}

					new AdminHTML('tableEnd', '', true, Array('form' => 0, 'colspan' => 5));
				}

				new AdminHTML('footer', '', true);

				// quit...
				exit;
			}
		}

		else if($which == 'edit') {
			$update = Array();

			// check errors...
			if(empty($_POST['user']['username']) OR empty($_POST['user']['email'])) {
				new WtcBBException($lang['admin_error_notEnoughInfo']);
			}

			$checkNameQ = new Query($query['user']['checkUniqueName_edit'], Array(1 => $_POST['user']['username'], $editinfo['userid']));
			$checkName = $wtcDB->fetchArray($checkNameQ);

			if($checkName['checking']) {
				new WtcBBException($lang['admin_error_uniqueName']);
			}

			if($bboptions['uniqueEmail']) {
				$checkEmailQ = new Query($query['user']['checkUniqueEmail_edit'], Array(1 => $_POST['user']['email'], $editinfo['userid']));
				$checkEmail = $wtcDB->fetchArray($checkEmailQ);

				if($checkEmail['checking']) {
					new WtcBBException($lang['admin_error_uniqueEmailInEffect']);
				}
			}

			// get password
			if(!empty($_POST['password'])) {
				$passObj = new Password($_POST['password']);
				$update['password'] = $passObj->getHashedPassword();
				$update['salt'] = $passObj->getSalt();
				$update['passTime'] = NOW;
			}

			// now... do dates... yuck
			if(is_array($_POST['userdate'])) {
				// form proper array
				foreach($_POST['userdate'] as $splitter => $v) {
					$kaboom = explode('_', $splitter);
					$userDates[$kaboom[0]][$kaboom[1]] = $v;
				}

				foreach($userDates as $field => $vals) {
					if($field != 'birthday' AND (empty($vals['month']) OR empty($vals['day']) OR empty($vals['year']))) {
						$insert[$field] = 0;
					}

					else {
						switch($field) {
							case 'birthday':
								if(!$vals['day']) {
									$update[$field] = '';
								}

								else {
									$update[$field] = WtcDate::mktime(0, 0, 0, $vals['month'], $vals['day'], $vals['year']);
								}
							break;

							default:
								if($vals['ampm'] AND $vals['hour'] != 12) {
									$vals['hour'] += 12;
								}

								else if(!$vals['ampm'] AND $vals['hour'] == 12) {
									$vals['hour'] = 0;
								}

								$update[$field] = WtcDate::mktime($vals['hour'], $vals['minute'], 0, $vals['month'], $vals['day'], $vals['year']);
							break;
						}
					}
				}
			}

			foreach($_POST['user'] as $field => $v) {
				switch($field) {
					case 'usertitle':
						$update[$field] = User::getUserTitle($_POST['user']['usertitle_opt'], $_POST['user']['posts'], $v, $_POST['user']['usergroupid']);
					break;

					default:
						$update[$field] = $v;
					break;
				}
			}

			if(is_array($_POST['secgroupids'])) {
				$arr = '';

				foreach($_POST['secgroupids'] as $index => $id) {
					if($id != $_POST['user']['usergroupid']) {
						$arr[] = $id;
					}
				}

				if(is_array($arr)) {
					$update['secgroupids'] = serialize($arr);
				}

				else {
					$update['secgroupids'] = '';
				}
			}

			else {
				$update['secgroupids'] = '';
			}

			$editObj->update($update);
			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=user&amp;do=search');
		}
	}

	if($which == 'add') {
		new AdminHTML('header', $lang['admin_users_add_title'], true, Array('form' => 1));
	}

	else if($which == 'edit') {
		$userOptionsObj = new AdminHTML('locationSelect', '', false, Array(
																	'locs' => Array(
																				'admin.php?file=user&amp;delete=' . $editinfo['userid'] => $lang['admin_users_ae_opts_delUser'],
																				'admin.php?file=user&amp;block=' . $editinfo['userid'] => $lang['admin_users_ae_opts_access']
																			),
																	'return' => true,
																	'name' => 'userOptions',
																	'noForm' => true
																));

		$userOptions = $userOptionsObj->dump();

		new AdminHTML('header', $lang['admin_users_edit_title'] . ': ' . $editinfo['username'], true, Array('form' => true));

		new AdminHTML('divit', Array('content' => '<strong>' . $lang['admin_users_ae_opts'] . ':</strong> ' . $userOptions), true);
	}

	else {
		new AdminHTML('header', $lang['admin_users_search_title'], true, Array('form' => 1));
	}

	if($which == 'search' AND !isset($_GET['go'])) {
		$keyBox = "\t\t\t" . '<ul class="noBullets">' . "\n";
			$keyBox .= "\t\t\t\t" . '<li><a href="admin.php?file=user&amp;do=search&amp;formSet=1">' . $lang['admin_users_ae_allUsers'] . '</a></li>' . "\n";
		$keyBox .= "\t\t\t" . '</ul>' . "\n";

		new AdminHTML('divitBox', Array(
									'title' => $lang['admin_options'],
									'content' => $keyBox
								), true);
	}


	// ##### BEGIN: MASS EMAIL ##### \\
	if($_GET['go'] == 'email') {
		new AdminHTML('tableBegin', $lang['admin_users_mail'], true, Array('form' => 0));

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_mail_test'],
									'desc' => $lang['admin_users_mail_test_desc'],
									'type' => 'checkbox',
									'name' => 'massE[testEmail]',
									'value' => 1
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_mail_num'],
									'desc' => $lang['admin_users_mail_num_desc'],
									'type' => 'text',
									'name' => 'massE[num]',
									'value' => 100
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_mail_from'],
									'desc' => $lang['admin_users_mail_from_desc'],
									'type' => 'text',
									'name' => 'massE[from]',
									'value' => $bboptions['adminContact']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_mail_sub'],
									'desc' => $lang['admin_users_mail_sub_desc'],
									'type' => 'text',
									'name' => 'massE[subject]',
									'value' => 'Re: '
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_mail_mes'],
									'desc' => $lang['admin_users_mail_mes_desc'],
									'type' => 'textarea',
									'name' => 'massE[message]',
									'value' => ''
								), true);

		new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	}


	// ##### BEGIN: REQUIRED FIELDS ##### \\
	new AdminHTML('tableBegin', $lang['admin_users_ae_required'], true, Array('form' => 0));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_username'],
								'desc' => $lang['admin_users_ae_username_desc'],
								'type' => 'text',
								'name' => 'user[username]',
								'value' => $editinfo['username']
							), true);

	if($which != 'search') {
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_password'],
									'desc' => $lang['admin_users_ae_password_desc'],
									'type' => 'text',
									'name' => 'password',
									'value' => ''
								), true);
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_email'],
								'desc' => $lang['admin_users_ae_email_desc'],
								'type' => 'text',
								'name' => 'user[email]',
								'value' => $editinfo['email']
							), true);

	$groupSelect = Array();
	$groups = Usergroup::groupAndSort($query['usergroups']['get_groups']);
	$selection = $editinfo['usergroupid'];

	if($which == 'search') {
		$groupSelect['All Primary Usergroups'] = 0;
	}

	foreach($groups as $title => $info) {
		$groupSelect[$title] = $info['usergroupid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_usergroup'],
								'desc' => $lang['admin_users_ae_usergroup_desc'],
								'type' => 'select',
								'name' => 'user[usergroupid]',
								'select' => Array('fields' => $groupSelect, 'select' => $selection)
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: REQUIRED FIELDS ##### \\


	if($which != 'search') {
		// ##### BEGIN: SECONDARY USERGROUPS ##### \\
		new AdminHTML('tableBegin', $lang['admin_users_ae_secGroups'], true, Array('form' => 0));

		$selecting = '';

		// go through groups and select ours...
		if(is_array($editinfo['secgroupids'])) {
			foreach($groupSelect as $title => $id) {
				if(in_array($id, $editinfo['secgroupids'])) {
					$selecting .= $id . ',';
				}
			}
		}

		// get rid of primary group from list
		if($which == 'edit') {
			$groupObj = new Usergroup($editinfo['usergroupid']);
			unset($groupSelect[$groupObj->info['title']]);
		}

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_secUsergroup'],
									'desc' => $lang['admin_users_ae_secUsergroup_desc'],
									'type' => 'multiple',
									'name' => 'secgroupids[]',
									'select' => Array('fields' => $groupSelect, 'select' => $selecting)
								), true);

		new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
		// ##### END: SECONDARY USERGROUPS ##### \\
	}


	// ##### BEGIN: ADMINISTRATIVE OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_users_ae_adminOpt'], true, Array('form' => 0));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_usertitle'],
								'desc' => $lang['admin_users_ae_usertitle_desc'],
								'type' => 'text',
								'name' => 'user[usertitle]',
								'value' => $editinfo['usertitle'],
								'html' => ($editinfo['usertitle_opt'] != 2)
							), true);

	$usertitleOpts = Array(
		$lang['admin_users_ae_usertitleOpt_no'] => 0,
		$lang['admin_users_ae_usertitleOpt_yes'] => 1,
		$lang['admin_users_ae_usertitleOpt_yesNoHtml'] => 2
	);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_usertitleOpt'],
								'desc' => $lang['admin_users_ae_usertitleOpt_desc'],
								'type' => 'select',
								'name' => 'user[usertitle_opt]',
								'select' => Array('fields' => $usertitleOpts, 'select' => $editinfo['usertitle_opt'])
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_htmlBegin'],
								'desc' => $lang['admin_users_ae_htmlBegin_desc'],
								'type' => 'text',
								'name' => 'user[htmlBegin]',
								'value' => $editinfo['htmlBegin'],
								'html' => true
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_htmlEnd'],
								'desc' => $lang['admin_users_ae_htmlEnd_desc'],
								'type' => 'text',
								'name' => 'user[htmlEnd]',
								'value' => $editinfo['htmlEnd'],
								'html' => true
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_posts'],
								'desc' => $lang['admin_users_ae_posts_desc'],
								'type' => 'text',
								'name' => 'user[posts]',
								'value' => $editinfo['posts']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_threads'],
								'desc' => $lang['admin_users_ae_threads_desc'],
								'type' => 'text',
								'name' => 'user[threads]',
								'value' => $editinfo['threads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_warn'],
								'desc' => $lang['admin_users_ae_warn_desc'],
								'type' => 'text',
								'name' => 'user[warn]',
								'value' => $editinfo['warn']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_ip'],
								'desc' => $lang['admin_users_ae_ip_desc'],
								'type' => 'text',
								'name' => 'user[ip]',
								'value' => $editinfo['ip']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_referrer'],
								'desc' => $lang['admin_users_ae_referrer_desc'],
								'type' => 'text',
								'name' => 'user[referrer]',
								'value' => $editinfo['referrer']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_referrals'],
								'desc' => $lang['admin_users_ae_referrals_desc'],
								'type' => 'text',
								'name' => 'user[referrals]',
								'value' => $editinfo['referrals']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_av'],
								'desc' => $lang['admin_users_ae_av_desc'],
								'type' => 'text',
								'name' => 'user[avatar]',
								'value' => $editinfo['avatar']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_sig'],
								'desc' => $lang['admin_users_ae_sig_desc'],
								'type' => 'textarea',
								'name' => 'user[sig]',
								'value' => $editinfo['sig']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: ADMINISTRATIVE OPTIONS ##### \\


	// ##### BEGIN: COPPA OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_users_ae_coppaOpt'], true, Array('form' => 0));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_parentEmail'],
								'desc' => $lang['admin_users_ae_parentEmail_desc'],
								'type' => 'text',
								'name' => 'user[parentEmail]',
								'value' => $editinfo['parentEmail']
							), true);

	if($which != 'search') {
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_coppa'],
									'desc' => $lang['admin_users_ae_coppa_desc'],
									'type' => 'checkbox',
									'name' => 'user[coppa]',
									'value' => $editinfo['coppa']
								), true);
	}

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: COPPA OPTIONS ##### \\


	// ##### BEGIN: TIME OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_users_ae_timeOpt'], true, Array('form' => 0));

	if($which != 'search') {
		$selection = $editinfo['timezone'];

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_timeZone'],
									'desc' => $lang['admin_users_ae_timeZone_desc'],
									'type' => 'select',
									'name' => 'user[timezone]',
									'select' => Array('fields' => array_flip(WtcDate::buildTimeZones()), 'select' => $selection)
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_dst'],
									'desc' => $lang['admin_users_ae_dst_desc'],
									'type' => 'checkbox',
									'name' => 'user[dst]',
									'value' => $editinfo['dst']
								), true);
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_joined'],
								'desc' => $lang['admin_users_ae_joined_desc'],
								'type' => 'date',
								'month' => Array(
											'name' => 'userdate[joined_month]',
											'value' => $editinfo['joined']['month']
										),
								'day' => Array(
											'name' => 'userdate[joined_day]',
											'value' => $editinfo['joined']['day']
										),
								'year' => Array(
											'name' => 'userdate[joined_year]',
											'value' => $editinfo['joined']['year']
										)
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_lastvisit'],
								'desc' => $lang['admin_users_ae_lastvisit_desc'],
								'type' => 'dateTime',
								'month' => Array(
											'name' => 'userdate[lastvisit_month]',
											'value' => $editinfo['lastvisit']['month']
										),
								'day' => Array(
											'name' => 'userdate[lastvisit_day]',
											'value' => $editinfo['lastvisit']['day']
										),
								'year' => Array(
											'name' => 'userdate[lastvisit_year]',
											'value' => $editinfo['lastvisit']['year']
										),
								'hour' => Array(
											'name' => 'userdate[lastvisit_hour]',
											'value' => $editinfo['lastvisit']['hour']
										),
								'minute' => Array(
											'name' => 'userdate[lastvisit_minute]',
											'value' => $editinfo['lastvisit']['minute']
										),
								'ampm' => Array(
											'name' => 'userdate[lastvisit_ampm]',
											'value' => (($editinfo['lastvisit']['ampm'] == 'pm') ? 1 : 0)
										)
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_lastactivity'],
								'desc' => $lang['admin_users_ae_lastactivity_desc'],
								'type' => 'dateTime',
								'month' => Array(
											'name' => 'userdate[lastactivity_month]',
											'value' => $editinfo['lastactivity']['month']
										),
								'day' => Array(
											'name' => 'userdate[lastactivity_day]',
											'value' => $editinfo['lastactivity']['day']
										),
								'year' => Array(
											'name' => 'userdate[lastactivity_year]',
											'value' => $editinfo['lastactivity']['year']
										),
								'hour' => Array(
											'name' => 'userdate[lastactivity_hour]',
											'value' => $editinfo['lastactivity']['hour']
										),
								'minute' => Array(
											'name' => 'userdate[lastactivity_minute]',
											'value' => $editinfo['lastactivity']['minute']
										),
								'ampm' => Array(
											'name' => 'userdate[lastactivity_ampm]',
											'value' => (($editinfo['lastactivity']['ampm'] == 'pm') ? 1 : 0)
										)
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_lastpost'],
								'desc' => $lang['admin_users_ae_lastpost_desc'],
								'type' => 'dateTime',
								'month' => Array(
											'name' => 'userdate[lastpost_month]',
											'value' => $editinfo['lastpost']['month']
										),
								'day' => Array(
											'name' => 'userdate[lastpost_day]',
											'value' => $editinfo['lastpost']['day']
										),
								'year' => Array(
											'name' => 'userdate[lastpost_year]',
											'value' => $editinfo['lastpost']['year']
										),
								'hour' => Array(
											'name' => 'userdate[lastpost_hour]',
											'value' => $editinfo['lastpost']['hour']
										),
								'minute' => Array(
											'name' => 'userdate[lastpost_minute]',
											'value' => $editinfo['lastpost']['minute']
										),
								'ampm' => Array(
											'name' => 'userdate[lastpost_ampm]',
											'value' => (($editinfo['lastpost']['ampm'] == 'pm') ? 1 : 0)
										)
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: TIME OPTIONS ##### \\


	// #### BEGIN: DEFAULT MESSAGE TEXT ##### \\
	new AdminHTML('tableBegin', $lang['admin_users_ae_defMessageText'], true, Array('form' => 0));

	if($which != 'search') {
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_defAuto'],
									'desc' => $lang['admin_users_ae_defAuto_desc'],
									'type' => 'checkbox',
									'name' => 'user[defAuto]',
									'value' => $editinfo['defAuto']
								), true);
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_defFont'],
								'desc' => $lang['admin_users_ae_defFont_desc'],
								'type' => 'text',
								'name' => 'user[defFont]',
								'value' => $editinfo['defFont']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_defColor'],
								'desc' => $lang['admin_users_ae_defColor_desc'],
								'type' => 'text',
								'name' => 'user[defColor]',
								'value' => $editinfo['defColor']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_defSize'],
								'desc' => $lang['admin_users_ae_defSize_desc'],
								'type' => 'text',
								'name' => 'user[defSize]',
								'value' => $editinfo['defSize']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: DEFAULT MESSAGE TEXT ##### \\


	// ##### BEGIN: PREFERENCES ##### \\
	new AdminHTML('tableBegin', $lang['admin_users_ae_preferences'], true, Array('form' => 0));

	if($which != 'search') {
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_toolbar'],
									'desc' => $lang['admin_users_ae_toolbar_desc'],
									'type' => 'checkbox',
									'name' => 'user[toolbar]',
									'value' => $editinfo['toolbar']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_allowHtml'],
									'desc' => $lang['admin_users_ae_allowHtml_desc'],
									'type' => 'checkbox',
									'name' => 'user[allowHtml]',
									'value' => $editinfo['allowHtml']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_censor'],
									'desc' => $lang['admin_users_ae_censor_desc'],
									'type' => 'checkbox',
									'name' => 'user[censor]',
									'value' => $editinfo['censor']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_banSig'],
									'desc' => $lang['admin_users_ae_banSig_desc'],
									'type' => 'checkbox',
									'name' => 'user[banSig]',
									'value' => $editinfo['banSig']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_disSigs'],
									'desc' => $lang['admin_users_ae_disSigs_desc'],
									'type' => 'checkbox',
									'name' => 'user[disSigs]',
									'value' => $editinfo['disSigs']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_disImgs'],
									'desc' => $lang['admin_users_ae_disImgs_desc'],
									'type' => 'checkbox',
									'name' => 'user[disImgs]',
									'value' => $editinfo['disImgs']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_disAttach'],
									'desc' => $lang['admin_users_ae_disAttach_desc'],
									'type' => 'checkbox',
									'name' => 'user[disAttach]',
									'value' => $editinfo['disAttach']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_disAv'],
									'desc' => $lang['admin_users_ae_disAv_desc'],
									'type' => 'checkbox',
									'name' => 'user[disAv]',
									'value' => $editinfo['disAv']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_disSmi'],
									'desc' => $lang['admin_users_ae_disSmi_desc'],
									'type' => 'checkbox',
									'name' => 'user[disSmi]',
									'value' => $editinfo['disSmi']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_invis'],
									'desc' => $lang['admin_users_ae_invis_desc'],
									'type' => 'checkbox',
									'name' => 'user[invis]',
									'value' => $editinfo['invis']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_emailContact'],
									'desc' => $lang['admin_users_ae_emailContact_desc'],
									'type' => 'checkbox',
									'name' => 'user[emailContact]',
									'value' => $editinfo['emailContact']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_adminEmails'],
									'desc' => $lang['admin_users_ae_adminEmails_desc'],
									'type' => 'checkbox',
									'name' => 'user[adminEmails]',
									'value' => $editinfo['adminEmails']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_receivePm'],
									'desc' => $lang['admin_users_ae_receivePm_desc'],
									'type' => 'checkbox',
									'name' => 'user[receivePm]',
									'value' => $editinfo['receivePm']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_receivePmEmail'],
									'desc' => $lang['admin_users_ae_receivePmEmail_desc'],
									'type' => 'checkbox',
									'name' => 'user[receivePmEmail]',
									'value' => $editinfo['receivePmEmail']
								), true);

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_receivePmAlert'],
									'desc' => $lang['admin_users_ae_receivePmAlert_desc'],
									'type' => 'checkbox',
									'name' => 'user[receivePmAlert]',
									'value' => $editinfo['receivePmAlert']
								), true);

		$displayOrders = Array();
		$displayOrders[$lang['admin_users_ae_displayOrder_asc']] = 'ASC';
		$displayOrders[$lang['admin_users_ae_displayOrder_desce']] = 'DESC';
		$dOSelect = $editinfo['displayOrder'];

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_users_ae_displayOrder'],
									'desc' => $lang['admin_users_ae_displayOrder_desc'],
									'type' => 'select',
									'name' => 'user[displayOrder]',
									'select' => Array('fields' => $displayOrders, 'select' => $dOSelect)
								), true);
	}

	$postsPerPage = Array();
	$postsPerPage[$lang['global_useForumDefault']] = 0;
	$pPPSelect = $editinfo['postsPerPage'];
	$kaboom = preg_split('/\s+/', $bboptions['settablePostsPerPage']);

	foreach($kaboom as $v) {
		$postsPerPage[$v] = $v;
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_postsPerPage'],
								'desc' => $lang['admin_users_ae_postsPerPage_desc'],
								'type' => 'select',
								'name' => 'user[postsPerPage]',
								'select' => Array('fields' => $postsPerPage, 'select' => $pPPSelect)
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_threadViewAge'],
								'desc' => $lang['admin_users_ae_threadViewAge_desc'],
								'type' => 'select',
								'name' => 'user[threadViewAge]',
								'select' => Array('fields' => array_flip(WtcDate::buildViewAge()), 'select' => $editinfo['threadViewAge'])
							), true);

	// get all languages
	$langs = Array();
	$merger = Array();
	$merger[$lang['global_useForumDefault']] = -1;
	$langs = $merger + Language::buildLanguages();

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_lang'],
								'desc' => $lang['admin_users_ae_lang_desc'],
								'type' => 'select',
								'name' => 'user[lang]',
								'select' => Array('fields' => $langs, 'select' => $editinfo['lang'])
							), true);

	$styleArr = Array();
	$styleArr[$lang['global_useForumDefault']] = 0;

	$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator(), true);

	foreach($styleIter as $style) {
		$styleArr[str_repeat('-', $styleIter->getDepth()) . $style->getName()] = $style->getStyleId();
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_styleid'],
								'desc' => $lang['admin_users_ae_styleid_desc'],
								'type' => 'select',
								'name' => 'user[styleid]',
								'select' => Array('fields' => $styleArr, 'select' => $editinfo['styleid'])
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: PREFERENCES ##### \\


	// ##### BEGIN: PROFILE FIELDS ##### \\
	new AdminHTML('tableBegin', $lang['admin_users_ae_profileFields'], true, Array('form' => 0));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_birthday'],
								'desc' => $lang['admin_users_ae_birthday_desc'],
								'type' => 'date',
								'month' => Array(
											'name' => 'userdate[birthday_month]',
											'value' => $editinfo['birthday']['month']
										),
								'day' => Array(
											'name' => 'userdate[birthday_day]',
											'value' => $editinfo['birthday']['day']
										),
								'year' => Array(
											'name' => 'userdate[birthday_year]',
											'value' => $editinfo['birthday']['year']
										)
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_homepage'],
								'desc' => $lang['admin_users_ae_homepage_desc'],
								'type' => 'text',
								'name' => 'user[homepage]',
								'value' => $editinfo['homepage']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_biography'],
								'desc' => $lang['admin_users_ae_biography_desc'],
								'type' => 'text',
								'name' => 'user[biography]',
								'value' => $editinfo['biography']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_occupation'],
								'desc' => $lang['admin_users_ae_occupation_desc'],
								'type' => 'text',
								'name' => 'user[occupation]',
								'value' => $editinfo['occupation']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_interests'],
								'desc' => $lang['admin_users_ae_interests_desc'],
								'type' => 'text',
								'name' => 'user[interests]',
								'value' => $editinfo['interests']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_location'],
								'desc' => $lang['admin_users_ae_location_desc'],
								'type' => 'text',
								'name' => 'user[location]',
								'value' => $editinfo['location']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_aim'],
								'desc' => $lang['admin_users_ae_aim_desc'],
								'type' => 'text',
								'name' => 'user[aim]',
								'value' => $editinfo['aim']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_msn'],
								'desc' => $lang['admin_users_ae_msn_desc'],
								'type' => 'text',
								'name' => 'user[msn]',
								'value' => $editinfo['msn']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_icq'],
								'desc' => $lang['admin_users_ae_icq_desc'],
								'type' => 'text',
								'name' => 'user[icq]',
								'value' => $editinfo['icq']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_users_ae_yahoo'],
								'desc' => $lang['admin_users_ae_yahoo_desc'],
								'type' => 'text',
								'name' => 'user[yahoo]',
								'value' => $editinfo['yahoo']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: PROFILE FIELDS ##### \\

	new AdminHTML('footer', '', true, Array('form' => 1));
}

?>