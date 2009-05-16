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
## ***************** wtcBB AVATARS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-AVATARS');
define('FILE_ACTION', 'Avatars');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	if($_GET['do'] == 'add') {
		$which = 'add';
		$editinfo = Array(
						'groupid' => (isset($_GET['groupid']) ? $_GET['groupid'] : 1), 'filePath' => './images/avatars/', 'disOrder' => 1
					);
	}

	else {
		$which = 'edit';
		$avatarObj = new Avatar($_GET['edit']);
		$editinfo = $avatarObj->getInfo();
	}

	// update avatar table
	if($_POST['formSet']) {
		// must fill out avatar name
		if(empty($_POST['avatar']['title'])) {
			new WtcBBException($lang['admin_error_notEnoughInfo']);
		}

		// are we uploading?
		if(!empty($_FILES['fupload']['name'])) {
			$upload = new Upload(null, null, $_FILES['fupload'], './images/avatars/');
			$do = $upload->doUpload();

			// not an image?
			if(!$upload->isImage() OR $do instanceof WtcBBException) {
				$upload->destroy();
				new WtcBBException($lang['admin_error_mustUploadImage']);
			}

			// set img path...
			$_POST['avatar']['imgPath'] = $upload->getDestination();
		}

		else {
			// bad filename?
			if(!file_exists($_POST['avatar']['imgPath']) OR !is_file($_POST['avatar']['imgPath'])) {
				new WtcBBException($lang['admin_error_fileDoesNotExist']);
			}
		}

		// set dis order to 1 if not set
		if(empty($_POST['avatar']['disOrder']) OR $_POST['avatar']['disOrder'] < 1) {
			$_POST['avatar']['disOrder'] = 1;
		}

		// add?
		if($which == 'add') {
			// just insert...
			Avatar::insert($_POST['avatar']);
		}

		// update
		else {
			$avatarObj->update($_POST['avatar']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=avatar');
	}

	new AdminHTML('header', $lang['admin_avatar_' . $which], true);

	new AdminHTML('tableBegin', $lang['admin_avatar_' . $which], true, Array('upload' => true));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_avatar_ae_title'],
								'desc' => $lang['admin_avatar_ae_title_desc'],
								'type' => 'text',
								'name' => 'avatar[title]',
								'value' => $editinfo['title']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_avatar_ae_filePath'],
								'desc' => $lang['admin_avatar_ae_filePath_desc'],
								'type' => 'text',
								'name' => 'avatar[imgPath]',
								'value' => $editinfo['imgPath']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_avatar_ae_imgUp'],
								'desc' => $lang['admin_avatar_ae_imgUp_desc'],
								'type' => 'file',
								'name' => 'fupload'
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_avatar_ae_disOrder'],
								'desc' => $lang['admin_avatar_ae_disOrder_desc'],
								'type' => 'text',
								'name' => 'avatar[disOrder]',
								'value' => $editinfo['disOrder']
							), true);

	// get all groups...
	$avatarGroupsQ = new Query($query['avatar']['get_all_groups']);
	$groupSelect = Array();

	while($avatarGroup = $wtcDB->fetchArray($avatarGroupsQ)) {
		$groupSelect[$avatarGroup['groupName']] = $avatarGroup['groupid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_avatar_ae_group'],
								'desc' => $lang['admin_avatar_ae_group_desc'],
								'type' => 'select',
								'name' => 'avatar[groupid]',
								'select' => Array('fields' => $groupSelect, 'select' => $editinfo['groupid'])
							), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

// delete group
else if(isset($_GET['delGroup'])) {
	$groupObj = new Group($_GET['delGroup']);

	// uh oh... can't delete primary groups!
	if($groupObj->getGroupId() <= 1) {
		new WtcBBException($lang['admin_error_cannotDelGroup']);
	}

	if($_POST['formSet']) {
		if($_POST['delConfirm']) {
			$groupObj->destroy('avatar');

			new Cache('Avatars');

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=avatar');
		}

		else {
			new Redirect('admin.php?file=avatar');
		}
	}

	new Delete('', '', '', '', true, false, 'admin_avatars_delete');
}

