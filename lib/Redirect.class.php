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
## **************** REDIRECTION CLASS *************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Redirect {
	private $goto;
	
	// Constructor	
	public function __construct($uri = '') {
		if(empty($uri)) {
			$this->goto = $_SERVER['HTTP_REFERER'];
		}
		
		else {
			$this->goto = $uri;
		}
		
		// make sure to remove ampersands...
		$this->goto = str_replace('&amp;', '&', $this->goto);
		
		$this->newLocation();
	}
	
	// Private Methods
	private function newLocation() {
		header('Location: ' . $this->goto);
		flush(); // odd... sometimes weird things happen without this... o_0
	}
}
