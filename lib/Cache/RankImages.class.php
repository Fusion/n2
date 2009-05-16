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
## ************* RANK IMAGES CACHE CLASS ************ ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class RankImages extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'rankImages';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['rankImages'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;
		
		$getRankImages = new Query($query['rankImage']['get_all']);
		$this->cacheInfo = Array();
		
		while($rankImage = $wtcDB->fetchArray($getRankImages)) {
			$this->cacheInfo[$rankImage['rankiid']] = new RankImage('', $rankImage);
			
			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $rankImage['rankiid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new RankImage(\'\', Array(' . Cache::writeArray($rankImage) . '));' . "\n";
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
