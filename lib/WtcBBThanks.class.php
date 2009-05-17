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
## ****************** THANKS CLASS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class WtcBBThanks {
	private $msg, $goto, $redirect;

	// Constructor - Allow Immediate Printing
	public function __construct($thanks, $uri = '', $aRedirect = true) {
		global $bboptions;

		$this->msg = $thanks;
		$this->goto = $uri;
		$this->redirect = $aRedirect;

		if(empty($this->goto) AND $this->goto !== false) {
			$this->goto = $_SERVER['HTTP_REFERER'];
		}

		if(ADMIN) {
			$this->adminThanks();
		}

		else {
			// only do it if we're using redirects...
			if($bboptions['redirect']) {
				$this->userThanks();
			}

			else {
				new Redirect($this->goto);
			}
		}
	}

	// Private Methods
	private function adminThanks() {
		global $lang;

		$header = new AdminHTML('header', $lang['admin_thanks_title']);

		if($this->goto !== false) {
			$header->setExtra('<meta http-equiv="refresh" content="3; url=' . $this->goto . '" />');
		}

		$header->dump();

		print("\t" . '<div class="box">' . "\n");
			print("\t\t" . '<h2>' . $lang['admin_thanks_title'] . '</h2>' . "\n");
			print("\t\t" . '<p>' . $this->msg . '</p>' . "\n");

			if($this->goto !== false) {
				print("\t\t" . '<p class="center"><a href="' . $this->goto . '" id="clicky">' . $lang['admin_redirection'] . '</a></p>' . "\n\n");

				print("\t\t" . '<script type="text/javascript">document.getElementById(\'clicky\').focus();</script>' . "\n");
			}
		print("\t" . '</div>' . "\n\n");

		new AdminHTML('footer', '', true);
		exit;
	}

	private function userThanks() {
		global $myThanks, $myLoc, $REDURI, $meta, $Nav, $SESSURL;

		extract($GLOBALS);

		$myThanks = $this->msg;
		$myLoc = stripSessionId($this->goto);
		$REDURI = $myLoc;
		$meta = '';

		// get our meta tag
		if($this->redirect) {
			$meta = new StyleFragment('meta');
			$meta = $meta->dump();
		}

		$header = new StyleFragment('header');
		$content = new StyleFragment('thanks');
		$footer = new StyleFragment('footer');

		$header->output();
		$content->output();
		$footer->output();

		exit();
	}
}
