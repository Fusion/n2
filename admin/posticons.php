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
## **************** wtcBB POST ICONS **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-POSTICONS');
define('FILE_ACTION', 'Post Icons');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();


if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	if($_GET['do'] == 'add') {
		$which = 'add';
		$editinfo = Array(
						'filePath' => './images/icons/', 'disOrder' => 1
					);
	}

	else {
		$which = 'edit';
		$iconObj = new PostIcon($_GET['edit']);
		$editinfo = $iconObj->getInfo();
	}

	// update posticons table
	if($_POST['formSet']) {
		// must fill out icon name
		if(empty($_POST['icon']['title'])) {
			new WtcBBException($lang['admin_error_notEnoughInfo']);
		}

		// are we uploading?
		if(!empty($_FILES['fupload']['name'])) {
			$upload = new Upload(null, null, $_FILES['fupload'], './images/icons/');
			$upload->doUpload();

			// not an image?
			if(!$upload->isImage()) {
				$upload->destroy();
				new WtcBBException($lang['admin_error_mustUploadImage']);
			}

			// set img path...
			$_POST['icon']['imgPath'] = $upload->getDestination();
		}

		else {
			// bad filename?
			if(!file_exists($_POST['icon']['imgPath']) OR !is_file($_POST['icon']['imgPath'])) {
				new WtcBBException($lang['admin_error_fileDoesNotExist']);
			}
		}

		// set dis order to 1 if not set
		if(empty($_POST['icon']['disOrder']) OR $_POST['icon']['disOrder'] < 1) {
			$_POST['icon']['disOrder'] = 1;
		}

		// add?
		if($which == 'add') {
			// just insert...
			PostIcon::insert($_POST['icon']);
		}

		// update
		else {
			$iconObj->update($_POST['icon']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=posticons');
	}

	new AdminHTML('header', $lang['admin_icons_' . $which], true);

	new AdminHTML('tableBegin', $lang['admin_icons_' . $which], true, Array('upload' => true));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_icons_ae_title'],
								'desc' => $lang['admin_icons_ae_title_desc'],
								'type' => 'text',
								'name' => 'icon[title]',
								'value' => $editinfo['title']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_icons_ae_filePath'],
								'desc' => $lang['admin_icons_ae_filePath_desc'],
								'type' => 'text',
								'name' => 'icon[imgPath]',
								'value' => $editinfo['imgPath']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_icons_ae_imgUp'],
								'desc' => $lang['admin_icons_ae_imgUp_desc'],
								'type' => 'file',
								'name' => 'fupload'
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_icons_ae_disOrder'],
								'desc' => $lang['admin_icons_ae_disOrder_desc'],
								'type' => 'text',
								'name' => 'icon[disOrder]',
								'value' => $editinfo['disOrder']
							), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

// add multiple icons
else if($_GET['do'] == 'addMultiple') {
	if(!isset($_GET['path'])) {
		new AdminHTML('header', $lang['admin_icons_addMultiple'], true);

		new AdminHTML('tableBegin', $lang['admin_icons_addMultiple'], true, Array(
																				'method' => 'get',
																				'hiddenInputs' => Array(
																									'file' => 'posticons',
																									'do' => 'addMultiple'
																								)
																				));

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_icons_addMultiple_path'],
									'desc' => $lang['admin_icons_addMultiple_path_desc'],
									'type' => 'text',
									'name' => 'path',
									'value' => './images/icons'
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

		// add icons...
		if(isset($_POST['iconNames']) AND is_array($_POST['iconNames'])) {
			foreach($_POST['iconNames'] as $fileName => $v) {
				// if this is empty, or if it isn't ticked
				if(empty($v) OR !$_POST['addIcon'][$fileName]) {
					continue;
				}

				// form out array
				$insert = Array(
							'title' => $v,
							'disOrder' => ($_POST['iconDisOrders'][$fileName] < 1) ? 1 : $_POST['iconDisOrders'][$fileName],
							'imgPath' => $iterPath . '/' . $fileName
						);

				PostIcon::insert($insert);
			}

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=posticons');
		}

		// get post icons in an array of file paths... check if already exists...
		$iconPaths = Array();

		if(count($posticons)) {
			foreach($posticons as $obj) {
				$iconPaths[$obj->getImgPath()] = true;
			}
		}

		// make sure we have something... o_0
		$dir = new DirectoryIterator($iterPath);
		$success = false;

		foreach($dir as $iter) {
			// continue if not an image... or it's already in DB
			if(isset($iconPaths[$iterPath . '/' . $iter->getFilename()]) OR $iter->isDot() OR !@getimagesize($iterPath . '/' . $iter->getFilename())) {
				continue;
			}

			$success = true;
		}

		if(!$success) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		new AdminHTML('header', $lang['admin_icons_addMultiple'], true, Array(
																	'form' => true,
																	'extra2' => "\t" . '<p class="marBot">' . $lang['admin_icons_addMultiple_details'] . '</p>' . "\n\n"
																	));

		new AdminHTML('tableBegin', $lang['admin_icons_addMultiple'], true, Array('colspan' => 4, 'form' => false));

		// initiate dir iterator
		$dir = new DirectoryIterator($iterPath);
		$disCount = 1;

		$thCells = Array(
						'<input type="checkbox" onclick="wtcBB.tickBoxes(this.form, this);" name="tickAll" checked="checked" />' => Array('th' => true),
						$lang['admin_icons_addMultiple_img'] => Array('th' => true),
						$lang['admin_icons_addMultiple_name'] => Array('th' => true),
						$lang['admin_icons_addMultiple_disOrder'] => Array('th' => true),
					);

		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		foreach($dir as $iter) {
			// continue if not an image... or it's already in DB
			if(isset($iconPaths[$iterPath . '/' . $iter->getFilename()]) OR $iter->isDot() OR !@getimagesize($iterPath . '/' . $iter->getFilename())) {
				continue;
			}

			// form cells
			$cells = Array(
						'<input type="checkbox" name="addIcon[' . $iter->getFilename() . ']" value="1" checked="checked" />' => Array(),
						'<img src="' . $iterPath . '/' . $iter->getFilename() . '" alt="' . $iter->getFilename() . '" />' => Array(),
						'<input type="text" class="text" name="iconNames[' . $iter->getFilename() . ']" value="' . ucfirst(substr($iter->getFilename(), 0, strpos($iter->getFilename(), '.'))) . '" />' => Array('class' => 'small'),
						'<input type="text" class="text less" name="iconDisOrders[' . $iter->getFilename() . ']" value="' . $disCount++ . '" />' => Array('class' => 'small')
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		new AdminHTML('tableEnd', '', true, Array('colspan' => 4, 'form' => -1));

		new AdminHTML('footer', '', true, Array('form' => true));
	}
}

// delete post icon
else if(isset($_GET['delete'])) {
	$iconObj = new PostIcon($_GET['delete']);
	$iconObj->destroy();
}

else {
	// nothin...
	if(!is_array($posticons) OR !count($posticons)) {
		new WtcBBException($lang['admin_error_noResults']);
	}

	// update quick-fields?
	if(isset($_POST['disOrders'])) {
		if(is_array($_POST['disOrders'])) {
			foreach($_POST['disOrders'] as $id => $val) {
				if($val != $posticons[$id]->getDisOrder()) {
					$posticons[$id]->update(Array('disOrder' => $val));
				}
			}
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=posticons');
	}

	new AdminHTML('header', $lang['admin_icons_man'], true, Array('form' => true));

	new AdminHTML('tableBegin', $lang['admin_icons_man'], true, Array('form' => false, 'colspan' => 3));

	$thCells = Array(
				$lang['admin_icons_man_img'] => Array('th' => true),
				$lang['admin_icons_man_disOrder'] => Array('th' => true),
				$lang['admin_options'] => Array('th' => true)
			);

	new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

	// loop and display
	foreach($posticons as $id => $icon) {
		$cells = Array(
					'<img src="' . $icon->getImgPath() . '" alt="' . $icon->getTitle() . '" />' => Array(),
					'<input type="text" class="text less" name="disOrders[' . $id . ']" value="' . $icon->getDisOrder() . '" />' => Array(),
					'<a href="admin.php?file=posticons&amp;edit=' . $icon->getIconId() . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=posticons&amp;delete=' . $icon->getIconId() . '">' . $lang['admin_delete'] . '</a>' => Array()
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => '<a href="admin.php?file=posticons&amp;do=add">' . $lang['admin_icons_add'] . '</a>&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="' . $lang['admin_save'] . '" />', 'colspan' => 3));

	new AdminHTML('footer', '', true, Array('form' => true));
}


?>