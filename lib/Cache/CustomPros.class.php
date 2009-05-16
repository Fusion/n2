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
## ******* CUSTOM PROFILE FIELDS CACHE CLASS ******** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class CustomPros extends Cache {
	// Constructor
	public function __construct() {
		global $_CACHE;

		$this->cacheType = 'profs';
		$this->cacheArray = 1;
		$this->formCache();

		// update cache...
		if(!isset($_CACHE['profs'])) {
			$this->insert();
		}

		else {
			$this->update();
		}
	}


	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;

		$getProfs = new Query($query['custom_pro']['get_all']);
		$this->cacheInfo = Array();

		while($prof = $wtcDB->fetchArray($getProfs)) {
			$this->cacheInfo[$prof['groupid']][$prof['proid']] = new CustomPro('', $prof);

			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $prof['groupid'] . '\'][\'' . $prof['proid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new CustomPro(\'\', Array(' . Cache::writeArray($prof) . '));' . "\n";
		}

		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
