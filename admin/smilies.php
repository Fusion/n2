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
## ***************** wtcBB SMILIES ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-SMILIES');
define('FILE_ACTION', 'Smilies');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	if($_GET['do'] == 'add') {
		$which = 'add';
		$editinfo = Array(
						'groupid' => (isset($_GET['groupid']) ? $_GET['groupid'] : 1), 'filePath' => './images/smilies/', 'disOrder' => 1
					);
	}

	else {
		$which = 'edit';
		$smileyObj = new Smiley($_GET['edit']);
		$editinfo = $smileyObj->getInfo();
	}

	// update smiley table
	if($_POST['formSet']) {
		// must fill out smiley name and replacement
		if(empty($_POST['smiley']['title']) OR empty($_POST['smiley']['replacement'])) {
			new WtcBBException($lang['admin_error_notEnoughInfo']);
		}

		// are we uploading?
		if(!empty($_FILES['fupload']['name'])) {
			$upload = new Upload(null, null, $_FILES['fupload'], './images/smilies/');
			$do = $upload->doUpload();

			// not an image?
			if(!$upload->isImage()) {
				$upload->destroy();
				new WtcBBException($lang['admin_error_mustUploadImage']);
			}

			// set img path...
			$_POST['smiley']['imgPath'] = $upload->getDestination();
		}

		else {
			// bad filename?
			if(!file_exists($_POST['smiley']['imgPath']) OR !is_file($_POST['smiley']['imgPath'])) {
				new WtcBBException($lang['admin_error_fileDoesNotExist']);
			}
		}

		// set dis order to 1 if not set
		if(empty($_POST['smiley']['disOrder']) OR $_POST['smiley']['disOrder'] < 1) {
			$_POST['smiley']['disOrder'] = 1;
		}

		// add?
		if($which == 'add') {
			// just insert...
			Smiley::insert($_POST['smiley']);
		}

		// update
		else {
			$smileyObj->update($_POST['smiley']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=smilies');
	}

	new AdminHTML('header', $lang['admin_smilies_' . $which], true);

	new AdminHTML('tableBegin', $lang['admin_smilies_' . $which], true, Array('upload' => true));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_smilies_ae_title'],
								'desc' => $lang['admin_smilies_ae_title_desc'],
								'type' => 'text',
								'name' => 'smiley[title]',
								'value' => $editinfo['title']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_smilies_ae_filePath'],
								'desc' => $lang['admin_smilies_ae_filePath_desc'],
								'type' => 'text',
								'name' => 'smiley[imgPath]',
								'value' => $editinfo['imgPath']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_smilies_ae_imgUp'],
								'desc' => $lang['admin_smilies_ae_imgUp_desc'],
								'type' => 'file',
								'name' => 'fupload'
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_smilies_ae_replace'],
								'desc' => $lang['admin_smilies_ae_replace_desc'],
								'type' => 'text',
								'name' => 'smiley[replacement]',
								'value' => $editinfo['replacement']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_smilies_ae_disOrder'],
								'desc' => $lang['admin_smilies_ae_disOrder_desc'],
								'type' => 'text',
								'name' => 'smiley[disOrder]',
								'value' => $editinfo['disOrder']
							), true);

	// get all groups...
	$smileyGroupsQ = new Query($query['smilies']['get_all_groups']);
	$groupSelect = Array();

	while($smileyGroup = $wtcDB->fetchArray($smileyGroupsQ)) {
		$groupSelect[$smileyGroup['groupName']] = $smileyGroup['groupid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_smilies_ae_group'],
								'desc' => $lang['admin_smilies_ae_group_desc'],
								'type' => 'select',
								'name' => 'smiley[groupid]',
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
			$groupObj->destroy();

			new Cache('Smilies');

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=smilies');
		}

		else {
			new Redirect('admin.php?file=smilies');
		}
	}

	new Delete('', '', '', '', true, false, 'admin_smilies_delete');
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
		// no name?
		if(empty($_POST['groups']['groupName'])) {
			new WtcBBException($lang['admin_error_notEnoughInfo']);
		}

		// add?
		if($which == 'add') {
			Group::insert($_POST['groups']);
		}

		else {
			$groupObj->update($_POST['groups']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=smilies');
	}

	new AdminHTML('header', $lang['admin_groups_ae_' . $which], true);

	new AdminHTML('tableBegin', $lang['admin_groups_ae_' . $which], true, Array(
																			'hiddenInputs' => Array(
																								'groups[groupType]' => 'smilies'
																							)
																		));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_groups_ae_name'],
								'desc' => $lang['admin_groups_ae_name_desc'],
								'type' => 'text',
								'name' => 'groups[groupName]',
								'value' => $editinfo['groupName']
							), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

