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
## *********** ORDERED FORUMS CACHE CLASS *********** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class OrderedForums extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'orderedForums';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['orderedForums'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB, $forums;
		
		$getForums = new Query($query['forum']['get_all']);
		$this->cacheInfo = Array();
		$forumArr = Array();
		
		while($forum = $wtcDB->fetchArray($getForums)) {
			$forumArr[$forum['parent']][$forum['disOrder']][$forum['forumid']] = $forum['forumid'];
		}
		
		// sort'em...
		foreach($forumArr as $parent => $bleh) {
			ksort($forumArr["$parent"]);
		}
		
		// now pack'em...
		foreach($forumArr as $parent => $disOrders) {
			foreach($disOrders as $disOrder => $fids) {
				foreach($fids as $fid => $fidDupe) {
					$this->cacheInfo["$parent"][$fid] = $fid;
					
					$this->cacheContents .= '$' . $this->cacheType . '["' . $parent . '"][\'' . $fid . '\']';
					$this->cacheContents .= ' = ';
					$this->cacheContents .= '\'' . addslashes($fid) . '\';' . "\n";
				}
			}
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
