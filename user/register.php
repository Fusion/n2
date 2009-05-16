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
## ************************************************** ##
## **************** THREAD DISPLAY ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// if not logged in... perm
if(LOGIN AND !$_GET['activate']) {
	new WtcBBException('perm');
}

// activation time!
if(isset($_GET['activate'])) {
	// Define AREA
	define('AREA', 'USER-ACTIVATING');
	require_once('./includes/sessions.php');

	// get the user based on passTime...
	$getUser = new Query($query['user']['get_activation'], Array(1 => $_GET['activate']));

	// invalid code
	if(!$getUser->numRows()) {
		new WtcBBException($lang['error_reg_invalidActivate']);
	}

	$userinfo = $getUser->fetchArray();
	$userObj = new User($userinfo['userid']);

	// already activated?
	if($userObj->info['usergroupid'] != 3) {
		new WtcBBException($lang['error_reg_activated']);
	}

	// coppa?
	if($userObj->info['coppa']) {
		// update user title too...
		$newTitle = User::getUserTitle(0, $userObj->info['posts'], '', 2);

		$userObj->update(Array('usergroupid' => 2, 'usertitle' => $newTitle));
	}

	else {
		// update user title too...
		$newTitle = User::getUserTitle(0, $userObj->info['posts'], '', 4);

		$userObj->update(Array('usergroupid' => 4, 'usertitle' => $newTitle));
	}

	// send off the email...
	new Email('regComp', $userObj->info['userid']);

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_reg_activating'] => ''
						));

	new WtcBBThanks($lang['thanks_activation'], './index.php');
}

else if($_GET['do'] == 'info') {
	// Define AREA
	define('AREA', 'USER-REGISTERING');
	require_once('./includes/sessions.php');

	// redirect to forum index
	if(!$_POST['agree'] AND !$_POST['reg']) {
		new Redirect('./index.php');
	}

	// no error... yet
	$error = '';

       

	if($_POST['reg']) {
                
		$username = trim($_POST['reg']['username']);
                // test for duplicates...
		$uniqueName = new Query($query['user']['checkUniqueName'], Array(1 => $username));
		$uniqueName = $uniqueName->fetchArray();

		$uniqueEmail = new Query($query['user']['checkUniqueEmail'], Array(1 => $_POST['reg']['email']));
		$uniqueEmail = $uniqueEmail->fetchArray();

		// not enough required fields
		if(!$_POST['reg']['username'] OR !$_POST['reg']['password'] OR !$_POST['reg']['confPassword'] OR !$_POST['reg']['email'] OR ($_POST['coppa'] AND !$_POST['reg']['parentEmail'])) {
			$error = new WtcBBException($lang['error_reg_requiredFields'], false);
		}

		// parent email can't be regular email
		else if($_POST['coppa'] AND $_POST['reg']['email'] == $_POST['reg']['parentEmail']) {
			$error = new WtcBBException($lang['error_reg_parentEmail'], false);
		}

		// uniqueness problems
		else if($uniqueName['checking']) {
			$error = new WtcBBException($lang['error_reg_uniqueUsername'], false);
		}

		// uniqueness problems
		else if($bboptions['uniqueEmail'] AND $uniqueEmail['checking']) {
			$error = new WtcBBException($lang['error_reg_uniqueEmail'], false);
		}

		// length problems
		else if(strlen($_POST['reg']['username']) < $bboptions['usernameMin']) {
			$error = new WtcBBException($lang['error_reg_usernameMin'] . ' <strong>' . $bboptions['usernameMin'] . '</strong>', false);
		}

		// length problems
		else if(strlen($username) > $bboptions['usernameMax']) {
			$error = new WtcBBException($lang['error_reg_usernameMax'] . ' <strong>' . $bboptions['usernameMax'] . '</strong>', false);
		}

		// invalid characters
		else if(!preg_match('/[-a-zA-Z0-9_ ]+/', $username)) {
			$error = new WtcBBException($lang['error_reg_usernameInvalid'], false);
		}

		// confirm password is incorrect
		else if($_POST['reg']['password'] != $_POST['reg']['confPassword']) {
			$error = new WtcBBException($lang['error_reg_passMatch'], false);
		}

                else if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/',$_POST['reg']['email'])) {
                       $error = new WtcBBException($lang['error_reg_invalidEmail'], false);
                }

		// error free!
		else {
			// start the insert...
			$insert = $_POST['reg'];
			unset($insert['confPassword']);

			// get password
			$passObj = new Password($_POST['reg']['password']);
			$insert['password'] = $passObj->getHashedPassword();
			$insert['salt'] = $passObj->getSalt();
			$insert['passTime'] = NOW;

			// groupid?
			if($bboptions['verifyEmail']) {
				$insert['usergroupid'] = 3;
			}

			else {
				// still send coppa email...
				if($_POST['coppa']) {
					$insert['usergroupid'] = 2;
				}

				else {
					$insert['usergroupid'] = 4;
				}
			}

			// coppa?
			if($_POST['coppa']) {
				$insert['coppa'] = 1;
			}

			else {
				$insert['coppa'] = 0;
				$insert['parentEmail'] = '';
			}

			// start setting default values...
			$insert['joined'] = NOW;
			$insert['ip'] = $_SERVER['REMOTE_ADDR'];
			$insert['posts'] = 0;
			$insert['threads'] = 0;
			$insert['referrals'] = 0;
			$insert['styleid'] = 0;
			$insert['toolbar'] = 1;
			$insert['allowHtml'] = 0;
			$insert['banSig'] = 0;
			$insert['disSigs'] = 1;
			$insert['disImgs'] = 1;
			$insert['disAttach'] = 1;
			$insert['disAv'] = 1;
			$insert['disSmi'] = 1;
			$insert['emailContact'] = 1;
			$insert['adminEmails'] = 1;
			$insert['receivePm'] = 1;
			$insert['receivePmEmail'] = 1;
			$insert['receivePmAlert'] = 1;
			$insert['displayOrder'] = 'ASC';
			$insert['postsPerPage'] = 0;
			$insert['censor'] = 0;
			$insert['lang'] = -1;
			$insert['markedRead'] = NOW;
			$insert['lastvisit'] = NOW;
			$insert['lastactivity'] = NOW;
			$insert['usertitle_opt'] = 0;
			$insert['usertitle'] = User::getUsertitle(0, 0, '', $insert['usergroupid']);
                        $insert['birthday']  = WtcDate::mktime(0, 0, 0, $_POST['birthday']['month'], $_POST['birthday']['day'], $_POST['birthday']['year']);
			// add to referrals?
			new Query($query['user']['referrer'], Array(1 => $insert['referrer']));

			// insert'em
			$userid = User::insert($insert);

			// send to parent (also get appropriate "thanks" message...
			if($_POST['coppa']) {
				new Email('regCoppa', $userid, '', Array('link' => $_SERVER['SCRIPT_URI'].'?file=register&activate=' . $insert['passTime']));
				$thanks = 'thanks_registration_coppa';
			}

			// send activation
			else if($bboptions['verifyEmail']) {
				new Email('regAct', $userid, '', Array('link' => $_SERVER['SCRIPT_URI'].'?file=register&activate=' . $insert['passTime']));
				$thanks = 'thanks_registration_act';
			}

			// send reg confirmation
			else {
				new Email('regComp', $userid);
				$thanks = 'thanks_registration';
			}

			// log'em in
			new Cookie('userid', $userid, NOW + AYEAR);
			new Cookie('password', $insert['password'], NOW + AYEAR);


			// redirect to index...
			new WtcBBThanks($lang[$thanks], './index.php', true);
		}

		// uh oh!
		if($error instanceof WtcBBException) {
			$error = $error->dump();
		}

		$_POST['reg'] = array_map('wtcspecialchars', $_POST['reg']);
	}

	else {
		$_POST['reg']['timezone'] = $bboptions['timezone'];
	}

	// build timezones
	$timezones = WtcDate::getTimeZones('reg[timezone]', $_POST['reg']['timezone']);

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_reg'] => './index.php?file=register',
							$lang['user_reg_info'] => ''
						));

	$content = new StyleFragment('register_info');
}