// add/edit group
else if($_GET['do'] == 'addGroup' OR isset($_GET['editGroup'])) {
	if($_GET['do'] == 'addGroup') {
		$which = 'add';
		$editinfo = Array('usergroupid' => -1);
	}

	else {
		$which = 'edit';
		$groupObj = new Group($_GET['editGroup']);
		$editinfo = $groupObj->getInfo();
	}

	if(isset($_POST['formSet'])) {
		// don't forget to form groupids array...
		if(!is_array($_POST['usergroupids']) OR !count($_POST['usergroupids'])) {
			new WtcBBException($lang['admin_error_mustSelectGroup']);
		}

		$_POST['groups']['usergroupids'] = Array();

		// hmmm... all usergroups?
		if(in_array(-1, $_POST['usergroupids'])) {
			$_POST['groups']['usergroupids'][] = -1;
		}

		else {
			foreach($_POST['usergroupids'] as $groupid) {
				$_POST['groups']['usergroupids'][] = $groupid;
			}
		}

		$_POST['groups']['usergroupids'] = serialize($_POST['groups']['usergroupids']);

		// add?
		if($which == 'add') {
			Group::insert($_POST['groups']);
		}

		else {
			$groupObj->update($_POST['groups']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=avatar');
	}

	new AdminHTML('header', $lang['admin_groups_ae_' . $which], true);

	new AdminHTML('tableBegin', $lang['admin_groups_ae_' . $which], true, Array(
																			'hiddenInputs' => Array(
																								'groups[groupType]' => 'avatar'
																							)
																		));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_groups_ae_name'],
								'desc' => $lang['admin_groups_ae_name_desc'],
								'type' => 'text',
								'name' => 'groups[groupName]',
								'value' => $editinfo['groupName']
							), true);

	// form usergroups...
	$groupSelect = Array();

	foreach($groups as $groupid => $usergroupObj) {
		$groupSelect[$usergroupObj->info['title']] = $groupid;
	}

	ksort($groupSelect);

	$groupSelect = Array($lang['admin_allGroups'] => -1) + $groupSelect;

	$selecting = '';

	// go through groups and select ours...
	if(is_array($editinfo['usergroupids'])) {
		// wait... is -1 in here?
		if(in_array(-1, $editinfo['usergroupids'])) {
			$selecting = -1;
		}

		else {
			foreach($groupSelect as $title => $id) {
				if(in_array($id, $editinfo['usergroupids'])) {
					$selecting .= $id . ',';
				}
			}
		}
	}

	// otherwise, make 'All Usergroups' selected
	else {
		$selecting = -1;
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_groups_ae_usergroup'],
								'desc' => $lang['admin_groups_ae_usergroup_desc'],
								'type' => 'multiple',
								'name' => 'usergroupids[]',
								'select' => Array('fields' => $groupSelect, 'select' => $selecting)
							), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

// add multiple avatars
else if($_GET['do'] == 'addMultiple') {
	if(!isset($_GET['path'])) {
		new AdminHTML('header', $lang['admin_avatar_addMultiple'], true);

		new AdminHTML('tableBegin', $lang['admin_avatar_addMultiple'], true, Array(
																				'method' => 'get',
																				'hiddenInputs' => Array(
																									'file' => 'avatar',
																									'do' => 'addMultiple'
																								)
																				));

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_avatar_addMultiple_path'],
									'desc' => $lang['admin_avatar_addMultiple_path_desc'],
									'type' => 'text',
									'name' => 'path',
									'value' => './images/avatars'
								), true);

		new AdminHTML('tableEnd', '', true);

		new AdminHTML('footer', '', true);
	}

	else {
		// get rid of possible trailing slash
		$iterPath = preg_replace('/(\/|\\\)$/', '', $_GET['path']);

		if(!is_dir($iterPath)) {
			new WtcBBException($lang['admin_error_noDir']);
		}

		// add avatars...
		if(isset($_POST['avatarNames']) AND is_array($_POST['avatarNames'])) {
			foreach($_POST['avatarNames'] as $fileName => $v) {
				// if this is empty... or if it isn't ticked
				if(empty($v) OR !$_POST['addAvatar'][$fileName]) {
					continue;
				}

				// form out array
				$insert = Array(
							'title' => $v,
							'disOrder' => ($_POST['avatarDisOrders'][$fileName] < 1) ? 1 : $_POST['avatarDisOrders'][$fileName],
							'groupid' => $_POST['groupid'],
							'imgPath' => $iterPath . '/' . $fileName
						);

				Avatar::insert($insert);
			}

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=avatar');
		}

		// get post icons in an array of file paths... check if already exists...
		$avatarPaths = Array();

		if(is_array($avatars)) {
			foreach($avatars as $meh) {
				if(is_array($meh)) {
					foreach($meh as $obj) {
						$avatarPaths[$obj->getImgPath()] = true;
					}
				}
			}
		}

		// make sure we have something... o_0
		$dir = new DirectoryIterator($iterPath);
		$success = false;

		foreach($dir as $iter) {
			// continue if not an image... or it's already in DB
			if(isset($avatarPaths[$iterPath . '/' . $iter->getFilename()]) OR $iter->isDot() OR !@getimagesize($iterPath . '/' . $iter->getFilename())) {
				continue;
			}

			$success = true;
		}

		if(!$success) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		new AdminHTML('header', $lang['admin_avatar_addMultiple'], true, Array(
																	'form' => true,
																	'extra2' => "\t" . '<p class="marBot">' . $lang['admin_avatar_addMultiple_details'] . '</p>' . "\n\n"
																	));

		// select group...
		new AdminHTML('tableBegin', $lang['admin_avatar_addMultiple_group'], true, Array('form' => false));

		// get all groups...
		$avatarGroupsQ = new Query($query['avatar']['get_all_groups']);
		$groupSelect = Array();

		while($avatarGroup = $wtcDB->fetchArray($avatarGroupsQ)) {
			$groupSelect[$avatarGroup['groupName']] = $avatarGroup['groupid'];
		}

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_avatar_ae_group'],
									'desc' => $lang['admin_avatar_addMultiple_group_desc'],
									'type' => 'select',
									'name' => 'groupid',
									'select' => Array('fields' => $groupSelect, 'select' => $editinfo['groupid'])
								), true);

		new AdminHTML('tableEnd', '', true, Array('form' => false));

		new AdminHTML('tableBegin', $lang['admin_avatar_addMultiple'], true, Array('colspan' => 4, 'form' => false));

		// initiate dir iterator
		$dir = new DirectoryIterator($iterPath);
		$disCount = 1;

		$thCells = Array(
						'<input type="checkbox" onclick="wtcBB.tickBoxes(this.form, this);" name="tickAll" checked="checked" />' => Array('th' => true),
						$lang['admin_avatar_addMultiple_img'] => Array('th' => true),
						$lang['admin_avatar_addMultiple_name'] => Array('th' => true),
						$lang['admin_avatar_addMultiple_disOrder'] => Array('th' => true)
					);

		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		foreach($dir as $iter) {
			// continue if not an image
			if(isset($avatarPaths[$iterPath . '/' . $iter->getFilename()]) OR $iter->isDot() OR !@getimagesize($iterPath . '/' . $iter->getFilename())) {
				continue;
			}

			// form cells
			$cells = Array(
						'<input type="checkbox" name="addAvatar[' . $iter->getFilename() . ']" value="1" checked="checked" />' => Array(),
						'<img src="' . $iterPath . '/' . $iter->getFilename() . '" alt="' . $iter->getFilename() . '" />' => Array(),
						'<input type="text" class="text" name="avatarNames[' . $iter->getFilename() . ']" value="' . ucfirst(substr($iter->getFilename(), 0, strpos($iter->getFilename(), '.'))) . '" />' => Array('class' => 'small'),
						'<input type="text" class="text less" name="avatarDisOrders[' . $iter->getFilename() . ']" value="' . $disCount++ . '" />' => Array('class' => 'small')
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('colspan' => 4, 'form' => -1));

		new AdminHTML('footer', '', true, Array('form' => true));
	}
}

