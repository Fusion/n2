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
## ************************************************** ##
## **************** THREAD DISPLAY ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// if not logged in... perm
if(!LOGIN) {
	new WtcBBException('perm');
}

if($_GET['do'] == 'avatar') {
	// Define AREA
	define('AREA', 'USER-CP');
	require_once('./includes/sessions.php');

	// :(
	if(!$User->check('canAv')) {
		new WtcBBException('perm');
	}

	// no error... yet...
	$error = '';

	// start processing the signature
	if($_POST) {
		// if we're changing group, just let it go...
		if($_POST['go']) {
			$_GET['page'] = $_POST['page'];
			$_GET['groupid'] = $_POST['groupid'];

			// make sure we don't lose pages...
			if($_GET['groupid'] != $_POST['oldGroupId']) {
				$_GET['page'] = 1;
			}
		}

		// just setting a normal avatar... no checking at all!
		else if($_POST['predefined']) {
			// set it and forget it...
			$User->update(Array('avatar' => $_POST['avatar']['predefined']));
		}

		// no more avatar? :(
		else if($_POST['delete']) {
			$User->update(Array('avatar' => ''));
		}

		// time for the real work...
		else if($_POST['custom']) {
			// are we uploading?
			if(!empty($_FILES['fupload']['name'])) {
				// make a hash name...
				$fileName = md5($_FILES['fupload']['name'] . microtime() . time() . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) . '.avatar';

				$upload = new Upload(null, null, $_FILES['fupload'], './images/avatars/' . $fileName, $User->check('avatarFilesize'), Array('width' => $User->check('avatarWidth'), 'height' => $User->check('avatarHeight')));
				$do = $upload->doUpload();

				// hmmm...
				if($do instanceof WtcBBException) {
					$error = $do->dump();
				}

				// make sure it's an image though
				else if(!$upload->isImage()) {
					$upload->destroy();
					$error = new WtcBBException($lang['error_cp_mustUploadImage'], false);
					$error = $error->dump();
				}

				// good to go
				else {
					$User->update(Array('avatar' => HOME . $upload->getDestination()));
				}
			}
		}

		if(!$error AND !$_POST['go']) {
			new WtcBBThanks($lang['thanks_avatar'], './index.php?file=usercp&amp;do=avatar');
		}
	}

	// create the avatar bits...
	Avatar::init();
	$avatarBits = '';
	$ALT = 1;
	$counter = 0;
	$emptyCell = false;
	$totalAvatars = 0;
	$perPage = 8;

	// get the groupid
	if(isset($avatars[$_GET['groupid']])) {
		$groupid = $_GET['groupid'];
	}

	else {
		$groupid = 150;
	}

	// get the group object
	$AvatarGroup = new Group($groupid);

	if(!$AvatarGroup->canView()) {
		new WtcBBException('perm');
	}

	// start page number setup
	if(!is_numeric($_GET['page']) OR $_GET['page'] <= 0) {
		$page = 1;
	}

	else {
		$page = $_GET['page'];
	}

	$start = $perPage * ($page - 1);
	$end = $start + $perPage;

	if(is_array($avatars[$groupid])) {
		foreach($avatars[$groupid] as $avid => $avatar) {
			// total avatars
			$totalAvatars++;

			if(($totalAvatars - 1) < $start OR $totalAvatars > $end) {
				continue;
			}

			// should we do a new row now?
			if(!($counter % 4) AND $counter > 0) {
				$temp = new StyleFragment('usercp_avatar_newRowBit');
				$avatarBits .= $temp->dump();
			}

			// now increase counter...
			$counter++;

			$temp = new StyleFragment('usercp_avatar_bit');
			$avatarBits .= $temp->dump();

			if($ALT == 2) {
				$ALT = 1;
			}

			else {
				$ALT = 2;
			}
		}

		// mmmhmm... leftovers
		if(!empty($avatarBits)) {
			if($counter % 4) {
				$emptyCell = true;
				for($i = 4; $i > ($counter % 4); $i--) {
					$temp = new StyleFragment('usercp_avatar_bit');
					$avatarBits .= $temp->dump();

					if($ALT == 2) {
						$ALT = 1;
					}

					else {
						$ALT = 2;
					}
				}
			}
		}

		// create page numbers
		$pages = new PageNumbers($page, $totalAvatars, $perPage);

		// now build the group bits...
		$groups = Avatar::groupNames($avatars);
		$groupBits = '';

		// bah... not worth it if it's only default
		if(count($groups) > 1) {
			foreach($groups as $name => $id) {
				$select = '';

				if($id == $groupid) {
					$select = ' selected="selected"';
				}

				$groupBits .= '<option value="' . $id . '"' . $select . '>' . $name . '</option>' . "\n";
			}
		}
	}

	// no current? can't upload? no display?
	if(empty($User->info['avatar']) AND (empty($avatarBits) AND count($groups) < 2) AND !$User->check('canUploadAv')) {
		new WtcBBException($lang['error_cp_avNothing']);
	}

	// constraints...
	$maxSize = floor($User->check('avatarFilesize') / 1000);
	$maxHeight = $User->check('avatarHeight');
	$maxWidth = $User->check('avatarWidth');

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_cp_cp'] => './index.php?file=usercp',
							$lang['user_cp_av'] => ''
						));

	$content = new StyleFragment('usercp_avatar');
}

