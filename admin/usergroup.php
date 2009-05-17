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
## ******************* USERGROUP ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-USERGROUPS');
define('FILE_ACTION', 'Usergroups');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

if($_GET['do'] == 'admins') {
	if(!$User->isSuperAdmin()) {
		new WtcBBException($lang['admin_error_privilegesAdmin']);
	}

	// get our admins
	$get = new Query($query['admin']['get_admins_users']);

	if(!$wtcDB->numRows($get)) {
		new WtcBBException($lang['admin_error_noAdmins']);
	}

	while($admin = $wtcDB->fetchArray($get)) {
		$admins[$admin['username']] = $admin;
	}

	ksort($admins);

	new AdminHTML('header', $lang['admin_usergroups_admins'], true);

	new AdminHTML('tableBegin', $lang['admin_usergroups_admins'], true);

	foreach($admins as $username => $info) {
		$cells = Array(
					'<a href="admin.php?file=usergroup&amp;admin=' . $info['userid'] . '">' . $username . '</a>' => Array(),
					'<a href="admin.php?file=usergroup&amp;admin=' . $info['userid'] . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=log&amp;do=admin">' . $lang['admin_usergroups_admins_viewLog'] . '</a>' => Array()
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}

	new AdminHTML('tableEnd', '', true, Array('form' => 0));
	new AdminHTML('footer', '', true);
}

else if(isset($_GET['admin'])) {
	if(!$User->isSuperAdmin()) {
		new WtcBBException($lang['admin_error_privilegesAdmin']);
	}

	$userObj = new Admin($_GET['admin']);
	$user = $userObj->info;

	// get our admin
	$getAdmin = new Query($query['admin']['get_admin'], Array(1 => $user['userid']));

	if(!$wtcDB->numRows($getAdmin)) {
		new WtcBBException($lang['admin_error_noAdmins']);
	}

	$admin = $wtcDB->fetchArray($getAdmin);

	// get all fields in ADMIN table
	$getAdminFields = new Query($query['global']['get_table_fields'], Array(1 => 'admins'));

	if(isset($_POST['formSet'])) {
		$update = $wtcDB->massUpdate($_POST['admin']);

		new Query($query['admin']['update_admin'], Array(1 => preg_replace('/,\s$/', '', $update), $user['userid']), 'query', false);
		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=usergroup&amp;do=admins');
	}

	new AdminHTML('header', $lang['admin_usergroups_admins'], true);

	new AdminHTML('tableBegin', $lang['admin_usergroups_admins_admin'] . ': ' . $user['username'], true, Array('form' => true));

	$allYesNo = new AdminHTML('allYesNo', '', false, Array('return' => true));

	$cells = Array(
				$lang['users_username'] => Array('th' => true),
				$allYesNo->dump() => Array('th' => true, 'class' => 'left')
			);

	new AdminHTML('tableCells', '', true, Array('cells' => $cells));

	while($field = $wtcDB->fetchArray($getAdminFields)) {
		$fields[$lang['admin_usergroups_admins_' . $field['Field']]] = $field;
	}

	ksort($fields);

	foreach($fields as $langName => $bleh) {
		$fieldName = $bleh['Field'];

		if($fieldName == 'adminid' OR $fieldName == 'userid') {
			continue;
		}

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_usergroups_admins_' . $fieldName],
									'desc' => $lang['admin_usergroups_admins_' . $fieldName . '_desc'],
									'type' => 'checkbox',
									'name' => 'admin[' . $fieldName . ']',
									'value' => $admin[$fieldName]
								), true);
	}

	new AdminHTML('tableEnd', '', true, Array('form' => true));
	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'automation' AND isset($_GET['delete'])) {
	if($_POST['formSet']) {
		if($_POST['delConfirm']) {
			new Delete('usergroups_auto', 'autoid', $_GET['delete'], '');
			new Cache('Automations');
			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=usergroup&amp;do=automation');
		}

		else {
			new Redirect('admin.php?file=usergroup&amp;do=automation');
		}
	}

	new Delete('', '', '', '', true);
}

