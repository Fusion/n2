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
