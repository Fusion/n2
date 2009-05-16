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
## ************* LANGUAGES CACHE CLASS ************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Languages extends Cache {
	// Constructor
	public function __construct() {
		global $_CACHE;

		$this->cacheType = 'langs';
		$this->cacheArray = 1;
		$this->formCache();

		// update cache...
		if(!isset($_CACHE['langs'])) {
			$this->insert();
		}

		else {
			$this->update();
		}
	}


	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;

		$getLangs = new Query($query['admin']['get_langs']);
		$this->cacheInfo = Array();

		while($lang = $wtcDB->fetchArray($getLangs)) {
			$this->cacheInfo[$lang['langid']] = new Language('', $lang);

			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $lang['langid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new Language(\'\', Array(' . Cache::writeArray($lang) . '));' . "\n";
		}

		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
