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
## **************** wtcBB BB Code ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-BBCODE');
define('FILE_ACTION', 'BB Code');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	if($_GET['do'] == 'add') {
		$which = 'add';
		$editinfo = Array(
						'name' => '',
						'tag' => '',
						'replacement' => '',
						'example' => '',
						'description' => '',
						'opt' => 0,
						'display' => 0
					);
	}
	
	else {
		$which = 'edit';
		$bbObj = new BBCode($_GET['edit']);
		$editinfo = $bbObj->getInfo();
	}
	
	if(isset($_POST['formSet'])) {
		if($which == 'add') {
			// insert
			BBCode::insert($_POST['bbcode']);
		}
		
		else {
			// insert
			$bbObj->update($_POST['bbcode']);
		}
		
		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=bbcode');			
	}
	
	new AdminHTML('header', $lang['admin_bbcode_' . $which], true);	
	new AdminHTML('tableBegin', $lang['admin_bbcode_' . $which], true, Array('form' => true));
	
	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_bbcode_ae_name'],
									'desc' => $lang['admin_bbcode_ae_name_desc'],
									'type' => 'text',
									'name' => 'bbcode[name]',
									'value' => $editinfo['name']
								), true);
								
	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_bbcode_ae_tag'],
									'desc' => $lang['admin_bbcode_ae_tag_desc'],
									'type' => 'text',
									'name' => 'bbcode[tag]',
									'value' => $editinfo['tag']
								), true);
								
	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_bbcode_ae_replace'],
									'desc' => $lang['admin_bbcode_ae_replace_desc'],
									'type' => 'textarea',
									'name' => 'bbcode[replacement]',
									'value' => $editinfo['replacement']
								), true);
								
	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_bbcode_ae_example'],
									'desc' => $lang['admin_bbcode_ae_example_desc'],
									'type' => 'text',
									'name' => 'bbcode[example]',
									'value' => $editinfo['example']
								), true);
								
	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_bbcode_ae_desc'],
									'desc' => $lang['admin_bbcode_ae_desc_desc'],
									'type' => 'textarea',
									'name' => 'bbcode[description]',
									'value' => $editinfo['description']
								), true);
								
	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_bbcode_ae_display'],
									'desc' => $lang['admin_bbcode_ae_display_desc'],
									'type' => 'checkbox',
									'name' => 'bbcode[display]',
									'value' => $editinfo['display']
								), true);
	
	new AdminHTML('tableEnd', '', true, Array('form' => true));
	new AdminHTML('footer', '', true);
}

// delete bb code
else if(isset($_GET['delete'])) {
	$bbObj = new BBCode($_GET['delete']);
	$bbObj->destroy();
}

// parse bb code
else if($_GET['do'] == 'parse') {
	new AdminHTML('header', $lang['admin_bbcode_parse'], true, Array(
																	'extra2' => "\t" . '<p class="marBot">' . $lang['admin_bbcode_parse_details'] . '</p>' . "\n\n"
																	));
																	
	if(!empty($_POST['txt'])) {
		$parsedText = BBCode::parseAll(nl2br(wtcspecialchars($_POST['txt'])));
		
		new AdminHTML('divitBox', Array(
									'title' => $lang['admin_bbcode_parse_message'],
									'content' => $parsedText
								), true);
	}
																	
	new AdminHTML('tableBegin', $lang['admin_bbcode_parse'], true, Array('form' => 1));
		
	new AdminHTML('bigTextarea', Array(
									'title' => '',
									'name' => 'txt',
									'value' => (empty($_POST['txt']) ? 'Parse some [b]BB Code[/b]!' : $_POST['txt'])
								), true);
								
	new AdminHTML('tableEnd', '', true);
	
	new AdminHTML('footer', '', true);
}

// bb code manager
else {
	// put all crons into array
	$bbCodes = Array();
	$getAll = new Query($query['bbcode']['get_all_realOrder']);
	
	new AdminHTML('header', $lang['admin_bbcode_man'], true);
	
	if(!$wtcDB->numRows($getAll)) {
		new AdminHTML('divit', Array(
									'content' => '<a href="admin.php?file=bbcode&amp;do=add">' . $lang['admin_bbcode_add'] . '</a>',
									'class' => 'center'
								), true);
	}
	
	else {	
		while($bbcode = $wtcDB->fetchArray($getAll)) {
			$bbCodes[$bbcode['bbcodeid']] = $bbcode;
		}
		
		// do default usergroups
		new AdminHTML('tableBegin', $lang['admin_bbcode_man'], true, Array('form' => 0, 'colspan' => 4));
		
		$cells = Array(
					$lang['admin_bbcode_man_name'] => Array('th' => true, 'class' => 'small'),
					$lang['admin_bbcode_man_tag'] => Array('th' => true, 'class' => 'small'),
					$lang['admin_bbcode_man_ex'] => Array('th' => true, 'class' => 'small'),
					$lang['admin_options'] => Array('th' => true, 'class' => 'small')
				);
				
		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		
		foreach($bbCodes as $id => $info) {
			$bb = new BBCode('', $info);
				
			$cells = Array(
					'<a href="admin.php?file=bbcode&amp;edit=' . $info['bbcodeid'] . '">' . $info['name'] . '</a>' => Array(),
					$info['tag'] => Array(),
					$bb->parse(nl2br(wtcspecialchars($info['example']))) => Array(),
					'<a href="admin.php?file=bbcode&amp;edit=' . $info['bbcodeid'] . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=bbcode&amp;delete=' . $info['bbcodeid'] . '">' . $lang['admin_delete'] . '</a>' => Array()
				);
				
			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}
		
		new AdminHTML('tableEnd', '', true, Array('form' => 0, 'colspan' => 4, 'footerText' => '<a href="admin.php?file=bbcode&amp;do=add">' . $lang['admin_bbcode_add'] . '</a>'));
	}
	
	new AdminHTML('footer', '', true);
}
	

?>