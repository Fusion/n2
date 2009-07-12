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
## ***************** wtcBB STYLES ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-STYLES');
define('FILE_ACTION', 'Style System');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

// set the locations for styles...
// used many times...
$styleLocations = Array(
						'admin.php?file=style&amp;templates=!@#$%' => $lang['admin_style_man_templates'],
						'admin.php?file=style&amp;edit=!@#$%' => $lang['admin_style_man_edit'],
						'admin.php?file=style&amp;colors=!@#$%' => $lang['admin_style_man_colors'],
						'admin.php?file=style&amp;visual=!@#$%' => $lang['admin_style_man_visual'],
						'admin.php?file=style&amp;images=!@#$%' => $lang['admin_style_man_images'],
						'admin.php?file=style&amp;repVars=!@#$%' => $lang['admin_style_man_repVars'],
						'admin.php?file=style&amp;do=addTemplate&amp;s=!@#$%' => $lang['admin_style_addTemplate'],
						'admin.php?file=style&amp;do=add&amp;s=!@#$%' => $lang['admin_style_addChild'],
						'admin.php?file=style&amp;do=export&amp;s=!@#$%' => $lang['admin_style_man_export'],
						'admin.php?file=style&amp;fixphp=!@#$%' => $lang['admin_style_man_fixPHP'],						
						'admin.php?file=style&amp;delete=!@#$%' => $lang['admin_delete']
				);

// exporting a style
if($_GET['do'] == 'export') {
	// load our style object first
	$Style = new Style($_GET['s']);

	header('Expires: Sun, 05 Jul 1987 22:45:00 GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', false);
	header('Pragma: no-cache');
	header('Content-type: text/xml');
	header('Content-Disposition: attachment; filename="style_export_' . $Style->getStyleId() . '.xml"');
	print('<?xml version="1.0" encoding="utf-8"?>' . "\n\n");

	$fragIds = $Style->getFragmentIds();

	// get all our fragments and such...
	$frags = $Style->buildFragments('%');

	print('<root>' . "\n");

	print('<style styleid="' . $Style->getStyleId() . '" parentid="' . $Style->getParentId() . '" name="' . $Style->getName() . '" disOrder="' . $Style->getDisOrder() . '" selectable="' . $Style->isSelectable() . '" enabled="' . $Style->isEnabled() . '" fragmentids="' . htmlspecialchars(serialize($Style->getFragmentIds())) . '">' . "\n");

	print('<css><![CDATA[' . $Style->getCSS() . ']]></css>' . "\n");

	foreach($frags as $gid => $more) {
		foreach($more as $fragid => $obj) {
			$info = $obj->getInfo();

			if($obj->getDefaultId() == 0) {
				print('<fragment fragmentid="' . $obj->getFragmentId() . '" styleid="' . $obj->getStyleId() . '" groupid="' . $obj->getGroupId() . '" fragmentName="' . $obj->getName() . '" fragmentVarName="' . $obj->getVarName() . '" fragmentType="' . $obj->getFragmentType() . '" defaultid="' . $obj->getDefaultId() . '" disOrder="' . $obj->getDisOrder() . '">' . "\n");
					print('<template><![CDATA[' . $obj->getFragment() . ']]></template>' . "\n");
					print('<templatephp><![CDATA[' . $obj->getFragmentPHP() . ']]></templatephp>' . "\n");
				print('</fragment>' . "\n\n");
			}
		}
	}

	print('</style>' . "\n");
	print('</root>');
}

// importing default style...
else if($_GET['do'] == 'devimport') {
	$xml = file_get_contents('./admin/style_export_1.xml');

	$DOM = new DomDocument();
	$DOM->loadXML($xml);

	$fragments = $DOM->getElementsByTagName('fragment');

	foreach($fragments as $frag) {
		$template = $frag->getElementsByTagName('template');
		$templatePHP = $frag->getElementsByTagName('templatephp');

		foreach($template as $t) {
			$myFrag = $t->nodeValue;
			break;
		}

		foreach($templatePHP as $tp) {
			$myFragPHP = $tp->nodeValue;
			break;
		}

		$myFrag = str_replace("\n", "\r\n", $myFrag);

		StyleFragment::insert(Array(
			'fragmentid' => $frag->getAttribute('fragmentid'),
			'styleid' => $frag->getAttribute('styleid'),
			'groupid' => $frag->getAttribute('groupid'),
			'fragmentName' => $frag->getAttribute('fragmentName'),
			'fragmentVarName' => $frag->getAttribute('fragmentVarName'),
			'fragmentType' => $frag->getAttribute('fragmentType'),
			'defaultid' => $frag->getAttribute('defaultid'),
			'disOrder' => $frag->getAttribute('disOrder'),
			'fragment' => $myFrag,
			'template_php' => $myFragPHP
			)
		);
	}

	$styles = $DOM->getElementsByTagName('style');

	foreach($styles as $style) {
		$css = $style->getElementsByTagName('css');

		foreach($css as $sheet) {
			$cssContent = $sheet->nodeValue;
			break;
		}

		Style::insert(Array(
			'styleid' => $style->getAttribute('styleid'),
			'parentid' => $style->getAttribute('parentid'),
			'name' => $style->getAttribute('name'),
			'disOrder' => $style->getAttribute('disOrder'),
			'selectable' => $style->getAttribute('selectable'),
			'enabled' => $style->getAttribute('enabled'),
			'fragmentids' => $style->getAttribute('fragmentids'),
			'css' => $cssContent
			)
		);
	}

	exit('Import Complete');
}

// adding or editing a style
else if($_GET['do'] == 'add' OR isset($_GET['edit'])) {
	if($_GET['do'] == 'add') {
		$which = 'add';
		$editinfo = Array(
						'parentid' => (isset($_GET['parent']) ? $_GET['parent'] : -1), 'name' => 'Style', 'disOrder' => 1,
						'selectable' => 1, 'enabled' => 1
					);
	}

	else {
		$which = 'edit';
		$styleObj = new Style($_GET['edit']);
		$editinfo = $styleObj->getInfo();
	}

	// update style table
	if($_POST['formSet']) {
		// must fill out avatar name
		if(empty($_POST['style']['name'])) {
			new WtcBBException($lang['admin_error_notEnoughInfo']);
		}

		// set dis order to 1 if not set
		if(empty($_POST['style']['disOrder']) OR $_POST['style']['disOrder'] < 1) {
			$_POST['style']['disOrder'] = 1;
		}

		// add?
		if($which == 'add') {
			// just insert...
			Style::insert($_POST['style']);
		}

		// update
		else {
			// make sure we aren't making this a child of a child style...
			if($_POST['style']['parentid'] != $editinfo['parentid']) {
				// or if same style...
				if($_POST['style']['parentid'] == $editinfo['styleid']) {
					new WtcBBException($lang['admin_error_childOfChild']);
				}

				// iter through childs...
				$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator($editinfo['styleid']), true);

				foreach($styleIter as $style) {
					// whaa??!!
					if($style->getStyleId() == $_POST['style']['parentid']) {
						new WtcBBException($lang['admin_error_childOfChild']);
					}
				}
			}

			$styleObj->update($_POST['style']);
			Style::buildStyles();
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=style');
	}

	new AdminHTML('header', $lang['admin_style_' . $which], true);

	new AdminHTML('tableBegin', $lang['admin_style_' . $which], true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_style_ae_name'],
								'desc' => $lang['admin_style_ae_name_desc'],
								'type' => 'text',
								'name' => 'style[name]',
								'value' => $editinfo['name']
							), true);


	// get styles
	$styleSelect = Array();
	$styleSelect[$lang['admin_style_noParent']] = -1;

	// init forum iter
	$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator(), true);

	foreach($styleIter as $style) {
		$styleSelect[str_repeat('-', $styleIter->getDepth()) . ' ' . $style->getName()] = $style->getStyleId();
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_style_ae_parent'],
								'desc' => $lang['admin_style_ae_parent_desc'],
								'type' => 'select',
								'name' => 'style[parentid]',
								'select' => Array('fields' => $styleSelect, 'select' => (isset($_GET['s']) AND $which == 'add') ? $_GET['s'] : $editinfo['parentid'])
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_style_ae_disOrder'],
								'desc' => $lang['admin_style_ae_disOrder_desc'],
								'type' => 'text',
								'name' => 'style[disOrder]',
								'value' => $editinfo['disOrder']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_style_ae_selectable'],
								'desc' => $lang['admin_style_ae_selectable_desc'],
								'type' => 'checkbox',
								'name' => 'style[selectable]',
								'value' => $editinfo['selectable']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_style_ae_enabled'],
								'desc' => $lang['admin_style_ae_enabled_desc'],
								'type' => 'checkbox',
								'name' => 'style[enabled]',
								'value' => $editinfo['enabled']
							), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