else if($_GET['do'] == 'tos') {
	// Define AREA
	define('AREA', 'USER-REGISTERING');
	require_once('./includes/sessions.php');

	// trying to bypass me? I DON'T THINK SO!
	if($bboptions['coppa'] AND (!$_POST['birthday']['month'] OR !$_POST['birthday']['day'] OR !$_POST['birthday']['year'])) {
		new WtcBBException($lang['error_reg_invalidRequest']);
	}
        
	// now.. are we coppa? o_0
	$stamp = WtcDate::mktime(0, 0, 0, $_POST['birthday']['month'], $_POST['birthday']['day'], $_POST['birthday']['year']);
        if(mktime() < $stamp) {
                new WtcBBException($lang['error_reg_invalidDate']);
        }  
	// thirteen years ago...
	$thirteen = NOW - ((60 * 60 * 24 * 365) * 13);

	if($thirteen < $stamp) {
		$coppa = true;
	}

	else {
		$coppa = false;
	}

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_reg'] => './index.php?file=register',
							$lang['user_reg_tos'] => ''
						));

	$content = new StyleFragment('register_tos');
}

// first register screen
// this is asking for the birthday
// if COPPA is disabled, then we can skip...
else {
	// Define AREA
	define('AREA', 'USER-REGISTERING');
	require_once('./includes/sessions.php');

	if(!$bboptions['coppa']) {
		new Redirect('./index.php?file=register&amp;do=tos');
	}

	// create the birthday bits
	$monthBits = WtcDate::getMonths('birthday[month]', 1);
	$dayBits = WtcDate::getDays('birthday[day]', 0);
	$yearBits = WtcDate::getYears('birthday[year]', 0);

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_reg'] => '',
							$lang['user_reg_birthday'] => ''
						));

	$content = new StyleFragment('register_main');
}

$header = new StyleFragment('header');
$footer = new StyleFragment('footer');

$header->output();
$content->output();
$footer->output();

?>