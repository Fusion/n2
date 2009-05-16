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
## ************* BB CODES CACHE CLASS *************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class BBCodes extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'bbcode';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['bbcode'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;
		
		$getBBCodes = new Query($query['bbcode']['get_all']);
		$this->cacheInfo = Array();
		
		while($bbcode = $wtcDB->fetchArray($getBBCodes)) {
			$this->cacheInfo[$bbcode['bbcodeid']] = new BBCode('', $bbcode);
			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $bbcode['bbcodeid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new BBCode(\'\', Array(' . Cache::writeArray($bbcode) . '));' . "\n";
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