// add/edit group
else if($_GET['do'] == 'addGroup' OR isset($_GET['editGroup'])) {
	if($_GET['do'] == 'addGroup') {
		$which = 'add';
		$editinfo = Array('parentid' => -1);
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
			// make sure we aren't making this a child of a child group...
			if($_POST['group']['parentid'] != $editinfo['parentid']) {
				// or if same group...
				if($_POST['group']['parentid'] == $editinfo['groupid']) {
					new WtcBBException($lang['admin_error_childOfChild']);
				}

				// iter through childs...
				$groupIter = new RecursiveIteratorIterator(new RecursiveStyleIterator($editinfo['groupid']), true);

				foreach($groupIter as $obj) {
					// whaa??!!
					if($style->getGroupId() == $_POST['group']['parentid']) {
						new WtcBBException($lang['admin_error_childOfChild']);
					}
				}
			}

			$groupObj->update($_POST['groups']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=style');
	}

	new AdminHTML('header', $lang['admin_groups_ae_' . $which], true);

	new AdminHTML('tableBegin', $lang['admin_groups_ae_' . $which], true, Array(
																			'hiddenInputs' => Array(
																								'groups[groupType]' => 'styles_fragments'
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
	$groupSelect = Array();
	$groupSelect[$lang['admin_groups_noParent']] = -1;

	// get all groups
	$groupIter = new RecursiveIteratorIterator(new RecursiveGroupIterator('styles_fragments'), true);

	foreach($groupIter as $obj) {
		$groupSelect[str_repeat('-', $groupIter->getDepth()) . $obj->getGroupName()] = $obj->getGroupId();
	}

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_groups_ae_parent'],
									'desc' => $lang['admin_groups_ae_parentTemplate_desc'],
									'type' => 'select',
									'name' => 'groups[parentid]',
									'select' => Array('fields' => $groupSelect, 'select' => $editinfo['parentid'])
								), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

// re-create all PHP Code
else if(isset($_GET['fixphp'])) {
	new Confirm(
		'',
		create_function('', 'return fixPHP();'),
		'admin.php?file=style');
}

// edit template in window
else if(isset($_GET['windowEdit'])) {
	$which = 'edit';
	$templateObj = new StyleFragment($_GET['windowEdit']);
	$editinfo = $templateObj->getInfo();

	if($_GET['s'] AND (!$editinfo['defaultid'] OR $_GET['s'] != $templateObj->getStyleId())) {
		$editinfo['styleid'] = $_GET['s'];
	}

	if(isset($_POST['formSet'])) {
		// meh
		$_POST['isDefault'] = 0;
#CFR: Always new fragment matching current style		if(DEV) $_POST['isDefault'] = 1;

		// fill in some info...
		if(!$_POST['isDefault']) {
			$_POST['template']['fragmentVarName'] = $editinfo['fragmentVarName'];
			$_POST['template']['fragmentName'] = $editinfo['fragmentVarName'];
			$_POST['template']['groupid'] = $editinfo['groupid'];
			$_POST['template']['styleid'] = $editinfo['styleid'];
		}

		// set normal name to var name
		if(empty($_POST['template']['fragmentName'])) {
			$_POST['template']['fragmentName'] = $_POST['template']['fragmentVarName'];
		}

		// do template conditionals...
		$_POST['template']['template_php'] = StyleFragment::parseTemplate($_POST['template']['fragment']);

		// which defaultid should we use?
		if($_POST['isDefault']) {
			$_POST['template']['defaultid'] = 0;
			$_POST['template']['styleid'] = 0;
		}

		else if(!$editinfo['defaultid']) {
			$_POST['template']['defaultid'] = $editinfo['fragmentid'];
		}

		else if(isset($_GET['s']) AND $_GET['s'] != $templateObj->getStyleId()) {
			$_POST['template']['defaultid'] = $templateObj->getDefaultId();
		}

		// add?
		if((isset($_GET['s']) AND $_GET['s'] != $templateObj->getStyleId() AND !$_POST['isDefault']) OR (!$editinfo['defaultid'] AND !$_POST['isDefault'])) {
			$lastId = StyleFragment::insert($_POST['template']);
			$tid = $lastId;
		}

		else {
			$templateObj->update($_POST['template']);
			$tid = $templateObj->getFragmentId();
		}

		if(!$_POST['template']['defaultid']) {
			$addStyleid = '&amp;templates=1';
		}

		else {
			$addStyleid = '&amp;templates=' . $_POST['template']['styleid'];
		}

		$addGroupid = '&amp;groupid=' . $_POST['template']['groupid'] . '#' . $_POST['template']['groupid'];

		if($_POST['saveReload']) {
			new Redirect('admin.php?file=style&windowEdit=' . $tid . '&s=' . $editinfo['styleid']);
		}

		else {
			print('<script> window.close(); </script>');
		}
	}

	new AdminHTML('header', $templateObj->getVarName(), true, Array(
										'form' => true,
										'hiddenInputs' => Array(
															'template[fragmentType]' => 'template'
															)
										));

	new AdminHTML('tableBegin', $templateObj->getVarName(), true, Array('form' => false));

	new AdminHTML('bigTextarea', Array(
									'title' => '',
									'name' => 'template[fragment]',
									'value' => $editinfo['fragment'],
									'class' => ' code'
								), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => '<input type="submit" value="' . $lang['admin_style_t_saveReload'] . '" class="button" name="saveReload" />  <input type="submit" value="' . $lang['admin_save'] . '" class="button" />  <input type="reset" value="' . $lang['admin_reset'] . '" class="button" />  <input type="button" value="' . $lang['admin_close'] . '" class="button" onclick="window.close();" />'));

	AdminHTML::formatBigTextArea('template[fragment]');
	
	new AdminHTML('footer', '', true, Array('form' => true));
}

// add/edit template
else if($_GET['do'] == 'addTemplate' OR isset($_GET['editTemplate'])) {
	if($_GET['do'] == 'addTemplate') {
		$which = 'add';
		$editinfo = Array('styleid' => (isset($_GET['s']) ? $_GET['s'] : 1), 'groupid' => (isset($_GET['groupid']) ? $_GET['groupid'] : 160), 'fragmentType' => 'template');
	}

	else {
		$which = 'edit';
		$templateObj = new StyleFragment($_GET['editTemplate']);
		$editinfo = $templateObj->getInfo();

		if($_GET['s'] AND (!$editinfo['defaultid'] OR $_GET['s'] != $templateObj->getStyleId())) {
			$editinfo['styleid'] = $_GET['s'];
		}
	}

	if(isset($_POST['formSet'])) {
		// set normal name to var name
		if(empty($_POST['template']['fragmentName'])) {
			$_POST['template']['fragmentName'] = $_POST['template']['fragmentVarName'];
		}

		// we might need it...
		$realStyleId = $_POST['template']['styleid'];

		// do template conditionals...
		$_POST['template']['template_php'] = StyleFragment::parseTemplate($_POST['template']['fragment']);

		if(!DEV) {
			$_POST['isDefault'] = 0;
		}

		// which defaultid should we use?
		if($_POST['isDefault']) {
			$_POST['template']['defaultid'] = 0;
			$_POST['template']['styleid'] = 0;
		}

		else if($which == 'edit' AND !$editinfo['defaultid']) {
			$_POST['template']['defaultid'] = $editinfo['fragmentid'];
		}

		else if($which == 'add') {
			$_POST['template']['defaultid'] = -1;
		}

		else if($which == 'edit' AND isset($_GET['s']) AND $_GET['s'] != $templateObj->getStyleId()) {
			$_POST['template']['defaultid'] = $templateObj->getDefaultId();
		}

		// add?
		if($which == 'add' OR ($which == 'edit' AND ((isset($_GET['s']) AND $_GET['s'] != $templateObj->getStyleId() AND !$_POST['isDefault']) OR (!$editinfo['defaultid'] AND !$_POST['isDefault'])))) {
			$lastId = StyleFragment::insert($_POST['template']);

			// if it's an add, update the defaultid to it's own ID...
			if($which == 'add' AND !$_POST['isDefault']) {
				$obj = new StyleFragment($lastId);
				$obj->update(Array('defaultid' => $lastId));
			}

			$tid = $lastId;
		}

		else {
			$templateObj->update($_POST['template']);
			$tid = $templateObj->getFragmentId();
		}

		if($_POST['template']['defaultid']) {
			$addStyleid = '&amp;templates=1';
		}

		else {
			$addStyleid = '&amp;templates=' . $realStyleId;
		}

		$addStyleid = '&amp;templates=' . $editinfo['styleid'];

		$addGroupid = '&amp;groupid=' . $_POST['template']['groupid'] . '#' . $_POST['template']['groupid'];

		if($_POST['saveReload']) {
			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=style&amp;editTemplate=' . $tid . '&amp;s=' . $editinfo['styleid']);
		}

		else {
			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=style' . $addStyleid . $addGroupid);
		}
	}

	new AdminHTML('header', $lang['admin_style_template_ae_' . $which], true, Array(
																			'form' => true/*,
																			'hiddenInputs' => Array(
																								'template[fragmentType]' => 'template'
																								)*/
																			));

	new AdminHTML('tableBegin', $lang['admin_style_template_ae_' . $which], true, Array('form' => false));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_style_template_ae_name'],
								'desc' => $lang['admin_style_template_ae_name_desc'],
								'type' => 'text',
								'name' => 'template[fragmentVarName]',
								'value' => $editinfo['fragmentVarName']
							), true);

	// get all styles
	$styleSelect = Array();

	$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator(), true);

	foreach($styleIter as $obj) {
		$styleSelect[str_repeat('-', $styleIter->getDepth()) . $obj->getName()] = $obj->getStyleId();
	}

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_style_template_ae_style'],
									'desc' => $lang['admin_style_template_ae_style_desc'],
									'type' => 'select',
									'name' => 'template[styleid]',
									'select' => Array('fields' => $styleSelect, 'select' => $editinfo['styleid'])
								), true);

	// get template groups
	$groupSelect = Array();

	// get all groups
	$groupIter = new RecursiveIteratorIterator(new RecursiveGroupIterator('styles_fragments'), true);

	foreach($groupIter as $obj) {
		$groupSelect[str_repeat('-', $groupIter->getDepth()) . $obj->getGroupName()] = $obj->getGroupId();
	}

	new AdminHTML('tableRow', Array(
									'title' => $lang['admin_style_template_ae_group'],
									'desc' => $lang['admin_style_template_ae_group_desc'],
									'type' => 'select',
									'name' => 'template[groupid]',
									'select' => Array('fields' => $groupSelect, 'select' => $editinfo['groupid'])
								), true);

	new AdminHTML('tableRow', Array(
									'title' => 'Is Default:',
									'desc' => 'Sets whether this style uses the default template or if, instead, a custom template must be created for this style. <strong>IMPORTANT: </strong>If you select \'Yes\' and have already created a custom template for this style, your custom template will be deleted.',
									'type' => 'checkbox',
									'name' => 'isDefault',
									'value' => ($which == 'edit' ? false : true)
								), true);

	new AdminHTML('tableRow', Array(
									'title' => 'Fragment Type:',
									'desc' => 'Specifies what type of fragment this is.',
									'type' => 'select',
									'name' => 'template[fragmentType]',
									'select' => Array('fields' => Array(
																	'template' => 'template',
																	'style' => 'style',
																	'option' => 'option',
																	'variable' => 'variable',
																	'image' => 'imageName'
																), 'select' => $editinfo['fragmentType'])
								), true);

	new AdminHTML('tableRow', Array(
									'title' => 'Fragment Var Name: ',
									'desc' => 'This should be unique, template name should line up with language var.',
									'type' => 'text',
									'name' => 'template[fragmentName]',
									'value' => $editinfo['fragmentName']
								), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));

	new AdminHTML('tableBegin', $lang['admin_style_template_ae_template'], true, Array('form' => false));

	new AdminHTML('bigTextarea', Array(
									'title' => '',
									'name' => 'template[fragment]',
									'value' => $editinfo['fragment'],
									'class' => ' code'
								), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'footerText' => '<input type="submit" value="' . $lang['admin_style_t_saveReload'] . '" class="button" name="saveReload" />  <input type="submit" value="' . $lang['admin_save'] . '" class="button" />  <input type="reset" value="' . $lang['admin_reset'] . '" class="button" />'));

	AdminHTML::formatBigTextArea('template[fragment]');
	
	new AdminHTML('footer', '', true, Array('form' => true));
}

