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
## **************** EXCEPTION CLASS ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class WtcBBException {
	private $msg, $full, $err;

	// Constructor - Allow Immediate Printing
	public function __construct($err, $myFull = true) {
		$this->msg = $err;
		$this->full = $myFull;
		$this->err = '';

		if(ADMIN) {
			$this->adminError();
		}

		else if($err == 'perm') {
			$this->permError();
		}

		else {
			$this->userError();
		}
	}


	// Public Methods
	// Gets the err string
	public function dump() {
		return $this->err;
	}


	// Private Methods
	private function adminError() {
		global $lang;

		new AdminHTML('header', $lang['admin_error_title'], true);

		print("\t" . '<div class="box">' . "\n");
			print("\t\t" . '<h2>' . $lang['admin_error_title'] . '</h2>' . "\n");
			print("\t\t" . '<p>' . $this->msg . '</p>' . "\n");
			//print("\t\t" . '<p>' . $lang['admin_error_note'] . '</p>' . "\n");
			print("\t\t" . '<p class="center"><a href="javascript:history.back();">' . $lang['admin_goBack'] . '</a></p>' . "\n");
		print("\t" . '</div>' . "\n\n");

		new AdminHTML('footer', '', true);

		exit();
	}

	private function userError() {
		global $myError, $myFull, $Nav, $SESSURL;

		extract($GLOBALS);

		// uh oh...
		if(empty($SESSURL)) {
			// Define AREA
		define('AREA', 'USER-VIEWERROR');
		require_once('./includes/sessions.php');
		}

		$myError = $this->msg;
		$myFull = $this->full;

		if($this->full) {
			$Nav = new Navigation(
						Array(
							$lang['user_nav_error'] => ''
						)
					);

			$header = new StyleFragment('header');
			$content = new StyleFragment('error');
			$footer = new StyleFragment('footer');

			$header->output();
			$content->output();
			$footer->output();

			exit();
		}

		else {
			$error = new StyleFragment('error');
			$this->err = $error->dump();
		}
	}

	private function permError() {
		global $myError, $myFull, $Nav;

		extract($GLOBALS);

		$myError = $this->msg;
		$myFull = $this->full;

		if($this->full) {
			$Nav = new Navigation(
						Array(
							$lang['user_nav_error'] => ''
						)
					);

			$header = new StyleFragment('header');
			$content = new StyleFragment('error_perm');
			$footer = new StyleFragment('footer');

			$header->output();
			$content->output();
			$footer->output();

			exit();
		}

		else {
			$error = new StyleFragment('error_perm');
			$this->err = $error->dump();
		}
	}
}
