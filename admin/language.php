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
## ******************** LANGUAGES ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-LANGUAGE');
define('FILE_ACTION', 'Languages');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();


if($_GET['do'] == 'addWords' OR $_GET['do'] == 'editWords') {
	// check if exists?
	// then get info... too...
	if($_GET['do'] == 'editWords') {
		$wordObj = new Word($_GET['wordsid']);
		$editinfo = $wordObj->getInfo();
		$which = 'editWords';
	}

	else {
		$editinfo = Array('name' => '', 'displayName' => '', 'langid' => $_GET['langid'], 'catid' => $_GET['catid'], 'words' => '');

		$which = 'addWords';
	}

	if(isset($_POST['formSet'])) {
		// check to make sure we aren't using a duplicate var name... O_O
		if(($which == 'editWords' AND isset($lang[$_POST['word']['name']]) AND $_POST['word']['name'] != $editinfo['name']) OR (isset($lang[$_POST['word']['name']]) AND $which != 'editWords')) {
			new WtcBBException($lang['admin_error_duplicateVarName']);
		}

		if($which == 'editWords') {
			if(!$editinfo['defaultid'] AND !$_POST['default']) {
				$_POST['word']['defaultid'] = $editinfo['wordsid'];

				Word::insert($_POST['word']);
			}

			else {
				$oldLang = $_POST['word']['langid'];

				if($_POST['default'] AND !$editinfo['defaultid']) {
					$_POST['word']['langid'] = 0;
				}

				$wordObj->update($_POST['word']);

				$_POST['word']['langid'] = $oldLang;
			}
		}

		else {
			if($_POST['default']) {
				$_POST['word']['defaultid'] = 0;
				$oldLang = $_POST['word']['langid'];
				$_POST['word']['langid'] = 0;

				Word::insert($_POST['word']);

				$_POST['word']['langid'] = $oldLang;
			}

			else {
				$_POST['word']['defaultid'] = -1;
				Word::insert($_POST['word']);
			}
		}

		if(!$_POST['word']['langid'] AND !$_POST['default']) {
			$_POST['word']['langid'] = $_GET['langid'];
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=language&amp;langid=' . $_POST['word']['langid'] . '&amp;catid=' . $_POST['word']['catid'] . '#' . $_POST['word']['catid']);
	}

	new AdminHTML('header', $lang['admin_language_' . $which . '_title'], true);

	if($which == 'editWords') {
		new AdminHTML('tableBegin', $lang['admin_language_' . $which . '_title'] . ' <em>' . $wordinfo['displayName'] . '</em>', true);
	}

	else {
		new AdminHTML('tableBegin', $lang['admin_language_' . $which . '_title'], true);
	}

	new AdminHTML('tableRow', Array(
									'title' => 'Default:',
									'desc' => 'DEVELOPMENT PURPOSES ONLY',
									'type' => 'checkbox',
									'name' => 'default',
									'value' => 1
								), true, Array('checkboxType' => $lang['admin_yes']));

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_addWords_display'],
									'desc' => $lang['admin_language_addWords_display_desc'],
									'type' => 'text',
									'name' => 'word[displayName]',
									'value' => $editinfo['displayName']
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_addWords_var'],
									'desc' => $lang['admin_language_addWords_var_desc'],
									'type' => 'text',
									'name' => 'word[name]',
									'value' => $editinfo['name']
								), true);

	// get all languages
	$getLangs = new Query($query['admin']['get_langs']);
	$selection = 1;
	$langs = Array();

	while($langA = $wtcDB->fetchArray($getLangs)) {
		if(isset($_GET['langid']) AND $_GET['langid'] == $langA['langid']) {
			$selection = $langA['langid'];
		}

		$langs[$langA['name']] = $langA['langid'];
	}

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_addWords_lang'],
									'desc' => $lang['admin_language_addWords_lang_desc'],
									'type' => 'select',
									'name' => 'word[langid]',
									'select' => Array('fields' => $langs, 'select' => $selection)
								), true);

	// get all cats... and sort them appropriately
	$groupIter = new RecursiveIteratorIterator(new RecursiveGroupIterator('lang_words'), true);
	$catFields = Array();

	foreach($groupIter as $obj) {
		$catFields[str_repeat('-', $groupIter->getDepth()) . $obj->getGroupName()] = $obj->getGroupId();
	}

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_addWords_cat'],
									'desc' => $lang['admin_language_addWords_cat_desc'],
									'type' => 'select',
									'name' => 'word[catid]',
									'select' => Array('fields' => $catFields, 'select' => $editinfo['catid'])
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_addWords_words'],
									'desc' => $lang['admin_language_addWords_words_desc'],
									'type' => 'textarea',
									'name' => 'word[words]',
									'value' => $editinfo['words']
								), true);

	new AdminHTML('tableEnd', '', true);
	new AdminHTML('footer', '', true);

}

