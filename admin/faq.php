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
## ************ wtcBB FAQ ADMINISTRATION ************ ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-FAQ');
define('FILE_ACTION', 'FAQ');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();


/**
 * Initialize FAQ Stuff
 */
FaqEntry::init();


if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	if($_GET['do'] == 'add') {
		$which = 'add';
		$editinfo = Array(
						'varname' => 'faq_', 'disOrder' => '1', 'parent' => ((!isset($_GET['parent'])) ? -1 : $_GET['parent'])
					);
	}
	
	else {
		$which = 'edit';
		$faqObj = new FaqEntry($_GET['edit']);
		$editinfo = $faqObj->getInfo();
	}
	
	// get all languages... (for later)
	$getLangs = new Query($query['admin']['get_langs']);
	$langs = Array();
	
	while($langA = $wtcDB->fetchArray($getLangs)) {
		$langs[$langA['name']] = $langA;
	}
	
	ksort($langs);
	
	// if it's edit, need to get the wordinfo...
	if($which == 'edit') {
		$getWords = new Query($query['faq']['get_words'], Array(1 => FAQ_LANG_CAT));
		
		// no rows? bleh...
		if(!$wtcDB->numRows($getWords)) {
			new WtcBBException($lang['admin_error_noFaqWords']);
		}
		
		// loop through the words, and put into langid array
		$faqLangWords = Array();
		
		while($word = $wtcDB->fetchArray($getWords)) {
			$faqLangWords[$word['langid']][$word['name']] = $word;
		}
	}
	
	else {
		$faqLangWords = Array();
	}
	
	if($_POST['formSet']) {
		// no ext OR mime? tsk tsk...
		if(empty($_POST['faq']['varname'])) {
			new WtcBBException($lang['admin_error_notEnoughInfo']);
		}
		
		// var name already exists? (in any lang)...
		$checkVarNameQ = new Query($query['faq']['check_varname'], Array(1 => $_POST['faq']['varname'] . '__title', $_POST['faq']['varname'] . '__content', $_POST['faq']['varname'] . '__title', $_POST['faq']['varname'] . '__content'));
		$checkVarName = $wtcDB->fetchArray($checkVarNameQ);
		
		if($checkVarName['checking']) {
			new WtcBBException($lang['admin_error_duplicateVarName']);
		}
		
		// set display order to 1 if not specified...
		if($_POST['faq']['disOrder'] <= 0 OR !is_numeric($_POST['faq']['disOrder'])) {
			$_POST['faq']['disOrder'] = 1;
		}
		
		// insert?
		if($which == 'add') {
			$goody = true;
			
			// loop through languages and insert...
			foreach($langs as $langName => $info) {
				$stuff = $_POST[$info['langid']];
				
				// ouch...
				if(empty($stuff['title'])) {
					$goody = false;
					break;
				}
				
				// now insert the words...
				new Query($query['admin']['insert_words'], Array(
																1 => $_POST['faq']['varname'] . '__title',
																2 => $stuff['title'],
																3 => $info['langid'],
																4 => FAQ_LANG_CAT,
																5 => $stuff['title'] . ' - Title',
																6 => -1
															), true);
															
				// only insert if not empty...
				if(!empty($stuff['content'])) {				
					new Query($query['admin']['insert_words'], Array(
																	1 => $_POST['faq']['varname'] . '__content',
																	2 => $stuff['content'],
																	3 => $info['langid'],
																	4 => FAQ_LANG_CAT,
																	5 => $stuff['title'] . ' - Content',
																	6 => -1
																), true);
				}
			}
			
			if(!$goody) {
				new WtcBBException($lang['admin_error_allLangs']);
			}
			
			FaqEntry::insert($_POST['faq']);
		}
		
		// update...
		else {
			// make sure we aren't making this a parent of one of its childs
			if($editinfo['parent'] != $_POST['faq']['parent']) {
				// if same faq entry...
				if($_POST['faq']['parent'] == $editinfo['faqid']) {
					new WtcBBException($lang['admin_error_childOfChild']);
				}
				
				// initialize faq iter
				$faqIter = new RecursiveIteratorIterator(new RecursiveFaqIterator($editinfo['faqid']), true);
				
				// loop through childs
				foreach($faqIter as $faq) {
					// whaa??!!
					if($faq->getFaqId() == $_POST['faq']['parent']) {
						new WtcBBException($lang['admin_error_childOfChild']);
					}
				}		
			}
			
			$goody = true;
			
			// loop through languages and insert...
			foreach($langs as $langName => $info) {
				$stuff = $_POST[$info['langid']];
				
				// ouch...
				if(empty($stuff['title'])) {
					$goody = false;
					break;
				}
				
				// now update the words... 
				// doesn't exist? O_O we still might need to insert
				if(!isset($faqLangWords[$info['langid']][$editinfo['varname'] . '__title'])) {
					new Query($query['admin']['insert_words'], Array(
																1 => $_POST['faq']['varname'] . '__title',
																2 => $stuff['title'],
																3 => $info['langid'],
																4 => FAQ_LANG_CAT,
																5 => $stuff['title'] . ' - Title',
																6 => -1
															), true);
				}
				
				else {	
					new Query($query['admin']['update_words'], Array(
																	1 => $_POST['faq']['varname'] . '__title',
																	2 => $stuff['title'],
																	3 => $info['langid'],
																	4 => FAQ_LANG_CAT,
																	5 => $stuff['title'] . ' - Title',
																	6 => $faqLangWords[$info['langid']][$editinfo['varname'] . '__title']['wordsid']
																), true);
				}
															
				// only insert if not empty...
				if(!empty($stuff['content'])) {		
					// we also might need to insert here too...
					if(!isset($faqLangWords[$info['langid']][$editinfo['varname'] . '__content'])) {
						new Query($query['admin']['insert_words'], Array(
																		1 => $_POST['faq']['varname'] . '__content',
																		2 => $stuff['content'],
																		3 => $info['langid'],
																		4 => FAQ_LANG_CAT,
																		5 => $stuff['title'] . ' - Content',
																		6 => -1
																	), true);
					}		
					
					else {
						new Query($query['admin']['update_words'], Array(
																		1 => $_POST['faq']['varname'] . '__content',
																		2 => $stuff['content'],
																		3 => $info['langid'],
																		4 => FAQ_LANG_CAT,
																		5 => $stuff['title'] . ' - Content',
																		6 => $faqLangWords[$info['langid']][$editinfo['varname'] . '__content']['wordsid']
																	), true);
					}
				}
			}
			
			if(!$goody) {
				new WtcBBException($lang['admin_error_allLangs']);
			}
			
			$faqObj->update($_POST['faq']);
		}
		
		Language::cache();		
		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=faq');
	}
	
	new AdminHTML('header', $lang['admin_faq_' . $which], true, Array('form' => true));
	
	new AdminHTML('tableBegin', $lang['admin_faq_' . $which], true, Array('form' => false));
	
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_faq_ae_var'],
								'desc' => $lang['admin_faq_ae_var_desc'],
								'type' => 'text',
								'name' => 'faq[varname]',
								'value' => $editinfo['varname']
							), true);
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_faq_ae_order'],
								'desc' => $lang['admin_faq_ae_order_desc'],
								'type' => 'text',
								'name' => 'faq[disOrder]',
								'value' => $editinfo['disOrder']
							), true);
							
	// initialize iterator
	$faqIter = new RecursiveIteratorIterator(new RecursiveFaqIterator(), true);
	$faqList[$lang['admin_faq_noParent']] = -1;
	
	foreach($faqIter as $faq) {
		$faqList[str_repeat('-', $faqIter->getDepth()) . ' ' . $faq->getFaqTitle()] = $faq->getFaqId();
	}
							
	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_faq_ae_parent'],
								'desc' => $lang['admin_faq_ae_parent_desc'],
								'type' => 'select',
								'name' => 'faq[parent]',
								'select' => Array('fields' => $faqList, 'select' => $editinfo['parent'])
							), true);
	
	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	
	
	// ##### LANGUAGE TRANSLATIONS ##### \\
	new AdminHTML('divit', Array('content' => $lang['admin_faq_ae_translations'], 'class' => 'emphasis'), true);
	
	// now loop and show table for each...
	foreach($langs as $langName => $info) {
		new AdminHTML('tableBegin', $langName, true, Array('form' => false));
		
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_faq_ae_title'],
									'desc' => $lang['admin_faq_ae_title_desc'],
									'type' => 'text',
									'name' => $info['langid'] . '[title]',
									'value' => $faqLangWords[$info['langid']][$editinfo['varname'] . '__title']['words']
								), true);
								
		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_faq_ae_content'],
									'desc' => $lang['admin_faq_ae_content_desc'],
									'type' => 'textarea',
									'name' => $info['langid'] . '[content]',
									'value' => $faqLangWords[$info['langid']][$editinfo['varname'] . '__content']['words']
								), true);
		
		new AdminHTML('tableEnd', '', true, Array('form' => -1));
	}
	
	
	new AdminHTML('footer', '', true, Array('form' => true));
}

