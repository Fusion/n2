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
## ****************** EMAIL CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Email {
	private $headers, $to, $from, $user, $type, $content, $subject, $body, $sent;

	// Constructor
	public function __construct($aType, $aTo, $aSubject = '', $aContent = '', $aFrom = '') {
		global $bboptions;

		// hasn't been sent yet...
		$this->sent = false;

		// no userid?
		if(is_numeric($aTo) AND (!$aTo OR !User::exists($aTo))) {
			return false;
		}

		// get the from...
		if(empty($aFrom)) {
			$this->from = $bboptions['adminContact'];
		}

		else {
			$this->from = $aFrom;
		}

		// get the user info and then generate the headers
		// maybe already have info? (kind of a hack)
		if(is_array($aTo)) {
			$this->user = $aTo;
		}

		else {
			$this->user = new User($aTo);
			$this->user = $this->user->info;
		}

		// no email?
		if(!$this->user['email']) {
			return false;
		}

		// assign more vars...
		$this->type = $aType;
		$this->subject = $aSubject;
		$this->content = $aContent;
		$this->body = '';

		// get the "to"...
		if($this->type == 'regCoppa') {
			$this->to = $this->user['parentEmail'];
		}

		else {
			$this->to = $this->user['email'];
		}

		$this->buildHeaders();
		$this->buildSubject();
		$this->buildBody();
		$this->send();
	}

	// Public Methods
	// sends the actual message
	public function send() {
		//_DEBUG($this->to); _DEBUG($this->subject); _DEBUG($this->body); _DEBUG($this->headers);
		if(!mail($this->to, $this->subject, $this->body, $this->headers)) {
			return false;
		}

		// yay...
		$this->sent = true;

		return true;
	}

	// has it been sent?
	public function isSent() {
		return $this->sent;
	}

	// Private Methods
	// starts off the headers to any basic email
	private function buildHeaders() {
		global $bboptions, $User;

		// get the from "display name"...
		if($this->type == 'user') {
			$fromName = $User->info['username'];
		}

		else {
			$fromName = $bboptions['boardName'];
		}

		$this->headers = 'From: "' . $fromName . '" <' . $this->from . '>' . "\n";
		$this->headers .= 'MIME-Version: 1.0' . "\n";
		$this->headers .= 'Content-Type: text/plain' . "\n";
		$this->headers .= 'Content-Transfer-Encoding: 7bit' . "\n";
	}

	// this will build the subject...
	private function buildSubject() {
		global $lang, $bboptions;

		// if it isn't empty, then just add board name before it...
		if(!empty($this->subject)) {
			$this->subject = $bboptions['boardName'] . ' - ' . $this->subject;
		}

		// otherwise, build based on type...
		else {
			$this->subject = $bboptions['boardName'] . ' - ';

			switch($this->type) {
				case 'admin':
					$this->subject .= $lang['email_adminSub'];
				break;

				case 'report':
					$this->subject .= $lang['email_reportSub'];
				break;

				case 'user':
					$this->subject .= $lang['email_userSub'];
				break;

				case 'subscribe':
					$this->subject .= $lang['email_subSub'];
				break;

				case 'regComp':
					$this->subject .= $lang['email_regCompSub'];
				break;

				case 'regAct':
					$this->subject .= $lang['email_regActSub'];
				break;

				case 'regCoppa':
					$this->subject .= $lang['email_regCoppaSub'];
				break;

				case 'verifyPass':
					$this->subject .= $lang['email_passwordChange'];
				break;

				default:
					// just in case they don't want anything extra...
					if(empty($lang['email_noSub'])) {
						$this->subject = $bboptions['boardName'];
					}

					else {
						$this->subject .= $lang['email_noSub'];
					}
				break;
			}
		}
	}

	// this constructs parts of the body that are in some types of emails
	private function buildBody() {
		global $lang, $bboptions, $User;

		// start it off...
		$this->body = '';

		// only add "not official" for member emails...
		if($this->type == 'user') {
			$this->body = $lang['email_notOfficial'] . "\n";
			$this->body .= $lang['email_from'] . ' ' . $User->info['username'] . "\n";
			$this->body .= '--------------------------------------------------------' . "\n\n";
		}

		// start the actual message...
		switch($this->type) {
			case 'regCoppa':
				$this->body .= $lang['email_regMessageCoppa'] . "\n\n";
				$this->body .= $this->content['link'];
			break;

			case 'regAct':
				$this->body .= $lang['email_regMessageAct'] . "\n\n";
				$this->body .= $this->content['link'];
			break;

			case 'regComp':
				$this->body .= $lang['email_regMessageComp'];
			break;

			case 'report':
				$this->body .= $lang['email_repPost'] . "\n\n";
				$this->body .= $lang['email_repPost_user'] . ' ' . $this->content['username'] . "\n";
				$this->body .= $lang['email_repPost_forum'] . ' ' . $this->content['forum'] . "\n";
				$this->body .= $lang['email_repPost_thread'] . ' ' . $this->content['thread'] . "\n";
				$this->body .= $lang['email_repPost_link'] . ' ' . $this->content['link'] . "\n";
				$this->body .= $lang['email_repPost_reason'] . "\n" . $this->content['reason'];
			break;

			case 'subscribe':
				$this->body .= $lang['email_subscribe'] . "\n\n";
				$this->body .= $this->content['link'];
			break;

			case 'verifyPass':
				$this->body .= $this->content['link'];
			break;

			case 'admin':
				$this->body .= $this->content;
			break;

			case 'user':
				$this->body .= $this->content;
			break;
		}

		// add "from staff"...
		if($this->type == 'report' OR $this->type == 'subscribe' OR $this->type == 'regAct' OR $this->type == 'regComp' OR $this->type == 'regCoppa') {
			$this->body .= "\n\n" . $bboptions['emailSig'];
		}

		// always add "unsubscribe"
		if($this->type != 'report' AND $this->type != 'regAct' AND $this->type != 'regComp' AND $this->type != 'regCoppa') {
			$this->body .= "\n\n" . $lang['email_stop'];
		}
	}
}


?>