else if($_GET['do'] == 'automation' AND ($_GET['go'] == 'add' OR isset($_GET['edit']))) {
	if($_GET['go'] == 'add') {
		$which = 'add';

		$editinfo = Array(
						'postsa' => 50, 'postsComp' => 1, 'daysReg' => 30,
						'daysRegComp' => 1, 'secondary' => 0, 'type' => 1,
						'affectedId' => (isset($_GET['affected']) ? $_GET['affected'] : 4), 'moveTo' => 5
					);
	}

	else {
		$which = 'edit';

		$getAuto = new Query($query['admin']['get_auto'], Array(1 => $_GET['edit']));

		if(!$wtcDB->numRows($getAuto)) {
			new WtcBBException($lang['error_noInfo']);
		}

		$editinfo = $wtcDB->fetchArray($getAuto);
	}

	if(isset($_POST['formSet'])) {
		// get affected IDs...
		// make sure we have an array!
		if(empty($_POST['postsa']) OR empty($_POST['daysReg'])) {
			new WtcBBException($lang['admin_error_notEnoughInfo']);
		}

		if($which == 'add') {
			// insert information
			new Query($query['admin']['insert_automation'], Array(
																1 => $_POST['affectedId'],
																$_POST['moveTo'],
																$_POST['daysReg'],
																$_POST['daysRegComp'],
																$_POST['postsa'],
																$_POST['postsComp'],
																$_POST['type'],
																$_POST['secondary']
															));
		}

		else {
			new Query($query['admin']['update_automation'], Array(
																1 => $_POST['affectedId'],
																$_POST['moveTo'],
																$_POST['daysReg'],
																$_POST['daysRegComp'],
																$_POST['postsa'],
																$_POST['postsComp'],
																$_POST['type'],
																$_POST['secondary'],
																$editinfo['autoid']
															));
		}

		// update cache
		new Cache('Automations');

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=usergroup&amp;do=automation');
	}

	new AdminHTML('header', $lang['admin_usergroups_auto_' . $which], true, Array(
																	'extra2' => "\t" . '<p class="marBot">' . $lang['admin_usergroups_auto_details'] . '</p>' . "\n\n"
																	));

	new AdminHTML('tableBegin', $lang['admin_usergroups_auto_' . $which], true, Array('form' => true));

	$compSelect = Array(
					'Greater Than or Equal To' => 1,
					'Less Than' => 0
				);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_auto_posts'],
								'desc' => $lang['admin_usergroups_auto_posts_desc'],
								'type' => 'text',
								'name' => 'postsa',
								'value' => $editinfo['postsa']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_auto_postsComp'],
								'desc' => $lang['admin_usergroups_auto_postsComp_desc'],
								'type' => 'select',
								'name' => 'postsComp',
								'select' => Array('fields' => $compSelect, 'select' => $editinfo['postsComp'])
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_auto_reg'],
								'desc' => $lang['admin_usergroups_auto_reg_desc'],
								'type' => 'text',
								'name' => 'daysReg',
								'value' => $editinfo['daysReg']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_auto_regComp'],
								'desc' => $lang['admin_usergroups_auto_regComp_desc'],
								'type' => 'select',
								'name' => 'daysRegComp',
								'select' => Array('fields' => $compSelect, 'select' => $editinfo['daysRegComp'])
							), true);

	$typeSelected = $editinfo['type'];
	$typeSelect = Array(
					'Posts' => 1,
					'Days Registered' => 2,
					'Posts or Days Registered' => 3,
					'Posts and Days Registered' => 4
				);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_auto_type'],
								'desc' => $lang['admin_usergroups_auto_type_desc'],
								'type' => 'select',
								'name' => 'type',
								'select' => Array('fields' => $typeSelect, 'select' => $typeSelected)
							), true);

	$groupSelect = Array();

	foreach($groups as $groupid => $obj) {
		$groupSelect[$obj->getName()] = $obj->getId();
	}

	ksort($groupSelect);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_auto_affected'],
								'desc' => $lang['admin_usergroups_auto_affected_desc'],
								'type' => 'select',
								'name' => 'affectedId',
								'select' => Array('fields' => $groupSelect, 'select' => $editinfo['affectedId'])
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_auto_secondary'],
								'desc' => $lang['admin_usergroups_auto_secondary_desc'],
								'type' => 'checkbox',
								'name' => 'secondary',
								'value' => $editinfo['secondary']
							), true);

	$groupSelected = $editinfo['moveTo'];

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_auto_moveTo'],
								'desc' => $lang['admin_usergroups_auto_moveTo_desc'],
								'type' => 'select',
								'name' => 'moveTo',
								'select' => Array('fields' => $groupSelect, 'select' => $groupSelected)
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => true));
	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'automation') {
	new AdminHTML('header', $lang['admin_usergroups_man'], true, Array(
																	'extra2' => "\t" . '<p class="marBot">' . $lang['admin_usergroups_auto_details'] . '</p>' . "\n\n"
																	));

	// get all automations
	$getAutos = new Query($query['admin']['get_automations']);

	if(!$wtcDB->numRows($getAutos)) {
		new AdminHTML('divit', Array(
									'content' => '<a href="admin.php?file=usergroup&amp;do=automation&amp;go=add">' . $lang['admin_usergroups_auto_add'] . '</a>',
									'class' => 'center'
								), true);
	}

	else {
		new AdminHTML('tableBegin', $lang['admin_usergroups_auto_man'], true, Array('form' => 0, 'colspan' => 4));

		$thCells = Array(
						$lang['admin_usergroups_auto_man_affected'] => Array('th' => true, 'class' => 'nowrap'),
						$lang['admin_usergroups_auto_man_moveTo'] => Array('th' => true, 'class' => 'nowrap'),
						$lang['admin_usergroups_auto_man_seconday'] => Array('th' => true, 'class' => 'nowrap'),
						$lang['admin_options'] => Array('th' => true, 'class' => 'nowrap')
					);

		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		while($auto = $wtcDB->fetchArray($getAutos)) {
			$cells = Array(
						'<a href="admin.php?file=usergroup&amp;do=automation&amp;edit=' . $auto['autoid'] . '">' . $groups[$auto['affectedId']]->getName() . '</a>' => Array(),
						'<a href="admin.php?file=usergroups&amp;edit=' . $auto['moveTo'] . '">' . $groups[$auto['moveTo']]->getName() . '</a>' => Array(),
						(($auto['secondary'] == 1) ? $lang['admin_yes'] : $lang['admin_no']) => Array('class' => 'center'),
						'<a href="admin.php?file=usergroup&amp;do=automation&amp;edit=' . $auto['autoid'] . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=usergroup&amp;do=automation&amp;delete=' . $auto['autoid'] . '">' . $lang['admin_delete'] . '</a>' => Array()
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('form' => 0, 'colspan' => 4, 'footerText' => '<a href="admin.php?file=usergroup&amp;do=automation&amp;go=add">' . $lang['admin_usergroups_auto_add'] . '</a>'));
	}

	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	// setup default values
	if($_GET['do'] == 'add') {
		$which = 'add';
		$submitText = $lang['admin_usergroups_add_insertGroup'];

		// which group should we model after?
		if(!isset($_GET['groupid'])) {
			$groupObj = new Usergroup(4);
		}

		else {
			$groupObj = new Usergroup($_GET['groupid']);
		}

		$editinfo = $groupObj->info;
	}

	else if(isset($_GET['edit'])) {
		$usergroupObj = new Usergroup($_GET['edit']);
		$which = 'edit';
		$submitText = $lang['admin_usergroups_edit_updateGroup'];
		$editinfo = $usergroupObj->info;
	}

	if(isset($_POST['formSet'])) {
		if($which == 'add') {
			// check to make sure we have a unique title
			$checkUnique = new Query($query['usergroups']['check_unique_title'], Array(1 => $_POST['usergroup']['title']));
			$check = $wtcDB->fetchArray($checkUnique);

			if($check['checking']) {
				new WtcBBException($lang['admin_error_uniqueGroupTitle']);
			}

			// form array, and insert...
			Usergroup::insert($_POST['usergroup']);
		}

		else if($which == 'edit') {
			// check to make sure we have a unique title
			$checkUnique = new Query($query['usergroups']['check_unique_title_edit'], Array(1 => $_POST['usergroup']['title'], 2 => $editinfo['usergroupid']));
			$check = $wtcDB->fetchArray($checkUnique);

			if($check['checking']) {
				new WtcBBException($lang['admin_error_uniqueGroupTitle']);
			}

			// form array and update
			$usergroupObj->update($_POST['usergroup']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=usergroup&amp;do=manager');
	}

	if($which == 'add') {
		$groupArr = Usergroup::groupAndSort($query['usergroups']['get_groups']);

		foreach($groupArr as $title => $info) {
			$models['admin.php?file=usergroup&amp;do=add&amp;groupid=' . $info['usergroupid']] = $title;
		}

		$groupModel = new AdminHTML('locationSelect', '', true, Array(
																	'locs' => $models,
																	'return' => true,
																	'select' => ((!isset($_GET['groupid'])) ? $groups[4]->misc('title') : $groups[$_GET['groupid']]->misc('title')),
																	'message' => '<strong>' . $lang['admin_usergroups_ae_model'] . ':</strong> '
																));

		@ob_start();
			new AdminHTML('divit', Array('content' => $groupModel->dump()), true);
			$groupModel = @ob_get_contents();
		@ob_end_clean();

		new AdminHTML('header', $lang['admin_usergroups_add'], true, Array('form' => 1, 'extra2' => $groupModel));
	}

	else {
		new AdminHTML('header', $lang['admin_usergroups_edit'] . ': ' . $editinfo['title'], true, Array('form' => 1));
	}

	// ##### BEGIN: GENERAL INFORMATION ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_information'], true, Array('form' => 0));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_title'],
								'desc' => $lang['admin_usergroups_ae_title_desc'],
								'type' => 'text',
								'name' => 'usergroup[title]',
								'value' => $editinfo['title']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_description'],
								'desc' => $lang['admin_usergroups_ae_description_desc'],
								'type' => 'textarea',
								'name' => 'usergroup[description]',
								'value' => $editinfo['description'],
								'html' => true
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_usertitle'],
								'desc' => $lang['admin_usergroups_ae_usertitle_desc'],
								'type' => 'text',
								'name' => 'usergroup[usertitle]',
								'value' => $editinfo['usertitle'],
								'html' => true
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_htmlBegin'],
								'desc' => $lang['admin_usergroups_ae_htmlBegin_desc'],
								'type' => 'text',
								'name' => 'usergroup[htmlBegin]',
								'value' => $editinfo['htmlBegin'],
								'html' => true
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_htmlEnd'],
								'desc' => $lang['admin_usergroups_ae_htmlEnd_desc'],
								'type' => 'text',
								'name' => 'usergroup[htmlEnd]',
								'value' => $editinfo['htmlEnd'],
								'html' => true
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: REQUIRED FIELDS ##### \\


	// ##### BEGIN: USERGROUP TYPE ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_type'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_admin'],
								'desc' => $lang['admin_usergroups_ae_admin_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[admin]',
								'value' => $editinfo['admin']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_global'],
								'desc' => $lang['admin_usergroups_ae_global_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[global]',
								'value' => $editinfo['global']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_isBanned'],
								'desc' => $lang['admin_usergroups_ae_isBanned_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[isBanned]',
								'value' => $editinfo['isBanned']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: USERGROUP TYPE ##### \\


	// ##### BEGIN: VIEWABLE OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_viewable'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_listedGroups'],
								'desc' => $lang['admin_usergroups_ae_listedGroups_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[showListedGroups]',
								'value' => $editinfo['showListedGroups']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_memberList'],
								'desc' => $lang['admin_usergroups_ae_memberList_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[showMemberList]',
								'value' => $editinfo['showMemberList']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_birthdays'],
								'desc' => $lang['admin_usergroups_ae_birthdays_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[showBirthdays]',
								'value' => $editinfo['showBirthdays']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_showEditedNotice'],
								'desc' => $lang['admin_usergroups_ae_showEditedNotice_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[showEditedNotice]',
								'value' => $editinfo['showEditedNotice']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_showRanks'],
								'desc' => $lang['admin_usergroups_ae_showRanks_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[showRanks]',
								'value' => $editinfo['showRanks']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: VIEWABLE OPTIONS ##### \\


	// ##### BEGIN: GENERAL DISPLAY ACCESS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_genDisAccess'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewBoard'],
								'desc' => $lang['admin_usergroups_ae_viewBoard_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canViewBoard]',
								'value' => $editinfo['canViewBoard']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewForums'],
								'desc' => $lang['admin_usergroups_ae_viewForums_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canViewForums]',
								'value' => $editinfo['canViewForums']
							), true);


	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewInvis'],
								'desc' => $lang['admin_usergroups_ae_viewInvis_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canViewInvis]',
								'value' => $editinfo['canViewInvis']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewProfile'],
								'desc' => $lang['admin_usergroups_ae_viewProfile_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canViewProfile]',
								'value' => $editinfo['canViewProfile']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewMemberList'],
								'desc' => $lang['admin_usergroups_ae_viewMemberList_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canViewMemberList]',
								'value' => $editinfo['canViewMemberList']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: GENERAL DISPLAY ACCESS ##### \\


	// ##### BEGIN: GENERAL OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_genOptions'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_search'],
								'desc' => $lang['admin_usergroups_ae_search_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canSearch]',
								'value' => $editinfo['canSearch']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_invis'],
								'desc' => $lang['admin_usergroups_ae_invis_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canInvis]',
								'value' => $editinfo['canInvis']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_canUsertitle'],
								'desc' => $lang['admin_usergroups_ae_canUsertitle_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canUsertitle]',
								'value' => $editinfo['canUsertitle']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_sig'],
								'desc' => $lang['admin_usergroups_ae_sig_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canSig]',
								'value' => $editinfo['canSig']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_defBBCode'],
								'desc' => $lang['admin_usergroups_ae_defBBCode_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canDefBBCode]',
								'value' => $editinfo['canDefBBCode']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_editProfile'],
								'desc' => $lang['admin_usergroups_ae_editProfile_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canEditProfile]',
								'value' => $editinfo['canEditProfile']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_styles'],
								'desc' => $lang['admin_usergroups_ae_styles_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canSwitchStyles]',
								'value' => $editinfo['canSwitchStyles']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_censor'],
								'desc' => $lang['admin_usergroups_ae_censor_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canDisableCensor]',
								'value' => $editinfo['canDisableCensor']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_ignore'],
								'desc' => $lang['admin_usergroups_ae_ignore_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canIgnoreList]',
								'value' => $editinfo['canIgnoreList']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: GENERAL OPTIONS ##### \\


	// ##### BEGIN: FORUM OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_forumOptions'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_editedNotice'],
								'desc' => $lang['admin_usergroups_ae_editedNotice_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canEditedNotice]',
								'value' => $editinfo['canEditedNotice']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_close'],
								'desc' => $lang['admin_usergroups_ae_close_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canCloseOwn]',
								'value' => $editinfo['canCloseOwn']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewThreads'],
								'desc' => $lang['admin_usergroups_ae_viewThreads_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canViewThreads]',
								'value' => $editinfo['canViewThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewOwnThreads'],
								'desc' => $lang['admin_usergroups_ae_viewOwnThreads_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canViewOwnThreads]',
								'value' => $editinfo['canViewOwnThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_postThreads'],
								'desc' => $lang['admin_usergroups_ae_postThreads_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canPostThreads]',
								'value' => $editinfo['canPostThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_reply'],
								'desc' => $lang['admin_usergroups_ae_reply_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canReplyOthers]',
								'value' => $editinfo['canReplyOthers']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_replyOwn'],
								'desc' => $lang['admin_usergroups_ae_replyOwn_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canReplyOwn]',
								'value' => $editinfo['canReplyOwn']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_edit'],
								'desc' => $lang['admin_usergroups_ae_edit_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canEditOwn]',
								'value' => $editinfo['canEditOwn']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_editThreadTitle'],
								'desc' => $lang['admin_usergroups_ae_editThreadTitle_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canEditOwnThreadTitle]',
								'value' => $editinfo['canEditOwnThreadTitle']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewDelNotices'],
								'desc' => $lang['admin_usergroups_ae_viewDelNotices_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canViewDelNotices]',
								'value' => $editinfo['canViewDelNotices']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_delPosts'],
								'desc' => $lang['admin_usergroups_ae_delPosts_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canDelOwnPosts]',
								'value' => $editinfo['canDelOwnPosts']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_permPosts'],
								'desc' => $lang['admin_usergroups_ae_permPosts_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canPermDelOwnPosts]',
								'value' => $editinfo['canPermDelOwnPosts']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_delThreads'],
								'desc' => $lang['admin_usergroups_ae_delThreads_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canDelOwnThreads]',
								'value' => $editinfo['canDelOwnThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_permThreads'],
								'desc' => $lang['admin_usergroups_ae_permThreads_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canPermDelOwnThreads]',
								'value' => $editinfo['canPermDelOwnThreads']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: FORUM OPTIONS ##### \\


	// ##### BEGIN: MESSAGE OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_messageOpt'], true, Array('form' => 0));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_bb'],
								'desc' => $lang['admin_usergroups_ae_bb_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canBBCode]',
								'value' => $editinfo['canBBCode']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_img'],
								'desc' => $lang['admin_usergroups_ae_img_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canImg]',
								'value' => $editinfo['canImg']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_smilies'],
								'desc' => $lang['admin_usergroups_ae_smilies_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canSmilies]',
								'value' => $editinfo['canSmilies']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_icons'],
								'desc' => $lang['admin_usergroups_ae_icons_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canIcons]',
								'value' => $editinfo['canIcons']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: MESSAGE OPTIONS ##### \\


	// ##### BEGIN: SUPERVISION ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_supervision'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_supThreads'],
								'desc' => $lang['admin_usergroups_ae_supThreads_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[superThreads]',
								'value' => $editinfo['superThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_supPosts'],
								'desc' => $lang['admin_usergroups_ae_supPosts_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[superPosts]',
								'value' => $editinfo['superPosts']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: SUPERVISION ##### \\


	// ##### BEGIN: OVERRIDES ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_overrides'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_flood'],
								'desc' => $lang['admin_usergroups_ae_flood_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[overrideFlood]',
								'value' => $editinfo['overrideFlood']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_mesMinChars'],
								'desc' => $lang['admin_usergroups_ae_mesMinChars_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[overridePostMinChars]',
								'value' => $editinfo['overridePostMinChars']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_mesMaxChars'],
								'desc' => $lang['admin_usergroups_ae_mesMaxChars_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[overridePostMaxChars]',
								'value' => $editinfo['overridePostMaxChars']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_mesMaxImgs'],
								'desc' => $lang['admin_usergroups_ae_mesMaxImgs_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[overridePostMaxImages]',
								'value' => $editinfo['overridePostMaxImages']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_searchMinChars'],
								'desc' => $lang['admin_usergroups_ae_searchMinChars_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[overrideSearchMinChars]',
								'value' => $editinfo['overrideSearchMinChars']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_searchMaxChars'],
								'desc' => $lang['admin_usergroups_ae_searchMaxChars_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[overrideSearchMaxChars]',
								'value' => $editinfo['overrideSearchMaxChars']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_sigMaxChars'],
								'desc' => $lang['admin_usergroups_ae_sigMaxChars_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[overrideMaxSig]',
								'value' => $editinfo['overrideMaxSig']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: OVERRIDES ##### \\


	// ##### BEGIN: PERSONAL MESSAGING ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_personal'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_receipts'],
								'desc' => $lang['admin_usergroups_ae_receipts_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canReceipts]',
								'value' => $editinfo['canReceipts']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_denyReceipts'],
								'desc' => $lang['admin_usergroups_ae_denyReceipts_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canDenyReceipts]',
								'value' => $editinfo['canDenyReceipts']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_folders'],
								'desc' => $lang['admin_usergroups_ae_folders_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canFolders]',
								'value' => $editinfo['canFolders']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_maxMessages'],
								'desc' => $lang['admin_usergroups_ae_maxMessages_desc'],
								'type' => 'text',
								'name' => 'usergroup[personalMaxMessages]',
								'value' => $editinfo['personalMaxMessages']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_sendUsers'],
								'desc' => $lang['admin_usergroups_ae_sendUsers_desc'],
								'type' => 'text',
								'name' => 'usergroup[personalSendUsers]',
								'value' => $editinfo['personalSendUsers']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_rules'],
								'desc' => $lang['admin_usergroups_ae_rules_desc'],
								'type' => 'text',
								'name' => 'usergroup[personalRules]',
								'value' => $editinfo['personalRules']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: PERSONAL MESSAGING ##### \\


	// ##### BEGIN: WARNING SYSTEM PERMISSIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_warnSystem'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_warnOthers'],
								'desc' => $lang['admin_usergroups_ae_warnOthers_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canWarnOthers]',
								'value' => $editinfo['canWarnOthers']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_warnImmune'],
								'desc' => $lang['admin_usergroups_ae_warnImmune_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canWarnImmune]',
								'value' => $editinfo['canWarnImmune']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_warnViewOwn'],
								'desc' => $lang['admin_usergroups_ae_warnViewOwn_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canWarnViewOwn]',
								'value' => $editinfo['canWarnViewOwn']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_warnViewOthers'],
								'desc' => $lang['admin_usergroups_ae_warnViewOthers_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canWarnViewOthers]',
								'value' => $editinfo['canWarnViewOthers']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: WARNING SYSTEM PERMISSIONS ##### \\


	// ##### BEGIN: AVATAR OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_avatar'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_av'],
								'desc' => $lang['admin_usergroups_ae_av_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canAv]',
								'value' => $editinfo['canAv']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_uploadAv'],
								'desc' => $lang['admin_usergroups_ae_uploadAv_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canUploadAv]',
								'value' => $editinfo['canUploadAv']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_maxFilesizeAv'],
								'desc' => $lang['admin_usergroups_ae_maxFilesizeAv_desc'],
								'type' => 'text',
								'name' => 'usergroup[avatarFilesize]',
								'value' => $editinfo['avatarFilesize']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_maxWidth'],
								'desc' => $lang['admin_usergroups_ae_maxWidth_desc'],
								'type' => 'text',
								'name' => 'usergroup[avatarWidth]',
								'value' => $editinfo['avatarWidth']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_maxHeight'],
								'desc' => $lang['admin_usergroups_ae_maxHeight_desc'],
								'type' => 'text',
								'name' => 'usergroup[avatarHeight]',
								'value' => $editinfo['avatarHeight']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: AVATAR OPTIONS ##### \\


	// ##### BEGIN: ATTACHMENT OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_attach'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_upAttach'],
								'desc' => $lang['admin_usergroups_ae_upAttach_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canUpAttach]',
								'value' => $editinfo['canUpAttach']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_downAttach'],
								'desc' => $lang['admin_usergroups_ae_downAttach_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canDownAttach]',
								'value' => $editinfo['canDownAttach']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_maxFilesizeAttach'],
								'desc' => $lang['admin_usergroups_ae_maxFilesizeAttach_desc'],
								'type' => 'text',
								'name' => 'usergroup[attachFilesize]',
								'value' => $editinfo['attachFilesize']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_maxAttach'],
								'desc' => $lang['admin_usergroups_ae_maxAttach_desc'],
								'type' => 'text',
								'name' => 'usergroup[maxAttach]',
								'value' => $editinfo['maxAttach']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: ATTACHMENT OPTIONS ##### \\


	// ##### BEGIN: WHO'S ONLINE PERMISSIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_whosOnline'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewOnline'],
								'desc' => $lang['admin_usergroups_ae_viewOnline_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canViewOnline]',
								'value' => $editinfo['canViewOnline']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_onlineIp'],
								'desc' => $lang['admin_usergroups_ae_onlineIp_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canViewOnlineIp]',
								'value' => $editinfo['canViewOnlineIp']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: WHO'S ONLINE PERMISSIONS ##### \\


	// ##### BEGIN: POLL OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_poll'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_createPolls'],
								'desc' => $lang['admin_usergroups_ae_createPolls_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canCreatePolls]',
								'value' => $editinfo['canCreatePolls']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_vote'],
								'desc' => $lang['admin_usergroups_ae_vote_desc'],
								'type' => 'checkbox',
								'name' => 'usergroup[canVotePolls]',
								'value' => $editinfo['canVotePolls']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: POLL OPTIONS ##### \\

	new AdminHTML('footer', '', true, Array('form' => 1));
}

// do delete
else if(isset($_GET['delete'])) {
	$groupObj = new Usergroup($_GET['delete']);

	// uh oh... can't delete primary groups!
	if($groupObj->info['usergroupid'] <= 8) {
		new WtcBBException('admin_error_cannotDelDefGroup');
	}

	if($_POST['formSet']) {
		if($_POST['delConfirm']) {
			$groupObj->setDestination(4);
			$groupObj->destroy();

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=usergroup&amp;do=manager');
		}

		else {
			new Redirect('admin.php?file=usergroup&do=manager');
		}
	}

	new Delete('', '', '', '', true);
}

// do manager
else {
	new AdminHTML('header', $lang['admin_usergroups_man'], true);

	// do default usergroups
	new AdminHTML('tableBegin', $lang['admin_usergroups_man_def'], true, Array('form' => 0, 'colspan' => 4));

	$cells = Array(
				$lang['admin_usergroups_man_title'] => Array('th' => true, 'class' => 'small'),
				$lang['admin_usergroups_man_primUsers'] => Array('th' => true, 'class' => 'small'),
				$lang['admin_usergroups_man_secUsers'] => Array('th' => true, 'class' => 'small'),
				$lang['admin_options'] => Array('th' => true, 'class' => 'small')
			);

	new AdminHTML('tableCells', '', true, Array('cells' => $cells));

	$groups = Usergroup::groupAndSort($query['usergroups']['get_default_groups']);
	$secUserCount = Array();

	// get total users for secondary groups...
	$get = new Query($query['usergroups']['get_total_secUsers']);

	while($count = $wtcDB->fetchArray($get)) {
		foreach(unserialize($count['secgroupids']) as $groupid) {
			$secUserCount[$groupid]++;
		}
	}

	foreach($groups as $title => $info) {
		if(!$secUserCount[$info['usergroupid']]) {
			$secUserCount[$info['usergroupid']] = 0;
		}

		$optionsObj = new AdminHTML('locationSelect', '', false, Array(
																'locs' => Array(
																			'admin.php?file=usergroup&amp;edit=' . $info['usergroupid'] => $lang['admin_edit'],
																			'admin.php?file=user&amp;do=search&amp;formSet=1&amp;user[usergroupid]=' . $info['usergroupid'] => $lang['admin_usergroups_man_showAllPrim'],
																			'admin.php?file=user&amp;do=search&amp;formSet=1&amp;secgroupid=' . $info['usergroupid'] => $lang['admin_usergroups_man_showAllSec'],
																			'admin.php?file=usergroup&amp;do=automation&amp;go=add&amp;affected=' . $info['usergroupid'] => $lang['admin_usergroups_man_addAuto']
																		),
																'return' => true,
																'name' => $info['usergroupid']
															));

		$options = $optionsObj->dump();

		$cells = Array(
					'<a href="admin.php?file=usergroup&amp;edit=' . $info['usergroupid'] . '">' . $info['title'] . '</a>' => Array(),
					$info['primUsers'] => Array('class' => 'center'),
					$secUserCount[$info['usergroupid']] . '&nbsp;' => Array('class' => 'center'),
					$options => Array()
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}

	new AdminHTML('tableEnd', '', true, Array('form' => 0, 'colspan' => 4, 'footerText' => '<a href="admin.php?file=usergroup&amp;do=add">' . $lang['admin_usergroups_man_addGroup'] . '</a>'));

	// do custom usergroups
	$groups = Array();
	$groups = Usergroup::groupAndSort($query['usergroups']['get_custom_groups']);

	if(count($groups)) {
		new AdminHTML('tableBegin', $lang['admin_usergroups_man_custom'], true, Array('form' => 0, 'colspan' => 4));

		$cells = Array(
					$lang['admin_usergroups_man_title'] => Array('th' => true, 'class' => 'small'),
					$lang['admin_usergroups_man_primUsers'] => Array('th' => true, 'class' => 'small'),
					$lang['admin_usergroups_man_secUsers'] => Array('th' => true, 'class' => 'small'),
					$lang['admin_options'] => Array('th' => true, 'class' => 'small')
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));

		foreach($groups as $title => $info) {
			if(!$secUserCount[$info['usergroupid']]) {
				$secUserCount[$info['usergroupid']] = 0;
			}

			$optionsObj = new AdminHTML('locationSelect', '', false, Array(
																	'locs' => Array(
																				'admin.php?file=usergroup&amp;edit=' . $info['usergroupid'] => $lang['admin_edit'],
																				'admin.php?file=user&amp;do=search&amp;formSet=1&amp;user[usergroupid]=' . $info['usergroupid'] => $lang['admin_usergroups_man_showAllPrim'],
																				'admin.php?file=user&amp;do=search&amp;formSet=1&amp;secgroupid=' . $info['usergroupid'] => $lang['admin_usergroups_man_showAllSec'],
																				'admin.php?file=usergroup&amp;do=automation&amp;go=add&amp;affected=' . $info['usergroupid'] => $lang['admin_usergroups_man_addAuto'],
																				'admin.php?file=usergroup&amp;delete=' . $info['usergroupid'] => $lang['admin_delete']
																			),
																	'return' => true,
																	'name' => $info['usergroupid']
																));

			$options = $optionsObj->dump();

			$cells = Array(
						'<a href="admin.php?file=usergroup&amp;edit=' . $info['usergroupid'] . '">' . $info['title'] . '</a>' => Array(),
						$info['primUsers'] => Array('class' => 'center'),
						$secUserCount[$info['usergroupid']] . '&nbsp;' => Array('class' => 'center'),
						$options => Array()
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('form' => 0, 'colspan' => 4, 'footerText' => '<a href="admin.php?file=usergroup&amp;do=add">' . $lang['admin_usergroups_man_addGroup'] . '</a>'));
	}

	new AdminHTML('footer', '', true);
}


?>