else if($_GET['do'] == 'signature') {
	// Define AREA
	define('AREA', 'USER-CP');
	require_once('./includes/sessions.php');

	// no error... yet...
	$error = '';

	// initiate the message parser
	$MessageParser = new Message();
	$MessageParser->setOptions($User->check('canBBCode'), $User->check('canSmilies'), $User->check('canImg'), $User->info['allowHtml']);

	// start processing the signature
	if($_POST) {
		// too long?
		if($bboptions['maxSig'] AND !$User->check('overrideMaxSig') AND strlen($_POST['message']) > $bboptions['maxSig']) {
			$error = new WtcBBException($lang['error_cp_sigRestrict'] . ' <strong>' . $bboptions['maxSig'] . '</strong>', false);
		}

		else {
			// preview?
			if($_POST['preview']) {
				$preview = $MessageParser->parse($_POST['message'], $User->info['username']);
			}

			// just update...
			else {
				$User->update(Array('sig' => $_POST['message']));

				new WtcBBThanks($lang['thanks_sig']);
			}
		}

		// uh oh...
		if($error instanceof WtcBBException) {
			$_POST['message'] = wtcspecialchars($_POST['message']);
			$error = $error->dump();

			// no preview!
			$preview = '';
		}
	}

	else {
		$preview = $MessageParser->parse($User->info['sig'], $User->info['username']);
		$_POST['message'] = wtcspecialchars($User->info['sig']);
	}

	// build toolbar
	$toolBar = Message::buildToolBar();

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_cp_cp'] => './index.php?file=usercp',
							$lang['user_cp_sig'] => ''
						));

	$content = new StyleFragment('usercp_signature');
}