// delete extension
else if(isset($_GET['delete'])) {
	// create faq obj
	$faqObj = new FaqEntry($_GET['delete']);
	
	if($_POST) {
		if($_POST['delConfirm']) {
			$faqObj->destroy();
			
			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=faq');
		}
		
		else {
			new Redirect('admin.php?file=faq');
		}
	}
	
	new Delete('', '', '', 'admin.php?file=faq');
}

// faq entry manager
else {
	// update display order?
	if(is_array($_POST['disOrders'])) {
		// only update if display order is different...
		foreach($_POST['disOrders'] as $faqid => $newOrder) {
			if($faqs[$faqid]->getDisOrder() != $newOrder) {
				if(!is_numeric($newOrder) OR $newOrder < 1) {
					$newOrder = 1;
				}
				
				$faqs[$faqid]->update(Array('disOrder' => $newOrder));
			}
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=faq');	
	}
	
	new AdminHTML('header', $lang['admin_faq_man'], true, Array('form' => true));
	
	new AdminHTML('tableBegin', $lang['admin_faq_man'], true, Array('form' => false, 'colspan' => 3));
	
	$thCells = Array(
				$lang['admin_faq_man_faqTitle'] => Array('th' => true, 'class' => 'small'),
				$lang['admin_faq_man_disOrder'] => Array('th' => true, 'class' => 'small'),
				$lang['admin_options'] => Array('th' => true, 'class' => 'small')
			);
			
	new AdminHTML('tableCells', '', true, Array('cells' => $thCells));
	
	// initialize faq iter
	$faqIter = new RecursiveIteratorIterator(new RecursiveFaqIterator(), true);
	
	// loop and display
	foreach($faqIter as $faq) {
		$cells = Array(
					str_repeat('-- ', $faqIter->getDepth()) . '<a href="admin.php?file=faq&amp;edit=' . $faq->getFaqId() . '">' . $faq->getFaqTitle() . '</a>' => Array(),
					'<input type="text" name="disOrders[' . $faq->getFaqId() . ']" class="text less" value="' . $faq->getDisOrder() . '" />' => Array(),
					'<a href="admin.php?file=faq&amp;do=add&amp;parent=' . $faq->getFaqId() . '">' . $lang['admin_faq_man_addChild'] . '</a> - <a href="admin.php?file=faq&amp;edit=' . $faq->getFaqId() . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=faq&amp;delete=' . $faq->getFaqId() . '">' . $lang['admin_delete'] . '</a>' => Array('class' => 'small')
				);
				
		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}		
	
	new AdminHTML('tableEnd', '', true, Array('form' => 0, 'footerText' => '<a href="admin.php?file=faq&amp;do=add">' . $lang['admin_faq_add'] . '</a>&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="' . $lang['admin_forums_man_saveDis'] . '" />', 'colspan' => 3));
	
	new AdminHTML('footer', '', true, Array('form' => true));
}

?>