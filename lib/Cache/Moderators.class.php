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
## ************* MODERATORS CACHE CLASS ************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Moderators extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'moderators';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['moderators'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB, $forums, $orderedForums;
		
		// lets cache the inherited mods too...
		$modQ = new Query($query['moderator']['get_all']);
		$moderators = Array();
		
		while($mod = $wtcDB->fetchArray($modQ)) {
			$moderators[$mod['forumid']][$mod['userid']] = new Moderator('', $mod);
		}
		
		// now lets add inherited mods...
		$solidMods = $moderators;
		$moderators = Moderator::getInheritMods($moderators, $solidMods);
		
		foreach($moderators as $forumid => $more) {
			foreach($more as $userid => $obj) {
				$mod = $obj->getInfo();
				
				$this->cacheInfo[$mod['forumid']][$mod['userid']] = new Moderator('', $mod);
				
				$this->cacheContents .= '$' . $this->cacheType . '[\'' . $forumid . '\'][\'' . $userid . '\']';
				$this->cacheContents .= ' = ';
				$this->cacheContents .= 'new Moderator(\'\', Array(' . Cache::writeArray($mod) . '));' . "\n";
			}
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