else if($_GET['do'] == 'password') {
	// Define AREA
	define('AREA', 'USER-CP');
	require_once('./includes/sessions.php');

	// no error... yet...
	$error = '';

	// act-i-va-tion time... c'mon!
	// i think i said that in wtcBB 1.x.x too...
	// i haven't changed
	if($_GET['activate']) {
		// make sure the code is okay...
		if($_GET['activate'] != md5(md5($User->info['passActivate']) . $User->info['passActivate'] . md5($User->info['passActivate']))) {
			new WtcBBException($lang['error_cp_badActCode']);
		}

		// 24 hours?
		if($User->info['passActivate'] < (NOW - (60 * 60 * 24))) {
			new WtcBBException($lang['error_cp_actCodeExpire']);
		}

		// start the update...
		$update['password'] = $User->info['passNew'];
		$update['passTime'] = $User->info['passTimeNew'];
		$update['salt'] = $User->info['saltNew'];
		$update['passNew'] = '';
		$update['passTimeNew'] = '';
		$update['saltNew'] = '';
		$update['passActivate'] = 0;
		$update['oldPass'] = 0;

		// now we're okay...
		$User->update($update);

		// don't forget to reset cookie...
		new Cookie('password', '');
		new Cookie('password', $update['password'], NOW + AYEAR);

		new WtcBBThanks($lang['thanks_passActivation'], './index.php?file=usercp');
	}

	// if we're good, just send email
	if($_POST['password']) {
		// get current password hash to check against their REAL password...
		$passObj = new Password($_POST['password']['current'], $User);

		// not all info
		if(!$_POST['password']['newPass'] OR !$_POST['password']['newConf']) {
			$error = new WtcBBException($lang['error_reg_requiredFields'], false);
		}

		// do not match
		else if($_POST['password']['newPass'] != $_POST['password']['newConf']) {
			$error = new WtcBBException($lang['error_cp_passMatch'], false);
		}

		// current doesn't match REAL
		else if($passObj->getHashedPassword() != $User->info['password']) {
			$error = new WtcBBException($lang['error_cp_currentMatch'], false);
		}

		// good to go!
		else {
			// just send out the activation email...
			$activation = md5(md5(NOW) . NOW . md5(NOW));

			new Email('verifyPass', $User->info, '', Array('link' => 'http://wtcbb2.com/index.php?file=usercp&do=password&activate=' . $activation));

			// get password
			$passObj = new Password($_POST['password']['newPass']);
			$update['passNew'] = $passObj->getHashedPassword();
			$update['saltNew'] = $passObj->getSalt();
			$update['passTimeNew'] = NOW;
			$update['passActivate'] = NOW;

			// now update the passActivate time...
			$User->update($update);

			// done
			new WtcBBThanks($lang['thanks_actSent'], './index.php?file=usercp');
		}

		// uh oh...
		if($error instanceof WtcBBException) {
			$error = $error->dump();

			$_POST['password'] = array_map('wtcspecialchars', $_POST['password']);
		}
	}

	else {
		// nothin...
		$_POST = Array();
	}

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_cp_cp'] => './index.php?file=usercp',
							$lang['user_cp_passChange'] => ''
						));

	$content = new StyleFragment('usercp_password');
}

else if($_GET['do'] == 'email') {
	// Define AREA
	define('AREA', 'USER-CP');
	require_once('./includes/sessions.php');

	// no error... yet...
	$error = '';

	// act-i-va-tion time... c'mon!
	// i think i said that in wtcBB 1.x.x too...
	// i haven't changed
	if($_GET['activate']) {
		// make sure the code is okay...
		if($_GET['activate'] != md5(md5($User->info['emailActivate']) . $User->info['emailActivate'] . md5($User->info['emailActivate']))) {
			new WtcBBException($lang['error_cp_badActCode']);
		}

		// 24 hours?
		if($User->info['emailActivate'] < (NOW - (60 * 60 * 24))) {
			new WtcBBException($lang['error_cp_actCodeExpire']);
		}

		// now we're okay...
		$User->update(Array('email' => $User->info['emailNew'], 'emailNew' => '', 'emailActivate' => 0));

		new WtcBBThanks($lang['thanks_emailActivation'], './index.php?file=usercp');
	}

	// if we're good, just send email
	if($_POST['email']) {
		// check for uniqueness
		$uniqueEmail = new Query($query['user']['checkUniqueEmail'], Array(1 => $_POST['email']['newEmail']));
		$uniqueEmail = $uniqueEmail->fetchArray();

		// not all info
		if(!$_POST['email']['newEmail'] OR !$_POST['email']['newConf']) {
			$error = new WtcBBException($lang['error_reg_requiredFields'], false);
		}

		// do not match
		else if($_POST['email']['newEmail'] != $_POST['email']['newConf']) {
			$error = new WtcBBException($lang['error_cp_emailMatch'], false);
		}

		// uniqueness problems
		else if($bboptions['uniqueEmail'] AND $uniqueEmail['checking']) {
			$error = new WtcBBException($lang['error_reg_uniqueEmail'], false);
		}

		// good to go!
		else {
			// just send out the activation email...
			$activation = md5(md5(NOW) . NOW . md5(NOW));

			new Email('verifyEmail', $User->info, '', Array('link' => 'http://wtcbb2.com/index.php?file=usercp&do=email&activate=' . $activation));

			// now update the emailActivate time...
			$User->update(Array('emailActivate' => NOW, 'emailNew' => $_POST['email']['newEmail']));

			// done
			new WtcBBThanks($lang['thanks_actSent'], './index.php?file=usercp');
		}

		// uh oh...
		if($error instanceof WtcBBException) {
			$error = $error->dump();

			$_POST['email'] = array_map('wtcspecialchars', $_POST['email']);
		}
	}

	else {
		// nothin...
		$_POST = Array();
	}

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_cp_cp'] => './index.php?file=usercp',
							$lang['user_cp_emailChange'] => ''
						));

	$content = new StyleFragment('usercp_email');
}

