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
## *************** RANKS CACHE CLASS **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Ranks extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'ranks';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['ranks'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;
		
		$getRanks = new Query($query['rank']['get_all']);
		$this->cacheInfo = Array();
		
		while($rank = $wtcDB->fetchArray($getRanks)) {
			$this->cacheInfo[$rank['rankid']] = new Rank('', $rank);
			
			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $rank['rankid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new Rank(\'\', Array(' . Cache::writeArray($rank) . '));' . "\n";
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