else if($_GET['do'] == 'addCat' OR $_GET['do'] == 'editCat') {
	// check if exists?
	// then get info... too...
	if($_GET['do'] == 'editCat') {
		$langGroup = new Group($_GET['catid']);

		$editinfo = $langGroup->getInfo();
		$which = 'edit';
	}

	else {
		$editinfo = Array('parentid' => -1);
		$which = 'add';
	}

	if(isset($_POST['formSet'])) {
		// no group name?
		if(empty($_POST['groups']['groupName'])) {
			new WtcBBException($lang['admin_error_notEnoughInfo']);
		}

		if($which == 'edit') {
			$langGroup->update($_POST['groups']);
			$id = $langGroup->getGroupId();
		}

		else {
			Group::insert($_POST['groups']);
			$id = $wtcDB->lastInsertId();
		}

		$extra = '';

		if($_GET['langid']) {
			$extra = '&amp;langid=' . $_GET['langid'];
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=language' . $extra . '&amp;catid=' . $id);
	}

	new AdminHTML('header', $lang['admin_groups_ae_' . $which], true);

	new AdminHTML('tableBegin', $lang['admin_groups_ae_' . $which], true, Array(
																			'hiddenInputs' => Array(
																								'groups[groupType]' => 'lang_words'
																							)
																		));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_groups_ae_name'],
								'desc' => $lang['admin_groups_ae_name_desc'],
								'type' => 'text',
								'name' => 'groups[groupName]',
								'value' => $editinfo['groupName']
							), true);

	// get all level one categories
	$langCats = Array();
	$langCats[$lang['admin_groups_noParent']] = -1;

	// get all groups
	$groupIter = new RecursiveIteratorIterator(new RecursiveGroupIterator('lang_words'), true);

	foreach($groupIter as $obj) {
		$langCats[str_repeat('-', $groupIter->getDepth()) . $obj->getGroupName()] = $obj->getGroupId();
	}

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_addCat_parent'],
									'desc' => $lang['admin_language_addCat_parent_desc'],
									'type' => 'select',
									'name' => 'groups[parentid]',
									'select' => Array('fields' => $langCats, 'select' => $editinfo['parentid'])
								), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'addLang' OR $_GET['do'] == 'editLang') {
	// hmm... if we're editing, make sure we have a good ID
	if($_GET['do'] == 'editLang') {
		$langObj = new Language($_GET['langid']);

		// ok... here we go!
		$editinfo = $langObj->getInfo();
		$which = 'edit';
	}

	else {
		$editinfo = Array();
		$which = 'add';
	}

	if(isset($_POST['formSet'])) {
		// update? or... insert...
		if($which == 'edit') {
			$langObj->update($_POST['lang']);
		}

		else {
			Language::insert($_POST['lang']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=language');
	}

	new AdminHTML('header', $lang['admin_language_' . $which], true);
	new AdminHTML('tableBegin', $lang['admin_language_' . $which], true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_addLang_langName'],
									'desc' => $lang['admin_language_addLang_langName_desc'],
									'type' => 'text',
									'name' => 'lang[name]',
									'value' => $editinfo['name']
								), true);

	new AdminHTML('tableEnd', '', true);
	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'delWord') {
	$wordObj = new Word($_GET['wordsid']);

	// make sure it isn't default...
	if(!$wordObj->getDefaultId()) {
		new WtcBBException($lang['admin_error_deleteDefault']);
	}

	if($_POST['formSet']) {
		if($_POST['delConfirm']) {
			// destroy... then redo cache...
			$wordObj->destroy();

			Language::cache();

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=language&amp;langid=' . $wordObj->getLangId());
		}

		else {
			new Redirect('admin.php?file=language&amp;langid=' . $wordObj->getLangId());
		}
	}

	new Delete('', '', '', '');
}

else if($_GET['do'] == 'delCat') {
	$groupObj = new Group($_GET['catid']);

	if($_POST['formSet']) {
		if($_POST['delConfirm']) {
			// loop through each sub cat and destroy!
			$groupIter = new RecursiveIteratorIterator(new RecursiveGroupIterator('lang_words', $groupObj->getGroupId()), true);

			foreach($groupIter as $obj) {
				$obj->destroy();
			}

			$groupObj->destroy();

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=language&amp;langid=' . $_GET['langid']);
		}

		else {
			new Redirect('admin.php?file=language&amp;langid=' . $_GET['langid']);
		}
	}

	new Delete('', '', '', '', true);
}

else if($_GET['do'] == 'delLang') {
	// hmm... only one language left? NOPE!
	$groupLang = new Language($_GET['langid']);

	if($_POST['formSet']) {
		if($_POST['delConfirm']) {
			// delete all words with langid...
			$groupLang->destroy();
		}

		else {
			new Redirect('admin.php?file=language');
		}
	}

	new Delete('', '', '', '', true);
}

else if($_GET['do'] == 'search') {
	new AdminHTML('header', $lang['admin_search_language'], true);
	new AdminHTML('tableBegin', $lang['admin_search_language'], true, Array(
																		'method' => 'get',
																		'action' => 'admin.php',
																		'hiddenInputs' => Array(
																							'file' => 'language',
																							'go' => 'search'
																						)
																		));

	// get all languages
	$getLangs = new Query($query['admin']['get_langs']);
	$selection = 1;

	while($langA = $wtcDB->fetchArray($getLangs)) {
		if($_GET['langid'] == $langA['langid']) {
			$selection = $langA['langid'];
		}

		$langs[$langA['name']] = $langA['langid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_language_search_lang'],
								'desc' => $lang['admin_language_search_lang_desc'],
								'type' => 'select',
								'name' => 'langid',
								'select' => Array('fields' => $langs, 'select' => $selection)
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_language_search_searchIn'],
								'desc' => $lang['admin_language_search_searchIn_desc'],
								'type' => 'select',
								'name' => 'searchIn',
								'select' => Array(
												'fields' => Array(
															'Variable Name' => 'name',
															'Display Name' => 'displayName',
															'Word Content' => 'words'
															),
												'select' => 'words'
											)
								), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_language_search_query'],
								'desc' => $lang['admin_language_search_query_desc'],
								'type' => 'textarea',
								'name' => 'query',
							), true);

	new AdminHTML('tableEnd', '', true, Array('submitText' => $lang['admin_search_submit']));
	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'ex') {
	// get all level one categories
	// can't import/export child categories...
	// as the place they end up may or may not have their parents
	// even if they do, the IDs will probably be messed up! O_O
	// also use for exporting
	$getLevel1s = new Query($query['admin']['get_level1_langCats']);
	$langCats['Whole Language'] = -1;

	while($langCat = $wtcDB->fetchArray($getLevel1s)) {
		$langCats[$langCat['catName']] = $langCat['catid'];
		$catsinfo[$langCat['catid']] = $langCat;
	}

	if($_POST) {
		// Export
		if(is_array($_POST['catids'])) {
			// whole language...
			if($_POST['catids'][0] == -1) {
				$exportCats = $catsinfo;
			}

			// not whole... so form array
			else {
				foreach($_POST['catids'] as $id) {
					$exportCats[$id] = $catsinfo[$id];
				}
			}

			// let's get some stuff...
			// get language info, words, and sub cats
			$getLang = new Query($query['admin']['get_lang'], Array(1 => $_POST['langid']));
			$getWords = new Query($query['admin']['get_words_ordered'], Array(1 => $_POST['langid']));
			$getSubCats = new Query($query['admin']['get_level2_langCats']);

			// get lang info...
			$langinfo = $wtcDB->fetchArray($getLang);

			// now get all words... and sort them too!
			while($word = $wtcDB->fetchArray($getWords)) {
				$wordref[$word['wordsid']] = $word;
				$defs[$word['defaultid']] = $word;
			}

			// go through, and sort through default/custom words
			foreach($wordref as $wordsid => $info) {
				if($info['defaultid'] == 0) {
					$words[$info['catid']][$info['wordsid']] = $info;
					continue;
				}

				else {
					$words[$info['catid']][$info['wordsid']] = $info;
				}
			}

			// yikes... no custom words!
			if(!is_array($words)) {
				new WtcBBException($lang['admin_error_noCustomWords']);
			}

			// sorting...
			foreach($words as $catid => $meh) {
				ksort($words["$catid"]);
			}

			// now form sub cat array...
			while($subcat = $wtcDB->fetchArray($getSubCats)) {
				$subcats[$subcat['parentid']][$subcat['catid']] = $subcat;
			}

			// start exportation process
			$xml = '';

			$xml = '<?xml version="1.0" encoding="iso-8859-1" ?>' . "\n\n";
				$xml .= '<Language langid="' . $langinfo['langid'] . '" name="' . wtcspecialchars($langinfo['name']) . '">' . "\n";

				// now loop through cats, and put in words!
				foreach($exportCats as $catid => $info) {
					if(!is_array($words[$catid]) AND !is_array($subcats[$catid])) {
						continue;
					}

					// check sub cats to make sure we have some words... or something...
					$hasSubCatWords = false;

					if(is_array($subcats[$catid])) {
						foreach($subcats[$catid] as $subcatid => $subinfo) {
							if(is_array($words[$subcatid])) {
								$hasSubCatWords = true;
								break;
							}
						}
					}

					if((!is_array($words[$catid]) AND !is_array($subcats[$catid])) OR (is_array($subcats[$catid]) AND !$hasSubCatWords AND !is_array($words[$catid]))) {
						continue;
					}

					$xml .= "\t" . '<Category catid="' . $catid . '" catName="' . wtcspecialchars($info['catName']) . '" depth="' . $info['depth'] . '" parentid="' . $info['parentid'] . '">' . "\n";

					// any subcats?
					if(is_array($subcats[$catid])) {
						foreach($subcats[$catid] as $subcatid => $subinfo) {
							if(!is_array($words[$subcatid])) {
								continue;
							}

							$xml .= "\t\t" . '<SubCategory catid="' . $subcatid . '" catName="' . wtcspecialchars($subinfo['catName']) . '" depth="' . $subinfo['depth'] . '" parentid="' . $catid . '">' . "\n";

							// words?
							if(is_array($words[$subcatid])) {
								foreach($words[$subcatid] as $wordid => $wordinfo) {
									$xml .= "\t\t\t" . '<Word wordsid="' . $wordid . '" name="' . wtcspecialchars($wordinfo['name']) . '" catid="' . $wordinfo['catid'] . '" displayName="' . wtcspecialchars($wordinfo['displayName']) . '" defaultid="' . $wordinfo['defaultid'] . '"><![CDATA[' . $wordinfo['words'] . ']]></Word>' . "\n\n";
								}
							}

							$xml .= "\t\t" . '</SubCategory>' . "\n\n";
						}
					}

					// words... for level 1
					if(is_array($words[$catid])) {
						foreach($words[$catid] as $wordid => $wordinfo) {
							$xml .= "\t\t" . '<Word wordsid="' . $wordid . '" name="' . wtcspecialchars($wordinfo['name']) . '" catid="' . $wordinfo['catid'] . '" displayName="' . wtcspecialchars($wordinfo['displayName']) . '" defaultid="' . $wordinfo['defaultid'] . '"><![CDATA[' . $wordinfo['words'] . ']]></Word>' . "\n\n";
						}
					}

					$xml .= "\t" . '</Category>' . "\n\n";
				}

				$xml .= '</Language>' . "\n";

			// form lang file name...
			$langFilename = preg_replace('/\s/isU', '-', $langinfo['name']);

			// now what... download, or write to file?
			if($_POST['download']) {
				header('Content-type: text/xml');
				header('Content-Disposition: attachment; filename="wtcBB_lang_' . $langFilename . '.xml"');

				print($xml);

				exit; // so we don't add anything else O_O
			}

			// create file and write XML contents
			else {
				if(!($handle = fopen('./exports/wtcBB_lang_' . $langFilename . '.xml', 'wb'))) {
					new WtcBBException($lang['admin_error_fileOpen']);
				}

				// ok... write to file...
				fwrite($handle, $xml);

				// close it...
				fclose($handle);
			}
		}

		new WtcBBThanks($lang['admin_thanks_msg']);
	}

	new AdminHTML('header', $lang['admin_language_imEx_title'], true);

	// Export
	new AdminHTML('tableBegin', $lang['admin_language_imEx_export'], true);

	// get all languages
	$getLangs = new Query($query['admin']['get_langs']);
	$selection = 1;

	while($langA = $wtcDB->fetchArray($getLangs)) {
		if($_GET['langid'] == $langA['langid']) {
			$selection = $langA['langid'];
		}

		$langs[$langA['name']] = $langA['langid'];
	}

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_imEx_lang'],
									'desc' => $lang['admin_language_imEx_lang_desc'],
									'type' => 'select',
									'name' => 'langid',
									'select' => Array('fields' => $langs, 'select' => $selection)
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_imEx_category'],
									'desc' => $lang['admin_language_imEx_category_desc'],
									'type' => 'multiple',
									'name' => 'catids[]',
									'select' => Array('fields' => $langCats, 'select' => -1)
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_download'],
									'desc' => $lang['admin_download_desc'],
									'type' => 'checkbox',
									'name' => 'download',
									'value' => 1
								), true);

	new AdminHTML('tableEnd', '', true, Array('submitText' => $lang['admin_export']));

	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'im') {
	if($_POST) {
		// Import
		if(isset($_POST['path']) OR is_array($_FILES['fupload'])) {
			if(!is_array($_FILES['fupload'])) {
				$xml = file_get_contents($_POST['path']);
			}

			else {
				$upload = new Upload(Array('xml'), Array('text/xml'), $_FILES['fupload']);
				$xml = $upload->getFileContents();
			}

			$import = new ImportLanguage($xml, $_POST['newLang'], $_POST['langTitle']);
		}

		// Error!
		else {
			new WtcBBException($lang['admin_error_notEnoughInfo']);
		}

		new WtcBBThanks($lang['admin_thanks_msg']);
	}

	new AdminHTML('header', $lang['admin_language_imEx_title'], true);

	// Import
	new AdminHTML('tableBegin', $lang['admin_language_imEx_import'], true, Array('upload' => true));

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_imEx_filePath'],
									'desc' => $lang['admin_language_imEx_filePath_desc'],
									'type' => 'text',
									'name' => 'path',
									'value' => './exports/'
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_imEx_upload'],
									'desc' => $lang['admin_language_imEx_upload_desc'],
									'type' => 'file',
									'name' => 'fupload'
								), true);

	// before we get languages, unset previous array
	unset($langs);

	// get all languages
	$getLangs = new Query($query['admin']['get_langs']);
	$langs['Create New Language'] = -1;

	while($langA = $wtcDB->fetchArray($getLangs)) {
		$langs[$langA['name']] = $langA['langid'];
	}

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_imEx_newLang'],
									'desc' => $lang['admin_language_imEx_newLang_desc'],
									'type' => 'select',
									'name' => 'newLang',
									'select' => Array('fields' => $langs, 'select' => -1)
								), true, Array('checkboxType' => $lang['admin_yes']));

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_language_imEx_langTitle'],
									'desc' => $lang['admin_language_imEx_langTitle_desc'],
									'type' => 'text',
									'name' => 'langTitle'
								), true);

	new AdminHTML('tableEnd', '', true, Array('submitText' => $lang['admin_import']));

	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'viewDefault') {
	$wordObj = new Word($_GET['wordsid']);
	$default = $wordObj->getInfo();

	// get cat info (for name)
	$catinfo = $generalGroups['lang_words'][$default['catid']]->getInfo();

	new AdminHTML('header', $lang['admin_language_viewDef'], true);
	new AdminHTML('tableBegin', $lang['admin_language_viewDef'] . ': ' . $default['displayName'], true, Array('form' => false));

	new AdminHTML('tableCells', '', true, Array(
											'cells' => Array(
															$lang['admin_language_addWords_cat'] => Array('bold' => true),
															$catinfo['groupName'] => Array()
														)
											));

	new AdminHTML('tableCells', '', true, Array(
											'cells' => Array(
															$lang['admin_language_addWords_display'] => Array('bold' => true),
															$default['displayName'] => Array()
														),
											));

	new AdminHTML('tableCells', '', true, Array(
											'cells' => Array(
															$lang['admin_language_addWords_var'] => Array('bold' => true),
															$default['name'] => Array()
														),
											));

	new AdminHTML('tableCells', '', true, Array(
											'cells' => Array(
															$lang['admin_language_addWords_words'] => Array('bold' => true),
															$default['words'] => Array()
														)
											));

	new AdminHTML('tableEnd', '', true, Array(
											'form' => false,
											'footerText' => '<a href="admin.php?file=language&amp;do=delWord&amp;wordsid=' . $_GET['customid'] . '&amp;langid=' . $_GET['langid'] . '">Revert to Default</a> - <a href="' . $_SERVER['HTTP_REFERER'] . '">Go Back</a>'
										));
	new AdminHTML('footer', '', true);
}

