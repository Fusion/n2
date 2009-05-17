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
