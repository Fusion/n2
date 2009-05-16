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
## ****************** COOKIE CLASS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Cookie {
	private $name, $value, $expire, $domain, $path;

	// Constructor - Sets cookie
	public function __construct($cookieName, $cookieValue = '', $cookieExpire = '') {
		global $bboptions;

		$this->name = $cookieName;
		$this->value = $cookieValue;
		$this->expire = $cookieExpire;
		$this->domain = $bboptions['cookDomain'];
		$this->path = $bboptions['cookPath'];

		if(is_array($this->value)) {
			$this->setArrayCookie();
		}

		else if(empty($this->value)) {
			$this->destroyCookie();
		}

		else {
			$this->setNormalCookie();
		}
	}

	// Private Methods
	// sets normal cookie
	private function setNormalCookie() {
		setcookie(WTC_COOKIE_PREFIX . $this->name, $this->value, $this->expire, $this->path, $this->domain);
	}

	// sets an array for the cookie value
	// takes care of serialization
	private function setArrayCookie() {
		setcookie(WTC_COOKIE_PREFIX . $this->name, serialize($this->value), $this->expire, $this->path, $this->domain);
	}

	// deletes cookie
	private function destroyCookie() {
		setcookie(WTC_COOKIE_PREFIX . $this->name, '', NOW - 100000, $this->path, $this->domain);
	}

	// Public static
	public static function getArrayCookie($cookName) {
		if(isset($_COOKIE[WTC_COOKIE_PREFIX . $cookName])) {
			return unserialize($_COOKIE[WTC_COOKIE_PREFIX . $cookName]);
		}

		else {
			return false;
		}
	}

	public static function get($cookName) {
		if(isset($_COOKIE[WTC_COOKIE_PREFIX . $cookName])) {
			return $_COOKIE[WTC_COOKIE_PREFIX . $cookName];
		}

		else {
			return false;
		}
	}
}
