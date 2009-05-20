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
// ************************************************** \\#
# ************************************************** ##
## ************************************************** ##
## *************** wtcBB ATTACHMENTS **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-ATTACHMENTS');
define('FILE_ACTION', 'Attachments');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();


if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	if($_GET['do'] == 'add') {
		$which = 'add';
		$editinfo = Array(
						'maxSize' => 100000, 'maxWidth' => 0, 'maxHeight' => 0, 'enabled' => 1
					);
	}
	
	else {
		$which = 'edit';
		$attachExtObj = new AttachmentExtension($_GET['edit']);
		$editinfo = $attachExtObj->info;
	}
	
	if($_POST['formSet']) {
		// no ext OR mime? tsk tsk...
		if(empty($_POST['ext']['ext']) OR empty($_POST['ext']['mime'])) {
			new WtcBBException($lang['admin_error_notEnoughInfo']);
		}
		
		// insert?
		if($which == 'add') {
			// make sure we don't have the ext...
			$check = new Query($query['ext']['check_unique'], Array(1 => $_POST['ext']['ext']));
			$checking = $wtcDB->fetchArray($check);
			
			if($checking['total']) {
				new WtcBBException($lang['admin_error_doubleExt']);
			}
			
			AttachmentExtension::insert($_POST['ext']);
		}
		
		// update...
		else {
			// make sure we don't have the ext...
			$check = new Query($query['ext']['check_unique_edit'], Array(1 => $_POST['ext']['ext'], $attachExtObj->info['storeid']));
			$checking = $wtcDB->fetchArray($check);
			
			if($checking['total']) {
				new WtcBBException($lang['admin_error_doubleExt']);
			}
			
			$attachExtObj->update($_POST['ext']);
		}
		
		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=attachments');
	}
	
	new AdminHTML('header', $lang['admin_attach_' . $which], true);
	
	new AdminHTML('tableBegin', $lang['admin_attach_' . $which], true);
	
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_attach_ae_ext'],
								'desc' => $lang['admin_attach_ae_ext_desc'],
								'type' => 'text',
								'name' => 'ext[ext]',
								'value' => $editinfo['ext']
							), true);
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_attach_ae_size'],
								'desc' => $lang['admin_attach_ae_size_desc'],
								'type' => 'text',
								'name' => 'ext[maxSize]',
								'value' => $editinfo['maxSize']
							), true);
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_attach_ae_width'],
								'desc' => $lang['admin_attach_ae_width_desc'],
								'type' => 'text',
								'name' => 'ext[maxWidth]',
								'value' => $editinfo['maxWidth']
							), true);
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_attach_ae_height'],
								'desc' => $lang['admin_attach_ae_height_desc'],
								'type' => 'text',
								'name' => 'ext[maxHeight]',
								'value' => $editinfo['maxHeight']
							), true);
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_attach_ae_enabled'],
								'desc' => $lang['admin_attach_ae_enabled_desc'],
								'type' => 'checkbox',
								'name' => 'ext[enabled]',
								'value' => $editinfo['enabled']
							), true);
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_attach_ae_mime'],
								'desc' => $lang['admin_attach_ae_mime_desc'],
								'type' => 'textarea',
								'name' => 'ext[mime]',
								'value' => $editinfo['mime']
							), true);
	
	new AdminHTML('tableEnd', '', true);
	
	new AdminHTML('footer', '', true);
}

// delete extension
else if(isset($_GET['delete'])) {
	$attachExtObj = new AttachmentExtension($_GET['delete']);
	$attachExtObj->destroy();
}

// change storage type...
else if($_GET['do'] == 'storageType') {
	if($_POST['formSet']) {
		// hmm... same?
		if($bboptions['attachStorageType'] == $_POST['storageType']) {
			new WtcBBException($lang['admin_error_currMedium']);
		}
		
		// move to file system...
		if($_POST['storageType'] == 1) {
		}
		
		// move to database
		else {
		}
		
		// now update bb options...
		new Query($query['admin']['options_update_withName'], Array(1 => $_POST['storageType'], 'attachStorageType'));
		
		// rebuild cache
		new Cache('BBOptions');
		
		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=attachments&amp;do=storageType');
	}
	
	new AdminHTML('header', $lang['admin_attach_store'], true, Array(
																'extra2' => "\t" . '<p class="marBot important">' . (($bboptions['attachStorageType'] == 1) ? $lang['admin_attach_store_fileSystem'] : $lang['admin_attach_store_database']) . '</p>' . "\n\n"
																));
	
	new AdminHTML('tableBegin', $lang['admin_attach_store'], true);
	
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_attach_store_type'],
								'desc' => $lang['admin_attach_store_type_desc'],
								'type' => 'checkbox',
								'name' => 'storageType',
								'value' => $bboptions['attachStorageType']
							), true);
	
	new AdminHTML('tableEnd', '', true);
	
	new AdminHTML('footer', '', true);
}

// extensions manager
else {
	// check if we have any ranks...
	$getExts = new Query($query['ext']['get_all']);
	
	// check if we have any...
	if(!$wtcDB->numRows($getExts)) {
		new WtcBBException($lang['admin_error_noResults']);
	}
	
	// sort...
	// extension must be unique anyway
	$sortedExts = Array();
	
	while($ext = $wtcDB->fetchArray($getExts)) {
		$sortedExts[$ext['ext']] = $ext;
	}
	
	ksort($sortedExts);
	
	new AdminHTML('header', $lang['admin_ext_man'], true);
	
	new AdminHTML('tableBegin', $lang['admin_ext_man'], true, Array('form' => false, 'colspan' => 6));
	
	$thCells = Array(
				$lang['admin_ext_man_ext'] => Array('th' => true, 'class' => 'small'),
				$lang['admin_ext_man_size'] => Array('th' => true, 'class' => 'small'),
				$lang['admin_ext_man_height'] => Array('th' => true, 'class' => 'small'),
				$lang['admin_ext_man_width'] => Array('th' => true, 'class' => 'small'),
				$lang['admin_ext_man_enabled'] => Array('th' => true, 'class' => 'small'),
				$lang['admin_options'] => Array('th' => true, 'class' => 'small')
			);
			
	new AdminHTML('tableCells', '', true, Array('cells' => $thCells));
	
	// loop and display
	foreach($sortedExts as $ext) {
		$cells = Array(
					'<a href="admin.php?file=attachments&amp;edit=' . $ext['storeid'] . '">' . $ext['ext'] . '</a>' => Array(),
					(($ext['maxSize'] <= 0) ? $lang['global_noLimit'] : $ext['maxSize']) => Array(),
					(($ext['maxHeight'] <= 0) ? $lang['global_noLimit'] : $ext['maxHeight']) . '&nbsp;' => Array(),
					(($ext['maxWidth'] <= 0) ? $lang['global_noLimit'] : $ext['maxWidth']) . '&nbsp;&nbsp;' => Array(),
					(($ext['enabled'] == 1) ? $lang['admin_yes'] : $lang['admin_no']) => Array(),
					'<a href="admin.php?file=attachments&amp;edit=' . $ext['storeid'] . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=attachments&amp;delete=' . $ext['storeid'] . '">' . $lang['admin_delete'] . '</a>' => Array('class' => 'small')
				);
				
		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}		
	
	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => '<a href="admin.php?file=attachments&amp;do=add">' . $lang['admin_attach_add'] . '</a>', 'colspan' => 6));
	
	new AdminHTML('footer', $lang['admin_ext_man'], true);
}

?>