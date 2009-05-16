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
## ****************** wtcBB CRON ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-FORUMS');
define('FILE_ACTION', 'Forums/Moderators');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

if($_GET['do'] == 'addForum' OR isset($_GET['editForum'])) {
	if($_GET['do'] == 'addForum') {
		$which = 'add';

		$editinfo = Array(
						'disOrder' => 1, 'viewAge' => 0, 'parent' => -1,
						'isCat' => 0, 'isAct' => 1, 'countPosts' => 1
					);
	}

	else {
		$which = 'edit';

		// instantiate forum obj
		$forumObj = new Forum($_GET['editForum']);

		$editinfo = $forumObj->info;
	}

	if($_POST['formSet']) {
		if($which == 'add') {
			// insert forum...
			Forum::insert($_POST['forum']);
		}

		else {
			// make sure we aren't making this a child of a child forum...
			// need to do some directSubs editing too, if parent changes
			if($_POST['forum']['parent'] != $editinfo['parent']) {
				// or if same forum...
				if($_POST['forum']['parent'] == $editinfo['forumid']) {
					new WtcBBException($lang['admin_error_childOfChild']);
				}

				// iter through childs...
				$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator($editinfo['forumid']), true);

				foreach($forumIter as $forum) {
					// whaa??!!
					if($forum->info['forumid'] == $_POST['forum']['parent']) {
						new WtcBBException($lang['admin_error_childOfChild']);
					}
				}

				// only if we had a previous parent...
				if(isset($forums[$editinfo['parent']])) {
					$prevParentSubs = $forums[$editinfo['parent']]->info['directSubs'];

					// get rid of forumid in old parent subs...
					if(is_array($prevParentSubs)) {
						foreach($prevParentSubs as $index => $forumid) {
							if($forumid == $editinfo['forumid']) {
								unset($prevParentSubs[$index]);
							}
						}

						// reupdate...
						$forums[$editinfo['parent']]->update(Array('directSubs' => (!count($prevParentSubs) ? '' : serialize($prevParentSubs))));
					}
				}

				// only if new parent exists...
				if(isset($forums[$_POST['forum']['parent']])) {
					$newParentSubs = $forums[$_POST['forum']['parent']]->info['directSubs'];

					// tack it on...
					$newParentSubs[] = $editinfo['forumid'];

					// update
					$forums[$_POST['forum']['parent']]->update(Array('directSubs' => (!count($newParentSubs) ? '' : serialize($newParentSubs))));
				}

				// new depth...
				$_POST['forum']['depth'] = $forums[$_POST['forum']['parent']]->info['depth'] + 1;

				// lots of things affected by this change...
				// well, if depth has changed...
				if($_POST['forum']['depth'] != $editinfo['depth']) {
					// iter through forums again...
					$forumIter2 = new RecursiveIteratorIterator(new RecursiveForumIterator($editinfo['forumid']), true);

					foreach($forumIter2 as $forum) {
						$forum->update(Array('depth' => ($_POST['forum']['depth'] + ($forumIter2->getDepth() + 1))));
					}
				}
			}

			$forumObj->update($_POST['forum']);
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=forum');
	}

	new AdminHTML('header', $lang['admin_forums_' . $which], true, Array('form' => true));


	// ##### BEGIN: GENERAL INFORMATION ##### \\
	new AdminHTML('tableBegin', $lang['admin_forums_ae_generalInfo'], true, Array('form' => 0));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_ae_name'],
								'desc' => $lang['admin_forums_ae_name_desc'],
								'type' => 'text',
								'name' => 'forum[name]',
								'value' => $editinfo['name']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_ae_desc'],
								'desc' => $lang['admin_forums_ae_desc_desc'],
								'type' => 'textarea',
								'name' => 'forum[description]',
								'value' => $editinfo['description']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_ae_order'],
								'desc' => $lang['admin_forums_ae_order_desc'],
								'type' => 'text',
								'name' => 'forum[disOrder]',
								'value' => $editinfo['disOrder']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_ae_viewAge'],
								'desc' => $lang['admin_forums_ae_viewAge_desc'],
								'type' => 'text',
								'name' => 'forum[viewAge]',
								'value' => $editinfo['viewAge']
							), true);

	// get forums
	$forumSelect = Array();
	$forumSelect[$lang['admin_forums_noParent']] = -1;

	// init forum iter
	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

	foreach($forumIter as $forum) {
		$forumSelect[str_repeat('-', $forumIter->getDepth()) . ' ' . $forum->info['name']] = $forum->info['forumid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_ae_parent'],
								'desc' => $lang['admin_forums_ae_parent_desc'],
								'type' => 'select',
								'name' => 'forum[parent]',
								'select' => Array('fields' => $forumSelect, 'select' => (isset($_GET['f']) AND $which == 'add') ? $_GET['f'] : $editinfo['parent'])
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	// ##### END: GENERAL INFORMATION ##### \\


	// ##### BEGIN: CONFIGURATION ##### \\
	new AdminHTML('tableBegin', $lang['admin_forums_ae_config'], true, Array('form' => 0));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_ae_pass'],
								'desc' => $lang['admin_forums_ae_pass_desc'],
								'type' => 'text',
								'name' => 'forum[forumPass]',
								'value' => $editinfo['forumPass']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_ae_link'],
								'desc' => $lang['admin_forums_ae_link_desc'],
								'type' => 'text',
								'name' => 'forum[link]',
								'value' => $editinfo['link']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_ae_count'],
								'desc' => $lang['admin_forums_ae_count_desc'],
								'type' => 'checkbox',
								'name' => 'forum[countPosts]',
								'value' => $editinfo['countPosts']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	// ##### END: CONFIGURATION ##### \\


	// ##### BEGIN: FORUM TYPE ##### \\
	new AdminHTML('tableBegin', $lang['admin_forums_ae_type'], true, Array('form' => 0));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_ae_cat'],
								'desc' => $lang['admin_forums_ae_cat_desc'],
								'type' => 'checkbox',
								'name' => 'forum[isCat]',
								'value' => $editinfo['isCat']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_ae_act'],
								'desc' => $lang['admin_forums_ae_act_desc'],
								'type' => 'checkbox',
								'name' => 'forum[isAct]',
								'value' => $editinfo['isAct']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	// ##### END: FORUM TYPE ##### \\

	new AdminHTML('footer', '', true, Array('form' => true));
}

