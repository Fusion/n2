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
## ************ FORUM PERMS CACHE CLASS ************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class ForumPerms extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'perms';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['perms'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;
		
		$getPerms = new Query($query['perm']['get_all']);
		$this->cacheInfo = Array();
		
		while($perm = $wtcDB->fetchArray($getPerms)) {
			foreach($perm as $key => $val) {
				if(is_numeric($key)) {
					unset($perm[$key]);
				}
			}
			
			$this->cacheInfo[$perm['forumid']][$perm['usergroupid']] = new ForumPerm('', $perm);
			
			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $perm['forumid'] . '\'][\'' . $perm['usergroupid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new ForumPerm(\'\', Array(' . Cache::writeArray($perm) . '));' . "\n";
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