// add multiple smilies
else if($_GET['do'] == 'addMultiple') {
	if(!isset($_GET['path'])) {
		new AdminHTML('header', $lang['admin_smilies_addMultiple'], true);

		new AdminHTML('tableBegin', $lang['admin_smilies_addMultiple'], true, Array(
																				'method' => 'get',
																				'hiddenInputs' => Array(
																									'file' => 'smilies',
																									'do' => 'addMultiple'
																								)
																				));

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_smilies_addMultiple_path'],
									'desc' => $lang['admin_smilies_addMultiple_path_desc'],
									'type' => 'text',
									'name' => 'path',
									'value' => './images/smilies'
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

		// add smilies...
		if(isset($_POST['smileyNames']) AND is_array($_POST['smileyNames'])) {
			foreach($_POST['smileyNames'] as $fileName => $v) {
				// if this is empty, or replacement, or if not ticked
				if(empty($v) OR empty($_POST['smileyReplace'][$fileName]) OR !$_POST['addSmiley'][$fileName]) {
					continue;
				}

				// form out array
				$insert = Array(
							'title' => $v,
							'replacement' => $_POST['smileyReplace'][$fileName],
							'disOrder' => ($_POST['smileyDisOrders'][$fileName] < 1) ? 1 : $_POST['smileyDisOrders'][$fileName],
							'groupid' => $_POST['groupid'],
							'imgPath' => $iterPath . '/' . $fileName
						);

				Smiley::insert($insert);
			}

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=smilies');
		}

		// get post icons in an array of file paths... check if already exists...
		$smileyPaths = Array();

		if(is_array($smilies)) {
			foreach($smilies as $meh) {
				if(is_array($meh)) {
					foreach($meh as $obj) {
						$smileyPaths[$obj->getImgPath()] = true;
					}
				}
			}
		}

		// make sure we have something... o_0
		$dir = new DirectoryIterator($iterPath);
		$success = false;

		foreach($dir as $iter) {
			// continue if not an image... or it's already in DB
			if(isset($smileyPaths[$iterPath . '/' . $iter->getFilename()]) OR $iter->isDot() OR !@getimagesize($iterPath . '/' . $iter->getFilename())) {
				continue;
			}

			$success = true;
		}

		if(!$success) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		new AdminHTML('header', $lang['admin_smilies_addMultiple'], true, Array(
																	'form' => true,
																	'extra2' => "\t" . '<p class="marBot">' . $lang['admin_smilies_addMultiple_details'] . '</p>' . "\n\n"
																	));

		// select group...
		new AdminHTML('tableBegin', $lang['admin_smilies_addMultiple_group'], true, Array('form' => false));

		// get all groups...
		$smileyGroupsQ = new Query($query['smilies']['get_all_groups']);
		$groupSelect = Array();

		while($smileyGroup = $wtcDB->fetchArray($smileyGroupsQ)) {
			$groupSelect[$smileyGroup['groupName']] = $smileyGroup['groupid'];
		}

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_smilies_ae_group'],
									'desc' => $lang['admin_smilies_addMultiple_group_desc'],
									'type' => 'select',
									'name' => 'groupid',
									'select' => Array('fields' => $groupSelect, 'select' => $editinfo['groupid'])
								), true);

		new AdminHTML('tableEnd', '', true, Array('form' => false));

		new AdminHTML('tableBegin', $lang['admin_smilies_addMultiple'], true, Array('colspan' => 5, 'form' => false));

		// initiate dir iterator
		$dir = new DirectoryIterator($iterPath);
		$disCount = 1;

		$thCells = Array(
						'<input type="checkbox" onclick="wtcBB.tickBoxes(this.form, this);" name="tickAll" checked="checked" />' => Array('th' => true),
						$lang['admin_smilies_addMultiple_img'] => Array('th' => true),
						$lang['admin_smilies_addMultiple_name'] => Array('th' => true),
						$lang['admin_smilies_addMultiple_disOrder'] => Array('th' => true),
						$lang['admin_smilies_addMultiple_replace'] => Array('th' => true)
					);

		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		foreach($dir as $iter) {
			// continue if not an image
			if(isset($smileyPaths[$iterPath . '/' . $iter->getFilename()]) OR $iter->isDot() OR !@getimagesize($iterPath . '/' . $iter->getFilename())) {
				continue;
			}

			// form cells
			$cells = Array(
						'<input type="checkbox" name="addSmiley[' . $iter->getFilename() . ']" value="1" checked="checked" />' => Array(),
						'<img src="' . $iterPath . '/' . $iter->getFilename() . '" alt="' . $iter->getFilename() . '" />' => Array(),
						'<input type="text" class="text" name="smileyNames[' . $iter->getFilename() . ']" value="' . ucfirst(substr($iter->getFilename(), 0, strpos($iter->getFilename(), '.'))) . '" />' => Array('class' => 'small'),
						'<input type="text" class="text less" name="smileyDisOrders[' . $iter->getFilename() . ']" value="' . $disCount++ . '" />' => Array('class' => 'small'),
						'<input type="text" class="text" name="smileyReplace[' . $iter->getFilename() . ']" value="" />' => Array('class' => 'small')
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('colspan' => 5, 'form' => -1));

		new AdminHTML('footer', '', true, Array('form' => true));
	}
}

