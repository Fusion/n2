<?php
/*
 * "n2" - Forum Software - a nBBS v0.6 + wtcBB remix.
 * Copyright (C) 2009 Chris F. Ravenscroft
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 * 
 * Questions? We can be reached at http://www.nextbbs.com
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
