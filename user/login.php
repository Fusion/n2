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
## ********************* LOGIN ********************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// they are trying to login
if(isset($_POST['login'])) {
	// Require global and define AREA
	define('AREA', 'USER-LOGIN');
	require_once('./includes/sessions.php');

	$login = array_map('trim', $_POST['login']);

	// no username or password?
	if(empty($login['username']) OR empty($login['password']) OR $login['username'] == 'User Name') {
		new WtcBBException($lang['error_login_noInfo']);
	}

	// gets the user object, and also checks if user exists...
	$userObj = new User('', $login['username']);

	// make sure we have appropriate authentication
	Password::validate($login['password'], $userObj);

	// alright, user exists and password is correct...
	// login time!
	if(!empty($_REQUEST['session']) AND !$bboptions['cookLogin']) {
		// get our values into array
		$lastaction = NOW - $bboptions['floodcheck'] - 100;

		$replace = Array(1 => SID, $userObj->info['username'], $userObj->info['userid'], NOW, stripSessionId($_SERVER['REQUEST_URI']), $lang['user_login'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $lastaction);
		new Query($query['sessions']['replace'], $replace);
	}

	else if(!empty($_REQUEST['session']) AND $bboptions['cookLogin']) {
		new WtcBBException($lang['error_login_cookiesRequired']);
	}

	new Cookie('userid', $userObj->info['userid'], NOW + AYEAR);
	new Cookie('password', $userObj->info['password'], NOW + AYEAR);

	// do nav
	$Nav = new Navigation(
				Array(
					$lang['user_nav_login'] => ''
				)
			);

	// hmm...
	if(strpos($_SERVER['HTTP_REFERER'], 'file=login') !== false) {
		$_SERVER['HTTP_REFERER'] = './index.php';
	}

	new WtcBBThanks($lang['thanks_login']);
}

// logging out...
else if($_GET['do'] == 'logout') {
	// Require global and define AREA
	define('AREA', 'USER-LOGOUT');
	require_once('./includes/sessions.php');

	// not logged in? o_0
	if(!$LOGIN) {
		new WtcBBException($lang['error_login_notLoggedIn']);
	}

	if(!empty($_REQUEST['session']) AND !$bboptions['cookLogin']) {
		// get our values into array
		$replace = Array(1 => SID, $lang['global_guest'], 0, NOW, stripSessionId($_SERVER['REQUEST_URI']), $lang['user_login'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		new Query($query['sessions']['replace'], $replace);
	}

	// update last visit while we're at it
	$User->update(Array('lastvisit' => NOW, 'lastactivity' => NOW));

	// destroy the login cookies...
	new Cookie('userid', '');
	new Cookie('password', '');

	// do nav
	$Nav = new Navigation(
				Array(
					$lang['user_nav_logout'] => ''
				)
			);

	new WtcBBThanks($lang['thanks_logout']);
}

// no good...
else {
	// Require global and define AREA
	define('AREA', 'USER-INVALIDLINK');
	require_once('./includes/sessions.php');

	new WtcBBException($lang['error_invalidLink']);
}

?>