else if(isset($_GET['deleteForum'])) {
	// create forum obj
	$forumObj = new Forum($_GET['deleteForum']);

	if($_POST) {
		if($_POST['delConfirm']) {
			$forumObj->destroy();
			new Cache('Forums');

			new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=forum');
		}

		else {
			new Redirect('admin.php?file=forum');
		}
	}

	new Delete('', '', '', 'admin.php?file=forum');
}

else if(isset($_GET['deleteMod'])) {
	$modObj = new Moderator($_GET['deleteMod']);
	$modObj->destroy();
}

else if(isset($_GET['removeMod'])) {
	$userObj = new User($_GET['removeMod']);
	new Delete('moderators', 'userid', $userObj->info['userid'], '');

	new Cache('Moderators');

	new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=forum');
}

else if($_GET['do'] == 'block' AND isset($_GET['u'])) {
	// get user
	$userObj = new User($_GET['u']);

	// alright, go through and update the user...
	if($_POST['formSet']) {
		if(is_array($_POST['access'])) {
			// easier reference...
			$blocks = $userObj->info['blockedForums'];

			foreach($_POST['access'] as $forumid => $lvl) {
				// is it already set?
				if(isset($blocks[$forumid])) {
					// unset it?
					if($lvl == -1) {
						unset($blocks[$forumid]);
					}

					// just set level...
					else {
						$blocks[$forumid] = $lvl;
					}
				}

				// new...
				else if($lvl != -1) {
					$blocks[$forumid] = $lvl;
				}
			}

			// update...
			$userObj->update(Array('blockedForums' => ((count($blocks)) ? serialize($blocks) : '')));
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=forum&amp;do=block&amp;u=' . $userObj->info['userid']);
	}

	new AdminHTML('header', $lang['admin_forums_block'], true, Array(
																'form' => true,
																'extra2' => "\t" . '<p class="marBot">' . $lang['admin_forums_block_msg'] . '</p>' . "\n\n"
															));

	new AdminHTML('tableBegin', $lang['admin_forums_block'] . ': ' . $userObj->info['username'], true, Array('form' => false));

	$thCells = Array(
					$lang['admin_forums_man_name'] => Array('th' => true),
					$lang['admin_forums_block_accessLvl'] => Array('th' => true)
				);

	new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

	$allYesNo = new AdminHTML('allYesNo', '', false, Array('return' => true));

	$moreCells = Array(
					'&nbsp;' => Array(),
					$allYesNo->dump() => Array('class' => 'emphasis')
				);

	new AdminHTML('tableCells', '', true, Array('cells' => $moreCells));

	// iter through forums...
	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

	foreach($forumIter as $forum) {
		// which one is checked?
		$checkedYes = ''; $checkedNo = ''; $checkedInherit = ''; $checked = ' checked="checked"';

		if(!isset($userObj->info['blockedForums'][$forum->info['forumid']])) {
			$checkedInherit = $checked;
		}

		else if($userObj->info['blockedForums'][$forum->info['forumid']] == 1) {
			$checkedYes = $checked;
		}

		else if($userObj->info['blockedForums'][$forum->info['forumid']] == 0) {
			$checkedNo = $checked;
		}

		$labels = '<label for="yes' . $forum->info['forumid'] . '"><input type="radio" name="access[' . $forum->info['forumid'] . ']" id="yes' . $forum->info['forumid'] . '"' . $checkedYes . ' value="1" /> ' . $lang['admin_yes'] . '</label>';
		$labels .= '<label for="no' . $forum->info['forumid'] . '"><input type="radio" name="access[' . $forum->info['forumid'] . ']" id="no' . $forum->info['forumid'] . '"' . $checkedNo . ' value="0" /> ' . $lang['admin_no'] . '</label>';
		$labels .= '<label for="inherit' . $forum->info['forumid'] . '"><input type="radio" name="access[' . $forum->info['forumid'] . ']" id="inherit' . $forum->info['forumid'] . '"' . $checkedInherit .' value="-1" /> ' . $lang['admin_inherit'] . '</label>';

		$cells = Array(
					str_repeat('-- ', $forumIter->getDepth()) . '<a href="admin.php?file=forum&amp;editForum=' . $forum->info['forumid'] . '">' . $forum->info['name'] . '</a>' => Array(),
					$labels => Array()
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}

	new AdminHTML('tableEnd', '', true, Array('form' => -1));

	new AdminHTML('footer', '', true, Array('form' => true));
}

else if($_GET['do'] == 'block' AND !isset($_GET['u'])) {
	if($_POST['formSet']) {
		// get user and redirect
		$userObj = new User('', $_POST['username']);

		new Redirect('admin.php?file=forum&do=block&u=' . $userObj->info['userid']);
	}

	new AdminHTML('header', $lang['admin_forums_block'], true, Array('form' => true));

	new AdminHTML('tableBegin', $lang['admin_forums_block'], true, Array('form' => false));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_block_username'],
								'desc' => $lang['admin_forums_block_username_desc'],
								'type' => 'text',
								'name' => 'username',
								'value' => ''
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));

	new AdminHTML('footer', '', true, Array('form' => true));
}

