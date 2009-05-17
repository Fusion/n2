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
## ************ wtcBB USER RANK IMAGES ************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-RANKS_IMAGES');
define('FILE_ACTION', 'User Rank Images');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();


if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	if($_GET['do'] == 'add') {
		$which = 'add';
		$editinfo = Array(
						'minPosts' => 0, 'rankRepeat' => 1, 'imgPath' => './images/ranks/'
					);
	}

	else {
		$which = 'edit';
		$rankImgObj = new RankImage($_GET['edit']);
		$editinfo = $rankImgObj->info;
	}

	// update rank table
	if($_POST['formSet']) {
		// are we uploading?
		if(!empty($_FILES['fupload']['name'])) {
			$upload = new Upload(null, null, $_FILES['fupload'], './images/ranks/');
			$upload->doUpload();

			// not an image?
			if(!$upload->isImage()) {
				$upload->destroy();
				new WtcBBException($lang['admin_error_mustUploadImage']);
			}

			// set img path...
			$_POST['rankImage']['imgPath'] = $upload->getDestination();
		}

		else {
			// bad filename?
			if(!file_exists($_POST['rankImage']['imgPath']) OR !is_file($_POST['rankImage']['imgPath'])) {
				new WtcBBException($lang['admin_error_fileDoesNotExist']);
			}
		}

		// set min posts to 0 if not set
		if(empty($_POST['rankImage']['minPosts'])) {
			$_POST['rank']['minPosts'] = 0;
		}

		if(empty($_POST['rankImage']['rankRepeat']) OR $_POST['rankImage']['rankRepeat'] <= 0) {
			$_POST['rankImage']['rankRepeat'] = 1;
		}

		// add?
		if($which == 'add') {
			// just insert...
			RankImage::insert($_POST['rankImage']);
		}

		// update
		else {
			$rankImgObj->update($_POST['rankImage']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=rankImages');
	}

	new AdminHTML('header', $lang['admin_rankImages_' . $which], true);

	new AdminHTML('tableBegin', $lang['admin_rankImages_' . $which], true, Array('upload' => true));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_rankImages_ae_imgPath'],
								'desc' => $lang['admin_rankImages_ae_imgPath_desc'],
								'type' => 'text',
								'name' => 'rankImage[imgPath]',
								'value' => $editinfo['imgPath']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_rankImages_ae_imgUp'],
								'desc' => $lang['admin_rankImages_ae_imgUp_desc'],
								'type' => 'file',
								'name' => 'fupload'
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_rankImages_ae_repeat'],
								'desc' => $lang['admin_rankImages_ae_repeat_desc'],
								'type' => 'text',
								'name' => 'rankImage[rankRepeat]',
								'value' => $editinfo['rankRepeat']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_ranks_ae_minPosts'],
								'desc' => $lang['admin_ranks_ae_minPosts_desc'],
								'type' => 'text',
								'name' => 'rankImage[minPosts]',
								'value' => $editinfo['minPosts']
							), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

// delete rank
else if(isset($_GET['delete'])) {
	$rankObj = new RankImage($_GET['delete']);
	$rankObj->destroy();
}

else {
	// check if we have any ranks...
	$getRankImages = new Query($query['rankImage']['get_all']);

	// check if we have any...
	if(!$wtcDB->numRows($getRankImages)) {
		new WtcBBException($lang['admin_error_noResults']);
	}

	new AdminHTML('header', $lang['admin_rankImages_man'], true);

	new AdminHTML('tableBegin', $lang['admin_rankImages_man'], true, Array('form' => false, 'colspan' => 3));

	$thCells = Array(
				$lang['admin_rankImages_man_imgs'] => Array('th' => true),
				$lang['admin_rankImages_man_minPosts'] => Array('th' => true),
				$lang['admin_options'] => Array('th' => true)
			);

	new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

	// loop and display
	while($rankImage = $wtcDB->fetchArray($getRankImages)) {
		$cells = Array(
					str_repeat('<img src="' . $rankImage['imgPath'] . '" alt="Minimum Posts: ' . $rankImage['minPosts'] . '" />', $rankImage['rankRepeat']) => Array(),
					$rankImage['minPosts'] => Array(),
					'<a href="admin.php?file=rankImages&amp;edit=' . $rankImage['rankiid'] . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=rankImages&amp;delete=' . $rankImage['rankiid'] . '">' . $lang['admin_delete'] . '</a>' => Array()
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => '<a href="admin.php?file=rankImages&amp;do=add">' . $lang['admin_rankImages_add'] . '</a>', 'colspan' => 3));

	new AdminHTML('footer', '', true);
}

?>