// delete avatar
else if(isset($_GET['delete'])) {
	$avatarObj = new Avatar($_GET['delete']);
	$avatarObj->destroy();
}

else {
	// we have a group?
	if(isset($_GET['groupid'])) {
		$gid = $_GET['groupid'];

		// check if we have any...
		if(!isset($avatars[$gid]) OR !count($avatars[$gid])) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		// update quick-fields?
		if(isset($_POST['disOrders'])) {
			if(is_array($_POST['disOrders'])) {
				foreach($_POST['disOrders'] as $id => $val) {
					if($val != $avatars[$gid][$id]->getDisOrder()) {
						$avatars[$gid][$id]->update(Array('disOrder' => $val));
					}
				}
			}

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=avatar');
		}

		new AdminHTML('header', $lang['admin_avatar_man'], true, Array('form' => true));

		new AdminHTML('tableBegin', $generalGroups['avatar'][$gid]->getGroupName(), true, Array('form' => false, 'colspan' => 3));

		$thCells = Array(
					$lang['admin_avatar_man_img'] => Array('th' => true),
					$lang['admin_avatar_man_disOrder'] => Array('th' => true),
					$lang['admin_options'] => Array('th' => true)
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		// loop and display
		foreach($avatars[$gid] as $id => $avatar) {
			$cells = Array(
						'<img src="' . $avatar->getImgPath() . '" alt="' . $avatar->getTitle() . '" />' => Array(),
						'<input type="text" class="text less" name="disOrders[' . $id . ']" value="' . $avatar->getDisOrder() . '" />' => Array(),
						'<a href="admin.php?file=avatar&amp;edit=' . $avatar->getAvatarId() . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=avatar&amp;delete=' . $avatar->getAvatarId() . '">' . $lang['admin_delete'] . '</a>' => Array()
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => '<a href="admin.php?file=avatar&amp;do=add&amp;groupid=' . $gid . '">' . $lang['admin_avatar_add'] . '</a>&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="' . $lang['admin_save'] . '" />', 'colspan' => 3));

		new AdminHTML('footer', '', true, Array('form' => true));
	}

	else {
		new AdminHTML('header', $lang['admin_avatar_man'], true);

		new AdminHTML('tableBegin', $lang['admin_avatar_man'], true, Array('form' => false, 'colspan' => 3));

		$thCells = Array(
					$lang['admin_avatar_man_groupName'] => Array('th' => true),
					$lang['admin_avatar_man_usergroups'] => Array('th' => true),
					$lang['admin_options'] => Array('th' => true)
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		// get group iterator
		$groupIter = new GroupIterator('avatar');

		// loop through general avatar groups...
		foreach($groupIter as $obj) {
			// form our usergroups list...
			$before = '';
			$groupIds = $obj->getUserGroupIds();
			$groupStr = '';

			if(in_array(-1, $groupIds)) {
				$groupStr = '<strong>' . $lang['admin_allGroups'] . '</strong>';
			}

			else {
				foreach($groupIds as $usergroupid) {
					$groupStr .= $before . '<a href="admin.php?file=usergroup&amp;edit=' . $usergroupid . '">' . $groups[$usergroupid]->getName() . '</a>';
					$before = ', ';
				}
			}

			$cells = Array(
						'<a href="admin.php?file=avatar&amp;groupid=' . $obj->getGroupId() . '">' . $obj->getGroupName() . '</a>' => Array(),
						$groupStr => Array(),
						'<a href="admin.php?file=avatar&amp;do=add&amp;groupid=' . $obj->getGroupId() . '">' . $lang['admin_avatar_add'] . '</a> - <a href="admin.php?file=avatar&amp;editGroup=' . $obj->getGroupId() . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=avatar&amp;delGroup=' . $obj->getGroupId() . '">' . $lang['admin_delete'] . '</a>' => Array('class' => 'small')
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('form' => -1, 'colspan' => 3, 'footerText' => '<a href="admin.php?file=avatar&amp;do=addGroup">' . $lang['admin_groups_ae_add'] . '</a>'));

		new AdminHTML('footer', '', true);
	}
}


?>