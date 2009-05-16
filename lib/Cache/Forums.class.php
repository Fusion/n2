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
## *************** FORUMS CACHE CLASS **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Forums extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'forums';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['forums'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;
		
		$getForums = new Query($query['forum']['get_all']);
		$this->cacheInfo = Array();
		
		while($forum = $wtcDB->fetchArray($getForums)) {
			$this->cacheInfo[$forum['forumid']] = new Forum('', $forum);
			
			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $forum['forumid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new Forum(\'\', Array(' . Cache::writeArray($forum) . '));' . "\n";
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
