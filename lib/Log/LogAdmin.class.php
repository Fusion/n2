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
## **************** ADMIN LOG CLASS ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class LogAdmin extends Log {
	// Constructor
	public function __construct() {
		global $User, $query, $wtcDB;

		$this->logit();
	}


	// Protected Methods
	protected function logit() {
		global $User, $query, $wtcDB, $lang;

		new Query($query['log_admin']['insert'], Array(
													1 => $User->info['userid'],
													$User->info['username'],
													NOW,
													$_SERVER['REMOTE_ADDR'],
													$_GET['file'] . '.php',
													$lang['admin_fileActions_' . preg_replace('/\s/', '-', FILE_ACTION)]
												));
	}
}
