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
## ***************** PASSWORD CLASS ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Password {
	private $salt, $unhashed, $hashed, $userinfo, $hashTime;

	// Constructor
	public function __construct($pass, $userObj = NULL) {
		$this->unhashed = $pass;
		$this->user = $userObj;
		$this->hashed = '';
		$this->salt = '';
		$this->hashTime = $this->fetchHashTime();
		$this->fetchSalt();
		$this->hashPassword();
	}

	// Private Methods
	// will fetch salt... or generate it
	// or get it from current user
	// salt length must be 255 or less... unless you change the 'salt'
	// database field in the userinfo table to accomedate a higher value
	private function fetchSalt($saltLength = 32) {
		// generate salt
		if($this->user == NULL) {
			$chars = Array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l',
							'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
							'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
							'!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '[', ']'
						);

			for($i = 0; $i < $saltLength; $i++) {
				$randIndex = rand(0, count($chars));

				// uppercase?
				if(rand(0, 1)) {
					$this->salt .= strtoupper($chars[$randIndex]);
				}

				else {
					$this->salt .= $chars[$randIndex];
				}
			}
		}

		else {
			$this->salt = $this->user->info['salt'];
		}
	}

	// hashes the password, with the salt...
	private function hashPassword() {
		if($this->user->info['oldPass']) {
			$this->hashed = md5($this->unhashed);
		}

		else {
			$this->hashed = md5(md5(md5($this->salt) . md5($this->unhashed)) . md5($this->unhashed) . $this->salt . md5($this->hashTime));
		}
	}

	// gets the hash time...
	// either NOW... or user specified
	private function fetchHashTime() {
		if($this->user == NULL) {
			return NOW;
		}

		else {
			return $this->user->info['passTime'];
		}
	}


	// Public Accessors
	public function getHashedPassword() {
		return $this->hashed;
	}

	public function getSalt() {
		return $this->salt;
	}


	// Public Static Methods
	// validates password... and ONLY password (doesn't deal with cookies)
	public static function validate($given, $userObj) {
		global $lang;

		// if empty... or no userinfo... FAIL
		if(empty($given) OR !is_array($userObj->info)) {
			new WtcBBException($lang['error_invalidPassword']);
		}

		$passObj = new Password($given, $userObj);

		if($passObj->getHashedPassword() != $userObj->info['password']) {
			new WtcBBException($lang['error_invalidPassword']);
		}

		return true;
	}
}
