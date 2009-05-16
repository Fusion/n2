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
## ************** SMILIES CACHE CLASS *************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Smilies extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'smilies';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['smilies'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;
		
		$getSmilies = new Query($query['smilies']['get_all']);
		$this->cacheInfo = Array();
		
		while($smiley = $wtcDB->fetchArray($getSmilies)) {
			$this->cacheInfo[$smiley['groupid']][$smiley['smileyid']] = new Smiley('', $smiley);
			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $smiley['groupid'] . '\'][\'' . $smiley['smileyid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new Smiley(\'\', Array(' . Cache::writeArray($smiley) . '));' . "\n";
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