// delete style
else if(isset($_GET['delete'])) {
	// create style obj
	$styleObj = new Style($_GET['delete']);

	if($_POST) {
		if($_POST['delConfirm']) {
			$styleObj->destroy();

			// update styles now...
			Style::buildStyles();

			// rebuild cache
			new Cache('Styles');
			new Cache('OrderedStyles');

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=style');
		}

		else {
			new Redirect('admin.php?file=style');
		}
	}

	new Delete('', '', '', 'admin.php?file=style');
}

// delete group
else if(isset($_GET['delGroup'])) {
	$groupObj = new Group($_GET['delGroup']);

	if($_POST['formSet']) {
		if($_POST['delConfirm']) {
			$groupObj->destroy('styles_fragments');

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=style');
		}

		else {
			new Redirect('admin.php?file=style');
		}
	}

	new Delete('', '', '', '', true, false, 'admin_styles_delete');
}

// delete template
else if(isset($_GET['delTemplate'])) {
	$template = new StyleFragment($_GET['delTemplate']);
	$template->destroy();
}

// view default template...
else if(isset($_GET['viewDefault'])) {
	$template = new StyleFragment($_GET['viewDefault']);

	new AdminHTML('header', $lang['admin_style_template_viewDef'], true);
	new AdminHTML('tableBegin', $lang['admin_style_template_viewDef'] . ': ' . $template->getVarName(), true, Array('form' => false));

	new AdminHTML('tableCells', '', true, Array(
											'cells' => Array(
															$lang['admin_style_template_viewDef_name'] => Array('bold' => true),
															$template->getVarName() => Array()
														),
											));

	new AdminHTML('tableCells', '', true, Array(
											'cells' => Array(
															$lang['admin_style_template_viewDef_group'] => Array('bold' => true),
															$template->getGroupName() => Array()
														)
											));

	new AdminHTML('tableCells', '', true, Array(
											'cells' => Array(
															'<p class="left"><strong>' . $lang['admin_style_template_viewDef_template'] . '</strong></p> <p class="left small">You cannot edit this template here.</p> <textarea class="bigArea" onkeydown="return false;">' . $template->getFragment() . '</textarea>' => Array('colspan' => 2, 'class' => 'center')
														)
											));

	new AdminHTML('tableEnd', '', true, Array(
											'form' => false,
											'footerText' => '<a href="admin.php?file=style&amp;delTemplate=' . $_GET['customid'] . '">Revert to Default</a> - <a href="' . $_SERVER['HTTP_REFERER'] . '">Go Back</a>'
										));
	new AdminHTML('footer', '', true);
}

