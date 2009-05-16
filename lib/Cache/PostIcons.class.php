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
## ************* POST ICONS CACHE CLASS ************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class PostIcons extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'posticons';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['posticons'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;
		
		$getIcons = new Query($query['posticons']['get_all']);
		$this->cacheInfo = Array();
		
		while($icon = $wtcDB->fetchArray($getIcons)) {
			$this->cacheInfo[$icon['iconid']] = new PostIcon('', $icon);
			
			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $icon['iconid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new PostIcon(\'\', Array(' . Cache::writeArray($icon) . '));' . "\n";
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