else if($_GET['do'] == 'addMod' OR isset($_GET['editMod'])) {
	if($_GET['do'] == 'addMod') {
		$which = 'add';

		$editinfo = Array(
						'modSubs' => 1, 'canEditPosts' => 1, 'canEditThreads' => 1, 'canEditPolls' => 1,
						'canDelete' => 1, 'canPermDelete' => 0, 'canOpenClose' => 1, 'canMove' => 1,
						'canMerge' => 1, 'canSplit' => 1, 'canIp' => 1, 'modAccess' => 1,
						'modAnnounce' => 1, 'modMassMove' => 0, 'modMassPrune' => 0, 'modProfile' => 1,
						'modBan' => 0, 'modRestore' => 0, 'modSigs' => 0, 'modAvatars' => 0,
						'emailThread' => 0, 'emailPost' => 0, 'modPosts' => 0, 'modThreads' => 0,
						'canStick' => 1
					);
	}

	else {
		$which = 'edit';
		$modObj = new Moderator($_GET['editMod']);
		$editinfo = $modObj->getInfo();

		// if it's an inherited mod, change forumid
		if(isset($_GET['f']) AND $_GET['f'] != $editinfo['forumid']) {
			$editinfo['forumid'] = $_GET['f'];
		}
	}

	if($_POST['formSet']) {
		// insert?
		if($which == 'add') {
			// get our user...
			$userObj = new User('', $_POST['username']);

			// insert for each forum...
			if(!is_array($_POST['forums'])) {
				new WtcBBException($lang['admin_error_selectForum']);
			}

			foreach($_POST['forums'] as $forumid) {
				// make sure we don't already have a mod for this forum...
				// if we do, just continue
				if(isset($solidMods[$forumid][$userObj->info['userid']])) {
					continue;
				}

				$insert = $_POST['mod'];
				$insert['forumid'] = $forumid;
				$insert['userid'] = $userObj->info['userid'];

				Moderator::insert($insert);
			}

			// wants to switch usergroups?
			if($_POST['changeGroup'] > 0) {
				// alright... then lets switch'em!
				$update['usergroupid'] = $_POST['changeGroup'];

				// make sure we aren't already a member...
				if($update['usergroupid'] != $userObj->info['usergroupid'] AND !in_array($update['usergroupid'], ((is_array($userObj->info['secgroupids'])) ? $userObj->info['secgroupids'] : Array()))) {
					$userObj->update($update);
				}
			}
		}

		// update
		else {
			// just... update... what is inherited??
			if(!isset($solidMods[$editinfo['forumid']][$editinfo['userid']])) {
				// add userid!
				$_POST['mod']['userid'] = $modObj->getUserid();

				Moderator::insert($_POST['mod']);
			}

			else {
				$modObj->update($_POST['mod']);
			}
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=forum');
	}

	new AdminHTML('header', $lang['admin_forums_mods_' . $which], true, Array('form' => true));

	if($which == 'edit') {
		$keyBox = "\t\t\t" . '<ul class="noBullets">' . "\n";
			$keyBox .= "\t\t\t\t" . '<li><a href="admin.php?file=forum&amp;deleteMod=' . $editinfo['modid'] . '">' . $lang['admin_delete'] . '</a></li>' . "\n";
			$keyBox .= "\t\t\t\t" . '<li><a href="admin.php?file=user&amp;edit=' . $editinfo['userid'] . '">' . $lang['admin_users_viewInfo'] . '</a></li>' . "\n";
		$keyBox .= "\t\t\t" . '</ul>' . "\n";

		new AdminHTML('divitBox', Array(
									'title' => $lang['admin_options'],
									'content' => $keyBox
								), true);
	}


	// ##### BEGIN: SETUP ##### \\
	new AdminHTML('tableBegin', $lang['admin_forums_mods_ae_setup'], true, Array('form' => false));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_user'],
								'desc' => $lang['admin_forums_mod_ae_user_desc'],
								'type' => (($which == 'add') ? 'text' : 'plainText'),
								'name' => 'username',
								'value' => $editinfo['username']
							), true);

	// get forums
	$forumSelect = Array();

	// init forum iter
	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

	foreach($forumIter as $forum) {
		$forumSelect[str_repeat('-', $forumIter->getDepth()) . ' ' . $forum->info['name']] = $forum->info['forumid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_forum'],
								'desc' => $lang['admin_forums_mod_ae_forum_desc'],
								'type' => (($which == 'add') ? 'multiple' : 'select'),
								'name' => (($which == 'add') ? 'forums[]' : 'mod[forumid]'),
								'select' => Array('fields' => $forumSelect, 'select' => (isset($_GET['f']) AND $which == 'add') ? $_GET['f'] : $editinfo['forumid'])
							), true);

	if($which == 'add') {
		$groupSelect = Array();
		$groups = Usergroup::groupAndSort($query['usergroups']['get_groups']);
		$groupSelect[$lang['admin_forums_mod_ae_doNotChange']] = 0;

		foreach($groups as $title => $info) {
			$groupSelect[$title] = $info['usergroupid'];
		}

		new AdminHTML('tableRow', Array(
									'title' => $lang['admin_forums_mod_ae_changeGroup'],
									'desc' => $lang['admin_forums_mod_ae_changeGroup_desc'],
									'type' => 'select',
									'name' => 'changeGroup',
									'select' => Array('fields' => $groupSelect, 'select' => 0)
								), true);
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_subs'],
								'desc' => $lang['admin_forums_mod_ae_subs_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modSubs]',
								'value' => $editinfo['modSubs']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	// ##### END: SETUP ##### \\


	// ##### BEGIN: FORUM PRIVILEGES ##### \\
	new AdminHTML('tableBegin', $lang['admin_forums_mod_ae_forumPrivs'], true, Array('form' => false));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_editPosts'],
								'desc' => $lang['admin_forums_mod_ae_editPosts_desc'],
								'type' => 'checkbox',
								'name' => 'mod[canEditPosts]',
								'value' => $editinfo['canEditPosts']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_editThreads'],
								'desc' => $lang['admin_forums_mod_ae_editThreads_desc'],
								'type' => 'checkbox',
								'name' => 'mod[canEditThreads]',
								'value' => $editinfo['canEditThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_editPolls'],
								'desc' => $lang['admin_forums_mod_ae_editPolls_desc'],
								'type' => 'checkbox',
								'name' => 'mod[canEditPolls]',
								'value' => $editinfo['canEditPolls']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_delete'],
								'desc' => $lang['admin_forums_mod_ae_delete_desc'],
								'type' => 'checkbox',
								'name' => 'mod[canDelete]',
								'value' => $editinfo['canDelete']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_permDelete'],
								'desc' => $lang['admin_forums_mod_ae_permDelete_desc'],
								'type' => 'checkbox',
								'name' => 'mod[canPermDelete]',
								'value' => $editinfo['canPermDelete']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_stick'],
								'desc' => $lang['admin_forums_mod_ae_stick_desc'],
								'type' => 'checkbox',
								'name' => 'mod[canStick]',
								'value' => $editinfo['canStick']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_openClose'],
								'desc' => $lang['admin_forums_mod_ae_openClose_desc'],
								'type' => 'checkbox',
								'name' => 'mod[canOpenClose]',
								'value' => $editinfo['canOpenClose']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_move'],
								'desc' => $lang['admin_forums_mod_ae_move_desc'],
								'type' => 'checkbox',
								'name' => 'mod[canMove]',
								'value' => $editinfo['canMove']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_merge'],
								'desc' => $lang['admin_forums_mod_ae_merge_desc'],
								'type' => 'checkbox',
								'name' => 'mod[canMerge]',
								'value' => $editinfo['canMerge']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_split'],
								'desc' => $lang['admin_forums_mod_ae_split_desc'],
								'type' => 'checkbox',
								'name' => 'mod[canSplit]',
								'value' => $editinfo['canSplit']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_ip'],
								'desc' => $lang['admin_forums_mod_ae_ip_desc'],
								'type' => 'checkbox',
								'name' => 'mod[canIp]',
								'value' => $editinfo['canIp']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	// ##### END: FORUM PRIVILEGES ##### \\


	// ##### BEGIN: MODERATOR CONTROL PANEL PRIVILEGES ##### \\
	new AdminHTML('tableBegin', $lang['admin_forums_mod_ae_modPanel'], true, Array('form' => false));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_access'],
								'desc' => $lang['admin_forums_mod_ae_access_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modAccess]',
								'value' => $editinfo['modAccess']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_announce'],
								'desc' => $lang['admin_forums_mod_ae_announce_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modAnnounce]',
								'value' => $editinfo['modAnnounce']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_massMove'],
								'desc' => $lang['admin_forums_mod_ae_massMove_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modMassMove]',
								'value' => $editinfo['modMassMove']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_massPrune'],
								'desc' => $lang['admin_forums_mod_ae_massPrune_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modMassPrune]',
								'value' => $editinfo['modMassPrune']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_profile'],
								'desc' => $lang['admin_forums_mod_ae_profile_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modProfile]',
								'value' => $editinfo['modProfile']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_ban'],
								'desc' => $lang['admin_forums_mod_ae_ban_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modBan]',
								'value' => $editinfo['modBan']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_restore'],
								'desc' => $lang['admin_forums_mod_ae_restore_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modRestore]',
								'value' => $editinfo['modRestore']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_sigs'],
								'desc' => $lang['admin_forums_mod_ae_sigs_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modSigs]',
								'value' => $editinfo['modSigs']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_avs'],
								'desc' => $lang['admin_forums_mod_ae_avs_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modAvatars]',
								'value' => $editinfo['modAvatars']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_modThreads'],
								'desc' => $lang['admin_forums_mod_ae_modThreads_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modThreads]',
								'value' => $editinfo['modThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_modPosts'],
								'desc' => $lang['admin_forums_mod_ae_modPosts_desc'],
								'type' => 'checkbox',
								'name' => 'mod[modPosts]',
								'value' => $editinfo['modPosts']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	// ##### END: MODERATOR CONTROL PANEL PRIVILEGES ##### \\


	// ##### BEGIN: EMAIL NOTIFICATIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_forums_mods_ae_emailNotif'], true, Array('form' => false));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_emailThreads'],
								'desc' => $lang['admin_forums_mod_ae_emailThreads_desc'],
								'type' => 'checkbox',
								'name' => 'mod[emailThread]',
								'value' => $editinfo['emailThread']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_mod_ae_emailPosts'],
								'desc' => $lang['admin_forums_mod_ae_emailPosts_desc'],
								'type' => 'checkbox',
								'name' => 'mod[emailPost]',
								'value' => $editinfo['emailPost']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	// ##### END: EMAIL NOTIFICATIONS ##### \\


	new AdminHTML('footer', '', true, Array('form' => true));
}

else if($_GET['do'] == 'addPerm' OR $_GET['do'] == 'editPerm') {
	if($_GET['do'] == 'addPerm') {
		$which = 'add';

		// if groupid set... use those perms...
		if(isset($groups[$_GET['groupid']])) {
			$editinfo = $groups[$_GET['groupid']]->info;
		}

		// use registered user perms...
		else {
			$editinfo = $groups[4]->info;
		}
	}

	else {
		$which = 'edit';
		$permObj = new ForumPerm($_GET['permid']);
		$editinfo = $permObj->getInfo();

		// if it it's an inherited forum... change forumid
		if(isset($_GET['f']) AND $_GET['f'] != $editinfo['forumid']) {
			$editinfo['forumid'] = $_GET['f'];
		}
	}

	// add/update db...
	if($_POST['formSet']) {
		// add forum perm
		if($which == 'add') {
			// if no forum or group select... bleh...
			if(!count($_POST['forums']) OR !count($_POST['groups'])) {
				new WtcBBException($lang['admin_error_noGroupOrForum']);
			}

			// now loop through forums, groups and add!
			foreach($_POST['forums'] as $forumid) {
				foreach($_POST['groups'] AS $groupid) {
					// if it already exists, continue! but make sure it isn't inherited
					if(isset($solidPerms[$forumid][$groupid])) {
						continue;
					}

					$_POST['perm']['forumid'] = $forumid;
					$_POST['perm']['usergroupid'] = $groupid;

					ForumPerm::insert($_POST['perm']);
				}
			}
		}

		// update info
		else {
			// forum and group has to be selected... no need to check...

			// form update array... and go...
			$update = $_POST['perm'];

			// and make sure the perm doesn't exist...
			// have to loop to make sure it isn't THIS perm...
			foreach($solidPerms as $forumid => $more) {
				foreach($more as $groupid => $info) {
					if($forumid == $update['forumid'] AND $groupid == $update['usergroupid'] AND $info->getPermid() != $editinfo['permid']) {
						new WtcBBException($lang['admin_error_doublePerms']);
					}
				}
			}

			// now we can update...
			// errm... if inherit, INSERT!
			if(!isset($solidPerms[$editinfo['forumid']][$editinfo['usergroupid']])) {
				ForumPerm::insert($update);
			}

			else {
				$permObj->update($update);
			}
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=forum&amp;do=perms');
	}

	new AdminHTML('header', $lang['admin_forums_perms_' . $which], true, Array('form' => true));

	// ##### BEGIN: SETUP ##### \\
	new AdminHTML('tableBegin', $lang['admin_forums_perms_ae_setup'], true, Array('form' => false));

	// get forums
	$forumSelect = Array();

	// init forum iter
	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

	foreach($forumIter as $forum) {
		$forumSelect[str_repeat('-', $forumIter->getDepth()) . ' ' . $forum->info['name']] = $forum->info['forumid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_perms_ae_forum'],
								'desc' => $lang['admin_forums_perms_ae_forum_desc'],
								'type' => (($which == 'add') ? 'multiple' : 'select'),
								'name' => (($which == 'add') ? 'forums[]' : 'perm[forumid]'),
								'select' => Array('fields' => $forumSelect, 'select' => (isset($_GET['f']) AND $which == 'add') ? $_GET['f'] : $editinfo['forumid'])
							), true);

	$groupSelect = Array();
	$groups = Usergroup::groupAndSort($query['usergroups']['get_groups']);

	foreach($groups as $title => $info) {
		$groupSelect[$title] = $info['usergroupid'];
	}

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_perms_ae_group'],
								'desc' => $lang['admin_forums_perms_ae_group_desc'],
								'type' => (($which == 'add') ? 'multiple' : 'select'),
								'name' => (($which == 'add') ? 'groups[]' : 'perm[usergroupid]'),
								'select' => Array('fields' => $groupSelect, 'select' => (isset($_GET['groupid']) AND $which == 'add') ? $_GET['groupid'] : $editinfo['usergroupid'])
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	// ##### END: SETUP ##### \\


	// form allYes allNo divit...
	$allYesNo = new AdminHTML('allYesNo', '', false, Array('return' => true));

	new AdminHTML('divit', Array('content' => $allYesNo->dump(), 'class' => 'right'), true);


	// ##### BEGIN: FORUM VIEWING ##### \\
	new AdminHTML('tableBegin', $lang['admin_forums_perms_ae_forumViewing'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_forums_perms_ae_viewBoard'],
								'desc' => $lang['admin_forums_perms_ae_viewBoard_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canViewBoard]',
								'value' => $editinfo['canViewBoard']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewThreads'],
								'desc' => $lang['admin_usergroups_ae_viewThreads_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canViewThreads]',
								'value' => $editinfo['canViewThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewOwnThreads'],
								'desc' => $lang['admin_usergroups_ae_viewOwnThreads_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canViewOwnThreads]',
								'value' => $editinfo['canViewOwnThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_viewDelNotices'],
								'desc' => $lang['admin_usergroups_ae_viewDelNotices_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canViewDelNotices]',
								'value' => $editinfo['canViewDelNotices']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_upAttach'],
								'desc' => $lang['admin_usergroups_ae_upAttach_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canUpAttach]',
								'value' => $editinfo['canUpAttach']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_downAttach'],
								'desc' => $lang['admin_usergroups_ae_downAttach_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canDownAttach]',
								'value' => $editinfo['canDownAttach']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	// ##### END: FORUM OPTIONS ##### \\


	// ##### BEGIN: FORUM ACCESS ##### \\
	new AdminHTML('tableBegin', $lang['admin_forums_perms_ae_forumAccess'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_search'],
								'desc' => $lang['admin_usergroups_ae_search_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canSearch]',
								'value' => $editinfo['canSearch']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_editedNotice'],
								'desc' => $lang['admin_usergroups_ae_editedNotice_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canEditedNotice]',
								'value' => $editinfo['canEditedNotice']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_close'],
								'desc' => $lang['admin_usergroups_ae_close_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canCloseOwn]',
								'value' => $editinfo['canCloseOwn']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_postThreads'],
								'desc' => $lang['admin_usergroups_ae_postThreads_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canPostThreads]',
								'value' => $editinfo['canPostThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_reply'],
								'desc' => $lang['admin_usergroups_ae_reply_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canReplyOthers]',
								'value' => $editinfo['canReplyOthers']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_replyOwn'],
								'desc' => $lang['admin_usergroups_ae_replyOwn_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canReplyOwn]',
								'value' => $editinfo['canReplyOwn']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_edit'],
								'desc' => $lang['admin_usergroups_ae_edit_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canEditOwn]',
								'value' => $editinfo['canEditOwn']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_editThreadTitle'],
								'desc' => $lang['admin_usergroups_ae_editThreadTitle_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canEditOwnThreadTitle]',
								'value' => $editinfo['canEditOwnThreadTitle']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_delPosts'],
								'desc' => $lang['admin_usergroups_ae_delPosts_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canDelOwnPosts]',
								'value' => $editinfo['canDelOwnPosts']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_permPosts'],
								'desc' => $lang['admin_usergroups_ae_permPosts_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canPermDelOwnPosts]',
								'value' => $editinfo['canPermDelOwnPosts']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_delThreads'],
								'desc' => $lang['admin_usergroups_ae_delThreads_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canDelOwnThreads]',
								'value' => $editinfo['canDelOwnThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_permThreads'],
								'desc' => $lang['admin_usergroups_ae_permThreads_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canPermDelOwnThreads]',
								'value' => $editinfo['canPermDelOwnThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_flood'],
								'desc' => $lang['admin_usergroups_ae_flood_desc'],
								'type' => 'checkbox',
								'name' => 'perm[overrideFlood]',
								'value' => $editinfo['overrideFlood']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1));
	// ##### END: FORUM ACCESS ##### \\


	// ##### BEGIN: MESSAGE OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_messageOpt'], true, Array('form' => 0));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_bb'],
								'desc' => $lang['admin_usergroups_ae_bb_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canBBCode]',
								'value' => $editinfo['canBBCode']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_img'],
								'desc' => $lang['admin_usergroups_ae_img_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canImg]',
								'value' => $editinfo['canImg']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_smilies'],
								'desc' => $lang['admin_usergroups_ae_smilies_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canSmilies]',
								'value' => $editinfo['canSmilies']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_icons'],
								'desc' => $lang['admin_usergroups_ae_icons_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canIcons]',
								'value' => $editinfo['canIcons']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: MESSAGE OPTIONS ##### \\


	// ##### BEGIN: SUPERVISION ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_supervision'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_supThreads'],
								'desc' => $lang['admin_usergroups_ae_supThreads_desc'],
								'type' => 'checkbox',
								'name' => 'perm[superThreads]',
								'value' => $editinfo['superThreads']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_supPosts'],
								'desc' => $lang['admin_usergroups_ae_supPosts_desc'],
								'type' => 'checkbox',
								'name' => 'perm[superPosts]',
								'value' => $editinfo['superPosts']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: SUPERVISION ##### \\


	// ##### BEGIN: POLL OPTIONS ##### \\
	new AdminHTML('tableBegin', $lang['admin_usergroups_ae_poll'], true, Array('form' => -1));

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_createPolls'],
								'desc' => $lang['admin_usergroups_ae_createPolls_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canCreatePolls]',
								'value' => $editinfo['canCreatePolls']
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_usergroups_ae_vote'],
								'desc' => $lang['admin_usergroups_ae_vote_desc'],
								'type' => 'checkbox',
								'name' => 'perm[canVotePolls]',
								'value' => $editinfo['canVotePolls']
							), true);

	new AdminHTML('tableEnd', '', true, Array('form' => -1, 'submitText' => $submitText));
	// ##### END: POLL OPTIONS ##### \\


	new AdminHTML('footer', '', true, Array('form' => true));
}

else if(isset($_GET['delPerm'])) {
	$permObj = new ForumPerm($_GET['delPerm']);
	$permObj->destroy();
}

else if($_GET['do'] == 'perms') {
	new AdminHTML('header', $lang['admin_forums_perms'], true);

	$keyBox = "\t\t\t" . '<ul class="noBullets">' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="emphasis">' . $lang['admin_forums_perms_keyBlack'] . '</li>' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="important">' . $lang['admin_forums_perms_keyRed'] . '</li>' . "\n";
		$keyBox .= "\t\t\t\t" . '<li class="altImportant">' . $lang['admin_forums_perms_keyBlue'] . '</li>' . "\n";
	$keyBox .= "\t\t\t" . '</ul>' . "\n";

	new AdminHTML('divitBox', Array(
								'title' => $lang['admin_language_manager_key'],
								'content' => $keyBox
							), true);

	// instantiate forum iter
	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

	// get groups array... (sorted)
	$sortedGroups = Usergroup::groupAndSort($query['usergroups']['get_groups']);

	$thCells = Array(
				$lang['admin_forums_perms_groupName'] => Array('th' => true),
				$lang['admin_options'] => Array('th' => true)
			);

	foreach($forumIter as $forum) {
		// echo forum title...
		print('<h2 class="noMar" style="margin-bottom: 2px;">' . str_repeat('-- ', $forumIter->getDepth()) . '<a href="admin.php?file=forum&amp;editForum=' . $forum->info['forumid'] . '">' . $forum->info['name'] . '</a></h2>' . "\n\n");

		// start table
		new AdminHTML('tableBegin', str_repeat('-- ', $forumIter->getDepth()) . $forum->info['name'], true, Array('form' => false, 'class' => 'left', 'noTh' => true));

		// add headers
		new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

		// loop through each usergroup...
		foreach($sortedGroups as $title => $info) {
			// get our options...
			// different if a perm exists...
			if(!isset($perms[$forum->info['forumid']][$info['usergroupid']])) {
				$options = '<a href="admin.php?file=forum&amp;do=addPerm&amp;f=' . $forum->info['forumid'] . '&amp;groupid=' . $info['usergroupid'] . '">' . $lang['admin_edit'] . '</a>';
			}

			else {
				// if not inherited, add delete
				$delete = '';

				if(isset($solidPerms[$forum->info['forumid']][$info['usergroupid']])) {
					$delete = ' - <a href="admin.php?file=forum&amp;delPerm=' . $perms[$forum->info['forumid']][$info['usergroupid']]->getPermid() . '">' . $lang['admin_delete'] . '</a>';
				}

				$options = '<a href="admin.php?file=forum&amp;do=editPerm&amp;permid=' . $perms[$forum->info['forumid']][$info['usergroupid']]->getPermid() . '&amp;f=' . $forum->info['forumid'] . '">' . $lang['admin_edit'] . '</a>' . $delete;
			}

			// find the class name for the title...
			$class = '';

			// not inherited
			if(isset($solidPerms[$forum->info['forumid']][$info['usergroupid']])) {
				$class = ' class="important"';
			}

			// inherited
			else if(isset($perms[$forum->info['forumid']][$info['usergroupid']])) {
				$class = ' class="altImportant"';
			}

			// form cells
			$cells = Array(
						str_repeat('-- ', $forumIter->getDepth()) . '<strong' . $class . '>' . $title . '</strong>' => Array(),
						$options => Array()
					);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}

		// end table
		new AdminHTML('tableEnd', '', true, Array('form' => 0));
	}

	new AdminHTML('footer', '', true);
}

else if($_GET['do'] == 'showMods') {
	// loop through mods, put in new array, sort
	// while we're at it, find the forums each mod mods
	$sortedMods = Array();
	$moddedForums = Array();

	// no mods?
	if(!count($moderators)) {
		new WtcBBException($lang['admin_error_noResults']);
	}

	foreach($moderators as $forumid => $more) {
		if(!is_array($more)) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		foreach($more as $userid => $modObj) {
			$sortedMods[$modObj->misc('username')] = $userid;
			$moddedForums[$userid][$forumid] = Array('mod' => $modObj, 'forum' => $forums[$forumid]);
		}
	}

	ksort($sortedMods);

	new AdminHTML('header', $lang['admin_forums_mods_all'], true);

	new AdminHTML('tableBegin', $lang['admin_forums_mods_all'], true, Array('form' => false, 'colspan' => 3));

	$thCells = Array(
					$lang['users_username'] => Array('th' => true),
					$lang['admin_forums_mods_moddedForums'] => Array('th' => true),
					$lang['admin_options'] => Array('th' => true)
				);

	new AdminHTML('tableCells', '', true, Array('cells' => $thCells));

	// loop...
	foreach($sortedMods as $username => $userid) {
		$forumHtml = "\t\t\t" . '<ul>' . "\n";

		// loop through modded forums
		foreach($moddedForums[$userid] as $forumid => $more) {
			// add a forumid, if inherited
			$addForumId = '';

			if(!isset($solidMods[$forumid][$userid])) {
				$addForumId = '&amp;f=' . $forumid;
			}

			$forumHtml .= "\t\t\t\t" . '<li><a href="admin.php?file=forum&amp;editForum=' . $forumid . '">' . $more['forum']->info['name'] . '</a> - <a href="admin.php?file=forum&amp;editMod=' . $more['mod']->getModid() . $addForumId . '">' . $lang['admin_edit'] . '</a></li>' . "\n";
		}

		$forumHtml .= "\t\t\t" . '</ul>' . "\n";

		$cells = Array(
					'<a href="admin.php?file=user&amp;edit=' . $userid . '">' . $username . '</a>' => Array(),
					$forumHtml => Array(),
					'<a href="admin.php?file=forum&amp;removeMod=' . $userid . '">' . $lang['admin_forums_mods_removeAll'] . '</a>' => Array()
				);

		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}

	new AdminHTML('tableEnd', '', true, Array('form' => 0, 'colspan' => 3));

	new AdminHTML('footer', '', true);
}

// forum manager
else {
	// update display order?
	if(is_array($_POST['disOrders'])) {
		// only update if display order is different...
		foreach($_POST['disOrders'] as $forumid => $newOrder) {
			if($forums[$forumid]->info['disOrder'] != $newOrder) {
				if(!is_numeric($newOrder) OR $newOrder < 1) {
					$newOrder = 1;
				}

				$forums[$forumid]->update(Array('disOrder' => $newOrder));
			}
		}

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=forum');
	}

	// initialize iterator
	$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

	new AdminHTML('header', $lang['admin_forums_man'], true, Array('form' => true));

	$thCells = Array(
					$lang['admin_forums_man_name'] => Array('th' => true),
					$lang['admin_forums_man_disOrder'] => Array('th' => true),
					$lang['admin_forums_man_mods'] => Array('th' => true),
					$lang['admin_options'] => Array('th' => true)
				);

	new AdminHTML('tableBegin', $lang['admin_forums_man'], true, Array('form' => 0, 'colspan' => 4));

	foreach($forumIter as $count => $forum) {
		// if depth is one... start new table...
		if(($forumIter->getDepth() + 1) == 1) {
			new AdminHTML('tableCells', '', true, Array('cells' => $thCells));
		}

		$optionsObj = new AdminHTML('locationSelect', '', false, Array(
																	'locs' => Array(
																				'admin.php?file=forum&amp;editForum=' . $forum->info['forumid'] => $lang['admin_edit'],
																				'admin.php?file=forum&amp;do=addMod&amp;f=' . $forum->info['forumid'] => $lang['admin_forums_man_addMod'],
																				'admin.php?file=announce&amp;do=add&amp;f=' . $forum->info['forumid'] => $lang['admin_forums_man_addAnnounce'],
																				'admin.php?file=forum&amp;do=addForum&amp;f=' . $forum->info['forumid'] => $lang['admin_forums_man_addChild'],
																				'admin.php?file=forum&amp;deleteForum=' . $forum->info['forumid'] => $lang['admin_delete']
																			),
																	'return' => true,
																	'name' => $forum->info['forumid'],
																	'noForm' => true
																));

		$options = $optionsObj->dump();

		// now do moderators...
		$mods = $forum->getModerators();
		$modLinks = Array();

		if(count($mods) > 0) {
			$modLinks['admin.php?file=forum'] = $lang['admin_forums_man_modMenu'];
		}

		else {
			$modLinks['admin.php?file=forum&amp;do=addMod&amp;f=' . $forum->info['forumid']] = $lang['admin_forums_man_noMods'];
		}

		foreach($mods as $modid => $modObj) {
			// add a forumid, if inherited
			$addForumId = '';

			if(!isset($solidMods[$forum->info['forumid']][$modObj->getUserid()])) {
				$addForumId = '&amp;f=' . $forum->info['forumid'];
			}

			$modLinks['admin.php?file=forum&amp;editMod=' . $modid . $addForumId] = $modObj->misc('username');
		}

		$modsObj = new AdminHTML('locationSelect', '', false, Array(
																	'locs' => $modLinks,
																	'return' => true,
																	'name' => $forum->info['forumid'] . '5',
																	'noForm' => true
																));

		$modsHTML = $modsObj->dump();

		$cells = Array(
				str_repeat('-- ', $forumIter->getDepth()) . '<a href="admin.php?file=forum&amp;editForum=' . $forum->info['forumid'] . '">' . $forum->info['name'] . '</a>' => Array(),
				'<input type="text" class="text less" name="disOrders[' . $forum->info['forumid'] . ']" value="' . $forum->info['disOrder'] . '" />' => Array(),
				$modsHTML => Array(),
				$options => Array()
			);

			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
	}

	new AdminHTML('tableEnd', '', true, Array('form' => 0, 'colspan' => 4, 'footerText' => '<a href="admin.php?file=forum&amp;do=addForum">' . $lang['admin_forums_man_add'] . '</a>&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="' . $lang['admin_forums_man_saveDis'] . '" />'));

	new AdminHTML('footer', '', true, Array('form' => true));
}

?>