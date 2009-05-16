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
## ****************** GLOBAL ADMIN ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Initialize Admin User
if(Cookie::get('adminPassword') AND Cookie::get('adminUserid')) {
	$User = new Admin(Cookie::get('adminUserid'), '', false, true);
}


/**
 * Define our langid...
 */
define('LANG', (($User->info['lang'] == -1 OR !$User) ? $bboptions['defLang'] : $User->info['lang']));

require_once('./language/' . $langs[LANG]->getFileName() . '_admin.php');

// Start authorization process
if(!Cookie::get('adminUsername') OR !Cookie::get('adminPassword') OR !Cookie::get('adminUserid') OR !$User->validateSession(Cookie::get('adminPassword'))) {
	if(isset($_POST['login']['username']) AND isset($_POST['login']['password'])) {
		// user exists... and is admin?
		$userObj = new Admin('', $_POST['login']['username']);

		// check auth
		Password::validate($_POST['login']['password'], $userObj);

		// otherwise... LOGIN!
		new Cookie('adminUsername', $userObj->info['username'], NOW + AYEAR);
		new Cookie('adminUserid', $userObj->info['userid'], 0);
		new Cookie('adminPassword', $userObj->info['password'], 0);

		new Redirect($_SERVER['REQUEST_URI']);
	}

	new AdminHTML('loginScreen', $lang['admin_login'], true);
}

// not enough admin rights?
// if area is logs... run different check...
if(AREA != 'ADMIN-LOGS') {
	if(!$User->canAdmin(AREA) AND strpos($_SERVER['REQUEST_URI'], 'usergroup.php&do=admins') === false AND strpos($_SERVER['REQUEST_URI'], 'usergroup.php&admin') === false) {
		new WtcBBException($lang['admin_error_privilegesAdmin']);
	}
}

if(isset($_GET['action'])) {
	new Redirect('admin.php?file=' . $_GET['file'] . '&' . $_GET['action'] . '=' . $_GET['val']);
}

?>