else if($_GET['do'] == 'preferences') {
	// Define AREA
	define('AREA', 'USER-CP');
	require_once('./includes/sessions.php');

	// initialize fields to edit...
	$fields = Array(
		'dst', 'timezone', 'styleid', 'toolbar', 'disSigs', 'disImgs', 'disAttach', 'disAv',
		'disSmi', 'emailContact', 'adminEmails', 'receivePm', 'receivePmEmail', 'receivePmAlert',
		'displayOrder', 'postsPerPage', 'censor', 'lang'
	);

	// I be lazy
	$radioFields = Array(
		'dst', 'toolbar', 'disSigs', 'disImgs', 'disAttach', 'disAv', 'disSmi',
		'emailContact', 'adminEmails', 'receivePm', 'receivePmEmail',
		'receivePmAlert', 'censor'
	);

	// no error... yet
	$error = '';

	// just do a simple update... no required fields...
	if($_POST) {
		// wha whoa...
		// sanity check...
		// we have to check permissions...
		foreach($_POST['pref'] as $name) {
			switch($name) {
				case 'invis':
					if(!$User->check('canInvis')) {
						unset($_POST['pref'][$name]);
					}
				break;

				case 'censor':
					if(!$User->check('canDisableCensor')) {
						unset($_POST['pref'][$name]);
					}
				break;

				case 'receivePm':
				case 'receivePmEmail':
				case 'receivePmAlert':
					if(!$User->check('personalMaxMessages')) {
						unset($_POST['pref'][$name]);
					}
				break;

				case 'styleid':
					if(!$User->check('canSwitchStyles')) {
						unset($_POST['pref'][$name]);
					}
				break;
			}
		}

		// do the update!
		$User->update($_POST['pref']);

		new WtcBBThanks($lang['thanks_preferences']);
	}

	else {
		$_POST['pref'] = Array();

		foreach($fields as $val) {
			$_POST['pref'][$val] = $User->info[$val];
		}

		$_POST['pref'] = array_map('wtcspecialchars', $_POST['pref']);
	}

	// build timezones
	$timezones = WtcDate::getTimeZones('pref[timezone]', $_POST['pref']['timezone']);

	// build posts per page...
	$postsPerPage = ''; $stylesBits = ''; $langBits = '';

	{
		$val = 0;
		$text = $lang['user_cp_pref_forumDefault'];

		if(!$User->info['postsPerPage']) {
			$select = ' selected="selected"';
		}

		$temp = new StyleFragment('usercp_preferences_optBit');
		$postsPerPage .= $temp->dump();

		foreach(preg_split('/\s+/', $bboptions['settablePostsPerPage']) as $val) {
			$select = '';

			if($val == $_POST['pref']['postsPerPage']) {
				$select = ' selected="selected"';
			}

			$text = $val;

			$temp = new StyleFragment('usercp_preferences_optBit');
			$postsPerPage .= $temp->dump();
		}

		$select = '';
	}

	if($User->check('canSwitchStyles')) {
		Style::init();

		$val = 0;
		$text = $lang['user_cp_pref_defaultStyle'];
		$styleBits = '';

		if(!$User->info['styleid']) {
			$select = ' selected="selected"';
		}

		$temp = new StyleFragment('usercp_preferences_optBit');
		$stylesBits .= $temp->dump();

		foreach($styles as $val => $obj) {
			// bah...
			if(!$obj->isSelectable() OR !$obj->isEnabled()) {
				continue;
			}

			$select = '';

			if($_POST['pref']['styleid'] == $val) {
				$select = ' selected="selected"';
			}

			$text = $obj->getName();

			$temp = new StyleFragment('usercp_preferences_optBit');
			$styleBits .= $temp->dump();
		}

		$stylesBits .= $styleBits;
	}

	// now languages
	$val = -1;
	$text = $lang['user_cp_pref_defaultLang'];

	$temp = new StyleFragment('usercp_preferences_optBit');
	$langBits .= $temp->dump();

	foreach($langs as $val => $obj) {
		$select = '';

		if($_POST['pref']['lang'] == $val) {
			$select = ' selected="selected"';
		}

		$text = $obj->getName();

		$temp = new StyleFragment('usercp_preferences_optBit');
		$langBits .= $temp->dump();
	}

	$radioBits = '';
	$ALT = 1; $ALTB = 0;

	foreach($radioFields as $name) {
		// we have to check permissions...
		switch($name) {
			case 'invis':
				if(!$User->check('canInvis')) {
					continue 2;
				}
			break;

			case 'censor':
				if(!$User->check('canDisableCensor')) {
					continue 2;
				}
			break;

			case 'receivePm':
			case 'receivePmEmail':
			case 'receivePmAlert':
				if(!$User->check('personalMaxMessages')) {
					continue 2;
				}
			break;
		}

		$langVar = $lang['user_cp_pref_' . $name];
		$langVarDesc = $lang['user_cp_pref_' . $name . '_desc'];

		$temp = new StyleFragment('usercp_preferences_radioBit');
		$radioBits .= $temp->dump();

		if($ALT == 2) {
			$ALT = 1;
		}

		else {
			$ALT = 2;
		}
	}

	if($ALT == 2) {
		$ALTB = 2;
		$ALT = 1;
	}

	else {
		$ALTB = 1;
		$ALT = 2;
	}

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_cp_cp'] => './index.php?file=usercp',
							$lang['user_cp_preferences'] => ''
						));

	$content = new StyleFragment('usercp_preferences');
}