// searching time
else if($_GET['do'] == 'search') {
	new AdminHTML('header', $lang['admin_search_templates'], true);
	new AdminHTML('tableBegin', $lang['admin_search_templates'], true, Array(
																		'method' => 'get',
																		'action' => 'admin.php',
																		'hiddenInputs' => Array(
																							'file' => 'style',
																							'go' => 'search'
																						)
																		));

	// get all styles...
	$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator(), true);
	$selection = (isset($_GET['s']) ? $_GET['s'] : 1);

	foreach($styleIter as $style) {
		$styleSelect[str_repeat('-', $styleIter->getDepth()) . $style->getName()] = $style->getStyleId();
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_style_search_style'],
								'desc' => $lang['admin_style_search_style_desc'],
								'type' => 'select',
								'name' => 'templates',
								'select' => Array('fields' => $styleSelect, 'select' => $selection)
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_style_search_query'],
								'desc' => $lang['admin_style_search_query_desc'],
								'type' => 'textarea',
								'name' => 'query',
							), true);

	new AdminHTML('tableEnd', '', true, Array('submitText' => $lang['admin_search_submit']));
	new AdminHTML('footer', '', true);
}

// replacement variables
else if(isset($_GET['repVars'])) {
	// create style obj...
	$styleObj = new Style($_GET['repVars']);
	$fragIds = $styleObj->getFragmentIds();

	// get all our settings...
	$vars = $styleObj->buildFragments('variable');

	// update settings
	if($_POST['formSet']) {
		foreach($vars as $groupid => $more) {
			foreach($more as $fragid => $varObj) {
				// revert?
				if($_POST['revert'][$fragid]) {
					$varObj->destroy(true);
					continue;
				}

				// not set or unchanged... forget about it
				if(empty($_POST['find'][$fragid]) OR ($_POST['find'][$fragid] == $varObj->getVarName() AND $_POST['replace'][$fragid] == $varObj->getFragment())) {
					continue;
				}

				// just update... but what to do, insert or update?
				if($styleObj->getStyleId() == $varObj->getStyleId()) {
					$varObj->update(Array('fragmentVarName' => $_POST['find'][$fragid], 'fragment' => $_POST['replace'][$fragid]));
				}

				// insert a new template...
				else {
					$insert = Array(
								'styleid' => $styleObj->getStyleId(),
								'groupid' => $varObj->getGroupId(),
								'fragmentName' => $_POST['find'][$fragid],
								'fragmentVarName' => $_POST['find'][$fragid],
								'fragmentType' => 'variable',
								'fragment' => $_POST['replace'][$fragid],
								'defaultid' => $varObj->getDefaultId()
							);

					StyleFragment::insert($insert);
				}
			}
		}

		// add anything?
		if(!empty($_POST['add']['find'])) {
			$insert = Array(
						'styleid' => $styleObj->getStyleId(),
						'groupid' => 0,
						'fragmentName' => $_POST['add']['find'],
						'fragmentVarName' => $_POST['add']['find'],
						'fragmentType' => 'variable',
						'fragment' => $_POST['add']['replace'],
						'defaultid' => -1
					);

			$lastId = StyleFragment::insert($insert);

			$tempVar = new StyleFragment($lastId);
			$tempVar->update(Array('defaultid' => $lastId));
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=style&amp;repVars=' . $styleObj->getStyleId());
	}

	$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator(), true);

	new AdminHTML('header', $lang['admin_style_repVars'] . ': ' . $styleObj->getName(), true, Array('form' => true));

	$keyBox = "\t\t\t" . '<ul class="noBullets">' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="custom">' . $lang['admin_style_key_red'] . '</li>' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="inherit">' . $lang['admin_style_key_green'] . '</li>' . "\n";
	$keyBox .= "\t\t\t" . '</ul>' . "\n";

	new AdminHTML('divitBox', Array(
								'title' => $lang['admin_style_key'],
								'content' => $keyBox
							), true);

	new AdminHTML('tableBegin', $lang['admin_style_man'], true, Array('form' => false, 'colspan' => 2));

	foreach($styleIter as $style) {
		$optionsObj = new AdminHTML('locationSelect', '', false, Array(
																	'locs' => array_str_replace('!@#$%', $style->getStyleId(), $styleLocations),
																	'return' => true,
																	'name' => $style->getStyleId(),
																	'noForm' => true
																));

		$options = $optionsObj->dump();

		$cells = Array(
				str_repeat('-- ', $styleIter->getDepth()) . '<a href="admin.php?file=style&amp;repVars=' . $style->getStyleId() . '">' . $style->getName() . '</a>' => Array('th' => true, 'class' => 'noAlt left'),
				$options => Array('th' => true, 'class' => 'noAlt right noBorderLeft')
			);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));

		if($styleObj->getStyleId() == $style->getStyleId()) {
			$contents = ''; $fieldBits = '';

			$thCells = Array(
							$lang['admin_style_repVars_find'] => Array('th' => true),
							$lang['admin_style_repVars_replace'] => Array('th' => true)
						);

			$tabBegin = new AdminHTML('tableBegin', $lang['admin_style_repVars_add'], false, Array('form' => false, 'colspan' => 2, 'return' => true));

			$thObj = new AdminHTML('tableCells', '', false, Array('cells' => $thCells, 'return' => true));

			$addCells = Array(
							'<input type="text" class="text" name="add[find]" />' => Array('class' => 'center'),
							'<input type="text" class="text" name="add[replace]" />' => Array('class' => 'center')
						);

			$addObj = new AdminHTML('tableCells', '', false, Array('cells' => $addCells, 'return' => true));

			$tabEnd = new AdminHTML('tableEnd', '', false, Array('form' => -1, 'colspan' => 2, 'return' => true));

			$contents .= '<p>' . $lang['admin_style_repVars_effect'] . '</p>';

			$contents .= '<div class="moreMarTop">' . $tabBegin->dump() . $thObj->dump() . $addObj->dump() . $tabEnd->dump();

			if(count($vars)) {
				$thCells[$lang['admin_delete']] = Array('th' => true);

				$tabBegin = new AdminHTML('tableBegin', $lang['admin_style_repVars'], false, Array('form' => false, 'colspan' => 3, 'return' => true));

				$thObj = new AdminHTML('tableCells', '', false, Array('cells' => $thCells, 'return' => true));

				foreach($vars as $groupid => $more) {
					foreach($more as $fragid => $varObj) {
						// what type are we?
						$varType = 'custom';

						if($fragIds[$varObj->getDefaultId()]['type'] == 'inherit') {
							$varType = 'inherit';
						}

						$editCells = Array(
										'<input type="text" class="text ' . $varType . '" name="find[' . $fragid . ']" value="' . wtcspecialchars($varObj->getVarName()) . '" />' => Array('class' => 'center'),
										'<input type="text" class="text ' . $varType . '" name="replace[' . $fragid . ']" value="' . wtcspecialchars($varObj->getFragment()) . '" />' => Array('class' => 'center'),
										(($varType == 'inherit') ? '<strong class="inherit">' . $lang['admin_style_repVars_cannotRevert'] . '</strong>' : '<label for="revert_' . $fragid . '"><input type="checkbox" name="revert[' . $fragid . ']" value="1" id="revert_' . $fragid . '" /> <strong>' . $lang['admin_delete'] . '</strong></label>') => Array('class' => 'center')
									);

						$fieldObj = new AdminHTML('tableCells', '', false, Array('cells' => $editCells, 'return' => true));

						$fieldBits .= $fieldObj->dump();
					}
				}

				$tabEnd = new AdminHTML('tableEnd', '', false, Array('form' => -1, 'colspan' => 3, 'return' => true));

				$contents .= $tabBegin->dump() . $thObj->dump() . $fieldBits . $tabEnd->dump();
			}

			$contents .= '</div>';

			new AdminHTML('tableCells', '', true, Array('cells' => Array($contents => Array('colspan' => 2, 'class' => 'noAlt'))));
		}
	}

	new AdminHTML('tableEnd', '', true, Array('form' => false, 'colspan' => 2));

	new AdminHTML('footer', '', true, Array('form' => true));
}

