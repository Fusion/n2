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
## ************** AVATARS CACHE CLASS *************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Avatars extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'avatars';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['avatars'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;
		
		$getAvatars = new Query($query['avatar']['get_all']);
		$this->cacheInfo = Array();
		
		while($avatar = $wtcDB->fetchArray($getAvatars)) {
			$this->cacheInfo[$avatar['groupid']][$avatar['avatarid']] = new Avatar('', $avatar);
			
			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $avatar['groupid'] . '\'][\'' . $avatar['avatarid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new Avatar(\'\', Array(' . Cache::writeArray($avatar) . '));' . "\n";
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