else if($_GET['do'] == 'profile') {
	// Define AREA
	define('AREA', 'USER-CP');
	require_once('./includes/sessions.php');

	// initialize fields to edit...
	$fields = Array(
		'usertitle', 'birthday', 'homepage', 'location'
	);

	// no error... yet
	$error = '';

	// just do a simple update... no required fields...
	if($_POST) {
		$_POST['pro']['usertitle'] = trim($_POST['pro']['usertitle']);

		// wha whoa...
		if(!empty($_POST['pro']['usertitle']) AND strlen($_POST['pro']['usertitle']) < $bboptions['minTitle']) {
			$error = new WtcBBException($lang['error_cp_minTitle'] . ' <strong>' . $bboptions['minTitle'] . '</strong>', false);
		}

		else if(!empty($_POST['pro']['usertitle']) AND strlen($_POST['pro']['usertitle']) > $bboptions['maxTitle']) {
			$error = new WtcBBException($lang['error_cp_maxTitle'] . ' <strong>' . $bboptions['maxTitle'] . '</strong>', false);
		}

		else {
			// construct the birthday...
			if($_POST['birthday']['day'] AND $_POST['birthday']['month'] AND $_POST['birthday']['year']) {
				$_POST['pro']['birthday'] = WtcDate::mktime(0, 0, 0, $_POST['birthday']['month'], $_POST['birthday']['day'], $_POST['birthday']['year']);
			}

			else {
				$_POST['pro']['birthday'] = 0;
			}

			$_POST['pro']['usertitle'] = trim($_POST['pro']['usertitle']);

			// do user title...
			// unless... revert!
			if($_POST['revert']) {
				$_POST['pro']['usertitle'] = User::getUsertitle(0, $User->info['posts'], '', $User->info['usergroupid']);
				$_POST['pro']['usertitle_opt'] = 0;
			}

			else if(!empty($_POST['pro']['usertitle'])) {
				$_POST['pro']['usertitle'] = User::getUsertitle(2, $User->info['posts'], $_POST['pro']['usertitle'], $User->info['usergroupid']);
				$_POST['pro']['usertitle_opt'] = 2;
			}

			// same ol'
			else {
				$_POST['pro']['usertitle'] = $User->info['usertitle'];
			}
                      
			// make sure homepage is okay...
			if(!preg_match('/^http:\/\//i', $_POST['pro']['homepage'])) {
                               new WtcBBException($lang['error_cp_homepage']);
			}
			// now do some work for updating custom profile stuff...
			$cUpdate = Array();

			if(is_array($_POST['cpro'])) {
				foreach($_POST['cpro'] as $fieldName => $val) {
					// multi selecting... more work...
					if(is_array($val)) {
						$cVal = '';
						$before = '';

						foreach($val as $myVal) {
							// we needed something to say that
							// "checkboxes are here, even if none are checked!"
							if($myVal == 'wtcBB Rocks Your Socks') {
								continue;
							}

							$cVal .= $before . $myVal;
							$before = "\n";
						}

						$cUpdate[$fieldName] = $cVal;
					}

					// just put it in...
					else {
						$cUpdate[$fieldName] = $val;
					}
				}

				$User->updateCustom(array_map('wtcspecialchars', array_map('censor', $cUpdate)));
			}

			$usertitle = $_POST['pro']['usertitle'];
			$_POST['pro'] = array_map('wtcspecialchars', $_POST['pro']);
			$_POST['pro']['usertitle'] = $usertitle;
                        
			$User->update(array_map('censor', $_POST['pro']));

			new WtcBBThanks($lang['thanks_profile']);
		}

		if($error instanceof WtcBBException) {
			$error = $error->dump();
		}

		$_POST['pro'] = array_map('wtcspecialchars', $_POST['pro']);
		$_POST['cpro'] = array_map_recursive('wtcspecialchars', $_POST['pro']);

		// construct date bits
		$monthS = $_POST['birthday']['month'];
		$dayS = $_POST['birthday']['day'];
		$yearS = $_POST['birthday']['year'];
	}

	else {
		$_POST['pro'] = Array();

		foreach($fields as $val) {
			$_POST['pro'][$val] = $User->info[$val];
		}

		//$_POST['pro'] = array_map('wtcspecialchars', $_POST['pro']);

		// construct date bits
		if(!$_POST['pro']['birthday']) {
			$monthS = 1; $dayS = 0; $yearS = 0;
		}

		else {
			$monthS = new WtcDate('m', $_POST['pro']['birthday']);
			$dayS = new WtcDate('d', $_POST['pro']['birthday']);
			$yearS = new WtcDate('Y', $_POST['pro']['birthday']);

			$monthS = $monthS->getDate(); $dayS = $dayS->getDate(); $yearS = $yearS->getDate();
		}
	}

	$monthBits = WtcDate::getMonths('birthday[month]', $monthS);
	$dayBits = WtcDate::getDays('birthday[day]', $dayS);
	$yearBits = WtcDate::getYears('birthday[year]', $yearS);

	// now start fetching custom profile field data...
	$customBits = '';
	$fieldBits = '';
	$haveFields = false;
	$GROUP_ALT = 1;

	// initialize our categories and fields...
	Group::init();
	CustomPro::init();

	if(is_array($generalGroups['custom_pro'])) {
		$groupIter = new GroupIterator('custom_pro');

		foreach($groupIter as $group) {
			$haveFields = false;
			$fieldBits = '';
			$GROUP_ALT = 1;

			if(is_array($profs[$group->getGroupId()])) {
				foreach($profs[$group->getGroupId()] as $id => $prof) {
					$fieldName = $prof->getName();
					$fieldValue = trim($User->info[$prof->getColName()]);
					$fieldDesc = trim($prof->getDesc());
					$fieldHTML = $prof->buildHTML('cpro[' . $prof->getColName() . ']', $fieldValue);

					$haveFields = true;
					$temp = new StyleFragment('usercp_profile_category_field');
					$fieldBits .= $temp->dump();

					if($GROUP_ALT == 1) {
						$GROUP_ALT = 2;
					}

					else {
						$GROUP_ALT = 1;
					}
				}
			}

			// only continue if we have at least one field...
			if(!$haveFields) {
				continue;
			}

			$temp = new StyleFragment('usercp_profile_category');
			$customBits .= $temp->dump();
		}
	}

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_cp_cp'] => './index.php?file=usercp',
							$lang['user_cp_profile'] => ''
						));

	$content = new StyleFragment('usercp_profile');
}

// main CP area
else {
	// Define AREA
	define('AREA', 'USER-CP');
	require_once('./includes/sessions.php');

	new Redirect('./index.php?file=usercp&do=profile' . $SESSURL);

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_cp_cp'] => ''
						));

	$content = new StyleFragment('usercp_main');
}

$header = new StyleFragment('header');
$cpHeader = new StyleFragment('usercp_header');
$cpFooter = new StyleFragment('usercp_footer');
$footer = new StyleFragment('footer');

$header->output();
$cpHeader->output();
$content->output();
$cpFooter->output();
$footer->output();

?>