// visual settings
else if(isset($_GET['visual'])) {
	// create style obj...
	$styleObj = new Style($_GET['visual']);
	$fragIds = $styleObj->getFragmentIds();

	// get all our settings...
	$settings = $styleObj->buildFragments('option');

	// update settings
	if($_POST['formSet'] AND is_array($_POST['setting'])) {
		foreach($settings as $groupid => $more) {
			foreach($more as $fragid => $settingObj) {
				// revert?
				if($_POST['revert_setting'][$fragid]) {
					$settingObj->destroy(true);
					continue;
				}

				// not set or unchanged... forget about it
				if(!isset($_POST['setting'][$fragid]) OR $_POST['setting'][$fragid] == $settingObj->getFragment()) {
					continue;
				}

				// just update... but what to do, insert or update?
				if((!$settingObj->getDefaultId() AND DEV) OR ($settingObj->getDefaultId() AND $styleObj->getStyleId() == $settingObj->getStyleId())) {
					$settingObj->update(Array('fragment' => $_POST['setting'][$fragid]));

				}

				// insert a new template...
				else {
					$insert = Array(
								'styleid' => $styleObj->getStyleId(),
								'groupid' => $settingObj->getGroupId(),
								'fragmentName' => $settingObj->getName(),
								'fragmentVarName' => $settingObj->getVarName(),
								'fragmentType' => 'option',
								'fragment' => $_POST['setting'][$fragid],
								'defaultid' => ((!$settingObj->getDefaultId()) ? $settingObj->getFragmentId() : $settingObj->getDefaultId())
							);

					StyleFragment::insert($insert);
				}
			}
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=style&amp;visual=' . $styleObj->getStyleId());
	}

	$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator(), true);

	new AdminHTML('header', $lang['admin_style_visual'] . ': ' . $styleObj->getName(), true, Array('form' => true));

	$keyBox = "\t\t\t" . '<ul class="noBullets">' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="default">' . $lang['admin_style_key_blue'] . '</li>' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="custom">' . $lang['admin_style_key_red'] . '</li>' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="inherit">' . $lang['admin_style_key_green'] . '</li>' . "\n";
	$keyBox .= "\t\t\t" . '</ul>' . "\n";

	new AdminHTML('divitBox', Array(
								'title' => $lang['admin_style_key'],
								'content' => $keyBox
							), true);

	new AdminHTML('tableBegin', $lang['admin_style_man'], true, Array('form' => false, 'colspan' => 2));

	foreach($styleIter as $style) {
		$optionsObj = new AdminHTML('locationSelect', '', false, Array(
																	'locs' => array_str_replace('!@#$%', $style->getStyleId(), $styleLocations),
																	'return' => true,
																	'name' => $style->getStyleId(),
																	'noForm' => true
																));

		$options = $optionsObj->dump();

		$cells = Array(
				str_repeat('-- ', $styleIter->getDepth()) . '<a href="admin.php?file=style&amp;visual=' . $style->getStyleId() . '">' . $style->getName() . '</a>' => Array('th' => true, 'class' => 'noAlt left'),
				$options => Array('th' => true, 'class' => 'noAlt right noBorderLeft')
			);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));

		if($styleObj->getStyleId() == $style->getStyleId()) {
			$contents = ''; $fieldBits = '';

			$tabBegin = new AdminHTML('tableBegin', $lang['admin_style_visual'], false, Array('form' => false, 'colspan' => 2, 'return' => true));

			foreach($settings as $groupid => $more) {
				foreach($more as $fragid => $settingObj) {
					// what type are we?
					$settingType = 'custom';

					if(!$settingObj->getDefaultId()) {
						$settingType = 'default';
					}

					else if($fragIds[$settingObj->getDefaultId()]['type'] == 'inherit') {
						$settingType = 'inherit';
					}

					$fieldObj = new AdminHTML('tableRow', Array(
												'title' => $lang['admin_style_v_' . $settingObj->getVarName()],
												'desc' => '',
												'type' => ((strpos($settingObj->getVarName(), 'Color') !== false) ? 'textColor' : 'text'),
												'name' => 'setting[' . $settingObj->getFragmentId() . ']',
												'value' => $settingObj->getFragment(),
												'class' => ' ' . $settingType,
												'addRevert' => ($settingType != 'inherit' AND $settingObj->getDefaultId()) ? true : false
											), false, Array('return' => true));

					$fieldBits .= $fieldObj->dump();
				}
			}

			$tabEnd = new AdminHTML('tableEnd', '', false, Array('form' => -1, 'colspan' => 2, 'return' => true));

			$contents .= '<div class="moreMarTop">' . $tabBegin->dump() . $fieldBits . $tabEnd->dump() . '</div>';

			new AdminHTML('tableCells', '', true, Array('cells' => Array($contents => Array('colspan' => 2, 'class' => 'noAlt'))));
		}
	}

	new AdminHTML('tableEnd', '', true, Array('form' => false, 'colspan' => 2));

	new AdminHTML('footer', '', true, Array('form' => true));
}

