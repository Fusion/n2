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
## *********** ORDERED GROUPS CACHE CLASS *********** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


/**
 * This cache is designed specifically for groups
 * that can contain other groups.
 */

class OrderedGroups extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'orderedGroups';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['orderedGroups'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB, $generalGroups;
		
		$getGroups = new Query($query['groups']['get_all']);
		$this->cacheInfo = Array();
		$groupArr = Array();
		
		while($group = $wtcDB->fetchArray($getGroups)) {
			$groupArr[$group['groupType']][$group['parentid']][$group['groupid']] = $group['groupid'];
			
			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $group['groupType'] . '\'][\'' . $group['parentid'] . '\'][\'' . $group['groupid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= '\'' . addslashes($group['groupid']) . '\';' . "\n";
		}
		
		// they should already be sorted... so let's get'em...
		$this->cacheInfo = serialize($groupArr);
	}
}
