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
## ********** wtcBB CUSTOM PROFILE FIELDS *********** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-CUS_PRO');
define('FILE_ACTION', 'Custom Profile Fields');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	if($_GET['do'] == 'add') {
		$which = 'add';
		$editinfo = Array(
						'fieldName' => '', 'fieldDesc' => '', 'fieldType' => 'text', 'defValue' => '',
						'optionText' => '', 'groupid' => $_GET['groupid']
					);
	}

	else {
		$which = 'edit';
		$cusProObj = new CustomPro($_GET['edit']);
		$editinfo = $cusProObj->getInfo();
	}

	// update rank table
	if($_POST['formSet']) {
		// trim it first...
		$_POST['cusPro'] = array_map('trim', $_POST['cusPro']);

		// we need a name, and option text if isn't a text field...
		if(empty($_POST['cusPro']['fieldName'])) {
			new WtcBBException($lang['admin_error_noName']);
		}

		if($_POST['cusPro']['fieldType'] != 'text' AND $_POST['cusPro']['fieldType'] != 'textarea' AND empty($_POST['cusPro']['optionText'])) {
			new WtcBBException($lang['admin_error_optionText']);
		}

		// add?
		if($which == 'add') {
			// just insert...
			CustomPro::insert($_POST['cusPro']);
		}

		// update
		else {
			$cusProObj->update($_POST['cusPro']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=cusPro&amp;groupid=' . $_POST['cusPro']['groupid']);
	}

	// set the field types...
	$fieldTypes = Array(
		$lang['admin_cusPro_f_text'] => 'text',
		$lang['admin_cusPro_f_textarea'] => 'textarea',
		$lang['admin_cusPro_f_select'] => 'select',
		$lang['admin_cusPro_f_multi-select'] => 'multi-select',
		$lang['admin_cusPro_f_radio'] => 'radio',
		$lang['admin_cusPro_f_checkbox'] => 'checkbox'
	);

	new AdminHTML('header', $lang['admin_cusPro_' . $which], true);

	new AdminHTML('tableBegin', $lang['admin_cusPro_' . $which], true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_cusPro_ae_fieldName'],
								'desc' => $lang['admin_cusPro_ae_fieldName_desc'],
								'type' => 'text',
								'name' => 'cusPro[fieldName]',
								'value' => $editinfo['fieldName']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_cusPro_ae_fieldDesc'],
								'desc' => $lang['admin_cusPro_ae_fieldDesc_desc'],
								'type' => 'textarea',
								'name' => 'cusPro[fieldDesc]',
								'value' => $editinfo['fieldDesc']
							), true);

	// get all groups...
	$proGroupsQ = new Query($query['custom_pro']['get_all_groups']);
	$groupSelect = Array();

	while($proGroup = $wtcDB->fetchArray($proGroupsQ)) {
		$groupSelect[$proGroup['groupName']] = $proGroup['groupid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_cusPro_ae_group'],
								'desc' => $lang['admin_cusPro_ae_group_desc'],
								'type' => 'select',
								'name' => 'cusPro[groupid]',
								'select' => Array('fields' => $groupSelect, 'select' => $editinfo['groupid'])
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_cusPro_ae_fieldType'],
								'desc' => $lang['admin_cusPro_ae_fieldType_desc'],
								'type' => 'select',
								'name' => 'cusPro[fieldType]',
								'select' => Array('fields' => $fieldTypes, 'select' => $editinfo['fieldType'])
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_cusPro_ae_defValue'],
								'desc' => $lang['admin_cusPro_ae_defValue_desc'],
								'type' => 'textarea',
								'name' => 'cusPro[defValue]',
								'value' => $editinfo['defValue']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_cusPro_ae_optionText'],
								'desc' => $lang['admin_cusPro_ae_optionText_desc'],
								'type' => 'textarea',
								'name' => 'cusPro[optionText]',
								'value' => $editinfo['optionText']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_cusPro_ae_disOrder'],
								'desc' => $lang['admin_cusPro_ae_disOrder_desc'],
								'type' => 'text',
								'name' => 'cusPro[disOrder]',
								'value' => $editinfo['disOrder']
							), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

// delete group
else if(isset($_GET['delGroup'])) {
	$groupObj = new Group($_GET['delGroup']);

	// uh oh... can't delete primary groups!
	if(!$groupObj->isDeletable()) {
		new WtcBBException($lang['admin_error_cannotDelGroup']);
	}

	if($_POST['formSet']) {
		if($_POST['delConfirm']) {
			$groupObj->destroy('custom_pro');

			new Cache('CustomPros');

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=cusPro');
		}

		else {
			new Redirect('admin.php?file=cusPro');
		}
	}

	new Delete('', '', '', '');
}

// add/edit group
else if($_GET['do'] == 'addGroup' OR isset($_GET['editGroup'])) {
	if($_GET['do'] == 'addGroup') {
		$which = 'add';
		$editinfo = Array('groupName' => '', 'groupOrder' => 0);
	}

	else {
		$which = 'edit';
		$groupObj = new Group($_GET['editGroup']);
		$editinfo = $groupObj->getInfo();
	}

	if(isset($_POST['formSet'])) {
		// add?
		if($which == 'add') {
			Group::insert($_POST['groups']);
		}

		else {
			$groupObj->update($_POST['groups']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=cusPro');
	}

	new AdminHTML('header', $lang['admin_groups_ae_' . $which], true);

	new AdminHTML('tableBegin', $lang['admin_groups_ae_' . $which], true, Array(
																			'hiddenInputs' => Array(
																								'groups[groupType]' => 'custom_pro'
																							)
																		));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_groups_ae_name'],
								'desc' => $lang['admin_groups_ae_name_desc'],
								'type' => 'text',
								'name' => 'groups[groupName]',
								'value' => $editinfo['groupName']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_groups_ae_groupOrder'],
								'desc' => $lang['admin_groups_ae_groupOrder_desc'],
								'type' => 'text',
								'name' => 'groups[groupOrder]',
								'value' => $editinfo['groupOrder']
							), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

// delete profile field
else if(isset($_GET['delete'])) {
	$proObj = new CustomPro($_GET['delete']);

	if($_POST['formSet']) {
		if($_POST['delConfirm']) {
			$proObj->destroy();

			new Cache('CustomPros');

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=cusPro&amp;groupid=' . $proObj->getGroupId());
		}

		else {
			new Redirect('admin.php?file=cusPro&amp;groupid=' . $proObj->getGroupId());
		}
	}

	new Delete('', '', '', '');
}

// profile field manager
else {
	// we have a group?
	if(isset($_GET['groupid'])) {
		$gid = $_GET['groupid'];

		// check if we have any...
		if(!isset($profs[$gid]) OR !count($profs[$gid])) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		// update quick-fields?
		if(isset($_POST['disOrders'])) {
			if(is_array($_POST['disOrders'])) {
				foreach($_POST['disOrders'] as $id => $val) {
					if($val != $profs[$gid][$id]->getDisOrder()) {
						$profs[$gid][$id]->update(Array('disOrder' => $val));
					}
				}
			}

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=cusPro&amp;groupid=' . $gid);
		}

		new AdminHTML('header', $lang['admin_cusPro_man'], true, Array('form' => true));

		new AdminHTML('tableBegin', $generalGroups['custom_pro'][$gid]->getGroupName(), true, Array('form' => false, 'colspan' => 4));

		$thCells = Array(
					$lang['admin_cusPro_man_fieldName'] => Array('th' => true),
					$lang['admin_cusPro_man_disOrder'] => Array('th' => true),
					$lang['admin_cusPro_man_fieldType'] => Array('th' => true),
					$lang['admin_options'] => Array('th' => true)
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		// loop and display
		foreach($profs[$gid] as $id => $prof) {
			$cells = Array(
						'<a href="admin.php?file=cusPro&amp;edit=' . $prof->getProId() . '">' . $prof->getName() . '</a>' => Array(),
						'<input type="text" class="text less" name="disOrders[' . $id . ']" value="' . $prof->getDisOrder() . '" />' => Array(),
						'<strong>' . $lang['admin_cusPro_f_' . $prof->getType()] . '</strong>' => Array(),
						'<a href="admin.php?file=cusPro&amp;edit=' . $prof->getProId() . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=cusPro&amp;delete=' . $prof->getProId() . '">' . $lang['admin_delete'] . '</a>' => Array()
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => '<a href="admin.php?file=cusPro&amp;do=add&amp;groupid=' . $gid . '">' . $lang['admin_cusPro_add'] . '</a>&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="' . $lang['admin_save'] . '" />', 'colspan' => 4));

		new AdminHTML('footer', '', true, Array('form' => true));
	}

	else {
		if(!is_array($generalGroups['custom_pro'])) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		// update quick-fields?
		if(isset($_POST['disOrders'])) {
			if(is_array($_POST['disOrders'])) {
				foreach($_POST['disOrders'] as $id => $val) {
					if($val != $generalGroups['custom_pro'][$id]->getDisOrder()) {
						$generalGroups['custom_pro'][$id]->update(Array('groupOrder' => $val));
					}
				}
			}

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=cusPro');
		}

		new AdminHTML('header', $lang['admin_cusPro_man'], true, Array('form' => true));

		new AdminHTML('tableBegin', $lang['admin_cusPro_man'], true, Array('form' => false, 'colspan' => 3));

		$thCells = Array(
					$lang['admin_cusPro_man_groupName'] => Array('th' => true),
					$lang['admin_cusPro_man_disOrder'] => Array('th' => true),
					$lang['admin_options'] => Array('th' => true)
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		// get group iterator
		$groupIter = new GroupIterator('custom_pro');

		// loop through general custom profile field groups...
		foreach($groupIter as $obj) {
			$cells = Array(
						'<a href="admin.php?file=cusPro&amp;groupid=' . $obj->getGroupId() . '">' . $obj->getGroupName() . '</a>' => Array(),
						'<input type="text" class="text less" name="disOrders[' . $obj->getGroupId() . ']" value="' . $obj->getDisOrder() . '" />' => Array(),
						'<a href="admin.php?file=cusPro&amp;do=add&amp;groupid=' . $obj->getGroupId() . '">' . $lang['admin_cusPro_add'] . '</a> - <a href="admin.php?file=cusPro&amp;editGroup=' . $obj->getGroupId() . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=cusPro&amp;delGroup=' . $obj->getGroupId() . '">' . $lang['admin_delete'] . '</a>' => Array('class' => 'small')
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('form' => -1, 'colspan' => 3, 'footerText' => '<a href="admin.php?file=cusPro&amp;do=addGroup">' . $lang['admin_groups_ae_add'] . '</a>&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="' . $lang['admin_save'] . '" />'));

		new AdminHTML('footer', '', true, Array('form' => true));
	}
}

?>