// image names
else if(isset($_GET['images'])) {
	// create style obj...
	$styleObj = new Style($_GET['images']);
	$fragIds = $styleObj->getFragmentIds();

	// get all our image names...
	$imageNames = $styleObj->buildFragments('imageName');

	// update settings
	if($_POST['formSet'] AND is_array($_POST['images'])) {
		foreach($imageNames as $groupid => $more) {
			foreach($more as $fragid => $imagesObj) {
				// revert?
				if($_POST['revert_images'][$fragid]) {
					$imagesObj->destroy(true);
					continue;
				}

				// not set or unchanged... forget about it
				if(/*!isset($_POST['images'][$fragid]) OR */$_POST['images'][$fragid] == $imagesObj->getFragment()) {
					continue;
				}

				// just update... but what to do, insert or update?
				if((!$imagesObj->getDefaultId() AND DEV) OR ($imagesObj->getDefaultId() AND $styleObj->getStyleId() == $imagesObj->getStyleId())) {
					$imagesObj->update(Array('fragment' => $_POST['images'][$fragid]));

				}

				// insert a new template...
				else {
					$insert = Array(
								'styleid' => $styleObj->getStyleId(),
								'groupid' => $imagesObj->getGroupId(),
								'fragmentName' => $imagesObj->getName(),
								'fragmentVarName' => $imagesObj->getVarName(),
								'fragmentType' => 'imageName',
								'fragment' => $_POST['images'][$fragid],
								'defaultid' => ((!$imagesObj->getDefaultId()) ? $imagesObj->getFragmentId() : $imagesObj->getDefaultId())
							);

					StyleFragment::insert($insert);
				}
			}
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=style&amp;images=' . $styleObj->getStyleId());
	}

	$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator(), true);

	new AdminHTML('header', $lang['admin_style_images'] . ': ' . $styleObj->getName(), true, Array('form' => true));

	$keyBox = "\t\t\t" . '<ul class="noBullets">' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="default">' . $lang['admin_style_key_blue'] . '</li>' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="custom">' . $lang['admin_style_key_red'] . '</li>' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="inherit">' . $lang['admin_style_key_green'] . '</li>' . "\n";
	$keyBox .= "\t\t\t" . '</ul>' . "\n";

	new AdminHTML('divitBox', Array(
								'title' => $lang['admin_style_key'],
								'content' => $keyBox
							), true);

	new AdminHTML('tableBegin', $lang['admin_style_man'], true, Array('form' => false, 'colspan' => 2));

	foreach($styleIter as $style) {
		$optionsObj = new AdminHTML('locationSelect', '', false, Array(
																	'locs' => array_str_replace('!@#$%', $style->getStyleId(), $styleLocations),
																	'return' => true,
																	'name' => $style->getStyleId(),
																	'noForm' => true
																));

		$options = $optionsObj->dump();

		$cells = Array(
				str_repeat('-- ', $styleIter->getDepth()) . '<a href="admin.php?file=style&amp;images=' . $style->getStyleId() . '">' . $style->getName() . '</a>' => Array('th' => true, 'class' => 'noAlt left'),
				$options => Array('th' => true, 'class' => 'noAlt right noBorderLeft')
			);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));

		if($styleObj->getStyleId() == $style->getStyleId()) {
			$contents = ''; $fieldBits = '';

			$tabBegin = new AdminHTML('tableBegin', $lang['admin_style_images'], false, Array('form' => false, 'colspan' => 2, 'return' => true));

			foreach($imageNames as $groupid => $more) {
				foreach($more as $fragid => $imagesObj) {
					// what type are we?
					$imagesType = 'custom';

					if(!$imagesObj->getDefaultId()) {
						$imagesType = 'default';
					}

					else if($fragIds[$imagesObj->getDefaultId()]['type'] == 'inherit') {
						$imagesType = 'inherit';
					}

					$fieldObj = new AdminHTML('tableRow', Array(
												'title' => $lang['admin_style_i_' . $imagesObj->getVarName()],
												'desc' => '',
												'type' => 'text',
												'name' => 'images[' . $imagesObj->getFragmentId() . ']',
												'value' => $imagesObj->getFragment(),
												'class' => ' ' . $imagesType,
												'addRevert' => ($imagesType != 'inherit' AND $imagesObj->getDefaultId()) ? true : false
											), false, Array('return' => true));

					$fieldBits .= $fieldObj->dump();
				}
			}

			$tabEnd = new AdminHTML('tableEnd', '', false, Array('form' => -1, 'colspan' => 2, 'return' => true));

			$contents .= '<p>' . $lang['admin_style_images_desc'] . '</p>';

			$contents .= '<div class="moreMarTop">' . $tabBegin->dump() . $fieldBits . $tabEnd->dump() . '</div>';

			new AdminHTML('tableCells', '', true, Array('cells' => Array($contents => Array('colspan' => 2, 'class' => 'noAlt'))));
		}
	}

	new AdminHTML('tableEnd', '', true, Array('form' => false, 'colspan' => 2));

	new AdminHTML('footer', '', true, Array('form' => true));
}