else {
	if(!isset($_GET['langid'])) {
		new AdminHTML('header', $lang['admin_language_manager_title'], true);
		new AdminHTML('tableBegin', $lang['admin_language_manager_title'], true, Array('form' => false));

		$getLangs = new Query($query['admin']['get_langs']);

		while($langInfo = $wtcDB->fetchArray($getLangs)) {
			new AdminHTML('tableCells', '', true, Array(
													'cells' => Array(
																	'<a href="admin.php?file=language&amp;langid=' . $langInfo['langid'] . '">' . $langInfo['name'] . '</a>' => Array(),
																	'<a href="admin.php?file=language&amp;langid=' . $langInfo['langid'] . '">' . $lang['admin_manage'] . '</a> - <a href="admin.php?file=language&amp;do=editLang&amp;langid=' . $langInfo['langid'] . '">' . $lang['admin_edit'] . '</a> - <a href="admin.php?file=language&amp;do=delLang&amp;langid=' . $langInfo['langid'] . '">' . $lang['admin_delete'] . '</a>' => Array('class' => 'small')
																)
														));
		}

		new AdminHTML('tableEnd', '', true, Array('form' => false, 'footerText' => '<a href="admin.php?file=language&amp;do=addLang">' . $lang['admin_language_manager_add'] . '</a>'));
		new AdminHTML('footer', '', true);
	}

	else {
		$langObj = new Language($_GET['langid']);

		// get all words... and sort them appropriately
		$getWords = new Query($query['admin']['get_words_ordered'], Array(1 => $langObj->getLangId()));

		// now get all words... and sort them too!
		while($word = $wtcDB->fetchArray($getWords)) {
			$wordref[$word['wordsid']] = $word;
			$defs[$word['defaultid']] = $word;
		}

		// go through, and sort through default/custom words
		foreach($wordref as $wordsid => $info) {
			if($info['defaultid'] OR ($info['defaultid'] == 0 AND !isset($defs[$info['wordsid']]))) {
				$words[$info['catid']][$info['displayName']] = $info;
			}
		}

		// sorting...
		foreach($words as $catid => $meh) {
			ksort($words["$catid"]);
		}

		$results = NULL;

		// searching? we need to get matchids!
		if($_GET['go'] == 'search') {
			$search = new Query($query['admin']['search_language'], Array(1 => $_GET['searchIn'], 2 => $_GET['query'], 3 => $_GET['langid']));

			// nuttin!
			if(!$wtcDB->numRows($search)) {
				new WtcBBException($lang['admin_error_noResults']);
			}

			// alrighty... loop through and put results into array
			while($result = $wtcDB->fetchArray($search)) {
				$results[$result['catid']][$result['wordsid']] = $result;
			}
		}

		// initiate group iterator
		$groupIter = new RecursiveIteratorIterator(new RecursiveGroupIterator('lang_words'), true);
		$toPrint = Array();
		$prevDepth = -1;

		// start HTML header
		new AdminHTML('header', $lang['admin_language_manager_lang'] . ' ' . $langObj->getName(), true);

		$keyBox = "\t\t\t" . '<ul class="noBullets">' . "\n";
			$keyBox .= "\t\t\t\t" . '<li style="color: #00285b; font-weight: bold;">' . $lang['admin_language_manager_key_blue'] . '</li>' . "\n";
			$keyBox .= "\t\t\t\t" . '<li style="color: #bb0000; font-weight: bold;">' . $lang['admin_language_manager_key_red'] . '</li>' . "\n";
		$keyBox .= "\t\t\t" . '</ul>' . "\n";

		new AdminHTML('divitBox', Array(
									'title' => $lang['admin_language_manager_key'],
									'content' => $keyBox
								), true);

		new AdminHTML('tableBegin', $lang['admin_language_manager_lang'] . ' <em>' . $langObj->getName() . '</em>', true, Array('form' => false));

		foreach($groupIter as $obj) {
			krsort($toPrint);

			// do we need to print?
			foreach($toPrint as $depth => $more) {
				foreach($more as $id => $vals) {
					if($depth >= $groupIter->getDepth()) {
						print($vals['contents']);
						unset($toPrint[$depth][$id]);
					}
				}
			}

			$extraLink = '&amp;catid=' . $obj->getGroupId() . '#' . $obj->getGroupId();

			if($_GET['go'] == 'search') {
				$isSibling = $obj->isSibling($results);
				$isAuntOrUncle = $obj->isAuntOrUncle($results);
				$isParent = $obj->isParent($results);
				$isChild = $obj->isChild($results);
			}

			else {
				$isSibling = $obj->isSibling($_GET['catid']);
				$isAuntOrUncle = $obj->isAuntOrUncle($_GET['catid']);
				$isParent = $obj->isParent($_GET['catid']);
				$isChild = $obj->isChild($_GET['catid']);
			}

			if(!$groupIter->getDepth() OR $isSibling OR $isAuntOrUncle OR $isParent OR $isChild) {
				if(!$groupIter->getDepth() AND $obj->getGroupId() == $_GET['catid']) {
					$extraLink = '';
				}

				else if(($isChild OR $obj->getGroupId() == $_GET['catid']) AND $groupIter->getDepth()) {
					$extraLink = '&amp;catid=' . $obj->getParentId() . '#' . $obj->getParentId();
				}

				$opts = Array(
					'cells' => Array(
									str_repeat('-- ', $groupIter->getDepth()) . '<a href="admin.php?file=language&amp;langid=' . $_GET['langid'] . $extraLink . '" name="' . $obj->getGroupId() . '">' . $obj->getGroupName() . '</a>' => Array('class' => 'header'),
									'<a href="admin.php?file=language&amp;langid=' . $_GET['langid'] . '&amp;do=addWords&amp;catid=' . $obj->getGroupId() . '">' . $lang['admin_add'] . '</a> - <a href="admin.php?file=language&amp;langid=' . $_GET['langid'] . '&amp;do=editCat&amp;catid=' . $obj->getGroupId() . '">' . $lang['admin_edit'] . '</a>' => Array('small' => true, 'class' => 'header')
							)
						);

				new AdminHTML('tableCells', '', true, $opts);

				if(is_array($words[$obj->getGroupId()]) AND ($_GET['go'] == 'search' OR ($obj->getGroupId() == $_GET['catid'] OR $isChild))) {

					foreach($words[$obj->getGroupId()] as $displayName => $info) {
						// search query already ran!
						if($_GET['go'] == 'search' AND !isset($results[$obj->getGroupId()][$info['wordsid']])) {
							continue;
						}

						$class = ''; $delete = '';

						if($info['defaultid'] != 0) {
							$class = ' class="custom"';
							$delete = '- <a href="admin.php?file=language&amp;langid=' . $_GET['langid'] . '&amp;do=delWord&amp;wordsid=' . $info['wordsid'] . '">' . $lang['admin_delete'] . '</a>';

							if($info['defaultid'] != -1) {
								$delete .= ' - <a href="admin.php?file=language&amp;do=viewDefault&amp;wordsid=' . $info['defaultid'] . '&amp;customid=' . $info['wordsid'] . '&amp;langid=' . $_GET['langid'] . '">' . $lang['admin_viewDefault'] . '</a>';
							}
						}

						$opts = Array(
							'cells' => Array(
											str_repeat('-- ', $groupIter->getDepth() + 1) . '<a href="admin.php?file=language&amp;langid=' . $_GET['langid'] . '&amp;do=editWords&amp;wordsid=' . $info['wordsid'] . '"' . $class . '>' . $displayName . '</a>' => Array('class' => 'noAlt'),
											'<a href="admin.php?file=language&amp;langid=' . $_GET['langid'] . '&amp;do=editWords&amp;wordsid=' . $info['wordsid'] . '">' . $lang['admin_edit'] . '</a>' . $delete => Array('small' => true, 'class' => 'noAlt')
										)
								);

						ob_start();
						new AdminHTML('tableCells', '', true, $opts);
						$toPrint[$groupIter->getDepth()][$obj->getGroupId()]['contents'] .= ob_get_contents();
						$prevDepth = $groupIter->getDepth();
						ob_end_clean();
					}
				}
			}
		}

		// anything else?
		krsort($toPrint);

		foreach($toPrint as $depth => $more) {
			foreach($more as $id => $vals) {
				print($vals['contents']);
				unset($toPrint[$depth][$id]);
			}
		}

		new AdminHTML('tableEnd', '', true, Array('form' => false));
		new AdminHTML('footer', '', true);
	}
}



?>