// delete smiley
else if(isset($_GET['delete'])) {
	$smileyObj = new Smiley($_GET['delete']);
	$smileyObj->destroy();
}

else {
	// we have a group?
	if(isset($_GET['groupid'])) {
		$gid = $_GET['groupid'];

		// check if we have any...
		if(!isset($smilies[$gid]) OR !count($smilies[$gid])) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		// update quick-fields?
		if(isset($_POST['disOrders']) OR isset($_POST['replacements'])) {
			if(is_array($_POST['disOrders'])) {
				foreach($_POST['disOrders'] as $id => $val) {
					if($val != $smilies[$gid][$id]->getDisOrder()) {
						$smilies[$gid][$id]->update(Array('disOrder' => $val));
					}
				}
			}

			if(is_array($_POST['replacements'])) {
				foreach($_POST['replacements'] as $id => $val) {
					if($val != $smilies[$gid][$id]->getReplacement()) {
						$smilies[$gid][$id]->update(Array('replacement' => $val));
					}
				}
			}

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=smilies');
		}

		new AdminHTML('header', $lang['admin_smilies_man'], true, Array('form' => true));

		new AdminHTML('tableBegin', $generalGroups['smilies'][$gid]->getGroupName(), true, Array('form' => false, 'colspan' => 4));

		$thCells = Array(
					$lang['admin_smilies_man_img'] => Array('th' => true),
					$lang['admin_smilies_man_disOrder'] => Array('th' => true),
					$lang['admin_smilies_man_replacement'] => Array('th' => true),
					$lang['admin_options'] => Array('th' => true)
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		// loop and display
		foreach($smilies[$gid] as $id => $smiley) {
			$cells = Array(
						'<img src="' . $smiley->getImgPath() . '" alt="' . $smiley->getReplacement() . '" />' => Array(),
						'<input type="text" class="text less" name="disOrders[' . $id . ']" value="' . $smiley->getDisOrder() . '" />' => Array(),
						'<input type="text" class="text" name="replacements[' . $id . ']" value="' . $smiley->getReplacement() . '" />' => Array(),
						'<a href="admin.php?file=smilies&amp;edit=' . $smiley->getSmileyId() . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=smilies&amp;delete=' . $smiley->getSmileyId() . '">' . $lang['admin_delete'] . '</a>' => Array()
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => '<a href="admin.php?file=smilies&amp;do=add&amp;groupid=' . $gid . '">' . $lang['admin_smilies_add'] . '</a>&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="' . $lang['admin_save'] . '" />', 'colspan' => 4));

		new AdminHTML('footer', '', true, Array('form' => true));
	}

	else {
		new AdminHTML('header', $lang['admin_smilies_man'], true);

		new AdminHTML('tableBegin', $lang['admin_smilies_man'], true, Array('form' => false, 'colspan' => 2));

		$thCells = Array(
					$lang['admin_smilies_man_groupName'] => Array('th' => true),
					$lang['admin_options'] => Array('th' => true)
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		// create group iterator
		$groupIter = new GroupIterator('smilies');

		// loop through general smiley groups...
		foreach($groupIter as $obj) {
			// form our usergroups list...
			$before = '';

			$cells = Array(
						'<a href="admin.php?file=smilies&amp;groupid=' . $obj->getGroupId() . '">' . $obj->getGroupName() . '</a>' => Array(),
						'<a href="admin.php?file=smilies&amp;do=add&amp;groupid=' . $obj->getGroupId() . '">' . $lang['admin_smilies_add'] . '</a> - <a href="admin.php?file=smilies&amp;editGroup=' . $obj->getGroupId() . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=smilies&amp;delGroup=' . $obj->getGroupId() . '">' . $lang['admin_delete'] . '</a>' => Array('class' => 'small')
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('form' => -1, 'colspan' => 2, 'footerText' => '<a href="admin.php?file=smilies&amp;do=addGroup">' . $lang['admin_groups_ae_add'] . '</a>'));

		new AdminHTML('footer', '', true);
	}
}


?>