// view style colors
else if(isset($_GET['colors'])) {
	// create style obj...
	$styleObj = new Style($_GET['colors']);
	$colorObj = false;
	$fragIds = $styleObj->getFragmentIds();

	// get all our colors...
	$colors = $styleObj->buildFragments('style');

	// build our select menu...
	$colorTemps = Array();
	$selection = '';

	foreach($colors as $groupid => $more) {
		foreach($more as $fragid => $obj) {
			if(!$colorObj) {
				$colorObj = $obj;
			}

			if(!$obj->getDefaultId()) {
				$type = 'default';
			}

			else if($fragIds[$obj->getDefaultId()]['type'] == 'inherit') {
				$type = 'inherit';
			}

			else {
				$type = 'custom';
			}

			$colorTemps['admin.php?file=style&amp;colors=' . $styleObj->getStyleId() . '&amp;t=' . $obj->getFragmentId() . '" class="' . $type] = $lang['admin_style_g_' . $obj->getVarName()];

			// get our color obj while we're at it...
			if(isset($_GET['t']) AND $_GET['t'] == $obj->getFragmentId()) {
				$colorObj = $obj;
				$selection = $lang['admin_style_g_' . $obj->getVarName()];
			}
			
			// never default to "advanced" or any other less important style fragment
			if(empty($_GET['t']) && $obj->getVarName() == 'body') {
				$colorObj = $obj;
				$selection = $lang['admin_style_g_' . $obj->getVarName()];
			}
		}
	}

	$advanced = ($colorObj->getVarName() == 'advanced');
	
	$test = $colorObj->getFragment();
	$colValues = unserialize($test);

	$colorType = 'custom';

	if(!$colorObj->getDefaultId()) {
		$colorType = 'default';
	}

	else if($fragIds[$colorObj->getDefaultId()]['type'] == 'inherit') {
		$colorType = 'inherit';
	}

	// update CSS!
	if($_POST['formSet'] AND is_array($_POST['css'])) {
		// revert?
		if($_POST['revert']) {
			new Redirect('admin.php?file=style&delTemplate=' . $colorObj->getFragmentId());
		}

		// just serialize... but what to do, insert or update?
		if((!$colorObj->getDefaultId() AND DEV) OR ($colorObj->getDefaultId() AND $styleObj->getStyleId() == $colorObj->getStyleId())) {
			$colorObj->update(Array('fragment' => serialize($_POST['css'])));
			$tid = $colorObj->getFragmentId();
		}

		// insert a new template...
		else {
			$insert = Array(
						'styleid' => $styleObj->getStyleId(),
						'groupid' => $colorObj->getGroupId(),
						'fragmentName' => $colorObj->getName(),
						'fragmentVarName' => $colorObj->getVarName(),
						'fragmentType' => 'style',
						'fragment' => serialize($_POST['css']),
						'defaultid' => ((!$colorObj->getDefaultId()) ? $colorObj->getFragmentId() : $colorObj->getDefaultId())
					);

			$tid = StyleFragment::insert($insert);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=style&amp;colors=' . $styleObj->getStyleId() . '&amp;t=' . $tid);
	}

	// check to see if it should include links...
	$noLinks = Array('button' => '', 'radioCheck' => '', 'selectMenu' => '', 'smallFont' => '', 'textInput' => '', 'timeFont' => '');

	if(!$advanced)
	{
		// set our different sub-sections
		$sections = Array(
						'main' => 'admin_style_c_main', 'regLink' => 'admin_style_c_regLink',
						'visitLink' => 'admin_style_c_visitLink', 'hoverLink' => 'admin_style_c_hoverLink',
						'extra' => 'admin_style_c_extra'
					);
	}
	else
	{
		$sections = Array('extra' => 'admin_style_c_extra');	
	}

	// now set our fields...
	$fields = Array(
					'bgColor' => 'admin_style_c_bgColor', 'fontColor' => 'admin_style_c_fontColor',
					'fontFamily' => 'admin_style_c_fontFamily', 'fontSize' => 'admin_style_c_fontSize',
					'fontStyle' => 'admin_style_c_fontStyle', 'fontWeight' => 'admin_style_c_fontWeight',
					'textDec' => 'admin_style_c_textDec', 'advanced_extra' => 'admin_style_c_advanced_extra'
				);

	$colorSectionsObj = new AdminHTML('locationSelect', '', false, Array(
																	'locs' => $colorTemps,
																	'return' => true,
																	'name' => $styleObj->getStyleId() . '_color',
																	'noForm' => true,
																	'select' => $selection
																));

	$colorSections = $colorSectionsObj->dump();

	$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator(), true);

	new AdminHTML('header', $lang['admin_style_colors'] . ': ' . $styleObj->getName(), true, Array('form' => true));

	print('<script type="text/javascript" src="./scripts/Tabs.js"></script>' . "\n\n");

	$keyBox = "\t\t\t" . '<ul class="noBullets">' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="default">' . $lang['admin_style_key_blue'] . '</li>' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="custom">' . $lang['admin_style_key_red'] . '</li>' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="inherit">' . $lang['admin_style_key_green'] . '</li>' . "\n";
	$keyBox .= "\t\t\t" . '</ul>' . "\n";

	new AdminHTML('divitBox', Array(
								'title' => $lang['admin_style_key'],
								'content' => $keyBox
							), true);

	new AdminHTML('tableBegin', $lang['admin_style_man'], true, Array('form' => false, 'colspan' => 2));

	foreach($styleIter as $style) {
		$optionsObj = new AdminHTML('locationSelect', '', false, Array(
																	'locs' => array_str_replace('!@#$%', $style->getStyleId(), $styleLocations),
																	'return' => true,
																	'name' => $style->getStyleId(),
																	'noForm' => true
																));

		$options = $optionsObj->dump();

		$cells = Array(
				str_repeat('-- ', $styleIter->getDepth()) . '<a href="admin.php?file=style&amp;colors=' . $style->getStyleId() . '">' . $style->getName() . '</a>' => Array('th' => true, 'class' => 'noAlt left'),
				$options => Array('th' => true, 'class' => 'noAlt right noBorderLeft')
			);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));

		if($styleObj->getStyleId() == $style->getStyleId()) {
			$contents = '';

			// revert?
			if($colorObj->getDefaultId() AND $styleObj->getStyleId() == $colorObj->getStyleId()) {
				$contents .= '<div class="floatLeft">';
					$contents .= '<label for="revert"><input type="checkbox" name="revert" value="1" id="revert" /> <strong>' . $lang['admin_style_revert'] . '</strong></label>';
				$contents .= '</div>';
			}

			// get our page sections...
			$contents .= '<div class="floatRight right" style="width: 310px;">';
				$contents .= '<strong>' . $lang['admin_style_colors_cssCat'] . '</strong> ' . $colorSections;
				$contents .= '<p class="right small">' . $lang['admin_style_colors_note'] . '</p>';
			$contents .= '</div>' . "\n\n";

			$contents .= '<div class="spacer marBot"></div>' . "\n\n";

			$contents .= '<ul class="tabs' . ((isset($noLinks[$colorObj->getVarName()])) ? ' fewer' : '') . '">' . "\n";

			foreach($sections as $name => $langName) {
				if(strpos($name, 'Link') !== false AND isset($noLinks[$colorObj->getVarName()])) {
					continue;
				}

				$contents .= '<li><a href="javascript:void(0);" id="' . $name . '">' . $lang[$langName] . '</a></li>' . "\n";
			}

			$contents .= '</ul> <div class="spacer"></div>' . "\n\n";

			foreach($sections as $name => $langName) {
				if(strpos($name, 'Link') !== false AND isset($noLinks[$colorObj->getVarName()])) {
					continue;
				}

				$tabBegin = new AdminHTML('tableBegin', $lang['admin_style_g_' . $colorObj->getVarName()], false, Array('form' => false, 'colspan' => 2, 'return' => true, 'class' => $colorType, 'tableClass' => '" id="' . $name . '_table'));

				if($name != 'extra') {
					$fieldBits = '';

					foreach($fields as $var => $langVar) {
						$fieldObj = new AdminHTML('tableRow', Array(
																'title' => $lang[$langVar],
																'desc' => '',
																'type' => ((strpos($var, 'Color') !== false) ? 'textColor' :
																	((substr($var, 0, 8) == 'advanced') ? 'advanced' : 'text')),
																'name' => 'css[' . $name . '_' . $var . ']',
																'value' => $colValues[$name . '_' . $var],
																'class' => ' ' . $colorType
															), false, Array('return' => true));

						$fieldBits .= $fieldObj->dump();
					}

					AdminHTML::switchAlt();
				}

				else {
					$fieldObj = new AdminHTML('bigTextarea', Array(
																'title' =>
																	($advanced ? $lang['admin_style_colors_advancedNote'] : $lang['admin_style_colors_extraNote']),
																'name' => 'css[extra]',
																'value' => $colValues['extra'],
																'class' => ' ' . $colorType
															), false, Array('return' => true));

					$fieldBits = $fieldObj->dump();
				}

				$tabEnd = new AdminHTML('tableEnd', '', false, Array('form' => -1, 'colspan' => 2, 'return' => true));

				$contents .= '<div>' . $tabBegin->dump() . $fieldBits . $tabEnd->dump() . '</div>';
			}

			new AdminHTML('tableCells', '', true, Array('cells' => Array($contents => Array('colspan' => 2, 'class' => 'noAlt'))));
		}
	}

	new AdminHTML('tableEnd', '', true, Array('form' => false, 'colspan' => 2));

	new AdminHTML('footer', '', true, Array('form' => true));
}

