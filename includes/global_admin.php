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