// view templates
else if(isset($_GET['templates'])) {
	// create style obj...
	$styleObj = new Style($_GET['templates']);
	$fragIds = $styleObj->getFragmentIds();
	$myFragIds = '';

	// get all our templates...
	$templates = $styleObj->buildFragments('template');

	// initiate some stuff
	$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator(), true);
	$groupIter = new RecursiveIteratorIterator(new RecursiveGroupIterator('styles_fragments'), true);
	$toPrint = Array();
	$prevDepth = -1;

	$results = NULL;

	// searching? we need to get matchids!
	if($_GET['go'] == 'search') {
		if(is_array($fragIds)) {
			foreach($fragIds as $vals) {
				$myFragIds .= $before . $vals['fragmentid'];
				$before = ',';
			}
		}

		// uh oh?
		if(empty($myFragIds)) {
			$myFragIds = 0;
		}

		$search = new Query($query['styles_fragments']['search'], Array(1 => $myFragIds, '%', $_GET['query'], $_GET['query']));

		// nuttin!
		if(!$wtcDB->numRows($search)) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		// alrighty... loop through and put results into array
		while($result = $wtcDB->fetchArray($search)) {
			$results[$result['groupid']][$result['fragmentid']] = new StyleFragment('', $result);
		}
	}

	new AdminHTML('header', $lang['admin_style_templates_man'] . ' ' . $styleObj->getName(), true, Array('form' => true));

	$keyBox = "\t\t\t" . '<ul class="noBullets">' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="default">' . $lang['admin_style_key_blue'] . '</li>' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="custom">' . $lang['admin_style_key_red'] . '</li>' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="inherit">' . $lang['admin_style_key_green'] . '</li>' . "\n";
	$keyBox .= "\t\t\t" . '</ul>' . "\n";

	new AdminHTML('divitBox', Array(
								'title' => $lang['admin_style_key'],
								'content' => $keyBox
							), true);

	new AdminHTML('tableBegin', $lang['admin_style_man'], true, Array('form' => false, 'colspan' => 2));

	foreach($styleIter as $style) {
		$optionsObj = new AdminHTML('locationSelect', '', false, Array(
																	'locs' => array_str_replace('!@#$%', $style->getStyleId(), $styleLocations),
																	'return' => true,
																	'name' => $style->getStyleId(),
																	'noForm' => true
																));

		$options = $optionsObj->dump();

		$cells = Array(
				str_repeat('-- ', $styleIter->getDepth()) . '<a href="admin.php?file=style&amp;templates=' . $style->getStyleId() . '">' . $style->getName() . '</a>' => Array('th' => true, 'class' => 'noAlt left'),
				$options => Array('th' => true, 'class' => 'noAlt right noBorderLeft')
			);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));

		if($styleObj->getStyleId() == $style->getStyleId()) {
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

				$extraLink = '&amp;groupid=' . $obj->getGroupId() . '#' . $obj->getGroupId();

				if($_GET['go'] == 'search') {
					$isSibling = $obj->isSibling($results);
					$isAuntOrUncle = $obj->isAuntOrUncle($results);
					$isParent = $obj->isParent($results);
					$isChild = $obj->isChild($results);
				}

				else {
					$isSibling = $obj->isSibling($_GET['groupid']);
					$isAuntOrUncle = $obj->isAuntOrUncle($_GET['groupid']);
					$isParent = $obj->isParent($_GET['groupid']);
					$isChild = $obj->isChild($_GET['groupid']);
				}

				if(!$groupIter->getDepth() OR $isSibling OR $isAuntOrUncle OR $isParent OR $isChild) {
					if(!$groupIter->getDepth() AND ($obj->getGroupId() == $_GET['groupid'] OR $isChild)) {
						$extraLink = '';
					}

					else if(($isChild OR $obj->getGroupId() == $_GET['groupid']) AND $groupIter->getDepth()) {
						$extraLink = '&amp;groupid=' . $obj->getParentId() . '#' . $obj->getParentId();
					}

					$opts = Array(
						'cells' => Array(
										str_repeat('-- ', $styleIter->getDepth() + 1) . str_repeat('-- ', $groupIter->getDepth()) . '<a href="admin.php?file=style&amp;templates=' . $_GET['templates'] . $extraLink . '" name="' . $obj->getGroupId() . '">' . $obj->getGroupName() . '</a>' => Array('class' => 'header'),
										'<a href="admin.php?file=style&amp;do=addTemplate&amp;groupid=' . $obj->getGroupId() . '">' . $lang['admin_add'] . '</a> - <a href="admin.php?file=style&amp;editGroup=' . $obj->getGroupId() . '">' . $lang['admin_edit'] . '</a>' => Array('small' => true, 'class' => 'header')
								)
							);

					new AdminHTML('tableCells', '', true, $opts);

					if(is_array($templates[$obj->getGroupId()]) AND ($_GET['go'] == 'search' OR $obj->getGroupId() == $_GET['groupid'] OR $isChild)) {
						foreach($templates[$obj->getGroupId()] as $fragid => $tempObj) {
							// search query already ran!
							if($_GET['go'] == 'search' AND !isset($results[$obj->getGroupId()][$fragid])) {
								continue;
							}

							$class = ''; $delete = '';

							$delete = ' - <a href="admin.php?file=style&amp;delTemplate=' . $fragid . '">' . $lang['admin_delete'] . '</a>';

							if($tempObj->getDefaultId() != 0) {
								if($fragIds[$tempObj->getDefaultId()]['type'] == 'inherit') {
									$class = ' class="inherit"';
								}

								else {
									$class = ' class="custom"';
								}

								$delete = ' - <a href="admin.php?file=style&amp;delTemplate=' . $fragid . '">' . $lang['admin_delete'] . '</a>';

								if($tempObj->getDefaultId() != -1) {
									$delete .= ' - <a href="admin.php?file=style&amp;viewDefault=' . $tempObj->getDefaultId() . '&amp;customid=' . $fragid . '">' . $lang['admin_viewDefault'] . '</a>';
								}
							}

							if(!$tempObj->getDefaultId() OR $styleObj->getStyleId() != $tempObj->getStyleId()) {
								$addStyleid = '&amp;s=' . $styleObj->getStyleId();
							}

							$opts = Array(
								'cells' => Array(
												str_repeat('-- ', $styleIter->getDepth() + 1) . str_repeat('-- ', $groupIter->getDepth() + 1) . '<a href="admin.php?file=style&amp;editTemplate=' . $fragid . $addStyleid . '" onclick="window.open(\'admin.php?file=style&amp;windowEdit=' . $fragid . $addStyleid . '\', \'windowEdit' . $fragid . '\', \'height=500, width=700, resizable=yes\'); return false;"' . $class . '>' . $tempObj->getVarName() . '</a>' => Array('class' => 'noAlt'),
												'<a href="admin.php?file=style&amp;editTemplate=' . $fragid . $addStyleid . '">' . $lang['admin_edit'] . '</a>' . $delete => Array('small' => true, 'class' => 'noAlt')
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
		}
	}

	new AdminHTML('tableEnd', '', true, Array('form' => false, 'colspan' => 2));

	new AdminHTML('footer', '', true, Array('form' => true));
}

// style manager
else {
	// update display order?
	if(is_array($_POST['disOrders'])) {
		// only update if display order is different...
		foreach($_POST['disOrders'] as $styleid => $newOrder) {
			if($styles[$styleid]->getDisOrder() != $newOrder) {
				if(!is_numeric($newOrder) OR $newOrder < 1) {
					$newOrder = 1;
				}

				$styles[$styleid]->update(Array('disOrder' => $newOrder));
			}
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=style');
	}

	// initialize iterator
	$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator(), true);

	new AdminHTML('header', $lang['admin_style_man'], true, Array('form' => true));

	$thCells = Array(
					$lang['admin_style_man_name'] => Array('th' => true),
					$lang['admin_style_man_disOrder'] => Array('th' => true),
					$lang['admin_options'] => Array('th' => true)
				);

	new AdminHTML('tableBegin', $lang['admin_style_man'], true, Array('form' => 0, 'colspan' => 3));

	foreach($styleIter as $count => $style) {
		// if depth is one... start new table...
		if(($styleIter->getDepth() + 1) == 1) {
			new AdminHTML('tableCells', '', true, Array('cells' => $thCells));
		}

		$optionsObj = new AdminHTML('locationSelect', '', false, Array(
																	'locs' => array_str_replace('!@#$%', $style->getStyleId(), $styleLocations),
																	'return' => true,
																	'name' => $style->getStyleId(),
																	'noForm' => true
																));

		$options = $optionsObj->dump();

		$cells = Array(
				str_repeat('-- ', $styleIter->getDepth()) . '<a href="admin.php?file=style&amp;templates=' . $style->getStyleId() . '">' . $style->getName() . '</a>' => Array(),
				'<input type="text" class="text less" name="disOrders[' . $style->getStyleId() . ']" value="' . $style->getDisOrder() . '" />' => Array(),
				$options => Array()
			);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}

	new AdminHTML('tableEnd', '', true, Array('form' => 0, 'colspan' => 3, 'footerText' => '<a href="admin.php?file=style&amp;do=add">' . $lang['admin_style_add'] . '</a>&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="' . $lang['admin_style_man_saveDis'] . '" />'));

	new AdminHTML('footer', '', true, Array('form' => true));
}

// This function will read a template's complete fragment database and re-generate the PHP version of each fragment
// TODO: OK this is weird but it seems that there isn't much styleid management happening here...all fragments are considered
// parts of all styles. Maybe I do not understand styles yet...
function fixPHP()
{
global $lang, $query, $wtcDB;

	if(empty($_GET['fixphp']))
		new WtcBBException($lang['admin_error_notEnoughInfo']);
	$templateid = $_GET['fixphp'];
	
	$search = new Query($query['styles_fragments']['get_all_ids'], array(1 => 'template'));
	
	// nuttin!
	if(!$wtcDB->numRows($search)) {
		new WtcBBException($lang['admin_error_noResults']);
	}

	// alrighty... loop through and put results into array
	while($result = $wtcDB->fetchArray($search)) {
		$fragmentObj = new StyleFragment($result['fragmentid']);
		$updateData = array('template_php' => StyleFragment::parseTemplate($fragmentObj->getFragment()));
		$fragmentObj->update($updateData);
	}
	
	return true;
}

?>